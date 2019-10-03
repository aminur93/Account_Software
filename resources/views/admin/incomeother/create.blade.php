@extends('admin.layouts.master')

@section('page')
    Other Income Create
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

                <h4 class="panel-title">Other Income Create</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form action="{{ route('other.store') }}" method="post" enctype="multipart/form-data" id="other">@csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="income_date" class="control-label">Date:</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="datepicker" name="income_date" required>
                            </div>
                            <div class="form-group">
                                <label for="account" class="control-label">Account:</label>
                                <span class="text-danger">*</span>
                                <select name="account" id="" class="form-control" required>
                                    <option value="">Select Account</option>
                                    @foreach ($account as $acc)
                                        <option value="{{ $acc->id }}">{{ $acc->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="branch" class="control-label">Branch:</label>
                                <span class="text-danger">*</span>
                                <select name="branch" id="branch" class="form-control" required>
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="payment_method" class="control-label">Payment Method:</label>
                                <span class="text-danger">*</span>
                                <select name="payment_method" id="" class="form-control" required>
                                    <option value="">Select Payment Method</option>
                                    @foreach($payment as $pay)
                                        <option value="{{ $pay->id }}">{{ $pay->payment_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Attachment:</label>
                                <input type="file" class="form-control" name="attachment">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category" class="control-label">Category:</label>
                                <span class="text-danger">*</span>
                                <select name="category_id" id="" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php
                                        if(array_key_exists('income', $dataCategory)){
                                        foreach ($dataCategory['income'] as $dc)
                                    {?>
                                        <option value="{{ $dc->id }}">{{ $dc->name }}</option>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount" class="control-label">Amount:</label>
                                <span class="text-danger">*</span>
                                <input type="number" class="form-control" name="amount"  required>
                            </div>
                            <div class="form-group">
                                <label for="source_name" class="control-label">Source Name:</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="source_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="Description" class="control-label">Description:</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <a href="{{ route('other.index') }}" class="btn btn-info">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
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
            $('#other').validate({
                rules: {
                    income_date: {
                        required: true,
                    },
                    account: {
                        required: true,
                    },
                    branch: {
                        required: true,
                    },
                    payment_method: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    amount: {
                        required: true,
                        number : true
                    },
                    source_name: {
                        required: true,
                    },
                },
            });
        });
    </script>
@endpush