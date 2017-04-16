<?php
// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('主页', route('home'));
});

// 主页 > 商品列表
Breadcrumbs::register('product.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('商品列表', route('product.index'));
});
// 主页 > 商品列表 > 新增商品
Breadcrumbs::register('product.create', function($breadcrumbs)
{
    $breadcrumbs->parent('product.index');
    $breadcrumbs->push('新增商品', route('product.create'));
});

/*// Home >
Breadcrumbs::register('blog', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('blog');
    $breadcrumbs->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});*/