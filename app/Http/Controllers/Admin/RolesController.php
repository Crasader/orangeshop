<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Repositories\Repositories\RoleRepository;
use App\Validators\RoleValidator;


class RolesController extends Controller
{

    /**
     * @var RoleRepository
     */
    protected $repository;

    /**
     * @var RoleValidator
     */
    protected $validator;

    public function __construct(RoleRepository $repository, RoleValidator $validator)
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
        $roles = $this->repository->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $roles,
            ]);
        }
        $permissions = Permission::with('child_checkbox')->where('parent_id', 0)->get();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $role = $this->repository->create($request->all());
            $perms = $request->get('permission');
            if ($perms) {
                $role->perms()->sync($perms);
            }

            $response = [
                'message' => '角色创建成功.',
                'data' => $role->toArray(),
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
        $role = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $role,
            ]);
        }

        return view('admin.roles.show', compact('role'));
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

        $role = $this->repository->find($id);
        $permissions = Permission::with('child_checkbox')->where('parent_id', 0)->get();
        $perms = $role->perms->pluck('id');

        return view('admin.roles.edit', compact('role', 'permissions', 'perms'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  RoleUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $role = $this->repository->update($request->all(), $id);
            $perms = $request->get('permission');
            !$perms && $perms = [];
            $role->perms()->sync($perms);

            $response = [
                'message' => 'Role updated.',
                'data' => $role->toArray(),
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
        $role = Role::findOrFail($id);
        $role->delete();
        if (request()->wantsJson()) {

            return response()->json([
                'message' => '角色删除成功.',
                'error' => 0,
            ]);
        }

        return redirect()->back()->with('message', 'Role deleted.');
    }
}
