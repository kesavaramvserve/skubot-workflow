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
    <link rel="stylesheet" href="{{ asset('css/report_n.css') }}">
    <style>
        @media print {
            .ignore-print{
                display : none !important;
            }
            .main-section{
                margin-top: 110px! important;
            }
            .site-logo{
                width: 75px;
            }
            .desktop-table-row{
                display: block !important;
            }
            th,td{
                font-size : 7px !important;
            }
            .only-print{
                display : block !important;
            }
            .user-details {
                width: 400px;
            }
            .col-6{
                width:50%;
            }
            .col-12{
                width:100%;
            }
            .overall-score {
                background-size: 93%;
            }
            .pointer-label{
                width:75px;
                margin-top:-2%;
            }
            .pointer{
                width:40px;
                margin-top:0%;
            }
            .pointer-label-content{
                font-size:10px;
                margin-top:-10%;
            }
            .row {
                --bs-gutter-x: 1.5rem;
                --bs-gutter-y: 0;
                display: flex;
                flex-wrap: wrap;
                margin-top: calc(var(--bs-gutter-y) * -1);
                margin-right: calc(var(--bs-gutter-x) * -.5);
                margin-left: calc(var(--bs-gutter-x) * -.5);
            }
            .col-1{
                width: 5%;
            }
            .col-10{
                width: 90%;
            }
            
            .chart-row{
                width:100%;
            }
            .chart-column{
                min-height: 330px;
                background-color: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-left:3%;
                margin-top:5%;
                width:95%;
                border-radius:10px;
            }
            .chart-section{
                width:30%;
                min-height: 50px !important;
                margin-left: 1% !important;
                margin-top: -8% !important;
                background-color: transparent !important;
                float:left;
            }
            .score{
                margin-left: 10% !important;
                margin-top: -45% !important;
            }
            #score-title, #score-description, #score-feature, #score-specification, #score-image{
                font-size:15px !important;
            }
            /* #overall_row{
                page-break-after: always;
            } */
            #title-row{
                page-break-after: always;
            }
            #feature-row{
                page-break-after: always;
            }
            #specification-row{
                page-break-before: always;
            }
            #image-row{
                page-break-after: always;
            }
            .chart-content-section{
                float:left;
                width:65%;
                min-height: 50px !important;
                font-size:5px !important;
            }
            .chart-content1, .chart-content2, .chart-content3, .chart-content4{
                height: 250px !important;
            }
            .enhance-heading{
                margin-top: 10%;
            }
        }
        .only-print{
            display : none;
        }
    </style>
