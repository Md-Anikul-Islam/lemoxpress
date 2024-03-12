<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Toll;
use Illuminate\Http\Request;

class TollController extends Controller
{
    public function allToll()
    {
        try {
            $toll = Toll::latest()->get();
            return response()->json(['coordinate' => $toll], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }
}
