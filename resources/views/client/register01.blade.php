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
            height: 500px;
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
            padding: 25px;
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
                <img src="{{asset('client/images/vserve-logo.png')}}" alt="logo" class="img-fluid">
                <p class="text">Fill in the form below to get details about your Site's Health Check</p>
                <form action="{{route('clients.store')}}" method="post" id="client_register">
                @csrf
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-4 text-right">
                            <div class="mb-2"><label for="">First Name<span style="color:red">*</span></label></div>
                        </div>
                        <div class="col-8 text-left">
                            <div class="mb-2"><input class="input" type="text" name="first_name" id="first_name" placeholder="John" value="{{old('first_name')}}"></div>
                            @if($errors->has('first_name'))
                            <div class="error">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                        <!-- Last Name -->
                        <div class="col-4 text-right">
                            <div class="mb-2"><label for="">Last Name</label></div>
                        </div>
                        <div class="col-8 text-left">
                            <div class="mb-2"><input class="input" type="text" name="last_name" id="last_name" placeholder="Doe" value="{{old('last_name')}}"></div>
                            @if($errors->has('last_name'))
                            <div class="error">{{ $errors->first('last_name') }}</div>
                            @endif
                        </div>
                        <!-- Email -->
                        <div class="col-4 text-right">
                            <div class="mb-2"><label for="">Email<span style="color:red">*</span></label></div>
                        </div>
                        <div class="col-8 text-left">
                            <div class="mb-2"><input class="input" type="email" name="email" id="email" placeholder="abc@abc.com" value="{{old('email')}}"></div>
                            @if($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <!-- Company -->
                        <div class="col-4 text-right">
                            <div class="mb-2"><label for="">Company<span style="color:red">*</span></label></div>
                        </div>
                        <div class="col-8 text-left">
                            <div class="mb-2"><input class="input" type="text" name="company_name" id="company_name" placeholder="John Pvt Ltd" value="{{old('company_name')}}"></div>
                            @if($errors->has('company_name'))
                            <div class="error">{{ $errors->first('company_name') }}</div>
                            @endif
                        </div>
                        <!-- Website URL -->
                        <div class="col-4 text-right">
                            <div class="mb-2"><label for="">Website URL<span style="color:red">*</span></label></div>
                        </div>
                        <div class="col-8 text-left">
                            <div class="mb-2"><input class="input" type="url" name="website" id="website" placeholder="https://website.com/" value="{{old('website')}}"></div>
                            @if($errors->has('website'))
                            <div class="error">{{ $errors->first('website') }}</div>
                            @endif
                        </div>
                        <!-- Agree -->
                        <div class="col-3 text-right">
                            <div class="mb-3"><input class="" type="checkbox" id="agree"></div>
                        </div>
                        <div class="col-9 text-left">
                            <div class="mb-3"><p id="agree_div" style="color:#4f64b6">I agree to the Terms & Conditions</p></div>
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
            var err_value           = 500;

            $(".error").empty();

            if(first_name.length < 1){
                $("#first_name").after('<span class="error">First Name field is required</span>');
                err_value = err_value + 20;
            }else if(first_name.length < 3){
                $("#first_name").after('<span class="error">The first name field must be at least 3 characters.</span>');
            }else if(!first_name_pattern.test(first_name)){
                $("#first_name").after('<span class="error">The first name field must not be alphabet characters.</span>');
                err_value = err_value + 20;
            }

            if(!first_name_pattern.test(last_name) && last_name.length > 1){
                $("#last_name").after('<span class="error">The Last name field must not be alphabet characters.</span>');
                err_value = err_value + 20;
            }

            if(email.length < 1){
                $("#email").after('<span class="error">Email field is required</span>');
                err_value = err_value + 20;
            }else if(!email_pattern.test(email)){
                $("#email").after('<span class="error">Invalid Email address</span>');
                err_value = err_value + 20;
            }

            if(company_name.length < 1){
                $("#company_name").after('<span class="error">Company Name field is required</span>');
                err_value = err_value + 20;
            }

            if(website.length < 1){
                $("#website").after('<span class="error">Website field is required</span>');
                err_value = err_value + 20;
            }else if(!url_pattern.test(website)){
                $("#website").after('<span class="error">Invalid Website address</span>');
                err_value = err_value + 20;
            }

            if(!agree){
                $("#agree_div").after('<span class="error">Please agree to the Terms and Conditions</span>');
                err_value = err_value + 20;
            }

            if(err_value > 500){
                e.preventDefault();
                $(".content").css("height", err_value+"px");
                $(".title").css("padding", "0 30px 0 30px");
            }
            
        });
    });
</script>

</body>
</html>