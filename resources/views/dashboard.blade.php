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
    <style>
        .multiselect-dropdown{
            width : 100% !important;
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
                                <span class=""><strong>Website</strong></span><br>
                                <span class="">{{$website_name}}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menus -->
                    <div class="row menu-row">
                        <div class="col-md-12 col-xs-12 pad-0">
                            <!-- TL Menu -->
                            @if($project_role == 'Team Lead')
                            <div class="row mb-2">
                                <div class="col-md-12 col-xs-12 text-center">
                                    <div class="bg-info text-dark first-row">
                                        TL Menu
                                    </div>
                                </div>
                                <!-- Import Client File -->
                                <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                    <a class="btn btn-queue import_client_file" data-id="{{$website_id}}" href="javascript:void(0)">Import</a>
                                </div>
                                <!-- Project Settings -->
                                <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                    <a class="btn btn-progress project_settings"
                                        data-id="{{ $data[0]->id }}"
                                        data-platform="{{ $data[0]->platform }}"
                                        data-workflow-settings="{{ $data[0]->workflow_settings }}"
                                        data-platform-details="{{ $data[0]->platform_details }}"
                                        data-project-status="{{ $data[0]->project_status }}" 
                                        data-reason="{{ $data[0]->reason }}"
                                        data-download-image="{{ $data[0]->download_image }}"
                                        data-download-asset="{{ $data[0]->download_asset }}"
                                        data-time-track="{{ $data[0]->time_track }}"
                                        data-project-name="{{ $data[0]->website }}" 
                                      href="javascript:void(0)">Project Settings</a>
                                </div>
                                <!-- Assign Users -->
                                <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                    <a class="btn btn-rejected assign_users" data-id="{{$website_id}}" href="javascript:void(0)">Assign Users</a>
                                </div>
                                <!-- View Client Files -->
                                <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                    <?php $enc_id = Crypt::encryptString($website_id); ?>
                                    <a class="btn btn-completed" data-id="{{$website_id}}" href="{{route('website_list.view_client_files',$enc_id)}}">View Client Files</a>
                                </div>
                            </div>
                            @endif
                            <!-- PA Menu -->
                            @if($project_role == 'PA' || $project_role == 'Team Lead')
                            <div class="row mb-2">
                                <div class="col-md-12 col-xs-12 text-center">
                                    <div class="bg-info text-dark first-row">
                                        PA Menu
                                    </div>
                                </div>
                                <!-- PA In Queue -->
                                @if($project_role == 'Team Lead')
                                    <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                        <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="PA" data-status="inqueue" href="javascript:void(0)">PA Queue</a>
                                    </div>
                                @endif
                                <!-- PA In Progress -->
                                <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                    <a class="btn btn-progress select_batch" data-id="{{$website_id}}" data-role="PA" data-status="inprogress" href="javascript:void(0)">PA In Progress</a>
                                </div>
                                <!-- QC Rejected -->
                                <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                    <a class="btn btn-rejected select_batch" data-id="{{$website_id}}" data-role="PA" data-status="rejected" href="javascript:void(0)">QC Rejected</a>
                                </div>
                                <!-- PA Completed -->
                                @if($project_role == 'PA')
                                    <div class="col-md-3 col-xs-12 text-center mb-3 mt-3">
                                        <a class="btn btn-completed select_batch" data-id="{{$website_id}}" data-role="PA" data-status="completed" href="javascript:void(0)">PA Completed</a>
                                    </div>
                                @endif
                            </div>
                            @endif
                            <!-- QC Menu -->
                            @if($project_role == 'QC' || $project_role == 'Team Lead')
                                <div class="row mt-3 mb-2">
                                    <div class="col-md-12 col-xs-12 mb-3 text-center">
                                        <div class="bg-info text-dark">
                                            QC Menu
                                        </div>
                                    </div>
                                    <!-- QC In Queue -->
                                    @if($project_role == 'Team Lead')
                                        <div class="col-md-3 col-xs-12 mb-3 text-center">
                                            <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="QC" data-status="inqueue" href="javascript:void(0)">QC Queue</a>
                                        </div>
                                    @endif
                                    <!-- QC In Progress -->
                                    <div class="col-md-3 col-xs-12 mb-3 text-center">
                                        <a class="btn btn-progress select_batch" data-id="{{$website_id}}" data-role="QC" data-status="inprogress" href="javascript:void(0)">QC In Progress</a>
                                    </div>
                                    <!-- QC Rework Done -->
                                    @if($project_role == 'QC')
                                        <div class="col-md-3 col-xs-12 mb-3 text-center">
                                            <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QC" data-status="reworked" href="javascript:void(0)">Rework Done</a>
                                        </div>
                                    @endif
                                    <!-- QC Completed -->
                                    @if($project_role == 'QC')
                                        <div class="col-md-3 col-xs-12 mb-3 text-center">
                                            <a class="btn btn-completed select_batch" data-id="{{$website_id}}" data-role="QC" data-status="completed" href="javascript:void(0)">QC Completed</a>
                                        </div>
                                    @endif
                                    <!-- QC Import Enhance File -->
                                    @if($project_role == 'QC')
                                        <div class="col-md-3 col-xs-12 mb-3 text-center">
                                            <a class="btn btn-rejected import_enhance_file" data-id="{{$website_id}}" href="javascript:void(0)">Import</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <!-- QA Menu -->
                            @if($project_role == 'QA' || $project_role == 'Team Lead')
                            <div class="row mt-3 mb-2">
                                <div class="col-md-12 col-xs-12 mb-3 text-center">
                                    <div class="bg-info text-dark">
                                        QA Menu
                                    </div>
                                </div>
                                <!-- QA IN Queue -->
                                @if($project_role == 'Team Lead')
                                    <div class="col-md-3 col-xs-12 mb-3 text-center">
                                        <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="QA" data-status="inqueue" href="javascript:void(0)">QA Queue</a>
                                    </div>
                                @endif
                                <div class="col-md-3 col-xs-12 mb-3 text-center">
                                    <a class="btn btn-progress select_batch" data-id="{{$website_id}}" data-role="QA" data-status="inprogress" href="javascript:void(0)">QA In Progress</a>
                                </div>
                                <!-- QA Completed -->
                                @if($project_role == 'QA')
                                    <div class="col-md-3 col-xs-12 mb-3 text-center">
                                        <a class="btn btn-completed select_batch" data-id="{{$website_id}}" data-role="QA" data-status="completed" href="javascript:void(0)">QA Completed</a>
                                    </div>
                                @endif
                                <!-- QA Import Enhance File -->
                                @if($project_role == 'QA')
                                    <div class="col-md-3 col-xs-12 mb-3 text-center">
                                        <a class="btn btn-rejected import_enhance_file" data-id="{{$website_id}}" href="javascript:void(0)">Import</a>
                                    </div>
                                @endif
                            </div>
                            @endif
                            <!-- Other Menu -->
                            @if($project_role == 'Team Lead')
                            <div class="row mt-3 mb-2">
                                <div class="col-md-12 col-xs-12 mb-3 text-center">
                                    <div class="bg-info text-dark">
                                        Other Menu
                                    </div>
                                </div>
                                <!-- Completed Queue -->
                                <div class="col-md-3 col-xs-12 mb-3 text-center">
                                    <a class="btn btn-queue select_batch" data-id="{{$website_id}}" data-role="QA" data-status="completed" href="javascript:void(0)">Completed Queue</a>
                                </div>
                                <!-- Live Updated -->
                                <div class="col-md-3 col-xs-12 mb-3 text-center">
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
                <form action="{{route('batch_list.index')}}" method="get" enctype="multipart/form-data" id="batch_form">
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

    <!-- Import Client File from TL Login-->
    <div id="myModal3" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="row">
                <form action="{{route('import_client_file')}}" method="post" enctype="multipart/form-data" id="support_enhance">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="website_id3"> 
                    <div class="mb-3">
                        <label for="file">Import File</label>
                        <input type="file" name="file" class="form-control" id="fileinput3">
                    </div>
                    <div class="mb-3">
                        <label for="notes">Notes</label>
                        <input type="text" name="notes" class="form-control" id="notes">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Project Settings Modal -->
    <div id="project_settings" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="project_settings_close">&times;</span>
            <div class="row">
                <form action="{{route('project_settings')}}" method="post" enctype="multipart/form-data" id="project_settings_form">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="project_settings_website_id"> 
                    <!-- Project Name -->
                    <div class="mb-3">
                        <label for="project_name"><strong>Project Name</strong></label>
                        <input type="text" class="form-control" name="project_name" id="project_name" readonly>
                    </div>
                    <!-- Platform -->
                    <div class="mb-3">
                        <label for="platform"><strong>Platform</strong></label>
                        <select name="platform" id="platform" class="form-control">
                            <option value="">select Platform</option>
                            <option value="wordpress">Wordpress</option>
                            <option value="shopify">Shopify</option>
                            <option value="megento">Megento</option>
                            <option value="bigcommerce">Bigcommerce</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div id="platform_details_div">

                    </div>
                    <!-- Workflow Settings -->
                    <div class="mb-3">
                        <label for="workflow_settings"><strong>Workflow Settings</strong></label>
                        <select name="workflow_settings" id="workflow_settings" class="form-control">
                            <option value="">select Workflow Settings</option>
                            <option value="single">Single</option>
                            <option value="bulk">Bulk</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                    <!-- Project Status -->
                    <div class="mb-3">
                        <label for="project_status"><strong>Project Status</strong></label>
                        <select name="project_status" id="project_status" class="form-control">
                            <option value="">select Project Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div id="reason_div">

                    </div>
                    <!-- Download Image -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-3">
                                <label for="workflow_settings"><strong>Download Image</strong></label>
                            </div>
                            <div class="col-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="download_image" id="download_image1" value="1">
                                    <label class="form-check-label" for="download_image1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline" id="download_image">
                                    <input class="form-check-input" type="radio" name="download_image" id="download_image2" value="0">
                                    <label class="form-check-label" for="download_image2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Download Asset -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-3">
                                <label for="workflow_settings"><strong>Download Asset</strong></label>
                            </div>
                            <div class="col-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="download_asset" id="download_asset1" value="1">
                                    <label class="form-check-label" for="download_asset1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline" id="download_asset">
                                    <input class="form-check-input" type="radio" name="download_asset" id="download_asset2" value="0">
                                    <label class="form-check-label" for="download_asset2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Time Track -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-3">
                                <label for="time_track"><strong>Time Track</strong></label>
                            </div>
                            <div class="col-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="time_track" id="time_track1" value="1">
                                    <label class="form-check-label" for="time_track1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline" id="time_track">
                                    <input class="form-check-input" type="radio" name="time_track" id="time_track2" value="0">
                                    <label class="form-check-label" for="time_track2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Assign Users from TL login-->
    <div id="assign_users_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="assign_users_close">&times;</span>
            <div class="row">
                <form action="{{route('assign_users')}}" method="post" enctype="multipart/form-data" id="assign_users_form">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="assign_users_website_id">

                    <!-- Select Scrapper -->
                    <div class="mb-3">
                        <label for="scrapper">Select Scrapper</label>
                        <select name="scrapper[]" id="scrapper" class="form-control" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)">
                            @foreach($other_user_list as $other_user_lists)
                                <option value="{{$other_user_lists->id}}" >{{$other_user_lists->first_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Select PA -->
                    <div class="mb-3">
                        <label for="pa">Select PA</label>
                        <select name="pa[]" id="pa" class="form-control" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)">
                            @foreach($other_user_list as $other_user_lists)
                                <option value="{{$other_user_lists->id}}" >{{$other_user_lists->first_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select QC -->
                    <div class="mb-3">
                        <label for="qc">Select QC</label>
                        <select name="qc[]" id="qc" class="form-control" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)">
                            @foreach($other_user_list as $other_user_lists)
                                <option value="{{$other_user_lists->id}}" >{{$other_user_lists->first_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select QA -->
                    <div class="mb-3">
                        <label for="qa">Select QA</label>
                        <select name="qa[]" id="qa" class="form-control" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)">
                            @foreach($other_user_list as $other_user_lists)
                                <option value="{{$other_user_lists->id}}" >{{$other_user_lists->first_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Enhance File -->
    <div id="import_enhance_file_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="import_enhance_file_close">&times;</span>
            <div class="row">
                <form action="{{route('update_batches')}}" method="post" enctype="multipart/form-data" id="import_enhance_file_form">
                    @csrf
                    <input type="hidden" name="website_id" id="import_enhance_file_website_id">
                    <div class="mb-3">
                        <label for="file">Import File</label>
                        <input type="file" name="file" class="form-control" id="import_enhance_file_input">
                    </div>
                    <div class="mb-3 text-center">
                        <input type="submit" class="btn submit-button">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Multi Dropdown JS -->
    <script src="{{ asset('js/multiselect-dropdown.js') }}"></script>
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

        // Import Client File Open
        $(document).on("click",".import_client_file",function() {
            $("#myModal3").show();
            var website_id = $(this).attr('data-id');
            $("#website_id3").val(website_id);
        });

        // Import Client File Form Submit
        $("#support_enhance").on("submit", function (e) {
            var data = $("#fileinput3").val();
            $(".error").empty();
            if(data.length < 1){
                e.preventDefault();
                $("#fileinput3").after('<span class="error">This field is required </span>');
            }
        });

        // Import Client File Close
        $(document).on("click",".close",function() {
            $("#support_enhance")[0].reset();
            $(".error").empty();
            $("#myModal3").hide();
        });

        // Project Settings Modal Open
        $(document).on("click",".project_settings",function() {
            $("#project_settings").show();
            var website_id = $(this).attr('data-id');  
            var platform = $(this).attr('data-platform');
            var platform_details = $(this).attr('data-platform-details');
            var workflow_settings = $(this).attr('data-workflow-settings');
            var project_status = $(this).attr('data-project-status');
            var reason = $(this).attr('data-reason');
            var download_image = $(this).attr('data-download-image');
            var download_asset = $(this).attr('data-download-asset');
            var time_track = $(this).attr('data-time-track');
            var project_name = $(this).attr('data-project-name');

            $("#project_settings_website_id").val(website_id);
            $("#project_name").val(project_name);
            $('select[name^="platform"] option[value="'+platform+'"]').attr("selected","selected");
            $('select[name^="workflow_settings"] option[value="'+workflow_settings+'"]').attr("selected","selected");
            $('select[name^="project_status"] option[value="'+project_status+'"]').attr("selected","selected");
            if(platform_details){
                $("#platform_details_div").append('<div class="mb-3"><label for="platform_details"><strong>Platform Details</strong></label><input type="text" class="form-control" name="platform_details" value="'+platform_details+'" id="platform_details" required></div>');
            }
            if(reason){
                $("#reason_div").append('<div class="mb-3"><label for="reason"><strong>Reason</strong></label><select name="reason" id="reason" class="form-control" required><option value="">select Reason</option><option value="completed">Completed</option><option value="closed">Closed</option><option value="canceled">Canceled</option></select></div>');
                $('select[name^="reason"] option[value="'+reason+'"]').attr("selected","selected");
            }

            $('input[name=download_image][value="'+download_image+'"]').prop('checked', true);
            $('input[name=download_asset][value="'+download_asset+'"]').prop('checked', true);
            $('input[name=time_track][value="'+time_track+'"]').prop('checked', true);
        });

        // Platform on change
        $(document).on("change","#platform",function() {
            var platform = $(this).val();
            if(platform == 'other'){
                $("#platform_details_div").append('<div class="mb-3"><label for="platform_details"><strong>Platform Details</strong></label><input type="text" class="form-control" name="platform_details" id="platform_details" required></div>');
            }else{
                $("#platform_details_div").empty();
            }
        });

        // Project Status on change
        $(document).on("change","#project_status",function() {
            var project_status = $(this).val();
            if(project_status == 0){
                $("#reason_div").append('<div class="mb-3"><label for="reason"><strong>Reason</strong></label><select name="reason" id="reason" class="form-control" required><option value="">select Reason</option><option value="completed">Completed</option><option value="closed">Closed</option><option value="canceled">Canceled</option></select></div>');
            }else{
                $("#reason_div").empty();
            }
        });

        // Project Settings Validation
        $("#project_settings").on("submit", function (e) {
            var platform            = $("#platform").val();
            var workflow_settings   = $("#workflow_settings").val();
            var project_status      = $("#project_status").val();
            var download_image      = $("input[name=download_image]").is(":checked");
            var download_asset      = $("input[name=download_asset]").is(":checked");
            var time_track          = $("input[name=time_track]").is(":checked");
            
            $(".error").empty();
            if(platform.length < 1){
                e.preventDefault();
                $("#platform").after('<span class="error">This field is required </span>');
            }
            if(workflow_settings.length < 1){
                e.preventDefault();
                $("#workflow_settings").after('<span class="error">This field is required </span>');
            }
            if(project_status.length < 1){
                e.preventDefault();
                $("#project_status").after('<span class="error">This field is required </span>');
            }
            if(!download_image){
                e.preventDefault();
                $("#download_image").after('<span class="error">This field is required </span>');
            }
            if(!download_asset){
                e.preventDefault();
                $("#download_asset").after('<span class="error">This field is required </span>');
            }
            if(!time_track){
                e.preventDefault();
                $("#time_track").after('<span class="error">This field is required </span>');
            }
        });

        // project settings _close Close Button
        $(document).on("click",".project_settings_close",function() {
            $("#project_settings").hide();
            $(".error").empty();
            $("#project_settings_form")[0].reset();
        });

        // Open assign_users Modal
        $(document).on("click",".assign_users",function() {
            $("#assign_users_modal").show();
            var website_id = $(this).attr('data-id');
            $("#assign_users_website_id").val(website_id);
            $.ajax({
                url: '/get_scrapper_list', // Replace with your Laravel endpoint URL
                method: 'GET',
                data: {
                    // Data to be sent in the request body (if needed)
                    key2: website_id,
                },
                success: function(response){
                    // Handle the successful response from the server
                    console.log(response);
                    let selectedOptions = response; // Array of values to be selected

                    selectedOptions.forEach(value => {
                        console.log(value);
                        $('select[id^="scrapper"] option[value="'+value+'"]').prop('selected', true);
                    });
                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                }
            });

            $.ajax({
                url: '/get_pa_list', // Replace with your Laravel endpoint URL
                method: 'GET',
                data: {
                    // Data to be sent in the request body (if needed)
                    key2: website_id,
                },
                success: function(response){
                    // Handle the successful response from the server
                    console.log(response);
                    let selectedOptions = response; // Array of values to be selected

                    selectedOptions.forEach(value => {
                        console.log(value);
                        $('select[id^="pa"] option[value="'+value+'"]').prop('selected', true);
                    });
                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                }
            });

            $.ajax({
                url: '/get_qc_list', // Replace with your Laravel endpoint URL
                method: 'GET',
                data: {
                    // Data to be sent in the request body (if needed)
                    key2: website_id,
                },
                success: function(response){
                    // Handle the successful response from the server
                    console.log(response);
                    let selectedOptions = response; // Array of values to be selected

                    selectedOptions.forEach(value => {
                        console.log(value);
                        $('select[id^="qc"] option[value="'+value+'"]').prop('selected', true);
                    });
                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                }
            });

            $.ajax({
                url: '/get_qa_list', // Replace with your Laravel endpoint URL
                method: 'GET',
                data: {
                    // Data to be sent in the request body (if needed)
                    key2: website_id,
                },
                success: function(response){
                    // Handle the successful response from the server
                    console.log(response);
                    let selectedOptions = response; // Array of values to be selected

                    selectedOptions.forEach(value => {
                        console.log(value);
                        $('select[id^="qa"] option[value="'+value+'"]').prop('selected', true);
                    });
                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                }
            });
        });

        // Close assign_users Modal
        $(document).on("click",".assign_users_close",function() {
            $("#assign_users_form")[0].reset();
            $(".error").empty();
            $("#assign_users_modal").hide();
        });

        // Import Client File Open
        $(document).on("click",".import_enhance_file",function() {
            $("#import_enhance_file_modal").show();
            var website_id = $(this).attr('data-id');
            $("#import_enhance_file_website_id").val(website_id);
        });

        // Import Client File Form Submit
        $("#import_enhance_file_form").on("submit", function (e) {
            var data = $("#import_enhance_file_input").val();
            $(".error").empty();
            if(data.length < 1){
                e.preventDefault();
                $("#import_enhance_file_input").after('<span class="error">This field is required </span>');
            }
        });

        // Import Client File Close
        $(document).on("click",".import_enhance_file_close",function() {
            $("#import_enhance_file_form")[0].reset();
            $(".error").empty();
            $("#import_enhance_file_modal").hide();
        });

    </script>
    
</body>
</html>