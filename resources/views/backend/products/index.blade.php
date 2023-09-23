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
                                            <h5 class="pt-2">Manage Product</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter</button>
                                               @if($data['product_add'])
                                                <a href="products_add" class="btn btn-sm btn-success px-3 py-1 src_data"><i class="fa fa-plus"></i> New</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- <hr class="mb-0"> -->
                            	<div class="card-body">
                                    <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Sr.no</label>
                                            <input class="form-control mb-3" type="text" id="search_product_sr_no" name="search_product_sr_no">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Name</label>
                                            <input class="form-control mb-3" type="text" id="search_name" name="search_name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Range</label>
                                            <input class="form-control mb-3" type="text" id="search_range" name="search_range">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Make</label>
                                            <input class="form-control mb-3" type="text" id="search_make" name="search_make">
                                        </div>
                                         <div class="col-md-4">
                                            <label>Least Count</label>
                                            <input class="form-control mb-3" type="text" id="search_count" name="search_count">
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <label>&nbsp;</label><br/>
                                            <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                        </div>
                                    </div>
                            		<div class="table-responsive">
                                        <table class="table table-bordered table-hover datatable" id="dataTable" width="100%" cellspacing="0" data-url="products_data">
				                            <thead>
				                                <tr>
				                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">Id</th>
                                                    <th id="name" data-orderable="false" data-searchable="false">Name</th>
                                                    <th id="product_sr_no" data-orderable="false" data-searchable="false">Product Model No</th>
                                                  
                                                    @if($data['product_edit'] || $data['product_view'] || $data['product_status'] || $data['product_delete'])
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
