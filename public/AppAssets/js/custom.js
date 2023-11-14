
function ShowToast(status, msg) {
    var className = '';
    //Success
    if (status == "Success") {
        className = 'bg-success'
    }
    else if (status == "Info") {
        className = 'bg-info'
    }
    else if (status == "Warrning") {
        className = 'bg-warning'
    }
    else if (status == "Error") {
        className = 'bg-danger'
    }
    $(document).Toasts('create', {
        class: className,
        title: status,
        subtitle: '',
        body: msg,
        autohide: true,
        delay: 1500
    });

}

function ToJavaScriptDate(value) {
    let monthNames = ["Jan", "Feb", "Mar", "Apr",
        "May", "Jun", "Jul", "Aug",
        "Sep", "Oct", "Nov", "Dec"];
    var pattern = /Date\(([^)]+)\)/;
    var results = pattern.exec(value);
    var dt = new Date(parseFloat(results[1]));
    return dt.getDate() + "-" + monthNames[(dt.getMonth())] + "-" + dt.getFullYear();
}
