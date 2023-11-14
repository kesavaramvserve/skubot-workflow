<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Merch Metric</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 content">
                <!-- Logo -->
                <div class="text-center">
                    <img src="{{asset('images/MM-logo.png')}}" alt="MM-logo" class="image-responsive mm-logo">
                </div>
                <!-- Heading -->
                <div class="mt-3 text-center">
                    <h3 class="login-heading">SKUs Selection</h3>
                </div>
                <!-- Sub Heading -->
                <div class="mt-3 text-center">
                    <p class="login-sub-heading">Let’s take a look at the SKUs you want to audit!</p>
                </div>
                <!-- SKU -->
                <div class="mt-4 mb-3 text-center">
                    <!-- <p class="login-sub-heading">Please chosen the below number</p> -->
                    <button type="button" class="btn sku-button">
                        <img class="tick-icon" src="{{asset('images/tick.png')}}" alt=""> <span class="sku-count">{{$sku_count}} SKUs</span>
                    </button>
                </div>
                <!-- Form Start -->
                <form action="{{route('sku_selection')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="website_url" class="label">Website URL</label>
                        <input type="url" class="form-control" name="website" id="website_url" value="{{old('website')}}" placeholder="Enter Website URL (E.g: https://www.website.in/)" required>
                        @if($errors->has('website'))
                            <div class="error">{{ $errors->first('website') }}</div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label for="" class="label">Please upload the SKU list here</label>
                        <!-- <input type="text" class="form-control" name="" id="" value=""  required> -->
                        <div class="input-group">
                            <input type="text" class="form-control text-input" placeholder="Upload Here" readonly/>
                            <span class="input-group-btn"><span class="btn btn-file"><span><img src="{{asset('images/upload.png')}}" alt=""></span>
                            <input type="file" name="file" class="form-control" required></span></span>
                            @if($errors->has('file'))
                                <div class="error">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-4">
                        <input type="submit" class="form-control submit-button" name="" id="" value="Submit" required>
                    </div>
                </form>
                <!-- click here -->
                <div class="mb-4 text-center">
                    <p style="color: white;font-size: 12px;">If you do not have the SKU list handy, please <br><a href="{{route('sku_selection_view')}}" style="color: #C8EB7D;text-decoration: none;"> click here.</a></p>
                </div>
                <div class="mb-4 text-center">
                    <a href="https://merchmetric.com/contact/" target="_blank" style="color: white;font-size: 12px;">In case of any assistance, please contact us</a>
                </div>
            </div>
            <div class="col-4">
            </div>
        </div>
    </div>
<script>
    $(".text-input").click(function () {
        $("input[type='file']").trigger('click');
    });
    $('input[type="file"]').on('change', function() {
        var val = $(this).val();
        $(".text-input").val(val);
    });
</script>
</body>
</html>