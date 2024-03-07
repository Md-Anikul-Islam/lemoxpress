<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function driverList()
    {
        $driver = Driver::with('histories')->latest()->get();
        //dd($driver);
        return view('admin.pages.driver.index',compact('driver'));
    }
}
