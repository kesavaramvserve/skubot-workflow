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
        .row{
            padding: 0 150px;
            margin-top: 10%;
        }
        .text-center{
            text-align: center;
        }
        .img-fluid{
            max-width: 20%;
        }
        
        .text{
            font-size : 20px;
            color:white !important;
        }
        .thanks{
            padding : 20px 30px 10px 20px;
            background-color: #ffffff;
            border-radius : 0 0 20px 20px;
        }
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
        <div class="row">
            <div class="col-12" style="text-align:center;">
                <h1 style="color:#c9eb7d">Greetings From Merch Metric!</h1>
                <p class="text">Thank you for reaching Merch Metric for content health check!.We reveived your Enhancement request for {{$mailData['website']}}.
                Our team is working on it. You will receive further update over another email once the result is generated.</p>
            </div>
        </div>
    </div>

</body>
</html>
