@extends('layouts.app')
@section('main-content')
                <!-- Table Heading -->
                <div class="row heading">
                    <div class="col-md-6 col-xs-12 mt-3">
                        <h4 class="float-start mt-2">Project List</h4>
                    </div>
                    <div class="col-md-6 col-xs-12 mt-3">
                        <div class="float-end">
                            <?php $route = Route::current()->getName(); ?>
                            <a class="menu-item {{$route =='super-admin.index' ? 'active' : '' }}" href="{{route('super-admin.index')}}">Projects</a>
                            <a class="menu-item {{$route =='users.index' ? 'active' : '' }}" href="{{route('users.index')}}">Users</a>
                            <a class="menu-item {{$route =='roles.index' ? 'active' : '' }}" href="{{route('roles.index')}}">Roles</a>
                        </div>
                    </div>
                </div>

                <!-- Add Project Button -->
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{route('super-admin.create')}}" class="btn submit-button" style="margin-left:87%;">Add Project</a>
                    </div>
                </div>
                
                <!-- Table -->
                <div class="row table-row mt-3">
                    <div class="col-12 table-responsive">
                        <table class="table  nowrap" style="width:100%">
                            <thead>
                                <th>S.No</th>
                                <!-- <th>Client Name</th>
                                <th>Company Name</th>
                                <th>Client Email</th> -->
                                <th>Project</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>History</th>
                            </thead>
                            <tbody>
                                @php
                                    $serialNumber = $datas->firstItem();
                                @endphp
                                @foreach($datas as $sno => $data)
                                <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->id); ?>
                                <tr>
                                    <td class="">{{ $serialNumber++ }}</td>
                                    <!-- <td class="">{{$data->getClient->getUser->first_name}}</td>
                                    <td class="">{{$data->getClient->company_name}}</td>
                                    <td class="">{{$data->getClient->getUser->email}}</td> -->
                                    <td class="">{{$data->website}}</td>
                                    <td class="">
                                        @if($data->status == '1')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="">
                                    <!-- Assign ops -->
                                    <a href="javascript:void(0)" class="assign_ops" data-id="{{ $data->id }}" data-ops-id="{{ $data->ops_id }}" ><img src="{{asset('client/images/user.png')}}" alt="Assign PM" title="Assign PM"></a>
                                    </td>
                                    <td class="">-</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mt-3">
                        <div style="margin-left:40%;">
                            {{$datas->links("pagination::bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
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
                    <label for="ops"><strong>Select PM</strong></label>
                    <select name="ops" id="ops" class="form-control">
                        <option value="">select PM</option>
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
@endsection