@extends('admin.layouts.master')

@section('page')
Booking Commision Update
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
        @foreach ($errors->all() as $error)
            @if (isset($error))
                <div class="alert alert-danger">
                    <li>{{$error}}</li>
                </div>
            @endif
        @endforeach


        <div class="panel-heading">
            <h4 class="panel-title">Booking Commision</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <form action="{{url('/customer/cummision/update')}}" method="post" id="sele_come">
                    @csrf

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="booking_no" class="col-form-label">Booking No:</label>
                            <select class="form-control" name="booking_no">
                                <option value="{{ $CostomerCommision->booking_no }}">{{ $CostomerCommision->booking_no }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="booking_no" class="col-form-label">Customer:</label>
                            <select class="form-control" name="customer">
                                <option value="{{ $CostomerCommision->customer_id }}">{{ $CostomerCommision->Customer->customer_name }}</option>
                            </select>
                            <input type="hidden" name="id" value="{{ $CostomerCommision->id }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="booking_no" class="col-form-label">Branch:</label>
                            <select class="form-control" id="branch" name="branch_id">
                                <option value="{{$CostomerCommision->branchId}}">{{$CostomerCommision->branch->branch_name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Category:</label>
                            <select id='category_name' class="form-control" name="category_id">
                                <option value="{{$CostomerCommision->categoryId}}">{{$CostomerCommision->category->name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sub_category_name" class="col-form-label">Sub Category:</label>
                            <select id="sub_category_name" class="form-control" name="sub_cotegoryid">
                                <option value="{{$CostomerCommision->subcategoryId}}">{{$CostomerCommision->subCategory->sname}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sqft" class="col-form-label">Square fit:</label>
                            <input type="number" id="sqft" name="sqft" class="form-control" value='{{$CostomerCommision->square_fit}}' placeholder="Square Fit">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="booking_no" class="col-form-label">Company:</label>

                            <select class="form-control" name="company">
                              <option value="{{ $CostomerCommision->company }}">{{ $CostomerCommision->Companys->company_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="booking_no" class="col-form-label">Installment:</label>
                              <input type="text" class="form-control" value="{{$CostomerCommision->installment}}" name="installment" id="installment">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="booking_no" class="col-form-label">Parcentage:</label>
                            <input type="text" class="form-control"  name="parcentage" value="{{$CostomerCommision->parcentage}}" id="parcentage" >                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company" class="col-form-label">Grand Total:</label>
                            <input type="text" class="form-control" name="grand_total" value="{{$CostomerCommision->grand_total}}" id="grand_total">
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_method" class="control-label">Payment Method:</label>
                            <select class="form-control" name="payment_method">
                                @foreach ($payment_method as $value)
                                    <option value="{{$value->id}}">{{$value->payment_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="transaction" value="{{ $tr }}">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account" class="control-label">Account:</label>
                            <select class="form-control" name="account" id="account">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" @if($CostomerCommision->account == $account->id) selected @endif>{{ $account->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="accout" value="{{ $CostomerCommision->account }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date" class="control-label">Date:</label>
                            <input type="text" class="form-control" id="datepicker" value="{{$CostomerCommision->date}}" name="date" />
                            <input type="hidden"  name="id" value="{{$CostomerCommision->id}}" />
                        </div>
                        <span id="wrapper" style="color: red;"></span>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group pull-right">
                            <a href="{{url('/customer/commision')}}" class="btn btn-info">Back</a>
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
            $( "#datepicker" ).datepicker();
        } );
    </script>

    <script>
        $('#installment, #parcentage').on('input',function() {
            var percentage = parseInt($('#parcentage').val());
            var installment = parseFloat($('#installment').val());
            console.log(installment);
            $('#grand_total').val((percentage / 100 * installment ? percentage / 100 *installment:0).toFixed(2));
        });
    </script>
    
    <script>
            $(document).ready(function () {
                $("#account").on('change',function () {
                    var account = $("#account").val();
                    var amount = $("#grand_total").val();
                    //console.log(account);
                    $.ajax({
                        url : "{{ route('customer.check') }}",
                        method : "get",
                        data : { account : account, amount : amount },
                        success : function (data) {
                        var html ='';
                        var returnedData = JSON.parse(data);
                        $('#wrapper').html(returnedData);
                        console.log(returnedData);  
                        if(returnedData != ''){
                            $('#submit').attr("disabled", true);
                        }else{
                            $('#submit').attr("disabled", false);
                        }
                    }
                     
                    });
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
    <script>
        $(document).ready(function () {
            $('#customar').validate({
      
                rules: {
                  booking_no: {
                        required: true
                    },
                    seler_id: {
                      required: true
                  },
                    branch_id: {
                        required: true
                    },
                    customer: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    parcentage: {
                        required: true
                    },
                    sub_cotegoryid: {
                        required: true
                    },
                    installment: {
                        required: true
                    },
                    install: {
                      required: true
                  },
                    sqft: {
                        required: true,
                        number : true
                    },
                     total: {
                        required: true,
                        number : true
                    },
                    parcentage: {
                        required: true
                    },
                    seller_income: {
                        required: true,
                        number : true
                    },
                    company: {
                        required: true
                    },
                    date: {
                        required: true
                    },
                    payment_method: {
                        required: true
                    },
                    grand_total: {
                        required: true
                    },
                    account: {
                      required: true
                  },
                },
      
                messages: {
                  booking_no: {
                        required: "<span class='text-danger'>This Booking field is Required</span>"
                    },
                    seler_id: {
                      required: "<span class='text-danger'>This Seller field is Required</span>"
                  },
                    branch_id: {
                        required: "<span class='text-danger'>This Branch field is Required</span>"
                    },
                    category_id: {
                        required: "<span class='text-danger'>This Category Name field is Required</span>"
                    },
                    grand_total: {
                        required: "<span class='text-danger'>This Grand Total field is Required</span>"
                    },
                    install: {
                      required: "<span class='text-danger'>This Installment field is Required</span>"
                  },
                    parcentage: {
                        required: "<span class='text-danger'>This Parcentage field is Required</span>"
                    },
                    installment: {
                        required: "<span class='text-danger'>This Installment Name field is Required</span>"
                    },
      
                    sub_cotegoryid: {
                        required: "<span class='text-danger'>This Sub Category field is Required</span>"
                    },
                    customer: {
                        required: "<span class='text-danger'>This Customer field is Required</span>"
                    },
                    sqft: {
                        required: "<span class='text-danger'>This Sqft field is Required</span>"
                    },
                    total: {
                        required: "<span class='text-danger'>This Total field is Required</span>"
                    },
                    parcentage: {
                        required: "<span class='text-danger'>This Percentage field is Required</span>"
                    },
                    seller_income: {
                        required: "<span class='text-danger'>This Seller Income field is Required</span>"
                    },
                    company: {
                        required: "<span class='text-danger'>This Company field is Required</span>"
                    },
                    date: {
                        required: "<span class='text-danger'>This Date field is Required</span>"
                    },
                    payment_method: {
                        required: "<span class='text-danger'>This Payment field is Required</span>"
                    },
                    account: {
                      required: "<span class='text-danger'>This account field is Required</span>"
                  }
                    
                }
            });
        });
       </script>
       

@endpush
