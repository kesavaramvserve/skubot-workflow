<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merch Metric</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <!-- Report Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/set_range.css') }}">
    <style>
        .heading{
            height:18% !important;
        }
        .upload-row{
            margin: 25px;
            /* border: 1px solid black; */
            border-radius: 10px;
        }
        .pad-0{
            padding:0%;
        }
        .bg-info {
            background-color: #f7f7f7!important;
            height: 30px;
        }
        .first-row{
            border-radius: 10px 10px 0 0;
        }
        .btn-queue{
            background-color: #B2DCB8 !important;
        }
        .btn-progress{
            background-color: #FFE29A !important;
        }
        .btn-rejected{
            background-color: #FFD3D0 !important;
        }
        .btn-completed{
            background-color: #39BC86 !important;
        }
        @media (max-width: 844px) {
    
            .main-section{
                margin-top: 25% !important;
                height: 100%;
            }
            .gen-padding {
                padding: 5% 5%;
            }
            .site-logo{
                width: 75px;
            }
            .user-details {
                width: 270px;
            }
            .personal{
                display: none;
            }
            .page-heading-div {
                width: 45% !important;
            }
            .page-heading {
                font-size: 18px;
                margin-left: 20%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">

        <!-- Header Start -->
        <div class="row head-section">
            <div class="col-md-12 gen-padding">
                <div class="float-start">
                    <img src="{{asset('images/MM-logo.png')}}" alt="logo" width="100px" class="site-logo">
                </div>
                <div class="float-end user-details ignore-print">
                    <div class="row">
                        <div class="col-md-9 personal">
                            <div class="profile float-start">
                                <img src="{{asset('images/profile.png')}}" alt="profile" width="40px">
                            </div>
                            <div class="user">
                                <h6 class="user-name">{{ auth()->user()->first_name }}</h6>
                                <span class="user-role">({{ auth()->user()->getRole->name }})</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="logout float-end">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
        
            <!-- Main section 1 -->
            <div class="row mb-5">
                <div class="col-1"></div>
                <div class="main-section col-10">
                    <!-- Page Heading -->
                    <div class="row heading">
                        <!-- Back icon with Page heading -->
                        <div class="col-md-6 col-xs-12">
                            <div style="float: left;" class="mt-3">
                                <a href="{{route('website_list.index')}}"><img src="{{asset('images/back.png')}}" alt="Back" class="" width="35px"></a>
                            </div>
                            <div style="float: left;width: 35%;" class="mt-3 page-heading-div">
                                <span class="page-heading">Upload File</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            
                        </div>
                    </div>
                    
                    <!-- Menus -->
                    <div class="row upload-row">
                        <div class="col-12">
                            <form action="{{route('update_batches')}}" method="post" enctype="multipart/form-data" id="import_form">
                                @csrf
                                <div class="mb-3">
                                    <label for="file">Import File</label>
                                    <input type="file" name="file" class="form-control" id="fileinput">
                                </div>
                                <div class="mb-3 text-center">
                                    <input type="submit" class="btn submit-button">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-1"></div>
            </div>
    </div>

    <script>
        // Import Form Submit with Validation
        $("#import_form").on("submit", function (e) {
            var data = $("#fileinput").val();
            $(".error").empty();
            if(data.length < 1){
                e.preventDefault();
                $("#fileinput").after('<span class="error">This field is required </span>');
            }
        });
    </script>
</body>
</html>