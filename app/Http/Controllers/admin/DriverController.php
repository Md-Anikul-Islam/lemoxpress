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
        return view('admin.pages.driver.index',compact('driver'));
    }

    public function inactive($id)
    {
        Driver::where('id',$id)->update(['status'=> 0]);
        return Redirect()->back();

    }

    public function active($id)
    {
        Driver::where('id',$id)->update(['status'=> 1]);
        return Redirect()->back();
    }
}
