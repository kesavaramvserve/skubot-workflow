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
        .mobile-table{
            display: none;
        }
        @media (max-width: 844px) {
            .desktop-table{
                display: none;
            }
            .mobile-table{
                display: block;
            }
            /* .main-section{
                margin-top: 25% !important;
                height: 100%;
            }
            .gen-padding {
                padding: 5% 5%;
            } */
            .site-logo{
                width: 75px;
            }
            .user-details {
                width: 270px;
            }
            .personal{
                display: none;
            }
            .page-heading-div {
                width: 45% !important;
            }
            .page-heading {
                font-size: 18px;
                margin-left: 20%;
            }
            .website-icon-div, .price-icon-div{
                margin-left:0% !important;
            }
            .col-xs-6{
                float:left;
                width: 50%;
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
                <div class="float-end user-details">
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
                <div class="row heading mb-5">
                    <!-- Back icon with Page heading -->
                    <div class="col-md-4 col-xs-12">
                        <div style="float: left;" class="mt-3">
                            <a href="{{ url()->previous() }}"><img src="{{asset('images/back.png')}}" alt="Back" class="" width="35px"></a>
                        </div>
                        <div style="float: left;" class="mt-3">
                            <span class="page-heading">Edit</span>
                        </div>
                    </div>
                    <!-- Empty -->
                    <div class="col-1">
                        
                    </div>
                    <!-- Website -->
                    <div class="col-md-4 col-xs-12">
                        <!-- Icon -->
                        <div style="float: left;margin-left: 20%;" class="mt-3 website-icon-div">
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
                    <!-- Total Price -->
                    <div class="col-md-3 col-xs-12">
                        <!-- Icon -->
                        <div style="float: left;margin-left: 20%;" class="mt-3 price-icon-div">
                            <img src="{{asset('images/total-sku.png')}}" alt="Back" class="" width="50px">
                        </div>
                        <!-- Text -->
                        <div style="float: left;" class="mt-3 float-end">
                            <div>
                                <span class="">Total Price</span>
                            </div>
                            <div>
                                <span style="font-weight: 600;">${{$grand_total}}</span style="font-weight: 500;">
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- Table -->
                <div class="row">
                    <form action="{{route('client.client_request')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{$website_id}}" name="website_id">
                    <input type="hidden" value="{{$category}}" name="category">
                    <input type="hidden" value="{{$brand}}" name="brand">
                    <input type="hidden" name="grand_total" value="{{$grand_total}}">
                    <input type="hidden" name="price[]" value="{{$req_title[0]}}">
                    <input type="hidden" name="price[]" value="{{$req_title[1]}}">
                    <input type="hidden" name="price[]" value="{{$req_title[2]}}">
                    <input type="hidden" name="price[]" value="{{$req_title[3]}}">
                    <input type="hidden" name="price[]" value="{{$req_title[4]}}">
                    <input type="hidden" name="price[]" value="{{$req_description[0]}}">
                    <input type="hidden" name="price[]" value="{{$req_description[1]}}">
                    <input type="hidden" name="price[]" value="{{$req_description[2]}}">
                    <input type="hidden" name="price[]" value="{{$req_description[3]}}">
                    <input type="hidden" name="price[]" value="{{$req_description[4]}}">
                    <input type="hidden" name="price[]" value="{{$req_feature[0]}}">
                    <input type="hidden" name="price[]" value="{{$req_feature[1]}}">
                    <input type="hidden" name="price[]" value="{{$req_feature[2]}}">
                    <input type="hidden" name="price[]" value="{{$req_feature[3]}}">
                    <input type="hidden" name="price[]" value="{{$req_feature[4]}}">
                    <input type="hidden" name="price[]" value="{{$req_specification[0]}}">
                    <input type="hidden" name="price[]" value="{{$req_specification[1]}}">
                    <input type="hidden" name="price[]" value="{{$req_specification[2]}}">
                    <input type="hidden" name="price[]" value="{{$req_specification[3]}}">
                    <input type="hidden" name="price[]" value="{{$req_specification[4]}}">
                    <input type="hidden" name="price[]" value="{{$req_image[0]}}">
                    <input type="hidden" name="price[]" value="{{$req_image[1]}}">
                    <input type="hidden" name="price[]" value="{{$req_image[2]}}">
                    <input type="hidden" name="price[]" value="{{$req_image[3]}}">
                    <input type="hidden" name="price[]" value="{{$req_image[4]}}">
                        <div class="col-12 table-responsive table-section desktop-table">
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
                                    <!-- Title -->
                                    <tr class="table-row">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Title Characters</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$title_prices[0]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$title[0]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$title_total[0]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$title_prices[1]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$title[1]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$title_total[1]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$title_prices[2]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$title[2]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$title_total[2]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$title_prices[3]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$title[3]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$title_total[3]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$title_prices[4]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$title[4]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$title_total[4]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Description -->
                                    <tr class="table-row">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Description Words</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$description_prices[0]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$description[0]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$description_total[0]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$description_prices[1]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$description[1]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$description_total[1]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$description_prices[2]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$description[2]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$description_total[2]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$description_prices[3]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$description[3]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$description_total[3]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$description_prices[4]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$description[4]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$description_total[4]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Feature -->
                                    <tr class="table-row">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Feature Bullets Count</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$feature_prices[0]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$feature[0]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$feature_total[0]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$feature_prices[1]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$feature[1]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$feature_total[1]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$feature_prices[2]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$feature[2]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$feature_total[2]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$feature_prices[3]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$feature[3]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$feature_total[3]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                            <!-- Range -->
                                            <div class="col-12">
                                                <span class="float-start">Rate Per SKU: ${{$feature_prices[4]->price}}</span>
                                            </div>
                                            <!-- SKU Count -->
                                            <div class="col-6">
                                                <span class="float-start">{{$feature[4]}} SKU's</span>
                                            </div>
                                            <!-- SKU Percentage -->
                                            <div class="col-6">
                                                <span class="float-end">${{$feature_total[4]}}</span>
                                            </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Specification -->
                                    <tr class="table-row">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Prod Specifications Count</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$specification_prices[0]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$specification[0]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$specification_total[0]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$specification_prices[1]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$specification[1]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$specification_total[1]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$specification_prices[2]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$specification[2]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$specification_total[2]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$specification_prices[3]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$specification[3]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$specification_total[3]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$specification_prices[4]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$specification[4]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$specification_total[4]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Image -->
                                    <tr class="table-row">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Images Count</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$image_prices[0]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$image[0]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$image_total[0]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$image_prices[1]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$image[1]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$image_total[1]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$image_prices[2]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$image[2]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$image_total[2]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$image_prices[3]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$image[3]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$image_total[3]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <!-- Range -->
                                                <div class="col-12">
                                                    <span class="float-start">Rate Per SKU: ${{$image_prices[4]->price}}</span>
                                                </div>
                                                <!-- SKU Count -->
                                                <div class="col-6">
                                                    <span class="float-start">{{$image[4]}} SKU's</span>
                                                </div>
                                                <!-- SKU Percentage -->
                                                <div class="col-6">
                                                    <span class="float-end">${{$image_total[4]}}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 col-xs-12 mobile-table">
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
                                                        <div class="col-xs-12">
                                                            <span class="float-start">Rate Per SKU: ${{$title_prices[0]->price}}</span>
                                                        </div>
                                                        <!-- SKU Count -->
                                                        <div class="col-xs-6">
                                                            <span class="float-start">{{$title[0]}} SKU's</span>
                                                        </div>
                                                        <!-- SKU Percentage -->
                                                        <div class="col-xs-6">
                                                            <span class="float-end">${{$title_total[0]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$title_prices[1]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$title[1]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$title_total[1]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$title_prices[2]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$title[2]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$title_total[2]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$title_prices[3]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$title[3]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$title_total[3]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$title_prices[4]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$title[4]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$title_total[4]}}</span>
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
                                                        <div class="col-xs-12">
                                                            <span class="float-start">Rate Per SKU: ${{$description_prices[0]->price}}</span>
                                                        </div>
                                                        <!-- SKU Count -->
                                                        <div class="col-xs-6">
                                                            <span class="float-start">{{$description[0]}} SKU's</span>
                                                        </div>
                                                        <!-- SKU Percentage -->
                                                        <div class="col-xs-6">
                                                            <span class="float-end">${{$description_total[0]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$description_prices[1]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$description[1]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$description_total[1]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$description_prices[2]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$description[2]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$description_total[2]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$description_prices[3]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$description[3]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$description_total[3]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$description_prices[4]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$description[4]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$description_total[4]}}</span>
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
                                                        <div class="col-xs-12">
                                                            <span class="float-start">Rate Per SKU: ${{$feature_prices[0]->price}}</span>
                                                        </div>
                                                        <!-- SKU Count -->
                                                        <div class="col-xs-6">
                                                            <span class="float-start">{{$feature[0]}} SKU's</span>
                                                        </div>
                                                        <!-- SKU Percentage -->
                                                        <div class="col-xs-6">
                                                            <span class="float-end">${{$feature_total[0]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$feature_prices[1]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$feature[1]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$feature_total[1]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$feature_prices[2]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$feature[2]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$feature_total[2]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$feature_prices[3]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$feature[3]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$feature_total[3]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$feature_prices[4]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$feature[4]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$feature_total[4]}}</span>
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
                                                        <div class="col-xs-12">
                                                            <span class="float-start">Rate Per SKU: ${{$specification_prices[0]->price}}</span>
                                                        </div>
                                                        <!-- SKU Count -->
                                                        <div class="col-xs-6">
                                                            <span class="float-start">{{$specification[0]}} SKU's</span>
                                                        </div>
                                                        <!-- SKU Percentage -->
                                                        <div class="col-xs-6">
                                                            <span class="float-end">${{$specification_total[0]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$specification_prices[1]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$specification[1]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$specification_total[1]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$specification_prices[2]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$specification[2]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$specification_total[2]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$specification_prices[3]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$specification[3]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$specification_total[3]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$specification_prices[4]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$specification[4]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$specification_total[4]}}</span>
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
                                                        <div class="col-xs-12">
                                                            <span class="float-start">Rate Per SKU: ${{$image_prices[0]->price}}</span>
                                                        </div>
                                                        <!-- SKU Count -->
                                                        <div class="col-xs-6">
                                                            <span class="float-start">{{$image[0]}} SKU's</span>
                                                        </div>
                                                        <!-- SKU Percentage -->
                                                        <div class="col-xs-6">
                                                            <span class="float-end">${{$image_total[0]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$image_prices[1]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$image[1]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$image_total[1]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$image_prices[2]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$image[2]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$image_total[2]}}</span>
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
                                                            <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$image_prices[3]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$image[3]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$image_total[3]}}</span>
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
                                                           <div class="col-xs-12">
                                                                <span class="float-start">Rate Per SKU: ${{$image_prices[4]->price}}</span>
                                                            </div>
                                                            <!-- SKU Count -->
                                                            <div class="col-xs-6">
                                                                <span class="float-start">{{$image[4]}} SKU's</span>
                                                            </div>
                                                            <!-- SKU Percentage -->
                                                            <div class="col-xs-6">
                                                                <span class="float-end">${{$image_total[4]}}</span>
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
                </div>
            </div>
            <div class="col-1"></div>
        </div>

        <!-- Print Button -->
        <div class="row mb-5">
            <div class="col-5"></div>
            <div class="col-2 text-center">
                <input type="submit" class="btn submit-button" value="Proceed to Pay">
            </div>
            <div class="col-5"></div>
        </div>
        </form>
    </div>
</body>
</html>