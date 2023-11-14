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
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-12">
                <img src="{{asset('assets/images/logo.jpg')}}" alt="logo">
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="float-end mt-4">
                    <span class="user_role">{{ auth()->user()->first_name }} ({{ auth()->user()->getRole->name }})</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <!-- Title Section -->
        <div class="row content-section">
            <div class="col-12 title-section">
                <div class="mt-2">
                    <span class="dot"></span>
                    <span class="website_list">ENHANCE RESULT</span>
                </div>
            </div>
            <div class="col-6 website-details-section">
                <p>Website: <strong>{{$website_name}}</strong></p>
                <p>Total Price: <strong>${{$grand_total}}</strong></p>
            </div>
            <form action="{{route('client.client_request')}}" method="post">
                @csrf
                <input type="hidden" value="{{$website_id}}" name="website_id">
                <input type="hidden" value="{{$category}}" name="category">
                <input type="hidden" value="{{$brand}}" name="brand">
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
                                <td class="data2">Rate Per SKU: ${{$title_prices[0]->price}}<br>{{$title[0]}} SKU's<br><strong>${{$title_total[0]}}</strong></td>
                                <td class="data3">Rate Per SKU: ${{$title_prices[1]->price}}<br>{{$title[1]}} SKU's<br><strong>${{$title_total[1]}}</strong></td>
                                <td class="data4">Rate Per SKU: ${{$title_prices[2]->price}}<br>{{$title[2]}} SKU's<br><strong>${{$title_total[2]}}</strong></td>
                                <td class="data5">Rate Per SKU: ${{$title_prices[3]->price}}<br>{{$title[3]}} SKU's<br><strong>${{$title_total[3]}}</strong></td>
                                <td class="data6">Rate Per SKU: ${{$title_prices[4]->price}}<br>{{$title[4]}} SKU's<br><strong>${{$title_total[4]}}</strong></td>
                            </tr>
                            @endif
                
                            @if($data[0]->description_status == 1)
                            <tr id="">
                                <td class="data1">Description Words</td>
                                <td class="data2">Rate Per SKU: ${{$description_prices[0]->price}}<br>{{$description[0]}} SKU's<br><strong>${{$description_total[0]}}</strong></td>
                                <td class="data3">Rate Per SKU: ${{$description_prices[1]->price}}<br>{{$description[1]}} SKU's<br><strong>${{$description_total[1]}}</strong></td>
                                <td class="data4">Rate Per SKU: ${{$description_prices[2]->price}}<br>{{$description[2]}} SKU's<br><strong>${{$description_total[2]}}</strong></td>
                                <td class="data5">Rate Per SKU: ${{$description_prices[3]->price}}<br>{{$description[3]}} SKU's<br><strong>${{$description_total[3]}}</strong></td>
                                <td class="data6">Rate Per SKU: ${{$description_prices[4]->price}}<br>{{$description[4]}} SKU's<br><strong>${{$description_total[4]}}</strong></td>
                            </tr>
                            @endif

                            @if($data[0]->feature_status == 1)
                            <tr id="">
                                <td class="data1">Feature Bullets Count</td>
                                <td class="data2">Rate Per SKU: ${{$feature_prices[0]->price}}<br>{{$feature[0]}} SKU's<br><strong>${{$feature_total[0]}}</strong></td>
                                <td class="data3">Rate Per SKU: ${{$feature_prices[1]->price}}<br>{{$feature[1]}} SKU's<br><strong>${{$feature_total[1]}}</strong></td>
                                <td class="data4">Rate Per SKU: ${{$feature_prices[2]->price}}<br>{{$feature[2]}} SKU's<br><strong>${{$feature_total[2]}}</strong></td>
                                <td class="data5">Rate Per SKU: ${{$feature_prices[3]->price}}<br>{{$feature[3]}} SKU's<br><strong>${{$feature_total[3]}}</strong></td>
                                <td class="data6">Rate Per SKU: ${{$feature_prices[4]->price}}<br>{{$feature[4]}} SKU's<br><strong>${{$feature_total[4]}}</strong></td>
                            </tr>
                            @endif

                            @if($data[0]->specification_status == 1)
                            <tr id="">
                                <td class="data1">Prod Specifications Count</td>
                                <td class="data2">Rate Per SKU: ${{$specification_prices[0]->price}}<br>{{$specification[0]}} SKU's<br><strong>${{$specification_total[0]}}</strong></td>
                                <td class="data3">Rate Per SKU: ${{$specification_prices[1]->price}}<br>{{$specification[1]}} SKU's<br><strong>${{$specification_total[1]}}</strong></td>
                                <td class="data4">Rate Per SKU: ${{$specification_prices[2]->price}}<br>{{$specification[2]}} SKU's<br><strong>${{$specification_total[2]}}</strong></td>
                                <td class="data5">Rate Per SKU: ${{$specification_prices[3]->price}}<br>{{$specification[3]}} SKU's<br><strong>${{$specification_total[3]}}</strong></td>
                                <td class="data6">Rate Per SKU: ${{$specification_prices[4]->price}}<br>{{$specification[4]}} SKU's<br><strong>${{$specification_total[4]}}</strong></td>
                            </tr>
                            @endif

                            @if($data[0]->image_status == 1)
                            <tr id="">
                                <td class="data1 data1-first">Images Count</td>
                                <td class="data2">Rate Per SKU: ${{$image_prices[0]->price}}<br>{{$image[0]}} SKU's<br><strong>${{$image_total[0]}}</strong></td>
                                <td class="data3">Rate Per SKU: ${{$image_prices[1]->price}}<br>{{$image[1]}} SKU's<br><strong>${{$image_total[1]}}</strong></td>
                                <td class="data4">Rate Per SKU: ${{$image_prices[2]->price}}<br>{{$image[2]}} SKU's<br><strong>${{$image_total[2]}}</strong></td>
                                <td class="data5">Rate Per SKU: ${{$image_prices[3]->price}}<br>{{$image[3]}} SKU's<br><strong>${{$image_total[3]}}</strong></td>
                                <td class="data6 data6-last">Rate Per SKU: ${{$image_prices[4]->price}}<br>{{$image[4]}} SKU's<br><strong>${{$image_total[4]}}</strong></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="row mb-3 px-5">
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                        <div class="float-end">
                            <a href="{{ url()->previous() }}" class="submit-button edit">Edit</a>
                            <input type="submit" class="submit-button">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/report.js') }}"></script>
</body>
</html>