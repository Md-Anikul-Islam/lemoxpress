@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Limo express</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                        <li class="breadcrumb-item active">History!</li>
                    </ol>
                </div>
                <h4 class="page-title">History!</h4>
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
                        <th>UID</th>
                        <th>Origin Address</th>
                        <th>Destination Address</th>
                        <th>Time</th>
                        <th>Fare</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userHistpry as $key=>$userHistpryData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$userHistpryData->uid}}</td>
                            <td>{{$userHistpryData->origin_address}}</td>
                            <td>{{$userHistpryData->destination_address}}</td>
                            <td>{{$userHistpryData->time}}</td>
                            <td>{{$userHistpryData->total_fare}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
