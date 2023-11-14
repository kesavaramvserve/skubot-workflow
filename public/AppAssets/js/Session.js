
function LoadSession() {
    if (document.readyState === 'complete') {
        $('#Session').load("/Base/GetSessionTime");
        if (showCounter != undefined)
            clearInterval(showCounter);
        document.removeEventListener('keydown', function (event) { }, false);
    }
}

var showCounter; var showSession;
if (showSession != undefined)
    clearInterval(showSession);
//$('#ModelYes1').click(function () { LoadSession(); });
//$('#ModelYes1').click(function () { window.location.href = "/Account/Login"; });
showSession = setInterval(function () {
    if ($('#HDNSession').length > 0) {
        if (counter == undefined || counter == '0' || counter == 0)
            counter = $('#HDNSession').val();
        counter -= 10000;

        $('#HDNSession').val(counter);


        if (counter == 0) {
            window.location.href = "/Home/Login";

        }


    }
}, 10000);

$(document).ready(function () {
    $("#div_Loading").hide();
});
$(document).ajaxStart(function () {
    $("#div_Loading").show();
});
$(document).ajaxComplete(function (event, xhr, settings) {
    if (settings.url != "/Base/GetSessionTime") {
        $("#div_Loading").hide();
        LoadSession();
    }
});