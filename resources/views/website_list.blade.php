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
    <!-- Data table CSS -->
	<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- Website Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/website_list.css') }}">
    <style>
        .multiselect-dropdown{
            width : 100% !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
    <?php $user_role = auth()->user()->getrole->name ?>
        <!-- Header Start -->
        <div class="row head-section">
            <div class="col-md-12 gen-padding">
                <div class="float-start">
                    <img src="{{asset('images/MM-logo.png')}}" alt="logo" width="100px" class="site-logo img-fluid">
                </div>
                <div class="float-end user-details">
                    <div class="row">
                        <div class="col-md-9 personal">
                            <div class="profile float-start">
                                <img src="{{asset('images/profile.png')}}" alt="profile" width="40px">
                            </div>
                            <div class="user">
                                @if(auth()->user()->getRole->name == 'Client')
                                    <h6 class="user-name mt-2">{{ auth()->user()->first_name }}</h6>
                                @else
                                    <h6 class="user-name">{{ auth()->user()->first_name }}</h6>
                                    <span class="user-role">({{ auth()->user()->getRole->name }})</span>
                                @endif
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

        <div class="row ">
            <div class="col-1"></div>
            <div class="main-section col-10">
                <!-- Table Heading -->
                <div class="row heading">
                    <div class="col-12">
                        <h4 class="float-start mt-2">Project List</h4>
                    </div>
                </div>
                <!-- Filters -->
                <div class="row filter-row">
                    <div class="col-3">
                        <select name="show" id="show" class="filter-select" style="width:50px">
                            <option value="10" selected>10</option> <!-- Default value -->
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        
                    </div>
                    
                    

                    <div class="col-9">
                        @if(auth()->user()->getrole->name != 'Client')
                        <!-- <select name="" id="" class="filter-select">
                            <option value="">Search Type</option>
                        </select> -->
                        @endif
                        <input type="search" id="search_filter" placeholder="Search" class="filter-search float-end">
                    </div>
                    
                </div>
                <!-- Table -->
                <div class="row table-row">
                    <div class="col-12 table-responsive">
                        <table class="data-table table  nowrap" style="width:100%">
                            <thead>
                                <th style="min-width:30px !important;">ID</th>
                                <!-- <th style="min-width:110px !important;">Client Name <img class="sort" src="{{asset('client/images/sort.png')}}"></th>
                                <th style="min-width:130px !important;">Client Email <img class="sort" src="{{asset('client/images/sort.png')}}"></th>
                                <th style="min-width:140px !important;">Company Name <img class="sort" src="{{asset('client/images/sort.png')}}"></th> -->
                                <th style="min-width:80px !important;">Project </th>
                                <th style="min-width:80px !important;">Role </th>
                                <th style="min-width:50px !important;">Action </th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
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
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Assign Users from TL login-->
    <div id="batch_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="batch_close">&times;</span>
            <div class="row">
                <form action="{{route('assign_users')}}" method="post" enctype="multipart/form-data" id="batch_form">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="batch_website_id">

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

<!-- Import Scrapped File from Scrapper Login-->
    <div id="import_scrapped_file_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="import_scrapped_file_close">&times;</span>
            <div class="row">
                <form action="{{route('scraper_upload')}}" method="post" enctype="multipart/form-data" id="import_scrapped_file_form">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="import_scrapped_file_website_id"> 
                    <div class="mb-3">
                        <label for="file">Import Scrapped File</label>
                        <input type="file" name="file" class="form-control" id="import_scrapped_file_input">
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

<!-- Data table JavaScript -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<!-- Multi Dropdown JS -->
<script src="{{ asset('js/multiselect-dropdown.js') }}"></script>

<!-- Render Table datas -->
<script type="text/javascript">
  $(function () {
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        pageLength: 10,
        responsive: true,
        ajax: {
            url: "{{ route('website_list.index') }}",
            data: function (d) {
                    d.validation_status_filter = $('#validation_status_filter').val(),
                    d.search_type_filter = $('#search_type_filter').val(),
                    d.search = $('input[type="search"]').val(),
                    d.show = $('#show').val()
                }
            },
        columns: [
            {data: 'id', name: 'id', orderable: true},
            // {data: 'client_name', name: 'first_name', orderable: true},
            // {data: 'client_email', name: 'email', orderable: true},
            // {data: 'company_name', name: 'company_name', orderable: true},
            {data: 'website', name: 'website', orderable: true},
            {data: 'role', name: 'role', orderable: true},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // search Filter
    $('#search_filter').keyup(function(){
        table.draw();
    });

    // SHow Filter
    $('#show').on('change', function() {
        var selectedLength = $(this).val();
        $('.data-table').DataTable().page.len(selectedLength).draw();
    });

    // search_type Filter
    $('#search_type_filter').change(function(){
        table.draw();
    });

  });
</script>

<script>
    // Support Import enhanced Data
    $(document).on("click",".import_client_file",function() {
        $("#myModal3").show();
        var website_id = $(this).attr('data-id');
        $("#website_id3").val(website_id);
    });
    // Support Form Submit(Enhanced Data)
    $("#support_enhance").on("submit", function (e) {
        var data = $("#fileinput3").val();
        $(".error").empty();
        // alert(data);
        if(data.length < 1){
            e.preventDefault();
            $("#fileinput3").after('<span class="error">This field is required </span>');
        }
    });
        // Support Close Button
    $(document).on("click",".close",function() {
        $("#support_enhance")[0].reset();
        $(".error").empty();
        $("#myModal3").hide();
    });

    // Import Scrapped File - On Click
    $(document).on("click",".import_scrapped_file",function() {
        $("#import_scrapped_file_modal").show();
        var website_id = $(this).attr('data-id');
        $("#import_scrapped_file_website_id").val(website_id);
    });
    // Import Scrapped File - Form Submit
    $("#import_scrapped_file_form").on("submit", function (e) {
        var data = $("#import_scrapped_file_input").val();
        $(".error").empty();
        // alert(data);
        if(data.length < 1){
            e.preventDefault();
            $("#import_scrapped_file_input").after('<span class="error">This field is required </span>');
        }
    });
    // Support Close Button
    $(document).on("click",".import_scrapped_file_close",function() {
        $("#import_scrapped_file_form")[0].reset();
        $(".error").empty();
        $("#import_scrapped_file_modal").hide();
    });


    // Open Batch Modal
    $(document).on("click",".assign_users",function() {
        $("#batch_modal").show();
        var website_id = $(this).attr('data-id');
        $("#batch_website_id").val(website_id);
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
        // Add status Value
        $(document).on("change","#role",function() {
        var role = $('#role').val();
        // alert(role)
        if(role == 'pa'){
            $('#status').empty();
            $('#status').append('<option value="">Select Status</option><option value="inprogress">In-progress</option><option value="rejected">QC Rejected</option><option value="completed">Completed</option>');
        }else if(role == 'qc'){
            $('#status').empty();
            $('#status').append('<option value="">Select Status</option><option value="inprogress">In-progress</option><option value="reworked">Rework Done</option><option value="completed">Completed</option>');
        }else if(role == 'qa'){
            $('#status').empty();
            $('#status').append('<option value="">Select Status</option><option value="inprogress">In-progress</option><option value="completed">Completed</option>');
        }
    });
    // Submit Batch Modal
    $("#batch_form").on("submit", function (e) {
        // e.preventDefault();
        var role    = $("#role").val();
        var status  = $("#status").val();
        $(".error").empty();
        // alert(status.length);
        if(role.length < 1){
            e.preventDefault();
            $("#role").after('<span class="error">This field is required </span>');
        }
        if(status.length < 1){
            e.preventDefault();
            $("#status").after('<span class="error">This field is required </span>');
        }
        
    });
        // Close Batch Modal
    $(document).on("click",".batch_close",function() {
        $("#batch_form")[0].reset();
        $(".error").empty();
        $("#batch_modal").hide();
    });
</script>

<script>
    $(document).on("change","#action-select",function() {
        var val = $(this).val();
        $("#"+val).trigger("click");
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
</script>

</body>
</html>