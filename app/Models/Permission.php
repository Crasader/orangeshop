<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = [
        'name', 'display_name', 'parent_id', 'order', 'description', 'is_menu'
    ];

    //获取分类树
    public static function permission_tree($pid = 0)
    {
        $permissions = Permission::orderBy('order')->get()->toArray();
        //dd($permissions);
        $permissions_tree = self::tree($permissions, $pid);
        return $permissions_tree;
    }

    public static function tree($permissions, $pid = 0, $depth = 0, $prefix = '|——')
    {
        $arr = [];
        foreach ($permissions as $permission) {
            if ($permission['parent_id'] == $pid) {
                if ($depth > 0) {
                    $permission['display_name'] = str_repeat('　　', $depth) . $prefix . $permission['display_name'];
                }
                $arr[] = $permission;
                $_depth = $depth + 1;
                $arr = array_merge($arr, self::tree($permissions, $permission['id'], $_depth));
            }
        }
        return $arr;
    }

    // 多对多
    public function child_menu()
    {
        return $this->hasMany(Permission::class,'parent_id','id')->where('is_menu',1)->orderBy('order');
    }

    public function child_checkbox()
    {
        return $this->hasMany(Permission::class,'parent_id','id');
    }

}
