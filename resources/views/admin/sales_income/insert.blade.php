 @extends('admin.layouts.master')

@section('page')
Seller Commission
  @endsection

@push('css')
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
              <form action="{{url('/seller/commission/store')}}" method="post" id="sele_income">
                  @csrf
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Booking No<span class="text-danger">*</span></label>
                          <select id="booking_no" class="form-control" name="booking_no">
                            <option value="">-Select One-</option>
                            @foreach ($booking_no as $value)
                              <option value="{{$value->booking_no}}">{{ $value->booking_no }}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="branch" class="col-form-label">Seller<span class="text-danger">*</span></label>
                          <select class="form-control" id="seller" name="seller_id">

                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="branch" class="col-form-label">Branch<span class="text-danger">*</span></label>
                          <select class="form-control" id="branch" name="branch_id">
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="company" class="col-form-label">Company<span class="text-danger">*</span></label>
                          <select class="form-control" name="company" id="company">
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="category_name" class="col-form-label">Category<span class="text-danger">*</span></label>
                          <select id='category_name' class="form-control" name="category_id">

                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="sub_category_name" class="col-form-label">Sub Category<span class="text-danger">*</span></label>
                          <select id="sub_category_name" class="form-control" name="sub_cotegoryid">

                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="sqft" class="col-form-label">Square fit<span class="text-danger">*</span></label>
                          <input type="number" id="sqft" name="sqft" class="form-control" value='' >
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="booking_no" class="col-form-label">Total<span class="text-danger">*</span></label>
                          <input type="number" name="total" class="form-control" id="total" value="" >
                      </div>
                  </div>
                  <input type="hidden" name="sales_commision" value="Seller Expenses">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="parcentage" class="col-form-label">Parcentage<span class="text-danger">*</span></label>
                          <input type="number" name="parcentage" class="form-control" id="percentage">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="seller_income" class="col-form-label">Seller Commission<span class="text-danger">*</span></label>
                          <input type="number" name="seller_income" class="form-control" id="income" value="">
                          <span id="wrapper" style="color: red;"></span>
                        </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="date" class="control-label">Date<span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="datepicker" name="date" />
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="payment_method" class="control-label">Payment Method<span class="text-danger">*</span></label>
                              <select class="form-control" name="payment_method">
                                <option value="">-Select One-</option>
                                @foreach ($payment_methods as $payment_method)
                                  <option value="{{$payment_method->id}}">{{$payment_method->payment_name}}</option>
                                @endforeach
                              </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="account" class="control-label">Bank Account<span class="text-danger">*</span></label>
                              <select class="form-control" name="account" id="account" required>
                                  <option value="">-Select One-</option>
                                @foreach ($bank_accounts as $bank_account)
                                  <option value="{{$bank_account->id}}">{{$bank_account->account_name}}</option>
                                @endforeach
                              </select>
                      </div>
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
      $("#booking_no").change(function(){
          $.ajax({
              url: "{{ route('saller.details') }}?id=" + $(this).val(),
              method: 'GET',
              success: function(data) {

                  $('#seller').html(data.seller);
                  $('#branch').html(data.html);
                  $('#category_name').html(data.html2);
                  $('#sub_category_name').html(data.html3);
                  $('#sqft').val(data.html4);
                  $('#total').val(data.html5);
                  $('#income').val(data.html6);
                  $('#percentage').val(data.html7);
                  $('#company').html(data.html8);
              }
          });
      });
  </script>

  <script>
    $(document).ready(function () {
        $("#account").on('change',function () {
            var account = $("#account").val();
            var amount = $("#income").val();
            //console.log(amount);
           $.ajax({
               url : "{{ route('seller.check') }}",
               method : "get",
               data : {account : account, amount : amount},
               success:function(data) {
                var html ='';
                var returnedData = JSON.parse(data);
                $('#wrapper').html(returnedData);
    
                if(returnedData != ''){
                    $('#submit').attr("disabled", true);
                }else{
                    $('#submit').attr("disabled", false);
                }
                
                console.log(returnedData);
    
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

    @endpush
