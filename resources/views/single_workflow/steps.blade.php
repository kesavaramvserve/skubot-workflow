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
            height : 50px !important;
        }
        .step-bar-row, .inputs-ro{
            width: 100% !important;
            /* margin-left: 3%; */
        }
        .step{
            height : 30px;
            width: 100%;
            color : #C8EB7D;
            font-weight : bold;
            border: 3px solid #C8EB7D;
            border-radius: 10px;
            cursor: pointer;
            text-align:center;
            /* background-color:#C8EB7D; */
        }
        .active{
            background-color:#C8EB7D;
            color : #fff;
        }
        .save-btn{
            border : 2px solid #C8EB7D;
            color :#C8EB7D;
            font-weight: bold;
        }
        .continue-btn, .complete-btn{
            background-color:#C8EB7D;
            border : 2px solid #C8EB7D;
            color :#fff;
            font-weight: bold;
        }
        .save-btn:hover{
            background-color:#C8EB7D;
            border : 2px solid #C8EB7D;
            color :#fff;
            font-weight: bold;
        }
        .continue-btn:hover, .complete-btn:hover{
            background-color:#fff;
            border : 2px solid #C8EB7D;
            color :#C8EB7D;
            font-weight: bold;
        }
        .active-form{
            display: block;
        }
        .deactive-form{
            display: none;
        }
        .step3-label-col{
            width:10% !important;
        }
        .step3-input-col{
            width:85% !important;
        }
        .step3-label{
            margin-top:3%;
        }
        .ck-editor__editable {
            min-height: 300px;
            max-height: 300px; /* Adjust this value as needed */
            overflow-y: auto; /* Add scrollbar if content exceeds max height */
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
                        <div class="col-12">
                            <h4 class="mt-1">SKU Edit</h4>
                        </div>
                    </div>
                    
                    <!-- Error Message Row -->
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <span class="checkbox_error" id="checkbox_error"></span>
                        </div>
                    </div>

                    <!-- Heading -->
                    <div class="row ms-4">
                       <div class="col-12">
                            <h6 id="form-heading">Enhanced Output - Product Details</h6>
                       </div>
                    </div>

                    <!-- Step Bar -->
                    <div class="row step-bar-row mt-3 ms-4">
                        
                        <div class="col-2">
                            <div class="step active" id="step1">Product Details</div>
                        </div>
                        <div class="col-2">
                            <div class="step" id="step2">Product Details</div>
                        </div>
                        <div class="col-2">
                            <div class="step" id="step3">Digital Assets</div>
                        </div>
                        <div class="col-2">
                            <div class="step" id="step4">SEO Tags</div>
                        </div>
                        <div class="col-2">
                            <div class="step" id="step5">Input Reference</div>
                        </div>
                        <div class="col-2"></div>
                           
                    </div>

                    <form action="{{route('update_sku')}}" method="POST" id="steps_form">
                        @csrf
                        <input type="hidden" name="sku_id" id="sku_id" value="{{$data[0]->id}}">
                        <input type="hidden" name="pa_done" id="pa_done" value="">
                        <!-- Step 1 Form -->
                        <div class="row inputs-row ms-4" id="step1_form">
                            <div class="col-6">
                                <!-- product_url -->
                                <label class="mt-3" for="product_url">Product URL</label>
                                <input type="text" value="{{$data[0]->url}}" name="product_url" class="form-control inputs" id="product_url">
                                <!-- mpn -->
                                <label class="mt-3" for="mpn">MPN</label>
                                <input type="text" value="{{$data[0]->mpn}}" name="mpn" class="form-control inputs" id="mpn">
                                <!-- color -->
                                <label class="mt-3" for="color">Color</label>
                                <input type="text" value="" name="color" class="form-control inputs" id="color">
                                <!-- pack_of -->
                                <label class="mt-3" for="pack_of">Pack of</label>
                                <input type="text" value="" name="pack_of" class="form-control inputs" id="pack_of">
                                <!-- title -->
                                <label class="mt-3" for="title">Title</label>
                                <input type="text" value="{{$data[0]->title}}" name="title" class="form-control inputs" id="title">
                                <!-- brand_name -->
                                <label class="mt-3" for="brand_name">Brand Name</label>
                                <input type="text" value="{{$data[0]->brand}}" name="brand_name" class="form-control inputs" id="brand_name">
                                <!-- product_type -->
                                <label class="mt-3" for="product_type">Product Type</label>
                                <input type="text" value="" name="product_type" class="form-control inputs" id="product_type">
                            </div>
                            <div class="col-6">
                                <!-- size -->
                                <label class="mt-3" for="size">Size/Dimension</label>
                                <input type="text" value="" name="size" class="form-control inputs" id="size">
                                <!-- Description -->
                                <label class="mt-3" for="description">Description</label>
                                <textarea name="description" id="description" class="form-control description_ckeditor" cols="20" rows="4">{{$data[0]->description}}</textarea>
                            </div>
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" class="btn save-btn">Save</a>
                            </div>
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" data-form="step2" class="btn continue-btn">Continue</a>
                            </div>
                        </div>

                        <!-- Step 2 Form -->
                        <div class="row inputs-row ms-4" id="step2_form">
                            <div class="col-6">
                                <!-- Feature -->
                                <label class="mt-3" for="feature">Features</label>
                                <textarea name="feature" id="feature" class="form-control feature_ckeditor" cols="20" rows="15">
                                    @foreach($data[0]->getEnhanceFeature as $features)
                                    <li>{{$features->feature}}
                                    @endforeach
                                </textarea>                            
                            </div>
                            <div class="col-6">
                                <!-- Specification -->
                                <label class="mt-3" for="specification">Specifications</label>
                                <textarea name="specification" id="specification" class="form-control specification_ckeditor" cols="20" rows="15">
                                    @foreach($data[0]->getEnhanceSpecification as $specifications)
                                        <li>{{$specifications->specification_head}} ={{$specifications->specification_value}}
                                    @endforeach
                                </textarea>
                            </div>
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" class="btn save-btn">Save</a>
                            </div>
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" data-form="step3" class="btn continue-btn">Continue</a>
                            </div>
                        </div>

                        <!-- Step 3 Form -->
                        <div id="step3_form" class="inputs-row">
                            @foreach($data[0]->getEnhanceImage as $key => $images)
                                <div class="row ms-4" id="initial_img_row">
                                    <!-- img_src1 -->
                                    <div class="col-2 step3-label-col mt-3">
                                        <label class="" for="img_src{{$key}}">IMG_SCR{{++$key}}</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3" style="float:left;">
                                        <input type="text" value="{{$images->image}}" name="img_src[]" id="img_src{{$key}}" class="form-control">
                                    </div>
                                    
                                    @if($loop->first)
                                        <div style="float:left;width:5%" class="mt-4" id="add_img_src_div">
                                            <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_img_src_field">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="row ms-4" >
                                <!-- Video Link -->
                                <div class="col-2 step3-label-col mt-3">
                                    <label class="" for="video_link">Video Link</label>
                                </div>
                                <div class="col-10 step3-input-col mt-3" style="float:left">
                                    <input type="text" name="video_link[]" id="" class="form-control">
                                </div>
                                <div style="float:left;width:5%" class="mt-4" id="add_video_link_div">
                                    <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_video_link_field">
                                </div>
                            </div>
                            <div class="row ms-4" >
                                <!-- Instruction Manual -->
                                <div class="col-2 step3-label-col mt-3">
                                    <label class="" for="instruction_manual">Instruction Manual</label>
                                </div>
                                <div class="col-10 step3-input-col mt-3">
                                    <input type="text" name="instruction_manual" id="instruction_manual" class="form-control">
                                </div>
                            </div>
                            <div class="row ms-4" >
                                <!-- Data Sheet -->
                                <div class="col-2 step3-label-col mt-3">
                                    <label class="" for="data_sheet">Data Sheet</label>
                                </div>
                                <div class="col-10 step3-input-col mt-3">
                                    <input type="text" name="data_sheet" id="data_sheet" class="form-control">
                                </div>
                            </div>
                            <div class="row ms-4" >
                                <!-- Installation Guide -->
                                <div class="col-2 step3-label-col mt-3">
                                    <label class="" for="installation_guide">Installation Guide</label>
                                </div>
                                <div class="col-10 step3-input-col mt-3">
                                    <input type="text" name="installation_guide" id="installation_guide" class="form-control">
                                </div>
                            </div>
                            <div class="row ms-4" >
                                <div class="col-6 mb-5 mt-3 text-center">
                                    <a href="javascript:void(0)" class="btn save-btn">Save</a>
                                </div>
                                <div class="col-6 mb-5 mt-3 text-center">
                                    <a href="javascript:void(0)" data-form="step4" class="btn continue-btn">Continue</a>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 Form -->
                        <div class="row inputs-row ms-4" id="step4_form">
                            <div class="col-6">
                                <!-- Meta Title -->
                                <label class="mt-3" for="meta_title">Meta Title</label>
                                <textarea name="meta_title" id="meta_title" class="form-control meta_title_ckeditor" cols="20" rows="5">
                                    {{$data[0]->title_metadata}}
                                </textarea>   
                                <!-- Meta Description -->
                                <label class="mt-3" for="meta_description">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" class="form-control meta_description_ckeditor" cols="20" rows="5">
                                    {{$data[0]->description_metadata}}
                                </textarea>                         
                            </div>
                            <div class="col-6">
                                <!-- Meta Keywords -->
                                <label class="mt-3" for="meta_keywords">Meta Keywords</label>
                                <textarea name="meta_keywords" id="meta_keywords" class="form-control meta_keywords_ckeditor" cols="20" rows="5">
                                    {{$data[0]->keywords_metadata}}
                                </textarea>
                                <!-- Search Keywords -->
                                <label class="mt-3" for="search_keywords">Search Keywords</label>
                                <textarea name="search_keywords" id="search_keywords" class="form-control search_keywords_ckeditor" cols="20" rows="5"></textarea>
                            </div>
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" class="btn save-btn">Save</a>
                            </div>
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" data-form="step5" class="btn continue-btn">Continue</a>
                            </div>
                        </div>

                        <!-- Step 5 Form -->
                        <div class="row inputs-row ms-4" id="step5_form">
                            <div class="col-12">
                                <!-- Ref. Link 1 -->
                                <label class="mt-3" for="ref_link1">Ref. Link 1</label>
                                <input type="text" name="ref_link1" id="ref_link1" class="form-control">    
                                <!-- Ref. Link 2 -->
                                <label class="mt-3" for="ref_link2">Ref. Link 2</label>
                                <input type="text" name="ref_link2" id="ref_link2" class="form-control">                      
                                <!-- Ref. Link 3 -->
                                <label class="mt-3" for="ref_link3">Ref. Link 3</label>
                                <input type="text" name="ref_link3" id="ref_link3" class="form-control"> 
                            </div>
                            
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" class="btn save-btn">Save</a>
                            </div>
                            <div class="col-6 mb-5 mt-3 text-center">
                                <a href="javascript:void(0)" class="btn complete-btn">Complete</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-1"></div>
            </div>
    </div>

<!-- CKEditor  -->
<!-- <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>

    // Page load changes
    $(document).ready(function(){
        $(".inputs-row").hide();
        $("#step1_form").show();
    });

    // Step Bar On Click Form Changes
    $(document).on("click",".step",function() {
        var step = $(this).attr('id');
        $(".step").removeClass('active');
        $("#"+step).addClass('active');
        $(".inputs-row").hide();
        $("#"+step+"_form").show();
        if(step == 'step1'){
            $("#form-heading").text("Enhanced Output - Product Details");
        }
        if(step == 'step2'){
            $("#form-heading").text("Enhanced Output - Product Details");
        }
        if(step == 'step3'){
            $("#form-heading").text("Digital Assets");
        }
        if(step == 'step4'){
            $("#form-heading").text("SEO Tags");
        }
        if(step == 'step5'){
            $("#form-heading").text("Input Reference");
        }
        
    });

    // Contine On Click Form Changes
    $(document).on("click",".continue-btn",function() {
        var step = $(this).attr('data-form');
        $(".step").removeClass('active');
        $("#"+step).addClass('active');
        $(".inputs-row").hide();
        $("#"+step+"_form").show();
        if(step == 'step1'){
            $("#form-heading").text("Enhanced Output - Product Details");
        }
        if(step == 'step2'){
            $("#form-heading").text("Enhanced Output - Product Details");
        }
        if(step == 'step3'){
            $("#form-heading").text("Digital Assets");
        }
        if(step == 'step4'){
            $("#form-heading").text("SEO Tags");
        }
        if(step == 'step5'){
            $("#form-heading").text("Input Reference");
        }
    });

    // Click Save button to form Submit
    $(document).on("click",".save-btn",function() {
        $("#steps_form").submit();
    });

    // Click Complete button to form Submit
    $(document).on("click",".complete-btn",function() {
        var confirmed = confirm("Are you sure you want to proceed?");
        if(confirmed) {
            $("#pa_done").val('1');
            $("#steps_form").submit();
        } else {
            
        }
    });

    // CKEditor 
    $(document).ready(function() {

        // description_ckeditor
        ClassicEditor.create(document.querySelector('.description_ckeditor'), {
            // Remove specific buttons from the toolbar
            removeButtons: 'Subscript,Superscript,Image,Table,HorizontalLine,SpecialChar',
            plugins: [ 'Heading', 'Bold' ] // Only keeping essential plugins
        })
        .catch(error => {
            console.error(error);
        });

        // feature_ckeditor
        ClassicEditor.create(document.querySelector('.feature_ckeditor'), {
            // Remove specific buttons from the toolbar
            removeButtons: 'Subscript,Superscript,Image,Table,HorizontalLine,SpecialChar',
            plugins: [ 'Heading', 'Bold' ] // Only keeping essential plugins
        })
        .catch(error => {
            console.error(error);
        });

        // specification_ckeditor
        ClassicEditor.create(document.querySelector('.specification_ckeditor'), {
            // Remove specific buttons from the toolbar
            removeButtons: 'Subscript,Superscript,Image,Table,HorizontalLine,SpecialChar',
            plugins: [ 'Heading', 'Bold' ] // Only keeping essential plugins
        })
        .catch(error => {
            console.error(error);
        });

        // meta_title_ckeditor
        ClassicEditor.create(document.querySelector('.meta_title_ckeditor'), {
            // Remove specific buttons from the toolbar
            removeButtons: 'Subscript,Superscript,Image,Table,HorizontalLine,SpecialChar',
            plugins: [ 'Heading', 'Bold' ] // Only keeping essential plugins
        })
        .catch(error => {
            console.error(error);
        });

        // meta_description_ckeditor
        ClassicEditor.create(document.querySelector('.meta_description_ckeditor'), {
            // Remove specific buttons from the toolbar
            removeButtons: 'Subscript,Superscript,Image,Table,HorizontalLine,SpecialChar',
            plugins: [ 'Heading', 'Bold' ] // Only keeping essential plugins
        })
        .catch(error => {
            console.error(error);
        });

        // meta_keywords_ckeditor
        ClassicEditor.create(document.querySelector('.meta_keywords_ckeditor'), {
            // Remove specific buttons from the toolbar
            removeButtons: 'Subscript,Superscript,Image,Table,HorizontalLine,SpecialChar',
            plugins: [ 'Heading', 'Bold' ] // Only keeping essential plugins
        })
        .catch(error => {
            console.error(error);
        });

        // search_keywords_ckeditor
        ClassicEditor.create(document.querySelector('.search_keywords_ckeditor'), {
            // Remove specific buttons from the toolbar
            removeButtons: 'Subscript,Superscript,Image,Table,HorizontalLine,SpecialChar',
            plugins: [ 'Heading', 'Bold' ] // Only keeping essential plugins
        })
        .catch(error => {
            console.error(error);
        });

    });
    
    // Add Img Src
    $('#add_img_src_field').click(function(){
        var fieldHTML = '<div class="row ms-4 img_src_row"><div class="col-2 step3-label-col mt-3"><label class="" for="img_src">IMG_SCR</label></div><div class="col-10 step3-input-col mt-3" style="float:left;"><input type="text" value="" name="img_src[]" id="img_src" class="form-control"></div><div style="float:left;width:5%" class="mt-4" id="remove_img_src_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_img_src_field" id="remove_img_src_field"></div></div>';
        $("#initial_img_row").after(fieldHTML);
    });
    // Remove Img Src
    $("#step3_form").on("click",".remove_img_src_field",function() {
        $(this).parent('.img_src_row').remove();
    });

    // Add Video Link
    $('#add_video_link_field').click(function(){
        var fieldHTML = '<div class="col-2 step3-label-col mt-3"><label class="" for="video_link">Video Link</label></div><div class="col-10 step3-input-col mt-3" style="float:left"><input type="text" name="video_link[]" id="" class="form-control"></div>';
        $("#add_video_link_div").after(fieldHTML);
    });

</script>
 
</body>
</html>