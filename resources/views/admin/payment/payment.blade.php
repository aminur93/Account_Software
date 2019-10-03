@extends('admin.layouts.master')

@section('page')
    Payment
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
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Payment Type</button>
                </div>
                <h4 class="panel-title">Payment Type</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#Sl No</th>
                        <th>Payment Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Payment modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Payment type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payment.store') }}" method="post" id="payment">@csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="payment_name" class="col-form-label">Payment Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="payment_name" class="form-control" id="payment_name" required>
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

    <!--edit payment modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Payment Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payment.update') }}" method="post" id="payment">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="payment_id" id="payment_id" value="">
                        <div class="form-group">
                            <label for="payment_name" class="col-form-label">Payment Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="payment_name" class="form-control" id="payment_name" required>
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
                    url: '{!!  route('payment.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'payment_name', name: 'payment_name'},
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
            var payment_name = button.data('payment_name');
            var payment_id = button.data('payment_id');
            var modal = $(this);
            modal.find('.modal-body #payment_name').val(payment_name);
            modal.find('.modal-body #payment_id').val(payment_id);
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#payment').validate({

                rules: {
                    payment_name: {
                        required: true
                    }
                },

                messages: {
                    payment_name: {
                        required: "<span class='text-danger'>This Payment Name field is Required</span>"
                    }
                }

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
                    window.location.href="/payment/"+deleteFunction+"/"+id;
                });
        });

    </script>
@endpush
