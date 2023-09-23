<?php use Carbon\Carbon; ?>
<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Certificate: {{$data->certificate_no}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body" >
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#details" role="tab" id="details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="details" aria-selected="true">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">Details</span> -->
                                        <span class="">Certificate Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#features" role="tab" id="features-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="features" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Test Result</span>
                                    </a>
                                </li>
                            </ul>
                            <form id="editCertificateData" method="post" action="saveCertificate?id={{$data->id}}">
                                <!-- <h4 class="form-section"><i class="ft-info"></i>Details</h4> -->
                    			@csrf
                                <div class="tab-content">
                                    <div class="tab-pane fade mt-2 show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                        <div class="row">
                                            <div class="col-sm-12" >
                                                <label>Certificate No:</label><br>
                                                <h4>{{$data->certificate_no}}</h4>
                                            </div>
                                            <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix()) }}"/>
                                            <br><br>
                                            <div class="col-sm-6" >
                                            <div id="client_select" >
                                                <label for="client_id">Client<span class="text-danger">*</span></label>
                                                <select class="select2 required" id="client_id" name="client_id" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach ($data->clients as $client)
                                                    <option value="{{$client->id}}" {{ ($data->client_id == $client->id) ? 'selected' : '' }}>{{$client->contact_person_name}}</option>
                                                    @endforeach
                                                </select>
                                                <br/>
                                            </div>
                                                <span id="client_details"></span><br>
                                            </div>
                                            <br><br>
                                            <div class="col-sm-6" >
                                                <div id="product_select">
                                                <label for="product_id">Product<span class="text-danger">*</span></label>
                                                <select class="select2 required" id="product_id" name="product_id" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach ($data->products as $product)
                                                    <option value="{{$product->id}}" {{ ($data->product_id == $product->id) ? 'selected' : '' }}>{{$product->product_sr_no}}({{$product->name}})</option>
                                                    @endforeach
                                                </select>
                                                <br/>
                                                </div>
                                                <span id="product_details"></span><br>
                                              </div>
                                              <br><br>
                                              <div class="col-sm-6">
                                                <label for="calibration_date">Date of Calibration<span class="text-danger">*</span></label>
                                                <input class="form-control required" type="date" id="calibration_date" name="calibration_date"  value="{{$data->calibration_date}}"><br/>
                                            </div>                                          
                                            <div class="col-sm-6">
                                                <label for="next_calibration_date">Next Calibration Date<span class="text-danger">*</span></label>
                                                <input class="form-control required" type="date" id="next_calibration_date" name="next_calibration_date" value="{{Carbon::
                                                parse($data->calibration_date)->addDays(364)->toDateString()
                                                }}" readonly>
                                            </div><br><br>
                                            <div class="col-sm-6">
                                                <label for="reference">Reference<span class="text-danger">*</span></label>
                                                <input class="form-control required" type="text" id="reference" name="reference" value="{{$data->reference}}"><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="remark">Test Condition (will be printed on certificate)</label>
                                                <textarea class="form-control" id="remark" name="remark">{{$data->remark}}</textarea><br/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="features" role="tabpanel" aria-labelledby="features-tab">
                                        <table id="main">
                                            <thead>
                                                <th>#</th>
                                                <th>Setting Reading</th>
                                                <th>Instrument Reading</th>
                                                <th>Error in Reading</th>
                                                <th><button type="button" class="btn btn-success btn-sm" id="addRow"><i class="fa fa-plus"></i></button></th>
                                            </thead>
                                            <tbody id="resRow">
                                                @foreach ($data->test_results as $key => $test_result)
                                                <tr id="batchTblTr{{ $key + 1 }}">
                                                    <td style="text-align: center;">
                                                        {{ $key + 1 }}
                                                    </td >  
                                                    <td style="padding-right:10px;">
                                                        <input type="number" id="setting{{ $key + 1 }}" class="form-control" name="setting[]" step="0.2" value="{{ $test_result->setting }}" onchange="calculate({{$key + 1}});">
                                                    </td>
                                                    <td style="padding-right:10px;">
                                                        <input type="number" id="instrument{{ $key + 1 }}" class="form-control" name="instrument[]" step="0.2" value="{{ $test_result->instrument }}" onchange="calculate({{$key + 1}});">
                                                    </td>
                                                    <td style="padding-right:10px;">
                                                        <input type="number" id="error{{ $key + 1 }}" class="form-control" name="error[]" value="{{ $test_result->error }}" placeholder="0" readonly>
                                                    </td>
                                                    <td style="padding-right:10px;">
                                                        <button type="button" class="btn btn-danger btn-sm" id="removeReading{{ $key + 1 }}" onclick="remove_batch_tbl_row({{ $key + 1 }})"><i class="fa fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('editCertificateData','post')">Update</button>
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

