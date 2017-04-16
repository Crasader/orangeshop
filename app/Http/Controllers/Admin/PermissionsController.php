<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions_tree = Permission::permission_tree();
        //dd($permissions_tree);
        return view('admin.permissions.index', compact('permissions_tree'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'display_name' => 'required',
            'name' => 'required',
            'parent_id' => 'required|integer',
            'order' => 'required|integer',
            'is_menu' => 'in:0,1'
        ];
        $this->validate($request, $rule);
        if (str_contains('#', $request->get('name'))) {
            $data = array_merge($request->all(), ['name' => '#' . Carbon::now()->toDateTimeString()]);
        } else {
            $data = $request->all();
        }

        $rst = Permission::create($data);
        if ($rst) {
            return redirect('admin/permission')->with(['message' => '添加成功']);
        } else {
            return back()->withErrors(['message' => '添加失败']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $permissions_tree = Permission::permission_tree();
        return view('admin.permissions.edit', compact('permission', 'permissions_tree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        //判断是否只更新排序
        if ($request->ajax()) {
            $permission->order = $request->get('order');
            $rst = $permission->save();
            if ($rst) {
                return response()->json([
                    'message' => '更新排序成功',
                    'error' => '0'
                ]);
            } else {
                return response()->json([
                    'message' => '更新排序失败',
                    'error' => 1
                ]);
            }
        }

        //整体更新
        $rule = [
            'display_name' => 'required',
            'name' => 'required',
            'parent_id' => 'required|integer',
            'order' => 'required|integer',
            'is_menu' => 'in:0,1'
        ];

        $this->validate($request, $rule);
        if (str_contains('#', $request->get('name'))) {
            $data = array_merge($request->all(), ['name' => '#' . Carbon::now()->toDateTimeString()]);
        } else {
            $data = $request->all();
        }
        $rst = $permission->update($data);
        if ($rst) {
            return redirect('admin/permission')->with(['message' => '更新成功']);
        } else {
            return back()->withErrors(['message' => '更新失败']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $children = Permission::where('parent_id',$permission->id)->get(['id'])->toArray();

        $rst = Permission::destroy(array_flatten($children));
        if($rst){
            $response = [
                'message' => '删除成功',
                'error' => 0
            ];
        }else{
            $response = [
                'message' => '删除失败',
                'error' => 1
            ];
        }
        return response()->json($response);
    }
}
