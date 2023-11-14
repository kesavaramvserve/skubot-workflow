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
                width: 70%;
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
                            <span class="page-heading">Set Range</span>
                        </div>
                    </div>
                    <div class="col-6"></div>
                </div>

                <!-- Filter Section -->
                <div class="row filter-section">
                    <!-- Category -->
                    <div class="col-md-3 col-xs-12">
                        <select id="description_category" name="description_category" class="filter-select">
                            <option value="">Select Category</option>
                            <option value="Clothing" {{$description_category == 'Clothing' ? 'selected' : ''}}>Clothing</option>
                            <option value="Decor, Gift & Toys" {{$description_category == 'Decor, Gift & Toys' ? 'selected' : ''}}>Decor, Gift & Toys</option>
                            <option value="Electrical" {{$description_category == 'Electrical' ? 'selected' : ''}}>Electrical</option>
                            <option value="Electronics" {{$description_category == 'Electronics' ? 'selected' : ''}}>Electronics</option>
                            <option value="Food & Drink" {{$description_category == 'Food & Drink' ? 'selected' : ''}}>Food & Drink</option>
                            <option value="Hardware" {{$description_category == 'Hardware' ? 'selected' : ''}}>Hardware</option>
                            <option value="Heating, Ventilation and Air-Conditioning & Fans" {{$description_category == 'Heating, Ventilation and Air-Conditioning & Fans' ? 'selected' : ''}}>Heating, Ventilation and Air-Conditioning & Fans</option>
                            <option value="Office & School Supplies" {{$description_category == 'Office & School Supplies' ? 'selected' : ''}}>Office & School Supplies</option>
                            <option value="Packaging & Shipping" {{$description_category == 'Packaging & Shipping' ? 'selected' : ''}}>Packaging & Shipping</option>
                            <option value="Pet Supplies" {{$description_category == 'Pet Supplies' ? 'selected' : ''}}>Pet Supplies</option>
                            <option value="Pool & Spa" {{$description_category == 'Pool & Spa' ? 'selected' : ''}}>Pool & Spa</option>
                            <option value="Safety & Security" {{$description_category == 'Safety & Security' ? 'selected' : ''}}>Safety & Security</option>
                            <option value="Skin & Health Care" {{$description_category == 'Skin & Health Care' ? 'selected' : ''}}>Skin & Health Care</option>
                            <option value="Sports and Outdoor" {{$description_category == 'Sports and Outdoor' ? 'selected' : ''}}>Sports and Outdoor</option>
                            <option value="Vehicle Maintanance" {{$description_category == 'Vehicle Maintanance' ? 'selected' : ''}}>Vehicle Maintanance</option>
                            <option value="Furnitures" {{$description_category == 'Furnitures' ? 'selected' : ''}}>Furnitures</option>
                            <option value="Clothing Accessories" {{$description_category == 'Clothing Accessories' ? 'selected' : ''}}>Clothing Accessories</option>
                            <option value="Jewelry" {{$description_category == 'Jewelry' ? 'selected' : ''}}>Jewelry</option>
                            <option value="Sunglasses" {{$description_category == 'Sunglasses' ? 'selected' : ''}}>Sunglasses</option>
                            <option value="Building Supplies" {{$description_category == 'Building Supplies' ? 'selected' : ''}}>Building Supplies</option>
                            <option value="Plumbing" {{$description_category == 'Plumbing' ? 'selected' : ''}}>Plumbing</option>
                            <option value="Oil & Gas" {{$description_category == 'Oil & Gas' ? 'selected' : ''}}>Oil & Gas</option>
                        </select>
                    </div>
                    <div class="col-md-9 col-xs-12">
                    </div>
                </div>

                <!-- Desktop Table Start -->
                <form action="{{route('scrape_view')}}" method="get" id="set_range_form" class="desktop-table">
                    @csrf
                    <input type="hidden" value="{{$website_id}}" name="website_id">
                    <div class="row desktop-table">
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
                                        <td class="data1"><input type="checkbox" name="title_status" value="1" class="checkbox" id="" {{$data[0]->title_status==1 ? 'checked':''}}>Title Characters<br><span id="title_error_div"></span> </td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 title" min="0" value="{{$title[0]}}" name="title[]" type="number" id="title1">
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
                                                        <input class="quantity no-arrows btn range2 title" min="0" value="{{$title[1]}}" name="title[]" type="number" id="title2">
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
                                                    <input class="quantity no-arrows btn range3 title" min="0" value="{{$title[2]}}" name="title[]" type="number" id="title3">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 title" min="0" value="{{$title[3]}}" name="title[]" type="number" id="title4">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 title" min="0" value="{{$title[4]}}" name="title[]" type="number" id="title5">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Description Words -->
                                    <tr class="table-row" id="description">
                                        <!-- Data 1 Heading -->
                                        <td class="data1"><input type="checkbox" name="description_status" value="1" class="checkbox" id="" {{$data[0]->description_status==1 ? 'checked':''}}>Description Words<br><span id="description_error_div"></span></td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 description" min="0" value="{{$description[0]}}" name="description[]" type="number" id="description1">
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
                                                        <input class="quantity no-arrows btn range2 description" min="0" value="{{$description[1]}}" name="description[]" type="number" id="description2">
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
                                                    <input class="quantity no-arrows btn range3 description" min="0" value="{{$description[2]}}" name="description[]" type="number" id="description3">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 description" min="0" value="{{$description[3]}}" name="description[]" type="number" id="description4">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 description" min="0" value="{{$description[4]}}" name="description[]" type="number" id="description5">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Feature Bullets Count -->
                                    <tr class="table-row" id="feature">
                                        <!-- Data 1 Heading -->
                                        <td class="data1"><input type="checkbox" name="feature_status" value="1" class="checkbox" id="" {{$data[0]->feature_status==1 ? 'checked':''}}>Feature Bullets Count<br><span id="feature_error_div"></span></td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 feature" min="0" value="{{$feature[0]}}" name="feature[]" type="number" id="feature1">
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
                                                        <input class="quantity no-arrows btn range2 feature" min="0" value="{{$feature[1]}}" name="feature[]" type="number" id="feature2">
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
                                                    <input class="quantity no-arrows btn range3 feature" min="0" value="{{$feature[2]}}" name="feature[]" type="number" id="feature3">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 feature" min="0" value="{{$feature[3]}}" name="feature[]" type="number" id="feature4">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 feature" min="0" value="{{$feature[4]}}" name="feature[]" type="number" id="feature5">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Prod Specifications Count -->
                                    <tr class="table-row" id="specification">
                                        <!-- Data 1 Heading -->
                                        <td class="data1"><input type="checkbox" name="specification_status" value="1" class="checkbox" id="" {{$data[0]->specification_status==1 ? 'checked':''}}>Prod Specifications Count<br><span id="specification_error_div"></span></td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 specification" min="0" value="{{$specification[0]}}" name="specification[]" type="number" id="specification1">
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
                                                        <input class="quantity no-arrows btn range2 specification" min="0" value="{{$specification[1]}}" name="specification[]" type="number" id="specification2">
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
                                                    <input class="quantity no-arrows btn range3 specification" min="0" value="{{$specification[2]}}" name="specification[]" type="number" id="specification3">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 specification" min="0" value="{{$specification[3]}}" name="specification[]" type="number" id="specification4">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 specification" min="0" value="{{$specification[4]}}" name="specification[]" type="number" id="specification5">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Image -->
                                    <tr class="table-row" id="image">
                                        <!-- Data 1 Heading -->
                                        <td class="data1"><input type="checkbox" name="image_status" value="1" class="checkbox" id="" {{$data[0]->image_status==1 ? 'checked':''}}>Images Count<br><span id="image_error_div"></span></td>
                                        <!-- Data 2 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <div class="number-input">
                                                        <input class="quantity no-arrows btn range1 image" min="0" value="{{$image[0]}}" name="image[]" type="number" id="image1">
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
                                                        <input class="quantity no-arrows btn range2 image" min="0" value="{{$image[1]}}" name="image[]" type="number" id="image2">
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
                                                    <input class="quantity no-arrows btn range3 image" min="0" value="{{$image[2]}}" name="image[]" type="number" id="image3">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 5 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range4 image" min="0" value="{{$image[3]}}" name="image[]" type="number" id="image4">
                                                    <button type="button" class="btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                    <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Data 6 -->
                                        <td class="">
                                            <div class="row data-row">
                                                <div class="col-12">
                                                    <input class="quantity no-arrows btn range5 image" min="0" value="{{$image[4]}}" name="image[]" type="number" id="image5">
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
                <form action="{{route('scrape_view')}}" method="get" id="set_range_form" class="mobile-table">
                    @csrf
                    <input type="hidden" value="{{$website_id}}" name="website_id">
                    <div class="row mobile-table mt-3">
                        <div class="accordion" id="accordionExample">

                            <!-- Title -->
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <input type="checkbox" name="title_status" value="1" class="checkbox" id="" {{$data[0]->title_status==1 ? 'checked':''}}>Title Characters
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
                                                            <input class="quantity no-arrows btn range1 title" min="0" value="{{$title[0]}}" name="title[]" type="number" id="title1">
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
                                                                <input class="quantity no-arrows btn range1 title" min="0" value="{{$title[1]}}" name="title[]" type="number" id="title2">
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
                                                                <input class="quantity no-arrows btn range1 title" min="0" value="{{$title[2]}}" name="title[]" type="number" id="title3">
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
                                                                <input class="quantity no-arrows btn range1 title" min="0" value="{{$title[3]}}" name="title[]" type="number" id="title4">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 title" min="0" value="{{$title[4]}}" name="title[]" type="number" id="title5">
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
                                    <input type="checkbox" name="description_status" value="1" class="checkbox" id="" {{$data[0]->description_status==1 ? 'checked':''}}>Description Words
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
                                                            <input class="quantity no-arrows btn range1 description" min="0" value="{{$description[0]}}" name="description[]" type="number" id="mobile-description1">
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
                                                                <input class="quantity no-arrows btn range1 description" min="0" value="{{$description[1]}}" name="description[]" type="number" id="mobile-description2">
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
                                                                <input class="quantity no-arrows btn range1 description" min="0" value="{{$description[2]}}" name="description[]" type="number" id="mobile-description3">
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
                                                                <input class="quantity no-arrows btn range1 description" min="0" value="{{$description[3]}}" name="description[]" type="number" id="mobile-description4">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 description" min="0" value="{{$description[4]}}" name="description[]" type="number" id="mobile-description5">
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
                                    <input type="checkbox" name="feature_status" value="1" class="checkbox" id="" {{$data[0]->feature_status==1 ? 'checked':''}}>Feature Bullets Count
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
                                                            <input class="quantity no-arrows btn range1 feature" min="0" value="{{$feature[0]}}" name="feature[]" type="number" id="feature1">
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
                                                                <input class="quantity no-arrows btn range1 feature" min="0" value="{{$feature[1]}}" name="feature[]" type="number" id="feature2">
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
                                                                <input class="quantity no-arrows btn range1 feature" min="0" value="{{$feature[2]}}" name="feature[]" type="number" id="feature3">
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
                                                                <input class="quantity no-arrows btn range1 feature" min="0" value="{{$feature[3]}}" name="feature[]" type="number" id="feature4">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 feature" min="0" value="{{$feature[4]}}" name="feature[]" type="number" id="feature5">
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
                                    <input type="checkbox" name="specification_status" value="1" class="checkbox" id="" {{$data[0]->specification_status==1 ? 'checked':''}}>Prod Specifications Count
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
                                                            <input class="quantity no-arrows btn range1 specification" min="0" value="{{$specification[0]}}" name="specification[]" type="number" id="specification1">
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
                                                                <input class="quantity no-arrows btn range1 specification" min="0" value="{{$specification[1]}}" name="specification[]" type="number" id="specification2">
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
                                                                <input class="quantity no-arrows btn range1 specification" min="0" value="{{$specification[2]}}" name="specification[]" type="number" id="specification3">
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
                                                                <input class="quantity no-arrows btn range1 specification" min="0" value="{{$specification[3]}}" name="specification[]" type="number" id="specification4">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 specification" min="0" value="{{$specification[4]}}" name="specification[]" type="number" id="specification5">
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
                                    <input type="checkbox" name="image_status" value="1" class="checkbox" id="" {{$data[0]->image_status==1 ? 'checked':''}}>Images Count
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
                                                            <input class="quantity no-arrows btn range1 image" min="0" value="{{$image[0]}}" name="image[]" type="number" id="image1">
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
                                                                <input class="quantity no-arrows btn range1 image" min="0" value="{{$image[1]}}" name="image[]" type="number" id="image2">
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
                                                                <input class="quantity no-arrows btn range1 image" min="0" value="{{$image[2]}}" name="image[]" type="number" id="image3">
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
                                                                <input class="quantity no-arrows btn range1 image" min="0" value="{{$image[3]}}" name="image[]" type="number" id="image4">
                                                                <button type="button" class="btn minus" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><img src="{{asset('images/down-small.png')}}" alt=""></button>
                                                                <button type="button" class="btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><img src="{{asset('images/up.png')}}" alt=""></button>
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
                                                        <div class="col-12">
                                                            <div class="number-input">
                                                                <input class="quantity no-arrows btn range1 image" min="0" value="{{$image[4]}}" name="image[]" type="number" id="image5">
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
                <input type="submit" class="btn submit-button desktop-submit" value="Submit">
                <input type="submit" class="btn submit-button mobile-submit" value="Submit">
            </div>
            <div class="col-5"></div>
        </div>

    </div>

    <!-- Category -->
    <script>
         $(document).on("change","#description_category",function() {
            var description_category = $("#description_category").val();
            if(description_category == 'Clothing'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Decor, Gift & Toys'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Electrical'){
                $("#description1").val('50');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
                $("#mobile-description1").val('50');
                $("#mobile-description2").val('100');
                $("#mobile-description3").val('150');
                $("#mobile-description4").val('200');
                $("#mobile-description5").val('201');
            }
            else if(description_category == 'Electronics'){
                $("#description1").val('50');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
                $("#mobile-description1").val('50');
                $("#mobile-description2").val('100');
                $("#mobile-description3").val('150');
                $("#mobile-description4").val('200');
                $("#mobile-description5").val('201');
            }
            else if(description_category == 'Food & Drink'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('60');
                $("#mobile-description3").val('80');
                $("#mobile-description4").val('100');
                $("#mobile-description5").val('101');
            }
            else if(description_category == 'Hardware'){
                $("#description1").val('50');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
                $("#mobile-description1").val('50');
                $("#mobile-description2").val('100');
                $("#mobile-description3").val('150');
                $("#mobile-description4").val('200');
                $("#mobile-description5").val('201');
            }
            else if(description_category == 'Heating, Ventilation and Air-Conditioning & Fans'){
                $("#description1").val('40');
                $("#description2").val('70');
                $("#description3").val('90');
                $("#description4").val('120');
                $("#description5").val('121');
                $("#mobile-description1").val('40');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('90');
                $("#mobile-description4").val('120');
                $("#mobile-description5").val('121');
            }
            else if(description_category == 'Office & School Supplies'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Packaging & Shipping'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Pet Supplies'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Pool & Spa'){
                $("#description1").val('30');
                $("#description2").val('100');
                $("#description3").val('200');
                $("#description4").val('250');
                $("#description5").val('251');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('100');
                $("#mobile-description3").val('200');
                $("#mobile-description4").val('250');
                $("#mobile-description5").val('251');
            }
            else if(description_category == 'Safety & Security'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Skin & Health Care'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Sports and Outdoor'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Vehicle Maintanance'){
                $("#description1").val('30');
                $("#description2").val('100');
                $("#description3").val('200');
                $("#description4").val('250');
                $("#description5").val('251');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('100');
                $("#mobile-description3").val('200');
                $("#mobile-description4").val('250');
                $("#mobile-description5").val('251');
            }
            else if(description_category == 'Furnitures'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Clothing Accessories'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('60');
                $("#mobile-description3").val('80');
                $("#mobile-description4").val('100');
                $("#mobile-description5").val('101');
            }
            else if(description_category == 'Jewelry'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('60');
                $("#mobile-description3").val('80');
                $("#mobile-description4").val('100');
                $("#mobile-description5").val('101');
            }
            else if(description_category == 'Sunglasses'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Building Supplies'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('70');
                $("#mobile-description3").val('100');
                $("#mobile-description4").val('150');
                $("#mobile-description5").val('151');
            }
            else if(description_category == 'Plumbing'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('60');
                $("#mobile-description3").val('80');
                $("#mobile-description4").val('100');
                $("#mobile-description5").val('101');
            }
            else if(description_category == 'Oil & Gas'){
                $("#description1").val('500');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
                $("#mobile-description1").val('500');
                $("#mobile-description2").val('100');
                $("#mobile-description3").val('150');
                $("#mobile-description4").val('200');
                $("#mobile-description5").val('201');
            }
            else{
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
                $("#mobile-description1").val('30');
                $("#mobile-description2").val('60');
                $("#mobile-description3").val('80');
                $("#mobile-description4").val('100');
                $("#mobile-description5").val('101');
            }
            console.log(description_category);
        });
    </script>

    <!-- Set Range validation -->
    <script>
        $("#set_range_form").on("submit", function (e) {
            var title1  = parseInt($("#title1").val());
            var title2  = parseInt($("#title2").val());
            var title3  = parseInt($("#title3").val());
            var title4  = parseInt($("#title4").val());
            var title5  = parseInt($("#title5").val());
            $("#title_error_div").empty();

            var description1  = parseInt($("#description1").val());
            var description2  = parseInt($("#description2").val());
            var description3  = parseInt($("#description3").val());
            var description4  = parseInt($("#description4").val());
            var description5  = parseInt($("#description5").val());
            $("#description_error_div").empty();

            var feature1  = parseInt($("#feature1").val());
            var feature2  = parseInt($("#feature2").val());
            var feature3  = parseInt($("#feature3").val());
            var feature4  = parseInt($("#feature4").val());
            var feature5  = parseInt($("#feature5").val());
            $("#feature_error_div").empty();

            var specification1  = parseInt($("#specification1").val());
            var specification2  = parseInt($("#specification2").val());
            var specification3  = parseInt($("#specification3").val());
            var specification4  = parseInt($("#specification4").val());
            var specification5  = parseInt($("#specification5").val());
            $("#specification_error_div").empty();

            var image1  = parseInt($("#image1").val());
            var image2  = parseInt($("#image2").val());
            var image3  = parseInt($("#image3").val());
            var image4  = parseInt($("#image4").val());
            var image5  = parseInt($("#image5").val());
            $("#image_error_div").empty();

            // Title Validation
            if(title2 <= title1 || title3 <= title2 || title4 <= title3 || title5 <= title4){
                e.preventDefault()
                $("#title_error_div").append("<span class='error'><strong>Invalid Title Range</strong><span>");
            }

            // Description Validation
            if(description2 <= description1 || description3 <= description2 || description4 <= description3 || description5 <= description4){
                e.preventDefault()
                $("#description_error_div").append("<span class='error'><strong>Invalid Description Range</strong><span>");
            }

            // Feature Validation
            if(feature2 <= feature1 || feature3 <= feature2 || feature4 <= feature3 || feature5 <= feature4){
                e.preventDefault()
                $("#feature_error_div").append("<span class='error'><strong>Invalid Feature Range</strong><span>");
            }

            // Specification Validation
            if(specification2 <= specification1 || specification3 <= specification2 || specification4 <= specification3 || specification5 <= specification4){
                e.preventDefault()
                $("#specification_error_div").append("<span class='error'><strong>Invalid Specification Range</strong><span>");
            }

            // Image Validation
            if(image2 <= image1 || image3 <= image2 || image4 <= image3 || image5 <= image4){
                e.preventDefault()
                $("#image_error_div").append("<span class='error'><strong>Invalid Image Range</strong><span>");
            }
        });
    </script>

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