<style>
    .table_row{
        font-size:15px;
    }
</style>
<?php
    $product_data_db=$data->product_details ?? '[]';
    $product_data = json_decode($product_data_db, true);
?>
<table class="table">
    <tr class="table_row">
        <td width="25%"></td>
        <td width="45%"style="text-align:center; font-size:15px;"></td>
        <td width="30%"style="text-align:right; font-size:15px;"><b>{{$data->certificate_no}}</b></td>
    </tr>
    <tr class="table_row">
        <td width="25%"></td>
        <td width="45%"style="text-align:center;"><b>CALIBRATION CERTIFICATE OF</b><div style="color:#230677; text-transform: uppercase;"><b>{{$product_data['product_name'] ?? ''}}</b></div></td>
        <td width="30%"style="text-align:right; font-size:15px;"></td>
    </tr>
    <br>
    <tr class="table_row">
        <td width="33.5%" style="border-left-color: rgb(17, 5, 5); border-top-color:black; text-align:center; "><b>Date of Calibration</b></td>
        <td width="33.5%" style="border-left-color: black;border-top-color: black;border-right-color: black;text-align:center;"><b>Next Calibration</b></td>
        <td width="33.5%" style="border-right-color: rgb(17, 5, 5);border-top-color: black; text-align:center;"><b>Date of Issue</b></td>
    </tr>
    <tr class="table_row">
        <td width="33.5%" style="border-left-color: rgb(17, 5, 5); border-top-color:black; text-align:center;">{{  date('d-m-Y', strtotime($data->calibration_date))}}</td>
        <td width="33.5%" style="border-left-color: black;border-top-color: black;border-right-color: black;text-align:center;">{{ date('d-m-Y', strtotime($data->next_calibration_date))}}</td>
        <td width="33.5%" style="border-right-color: rgb(17, 5, 5);border-top-color: black; text-align:center;">{{(!empty($data->creation_date)) ? date('d-m-Y', strtotime($data->creation_date)) : ''}}</td>
    </tr>
    <tr>
        <td width="100.5%" style="text-align:center; border-top-color: rgb(17, 5, 5);"></td>
    </tr>
    <tr>
        <td width="45%" ><b>Tested For</b></td>
        <?php
            $client_data_db=$data->client_details ?? '[]';
            $client_data = json_decode($client_data_db, true);
        ?>
        <td width="5%">:</td>
        <td width="45%">{{$client_data['company_name'] ?? ''}}<br>{{$client_data['address'] ?? ''}}</td>
    </tr>
    <tr class="table_row">
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td width="45%"><b>Reference</b></td>
        <td width="5%">:</td>
        <td width="45%">{{$data->reference}} &nbsp;Dated : {{(!empty($data->creation_date)) ? date('d-m-Y', strtotime($data->creation_date)) : ''}}</td>
    </tr>
    <tr class="table_row">
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td width="45%"><b>Description of item</b></td>
        <td width="5%">:</td>
        <td width="45%">{{$product_data['product_name'] ?? ''}}</td>
    </tr>
    <tr>
        <td width="45%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Range</td>
        <td width="5%">:</td>
        <td width="45%">{{$product_data['product_range'] ?? ''}}</td>
    </tr>
     
    @if(!empty($product_data['count']))
        <tr>
            <td width="45%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Least Count</td>
            <td width="5%">:</td>
            <td width="45%">{{$product_data['count']}}</td>
        </tr>
    @endif
    <tr>
        <td width="45%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Make / Identification</td>
        <td width="5%">:</td>
        <td width="45%">{{$product_data['product_make'] ?? ''}}</td>
    </tr>
    <tr>
        <td width="45%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Model No</td>
        <td width="5%">:</td>
        <td width="45%">{{$product_data['product_sr_no'] ?? ''}}</td>
    </tr>
    <tr class="table_row">
        <td></td>
        <td></td>
    </tr>
    @if(!empty($data->remark)) 
        <tr>
            <td width="45%"><b>Test Condition</b></td>
            <td width="5%">:</td>
            <td width="45%">{{$data->remark}}</td>
        </tr>
    @endif
    <tr class="table_row">
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td width="45%"><b>Standard Equipment</b></td>
        <td width="5%">:</td>
        <td width="45%">{{$product_data['equipment_description'] ?? ''}}</td>
    </tr>
     <tr>
        <td width="71.1%" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
        echo $data->product_ckeditor;
    ?></td>
    </tr>

    <br>
    @if(!empty($test_results)) 
        <tr class="table_row">
            <td width="33.5%"></td>
            <td width="33.5%" style="text-align:center; font-size:15px;"><b>TEST RESULTS</b></td>
            <td width="33.5%"></td>
        </tr>
        <br>
       <tr class="table_row">
            <td width="25%" style="border-left-color: rgb(17, 5, 5); border-top-color:black; text-align:center;border-bottom-color:rgb(17, 5, 5);">Test<br><b>Reading No</b></td>
            <td width="25%" style="border-left-color: black;border-top-color: black;border-right-color: black;text-align:center; border-bottom-color:rgb(17, 5, 5);">Setting<br><b>Reading V</b></td>
            <td width="25%" style="border-right-color: rgb(17, 5, 5);border-top-color: black; text-align:center;border-bottom-color:rgb(17, 5, 5);">Reading On<br><b>Instrument V</b></td>
            <td width="25%" style="border-right-color: rgb(17, 5, 5);border-top-color: black; text-align:center;border-bottom-color:rgb(17, 5, 5);">Error<br><b>in reading Volts</b></td>
        </tr>
        @foreach($test_results as $key => $test_result)
            <tr class="table_row">
                <td width="25%" style="border-left-color: rgb(17, 5, 5); border-top-color:black; text-align:center; border-bottom-color:black;">{{ $key + 1}}</td>
                <td width="25%" style="border-left-color: black;border-top-color: black;border-right-color: black;text-align:center; border-bottom-color:black;">{{ $test_result->setting }}</td>
                <td width="25%" style="border-right-color: rgb(17, 5, 5);border-top-color: black; text-align:center;border-bottom-color:black;">{{ $test_result->instrument }}</td>
                <td width="25%" style="border-right-color: rgb(17, 5, 5);border-top-color: black; text-align:center;border-bottom-color:black;">{{ $test_result->error }}</td>
            </tr>
        @endforeach
        <br>
        <tr>
            <td width="100%">Remarks : {{$product_data['remarks'] ?? ''}}</td>
        </tr>        
        @endif
    <table>
        <tr class="table_row">
            <td width="25%"></td>
            <td width="25%"></td>
            <td width="25%"></td>
            <td width="25%" style="text-align:center;"><img src="{{$no_image}}" alt="" width="150" height="120"></td>
        </tr>
    </table>
</table>
