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
                    <h3 class="login-heading">Create your Account</h3>
                </div>
                <!-- Sub Heading -->
                <div class="mt-3 text-center">
                    <p class="login-sub-heading">Take your first step to better product content here</p>
                </div>
                <!-- Form Start -->
                <form action="{{route('clients.store')}}" method="post" id="client_register">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="first_name" class="label">Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{old('first_name')}}" placeholder="Enter First Name" required>
                            @if($errors->has('first_name'))
                                <div class="error">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                        <!-- Work Email -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="email" class="label">Work Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" placeholder="Enter Work Email" required>
                            @if($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <!-- Create Password -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="password" class="label">Create Password</label>
                            <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}" placeholder="*****************" required>
                            @if($errors->has('password'))
                                <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <!-- Confirm Password -->
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="c_password" class="label">Confirm Password</label>
                            <input type="password" class="form-control" name="c_password" id="c_password" value="{{old('c_password')}}" placeholder="*****************" required>
                            @if($errors->has('c_password'))
                                <div class="error">{{ $errors->first('c_password') }}</div>
                            @endif
                        </div>
                        <!-- Company Name -->
                        <div class="col-md-12 col-xs-12 mb-3">
                            <label for="company_name" class="label">Company Name</label>
                            <input type="text" class="form-control" name="company_name" id="company_name" value="{{old('company_name')}}" placeholder="Enter Company Name" required>
                            @if($errors->has('company_name'))
                                <div class="error">{{ $errors->first('company_name') }}</div>
                            @endif
                        </div>
                        <!-- Pricing Plans -->
                        <div class="col-md-12 col-xs-12 mb-3">
                            <label for="plan" class="label">Confirm the Pricing Plan</label>
                            <select name="plan" id="plan" class="form-control select-input" required>
                                <option value="{{old('plan')}}">Please Select the Plan</option>
                                <option value="$49" {{$plan=='500_skus' ? 'selected' : ''}}>500 SKUS   $49</option>
                                <option value="$249" {{$plan=='5000_skus' ? 'selected' : ''}}>5000 SKUS   $249</option>
                                <option value="$699" {{$plan=='5000-20k_skus' ? 'selected' : ''}}>5000 - 20K SKUS   $699</option>
                                <option value="Custom Pricing" {{$plan=='custom_pricing' ? 'selected' : ''}}>20K SKUS   Custom Pricing</option>
                            </select>
                            @if($errors->has('plan'))
                                <div class="error">{{ $errors->first('plan') }}</div>
                            @endif
                        </div>
                        <!-- Agree Checkbox -->
                        <div class="col-md-12 col-xs-12 mb-3">
                            <span class="float-start login-sub-heading"><input class="" id="agree" type="checkbox" required><span style="margin-left: 5px;cursor:pointer;text-decoration:underline;" id="tc">By submitting this form, you agree to our Terms of Service.</span></span>
                        </div>
                        <!-- submit-button -->
                        <div class="col-3">
                        </div>
                        <div class="col-md-6 col-xs-12 mb-3">
                            <input type="submit" class="form-control submit-button" name="" id="" value="Continue to Payment" required>
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                </form>
                <!-- Login -->
                <div class="mb-3 text-center">
                    <p style="color: white;font-size: 12px;">Already have an Account? <a href="{{route('login')}}" style="color: #C8EB7D;text-decoration: none;"> Login</a></p>
                </div>
            </div>
            <div class="col-3">
            </div>
        </div>
    </div>
