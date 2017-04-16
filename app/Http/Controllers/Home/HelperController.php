<?php

namespace App\Http\Controllers\Home;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HelperController extends Controller
{


    public function getCities(Request $request)
    {
        debugbar()->disable();
        $pid = $request->get('pid');
        $level = $request->get('level');

        //取city
        if($level == 2){
            $cities = Cache::get('cities',function(){
                return City::where('level',2)->get();
            });
            $data = $cities->where('pid',$pid)->all();
        }

        //取区
        if($level == 3){
            $districts = Cache::get('districts',function(){
                return City::where('level',3)->get();
            });
            $data = $districts->where('pid',$pid)->all();
        }

        return response()->json($data);
    }
}
