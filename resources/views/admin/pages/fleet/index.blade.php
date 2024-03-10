@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Limoe xpress</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Fleet</a></li>
                        <li class="breadcrumb-item active">Fleet!</li>
                    </ol>
                </div>
                <h4 class="page-title">Fleet!</h4>
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
                        <th>Fleet Type Name</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($fleet as $key=>$fleetData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$fleetData->fleetType->name}}</td>
                            <td>{{$fleetData->car_name}}</td>
                            <td>
                                <img src="{{asset('images/carImage/'. $fleetData->car_image )}}" alt="Current Image" style="max-width: 50px;">
                            </td>
                            <td>{{$fleetData->car_model}}</td>
                            <td>{{$fleetData->car_color}}</td>
                            <td>{{$fleetData->car_base}}</td>
                            <td>{{$fleetData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$fleetData->id}}">Edit</button>
                                    <a href="{{route('fleet.destroy',$fleetData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$fleetData->id}}">Delete</a>
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$fleetData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$fleetData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$fleetData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('fleet.update',$fleetData->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">

                                                        <div class="mb-2">
                                                            <label for="example-select" class="form-label">Type</label>
                                                            <select name="car_type" class="form-select" id="example-select">
                                                                <option>Select Type</option>
                                                                @foreach($fleetType as $fleetTypeData)
                                                                    <option value="{{$fleetTypeData->id}}" {{$fleetTypeData->id == $fleetData->car_type ? 'selected' : ''}}>{{$fleetTypeData->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="car_name" class="form-label">Name</label>
                                                            <input type="text" id="car_name" name="car_name" value="{{$fleetData->car_name}}"
                                                                   class="form-control" placeholder="Enter Car Name" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="car_model" class="form-label">Model</label>
                                                            <input type="text" id="car_model" name="car_model" value="{{$fleetData->car_model}}"
                                                                   class="form-control" placeholder="Enter Fleet model" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="car_color" class="form-label">Color</label>
                                                            <input type="text" id="car_color" name="car_color" value="{{$fleetData->car_color}}"
                                                                   class="form-control" placeholder="Enter Fleet color" required>
                                                        </div>


                                                        <div class="mb-2">
                                                            <label for="passengers" class="form-label">Passengers</label>
                                                            <input type="text" id="passengers" name="passengers" value="{{$fleetData->passengers}}"
                                                                   class="form-control" placeholder="Enter Fleet Passengers" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="car_base" class="form-label">Amount Per K.M.</label>
                                                            <input type="text" id="car_base" name="car_base" value="{{$fleetData->car_base}}"
                                                                   class="form-control" placeholder="Enter Fleet Amount Per K.M." required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="car_base" class="form-label">Car Image</label>
                                                            <input type="file" id="car_image" name="car_image"
                                                                   class="form-control" placeholder="Enter Fleet Image">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1" {{ $fleetData->status === 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $fleetData->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{$fleetData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$fleetData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$fleetData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('fleet.destroy',$fleetData->id)}}" class="btn btn-danger">Delete</a>
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
                    <form method="post" action="{{route('fleet.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">

                                <div class="mb-2">
                                    <label for="example-select" class="form-label">Type</label>
                                    <select name="car_type" class="form-select" id="example-select">
                                        <option>Select Type</option>
                                        @foreach($fleetType as $fleetTypeData)
                                        <option value="{{$fleetTypeData->id}}">{{$fleetTypeData->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label for="car_name" class="form-label">Name</label>
                                    <input type="text" id="car_name" name="car_name"
                                           class="form-control" placeholder="Enter Car Name" required>
                                </div>

                                <div class="mb-2">
                                    <label for="car_model" class="form-label">Model</label>
                                    <input type="text" id="car_model" name="car_model"
                                           class="form-control" placeholder="Enter Fleet model" required>
                                </div>

                                <div class="mb-2">
                                    <label for="car_color" class="form-label">Color</label>
                                    <input type="text" id="car_color" name="car_color"
                                           class="form-control" placeholder="Enter Fleet color" required>
                                </div>


                                <div class="mb-2">
                                    <label for="passengers" class="form-label">Passengers</label>
                                    <input type="text" id="passengers" name="passengers"
                                           class="form-control" placeholder="Enter Fleet Passengers" required>
                                </div>

                                <div class="mb-2">
                                    <label for="car_base" class="form-label">Amount Per K.M.</label>
                                    <input type="text" id="car_base" name="car_base"
                                           class="form-control" placeholder="Enter Fleet Amount Per K.M." required>
                                </div>

                                <div class="mb-2">
                                    <label for="car_base" class="form-label">Car Image</label>
                                    <input type="file" id="car_image" name="car_image"
                                           class="form-control" placeholder="Enter Fleet Image" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
