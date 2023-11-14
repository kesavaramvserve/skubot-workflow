@extends('layouts.main')

@section('main-content')

<div class="content-wrapper">
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if(blank($website_prices))
        <!-- Create Form -->
        <form action="{{route('support.store')}}" method="post">
            @csrf
            <input type="hidden" name="website_id" value="{{$website[0]->id}}">
            <!-- Client Details -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <span><strong>Client Name:</strong> {{$website[0]->getClient->getUser->first_name}}</span>
                </div>
                <div class="col-md-6">
                    <span><strong>Website:</strong> {{$website[0]->website}}</span>
                    <a href="{{ route('website.index') }}" class="btn btn-primary" style="margin-left: 35%;">Back</a>
                </div>
            </div>
            <!-- Set Price Table -->
            <div class="row mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Warning Notes</th>
                            <th>High attention required</th>
                            <th>Needs Improvement</th>
                            <th>Good To Improve</th>
                            <th>Average Optimized</th>
                            <th>Optimized</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Score</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                        </tr>
                        <tr id="title">
                            <td>Title Characters</td>
                            <td><input step="any" type="number" value="" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="" class="title" name="title[]"></td>
                        </tr>
                        <tr id="description">
                            <td>Description Words</td>
                            <td><input step="any" type="number" value="" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="" class="description" name="description[]"></td>
                        </tr>
                        <tr id="feature">
                            <td>Feature Bullets Count</td>
                            <td><input step="any" type="number" value="" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="" class="feature" name="feature[]"></td>
                        </tr>
                        <tr id="specification">
                            <td>Prod Specifications Count</td>
                            <td><input step="any" type="number" value="" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="" class="specification" name="specification[]"></td>
                        </tr>
                        <tr id="image">
                            <td>Images Count</td>
                            <td><input step="any" type="number" value="" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="" class="image" name="image[]"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Form Submit -->
            <div class="row">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    @else
        <!-- Update Form -->
        <form action="{{route('support.update',$website[0]->id)}}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="website_id" value="{{$website[0]->id}}">
            <!-- Client Details -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <span><strong>Client Name:</strong> {{$website[0]->getClient->getUser->first_name}}</span>
                </div>
                <div class="col-md-6">
                    <span><strong>Website:</strong> {{$website[0]->website}}</span>
                    <a href="{{ route('website.index') }}" class="btn btn-primary" style="margin-left: 35%;">Back</a>
                </div>
            </div>
            <!-- Set Price Table -->
            <div class="row mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Warning Notes</th>
                            <th>High attention required</th>
                            <th>Needs Improvement</th>
                            <th>Good To Improve</th>
                            <th>Average Optimized</th>
                            <th>Optimized</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Score</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                        </tr>
                        <tr id="title">
                            <td>Title Characters</td>
                            <input type="hidden" value="{{$website_prices[0]->id}}" name="title_id[]">
                            <input type="hidden" value="{{$website_prices[1]->id}}" name="title_id[]">
                            <input type="hidden" value="{{$website_prices[2]->id}}" name="title_id[]">
                            <input type="hidden" value="{{$website_prices[3]->id}}" name="title_id[]">
                            <input type="hidden" value="{{$website_prices[4]->id}}" name="title_id[]">
                            <td><input step="any" type="number" value="{{$website_prices[0]->price}}" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[1]->price}}" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[2]->price}}" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[3]->price}}" class="title" name="title[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[4]->price}}" class="title" name="title[]"></td>
                        </tr>
                        <tr id="description">
                            <td>Description Words</td>
                            <input type="hidden" value="{{$website_prices[5]->id}}" name="description_id[]">
                            <input type="hidden" value="{{$website_prices[6]->id}}" name="description_id[]">
                            <input type="hidden" value="{{$website_prices[7]->id}}" name="description_id[]">
                            <input type="hidden" value="{{$website_prices[8]->id}}" name="description_id[]">
                            <input type="hidden" value="{{$website_prices[9]->id}}" name="description_id[]">
                            <td><input step="any" type="number" value="{{$website_prices[5]->price}}" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[6]->price}}" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[7]->price}}" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[8]->price}}" class="description" name="description[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[9]->price}}" class="description" name="description[]"></td>
                        </tr>
                        <tr id="feature">
                            <td>Feature Bullets Count</td>
                            <input type="hidden" value="{{$website_prices[10]->id}}" name="feature_id[]">
                            <input type="hidden" value="{{$website_prices[11]->id}}" name="feature_id[]">
                            <input type="hidden" value="{{$website_prices[12]->id}}" name="feature_id[]">
                            <input type="hidden" value="{{$website_prices[13]->id}}" name="feature_id[]">
                            <input type="hidden" value="{{$website_prices[14]->id}}" name="feature_id[]">
                            <td><input step="any" type="number" value="{{$website_prices[10]->price}}" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[11]->price}}" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[12]->price}}" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[13]->price}}" class="feature" name="feature[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[14]->price}}" class="feature" name="feature[]"></td>
                        </tr>
                        <tr id="specification">
                            <td>Prod Specifications Count</td>
                            <input type="hidden" value="{{$website_prices[15]->id}}" name="specification_id[]">
                            <input type="hidden" value="{{$website_prices[16]->id}}" name="specification_id[]">
                            <input type="hidden" value="{{$website_prices[17]->id}}" name="specification_id[]">
                            <input type="hidden" value="{{$website_prices[18]->id}}" name="specification_id[]">
                            <input type="hidden" value="{{$website_prices[19]->id}}" name="specification_id[]">
                            <td><input step="any" type="number" value="{{$website_prices[15]->price}}" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[16]->price}}" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[17]->price}}" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[18]->price}}" class="specification" name="specification[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[19]->price}}" class="specification" name="specification[]"></td>
                        </tr>
                        <tr id="image">
                            <td>Images Count</td>
                            <input type="hidden" value="{{$website_prices[20]->id}}" name="image_id[]">
                            <input type="hidden" value="{{$website_prices[21]->id}}" name="image_id[]">
                            <input type="hidden" value="{{$website_prices[22]->id}}" name="image_id[]">
                            <input type="hidden" value="{{$website_prices[23]->id}}" name="image_id[]">
                            <input type="hidden" value="{{$website_prices[24]->id}}" name="image_id[]">
                            <td><input step="any" type="number" value="{{$website_prices[20]->price}}" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[21]->price}}" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[22]->price}}" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[23]->price}}" class="image" name="image[]"></td>
                            <td><input step="any" type="number" value="{{$website_prices[24]->price}}" class="image" name="image[]"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Form Submit -->
            <div class="row">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    @endif
