//var SECURE_IMAGE = '/rs/securimage/securimage_show.php?sid=';
var SECURE_IMAGE = '/portal/securimage_show.php?sid=';

//var ONLINE_PRESENCE_PATH = "/rs/online_presence/";
var ONLINE_PRESENCE_PATH = "/portal/online_presence/";
var URL_JSON_NEXT_LOGIN_TIME = ONLINE_PRESENCE_PATH + "nextLoginTime.php";
var URL_SUBMIT_CODE = ONLINE_PRESENCE_PATH + "submitCode.php";

var RELOGIN_POLL_INTERVAL = 60000; 
//var RELOGIN_POLL_INTERVAL = 10000; 

var time_asia_manila = '';
var time_australia_sydney = ''; 

var flag_form_relogin_visible = false;
var seconds_idle = 0;
var idle_timer;
var flag_idle_timer = false;
var next_relogin_timeout;  //timeout variable to be used on the exact time to relogin
connect(window, "onload", OnLoadApplicantHome);

function OnLoadApplicantHome(e) {
    replaceChildNodes("divConfirmPresence", [
        DIV({'id':'clocks'}, [
            DIV({'id':'asia_manila_tz', 'class':'dtr_col_time_ph'}, [
                'Asia/Manila Time : ',
                SPAN({'id': 'asia_manila_clock'}, null),
            ]),
            DIV({'id':'au_sydney_tz', 'class':'dtr_col_time_au'}, [
                'Australia/Sydney Time : ',
                SPAN({'id': 'australia_sydney_clock'}, null),
            ]),
        ]),
        DIV({'class': 'clear'}, null),
        DIV({'id':'statusNextLogin'}, 'Timer Status...'),
        DIV({'id':'formRelogin', 'class':'invisible'}, null)
    ]);
    GetReloginStatus();
    poll_relogin = setTimeout("PollReloginTime()", RELOGIN_POLL_INTERVAL);
    clock_timer = setTimeout("UpdateClock()", 1000);
}


function UpdateClock() {
    clock_timer = setTimeout("UpdateClock()", 1000); 
    date_time_asia_manila = isoTimestamp(time_asia_manila);
    date_time_australia_sydney = isoTimestamp(time_australia_sydney);
    replaceChildNodes('asia_manila_clock', FormatDateTimeToStr(date_time_asia_manila));
    replaceChildNodes('australia_sydney_clock', FormatDateTimeToStr(date_time_australia_sydney));

    date_time_asia_manila.setTime(date_time_asia_manila.getTime() + 1000);
    date_time_australia_sydney.setTime(date_time_australia_sydney.getTime() + 1000);
    time_asia_manila = toISOTimestamp(date_time_asia_manila);
    time_australia_sydney = toISOTimestamp(date_time_australia_sydney);
}


//returns desired string format
function FormatDateTimeToStr(DateTimeObj) {
    var hours = DateTimeObj.getHours();
    var minutes = numberFormatter('00:')(DateTimeObj.getMinutes());
    var seconds = numberFormatter('00 ')(DateTimeObj.getSeconds());
    if (hours >= 12) {
        am_pm = 'pm';
        if (hours == 12) {
            hours = numberFormatter('00:')(hours);
        }
        else {
            hours = numberFormatter('00:')(hours - 12);
        }
    }
    else {
        am_pm = 'am';
        hours = numberFormatter('00:')(hours);
    }

    return hours  + minutes  + seconds + am_pm;
}


function StartIdleTimer() {
    flag_idle_timer = true;
    idle_timer = setTimeout("StartIdleTimer()", 1000);
    UpdateDivIdleTime();
    seconds_idle += 1;
}

function StopIdleTimer() {
    clearTimeout(idle_timer);
    flag_idle_timer = false;
    seconds_idle = 0;
}

function UpdateDivIdleTime() {
    //TODO work on hours/minutes/seconds display
    var idle_message = '';
    var total_time = seconds_idle;

    //get total hour
    var hours = Math.floor(seconds_idle / 3600);
    if (hours != 0) {
        if (hours < 10) {
            idle_message += '0';
        }
        idle_message += hours + ':';
        total_time = total_time - (hours * 3600);
    }
    else {
        idle_message += '00:';
    }

    //get total minutes
    var mins = Math.floor(total_time / 60);
    if (mins != 0) {
        if (mins < 10) {
            idle_message += '0';
        }
        idle_message += mins + ':';
        total_time = total_time - (mins * 60);
    }
    else {
        idle_message += '00:';
    }

    var secs = total_time;
    if (secs < 10) {
        idle_message += '0';
    }
    idle_message += secs;

    replaceChildNodes('div_idle_time',  idle_message + ' idle');
}

