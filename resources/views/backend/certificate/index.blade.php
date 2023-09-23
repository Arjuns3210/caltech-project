@extends('backend.layouts.app')
@section('content')
<div class="main-content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <section class="users-list-wrapper">
                <div class="users-list-table">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2">Manage Certificate</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter</button>
                                               @if($data['certificate_add'])
                                                <a href="certificate_add" class="btn btn-sm btn-success px-3 py-1 src_data"><i class="fa fa-plus"></i> New</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- <hr class="mb-0"> -->
                                    <div class="card-body">
                                     <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Certificate No</label>
                                            <input class="form-control mb-3" type="text" id="search_certificate_no" name="search_certificate_no">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Product</label>
                                            <select class="form-control mb-3 select2" id="search_product_id" name="search_product_id" style="width: 100% !important;">
                                                <option value="">Select</option>
                                                @foreach($data['products'] as $product)
                                                    <option value="{{$product->id}}">{{$product->make}}</option>
                                                @endforeach
                                            </select>
                                         </div>
                                         <div class="col-md-4">
                                            <label>Client</label>
                                            <select class="form-control mb-3 select2" id="search_client_id" name="search_client_id" style="width: 100% !important;">
                                                <option value="">Select</option>
                                                @foreach($data['clients'] as $client)
                                                    <option value="{{$client->id}}">{{$client->contact_person_name}}</option>
                                                @endforeach
                                            </select>
                                         </div>
                                        <div class="col-md-4">
                                            <label>Date of Calibration</label>
                                            <input class="form-control mb-3 date" type="date" id="search_calibration_date" name="search_calibration_date" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'>
                                        </div>
                                         <div class="col-md-4">
                                            <label>Next Date Calibration</label>
                                            <input class="form-control mb-3 date" type="date" id="search_next_calibration_date" name="search_next_calibration_date"  onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'>
                                        </div>
                                        <div class="col-md-4">
                                            <label>&nbsp;</label><br/>
                                            <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                        </div>
                                    </div>
                                     <div class="table-responsive">
                                        <table class="table table-bordered table-hover datatable" id="dataTable" width="100%" cellspacing="0" data-url="certificate_data">
                                                <thead>
                                                <tr>
                                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">Id</th>
                                                    <th id="certificate_no" data-orderable="false" data-searchable="false">CERTIFICATE NO</th>
                                                    <th id="client" data-orderable="false" data-searchable="false">COMPANY NAME</th>
                                                    <th id="product" data-orderable="false" data-searchable="false">PRODUCT MODEL NO</th>
                                                    {{-- @if($data['product_edit'] || $data['product_view'] || $data['product_status'] || $data['product_delete']) --}}
                                                    <th id="action" data-orderable="false" data-searchable="false" width="130px">Action</th>
                                                    {{-- @endif --}}
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
