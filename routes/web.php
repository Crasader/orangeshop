<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {

    return view('admin.layouts.layout');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'],function (){
    //登录和注册
    Route::auth();
    Route::get('active', 'Auth\RegisterController@active')->name('active');
});

//需要 权限验证
Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>['auth:admin']], function () {
    Route::get('home',function(){
        return view('admin.layouts.layout');
    })->name('home');

    //错误页
    Route::get('403',function(){
        return view('admin.errors.403');
    });

    //图片上传
    Route::post('upload_image', 'UploadImageController@upload')->name('upload_image');

    //brand
    Route::delete('brand/batch_delete', 'BrandsController@batchDelete')->name('brand.batch_delete');
    Route::resource('brand', 'BrandsController', ['except' => ['show']]);

    //attribute
    Route::delete('attribute/batch_delete', 'AttributesController@batchDelete')->name('attribute.batch_delete');
    Route::resource('attribute', 'AttributesController', ['except' => ['show']]);

    //attributeValue
    Route::resource('attribute_value', 'AttributeValuesController', ['except' => ['show']]);

    //category
    Route::delete('category/batch_delete', 'CategoriesController@batchDelete')->name('category.batch_delete');
    Route::resource('category', 'CategoriesController', ['except' => ['show']]);

    //product_image
    Route::get('product/{pid}/image', 'ProductsController@showImage')->name('product.show_image');
    Route::post('product/{pid}/image', 'ProductsController@storeImage')->name('product.store_image');
    Route::delete('product/{pid}/image', 'ProductsController@deleteImage')->name('product.delete_image');
    Route::put('product/{pid}/image', 'ProductsController@updateImage')->name('product.update_image');

    //product_related
    Route::get('product/{pid}/related', 'ProductsController@showRelated')->name('product.show_related');
    Route::post('product/{pid}/related', 'ProductsController@storeRelated')->name('product.store_related');
    Route::delete('product/{pid}/related', 'ProductsController@deleteRelated')->name('product.delete_related');

    // product
    Route::post('product/search_product','ProductsController@searchProduct')->name('product.search_product');
    Route::post('product/get_cates_by_brand','ProductsController@getCatesByBrand')->name('product.get_cates_by_brand');
    Route::resource('product', 'ProductsController', ['except' => ['show']]);

    //权限
    Route::resource('permission', 'PermissionsController', ['except' => ['show', 'create']]);

    //管理员
    Route::resource('admin', 'AdminsController', ['except' => ['show']]);

    //角色
    Route::resource('role', 'RolesController', ['except' => ['show', 'create']]);

    //活动
    //单品活动
    Route::delete('promotion_single/batch_delete','PromotionSinglesController@batchDelete')->name('promotion_single.batch_delete');
    Route::resource('promotion_single','PromotionSinglesController',['except'=>['show']]);

    //买赠活动 同款产品够几个送几个
    Route::delete('promotion_buy_send/batch_delete','PromotionBuySendsController@batchDelete')->name('promotion_buy_send.batch_delete');
    Route::get('promotion_buy_send/{pm_id}/products','PromotionBuySendsController@products')->name('promotion_buy_send.products');
    Route::post('promotion_buy_send/{pm_id}/add_product','PromotionBuySendsController@addProduct')->name('promotion_buy_send.add_product');
    Route::delete('promotion_buy_send/{pm_id}/remove_product','PromotionBuySendsController@removeProduct')->name('promotion_buy_send.remove_product');
    Route::resource('promotion_buy_send','PromotionBuySendsController',['except'=>['show']]);

    //满赠活动
    Route::delete('promotion_full_send/batch_delete','PromotionFullSendsController@batchDelete')->name('promotion_full_send.batch_delete');
    Route::get('promotion_full_send/{pm_id}/products','PromotionFullSendsController@products')->name('promotion_full_send.products');
    Route::post('promotion_full_send/{pm_id}/add_product','PromotionFullSendsController@addProduct')->name('promotion_full_send.add_product');
    Route::delete('promotion_full_send/{pm_id}/remove_product','PromotionFullSendsController@removeProduct')->name('promotion_full_send.remove_product');
    Route::resource('promotion_full_send','PromotionFullSendsController');

    //套装活动
    Route::delete('promotion_suit/batch_delete','PromotionSuitsController@batchDelete')->name('promotion_suit.batch_delete');
    Route::get('promotion_suit/{pm_id}/products','PromotionSuitsController@products')->name('promotion_suit.products');
    Route::post('promotion_suit/{pm_id}/add_product','PromotionSuitsController@addProduct')->name('promotion_suit.add_product');
    Route::delete('promotion_suit/{pm_id}/remove_product','PromotionSuitsController@removeProduct')->name('promotion_suit.remove_product');
    Route::resource('promotion_suit','PromotionSuitsController');

    //订单管理
    Route::get('order',function(){
        return  '';
    })->name('order.index');

    //用户管理
    Route::get('user',function(){
        return  '';
    })->name('user.index');

    //新闻管理
    Route::get('news',function(){
        return  '';
    })->name('news.index');

    //内容管理
    Route::get('content',function(){
        return  '';
    })->name('content.index');

    //内容管理
    Route::get('logistics',function(){
        return  '';
    })->name('logistics.index');

    //内容管理
    Route::get('pay',function(){
        return  '';
    })->name('pay.index');
});

//用户
Route::group(['namespace' => 'Home'],function(){

    //注册登录
    Route::get('active','Auth\RegisterController@active');
    Route::auth();
    //邮箱验证
    Route::get('active', 'Auth\RegisterController@active')->name('active');

    //首页
    Route::get('/','IndexController@index');

    //商品详情
    Route::get('/introduction/{pid}','IndexController@introduction');


    Route::get('/search',function(){
        return view('home.index.search');
    });
    Route::get('/cart',function(){
        return view('home.index.cart');
    });
    Route::get('/sort',function(){
        return view('home.index.sort');
    });
    Route::get('/success',function(){
        return view('home.index.success');
    });
//    Route::get('/login',function(){
//        return view('home.auth.login');
//    });
//    Route::get('/register',function(){
//        return view('home.auth.register');
//    });

    //ajax获取邮寄地址
    Route::post('/city','HelperController@getCities');


});

//个人中心
Route::group(['namespace'=>'Home','middleware'=>'auth','prefix'=>'user'],function(){
    Route::get('/index','UserController@index');
    Route::get('/information','UserController@information');
    Route::post('/information/update','UserController@update');
    Route::get('/safety','UserController@safety');

    //购物车
    //列表
    Route::get('/cart/{record_id?}','CartController@index');
    //添加商品
    Route::post('/cart/add','CartController@addOrder');
    //移除商品
    Route::delete('/cart/remove','CartController@removeOrder');

    //修改密码
    Route::get('/password','UserController@password');
    Route::post('/password','UserController@passwordReset');

    //换绑邮箱
    Route::get('/email','UserController@email');
    Route::post('/email','UserController@emailReset');
    Route::post('/send_email','UserController@sendEmail');

    //换绑手机
    Route::get('/mobile','UserController@mobile');
    Route::post('/mobile','UserController@mobileReset');
    Route::post('/send_mobile_code','UserController@sendMobileCode');

    //地址管理
    Route::get('/address', 'UserController@address');
    Route::post('/address', 'UserController@addressAdd');
    Route::post('/address/update', 'UserController@addressUpdate');
    Route::delete('/address/delete', 'UserController@addressDelete');

    //订单管理
    Route::get('/order','UserController@order');
    Route::get('/orderinfo','UserController@orderinfo');

    //浏览历史
    Route::get('/history','UserController@history');
});
