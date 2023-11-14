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
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-3 col-xs-12">
                <img src="{{asset('assets/images/logo.jpg')}}" alt="logo">
            </div>
            <div class="col-md-6 col-xs-12 menu-list">
                <a class="menu-item active" href="{{route('qc.index')}}">QC In Progress</a>
                <a class="menu-item " href="{{route('qa_reject')}}">QA Rejected</a>
                <a class="menu-item " href="{{route('qc_complete')}}">QC Completed</a>
                <a class="menu-item " href="{{route('qc.create')}}">Upload</a>
            </div>
            <div class="col-md-3 col-xs-12">
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
                    <span class="website_list">Batch LIST</span>
                </div>
            </div>
            <!-- Export -->
            <div class="col-12 mt-3">
                <span class="checkbox_error" id="checkbox_error"></span>
                <a href="javascript:void(0)" class="btn btn-success export float-end">Export</a>
            </div>
            <!-- Table -->
            <div class="col-12 table-section table-responsive">
                <form action="{{route('download_batch')}}" method="post" id="export_form">
                    @csrf
                    <table class="table">
                        <thead>
                            <th><input type="checkbox" id="checkbox_controller"></th>
                            <th class="">S.No</th>
                            <th class="">Batch ID</th>
                            <th class="">Supplier Type</th>
                            <th class="">Total Records</th>
                            <th class="">TL</th>
                            <th class="">PA</th>
                            <th class="">QC</th>
                            <th class="">DA</th>
                            <th class="">QA</th>
                            <th class="">Note</th>
                        </thead>
                        <tbody>
                            @foreach($datas as $sno => $data)
                            <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->id); ?>
                            <tr>
                                <!-- batch_id checkbox -->
                                <td>
                                    <input type="checkbox" class="checkbox" name="batch[]" value="{{$data->batch_id}}">
                                </td>
                                <td class="">{{++$sno}}</td>
                                <td class="">{{$data->batch_id}}</td>
                                <td class="">{{$data->supplier_type}}</td>
                                <td class="">{{$data->total}}</td>
                                <!-- TL -->
                                <td>
                                    @if($data->getTL)
                                        {{$data->getTL->first_name}}
                                    @endif
                                </td>
                                <!-- pa -->
                                <td>
                                    @if($data->getPA)
                                        {{$data->getPA->first_name}}
                                    @endif
                                </td>
                                <!-- qc -->
                                <td>
                                    @if($data->getQC)
                                        {{$data->getQC->first_name}}
                                    @endif
                                </td>
                                <!-- da -->
                                <td>
                                    @if($data->getDA)
                                        {{$data->getDA->first_name}}
                                    @endif
                                </td>
                                <!-- qa -->
                                <td>
                                    @if($data->getQA)
                                        {{$data->getQA->first_name}}
                                    @endif
                                </td>
                                <td class="">
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <input type="submit" id="submit_button">
                </form>
            </div>
            <div class="c0l-12 mt-3">
                <div style="margin-left:40%;">
                    
                </div>
            </div>
        </div>
    </div>
<!-- Enhance data import Modal)-->
<div id="myModal3" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="row">
            <form action="{{route('pa.store')}}" method="post" enctype="multipart/form-data" id="import_enhance_form">
                @csrf
                <input type="hidden" name="batch_id" value="" id="batch_id"> 
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


<Script>
    // Import enhanced Data
    $(document).on("click",".enhance-import",function() {
        $("#myModal3").show();
        var batch_id = $(this).attr('data-id');
        $("#batch_id").val(batch_id);
    });

    // Support Form Submit(Enhanced Data)
    $("#import_enhance_form").on("submit", function (e) {
        var data = $("#fileinput3").val();
        $(".error").empty();
        if(data.length < 1){
            e.preventDefault();
            $("#fileinput3").after('<span class="error">This field is required </span>');
        }
    });

    // Close Enhance Modal
    $(document).on("click",".close",function() {
        $("#import_enhance_form")[0].reset();
        $(".error").empty();
        $("#myModal3").hide();
    });

    // Select Controller
    $(document).on("click","#checkbox_controller",function() {
        var res = $("#checkbox_controller").prop('checked'); 
        if(res){
            $(".checkbox").prop('checked',true); 
        }else{
            $(".checkbox").prop('checked',false); 
        }
    });
    
    // Validation and Submit Export
    $(document).on("click",".export",function() {
        // var res = $(".checkbox").prop('checked'); 
        var checkboxValues = $('.checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        if(checkboxValues.length > 0){
            $("#checkbox_error").empty();
            $("#export_form").submit();
        }else{
            $("#checkbox_error").empty();
            $("#checkbox_error").append('<span class="error">Please Select checkbox</span>');
        }                
    });
</Script>
</body>
</html>