<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CouponCreateRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Repositories\Repositories\CouponRepository;
use App\Validators\CouponValidator;


class CouponsController extends Controller
{

    /**
     * @var CouponRepository
     */
    protected $repository;

    /**
     * @var CouponValidator
     */
    protected $validator;

    public function __construct(CouponRepository $repository, CouponValidator $validator)
    {
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
        $coupons = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $coupons,
            ]);
        }

        return view('coupons.index', compact('coupons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CouponCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CouponCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $coupon = $this->repository->create($request->all());

            $response = [
                'message' => 'Coupon created.',
                'data'    => $coupon->toArray(),
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
        $coupon = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $coupon,
            ]);
        }

        return view('coupons.show', compact('coupon'));
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

        $coupon = $this->repository->find($id);

        return view('coupons.edit', compact('coupon'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CouponUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CouponUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $coupon = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'Coupon updated.',
                'data'    => $coupon->toArray(),
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Coupon deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Coupon deleted.');
    }
}
