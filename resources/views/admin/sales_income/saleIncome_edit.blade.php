@extends('admin.layouts.master')

@section('page')
Seller Commission Update
@endsection

@push('css')

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
          <h4 class="panel-title">Seller Commission</h4>
      </div>
      <div class="panel-body">
          <div class="row">
              <form action="{{url('/seles/income/update')}}" method="post" id="sele_come">
                  @csrf

                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Booking No:</label>
                          <select class="form-control" name="booking_no">
                              <option value="{{$sales_detiels->booking_no}}">{{$sales_detiels->booking_no}}</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Sales Person:</label>
                          <select class="form-control" name="seler_id">
                              <option value="{{$sales_detiels->sellerId}}">{{$sales_detiels->saller_people->seller_name}}</option>
                          </select>
                      </div>
                  </div>
                   <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Branch:</label>
                          <select class="form-control" id="branch" name="branch_id">
                              <option value="{{$sales_detiels->branchId}}">{{$sales_detiels->branch->branch_name}}</option>
                          </select>
                      </div>
                  </div>
                  <input type="hidden" name="tranaction_id" value="{{ $tr }}" >
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="category_name" class="col-form-label">Category:</label>
                          <select id='category_name' class="form-control" name="category_id">
                              <option value="{{$sales_detiels->categoryId}}">{{$sales_detiels->category->name}}</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="sub_category_name" class="col-form-label">Sub Category:</label>
                          <select id="sub_category_name" class="form-control" name="sub_cotegoryid">
                              <option value="{{$sales_detiels->subcategoryId}}">{{$sales_detiels->subCategory->sname}}</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="sqft" class="col-form-label">Square fit:</label>
                          <input type="number" id="sqft" name="sqft" class="form-control" value='{{$sales_detiels->square_fit}}' placeholder="Square Fit">
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Total:</label>
                          <input type="number" name="total" class="form-control" id="total" value="{{$sales_detiels->total}}" placeholder="Seller income">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Parcentage:</label>
                          <input type="number" name="parcentage" class="form-control" value="{{$sales_detiels->parcentage}}" id="percentage" placeholder="Parcentage">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Seller income:</label>
                          <select class="form-control" name="seller_income" id="amount">
                            <option value="{{$sales_detiels->seller_income}}">{{$sales_detiels->seller_income}}</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="company" class="col-form-label">Company:</label>
                          <select class="form-control" name="company" id="company">
                              <option value="{{ $sales_detiels->companyId }}">{{ $sales_detiels->Companys->company_name }}</option>
                          </select>
                          <input type="hidden"  name="seller_id" value="{{$sales_detiels->sellerId}}" />
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="date" class="control-label">Date:</label>
                          <input type="text" class="form-control" id="datepicker" value="{{$sales_detiels->date}}" name="date" />
                          <input type="hidden"  name="id" value="{{$sales_detiels->id}}" />

                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="date" class="control-label">Payment Method:</label>
                          <select class="form-control" name="payment_method">
                            @foreach ($payment_method as $value)
                              <option value="{{$value->id}}">{{$value->payment_name}}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="account" class="control-label">Account:</label>
                        <select class="form-control" name="account" id="account">
                          @foreach ($accounts as $account)
                          <option value="{{ $account->id }}" @if($sales_detiels->account == $account->id) selected @endif>{{ $account->account_name }}</option>
                          @endforeach
                        </select>
                    </div>
                    <span id="wrapper" style="color: red;"></span>
                </div>

                  <div class="col-md-12">
                      <div class="form-group pull-right">
                          <a href="{{url('/seller/commission')}}" class="btn btn-info">Back</a>
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

    <script>
            $(document).ready(function () {
                $("#account").on('change',function () {
                    var account = $("#account").val();
                    var amount = $("#amount").val();
                    //console.log(account);
                    $.ajax({
                        url : "{{ route('seller.check') }}",
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
        <script>
            $(document).ready(function () {
                $('#sele_income').validate({
          
                    rules: {
                        booking_no: {
                            required: true
                        },
                        seller_id: {
                            required: true
                        },
                        date: {
                            required: true
                        },
                        payment_method: {
                            required: true
                        },
                        category_id: {
                            required: true
                        },
                        total: {
                            required: true
                        },
                        sub_cotegoryid: {
                            required: true
                        },
                        branch_id: {
                            required: true
                        },
                        sqft: {
                            required: true
                        },
                        company: {
                            required: true
                        },
                        parcentage: {
                            required: true,
                            number : true
                        },
                        account: {
                          required: true
                      },
                      
                      seller_income: {
                          required: true
                      },
                    },
          
                    messages: {
                        booking_no: {
                            required: "<span class='text-danger'>This Booking field is Required</span>"
                        },
                        category_id: {
                            required: "<span class='text-danger'>This Category field is Required</span>"
                        },
                        sub_cotegoryid: {
                            required: "<span class='text-danger'>This Sub Category field is Required</span>"
                        },
                        seller_id: {
                            required: "<span class='text-danger'>This Seller field is Required</span>"
                        },
                        parcentage: {
                            required: "<span class='text-danger'>This Parcentage field is Required</span>"
                        },
                        company: {
                            required: "<span class='text-danger'>This Company field is Required</span>"
                        },
                        branch_id: {
                            required: "<span class='text-danger'>This Branch field is Required</span>"
                        },
                        sqft: {
                            required: "<span class='text-danger'>This Square Fit field is Required</span>"
                        },
                        total: {
                            required: "<span class='text-danger'>This Total Amount  field is Required</span>"
                        },
                        seller_income: {
                            required: "<span class='text-danger'>This Seller Income  field is Required</span>"
                        },
          
                        date: {
                            required: "<span class='text-danger'>This Date field is Required</span>"
                        },
                        payment_method: {
                            required: "<span class='text-danger'>This Payment field is Required</span>"
                        },
                        account: {
                          required: "<span class='text-danger'>This Account field is Required</span>"
                      },
          
                      seller_income: {
                          required: "<span class='text-danger'>This Seller Commission field is Required</span>"
                      },
          
                    }
                });
            });
          </script>
          
@endpush
