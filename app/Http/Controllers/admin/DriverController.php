<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverHistory;
use Illuminate\Http\Request;
use Toastr;
class DriverController extends Controller
{
    public function driverList()
    {
        $driver = Driver::with('driverHistory')->latest()->get();
        return view('admin.pages.driver.index',compact('driver'));
    }

    public function driverHistpry($id)
    {
        $driverHistpry = DriverHistory::where('did',$id)->latest()->get();
        return view('admin.pages.driver.history',compact('driverHistpry'));
    }


    public function update(Request $request, $id)
    {
        try {
            $driver = Driver::findOrFail($id);
            $request->validate([
                'status' => 'required',
            ]);
            $driver->status = (int)$request->status;
            $driver->save();
            Toastr::success('Driver Status Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

}
