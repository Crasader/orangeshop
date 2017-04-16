<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromotionBuySend;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PromotionBuySendCreateRequest;
use App\Http\Requests\PromotionBuySendUpdateRequest;
use App\Repositories\Repositories\PromotionBuySendRepository;
use App\Validators\PromotionBuySendValidator;


class PromotionBuySendsController extends Controller
{

    /**
     * @var PromotionBuySendRepository
     */
    protected $repository;

    /**
     * @var PromotionBuySendValidator
     */
    protected $validator;

    public function __construct(PromotionBuySendRepository $repository, PromotionBuySendValidator $validator)
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
        $promotion_buy_sends = $this->repository->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_buy_sends,
            ]);
        }

        return view('admin.promotion_buy_sends.index', compact('promotion_buy_sends'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PromotionBuySendCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionBuySendCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $promotion_buy_send = $this->repository->create($request->all());

            $response = [
                'message' => '买赠活动新增成功.',
                'data' => $promotion_buy_send->toArray(),
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
        $promotion_buy_send = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_buy_send,
            ]);
        }

        return view('admin.promotion_buy_sends.show', compact('promotion_buy_send'));
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

        $promotion_buy_send = $this->repository->find($id);

        return view('admin.promotion_buy_sends.edit', compact('promotion_buy_send'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  promotion_buy_sendUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(PromotionBuySendUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $promotion_buy_send = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'promotion_buy_send updated.',
                'data' => $promotion_buy_send->toArray(),
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
        $to_delete = PromotionBuySend::find($id);
        $to_delete->products()->detach();
        $deleted = $to_delete->delete();
        if (request()->wantsJson()) {

            return response()->json([
                'message' => '删除成功.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', '删除成功.');
    }

    //新增
    public function create()
    {
        return view('admin.promotion_buy_sends.create');
    }

    //批量删除
    public function batchDelete(Request $request)
    {
        if ($request->ajax()) {
            $pm_ids = $request->get('ids');
            foreach ($pm_ids as $pm_id){
                PromotionBuySend::find($pm_id)->products()->detach();
            }
            $rst = PromotionBuySend::destroy($pm_ids);
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

    //get 显示添加商品页面
    public function products(Request $request, $pm_id)
    {
        $promotion_buy_send = PromotionBuySend::find($pm_id);
        return view('admin.promotion_buy_sends.products', compact('promotion_buy_send'));
    }

    //post 添加产品
    public function addProduct(Request $request, $pm_id)
    {
        $pid = $request->get('pid');
        $to_add = DB::table('promotion_buy_send_products')->where(['pm_id'=>$pm_id,'pid'=>$pid])->get();
        if($to_add->isEmpty()){
            DB::table('promotion_buy_send_products')->insert(['pm_id'=>$pm_id,'pid'=>$pid]);
            $message = [
                'error' => 0,
                'message' => '添加产品成功'
            ];

        }else{
            $message = [
                'error' =>1,
                'message' => '该商品已经添加到当前活动'
            ];
        }

        return response()->json($message);
    }

    //delete 删除买赠商品
    public function removeProduct(Request $request, $pm_id)
    {
        $pid = $request->get('pid');
        $to_delete = DB::table('promotion_buy_send_products')->where(['pm_id'=>$pm_id,'pid'=>$pid]);
        if($to_delete){
            $to_delete->delete();
            $message = [
                'error' => 0,
                'message' => '删除成功'
            ];
        }else{
            $message = [
                'error' =>1,
                'message' => '未找到数据'
            ];
        }

        return response()->json($message);
    }
}
