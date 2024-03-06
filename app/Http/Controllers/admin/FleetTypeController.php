<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FleetType;
use Illuminate\Http\Request;
use Toastr;
class FleetTypeController extends Controller
{
    public function index()
    {
        $fleetType =  FleetType::latest()->get();
        return view('admin.pages.fleetType.index',compact('fleetType'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $fleetType = new FleetType();
            $fleetType->name = $request->name;
            $fleetType->save();
            Toastr::success('Fleet Type Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $fleetType = FleetType::find($id);
            $fleetType->name = $request->name;;
            $fleetType->status = $request->status;
            $fleetType->save();
            Toastr::success('Fleet Type Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $fleetType = FleetType::find($id);
            $fleetType->delete();
            Toastr::success('Fleet Type Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
