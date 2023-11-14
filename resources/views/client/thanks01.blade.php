<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('client/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('client/bootstrap/css/bootstrap.min.css')}}">
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
            width: 350px;
            height: 220px;
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
        .text-center{
            padding: 0px 10px 0px 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid main">
        <div class="content">
            <div class="text-center mt-3">
                <img src="{{asset('client/images/vserve-logo.png')}}" alt="logo" class="img-fluid mb-2">
                <p class="text">Thank you for reaching Merch Metric for content health check!
                        Our team is working on it. You will receive an email once the result is generated.</p>
            </div>
        </div>
    </div>
</body>
</html>