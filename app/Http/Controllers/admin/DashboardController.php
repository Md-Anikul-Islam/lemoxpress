<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\Toll;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::where('role',2)->count();
        $totalDriver = Driver::count();
        $totalFleet =Fleet::count();
        $totalToll =Toll::count();
        return view('admin.dashboard',compact('totalUser','totalDriver', 'totalFleet','totalToll'));
    }
}
