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
        input[type="number"] {
            width: 50%;
        }
        .ml{
            margin-left:10px;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-4 print-logo1">
                <a href="{{route('website.index')}}"><img src="{{asset('assets/images/logo.jpg')}}" alt="logo"></a>
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
                    <span class="website_list">Set Range</span>
                    <a href="{{route('website.index')}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a>
                </div>
            </div>
            <form action="{{route('scrape_view')}}" method="get" id="set_range_form">
                @csrf
                <input type="hidden" value="{{$website_id}}" name="website_id">
                <!--Description Category range-->
                <div class="col-12 mt-3 text-center">
                    <label><strong>Select Category:</strong></label>
                    <select id="description_category" name="description_category">
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
                
                <!-- Table -->
                <div class="col-12 table-section table-responsive mt-3">
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
                                <td class="data1">Title Characters<input type="checkbox" name="title_status" value="1" class="ml" id="" {{$data[0]->title_status==1 ? 'checked':''}}><br><span id="title_error_div"></span></td>
                                <td class="data2"><input type="number" name="title[]" value="{{$title[0]}}" class="text-center" id="title1"></td>
                                <td class="data3"><input type="number" name="title[]" value="{{$title[1]}}" class="text-center" id="title2"></td>
                                <td class="data4"><input type="number" name="title[]" value="{{$title[2]}}" class="text-center" id="title3"></td>
                                <td class="data5"><input type="number" name="title[]" value="{{$title[3]}}" class="text-center" id="title4"></td>
                                <td class="data6"><input type="number" name="title[]" value="{{$title[4]}}" class="text-center" id="title5"></td>
                            </tr>
                            <tr id="">
                                <td class="data1">Description Words<input type="checkbox" name="description_status" value="1" class="ml" id="" {{$data[0]->description_status==1 ? 'checked':''}}><br><span id="description_error_div"></span></td>
                                <td class="data2"><input type="number" name="description[]" value="{{$description[0]}}" class="text-center" id="description1"></td>
                                <td class="data3"><input type="number" name="description[]" value="{{$description[1]}}" class="text-center" id="description2"></td>
                                <td class="data4"><input type="number" name="description[]" value="{{$description[2]}}" class="text-center" id="description3"></td>
                                <td class="data5"><input type="number" name="description[]" value="{{$description[3]}}" class="text-center" id="description4"></td>
                                <td class="data6"><input type="number" name="description[]" value="{{$description[4]}}" class="text-center" id="description5"></td>
                            </tr>
                            <tr id="">
                                <td class="data1">Feature Bullets Count<input type="checkbox" name="feature_status" value="1" class="ml" id="" {{$data[0]->feature_status==1 ? 'checked':''}}><br><span id="feature_error_div"></span></td>
                                <td class="data2"><input type="number" name="feature[]" value="{{$feature[0]}}" class="text-center" id="feature1"></td>
                                <td class="data3"><input type="number" name="feature[]" value="{{$feature[1]}}" class="text-center" id="feature2"></td>
                                <td class="data4"><input type="number" name="feature[]" value="{{$feature[2]}}" class="text-center" id="feature3"></td>
                                <td class="data5"><input type="number" name="feature[]" value="{{$feature[3]}}" class="text-center" id="feature4"></td>
                                <td class="data6"><input type="number" name="feature[]" value="{{$feature[4]}}" class="text-center" id="feature5"></td>
                            </tr>
                            <tr id="">
                                <td class="data1">Prod Specifications Count<input type="checkbox" name="specification_status" value="1" class="ml" id="" {{$data[0]->specification_status==1 ? 'checked':''}}><br><span id="specification_error_div"></span></td>
                                <td class="data2"><input type="number" name="specification[]" value="{{$specification[0]}}" class="text-center" id="specification1"></td>
                                <td class="data3"><input type="number" name="specification[]" value="{{$specification[1]}}" class="text-center" id="specification2"></td>
                                <td class="data4"><input type="number" name="specification[]" value="{{$specification[2]}}" class="text-center" id="specification3"></td>
                                <td class="data5"><input type="number" name="specification[]" value="{{$specification[3]}}" class="text-center" id="specification4"></td>
                                <td class="data6"><input type="number" name="specification[]" value="{{$specification[4]}}" class="text-center" id="specification5"></td>
                            </tr>
                            <tr id="">
                                <td class="data1 data1-first">Images Count<input type="checkbox" name="image_status" value="1" class="ml" id="" {{$data[0]->image_status==1 ? 'checked':''}}><br><span id="image_error_div"></span></td>
                                <td class="data2"><input type="number" name="image[]" value="{{$image[0]}}" class="text-center" id="image1"></td>
                                <td class="data3"><input type="number" name="image[]" value="{{$image[1]}}" class="text-center" id="image2"></td>
                                <td class="data4"><input type="number" name="image[]" value="{{$image[2]}}" class="text-center" id="image3"></td>
                                <td class="data5"><input type="number" name="image[]" value="{{$image[3]}}" class="text-center" id="image4"></td>
                                <td class="data6 data6-last"><input type="number" name="image[]" value="{{$image[4]}}" class="text-center" id="image5"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Print Button -->
                <div class="col-12 mb-3 text-center">
                    <input type="submit" value="Submit" class="submit-button">
                </div>
            </form>
        </div>        
    </div>
    <script>
         $(document).on("change","#description_category",function() {
            var description_category = $("#description_category").val();
            if(description_category == 'Clothing'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Decor, Gift & Toys'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Electrical'){
                $("#description1").val('50');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
            }
            else if(description_category == 'Electronics'){
                $("#description1").val('50');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
            }
            else if(description_category == 'Food & Drink'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
            }
            else if(description_category == 'Hardware'){
                $("#description1").val('50');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
            }
            else if(description_category == 'Heating, Ventilation and Air-Conditioning & Fans'){
                $("#description1").val('40');
                $("#description2").val('70');
                $("#description3").val('90');
                $("#description4").val('120');
                $("#description5").val('121');
            }
            else if(description_category == 'Office & School Supplies'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Packaging & Shipping'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Pet Supplies'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Pool & Spa'){
                $("#description1").val('30');
                $("#description2").val('100');
                $("#description3").val('200');
                $("#description4").val('250');
                $("#description5").val('251');
            }
            else if(description_category == 'Safety & Security'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Skin & Health Care'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Sports and Outdoor'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Vehicle Maintanance'){
                $("#description1").val('30');
                $("#description2").val('100');
                $("#description3").val('200');
                $("#description4").val('250');
                $("#description5").val('251');
            }
            else if(description_category == 'Furnitures'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Clothing Accessories'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
            }
            else if(description_category == 'Jewelry'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
            }
            else if(description_category == 'Sunglasses'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Building Supplies'){
                $("#description1").val('30');
                $("#description2").val('70');
                $("#description3").val('100');
                $("#description4").val('150');
                $("#description5").val('151');
            }
            else if(description_category == 'Plumbing'){
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
            }
            else if(description_category == 'Oil & Gas'){
                $("#description1").val('500');
                $("#description2").val('100');
                $("#description3").val('150');
                $("#description4").val('200');
                $("#description5").val('201');
            }
            else{
                $("#description1").val('30');
                $("#description2").val('60');
                $("#description3").val('80');
                $("#description4").val('100');
                $("#description5").val('101');
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
</body>
</html>