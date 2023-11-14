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
                    <span class="website_list">WEBSITE LIST</span>
                </div>
            </div>
            <div class="col-12 table-section table-responsive">
                <table class="">
                    <thead>
                        <th class="head1 first_head">Client Name</th>
                        <th class="head2">Company Name</th>
                        <th class="head1">Client Email</th>
                        <th class="head2">Website</th>
                        <th class="head1">Vserve Status</th>
                        <th class="head2">Client Status</th>
                        <th class="head1">Action</th>
                        <th class="action_head last_head">History</th>
                    </thead>
                    <tbody>
                        @foreach($datas as $sno => $data)
                        <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->id); ?>
                        <tr>
                            <td class="data1">{{$data->getClient->getUser->first_name}}</td>
                            <td class="data2">{{$data->getClient->company_name}}</td>
                            <td class="data1">{{$data->getClient->getUser->email}}</td>
                            <td class="data2">{{$data->website}}</td>
                            <td class="data1">{{$data->vserve_status}}</td>
                            <td class="data2">{{$data->client_status}}</td>
                            <td class="data1">
                                @if(!blank($data->getWebsiteEnhancedData))
                                    <!-- Split SKU's -->
                                    <a href="{{route('split_sku',$enc_id)}}" class="" ><img src="{{asset('client/images/split.png')}}" alt="split" title="Split SKU's"></a>
                                    <!-- Batches -->
                                    <a href="{{route('batches',$enc_id)}}" class="" ><img src="{{asset('client/images/batch.png')}}" alt="batch" title="batches"></a>
                                @else
                                    <a href="javascript:void(0)" class="enhance-import" data-id="{{ $data->id }}"><img src="{{asset('client/images/import.png')}}" alt="import" title="Import Enhanced Data"></a>
                                @endif
                                </td>
                            <td class="data2">-</td>
                        </tr>
                        @endforeach
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
    </script>
</div>
</body>
</html>