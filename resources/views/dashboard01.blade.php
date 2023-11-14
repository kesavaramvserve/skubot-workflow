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
        
        <div class="row content-section">
            <!-- Title Section -->
            <div class="col-12 title">
                <div class="row mt-2">
                    <div class="col-4">
                        <span class="dot"></span>
                        <span class="website_list">User Menu
                    </div>
                    <div class="col-4 text-center">
                    </div>
                    <div class="col-4">
                        <a href="{{route('website_list.index')}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a>
                    </div>
                </div>
            </div>
            <!-- Website Name -->
            <div class="col-12 mt-3">
                <strong>Website: </strong>{{$website_name}}
            </div> 
            <!-- Menus -->
            <div class="col-md-12 col-xs-12">
                <!-- PA Menu -->
                @if(auth()->user()->getrole->name == 'PA' || auth()->user()->getrole->name == 'Team Lead')
                <div class="row mt-3 mb-2">
                    <div class="col-md-12 col-xs-12 text-center">
                        <div class="bg-info text-dark">
                            PA Menu
                        </div>
                    </div>
                    <!-- PA In Queue -->
                    @if(auth()->user()->getrole->name == 'Team Lead')
                        <div class="col-md-4 col-xs-12 text-center mb-3">
                            <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="PA" data-status="inqueue" href="javascript:void(0)">PA Queue</a>
                        </div>
                    @endif
                    <!-- PA In Progress -->
                    <div class="col-md-4 col-xs-12 text-center mb-3">
                        <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="PA" data-status="inprogress" href="javascript:void(0)">PA In Progress</a>
                    </div>
                    <!-- QC Rejected -->
                    <div class="col-md-4 col-xs-12 text-center mb-3">
                        <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="PA" data-status="rejected" href="javascript:void(0)">QC Rejected</a>
                    </div>
                     <!-- PA Completed -->
                     @if(auth()->user()->getrole->name == 'PA')
                        <div class="col-md-4 col-xs-12 text-center mb-3">
                            <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="PA" data-status="completed" href="javascript:void(0)">PA Completed</a>
                        </div>
                    @endif
                </div>
                @endif
                <!-- QC Menu -->
                @if(auth()->user()->getrole->name == 'QC' || auth()->user()->getrole->name == 'Team Lead')
                    <div class="row mt-3 mb-2">
                        <div class="col-md-12 col-xs-12 mb-3 text-center">
                            <div class="bg-info text-dark">
                                QC Menu
                            </div>
                        </div>
                        <!-- QC In Queue -->
                        @if(auth()->user()->getrole->name == 'Team Lead')
                            <div class="col-md-4 col-xs-12 mb-3 text-center">
                                <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QC" data-status="inqueue" href="javascript:void(0)">QC Queue</a>
                            </div>
                        @endif
                        <!-- QC In Progress -->
                        <div class="col-md-4 col-xs-12 mb-3 text-center">
                            <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QC" data-status="inprogress" href="javascript:void(0)">QC In Progress</a>
                        </div>
                        <!-- QC Rework Done -->
                        @if(auth()->user()->getrole->name == 'QC')
                            <div class="col-md-4 col-xs-12 mb-3 text-center">
                                <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QC" data-status="reworked" href="javascript:void(0)">Rework Done</a>
                            </div>
                        @endif
                        <!-- QC Completed -->
                        @if(auth()->user()->getrole->name == 'QC')
                            <div class="col-md-4 col-xs-12 mb-3 text-center">
                                <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QC" data-status="completed" href="javascript:void(0)">QC Completed</a>
                            </div>
                        @endif
                    </div>
                @endif
                <!-- QA Menu -->
                @if(auth()->user()->getrole->name == 'QA' || auth()->user()->getrole->name == 'Team Lead')
                <div class="row mt-3 mb-2">
                    <div class="col-md-12 col-xs-12 mb-3 text-center">
                        <div class="bg-info text-dark">
                            QA Menu
                        </div>
                    </div>
                    <!-- QA IN Queue -->
                    @if(auth()->user()->getrole->name == 'Team Lead')
                        <div class="col-md-4 col-xs-12 mb-3 text-center">
                            <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QA" data-status="inqueue" href="javascript:void(0)">QA Queue</a>
                        </div>
                    @endif
                    <div class="col-md-4 col-xs-12 mb-3 text-center">
                        <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QA" data-status="inprogress" href="javascript:void(0)">QA In Progress</a>
                    </div>
                    <!-- QA Completed -->
                    @if(auth()->user()->getrole->name == 'QA')
                        <div class="col-md-4 col-xs-12 mb-3 text-center">
                            <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QA" data-status="completed" href="javascript:void(0)">QA Completed</a>
                        </div>
                    @endif
                </div>
                @endif
                <!-- Other Menu -->
                @if(auth()->user()->getrole->name == 'Team Lead')
                <div class="row mt-3 mb-2">
                    <div class="col-md-12 col-xs-12 mb-3 text-center">
                        <div class="bg-info text-dark">
                            Other Menu
                        </div>
                    </div>
                    <!-- Completed Queue -->
                    <div class="col-md-4 col-xs-12 mb-3 text-center">
                        <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="QA" data-status="completed" href="javascript:void(0)">Completed Queue</a>
                    </div>
                    <!-- Live Updated -->
                    <div class="col-md-4 col-xs-12 mb-3 text-center">
                        <a class="btn btn-light select_batch" data-id="{{$website_id}}" data-role="" data-status="updated" href="javascript:void(0)">Live Updated</a>
                    </div>
                </div>
                @endif
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
                    <input type="hidden" name="role" value="" id="role">
                    <input type="hidden" name="status" value="" id="status">
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>