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
                                            <h4 class="card-title">Update Password</h4>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            	<div class="card-body">
                            		<form method="post" id="changePwdForm" action="resetPassword">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Old Password<span class="text-danger">*</span></label>
                                                <input class="form-control" type="password" name="old_password">
                                            </div>
                                            <div class="col-md-4">
                                                <label>New Password<span class="text-danger">*</span></label>
                                                <input class="form-control" type="password" name="new_password">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Confirm Password<span class="text-danger">*</span></label>
                                                <input class="form-control" type="password" name="confirm_password">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('changePwdForm','post')">Reset Password</button>
                                                    <!-- <button type="submit" class="btn btn-success btn-sm">Reset Password</button> -->
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
    </div>
</div>
@endsection