<?php

namespace App\Http\Controllers\Home;

use App\Library\Common;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

}
