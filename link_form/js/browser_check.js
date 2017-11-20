/**
 * Created by IT on 8/17/2016.
 */
function isIE () {
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
}
var ua = window.navigator.userAgent;
//Internet Explorer | if | 9-11
var msg = "You're using Internet Explorer? Some features will not work on Internet Explorer, we recommend using Google Chrome, Mozilla Firefox, Microsoft Edge or Safari.";

if (isIE () == 8) {
    alert(msg);
} else if (isIE () == 9){
    alert(msg);
} else if (isIE () == 10){
    alert(msg);
} else if (ua.indexOf("Trident/7.0") > 0) {
    alert(msg);
}

isIE();