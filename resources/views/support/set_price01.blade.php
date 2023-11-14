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
    <link rel="stylesheet" href="{{ asset('css/set_price.css') }}">
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-12">
                <a href="{{route('website.index')}}"><img src="{{asset('assets/images/logo.jpg')}}" alt="logo"></a>
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
                    <span class="website_list">SET PRICE</span>
                    <a href="{{route('website.index')}}" class="float-end back"><img src="{{asset('client/images/back.png')}}" alt="Back" title="GO Back">Back</a>
                </div>
            </div>
            <div class="col-12 website-details-section">
                <p><strong>Website:</strong> {{$website[0]->website}}</p>
                <p><strong>Scoring Criteria</strong></p>
            </div>
            @if(blank($website_prices))
            <!-- Create Form -->
            <form action="{{route('support.store')}}" method="post">
                @csrf
                <input type="hidden" name="website_id" value="{{$website[0]->id}}">
                <div class="col-12 table-section table-responsive">
                    <table>
                        <thead>
                            <th class="head1">Warning Notes</th>
                            <th class="head2">High attention required</th>
                            <th class="head3">Needs Improvement</th>
                            <th class="head4">Good To Improve</th>
                            <th class="head5">Average Optimized</th>
                            <th class="head6">Optimized</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="data1">Score</td>
                                <td class="data2">1</td>
                                <td class="data3">2</td>
                                <td class="data4">3</td>
                                <td class="data5">4</td>
                                <td class="data6">5</td>
                            </tr>
                            <tr id="title">
                                <td class="data1">Title Characters</td>
                                <td class="data2"><input step="any" type="number" value="" class="title input" name="title[]"></td>
                                <td class="data3"><input step="any" type="number" value="" class="title input" name="title[]"></td>
                                <td class="data4"><input step="any" type="number" value="" class="title input" name="title[]"></td>
                                <td class="data5"><input step="any" type="number" value="" class="title input" name="title[]"></td>
                                <td class="data6"><input step="any" type="number" value="" class="title input" name="title[]"></td>
                            </tr>
                            <tr id="description">
                                <td class="data1">Description Words</td>
                                <td class="data2"><input step="any" type="number" value="" class="description input" name="description[]"></td>
                                <td class="data3"><input step="any" type="number" value="" class="description input" name="description[]"></td>
                                <td class="data4"><input step="any" type="number" value="" class="description input" name="description[]"></td>
                                <td class="data5"><input step="any" type="number" value="" class="description input" name="description[]"></td>
                                <td class="data6"><input step="any" type="number" value="" class="description input" name="description[]"></td>
                            </tr>
                            <tr id="feature">
                                <td class="data1">Feature Bullets Count</td>
                                <td class="data2"><input step="any" type="number" value="" class="feature input" name="feature[]"></td>
                                <td class="data3"><input step="any" type="number" value="" class="feature input" name="feature[]"></td>
                                <td class="data4"><input step="any" type="number" value="" class="feature input" name="feature[]"></td>
                                <td class="data5"><input step="any" type="number" value="" class="feature input" name="feature[]"></td>
                                <td class="data6"><input step="any" type="number" value="" class="feature input" name="feature[]"></td>
                            </tr>
                            <tr id="specification">
                                <td class="data1">Prod Specifications Count</td>
                                <td class="data2"><input step="any" type="number" value="" class="specification input" name="specification[]"></td>
                                <td class="data3"><input step="any" type="number" value="" class="specification input" name="specification[]"></td>
                                <td class="data4"><input step="any" type="number" value="" class="specification input" name="specification[]"></td>
                                <td class="data5"><input step="any" type="number" value="" class="specification input" name="specification[]"></td>
                                <td class="data6"><input step="any" type="number" value="" class="specification input" name="specification[]"></td>
                            </tr>
                            <tr id="image">
                                <td class="data1 data1-first">Images Count</td>
                                <td class="data2"><input step="any" type="number" value="" class="image input" name="image[]"></td>
                                <td class="data3"><input step="any" type="number" value="" class="image input" name="image[]"></td>
                                <td class="data4"><input step="any" type="number" value="" class="image input" name="image[]"></td>
                                <td class="data5"><input step="any" type="number" value="" class="image input" name="image[]"></td>
                                <td class="data6 data6-last"><input step="any" type="number" value="" class="image input" name="image[]"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 submit-section">
                    <input type="submit" class="submit-button" value="SUBMIT">
                </div>
            </form>
            @else
            <!-- Update Form -->
            <form action="{{route('support.update',$website[0]->id)}}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="website_id" value="{{$website[0]->id}}">
                <div class="col-12 table-section table-responsive">
                    <table>
                        <thead>
                            <th class="head1">Warning Notes</th>
                            <th class="head2">High attention required</th>
                            <th class="head3">Needs Improvement</th>
                            <th class="head4">Good To Improve</th>
                            <th class="head5">Average Optimized</th>
                            <th class="head6">Optimized</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="data1">Score</td>
                                <td class="data2">1</td>
                                <td class="data3">2</td>
                                <td class="data4">3</td>
                                <td class="data5">4</td>
                                <td class="data6">5</td>
                            </tr>
                            <tr id="title">
                                <input type="hidden" value="{{$website_prices[0]->id}}" name="title_id[]">
                                <input type="hidden" value="{{$website_prices[1]->id}}" name="title_id[]">
                                <input type="hidden" value="{{$website_prices[2]->id}}" name="title_id[]">
                                <input type="hidden" value="{{$website_prices[3]->id}}" name="title_id[]">
                                <input type="hidden" value="{{$website_prices[4]->id}}" name="title_id[]">
                                <td class="data1">Title Characters</td>
                                <td class="data2"><input step="any" type="number" value="{{$website_prices[0]->price}}" class="title input" name="title[]"></td>
                                <td class="data3"><input step="any" type="number" value="{{$website_prices[1]->price}}" class="title input" name="title[]"></td>
                                <td class="data4"><input step="any" type="number" value="{{$website_prices[2]->price}}" class="title input" name="title[]"></td>
                                <td class="data5"><input step="any" type="number" value="{{$website_prices[3]->price}}" class="title input" name="title[]"></td>
                                <td class="data6"><input step="any" type="number" value="{{$website_prices[4]->price}}" class="title input" name="title[]"></td>
                            </tr>
                            <tr id="description">
                                <input type="hidden" value="{{$website_prices[5]->id}}" name="description_id[]">
                                <input type="hidden" value="{{$website_prices[6]->id}}" name="description_id[]">
                                <input type="hidden" value="{{$website_prices[7]->id}}" name="description_id[]">
                                <input type="hidden" value="{{$website_prices[8]->id}}" name="description_id[]">
                                <input type="hidden" value="{{$website_prices[9]->id}}" name="description_id[]">
                                <td class="data1">Description Words</td>
                                <td class="data2"><input step="any" type="number" value="{{$website_prices[5]->price}}" class="description input" name="description[]"></td>
                                <td class="data3"><input step="any" type="number" value="{{$website_prices[6]->price}}" class="description input" name="description[]"></td>
                                <td class="data4"><input step="any" type="number" value="{{$website_prices[7]->price}}" class="description input" name="description[]"></td>
                                <td class="data5"><input step="any" type="number" value="{{$website_prices[8]->price}}" class="description input" name="description[]"></td>
                                <td class="data6"><input step="any" type="number" value="{{$website_prices[9]->price}}" class="description input" name="description[]"></td>
                            </tr>
                            <tr id="feature">
                                <input type="hidden" value="{{$website_prices[10]->id}}" name="feature_id[]">
                                <input type="hidden" value="{{$website_prices[11]->id}}" name="feature_id[]">
                                <input type="hidden" value="{{$website_prices[12]->id}}" name="feature_id[]">
                                <input type="hidden" value="{{$website_prices[13]->id}}" name="feature_id[]">
                                <input type="hidden" value="{{$website_prices[14]->id}}" name="feature_id[]">
                                <td class="data1">Feature Bullets Count</td>
                                <td class="data2"><input step="any" type="number" value="{{$website_prices[10]->price}}" class="feature input" name="feature[]"></td>
                                <td class="data3"><input step="any" type="number" value="{{$website_prices[11]->price}}" class="feature input" name="feature[]"></td>
                                <td class="data4"><input step="any" type="number" value="{{$website_prices[12]->price}}" class="feature input" name="feature[]"></td>
                                <td class="data5"><input step="any" type="number" value="{{$website_prices[13]->price}}" class="feature input" name="feature[]"></td>
                                <td class="data6"><input step="any" type="number" value="{{$website_prices[14]->price}}" class="feature input" name="feature[]"></td>
                            </tr>
                            <tr id="specification">
                                <input type="hidden" value="{{$website_prices[15]->id}}" name="specification_id[]">
                                <input type="hidden" value="{{$website_prices[16]->id}}" name="specification_id[]">
                                <input type="hidden" value="{{$website_prices[17]->id}}" name="specification_id[]">
                                <input type="hidden" value="{{$website_prices[18]->id}}" name="specification_id[]">
                                <input type="hidden" value="{{$website_prices[19]->id}}" name="specification_id[]">
                                <td class="data1">Prod Specifications Count</td>
                                <td class="data2"><input step="any" type="number" value="{{$website_prices[15]->price}}" class="specification input" name="specification[]"></td>
                                <td class="data3"><input step="any" type="number" value="{{$website_prices[16]->price}}" class="specification input" name="specification[]"></td>
                                <td class="data4"><input step="any" type="number" value="{{$website_prices[17]->price}}" class="specification input" name="specification[]"></td>
                                <td class="data5"><input step="any" type="number" value="{{$website_prices[18]->price}}" class="specification input" name="specification[]"></td>
                                <td class="data6"><input step="any" type="number" value="{{$website_prices[19]->price}}" class="specification input" name="specification[]"></td>
                            </tr>
                            <tr id="image">
                                <input type="hidden" value="{{$website_prices[20]->id}}" name="image_id[]">
                                <input type="hidden" value="{{$website_prices[21]->id}}" name="image_id[]">
                                <input type="hidden" value="{{$website_prices[22]->id}}" name="image_id[]">
                                <input type="hidden" value="{{$website_prices[23]->id}}" name="image_id[]">
                                <input type="hidden" value="{{$website_prices[24]->id}}" name="image_id[]">
                                <td class="data1 data1-first">Images Count</td>
                                <td class="data2"><input step="any" type="number" value="{{$website_prices[20]->price}}" class="image input" name="image[]"></td>
                                <td class="data3"><input step="any" type="number" value="{{$website_prices[21]->price}}" class="image input" name="image[]"></td>
                                <td class="data4"><input step="any" type="number" value="{{$website_prices[22]->price}}" class="image input" name="image[]"></td>
                                <td class="data5"><input step="any" type="number" value="{{$website_prices[23]->price}}" class="image input" name="image[]"></td>
                                <td class="data6 data6-last"><input step="any" type="number" value="{{$website_prices[24]->price}}" class="image input" name="image[]"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 submit-section">
                    <input type="submit" class="submit-button" value="UPDATE">
                </div>
            </form>
            @endif
        </div>
    </div>


<script src="{{ asset('js/set_price.js') }}"></script>
</body>
</html>