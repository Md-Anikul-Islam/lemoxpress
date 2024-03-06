<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\FleetType;
use Illuminate\Http\Request;
use Toastr;
class FleetController extends Controller
{
    public function index()
    {
        $fleetType =  FleetType::latest()->get();
        $fleet = Fleet::with('fleetType')->latest()->get();
        return view('admin.pages.fleet.index',compact('fleetType','fleet'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fleet_type_id' => 'required',
                'model' => 'required',
            ]);
            $fleet = new Fleet();
            $fleet->fleet_type_id = $request->fleet_type_id;
            $fleet->model = $request->model;
            $fleet->color = $request->color;
            $fleet->number = $request->number;
            $fleet->base_fare_amount = $request->base_fare_amount;
            $fleet->save();
            Toastr::success('Fleet Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'fleet_type_id' => 'required',
                'model' => 'required',
            ]);
            $fleet = Fleet::find($id);
            $fleet->fleet_type_id = $request->fleet_type_id;
            $fleet->model = $request->model;
            $fleet->color = $request->color;
            $fleet->number = $request->number;
            $fleet->base_fare_amount = $request->base_fare_amount;
            $fleet->status = $request->status;
            $fleet->save();
            Toastr::success('Fleet Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $fleet = Fleet::find($id);
            $fleet->delete();
            Toastr::success('Fleet Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
