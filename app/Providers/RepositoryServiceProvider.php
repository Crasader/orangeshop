<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Repositories\BrandRepository::class, \App\Repositories\Eloquent\BrandRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\AttributeRepository::class, \App\Repositories\Eloquent\AttributeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\AttributeValueRepository::class, \App\Repositories\Eloquent\AttributeValueRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\CategoryRepository::class, \App\Repositories\Eloquent\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\ProductRepository::class, \App\Repositories\Eloquent\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\AdminRepository::class, \App\Repositories\Eloquent\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\RoleRepository::class, \App\Repositories\Eloquent\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\PromotionSingleRepository::class, \App\Repositories\Eloquent\PromotionSingleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\PromotionSingleRepository::class, \App\Repositories\Eloquent\PromotionSingleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\PromotionSingleProductRepository::class, \App\Repositories\Eloquent\PromotionSingleProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\PromotionBuySendRepository::class, \App\Repositories\Eloquent\PromotionBuySendRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\PromotionFullSendRepository::class, \App\Repositories\Eloquent\PromotionFullSendRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\PromotionSuitRepository::class, \App\Repositories\Eloquent\PromotionSuitRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\CouponRepository::class, \App\Repositories\Eloquent\CouponRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Repositories\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        //:end-bindings:
    }
}
