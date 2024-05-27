@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Limo express</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Trip</a></li>
                        <li class="breadcrumb-item active">Driver!</li>
                    </ol>
                </div>
                <h4 class="page-title">Complete Trip List!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Driver</th>
                        <th>Origin Address</th>
                        <th>Destination Address</th>
                        <th>Total Fare</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($trip as $key=>$tripData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                {{$tripData->driver ? $tripData->driver->name : ''}}
                            </td>

                            <td>{{$tripData->origin_address}}</td>
                            <td>{{$tripData->destination_address}}</td>
                            <td>{{$tripData->total_fare}}</td>
                            <td>{{$tripData->time}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
