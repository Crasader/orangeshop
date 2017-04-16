<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromotionSuit;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PromotionSuitCreateRequest;
use App\Http\Requests\PromotionSuitUpdateRequest;
use App\Repositories\Repositories\PromotionSuitRepository;
use App\Validators\PromotionSuitValidator;


class PromotionSuitsController extends Controller
{

    /**
     * @var PromotionSuitRepository
     */
    protected $repository;

    /**
     * @var PromotionSuitValidator
     */
    protected $validator;

    public function __construct(PromotionSuitRepository $repository, PromotionSuitValidator $validator)
    {
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
        $promotion_suits = $this->repository->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_suits,
            ]);
        }

        return view('admin.promotion_suits.index', compact('promotion_suits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PromotionSuitCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionSuitCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $promotion_suit = $this->repository->create($request->all());

            $response = [
                'message' => '套装活动新增成功.',
                'data' => $promotion_suit->toArray(),
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
        $promotion_suit = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_suit,
            ]);
        }

        return view('admin.promotion_suits.show', compact('promotion_suit'));
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

        $promotion_suit = $this->repository->find($id);

        return view('admin.promotion_suits.edit', compact('promotion_suit'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PromotionSuitUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(PromotionSuitUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $promotion_suit = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PromotionSuit updated.',
                'data' => $promotion_suit->toArray(),
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
                'message' => 'PromotionSuit deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PromotionSuit deleted.');
    }

    //新增套装活动
    public function create()
    {
        return view('admin.promotion_suits.create');
    }

    public function batchDelete()
    {

    }

    //满赠商品列表
    public function products(Request $request, $pm_id)
    {
        $promotion_suit = PromotionSuit::find($pm_id);
        return view('admin.promotion_suits.products', compact('promotion_suit'));
    }

    //post 添加产品
    public function addProduct(Request $request, $pm_id)
    {
        $pid = $request->get('pid');
        $type = $request->get('type');
        $discount = $request->get('discount');
        $number = $request->get('number');
        $to_add = DB::table('promotion_suit_products')->where(['pm_id' => $pm_id, 'pid' => $pid])->get();
        if ($to_add->isEmpty()) {
            DB::table('promotion_suit_products')->insert([
                'pm_id' => $pm_id,
                'pid' => $pid,
                'discount' => $discount,
                'number' => $number
            ]);
            $message = [
                'error' => 0,
                'message' => '添加产品成功'
            ];

        } else {
            $message = [
                'error' => 1,
                'message' => '该商品已经添加到当前活动'
            ];
        }

        return response()->json($message);
    }

    //delete 删除满赠商品
    public function removeProduct(Request $request, $pm_id)
    {
        $pid = $request->get('pid');
        $to_delete = DB::table('promotion_suit_products')->where(['pm_id' => $pm_id, 'pid' => $pid]);
        if ($to_delete) {
            $to_delete->delete();
            $message = [
                'error' => 0,
                'message' => '删除成功'
            ];
        } else {
            $message = [
                'error' => 1,
                'message' => '未找到数据'
            ];
        }

        return response()->json($message);
    }
}
