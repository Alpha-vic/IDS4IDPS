<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\LGA;
use Illuminate\Http\Request;

class CampController extends Controller
{
    public function add(Request $request)
    {
        $in = $request->input();
        if (empty($in['code']) or empty($in['name']) or empty($in['lga']) or empty($in['address'])) {
            return ['status' => false, 'message' => 'Invalid Request'];
        }
        if (!is_object($lga = LGA::find($in['lga']))) {
            return ['status' => false, 'message' => 'Invalid LGA'];
        }
        if (is_object($camp = Camp::findByCode($in['code']))) {
            return ['status' => false, 'message' => 'Camp code must be unique.'];
        }
        $camp = Camp::create(['code' => $in['code'], 'name' => $in['name'], 'lga_id' => $lga->id, 'address' => $in['address']]);

        return ['status' => true, 'message' => 'LGA added successfully'];
    }
}