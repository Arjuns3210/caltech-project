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
                                            <h5 class="pt-2">Certificate Data Report</h5>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="DataReportForm" method="post" action="DataReport">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Calibration Date Range<span class="text-danger">*</span></label>
                                                    <input class="form-control required" type="text" id="daterange" name="daterange" readonly><br/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Client</label>
                                                    <select class="js-example-placeholder-single js-states form-control" id="search_client_id" name="search_client_id[]" style="width: 100% !important;" multiple>>
                                                        <option value="" disabled>Select</option>
                                                        @foreach($data['clients'] as $client)
                                                        <option value="{{$client->id}}">{{$client->contact_person_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success export">Export</button>
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
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(function() {
        $('#daterange').daterangepicker({
            startDate: moment(),
            endDate: 	moment(),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    });
</script>
@endsection
