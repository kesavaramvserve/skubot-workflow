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
                        <h4 class="float-start mt-2">Website List</h4>
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
                                <th style="min-width:80px !important;">Website </th>
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

<!-- Batch Modal-->
    <div id="batch_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="batch_close">&times;</span>
            <div class="row">
                <form action="{{route('batch_list.store')}}" method="post" enctype="multipart/form-data" id="batch_form">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="batch_website_id"> 
                    @if($user_role == 'Team Lead')
                    <div class="mb-3">
                        <label for="role">Select Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">Select Role</option>
                            <option value="pa">PA</option>
                            <option value="qc">QC</option>
                            <option value="qa">QA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status">Select Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select role first</option>
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="role" value="{{$user_role}}" id="role">
                    <div class="mb-3">
                        <label for="status">Select Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="inprogress">IN-Progress</option>
                            @if($user_role == 'PA')
                            <option value="rejected">Rejected</option>
                            @elseif($user_role == 'QC')
                            <option value="reworked">Rework Done</option>
                            @endif
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    @endif
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Data table JavaScript -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

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
    $(document).on("click",".enhance-import",function() {
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

    // Open Batch Modal
    $(document).on("click",".select_batch",function() {
        $("#batch_modal").show();
        var website_id = $(this).attr('data-id');
        $("#batch_website_id").val(website_id);
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
</script>

</body>
</html>