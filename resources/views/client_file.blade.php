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
        .submit-button-reverse{
            font-size: 14px !important;
            border: 1px solid #C8EB7D;
            border-radius: 10px;
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
                        <h4 class="float-start mt-2">Client File List</h4>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="row">
                    <div class="col-11">
                        @if(!$defult_scrapper)
                            <a class="float-end mt-2 btn submit-button-reverse" href="{{ url()->previous() }}">Back</a>
                        @endif
                    </div>
                    <div class="col-1">
                    </div>
                </div>
                
                <!-- Table -->
                <div class="row table-row">
                    <div class="col-12 table-responsive table-section">
                        <table class="data-table table  nowrap" style="width:100%">
                            <thead>
                                <th style="min-width:30px !important;">ID</th>
                                <th style="min-width:80px !important;">Project Name</th>
                                <th style="min-width:80px !important;">File Name</th>
                                <th style="min-width:80px !important;">Notes</th>
                                <th style="min-width:80px !important;">Updated at </th>
                                <th style="min-width:50px !important;">Action </th>
                            </thead>
                            <tbody>
                                @if($defult_scrapper)
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->getWebsite->website}}</td>
                                            <td>{{$data->path}}</td>
                                            <td>{{$data->notes}}</td>
                                            <td>{{$data->updated_at}}</td>
                                            <td>
                                                <a href="{{asset('client-sku-files/')}}/{{$data->path}}" class="btn btn-info" download><img id="" src="{{asset('client/images/download.png')}}" alt="Download Client File" title="Download Client File"></a>
                                                @if($data->getScarperData)
                                                    <a href="{{asset('scraper-data/')}}/{{$data->getScarperData->path}}" class="btn btn-info" download><img id="" src="{{asset('client/images/download.png')}}" alt="Download Scrapped File" title="Download Scrapped File"></a>
                                                @else
                                                    <a href="javascript:void(0)" data-id="{{$data->id}}" data-website-id="{{$data->website_id}}" class="btn btn-primary upload_scrapped_file"><img id="" src="{{asset('client/images/import.png')}}" alt="Upload Scrapped File" title="Upload Scrapped File"></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($datas as $data)
                                        <tr>
                                            <?php $enc_id = Crypt::encryptString($data->id); ?>
                                            <td>{{$data->id}}</td>
                                            <td>{{$project_name}}</td>
                                            <td>{{$data->path}}</td>
                                            <td>{{$data->notes}}</td>
                                            <td>{{$data->updated_at}}</td>
                                            <td>
                                                @if($project_role == 'Team Lead' || $project_role == 'Scrapper')
                                                    <a href="{{asset('client-sku-files/')}}/{{$data->path}}" class="btn btn-info" download><img id="" src="{{asset('client/images/download.png')}}" alt="Download Client File" title="Download Client File"></a>
                                                    <!-- @if($project_role == 'Team Lead')
                                                        <a href="javascript:void(0)" data-id="{{$data->id}}" data-website-id="{{$website_id}}" class="btn btn-primary assign_users"><img id="" src="{{asset('client/images/users.png')}}" alt="Assign Users" title="Assign Users"></a>
                                                        <a href="{{route('batch_list.show',$enc_id)}}" class="btn btn-success"><img id="" src="{{asset('client/images/view.png')}}" alt="View Client File" title="View Client File"></a>
                                                    @endif -->
                                                    @if($project_role == 'Scrapper')
                                                        @if($data->getScarperData)
                                                            <a href="{{asset('scraper-data/')}}/{{$data->getScarperData->path}}" class="btn btn-info" download><img id="" src="{{asset('client/images/download.png')}}" alt="Download Scrapped File" title="Download Scrapped File"></a>
                                                        @else
                                                            <a href="javascript:void(0)" data-id="{{$data->id}}" data-website-id="{{$website_id}}" class="btn btn-primary upload_scrapped_file"><img id="" src="{{asset('client/images/import.png')}}" alt="Upload Scrapped File" title="Upload Scrapped File"></a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="col-12 mt-3">
                        <div style="margin-left:20%;">
                            {{$datas->links("pagination::bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
    </div>


    <!-- Import Scrapped File from Scrapper Login-->
    <div id="scrapped_file_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="scrapped_file_close">&times;</span>
            <div class="row">
                <form action="{{route('enhance_data')}}" method="post" enctype="multipart/form-data" id="scrapped_file_form">
                    @csrf
                    <input type="hidden" name="website_id" value="" id="scrapped_file_website_id"> 
                    <input type="hidden" name="client_file_id" value="" id="scrapped_modal_file_id">
                    <input type="hidden" name="enhance_status" value="1" id="enhance_status">
                    <div class="mb-3">
                        <label for="file">Import File</label>
                        <input type="file" name="file" class="form-control" id="scrapped_file_input">
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

<script>

    // Assign Users Modal Open
    $(document).on("click",".assign_users",function() {

        $("#assign_users_modal").show();
        var file_id     = $(this).attr('data-id');
        var website_id  = $(this).attr('data-website-id');
        $("#file_id").val(file_id);

        $.ajax({
            url: '/get_scrapper_list', // Replace with your Laravel endpoint URL
            method: 'GET',
            data: {
                // Data to be sent in the request body (if needed)
                key1: file_id,
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
                key1: file_id,
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
                key1: file_id,
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
                key1: file_id,
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
    // Assign Users Modal Close
    $(document).on("click",".assign_users_close",function() {
        $("#assign_users_form")[0].reset();
        $(".error").empty();
        $("#assign_users_modal").hide();
    });

    // Import Scrapped File Modal Open
    $(document).on("click",".upload_scrapped_file",function() {
        $("#scrapped_file_modal").show();
        var file_id     = $(this).attr('data-id');
        var website_id  = $(this).attr('data-website-id');
        $("#scrapped_modal_file_id").val(file_id);
        $("#scrapped_file_website_id").val(website_id);
    });

    // Import Scrapped File Form Validation
    $(document).on("submit","#scrapped_file_form",function(e) {
        var data = $("#scrapped_file_input").val();
        $(".error").empty();
        if(data.length < 1){
            e.preventDefault();
            $("#scrapped_file_input").after('<span class="error">This field is required </span>');
        }
    });

    // Import Scrapped File Modal Close
    $(document).on("click",".scrapped_file_close",function() {
        $("#scrapped_file_form")[0].reset();
        $(".error").empty();
        $("#scrapped_file_modal").hide();
    });

</script>


</body>
</html>