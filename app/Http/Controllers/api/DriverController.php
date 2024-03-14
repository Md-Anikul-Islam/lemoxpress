<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverHistory;
use App\Models\Fleet;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function storeDriver(Request $request)
    {
        $request->validate([
            'did' => 'required|unique:drivers',
            'name' => 'required|string',
            'email' => 'required|email|unique:drivers',
            'phone' => 'required|string|unique:drivers',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif',
            'driving_licence_font_image' => 'required|image|mimes:jpeg,png,jpg',
            'driving_licence_back_image' => 'required|image|mimes:jpeg,png,jpg',
            'rta_card_font_image' => 'required|image|mimes:jpeg,png,jpg',
            'rta_card_back_image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $driver = new Driver();
        $driver->did = $request->did;
        $driver->car_id = (int)$request->car_id;
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->phone = $request->phone;
        $driver->address = $request->address;
        $driver->status = "0"; // Set as string
        $driver->ratting = "0"; // Set as string
        if($request->profile){
            $profile = time().'.'.$request->profile->extension();
            $request->profile->move(public_path('images/profile'), $profile);
            $driver->profile = $profile;
        }

        if($request->driving_licence_font_image){
            $driving_licence_font_image = time().'.'.$request->driving_licence_font_image->extension();
            $request->driving_licence_font_image->move(public_path('images/driving_licence_font_image'), $driving_licence_font_image);
            $driver->driving_licence_font_image = $driving_licence_font_image;
        }

        if($request->driving_licence_back_image){
            $driving_licence_back_image = time().'.'.$request->driving_licence_back_image->extension();
            $request->driving_licence_back_image->move(public_path('images/driving_licence_back_image'), $driving_licence_back_image);
            $driver->driving_licence_back_image = $driving_licence_back_image;
        }

        if($request->rta_card_font_image){
            $rta_card_font_image = time().'.'.$request->rta_card_font_image->extension();
            $request->rta_card_font_image->move(public_path('images/rta_card_font_image'), $rta_card_font_image);
            $driver->rta_card_font_image = $rta_card_font_image;
        }
        if($request->rta_card_back_image){
            $rta_card_back_image = time().'.'.$request->rta_card_back_image->extension();
            $request->rta_card_back_image->move(public_path('images/rta_card_back_image'), $rta_card_back_image);
            $driver->rta_card_back_image = $rta_card_back_image;
        }
        $driver->save();
        $fleet = Fleet::find($request->car_id);
        return response()->json(['driver' => $driver,'fleet' => $fleet,'message' => 'Driver Store Success'], 200);
    }


    public function storeDriverHistory(Request $request)
    {
        $request->validate([
            'did' => 'required',
            'origin_address' => 'required',
            'destination_address' => 'required',
            'time' => 'required',
            'total_fare' => 'required',
        ]);
        $driver = new DriverHistory();
        $driver->did = $request->did;
        $driver->origin_address = $request->origin_address;
        $driver->destination_address = $request->destination_address;
        $driver->total_fare = $request->total_fare;
        $driver->time = $request->time;
        $driver->save();
        return response()->json(['history' => $driver], 200);
    }

//    public function getDriverHistory($did)
//    {
//        try {
//            $diverHistory = DriverHistory::where('did',$did)->with('driver','driver.car')->latest()->get();
//            return response()->json(['history' => $diverHistory], 200);
//        } catch (\Exception $e) {
//            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
//        }
//    }

    public function getDriverHistory($did)
    {
        try {
            $diverHistory = DriverHistory::where('did', $did)
                ->with(['driver' => function ($query) {
                    $query->select('id', 'did', 'car_id', 'name', 'email', 'phone', 'address', 'profile', 'ratting', 'status');
                }, 'driver.car' => function ($query) {
                    $query->select('id', 'car_name', 'car_model', 'car_color', 'car_image');
                }])
                ->latest()
                ->get(['id', 'did', 'origin_address', 'destination_address', 'time', 'total_fare', 'created_at', 'updated_at']);

            return response()->json(['history' => $diverHistory], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }

    public function loginDriver(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $driver = Driver::where('phone', $request->phone)->first();
        if($driver){
            $fleet = Fleet::find($driver->car_id);
        }
        if($driver){
            if ($driver->status == 1) {
                return response()->json(['driver' => $driver, 'fleet' => $fleet,'message' => 'Driver found'], 200);
            }elseif ($driver->status == 0){
                return response()->json(['message' => 'Driver found But Your Account Not Approved'], 200);
            }
            elseif ($driver->status == 2){
                return response()->json(['message' => 'Driver found But Your Account Suspend Please contact Authority'], 200);
            }
        }
        else {
            return response()->json(['message' => 'No Driver found with this phone. Please register.'], 200);
        }
    }





}
