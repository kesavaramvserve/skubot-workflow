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
        <!-- Title Section -->
        <div class="row content-section">
            <div class="col-12 title">
                <div class="mt-2">
                    <span class="dot"></span>
                    <span class="website_list">SKU LIST</span>
                    <a href="{{route('website_list.index')}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="row">
                    <!-- Select Split Type -->
                    <div class="col-6 mt-3">
                        <div class="float-start">
                            <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($website_id); ?>
                            <form action="{{route('split_sku',$enc_id)}}" method="get">
                                @csrf
                                <label for=""><strong>Split Type</strong></label>
                                <select name="split_type" id="split_type">
                                    <option value="category" {{$split_type=='category' ? 'selected' : ''}}>Category</option>
                                    <option value="brand" {{$split_type=='brand' ? 'selected' : ''}}>Brand</option>
                                </select>
                                <input type="submit" class="">
                            </form>
                        </div>
                    </div>
                    <!-- Create Batch -->
                    <div class=" col-6 mt-3">
                        <div class="float-end">
                            <a href="javascript:void(0)" class="btn btn-success" id="trigger_btn">Create Batch</a>
                        </div>
                    </div>   
                </div>
            </div>
            <div class="col-12 table-section table-responsive">
                <form action="{{route('create_batch')}}" method="post" id="create_batch_form">
                    @csrf
                    <input name="website_id" type="hidden" value="{{$website_id}}" id="">
                    <input name="split_type" type="hidden" value="{{$split_type}}" id="create_split_type">
                    <table class="table">
                        <thead>
                            <th><input type="checkbox" id="checkbox_controller"></th>
                            <th>S.No</th>
                            @if($split_type=='category')
                            <th>Category</th>
                            @else
                            <th>Brand</th>
                            @endif
                            <th>Count</th>
                        </thead>
                        <tbody>
                            @foreach($datas as $key => $data)
                            <tr>
                                <!-- Category or Brand checkbox -->
                                <td>
                                    @if($split_type=='category')
                                        <input type="checkbox" class="checkbox" name="batch[]" value="{{$data->category}}">
                                    @else
                                        <input type="checkbox" class="checkbox" name="batch[]" value="{{$data->brand}}">
                                    @endif
                                </td>
                                <!-- S.NO -->
                                <td>{{++$key}}</td>
                                <!-- Brand or Category -->
                                <td>
                                    @if($split_type=='category')
                                        
                                        {{substr($data->category, strrpos($data->category, '>') + 1)}}
                                    @else
                                        {{$data->brand}}
                                    @endif
                                </td>
                                <!-- Count -->
                                <td>{{$data->total}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <input type="submit" id="submit_button">
                </form>
            </div>
        </div>
    </div>
    <script>
        // Create Batch Form Submit
        $(document).on("click","#trigger_btn",function() {
            $("#create_batch_form").submit();
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
    </script>
</body>
</html>