function ShowReloginForm() {
    if (flag_form_relogin_visible) {
        return;
    }
    replaceChildNodes('formRelogin', DIV(null, [
        DIV({}, [
            DIV({'style':'width:175px; float:left; text-align:right; padding-right: 4px;'}, 'Type the code shown'),
            INPUT({'name':'code', 'id': 'input_captcha_code', 'style':'width:175px;'}, null),
        ]),
        DIV({}, [
            DIV({'style':'width:175px; float:left; text-align:right; padding-right: 4px;'}, A({'href': '#', 'id':'reload_captcha', 'style': 'width: 175px;'}, 'Try a different image')),
            IMG({'src':SECURE_IMAGE + Math.random(), 'id':'captcha_img', 'style': 'float:left;'}, null), 
        ]),
        DIV({'class':'clear'}, null),
        DIV({'style':'text-align:center; width: 350px;', 'id': 'div_idle_time'}, "idle"),
        DIV({'style':'text-align:center; width: 350px;'}, [
            BUTTON({'id':'submit_code', 'style': 'width: 175px;'}, 'Submit')
        ])
    ]));
    appear('formRelogin');
    flag_form_relogin_visible = true;
    connect('reload_captcha', 'onclick', ReloadCaptchaImg);
    connect('submit_code', 'onclick', OnClickSubmitCode);
}

function OnClickSubmitCode(e) {
    var code = $('input_captcha_code').value;
    query = queryString({'code' : code, 'user_type':USER_TYPE});
    var deferred_submit_code = doXHR(URL_SUBMIT_CODE, {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    deferred_submit_code.addCallbacks(OnSuccessSubmitCode, OnFailSubmitCode);
}

function OnSuccessSubmitCode(e) {
    replaceChildNodes('statusNextLogin', e.responseText);
    Sequence([
        pulsate('statusNextLogin', {sync: true}),
        appear('statusNextLogin', {sync: true})
    ]);
    if (e.responseText == "Presence confirmed.") {
        HideReloginForm();
        StopIdleTimer();
        var x = setTimeout("GetReloginStatus()", 3000);
    }
}

function OnFailSubmitCode(e) {
    log('failed to submit code');
    log(e);
}

function HideReloginForm() {
    if (flag_form_relogin_visible == false) {
        return;
    }
    fade('formRelogin');
    flag_form_relogin_visible = false;
}

function ReloadCaptchaImg(e) {
    setNodeAttribute('captcha_img', 'src', SECURE_IMAGE + Math.random());
}

function PollReloginTime() {
    poll_relogin = setTimeout("PollReloginTime()", RELOGIN_POLL_INTERVAL);
    GetReloginStatus();
}

function GetReloginStatus() {
    var d = loadJSONDoc(URL_JSON_NEXT_LOGIN_TIME, {'user_type':USER_TYPE});
    d.addCallbacks(OnSuccessGetLoginTime, OnFailGetLoginTime);
}

function OnSuccessGetLoginTime(e) {
    replaceChildNodes('statusNextLogin', e.status_msg);
    var background_color = e.background_color;
    setStyle('statusNextLogin', {'background-color': e.background_color, 'color': e.color});
    time_asia_manila = e['time_asia_manila'];
    time_australia_sydney = e['time_australia_sydney'];
    if (e.status_msg == 'Please confirm your presence.') {
        ShowReloginForm();
        seconds_idle = e.seconds_idle;
        if (!flag_idle_timer) {
            StartIdleTimer();
        }
        clearTimeout(next_relogin_timeout);
    }
    else {
        HideReloginForm();
        StopIdleTimer();
        clearTimeout(next_relogin_timeout);
        next_relogin_timeout = setTimeout("GetReloginStatus()", e.seconds_to_relogin * 1000);
    }
}

function OnFailGetLoginTime(e) {
    replaceChildNodes('statusNextLogin', "retrying...");
}
