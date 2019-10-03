@extends('admin.layouts.master')

@section('page')
    Customers
@endsection

@push('css')
@endpush

@section('content')

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
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Customers</button>
            </div>
            <h4 class="panel-title">Customers</h4>
        </div>
        <div class="panel-body">
            <table id="data-table" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#Sl No</th>
                    <th>Name</th>
                    <th>Branch Name</th>
                    <th>Seller's Name</th>
                    <th>Total Booking</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    </div>

    <!--Add Customer modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Customer</h5>
                </div>
                <form action="{{ route('customer.store') }}" method="post" id="customers" enctype="multipart/form-data">@csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_name" class="col-form-label">Branch Name:</label>
                                    <span class="text-danger">*</span>
                                    <select name="customer_branch" id="customer_branch" class="form-control" required>
                                    @if(Auth::user()->type == 'admin')
                                        <option value="">Select Branch</option>
                                    @endif
                                    @foreach($branch as $b)
                                        <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                    @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="customer_name" class="col-form-label">Customer Name:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_name" class="form-control" id="customer_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <span class="text-danger">*</span>
                                    <input type="email" name="customer_email" class="form-control" id="customer_email" required>
                                </div>

                                <div class="form-group">
                                    <label for="user_phone" class="col-form-label">Phone:</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" name="customer_phone" class="form-control" id="customer_phone" required>
                                </div>

                                <div class="form-group">
                                    <label for="customer_zcode" class="col-form-label">Zip Code:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_zcode" class="form-control" id="customer_zcode" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sales_person" class="col-form-label">Sales Person:</label>
                                    <span class="text-danger">*</span>
                                    <select name="customer_seller" id="customer_seller" class="form-control" required>
                                        <option value="">Select Sales Person</option>
                                        @foreach($seller as $s)
                                            <option value="{{  $s->id }}">{{  $s->seller_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="customer_father" class="col-form-label">Father's Name:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_father" class="form-control" id="customer_father" required>
                                </div>

                                <div class="form-group">
                                    <label for="customer_address" class="col-form-label">Address:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_address" class="form-control" id="customer_address" required>
                                </div>

                                <div class="form-group">
                                    <label for="customer_city" class="col-form-label">City:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_city" class="form-control" id="customer_city" required>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="col-form-label">Image:</label>
                                    <input type="file" name="image" class="form-control" id="customer_image">
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

    <!--Edit Customer modal-->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="editModalLabel">Edit Customer</h5>
                </div>
                <form action="{{ route('customer.update') }}" method="post" id="customer" enctype="multipart/form-data">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" id="c_id" value="">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="branch_name" class="col-form-label">Branch Name:</label>
                                    <span class="text-danger">*</span>
                                    <select name="customer_branch" class="form-control" id="c_branch" required>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="customer_name" class="col-form-label">Customer Name:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_name" class="form-control" id="c_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <span class="text-danger">*</span>
                                    <input type="email" name="customer_email" class="form-control" id="c_email" required>
                                </div>

                                <div class="form-group">
                                    <label for="customer_phone" class="col-form-label">Phone:</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" name="customer_phone" class="form-control" id="c_phone" required>
                                </div>

                                <div class="form-group">
                                    <label for="customer_zcode" class="col-form-label">Zip Code:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_zcode" class="form-control" id="c_zcode" required>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sales_person" class="col-form-label">Sales Person:</label>
                                    <span class="text-danger">*</span>
                                    <select name="customer_seller" class="form-control" id="c_seller" required>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="customer_address" class="col-form-label">Address:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_address" class="form-control" id="c_address" required>
                                </div>

                                <div class="form-group">
                                    <label for="customer_city" class="col-form-label">City:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_city" class="form-control" id="c_city" required>
                                </div>

                                <div class="form-group">
                                    <label for="customer_father" class="col-form-label">Father Name:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="customer_father" class="form-control" id="c_father" required>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="col-form-label">Image:</label>
                                    <input type="file" name="image" class="form-control" id="c_image">
                                </div>

                            </div>
                        </div>

                        <div id="showimage"></div>
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
                    url: '{!!  route('customer.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'cus', name: 'cus'},
                    {data: 'branch_name', name: 'branch_name'},
                    {data: 'seller_name', name:'seller_name'},
                    {data: 'total_booking', name: 'total_booking'},
                    {data: 'phone', name: 'phone'},
                    {data: 'picture', name: 'picture'},
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
            var cd = button.data('cid');
            var cn = button.data('cname');
            var cfn = button.data('cfname');
            var ce = button.data('cemail');
            var cp = button.data('cphone');
            var ca = button.data('caddress');
            var czc = button.data('czcode');
            var cc = button.data('ccity');
            var ci = button.data('cimage');
            var branchId = button.data('bid');
            var branch_name = button.data('branch_name');
            var sellerId = button.data('sellerid');
            var seller_name = button.data('seller_name');
            var modal = $(this);

            modal.find('.modal-body #c_id').val(cd);
            modal.find('.modal-body #c_name').val(cn);
            modal.find('.modal-body #c_father').val(cfn);
            modal.find('.modal-body #c_email').val(ce);
            modal.find('.modal-body #c_phone').val(cp);
            modal.find('.modal-body #c_address').val(ca);
            modal.find('.modal-body #c_zcode').val(czc);
            modal.find('.modal-body #c_city').val(cc);
            modal.find('.modal-body #c_branch').val(branch_name);
            modal.find('.modal-body #c_seller').val(seller_name);

            $("#showimage").html('');
            $("#showimage").append("<img src='cimage/"+ci+"' width='50'>");

            $("#c_branch").html('');
            $("#c_branch").append("<option value='"+branchId+"'>"+branch_name+"</option>");
            
            $("#c_seller").html('');
            $("#c_seller").append("<option value='"+sellerId+"'>"+seller_name+"</option>");

        })
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
                    window.location.href="/customer/"+deleteFunction+"/"+id;
                });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#users').validate({

                rules: {
                    customer_branch: {
                        required: true
                    },

                    customer_seller: {
                        required: true
                    },
                    customer_name: {
                        required: true
                    },
                    customer_father: {
                        required: true
                    },
                    customer_email: {
                        required: true,
                        email: true
                    },

                    customer_phone: {
                        required: true,
                        number: true
                    },
                    customer_address: {
                        required: true
                    },
                    customer_zcode: {
                        required: true
                    },
                    customer_city: {
                        required: true
                    }
                },

                messages: {
                    customer_branch: {
                        required: "<span class='text-danger'>This Branch field is Required</span>"
                    },
                    customer_seller: {
                        required: "<span class='text-danger'>This Sales Person field is Required</span>"
                    },
                    customer_name: {
                        required: "<span class='text-danger'>This Name field is Required</span>"
                    },
                    customer_father: {
                        required: "<span class='text-danger'>This Father Name field is Required</span>"
                    },
                    customer_email: {
                        required: "<span class='text-danger'>This Email field is Required</span>"
                    },
                    customer_phone: {
                        required: "<span class='text-danger'>This Phone field is Required</span>"
                    },
                    customer_address: {
                        required: "<span class='text-danger'>This Address field is Required</span>"
                    },
                    customer_zcode: {
                        required: "<span class='text-danger'>This Zip Code field is Required</span>"
                    },
                    customer_city: {
                        required: "<span class='text-danger'>This City field is Required</span>"
                    },
                }

            });
        });
    </script>
@endpush