<!-- T&C Modal -->
<div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="row">
                <div class="col-12 mb-3">
                    <span style="color:#c8eb7d;"><strong>Terms and Conditions</strong></span>
                    <span class="close float-end">&times;</span>
                </div>
                <div class="col-12">
                    <p style="text-align: justify;color:white;">
                        These Terms & Conditions ("Agreement") govern the use of your website ("Website") by MerchMetric ("We," "Us," or "Our") for the purpose of scraping and analyzing content. By allowing us to access and scrape your Website, you ("You" or "Your") agree to be bound by these terms. Please read these terms carefully before providing consent.
                        <br>
                        <b style="color:#c8eb7d;">Grant of Access:</b>
                        <br>
                        By providing consent, You grant Us permission to access and scrape the content on Your Website for the purpose of content analysis. This includes but is not limited to text, images, data, and any other content accessible on Your Website.
                        <br>
                        <b style="color:#c8eb7d;">Purpose of Content Analysis:</b>
                        <br>
                        We will analyze the scraped content from Your Website to derive insights, conduct research, or develop products/services related to content analysis. The results of this analysis may be used for internal purposes, research publications, or commercial applications, while ensuring that any personal information is anonymized and aggregated.
                        <br>
                        <b style="color:#c8eb7d;">Intellectual Property Rights:</b>
                        <br>
                        You represent and warrant that You either own the intellectual property rights to the content on Your Website or have obtained the necessary permissions to allow Us to scrape and analyze such content. We acknowledge that all intellectual property rights to the content scraped from Your Website remain with You or the respective owners.
                        <br>
                        <b style="color:#c8eb7d;">Limitations on Liability:</b>
                        <br>
                        a. We will take reasonable measures to ensure the accuracy and security of the scraped content. However, We cannot guarantee the complete accuracy, reliability, or security of the data obtained from Your Website.
                        <br>
                        b. We are not responsible for any loss, damage, or liability arising from the use or reliance upon the scraped content or any actions taken based on the analysis performed.
                        <br>
                        c. We shall not be liable for any direct, indirect, incidental, consequential, or special damages arising out of or in connection with the scraping and analysis of Your Website's content.
                        <br>
                        <b style="color:#c8eb7d;">Indemnification:</b>
                        <br>
                        You agree to indemnify, defend, and hold Us harmless from any claims, demands, liabilities, costs, or expenses arising out of or relating to Your Website, including any third-party claims resulting from our scraping and analysis of the content on Your Website.
                        <br>
                        <b style="color:#c8eb7d;">Privacy:</b>
                        <br>
                        a. We respect Your privacy and will handle any personal information obtained from Your Website in accordance with applicable privacy laws and Our Privacy Policy.
                        <br>
                        b. We will not share Your personal information or any personally identifiable data obtained from Your Website with third parties without Your consent, except as required by law.
                        <br>
                        <b style="color:#c8eb7d;">Termination:</b>
                        <br>
                        Either party may terminate this Agreement at any time by providing written notice. Upon termination, We will cease scraping and analyzing the content on Your Website, and any previously scraped data will be deleted unless required to be retained by law.
                        <br>
                        <b style="color:#c8eb7d;">Modification of Terms:</b>
                        <br>
                        We reserve the right to modify these Terms & Conditions at any time, and such modifications will be effective upon posting on Our website or providing notice to You. It is Your responsibility to review these terms periodically to stay informed of any changes.
                    </p>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $("#client_register").on("submit", function (e) {
            var first_name          = $("#first_name").val();
            var last_name           = $("#last_name").val();
            var email               = $("#email").val();
            var company_name        = $("#company_name").val();
            var password            = $("#password").val();
            var c_password          = $("#c_password").val();
            // var website             = $("#website").val();
            var agree               = $("#agree").prop('checked');
            var first_name_pattern  = /^[a-zA-Z]+$/;
            var email_pattern       = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
            var url_pattern         = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
            var err_value           = 500;

            $(".error").empty();

            if(first_name.length < 1){
                $("#first_name").after('<span class="error">First Name field is required</span>');
                err_value = err_value + 20;
            }else if(first_name.length < 3){
                $("#first_name").after('<span class="error">The first name field must be at least 3 characters.</span>');
            }else if(!first_name_pattern.test(first_name)){
                $("#first_name").after('<span class="error">The first name field must not be alphabet characters.</span>');
                err_value = err_value + 20;
            }

            if(!first_name_pattern.test(last_name) && last_name.length > 1){
                $("#last_name").after('<span class="error">The Last name field must not be alphabet characters.</span>');
                err_value = err_value + 20;
            }

            if(email.length < 1){
                $("#email").after('<span class="error">Email field is required</span>');
                err_value = err_value + 20;
            }else if(!email_pattern.test(email)){
                $("#email").after('<span class="error">Invalid Email address</span>');
                err_value = err_value + 20;
            }

            if(company_name.length < 1){
                $("#company_name").after('<span class="error">Company Name field is required</span>');
                err_value = err_value + 20;
            }

            if(password.length < 1){
                $("#password").after('<span class="error">Password field is required</span>');
                err_value = err_value + 20;
            }else if(password.length < 8){
                $("#password").after('<span class="error">Password Should be Minimum of 8 Character</span>');
                err_value = err_value + 20;
            }

            if(c_password.length < 1){
                $("#c_password").after('<span class="error">Confirm Password field is required</span>');
                err_value = err_value + 20;
            }else if(c_password != password){
                $("#c_password").after('<span class="error">Confirm Password do not match</span>');
                err_value = err_value + 20;
            }

            // if(website.length < 1){
            //     $("#website").after('<span class="error">Website field is required</span>');
            //     err_value = err_value + 20;
            // }else if(!url_pattern.test(website)){
            //     $("#website").after('<span class="error">Invalid Website address</span>');
            //     err_value = err_value + 20;
            // }

            if(!agree){
                $("#agree_div").after('<span class="error">Please agree to the Terms and Conditions</span>');
                err_value = err_value + 20;
            }

            if(err_value > 500){
                e.preventDefault();
                $(".content").css("height", err_value+"px");
                $(".title").css("padding", "0 30px 0 30px");
            }
            
        });
    });

    // Open Modal
    $(document).on("click","#tc",function() {
        $("#myModal").show();
    });

    // Close Modal
    $(document).on("click",".close",function() {
        $("#myModal").hide();
    });
</script>
</body>
</html>