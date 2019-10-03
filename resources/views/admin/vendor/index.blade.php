@extends('admin.layouts.master')

@section('page')
    Vendor List
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
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Vendor</button>
                </div>
                <h4 class="panel-title">Vendor</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#Sl No</th>
                        <th>Vendor Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Category modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Vendor</h5>
                </div>
                <form action="{{ route('vendor.store') }}" method="post" id="vendor">@csrf
                    <div class="col-md-6">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="vendor_name" class="col-form-label">Vendor Name:</label>
                              <span class="text-danger">*</span>
                              <input type="text" name="vendor_name" class="form-control" id="vendor_name" placeholder="Vendor Name">
                          </div>
                          <div class="form-group">
                              <label for="vendor_phone" class="col-form-label">Phone:</label>
                              <span class="text-danger">*</span>
                              <input type="number" name="vendor_phone" class="form-control" id="vendor_phone" placeholder="Phone">
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="vendor_address" class="col-form-label">Address:</label>
                              <span class="text-danger">*</span>
                              <input type="text" name="vendor_address" class="form-control" id="vendor_address" placeholder="Address">
                          </div>
                          <div class="form-group">
                              <label for="ammount" class="col-form-label">Email:</label>
                              <span class="text-danger">*</span>
                              <input type="email" name="email" class="form-control" id="email" placeholder="email">
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

    <!--edit Category modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="editModalLabel">Edit Vendor</h5>
                </div>
                <form action="{{ route('vendor.update') }}" method="post" id="vendor">@csrf
                    <div class="col-md-6">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="vendor_name" class="col-form-label">Vendor Name:</label>
                              <span class="text-danger">*</span>
                              <input type="hidden" name="id" id='vendorid' value="">
                              <input type="text" name="vendor_name" class="form-control" id="vendor_name" placeholder="Vendor Name" required>
                          </div>
                          <div class="form-group">
                              <label for="vendor_phone" class="col-form-label">Phone:</label>
                              <span class="text-danger">*</span>
                              <input type="number" name="vendor_phone" class="form-control" id="vendor_phone" placeholder="Phone" required>
                          </div>

                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="vendor_address" class="col-form-label">Address:</label>
                              <span class="text-danger">*</span>
                              <input type="text" name="vendor_address" class="form-control" id="vendor_address" placeholder="Address" required>
                          </div>
                          <div class="form-group">
                              <label for="email" class="col-form-label">Email:</label>
                              <span class="text-danger">*</span>
                              <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
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
                    url: '{!!  route('vendor.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'vus', name: 'vus'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'email', name: 'email'},
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
            var id = button.data('id');
            var name = button.data('name');
            var phone = button.data('phone');
            var address = button.data('address');
            var email = button.data('email');
            var modal = $(this);
            modal.find('.modal-body #vendorid').val(id);
            modal.find('.modal-body #vendor_name').val(name);
            modal.find('.modal-body #vendor_phone').val(phone);
            modal.find('.modal-body #vendor_address').val(address);
            modal.find('.modal-body #email').val(email);

        })
    </script>

    <script>
        $(document).ready(function () {
            $('#vendor').validate({

                rules: {
                    vendor_name: {
                        required: true
                    },
                   
                    vendor_phone: {
                        required: true,
                        number : true
                    },
                    
                    vendor_address: {
                        required: true
                    },
                    email: {
                        required: true,
                        email : true
                    },
                   

                },

                messages: {
                    vendor_name: {
                        required: "<span class='text-danger'>This Vendor Name field is Required</span>"
                    },

                    vendor_phone: {
                        required: "<span class='text-danger'>This Vendor Phone field is Required</span>"
                    },

                    vendor_address: {
                        required: "<span class='text-danger'>This Vendor Address field is Required</span>"
                    },
                    email: {
                        required: "<span class='text-danger'>This Email field Required</span>"
                    },
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
                    window.location.href="/vendor/"+deleteFunction+"/"+id;
                });
        });

    </script>
@endpush
