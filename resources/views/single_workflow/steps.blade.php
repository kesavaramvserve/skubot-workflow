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
        .continue-btn, .complete-btn, .download-btn{
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
        .continue-btn:hover, .complete-btn:hover, .download-btn:hover{
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
        #timer{
            color : red;
            font-size :16px;
            font-weight : bold;
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
                                    <span class="user-role">({{ $project_role }})</span>
                                    <!-- <span class="user-role">({{ auth()->user()->getRole->name }})</span> -->
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
                        <div class="col-6">
                            <h4 class="mt-1">SKU Edit</h4>
                        </div>
                        <dv class="col-6">
                            @if($project_role == 'PA')
                                <span id="timer"></span>
                            @endif
                            <a class="float-end btn submit-button-reverse" href="{{ url()->previous() }}">Back</a>
                        </dv>
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
                        <input type="hidden" name="website_id" id="" value="{{$website_id}}">
                        <input type="hidden" name="sku_id" id="sku_id" value="{{$data[0]->id}}">
                        <input type="hidden" name="pa_done" id="pa_done" value="">
                        <input type="hidden" name="db_pa_done" id="" value="{{$data[0]->pa_done}}">
                        <input type="hidden" name="db_qc_done" id="" value="{{$data[0]->qc_done}}">
                        <input type="hidden" name="db_qa_done" id="" value="{{$data[0]->qa_done}}">
                        <input type="hidden" name="download_status" id="download_status" value="">
                        <input type="hidden" name="pa_started_at" id="pa_started_at" value="{{$data[0]->pa_started_at}}">
                        <!-- Step 1 Form -->
                        <div class="row inputs-row ms-4" id="step1_form">
                            <div class="col-6">
                                <!-- brand_name -->
                                <label class="mt-3" for="brand_name">Brand Name</label>
                                <input type="text" readonly value="{{$data[0]->brand}}" name="brand_name" class="form-control inputs" id="brand_name">
                                <!-- mpn -->
                                <label class="mt-3" for="mpn">MPN</label>
                                <input type="text" readonly value="{{$data[0]->mpn}}" name="mpn" class="form-control inputs" id="mpn">
                                <!-- color -->
                                <label class="mt-3" for="color">Color</label>
                                <input type="text" value="{{$data[0]->color}}" name="color" class="form-control inputs" id="color">
                                <!-- pack_of -->
                                <label class="mt-3" for="pack_of">Pack of</label>
                                <input type="text" value="{{$data[0]->pack_of}}" name="pack_of" class="form-control inputs" id="pack_of">
                                <!-- size -->
                                <label class="mt-3" for="size">Size/Dimension</label>
                                <input type="text" value="{{$data[0]->size}}" name="size" class="form-control inputs" id="size">
                                <!-- product_type -->
                                <label class="mt-3" for="product_type">Product Type</label>
                                <input type="text" value="{{$data[0]->product_type}}" name="product_type" class="form-control inputs" id="product_type">
                                <!-- title -->
                                <label class="mt-3" for="title">Title</label>
                                <input type="text" value="{{$data[0]->title}}" name="title" class="form-control inputs" id="title">
                            </div>
                            <div class="col-6">
                                <!-- product_url -->
                                <label class="mt-3" for="product_url">Product URL</label>
                                <input type="text" readonly value="{{$data[0]->url}}" name="product_url" class="form-control inputs" id="product_url">
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
                                        <li><b>{{$specifications->specification_head}}</b> : {{$specifications->specification_value}}
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

                            <!-- No Digital Asset and Download all -->
                            <div class="row ms-4 mt-5">
                                <div class="col-6">
                                    <input type="checkbox" name="digital_asset_status" id="digital_asset_status">No Digital Asset
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0)" class="btn download-btn float-end">Download All</a>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="row ms-4" id="img_row">
                                @if(!blank($data[0]->getEnhanceImage))
                                    @foreach($data[0]->getEnhanceImage as $key => $images)
                                        <?php $img_key = $key; ?>
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="img_src{{$key}}">IMG_SCR{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$images->image}}" name="img_src[]" id="img_src{{$key}}" class="form-control">
                                            @if(!blank($img_src))
                                                <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$img_src[$img_key]->file_name)}}">{{$img_src[$img_key]->file_name}}</a>
                                            @endif
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_img_src_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_img_src_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="img_src1">IMG_SCR1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="img_src[]" id="img_src1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_img_src_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_img_src_field">
                                    </div>
                                @endif
                            </div>
                           
                            <!-- data_360_spin_url -->
                            <div class="row ms-4" id="data_360_row">
                                @if(!blank($data_360))
                                    @foreach($data_360 as $key => $data_360s)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="data_360{{$key}}">Data 360 Spin URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$data_360s->file_url}}" name="data_360[]" id="data_360{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$data_360s->file_name)}}">{{$data_360s->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_data_360_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_data_360_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="data_3601">Data 360 Spin URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="data_360[]" id="data_3601" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_data_360_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_data_360_field">
                                    </div>
                                @endif
                            </div>
                            
                            <!-- spec_sheet_url -->
                            <div class="row ms-4" id="spec_sheet_row">
                                @if(!blank($spec_sheet))
                                    @foreach($spec_sheet as $key => $spec_sheets)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="spec_sheet{{$key}}">Spec Sheet URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$spec_sheets->file_url}}" name="spec_sheet[]" id="spec_sheet{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$spec_sheets->file_name)}}">{{$spec_sheets->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_spec_sheet_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_spec_sheet_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="spec_sheet1">Spec Sheet URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="spec_sheet[]" id="spec_sheet1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_spec_sheet_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_spec_sheet_field">
                                    </div>
                                @endif
                            </div>

                            <!-- part_drawing_url -->
                            <div class="row ms-4" id="part_drawing_row">
                                @if(!blank($part_drawing))
                                    @foreach($part_drawing as $key => $part_drawings)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="part_drawing{{$key}}">Part Drawing URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$part_drawings->file_url}}" name="part_drawing[]" id="part_drawing{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$part_drawings->file_name)}}">{{$part_drawings->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_part_drawing_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_part_drawing_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="part_drawing1">Part Drawing URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="part_drawing[]" id="part_drawing1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_part_drawing_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_part_drawing_field">
                                    </div>
                                @endif
                            </div>

                            <!-- brochure_url -->
                             <div class="row ms-4" id="brochure_row">
                                @if(!blank($brochure))
                                    @foreach($brochure as $key => $brochures)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="brochure{{$key}}">Brochure URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$brochures->file_url}}" name="brochure[]" id="brochure{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$brochures->file_name)}}">{{$brochures->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_brochure_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_brochure_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="brochure1">Brochure URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="brochure[]" id="brochure1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_brochure_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_brochure_field">
                                    </div>
                                @endif
                            </div>

                            <!-- catalog_page_url -->
                            <div class="row ms-4" id="catalog_page_row">
                                @if(!blank($catalog_page))
                                    @foreach($catalog_page as $key => $catalog_pages)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="catalog_page{{$key}}">Catalog Page URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$catalog_pages->file_url}}" name="catalog_page[]" id="catalog_page{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$catalog_pages->file_name)}}">{{$catalog_pages->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_catalog_page_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_catalog_page_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="catalog_page1">Catalog Page URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="catalog_page[]" id="catalog_page1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_catalog_page_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_catalog_page_field">
                                    </div>
                                @endif
                            </div>
                            
                            <!-- white_paper_url -->
                            <div class="row ms-4" id="white_paper_row">
                                @if(!blank($white_paper))
                                    @foreach($white_paper as $key => $white_papers)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="white_paper{{$key}}">White Paper URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$white_papers->file_url}}" name="white_paper[]" id="white_paper{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$white_papers->file_name)}}">{{$white_papers->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_white_paper_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_white_paper_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="white_paper1">White Paper URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="white_paper[]" id="white_paper1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_white_paper_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_white_paper_field">
                                    </div>
                                @endif
                            </div>

                            <!-- warranty_document_url -->
                            <div class="row ms-4" id="warranty_document_row">
                                @if(!blank($warranty_document))
                                    @foreach($warranty_document as $key => $warranty_documents)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="warranty_document{{$key}}">Warranty Document URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$warranty_documents->file_url}}" name="warranty_document[]" id="warranty_document{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$warranty_documents->file_name)}}">{{$warranty_documents->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_warranty_document_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_warranty_document_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="warranty_document1">Warranty Document URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="warranty_document[]" id="warranty_document1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_warranty_document_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_warranty_document_field">
                                    </div>
                                @endif
                            </div>

                            <!-- installation_manual_url -->
                            <div class="row ms-4" id="installation_manual_row">
                                @if(!blank($installation_manual))
                                    @foreach($installation_manual as $key => $installation_manuals)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="installation_manual{{$key}}">Installation Manual URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$installation_manuals->file_url}}" name="installation_manual[]" id="installation_manual{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$installation_manuals->file_name)}}">{{$installation_manuals->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_installation_manual_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_installation_manual_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="installation_manual1">Installation Manual URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="installation_manual[]" id="installation_manual1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_installation_manual_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_installation_manual_field">
                                    </div>
                                @endif
                            </div>

                            <!-- how_to_document_url -->
                            <div class="row ms-4" id="how_to_document_row">
                                @if(!blank($how_to_document))
                                    @foreach($how_to_document as $key => $how_to_documents)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="how_to_document{{$key}}">How to Document URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$how_to_documents->file_url}}" name="how_to_document[]" id="how_to_document{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$how_to_documents->file_name)}}">{{$how_to_documents->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_how_to_document_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_how_to_document_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="how_to_document1">How to Document URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="how_to_document[]" id="how_to_document1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_how_to_document_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_how_to_document_field">
                                    </div>
                                @endif
                            </div>
                            
                            <!-- selection_guide_url -->
                            <div class="row ms-4" id="selection_guide_row">
                                @if(!blank($selection_guide))
                                    @foreach($selection_guide as $key => $selection_guides)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="selection_guide{{$key}}">Selection Guide URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$selection_guides->file_url}}" name="selection_guide[]" id="selection_guide{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$selection_guides->file_name)}}">{{$selection_guides->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_selection_guide_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_selection_guide_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="selection_guide1">Selection Guide URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="selection_guide[]" id="selection_guide1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_selection_guide_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_selection_guide_field">
                                    </div>
                                @endif
                            </div>

                            <!-- video_url -->
                            <div class="row ms-4" id="video_row">
                                @if(!blank($video))
                                    @foreach($video as $key => $videos)
                                        <div class="col-2 step3-label-col mt-3 label{{++$key}}">
                                            <label class="" for="video{{$key}}">Video URL{{$key}}</label>
                                        </div>
                                        <div class="col-10 step3-input-col mt-3 input{{$key}}" style="float:left;">
                                            <input type="text" value="{{$videos->file_url}}" name="video[]" id="video{{$key}}" class="form-control">
                                            <a target="_blank" href="{{asset('digital_asset_images/'.$data[0]->mpn.'/'.$videos->file_name)}}">{{$videos->file_name}}</a>
                                        </div>
                                        @if($loop->first)
                                            <div style="float:left;width:5%" class="mt-4" id="add_video_div">
                                                <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_video_field">
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-2 step3-label-col mt-3 label1">
                                        <label class="" for="video1">Video URL1</label>
                                    </div>
                                    <div class="col-10 step3-input-col mt-3 input1" style="float:left;">
                                        <input type="text" value="" name="video[]" id="video1" class="form-control">
                                    </div>
                                    <div style="float:left;width:5%" class="mt-4" id="add_video_div">
                                        <img src="{{asset('client/images/plus.png')}}" alt="" class="" id="add_video_field">
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Save and Continue Button -->
                            <div class="row ms-4">
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
                                <!-- Ref. Link 4 -->
                                <label class="mt-3" for="ref_link4">Ref. Link 4</label>
                                <input type="text" name="ref_link4" id="ref_link4" class="form-control">
                                <!-- Ref. Link 5 -->
                                <label class="mt-3" for="ref_link5">Ref. Link 5</label>
                                <input type="text" name="ref_link5" id="ref_link5" class="form-control">
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
    
        var pa_started_at = $("#pa_started_at").val();
        
        console.log(pa_started_at)
        if(pa_started_at != null){
            var specificTime = new Date(pa_started_at); // Replace this with your specific time
            var currentTime = new Date();

            var timeDifferenceInSeconds = Math.abs((specificTime.getTime() - currentTime.getTime()) / 1000);
            var seconds = Math.floor(timeDifferenceInSeconds);
        }else{
            var seconds = 0;
        }
        
        var timerInterval;
        startTimer();
        function startTimer() {
          timerInterval = setInterval(updateTimer, 1000);
        }

        function updateTimer() {
          seconds++;
          $('#timer').text(formatTime(seconds));
        }

        function formatTime(seconds) {
          var hours             = Math.floor(seconds / 3600);
          var remainingminutes  = seconds % 3600;
          var minutes           = Math.floor(remainingminutes / 60);
          var remainingSeconds  = seconds % 60;
          return `${pad(hours)}:${pad(minutes)}:${pad(remainingSeconds)}`;
        }

        function pad(value) {
          return value < 10 ? `0${value}` : value;
        }

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

    // Click Download all button to form Submit
    $(document).on("click",".download-btn",function() {
        $("#download_status").val(1);
        $("#steps_form").submit();
    });

    // CKEditor 
    $(document).ready(function() {

        // description_ckeditor
        ClassicEditor.create(document.querySelector('.description_ckeditor'), {
            toolbar: {
                items: [
                    // 'heading', // Include heading
                    // '|',
                    'bold', // Include bold
                    // 'italic', // Include italic
                    '|',
                    'bulletedList', // Include bulleted list
                    // 'numberedList', // Include numbered list
                    // '|',
                    // 'link', // Include link
                    // Add or remove other toolbar items as needed
                ],
                // Configuration for the toolbar
            },
            // Other configurations...
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Editor initialization failed', error);
        });

        // feature_ckeditor
        ClassicEditor.create(document.querySelector('.feature_ckeditor'), {
            toolbar: {
                items: [
                    'bold', // Include bold
                    '|',
                    'bulletedList', // Include bulleted list
                ],
            },
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Editor initialization failed', error);
        });

        // specification_ckeditor
        ClassicEditor.create(document.querySelector('.specification_ckeditor'), {
            toolbar: {
                items: [
                    'bold', // Include bold
                    '|',
                    'bulletedList', // Include bulleted list
                ],
            },
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Editor initialization failed', error);
        });

        // meta_title_ckeditor
        ClassicEditor.create(document.querySelector('.meta_title_ckeditor'), {
            toolbar: {
                items: [
                    'bold', // Include bold
                    '|',
                    'bulletedList', // Include bulleted list
                ],
            },
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Editor initialization failed', error);
        });

        // meta_description_ckeditor
        ClassicEditor.create(document.querySelector('.meta_description_ckeditor'), {
            toolbar: {
                items: [
                    'bold', // Include bold
                    '|',
                    'bulletedList', // Include bulleted list
                ],
            },
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Editor initialization failed', error);
        });

        // meta_keywords_ckeditor
        ClassicEditor.create(document.querySelector('.meta_keywords_ckeditor'), {
            toolbar: {
                items: [
                    'bold', // Include bold
                    '|',
                    'bulletedList', // Include bulleted list
                ],
            },
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Editor initialization failed', error);
        });

        // search_keywords_ckeditor
        ClassicEditor.create(document.querySelector('.search_keywords_ckeditor'), {
            toolbar: {
                items: [
                    'bold', // Include bold
                    '|',
                    'bulletedList', // Include bulleted list
                ],
            },
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Editor initialization failed', error);
        });

    });
    
    // Add Img Src
    $('#add_img_src_field').click(function(){
        var count = $("#img_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="img_src">IMG_SCR'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="img_src[]" id="img_src" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_img_src_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_img_src_field" data-count="'+count+'" id="remove_img_src_field"></div>';
        $("#img_row").append(fieldHTML);
    });
    // Remove Img Src
    $("#img_row").on("click",".remove_img_src_field",function() {
        var count = $(this).attr('data-count');
        $('#img_row .label'+count).remove();
        $('#img_row .input'+count).remove();
        $('#img_row .remove_btn'+count).remove();
    });

    // Add data_360
    $('#add_data_360_field').click(function(){
        var count = $("#data_360_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="data_360_src">Data 360 Spin URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="data_360[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_data_360_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_data_360_field" data-count="'+count+'" id="remove_data_360_field"></div>';
        $("#data_360_row").append(fieldHTML);
    });
    // Remove data_360
    $("#data_360_row").on("click",".remove_data_360_field",function() {
        var count = $(this).attr('data-count');
        $('#data_360_row .label'+count).remove();
        $('#data_360_row .input'+count).remove();
        $('#data_360_row .remove_btn'+count).remove();
    });

    // Add spec_sheet
    $('#add_spec_sheet_field').click(function(){
        var count = $("#spec_sheet_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="spec_sheet_src">Spec Sheet URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="spec_sheet[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_spec_sheet_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_spec_sheet_field" data-count="'+count+'" id="remove_spec_sheet_field"></div>';
        $("#spec_sheet_row").append(fieldHTML);
    });
    // Remove spec_sheet
    $("#spec_sheet_row").on("click",".remove_spec_sheet_field",function() {
        var count = $(this).attr('data-count');
        $('#spec_sheet_row .label'+count).remove();
        $('#spec_sheet_row .input'+count).remove();
        $('#spec_sheet_row .remove_btn'+count).remove();
    });

    // Add part_drawing
    $('#add_part_drawing_field').click(function(){
        var count = $("#part_drawing_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="part_drawing_src">Part Drawing URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="part_drawing[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_part_drawing_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_part_drawing_field" data-count="'+count+'" id="remove_part_drawing_field"></div>';
        $("#part_drawing_row").append(fieldHTML);
    });
    // Remove part_drawing
    $("#part_drawing_row").on("click",".remove_part_drawing_field",function() {
        var count = $(this).attr('data-count');
        $('#part_drawing_row .label'+count).remove();
        $('#part_drawing_row .input'+count).remove();
        $('#part_drawing_row .remove_btn'+count).remove();
    });

    // Add brochure
    $('#add_brochure_field').click(function(){
        var count = $("#brochure_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="brochure_src">Brochure URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="brochure[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_brochure_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_brochure_field" data-count="'+count+'" id="remove_brochure_field"></div>';
        $("#brochure_row").append(fieldHTML);
    });
    // Remove brochure
    $("#brochure_row").on("click",".remove_brochure_field",function() {
        var count = $(this).attr('data-count');
        $('#brochure_row .label'+count).remove();
        $('#brochure_row .input'+count).remove();
        $('#brochure_row .remove_btn'+count).remove();
    });

    // Add catalog_page
    $('#add_catalog_page_field').click(function(){
        var count = $("#catalog_page_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="catalog_page_src">Catalog Page URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="catalog_page[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_catalog_page_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_catalog_page_field" data-count="'+count+'" id="remove_catalog_page_field"></div>';
        $("#catalog_page_row").append(fieldHTML);
    });
    // Remove catalog_page
    $("#catalog_page_row").on("click",".remove_catalog_page_field",function() {
        var count = $(this).attr('data-count');
        $('#catalog_page_row .label'+count).remove();
        $('#catalog_page_row .input'+count).remove();
        $('#catalog_page_row .remove_btn'+count).remove();
    });

    // Add white_paper
    $('#add_white_paper_field').click(function(){
        var count = $("#white_paper_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="white_paper_src">White Paper URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="white_paper[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_white_paper_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_white_paper_field" data-count="'+count+'" id="remove_white_paper_field"></div>';
        $("#white_paper_row").append(fieldHTML);
    });
    // Remove white_paper
    $("#white_paper_row").on("click",".remove_white_paper_field",function() {
        var count = $(this).attr('data-count');
        $('#white_paper_row .label'+count).remove();
        $('#white_paper_row .input'+count).remove();
        $('#white_paper_row .remove_btn'+count).remove();
    });

    // Add warranty_document
    $('#add_warranty_document_field').click(function(){
        var count = $("#warranty_document_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="warranty_document_src">Warranty Document URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="warranty_document[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_warranty_document_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_warranty_document_field" data-count="'+count+'" id="remove_warranty_document_field"></div>';
        $("#warranty_document_row").append(fieldHTML);
    });
    // Remove warranty_document
    $("#warranty_document_row").on("click",".remove_warranty_document_field",function() {
        var count = $(this).attr('data-count');
        $('#warranty_document_row .label'+count).remove();
        $('#warranty_document_row .input'+count).remove();
        $('#warranty_document_row .remove_btn'+count).remove();
    });

    // Add installation_manual
    $('#add_installation_manual_field').click(function(){
        var count = $("#installation_manual_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="installation_manual_src">Installation Manual URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="installation_manual[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_installation_manual_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_installation_manual_field" data-count="'+count+'" id="remove_installation_manual_field"></div>';
        $("#installation_manual_row").append(fieldHTML);
    });
    // Remove installation_manual
    $("#installation_manual_row").on("click",".remove_installation_manual_field",function() {
        var count = $(this).attr('data-count');
        $('#installation_manual_row .label'+count).remove();
        $('#installation_manual_row .input'+count).remove();
        $('#installation_manual_row .remove_btn'+count).remove();
    });

    // Add how_to_document
    $('#add_how_to_document_field').click(function(){
        var count = $("#how_to_document_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="how_to_document_src">How to Document URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="how_to_document[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_how_to_document_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_how_to_document_field" data-count="'+count+'" id="remove_how_to_document_field"></div>';
        $("#how_to_document_row").append(fieldHTML);
    });
    // Remove how_to_document
    $("#how_to_document_row").on("click",".remove_how_to_document_field",function() {
        var count = $(this).attr('data-count');
        $('#how_to_document_row .label'+count).remove();
        $('#how_to_document_row .input'+count).remove();
        $('#how_to_document_row .remove_btn'+count).remove();
    });

    // Add selection_guide
    $('#add_selection_guide_field').click(function(){
        var count = $("#selection_guide_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="selection_guide_src">Selection Guide URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="selection_guide[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_selection_guide_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_selection_guide_field" data-count="'+count+'" id="remove_selection_guide_field"></div>';
        $("#selection_guide_row").append(fieldHTML);
    });
    // Remove selection_guide
    $("#selection_guide_row").on("click",".remove_selection_guide_field",function() {
        var count = $(this).attr('data-count');
        $('#selection_guide_row .label'+count).remove();
        $('#selection_guide_row .input'+count).remove();
        $('#selection_guide_row .remove_btn'+count).remove();
    });

    // Add video
    $('#add_video_field').click(function(){
        var count = $("#video_row .step3-label-col").length;
        count = count + 1;
        label_text = 'label' + count;
        input_text = 'input' + count;
        var fieldHTML = '<div class="col-2 step3-label-col '+label_text+' mt-3"><label class="" for="video_src">Video URL'+count+'</label></div><div class="col-10 step3-input-col '+input_text+' mt-3" style="float:left;"><input type="text" value="" name="video[]" id="" class="form-control"></div><div style="float:left;width:5%" class="mt-4 remove_btn'+count+'" id="remove_video_div"><img src="{{asset("client/images/minus.png")}}" alt="" class="remove_video_field" data-count="'+count+'" id="remove_video_field"></div>';
        $("#video_row").append(fieldHTML);
    });
    // Remove video
    $("#video_row").on("click",".remove_video_field",function() {
        var count = $(this).attr('data-count');
        $('#video_row .label'+count).remove();
        $('#video_row .input'+count).remove();
        $('#video_row .remove_btn'+count).remove();
    });

    // Title Concadination while color on change
    $(document).on("change","#color",function() {
        var brand           = $("#brand_name").val();
        var mpn             = $("#mpn").val();
        var color           = $("#color").val();
        var size            = $("#size").val();
        var product_type    = $("#product_type").val();
        var title           = brand + " " + mpn + " "  + product_type + " "  + color + " "  + size;
        $("#title").val(title);
    });

    // Title Concadination while size on change
    $(document).on("change","#size",function() {
        var brand           = $("#brand_name").val();
        var mpn             = $("#mpn").val();
        var color           = $("#color").val();
        var size            = $("#size").val();
        var product_type    = $("#product_type").val();
        var title           = brand + " " + mpn + " "  + product_type + " "  + color + " "  + size;
        $("#title").val(title);
    });

    // Title Concadination while product_type on change
    $(document).on("change","#product_type",function() {
        var brand           = $("#brand_name").val();
        var mpn             = $("#mpn").val();
        var color           = $("#color").val();
        var size            = $("#size").val();
        var product_type    = $("#product_type").val();
        var title           = brand + " " + mpn + " "  + product_type + " "  + color + " "  + size;
        $("#title").val(title);
    });

    // $('#steps_form').on('submit', function(e) {
    //     var pa_done = $("#pa_done").val();
    //     if(pa_done == 1){
    //         e.preventDefault(); // Prevent the default form submission
            
    //         // AJAX submission example
    //         $.ajax({
    //             type: 'POST',
    //             url: $(this).attr('action'),
    //             data: $(this).serialize(),
    //             success: function(response) {
    //                 // On successful form submission
    //                 alert('Form submitted successfully!');
    //                 window.close(); // Close the window
    //             },
    //             error: function(error) {
    //                 // Handle error if the form submission fails
    //                 console.error(error);
    //             }
    //         });
    //     }

    //     // If you're using traditional form submission, you can directly use window.close() here.
    //     // window.close();
    // });

</script>
 
</body>
</html>