@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Profile</th>
                        <th>Licence</th>
                        <th>RTA Card</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($driver as $key=>$driverData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$driverData->name}}</td>
                            <td>{{$driverData->email}}</td>
                            <td>{{$driverData->phone}}</td>
                            <td>
                                <img src="{{asset('images/profile/'. $driverData->profile )}}" alt="Current Image" style="max-width: 70px;">
                            </td>
                            <td>
                                <img src="{{asset('images/driving_licence_font_image/'. $driverData->driving_licence_font_image )}}" alt="Current Image" style="max-width: 70px;">
                            </td>
                            <td>
                                <img src="{{asset('images/rta_card_font_image/'. $driverData->rta_card_font_image )}}" alt="Current Image" style="max-width: 70px;">
                            </td>
                            <td>{{$driverData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex  gap-1">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$driverData->id}}">History</button>
                                    @if($driverData->status == 1)
                                        <a href="{{route('driver.inactive',$driverData->id)}}" class="btn btn-danger">Inactive</a>
                                    @else
                                        <a href="{{route('driver.active',$driverData->id)}}" class="btn btn-success" >Active</a>
                                    @endif
                                </div>

                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$driverData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$driverData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$driverData->id}}">List</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Test
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
