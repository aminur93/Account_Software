@extends('admin.layouts.master')

@section('page')
    Transfer
    @endsection

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @endpush

@section('content')

    <div class="col-md-12">

        @if (Session::has('flash_message_error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{!! session('flash_message_error') !!}</strong>
            </div>
        @endif

        @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Transfer Amount</button>
                </div>
                <h4 class="panel-title">Transfer</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#Sl No</th>
                            <th>Date</th>
                            <th>From Account</th>
                            <th>To Account</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Transfer modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Transfer Amount</h5>
                </div>
                <form action="{{ route('transfer.store') }}" method="POST" id="transfer">@csrf
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from" class="col-form-label">From Account:</label>
                                        <span class="text-danger">*</span>
                                        <select name="from" id="from" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="to" class="col-form-label">To Account:</label>
                                        <span class="text-danger">*</span>
                                        <select name="to" id="to" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment" class="col-form-label">Payment Method:</label>
                                        <span class="text-danger">*</span>
                                        <select name="payment" id="payment" class="form-control">
                                            <option value="">Select Account</option>
                                            @foreach ($payments as $payment)
                                                <option value="{{ $payment->id }}">{{ $payment->payment_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount" class="col-form-label">Amount:</label>
                                        <span class="text-danger">*</span>
                                        <input type="number" name="amount" class="form-control" id="amount"  required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="date" class="col-form-label">Date:</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="date" class="form-control" id="datepicker"  required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="col-form-label">Description:</label>
                                        <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <b><span class="alert alert-denger" id="msg"></span></b>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );
    </script>

{{-- Get data for datatables --}}
<script>
    $(document).ready(function(){

        $('#data-table').DataTable({
            //reset auto order
            processing: true,
            responsive: true,
            serverSide: true,
            pagingType: "full_numbers",
            dom: "<'row'<'col-sm-2'l><'col-sm-4'i><'col-sm-3 text-center'B><'col-sm-3'f>>tp",
            ajax: {
                url: '{!!  route('transfer.getdata') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tDate', name: 'tDate'},
                {data: 'from', name: 'from'},
                {data: 'to', name: 'to'},
                {data: 'tAmount', name: 'tAmount'}
            ],
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'print',
                    autoPrint: true,
                    className: 'btn-sm btn-default',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                }
            ]
        });

    });
</script>
<script>
    $(document).ready(function () {
        $('#transfer').validate({

            rules: {
                from: {
                    required: true
                },
                to: {
                    required: true
                },
                amount: {
                    required: true,
                    number:true
                },
                date: {
                    required: true
                },
                description: {
                    required: true
                },
                payment_name: {
                    required: true
                },
            },

        });
    });
</script>

<script>
    $('#amount').keyup(function(){
      var from = $('#from').val();
      var amount = $('#amount').val();
        $.ajax({
           method: 'POST',
           url: '/transfer/checkBalance',
           data: {'from':from, 'amount':amount, '_token': '<?php echo csrf_token() ?>'},
           success:function(data) {
            var html ='';
            var returnedData = JSON.parse(data);
            $('#msg').html(returnedData);

            if(returnedData != ''){
                $('#submit').attr("disabled", true);
            }else{
                $('#submit').attr("disabled", false);
            }
            
            console.log(returnedData);

        }
      });
    });

  </script>
@endpush
