@extends('admin.layouts.master')

@section('page')
    Customer Installment
@endsection

@push('css')
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
<div class="col-md-12">

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Edit Customer Installment</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('installment.update') }}" method="post" id="installment">
                    @csrf
                    <input type="hidden" name="id" value="{{ $installment->id }}"/>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="install_name" class="col-form-label">Installment Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="install_name" class="form-control" id="install_name" value="{{ $installment->install_name }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="installment_date" class="control-label">Installment Date:</label>
                            <span class="text-danger">*</span>
                            <input type="text" value="{{ $installment->install_date }}" class="form-control" id="datepicker" name="installment_date"  required/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="booking_no" class="col-form-label">Booking No:</label>
                            <span class="text-danger">*</span>
                            <select id="booking_no" class="form-control" name="booking_no" required>
                                <option value="">Select Booking No</option>
                                @foreach ($bookings as $booking)
                                    <option value="{{ $booking->id }}" @if($installment->bookingId == $booking->id) selected @endif>{{ $booking->booking_no }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_name" class="col-form-label">Customer Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" value="{{ $installment->customer_name }}" name="customer_name" id="c_name" class="form-control" required>
                            <input type="hidden" value="{{ $installment->customerId }}"  name="customer_id" id="c_id">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch_name" class="col-form-label">Branch Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" value="{{ $installment->branch_name }}" class="form-control" id="branch_name" name="branch_name" required>
                            <input type="hidden" value="{{ $installment->branchId }}" id="branch_id" name="branch_id">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sales_person_name" class="col-form-label">Sales Person Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" value="{{ $installment->seller_name }}" id="sales_person_name" class="form-control" name="sales_person_name" required>
                            <input type="hidden" value="{{ $installment->sellerId }}" id="sales_person_id" name="sales_person_id">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" value="{{ $installment->name }}" id="category_name" class="form-control" name="category_name" required>
                            <input type="hidden" value="{{ $installment->categoryId }}" id="category_id" name="category_id">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sub_category_name" class="col-form-label">Sub Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" value="{{ $installment->sname }}" id="sub_category_name" class="form-control" name="sub_category_name" required>
                            <input type="hidden" value="{{ $installment->subcategoryId }}" id="sub_category_id" name="sub_category_id">

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sqft" class="col-form-label">Square Fit:</label>
                            <span class="text-danger">*</span>
                            <input type="number" value="{{ $installment->square_fit }}" name="sqft" class="form-control" id="sqft" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_price" class="col-form-label">Total:</label>
                            <span class="text-danger">*</span>
                            <input type="number" value="{{ $installment->total }}" name="total_price" class="form-control" id="total_price" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment" class="col-form-label">Payment:</label>
                            <span class="text-danger">*</span>
                            <input type="number" name="payment" class="form-control" value="{{ $installment->payment }}" id="payment" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account_id" class="col-form-label">Account</label>
                            <span class="text-danger">*</span>
                            <select id="account_id" class="form-control" name="account_id" required>
                                <option value="">Select Account:</option>
                                @foreach ($accounts as $acc)
                                    <option {{ $acc->id == $installment->accountId ? "selected" : "" }} value="{{ $acc->id }}">{{ $acc->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payement_method_id" class="col-form-label">Payment method</label>
                            <span class="text-danger">*</span>
                            <select id="payement_method_id" class="form-control" name="payement_method_id" required>
                                <option value="">Select Payment:</option>
                                @foreach ($payments as $pay)
                                    <option {{ $pay->id == $installment->bookingId ? "selected" : "" }} value="{{ $pay->id }}">{{ $pay->payment_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group pull-right">
                            <a href="{{ route('installment.index') }}" class="btn btn-info">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
    <script>
        $(document).ready(function () {
            $('#installment').validate({
                rules: {
                    install_name: {
                        required: true
                    },
                    booking_no: {
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
                    payment: {
                        required: true
                    },
                }
            });
        });
    </script>
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

    <!-- Get all fields -->
    <script>
        $("#booking_no").change(function(){
            $.ajax({
                url: "{{ route('installment.getfield') }}?id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $("#c_id").val(data.customerId);
                    $("#c_name").val(data.customer)
                    $('#branch_name').val(data.branch_name);
                    $('#branch_id').val(data.branchId);
                    $('#sales_person_name').val(data.sales_person_name);
                    $('#sales_person_id').val(data.sales_person_id);
                    $('#category_name').val(data.category_name);
                    $('#category_id').val(data.category_id);
                    $('#sub_category_name').val(data.sub_category_name);
                    $('#sub_category_id').val(data.sub_category_id);
                    $('#sqft').val(data.sqft);
                    $('#total_price').val(data.total);
                }
            });
        });
    </script>
@endpush
