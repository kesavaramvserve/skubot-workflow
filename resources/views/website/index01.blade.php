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
    <!-- Data table CSS -->
	<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Website Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/website.css') }}">
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-12">
                <a href="{{route('website.index')}}"><img src="{{asset('assets/images/logo.jpg')}}" alt="logo"></a>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="float-end mt-4">
                    <span class="user_role">{{ auth()->user()->first_name }} ({{ auth()->user()->getRole->name }})</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3 text-center p-0">
            <h3 class="mt-2">{{ $message }}</h3>
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-danger  mt-3 text-center p-0"">
            <h3 class="mt-2">{{ $message }}</h3 class="mt-2">
        </div>
        @endif
        <!-- Title Section -->
        <div class="row content-section">
            <div class="col-12 title">
                <div class="mt-2">
                    <span class="dot"></span>
                    <span class="website_list">WEBSITE LIST</span>
                </div>
            </div>
            <div class="col-6 mt-3 col-xs-12">
                <div class="row">
                    <div class="text-center col-6">
                        <label for="validation_status_filter" class="float-end"><b>Validation Status:</b></label>
                    </div>
                    <div class="text-center col-6">
                        <select name="validation_status_filter" id="validation_status_filter" class="form-control">
                            <option value="">Select Validation Status</option>
                            <option value="Valid">Valid</option>
                            <option value="Invalid">Invalid</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 mt-3 col-xs-12">
                <div class="row">
                    <div class="text-center col-6">
                        <label for="search_type_filter" class="float-end"><b>Search Type:</b></label>
                    </div>
                    <div class="text-center col-6">
                        <select name="search_type_filter" id="search_type_filter" class="form-control">
                            <option value="">Select Search Type</option>
                            <option value="client_name">Client Name</option>
                            <option value="client_email">Client Email</option>
                            <option value="company_name">Company Name</option>
                            <option value="website">Website</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 table-section table-responsive">
                <table class="data-table">
                    <thead>
                        <th>ID<img src="{{asset('client/images/sort.png')}}"></th>
                        <th>Client Name <img src="{{asset('client/images/sort.png')}}"></th>
                        <th>Client Email <img src="{{asset('client/images/sort.png')}}"></th>
                        <th>Company Name <img src="{{asset('client/images/sort.png')}}"></th>
                        <th>Website <img src="{{asset('client/images/sort.png')}}"></th>
                        <th width="250px">Action </th>
                        <th>Import Status </th>
                        <th>Validation Status </th>
                        <th>Data History </th>
                        <th>Created at <img src="{{asset('client/images/sort.png')}}"></th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="c0l-12 mt-3">
                <div style="margin-left:40%;">
                    
                </div>
            </div>
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
                <table class="">
                    <thead>
                        <th class="modal-head1 first_head">Action</th>
                        <th class="modal-head2 last_head">Updated at</th>
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
                        <option value="">select Team Lead</option>
                        @foreach($team_lead_list as $team_lead_lists)
                            <option value="{{$team_lead_lists->id}}">{{$team_lead_lists->first_name}}</option>
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

<script src="{{ asset('js/website.js') }}"></script>
<!-- Data table JavaScript -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
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
        ajax: {
            url: "{{ route('website.index') }}",
            data: function (d) {
                    d.validation_status_filter = $('#validation_status_filter').val(),
                    d.search_type_filter = $('#search_type_filter').val(),
                    d.search = $('input[type="search"]').val()
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
    
    // validation_status_filter 
    $('#validation_status_filter').change(function(){
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
</body>
</html>