
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
	<link href="./assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="./assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="./assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="./assets/css/animate.min.css" rel="stylesheet" />
	<link href="./assets/css/style.min.css" rel="stylesheet" />
	<link href="./assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="./assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->

	<div class="login-cover">
	    <div class="login-cover-image"><img src="./assets/img/login-bg/bg-1.jpg" data-id="login-cover-image" alt="" /></div>
	    <div class="login-cover-bg"></div>
	</div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> Purbachol
                    <small>Welcome to Purbachol builders Limited</small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
                <form action="{{ route('login') }}" method="POST" class="margin-bottom-0">
                  @csrf
                    <div class="form-group m-b-20">
                        <input type="text" name="email" class="form-control input-lg @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" name="password" class="form-control input-lg @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="Password"  />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                    </div>

                    <div class="form-group text-center">
                    	<div style="padding-top: 15px;">
                    		@if (Route::has('password.request'))
                    			<a href="{{ route('password.request') }}">Forgot Password </a>
                    		@endif
                    	</div>
                    </div>

                </form>
            </div>
        </div>
        <!-- end login -->

        <ul class="login-bg-list clearfix">
            <li class="active"><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-1.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="./assets/img/login-bg/bg-2.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="./assets/img/login-bg/bg-3.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="./assets/img/login-bg/bg-4.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="./assets/img/login-bg/bg-5.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="./assets/img/login-bg/bg-6.jpg" alt="" /></a></li>
        </ul>


	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="./assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="./assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="./assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="./assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="./assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="./assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->

	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="./assets/js/login-v2.demo.min.js"></script>
	<script src="./assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			LoginV2.init();
		});
	</script>
</body>
</html>
