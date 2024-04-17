<!DOCTYPE html>
<html lang="en">
<head>
    <title>Limo express</title>
    <meta content="limo express" name="author" />
    <link rel="shortcut icon" href="{{asset('backend/images/lemo.svg')}}">
    <script src="{{asset('backend/js/config.js')}}"></script>
    <link href="{{asset('backend/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .navbar-custom {
            display: flex;
            align-items: center;
        }
        .navbar-custom,
        .content-page {
             margin-left: 0;
        }
    </style>
</head>

<body>
<div class="wrapper">
    <div class="navbar-custom">
        <div class="topbar container-fluid">
            <img src="http://127.0.0.1:8000/backend/images/lemo.svg" alt="logo" style="height: 50px;">
        </div>
    </div>

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Limo Express</a></li>
                                    <li class="breadcrumb-item active">Trip Details</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Trip Details</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Trip History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">Passenger Name</th>
                                            <th scope="col">Passenger Phone</th>
                                            <th scope="col">Origin Address</th>
                                            <th scope="col">Destination Address</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Total Fare</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$tripRequest->passenger_name}}</td>
                                            <td>{{$tripRequest->passenger_phone}}</td>
                                            <td>{{$tripRequest->origin_address}}</td>
                                            <td>{{$tripRequest->destination_address}}</td>
                                            <td>{{$tripRequest->time}}</td>
                                            <td>{{$tripRequest->total_fare}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Driver Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive-sm">
                                    <table class="table table-bordered table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                @if($tripRequest->driver)
                                                <img src="{{asset('images/profile/'.$tripRequest->driver->profile )}}" alt="Current Image" style="max-width: 50px; height: 50px;">
                                                @else
                                                No Image
                                                @endif
                                            </td>
                                            <td>{{$tripRequest->driver? $tripRequest->driver->name:'N/A'}}</td>
                                            <td>{{$tripRequest->driver? $tripRequest->driver->email:'N/A'}}</td>
                                            <td>{{$tripRequest->driver? $tripRequest->driver->phone:'N/A'}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Car Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive-sm">
                                    <table class="table table-bordered table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Car Name</th>
                                            <th>Model</th>
                                            <th>Color</th>
                                            <th>Seat Capacity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                @if($tripRequest->driver)
                                                    <img src="{{asset('images/carImage/'. $tripRequest->driver->car->car_image )}}" alt="Current Image" style="max-width: 50px;height: 50px;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{{$tripRequest->driver? $tripRequest->driver->car->car_name:'N/A'}}</td>
                                            <td>{{$tripRequest->driver? $tripRequest->driver->car->car_model:'N/A'}}</td>
                                            <td>{{$tripRequest->driver? $tripRequest->driver->car->car_color:'N/A'}}</td>
                                            <td>{{$tripRequest->driver? $tripRequest->driver->car->passengers:'N/A'}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


</body>
</html>

