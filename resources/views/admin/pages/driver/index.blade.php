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
                            <td>
                                @if($driverData->status==0)
                                    Pending
                                @elseif($driverData->status==1)
                                    Approved
                                @elseif($driverData->status==2)
                                    Suspend
                                @endif
                            </td>
                            <td style="width: 100px;">
                                <div class="d-flex  gap-1">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$driverData->id}}">Change Status</button>
                                    <a href="{{route('driver.history',$driverData->did)}}"class="btn btn-info">History</a>
                                    <a href="{{route('driver.trip.history',$driverData->did)}}"class="btn btn-info">Trip</a>
                                </div>

                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$driverData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$driverData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$driverData->id}}">Status</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('driver.update',$driverData->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="example-select" class="form-label">Status</label>
                                                            <select name="status" class="form-select" id="example-select">
                                                                <option value="0" {{ $driverData->status === 0 ? 'selected' : '' }}>Pending</option>
                                                                <option value="1" {{ $driverData->status === 1 ? 'selected' : '' }}>Approved</option>
                                                                <option value="2" {{ $driverData->status === 2 ? 'selected' : '' }}>Account Suspend</option>
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
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
