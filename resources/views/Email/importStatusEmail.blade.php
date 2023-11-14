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
            background-image:linear-gradient(45deg,rgba(8,83,156, 0.75),rgba(245,70,66, 0.75)), url(https://sivab3.sg-host.com/public/client/images/background.jpg);
            width: 100%;
        }
        .content{
            /* width: 100%; */
            /* height: 500px; */
            background-color: #ffffff;
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
        .img-fluid{
            max-width: 20%;
        }
        .title{
            color : rgba(8,83,156, 0.75);
            padding : 20px 30px 10px 20px;
            background-color: #ffffff;
            border-radius : 20px 20px 0 0;
        }
        .text{
            /* margin-top : 50px; */
            /* color : rgba(8,83,156, 0.75); */
            /* padding : 20px 30px 10px 20px; */
            text-align : center;
            font-size : 15px;
            /* text-indent: 85px; */
        }
        .thanks{
            padding : 20px 30px 10px 20px;
            background-color: #ffffff;
            border-radius : 0 0 20px 20px;
        }
        .view-button{
            text-decoration: none;
            background-color : blue;
            padding : 5px 15px 5px 15px;
            color : white;
            border-radius : 3px;
        }
    </style>
</head>
<body>
    <div class="container-fluid main">
        <br>
        <div class="row content">
            <div class="col-12 title">
                <h1>Import Status From Merch Metric!</h1>
                <p class="text">{{$mailData['content']}}</p>
            </div>
            <div class="col-12 mt-5 thanks">
                <p>Regards,</p>
                <h3>Merch Metric Team</h3>
                <img src="https://mmv1.vgrowsolutions.co/public/client/images/vserve-logo.png" alt="logo" class="img-fluid">
            </div>
        </div>
    </div>

</body>
</html>
