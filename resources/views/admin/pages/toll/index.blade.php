@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Limo express</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Toll</a></li>
                        <li class="breadcrumb-item active">Toll!</li>
                    </ol>
                </div>
                <h4 class="page-title">Toll!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button>
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($toll as $key=>$tollData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$tollData->name}}</td>
                            <td>{{$tollData->latitude}}</td>
                            <td>{{$tollData->longitude}}</td>
                            <td>{{$tollData->amount}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$tollData->id}}">Edit</button>
                                    <a href="{{route('toll.destroy',$tollData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$tollData->id}}">Delete</a>
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$tollData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$tollData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$tollData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('toll.update',$tollData->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name" value="{{$tollData->name}}"
                                                                   class="form-control" placeholder="Enter name" required>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="latitude" class="form-label">Latitude </label>
                                                            <input type="text" id="latitude" name="latitude" value="{{$tollData->latitude}}"
                                                                   class="form-control" placeholder="Enter latitude" required>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="longitude" class="form-label">Longitude </label>
                                                            <input type="text" id="longitude" name="longitude" value="{{$tollData->longitude}}"
                                                                   class="form-control" placeholder="Enter longitude" required>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="amount" class="form-label">Amount </label>
                                                            <input type="text" id="amount" name="amount" value="{{$tollData->amount}}"
                                                                   class="form-control" placeholder="Enter amount" required>
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
                            <div id="danger-header-modal{{$tollData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$tollData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$tollData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('toll.destroy',$tollData->id)}}" class="btn btn-danger">Delete</a>
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
    <!--Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('toll.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name"
                                           class="form-control" placeholder="Enter name" required>
                                </div>
                                <div class="mb-2">
                                    <label for="latitude" class="form-label">Latitude </label>
                                    <input type="text" id="latitude" name="latitude"
                                           class="form-control" placeholder="Enter latitude" required>
                                </div>
                                <div class="mb-2">
                                    <label for="longitude" class="form-label">Longitude </label>
                                    <input type="text" id="longitude" name="longitude"
                                           class="form-control" placeholder="Enter longitude" required>
                                </div>
                                <div class="mb-2">
                                    <label for="amount" class="form-label">Amount </label>
                                    <input type="text" id="amount" name="amount"
                                           class="form-control" placeholder="Enter amount" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
