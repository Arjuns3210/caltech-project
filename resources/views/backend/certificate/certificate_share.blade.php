<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Share Certificate: {{ $data['certificate_no'] }}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="shareCertificate" action="certificate/sendEmail" method="POST">
                                @csrf
                                <input type="hidden" name="certificate_id" value="{{ $data['id'] }}">
                                <table id="main" class="table table-borderless">
                                    <thead>
                                        <th style="padding-right: 14px;">#</th>
                                        <th>Send Email To</th>
                                        <th><button type="button" class="btn btn-success btn-sm" id="addRow"><i class="fa fa-plus"></i></button></th>
                                    </thead>
                                    <tbody id="resRow">
                                        <tr id="batchTblTr1">
                                            <td style="padding-right: 14px;">1</td>
                                            <td>
                                                <input type="email" id="email1" class="form-control" name="email[]" value="{{ $data['client_email'] }}">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-left">
                                            @if ($message = Session::get('success'))
                                                <div class="successAlert alert text-success">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('shareCertificate','post')">Send Email</button>
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
    $(document).on('click', '#addRow', function() {
        var trlen = $('#main tbody tr').length;

        if(trlen == 0) {
            var i = trlen + 1;
        } else {
            var i = parseInt($('#main tbody tr:last-child').attr('id').substr(10))+1;
        }
        $('#main').append('<tr id="batchTblTr'+i+'">'+
            '<td style="padding-right: 14px;">'+i+'</td>'+
            '<td><input type="email" id="email'+i+'" class="form-control" name="email[]"></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm" id="removeReading'+i+'" onclick="remove_batch_tbl_row('+i+')"><i class="fa fa-minus"></i></button></td>'+
            '</tr>'
        );
    });

    function remove_batch_tbl_row(i) {
        $('#batchTblTr'+i).remove();
    }
</script>