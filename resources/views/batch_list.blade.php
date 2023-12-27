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
        .page-heading {
            font-size: 20px;
            margin-left:5%;
        }
        .heading{
            height : 100px !important;
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
            .submit-button-reverse{
                float :left !important;
            }
            .user-details {
                width: 70%;
            }
            .personal{
                display: none;
            }
            .page-heading-div {
                width: 90% !important;
            }
            .page-heading {
                font-size: 18px;
                margin-left: 20%;
            }
        }
    </style>
</head>
<body>
    <?php 
        $enc_id = Illuminate\Support\Facades\Crypt::encryptString($website_id);
    ?>
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
        
            <!-- Main section 1 -->
            <div class="row mb-5">
                <div class="col-1"></div>
                <div class="main-section col-10">

                    <!-- Page Heading -->
                    <div class="row heading">
                        <!-- Back icon with Page heading -->
                        <div class="col-md-4 col-xs-12">
                            <div style="float: left;width: 10%;" class="mt-3">
                                @if($user_role == 'Client')
                                    <a href="{{route('website_list.index')}}"><img src="{{asset('images/back.png')}}" alt="Back" class="" width="35px"></a>
                                @else
                                    <a href="{{route('batch_list.show',$enc_id)}}"><img src="{{asset('images/back.png')}}" alt="Back" class="" width="35px"></a>
                                @endif
                            </div>
                            <div style="float: left;width: 90%;" class="mt-3 page-heading-div">
                                <span class="page-heading">Batch List<span style="color:#C8EB7D"> - {{$heading}}</span></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div style="float: left;" class="mt-3">
                                <img src="{{asset('images/website.png')}}" alt="website" class="" width="50px">
                            </div>
                            <div style="float: left;width: 35%;margin-left:12%;" class="mt-2">
                                <span class=""><strong>Project</strong></span><br>
                                <span class="" style="font-size:12px;"><strong>{{$website_name}}</strong></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12 text-center mt-3">
                            @if($user_role == 'Team Lead')
                                <!-- Assign Users Button -->
                                @if($status == 'inqueue' || $status == 'inprogress')
                                    <a href="javascript:void(0)" class="btn submit-button-reverse assign_users">Assign Users</a>
                                @endif
                                <!-- Update Live Button -->
                                @if($status == 'completed')
                                    <!-- <a href="javascript:void(0)" class="btn submit-button-reverse update_to_live">Update to Live</a> -->
                                @endif
                            @endif
                            @if($user_role != 'PA')
                                <!-- Export Button -->
                                <a href="javascript:void(0)" class="btn submit-button export">Export</a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Error Message Row -->
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <span class="checkbox_error" id="checkbox_error"></span>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if($sku_count != '')
                                <span class="float-end mt-3" id="">{{$sku_count}} Records Found</span>
                            @else
                                <span class="float-end mt-3" id="">No Records Found</span>
                            @endif
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="row menu-row">
                        <div class="col-12 table-section table-responsive">
                            <form action="{{route('download_batch')}}" method="post" class="form_class" id="export_form">
                                @csrf
                                <!-- <form action="{{route('single_assign_users')}}" method="post" id="assign_users_form">
                                    @csrf -->
                                <input name="pa_id" type="hidden" value="" id="pa_id">
                                <input name="qc_id" type="hidden" value="" id="qc_id">
                                <input name="da_id" type="hidden" value="" id="da_id">
                                <input name="workflow" type="hidden" value="{{$workflow}}" id="workflow">
                                <input name="qa_id" type="hidden" value="" id="qa_id">
                                <input name="batch_status" type="hidden" value="{{$status}}" id="batch_status">
                                <input name="role" type="hidden" value="{{$current_role}}" id="role">
                                <input name="website_id" type="hidden" value="{{$website_id}}" id="">
                                <table class="table">
                                    @if($workflow == 'single')
                                    <thead>
                                        <th><input type="checkbox" id="checkbox_controller"></th>
                                        <th class="">S.No</th>
                                        <th class="">Client File</th>
                                        <th class="">Category</th>
                                        <th class="">MPN</th>
                                        <th class="">Product ID</th>
                                        <th class="">PA</th>
                                        <th class="">QC</th>
                                        <th class="">DA</th>
                                        <th class="">QA</th>
                                        <th class="">Date Alloted</th>
                                        <th class="">Note</th>
                                    </thead>
                                    <tbody>
                                        @if(!blank($datas))
                                            @foreach($datas as $sno => $data)
                                            <?php 
                                                $enc_sku_id = Illuminate\Support\Facades\Crypt::encryptString($data->id);
                                            ?>
                                            <tr>
                                                <!-- sku_id checkbox -->
                                                <td>
                                                    <input type="checkbox" class="checkbox" name="batch[]" value="{{$data->id}}">
                                                </td>
                                                <td class="">{{++$sno}}</td>
                                                @if($user_role != 'Client')
                                                    <td class="">{{$data->batch_id}}</td>
                                                @endif
                                                <td class="">
                                                    {{$data->category}}
                                                    @if($user_role != 'Team Lead' && $status != 'completed')
                                                        @if($data->pa_started_at == null)
                                                            <a href="#" data-route="{{route('sku',$enc_sku_id)}}" class="input-link">Input</a>
                                                        @else
                                                            <a href="{{route('sku',$enc_sku_id)}}" target="__blank" class="">Input</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="">{{$data->mpn}}</td>
                                                <td class="">{{$data->p_id}}</td>
                                                @if($user_role != 'Client')
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
                                                        @if($user_role == 'Team Lead')
                                                            {{$data->getWebsite->tl_assigned_at}}
                                                        @elseif($user_role == 'PA')
                                                            {{$data->pa_assigned_at}}
                                                        @elseif($user_role == 'QC')
                                                            {{$data->qc_assigned_at}}
                                                        @elseif($user_role == 'QA')
                                                            {{$data->qa_assigned_at}}
                                                        @endif
                                                    </td>
                                                    <td class="">
                                                        
                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                @if($user_role != 'Client')
                                                    <td colspan="12" style="text-align: center;">
                                                        NO Data Found
                                                    </td>
                                                @else
                                                    <td colspan="4" style="text-align: center;">
                                                        NO Data Found
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                    </tbody>
                                    @endif
                                    @if($workflow == 'bulk')
                                        <thead>
                                            <th><input type="checkbox" id="checkbox_controller"></th>
                                            <th class="">S.No</th>
                                            @if($user_role != 'Client')
                                                @if($workflow != 'single')
                                                    <th class="">Batch ID</th>
                                                    <th class="">Total Records</th>
                                                @else
                                                    <th class="">Client File</th>
                                                @endif
                                            @endif
                                            <th class="">Category/Brand</th>
                                            
                                            @if($user_role != 'Client')
                                                <!-- <th class="">TL</th> -->
                                                <th class="">MPN</th>
                                                <th class="">Produc ID</th>
                                                <th class="">PA</th>
                                                <th class="">QC</th>
                                                <th class="">DA</th>
                                                <th class="">QA</th>
                                                <th class="">Date Alloted</th>
                                                <th class="">Note</th>
                                            @endif
                                        </thead>
                                        <tbody>
                                            @if(!blank($datas))
                                                @foreach($datas as $sno => $data)
                                                <tr>
                                                    <!-- batch_id checkbox -->
                                                    <td>
                                                        <input type="checkbox" class="checkbox" name="batch[]" value="{{$data->batch_id}}">
                                                    </td>
                                                    <td class="">{{++$sno}}</td>
                                                    @if($user_role != 'Client')
                                                        <td class="">{{$data->batch_id}}</td>
                                                    @endif
                                                    <!-- <td class="">{{$data->supplier_type}}</td> -->
                                                    <td class="">{{$data->category}}</td>
                                                    <td class="">{{$data->mpn}}</td>
                                                    <td class="">{{$data->p_id}}</td>
                                                    <!-- <td class="">{{$data->total}}</td> -->
                                                    @if($user_role != 'Client')
                                                        <!-- TL -->
                                                        <!-- <td>
                                                            @if($data->getTL)
                                                                {{$data->getTL->first_name}}
                                                            @endif
                                                        </td> -->
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
                                                            @if($user_role == 'Team Lead')
                                                                {{$data->getWebsite->tl_assigned_at}}
                                                            @elseif($user_role == 'PA')
                                                                {{$data->pa_assigned_at}}
                                                            @elseif($user_role == 'QC')
                                                                {{$data->qc_assigned_at}}
                                                            @elseif($user_role == 'QA')
                                                                {{$data->qa_assigned_at}}
                                                            @endif
                                                        </td>
                                                        <td class="">
                                                            
                                                        </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    @if($user_role != 'Client')
                                                        <td colspan="12" style="text-align: center;">
                                                            NO Data Found
                                                        </td>
                                                    @else
                                                        <td colspan="4" style="text-align: center;">
                                                            NO Data Found
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        </tbody>
                                    @endif
                                    
                                </table>
                                <input type="submit" id="submit_button">
                            </form>
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

