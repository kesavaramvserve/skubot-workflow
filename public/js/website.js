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
        $("#assign_tl").show();
        var website_id = $(this).attr('data-id');
        var website_tl_id = $(this).attr('data-tl-id');
        $("#assign_tl_website_id").val(website_id);
        $('select[name^="tl"] option[value="'+website_tl_id+'"]').attr("selected","selected");
    });

});