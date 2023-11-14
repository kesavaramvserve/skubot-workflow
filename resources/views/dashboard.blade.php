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
            height:15% !important;
        }
        .menu-row{
            margin: 25px;
            border: 1px solid black;
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
                                <span class="page-heading">User Menu</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div style="float: left;" class="mt-3">
                                <img src="{{asset('images/website.png')}}" alt="website" class="" width="50px">
                            </div>
                            <div style="float: left;width: 35%;margin-left:5%;" class="mt-2">
                                <span class=""><strong>Website</strong></span>
                                <span class=""><strong>{{$website_name}}</strong></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menus -->
                    <div class="row menu-row">
                        <div class="col-md-12 col-xs-12 pad-0">
                            <!-- PA Menu -->
                            @if(auth()->user()->getrole->name == 'PA' || auth()->user()->getrole->name == 'Team Lead')
                            <div class="row mb-2">
                                <div class="col-md-12 col-xs-12 text-center">
                                    <div class="bg-info text-dark first-row">
                                        PA Menu
                                    </div>
                                </div>
                                <!-- PA In Queue -->
                                @if(auth()->user()->getrole->name == 'Team Lead')
                                    <div class="col-md-4 col-xs-12 text-center mb-3 mt-3">
                                        <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="PA" data-status="inqueue" href="javascript:void(0)">PA Queue</a>
                                    </div>
                                @endif
                                <!-- PA In Progress -->
                                <div class="col-md-4 col-xs-12 text-center mb-3 mt-3">
                                    <a class="btn btn-progress select_batch" data-id="{{$website_id}}" data-role="PA" data-status="inprogress" href="javascript:void(0)">PA In Progress</a>
                                </div>
                                <!-- QC Rejected -->
                                <div class="col-md-4 col-xs-12 text-center mb-3 mt-3">
                                    <a class="btn btn-rejected select_batch" data-id="{{$website_id}}" data-role="PA" data-status="rejected" href="javascript:void(0)">QC Rejected</a>
                                </div>
                                <!-- PA Completed -->
                                @if(auth()->user()->getrole->name == 'PA')
                                    <div class="col-md-4 col-xs-12 text-center mb-3 mt-3">
                                        <a class="btn btn-completed select_batch" data-id="{{$website_id}}" data-role="PA" data-status="completed" href="javascript:void(0)">PA Completed</a>
                                    </div>
                                @endif
                            </div>
                            @endif
                            <!-- QC Menu -->
                            @if(auth()->user()->getrole->name == 'QC' || auth()->user()->getrole->name == 'Team Lead')
                                <div class="row mt-3 mb-2">
                                    <div class="col-md-12 col-xs-12 mb-3 text-center">
                                        <div class="bg-info text-dark">
                                            QC Menu
                                        </div>
                                    </div>
                                    <!-- QC In Queue -->
                                    @if(auth()->user()->getrole->name == 'Team Lead')
                                        <div class="col-md-4 col-xs-12 mb-3 text-center">
                                            <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="QC" data-status="inqueue" href="javascript:void(0)">QC Queue</a>
                                        </div>
                                    @endif
                                    <!-- QC In Progress -->
                                    <div class="col-md-4 col-xs-12 mb-3 text-center">
                                        <a class="btn btn-progress select_batch" data-id="{{$website_id}}" data-role="QC" data-status="inprogress" href="javascript:void(0)">QC In Progress</a>
                                    </div>
                                    <!-- QC Rework Done -->
                                    @if(auth()->user()->getrole->name == 'QC')
                                        <div class="col-md-4 col-xs-12 mb-3 text-center">
                                            <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QC" data-status="reworked" href="javascript:void(0)">Rework Done</a>
                                        </div>
                                    @endif
                                    <!-- QC Completed -->
                                    @if(auth()->user()->getrole->name == 'QC')
                                        <div class="col-md-4 col-xs-12 mb-3 text-center">
                                            <a class="btn btn-completed select_batch" data-id="{{$website_id}}" data-role="QC" data-status="completed" href="javascript:void(0)">QC Completed</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <!-- QA Menu -->
                            @if(auth()->user()->getrole->name == 'QA' || auth()->user()->getrole->name == 'Team Lead')
                            <div class="row mt-3 mb-2">
                                <div class="col-md-12 col-xs-12 mb-3 text-center">
                                    <div class="bg-info text-dark">
                                        QA Menu
                                    </div>
                                </div>
                                <!-- QA IN Queue -->
                                @if(auth()->user()->getrole->name == 'Team Lead')
                                    <div class="col-md-4 col-xs-12 mb-3 text-center">
                                        <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="QA" data-status="inqueue" href="javascript:void(0)">QA Queue</a>
                                    </div>
                                @endif
                                <div class="col-md-4 col-xs-12 mb-3 text-center">
                                    <a class="btn btn-progress select_batch" data-id="{{$website_id}}" data-role="QA" data-status="inprogress" href="javascript:void(0)">QA In Progress</a>
                                </div>
                                <!-- QA Completed -->
                                @if(auth()->user()->getrole->name == 'QA')
                                    <div class="col-md-4 col-xs-12 mb-3 text-center">
                                        <a class="btn btn-completed select_batch" data-id="{{$website_id}}" data-role="QA" data-status="completed" href="javascript:void(0)">QA Completed</a>
                                    </div>
                                @endif
                            </div>
                            @endif
                            <!-- Other Menu -->
                            @if(auth()->user()->getrole->name == 'Team Lead')
                            <div class="row mt-3 mb-2">
                                <div class="col-md-12 col-xs-12 mb-3 text-center">
                                    <div class="bg-info text-dark">
                                        Other Menu
                                    </div>
                                </div>
                                <!-- Completed Queue -->
                                <div class="col-md-4 col-xs-12 mb-3 text-center">
                                    <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="QA" data-status="completed" href="javascript:void(0)">Completed Queue</a>
                                </div>
                                <!-- Live Updated -->
                                <div class="col-md-4 col-xs-12 mb-3 text-center">
                                    <a class="btn btn-progress select_batch" data-id="{{$website_id}}" data-role="" data-status="updated" href="javascript:void(0)">Live Updated</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-1"></div>
            </div>
    </div>
<!-- Batch Modal-->
<div id="batch_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="batch_close">&times;</span>
            <div class="row">
                <form action="{{route('batch_list.store')}}" method="post" enctype="multipart/form-data" id="batch_form">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="batch_website_id"> 
                    <input type="hidden" name="role" value="" id="role">
                    <input type="hidden" name="status" value="" id="status">
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Submit Batch Modal
        $(document).on("click",".select_batch",function() {
            var website_id = $(this).attr('data-id');
            var role = $(this).attr('data-role');
            var status = $(this).attr('data-status');
            $("#batch_website_id").val(website_id);
            $("#role").val(role);
            $("#status").val(status);
            $("#batch_form").submit();
        });
    </script>
    
</body>
</html>