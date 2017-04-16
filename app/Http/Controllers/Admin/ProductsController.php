<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductRelate;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\Repositories\ProductRepository;
use App\Validators\ProductValidator;


class ProductsController extends Controller
{

    /**
     * @var ProductRepository
     */
    protected $repository;

    /**
     * @var ProductValidator
     */
    protected $validator;

    public function __construct(ProductRepository $repository, ProductValidator $validator)
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
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $products = $this->repository->orderBy('order')->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $products,
            ]);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            //基本表
            $except_fields = ['attr_values', '_token'];
            $product = $this->repository->create($request->except($except_fields));

            //属性表,处理属性的附加钱信息
            $attr_values = $request->get('attr_values');
            if ($attr_values) {
                $data = [];
                foreach ($attr_values as $attr_value) {
                    $temp = explode('_', $attr_value);
                    $row = [
                        'pid' => $product->pid,
                        'attr_id' => $temp[0],
                        'attr_value_id' => $temp[1],
                        'add_money' => isset($temp[2]) ? $temp[2] : 0
                    ];
                    array_push($data, $row);

                }
                foreach ($data as $row) {
                    ProductAttribute::create($row);
                }
            }

            $response = [
                'message' => '产品新增成功.',
                'data' => $product->toArray(),
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
        $product = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $product,
            ]);
        }

        return view('admin.products.show', compact('product'));
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

        $product = $this->repository->with('attribute_values')->find($id);

        //分类
        //$cate_tree = Category::cate_tree();
        //$cate_tree = array_pluck($cate_tree, 'name', 'cate_id');

        $cates = Category::pluck('name', 'cate_id');
        //品牌
        $brands = Brand::with(['categories'])->orderBy('order')->get(['brand_id', 'name']);

        //属性和属性值
        $attrs = Attribute::with(['attribute_values' => function ($query) {
            return $query->select(['attr_value_id', 'attr_id', 'attr_value_0', 'attr_value_1', 'attr_value_2']);
        }])->get(['attr_id', 'name', 'show_type']);

        return view('admin.products.edit', compact('product', 'cates', 'brands', 'attrs'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ProductUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            //基本表
            $except_fields = ['attr_values', '_token'];
            $product = $this->repository->update($request->except($except_fields), $id);

            //属性表,处理属性的附加钱信息
            //先删除，再添加
            ProductAttribute::where('pid', $id)->delete();

            $attr_values = $request->get('attr_values');
            if ($attr_values) {
                $data = [];
                foreach ($attr_values as $attr_value) {
                    $temp = explode('_', $attr_value);
                    $row = [
                        'pid' => $product->pid,
                        'attr_id' => $temp[0],
                        'attr_value_id' => $temp[1],
                        'add_money' => isset($temp[2]) ? $temp[2] : 0
                    ];
                    array_push($data, $row);

                }
                foreach ($data as $row) {
                    ProductAttribute::create($row);
                }
            }
            $response = [
                'message' => 'Product updated.',
                'data' => $product->toArray(),
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
                'message' => 'Product deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Product deleted.');
    }


    /**
     * 新增
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //分类
        //$cate_tree = Category::cate_tree();
        //$cate_tree = array_pluck($cate_tree, 'name', 'cate_id');
        $cates = Category::pluck('name', 'cate_id');
        //品牌
        $brands = Brand::with(['categories'])->orderBy('order')->get(['brand_id', 'name']);

        //$brands = array_pluck($brands, 'name', 'brand_id');
        //属性和属性值
        $attrs = Attribute::with(['attribute_values' => function ($query) {
            return $query->select(['attr_value_id', 'attr_id', 'attr_value_0', 'attr_value_1', 'attr_value_2']);
        }])->get(['attr_id', 'name', 'show_type']);

        return view('admin.products.create', compact('brands', 'attrs', 'cates'));
    }

    /**
     * 展示上传图片
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showImage($id)
    {
        $product = Product::with(['images' => function ($query) {
            $query->orderBy('order');
        }])->find($id);
        return view('admin.products.product_image', compact('product'));
    }

    /**
     * 处理产品图片
     *
     * @return Response
     */
    public function storeImage(Request $request, $id)
    {
        $product = Product::find($id);
        $image = $product->images()->create($request->all());
        if ($image) {
            $response = [
                'message' => '数据库写入成功',
                'data' => $image->toArray(),
            ];
        } else {
            $response = [
                'message' => '数据库写入失败',
                'data' => '',
            ];
        }
        return redirect()->back()->with('message', $response['message']);
    }

    /**
     * 更新图片的order
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateImage(Request $request, $id)
    {
        $rst = Image::find($id)->update($request->all());
        if ($rst) {
            $response = ['message' => '图片更新成功', 'error' => 0];
        } else {
            $response = ['message' => '图片更新失败', 'error' => 1];
        }
        return response()->json($response);
    }

    /**
     * 删除图片
     * @param $id
     * @return mixed
     */
    public function deleteImage($id)
    {
        $rst = Image::destroy($id);
        if ($rst) {
            $response = ['message' => '图片删除成功', 'error' => 0];
        } else {
            $response = ['message' => '图片删除失败', 'error' => 1];
        }
        return response()->json($response);
    }

    /**
     * 显示关联产品页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRelated($pid)
    {
        //当前产品
        $product = Product::with('related_products')->find($pid);

        //所有产品
        $products = Product::orderBy('cate_id')->orderBy('order')->paginate();

        return view('admin.products.related_products', compact('pid', 'products', 'product'));
    }

    /**
     *
     */
    public function storeRelated(Request $request, $pid)
    {
        //如果是ajax
        //1、说明是页面跳转的时候进行的数据插入
        //2、说明是更新的order
        if ($request->ajax()) {
            $related_pids = $request->get('selected');

            $product = Product::findOrFail($pid);
            $product->related_products()->syncWithoutDetaching($related_pids);

            return response()->json(['message' => '关联成功', 'error' => 0]);
        }
    }

    //删除关联产品
    public function deleteRelated(Request $request, $pid)
    {
        $related_pid = $request->get('related_pid');
        $product = Product::findOrFail($pid);
        $rst = $product->related_products()->detach($related_pid);
        if ($rst) {
            $response = [
                'message' => '删除关联成功',
                'error' => 0
            ];
        } else {
            $response = [
                'message' => '删除关联失败',
                'error' => 1
            ];
        }
        return response()->json($response);
    }

    //查找产品
    public function searchProduct(Request $request)
    {
        debugbar()->disable();
        if (!$request->ajax()) {
            return response()->json([]);
        }

        $condition = $request->get('condition');
        $type = $request->get('type');
        switch ($type) {
            //按分类
            case 2:
                $products = Product::whereHas('category', function ($query) use ($condition) {
                    $query->where('name', 'like', '%' . $condition . '%');
                })->with(['category' => function ($query) {
                    $query->select('name', 'cate_id');
                }])->get(['pid', 'name', 'cate_id', 'shop_price']);

                break;
            //按品牌
            case 1:
                $products = Product::whereHas('brand', function ($query) use ($condition) {
                    $query->where('name', 'like', '%' . $condition . '%');
                })->with(['brand' => function ($query) {
                    $query->select('name', 'brand_id');
                }])->get(['pid', 'name', 'brand_id', 'shop_price']);
                break;
            default:
                $products = Product::where('name', 'like', '%' . $condition . '%')->get(['pid', 'name', 'shop_price'])->toArray();
        }
        return response()->json($products);
    }

    //
    public function getCatesByBrand(Request $request)
    {
        if ($request->ajax()) {
            $brand = Brand::findOrFail($request->get('brand_id'));
            $cates = $brand->categories->toArray();

            return response()->json($cates);
        }
    }

}
