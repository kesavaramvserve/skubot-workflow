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
        .assigned_batch,.unassigned_batch{
            text-decoration : none;
            color : #fff;
            font-weight : bold;
        }
        .unassigned_batch{
            margin-left :5%;
        }
        .assigned_batch:hover,.unassigned_batch:hover{
            text-decoration : none;
            color : #fff;
            font-weight : bold;
        }
        .active{
            color:#fff700 !important;
            /* -webkit-text-stroke: 0.5px white; */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-12">
                <img src="{{asset('assets/images/logo.jpg')}}" alt="logo">
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
        <div class="alert alert-danger mt-3 text-center p-0">
            <h3 class="mt-2">{{ $message }}</h3>
        </div>
        @endif
        <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($website_id); ?>
        <!-- Title Section -->
        <div class="row content-section">
            <div class="col-12 title">
                <div class="row mt-2">
                    <div class="col-4">
                        <span class="dot"></span>
                        <span class="website_list">BATCH LIST</span>
                    </div>
                    <div class="col-4 text-center">
                        <!-- <a href="{{route('batches',$enc_id)}}" class="assigned_batch active">Unassigned Batches</a>
                        <a href="{{route('unassign_batches',$enc_id)}}" class="unassigned_batch">Assigned Batches</a> -->
                    </div>
                    <div class="col-4">
                        <a href="{{route('website_list.index')}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a>
                    </div>
                </div>
            </div>
            <!-- Assign Users -->
            <div class="col-12 mt-3">
                <span class="checkbox_error" id="checkbox_error"></span>
                <a href="javascript:void(0)" class="btn btn-success assign_users float-end">Assign Users</a>
            </div>
            <!-- Table -->
            <div class="col-12 table-section table-responsive">
                <form action="{{route('assign_users')}}" method="post" id="assign_users_form">
                    @csrf
                    <input name="pa_id" type="hidden" value="" id="pa_id">
                    <input name="qc_id" type="hidden" value="" id="qc_id">
                    <input name="da_id" type="hidden" value="" id="da_id">
                    <input name="qa_id" type="hidden" value="" id="qa_id">
                    <table class="table">
                        <thead>
                            <th><input type="checkbox" id="checkbox_controller"></th>
                            <th>S.No</th>
                            <th>Batch ID</th>
                            <th>Category/Brand</th>
                            <th>Total Records</th>
                            <th>TL</th>
                            <th>PA</th>
                            <th>QC</th>
                            <th>DA</th>
                            <th>QA</th>
                            <th>Date</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($datas as $key => $data)
                            <tr>
                                <!-- batch_id checkbox -->
                                <td>
                                    <input type="checkbox" class="checkbox" name="batch[]" value="{{$data->batch_id}}">
                                </td>
                                <!-- S.NO -->
                                <td>{{++$key}}</td>
                                <!-- batch_id -->
                                <td>
                                    {{$data->batch_id}}
                                </td>
                                <!-- Supplier Type -->
                                <td>{{$data->supplier_type}}</td>
                                <!-- Count -->
                                <td>{{$data->total}}</td>
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
                                <td>
                                    -
                                </td>
                                <td><a href="javascript:void(0)" class="btn btn-primary split" data-id="{{$data->website_id}}" data-batch="{{$data->batch_id}}" data-total="{{$data->total}}">Split</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <input type="submit" id="submit_button">
                </form>
            </div>
        </div>
    </div>

    <!-- Split Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
        <div class="row">
            <form action="{{route('split_skus')}}" method="post" enctype="multipart/form-data" id="split_form">
                @csrf
                <input type="hidden" name="website_id" id="website_id" value="">
                <div class="mb-3">
                    <label for="batch_id">Batch ID</label>
                    <input type="text" name="batch_id" class="form-control" id="batch_id" readonly>
                </div>
                <div class="mb-3">
                    <label for="total_count">Total Count</label>
                    <input type="text" name="total_count" class="form-control" id="total_count" readonly>
                </div>
                <div class="mb-3">
                    <label for="split_count">Split Count</label>
                    <input type="number" name="split_count" class="form-control" id="split_count">
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Assign Users Modal -->
    <div id="myModal2" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close2">&times;</span>
        <div class="row">
            <!-- Select PA -->
            <div class="mb-3">
                <label for="modal_pa_id">Select PA</label>
                <select name="modal_pa_id" id="modal_pa_id" class="form-control">
                    <option value="">Select PA</option>
                    @foreach($pa_lists as $pa_list)
                        <option value="{{$pa_list->id}}">{{$pa_list->first_name}}</option>
                    @endforeach
                </select>
            </div>
            <!-- Select QC -->
            <div class="mb-3">
                <label for="modal_qc_id">Select QC</label>
                <select name="modal_qc_id" id="modal_qc_id" class="form-control">
                    <option value="">Select QC</option>
                    @foreach($qc_lists as $qc_list)
                        <option value="{{$qc_list->id}}">{{$qc_list->first_name}}</option>
                    @endforeach
                </select>
            </div>
            <!-- Select DA -->
            <div class="mb-3">
                <label for="modal_da_id">Select DA</label>
                <select name="modal_da_id" id="modal_da_id" class="form-control">
                    <option value="">Select DA</option>
                    @foreach($da_lists as $da_list)
                        <option value="{{$da_list->id}}">{{$da_list->first_name}}</option>
                    @endforeach
                </select>
            </div>
            <!-- Select QA -->
            <div class="mb-3">
                <label for="modal_qa_id">Select QA</label>
                <select name="modal_qa_id" id="modal_qa_id" class="form-control">
                    <option value="">Select QA</option>
                    @foreach($qa_lists as $qa_list)
                        <option value="{{$qa_list->id}}">{{$qa_list->first_name}}</option>
                    @endforeach
                </select>
            </div>
            <!-- Trigger to form Submit -->
            <div class="mb-3">
                <a href="javascript:void(0)" class="btn btn-primary" id="submit_trigger">Submit</a>
            </div>
        </div>
        </div>
    </div>

    <script>
        // Select Controller
        $(document).on("click","#checkbox_controller",function() {
            var res = $("#checkbox_controller").prop('checked'); 
            if(res){
                $(".checkbox").prop('checked',true); 
            }else{
                $(".checkbox").prop('checked',false); 
            }
        });

        $(document).ready(function() {
            // Open Split Model and Assign Data
            $(document).on("click",".split",function() {
                $("#myModal").show();
                var website_id = $(this).attr('data-id');
                var batch_id = $(this).attr('data-batch');
                var total_count = $(this).attr('data-total');
                $("#website_id").val(website_id);
                $("#batch_id").val(batch_id);
                $("#total_count").val(total_count);
            });

            // Open Split Model
            $(document).on("click",".close",function() {
                $('#split_form')[0].reset();
                $("#myModal").hide();
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
                $(".error").empty();
                var err   = 0;
                $("#pa_id").val(pa_id);
                $("#qc_id").val(qc_id);
                $("#da_id").val(da_id);
                $("#qa_id").val(qa_id);
                // if(pa_id.length <= 0){
                //     err++;
                //     $("#modal_pa_id").after('<span class="error">This field is required</span>');
                // }
                // if(qc_id.length <= 0){
                //     err++;
                //     $("#modal_qc_id").after('<span class="error">This field is required</span>');
                // }
                // if(da_id.length <= 0){
                //     err++;
                //     $("#modal_da_id").after('<span class="error">This field is required</span>');
                // }
                // if(qa_id.length <= 0){
                //     err++;
                //     $("#modal_qa_id").after('<span class="error">This field is required</span>');
                // }
                if(err==0){
                    $("#assign_users_form").submit();
                }
            });
            // Open Split Model
            $(document).on("click",".close2",function() {
                // alert()
                // $('#assign_users')[0].reset();
                $("#myModal2").hide();
            });
        });

        // Split Form Validation
        $(document).on("submit","#split_form",function(e) {
            var split_count = $("#split_count").val();
            if(split_count.length <= 0){
                e.preventDefault();
                $(".error").empty();
                $("#split_count").after('<span class="error">This Feild is required</span>');
            }
        });
    </script>
</body>
</html>