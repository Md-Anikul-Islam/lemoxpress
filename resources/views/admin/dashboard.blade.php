@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Limo express</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Welcome!</li>
                    </ol>
                </div>
                <h4 class="page-title">Welcome!</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-pink">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-app-store-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Total User</h6>
                    <h2 class="my-2">{{$totalUser}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-purple">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-profile-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Total Driver</h6>
                    <h2 class="my-2">{{$totalDriver}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-info">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-route-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Total Fleet</h6>
                    <h2 class="my-2">{{$totalFleet}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-primary">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-route-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Total Toll</h6>
                    <h2 class="my-2">{{$totalToll}}</h2>
                </div>
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
                                @if($driverData->profile!=null)
                                    <img src="{{asset('images/profile/'. $driverData->profile )}}" alt="Current Image" style="max-width: 70px;">
                                @else
                                    <img src="{{URL::to('backend/images/defult.png')}}" alt="logo" style="height: 70px;">
                                @endif
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
                                    <a href="{{route('driver.destroy',$driverData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$driverData->id}}">Delete</a>
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

                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{$driverData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$driverData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$driverData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($driverData->driverHistory->count() > 0)
                                                <h5 class="mt-0">
                                                    Deleting this driver will also remove all associated trip history records. Are you sure you want to proceed?
                                                </h5>
                                            @else
                                                <h5 class="mt-0">
                                                    This driver has no associated trip history. Are you sure you want to delete this driver?
                                                </h5>
                                            @endif

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('driver.destroy',$driverData->id)}}" class="btn btn-danger">Delete</a>
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
