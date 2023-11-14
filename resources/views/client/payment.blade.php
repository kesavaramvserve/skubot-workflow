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
    <style>
        .line{
            width: 38%;color: white;
        }
        .line-text{
            width: 24%;padding: 0%;text-align: center;font-size: 13px;color: white;margin-top: 1%;
        }
    </style>
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
                    <h3 class="login-heading">Choose Your Plan</h3>
                </div>
                <!-- Payment Details -->
                <div class="mt-3 text-center">
                    <div class="row">
                        <div class="line">
                            <hr>
                        </div>
                        <div class="line-text">
                            <p>Payment Details</p>
                        </div>
                        <div class="line">
                            <hr>
                        </div>
                    </div>
                </div>
                <!-- Form Start -->
                <form 
                    role="form" 
                    action="{{ route('payment') }}" 
                    method="post" 
                    class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="pk_test_bVB6a9Joaic63yNZP6RJ4zxF007oifYKYk"
                    id="payment-form">
                    @csrf
                    <div class="row">
                        <!-- Cardholder Name -->
                        <div class="col-md-12 col-xs-12 mb-3">
                            <label for="card_holder_name" class="label">Cardholder Name</label>
                            <input type="text" class="form-control" name="card_holder_name" id="card_holder_name" size='4' value="{{old('card_holder_name')}}" placeholder="Enter Cardholder Name" pattern="[A-Za-z]+" title="Please enter alphabetic characters only" required>
                        </div>
                        <!-- Card Number -->
                        <div class="col-md-12 col-xs-12 mb-3">
                            <label for="card_no" class="label">Card Number</label>
                            <div class="input-group">
                                <input type="number" class="form-control card-number" style="border-right: none;" name="card_no" id="card_no" size='20' value="{{old('card_no')}}" placeholder="Enter Card Number" required>
                                <span class="input-group-text" style="background-color: white !important;">
                                    <img src="{{asset('images/cards.png')}}" width="92px" alt="">
                                </span>
                            </div>
                        </div>
                        <!-- Expire Month -->
                        <div class="col-md-3 col-xs-12 mb-3">
                            <label for="expiry_month" class="label">Expire Month</label>
                            <select name="expiry_month" id="expiry_month" class="form-control card-expiry-month select-input" required>
                                <option value="">Select Month</option>
                                @for($i=1;$i<=12;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- Expire Year -->
                        <div class="col-md-3 col-xs-12 mb-3">
                            <label for="expiry_year" class="label">Expire Year</label>
                            <select name="expiry_year" id="expiry_year" class="form-control card-expiry-year select-input" required>
                                <option value="">Select Year</option>
                                @for($i=2023;$i<=2050;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- Security Code -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="security_code" class="label">Security Code</label>
                            <input type="password" class="form-control card-cvc" name="security_code" id="security_code" value="{{old('security_code')}}" placeholder="Enter Security Code" required>
                        </div>
                        <!-- Billing Address -->
                        <div class="col-md-12 col-xs-12 mb-3">
                            <div class="row">
                                <div class="line">
                                    <hr>
                                </div>
                                <div class="line-text">
                                    <p>Billing Address</p>
                                </div>
                                <div class="line">
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <!-- Full Name -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="name" class="label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Enter Full Name" required>
                        </div>
                        <!-- Address -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="address" class="label">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{old('address')}}" placeholder="Enter Address" required>
                        </div>
                        <!-- City -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="city" class="label">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="{{old('city')}}" placeholder="Enter City" pattern="[A-Za-z]+" title="Please enter alphabetic characters only" required>
                        </div>
                        <!-- Country -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="country" class="label">Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="{{old('country')}}" placeholder="Enter Country" pattern="[A-Za-z]+" title="Please enter alphabetic characters only" required>
                        </div>
                        <!-- State -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="state" class="label">State</label>
                            <input type="text" class="form-control" name="state" id="state" value="{{old('state')}}" placeholder="Enter State" pattern="[A-Za-z]+" title="Please enter alphabetic characters only" required>
                        </div>
                        <!-- ZIP Code -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="zip_code" class="label">ZIP Code</label>
                            <input type="number" class="form-control" name="zip_code" id="zip_code" value="{{old('zip_code')}}" placeholder="Enter ZIP Code" required>
                        </div>
                        <!-- Order Details -->
                        <div class="col-md-12 col-xs-12">
                            <div class="row">
                                <div class="line">
                                    <hr>
                                </div>
                                <div class="line-text">
                                    <p>Order Details</p>
                                </div>
                                <div class="line">
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <!-- Purchase Summary Content -->
                        <div class="col-md-12 col-xs-12 mb-2">
                            <div>
                                <span class="login-sub-heading float-start">Purchase Summary</span>
                            </div>
                            <div>
                                <span class="login-sub-heading float-end">Amount</span>
                            </div>
                        </div>
                        <!-- Purchase Summary Content -->
                        <div class="col-md-12 col-xs-12 mb-2">
                            <div>
                                <span class="login-sub-heading float-start">MerchMetric Report for {{$sku_count}} SKUs</span>
                            </div>
                            <div>
                                <span class="float-end" style="font-size: 15px;color: #C8EB7D;">{{$plan}} </span>
                            </div>
                        </div>
                        <!-- Last Hr Line -->
                        <div class="col-md-12 col-xs-12 mb-3" style="color: white;">
                            <hr style="margin: 0%;">
                        </div>
                        <!-- Total -->
                        <div class="col-6 mb-3">
                            <p style="color: white;font-size: 13px;" class="float-start">Total</p>
                        </div>
                        <div class="col-6 mb-3">
                            <p style="color: white;font-size: 13px;" class="float-end">{{$plan}}</p>
                        </div>
                        <!-- Error MSG -->
                        <div class='col-md-12 error form-group hide'>
                            <div class='alert-danger alert'></div>
                        </div>
                        <!-- submit-button -->
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6 col-xs-12 mb-5">
                            <input type="submit" class="form-control submit-button" name="" id="" value="submit">
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3">
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
<script type="text/javascript">
  
$(function() {
  
    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/
    $(".hide").hide();
    
    var $form = $(".require-validation");
     
    $('form.require-validation').bind('submit', function(e) {
        var card_holder_name   = $("#card_holder_name").val();
        var card_no            = $("#card_no").val();
        var expiry_month       = $("#expiry_month").val();
        var expiry_year        = $("#expiry_year").val();
        var security_code      = $("#security_code").val();
        var name               = $("#name").val();
        var address            = $("#address").val();
        var city               = $("#city").val();
        var country            = $("#country").val();
        var state              = $("#state").val();
        var zip_code           = $("#zip_code").val();
        var first_name_pattern = /^[a-zA-Z]+$/;

        // card_holder_name
        if(card_holder_name.length < 1){
            e.preventDefault();
            $("#card_holder_name").after('<div class="error">This field is required</div>');
        }
        // card_no
        if(card_no.length < 1){
            e.preventDefault();
            $("#card_no").after('<div class="error">This field is required</div>');
        }
        // expiry_month
        if(expiry_month.length < 1){
            e.preventDefault();
            $("#expiry_month").after('<div class="error">This field is required</div>');
        }
        // expiry_year
        if(expiry_year.length < 1){
            e.preventDefault();
            $("#expiry_year").after('<div class="error">This field is required</div>');
        }
        // security_code
        if(security_code.length < 1){
            e.preventDefault();
            $("#security_code").after('<div class="error">This field is required</div>');
        }
        // name
        if(name.length < 1){
            e.preventDefault();
            $("#name").after('<div class="error">This field is required</div>');
        }else if(!first_name_pattern.test(name) && name.length > 1){
            $("#name").after('<span class="error">Name field must be an alphabet characters only.</span>');
            err_value = err_value + 20;
        }
        // address
        if(address.length < 1){
            e.preventDefault();
            $("#address").after('<div class="error">This field is required</div>');
        }
        // city
        if(city.length < 1){
            e.preventDefault();
            $("#city").after('<div class="error">This field is required</div>');
        }else if(!first_name_pattern.test(city) && city.length > 1){
            $("#city").after('<span class="error">city field must be an alphabet characters only.</span>');
            err_value = err_value + 20;
        }
        // country
        if(country.length < 1){
            e.preventDefault();
            $("#country").after('<div class="error">This field is required</div>');
        }else if(!first_name_pattern.test(country) && country.length > 1){
            $("#country").after('<span class="error">Country field must be an alphabet characters only.</span>');
            err_value = err_value + 20;
        }
        // state
        if(state.length < 1){
            e.preventDefault();
            $("#state").after('<div class="error">This field is required</div>');
        }else if(!first_name_pattern.test(state) && state.length > 1){
            $("#state").after('<span class="error">state field must be an alphabet characters only.</span>');
            err_value = err_value + 20;
        }
        // zip_code
        if(zip_code.length < 1){
            e.preventDefault();
            $("#zip_code").after('<div class="error">This field is required</div>');
        }

        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
    
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
     
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
    
    });
      
    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $(".hide").show();
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
                 
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
</script>
</body>
</html>