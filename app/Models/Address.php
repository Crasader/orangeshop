<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $primaryKey = 'address_id';

    protected $fillable = [
        "user_id",
        "consignee",
        "mobile",
        "province_id",
        "city_id",
        "district_id",
        "address",
        "zipcode",
        "is_default",
    ];

    public function province()
    {
        return $this->belongsTo(City::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(City::class, 'district_id');
    }
}
