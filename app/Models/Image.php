<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $primaryKey = 'img_id';
    protected $fillable=[
        'pid','path','order','is_main'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'pid');
    }
}
