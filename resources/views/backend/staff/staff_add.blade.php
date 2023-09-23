<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Staff User</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="saveStaffData" method="post" action="saveStaff">
								<h4 class="form-section"><i class="ft-info"></i> Details</h4>
                    			@csrf
                        		<div class="row">
                        			<div class="col-sm-6">
                                        <label for="role_id">Role<span class="text-danger">*</span></label>
                        				<select class="select2 required" id="role_id" name="role_id" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($data['role'] as $roles)
                                                <option value="{{$roles->id}}">{{$roles->role_name}}</option>
                                            @endforeach
                                        </select><br/>
									</div>
									<div class="col-sm-6">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="name" name="name"><br/>
                        			</div>

								</div><br/>
								<div class="row">
									<div class="col-sm-6">
                                        <label for="nick_name">Nick Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="nick_name" name="nick_name"><br/>
                        			</div>
	                                <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="phone">Phone<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12 company_number_section">
                                                <input class="form-control required" type="text" id="phone" name="phone"><br/>
                                            </div>
                                        </div><br>
                                        <input class="form-control" type="text" id="country_code" hidden name="country_code">
                                    </div>
                        			<div class="col-sm-6">
                                        <label for="email">Email ID<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="email" id="email" name="email"><br/>
                        			</div>
								
                        			<div class="col-sm-6">
                                        <label for="password">Password<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="password" id="password" name="password"><br/>
                        			</div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveStaffData','post')">Submit</button>
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
    $('.select2').select2();
    $(function () {
            var code = "+91";
            $('#phone').val(code);
            $('#phone').intlTelInput({
                initialCountry: "auto",
                separateDialCode: true
            });
            $('#phone').on('blur', function () {
                var code = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
                var phoneNumber = $('#phone').val();
                document.getElementById("country_code").value = "+"+code;

                console.log(document.getElementById("country_code").value = "+"+code)
            });
        });
</script>