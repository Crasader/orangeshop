<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AttributeValueCreateRequest;
use App\Http\Requests\AttributeValueUpdateRequest;
use App\Repositories\Repositories\AttributeValueRepository;
use App\Validators\AttributeValueValidator;
use App\Http\Controllers\Admin\Controller;


class AttributeValuesController extends Controller
{

    /**
     * @var AttributeValueRepository
     */
    protected $repository;

    /**
     * @var AttributeValueValidator
     */
    protected $validator;

    public function __construct(AttributeValueRepository $repository, AttributeValueValidator $validator)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $attributeValues = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $attributeValues,
            ]);
        }

        return view('admin.attributeValues.index', compact('attributeValues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AttributeValueCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeValueCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $attributeValue = $this->repository->create($request->all());

            $response = [
                'message' => '属性值新增成功.',
                'data'    => $attributeValue->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
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
        $attributeValue = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $attributeValue,
            ]);
        }

        return view('admin.attributeValues.show', compact('attributeValue'));
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

        $attributeValue = $this->repository->find($id);

        return view('admin.attributeValues.edit', compact('attributeValue'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AttributeValueUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(AttributeValueUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $attributeValue = $this->repository->update($request->all(),$id);

            $response = [
                'message' => 'AttributeValue updated.',
                'data'    => $attributeValue->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
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
        //dd($id);
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'AttributeValue deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'AttributeValue deleted.');
    }
}
