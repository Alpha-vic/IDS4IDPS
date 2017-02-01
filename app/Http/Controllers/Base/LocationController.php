<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function addState(Request $request)
    {
        return ['ok'=>'ok'];
    }

    public function addLga(Request $request)
    {
        return ['ok'=>'ok'];
    }
}