<!-- Assign Users Modal -->
    @if($user_role == 'Team Lead')
        <div id="myModal2" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
            <span class="close2">&times;</span>
            <div class="row">
                <!-- Select PA -->
                @if($role == 'PA')
                    <div class="mb-3">
                        <label for="modal_pa_id">Select PA</label>
                        <select name="modal_pa_id" id="modal_pa_id" class="form-control">
                            <option value="">Select PA</option>
                            @foreach($pa_lists as $pa_list)
                                <option value="{{$pa_list->id}}">{{$pa_list->first_name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <!-- Select QC -->
                @if($role == 'QC')
                    <div class="mb-3">
                        <label for="modal_qc_id">Select QC</label>
                        <select name="modal_qc_id" id="modal_qc_id" class="form-control">
                            <option value="">Select QC</option>
                            @foreach($qc_lists as $qc_list)
                                <option value="{{$qc_list->id}}">{{$qc_list->first_name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <!-- Select DA -->
                @if($role == 'DA')
                    <div class="mb-3">
                        <label for="modal_da_id">Select DA</label>
                        <select name="modal_da_id" id="modal_da_id" class="form-control">
                            <option value="">Select DA</option>
                            @foreach($da_lists as $da_list)
                                <option value="{{$da_list->id}}">{{$da_list->first_name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <!-- Select QA -->
                @if($role == 'QA')
                    <div class="mb-3">
                        <label for="modal_qa_id">Select QA</label>
                        <select name="modal_qa_id" id="modal_qa_id" class="form-control">
                            <option value="">Select QA</option>
                            @foreach($qa_lists as $qa_list)
                                <option value="{{$qa_list->id}}">{{$qa_list->first_name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <!-- Trigger to form Submit -->
                <div class="mb-3">
                    <a href="javascript:void(0)" class="btn btn-primary" id="submit_trigger">Submit</a>
                </div>
            </div>
            </div>
        </div>
    @endif

<Script>
    // $(document).on("click",".data_input",function() {
    //     var sku_id = 'eyJpdiI6ImsyWmhISG1mYUlYMUZxMHAwM0dlRGc9PSIsInZhbHVlIjoiajJ0ME5yZ3kwYUZGR1BaaFc2VUgvQT09IiwibWFjIjoiNDg5YTYyMGNjNGExZjA0N2I2OTE0YjYyMDg5MGI5ZDBjOGY0ZjlkMmUzOTQ0OGJiMDNlNTI1MDNjYWEyZTQxMCIsInRhZyI6IiJ9';
    //     if(confirm("Are you sure you want to start?")) {
    //         var parameterValue = "your_parameter_value_here";
    //         window.location.href = "{{ route('sku', ':parameter') }}".replace(':parameter', sku_id);
    //     } else {
    //         // Do something else or leave it empty
    //     }
    // });

    $('.input-link').on('click', function(e) {
        e.preventDefault();
        
        var route = $(this).data('route');
        
        if (confirm('Are you sure you want to Start?')) {
            var win = window.open(route, '_blank');
            if (win) {
                // Browser has allowed opening in new tab
                win.focus();
            } else {
                // Browser has blocked opening in new tab
                alert('Please allow popups for this site to open the link.');
            }
        }
    });

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

    // Select all Controller
    $(document).on("click","#checkbox_controller",function() {
        var res = $("#checkbox_controller").prop('checked'); 
        if(res){
            $(".checkbox").prop('checked',true); 
        }else{
            $(".checkbox").prop('checked',false); 
        }
    });

    // Checkbox Controller
    $(document).on("click",".checkbox",function() {
        var checkbox_count = $('.checkbox').length;
        var checkboxValues = $('.checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        if(checkboxValues.length == checkbox_count){
            $("#checkbox_controller").prop('checked',true); 
        }else{
            $("#checkbox_controller").prop('checked',false);
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

    // Open Assign Users Model and Assign Data
    $(document).on("click",".assign_users",function() {
        // var res = $(".checkbox").prop('checked'); 
        var checkboxValues = $('.checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        if(checkboxValues.length > 0){
            $("#checkbox_error").empty();
            $("#myModal2").show();
            $(".form_class").attr("id","assign_users_form");
            $(".form_class").attr("action","{{route('single_assign_users')}}");
        }else{
            $("#checkbox_error").empty();
            $("#checkbox_error").append('<span class="error">Please Select checkbox</span>');
        }                
    });

    // Submit Assign Users Form and Assign users data to form
    $(document).on("click","#submit_trigger",function() {
        var pa_id = $("#modal_pa_id").val();
        var qc_id = $("#modal_qc_id").val();
        var da_id = $("#modal_da_id").val();
        var qa_id = $("#modal_qa_id").val();
        var role  = $("#role").val();
        $(".error").empty();
        var err   = 0;
        $("#pa_id").val(pa_id);
        $("#qc_id").val(qc_id);
        $("#da_id").val(da_id);
        $("#qa_id").val(qa_id);
        if(role == 'PA' && pa_id.length <= 0){
            err++;
            $("#modal_pa_id").after("<span class='error'>This field is required<span>");
        }
        if(role == 'QC' && qc_id.length <= 0){
            err++;
            $("#modal_qc_id").after("<span class='error'>This field is required<span>");
        }
        if(role == 'QA' && qa_id.length <= 0){
            err++;
            $("#modal_qa_id").after("<span class='error'>This field is required<span>");
        }
        if(err==0){
            $("#assign_users_form").submit();
        }
    });
            

    // Close Assign Users Model 
    $(document).on("click",".close2",function() {
        $("#myModal2").hide();
        $("#modal_pa_id").val("");
        $("#modal_qc_id").val("");
        $("#modal_da_id").val("");
        $("#modal_qa_id").val("");
        $(".error").empty();
        $(".form_class").attr("id","export_form");
        $(".form_class").attr("action","{{route('download_batch')}}");
    });

    // Update to Live
    $(document).on("click",".update_to_live",function() {
        // var res = $(".checkbox").prop('checked'); 
        var checkboxValues = $('.checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        if(checkboxValues.length > 0){
            $("#checkbox_error").empty();
            $(".form_class").attr("id","update_to_live_form");
            $(".form_class").attr("action","{{route('update_to_live')}}");
            $("#update_to_live_form").submit();
        }else{
            $("#checkbox_error").empty();
            $("#checkbox_error").append('<span class="error">Please Select checkbox</span>');
        }                
    });
    

</Script>  
</body>
</html>