@extends('admin.layouts.master')

@section('page')
    Sales Person
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
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Sales Person</button>
                </div>
                <h4 class="panel-title">Sales Person</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered small">
                    <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Postal Code</th>
                        <th>Country</th>
                        <th>Sales%</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Sales Person modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Sales Person</h5>
                </div>
                <form action="{{ route('salesperson.store') }}" method="post" id="sales_person" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sales_person_name" class="col-form-label">Sales Person Name:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="sales_person_name" class="form-control" id="sales_person_name">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone" class="col-form-label">Phone Number:</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="phone" class="form-control" id="phone">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email" class="col-form-label">Email:</label>
                                <span class="text-danger">*</span>
                                <input type="email" name="email" class="form-control" id="email">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="national_id" class="col-form-label">National ID:</label>
                                <input type="number" name="national_id" class="form-control" id="national_id">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="address" class="col-form-label">Address:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="address" class="form-control" id="address">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="city" class="col-form-label">City:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="city" class="form-control" id="city">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="postal_code" class="col-form-label">Postal Code:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="postal_code" class="form-control" id="postal_code">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="country" class="col-form-label">Country:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="country" class="form-control" id="country">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sales_parcentage" class="col-form-label">Sales Percantage:</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="sales_parcentage" class="form-control" id="sales_parcentage">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" name="image" class="form-control" id="image">
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

    <!--edit Sales Person modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="editModalLabel">Edit Sales Person</h5>
                </div>
                <form action="{{ route('salesperson.update') }}" method="post" id="sales_person" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="sales_person_id" id="sales_person_id" value="">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sales_person_name" class="col-form-label">Sales Person Name:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="sales_person_name" class="form-control" id="sales_person_name" required>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="phone" class="col-form-label">Phone Number:</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="phone" class="form-control" id="phone" required>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="email" class="col-form-label">Email:</label>
                                <span class="text-danger">*</span>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="national_id" class="col-form-label">National ID:</label>
                                <input type="number" name="national_id" class="form-control" id="national_id">
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="address" class="col-form-label">Address:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="address" class="form-control" id="address" required>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="city" class="col-form-label">City:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="city" class="form-control" id="city" required>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="postal_code" class="col-form-label">Postal Code:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="postal_code" class="form-control" id="postal_code" required>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="country" class="col-form-label">Country:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="country" class="form-control" id="country" required>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="sales_parcentage" class="col-form-label">Sales Percantage:</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="sales_parcentage" class="form-control" id="sales_parcentage" required>
                            </div>
    
                            <div class="form-group col-md-6" >
                                <label for="image" class="col-form-label">Image:</label>
                                <input class="form-control" type="file" name="image" id="image">
                                <div id="imageBox"></div>
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

{{-- Get Data and show table coloumn --}}

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
                    url: '{!!  route('salesperson.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'seller_name', name: 'seller_name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'address', name: 'address'},
                    {data: 'city', name: 'city'},
                    {data: 'postal_code', name: 'postal_code'},
                    {data: 'country', name: 'country'},
                    {data: 'sales_parcentage', name: 'sales_parcentage'},
                    {data: 'image', name: 'image',
                        render: function( data ) {
                            return "<img src=\"/images/" + data + "\" height=\"50\"/>";
                        }
                    },
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

{{-- Edit Sales Person Modal --}}

    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var sales_person_id = button.data('sales_person_id');
            var sales_person_name = button.data('sales_person_name');
            var phone = button.data('phone');
            var email = button.data('email');
            var national_id = button.data('national_id');
            var address = button.data('address');
            var city = button.data('city');
            var postal_code = button.data('postal_code');
            var country = button.data('country');
            var sales_parcentage = button.data('sales_parcentage');
            var image = button.data('image');
            var modal = $(this);

            modal.find('.modal-body #sales_person_id').val(sales_person_id);
            modal.find('.modal-body #sales_person_name').val(sales_person_name);
            modal.find('.modal-body #phone').val(phone);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #national_id').val(national_id);
            modal.find('.modal-body #address').val(address);
            modal.find('.modal-body #city').val(city);
            modal.find('.modal-body #postal_code').val(postal_code);
            modal.find('.modal-body #country').val(country);
            modal.find('.modal-body #sales_parcentage').val(sales_parcentage);
            $("#imageBox").html('');
            $("#imageBox").append("<img class='p-1' src='images/"+image+"' alt='' width='70'/>");
        })
    </script>
{{-- Validation --}}
        <script>
        $(document).ready(function () {
            $('#sales_person').validate({

                rules: {

                    sales_person_name: {
                        required: true

                    },
                    phone: {
                        required: true,
                        number : true
                    },
                    email: {
                        required: true,
                        email:true
                    },
                    address: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    postal_code: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    sales_parcentage: {
                        required: true
                    },
                }

            });
        });
    </script>

{{-- Delete Script --}}

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
                    window.location.href="/salesperson/"+deleteFunction+"/"+id;
                });
        });

    </script>
@endpush
