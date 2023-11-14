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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <style>
        @media print {
            body{
                background-color : #fff !important;
            }
            .header{
                box-shadow: none;
            }
            .only-print{
                display: block !important;
            }
            .ignore-print{
                display: none !important;
            }
            .border1{
                margin-top: -1170px;
                margin-left: -80px;
                z-index: 10000;
            }
            .border1-img{
                width:120%;
                height:130vh
            }
            .row>* {
                flex-shrink: 0;
                width: 100%;
                max-width: 100%;
                padding-right: calc(var(--bs-gutter-x) * .5);
                padding-left: calc(var(--bs-gutter-x) * .5);
                margin-top: var(--bs-gutter-y);
            }
            .col-md-10{
                float: left;
                width: 60%;
            }
            .col-md-2{
                float: left;
                width: 40%;
            }
           
            #overall_chart_div{
                margin-top : -50px;
                width: 200px;
                height: 200px;
                margin-left:100px;
            }
            #title_chart_div{
                margin-left:100px;
                margin-top: 80px;
            }
            #description_chart_div{
                margin-left:100px;
                /* margin-top: 80px; */
            }
            #feature_chart_div{
                margin-left:100px;
                /* margin-top: 80px; */
            }
            #specification_chart_div{
                margin-left:100px;
                /* margin-top: 80px; */
            }
            #image_chart_div{
                margin-left:100px;
                /* margin-top: 80px; */
            }
            #overall_row{
                page-break-before: always;
                page-break-after: always;
            }
            #title_row{
                page-break-after: always;
            }
            #description_row{
                page-break-after: always;
            }
            #feature_row{
                page-break-after: always;
            }
            #specification_row{
                page-break-after: always;
            } 
            
            .print-logo1{
                text-align : center;
            }
            .table-section{
                padding: 0 30px 30px 20px;
                text-align : center;
            }
            .head1{
                background-color: #f6f6f6;
                width: 20%;
                height: 70px;
                border-radius : 20px 0 0 0;
            }
            .head2{
                background-color: #ef9b9b;
                width: 15%;
                height: 70px;
            }
            .head3{
                background-color: #f6c056;
                width: 15%;
                height: 70px;
            }
            .head4{
                background-color: #eff078;
                width: 15%;
                height: 70px;
            }
            .head5{
                background-color: #80edc6;
                width: 15%;
                height: 70px;
            }
            .head6{
                background-color: #77c382;
                width: 15%;
                height: 70px;
                border-radius : 0 20px 0 0;
            }
            .data1{
                background-color: #eaeaea;
                height: 100px;
                text-align: end;
                padding-right: 3%;
            }
            .data2{
                background-color: #e49495;
                height: 100px;
            }
            .data3{
                background-color: #ebb752;
                height: 100px;
            }
            .data4{
                background-color: #e5e573;
                height: 100px;
            }
            .data5{
                background-color: #7ce2bd;
                height: 100px;
            }
            .data6{
                background-color: #72ba7b;
                height: 100px;
            }
            .data1-first{
                border-radius : 0  0 0 20px;
            }
            .data6-last{
                border-radius : 0 0 20px 0;
            }
            text.gtitle {
                font-weight: bold !important;
            }
            text.title {
                font-weight: bold;
            }
            .notes{
                margin-top: 50px;
            }
            .notes_div {
                padding: 00px 0px 0px 0px !important;
                background-color: #e0e0e0;
                /* height: auto !important; */
            }
            .overall_notes_div {
                padding: 00px 0px 0px 0px !important;
                background-color: #e0e0e0;
                margin-top: 50px !important;
            }
            .content_notes{
                padding: 10px 10px 10px 10px !important;
                margin-left: 0px !important;
                /* height: auto !important; */
                margin-bottom: 50px !important;
            }
        }
        .col-md-8.col-xs-12.notes_div {
                padding: 50px 0px 50px 50px;
        }
        .col-md-8.col-xs-12.overall_notes_div {
                padding: 0px 0px 0px 50px;
        }
        .content_notes{
            background-color: #e0e0e0;
            padding: 10px 10px 10px 70px;
            margin-left: -200px;
            min-height: 300px;
        }
        @media only screen 
            and (device-width: 390px) 
            and (device-height: 844px)
            and (-webkit-device-pixel-ratio: 3) {
                .content_notes{
                    margin-left : 0px !important;
                    padding : 10px !important;
                }
        }
    </style>
