<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromotionFullSend;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PromotionFullSendCreateRequest;
use App\Http\Requests\PromotionFullSendUpdateRequest;
use App\Repositories\Repositories\PromotionFullSendRepository;
use App\Validators\PromotionFullSendValidator;


class PromotionFullSendsController extends Controller
{

    /**
     * @var PromotionFullSendRepository
     */
    protected $repository;

    /**
     * @var PromotionFullSendValidator
     */
    protected $validator;

    public function __construct(PromotionFullSendRepository $repository, PromotionFullSendValidator $validator)
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
        $promotion_full_sends = $this->repository->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_full_sends,
            ]);
        }

        return view('admin.promotion_full_sends.index', compact('promotion_full_sends'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PromotionFullSendCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionFullSendCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $promotion_full_send = $this->repository->create($request->all());

            $response = [
                'message' => '满赠活动创建成功.',
                'data' => $promotion_full_send->toArray(),
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
        $promotion_full_send = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_full_send,
            ]);
        }

        return view('admin.promotion_full_sends.show', compact('promotion_full_send'));
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

        $promotion_full_send = $this->repository->find($id);

        return view('admin.promotion_full_sends.edit', compact('promotion_full_send'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PromotionFullSendUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(PromotionFullSendUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $promotion_full_send = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PromotionFullSend updated.',
                'data' => $promotion_full_send->toArray(),
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
        //$deleted = $this->repository->delete($id);
        $to_delete = PromotionFullSend::find($id);
        $to_delete->products()->detach();
        $deleted = $to_delete->delete();

        if (request()->wantsJson()) {

            return response()->json([
                'message' => '满减活动删除成功.',
                'error' => 0,
            ]);
        }

        return redirect()->back()->with('message', '满减活动删除成功.');
    }

    //批量删除
    public function batchDelete(Request $request)
    {
        if ($request->ajax()) {
            $pm_ids = $request->get('ids');
            foreach ($pm_ids as $pm_id){
                PromotionFullSend::find($pm_id)->products()->detach();
            }
            $rst = PromotionFullSend::destroy($pm_ids);
            if ($rst) {
                $response = [
                    'state' => 1,
                    'message' => '删除成功'
                ];

            } else {
                $response = [
                    'state' => 0,
                    'message' => '删除失败'
                ];
            }
            return response()->json($response);
        }
    }

    //新增
    public function create()
    {
        return view('admin.promotion_full_sends.create');
    }

    //满赠商品列表
    public function products(Request $request, $pm_id)
    {
        $promotion_full_send = PromotionFullSend::find($pm_id);
        return view('admin.promotion_full_sends.products', compact('promotion_full_send'));
    }

    //post 添加产品
    public function addProduct(Request $request, $pm_id)
    {
        $pid = $request->get('pid');
        $type = $request->get('type');
        $to_add = DB::table('promotion_full_send_products')->where(['pm_id' => $pm_id, 'pid' => $pid])->get();
        if ($to_add->isEmpty()) {
            DB::table('promotion_full_send_products')->insert(['pm_id' => $pm_id, 'pid' => $pid,'type'=>$type]);
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
        $to_delete = DB::table('promotion_full_send_products')->where(['pm_id' => $pm_id, 'pid' => $pid]);
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
