$(document).ready(function() {
    // Desktop
    $(".desktop-table").on("submit", function (e) {
        
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
            
            if($(titles[i]).val() == 0){
                ++title_error;
            }
        }
        
         // Description Range Validation
        for(var i = 0; i < descriptions.length; i++){
            if($(descriptions[i]).val() == 0){
                ++description_error;
            }
        }
        
        // Feature Range Validation
        for(var i = 0; i < features.length; i++){
            if($(features[i]).val() == 0){
                ++feature_error;
            }
        }

        // Specification Range Validation
        for(var i = 0; i < specifications.length; i++){
            if($(specifications[i]).val() == 0){
                ++specification_error;
            }
        }

        // Image Range Validation
        for(var i = 0; i < images.length; i++){
            if($(images[i]).val() == 0){
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
    // Mobile
    $(".mobile-table").on("submit", function (e) {
        var mobile_titles              = $('.mobile_title');
        var mobile_descriptions        = $('.mobile_description');
        var mobile_features            = $('.mobile_feature');
        var mobile_specifications      = $('.mobile_specification');
        var mobile_images              = $('.mobile_image');
        var title_error         = 0;
        var description_error   = 0;
        var feature_error       = 0;
        var specification_error = 0;
        var image_error         = 0;
        
        // Remove Error
        $(".errMsg").remove();
        $(".row_error").remove();
        
        // Title Range Validation
        for(var i = 0; i < mobile_titles.length; i++){
            
            if($(mobile_titles[i]).val() == 0){
                ++title_error;
            }
        }
        
         // Description Range Validation
        for(var i = 0; i < mobile_descriptions.length; i++){
            if($(mobile_descriptions[i]).val() == 0){
                ++description_error;
            }
        }
        
        // Feature Range Validation
        for(var i = 0; i <  mobile_features.length; i++){
            if($(mobile_features[i]).val() == 0){
                ++feature_error;
            }
        }

        // Specification Range Validation
        for(var i = 0; i <  mobile_specifications.length; i++){
            if($(mobile_specifications[i]).val() == 0){
                ++specification_error;
            }
        }

        // Image Range Validation
        for(var i = 0; i < mobile_images.length; i++){
            if($(mobile_images[i]).val() == 0){
                ++image_error;
            }
        }
        
        if(title_error > 0){
            e.preventDefault();
            $("#mobile-title").after('<tr class="row_error"><td colspan="2" style="text-align:center;"><span class="errMsg" style="color:red;">Title row contains empty value. </span></td></tr>');
        }
        if(description_error > 0){
            e.preventDefault();
            $("#mobile-description").after('<tr class="row_error"><td colspan="2" style="text-align:center;"><span class="errMsg" style="color:red;">Description row contains empty value. </span></td></tr>');
        }
        if(feature_error > 0){
            e.preventDefault();
            $("#mobile-feature").after('<tr class="row_error"><td colspan="2" style="text-align:center;"><span class="errMsg" style="color:red;">Feature row contains empty value. </span></td></tr>');
        }
        if(specification_error > 0){
            e.preventDefault();
            $("#mobile-specification").after('<tr class="row_error"><td colspan="2" style="text-align:center;"><span class="errMsg" style="color:red;">Specification row contains empty value. </span></td></tr>');
        }
        if(image_error > 0){
            e.preventDefault();
            $("#mobile-image").after('<tr class="row_error"><td colspan="2" style="text-align:center;"><span class="errMsg" style="color:red;">Image row contains empty value. </span></td></tr>');
        }
        
    });
});