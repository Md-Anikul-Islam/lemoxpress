<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\FleetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                'car_type' => 'required',
                'car_model' => 'required',
            ]);

            if($request->car_image){
                $car = time().'.'.$request->car_image->extension();
                $request->car_image->move(public_path('images/carImage'), $car);
            }
            $fleet = new Fleet();
            $fleet->car_type = $request->car_type;
            $fleet->car_model = $request->car_model;
            $fleet->car_name = $request->car_name;
            $fleet->car_color = $request->car_color;
            $fleet->car_base = $request->car_base;
            $fleet->passengers = $request->passengers;
            $fleet->car_image = $car??null;


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
            $fleet = Fleet::findOrFail($id); // Find the fleet record by ID

            $request->validate([
                'car_type' => 'required',
                'car_model' => 'required',
                'car_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Update validation for car image to be nullable
            ]);

            // Update fleet attributes
            $fleet->car_type = $request->car_type;
            $fleet->car_model = $request->car_model;
            $fleet->car_name = $request->car_name;
            $fleet->car_color = $request->car_color;
            $fleet->car_base = $request->car_base;
            $fleet->passengers = $request->passengers;
            $fleet->status = $request->status;
            // Check if a new image is uploaded
            if($request->car_image){
                $cover = time().'.'.$request->car_image->extension();
                $request->car_image->move(public_path('images/carImage'), $cover);
                $fleet->car_image = $cover;
            }
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
