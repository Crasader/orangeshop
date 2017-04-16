<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Repositories\Repositories\AdminRepository;
use App\Validators\AdminValidator;


class AdminsController extends Controller
{

    /**
     * @var AdminRepository
     */
    protected $repository;

    /**
     * @var AdminValidator
     */
    protected $validator;

    public function __construct(AdminRepository $repository, AdminValidator $validator)
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
        $admins = $this->repository->paginate();
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $admins,
            ]);
        }

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $admin = $this->repository->create($request->all());

            $response = [
                'message' => '管理员创建成功.',
                'data' => $admin->toArray(),
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
     * Update the specified resource in storage.
     *
     * @param  AdminUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(AdminUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $admin = $this->repository->update($request->all(), $id);

            $roles = $request->get('role');
            !$roles && $roles = [];
            $admin->roles()->sync($roles);
            $response = [
                'message' => '更新成功.',
                'error' => 0,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => 1,
                    'message' => '更新失败'
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
                'message' => 'Admin deleted.',
                'error' => 1,
            ]);
        }

        return redirect()->back()->with('message', 'Admin deleted.');
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

        $admin = Admin::find($id);

        $roles = Role::all();
        return view('admin.admins.edit', compact('admin','roles'));
    }
}
