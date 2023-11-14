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
    <!-- Website Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/pm_dashboard.css') }}">
    <style>
        .back{
            text-decoration: none;
            color : white;
            font-weight:bold;
        }
        .back:hover{
            text-decoration: none;
            color : white;
            font-weight:bold;
        }
        #submit_button{
            display : none;
        }
        .error{
            color: red;
        }
        .checkbox_error{
            margin-left: 100px;
            font-weight : bold;
        }
    </style>
</head>
<body>
    <?php $user_role = auth()->user()->getrole->name ?>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-3 col-xs-12">
                <img src="{{asset('assets/images/logo.jpg')}}" alt="logo">
            </div>
            
            <div class="col-md-9 col-xs-12">
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
        <div class="alert alert-danger mt-3 text-center p-0">
            <h3 class="mt-2">{{ $message }}</h3>
        </div>
        @endif
        <!-- Title Section -->
        <div class="row content-section">
            <div class="col-12 title">
                <div class="mt-2">
                    <span class="dot"></span>
                    <span class="website_list">Website LIST</span>
                </div>
            </div>
            <!-- Table -->
            <?php $user_role = auth()->user()->getrole->name ?>
            <div class="col-12 table-section table-responsive">
                <table class="table">
                    <thead>
                        <th class="">S.No</th>
                        <th class="">Client Name</th>
                        <th class="">Client Email</th>
                        <th class="">Company Name</th>
                        <th class="">Website</th>
                        <th class="">Action</th>
                    </thead>
                    <tbody>
                        @if(!blank($datas))
                            @foreach($datas as $sno => $data)
                                @if($user_role == 'Team Lead') <!-- TL Login -->
                                    <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->id); ?>
                                    <tr>
                                        <td>{{++$sno}}</td>
                                        <td>{{$data->first_name.' '.$data->last_name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->company_name}}</td>
                                        <td>{{$data->website}}</td>
                                        <td>
                                            @if(!blank($data->getWebsiteEnhancedData))
                                                <!-- Split SKU's -->
                                                <a href="{{route('split_sku',$enc_id)}}" class="" ><img src="{{asset('client/images/split.png')}}" alt="Create Batch" title="Create Batch"></a>
                                                <!--User Batches -->
                                                <!-- <a href="javascript:void(0)" class="select_batch" data-id="{{ $data->id }}"><img src="{{asset('client/images/batch.png')}}" alt="batch" title="batches"></a> -->
                                                <!--Batches -->
                                                <a href="{{route('batch_list.show',$enc_id)}}" class=""><img src="{{asset('client/images/batch.png')}}" alt="batch" title="batches"></a>
                                            @else
                                                <a href="javascript:void(0)" class="enhance-import" data-id="{{ $data->id }}"><img src="{{asset('client/images/import.png')}}" alt="import" title="Import Enhanced Data"></a>
                                            @endif    
                                        </td>
                                    </tr>
                                @elseif($user_role == 'Client') <!-- Client Login -->
                                    <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->id); ?>
                                    <tr>
                                        <td>{{++$sno}}</td>
                                        <td>{{$data->first_name.' '.$data->last_name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->company_name}}</td>
                                        <td>{{$data->website}}</td>
                                        <td>
                                            @if(!blank($data->getWebsiteData))
                                                <a href="{{route('client',$enc_id)}}" class=""><img src="{{asset('client/images/view.png')}}" alt="Scrape Report" title="Scrape Report"></a>
                                            @elseif(!blank($data->getClientRequiremnet))
                                                <a href="{{route('batch_list.show',$enc_id)}}" class=""><img src="{{asset('client/images/batch.png')}}" alt="batch" title="batches"></a>
                                            @endif
                                        </td>
                                    </tr>
                                @else <!-- Other Login -->
                                    <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->website_id); ?>
                                    <tr>
                                        <td>{{++$sno}}</td>
                                        <td>{{$data->getWebsite->first_name.' '.$data->getWebsite->last_name}}</td>
                                        <td>{{$data->getWebsite->email}}</td>
                                        <td>{{$data->getWebsite->company_name}}</td>
                                        <td>{{$data->getWebsite->website}}</td>
                                        <td>
                                            <!-- Batches -->
                                            <a href="{{route('batch_list.show',$enc_id)}}" class="" data-id="{{ $data->website_id }}"><img src="{{asset('client/images/batch.png')}}" alt="batch" title="batches"></a>
                                            <a href="{{route('batch_list.create')}}" class="" data-id=""><img src="{{asset('client/images/import.png')}}" alt="import" title="Import Enhanced Data"></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    No Data Found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="c0l-12 mt-3">
                <div style="margin-left:40%;">
                    {{$datas->links("pagination::bootstrap-4")}}
                </div>
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
</div>
</body>
</html>