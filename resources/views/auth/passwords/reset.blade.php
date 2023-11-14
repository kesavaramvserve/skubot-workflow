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
    <style>
        .content{
            margin-top:12% !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 content">
                <!-- Logo -->
                <div class="text-center">
                    <img src="{{asset('images/MM-logo.png')}}" alt="MM-logo" class="image-responsive mm-logo">
                </div>
                <!-- Form Start -->
                <form method="POST" action="{{ route('password.update') }}" id="reset_form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3">
                        <label for="email" class="label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $email ?? old('email') }}" placeholder="mail@abc.com" >
                        @if($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="label">Password</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="********">
                        @if($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="" class="label">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm" placeholder="********">
                        @if($errors->has('password-confirm'))
                            <div class="error">{{ $errors->first('password-confirm') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="form-control submit-button" name="" id="" value="Reset Password">
                    </div>
                </form>
            </div>
            <div class="col-4">
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#reset_form").on("submit", function (e) {
                var email       = $("#email").val();
                var password    = $("#password").val();
                var cpassword    = $("#password-confirm").val();
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

                if(cpassword.length < 1){
                    e.preventDefault();
                    $("#password-confirm").after('<div class="error">Confirm Password field is required</div>');
                }
            });
        });
    </script>
</body>
</html>