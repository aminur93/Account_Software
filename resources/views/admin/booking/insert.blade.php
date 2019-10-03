@extends('admin.layouts.master')

@section('page')
    Booking
    @endsection

@push('css')
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        .swidth{
            width: 110%;
        }
        .bmargin{
            margin-top: 22px;
            margin-left: 20px;
        }
    </style>
@endpush


@section('content')


<div class="panel panel-inverse text-dark">
    <div class="panel-heading">
        <h4 class="panel-title">Booking</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <form action="{{ route('booking.store') }}" method="post" id="booking">
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="booking_no" class="col-form-label">Booking No:</label>
                        <span class="text-danger">*</span>
                        <input type="text" name="booking_no" class="form-control" id="booking_no" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        @php
                            $types = array("Flat", "Land");
                        @endphp
                        <label for="booking_type" class="col-form-label">Booking type:</label>
                        <span class="text-danger">*</span>
                        <select name="booking_type" id="booking_type" class="form-control" required>
                            <option value="">Select Booking Type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="seller_name" class="col-form-label">Seller Name:</label>
                        <span class="text-danger">*</span>
                        <select id="seller_name" class="form-control swidth" name="seller_name" required>
                            <option value="">Select Seller Name</option>
                            @foreach ($sellers as $seller)
                                <option value="{{ $seller->id }}">{{ $seller->seller_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary bmargin" data-toggle="modal" data-target="#addSeller"><span class="fa fa-plus "></span></button>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="customer_name" class="col-form-label">Customer Name:</label>
                        <span class="text-danger">*</span>
                        <select id="customer_name" class="form-control swidth" name="customer_name" required>
                            <option value="">Select Customer Name</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary bmargin" data-toggle="modal" data-target="#addCustomer"><span class="fa fa-plus "></span></button>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="branch_name" class="col-form-label">Branch Name:</label>
                        <span class="text-danger">*</span>
                        <select id="branch_name" class="form-control swidth" name="branch_name" required>
                            @if(Auth::user()->type == 'admin')
                            <option value="">Select Branch Name</option>
                            @endif
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-1">
                    <button type="button" class="btn btn-primary bmargin" data-toggle="modal" data-target="#addBranch"><span class="fa fa-plus "></span></button>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="company_name" class="col-form-label">Company Name:</label>
                        <span class="text-danger">*</span>
                        @if(Auth::user()->type == 'admin')
                            <select id="company_name" class="form-control swidth" name="company_name" required>
                            <option value="">Select Company Name</option>
                        @else
                            <select id="company_name" class="form-control swidth" name="company_name">
                                @foreach($company as $com)
                                    <option value="{{ $com->id }}">{{ $com->company_name }}</option>
                                @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary bmargin" data-toggle="modal" data-target="#addCompany"><span class="fa fa-plus "></span></button>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="category_name" class="col-form-label">Category Name:</label>
                        <span class="text-danger">*</span>
                        <select id="category_name" class="form-control swidth" name="category_name" required>
                            <option value="">Select Category Name</option>
                            <?php 
                                if(array_key_exists('item', $dataCategory)){
                                foreach ($dataCategory['item'] as $dc){
                            ?>
                                <option value="{{ $dc->id }}">{{ $dc->name }}</option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary bmargin" data-toggle="modal" data-target="#addCategory"><span class="fa fa-plus "></span></button>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="sub_category_name" class="col-form-label">Sub Category Name:</label>
                        <span class="text-danger">*</span>
                        <select id="sub_category_name" class="form-control swidth" name="sub_category_name" required>
                            <option value="">Select Sub Category Name</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary bmargin" data-toggle="modal" data-target="#addSubCategory"><i class="fa fa-plus "></i></button>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sqft" class="col-form-label">Square Fit:</label>
                        <span class="text-danger">*</span>
                        <input type="number" name="sqft" class="form-control" id="sqft" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="booking_date" class="control-label">Booking Date:</label>
                        <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="datepicker" name="booking_date" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price" class="col-form-label">Price:</label>
                        <span class="text-danger">*</span>
                        <input type="number" name="price" class="form-control" id="price" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="total_price" class="col-form-label">Total:</label>
                        <span class="text-danger">*</span>
                        <input type="number" name="total_price" class="form-control" id="total_price" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group pull-right">
                        <a href="{{ route('booking.index') }}" class="btn btn-info">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Add Company modal-->
<div class="modal fade" id="addCompany" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Company</h5>
                </div>
                <form action="{{ route('company.store') }}" method="post" id="company">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="branch_name" class="col-form-label">Branch Name:</label>
                            <span class="text-danger">*</span>
                            <select name="branch_name" class="form-control" id="branch_name" required>
                                <option value="">Select Branch Name</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company_name" class="col-form-label">Company Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="company_name" class="form-control" id="company_name" required>
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

<!--Add Customer modal-->
<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
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
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $b)
                                        <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sales_person" class="col-form-label">Sales Person:</label>
                                <span class="text-danger">*</span>
                                <select name="customer_seller" id="customer_seller" class="form-control" required>
                                    <option value="">Select Sales Person</option>
                                    @foreach($sellers as $s)
                                        <option value="{{  $s->id }}">{{  $s->seller_name }}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="customer_email" class="form-control" id="customer_email" required>
                            </div>

                            <div class="form-group">
                                <label for="user_phone" class="col-form-label">Phone:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="customer_phone" class="form-control" id="customer_phone" required>
                            </div>

                            <div class="form-group">
                                <label for="customer_zcode" class="col-form-label">Zip Code:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="customer_zcode" class="form-control" id="customer_zcode" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_name" class="col-form-label">Name:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="customer_name" class="form-control" id="customer_name" required>
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

{{-- Add Seller Modal --}}
<div class="modal fade" id="addSeller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Add Seller</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('salesperson.store') }}" method="post" id="sales_person" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sales_person_name" class="col-form-label">Sales Person Name:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="sales_person_name" class="form-control" id="sales_person_name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone" class="col-form-label">Phone Number:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="phone" class="form-control" id="phone" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email" class="col-form-label">Email:</label>
                                <span class="text-danger">*</span>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="national_id" class="col-form-label">National ID:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="national_id" class="form-control" id="national_id" required>
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

                            <div class="form-group col-md-12">
                                <label for="sales_parcentage" class="col-form-label">Sales Percantage:</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="sales_parcentage" class="form-control" id="sales_parcentage" required>
                            </div>

                            <div class="form-group col-md-12">
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
</div>

{{-- Add Branch Modal --}}

<div class="modal fade" id="addBranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Add Branch</h5>
            </div>
            <div class="modal-body">
                    <form action="{{ route('branch.store') }}" method="post" id="branch">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="branch_name" class="col-form-label">Branch Name:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="branch_name" class="form-control" id="branch_name" required>
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
</div>

<!--Add Company modal-->
<div class="modal fade" id="addCompany" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="addModalLabel">Add Company</h5>
            </div>
            <form action="{{ route('company.store') }}" method="post" id="company">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="branch_name" class="col-form-label">Branch Name:</label>
                        <span class="text-danger">*</span>
                        <select name="branch_name" class="form-control" id="branch_name" required>
                            <option value="">Select Branch Name</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-form-label">Company Name:</label>
                        <span class="text-danger">*</span>
                        <input type="text" name="company_name" class="form-control" id="company_name" required>
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

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Add Catagory</h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('/category/store') }}" method="post" id="category">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="subcategory_name" class="col-form-label">Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="category_name" class="form-control" required>
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
</div>

{{-- Add Sub Category Modal --}}
<div class="modal fade" id="addSubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Add Sub-Category</h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('/subcategory/store') }}" method="post" id="category">@csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category:</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" name="categoryid" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Sub Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="sname" class="form-control" id="category_name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Square Fit</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="sqft" class="form-control" required>
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
</div>

@endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );
    </script>


    <script>
        $(document).ready(function () {
            $('#booking').validate({
                rules: {
                    booking_no: {
                        required: true
                    },
                    booking_type: {
                        required: true
                    },
                    seller_name: {
                        required: true

                    },
                    customer_name: {
                        required: true

                    },
                    branch_name: {
                        required: true

                    },
                    category_name: {
                        required: true

                    },
                    sub_category_name: {
                        required: true

                    },
                    sqft: {
                        required: true

                    },
                    price: {
                        required: true
                    },
                    total_price: {
                        required: true
                    },
                    booking_date: {
                        required: true
                    },
                    sales_person_name: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    email: {
                        required: true,
                        email:true
                    },
                    national_id: {
                        required: true
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
                    branch_name: {
                        required: true,
                    },
                    category_name: {
                        required: true
                    },
                    sname: {
                        required: true
                    },
                    categoryid: {
                        required: true
                    },
                    sqft: {
                        required: true
                    },
                }
            });
        });
    </script>


    {{-- Select Sub Category base on Category --}}

    <script>
        $("#category_name").change(function(){
            $.ajax({
                url: "{{ route('booking.subcategory') }}?categoryId=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#sub_category_name').html(data.html);
                }
            });
        });
    </script>

    {{-- Select company base on branch --}}

    <script>
        $("#branch_name").change(function(){
            $.ajax({
                url: "{{ route('booking.company') }}?branchId=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#company_name').html(data.html);
                }
            });
        });
    </script>

    {{-- Add Square fit value from sub category --}}
    <script>
        $("#sub_category_name").change(function(){
            $.ajax({
                url: "{{ route('booking.sqft') }}?id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#sqft').val(data);
                }
            });
        });
    </script>

    {{-- calculate total Price --}}
    <script>
        $('#sqft, #price').on('input',function() {
            var sqft = parseInt($('#sqft').val());
            var price = parseInt($('#price').val());
            $('#total_price').val((sqft * price ? sqft * price : 0));
        });
    </script>

@endpush
