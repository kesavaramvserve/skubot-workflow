<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
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
                <!-- GIF -->
                <div class="mt-3 text-center" style="height: 300px;">
                    <img src="{{asset('images/thanks.gif')}}" alt="" class="image-fluid" width="100%">
                </div>
                <!-- Content -->
                <div class="text-center">
                    <p class="login-sub-heading">Your payment for the MerchMetric audit has been successful!</p>
                    <p class="login-sub-heading">Click below to continue to select the products you want to analyze.</p>
                </div>
                
                <div class="mb-3 mt-5">
                    <a href="{{route('sku_upload_view')}}" style="text-decoration: none;text-align: center;" class="form-control submit-button">Continue To SKU Selection</a>
                </div>
                
            </div>
            <div class="col-4">
            </div>
        </div>
    </div>
</body>
</html>