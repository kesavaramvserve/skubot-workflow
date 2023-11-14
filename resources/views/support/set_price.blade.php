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
        .mobile-table, .mobile-submit{
            display: none;
        }
        @media (max-width: 844px) {
            .desktop-table, .desktop-submit{
                display: none;
            }
            .mobile-table, .mobile-submit{
                display: block;
            }
            .accordion-button{
                background-color: #39bc86 !important;
                color : black !important;
                border-radius: 10px 10px 0 0 !important;
            }
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
            .user-details {
                width: 270px;
            }
            .personal{
                display: none;
            }
            .page-heading-div {
                width: 45% !important;
                margin-left: 13%;
            }
            .page-heading {
                font-size: 18px;
                margin-left: 20%;
            }
            .website-icon{
                margin-left:0% !important;
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
            </div>
        </div>
        <!-- Header End -->
        
        <!-- Main section 1 -->
        <div class="row mb-5">
            <div class="col-1"></div>
            <div class="main-section col-10">

                <!-- Page Heading -->
                <div class="row heading">
                    <!-- Back icon with Page heading -->
                    <div class="col-md-6 col-xs-12">
                        <div style="float: left;" class="mt-3">
                            <a href="{{route('website.index')}}"><img src="{{asset('images/back.png')}}" alt="Back" class="" width="35px"></a>
                        </div>
                        <div style="float: left;width: 35%;" class="mt-3 page-heading-div">
                            <span class="page-heading">Set Price</span>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4 col-xs-12">
                        <!-- Icon -->
                        <div style="float: left;margin-left: 20%;" class="mt-3 website-icon">
                            <img src="{{asset('images/website.png')}}" alt="Back" class="" width="50px">
                        </div>
                        <!-- Text -->
                        <div style="float: left;" class="mt-3 float-end">
                            <div>
                                <span class="">Website</span>
                            </div>
                            <div>
                                <span style="font-weight: 600;">{{$website[0]->website}}</span style="font-weight: 500;">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Desktop Table Start -->
                <form action="{{route('support.update',$website[0]->id)}}" method="post" class="desktop-table">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="website_id" value="{{$website[0]->id}}">
                    <input type="hidden" value="{{$website_prices[0]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[1]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[2]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[3]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[4]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[5]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[6]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[7]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[8]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[9]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[10]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[11]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[12]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[13]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[14]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[15]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[16]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[17]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[18]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[19]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[20]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[21]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[22]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[23]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[24]->id}}" name="image_id[]">
                    <div class="row desktop-table mt-5">
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
                                    <!-- Title Characters -->
                                    <tr class="table-row" id="title">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Title Characters</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 title" min="0" value="{{$website_prices[0]->price}}" name="title[]" type="number">
                                                        <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range2 title" min="0" value="{{$website_prices[1]->price}}" name="title[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range3 title" min="0" value="{{$website_prices[2]->price}}" name="title[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 title" min="0" value="{{$website_prices[3]->price}}" name="title[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 title" min="0" value="{{$website_prices[4]->price}}" name="title[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Description Words -->
                                    <tr class="table-row" id="description">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Description Words</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 description" min="0" value="{{$website_prices[5]->price}}" name="description[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range2 description" min="0" value="{{$website_prices[6]->price}}" name="description[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range3 description" min="0" value="{{$website_prices[7]->price}}" name="description[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 description" min="0" value="{{$website_prices[8]->price}}" name="description[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 description" min="0" value="{{$website_prices[9]->price}}" name="description[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Feature Bullets Count -->
                                    <tr class="table-row" id="feature">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Feature Bullets Count</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 feature" min="0" value="{{$website_prices[10]->price}}" name="feature[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range2 feature" min="0" value="{{$website_prices[11]->price}}" name="feature[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range3 feature" min="0" value="{{$website_prices[12]->price}}" name="feature[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 feature" min="0" value="{{$website_prices[13]->price}}" name="feature[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 feature" min="0" value="{{$website_prices[14]->price}}" name="feature[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Prod Specifications Count -->
                                    <tr class="table-row" id="specification">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Prod Specifications Count</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 specification" min="0" value="{{$website_prices[15]->price}}" name="specification[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range2 specification" min="0" value="{{$website_prices[16]->price}}" name="specification[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range3 specification" min="0" value="{{$website_prices[17]->price}}" name="specification[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 specification" min="0" value="{{$website_prices[18]->price}}" name="specification[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 specification" min="0" value="{{$website_prices[19]->price}}" name="specification[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Image -->
                                    <tr class="table-row" id="image">
                                        <!-- Data 1 Heading -->
                                        <td class="data1">Images Count</td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 image" min="0" value="{{$website_prices[20]->price}}" name="image[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 3 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range2 image" min="0" value="{{$website_prices[21]->price}}" name="image[]" type="number">
                                                        <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                        <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 4 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range3 image" min="0" value="{{$website_prices[22]->price}}" name="image[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 image" min="0" value="{{$website_prices[23]->price}}" name="image[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 image" min="0" value="{{$website_prices[24]->price}}" name="image[]" type="number">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <!-- Desktop Table End -->

                <!-- Mobile Table Start -->
                <form action="{{route('support.update',$website[0]->id)}}" method="post" class="mobile-table">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="website_id" value="{{$website[0]->id}}">
                    <input type="hidden" value="{{$website_prices[0]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[1]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[2]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[3]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[4]->id}}" name="title_id[]">
                    <input type="hidden" value="{{$website_prices[5]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[6]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[7]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[8]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[9]->id}}" name="description_id[]">
                    <input type="hidden" value="{{$website_prices[10]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[11]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[12]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[13]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[14]->id}}" name="feature_id[]">
                    <input type="hidden" value="{{$website_prices[15]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[16]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[17]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[18]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[19]->id}}" name="specification_id[]">
                    <input type="hidden" value="{{$website_prices[20]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[21]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[22]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[23]->id}}" name="image_id[]">
                    <input type="hidden" value="{{$website_prices[24]->id}}" name="image_id[]">
                    <div class="row mobile-table mt-3">
                        <div class="accordion" id="accordionExample">

                            <!-- Title -->
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
                                                    <div class="col-12">
                                                        <div class="number-input">
                                                            <input class="quantity no-arrows btn range1 mobile_title" min="0" value="{{$website_prices[0]->price}}" name="title[]" type="number">
                                                            <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                            <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_title" min="0" value="{{$website_prices[1]->price}}" name="title[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_title" min="0" value="{{$website_prices[2]->price}}" name="title[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_title" min="0" value="{{$website_prices[3]->price}}" name="title[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="mobile-title">
                                                <th>
                                                    Optimized<br> (5)
                                                    <div class="progress data5-progress" style="width: 80%">
                                                        <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="row data-row">
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_title" min="0" value="{{$website_prices[4]->price}}" name="title[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                    <div class="col-12">
                                                        <div class="number-input">
                                                            <input class="quantity no-arrows btn range1 mobile_description" min="0" value="{{$website_prices[5]->price}}" name="description[]" type="number">
                                                            <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                            <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_description" min="0" value="{{$website_prices[6]->price}}" name="description[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_description" min="0" value="{{$website_prices[7]->price}}" name="description[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_description" min="0" value="{{$website_prices[8]->price}}" name="description[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="mobile-description">
                                                <th>
                                                    Optimized<br> (5)
                                                    <div class="progress data5-progress" style="width: 80%">
                                                        <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="row data-row">
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_description" min="0" value="{{$website_prices[9]->price}}" name="description[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                            
                            <!-- Feature -->
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Feature Bullets Count<br><span id="mobile-feature-error"></span>
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
                                                    <div class="col-12">
                                                        <div class="number-input">
                                                            <input class="quantity no-arrows btn range1 mobile_feature" min="0" value="{{$website_prices[10]->price}}" name="feature[]" type="number">
                                                            <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                            <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_feature" min="0" value="{{$website_prices[11]->price}}" name="feature[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_feature" min="0" value="{{$website_prices[12]->price}}" name="feature[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_feature" min="0" value="{{$website_prices[13]->price}}" name="feature[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="mobile-feature">
                                                <th>
                                                    Optimized<br> (5)
                                                    <div class="progress data5-progress" style="width: 80%">
                                                        <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="row data-row">
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_feature" min="0" value="{{$website_prices[14]->price}}" name="feature[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                            
                            <!-- Specification -->
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Prod Specifications Count<br><span id="mobile-specification-error"></span>
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
                                                    <div class="col-12">
                                                        <div class="number-input">
                                                            <input class="quantity no-arrows btn range1 mobile_specification" min="0" value="{{$website_prices[15]->price}}" name="specification[]" type="number">
                                                            <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                            <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_specification" min="0" value="{{$website_prices[16]->price}}" name="specification[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_specification" min="0" value="{{$website_prices[17]->price}}" name="specification[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_specification" min="0" value="{{$website_prices[18]->price}}" name="specification[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="mobile-specification">
                                                <th>
                                                    Optimized<br> (5)
                                                    <div class="progress data5-progress" style="width: 80%">
                                                        <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="row data-row">
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_specification" min="0" value="{{$website_prices[19]->price}}" name="specification[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                            
                            <!-- Image -->
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Images Count<br><span id="mobile-image-error"></span>
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
                                                    <div class="col-12">
                                                        <div class="number-input">
                                                            <input class="quantity no-arrows btn range1 mobile_image" min="0" value="{{$website_prices[20]->price}}" name="image[]" type="number">
                                                            <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                            <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_image" min="0" value="{{$website_prices[21]->price}}" name="image[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_image" min="0" value="{{$website_prices[22]->price}}" name="image[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_image" min="0" value="{{$website_prices[23]->price}}" name="image[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="mobile-image">
                                                <th>
                                                    Optimized<br> (5)
                                                    <div class="progress data5-progress" style="width: 80%">
                                                        <div class="progress-bar data5-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="row data-row">
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 mobile_image" min="0" value="{{$website_prices[24]->price}}" name="image[]" type="number">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                            
                        </div>
                    </div>
                </form>
                <!-- Mobile Table End -->

            </div>
            <div class="col-1"></div>
        </div>

        <!-- Print Button -->
        <div class="row mb-5">
            <div class="col-5"></div>
            <div class="col-2 text-center">
                <input type="submit" class="btn submit-button desktop-submit" value="Update">
                <input type="submit" class="btn submit-button mobile-submit" value="Update">
            </div>
            <div class="col-5"></div>
        </div>

    </div>
    <script src="{{ asset('js/set_price.js') }}"></script>
    <!-- Form Submit -->
    <script>
        $(".desktop-submit").on("click", function () {
            $(".desktop-table").submit();
        });
        $(".mobile-submit").on("click", function () {
            $(".mobile-table").submit();
        });
    </script>
</body>
</html>