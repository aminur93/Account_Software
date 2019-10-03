@extends('admin.layouts.master')

@section('page')
    Account
    @endsection

@push('css')
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
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Account</button>
                </div>
                <h4 class="panel-title">Account</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#Sl No</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Current balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Account modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Account</h5>
                </div>
                <form action="{{ route('account.store') }}" method="post" id="account">@csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_name" class="col-form-label">Account Name:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="account_name" class="form-control" id="account_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number" class="col-form-label">Account Number:</label>
                                    <input type="text" name="number" class="form-control" id="number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="balance" class="col-form-label">Opening Balance:</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" name="balance" class="form-control" id="balance" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bank_name" class="col-form-label">Bank Name:</label>
                                    <input type="text" name="bank_name" class="form-control" id="bank_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="col-form-label">Bank Phone:</label>
                                    <input type="number" name="phone" class="form-control" id="phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="col-form-label">Bank Address:</label>
                                    <input type="text" name="address" class="form-control" id="address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--edit Account modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="editModalLabel">Edit Account</h5>
                </div>
                <form action="{{ route('account.update') }}" method="post" id="account">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="account_id" id="account_id" value="">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_name" class="col-form-label">Account Name:</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="account_name" class="form-control" id="account_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number" class="col-form-label">Account Number:</label>
                                        <input type="text" name="number" class="form-control" id="number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="balance" class="col-form-label">Opening Balance:</label>
                                        <span class="text-danger">*</span>
                                        <input type="number" name="balance" class="form-control" id="balance" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_name" class="col-form-label">Bank Name:</label>
                                        <input type="text" name="bank_name" class="form-control" id="bank_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="col-form-label">Bank Phone:</label>
                                        <input type="number" name="phone" class="form-control" id="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="col-form-label">Bank Address:</label>
                                        <input type="text" name="address" class="form-control" id="address">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('js')
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
                    url: '{!!  route('account.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'account_name', name: 'account_name'},
                    {data: 'account_no', name: 'account_no'},
                    {data: 'current_balance', name: 'current_balance'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
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
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var account_name = button.data('account_name');
            var number = button.data('number');
            var balance = button.data('balance');
            var bank_name = button.data('bank_name');
            var phone = button.data('phone');
            var address = button.data('address');
            var account_id = button.data('account_id');
            var modal = $(this);

            modal.find('.modal-body #account_name').val(account_name);
            modal.find('.modal-body #number').val(number);
            modal.find('.modal-body #balance').val(balance);
            modal.find('.modal-body #bank_name').val(bank_name);
            modal.find('.modal-body #phone').val(phone);
            modal.find('.modal-body #address').val(address);
            modal.find('.modal-body #account_id').val(account_id);
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#account').validate({

                rules: {
                    account_name: {
                        required: true
                    },
                    balance: {
                        required: true,
                        number:true
                    }
                },
            });
        });
    </script>

    <script>
        $(document).on('click','.deleteRecord', function(e){
            var id = $(this).attr('rel');
            var deleteFunction = $(this).attr('rel1');
            swal({
                    title: "Are You Sure?",
                    text: "You will not be able to recover this record again",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete It"

                },
                function(){
                    window.location.href="/account/"+deleteFunction+"/"+id;
                });
        });

    </script>
@endpush
