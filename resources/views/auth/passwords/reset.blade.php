
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Purbachol | Login Page</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/assets/css/animate.min.css" rel="stylesheet" />
    <link href="/assets/css/style.min.css" rel="stylesheet" />
    <link href="/assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="/assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>

    <body class="pace-top">
        <div id="page-container" class="fade">
            <!-- begin login -->
            <div class="login login-v2" style="margin-top: 120px" data-pageload-addclass="animated fadeIn">
              <div class="col-md-8">
                <div class="login-content">
                      <div class="card-header text-white">
                        <h3>{{ __('Reset Password') }}</h3>
                      </div>
                      
                      <div class="modal-body">
                      <div class="card-body">
                     <form method="POST" action="{{ route('password.update') }}">
                       @csrf
                           <input type="hidden" name="token" value="{{ $token }}">
                             <div class="form-group">
                                 <label for="category_name" class="col-form-label">E-Mail Address</label>
                                 <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                 @error('email')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                             <div class="form-group">
                                 <label for="category_name" class="col-form-label">New Password</label>
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                 @error('password')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                             <div class="form-group">
                                 <label for="category_name" class="col-form-label">Confirm Password</label>
                                   <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                             </div>
                           </div>
                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Reset Password</button>
                         </div>
                     </form>
                  </div>
              </div>
            </div>
        </div>


<!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="/assets/js/login-v2.demo.min.js"></script>
    <script src="/assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            LoginV2.init();
        });
    </script>
</body>
</html>
