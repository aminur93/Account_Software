@extends('admin.layouts.master')

@section('page')
    Change Password
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
                <h4 class="panel-title">Change Password</h4>
            </div>
            <div class="panel-body">
                <div class="row" style="padding-left: 250px;">
                    <form action="{{ route('user.updatePassword') }}" method="post" id="change_password">@csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_pwd" class="col-form-label">Current Password:</label>
                                <input type="password" name="current_pwd" class="form-control" id="current_pwd">
                                <span id="chkPwd"></span>
                            </div>

                            <div class="form-group">
                                <label for="new_pwd" class="col-form-label">New Password:</label>
                                <input type="password" name="new_pwd" class="form-control" id="new_pwd">
                            </div>

                            <div class="form-group">
                                <label for="confirm_pwd" class="col-form-label">Confirm Password:</label>
                                <input type="password" name="confirm_pwd" class="form-control" id="confirm_pwd">
                            </div>

                            <div class="form-group">
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
    <script>
        $(document).ready(function () {
            $("#current_pwd").keyup(function(){
                var current_pwd = $("#current_pwd").val();

                $.ajax({
                    type: 'get',
                    url: '/user/check-pwd',
                    data: {current_pwd:current_pwd},
                    success: function(resp){
                        //alert(resp);
                        if(resp == 'false'){
                            $("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
                        }else if(resp == 'true'){
                            $("#chkPwd").html("<font color='green'>Current Password is Correct</font>");
                        }
                    }, error:function() {
                        alert("Error");
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#change_password').validate({

                rules: {

                    current_pwd: {
                        required: true,

                    },
                    new_pwd: {
                        required: true,
                        minlength:6,
                        maxlength:20
                    },
                    confirm_pwd: {
                        required: true,
                        minlength:6,
                        maxlength:20
                    }
                    
                },

                messages: {

                    current_pwd: {
                        required: "<span class='text-danger'>This Current Password field is Required</span>"
                    },
                    new_pwd: {
                        required: "<span class='text-danger'>This New Password field is Required</span>"
                    },
                    confirm_pwd: {
                        required: "<span class='text-danger'>This Confirm Password field is Required</span>"
                    }
                }

            });
        });
    </script>
    @endpush