</head>
<body>
<?php $route = Route::current()->getName(); ?>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-4 print-logo1">
                <a href="{{route('website.index')}}" class="ignore-print"><img src="{{asset('assets/images/logo.jpg')}}" alt="logo"></a>
                <a href="{{route('website.index')}}" class="only-print"><img width="150px" src="{{asset('assets/images/report_logo.png')}}" alt="logo"></a>
            </div>
            <div class="col-md-8 col-xs-8 ignore-print">
                <div class="float-end mt-4">
                    <span class="user_role">{{ auth()->user()->first_name }} ({{ auth()->user()->getRole->name }})</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="row content-section">
            <!-- Page Header -->
            <div class="col-12 title-section ignore-print">
                <div class="mt-2">
                    <span class="dot"></span>
                    <span class="website_list">REPORTS</span>
                    <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($website_id); ?>
                    @if($route == 'scrape_view')
                        <a href="{{route('set_range',$enc_id)}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a>
                    @elseif($route == 'enhance_result')
                        <a href="{{route('website.index')}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a>
                    @endif
                </div>
            </div>
            <!-- Filter -->
            <div class="col-12 website-details-section ignore-print">
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
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                            <!-- <label for="">Select Category</label> -->
                            <select name="category" id="category">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}" {{$category->category== $req_category ? 'selected' : ''}}>{{substr($category->category, strrpos($category->category, '>') + 1)}}</option>
                                @endforeach
                            </select>
                            <div style="margin-left:25%;">
                                <span>Category Count: {{$category_count}}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <!-- <label for="">Select brand</label> -->
                            <select name="brand" id="brand">
                                <option value="">Select brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->brand}}" {{$brand->brand == $req_brand ? 'selected' : ''}}>{{$brand->brand}}</option>
                                @endforeach
                            </select>
                            <div style="margin-left:25%;">
                                <span>Brand Count: {{$brand_count}}</span>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12 text-center mb-3">
                            <input type="submit" value="SUBMIT" class="submit-button">
                        </div>
                        
                        <div class="col-md-2 col-xs-12 text-center mb-3">
                            <a href="javascript:void(0)" class="send-mail notes" data-id="{{$website_id}}">Notes</a>
                        </div>
                        <div class="col-md-2">
                            @if(auth()->user()->getRole->name == 'Operation' || auth()->user()->getRole->name == 'Power User')
                                @if($route == 'scrape_view')
                                    <a href="{{route('send_mail',$website_id)}}" class="send-mail" >SEND MAIL</a>
                                @elseif($route == 'enhance_result')
                                    <a href="{{route('send_enhance_mail',$website_id)}}" class="send-mail" >SEND MAIL</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </form>
            </div> 
            <!-- Website Details -->
            <div class="col-md-10 website-details-section col-xs-12">
                <p>Website: <strong>{{$website_name}}</strong></p>
                
            </div>
            <div class="col-md-2 col-xs-12 website-details-section">
                <p>Total SKUs: <strong>{{$total_sku}}</strong></p>
            </div>
            <!-- Table -->
            @if($res_value != 0)
            <div class="col-12 table-section table-responsive">
                <table>
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
                        <tr id="">
                            <td class="data1">Title Characters</td>
                            <td class="data2">0 - {{$title[0]}} <br> <strong>{{$title_report[0]}} SKUs</strong> <br> ({{$title_pres_report[0]}}%)</td>
                            <td class="data3">{{++$title[0]}} - {{$title[1]}} <br> <strong>{{$title_report[1]}} SKUs</strong> <br> ({{$title_pres_report[1]}}%)</td>
                            <td class="data4">{{++$title[1]}} - {{$title[2]}} <br> <strong>{{$title_report[2]}} SKUs</strong> <br> ({{$title_pres_report[2]}}%)</td>
                            <td class="data5">{{++$title[2]}} - {{$title[3]}} <br> <strong>{{$title_report[3]}} SKUs</strong> <br> ({{$title_pres_report[3]}}%)</td>
                            <td class="data6">{{$title[4]++}}+ <br> <strong>{{$title_report[4]}} SKUs</strong> <br> ({{$title_pres_report[4]}}%)</td>
                        </tr>
                        @endif
                        @if($data[0]->description_status == 1)
                        <tr id="">
                            <td class="data1">Description Words</td>
                            <td class="data2">0 - {{$description[0]}} <br> <strong>{{$description_report[0]}} SKUs</strong> <br> ({{$description_pres_report[0]}}%)</td>
                            <td class="data3">{{++$description[0]}} - {{$description[1]}} <br> <strong>{{$description_report[1]}} SKUs</strong> <br> ({{$description_pres_report[1]}}%)</td>
                            <td class="data4">{{++$description[1]}} - {{$description[2]}} <br> <strong>{{$description_report[2]}} SKUs</strong> <br> ({{$description_pres_report[2]}}%)</td>
                            <td class="data5">{{++$description[2]}} - {{$description[3]}} <br> <strong>{{$description_report[3]}} SKUs</strong> <br> ({{$description_pres_report[3]}}%)</td>
                            <td class="data6">{{$description[4]++}}+ <br> <strong>{{$description_report[4]}} SKUs</strong> <br> ({{$description_pres_report[4]}}%)</td>
                        </tr>
                        @endif
                        @if($data[0]->feature_status == 1)
                        <tr id="">
                            <td class="data1">Feature Bullets Count</td>
                            <td class="data2">{{$feature[0]}} <br> <strong>{{$feature_report[0]}} SKUs</strong> <br> ({{$feature_pres_report[0]}}%)</td>
                            <td class="data3">{{$feature[1]}} <br> <strong>{{$feature_report[1]}} SKUs</strong> <br> ({{$feature_pres_report[1]}}%)</td>
                            <td class="data4">{{$feature[2]}} <br> <strong>{{$feature_report[2]}} SKUs</strong> <br> ({{$feature_pres_report[2]}}%)</td>
                            <td class="data5">{{$feature[3]}} <br> <strong>{{$feature_report[3]}} SKUs</strong> <br> ({{$feature_pres_report[3]}}%)</td>
                            <td class="data6">{{$feature[4]++}}+ <br> <strong>{{$feature_report[4]}} SKUs</strong> <br> ({{$feature_pres_report[4]}}%)</td>
                        </tr>
                        @endif
                        @if($data[0]->specification_status == 1)
                        <tr id="">
                            <td class="data1">Prod Specifications Count</td>
                            <td class="data2">{{$specification[0]}} <br> <strong>{{$specification_report[0]}} SKUs</strong> <br> ({{$specification_pres_report[0]}}%)</td>
                            <td class="data3">{{$specification[1]}} <br> <strong>{{$specification_report[1]}} SKUs</strong> <br> ({{$specification_pres_report[1]}}%)</td>
                            <td class="data4">{{$specification[2]}} <br> <strong>{{$specification_report[2]}} SKUs</strong> <br> ({{$specification_pres_report[2]}}%)</td>
                            <td class="data5">{{$specification[3]}} <br> <strong>{{$specification_report[3]}} SKUs</strong> <br> ({{$specification_pres_report[3]}}%)</td>
                            <td class="data6">{{$specification[4]++}}+ <br> <strong>{{$specification_report[4]}} SKUs</strong> <br> ({{$specification_pres_report[4]}}%)</td>
                        </tr>
                        @endif
                        @if($data[0]->image_status == 1)
                        <tr id="">
                            <td class="data1 data1-first">Images Count</td>
                            <td class="data2">{{$image[0]}} <br> <strong>{{$image_report[0]}} SKUs</strong> <br> ({{$image_pres_report[0]}}%)</td>
                            <td class="data3">{{$image[1]}} <br> <strong>{{$image_report[1]}} SKUs</strong> <br> ({{$image_pres_report[1]}}%)</td>
                            <td class="data4">{{$image[2]}} <br> <strong>{{$image_report[2]}} SKUs</strong> <br> ({{$image_pres_report[2]}}%)</td>
                            <td class="data5">{{$image[3]}} <br> <strong>{{$image_report[3]}} SKUs</strong> <br> ({{$image_pres_report[3]}}%)</td>
                            <td class="data6 data6-last">{{$image[4]++}}+ <br> <strong>{{$image_report[4]}} SKUs</strong> <br> ({{$image_pres_report[4]}}%)</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- Overall Chart -->
            <div class="row" id="overall_row">
                <div class="col-md-1 col-xs-12 ignore-print">

                </div>
                <div class="col-md-7 col-xs-12 overall_notes_div ignore-print">
                    <div class="mt-3">
                        <h5>Summary</h5>
                        <?php echo htmlspecialchars_decode($overall_notes); ?>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12" id="overall_chart_div">
                    <div id="overall_chart" ></div>
                </div>
                <div class="col-md-8 col-xs-12 overall_notes_div only-print">
                    <div class="content_notes mt-3">
                        <h5>Summary</h5>
                        <?php echo htmlspecialchars_decode($overall_notes); ?>
                    </div>
                </div>
            </div>

            @if($data[0]->title_status == 1)
            <!-- Title Chart -->
            <div class="row" id="title_row">
                <div class="col-md-4 col-xs-12" id="title_chart_div">
                    <div id="title_chart" >
                        
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 notes_div">
                    <div class="content_notes mt-3">
                        <h5>Title Character Analysis</h5>
                        <?php echo htmlspecialchars_decode($title_notes); ?>
                    </div>
                </div>
            </div>
            @endif

            @if($data[0]->description_status == 1)
            <!-- Description Chart -->
            <div class="row" id="description_row">
                <div class="col-md-4 col-xs-12" id="description_chart_div">
                    <div id="description_chart" >
                        
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 notes_div">
                    <div class="content_notes mt-3">
                        <h5>Description Word Analysis</h5>
                        <?php echo htmlspecialchars_decode($description_notes); ?>
                    </div>
                </div>
            </div>
            @endif

            @if($data[0]->feature_status == 1)
            <!-- Feature Chart -->
            <div class="row" id="feature_row">
                <div class="col-md-4 col-xs-12" id="feature_chart_div">
                    <div id="feature_chart" >
                        
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 notes_div">
                    <div class="content_notes mt-3">
                        <h5>Feature Bullet Count Analysis</h5>
                        <?php echo htmlspecialchars_decode($feature_notes); ?>
                    </div>
                </div>
            </div>
            @endif

            @if($data[0]->specification_status == 1)
            <!-- Specification Chart -->
            <div class="row" id="specification_row">
                <div class="col-md-4 col-xs-12" id="specification_chart_div">
                    <div id="specification_chart" >
                        
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 notes_div">
                    <div class="content_notes mt-3">
                        <h5>Specification count Analysis</h5>
                        <?php echo htmlspecialchars_decode($specification_notes); ?>
                    </div>
                </div>
            </div>
            @endif

            @if($data[0]->image_status == 1)
            <!-- Image Chart -->
            <div class="row" id="image_row">
                <div class="col-md-4 col-xs-12" id="image_chart_div">
                    <div id="image_chart" >
                       
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 notes_div">
                    <div class="content_notes mt-3">
                        <h5>Image count Analysis</h5>
                        <?php echo htmlspecialchars_decode($image_notes); ?>
                    </div>
                </div>
            </div>
            @endif
            @else
            <div class="col-12 mb-3 text-center">
                <h3>No data Found</h3>
            </div>
            @endif
            <!-- Print Button -->
            <div class="col-12 mb-3 mt-3 text-center ignore-print">
                <button class="submit-button" id="cmd">Print Report</button>
            </div>
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
    <script src="{{ asset('js/report.js') }}"></script>
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
            // name : ['hao','hai','hai','hai','hai'],
            // name: ['0 - {{$title[0]}} Characters','{{++$title[0]}} - {{$title[1]}} Characters','{{++$title[1]}} - {{$title[2]}} Characters','{{++$title[2]}} - {{$title[3]}} Characters','{{$title[3]}}+ Characters']
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#ef9b9b', '#f6c056', '#eff078', '#80edc6', '#77c382']
            },
            type: 'pie'
            }];

        // Description
        var data2 = [{
            values: ['{{$description_pres_report[0]}}', '{{$description_pres_report[1]}}', '{{$description_pres_report[2]}}', '{{$description_pres_report[3]}}', '{{$description_pres_report[4]}}'],
            labels: ['{{$description_report[0]}} SKUs', '{{$description_report[1]}} SKUs', '{{$description_report[2]}} SKUs', '{{$description_report[3]}} SKUs', '{{$description_report[4]}} SKUs' ],
            domain: {column: 0},
            name: 'GHG Emissions',
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#ef9b9b', '#f6c056', '#eff078', '#80edc6', '#77c382']
            },
            type: 'pie'
            }];

        // Feature
        var data3 = [{
            values: ['{{$feature_pres_report[0]}}', '{{$feature_pres_report[1]}}', '{{$feature_pres_report[2]}}', '{{$feature_pres_report[3]}}', '{{$feature_pres_report[4]}}'],
            labels: ['{{$feature_report[0]}} SKUs', '{{$feature_report[1]}} SKUs', '{{$feature_report[2]}} SKUs', '{{$feature_report[3]}} SKUs', '{{$feature_report[4]}} SKUs' ],
            domain: {column: 0},
            name: 'GHG Emissions',
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#ef9b9b', '#f6c056', '#eff078', '#80edc6', '#77c382']
            },
            type: 'pie'
            }];

        // Specification
        var data4 = [{
            values: ['{{$specification_pres_report[0]}}', '{{$specification_pres_report[1]}}', '{{$specification_pres_report[2]}}', '{{$specification_pres_report[3]}}', '{{$specification_pres_report[4]}}'],
            labels: ['{{$specification_report[0]}} SKUs', '{{$specification_report[1]}} SKUs', '{{$specification_report[2]}} SKUs', '{{$specification_report[3]}} SKUs', '{{$specification_report[4]}} SKUs' ],
            domain: {column: 0},
            name: 'GHG Emissions',
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#ef9b9b', '#f6c056', '#eff078', '#80edc6', '#77c382']
            },
            type: 'pie'
            }];

        // Image
        var data5 = [{
            values: ['{{$image_pres_report[0]}}', '{{$image_pres_report[1]}}', '{{$image_pres_report[2]}}', '{{$image_pres_report[3]}}', '{{$image_pres_report[4]}}'],
            labels: ['{{$image_report[0]}} SKUs', '{{$image_report[1]}} SKUs', '{{$image_report[2]}} SKUs', '{{$image_report[3]}} SKUs', '{{$image_report[4]}} SKUs' ],
            domain: {column: 0},
            name: 'GHG Emissions',
            hoverinfo: 'label+percent',
            hole: .4,
            marker: {
                colors: ['#ef9b9b', '#f6c056', '#eff078', '#80edc6', '#77c382']
            },
            type: 'pie'
            }];

        // Title
        var layout1 = {
        title: 'Title Score',
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
        height: 400,
        showlegend: false,
        grid: {rows: 1, columns:1 }
        };

        // description
        var layout2 = {
        title: 'Description Score',
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
        height: 400,
        showlegend: false,
        grid: {rows: 1, columns:1 }
        };

        // Feature
        var layout3 = {
        title: 'Feature Score',
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
        height: 400,
        showlegend: false,
        grid: {rows: 1, columns:1 }
        };

        // Specification
        var layout4 = {
        title: 'Specification Score',
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
        height: 400,
        showlegend: false,
        grid: {rows: 1, columns:1 }
        };

        // Image
        var layout5 = {
        title: 'Image Score',
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
        height: 400,
        showlegend: false,
        grid: {rows: 1, columns:1 }
        };

        var title_status = $("#title_status").val();
        var description_status = $("#description_status").val();
        var feature_status = $("#feature_status").val();
        var specification_status = $("#specification_status").val();
        var image_status = $("#image_status").val();
        // console.log(title_status)

        if(title_status == 1){
            Plotly.newPlot('title_chart', data1, layout1);
        }
        if(description_status == 1){
            Plotly.newPlot('description_chart', data2, layout2);
        }
        if(feature_status == 1){
            Plotly.newPlot('feature_chart', data3, layout3);
        }
        if(specification_status == 1){
            Plotly.newPlot('specification_chart', data4, layout4);
        }
        if(image_status == 1){
            Plotly.newPlot('image_chart', data5, layout5);
        }

        
    </script>
    <!-- Indicator Chart Script -->
    <script>
        var data = [
        {
            domain: { x: [0, 1], y: [0, 1] },
            value: "{{number_format($overall_score,2)}}",
            title: { text: "Overall Score" },
            type: "indicator",
            mode: "gauge+number",
            delta: { reference: 400 },
            gauge: { bar: { color: "#fead76" },
                     bgcolor: "#e2e2e2",
                     axis: { range: [null, 5] } }
        }
        ];

        var layout = {  height: 300 };

        Plotly.newPlot('overall_chart', data, layout);
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
        $(document).on("click","#cmd",function() {
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
</body>
</html>