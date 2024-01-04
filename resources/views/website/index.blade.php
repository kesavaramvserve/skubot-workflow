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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Website Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/website_list.css') }}">
    <style>
        .multiselect-dropdown{
            width : 100% !important;
        }
        .select2-container{
            width : 100% !important;
        }
        #tl {
            height: 35px !important;
            border: 1px solid #ddd !important;
            padding-left: 10px !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
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
                    <div class="col-md-4 col-xs-4 mb-3">
                        <select name="show" id="show" class="filter-select" style="width:25%">
                            <option value="10" selected>10</option> <!-- Default value -->
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <select name="validation_status_filter" id="validation_status_filter" class="filter-select" style="width:70%">
                            <option value="">Validation Status</option>
                            <option value="Valid">Valid</option>
                            <option value="Invalid">Invalid</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        
                    </div>

                    <div class="col-md-4 col-xs-8 mb-3">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 mb-3">
                                <select name="search_type_filter" id="search_type_filter" class="filter-select" style="width:100%">
                                    <option value="">Search Type</option>
                                    <option value="client_name">Client Name</option>
                                    <option value="client_email">Client Email</option>
                                    <option value="company_name">Company Name</option>
                                    <option value="website">Website</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <input type="search" placeholder="Search" name="search_filter" id="search_filter" class="filter-search float-end" style="width:100%">
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <!-- Table -->
                <div class="row table-row">
                    <div class="col-12 table-responsive">
                        <table class="data-table table  nowrap" style="width:100%">
                            <thead>
                                <th style="min-width:30px !important;">ID</th>
                                <th style="min-width:110px !important;">Client Name </th>
                                <th style="min-width:130px !important;">Client Email </th>
                                <th style="min-width:140px !important;">Company Name </th>
                                <th style="min-width:80px !important;">Project </th>
                                <th style="min-width:50px !important;">Action </th>
                                <th style="min-width:100px !important;">Import Status </th>
                                <th style="min-width:100px !important;">Val. Status </th>
                                <th style="min-width:95px !important;">Data History </th>
                                <th style="min-width:100px !important;">Created at </th>
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

<!-- The Scraper Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span class="close">&times;</span>
    <div class="row">
        <form action="{{route('scraper_upload')}}" method="post" enctype="multipart/form-data" id="scraper_data">
            @csrf
            <input type="hidden" name="website_id" value="" id="website_id"> 
            <div class="mb-3">
                <label for="file">Scrap File</label>
                <input type="file" name="file" class="form-control" id="fileinput">
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    </div>
</div>

<!-- The Support Modal (Scrape data import)-->
<div id="myModal2" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span class="close">&times;</span>
    <div class="row">
        <form action="{{route('import_scrape_data')}}" method="post" enctype="multipart/form-data" id="support_import">
            @csrf
            <input type="hidden" name="website_id" value="" id="website_id2"> 
            <div class="mb-3">
                <label for="file">Import File</label>
                <input type="file" name="file" class="form-control" id="fileinput2">
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    </div>
</div>

<!-- The Support Modal (enhance data import)-->
<div id="myModal3" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span class="close">&times;</span>
    <div class="row">
        <form action="{{route('enhance_data')}}" method="post" enctype="multipart/form-data" id="support_enhance">
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

<!-- Data History View-->
<div id="myModal4" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="row">
            <div class="col-9">
                <h2>Data History</h2>
            </div>
            <div class="col-3">
                <span class="history-close">&times;</span>
            </div>
            <div class="col-12 table-section table-responsive">
                <table class="history-table">
                    <thead>
                        <th class="modal-head1 first_head">Action</th>
                        <th class="modal-head2 last_head text-center">Updated at</th>
                    </thead>
                    <tbody id="history-data">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- The Validate Modal -->
<div id="myModal5" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span class="close5">&times;</span>
    <div class="row">
        <form action="{{route('validate_website')}}" method="post" enctype="multipart/form-data" id="validate_form">
            @csrf
            <input type="hidden" name="website_id" value="" id="validate_website_id"> 
            <div class="mb-3">
                <label for="validation_status">Validation Status</label>
                <select name="validation_status" id="validation_status" class="form-control">
                    <option value="">Select Validation Status</option>
                    <option value="Valid">Valid</option>
                    <option value="Invalid">Invalid</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="remark">Remark:</label>
                <textarea name="remark" id="remark" cols="" rows="3" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    </div>
</div>

