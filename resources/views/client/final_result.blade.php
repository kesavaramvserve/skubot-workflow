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
            }
            .overall_notes_div {
                padding: 00px 0px 0px 0px !important;
                background-color: #e0e0e0;
                margin-top: 50px !important;
            }
            .content_notes{
                padding: 10px 10px 10px 10px !important;
                margin-left: 0px !important;
                /* height: 0px !important; */
                margin-bottom: 50px !important;
            }
        }
        .col-md-8.col-xs-12.notes_div {
                padding: 50px 0px 50px 50px;
            }
        .content_notes{
            background-color: #e0e0e0;
            padding: 10px 10px 10px 70px;
            margin-left: -200px;
            min-height: 300px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-12 print-logo1">
                <img src="{{asset('assets/images/logo.jpg')}}" class="ignore-print" alt="logo">
                <img width="150px" src="{{asset('assets/images/report_logo.png')}}" class="only-print" alt="logo">
            </div>
            <div class="col-md-8 col-xs-12">
                
            </div>
        </div>
        <!-- Title Section -->
        <div class="row content-section">
            <div class="col-12 title-section ignore-print">
                <div class="mt-2">
                    <span class="dot"></span>
                    <span class="website_list">ENHANCE REPORT</span>
                    <!-- <a href="{{route('website.index')}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a> -->
                </div>
            </div>
            <!-- Filter -->
            <div class="col-12 website-details-section ignore-print">
                <form action="{{route('client.result',$website_id)}}" method="get">
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
                        
                        <div class="col-2 text-center ignore-print">
                            <button class="submit-button" id="cmd">Print Report</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ asset('enhance-data/'.$website_datas[0]->getEnhancedData->path) }}" data-id="{{$website_id}}" class="send-mail" download>Download Enhanced Data</a>
                        </div>
                    </div>
                </form>
            </div> 
            <div class="col-md-10 website-details-section">
                <p>Website: <strong>{{$website_name}}</strong></p>
            </div>
            <div class="col-md-2 website-details-section">
                <p>Total SKUs: <strong>{{$total_sku}}</strong></p>
            </div>
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
                        <tr id="">
                            <td class="data1">Title Characters</td>
                            <td class="data2">0-40 <br> <strong>{{$title_report[0]}} SKUs</strong> <br> ({{$title_pres_report[0]}}%)</td>
                            <td class="data3">41-60 <br> <strong>{{$title_report[1]}} SKUs</strong> <br> ({{$title_pres_report[1]}}%)</td>
                            <td class="data4">61-70 <br> <strong>{{$title_report[2]}} SKUs</strong> <br> ({{$title_pres_report[2]}}%)</td>
                            <td class="data5">71-80 <br> <strong>{{$title_report[3]}} SKUs</strong> <br> ({{$title_pres_report[3]}}%)</td>
                            <td class="data6">81+ <br> <strong>{{$title_report[4]}} SKUs</strong> <br> ({{$title_pres_report[4]}}%)</td>
                        </tr>
                        <tr id="">
                            <td class="data1">Description Words</td>
                            <td class="data2">0-30 <br> <strong>{{$description_report[0]}} SKUs</strong> <br> ({{$description_pres_report[0]}}%)</td>
                            <td class="data3">31-60 <br> <strong>{{$description_report[1]}} SKUs</strong> <br> ({{$description_pres_report[1]}}%)</td>
                            <td class="data4">61-80 <br> <strong>{{$description_report[2]}} SKUs</strong> <br> ({{$description_pres_report[2]}}%)</td>
                            <td class="data5">81-100 <br> <strong>{{$description_report[3]}} SKUs</strong> <br> ({{$description_pres_report[3]}}%)</td>
                            <td class="data6">101+ <br> <strong>{{$description_report[4]}} SKUs</strong> <br> ({{$description_pres_report[4]}}%)</td>
                        </tr>
                        <tr id="">
                            <td class="data1">Feature Bullets Count</td>
                            <td class="data2">0 <br> <strong>{{$feature_report[0]}} SKUs</strong> <br> ({{$feature_pres_report[0]}}%)</td>
                            <td class="data3">2 <br> <strong>{{$feature_report[1]}} SKUs</strong> <br> ({{$feature_pres_report[1]}}%)</td>
                            <td class="data4">3 <br> <strong>{{$feature_report[2]}} SKUs</strong> <br> ({{$feature_pres_report[2]}}%)</td>
                            <td class="data5">4 <br> <strong>{{$feature_report[3]}} SKUs</strong> <br> ({{$feature_pres_report[3]}}%)</td>
                            <td class="data6">5+ <br> <strong>{{$feature_report[4]}} SKUs</strong> <br> ({{$feature_pres_report[4]}}%)</td>
                        </tr>
                        <tr id="">
                            <td class="data1">Prod Specifications Count</td>
                            <td class="data2">0 <br> <strong>{{$specification_report[0]}} SKUs</strong> <br> ({{$specification_pres_report[0]}}%)</td>
                            <td class="data3">2 <br> <strong>{{$specification_report[1]}} SKUs</strong> <br> ({{$specification_pres_report[1]}}%)</td>
                            <td class="data4">3 <br> <strong>{{$specification_report[2]}} SKUs</strong> <br> ({{$specification_pres_report[2]}}%)</td>
                            <td class="data5">4 <br> <strong>{{$specification_report[3]}} SKUs</strong> <br> ({{$specification_pres_report[3]}}%)</td>
                            <td class="data6">5+ <br> <strong>{{$specification_report[4]}} SKUs</strong> <br> ({{$specification_pres_report[4]}}%)</td>
                        </tr>
                        <tr id="">
                            <td class="data1 data1-first">Images Count</td>
                            <td class="data2">0 <br> <strong>{{$image_report[0]}} SKUs</strong> <br> ({{$image_pres_report[0]}}%)</td>
                            <td class="data3">2 <br> <strong>{{$image_report[1]}} SKUs</strong> <br> ({{$image_pres_report[1]}}%)</td>
                            <td class="data4">3 <br> <strong>{{$image_report[2]}} SKUs</strong> <br> ({{$image_pres_report[2]}}%)</td>
                            <td class="data5">4 <br> <strong>{{$image_report[3]}} SKUs</strong> <br> ({{$image_pres_report[3]}}%)</td>
                            <td class="data6 data6-last">5+ <br> <strong>{{$image_report[4]}} SKUs</strong> <br> ({{$image_pres_report[4]}}%)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Overall Chart -->
            <div class="row" id="overall_row">
                <div class="col-md-8 col-xs-12 overall_notes_div ignore-print">
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
            @else
            <div class="col-12 mb-3 text-center">
                <h3>No data Found</h3>
            </div>
            @endif
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{asset('AppAssets/plugins/chart.js/Chart.min.js')}}"></script>
    <script src='https://cdn.plot.ly/plotly-2.16.1.min.js'></script> 
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="{{ asset('js/report.js') }}"></script>
    <script src='https://cdn.plot.ly/plotly-2.18.2.min.js'></script>
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


        Plotly.newPlot('title_chart', data1, layout1);
        Plotly.newPlot('description_chart', data2, layout2);
        Plotly.newPlot('feature_chart', data3, layout3);
        Plotly.newPlot('specification_chart', data4, layout4);
        Plotly.newPlot('image_chart', data5, layout5);
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
    <!-- Print Scripts -->
    <script>
        $(document).on("click","#cmd",function() {
            window.print();
        });
        // Add Data history
        $(document).on("click",".send-mail",function() {
            var website_id = $(this).attr('data-id');
            $.ajax({
                type: 'GET',
                url: 'add_data_history',
                data: {id:website_id},
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>
</body>
</html>