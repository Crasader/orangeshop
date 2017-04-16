<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromotionSingle;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PromotionSingleCreateRequest;
use App\Http\Requests\PromotionSingleUpdateRequest;
use App\Repositories\Repositories\PromotionSingleRepository;
use App\Validators\PromotionSingleValidator;


class PromotionSinglesController extends Controller
{

    /**
     * @var PromotionSingleRepository
     */
    protected $repository;

    /**
     * @var PromotionSingleValidator
     */
    protected $validator;

    public function __construct(PromotionSingleRepository $repository, PromotionSingleValidator $validator)
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
        $promotion_singles = $this->repository->with('product')->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_singles,
            ]);
        }

        return view('admin.promotion_singles.index', compact('promotion_singles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PromotionSingleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionSingleCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $promotion_single = $this->repository->create($request->all());

            $response = [
                'message' => '单品活动创建成功.',
                'data' => $promotion_single->toArray(),
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
        $promotion_single = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $promotion_single,
            ]);
        }

        return view('admin.promotion_singles.show', compact('promotion_single'));
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

        $promotion_single = $this->repository->with('product')->find($id);

        return view('admin.promotion_singles.edit', compact('promotion_single'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PromotionSingleUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(PromotionSingleUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $promotion_single = $this->repository->update($request->all(), $id);

            if ($request->get('start_time') == '') {
                $promotion_single->start_time = null;
                $promotion_single->end_time = null;
            }
            $promotion_single->save();

            $response = [
                'message' => '单品活动更新成功.',
                'data' => $promotion_single->toArray(),
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
                'message' => '单品活动删除成功.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PromotionSingle deleted.');
    }

    public function create()
    {
        return view('admin.promotion_singles.create');
    }

    //批量删除
    public function batchDelete(Request $request)
    {
        if ($request->ajax()) {
            $pm_ids = $request->get('ids');
            $rst = PromotionSingle::destroy($pm_ids);
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
}
