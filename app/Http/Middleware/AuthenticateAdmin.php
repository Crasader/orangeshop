<?php

namespace App\Http\Middleware;

use Closure;
use URL, Auth, Route;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        //超级管理员不做处理
        if ($admin->is_super) {
            return $next($request);
        }

        $previousUrl = URL::previous();

        if (!$admin->can(Route::currentRouteName())) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作'
                ]);
            } else {

                return response()->redirectTo('/admin/403');
            }
        }
        return $next($request);
    }
}
