@extends('admin.layouts.master')

@section('page')
    Vendor payment Edit
@stop

@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                <h4 class="panel-title">Vendor Payment Edit</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('vendors.update',$vendors->id) }}" method="post" enctype="multipart/form-data">@csrf
                    <div class="row">
                        <input type="hidden" name="id" value="{{ $vendors->id }}">
                        <input type="hidden" name="memberId" value="{{ $tr }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date" class="control-label">Date:</label>
                                <span class="text-danger">*</span>
                                <input type="text" value="{{ $vendors->date }}" class="form-control" id="datepicker" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="account" class="control-label">Account:</label>
                                <span class="text-danger">*</span>
                                <select name="account" id="account" class="form-control">
                                    <option value="">Select Account</option>
                                    @foreach($account as $ac)
                                        <option value="{{ $ac->id }}" @if($vendors->account == $ac->id) selected @endif>{{ $ac->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category" class="control-label">Category:</label>
                                <span class="text-danger">*</span>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php
                                    if(array_key_exists('expense', $dataCategory)){
                                    foreach ($dataCategory['expense'] as $dc){
                                    ?>
                                    <option value="{{ $dc->id }}" @if($vendors->category_id == $dc->id) selected @endif>{{ $dc->name }}</option>
                                    <?php } } ?>
                                </select>
                                <input type="hidden" name="type" value="expense">
                            </div>

                            <div class="form-group">
                                <label for="payment_method" class="control-label">Payment Method:</label>
                                <span class="text-danger">*</span>
                                <select name="payment_method" id="payment_method" class="form-control">
                                    <option value="">Select Payment Method</option>
                                    @foreach($payment as $p)
                                        <option value="{{ $p->id }}" @if($vendors->payment_method == $p->id) selected @endif>{{ $p->payment_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount" class="control-label">Amount:</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" value="{{ $vendors->amount }}" class="form-control" id="amount" name="amount" required>
                                    <span id="wrapper" style="color: red;"></span>
                                </div>
                            <div class="form-group">
                                <label for="vendor" class="control-label">Vendor:</label>
                                <span class="text-danger">*</span>
                                <select name="vendor" id="vendor" class="form-control">
                                    <option value="">Select vendor</option>
                                    @foreach($vendor as $v)
                                        <option value="{{ $v->id }}" @if($vendors->vendor_id == $v->id) selected @endif>{{ $v->vendor_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="branch" class="control-label">Branch:</label>
                                <span class="text-danger">*</span>
                                <select name="branch" id="branch" class="form-control">
                                    <option value="">Select Branch</option>
                                    @foreach($branch as $b)
                                        <option value="{{ $b->id }}" @if($vendors->branch_id == $b->id) selected @endif>{{ $b->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="attachment" class="control-label">Attachment:</label>
                                
                                <input type="file" class="form-control" id="attachment" name="attachment">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            </div>
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
                    url : "{{ route('vendorCheck.check') }}",
                    method : "get",
                    data : { account : account, amount : amount },
                    success : function (data) {
                    var html ='';
                    var returnedData = JSON.parse(data);
                    $('#wrapper').html(returnedData);
        
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
@endpush