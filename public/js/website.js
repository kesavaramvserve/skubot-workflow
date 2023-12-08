$(document).ready(function() {
    // Scraper Close Button
    $(document).on("click",".close",function() {
        $("#myModal").hide();
    });

    // Support Close Button
    $(document).on("click",".close",function() {
        $("#myModal2").hide();
    });

    // Support Close Button
    $(document).on("click",".close",function() {
        $("#myModal3").hide();
    });

    // Data History Close Button
    $(document).on("click",".history-close",function() {
        $("#myModal4").hide();
    });

    // Validate Close Button
    $(document).on("click",".close5",function() {
        $("#myModal5").hide();
        $("#validate_form")[0].reset();
    });

    // assign_tl_close Close Button
    $(document).on("click",".assign_tl_close",function() {
        $("#assign_tl").hide();
        $(".error").empty();
        $("#assign_tl_form")[0].reset();
    });

    // project settings _close Close Button
    $(document).on("click",".project_settings_close",function() {
        $("#project_settings").hide();
        $(".error").empty();
        $("#project_settings_form")[0].reset();
    });

    // Add More Close Button
    $(document).on("click",".close6",function() {
        $(".error").empty();
        $("#myModal6").hide();
        $("#add_more_form")[0].reset();
    });

    // Scraper Upload
    $(document).on("click",".upload",function() {
        $("#myModal").show();
        var website_id = $(this).attr('data-id');
        $("#website_id").val(website_id);
    });

    // Support Import scrapped Data
    $(document).on("click",".import",function() {
        $("#myModal2").show();
        var website_id = $(this).attr('data-id');
        $("#website_id2").val(website_id);
    });

    // Support Import enhanced Data
    $(document).on("click",".enhance-import",function() {
        $("#myModal3").show();
        var website_id = $(this).attr('data-id');
        $("#website_id3").val(website_id);
    });

    // Data History
    $(document).on("click",".data-history",function() {
        $("#myModal4").show();
        var website_id = $(this).attr('data-id');
        $.ajax({
            type: 'GET',
            url: 'data_history',
            data: {id:website_id},
            dataType: 'json',
            success: function (data) {
                $('#history-data').empty();
                console.log(data)
                $(data).each(function(index, value) {
                    var date = new Date(value.updated_at);
                    // var dateFormat = date.toDateString() + ", "+ date.getHours() + ":" + date.getMinutes();
                    var dateFormat = date.getDate()+
                                    "/"+(date.getMonth()+1)+
                                    "/"+date.getFullYear()+
                                    " "+date.getHours()+
                                    ":"+date.getMinutes()+
                                    ":"+date.getSeconds();
                    $('#history-data').append('<tr><td class="data1">' + value.action + '</td><td class="data2">' + dateFormat + '</td>');
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    // Validate Website Modal Show and data fetch
    $(document).on("click",".validate",function() {
        $("#myModal5").show();
        var website_id = $(this).attr('data-id');
        var validation_status = $(this).attr('data-vs');
        var remark = $(this).attr('data-remark');
        $("#validate_website_id").val(website_id);
        $('select[name^="validation_status"] option[value="'+validation_status+'"]').attr("selected","selected");
        $("#remark").text(remark);
    });

    // Add more Website Modal Show and data fetch
    $(document).on("click",".add_more",function() {
        $("#myModal6").show();
        var website_id = $(this).attr('data-id');
        $("#add_more_website_id").val(website_id);
    });
    
    // Scraper Form Submit
    $("#scraper_data").on("submit", function (e) {
        var data = $("#fileinput").val();
        if(data.length < 1){
            e.preventDefault();
            $("#fileinput").after('<span style="color:red;">This field is required </span>');
        }
    });

    // Support Form Submit(Scrapped Data)
    $("#support_import").on("submit", function (e) {
        var data = $("#fileinput2").val();
        if(data.length < 1){
            e.preventDefault();
            $("#fileinput2").after('<span style="color:red;">This field is required </span>');
        }
    });

    // Support Form Submit(Enhanced Data)
    $("#support_enhance").on("submit", function (e) {
        var data = $("#fileinput3").val();
        $(".error").empty();
        // alert(data);
        if(data.length < 1){
            e.preventDefault();
            $("#fileinput3").after('<span class="error">This field is required </span>');
        }
    });

    // Website Validate Form Submit
    $("#validate_form").on("submit", function (e) {
        var validation_status   = $("#validation_status").val();
        var remark              = $("#remark").val();
        $(".error").empty();
        if(validation_status.length < 1){
            e.preventDefault();
            $("#validation_status").after('<span class="error">This field is required </span>');
        }
        // if(remark.length < 1){
        //     e.preventDefault();
        //     $("#remark").after('<span class="error">This field is required </span>');
        // }
    });

    // Project Settings Validation
    $("#project_settings").on("submit", function (e) {
        var platform            = $("#platform").val();
        var workflow_settings   = $("#workflow_settings").val();
        var project_status      = $("#project_status").val();
        var download_image      = $("input[name=download_image]").is(":checked");
        var download_asset      = $("input[name=download_asset]").is(":checked");
        var time_track          = $("input[name=time_track]").is(":checked");
        
        $(".error").empty();
        if(platform.length < 1){
            e.preventDefault();
            $("#platform").after('<span class="error">This field is required </span>');
        }
        if(workflow_settings.length < 1){
            e.preventDefault();
            $("#workflow_settings").after('<span class="error">This field is required </span>');
        }
        if(project_status.length < 1){
            e.preventDefault();
            $("#project_status").after('<span class="error">This field is required </span>');
        }
        if(!download_image){
            e.preventDefault();
            $("#download_image").after('<span class="error">This field is required </span>');
        }
        if(!download_asset){
            e.preventDefault();
            $("#download_asset").after('<span class="error">This field is required </span>');
        }
        if(!time_track){
            e.preventDefault();
            $("#time_track").after('<span class="error">This field is required </span>');
        }
    });


    // Add More Website Form Submit
    $("#add_more_form").on("submit", function (e) {
        var website     = $("#website").val();
        var url_pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
        $(".error").empty();
        if(website.length < 1){
            e.preventDefault();
            $("#website").after('<span class="error">This field is required </span>');
        }else if(!url_pattern.test(website)){
            e.preventDefault();
            $("#website").after('<span class="error">Invalid Website address</span>');
        }
    });

    // Assign TL
    $(document).on("click",".assign_tl",function() {
        
        var website_id = $(this).attr('data-id');
        // $.ajax({
        //     url: '/get_tl_list', // Replace with your Laravel endpoint URL
        //     method: 'GET',
        //     data: {
        //         // Data to be sent in the request body (if needed)
        //         key1: website_id,
        //     },
        //     success: function(response){
        //         // Handle the successful response from the server
        //         console.log(response);
        //         let selectedOptions = response; // Array of values to be selected

        //         selectedOptions.forEach(value => {
        //             console.log(value);
        //             $('select[id^="tl"] option[value="'+value+'"]').prop('selected', true);
        //         });
        //     },
        //     error: function(xhr, status, error){
        //         // Handle errors
        //         console.error(error);
        //     }
        // });
        $("#assign_tl").show();
        var website_tl_id = $(this).attr('data-tl-id');
        $("#assign_tl_website_id").val(website_id);
        $('select[name^="tl"] option[value="'+website_tl_id+'"]').attr("selected","selected");
    });

    // Project Settings
    $(document).on("click",".project_settings",function() {
        $("#project_settings").show();
        var website_id = $(this).attr('data-id');
        

        
        var platform = $(this).attr('data-platform');
        var platform_details = $(this).attr('data-platform-details');
        var workflow_settings = $(this).attr('data-workflow-settings');
        var project_status = $(this).attr('data-project-status');
        var reason = $(this).attr('data-reason');
        var download_image = $(this).attr('data-download-image');
        var download_asset = $(this).attr('data-download-asset');
        var time_track = $(this).attr('data-time-track');
        var project_name = $(this).attr('data-project-name');

        $("#project_settings_website_id").val(website_id);
        $("#project_name").val(project_name);
        $('select[name^="platform"] option[value="'+platform+'"]').attr("selected","selected");
        $('select[name^="workflow_settings"] option[value="'+workflow_settings+'"]').attr("selected","selected");
        $('select[name^="project_status"] option[value="'+project_status+'"]').attr("selected","selected");
        if(platform_details){
            $("#platform_details_div").append('<div class="mb-3"><label for="platform_details"><strong>Platform Details</strong></label><input type="text" class="form-control" name="platform_details" value="'+platform_details+'" id="platform_details" required></div>');
        }
        if(reason){
            $("#reason_div").append('<div class="mb-3"><label for="reason"><strong>Reason</strong></label><select name="reason" id="reason" class="form-control" required><option value="">select Reason</option><option value="completed">Completed</option><option value="closed">Closed</option><option value="canceled">Canceled</option></select></div>');
            $('select[name^="reason"] option[value="'+reason+'"]').attr("selected","selected");
        }

        $('input[name=download_image][value="'+download_image+'"]').prop('checked', true);
        $('input[name=download_asset][value="'+download_asset+'"]').prop('checked', true);
        $('input[name=time_track][value="'+time_track+'"]').prop('checked', true);
    });

    // Platform on change
    $(document).on("change","#platform",function() {
        var platform = $(this).val();
        if(platform == 'other'){
            $("#platform_details_div").append('<div class="mb-3"><label for="platform_details"><strong>Platform Details</strong></label><input type="text" class="form-control" name="platform_details" id="platform_details" required></div>');
        }else{
            $("#platform_details_div").empty();
        }
    });

    // Project Status on change
    $(document).on("change","#project_status",function() {
        var project_status = $(this).val();
        if(project_status == 0){
            $("#reason_div").append('<div class="mb-3"><label for="reason"><strong>Reason</strong></label><select name="reason" id="reason" class="form-control" required><option value="">select Reason</option><option value="completed">Completed</option><option value="closed">Closed</option><option value="canceled">Canceled</option></select></div>');
        }else{
            $("#reason_div").empty();
        }
    });

});