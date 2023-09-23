<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">	
                                    <h5 class="pt-2">Add Product</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="saveproductsData" method="post" action="saveproducts">
								<h4 class="form-section"><i class="ft-info"></i>Product Details</h4>
                    			@csrf
								<div class="row">
                        			<div class="col-sm-6">
                                        <label for="product_sr_no">Product Model No<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="product_sr_no" name="product_sr_no"><br/>
                        			</div>
									<div class="col-sm-6">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="name" name="name"><br/>
                        			</div>
								
                                    <div class="col-sm-6">
                                        <label for="range">Product Range<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="range" name="range"><br/>
                                    </div>
                        			<div class="col-sm-6">
                                        <label for="make">Make / Identification<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="make" name="make"><br/>
                        			</div>
                        			<div class="col-sm-6">
                                        <label for="count">Least Count<span class="text-danger"></span></label>
                        				<input class="form-control" type="text" id="count" name="count"><br/>
                        			</div>
                                    <div class="col-sm-6">
                                        <label for="remarks">Remark (will be printed on certificate)<span class="text-danger"></span></label>
                                        <textarea class="form-control"  id="remarks" name="remarks"></textarea><br/>
                                    </div>
                        		</div>
								<h4 class="form-section"><i class="ft-info"></i>Standard Equipment Details</h4>	
                        		

									<div class="row">
                        			<div class="col-sm-6">
                                        <label for="standard_sr_no">SR.NO</label>
                        				<input class="form-control required" type="text" id="standard_sr_no" name="standard_sr_no"><br/>
                        			</div>
									<div class="col-sm-6">
                                        <label for="description">Description<span class="text-danger">*</span></label>
                        				<textarea class="form-control required" type="text" id="description" name="description"></textarea><br/>
                        			</div>
								
                                    <div class="col-sm-6">
                                        <label for="certificate_no">CERTIFICATE NO<span class="text-danger"></span></label>
                                        <input class="form-control" type="text" id="certificate_no" name="certificate_no"><br/>
                                    </div>
									 <div class="col-sm-6">
                                        <label for="standard_make">Make / Identification<span class="text-danger"></span></label>
                                        <input class="form-control" type="text" id="standard_make" name="standard_make"><br/>
                                    </div>
									 <div class="col-sm-6">
                                        <label for="standard_range">Range<span class="text-danger"></span></label>
                                        <input class="form-control" type="text" id="standard_range" name="standard_range"><br/>
                                    </div>
                        			<div class="col-sm-6">
                                        <label for="valid_till">Valid Till<span class="text-danger"></span></label>
                        				<input class="form-control required" type="Date" id="valid_till" name="valid_till"><br/>
                        			</div>
                                    <div class="col-md-12 mb-5">
                                        <label for="valid_till">Certificate Description <span class="text-danger">*</span>(will be printed on certificate)</label>
                                         <textarea" class = "ckeditor" name="ckeditor" id="standard_details">
                                            <figure class="table"><table>
                                            <tbody>
                                            <tr>
                                              <td>Make</td>
                                              <td>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</td>
                                              <td>Asus</td>
                                            </tr>
                                            <tr>
                                              <td>Sr No</td>
                                              <td>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</td>
                                              <td>0255</td>
                                            </tr>
                                            <tr>
                                              <td>Certificate No</td>
                                              <td>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</td>
                                              <td>012554</td>
                                            </tr>
                                            <tr>
                                              <td>Valid Till</td>
                                              <td>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</td>
                                              <td>20/02/2023</td>
                                            </tr>
                                            </tbody>
                                            </table></figure>
                                         </textarea">
                                    </div>
                        		</div>

								
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitEditor('saveproductsData','post')">Submit</button>
											<a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1"> Cancel</a>
                        				</div>
                        			</div>
                        		</div>
                        	</form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    loadCKEditor('standard_details')
</script>
