<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Client</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                         </div>
                         <!-- <hr class="mb-0"> -->
                         <div class="card-body">
                            <form id="saveClientData" method="post" action="saveClient">
                                <h4 class="form-section"><i class="ft-info"></i> Details</h4>
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="company_name">Company Name<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="company_name" name="company_name"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="contact_person_name">Contact Person Name<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="contact_person_name" name="contact_person_name"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="company_number">Company Number<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12 company_number_section">
                                                <input class="form-control required" type="text" id="company_number" name="company_number"><br/>
                                            </div>
                                        </div><br>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email">Email ID<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="email" id="email" name="email"><br/>
                        			</div>
                                    <div class="col-sm-6">
                                        <label for="address">Address (will be printed on certificate)<span class="text-danger">*</span></label>
                                        <textarea class="form-control required" id="address" name="address"></textarea><br/>
                                    </div>
                                    </div>
                                    <h4 class="form-section"><i class="ft-info"></i>Billing Details</h4> 
                                <div class="row">

                                    <div class="col-sm-6">
                                        <label for="country">Country<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="country" name="country"><br/>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="state">State<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="state" name="state">
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="city">City<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="city" name="city"><br/>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="pin_code">Pin Code<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="pin_code" name="pin_code"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="GSTIN">GSTIN<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="GSTIN" maxlength="15" name="GSTIN"><br/>
                                    </div>
                                        <div class="col-sm-6">
                                        <input class="form-control" type="text" id="country_code" hidden name="country_code">
                                    </div>
                        		</div>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveClientData','post')">Submit</button>
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
<script >
    $(function () {
            var code = "+91";
            $('#company_number').val(code);
            $('#company_number').intlTelInput({
                initialCountry: "auto",
                separateDialCode: true
            });
            $('#company_number').on('blur', function () {
                var code = $("#company_number").intlTelInput("getSelectedCountryData").dialCode;
                var phoneNumber = $('#company_number').val();
                document.getElementById("country_code").value = "+"+code;

                console.log(document.getElementById("country_code").value = "+"+code)
            });
        });
</script>