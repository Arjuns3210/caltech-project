@extends('backend.layouts.app')
@section('content')
<div class="wrapper">
    <div class="main-panel">
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section id="minimal-statistics">
                    <div class="row">
                        <div class="col-12">
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $total_staff }}</h3>
                                                <span>Total Staff</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $total_products }}</h3>
                                                <span>Total Products</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-product-hunt success font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $total_clients }}</h3>
                                                <span>Total clients</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-users success font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $total_certificate }}</h3>
                                                <span>Total certificate</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-certificate success font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{$updated_product}}</h3>
                                                <span>Products updated today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-pencil-square-o success font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{$todays_certificates}}</h3>
                                                <span>Certificate created Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa  fa-calendar warning font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{$todayExpiring_certificates}}</h3>
                                                <span>Certificate expiring today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-clock-o warning font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 danger">{{$expired_certificate}}</h3>
                                                <span>Total certificate Expired</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-calendar-times-o danger font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         
 
                    </div>
                  
                </section>
                <div class="row">
                    <!-- Line Chart starts -->
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Certificate Added in last 12 Months</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="line-chart2" class="d-flex justify-content-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <!-- Line Chart ends -->
                </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    lineChartCertificate();
});
</script>
@endsection
<!-- #f43736
#414091 -->