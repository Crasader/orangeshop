<?php

namespace App\Providers;

use App\Models\Permission;
use App\Repositories\Repositories\BrandRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //时间设置
        Carbon::setLocale('zh');
        //共享左侧菜单
        if(\Request::is('admin/*')){
            $menu = Permission::with('child_menu')->where(['parent_id'=>0,'is_menu'=>1])->orderBy('order')->get();
            View::share('menu',$menu);
        }

        if(Auth::check()){
            $total_goods = Auth::user()->order_products->count();
            View::share('total_goods',$total_goods);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->register(RepositoryServiceProvider::class);

    }
}
