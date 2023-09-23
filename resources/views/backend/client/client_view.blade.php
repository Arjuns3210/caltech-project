<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
            <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Client Details : {{$data->company_name}}</h5>
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
                                  <dt><i class="fa fa-building"></i> {{$data->company_name}}</dt>
                                  <hr style=" margin-top: 3px; margin-bottom: 12px;border: 0;border-top: 1px solid #e0e0e0;">
                                      <dd>GSTIN: {{$data->GSTIN}}</dd>
                                      <dd>Currency: INR</dd>
                                </dl><br>

                                <dl>
                                  <dt>Contact Person</dt>
                                  <hr style=" margin-top: 3px; margin-bottom: 12px;border: 0;border-top: 1px solid #e0e0e0;">
                                      <dd class="bold"><i class="fa fa-user"></i> {{$data->contact_person_name}}</dd>
                                      <dd><i class="fa fa-envelope"></i> {{$data->email}}</dd>
                                      <dd><i class="fa fa-phone"></i> {{$data->company_number}}</dd>
                                </dl>
                                <br>
                                <dl>
                                  <dt>Address</dt>
                                  <hr style=" margin-top: 3px; margin-bottom: 12px;border: 0;border-top: 1px solid #e0e0e0;">
                                   <dt><i class="fa fa-building"></i> BILLING ADDRESS</dt>
                                      <dd><i class="fa fa-map-marker"></i> {{$data->address}}</dd>
                                      <dd>&nbsp;&nbsp;&nbsp;{{$data->city}} {{$data->pin_code}}</dd>
                                      <dd>&nbsp;&nbsp;&nbsp;{{$data->state}},{{$data->country}}</dd>
                                  </dl>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>