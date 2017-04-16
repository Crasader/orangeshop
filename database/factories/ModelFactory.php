<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Brand::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'logo_path' => $faker->imageUrl(),
        'description' => $faker->sentence,
        'order' => $faker->numberBetween(0, 10),
        'state' => $faker->numberBetween(0, 1)
    ];
});

$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    $cates = \App\Models\Category::all()->toArray();
    $cate = $faker->randomElement($cates);
    return [
        'parent_id' => isset($cate['cate_id']) ? $cate['cate_id'] : 0,
        'name' => $faker->name,
        'description' => $faker->sentence,
        'keywords' => $faker->word,
        'price_range' => $faker->word,
        'url' => $faker->url,
        'is_show' => $faker->numberBetween(0, 1),
        'is_nav' => $faker->numberBetween(0, 1),
        'order' => $faker->numberBetween(0, 9)
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    $brands =\App\Models\Brand::has('categories')->with('categories')->get();
    $brand = $faker->randomElement($brands->toArray());
    return [
        'name' => '化妆品'.'-'.$brand['name'].'-'.$brand['categories'][0]['name'],
        'cate_id' => $brand['categories'][0]['cate_id'],
        'brand_id' => $brand['brand_id'],
        'order' => $faker->numberBetween(0,10),
        'weight' => $faker->numberBetween(5,300),
        'stock' => $faker->numberBetween(10,100),
        'stock_limit'=> $faker->numberBetween(0,5),
        'cost_price' => $faker->numberBetween(10,300),
        'market_price' => $faker->numberBetween(10,300),
        'shop_price' => $faker->numberBetween(10,300),
        'state' => $faker->boolean,
        'is_best' => $faker->boolean,
        'is_hot' => $faker->boolean,
        'is_new' => $faker->boolean,

        'is_free_shipping' => $faker->boolean,
        'description' => $faker->text,
        'keywords' => $faker->word,
        'sale_count' => $faker->numberBetween(10,100),
        'visit_count' => $faker->numberBetween(10,100),
        'review_count' => $faker->numberBetween(10,100),
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->safeEmail,
        'password' => bcrypt($faker->password),
        'mobile' => $faker->word,
        'verify_email' => $faker->boolean,
        'verify_mobile' => $faker->boolean,
        'lift_ban_time' => $faker->dateTimeBetween(),
        'level_id' => $faker->randomNumber(),
        'last_visit_time' => $faker->dateTimeBetween(),
        'last_visit_ip' => $faker->word,
        'register_ip' => $faker->word,
        'register_rg_id' => $faker->word,
        'sex' => $faker->boolean,
        'remember_token' => str_random(10),
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Models\Attribute::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'is_filter' => $faker->numberBetween(0, 1),
        'show_type' => $faker->numberBetween(0, 2),
        'order' => $faker->numberBetween(0, 20)
    ];
});

$factory->define(App\Models\AttributeValue::class, function (Faker\Generator $faker) {
    $attrs = \App\Models\Attribute::all()->toArray();
    $attr = $faker->randomElement($attrs);
    return [
        'attr_id' => $attr['attr_id'],
        'attr_value_0' => $attr['show_type'] == 0 ? $faker->name : '',
        'attr_value_1' => $attr['show_type'] == 1 ? $faker->rgbCssColor : '',
        'attr_value_2' => $attr['show_type'] == 2 ? $faker->imageUrl(60, 60) : '',
        'order' => $faker->numberBetween(0, 30)
    ];
});