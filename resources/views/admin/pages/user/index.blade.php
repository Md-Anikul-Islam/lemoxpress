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
                <h4 class="page-title">Driver!</h4>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Profile</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user as $key=>$userData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$userData->uid}}</td>
                            <td>{{$userData->name}}</td>
                            <td>{{$userData->email? $userData->email:'N/A'}}</td>
                            <td>{{$userData->phone? $userData->phone:'N/A'}}</td>
                            <td>
                                @if($userData->userProfile!=null)
                                  <img src="{{asset('images/userProfile/'. $userData->userProfile )}}" alt="Current Image" style="width: 70px; height: 70px; border-radius: 50%;">
                                @else
                                    <img src="{{URL::to('backend/images/defult.png')}}" alt="logo" style="height: 70px;">
                                @endif
                            </td>
                            <td style="width: 100px;">
                                <div class="d-flex  gap-1">
                                    <a href="{{route('user.history',$userData->uid)}}"class="btn btn-info">History</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
