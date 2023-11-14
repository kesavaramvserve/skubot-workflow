<!DOCTYPE html>
<html lang="en">

<head>
  <title>SKUBOT - Admin Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons STR-->
  <link href="" rel="icon">
  <link href="" rel="apple-touch-icon">
  <link rel="stylesheet" href="{{asset('client/css/admin_style.css')}}">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- Vendor CSS Files -->

	
 <!-- Template Main CSS File -->
<style>
 section.ftco-section {
    background-image: url(client/images/register_BG-01.png);
    min-height: auto;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
button.form-control.btn.btn-primary.rounded.submit.px-3 {
    font-size: 17px;
    font-weight: 700;
    background-color: #feec98 ! important;
    border-radius: 11px ! important;
    border-top: 0px solid transparent;
    color: #13182b ! important;
    color: #13182b ! important;
    direction: ltr;
    letter-spacing: 1px;
    display: inline-block;
	width:200px;
	margin-left: 80px;
}
.form-control {
  border-radius: 13px;
}
@media (max-width: 600px) {
  button.form-control.btn.btn-primary.rounded.submit.px-3 {
	margin-left: 40px;
  }
 .w-100.text-md-center {
    margin-left: 70px;
  }
}
</style>
</head>
<body>
 <!-- ======= Header ======= -->
   <div class="container">
		<div class="row">
		     <div class="col-lg-4"></div>
			 <div class="col-lg-4">
			 <a href="#" class="logo me-auto"><img src="{{asset('client/images/logo.png')}}" alt="" class="img-fluid"></a>
			 </div>
			 <div class="col-lg-4"></div>
		</div>
    </div>
 <!-- ======= Header ======= -->


<!-- ======= Hero Section ======= -->
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(client/images/Admin_Login_PC_V2_Bot-01.png);">
			            </div>
						<div class="login-wrap p-4 p-md-5">
                            <form action="{{ route('login') }}" class="signin-form" method="post">
                                @csrf
                                <div class="form-group mb-3">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3 text-md-center">SUBMIT</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-100 text-md-center">
                                        <a style="color:#ffffff;border-bottom: 1px solid white;" href="{{ route('password.request') }}">Forgot Password</a>
                                    </div>
                                </div>
                            </form>
		                    <p class="text-center" style="font-size: 12px;color:#ffffff;">Copyright © Vserve Ebusiness Solutions 2022.All Rights Reserved</p>
		                </div>
		            </div>
				</div>
			</div>
		</div>
	</section><!-- ======= Hero Section ======= -->	
    <script>
        $(document).ready(function() {
            $("#login_form").on("submit", function (e) {
                var email       = $("#email").val();
                var password    = $("#password").val();
                var email_pattern   = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                $(".error").empty();
                
                if(email.length < 1){
                    e.preventDefault();
                    $("#email").after('<div class="error">Email field is required</div>');
                }else if(!email_pattern.test(email)){
                    e.preventDefault();
                    $("#email").after('<div class="error">Invalid Email address</div>');
                }

                if(password.length < 1){
                    e.preventDefault();
                    $("#password").after('<div class="error">Password field is required</div>');
                }
            });
        });
    </script>
   </body>
</html>
