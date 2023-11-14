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
            <?php $route = Route::current()->getName(); ?>
            <div class="col-md-5 col-xs-12 menu-list">
              <a class="menu-item {{$route =='super-admin.index' ? 'active' : '' }}" href="{{route('super-admin.index')}}">Websites</a>
              <a class="menu-item {{$route =='users.index' ? 'active' : '' }}" href="{{route('users.index')}}">Users</a>
              <a class="menu-item {{$route =='roles.index' ? 'active' : '' }}" href="{{route('roles.index')}}">Roles</a>
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
                    <span class="website_list">WEBSITE LIST</span>
                </div>
            </div>
            <div class="col-12 table-section table-responsive">
                <table class="">
                    <thead>
                        <th class="head2 first_head">S.No</th>
                        <th class="head1">Client Name</th>
                        <th class="head2">Company Name</th>
                        <th class="head1">Client Email</th>
                        <th class="head2">Website</th>
                        <!-- <th class="head1">Vserve Status</th>
                        <th class="head2">Client Status</th> -->
                        <th class="head1">Action</th>
                        <th class="action_head last_head">History</th>
                    </thead>
                    <tbody>
                        @php
                            $serialNumber = $datas->firstItem();
                        @endphp
                        @foreach($datas as $sno => $data)
                        <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->id); ?>
                        <tr>
                            <td class="data2">{{ $serialNumber++ }}</td>
                            <td class="data1">{{$data->getClient->getUser->first_name}}</td>
                            <td class="data2">{{$data->getClient->company_name}}</td>
                            <td class="data1">{{$data->getClient->getUser->email}}</td>
                            <td class="data2">{{$data->website}}</td>
                            <!-- <td class="data1">{{$data->vserve_status}}</td>
                            <td class="data2">{{$data->client_status}}</td> -->
                            <td class="data1">
                                <!-- Assign ops -->
                                <a href="javascript:void(0)" class="assign_ops" data-id="{{ $data->id }}" data-ops-id="{{ $data->ops_id }}" ><img src="{{asset('client/images/user.png')}}" alt="Assign PM" title="Assign PM"></a>
                                <!-- <a href="javascript:void(0)"
                                 class="manage_content"
                                    data-id="{{ $data->id }}"
                                    data-title-status="{{ $data->title_status }}"
                                    data-description-status="{{ $data->description_status }}"
                                    data-feature-status="{{ $data->feature_status }}"
                                    data-specification-status="{{ $data->specification_status }}"
                                    data-image-status="{{ $data->image_status }}"><img src="{{asset('client/images/content.png')}}" alt="Manage Content" title="Manage Content"></a> -->

                                <!-- Scrape Report -->
                                <!-- @if(!blank($data->getWebsiteData))
                                <a href="{{route('client',$enc_id)}}" ><img src="{{asset('client/images/view.png')}}" alt="view" title="view"></a>
                                @endif -->
                                <!-- Enhance Report -->
                                <!-- @if(!blank($data->getWebsiteEnhancedData))
                                <a href="{{route('client.result',$enc_id)}}" ><img src="{{asset('client/images/view.png')}}" alt="view" title="view"></a>
                                @endif -->
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
    <!-- Assign Users Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
        <div class="row">
            <form action="{{route('super-admin.store')}}" method="post" enctype="multipart/form-data" id="assign_ops">
                @csrf
                <input type="hidden" name="website_id" value="" id="website_id"> 
                <!-- Project Manager -->
                <div class="mb-3">
                    <label for="ops"><strong>Select Operation</strong></label>
                    <select name="ops" id="ops" class="form-control">
                        <option value="">select Operation</option>
                        @foreach($ops_list as $ops_lists)
                            <option value="{{$ops_lists->id}}">{{$ops_lists->first_name}}</option>
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

    <!-- Manage Content Modal -->
    <div id="manage_content_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" id="manage_content_close">&times;</span>
        <div class="row">
            <div class="col-12">
                <h2>Manage Website Content</h2>
            </div>
            <form action="{{route('manage_content')}}" method="post" enctype="multipart/form-data" id="manage_content_form">
                @csrf
                <input type="hidden" name="website_id" value="" id="manage_content_website_id"> 
                <!-- Title -->
                <div class="form-check mb-3">
                    <input class="form-check-input ml-5" type="checkbox" name="title_status" value="1" id="title_status">
                    <label class="" for="title_status">Title</label>
                </div>
                <!-- Description -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="description_status" value="1" id="description_status">
                    <label class="" for="description_status">Description</label>
                </div>
                <!-- Feature -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="feature_status" value="1" id="feature_status">
                    <label class="" for="feature_status">Feature</label>
                </div>
                <!-- Specification -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="specification_status" value="1" id="specification_status">
                    <label class="" for="specification_status">Specification</label>
                </div>
                <!-- Image -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="image_status" value="1" id="image_status">
                    <label class="" for="image_status">Image</label>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
        </div>
    </div>
    <script>
        // Assign Users open popup
        $(document).on("click",".assign_ops",function() {
            $("#myModal").show();
            var website_id = $(this).attr('data-id');
            var website_ops_id = $(this).attr('data-ops-id');
            $("#website_id").val(website_id);
            $('select[name^="ops"] option[value="'+website_ops_id+'"]').attr("selected","selected");
        });

        // Assign Ops Submit and Validation
        $(document).on("submit","#assign_ops",function(e) {
            var ops = $("#ops").val();
            if(ops.length <= 0){
                e.preventDefault();
                $(".error").empty();
                $("#ops").after('<span class="error">This field is required</span>');
            }
            console.log("ok");
        });

        // Assign Users Close Button
        $(document).on("click",".close",function() {
            $("#myModal").hide();
            $(".error").empty();
            $("#assign_ops")[0].reset();
        });

        // Manage Content open popup
        $(document).on("click",".manage_content",function() {
            $("#manage_content_modal").show();
            var website_id = $(this).attr('data-id');
            var title_status = $(this).attr('data-title-status');
            var description_status = $(this).attr('data-description-status');
            var feature_status = $(this).attr('data-feature-status');
            var specification_status = $(this).attr('data-specification-status');
            var image_status = $(this).attr('data-image-status');
            if(title_status == 1){
                $("#title_status").prop('checked',true);
            }
            if(description_status == 1){
                $("#description_status").prop('checked',true);
            }
            if(feature_status == 1){
                $("#feature_status").prop('checked',true);
            }
            if(specification_status == 1){
                $("#specification_status").prop('checked',true);
            }
            if(image_status == 1){
                console.log(image_status.length)
                $("#image_status").prop('checked',true);
            }

            $("#manage_content_website_id").val(website_id);
        });

        // Manage Content Close Button
        $(document).on("click","#manage_content_close",function() {
            $("#manage_content_modal").hide();
        });
    </script>
</body>
</html>