<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{asset('client/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('client/bootstrap/css/bootstrap.min.css')}}">
    <script src="{{asset('client/bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('client/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
img.custom-header-logo {
    display: block;
    margin: auto;
}
.col-xs-12.col-md-5.register-custom-css {
    margin-top: 85px;
}

.col-sm-1.center-image {
  border-left: 1px solid #ffffff;
  height: 400px;
  margin-top: 93px;
}
.form-control{
	width: 65%;
	border-radius: 0.45rem;
	text-align: center;

}
.col-xs-12 {
    padding:0;
}
p.custom-tect-cls {
    color: white;
    text-align: center;
    margin-left: -63px;
    font-size: 19px;
    font-weight: 700;
    width: 390px;
}
h1.footer-custom {
    color: #d7dbeb;
    font-size: 14px;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    line-height: 120%;
    text-align: left;
    direction: ltr;
    font-weight: 700;
    letter-spacing: normal;
    margin-top: 0;
    margin-bottom: 0;
}
.bee-heading{
    margin-top: 1%;
    margin-top: 1%;
    margin-left:53%
}
.backg{
    background-image: url(client/images/register_BG-01.png);
    min-height:auto;
    background-position: center;
    background-repeat:no-repeat;
    background-size: cover;
}
@media (max-width : 480px) {
    .mobile_fix {
        padding:0;
    }
	.col-sm-1.center-image {
    display: none;
   }
   .col-xs-12.col-md-5.register-custom-css {
    margin-top: 0px;
   }
   p.custom-tect-cls {
    color: white;
    text-align: center;
    font-size: 19px;
    font-weight: 700;
  }
  .panel.panel-primary {
    margin-left: 100px;
}
h1.footer-custom {
margin-bottom: 27px;
    margin-left: 20px;
	}
	
}
.error{
    color: red;
    width: 100%;
}
.submit{
    background-color: #FEEC98;
    border: none;
    word-break: break-word;
    font-size: 17px;
    line-height: 150%;
    letter-spacing: 1px;
    color: #13182b;
    font-family: inherit;
    font-weight: 700;
    border-radius: 11px;
    border-top: 0px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 0px solid transparent;
    border-left: 0px solid transparent;
    color: #13182b;
    padding-top: 5px;
    padding-right: 25px;
    padding-bottom: 5px;
    padding-left: 25px;
    cursor: pointer;
}
</style>
</head>
<body>
   <div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
			    <img alt="Vserve Ebusiness Solutions" align="center" class="custom-header-logo" src="{{asset('client/images/vserve-logo.png')}}" style="max-width:293px;" />
			 </div>
		</div>
    </div>
            <!-- @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif -->
<div class="dashboard-form backg" style="">
 <div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-6">
			<img src="{{asset('client/images/Register_Bot-01.png')}}" width="150%" alt="SKUBOT">
		</div>
		<div class="col-sm-1 center-image"></div>
		<div class="col-xs-12 col-md-5 register-custom-css">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @else
			 <p class="custom-tect-cls">Fill in the form below to get details about your Site's Health Check</p>
             <form action="{{route('clients.store')}}" method="post" id="client_register">
               @csrf
				<div class="panel panel-primary" style="background: transparent;border: none;">
				  <div class="panel-body" >
					<div class="form-group row custom-pass-clss">
					 <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                     @if($errors->has('first_name'))
                        <div class="error">{{ $errors->first('first_name') }}</div>
                    @endif
					</div>
					<div class="form-group row custom-pass-clss">
					 <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                     @if($errors->has('last_name'))
                        <div class="error">{{ $errors->first('last_name') }}</div>
                    @endif
					</div>
					<div class="form-group row custom-pass-clss">
					<input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email" >
                    @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif
					</div>
					<div class="form-group row custom-pass-clss">
					<input type="text" name="company_name" id="company_name" class="form-control input-sm" placeholder="Company" >
                    @if($errors->has('company_name'))
                        <div class="error">{{ $errors->first('company_name') }}</div>
                    @endif
					</div>
					<div class="form-group row custom-pass-clss">
					<input type="url" name="website" id="website" class="form-control input-sm" placeholder="Website URL" >
                    @if($errors->has('website'))
                        <div class="error">{{ $errors->first('website') }}</div>
                    @endif
					</div>
					<div class="form-check checkbox-lg">
					    <input class="form-check-input" type="checkbox" value="" id="agree">
					    <label class="form-check-label" style="color:#ffffff;" for="agree">I agree to the T & C </label>
                        <div id="agree_div"></div>
                    </div><br>
					<div class="custom-sub-button">
                        <input type="submit" class="submit" value="SUBMIT">
					  <!-- <div class="bee-button-content" style="font-family: inherit; font-size: 17px; font-weight: 700; background-color: #feec98; border-radius: 11px; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; color: #13182b; padding-top: 5px; padding-right: 25px; padding-bottom: 5px; padding-left: 25px; width: auto; max-width: 100%; direction: ltr; letter-spacing: 1px; display: inline-block;"> -->
                        
                      <!-- <span dir="ltr" style="word-break: break-word; font-size: 17px; line-height: 150%; letter-spacing: 1px;">SUBMIT</span> -->
					  </div>
					</div>
				  </div>
				</div>
			</form><br>
            @endif
		     <div class="bee-block bee-block-4 bee-heading">
              <h1 class="footer-custom">Copyright © Vserve Ebusiness Solutions 2022.All Rights Reserved. </h1>
            </div>
		 </div>
		</div>
	 </div>
	</div>
    <script>
        $(document).ready(function() {
            $("#client_register").on("submit", function (e) {
                var first_name          = $("#first_name").val();
                var last_name           = $("#last_name").val();
                var email               = $("#email").val();
                var company_name        = $("#company_name").val();
                var website             = $("#website").val();
                var agree               = $("#agree").prop('checked');
                var first_name_pattern  = /^[a-zA-Z]+$/;
                var email_pattern       = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                var url_pattern         = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
                $(".error").empty();
                
                if(first_name.length < 1){
                    e.preventDefault();
                    $("#first_name").after('<div class="error">First Name field is required</div>');
                }else if(first_name.length < 3){
                    $("#first_name").after('<div class="error">The first name field must be at least 3 characters.</div>');
                }else if(first_name.length > 10){
                    $("#first_name").after('<div class="error">The first name field must not be greater than 10 characters.</div>');
                }else if(!first_name_pattern.test(first_name)){
                    e.preventDefault();
                    $("#first_name").after('<div class="error">The first name field must not be alphabet characters.</div>');
                }

                if(!first_name_pattern.test(last_name)){
                    e.preventDefault();
                    $("#last_name").after('<div class="error">The Last name field must not be alphabet characters.</div>');
                }

                if(email.length < 1){
                    e.preventDefault();
                    $("#email").after('<div class="error">Email field is required</div>');
                }else if(!email_pattern.test(email)){
                    e.preventDefault();
                    $("#email").after('<div class="error">Invalid Email address</div>');
                }

                if(company_name.length < 1){
                    e.preventDefault();
                    $("#company_name").after('<div class="error">Company Name field is required</div>');
                }

                if(website.length < 1){
                    e.preventDefault();
                    $("#website").after('<div class="error">Website field is required</div>');
                }else if(!url_pattern.test(website)){
                    e.preventDefault();
                    $("#website").after('<div class="error">Invalid Website address</div>');
                }

                if(!agree){
                    e.preventDefault();
                    $("#agree_div").append('<div class="error">Please agree to the Terms and Conditions</div>');
                }
            });
        });
    </script>
   </body>
</html>