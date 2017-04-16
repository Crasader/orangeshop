<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Repositories\Repositories\CategoryRepository;
use App\Validators\CategoryValidator;
use App\Http\Controllers\Admin\Controller;


class CategoriesController extends Controller
{

    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var CategoryValidator
     */
    protected $validator;

    public function __construct(CategoryRepository $repository, CategoryValidator $validator)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        // 构造数据
       /* $categories = [
            ["cate_id" => 1, "name" => "保温杯"],
            ["cate_id" => 2, "name" => "唇膏唇彩"],
            ["cate_id" => 3, "name" => "底妆遮瑕"],
            ["cate_id" => 4, "name" => "防晒修复"],
            ["cate_id" => 5, "name" => "护肤套装"],
            ["cate_id" => 6, "name" => "化妆水"],
            ["cate_id" => 7, "name" => "坚果蜜饯"],
            ["cate_id" => 8, "name" => "口腔护理"],
            ["cate_id" => 9, "name" => "裤袜"],
            ["cate_id" => 10, "name" => "美体纤体"],
            ["cate_id" => 11, "name" => "面部精华"],
            ["cate_id" => 12, "name" => "面膜专区"],
            ["cate_id" => 13, "name" => "沐浴清洁"],
            ["cate_id" => 14, "name" => "奶瓶"],
            ["cate_id" => 15, "name" => "奶嘴"],
            ["cate_id" => 16, "name" => "内衣"],
            ["cate_id" => 17, "name" => "女性护理"],
            ["cate_id" => 18, "name" => "清洁卸妆"],
            ["cate_id" => 19, "name" => "驱蚊防虫"],
            ["cate_id" => 20, "name" => "燃脂瘦身"],
            ["cate_id" => 21, "name" => "乳液面霜"],
            ["cate_id" => 22, "name" => "腮红修容"],
            ["cate_id" => 23, "name" => "时尚衣物"],
            ["cate_id" => 24, "name" => "手工绘画"],
            ["cate_id" => 25, "name" => "手足护理"],
            ["cate_id" => 26, "name" => "水杯水壶"],
            ["cate_id" => 27, "name" => "糖果/巧克力"],
            ["cate_id" => 28, "name" => "洗发护发"],
            ["cate_id" => 29, "name" => "洗发沐浴"],
            ["cate_id" => 30, "name" => "休闲零食"],
            ["cate_id" => 31, "name" => "眼部护理"],
            ["cate_id" => 32, "name" => "眼眉彩妆"],
            ["cate_id" => 33, "name" => "婴儿牙胶"],
        ];

        Category::buildTree($categories); // => true
        dd(1);
        */

        //如果不是ajax，并且没有搜索条件，那么就返回树状表
        if (is_null($request->get('search'))) {
            $categories = Category::cate_tree();
            $count = count($categories);
            $page = $request->get('page');
            if ($page) {
                $categories = array_slice($categories, ($page - 1) * 15, 15);
            }
            $categories = new \Illuminate\Pagination\LengthAwarePaginator(
                $categories,
                $count,
                15,
                $page
            );

            $categories->setPath('category');
            return view('admin.categories.index', compact('categories'));
        }

        //主要用来返回筛选的结果
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $categories = $this->repository->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $categories,
            ]);
        }

        return view('admin.categories.index', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $category = $this->repository->create($request->all());

            $response = [
                'message' => '分类新增成功.',
                'data' => $category->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $category,
            ]);
        }

        return view('admin.categories.show', compact('category'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = $this->repository->find($id);
        $cate_tree = Category::cate_tree();
        $cate_tree = array_pluck($cate_tree, 'name', 'cate_id');
        $cate_tree = array_prepend($cate_tree, '--父级分类--', 0);
        //array_unshift($cate_tree, '父级分类');
        $brands = Brand::orderBy('name')->get(['name','brand_id']);
        $related_brands = $category->brands->pluck('brand_id')->toArray();

        return view('admin.categories.edit', compact('category', 'cate_tree','related_brands','brands'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $category = $this->repository->update($request->all(), $id);

            $brands = $request->get('brands',[]);
            $category->brands()->sync($brands);

            $response = [
                'message' => 'Category updated.',
                'data' => $category->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cates = Category::cate_tree($id);
        if (count($cates) > 0) {
            $cates = array_pluck($cates, 'cate_id');
        }
        array_push($cates, (int)$id);
        $deleted = Category::destroy($cates);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Category deleted.',
                'deleted' => $cates,
            ]);
        }

        return redirect()->back()->with('message', 'Category deleted.');
    }

    public function create(Request $request)
    {

        $cate_tree = Category::cate_tree();
        $cate_tree = array_pluck($cate_tree, 'name', 'cate_id');
        $cate_tree = array_prepend($cate_tree, '--父级分类--', 0);
        $brands = Brand::get(['name','brand_id']);

        return view('admin.categories.create', compact('cate_tree','brands'));
    }
}
