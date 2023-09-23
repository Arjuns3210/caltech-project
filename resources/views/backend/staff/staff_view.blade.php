<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div>
                    <div class="card-content">
                    	<div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td><strong>Staff Name</strong></td>
                                            <td>{{$data->admin_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role</strong></td>
                                            <td>{{$data->role->role_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nick Name</strong></td>
                                            <td>{{$data->nick_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>{{$data->email}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <td><strong>Phone</strong></td>
                                            <td><span> {{ $data->country_code }} {{ $data->phone }}</span></td>

                                        </tr>
                                        <tr>
                                            <td><strong>Created On</strong></td>
                                            <td>{{date('d-m-Y H:i A', strtotime($data->updated_at)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>