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
                                            <h5 class="pt-2">Manage Client</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter</button>
                                               @if($data['client_add'])
                                                <a href="client_add" class="btn btn-sm btn-success px-3 py-1 src_data"><i class="fa fa-plus"></i>  New</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- <hr class="mb-0"> -->
                            	<div class="card-body">
                                    <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Company Name</label>
                                            <input class="form-control mb-3" type="text" id="search_company_name" name="search_company_name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Contact Person Name</label>
                                            <input class="form-control mb-3" type="text" id="search_contact_person_name" name="search_contact_person_name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email</label>
                                            <input class="form-control mb-3" type="email" id="search_email" name="search_email">
                                        </div>
                                        <div class="col-sm-4">
                                            <label >City</label>
                                            <input class="form-control mb-3" type="text" id="search_city" name="search_city">
                                        </div>
                                         <div class="col-md-4">
                                            <label>Company No</label>
                                            <input class="form-control mb-3" type="text" id="search_company_number" name="search_company_number">
                                        </div>
                                        <div class="col-md-4">
                                            <label>GSTIN</label>
                                            <input class="form-control mb-3" type="text" id="search_GSTIN" name="search_GSTIN">
                                        </div>
                                        <div class="col-md-4">
                                            <label>&nbsp;</label><br/>
                                            <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                        </div>
                                    </div>
                            		<div class="table-responsive">
                                        <table class="table table-bordered table-hover datatable" id="dataTable" width="100%" cellspacing="0" data-url="client_data">
				                            <thead>
				                                <tr>
				                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">Id</th>
                                                    <th id="company_name" data-orderable="false" data-searchable="false">Company Name</th>
                                                    <th id="contact_person_name" data-orderable="false" data-searchable="false" >Contact Person</th>
                                                    <th id="email" data-orderable="false" data-searchable="false">Email ID</th>
                                                    <th id="company_number" data-orderable="false" data-searchable="false">Company No</th>
                                                    
                                                    @if($data['client_edit'] || $data['client_view'] || $data['client_status']|| $data['client_delete'])
                                                    <th id="action" data-orderable="false" data-searchable="false" width="130px">Action</th>
                                                    @endif
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
