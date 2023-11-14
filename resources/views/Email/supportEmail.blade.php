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
        body {
            font-family: 'Poppins', sans-serif;
        }
        .main{
            height : 100vh;
            background-position: center;
            background-repeat:no-repeat;
            background-size: cover;
            background-image: url(https://members.merchmetric.com/public/images/background.jpg);
            width: 100%;
        }
        .content{
            /* width: 100%; */
            /* height: 500px; */
            /* background-color: #ffffff; */
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: 140px 50px 50px 50px;
            max-width: 100%;
            max-height: 100%;
            overflow: auto;
            border-radius : 20px;
        }
        .text-center{
            text-align: center;
        }
        .img-fluid{
            max-width: 20%;
        }
        .title{
            color : rgba(8,83,156, 0.75);
            padding : 20px 30px 10px 20px;
            /* background-color: #ffffff; */
            border-radius : 20px 20px 0 0;
        }
        .text{
            /* margin-top : 50px; */
            /* color : rgba(8,83,156, 0.75); */
            /* padding : 20px 30px 10px 20px; */
            /* text-align : justify; */
            font-size : 20px;
            /* text-indent: 85px; */
        }
        .thanks{
            padding : 20px 30px 10px 20px;
            background-color: #ffffff;
            border-radius : 0 0 20px 20px;
        }
        /* .cta-button{
            display: inline-block;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            color: #ffffff !important;
            background-color: #28a745;
            border-color: #28a745;
            text-decoration: none;
            margin-left:45%;
        }
        .cta-button:hover { background-color: #218838; } */
        .cta-button{
            text-decoration: none;
            background-color: #c9eb7d;
            border : 3px solid #c9eb7d;
            padding: 10px 25px;
            border-radius: 5px;
            color: #222222;
        }
        .cta-button:hover{
            text-decoration: none;
            background-color: #222222;
            border : 3px solid #c9eb7d;
            padding: 10px 25px;
            border-radius: 5px;
            color: #c9eb7d;
        }
    </style>
</head>
<body>
    <div class="container-fluid main">
        <br>
        <div class="row" style="margin-top: 10%;">
            <div class="col-12 text-center">
                <img src="https://members.merchmetric.com/public/images/MM-logo.png" alt="logo" class="img-fluid" width="100px">
                <h1 style="color:white">Greetings From Merch Metric!</h1>
                <h1 style="color:#c9eb7d">Hey {{ $mailData['first_name'] }},<br> you have successfully registered on MerchMetric.</h1>
                <p class="text" style="color:white">You clearly care about your product content being top notch and we’re here to<br> help you achieve just that.Click on the link below to complete the next step of the process.</p>
                
                <a href="https://members.merchmetric.com/login" class="cta-button">CLICK HERE</a>
            </div>
        </div>
    </div>

</body>
</html>