</head>
<body>
<?php $route = Route::current()->getName(); ?>
<?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($website_id); ?>
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
                                <h6 class="user-name">{{ auth()->user()->first_name }}</h6>
                                <span class="user-role">({{ auth()->user()->getRole->name }})</span>
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
                <div class="float-end user-details only-print">
                    <div class="row">
                        <!-- Website -->
                        <div class="col-6">
                            <!-- Icon -->
                            <div style="float: left;" class="mt-3">
                                <img src="{{asset('images/website-white.png')}}" alt="Back" class="" width="30px">
                            </div>
                            <!-- Text -->
                            <div style="float: left;color:white;margin-left:5%">
                                <div style="margin-top:2%">
                                    <span style="font-size:10px;">Website</span>
                                </div>
                                <div>
                                    <span style="color:white;font-size:10px;">{{$website_name}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Total SKU -->
                        <div class="col-6">
                            <!-- Icon -->
                            <div style="float: left;" class="mt-3">
                                <img src="{{asset('images/total-sku-white.png')}}" alt="Back" class="" width="30px">
                            </div>
                            <!-- Text -->
                            <div style="float: left;color:white;margin-left:5%">
                                <div style="margin-top:2%">
                                    <span style="font-size:10px;">Total SKU</span>
                                </div>
                                <div>
                                    <span style="color:white;font-size:10px;">{{$total_sku}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->

        <!-- Main section 1 -->
        <div class="row ">
            <div class="col-1"></div>
            <div class="main-section col-10">
                <!-- Page Heading -->
                <div class="row heading ignore-print">
                    <!-- Back icon with Page heading -->
                    <div class="col-md-3 col-xs-12">
                        <div style="float: left;" class="mt-3">
                            @if($route == 'scrape_view')
                                <a href="{{route('set_range',$enc_id)}}"><img src="{{asset('images/back.png')}}" alt="Back" class="" width="35px"></a>
                            @elseif($route == 'enhance_result')
                                <a href="{{route('website_list.index')}}"><img src="{{asset('images/back.png')}}" alt="Back" class="" width="35px"></a>
                            @endif
                        </div>
                        <div style="float: left;" class="mt-3">
                            <span class="page-heading">Report</span>
                        </div>
                    </div>
                    <!-- Website -->
                    <div class="col-md-4 col-xs-12">
                        <!-- Icon -->
                        <div style="float: left;margin-left: 20%;" class="mt-3  website-icon">
                            <img src="{{asset('images/website.png')}}" alt="Back" class="" width="50px">
                        </div>
                        <!-- Text -->
                        <div style="float: left;" class="mt-3 float-end">
                            <div>
                                <span class="">Website</span>
                            </div>
                            <div>
                                <span style="font-weight: 600;">{{$website_name}}</span style="font-weight: 500;">
                            </div>
                        </div>
                    </div>
                    <!-- Total SKU -->
                    <div class="col-md-2 col-xs-12">
                        <!-- Icon -->
                        <div style="float: left;margin-left: 20%;" class="mt-3  sku-icon">
                            <img src="{{asset('images/total-sku.png')}}" alt="Back" class="" width="50px">
                        </div>
                        <!-- Text -->
                        <div style="float: left;" class="mt-3 float-end  sku-text">
                            <div>
                                <span class="">Total SKU</span>
                            </div>
                            <div>
                                <span style="font-weight: 600;">{{$total_sku}}</span style="font-weight: 500;">
                            </div>
                        </div>
                    </div>
                    <!-- Print Report -->
                    <div class="col-md-3 col-xs-12 print-div">
                        <!-- Icon -->
                        <div style="float: left;margin-left: 40%;" class="mt-3">
                            <img src="{{asset('images/print.png')}}" alt="Back" class="" width="50px">
                        </div>
                        <!-- Text -->
                        <div style="float: left;margin-top: 12%;" class="float-end">
                            <div>
                                <span class="cmd" style="cursor:pointer;" id="cmd">Print Report</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter Form Details -->
                @if($route == 'scrape_view')
                <form action="{{route('scrape_view',$website_id)}}" method="get">
                @elseif($route == 'enhance_result')
                <form action="{{route('enhance_result',$website_id)}}" method="get">
                    @endif
                    @csrf
                    @method('GET')
                    <input type="hidden" value="{{$website_id}}" name="website_id">
                    <input type="hidden" value="{{$title[0]}}" name="title[]">
                    <input type="hidden" value="{{$title[1]}}" name="title[]">
                    <input type="hidden" value="{{$title[2]}}" name="title[]">
                    <input type="hidden" value="{{$title[3]}}" name="title[]">
                    <input type="hidden" value="{{$title[4]}}" name="title[]">

                    <input type="hidden" value="{{$feature[0]}}" name="feature[]">
                    <input type="hidden" value="{{$feature[1]}}" name="feature[]">
                    <input type="hidden" value="{{$feature[2]}}" name="feature[]">
                    <input type="hidden" value="{{$feature[3]}}" name="feature[]">
                    <input type="hidden" value="{{$feature[4]}}" name="feature[]">

                    <input type="hidden" value="{{$description[0]}}" name="description[]">
                    <input type="hidden" value="{{$description[1]}}" name="description[]">
                    <input type="hidden" value="{{$description[2]}}" name="description[]">
                    <input type="hidden" value="{{$description[3]}}" name="description[]">
                    <input type="hidden" value="{{$description[4]}}" name="description[]">

                    <input type="hidden" value="{{$specification[0]}}" name="specification[]">
                    <input type="hidden" value="{{$specification[1]}}" name="specification[]">
                    <input type="hidden" value="{{$specification[2]}}" name="specification[]">
                    <input type="hidden" value="{{$specification[3]}}" name="specification[]">
                    <input type="hidden" value="{{$specification[4]}}" name="specification[]">

                    <input type="hidden" value="{{$image[0]}}" name="image[]">
                    <input type="hidden" value="{{$image[1]}}" name="image[]">
                    <input type="hidden" value="{{$image[2]}}" name="image[]">
                    <input type="hidden" value="{{$image[3]}}" name="image[]">
                    <input type="hidden" value="{{$image[4]}}" name="image[]">

                    <input type="hidden" value="{{$data[0]->title_status}}" id="title_status">
                    <input type="hidden" value="{{$data[0]->description_status}}" id="description_status">
                    <input type="hidden" value="{{$data[0]->feature_status}}" id="feature_status">
                    <input type="hidden" value="{{$data[0]->specification_status}}" id="specification_status">
                    <input type="hidden" value="{{$data[0]->image_status}}" id="image_status">
                    <input type="hidden" value="1" id="filter_status" name="filter_status">
                    <!-- Filter Section -->
                    <div class="row filter-section ignore-print">
                        <!-- Category -->
                        <div class="col-md-3 col-xs-12 mb-3">
                            <select name="category" id="category" class="filter-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}" {{$category->category== $req_category ? 'selected' : ''}}>{{substr($category->category, strrpos($category->category, '>') + 1)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Brand -->
                        <div class="col-md-3 col-xs-12 mb-3">
                            <select name="brand" id="brand" class="filter-select">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->brand}}" {{$brand->brand == $req_brand ? 'selected' : ''}}>{{$brand->brand}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- submit-button -->
                        <div class="col-md-2 col-xs-5">
                            <input type="submit" value="SUBMIT" class="btn submit-button submit-tag">
                            <hr class="hr">
                        </div>
                        <!-- Notes -->
                        <div class="col-md-2 col-xs-2 ">
                            <!-- <a href="javascript:void(0)" class="btn submit-button-reverse float-end notes" data-id="{{$website_id}}">Notes</a> -->
                        </div>
                        <!-- Send Email -->
                        <div class="col-md-2 col-xs-5 ">
                            <a href="javascript:void(0)" class="btn submit-button-reverse  notes" data-id="{{$website_id}}">Notes</a>
                            @if(auth()->user()->getRole->name == 'Operation' || auth()->user()->getRole->name == 'Power User')
                                @if($route == 'scrape_view')
                                    <a href="{{route('send_mail',$website_id)}}" class="btn submit-button float-end" >SEND MAIL</a>
                                @elseif($route == 'enhance_result')
                                    <a href="{{route('send_enhance_mail',$website_id)}}" class="btn submit-button float-end" >SEND MAIL</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </form>

                <!-- Desktop Table Start -->
                <div class="row desktop-table-row">
                    <div class="col-12 table-responsive table-section">
                        <table class="table">
                            <thead>
                                <th class="head1">SKU Analysis</th>
                                <th class="head2">High attention required (1)</th>
                                <th class="head3">Needs Improvement (2)</th>
                                <th class="head4">Good To Improve (3)</th>
                                <th class="head5">Average Optimized (4)</th>
                                <th class="head6">Optimized (5)</th>
                            </thead>
                            <tbody>
                                @if($data[0]->title_status == 1)
                                <!-- Title -->
                                <tr class="table-row">
                                    <!-- Data 1 Heading -->
                                    <td class="data1">Title Characters</td>
                                    <!-- Data 2 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">0 - {{$title[0]}} Characters</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$title_report[0]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$title_pres_report[0]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data1-progress">
                                                    <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$title_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 3 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{++$title[0]}} - {{$title[1]}} Characters</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$title_report[1]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$title_pres_report[1]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data3-progress">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$title_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 4 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{++$title[1]}} - {{$title[2]}} Characters</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$title_report[2]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$title_pres_report[2]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data4-progress">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$title_pres_report[2]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 5 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{++$title[2]}} - {{$title[3]}} Characters</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$title_report[3]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$title_pres_report[3]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data5-progress">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$title_pres_report[3]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 6 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$title[4]++}}+ Characters</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$title_report[4]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$title_pres_report[4]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data6-progress">
                                                    <div class="progress-bar data6-progress-bar" role="progressbar" style="width: {{$title_pres_report[4]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($data[0]->description_status == 1)
                                <!-- Description -->
                                <tr class="table-row">
                                    <!-- Data 1 Heading -->
                                    <td class="data1">Description Words</td>
                                    <!-- Data 2 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">0 - {{$description[0]}} Words</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$description_report[0]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$description_pres_report[0]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data1-progress">
                                                    <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$description_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 3 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{++$description[0]}} - {{$description[1]}} Words</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$description_report[1]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$description_pres_report[1]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data3-progress">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$description_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 4 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{++$description[1]}} - {{$description[2]}} Words</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$description_report[2]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$description_pres_report[2]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data4-progress">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$description_pres_report[2]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 5 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{++$description[2]}} - {{$description[3]}} Words</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$description_report[3]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$description_pres_report[3]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data5-progress">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$description_pres_report[3]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 6 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$description[4]++}}+ Words</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$description_report[4]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$description_pres_report[4]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data6-progress">
                                                    <div class="progress-bar data6-progress-bar" role="progressbar" style="width: {{$description_pres_report[4]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($data[0]->feature_status == 1)
                                <!-- Feature -->
                                <tr class="table-row">
                                    <!-- Data 1 Heading -->
                                    <td class="data1">Feature Bullets Count</td>
                                    <!-- Data 2 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$feature[0]}} Features</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$feature_report[0]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$feature_pres_report[0]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data1-progress">
                                                    <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$feature_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 3 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$feature[1]}} Features</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$feature_report[1]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$feature_pres_report[1]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data3-progress">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$feature_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 4 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$feature[2]}} Features</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$feature_report[2]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$feature_pres_report[2]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data4-progress">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$feature_pres_report[2]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 5 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$feature[3]}} Features</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$feature_report[3]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$feature_pres_report[3]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data5-progress">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$feature_pres_report[3]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 6 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$feature[4]++}}+ Features</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$feature_report[4]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$feature_pres_report[4]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data6-progress">
                                                    <div class="progress-bar data6-progress-bar" role="progressbar" style="width: {{$feature_pres_report[4]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($data[0]->specification_status == 1)
                                <!-- Specification -->
                                <tr class="table-row">
                                    <!-- Data 1 Heading -->
                                    <td class="data1">Prod Specifications Count</td>
                                    <!-- Data 2 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$specification[0]}} Specifications</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$specification_report[0]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$specification_pres_report[0]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data1-progress">
                                                    <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$specification_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 3 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$specification[1]}} Specifications</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$specification_report[1]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$specification_pres_report[1]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data3-progress">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$specification_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 4 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$specification[2]}} Specifications</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$specification_report[2]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$specification_pres_report[2]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data4-progress">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$specification_pres_report[2]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 5 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$specification[3]}} Specifications</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$specification_report[3]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$specification_pres_report[3]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data5-progress">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$specification_pres_report[3]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 6 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$specification[4]++}}+ Specifications</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$specification_report[4]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$specification_pres_report[4]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data6-progress">
                                                    <div class="progress-bar data6-progress-bar" role="progressbar" style="width: {{$specification_pres_report[4]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($data[0]->image_status == 1)
                                <!-- Image -->
                                <tr class="table-row">
                                    <!-- Data 1 Heading -->
                                    <td class="data1">Images Count</td>
                                    <!-- Data 2 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$image[0]}} Images</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$image_report[0]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$image_pres_report[0]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data1-progress">
                                                    <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$image_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 3 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$image[1]}} Images</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$image_report[1]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$image_pres_report[1]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data3-progress">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$image_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 4 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$image[2]}} Images</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$image_report[2]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$image_pres_report[2]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data4-progress">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$image_pres_report[2]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 5 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$image[3]}} Images</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$image_report[3]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$image_pres_report[3]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data5-progress">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$image_pres_report[3]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Data 6 -->
                                    <td class="">
                                        <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">{{$image[4]++}}+ Images</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-8">
                                                <span class="float-start">{{$image_report[4]}} SKUs</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-4">
                                                <span class="float-end">({{$image_pres_report[4]}}%)</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-12">
                                                <div class="progress data6-progress">
                                                    <div class="progress-bar data6-progress-bar" role="progressbar" style="width: {{$image_pres_report[4]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Desktop Table End -->

                <!-- Mobile Table Start -->
                <div class="row mobile-table-row ignore-print">
                    <div class="accordion" id="accordionExample">
                        <!-- Title -->
                        @if($data[0]->title_status == 1)
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Title Characters
                            </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table>
                                    <thead>
                                        <th>
                                            High attention required (1)
                                            <div class="progress data1-progress" style="width: 80%">
                                                <div class="progress-bar data1-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">0 - {{$title[0]}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-7">
                                                    <span class="float-start" style="color:#E03F35">{{$title_report[0]}} SKUs</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-5">
                                                    <span class="float-end">({{$title_pres_report[0]}}%)</span>
                                                </div>
                                                <!-- Progress Bar -->
                                                <div class="col-12">
                                                    <div class="progress data1-progress">
                                                        <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$title_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>                     
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                Needs Improvement (2)
                                                <div class="progress data2-progress" style="width: 80%">
                                                    <div class="progress-bar data2-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$title[0]}} - {{$title[1]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#FFD3D0">{{$title_report[1]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$title_pres_report[1]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data2-progress">
                                                            <div class="progress-bar data2-progress-bar" role="progressbar" style="width: {{$title_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Good To Improve<br> (3)
                                                <div class="progress data3-progress" style="width: 80%">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$title[1]}} - {{$title[2]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#EEBF4B">{{$title_report[2]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$title_pres_report[2]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data3-progress">
                                                            <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$title_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Average Optimized<br> (4)
                                                <div class="progress data4-progress" style="width: 80%">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$title[2]}} - {{$title[3]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-8">
                                                        <span class="float-start" style="color:#92CA92">{{$title_report[3]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-4">
                                                        <span class="float-end">({{$title_pres_report[3]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data4-progress">
                                                            <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$title_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Optimized<br> (5)
                                                <div class="progress data5-progress" style="width: 80%">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{$title[4]++}}+</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#39BC86">{{$title_report[4]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$title_pres_report[4]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data5-progress">
                                                            <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$title_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        @endif
                        @if($data[0]->description_status == 1)
                        <!-- Description -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Description Words
                            </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table>
                                    <thead>
                                        <th>
                                            High attention required (1)
                                            <div class="progress data1-progress" style="width: 80%">
                                                <div class="progress-bar data1-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">0 - {{$description[0]}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-7">
                                                    <span class="float-start" style="color:#E03F35">{{$description_report[0]}} SKUs</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-5">
                                                    <span class="float-end">({{$description_pres_report[0]}}%)</span>
                                                </div>
                                                <!-- Progress Bar -->
                                                <div class="col-12">
                                                    <div class="progress data1-progress">
                                                        <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$description_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>                     
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                Needs Improvement (2)
                                                <div class="progress data2-progress" style="width: 80%">
                                                    <div class="progress-bar data2-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$description[0]}} - {{$description[1]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#FFD3D0">{{$description_report[1]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$description_pres_report[1]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data2-progress">
                                                            <div class="progress-bar data2-progress-bar" role="progressbar" style="width: {{$description_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Good To Improve<br> (3)
                                                <div class="progress data3-progress" style="width: 80%">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$description[1]}} - {{$description[2]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#EEBF4B">{{$description_report[2]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$description_pres_report[2]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data3-progress">
                                                            <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$description_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Average Optimized<br> (4)
                                                <div class="progress data4-progress" style="width: 80%">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$description[2]}} - {{$description[3]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-8">
                                                        <span class="float-start" style="color:#92CA92">{{$description_report[3]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-4">
                                                        <span class="float-end">({{$description_pres_report[3]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data4-progress">
                                                            <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$description_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Optimized<br> (5)
                                                <div class="progress data5-progress" style="width: 80%">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{$description[4]++}}+</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#39BC86">{{$description_report[4]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$description_pres_report[4]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data5-progress">
                                                            <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$description_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        @endif
                        @if($data[0]->feature_status == 1)
                        <!-- Feature -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Feature Bullets Count
                            </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table>
                                    <thead>
                                        <th>
                                            High attention required (1)
                                            <div class="progress data1-progress" style="width: 80%">
                                                <div class="progress-bar data1-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">0 - {{$feature[0]}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-7">
                                                    <span class="float-start" style="color:#E03F35">{{$feature_report[0]}} SKUs</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-5">
                                                    <span class="float-end">({{$feature_pres_report[0]}}%)</span>
                                                </div>
                                                <!-- Progress Bar -->
                                                <div class="col-12">
                                                    <div class="progress data1-progress">
                                                        <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$feature_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>                     
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                Needs Improvement (2)
                                                <div class="progress data2-progress" style="width: 80%">
                                                    <div class="progress-bar data2-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$feature[0]}} - {{$feature[1]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#FFD3D0">{{$feature_report[1]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$feature_pres_report[1]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data2-progress">
                                                            <div class="progress-bar data2-progress-bar" role="progressbar" style="width: {{$feature_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Good To Improve<br> (3)
                                                <div class="progress data3-progress" style="width: 80%">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$feature[1]}} - {{$feature[2]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#EEBF4B">{{$feature_report[2]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$feature_pres_report[2]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data3-progress">
                                                            <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$feature_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Average Optimized<br> (4)
                                                <div class="progress data4-progress" style="width: 80%">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$feature[2]}} - {{$feature[3]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-8">
                                                        <span class="float-start" style="color:#92CA92">{{$feature_report[3]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-4">
                                                        <span class="float-end">({{$feature_pres_report[3]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data4-progress">
                                                            <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$feature_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Optimized<br> (5)
                                                <div class="progress data5-progress" style="width: 80%">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{$feature[4]++}}+</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#39BC86">{{$feature_report[4]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$feature_pres_report[4]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data5-progress">
                                                            <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$feature_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        @endif
                        @if($data[0]->specification_status == 1)
                        <!-- Specification -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Prod Specifications Count
                            </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table>
                                    <thead>
                                        <th>
                                            High attention required (1)
                                            <div class="progress data1-progress" style="width: 80%">
                                                <div class="progress-bar data1-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">0 - {{$specification[0]}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-7">
                                                    <span class="float-start" style="color:#E03F35">{{$specification_report[0]}} SKUs</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-5">
                                                    <span class="float-end">({{$specification_pres_report[0]}}%)</span>
                                                </div>
                                                <!-- Progress Bar -->
                                                <div class="col-12">
                                                    <div class="progress data1-progress">
                                                        <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$specification_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>                     
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                Needs Improvement (2)
                                                <div class="progress data2-progress" style="width: 80%">
                                                    <div class="progress-bar data2-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$specification[0]}} - {{$specification[1]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#FFD3D0">{{$specification_report[1]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$specification_pres_report[1]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data2-progress">
                                                            <div class="progress-bar data2-progress-bar" role="progressbar" style="width: {{$specification_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Good To Improve<br> (3)
                                                <div class="progress data3-progress" style="width: 80%">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$specification[1]}} - {{$specification[2]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#EEBF4B">{{$specification_report[2]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$specification_pres_report[2]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data3-progress">
                                                            <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$specification_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Average Optimized<br> (4)
                                                <div class="progress data4-progress" style="width: 80%">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$specification[2]}} - {{$specification[3]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-8">
                                                        <span class="float-start" style="color:#92CA92">{{$specification_report[3]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-4">
                                                        <span class="float-end">({{$specification_pres_report[3]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data4-progress">
                                                            <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$specification_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Optimized<br> (5)
                                                <div class="progress data5-progress" style="width: 80%">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{$specification[4]++}}+</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#39BC86">{{$specification_report[4]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$specification_pres_report[4]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data5-progress">
                                                            <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$specification_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        @endif
                        @if($data[0]->image_status == 1)
                        <!-- Image -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Images Count
                            </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table>
                                    <thead>
                                        <th>
                                            High attention required (1)
                                            <div class="progress data1-progress" style="width: 80%">
                                                <div class="progress-bar data1-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">0 - {{$image[0]}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-7">
                                                    <span class="float-start" style="color:#E03F35">{{$image_report[0]}} SKUs</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-5">
                                                    <span class="float-end">({{$image_pres_report[0]}}%)</span>
                                                </div>
                                                <!-- Progress Bar -->
                                                <div class="col-12">
                                                    <div class="progress data1-progress">
                                                        <div class="progress-bar data1-progress-bar" role="progressbar" style="width: {{$image_pres_report[0]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>                     
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                Needs Improvement (2)
                                                <div class="progress data2-progress" style="width: 80%">
                                                    <div class="progress-bar data2-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$image[0]}} - {{$image[1]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#FFD3D0">{{$image_report[1]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$image_pres_report[1]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data2-progress">
                                                            <div class="progress-bar data2-progress-bar" role="progressbar" style="width: {{$image_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Good To Improve<br> (3)
                                                <div class="progress data3-progress" style="width: 80%">
                                                    <div class="progress-bar data3-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$image[1]}} - {{$image[2]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#EEBF4B">{{$image_report[2]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$image_pres_report[2]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data3-progress">
                                                            <div class="progress-bar data3-progress-bar" role="progressbar" style="width: {{$image_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Average Optimized<br> (4)
                                                <div class="progress data4-progress" style="width: 80%">
                                                    <div class="progress-bar data4-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{++$image[2]}} - {{$image[3]}}</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-8">
                                                        <span class="float-start" style="color:#92CA92">{{$image_report[3]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-4">
                                                        <span class="float-end">({{$image_pres_report[3]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data4-progress">
                                                            <div class="progress-bar data4-progress-bar" role="progressbar" style="width: {{$image_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Optimized<br> (5)
                                                <div class="progress data5-progress" style="width: 80%">
                                                    <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="row data-row">
                                                    <!-- Range -->
                                                    <div class="col-12">
                                                        <span class="float-start">{{$image[4]++}}+</span>
                                                    </div>
                                                    <!-- SKU Count -->
                                                    <div class="col-7">
                                                        <span class="float-start" style="color:#39BC86">{{$image_report[4]}} SKUs</span>
                                                    </div>
                                                    <!-- SKU Percentage -->
                                                    <div class="col-5">
                                                        <span class="float-end">({{$image_pres_report[4]}}%)</span>
                                                    </div>
                                                    <!-- Progress Bar -->
                                                    <div class="col-12">
                                                        <div class="progress data5-progress">
                                                            <div class="progress-bar data5-progress-bar" role="progressbar" style="width: {{$image_pres_report[1]}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Mobile Table End -->

            </div>
            <div class="col-1"></div>
        </div>

        <!-- Main section 2 -->
        <div class="row " id="overall_row">
            <div class="col-1"></div>
            <div class="main-section-2 col-10">
                <div class="row mt-3">
                    <div class="col-12">
                        <h6><b>Overall Score</b></h6>
                    </div>
                    <?php
                        $overall = ((number_format($overall_score,2) * 2) * 10);
                        $pointer_label          = $overall - 6;
                        $pointer                = $overall - 3;
                        $pointer_label_content  = $overall - 1;
                    ?>
                    <div class="col-md-12 col-xs-12 overall-score">
                        <img src="{{asset('images/pointer-label.png')}}" alt="" class="pointer-label" style="margin-left: {{$pointer_label}}%;">
                        <br>
                        <img src="{{asset('images/pointer.png')}}" alt="" class="pointer" style="margin-left: {{$pointer}}%;">
                        <br>
                        <div class="pointer-label-content" style="margin-left: {{$pointer_label_content}}%;">
                            <span>{{number_format($overall_score,2)}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>

        <!-- Main section 3 -->
        <div class="row mb-5 ignore-print">
            <div class="col-1"></div>
            <div class="main-section-3 col-10">
                <div class="row mt-3">
                    <div class="col-md-12 col-xs-12">
                        <select name="" id="analysis" class="analysis-select">
                            <option value="Title Character">Title Character Analysis</option>
                            <option value="Description Words">Description Words Analysis</option>
                            <option value="Feature Bullets Count">Feature Bullets Count Analysis</option>
                            <option value="Prod Specifications Count">Prod Specifications Count Analysis</option>
                            <option value="Images Count">Images Count Analysis</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row ignore-print">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="row">
                    <div class="col-md-3 col-xs-12 chart-section">
                        <div id="title_chart" class="chart">
                        
                        </div>
                        <div id="description_chart" class="chart">
                        
                        </div>
                        <div id="feature_chart" class="chart">
                        
                        </div>
                        <div id="specification_chart" class="chart">
                        
                        </div>
                        <div id="image_chart" class="chart">
                        
                        </div>
                        <div class="text-center">
                            <h4 id="score-title">Title Score</h4>
                        </div>
                    </div>
                    <div class="col-md-9 col-xs-12 content-section mt-4">
                        <?php  
                            $title_arr                  = explode("<li>", $title_notes);
                            $description_arr            = explode("<li>", $description_notes);
                            $feature_arr                = explode("<li>", $feature_notes);
                            $specification_arr          = explode("<li>", $specification_notes);
                            $image_arr                  = explode("<li>", $image_notes);
                        ?>
                        <!-- Title Content Section -->
                        <div class="content-show content-class" id="title-content">
                            <div class="row desktop-chart-content">
                                <?php $title_val = 1; ?>
                                @if($title_report[0] != 0)
                                <div class="chart-content1  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #E03F35;">
                                        <span style="font-size: 25px;">{{$title_report[0]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$title_arr[$title_val]}}</p>
                                        <?php $title_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot1"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">High attention required (1)</span>
                                            <br>
                                            <span class="sku-percentange">{{$title_pres_report[0]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($title_report[1] != 0)
                                <div class="chart-content2  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #FFD3D0;">
                                        <span style="font-size: 25px;">{{$title_report[1]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$title_arr[$title_val]}}</p>
                                        <?php $title_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot2"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Needs Improvement (2)</span>
                                            <br>
                                            <span class="sku-percentange">{{$title_pres_report[1]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($title_report[2] != 0)
                                <div class="chart-content3  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #EEBF4B;">
                                        <span style="font-size: 25px;">{{$title_report[2]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$title_arr[$title_val]}}</p>
                                        <?php $title_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot3"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Good To Improve (3)</span>
                                            <br>
                                            <span class="sku-percentange">{{$title_pres_report[2]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($title_report[3] != 0)
                                <div class="chart-content4  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #92CA92;">
                                        <span style="font-size: 25px;">{{$title_report[3]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$title_arr[$title_val]}}</p>
                                        <?php $title_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot4"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Average Optimized (4)</span>
                                            <br>
                                            <span class="sku-percentange">{{$title_pres_report[3]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row mobile-chart-content">
                                <div class="accordion" id="accordionExample">
                                    
                                    <?php $title_val = 1; ?>
                                    @if($title_report[0] != 0)
                                    <!-- Range1 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #E03F35;">
                                        <h2 class="accordion-header" id="headingMobileOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileOne" aria-expanded="true" aria-controls="collapseMobileOne">
                                                <span style="font-size: 25px;font-weight: bold;color: #E03F35;">{{$title_report[0]}} </span><span style="margin-left: 3%;color: #E03F35;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileOne" class="accordion-collapse collapse show" aria-labelledby="headingMobileOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$title_arr[$title_val]}}</p>
                                                <?php $title_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileOne">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot1"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">High attention required (1)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$title_pres_report[0]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($title_report[1] != 0)
                                    <!-- Range2 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #FFD3D0;">
                                        <h2 class="accordion-header" id="headingMobileTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileTwo" aria-expanded="true" aria-controls="collapseMobileTwo">
                                                <span style="font-size: 25px;font-weight: bold;color: #FFD3D0;">{{$title_report[1]}} </span><span style="margin-left: 3%;color: #FFD3D0;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileTwo" class="accordion-collapse collapse" aria-labelledby="headingMobileTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$title_arr[$title_val]}}</p>
                                                <?php $title_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileTwo">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot2"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Needs Improvement (2)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$title_pres_report[1]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($title_report[2] != 0)
                                    <!-- Range3 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #EEBF4B;">
                                        <h2 class="accordion-header" id="headingMobileThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileThree" aria-expanded="true" aria-controls="collapseMobileThree">
                                                <span style="font-size: 25px;font-weight: bold;color: #EEBF4B;">{{$title_report[2]}} </span><span style="margin-left: 3%;color: #EEBF4B;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileThree" class="accordion-collapse collapse" aria-labelledby="headingMobileThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$title_arr[$title_val]}}</p>
                                                <?php $title_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileThree">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot3"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Good To Improve (3)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$title_pres_report[2]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($title_report[3] != 0)
                                    <!-- Range4 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #92CA92;">
                                        <h2 class="accordion-header" id="headingMobileFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileFour" aria-expanded="true" aria-controls="collapseMobileFour">
                                                <span style="font-size: 25px;font-weight: bold;color: #92CA92;">{{$title_report[3]}} </span><span style="margin-left: 3%;color: #92CA92;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileFour" class="accordion-collapse collapse" aria-labelledby="headingMobileFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$title_arr[$title_val]}}</p>
                                                <?php $title_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileFour">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot4"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Average Optimized (4)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$title_pres_report[3]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Description Content Section -->
                        <div class="content-hide content-class" id="description-content">
                            <div class="row desktop-chart-content">
                                <?php $description_val = 1; ?>
                                @if($description_report[0] != 0)
                                <div class="chart-content1  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #E03F35;">
                                        <span style="font-size: 25px;">{{$description_report[0]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$description_arr[$description_val]}}</p>
                                        <?php $description_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot1"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">High attention required (1)</span>
                                            <br>
                                            <span class="sku-percentange">{{$description_pres_report[0]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($description_report[1] != 0)
                                <div class="chart-content2  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #FFD3D0;">
                                        <span style="font-size: 25px;">{{$description_report[1]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$description_arr[$description_val]}}</p>
                                        <?php $description_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot2"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Needs Improvement (2)</span>
                                            <br>
                                            <span class="sku-percentange">{{$description_pres_report[1]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($description_report[2] != 0)
                                <div class="chart-content3  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #EEBF4B;">
                                        <span style="font-size: 25px;">{{$description_report[2]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$description_arr[$description_val]}}</p>
                                        <?php $description_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot3"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Good To Improve (3)</span>
                                            <br>
                                            <span class="sku-percentange">{{$description_pres_report[2]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($description_report[3] != 0)
                                <div class="chart-content4  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #92CA92;">
                                        <span style="font-size: 25px;">{{$description_report[3]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$description_arr[$description_val]}}</p>
                                        <?php $description_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot4"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Average Optimized (4)</span>
                                            <br>
                                            <span class="sku-percentange">{{$description_pres_report[3]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row mobile-chart-content">
                                <div class="accordion" id="accordionExample">
                                    
                                    <?php $description_val = 1; ?>
                                    @if($description_report[0] != 0)
                                    <!-- Range1 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #E03F35;">
                                        <h2 class="accordion-header" id="headingMobileOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileOne" aria-expanded="true" aria-controls="collapseMobileOne">
                                                <span style="font-size: 25px;font-weight: bold;color: #E03F35;">{{$description_report[0]}} </span><span style="margin-left: 3%;color: #E03F35;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileOne" class="accordion-collapse collapse show" aria-labelledby="headingMobileOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$description_arr[$description_val]}}</p>
                                                <?php $description_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileOne">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot1"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">High attention required (1)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$description_pres_report[0]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($description_report[1] != 0)
                                    <!-- Range2 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #FFD3D0;">
                                        <h2 class="accordion-header" id="headingMobileTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileTwo" aria-expanded="true" aria-controls="collapseMobileTwo">
                                                <span style="font-size: 25px;font-weight: bold;color: #FFD3D0;">{{$description_report[1]}} </span><span style="margin-left: 3%;color: #FFD3D0;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileTwo" class="accordion-collapse collapse" aria-labelledby="headingMobileTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$description_arr[$description_val]}}</p>
                                                <?php $description_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileTwo">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot2"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Needs Improvement (2)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$description_pres_report[1]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($description_report[2] != 0)
                                    <!-- Range3 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #EEBF4B;">
                                        <h2 class="accordion-header" id="headingMobileThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileThree" aria-expanded="true" aria-controls="collapseMobileThree">
                                                <span style="font-size: 25px;font-weight: bold;color: #EEBF4B;">{{$description_report[2]}} </span><span style="margin-left: 3%;color: #EEBF4B;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileThree" class="accordion-collapse collapse" aria-labelledby="headingMobileThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$description_arr[$description_val]}}</p>
                                                <?php $description_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileThree">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot3"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Good To Improve (3)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$description_pres_report[2]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($description_report[3] != 0)
                                    <!-- Range4 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #92CA92;">
                                        <h2 class="accordion-header" id="headingMobileFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileFour" aria-expanded="true" aria-controls="collapseMobileFour">
                                                <span style="font-size: 25px;font-weight: bold;color: #92CA92;">{{$description_report[3]}} </span><span style="margin-left: 3%;color: #92CA92;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileFour" class="accordion-collapse collapse" aria-labelledby="headingMobileFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$description_arr[$description_val]}}</p>
                                                <?php $description_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileFour">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot4"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Average Optimized (4)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$description_pres_report[3]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Feature Content Section -->
                        <div class="content-hide content-class" id="feature-content">
                            <div class="row desktop-chart-content">
                                <?php $feature_val = 1; ?>
                                @if($feature_report[0] != 0)
                                <div class="chart-content1  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #E03F35;">
                                        <span style="font-size: 25px;">{{$feature_report[0]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$feature_arr[$feature_val]}}</p>
                                        <?php $feature_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot1"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">High attention required (1)</span>
                                            <br>
                                            <span class="sku-percentange">{{$feature_pres_report[0]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($feature_report[1] != 0)
                                <div class="chart-content2  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #FFD3D0;">
                                        <span style="font-size: 25px;">{{$feature_report[1]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$feature_arr[$feature_val]}}</p>
                                        <?php $feature_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot2"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Needs Improvement (2)</span>
                                            <br>
                                            <span class="sku-percentange">{{$feature_pres_report[1]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($feature_report[2] != 0)
                                <div class="chart-content3  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #EEBF4B;">
                                        <span style="font-size: 25px;">{{$feature_report[2]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$feature_arr[$feature_val]}}</p>
                                        <?php $feature_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot3"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Good To Improve (3)</span>
                                            <br>
                                            <span class="sku-percentange">{{$feature_pres_report[2]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($feature_report[3] != 0)
                                <div class="chart-content4  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #92CA92;">
                                        <span style="font-size: 25px;">{{$feature_report[3]}}</span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$feature_arr[$feature_val]}}</p>
                                        <?php $feature_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot4"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Average Optimized (4)</span>
                                            <br>
                                            <span class="sku-percentange">{{$feature_pres_report[3]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row mobile-chart-content">
                                <div class="accordion" id="accordionExample">
                                    
                                    <?php $feature_val = 1; ?>
                                    @if($feature_report[0] != 0)
                                    <!-- Range1 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #E03F35;">
                                        <h2 class="accordion-header" id="headingMobileOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileOne" aria-expanded="true" aria-controls="collapseMobileOne">
                                                <span style="font-size: 25px;font-weight: bold;color: #E03F35;">{{$feature_report[0]}} </span><span style="margin-left: 3%;color: #E03F35;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileOne" class="accordion-collapse collapse show" aria-labelledby="headingMobileOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$feature_arr[$feature_val]}}</p>
                                                <?php $feature_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileOne">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot1"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">High attention required (1)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$feature_pres_report[0]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($feature_report[1] != 0)
                                    <!-- Range2 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #FFD3D0;">
                                        <h2 class="accordion-header" id="headingMobileTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileTwo" aria-expanded="true" aria-controls="collapseMobileTwo">
                                                <span style="font-size: 25px;font-weight: bold;color: #FFD3D0;">{{$feature_report[1]}} </span><span style="margin-left: 3%;color: #FFD3D0;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileTwo" class="accordion-collapse collapse" aria-labelledby="headingMobileTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$feature_arr[$feature_val]}}</p>
                                                <?php $feature_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileTwo">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot2"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Needs Improvement (2)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$feature_pres_report[1]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($feature_report[2] != 0)
                                    <!-- Range3 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #EEBF4B;">
                                        <h2 class="accordion-header" id="headingMobileThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileThree" aria-expanded="true" aria-controls="collapseMobileThree">
                                                <span style="font-size: 25px;font-weight: bold;color: #EEBF4B;">{{$feature_report[2]}} </span><span style="margin-left: 3%;color: #EEBF4B;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileThree" class="accordion-collapse collapse" aria-labelledby="headingMobileThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$feature_arr[$feature_val]}}</p>
                                                <?php $feature_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileThree">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot3"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Good To Improve (3)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$feature_pres_report[2]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($feature_report[3] != 0)
                                    <!-- Range4 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #92CA92;">
                                        <h2 class="accordion-header" id="headingMobileFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileFour" aria-expanded="true" aria-controls="collapseMobileFour">
                                                <span style="font-size: 25px;font-weight: bold;color: #92CA92;">{{$feature_report[3]}} </span><span style="margin-left: 3%;color: #92CA92;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileFour" class="accordion-collapse collapse" aria-labelledby="headingMobileFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$feature_arr[$feature_val]}}</p>
                                                <?php $feature_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileFour">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot4"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Average Optimized (4)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$feature_pres_report[3]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Specification Content Section -->
                        <div class="content-hide content-class" id="specification-content">
                            <div class="row desktop-chart-content">
                                <?php $specification_val = 1; ?>
                                @if($specification_report[0] != 0)
                                <div class="chart-content1  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #E03F35;">
                                        <span style="font-size: 25px;">{{$specification_report[0]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$specification_arr[$specification_val]}}</p>
                                        <?php $specification_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot1"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">High attention required (1)</span>
                                            <br>
                                            <span class="sku-percentange">{{$specification_pres_report[0]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($specification_report[1] != 0)
                                <div class="chart-content2  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #FFD3D0;">
                                        <span style="font-size: 25px;">{{$specification_report[1]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$specification_arr[$specification_val]}}</p>
                                        <?php $specification_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot2"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Needs Improvement (2)</span>
                                            <br>
                                            <span class="sku-percentange">{{$specification_pres_report[1]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($specification_report[2] != 0)
                                <div class="chart-content3  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #EEBF4B;">
                                        <span style="font-size: 25px;">{{$specification_report[2]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$specification_arr[$specification_val]}}</p>
                                        <?php $specification_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot3"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Good To Improve (3)</span>
                                            <br>
                                            <span class="sku-percentange">{{$specification_pres_report[2]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($specification_report[3] != 0)
                                <div class="chart-content4  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #92CA92;">
                                        <span style="font-size: 25px;">{{$specification_report[3]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$specification_arr[$specification_val]}}</p>
                                        <?php $specification_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot4"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Average Optimized (4)</span>
                                            <br>
                                            <span class="sku-percentange">{{$specification_pres_report[3]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row mobile-chart-content">
                                <div class="accordion" id="accordionExample">
                                    
                                    <?php $specification_val = 1; ?>
                                    @if($specification_report[0] != 0)
                                    <!-- Range1 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #E03F35;">
                                        <h2 class="accordion-header" id="headingMobileOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileOne" aria-expanded="true" aria-controls="collapseMobileOne">
                                                <span style="font-size: 25px;font-weight: bold;color: #E03F35;">{{$specification_report[0]}} </span><span style="margin-left: 3%;color: #E03F35;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileOne" class="accordion-collapse collapse show" aria-labelledby="headingMobileOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$specification_arr[$specification_val]}}</p>
                                                <?php $specification_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileOne">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot1"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">High attention required (1)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$specification_pres_report[0]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($specification_report[1] != 0)
                                    <!-- Range2 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #FFD3D0;">
                                        <h2 class="accordion-header" id="headingMobileTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileTwo" aria-expanded="true" aria-controls="collapseMobileTwo">
                                                <span style="font-size: 25px;font-weight: bold;color: #FFD3D0;">{{$specification_report[1]}} </span><span style="margin-left: 3%;color: #FFD3D0;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileTwo" class="accordion-collapse collapse" aria-labelledby="headingMobileTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$specification_arr[$specification_val]}}</p>
                                                <?php $specification_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileTwo">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot2"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Needs Improvement (2)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$specification_pres_report[1]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($specification_report[2] != 0)
                                    <!-- Range3 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #EEBF4B;">
                                        <h2 class="accordion-header" id="headingMobileThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileThree" aria-expanded="true" aria-controls="collapseMobileThree">
                                                <span style="font-size: 25px;font-weight: bold;color: #EEBF4B;">{{$specification_report[2]}} </span><span style="margin-left: 3%;color: #EEBF4B;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileThree" class="accordion-collapse collapse" aria-labelledby="headingMobileThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$specification_arr[$specification_val]}}</p>
                                                <?php $specification_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileThree">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot3"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Good To Improve (3)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$specification_pres_report[2]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($specification_report[3] != 0)
                                    <!-- Range4 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #92CA92;">
                                        <h2 class="accordion-header" id="headingMobileFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileFour" aria-expanded="true" aria-controls="collapseMobileFour">
                                                <span style="font-size: 25px;font-weight: bold;color: #92CA92;">{{$specification_report[3]}} </span><span style="margin-left: 3%;color: #92CA92;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileFour" class="accordion-collapse collapse" aria-labelledby="headingMobileFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$specification_arr[$specification_val]}}</p>
                                                <?php $specification_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileFour">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot4"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Average Optimized (4)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$specification_pres_report[3]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Image Content Section -->
                        <div class="content-hide content-class" id="image-content">
                            <div class="row desktop-chart-content">
                                <?php $image_val = 1; ?>
                                @if($image_report[0] != 0)
                                <div class="chart-content1  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #E03F35;">
                                        <span style="font-size: 25px;">{{$image_report[0]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$image_arr[$image_val]}}</p>
                                        <?php $image_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot1"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">High attention required (1)</span>
                                            <br>
                                            <span class="sku-percentange">{{$image_pres_report[0]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($image_report[1] != 0)
                                <div class="chart-content2  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #FFD3D0;">
                                        <span style="font-size: 25px;">{{$image_report[1]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$image_arr[$image_val]}}</p>
                                        <?php $image_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot2"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Needs Improvement (2)</span>
                                            <br>
                                            <span class="sku-percentange">{{$image_pres_report[1]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($image_report[2] != 0)
                                <div class="chart-content3  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #EEBF4B;">
                                        <span style="font-size: 25px;">{{$image_report[2]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$image_arr[$image_val]}}</p>
                                        <?php $image_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot3"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Good To Improve (3)</span>
                                            <br>
                                            <span class="sku-percentange">{{$image_pres_report[2]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($image_report[3] != 0)
                                <div class="chart-content4  col-md-3 col-xs-12">
                                    <!-- SKU Count -->
                                    <div style="font-weight: bold;color: #92CA92;">
                                        <span style="font-size: 25px;">{{$image_report[3]}} </span><span style="margin-left: 3%;">SKUs</span>
                                    </div>
                                    <!-- Notes -->
                                    <div>
                                        <p>{{$image_arr[$image_val]}}</p>
                                        <?php $image_val++ ?>
                                    </div>
                                    <!-- Range and Percentage -->
                                    <div class="row">
                                        <div class="col-2"><span class="dot4"></span></div>
                                        <div class="col-9">
                                            </span><span class="dot-content">Average Optimized (4)</span>
                                            <br>
                                            <span class="sku-percentange">{{$image_pres_report[3]}}%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif   
                            </div>   
                            <div class="row mobile-chart-content">
                                <div class="accordion" id="accordionExample">
                                    
                                    <?php $image_val = 1; ?>
                                    @if($image_report[0] != 0)
                                    <!-- Range1 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #E03F35;">
                                        <h2 class="accordion-header" id="headingMobileOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileOne" aria-expanded="true" aria-controls="collapseMobileOne">
                                                <span style="font-size: 25px;font-weight: bold;color: #E03F35;">{{$image_report[0]}} </span><span style="margin-left: 3%;color: #E03F35;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileOne" class="accordion-collapse collapse show" aria-labelledby="headingMobileOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$image_arr[$image_val]}}</p>
                                                <?php $image_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileOne">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot1"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">High attention required (1)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$image_pres_report[0]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($image_report[1] != 0)
                                    <!-- Range2 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #FFD3D0;">
                                        <h2 class="accordion-header" id="headingMobileTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileTwo" aria-expanded="true" aria-controls="collapseMobileTwo">
                                                <span style="font-size: 25px;font-weight: bold;color: #FFD3D0;">{{$image_report[1]}} </span><span style="margin-left: 3%;color: #FFD3D0;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileTwo" class="accordion-collapse collapse" aria-labelledby="headingMobileTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$image_arr[$image_val]}}</p>
                                                <?php $image_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileTwo">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot2"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Needs Improvement (2)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$image_pres_report[1]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($image_report[2] != 0)
                                    <!-- Range3 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #EEBF4B;">
                                        <h2 class="accordion-header" id="headingMobileThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileThree" aria-expanded="true" aria-controls="collapseMobileThree">
                                                <span style="font-size: 25px;font-weight: bold;color: #EEBF4B;">{{$image_report[2]}} </span><span style="margin-left: 3%;color: #EEBF4B;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileThree" class="accordion-collapse collapse" aria-labelledby="headingMobileThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$image_arr[$image_val]}}</p>
                                                <?php $image_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileThree">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot3"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Good To Improve (3)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$image_pres_report[2]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    @if($image_report[3] != 0)
                                    <!-- Range4 -->
                                    <div class="accordion-item mb-3" style="border-left:1px solid #92CA92;">
                                        <h2 class="accordion-header" id="headingMobileFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileFour" aria-expanded="true" aria-controls="collapseMobileFour">
                                                <span style="font-size: 25px;font-weight: bold;color: #92CA92;">{{$image_report[3]}} </span><span style="margin-left: 3%;color: #92CA92;">SKUs</span>
                                            </button>
                                        </h2>
                                        <div id="collapseMobileFour" class="accordion-collapse collapse" aria-labelledby="headingMobileFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p style="margin-left:5%;">{{$image_arr[$image_val]}}</p>
                                                <?php $image_val++ ?>
                                            </div>
                                        </div>
                                        <h2 class="accordion-footer" id="headingMobileFour">
                                            <div class="row">
                                                <div class="col-1" style="margin-left:5%;"><span class="dot4"></span></div>
                                                <div class="col-9" style="font-size:14px;">
                                                    </span><span class="dot-content">Average Optimized (4)</span>
                                                    <br>
                                                    <span class="sku-percentange">{{$image_pres_report[3]}}%</span>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>                     
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
        <?php  
            $title_arr                  = explode("<li>", $title_notes);
            $description_arr            = explode("<li>", $description_notes);
            $feature_arr                = explode("<li>", $feature_notes);
            $specification_arr          = explode("<li>", $specification_notes);
            $image_arr                  = explode("<li>", $image_notes);
        ?>
        <!-- Chart Print View -->

        <!-- Title Row Start -->
        <div class="chart-row only-print" id="title-row">

            <div class="chart-column">

                <!-- Chart Heading -->
                <div class="" style="padding:10px">
                    <h3>Title Character Analysis <span style="font-size:12px;">( Based on Character count)</span></h3>
                </div>

                <!-- Chart -->
                <div class="chart-section">
                    <div id="print_title_chart" class="chart">
                    
                    </div>
                    <div class="score" style="">
                        <h4 id="score-title">Title Score</h4>
                    </div>
                </div>

                <!-- Chart Content -->
                <div class="chart-content-section">
                    
                        <?php $title_val = 1; ?>
                        @if($title_report[0] != 0)
                        <div class="print-chart-content1">
                            <!-- SKU Count -->
                            <div style="font-weight: bold;color: #E03F35;">
                                <span style="font-size: 10px;">{{$title_report[0]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                            </div>
                            <!-- Notes -->
                            <div>
                                <p style="font-size: 8px;">{{$title_arr[$title_val]}}</p>
                                <?php $title_val++ ?>
                            </div>
                            <!-- Range and Percentage -->
                            <div class="row">
                                <div class="col-2"><span class="dot1"></span></div>
                                <div class="col-9">
                                    </span><span class="dot-content" style="font-size: 8px;">High attention required (1)</span>
                                    <br>
                                    <span class="sku-percentange" style="font-size: 8px;">{{$title_pres_report[0]}}%</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($title_report[1] != 0)
                        <div class="print-chart-content2">
                            <!-- SKU Count -->
                            <div style="font-weight: bold;color: #EEBF4B;">
                                <span style="font-size: 10px;">{{$title_report[1]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                            </div>
                            <!-- Notes -->
                            <div>
                                <p style="font-size: 8px;">{{$title_arr[$title_val]}}</p>
                                <?php $title_val++ ?>
                            </div>
                            <!-- Range and Percentage -->
                            <div class="row">
                                <div class="col-2"><span class="dot2"></span></div>
                                <div class="col-9">
                                    </span><span class="dot-content" style="font-size: 8px;">Needs Improvement (2)</span>
                                    <br>
                                    <span class="sku-percentange" style="font-size: 8px;">{{$title_pres_report[1]}}%</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($title_report[2] != 0)
                        <div class="print-chart-content3">
                            <!-- SKU Count -->
                            <div style="font-weight: bold;color: #92CA92;">
                                <span style="font-size: 10px;">{{$title_report[2]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                            </div>
                            <!-- Notes -->
                            <div>
                                <p style="font-size: 8px;">{{$title_arr[$title_val]}}</p>
                                <?php $title_val++ ?>
                            </div>
                            <!-- Range and Percentage -->
                            <div class="row">
                                <div class="col-2"><span class="dot3"></span></div>
                                <div class="col-9">
                                    </span><span class="dot-content" style="font-size: 8px;">Good To Improve (3)</span>
                                    <br>
                                    <span class="sku-percentange" style="font-size: 8px;">{{$title_pres_report[2]}}%</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($title_report[3] != 0)
                        <div class="print-chart-content4">
                            <!-- SKU Count -->
                            <div style="font-weight: bold;color: #39BC86;">
                                <span style="font-size: 10px;">{{$title_report[3]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                            </div>
                            <!-- Notes -->
                            <div>
                                <p style="font-size: 8px;">{{$title_arr[$title_val]}}</p>
                                <?php $title_val++ ?>
                            </div>
                            <!-- Range and Percentage -->
                            <div class="row">
                                <div class="col-2"><span class="dot4"></span></div>
                                <div class="col-9">
                                    </span><span class="dot-content" style="font-size: 8px;">Average Optimized (4)</span>
                                    <br>
                                    <span class="sku-percentange" style="font-size: 8px;">{{$title_pres_report[3]}}%</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    
                </div>

            </div>

        </div>
        <!-- Title Row End -->

        <!-- Description Row Start -->
        <div class="chart-row only-print" id="description-row">

            <div class="chart-column">

                <!-- Chart Heading -->
                <div class="" style="padding:10px">
                    <h3>Description Words Analysis <span style="font-size:12px;">( Based on Word count)</span></h3>
                </div>

                <!-- Chart -->
                <div class="chart-section">
                    <div id="print_description_chart" class="chart">
                    
                    </div>
                    <div class="score" style="">
                        <h4 id="score-description">Description Score</h4>
                    </div>
                </div>

                <!-- Chart Content -->
                <div class="chart-content-section">
                    <?php $description_val = 1; ?>
                    @if($description_report[0] != 0)
                    <div class="print-chart-content1">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #E03F35;">
                            <span style="font-size: 10px;">{{$description_report[0]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 7px;">{{$description_arr[$description_val]}}</p>
                            <?php $description_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot1"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">High attention required (1)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$description_pres_report[0]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($description_report[1] != 0)
                    <div class="print-chart-content2">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #FFD3D0;">
                            <span style="font-size: 10px;">{{$description_report[1]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 7px;">{{$description_arr[$description_val]}}</p>
                            <?php $description_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot2"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Needs Improvement (2)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$description_pres_report[1]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($description_report[2] != 0)
                    <div class="print-chart-content3">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #EEBF4B;">
                            <span style="font-size: 10px;">{{$description_report[2]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 7px;">{{$description_arr[$description_val]}}</p>
                            <?php $description_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot3"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Good To Improve (3)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$description_pres_report[2]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($description_report[3] != 0)
                    <div class="print-chart-content4">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #92CA92;">
                            <span style="font-size: 10px;">{{$description_report[3]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 7px;">{{$description_arr[$description_val]}}</p>
                            <?php $description_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot4"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Average Optimized (4)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$description_pres_report[3]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
        <!-- Description Row End -->

        <!-- Feature Row Start -->
        <div class="chart-row only-print" id="feature-row">

            <div class="chart-column">

                <!-- Chart Heading -->
                <div class="" style="padding:10px">
                    <h3>Feature Analysis <span style="font-size:12px;">( It is ideal to have minimum of 3 to 5 bullet points)</span></h3>
                </div>

                <!-- Chart -->
                <div class="chart-section">
                    <div id="print_feature_chart" class="chart">
                    
                    </div>
                    <div class="score" style="">
                        <h4 id="score-feature">Feature Score</h4>
                    </div>
                </div>

                <!-- Chart Content -->
                <div class="chart-content-section">
                    <?php $feature_val = 1; ?>
                    @if($feature_report[0] != 0)
                    <div class="print-chart-content1">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #E03F35;">
                            <span style="font-size: 10px;">{{$feature_report[0]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$feature_arr[$feature_val]}}</p>
                            <?php $feature_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot1"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">High attention required (1)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$feature_pres_report[0]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($feature_report[1] != 0)
                    <div class="print-chart-content2">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #FFD3D0;">
                            <span style="font-size: 10px;">{{$feature_report[1]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$feature_arr[$feature_val]}}</p>
                            <?php $feature_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot2"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Needs Improvement (2)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$feature_pres_report[1]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($feature_report[2] != 0)
                    <div class="print-chart-content3">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #EEBF4B;">
                            <span style="font-size: 10px;">{{$feature_report[2]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$feature_arr[$feature_val]}}</p>
                            <?php $feature_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot3"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Good To Improve (3)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$feature_pres_report[2]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($feature_report[3] != 0)
                    <div class="print-chart-content4">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #92CA92;">
                            <span style="font-size: 10px;">{{$feature_report[3]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$feature_arr[$feature_val]}}</p>
                            <?php $feature_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot4"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Average Optimized (4)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$feature_pres_report[3]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
        <!-- Feature Row End -->

        <!-- Specification Row Start -->
        <div class="chart-row only-print" id="specification-row">

            <div class="chart-column">

                <!-- Chart Heading -->
                <div class="" style="padding:10px">
                    <h3>Specification Analysis</h3>
                </div>

                <!-- Chart -->
                <div class="chart-section">
                    <div id="print_specification_chart" class="chart">
                    
                    </div>
                    <div class="score" style="">
                        <h4 id="score-specification">Specification Score</h4>
                    </div>
                </div>

                <!-- Chart Content -->
                <div class="chart-content-section">
                    <?php $specification_val = 1; ?>
                    @if($specification_report[0] != 0)
                    <div class="print-chart-content1">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #E03F35;">
                            <span style="font-size: 10px;">{{$specification_report[0]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$specification_arr[$specification_val]}}</p>
                            <?php $specification_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot1"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">High attention required (1)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$specification_pres_report[0]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($specification_report[1] != 0)
                    <div class="print-chart-content2">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #EEBF4B;">
                            <span style="font-size: 10px;">{{$specification_report[1]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$specification_arr[$specification_val]}}</p>
                            <?php $specification_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot2"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Needs Improvement (2)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$specification_pres_report[1]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($specification_report[2] != 0)
                    <div class="print-chart-content3">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #92CA92;">
                            <span style="font-size: 10px;">{{$specification_report[2]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$specification_arr[$specification_val]}}</p>
                            <?php $specification_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot3"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Good To Improve (3)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$specification_pres_report[2]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($specification_report[3] != 0)
                    <div class="print-chart-content4">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #39BC86;">
                            <span style="font-size: 10px;">{{$specification_report[3]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$specification_arr[$specification_val]}}</p>
                            <?php $specification_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot4"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Average Optimized (4)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$specification_pres_report[3]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
        <!-- Specification Row End -->

        <!-- Image Row Start -->
        <div class="chart-row only-print" id="image-row">

            <div class="chart-column">

                <!-- Chart Heading -->
                <div class="" style="padding:10px">
                    <h3>Image Analysis</h3>
                </div>

                <!-- Chart -->
                <div class="chart-section">
                    <div id="print_image_chart" class="chart">
                    
                    </div>
                    <div class="score" style="">
                        <h4 id="score-image">Image Score</h4>
                    </div>
                </div>

                <!-- Chart Content -->
                <div class="chart-content-section">
                    <?php $image_val = 1; ?>
                    @if($image_report[0] != 0)
                    <div class="print-chart-content1">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #E03F35;">
                            <span style="font-size: 10px;">{{$image_report[0]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$image_arr[$image_val]}}</p>
                            <?php $image_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot1"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">High attention required (1)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$image_pres_report[0]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($image_report[1] != 0)
                    <div class="print-chart-content2">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #EEBF4B;">
                            <span style="font-size: 10px;">{{$image_report[1]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$image_arr[$image_val]}}</p>
                            <?php $image_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot2"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Needs Improvement (2)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$image_pres_report[1]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($image_report[2] != 0)
                    <div class="print-chart-content3">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #92CA92;">
                            <span style="font-size: 10px;">{{$image_report[2]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$image_arr[$image_val]}}</p>
                            <?php $image_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot3"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Good To Improve (3)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$image_pres_report[2]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($image_report[3] != 0)
                    <div class="print-chart-content4">
                        <!-- SKU Count -->
                        <div style="font-weight: bold;color: #39BC86;">
                            <span style="font-size: 10px;">{{$image_report[3]}} </span><span style="margin-left: 3%;font-size: 8px;">SKUs</span>
                        </div>
                        <!-- Notes -->
                        <div>
                            <p style="font-size: 8px;">{{$image_arr[$image_val]}}</p>
                            <?php $image_val++ ?>
                        </div>
                        <!-- Range and Percentage -->
                        <div class="row">
                            <div class="col-2"><span class="dot4"></span></div>
                            <div class="col-9">
                                </span><span class="dot-content" style="font-size: 8px;">Average Optimized (4)</span>
                                <br>
                                <span class="sku-percentange" style="font-size: 8px;">{{$image_pres_report[3]}}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
        <!-- Image Row End -->

        <!-- Enhance Table -->
        <div class="row mb-3">
            <div class="col-1"></div>
            <div class="col-10">
                <h3 class="text-center enhance-heading">Analysis on SEO data and Image quality</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Heading</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @if($lesser_width_percentage > 10)                       
                        <tr>
                            <td>Image Quality</td>
                            <td>
                                @if($lesser_width_percentage == 100)
                                    Your Website all the images shows less than the standard resolution of 200px . Images should be of high quality and resolution to ensure that customers can clearly see the details of the product. Large image files can slow down page loading times, affecting user experience and SEO.                                
                                @else
                                    Your Website images show that {{$lesser_width_percentage}}% are less than the standard resolution of 200px . Images should be of high quality and resolution to ensure that customers can clearly see the details of the product. Large image files can slow down page loading times, affecting user experience and SEO.                                
                                @endif
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td>Image Alt Tag</td>
                            <td>
                                @if($img_alt_percentage == 100)
                                    All of your images lack alt text. It's crucial to provide descriptive alt text for images. Alt text is important for accessibility and it can also have a positive impact on SEO.
                                @else
                                    {{$img_alt_percentage}}% of your images lack alt text. It's crucial to provide descriptive alt text for images. Alt text is important for accessibility and it can also have a positive impact on SEO.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Meta Titles</td>
                            <td>
                                @if($title_metadata_percentage == 100)
                                    Analysis of your site's meta titles reveals that all are surpass the 70-character threshold.  If your title is too long, it might get cut off in search engine results, potentially affecting click-through rates and user understanding of the page's content.
                                @else
                                    Analysis of your site's meta titles reveals that over {{$title_metadata_percentage}}% surpass the 70-character threshold.  If your title is too long, it might get cut off in search engine results, potentially affecting click-through rates and user understanding of the page's content.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Meta Descriptions</td>
                            <td>
                                @if($description_metadata_percentage == 100)
                                    Our analysis found that all of your descriptions exceed 170 characters. It is a good idea to keep your key information within the standard range. This ensures that your description is concise and impactful, while also minimizing the risk of it getting cut off in search results.</td>
                                @else    
                                    Our analysis found that more than {{$description_metadata_percentage}}% of your descriptions exceed 170 characters. It is a good idea to keep your key information within the standard range. This ensures that your description is concise and impactful, while also minimizing the risk of it getting cut off in search results.</td>
                                @endif
                        </tr>
                        <tr>
                            <td>Meta Keywords</td>
                            <td>
                                @if($keywords_metadata_percentage == 100)
                                    All the meta keywords on your website comprise less than ten Keywords. Enhancing your site's performance could be achieved by incorporating highly relevant keywords within this area.
                                @else
                                    {{$keywords_metadata_percentage}} % of the meta keywords on your website comprise less than ten Keywords. Enhancing your site's performance could be achieved by incorporating highly relevant keywords within this area.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Rating</td>
                            <td>
                                @if($rating_per == 100)     
                                    We find all the product pages are without customer reviews. Ratings on product pages are a valuable tool for both customers and businesses. They help build trust, aid in decision-making, provide feedback for improvement, and contribute to a positive shopping experience. Businesses should actively encourage customers to leave ratings and respond to reviews to maximize the benefits of this feature.
                                @else
                                    We find {{$rating_per}}% of the product pages are without customer reviews. Ratings on product pages are a valuable tool for both customers and businesses. They help build trust, aid in decision-making, provide feedback for improvement, and contribute to a positive shopping experience. Businesses should actively encourage customers to leave ratings and respond to reviews to maximize the benefits of this feature.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>FAQ</td>
                            <td>
                                @if($faq_per == 100)
                                    Our analysis reveals that all the product pages lack FAQs. Incorporating FAQs on product pages offers numerous advantages, including improving the user experience, fostering trust, decreasing cart abandonment rates, conserving customer service representative (CSR) resources, addressing technical queries, and enhancing SEO benefits.
                                @else
                                    Our analysis reveals that {{$faq_per}}% of product pages lack FAQs. Incorporating FAQs on product pages offers numerous advantages, including improving the user experience, fostering trust, decreasing cart abandonment rates, conserving customer service representative (CSR) resources, addressing technical queries, and enhancing SEO benefits.
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>

        <!-- Print Button -->
        <div class="row mb-5 ignore-print">
            <div class="col-md-5"></div>
            <div class="col-md-2 col-xs-12 text-center">
                <!-- <a href="" class="btn submit-button"></a> -->
                <button type="button" class="btn btn-labeled submit-button cmd" id="cmd">
                <span class="btn-label"><img src="{{asset('images/black-print.png')}}" alt="" class="black-print"></span>Print Report</button>
            </div>
            <div class="col-md-5"></div>
        </div>

    </div>
<!-- The Notes Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
        <div class="row">
            <form action="{{route('save_notes')}}" method="post" enctype="multipart/form-data" id="notes_form">
                @csrf
                <?php
                    if(!blank($website_data[0]->getNotes)){
                        $internal_notes         = $website_data[0]->getNotes->internal_notes;
                        $client_notes           = $website_data[0]->getNotes->client_notes;
                        $db_title_notes            = $website_data[0]->getNotes->title_notes;
                        $db_description_notes      = $website_data[0]->getNotes->description_notes;
                        $db_feature_notes          = $website_data[0]->getNotes->feature_notes;
                        $db_specification_notes    = $website_data[0]->getNotes->specification_notes;
                        $db_image_notes            = $website_data[0]->getNotes->image_notes;
                    }else{
                        $internal_notes         = '';
                        $client_notes           = '';
                        $db_title_notes            = '';
                        $db_description_notes      = '';
                        $db_feature_notes          = '';
                        $db_specification_notes    = '';
                        $db_image_notes            = '';
                    }
                ?>
                <input type="hidden" name="website_id" value="" id="website_id"> 
                <!--Internal Notes-->
                <div class="mb-3">
                    <label for="internal_notes"><strong>Internal Notes</strong></label>
                    <textarea name="internal_notes" class="form-control ckeditor" id="internal_notes" cols="30" rows="3">{{ $internal_notes}}</textarea>
                </div>
                <!--Client Notes-->
                <div class="mb-3">
                    <label for="client_notes"><strong>Client Notes</strong></label>
                    <textarea name="client_notes" class="form-control ckeditor" id="client_notes" cols="30" rows="3">{{$client_notes}}</textarea>
                </div>
                <!--Overall Notes-->
                <div class="mb-3">
                    <label for="overall_notes"><strong>Overall Notes</strong></label>
                    <textarea name="overall_notes" class="form-control ckeditor" id="overall_notes" cols="30" rows="3">{{$overall_notes}}</textarea>
                </div>
                <!--Title Notes-->
                <div class="mb-3">
                    <label for="title_notes"><strong>Title Notes</strong></label>
                    <textarea name="title_notes" class="form-control ckeditor" id="title_notes" cols="30" rows="3">{{$title_notes}}</textarea>
                </div>
                <!--Description Notes-->
                <div class="mb-3">
                    <label for="description_notes"><strong>Description Notes</strong></label>
                    <textarea name="description_notes" class="form-control ckeditor" id="description_notes" cols="30" rows="3">{{$description_notes}}</textarea>
                </div>
                <!--Feature Notes-->
                <div class="mb-3">
                    <label for="feature_notes"><strong>Feature Notes</strong></label>
                    <textarea name="feature_notes" class="form-control ckeditor" id="feature_notes" cols="30" rows="3">{{$feature_notes}}</textarea>
                </div>
                <!--Specification Notes-->
                <div class="mb-3">
                    <label for="specification_notes"><strong>Specification Notes</strong></label>
                    <textarea name="specification_notes" class="form-control ckeditor" id="specification_notes" cols="30" rows="3">{{$specification_notes}}</textarea>
                </div>
                <!--Image Notes-->
                <div class="mb-3">
                    <label for="image_notes"><strong>Image Notes</strong></label>
                    <textarea name="image_notes" class="form-control ckeditor" id="image_notes" cols="30" rows="3">{{$image_notes}}</textarea>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.18.2.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <!-- Pie Charts Script -->
    <script>
        // Title
        var data1 = [{
            values: ['{{$title_pres_report[0]}}', '{{$title_pres_report[1]}}', '{{$title_pres_report[2]}}', '{{$title_pres_report[3]}}', '{{$title_pres_report[4]}}'],
            labels: ['{{$title_report[0]}} SKUs', '{{$title_report[1]}} SKUs', '{{$title_report[2]}} SKUs', '{{$title_report[3]}} SKUs', '{{$title_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Title
        var layout1 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$title_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 400,
            showlegend: false,
        };

        // Description
        var data2 = [{
            values: ['{{$description_pres_report[0]}}', '{{$description_pres_report[1]}}', '{{$description_pres_report[2]}}', '{{$description_pres_report[3]}}', '{{$description_pres_report[4]}}'],
            labels: ['{{$description_report[0]}} SKUs', '{{$description_report[1]}} SKUs', '{{$description_report[2]}} SKUs', '{{$description_report[3]}} SKUs', '{{$description_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Description
        var layout2 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$description_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 400,
            showlegend: false,
        };

        // Feature
        var data3 = [{
            values: ['{{$feature_pres_report[0]}}', '{{$feature_pres_report[1]}}', '{{$feature_pres_report[2]}}', '{{$feature_pres_report[3]}}', '{{$feature_pres_report[4]}}'],
            labels: ['{{$feature_report[0]}} SKUs', '{{$feature_report[1]}} SKUs', '{{$feature_report[2]}} SKUs', '{{$feature_report[3]}} SKUs', '{{$feature_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Feature
        var layout3 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$feature_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 400,
            showlegend: false,
        };

        // Specification
        var data4 = [{
            values: ['{{$specification_pres_report[0]}}', '{{$specification_pres_report[1]}}', '{{$specification_pres_report[2]}}', '{{$specification_pres_report[3]}}', '{{$specification_pres_report[4]}}'],
            labels: ['{{$specification_report[0]}} SKUs', '{{$specification_report[1]}} SKUs', '{{$specification_report[2]}} SKUs', '{{$specification_report[3]}} SKUs', '{{$specification_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Specification
        var layout4 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$specification_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 400,
            showlegend: false,
        };

        // Image
        var data5 = [{
            values: ['{{$image_pres_report[0]}}', '{{$image_pres_report[1]}}', '{{$image_pres_report[2]}}', '{{$image_pres_report[3]}}', '{{$image_pres_report[4]}}'],
            labels: ['{{$image_report[0]}} SKUs', '{{$image_report[1]}} SKUs', '{{$image_report[2]}} SKUs', '{{$image_report[3]}} SKUs', '{{$image_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Image
        var layout5 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$image_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 400,
            showlegend: false,
        };
        
        Plotly.newPlot('title_chart', data1, layout1);
        
        $(document).on("change","#analysis",function() {
            $(".chart").empty();
            var analysis = $("#analysis").val();
            if(analysis == 'Title Character'){
                Plotly.newPlot('title_chart', data1, layout1);
                $("#score-title").text('Title Score');
                $('.content-class').removeClass('content-show content-hide');
                $('#title-content').addClass('content-show');
                $('#description-content').addClass('content-hide');
                $('#feature-content').addClass('content-hide');
                $('#specification-content').addClass('content-hide');
                $('#image-content').addClass('content-hide');
            }
            if(analysis == 'Description Words'){
                Plotly.newPlot('description_chart', data2, layout2);
                $("#score-title").text('Description Score');
                $('.content-class').removeClass('content-show content-hide');
                $('#title-content').addClass('content-hide');
                $('#description-content').addClass('content-show');
                $('#feature-content').addClass('content-hide');
                $('#specification-content').addClass('content-hide');
                $('#image-content').addClass('content-hide');
            }
            if(analysis == 'Feature Bullets Count'){
                Plotly.newPlot('feature_chart', data3, layout3);
                $("#score-title").text('Feature Score');
                $('.content-class').removeClass('content-show content-hide');
                $('#title-content').addClass('content-hide');
                $('#description-content').addClass('content-hide');
                $('#feature-content').addClass('content-show');
                $('#specification-content').addClass('content-hide');
                $('#image-content').addClass('content-hide');
            }
            if(analysis == 'Prod Specifications Count'){
                Plotly.newPlot('specification_chart', data4, layout4);
                $("#score-title").text('Specification Score');
                $('.content-class').removeClass('content-show content-hide');
                $('#title-content').addClass('content-hide');
                $('#description-content').addClass('content-hide');
                $('#feature-content').addClass('content-hide');
                $('#specification-content').addClass('content-show');
                $('#image-content').addClass('content-hide');
            }
            if(analysis == 'Images Count'){
                Plotly.newPlot('image_chart', data5, layout5);
                $("#score-title").text('Image Score');
                $('.content-class').removeClass('content-show content-hide');
                $('#title-content').addClass('content-hide');
                $('#description-content').addClass('content-hide');
                $('#feature-content').addClass('content-hide');
                $('#specification-content').addClass('content-hide');
                $('#image-content').addClass('content-show');
            }
        });
        
    </script>
    <!-- Notes and Print Scripts -->
    <script>
        $(document).on("click",".close",function() {
            $("#myModal").hide();
            // $("#notes_form")[0].reset();
        });
         // Scraper Upload
        $(document).on("click",".notes",function() {
            $("#myModal").show();
            var website_id = $(this).attr('data-id');
            $("#website_id").val(website_id);
        });
        $(document).on("click",".cmd",function() {
            window.print();
        });
    </script>
    <!-- CKEditor -->
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        $('.ckeditor').ckeditor();
        });
    </script>
    <!-- Print View Pie Charts Script -->
    <script>
        // Title
        var title_data1 = [{
            values: ['{{$title_pres_report[0]}}', '{{$title_pres_report[1]}}', '{{$title_pres_report[2]}}', '{{$title_pres_report[3]}}', '{{$title_pres_report[4]}}'],
            labels: ['{{$title_report[0]}} SKUs', '{{$title_report[1]}} SKUs', '{{$title_report[2]}} SKUs', '{{$title_report[3]}} SKUs', '{{$title_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Title
        var title_layout1 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$title_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 300,
            showlegend: false,
        };

        // Description
        var description_data2 = [{
            values: ['{{$description_pres_report[0]}}', '{{$description_pres_report[1]}}', '{{$description_pres_report[2]}}', '{{$description_pres_report[3]}}', '{{$description_pres_report[4]}}'],
            labels: ['{{$description_report[0]}} SKUs', '{{$description_report[1]}} SKUs', '{{$description_report[2]}} SKUs', '{{$description_report[3]}} SKUs', '{{$description_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Description
        var description_layout2 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$description_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 300,
            showlegend: false,
        };

        // Feature
        var feature_data3 = [{
            values: ['{{$feature_pres_report[0]}}', '{{$feature_pres_report[1]}}', '{{$feature_pres_report[2]}}', '{{$feature_pres_report[3]}}', '{{$feature_pres_report[4]}}'],
            labels: ['{{$feature_report[0]}} SKUs', '{{$feature_report[1]}} SKUs', '{{$feature_report[2]}} SKUs', '{{$feature_report[3]}} SKUs', '{{$feature_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Feature
        var feature_layout3 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$feature_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 300,
            showlegend: false,
        };

        // Specification
        var specification_data4 = [{
            values: ['{{$specification_pres_report[0]}}', '{{$specification_pres_report[1]}}', '{{$specification_pres_report[2]}}', '{{$specification_pres_report[3]}}', '{{$specification_pres_report[4]}}'],
            labels: ['{{$specification_report[0]}} SKUs', '{{$specification_report[1]}} SKUs', '{{$specification_report[2]}} SKUs', '{{$specification_report[3]}} SKUs', '{{$specification_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Specification
        var specification_layout4 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$specification_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 300,
            showlegend: false,
        };

        // Image
        var image_data5 = [{
            values: ['{{$image_pres_report[0]}}', '{{$image_pres_report[1]}}', '{{$image_pres_report[2]}}', '{{$image_pres_report[3]}}', '{{$image_pres_report[4]}}'],
            labels: ['{{$image_report[0]}} SKUs', '{{$image_report[1]}} SKUs', '{{$image_report[2]}} SKUs', '{{$image_report[3]}} SKUs', '{{$image_report[4]}} SKUs' ],
            domain: {column: 0},
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#E03F35', '#FFD3D0', '#EEBF4B', '#92CA92', '#39BC86']
            },
            type: 'pie'
        }];

        
        // Image
        var image_layout5 = {
            annotations: [
                {
                font: {
                    size: 20
                },
                showarrow: false,
                text: '{{$image_score}}',
                x: 0.50,
                y: 0.5,
                }
            ],
            width : 300,
            showlegend: false,
        };
        
        Plotly.newPlot('print_title_chart', title_data1, title_layout1);
        Plotly.newPlot('print_description_chart', description_data2, description_layout2);
        Plotly.newPlot('print_feature_chart', feature_data3, feature_layout3);
        Plotly.newPlot('print_specification_chart', specification_data4, specification_layout4);
        Plotly.newPlot('print_image_chart', image_data5, image_layout5);

    </script>
</body>
</html>