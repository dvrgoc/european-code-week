jQuery(document).ready(function(){
    startTime();
});

function startTime() {
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    var hours = today.getHours();
    var minutes = today.getMinutes();
    var seconds = today.getSeconds();
    hours = checkTime(hours);
    minutes = checkTime(minutes);
    seconds = checkTime(seconds);
    jQuery('#now').text(day + ". " + month + ". " + year + ". " + hours + ":" + minutes + ":" + seconds);
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    };  // add zero in front of numbers < 10
    return i;
}