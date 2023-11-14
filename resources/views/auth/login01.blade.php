<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('client/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('client/bootstrap/css/bootstrap.min.css')}}">
    <script src="{{asset('client/bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('client/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Merch Metric</title>
    <style>
        .main{
            height : 100vh;
            background-position: center;
            background-repeat:no-repeat;
            background-size: cover;
            background-image:linear-gradient(45deg,rgba(8,83,156, 0.75),rgba(245,70,66, 0.75)), url(client/images/background.jpg);
            width: 100%;
        }
        .content{
            width: 400px;
            height: 350px;
            background-color: #ffffff;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            max-width: 100%;
            max-height: 100%;
            overflow: auto;
            border-radius : 20px;
        }
        .img-fluid{
            max-width: 50%;
        }
        .text{
            color : #4f64b6;
            font-weight: 500;
        }
        .title{
            padding: 30px 30px 10px 30px;
        }
        .input{
            width:100%;
            border-radius: 5px;
            border: solid 1.5px #D3D3D3;
            box-shadow: 2px 2px 2px #D3D3D3;
            outline-width: 0px;
        }
        .submit-btn{
            background-color : #e48f3e;
            padding : 2px 40px 2px 40px;
            border : none;
            border-radius : 7px;
            color : #ffffff;
            font-weight : bold 500;
            cursor : pointer;
        }
        .error{
            color: red;
            width: 100%;
            /* font-size: 10px; */
        }   
    </style>
</head>
<body>
    <div class="container-fluid main">
        <div class="content">
            <div class="text-center title">
                <img src="{{asset('client/images/vserve-logo.png')}}" alt="logo" class="img-fluid mb-2">
                <!-- <p class="text">Fill in the form below to get details about your Site's Health Check</p> -->
                <form action="{{ route('login') }}" method="post" id="login_form">
                @csrf
                    <div class="row">
                        <!-- Email -->
                        <div class="col-4 text-right">
                            <div class="mb-2"><label for="">Email<span style="color:red">*</span></label></div>
                        </div>
                        <div class="col-8 text-left">
                            <div class="mb-2"><input class="input" type="email" name="email" id="email" placeholder="abc@abc.com"></div>
                            @if($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <!-- Password -->
                        <div class="col-4 text-right">
                            <div class="mb-2"><label for="">Password<span style="color:red">*</span></label></div>
                        </div>
                        <div class="col-8 text-left">
                            <div class="mb-2"><input class="input" type="password" name="password" id="password" placeholder="********"></div>
                            @if($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <!-- Forgot Password -->
                        <div class="col-12 text-center">
                            <div class="mb-3"><a href="{{ route('password.request') }}">Forgot Password</a></div>
                        </div>
                        <!-- Submit -->
                        <div class="col-12 text-center">
                            <input class="submit-btn" type="submit" value="SUBMIT">
                        </div>
                    </div>
                </form>
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