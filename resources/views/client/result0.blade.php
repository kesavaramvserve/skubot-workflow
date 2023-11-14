@extends('layouts.main')

@section('main-content')
    <div class="">
        <div class="content-wrapper">
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
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Total Price: ${{$grand_total}}</h1>
                </div>
            </div>
            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SKU Analysis</th>
                            <th>High attention required</th>
                            <th>Needs Improvement</th>
                            <th>Good To Improve</th>
                            <th>Average Optimized</th>
                            <th>Optimized</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Title Characters</td>
                            <td>Unit Price: ${{$title_prices[0]->price}}<br><br>{{$title[0]}} SKU's<br><br>${{$title_total[0]}}</td>
                            <td>Unit Price: ${{$title_prices[1]->price}}<br><br>{{$title[1]}} SKU's<br><br>${{$title_total[1]}}</td>
                            <td>Unit Price: ${{$title_prices[2]->price}}<br><br>{{$title[2]}} SKU's<br><br>${{$title_total[2]}}</td>
                            <td>Unit Price: ${{$title_prices[3]->price}}<br><br>{{$title[3]}} SKU's<br><br>${{$title_total[3]}}</td>
                            <td>Unit Price: ${{$title_prices[4]->price}}<br><br>{{$title[4]}} SKU's<br><br>${{$title_total[4]}}</td>
                        </tr>
                        <tr>
                            <td>Description Words</td>
                            <td>Unit Price: ${{$description_prices[0]->price}}<br><br>{{$description[0]}} SKU's<br><br>${{$description_total[0]}}</td>
                            <td>Unit Price: ${{$description_prices[1]->price}}<br><br>{{$description[1]}} SKU's<br><br>${{$description_total[1]}}</td>
                            <td>Unit Price: ${{$description_prices[2]->price}}<br><br>{{$description[2]}} SKU's<br><br>${{$description_total[2]}}</td>
                            <td>Unit Price: ${{$description_prices[3]->price}}<br><br>{{$description[3]}} SKU's<br><br>${{$description_total[3]}}</td>
                            <td>Unit Price: ${{$description_prices[4]->price}}<br><br>{{$description[4]}} SKU's<br><br>${{$description_total[4]}}</td>
                        </tr>
                        <tr>
                            <td>Feature Bullets Count</td>
                            <td>Unit Price: ${{$feature_prices[0]->price}}<br><br>{{$feature[0]}} SKU's<br><br>${{$feature_total[0]}}</td>
                            <td>Unit Price: ${{$feature_prices[1]->price}}<br><br>{{$feature[1]}} SKU's<br><br>${{$feature_total[1]}}</td>
                            <td>Unit Price: ${{$feature_prices[2]->price}}<br><br>{{$feature[2]}} SKU's<br><br>${{$feature_total[2]}}</td>
                            <td>Unit Price: ${{$feature_prices[3]->price}}<br><br>{{$feature[3]}} SKU's<br><br>${{$feature_total[3]}}</td>
                            <td>Unit Price: ${{$feature_prices[4]->price}}<br><br>{{$feature[4]}} SKU's<br><br>${{$feature_total[4]}}</td>
                        </tr>
                        <tr>
                            <td>Prod Specifications Count</td>
                            <td>Unit Price: ${{$specification_prices[0]->price}}<br><br>{{$specification[0]}} SKU's<br><br>${{$specification_total[0]}}</td>
                            <td>Unit Price: ${{$specification_prices[1]->price}}<br><br>{{$specification[1]}} SKU's<br><br>${{$specification_total[1]}}</td>
                            <td>Unit Price: ${{$specification_prices[2]->price}}<br><br>{{$specification[2]}} SKU's<br><br>${{$specification_total[2]}}</td>
                            <td>Unit Price: ${{$specification_prices[3]->price}}<br><br>{{$specification[3]}} SKU's<br><br>${{$specification_total[3]}}</td>
                            <td>Unit Price: ${{$specification_prices[4]->price}}<br><br>{{$specification[4]}} SKU's<br><br>${{$specification_total[4]}}</td>
                        </tr>
                        <tr>
                            <td>Images Count</td>
                            <td>Unit Price: ${{$image_prices[0]->price}}<br><br>{{$image[0]}} SKU's<br><br>${{$image_total[0]}}</td>
                            <td>Unit Price: ${{$image_prices[1]->price}}<br><br>{{$image[1]}} SKU's<br><br>${{$image_total[1]}}</td>
                            <td>Unit Price: ${{$image_prices[2]->price}}<br><br>{{$image[2]}} SKU's<br><br>${{$image_total[2]}}</td>
                            <td>Unit Price: ${{$image_prices[3]->price}}<br><br>{{$image[3]}} SKU's<br><br>${{$image_total[3]}}</td>
                            <td>Unit Price: ${{$image_prices[4]->price}}<br><br>{{$image[4]}} SKU's<br><br>${{$image_total[4]}}</td>
                        </tr>
                        <tr>
                            <td>Sub Total</td>
                            <td>${{$score1}}</td>
                            <td>${{$score2}}</td>
                            <td>${{$score3}}</td>
                            <td>${{$score4}}</td>
                            <td>${{$score5}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <a href="{{ url()->previous() }}" class="btn btn-info" style="margin-left:80%">Edit</a>
                </div>
                <div class="col-md-6">
                    <input type="submit" class="btn btn-success">
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection