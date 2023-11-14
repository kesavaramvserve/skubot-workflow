<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Merch Metric</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 content">
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
                    <p class="login-sub-heading">If you do not have your SKU list handy , don’t worry. We can help out.</p>
                </div>
                <!-- Form Start -->
                <form action="{{route('sku_selection')}}" method="post" enctype="multipart/form-data" id="sku_selection_form">
                    @csrf
                    <div class="row">
                        <!-- Website URL -->
                        <div class="col-12 mb-3">
                            <label for="website_url" class="label">Website URL</label>
                            <input type="url" class="form-control" name="website" id="website_url" value="{{old('website')}}" placeholder="Enter Website URL (E.g: https://www.website.in/)" required>
                            @error('website')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Audit -->
                        <div class="col-12 mb-3">
                            <label for="" class="label">How do you want us to audit the SKUs?</label>
                        </div>
                        <div class="col-12 mb-3">
                            <span class="float-start login-sub-heading"><input class="audit" type="radio" value="website" name="audit"><span style="margin-left: 5px;">Pick the SKUs directly from my website</span></span>
                        </div>
                        <div class="col-12 mb-3">
                            <span class="float-start login-sub-heading"><input class="audit" type="radio" value="category" name="audit"><span style="margin-left: 5px;">Pick the SKUs from a particular category from my website</span></span>
                        </div>
                        <div id="audit-error" class="col-12">
                                
                        </div>
                        <!-- Category -->
                        <div class="col-12" id="category-field">
                            
                        </div>
                        <!--Comments -->
                        <div class="col-12 mb-3">
                            <label for="comments" class="label">Comments</label>
                            <textarea name="comments" id="comments" value="" cols="" rows="3" class="form-control" placeholder="Enter Comment"></textarea>
                        </div>
                        <!-- submit-button -->
                        <div class="col-3">
                        </div>
                        <div class="col-6 mb-3">
                            <input type="submit" class="form-control submit-button" name="" id="" value="submit">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                </form>
                <!-- click here -->
                <div class="mb-1 text-center">
                    <p style="color: white;font-size: 12px;"><a href="{{route('sku_upload_view')}}" style="color: #C8EB7D;text-decoration: none;"> click here</a> to go back to the previous page.</p>
                </div>
                <div class="mb-4 text-center">
                    <a href="https://merchmetric.com/contact/" target="_blank" style="color: white;font-size: 12px;">In case of any assistance, please contact us</a>
                </div>
            </div>
            <div class="col-3">
            </div>
            
        </div>
    </div>
    <script>
        $(document).on("change",".audit",function() {
            var radioValue = $("input[name='audit']:checked").val();
            if(radioValue == 'category'){
                $("#category-field").empty();
                $("#category-field").append('<label for="" class="label">Category</label><input type="text" class="form-control" name="category" id="category" value="" placeholder="Enter Category" required>');
            }else{ 
                $("#category-field").empty();
            }
        });
        $("#sku_selection_form").on("submit", function (e) {
            var website_url         = $("#website_url").val();
            var audit               = $("#audit").val();

            $(".error").empty();

            if(website_url.length < 1){
                e.preventDefault();
                $("#website_url").after('<span class="error">Website URL field is required</span>');
            }
            if(!$("input[name='audit']:checked").val()){
                e.preventDefault();
                $("#audit-error").append('<span class="error">Audit field is required</span>');
            }
            
        });
    </script>
</body>
</html>