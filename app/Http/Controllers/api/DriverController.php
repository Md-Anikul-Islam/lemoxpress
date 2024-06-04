<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverHistory;
use App\Models\DriverRatting;
use App\Models\Fleet;
use App\Models\TripRequest;
use App\Models\UserHistory;
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
            'driving_licence_font_image' => 'required|mimes:jpeg,png,jpg,pdf',
            'driving_licence_back_image' => 'required|mimes:jpeg,png,jpg,pdf',
            'rta_card_font_image' => 'required|mimes:jpeg,png,jpg,pdf',
            'rta_card_back_image' => 'required|mimes:jpeg,png,jpg,pdf',
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


       // $fleet = Fleet::find($request->car_id);

        if($driver){
            $fleet = Fleet::with('fleetType')->find($driver->car_id);
            $fleet->car_type = $fleet->fleetType->name; // Add car_type to the fleet object
            unset($fleet->fleetType); // Remove fleetType object from fleet
        }




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

    public function getDriverHistory($did)
    {
        try {
            $diverHistory = DriverHistory::where('did',$did)->with('driver','driver.car')->latest()->get();
            return response()->json(['history' => $diverHistory], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }

//    public function getDriverHistory($did)
//    {
//        try {
//            $diverHistory = DriverHistory::where('did', $did)
//                ->with(['driver' => function ($query) {
//                    $query->select('id', 'did', 'car_id', 'name', 'email', 'phone', 'address', 'profile', 'ratting', 'status');
//                }, 'driver.car' => function ($query) {
//                    $query->select('id', 'car_name', 'car_model', 'car_color', 'car_image');
//                }])
//                ->latest()
//                ->get(['id', 'did', 'origin_address', 'destination_address', 'time', 'total_fare', 'created_at', 'updated_at']);
//
//            return response()->json(['history' => $diverHistory], 200);
//        } catch (\Exception $e) {
//            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
//        }
//    }

    public function loginDriver(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $driver = Driver::where('phone', $request->phone)->first();
//        if($driver){
//            $fleet = Fleet::find($driver->car_id);
//        }

        if($driver){
            $fleet = Fleet::with('fleetType')->find($driver->car_id);
            $fleet->car_type = $fleet->fleetType->name; // Add car_type to the fleet object
            unset($fleet->fleetType); // Remove fleetType object from fleet
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


    public function driverRatting(Request $request)
    {

        $request->validate([
            'did' => 'required',
            'uid' => 'required',
            'ratting' => 'required|numeric|min:1|max:5', // Added validation for rating range
        ]);

        // Save the rating
        $driverRating = new DriverRatting();
        $driverRating->did = $request->did;
        $driverRating->uid = $request->uid;
        $driverRating->ratting = $request->ratting;
        $driverRating->save();

        // Calculate average rating for the driver
        $driverId = $request->did;
        $ratings = DriverRatting::where('did', $driverId)->pluck('ratting');
        $totalRatings = count($ratings);
        $totalSum = $ratings->sum();
        $averageRating = $totalRatings > 0 ? $totalSum / $totalRatings : 0;

        // Update the driver's total rating in the Driver table
        $driver = Driver::where('did', $driverId)->first();
        if ($driver) {
            $driver->ratting = $averageRating;
            $driver->save();
        }

        return response()->json(['ratting' => $averageRating], 200);
    }


    public function storeDriverManuallyTrip(Request $request)
    {
        $request->validate([
            'driver_id' => 'required',
            'passenger_name' => 'required',
            'passenger_phone' => 'required',
            'origin_address' => 'required',
            'destination_address' => 'required',
            'time' => 'required',
            'estimated_fare' => 'required',
        ]);
        $tripRequest = new TripRequest();
        $tripRequest->driver_id = $request->driver_id;
        $tripRequest->passenger_name = $request->passenger_name;
        $tripRequest->passenger_phone = $request->passenger_phone;
        $tripRequest->origin_address = $request->origin_address;
        $tripRequest->destination_address = $request->destination_address;
        $tripRequest->estimated_fare = $request->estimated_fare;
        $tripRequest->calculated_fare = $request->calculated_fare;
        $tripRequest->time = $request->time;
        $tripRequest->is_complete = "0";
        $tripRequest->save();
        // Load driver and car information
        $tripRequest->load('driver.car');
        // Append link to the newly created trip request
        //$baseUrl = 'https://taxiapp.etldev.xyz'; // Your dynamic base URL
        $baseUrl = url('/');
        $encryptedId = encrypt($tripRequest->id); // Encrypting the ID
        $tripRequest->link = $baseUrl . '/get-specific-driver-trip-history/' . $encryptedId;
        return response()->json(['tripRequest' => $tripRequest], 200);
    }


    public function manualTripList()
    {
        $baseUrl = url('/');
        $tripRequest = TripRequest::with('driver','driver.car')->latest()->get();

        // Append link to each trip request
        $formattedTripRequests = $tripRequest->map(function ($request) use ($baseUrl) {
            $request->link = $baseUrl . '/get-specific-driver-trip-history/' . $request->id;
            return $request;
        });

        // Append encrypted link to each trip request
        $formattedTripRequests = $tripRequest->map(function ($request) use ($baseUrl) {
            $encryptedId = encrypt($request->id); // Encrypting the ID
            $request->link = $baseUrl . '/get-specific-driver-trip-history/' . $encryptedId;
            return $request;
        });

        return response()->json(['manualTripList' => $formattedTripRequests], 200);
    }


    public function manualSpecificTrip($id)
    {


        $baseUrl = url('/');
        $tripRequest = TripRequest::where('driver_id',$id)->with('driver','driver.car')->latest()->get();
        // Append link to each trip request
//        $formattedTripRequests = $tripRequest->map(function ($request) use ($baseUrl) {
//            $request->link = $baseUrl . '/get-specific-driver-trip-history/' . $request->id;
//            return $request;
//        });

        // Append encrypted link to each trip request
        $formattedTripRequests = $tripRequest->map(function ($request) use ($baseUrl) {
            $encryptedId = encrypt($request->id); // Encrypting the ID
            $request->link = $baseUrl . '/get-specific-driver-trip-history/' . $encryptedId;
            return $request;
        });
        return response()->json(['manualTripList' => $tripRequest], 200);
    }

    public function updateTripStatus(Request $request, $id)
    {
        $tripRequest = TripRequest::find($id);
        $tripRequest->is_complete = $request->is_complete;
        $tripRequest->fare_received_status = $request->fare_received_status;
        $tripRequest->save();
        // Load driver and car information
        $tripRequest->load('driver.car');
        // Append link to the newly created trip request
        //$baseUrl = 'https://taxiapp.etldev.xyz'; // Your dynamic base URL
        $baseUrl = url('/');
        $encryptedId = encrypt($tripRequest->id); // Encrypting the ID
        $tripRequest->link = $baseUrl . '/get-specific-driver-trip-history/' . $encryptedId;
        return response()->json(['tripRequest' => $tripRequest], 200);
    }

    public function getDriverProfile($id)
    {
        $driver = Driver::where('did', $id)->with('car.fleetType')->first();

        if ($driver && $driver->car && $driver->car->fleetType) {
            // Add car_type_name directly to the car object
            $driver->car->car_type_name = $driver->car->fleetType->name;
            // Remove the fleetType relationship from the car object
            unset($driver->car->fleetType);
        }
        return response()->json(['driver' => $driver], 200);
    }




//    public function driverTripHistoryAll($did)
//    {
//        $baseUrl = url('/');
//        $tripRequests = TripRequest::with(['userHistories.user', 'driver.car'])
//            ->where('driver_id', $did)
//            ->get();
//        $histories = [];
//        $uniqueHistories = [];
//        foreach ($tripRequests as $tripRequest) {
//            $car = $tripRequest->driver->car;
//            $encryptedId = encrypt($tripRequest->id); // Encrypting the ID
//            $link = $baseUrl . '/get-specific-driver-trip-history/' . $encryptedId;
//            $histories[] = [
//                'driver_id' => $tripRequest->driver_id,
//                'passenger_name' => $tripRequest->passenger_name,
//                'passenger_phone' => '+88' . $tripRequest->passenger_phone,
//                'origin_address' => $tripRequest->origin_address,
//                'destination_address' => $tripRequest->destination_address,
//                'time' => $tripRequest->time,
//                'total_fare' => null,
//                'estimated_fare' => $tripRequest->estimated_fare,
//                'calculated_fare' => $tripRequest->calculated_fare,
//                'fare_received_status' => $tripRequest->fare_received_status,
//                'is_complete' => $tripRequest->is_complete,
//                'trip_type' => $tripRequest->trip_type,
//                'car_name' => $car->car_name ?? null,
//                'car_model' => $car->car_model ?? null,
//                'car_image' => $car->car_image ?? null,
//                'link' => $link,
//            ];
//            foreach ($tripRequest->userHistories as $history) {
//                if (!isset($uniqueHistories[$history->id])) {
//                    $uniqueHistories[$history->id] = [
//                        'driver_id' => $history->did,
//                        'passenger_name' => $history->user->name ?? null,
//                        'passenger_phone' => $history->user->phone ?? null,
//                        'origin_address' => $history->origin_address,
//                        'destination_address' => $history->destination_address,
//                        'time' => $history->time,
//                        'total_fare' => $history->total_fare,
//                        'estimated_fare' => null,
//                        'calculated_fare' => null,
//                        'fare_received_status' => null,
//                        'is_complete' => null,
//                        'trip_type' => $history->trip_type,
//                        'car_name' => $car->car_name ?? null,
//                        'car_model' => $car->car_model ?? null,
//                        'car_image' => $car->car_image ?? null,
//                        'link' => null,
//                    ];
//                }
//            }
//        }
//        $histories = array_merge($histories, array_values($uniqueHistories));
//        return response()->json(['histories' => $histories]);
//    }



    public function driverTripHistoryAll($did)
    {
        $baseUrl = url('/');

        // Fetching trip requests
        $tripRequests = TripRequest::with(['userHistories.user', 'driver.car'])
            ->where('driver_id', $did)
            ->get();

        // Fetching user histories
        $userHistories = UserHistory::with(['user', 'driver.car'])
            ->where('did', $did)
            ->get();



        $histories = [];
        $uniqueHistories = [];

        foreach ($tripRequests as $tripRequest) {
            $car = $tripRequest->driver->car;
            $encryptedId = encrypt($tripRequest->id); // Encrypting the ID
            $link = $baseUrl . '/get-specific-driver-trip-history/' . $encryptedId;
            $histories[] = [
                'driver_id' => $tripRequest->driver_id,
                'passenger_name' => $tripRequest->passenger_name,
                'passenger_phone' => '+88' . $tripRequest->passenger_phone,
                'origin_address' => $tripRequest->origin_address,
                'destination_address' => $tripRequest->destination_address,
                'time' => $tripRequest->time,
                'total_fare' => null,
                'estimated_fare' => $tripRequest->estimated_fare,
                'calculated_fare' => $tripRequest->calculated_fare,
                'fare_received_status' => $tripRequest->fare_received_status,
                'is_complete' => $tripRequest->is_complete,
                'trip_type' => $tripRequest->trip_type,
                'car_name' => $car->car_name ?? null,
                'car_model' => $car->car_model ?? null,
                'car_image' => $car->car_image ?? null,
                'link' => $link,
            ];
            foreach ($tripRequest->userHistories as $history) {
                if (!isset($uniqueHistories[$history->id])) {
                    $uniqueHistories[$history->id] = [
                        'driver_id' => $history->did,
                        'passenger_name' => $history->user->name ?? null,
                        'passenger_phone' => $history->user->phone ?? null,
                        'origin_address' => $history->origin_address,
                        'destination_address' => $history->destination_address,
                        'time' => $history->time,
                        'total_fare' => $history->total_fare,
                        'estimated_fare' => null,
                        'calculated_fare' => null,
                        'fare_received_status' => null,
                        'is_complete' => null,
                        'trip_type' => $history->trip_type,
                        'car_name' => $car->car_name ?? null,
                        'car_model' => $car->car_model ?? null,
                        'car_image' => $car->car_image ?? null,
                        'link' => null,
                    ];
                }
            }
        }

        foreach ($userHistories as $history) {
            $tripRequest = $history->driver;
            $car = $tripRequest->car ?? null;
            //dd($car);

            if (!isset($uniqueHistories[$history->id])) {
                $uniqueHistories[$history->id] = [
                    'driver_id' => $history->did,
                    'passenger_name' => $history->user->name ?? null,
                    'passenger_phone' => $history->user->phone ?? null,
                    'origin_address' => $history->origin_address,
                    'destination_address' => $history->destination_address,
                    'time' => $history->time,
                    'total_fare' => $history->total_fare,
                    'estimated_fare' => null,
                    'calculated_fare' => null,
                    'fare_received_status' => null,
                    'is_complete' => null,
                    'trip_type' => $history->trip_type,
                    'car_name' => $car->car_name ?? null,
                    'car_model' => $car->car_model ?? null,
                    'car_image' => $car->car_image ?? null,
                    'link' => 'ok',
                ];
            }
        }

        $histories = array_merge($histories, array_values($uniqueHistories));

        return response()->json(['histories' => $histories]);
    }

}
