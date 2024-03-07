<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use Illuminate\Http\Request;

class FleetSearchController extends Controller
{
    public function search(Request $request, $fleet_type)
    {
        try {
            $fleet  = Fleet::where('fleet_type_id',$fleet_type)->with('fleetType')->get();
            return response()->json(['fleet' => $fleet], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }



}
