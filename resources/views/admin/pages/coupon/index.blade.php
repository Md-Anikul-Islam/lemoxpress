@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Limo express</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Coupon</a></li>
                        <li class="breadcrumb-item active">Coupon!</li>
                    </ol>
                </div>
                <h4 class="page-title">Coupon!</h4>
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
                        <th>Code</th>
                        <th>Discount Type</th>
                        <th>Discount Amount</th>
                        <th>Valid From</th>
                        <th>Valid To</th>
                        <th>Max Use</th>
                        <th>Max Order Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupon as $key=>$couponData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$couponData->code}}</td>
                            <td>{{$couponData->discount_type}}</td>
                            <td>{{$couponData->discount_amount}}</td>
                            <td>{{ \Carbon\Carbon::parse($couponData->valid_from)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($couponData->valid_to)->format('d M Y') }}</td>
                            <td>{{$couponData->max_uses}}</td>
                            <td>{{$couponData->max_amount_to_apply}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$couponData->id}}">Edit</button>
                                    <a href="{{route('coupon.destroy',$couponData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$couponData->id}}">Delete</a>
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$couponData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$couponData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$couponData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('coupon.update',$couponData->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                    <div class="col-12">

                                                        <div class="mb-2">
                                                            <label for="code" class="form-label">Code</label>
                                                            <input type="text" id="code" name="code" value="{{$couponData->code}}"
                                                                   class="form-control" placeholder="Enter Code" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="example-select" class="form-label">Discount Type</label>
                                                            <select name="discount_type" class="form-select" id="example-select">
                                                                <option value="percentage" {{ $couponData->discount_type === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                                <option value="fixed_amount" {{ $couponData->discount_type === 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="discount_amount" class="form-label">Discount Amount</label>
                                                            <input type="text" id="discount_amount" name="discount_amount" value="{{$couponData->discount_amount}}"
                                                                   class="form-control" placeholder="Enter Discount Amount" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="valid_from" class="form-label">Valid From</label>
                                                            <input type="text" id="valid_from" name="valid_from" value="{{ \Carbon\Carbon::parse($couponData->valid_from)->format('d M Y') }}"
                                                                   class="form-control" placeholder="Enter Valid From" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="valid_to" class="form-label">Valid To</label>
                                                            <input type="text" id="valid_to" name="valid_to" value="{{ \Carbon\Carbon::parse($couponData->valid_to)->format('d M Y') }}"
                                                                   class="form-control" placeholder="Enter Valid To" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="max_uses" class="form-label">Max Uses</label>
                                                            <input type="number" id="max_uses" name="max_uses" value="{{$couponData->max_uses}}"
                                                                   class="form-control" placeholder="Enter Max Uses" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="max_amount_to_apply" class="form-label">Max Amount To Apply</label>
                                                            <input type="number" id="max_amount_to_apply" name="max_amount_to_apply" value="{{$couponData->max_amount_to_apply}}"
                                                                   class="form-control" placeholder="Enter Max Amount To Apply" required>
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
                            <div id="danger-header-modal{{$couponData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$couponData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$couponData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('coupon.destroy',$couponData->id)}}" class="btn btn-danger">Delete</a>
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
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" id="code" name="code"
                                           class="form-control" placeholder="Enter Code" required>
                                </div>

                                <div class="mb-2">
                                    <label for="example-select" class="form-label">Discount Type</label>
                                    <select name="discount_type" class="form-select" id="example-select">
                                        <option>Select Type</option>
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed_amount">Fixed Amount</option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label for="discount_amount" class="form-label">Discount Amount</label>
                                    <input type="text" id="discount_amount" name="discount_amount"
                                           class="form-control" placeholder="Enter Discount Amount" required>
                                </div>

                                <div class="mb-2">
                                    <label for="valid_from" class="form-label">Valid From</label>
                                    <input type="date" id="valid_from" name="valid_from"
                                           class="form-control" placeholder="Enter Valid From" required>
                                </div>

                                <div class="mb-2">
                                    <label for="valid_to" class="form-label">Valid To</label>
                                    <input type="date" id="valid_to" name="valid_to"
                                           class="form-control" placeholder="Enter Valid To" required>
                                </div>

                                <div class="mb-2">
                                    <label for="max_uses" class="form-label">Max Uses</label>
                                    <input type="number" id="max_uses" name="max_uses"
                                           class="form-control" placeholder="Enter Max Uses" required>
                                </div>

                                <div class="mb-2">
                                    <label for="max_amount_to_apply" class="form-label">Max Amount To Apply</label>
                                    <input type="number" id="max_amount_to_apply" name="max_amount_to_apply"
                                           class="form-control" placeholder="Enter Max Amount To Apply" required>
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
