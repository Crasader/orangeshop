<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\AttributeFilterByCriteria;
use App\Criteria\AttributeOrderByCriteria;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AttributeCreateRequest;
use App\Http\Requests\AttributeUpdateRequest;
use App\Repositories\Repositories\AttributeRepository;
use App\Validators\AttributeValidator;
use App\Http\Controllers\Admin\Controller;

class AttributesController extends Controller
{

    /**
     * @var AttributeRepository
     */
    protected $repository;

    /**
     * @var AttributeValidator
     */
    protected $validator;

    public function __construct(AttributeRepository $repository, AttributeValidator $validator)
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
    public function index( )
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app(AttributeOrderByCriteria::class));
        if(request()->has('name')){
            $this->repository->pushCriteria(app(AttributeFilterByCriteria::class));
        }
        $attributes = $this->repository->with('attribute_values')->paginate();

        //dd(AttributeValue::with('attribute')->get()->toArray());
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $attributes,
            ]);
        }

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AttributeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $attribute = $this->repository->create($request->all());

            $response = [
                'message' => '属性新增成功.',
                'data' => $attribute->toArray(),
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
        $attribute = $this->repository->with('attribute_values')->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $attribute,
            ]);
        }

        return view('admin.attributes.show', compact('attribute'));
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

        $attribute = $this->repository->with('attribute_values')->find($id);

        return view('admin.attributes.edit', compact('attribute'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AttributeUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(AttributeUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $attribute = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Attribute updated.',
                'data' => $attribute->toArray(),
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
                'message' => 'Attribute deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Attribute deleted.');
    }

    //ajax
    public function batchDelete(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->except('_token');
            $ids = array_flatten($ids);
            $rst = Attribute::destroy($ids);
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
        }
    }

    public function create(Request $request)
    {
        return view('admin.attributes.create');
    }
}
