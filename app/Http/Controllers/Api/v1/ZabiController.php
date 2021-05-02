<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZabiController extends Controller
{
    public function zabi()
    {
        return auth()->guard('admin-api')->user();
        
    }
}