</div>
<script>
    $(document).ready(function() {
        $("form").on("submit", function (e) {
            var website_id          = $("#website_id").val();
            var titles              = $('.title');
            var descriptions        = $('.description');
            var features            = $('.feature');
            var specifications      = $('.specification');
            var images              = $('.image');
            var title_error         = 0;
            var description_error   = 0;
            var feature_error       = 0;
            var specification_error = 0;
            var image_error         = 0;

            // Remove Error
            $(".errMsg").remove();
            $(".row_error").remove();

            // Title Range Validation
            for(var i = 0; i < titles.length; i++){
                if($(titles[i]).val() == ''){
                    ++title_error;
                }
            }
            
             // Description Range Validation
            for(var i = 0; i < descriptions.length; i++){
                if($(descriptions[i]).val() == ''){
                    ++description_error;
                }
            }
            
            // Feature Range Validation
            for(var i = 0; i < features.length; i++){
                if($(features[i]).val() == ''){
                    ++feature_error;
                }
            }

            // Specification Range Validation
            for(var i = 0; i < specifications.length; i++){
                if($(specifications[i]).val() == ''){
                    ++specification_error;
                }
            }

            // Image Range Validation
            for(var i = 0; i < images.length; i++){
                if($(images[i]).val() == ''){
                    ++image_error;
                }
            }
            
            if(title_error > 0){
                e.preventDefault();
                $("#title").after('<tr class="row_error"><td colspan="6" style="text-align:center;"><span class="errMsg" style="color:red;">Title row contains empty value. </span></td></tr>');
            }
            if(description_error > 0){
                e.preventDefault();
                $("#description").after('<tr class="row_error"><td colspan="6" style="text-align:center;"><span class="errMsg" style="color:red;">Description row contains empty value. </span></td></tr>');
            }
            if(feature_error > 0){
                e.preventDefault();
                $("#feature").after('<tr class="row_error"><td colspan="6" style="text-align:center;"><span class="errMsg" style="color:red;">Feature row contains empty value. </span></td></tr>');
            }
            if(specification_error > 0){
                e.preventDefault();
                $("#specification").after('<tr class="row_error"><td colspan="6" style="text-align:center;"><span class="errMsg" style="color:red;">Specification row contains empty value. </span></td></tr>');
            }
            if(image_error > 0){
                e.preventDefault();
                $("#image").after('<tr class="row_error"><td colspan="6" style="text-align:center;"><span class="errMsg" style="color:red;">Image row contains empty value. </span></td></tr>');
            }
            
        });
    });
</script>
@endsection