<script type="text/javascript">
    $('.select2').select2();

    function calculate(position) {
        var num1 = parseFloat(document.getElementById("setting"+position).value);
        var num2 = parseFloat(document.getElementById("instrument"+position).value);
        var error = parseFloat(num1) - parseFloat(num2);

        $("#error"+position).val(error.toFixed(2));
    }

    $('#calibration_date').change(function () {
        var date = $(this).val();
        var new_date = new Date(date);

        new_date.setDate(new_date.getDate() + 364);

        $('#next_calibration_date').val(formatDate(new_date));
    });

    $(document).on('click', '#addRow', function() {
        var trlen = $('#main tbody tr').length;

        if(trlen == 0) {
            var i = trlen + 1;
        } else {
            var i = parseInt($('#main tbody tr:last-child').attr('id').substr(10))+1;
        }
        $('#main').append('<tr id="batchTblTr'+i+'">'+
            '<td style="text-align: center;">'+i+'</td>'+
            '<td style="padding-right:10px;"><input type="number" id="setting'+i+'" class="form-control"  name="setting[]" value="0" onchange="calculate('+i+');"></td>'+
            '<td style="padding-right:10px;"><input type="number" id="instrument'+i+'" class="form-control" name="instrument[]" value="0" onchange="calculate('+i+');"></td>' +
            '<td style="padding-right:10px;"><input type="number" id="error'+i+'" class="form-control" name="error[]" placeholder="0" readonly></td>' +
            '<td style="padding-right:10px;"><button type="button" class="btn btn-danger btn-sm" id="removeReading'+i+'" onclick="remove_batch_tbl_row('+i+')"><i class="fa fa-minus"></i></button></td>'+
            '</tr>'
        );
    });

    function remove_batch_tbl_row(i) {
        $('#batchTblTr'+i).remove();
    }

    $(document).ready(function(){
        var id = $('#product_id').val();
        var url = $('#application_url').val();
        $('#product_details').empty();

        $.ajax({
            url: url + "/product/" + id,
            dataType: "json",

            success: function (data) {
                var insert_html = '';

                if (data && Object.keys(data).length != 0) {
                    var name = data['name'];
                    var range =data['range'];
                    var make = data['make'];
                    var product_sr_no = data['product_sr_no'];
                    var standard_sr_no = data['standard_sr_no'];
                    var description = data['description'];
                    let valid_till = data['valid_till'];
                    var certificate_no =(data['certificate_no'] != null ? data['certificate_no'] : '');
                    var standard_make = (data['standard_make'] != null ? data['standard_make'] : '');
                    var standard_range =(data['standard_range'] != null ? data['standard_range'] : '');
                    var count = (data['count'] != null ? data['count'] : '');
                    var remarks = data['remarks'];

                    insert_html += '<label>Product Model No</label>:<span style=""> '+product_sr_no+'</span><br>';
                    insert_html += '<label>Product Name</label>:<span style="">'+name+'</span><br>';
                    insert_html += '<label>Make / Identification</label>:<span style="">'+make+'</span><br>';
                    insert_html += '<label>Range</label>:<span style="">'+range+'</span><br>';
                    if(count!=''){
                    insert_html += '<label>Count</label>:<span style="">'+count+'</span><br>';
                    }
                    insert_html += '<label>Standard Eqiupment No</label>:<span style="">'+standard_sr_no+'</span><br>';
                    insert_html += '<label>Description</label>:<span style="">'+description+'</span><br>';
                    if(certificate_no!=''){
                    insert_html += '<label>Certificate No</label>:<span style="">'+certificate_no+'</span><br>';
                    }
                    if(standard_make!=''){
                    insert_html += '<label>Standard Make</label>:<span style="">'+standard_make+'</span><br>';
                    }
                    if(standard_range!=''){
                    insert_html += '<label>Standard Range</label>:<span style="">'+standard_range+'</span><br>';
                    }
                    insert_html += '<label>Valid Till</label>:<span style="">'+valid_till+'</span><br>';
                    insert_html += '<label>Remark</label>:<span style="">'+remarks+'</span><br>';
                }
                $('#product_details').html(insert_html);
            }
        });
        var id = $('#client_id').val();
        var url = $('#application_url').val();
         $('#client_details').empty();
         $.ajax({
            url: url + "/client/" + id,
            dataType: "json",

            success: function (data) {
                var insert_html = '';

                if (data && Object.keys(data).length != 0) {
                    var company_name = data['company_name'];
                    var contact_person_name = data['contact_person_name'];
                    var email = data['email'];
                    var company_number = data['company_number'];
                     var city = data['city'];
                    var address = data['address'];
                    var pin_code = data['pin_code'];
                    var state = data['state'];
                    var country = data['country'];
                    var GSTIN = data['GSTIN'];

                    insert_html += '<label>Company Name</label>:<span style="">'+company_name+'</span><br>';
                    insert_html += '<label>Name</label>:<span style="">'+contact_person_name+'</span><br>';
                    insert_html += '<label>Email</label>:<span style="">'+email+'</span><br>';
                    insert_html += '<label>Mobile Number</label>:<span style="">'+company_number+'</span><br>';
                    insert_html += '<label>Address</label>:<span style="">'+address+'</span><br>';
                    insert_html += '<label>Pin code</label>:<span style="">'+pin_code+'</span><br>';
                    insert_html += '<label>City</label>:<span style="">'+city+'</span><br>';
                    insert_html += '<label>State</label>:<span style="">'+state+'</span><br>';
                    insert_html += '<label>Country</label>:<span style="">'+country+'</span><br>';
                    insert_html += '<label>GSTIN</label>:<span style="">'+GSTIN+'</span><br>';
                }
                $('#client_details').html(insert_html);
            }
        });
    });

    $('#client_id').change(async function () {
        var id = $(this).val();
        var url = $('#application_url').val();
        $('#client_details').empty();

        if (id == '') {
            changeClientViewEmpty();
            return false;
        }
        $.ajax({
            url: url + "/client/" + id,
            dataType: "json",

            success: function (data) {
                console.log('Data => ', data);
                var insert_html = '';

                if (data && Object.keys(data).length != 0) {
                    var company_name = data['company_name'];
                    var contact_person_name =  data['contact_person_name'];
                    var email = data['email'];
                    var company_number = data['company_number'];
                    var address = data['address'];
                    var city = data['city'];
                    var pin_code = data['pin_code'];
                    var state = data['state'];
                    var country = data['country'];
                    var GSTIN = data['GSTIN'];

                    insert_html += '<label>Company Name</label>:<span style="">'+company_name+'</span><br>';
                    insert_html += '<label>Name</label>:<span style="">'+contact_person_name+'</span><br>';
                    insert_html += '<label>Email</label>:<span style="">'+email+'</span><br>';
                    insert_html += '<label>Mobile Number</label>:<span style="">'+company_number+'</span><br>';
                    insert_html += '<label>Address</label>:<span style="">'+address+'</span><br>';
                    insert_html += '<label>City</label>:<span style="">'+city+'</span><br>';
                    insert_html += '<label>Pin code</label>:<span style="">'+pin_code+'</span><br>';
                    insert_html += '<label>State</label>:<span style="">'+state+'</span><br>';
                    insert_html += '<label>Country</label>:<span style="">'+country+'</span><br>';
                    insert_html += '<label>GSTIN</label>:<span style="">'+GSTIN+'</span><br>';
                }
                $('#client_details').html(insert_html);
            }
        });
    });

    $('#product_id').change(async function () {
        var id = $(this).val();
        var url = $('#application_url').val();
        $('#product_details').empty();

        if (id == '') {
            changeProductViewEmpty();
            return false;
        }
        $.ajax({
            url: url + "/product/" + id,
            dataType: "json",

            success: function (data) {
                var insert_html = '';

                if (data && Object.keys(data).length != 0) {
                    var name =  data['name'];
                    var range = data['range'];
                    var make =  data['make'];
                    var sr_no = data['sr_no'];
                    var standard_sr_no = data['standard_sr_no'];
                    var description = data['description'];
                    var valid_till = data['valid_till'];
                    var certificate_no =(data['certificate_no'] != null ? data['certificate_no'] : '');
                    var standard_make = (data['standard_make'] != null ? data['standard_make'] : '');
                    var standard_range =(data['standard_range'] != null ? data['standard_range'] : '');
                    var count = (data['count'] != null ? data['count'] : '');
                    var remarks = data['remarks'];

                    insert_html += '<label>Product Model No</label>:<span style=""> '+sr_no+'</span><br>';
                    insert_html += '<label>Product Name</label>:<span style="">'+name+'</span><br>';
                    insert_html += '<label>Make / Identification</label>:<span style="">'+make+'</span><br>';
                    insert_html += '<label>Range</label>:<span style="">'+range+'</span><br>';
                    if(count!=''){
                    insert_html += '<label>Count</label>:<span style="">'+count+'</span><br>';
                    }
                    insert_html += '<label>Remark</label>:<span style="">'+remarks+'</span><br>';
                    insert_html += '<label>Standard Eqiupment No</label>:<span style="">'+standard_sr_no+'</span><br>';
                    insert_html += '<label>Description</label>:<span style="">'+description+'</span><br>';
                    if(certificate_no!=''){
                    insert_html += '<label>certificate_no</label>:<span style="">'+certificate_no+'</span><br>';
                    }
                    if(standard_make!=''){
                    insert_html += '<label>Standard_make</label>:<span style="">'+standard_make+'</span><br>';
                    }
                    if(standard_range!=''){
                    insert_html += '<label>Standard_range</label>:<span style="">'+standard_range+'</span><br>';
                    }
                    insert_html += '<label>Valid Till</label>:<span style="">'+valid_till+'</span><br>';
                }
                $('#product_details').html(insert_html);
            }
        });
    });

    function changeProductView(){
        $('#display_product_icon').hide();
        $('#product_select').show();
        $('#product_id').select2('open');
    }

    function changeProductViewEmpty(){
        $('#display_product_icon').show();
        $('#product_select').show();
    }

    function changeClientView(){
        $('#display_client_icon').hide();
        $('#client_select').show();
        $('#client_id').select2('open');
    }

    function changeClientViewEmpty(){
        $('#display_client_icon').show();
        $('#client_select').show();
    }
</script>
