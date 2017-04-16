<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\BrandOrderByCriteria;
use App\Http\Controllers\Admin\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BrandCreateRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Repositories\Repositories\BrandRepository;
use App\Validators\BrandValidator;


class BrandsController extends Controller
{

    /**
     * @var BrandRepository
     */
    protected $repository;

    /**
     * @var BrandValidator
     */
    protected $validator;

    public function __construct(BrandRepository $repository, BrandValidator $validator)
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app(BrandOrderByCriteria::class));

        $brands = $this->repository->paginate();
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $brands,
            ]);
        }

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BrandCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BrandCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $brand = $this->repository->create($request->all());


            $response = [
                'message' => '品牌新增成功.',
                'data' => $brand->toArray(),
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
        $brand = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $brand,
            ]);
        }

        return view('admin.brands.show', compact('brand'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)    {

        $brand = $this->repository->find($id);
        $cates = Category::get(['name','cate_id']);
        $related_cates = $brand->categories->pluck('cate_id')->toArray();

        return view('admin.brands.edit', compact('brand','cates','related_cates'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  BrandUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(BrandUpdateRequest $request, $id)
    {
        //dd($request->all());
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $brand = $this->repository->update($request->all(), $id);

            $cates = $request->get('cates',[]);
            //dd($cates);
            $brand->categories()->sync($cates);

            $response = [
                'message' => 'Brand updated.',
                'data' => $brand->toArray(),
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Brand deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Brand deleted.');
    }

    public function create()
    {
        $cates = Category::get(['name','cate_id']);
        return view('admin.brands.create',compact('cates'));
    }

    //ajax get
    public function batchDelete(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->except('_token');
            $ids = array_flatten($ids);
            $rst = Brand::destroy($ids);
            if ($rst) {
                return response()->json([
                    'state' => 1,
                    'message' => '删除成功'
                ]);
            } else {
                return response()->json([
                    'state' => 0,
                    'message' => '删除失败'
                ]);
            }
        }else{
            return redirect()->route('brand.index');
        }
    }
}
