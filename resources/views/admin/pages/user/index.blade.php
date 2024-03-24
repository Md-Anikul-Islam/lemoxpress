@extends('admin.app')
@section('admin_content')
    <style>
        .table_header_style_one,
        .table_header_style_tow{
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            align-items: center;
            text-align: center;
            border: 1px solid #ddd;
        }
        .table_header_style_tow {
            border-top: none;
        }
        .table_header_style_one p, .table_header_style_tow p {
            border-right: 1px solid #ddd;
            height: 100%;
            margin-bottom: 0px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .table_header_style_one p {
            font-size: 15px;
        }
        .table_header_style_one p:last-child,
        .table_header_style_tow p:last-child {
            border-right: none;
        }
    </style>
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
                        <th>UID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Profile</th>
                        <th>Status</th>
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
                                <img src="{{asset('images/userProfile/'. $userData->userProfile )}}" alt="Current Image" style="max-width: 70px;">
                            </td>
                            <td>{{$userData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex  gap-1">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$userData->id}}">History</button>
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$userData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$userData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$userData->id}}">User History</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <div class="table_header_style_one">
                                                    <p>S/N</p>
                                                    <p>UID</p>
                                                    <p>Origin Address</p>
                                                    <p>Destination Address</p>
                                                    <p>Time</p>
                                                    <p>Fare</p>
                                                </div>
                                                <div>
                                                    @if($userData->userHistory->count()>0)
                                                   @foreach($userData->userHistory as $key=>$historyData)
                                                    <div class="table_header_style_tow">
                                                        <p>{{$key+1}}</p>
                                                        <p>{{$historyData->uid}}</p>
                                                        <p>{{$historyData->origin_address}}</p>
                                                        <p>{{$historyData->destination_address}}</p>
                                                        <p>{{$historyData->time}}</p>
                                                        <p>{{$historyData->total_fare}}</p>
                                                    </div>
                                                    @endforeach
                                                    @else
                                                        No History Found
                                                    @endif
                                                </div>
                                            </div>
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
