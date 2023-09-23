<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
            <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2"> View Product : ({{$data->name}})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                         </div>
                         <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                            <div class="col-12">
                                  <dl>
                                      <dt><i class="ft-info mr-1"></i>Product Details</dt>
                                      <hr style=" margin-top: 3px; margin-bottom: 12px;border: 0;border-top: 1px solid #e0e0e0;">
                                      <dd> Product Model No : {{$data->product_sr_no}}</dd>
                                      <dd> Product Name : {{$data->name}}</dd>
                                      <dd> Product Make / Identification : {{$data->make}}</dd>
                                      <dd> Product Range : {{$data->range}}</dd>
                                      <dd> Product Least Count : {{$data->count}}</dd>
                                      <dd> Remarks : {{$data->remarks}}</dd>
                                  </dl>
                                  <dl>
                                        <dt><i class="ft-info mr-1"></i>Standard Equipment Details </dt>
                                        <hr style=" margin-top: 3px; margin-bottom: 12px;border: 0;border-top: 1px solid #e0e0e0;">
                                        <dd>Standard Equipment Sr.No : {{$data->standard_sr_no}}</dd>
                                        <dd>Standard Description : {{$data->description}}</dd>
                                        <dd>Standard Certificate No : {{$data->certificate_no}}</dd>
                                        <dd>Standard Make : {{$data->standard_make}}</dd>
                                        <dd>Standard Range : {{$data->standard_range}}</dd>
                                        <dd>Valid Till : {{ date('d-m-Y', strtotime($data->valid_till)) }}</dd>
                                  </dl>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>