<!-- The Add More Websites Modal -->
<div id="myModal6" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span class="close6">&times;</span>
    <div class="row">
        <form action="{{route('add_more')}}" method="post" enctype="multipart/form-data" id="add_more_form">
            @csrf
            <input type="hidden" name="website_id" value="" id="add_more_website_id"> 
            <div class="mb-3">
                <label for="website">Website</label>
                <input type="text" class="form-control" name="website" id="website" placeholder="https://website.com/">
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    </div>
</div>

<!-- Assign Tl Modal -->
<div id="assign_tl" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="assign_tl_close">&times;</span>
        <div class="row">
            <form action="{{route('assign_tl')}}" method="post" enctype="multipart/form-data" id="assign_tl_form">
                @csrf
                <input type="hidden" name="website_id" value="" id="assign_tl_website_id"> 
                <!-- Team Lead -->
                <div class="mb-3">
                    <label for="tl"><strong>Select Team Lead</strong></label>
                    
                    <select name="tl" id="tl" class="form-control">
                        <option value="">Select TL</option>
                        @foreach($team_lead_list as $team_lead_lists)
                        <option value="{{$team_lead_lists->id}}" >{{$team_lead_lists->first_name}}</option>
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
<!-- <script src="{{ asset('js/searchdropdown.js') }}"></script> -->
<script src="{{ asset('js/website.js') }}"></script>
<!-- Multi Dropdown JS -->
<script src="{{ asset('js/multiselect-dropdown.js') }}"></script>
<!-- Data table JavaScript -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#tl").select2();
        $(".scrape_report").on("click", function (e) {
            var id = $(this).attr("data-id");
            var base_url = '<?php echo config('app.url') ?>'+'public/client/';
            var url = base_url+id;
            navigator.clipboard.writeText(url);
        });
        $(".enhance_report").on("click", function (e) {
            var id = $(this).attr("data-id");
            var base_url = '<?php echo config('app.url') ?>'+'public/client/result/';
            var url = base_url+id;
            navigator.clipboard.writeText(url);
        });
        
    });
</script>

<!-- Render Table datas -->
<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        responsive: true,
        // stateSave: true,
        // rowId: "id",
        pageLength: 10,
        ajax: {
            url: "{{ route('website.index') }}",
            data: function (d) {
                    d.validation_status_filter = $('#validation_status_filter').val(),
                    d.search_type_filter = $('#search_type_filter').val(),
                    d.search = $('input[type="search"]').val()
                    // d.show = $('#show').val(),
                    // d.length = $('#show').val()
                }
            },
        columns: [
            {data: 'id', name: 'id', orderable: true},
            {data: 'client_name', name: 'first_name', orderable: true},
            {data: 'client_email', name: 'email', orderable: true},
            {data: 'company_name', name: 'company_name', orderable: true},
            {data: 'website', name: 'website', orderable: true},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'import_status', name: 'import status', orderable: false},
            {data: 'validation_status', name: 'validation status', orderable: false},
            {data: 'data_history', name: 'data_history', orderable: false},
            {data: 'created_at', name: 'created_at', orderable: true},
        ]
    });
    // $(".data-table").DataTable().rows().every( function () {
    //     var tr = $(this.node());
    //     this.child(format(tr.data('child-value'))).show();
    //     tr.addClass('shown');
    // });
    // validation_status_filter 
    $('#validation_status_filter').change(function(){
        table.draw();
    });

    // search_type Filter
    // $('#show').change(function(){
    //     var opt_val = $(this).val();
    //     $("#show option[value="+opt_val+"]").attr('selected','selected');
    //     table.draw();
    // });
    // Handle manual page length selection
    $('#show').on('change', function() {
        var selectedLength = $(this).val();
        $('.data-table').DataTable().page.len(selectedLength).draw();
    });

    // search_type Filter
    $('#search_filter').keyup(function(){
        table.draw();
    });

    // search_type Filter
    $('#search_type_filter').change(function(){
        table.draw();
    });

  });
</script>

<!-- Assign TL validation -->
<script>
    $("#assign_tl_form").on("submit", function (e) {
        var tl  = $("#tl").val();
        $(".error").empty();
        if(tl.length <= 0){
            e.preventDefault()
            $("#tl").after("<span class='error'>This field is required<span>");
        }
    });
</script>

<!-- Action Select -->
<script>
    $(document).on("change","#action-select",function() {
        var val = $(this).val();
        $("#"+val).trigger("click");
    });
</script>
</body>
</html>