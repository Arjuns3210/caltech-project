<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
            <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Certificate: {{$data->certificate_no}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                         </div>
                         <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#certificate" role="tab" id="certificate-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="details" aria-selected="true">
                                        <i class="ft-info mr-1"></i>
                                        <span class="d-none d-sm-block">Certificate Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#client" role="tab" id="client-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                        <i class="ft-link mr-2"></i>
                                        <span class="d-none d-sm-block">Client Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product" role="tab" id="product-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                        <i class="ft-link mr-2"></i>
                                        <span class="d-none d-sm-block">Product Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#results" role="tab" id="results-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                        <i class="ft-link mr-2"></i>
                                        <span class="d-none d-sm-block">Test Result Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#update" role="tab" id="update-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                        <i class="ft-link mr-2"></i>
                                        <span class="d-none d-sm-block">Updated by</span>
                                    </a>
                                </li>
                            </ul>
                               <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" id="certificate" role="tabpanel" aria-labelledby="certificate-tab">
                                     <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                <tr>
                                            <td><strong>Certificate No</strong></td>
                                            <td>{{$data->certificate_no}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Client</strong></td>
                                            <td>{{$data->client->contact_person_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Product</strong></td>
                                            <td>{{$data->product->make}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Reference</strong></td>
                                            <td>{{$data->reference}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Test Condition</strong></td>
                                            <td>{{$data->remark}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At</strong></td>
                                            <td>{{date('d-m-Y H:i A', strtotime($data->updated_at)) }}</td>
                                        </tr>
                                        </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="client" role="tabpanel" aria-labelledby="client-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                         <table class="table table-striped table-bordered">
                                            <?php
                                                $updated_data_from_db=$data->client_details ?? '[]';
                                                    $client_data = json_decode($updated_data_from_db, true);                                                
                                             ?>
                                          <tr>
                                              <td><strong>Client Name</strong></td>
                                              <td>{{$client_data['client_name'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Company Name</strong></td>
                                              <td>{{$client_data['company_name'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Client Email</strong></td>
                                              <td>{{$client_data['client_email'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Phone</strong></td>
                                              <td>{{$client_data['phone'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong> Client Address</strong></td>
                                              <td>{{$client_data['address'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Country</strong></td>
                                              <td>{{$client_data['country'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>State</strong></td>
                                              <td>{{$client_data['state'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>City</strong></td>
                                              <td>{{$client_data['city'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Pin Code</strong></td>
                                              <td>{{$client_data['pin_code'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>GSTIN</strong></td>
                                              <td>{{$client_data['GSTIN'] ?? '-'}}</td>
                                           </tr>
                                         </table>
                                    </div>
                                </div>                                    
                             </div>
                         </div>
                        <div class="tab-pane fade mt-2" id="product" role="tabpanel" aria-labelledby="product-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered"> 
                                            <?php
                                                $updated_data_from_db=$data->product_details ?? '[]';
                                                    $product_data = json_decode($updated_data_from_db, true);
                                            ?>
                                           <tr>
                                             <td><strong>Product Model No</strong></td>
                                             <td>{{$product_data['product_sr_no' ] ?? '-'}}</td>
                                           </tr>

                                            <tr>
                                              <td><strong>Product Name</strong></td>
                                              <td>{{$product_data['product_name'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Product Make/ Identification</strong></td>
                                              <td>{{$product_data['product_make'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Product Range</strong></td>
                                              <td>{{$product_data['product_range'] ?? '-'}}</td>
                                           </tr>
                                           <!-- <tr>
                                              <td><strong>Standard Equipment No</strong></td>
                                              <td>{{$product_data['standard_sr_no'] ?? '-'}}</td>
                                           </tr> -->
                                           <tr>
                                              <td><strong>Standard Equipment Description</strong></td>
                                              <td>{{$product_data['equipment_description'] ?? '-'}}</td>
                                           </tr>
                                           <!-- <tr>
                                              <td><strong>Valid Till</strong></td>
                                              <td>{{ !empty($product_data['valid_till']) ? date('d-m-Y', strtotime($product_data['valid_till'])) : '-'}}</td>
                                           </tr> -->
                                           <tr>
                                              <td><strong>Count</strong></td>
                                              <td>{{$product_data['count'] ?? '-'}}</td>
                                           </tr>
                                           <tr>
                                              <td><strong>Remarks</strong></td>
                                              <td>{{$product_data['remarks'] ?? '-'}}</td>
                                           </tr>
                                        </table>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                               <div class="tab-pane fade mt-2" id="results" role="tabpanel" aria-labelledby="results-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                <thead><tr>
                                                        <th>Sr No</th>
                                                        <th>Setting Reading</th>
                                                        <th>Instrument Reading</th>
                                                        <th>Error in Reading</th>
                                                    </tr></thead>
                                                    <tbody>
                                                    @foreach($test_results as $key=>$value)
                                                     <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$value['setting'] ?? ''}}</td>
                                                        <td>{{$value['instrument'] ?? ''}}</td>
                                                        <td>{{$value['error'] ?? ''}}</td>
                                                     </tr>
                                                     @endforeach
                                                     </tbody>
                                             </table>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="update" role="tabpanel" aria-labelledby="update-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead><tr>
                                                        <th>User Name</th>
                                                        <th>Nick Name</th>
                                                        <th>Updated On</th>
                                                    </tr></thead>
                                                <?php
                                                $updated_data_from_db=$data->updated_by ?? '[]';
                                                     $updated_data = json_decode($updated_data_from_db, true); 
                                                              
                                                    ?>
                                                    @foreach($updated_data as $key => $value)
                                                    <tr>
                                                        <td>{{$value['admin_name'] ?? ''}}</td>
                                                        <td>{{$value['nick_name']  ?? ''}}</td>
                                                        <td>{{!empty($value['updated_on']) ? date('d-m-Y h:i:s A', strtotime($value['updated_on'])) : ''}}</td>
                                                    </tr>
                                                    @endforeach                                  
                                                </table>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>

                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>