@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Limo express</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Driver</a></li>
                        <li class="breadcrumb-item active">Driver!</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    Driver Details!
                    @if ($driver->status == "1")
                        <span class="btn btn-success">Approved</span>
                    @elseif ($driver->status == "0")
                        <span class="btn btn-warning">Pending</span>
                    @elseif ($driver->status == "2")
                        <span class="btn btn-danger">Reject</span>
                    @endif
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header border-0 cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Basic Info!</h3>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Image</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                @if($driver->profile != null)
                                    <img src="{{ asset('images/profile/' . $driver->profile) }}" alt="Current Image" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <img src="{{ URL::to('backend/images/default.png') }}" alt="logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Name</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12 fv-row fv-plugins-icon-container">
                                        <span class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                                            {{$driver->name}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Phone</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <span class="form-control form-control-lg form-control-solid">{{$driver->phone}}</span>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Email</label>
                            <div class="col-lg-8 fv-row">
                                <span class="form-control form-control-lg form-control-solid">{{$driver->email}}</span>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Address</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <span class="form-control form-control-lg form-control-solid">{{$driver->address}}</span>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Ratting</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <span class="form-control form-control-lg form-control-solid">{{$driver->ratting}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header border-0 cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Car Info!</h3>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Image</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <img src="{{asset('images/carImage/'. $driver->car->car_image )}}" alt="Current Image"  style="width: 150px; height: 90px;">
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Car Name</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12 fv-row fv-plugins-icon-container">
                                        <span class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                                            {{$driver->car->car_name}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Car Model</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <span class="form-control form-control-lg form-control-solid"> {{$driver->car->car_model}}</span>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Car Color</label>
                            <div class="col-lg-8 fv-row">
                                <span class="form-control form-control-lg form-control-solid">{{$driver->car->car_color}}</span>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Passenger Capacity</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <span class="form-control form-control-lg form-control-solid">{{$driver->car->passengers}}</span>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Bag Capacity</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <span class="form-control form-control-lg form-control-solid">{{$driver->car->car_bag}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header border-0 cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Licence Info!</h3>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6 mb-2">
                            <label class="col-form-label fw-semibold fs-6">Licence font Image</label>
                            <div class="fv-row fv-plugins-icon-container">
                                <img src="{{asset('images/driving_licence_font_image/'. $driver->driving_licence_font_image )}}" alt="Current Image" style="width: 500px; height: 300px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-form-label fw-semibold fs-6">Licence Back Image</label>
                            <div class="fv-row fv-plugins-icon-container">
                               <img src="{{asset('images/driving_licence_back_image/'. $driver->driving_licence_back_image )}}" alt="Current Image" style="width: 500px; height: 300px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header border-0 cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">RTA Info!</h3>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6 mb-2">
                            <label class="col-form-label fw-semibold fs-6">RTA card font Image</label>
                            <div class="fv-row fv-plugins-icon-container">
                                 <img src="{{asset('images/rta_card_font_image/'. $driver->rta_card_font_image )}}" alt="Current Image" style="width: 500px; height: 300px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-form-label fw-semibold fs-6">RTA card Back Image</label>
                            <div class="fv-row fv-plugins-icon-container">
                                 <img src="{{asset('images/rta_card_back_image/'. $driver->rta_card_back_image )}}" alt="Current Image" style="width: 500px; height: 300px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($driver->status === '0' || $driver->status === '2')
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header border-0 cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Change Status!</h3>
                        <form method="post" action="{{route('driver.update',$driver->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <select name="status" class="form-select" id="example-select">
                                            <option value="0" {{ $driver->status == "0" ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ $driver->status == "1" ? 'selected' : '' }}>Approved</option>
                                            <option value="2" {{ $driver->status == "2" ? 'selected' : '' }}>Account Suspend</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif


@endsection
