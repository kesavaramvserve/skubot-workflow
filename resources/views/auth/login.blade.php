<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Merch Metric</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 content">
                <!-- Logo -->
                <div class="text-center">
                    <img src="{{asset('images/MM-logo.png')}}" alt="MM-logo" class="image-responsive mm-logo">
                </div>
                <!-- Heading -->
                <div class="mt-3 text-center">
                    <h4 class="login-heading">Login to your Account</h4>
                </div>
                <!-- Sub Heading -->
                <div class="mt-3 text-center">
                    <p class="login-sub-heading">See what is going on with your business</p>
                </div>
                <!-- Form Start -->
                <form action="{{ route('login') }}" method="post" id="login_form">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" placeholder="mail@abc.com" >
                        @if($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}" placeholder="********" >
                        @if($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <span class="float-start login-sub-heading"><input style="float: left;" type="checkbox"><span style="margin-left: 5px;">Remember Me</span></span>
                        <a href="{{ route('password.request') }}" class="float-end login-sub-heading">Forgot Password</a>
                    </div>
                    <div class="mb-3 mt-5">
                        <input type="submit" class="form-control submit-button" name="" id="" value="Login" required>
                    </div>
                </form>
                <!-- Create an account -->
                <div class="mb-3 text-center">
                    <p style="color: white;font-size: 12px;">Not registered yet? <a href="{{route('client_register')}}" style="color: #C8EB7D;text-decoration: none;"> Create an account</a></p>
                </div>
            </div>
            <div class="col-4">
            </div>
        </div>
    </div>
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