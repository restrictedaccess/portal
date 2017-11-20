var SCREENSHOT_PATH = 'screenshots/';
var SCM_PATH = 'scm_tab/';

var URL_JSON_GET_SUBCON_LIST = SCM_PATH + 'getAllSubcon.php';
var URL_JSON_GET_AVAILABLE_DAYS = SCREENSHOT_PATH + 'getAvailableDays.php';
var URL_JSON_GET_IMAGE_LIST = SCREENSHOT_PATH + 'getImageList.php';
var SCREENSHOT_DIR = SCREENSHOT_PATH + 'images/';

var USER_TYPE = 'subcon';

connect(window, "onload", OnLoadScmTab);

function OnLoadScmTab() {
    replaceChildNodes('div_scm_tab', [
        DIV({'id': 'div_select_subcon'}, [
            SPAN({}, 'Select Sub-contractor : '),
            SPAN({'id' : 'span_subcontractor_list'}, null),
        ]),
        DIV({'id': 'subcon_status'}, null),
        DIV({'id': 'subcon_tabs'}, [
            DIV({'id': 'tab_time_sheet', 'class':'scm_tab'}, 'Time Sheet'),
            DIV({'id': 'tab_screen_shots', 'class':'scm_tab'}, 'Screen Shots'),
            DIV({'id': 'tab_internet_connection_status', 'class':'scm_tab'}, 'Internet Connection Status'),
            DIV({'id': 'tab_online_presence', 'class':'scm_tab scm_tab_last'}, 'Online Presence'),
        ]),
        DIV({'class': 'clear'}, null),
        DIV({'id': 'subcon_main'}, null),
    ]);

    connect('tab_time_sheet', 'onclick', OnClickSCMTab);
    connect('tab_screen_shots', 'onclick', OnClickSCMTab);
    connect('tab_internet_connection_status', 'onclick', OnClickSCMTab);
    connect('tab_online_presence', 'onclick', OnClickSCMTab);

    GetSubContractorList();
}


function OnClickSCMTab(evt) {
    replaceChildNodes('subcon_main', null);
    removeElementClass('tab_time_sheet', 'scm_tab_selected');
    removeElementClass('tab_screen_shots', 'scm_tab_selected');
    removeElementClass('tab_internet_connection_status', 'scm_tab_selected');
    removeElementClass('tab_online_presence', 'scm_tab_selected');
    addElementClass(evt.src(), 'scm_tab_selected');
    GetSubconStatus();
    RenderSubconMain();
}


function GetSubContractorList() {
    var d_subcon_list = loadJSONDoc(URL_JSON_GET_SUBCON_LIST);
    d_subcon_list.addCallbacks(OnSuccessGetSubConList, OnFailGetSubConList);
}


function OnSuccessGetSubConList(e){
    option_list = [OPTION({'value': ''}, 'Please select sub-contractor...')];
    for (i = 0; i < e.length; i++) {
        option_list.push(OPTION({'value':e[i].userid}, e[i].fname + ' ' + e[i].lname));
    }
    replaceChildNodes('span_subcontractor_list', SELECT({'id':'subcontractor_list'}, option_list));
    connect('subcontractor_list', 'onchange', OnChangeSubcon);
}


function OnFailGetSubConList(e){
    alert('Failed to get Subcontractors.\nPlease try again later.');
}


function OnChangeSubcon(e) {
    GetSubconStatus();
    RenderSubconMain();
}


function GetSubconStatus() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    replaceChildNodes('subcon_status', null);
    var d_subcon_status = loadJSONDoc(SCM_PATH + 'subconStatus.php?userid=' + userid);
    d_subcon_status.addCallbacks(OnSuccessGetSubconStatus, OnFailGetSubconStatus);
}


function OnSuccessGetSubconStatus(e) {
    replaceChildNodes('subcon_status', 'Sub-contractor status : ' + e['status']);
    Highlight('subcon_status');
}


function OnFailGetSubconStatus(e) {
    alert('Failed to retrieve the status of the subcontractor.\n Please try again later');
}


function RenderSubconMain() {
    if (hasElementClass('tab_time_sheet', 'scm_tab_selected')) {
        RenderTimeSheet();
    }
    
    if (hasElementClass('tab_screen_shots', 'scm_tab_selected')) {
        RenderScreenShots();
    }
    
    if (hasElementClass('tab_internet_connection_status', 'scm_tab_selected')) {
        RenderInternetConnectionStatus();
    }
    
    if (hasElementClass('tab_online_presence', 'scm_tab_selected')) {
        RenderOnlinePresence();
    }

}


function RenderOnlinePresence() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    var OnSuccessGetOnlinePresence = function(e) {
        var online_presence_data = e['online_presence_data'];
        ProcessOnlinePresenceData(online_presence_data);
    }

    var GetOnlinePresenceData = function(e) {
        var d_online_presence = loadJSONDoc(SCM_PATH + 'onlinePresence.php', {'userid':userid, 'date': $('month_list').value});
        d_online_presence.addCallbacks(OnSuccessGetOnlinePresence, OnFailGetOnlinePresence);
    }

    var ProcessAvailableMonths = function(month_list) {
        var options = [];
        for (var i = 0; i < month_list.length; i++) {
            var desc = month_list[i]['desc'];
            var date_d = month_list[i]['date'];
            options.push(OPTION({'value': date_d}, desc));
        }
        replaceChildNodes('available_months', [
            'Select Month : ',
            SELECT({'id':'month_list'}, options),
        ]);
        connect('month_list', 'onchange', GetOnlinePresenceData);
    }

    var ProcessOnlinePresenceData = function(online_presence_data) {
        var div_online_presence = [];
        div_online_presence.push(DIV({'class':'time_sheet_headers'}, [
            DIV({'class':'dtr_col_day_of_week'}, 'Day of Week'),
            DIV({'class':'dtr_col_time'}, 'Expected'),
            DIV({'class':'dtr_col_time'}, 'Confirmed'),
            DIV({'class':'dtr_col_time border_right'}, [
                DIV({'class':'hdr_2line'}, 'Time to'),
                DIV({'class':'hdr_2line'}, 'Respond')
            ]),
            DIV({'class':'clear'}, null)
        ]));

        var row_color = '';
        for (var i = 0; i < online_presence_data.length; i++) {
            var day_online_presence = online_presence_data[i];
            var online_presence_list = day_online_presence['online_presence'];
            var day_of = day_online_presence['date'];
            for (var j = 0; j < online_presence_list.length; j++) {
                if (j == 0) {
                    var day_of_wk = DIV({'class':'dtr_col_day_of_week'}, day_of);
                }
                else {
                    var day_of_wk = DIV({'class':'dtr_col_day_of_week'}, null);
                }

                var expected_time_ph = online_presence_list[j]['expected_time_ph'];
                var expected_time_au = online_presence_list[j]['expected_time_au'];
                var checked_in_time_ph = online_presence_list[j]['checked_in_time_ph'];
                var checked_in_time_au = online_presence_list[j]['checked_in_time_au'];
                var time_to_respond = FormatSeconds(online_presence_list[j]['seconds_difference']);

                rows = [day_of_wk,
                    DIV({'class':'dtr_col_time'}, [
                        DIV({'class':'dtr_col_time_ph'}, expected_time_ph),
                        DIV({'class':'dtr_col_time_au'}, expected_time_au)
                    ]),
                    DIV({'class':'dtr_col_time'}, [
                        DIV({'class':'dtr_col_time_ph'}, checked_in_time_ph),
                        DIV({'class':'dtr_col_time_au'}, checked_in_time_au)
                    ]),
                    DIV({'class':'dtr_col_time border_right'}, time_to_respond),
                    DIV({'class':'clear'}, null)
                ];

                if (row_color == 'bg_color_row_1') {
                    row_color = 'bg_color_row_2';
                }
                else {
                    row_color = 'bg_color_row_1';
                }
                var div_row = DIV({'class':'dtr_rows ' + row_color}, rows);
                div_online_presence.push(div_row);
            }
        }
        replaceChildNodes('dtr_time_sheet', div_online_presence);
    }

    var OnSuccessGetOnlinePresenceWithDate = function(e) {
        var available_months = e['months'];
        ProcessAvailableMonths(available_months);

        var online_presence_data = e['online_presence_data'];
        ProcessOnlinePresenceData(online_presence_data);
    }

    var OnFailGetOnlinePresence = function(e) {
        alert('Failed to get the online presence of the subcontractor.\n Please try again later.');
    }

    replaceChildNodes('subcon_main', DIV({'id':'time_sheet'}, [
        DIV({'id': 'available_months'}, null),
        DIV({'id': 'dtr_time_sheet'}, null),
    ]));

    var d_online_presence_with_date = loadJSONDoc(SCM_PATH + 'onlinePresence.php', {'userid': userid});
    d_online_presence_with_date.addCallbacks(OnSuccessGetOnlinePresenceWithDate, OnFailGetOnlinePresence);
}


function RenderTimeSheet() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    var OnSuccessGetTimeSheet = function(e) {
        var time_sheet_data = e['time_sheet'];
        ProcessTimeSheet(time_sheet_data);
    }

    var OnFailGetTimeSheet = function(e) {
        alert('Failed to retrieve time sheet data.\NPlease try again later.');
    }

    var GetTimeSheet = function() {
        var userid = $('subcontractor_list').value;
        var d_time_sheet = loadJSONDoc(SCM_PATH + 'timeSheet.php', {'userid':userid, 'date': $('month_list').value});
        d_time_sheet.addCallbacks(OnSuccessGetTimeSheet, OnFailGetTimeSheet);
    }

    var ProcessAvailableMonths = function(month_list) {
        var options = [];
        for (var i = 0; i < month_list.length; i++) {
            var desc = month_list[i]['desc'];
            var date_d = month_list[i]['date'];
            options.push(OPTION({'value': date_d}, desc));
        }
        replaceChildNodes('available_months', [
            'Select Month : ',
            SELECT({'id':'month_list'}, options),
        ]);
        connect('month_list', 'onchange', GetTimeSheet);
    }

    var ProcessTimeSheet = function(time_sheet_data) {
        var div_time_sheets = [];
        div_time_sheets.push(DIV({'class':'time_sheet_headers'}, [
            DIV({'class':'dtr_col_day_of_week'}, 'Day of Week'),
            DIV({'class':'dtr_col_time'}, 'Time In'),
            DIV({'class':'dtr_col_time'}, 'Time Out'),
            DIV({'class':'dtr_col_client'}, 'Client'),
            DIV({'class':'dtr_col_spacer'}, null),
            DIV({'class':'dtr_col_total_hours_header'}, 'Total Hrs'),
            DIV({'class':'dtr_col_total_hours_header'}, 'Lunch Hrs'),
            DIV({'class':'dtr_col_time'}, 'Start Lunch'),
            DIV({'class':'dtr_col_time'}, 'Fin Lunch'),
            DIV({'class':'dtr_col_regular_hours_header'}, 'Regular Hrs'),
            DIV({'class':'clear'}, null)
        ])); //headers
        var day_of_week = '';
        div_time_sheets.push(DIV({'class': 'clear'}, null));
        var row_color = '';
        for (var i = 0; i < time_sheet_data.length; i++) {
            var day_of = time_sheet_data[i]['day_of'];
            var time_in_ph = time_sheet_data[i]['time_in_ph'];
            var time_out_ph = time_sheet_data[i]['time_out_ph'];
            var time_in_au = time_sheet_data[i]['time_in_au'];
            var time_out_au = time_sheet_data[i]['time_out_au'];
            var client = time_sheet_data[i]['client'];
            var total_hours = time_sheet_data[i]['total_hours'];
            var total_lunch_hours = time_sheet_data[i]['total_lunch_hours'];
            var start_lunch_ph = time_sheet_data[i]['start_lunch_ph'];
            var start_lunch_au = time_sheet_data[i]['start_lunch_au'];
            var finish_lunch_ph = time_sheet_data[i]['finish_lunch_ph'];
            var finish_lunch_au = time_sheet_data[i]['finish_lunch_au'];
            var working_hours = time_sheet_data[i]['working_hours'];
            var rows = [
                DIV({'class':'dtr_col_day_of_week'}, day_of),
                DIV({'class':'dtr_col_time'}, [
                    DIV({'class':'dtr_col_time_ph'}, time_in_ph),
                    DIV({'class':'dtr_col_time_au'}, time_in_au)
                ]),
                DIV({'class':'dtr_col_time'}, [
                    DIV({'class':'dtr_col_time_ph'}, time_out_ph),
                    DIV({'class':'dtr_col_time_au'}, time_out_au)
                ]),
                DIV({'class':'dtr_col_client', 'title': client}, client),
                DIV({'class':'dtr_col_spacer'}, null),
                DIV({'class':'dtr_col_total_hours'}, roundToFixed(total_hours,2)),
                DIV({'class':'dtr_col_total_hours'}, roundToFixed(total_lunch_hours,2)),
                DIV({'class':'dtr_col_time'}, [
                    DIV({'class':'dtr_col_time_ph'}, start_lunch_ph),
                    DIV({'class':'dtr_col_time_au'}, start_lunch_au)
                ]),
                DIV({'class':'dtr_col_time'}, [
                    DIV({'class':'dtr_col_time_ph'}, finish_lunch_ph),
                    DIV({'class':'dtr_col_time_au'}, finish_lunch_au)
                ]),
                DIV({'class':'dtr_col_regular_hours'}, roundToFixed(working_hours,2)),
                DIV({'class':'clear'}, null)
            ];

            if (row_color == 'bg_color_row_1') {
                row_color = 'bg_color_row_2';
            }
            else {
                row_color = 'bg_color_row_1';
            }
            var div_row = DIV({'class':'dtr_rows ' + row_color}, rows);
            div_time_sheets.push(div_row);
            div_time_sheets.push(DIV({'class': 'clear'}, null));
        }
        replaceChildNodes('dtr_time_sheet', div_time_sheets);
    }

    var OnSuccessGetTimeSheetWithMonths = function(e) {
        var available_months = e['months'];
        ProcessAvailableMonths(available_months);
        var time_sheet_data = e['time_sheet'];
        ProcessTimeSheet(time_sheet_data);
    }

    var OnFailGetTimeSheetWithMonths = function(e) {
        alert("Failed to retrieve time-sheet. Please try again later...");
    }

    replaceChildNodes('subcon_main', DIV({'id':'time_sheet'}, [
        DIV({'id': 'available_months'}, null),
        DIV({'id': 'dtr_time_sheet'}, null),
    ]));

    var d_dtr_time_sheet = loadJSONDoc(SCM_PATH + 'timeSheet.php?userid=' + userid);
    d_dtr_time_sheet.addCallbacks(OnSuccessGetTimeSheetWithMonths, OnFailGetTimeSheetWithMonths);
}


function RenderScreenShots() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    var GetAvailableDays = function() {
        var d_available_days = loadJSONDoc(URL_JSON_GET_AVAILABLE_DAYS);
        d_available_days.addCallbacks(OnSuccessGetAvailableDays, OnFailGetAvailableDays);
    }

    var OnSuccessGetAvailableDays = function(e) {
        option_list = [];
        for (i = 0; i < e.length; i++) {
            option_list.push(OPTION({'value':e[i][1]}, e[i][0]));
        }
        replaceChildNodes('span_day_select', SELECT({'id':'day_list'}, option_list));
        connect('day_list', 'onchange', GetImageList);
        GetImageList(e);
    }

    var OnFailGetAvailableDays = function(e) {
        alert('Failed to get days.\nPlease try again later.');
    }


    var GetImageList = function(e) {
        replaceChildNodes('div_image_list', null);
        replaceChildNodes('div_screen_shot_img', null);
        date_param = $('day_list').value;
        var d_image_list = loadJSONDoc(URL_JSON_GET_IMAGE_LIST, {'userid': userid, 'user_type': USER_TYPE, 'date_param': date_param});
        d_image_list.addCallbacks(OnSuccessGetImageList, OnFailGetImageList);
    }

    var OnSuccessGetImageList = function(e) {
        if (e.stat == 'OK') {
            var image_list = e['image_list'];
            var opt_group_list = [];
            for (var i = 0; i < image_list.length; i++) {
                var images = [];
                var json_images_list = image_list[i]['images'];
                for (var j = 0; j < json_images_list.length; j++) {
                    var label = json_images_list[j].substr(11,5);
                    images.push(OPTION({'value':json_images_list[j]}, label));
                }
                opt_group_list.push(OPTGROUP({'label': image_list[i]['time_span']}, images));
            }
            replaceChildNodes('div_image_list', SELECT({'id':'image_list', 'size':24}, opt_group_list));
            appear('div_image_list');
            connect('image_list', 'onchange', FetchImage);
        }
    }

    var OnFailGetImageList = function(e) {
        alert('Failed to get image list.\n Please try again later.');
    }


    var FetchImage = function(e) {
        var date_time = $('image_list').value;
        var date_str = date_time.substring(0, 10);
        var time_str = date_time.substring(11);
        var time_str = time_str.replace(/:/g, '-');
        var uid = $('subcontractor_list').value;
        img_src = SCREENSHOT_DIR + USER_TYPE + '/' + date_str + '/' + uid + '/' + time_str + '.jpg';
        img = IMG({'src': img_src, 'width': 640}, null);
        replaceChildNodes('div_screen_shot_img', img);
    }


    replaceChildNodes('subcon_main', [
        DIV({}, [
            'Select Day : ',
            SPAN({'id': 'span_day_select'}, null),
        ]),
        DIV({'class': 'clear'}, null),
        DIV({'id':'div_bottom_screenshots'}, [
            DIV({'id' : 'div_image_list'}, ' '),
            DIV({'id' : 'div_screen_shot_img'}, ' ')
        ]),
        DIV({'class': 'clear'}, null),
    ]);

    GetAvailableDays();
}


function RenderInternetConnectionStatus() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    var OnSuccessGetInternetConnStat = function(e) {
        var internet_connection_data = e['internet_connection_data'];
        ProcessInternetConnectionData(internet_connection_data);
    }

    var GetInternetConnectionData = function(e) {
        var userid = $('subcontractor_list').value;
        if (userid == '') {
            return;
        }
        var d_internet_conn = loadJSONDoc(SCM_PATH + 'internetConnectionStatus.php', {'userid': userid, 'date': $('month_list').value});
        d_internet_conn.addCallbacks(OnSuccessGetInternetConnStat, OnFailGetInternetConnStatWithDate);
    }

    var ProcessAvailableMonths = function(month_list) {
        var options = [];
        for (var i = 0; i < month_list.length; i++) {
            var desc = month_list[i]['desc'];
            var date_d = month_list[i]['date'];
            options.push(OPTION({'value': date_d}, desc));
        }
        replaceChildNodes('available_months', [
            'Select Month : ',
            SELECT({'id':'month_list'}, options),
        ]);
       connect('month_list', 'onchange', GetInternetConnectionData);
    }

    var ProcessInternetConnectionData = function(internet_connection_data) {
        var div_internet_conn_stat = [];
        div_internet_conn_stat.push(DIV({'class':'time_sheet_headers'}, [
            DIV({'class':'dtr_col_day_of_week'}, 'Day of Week'),
            DIV({'class':'dtr_col_time'}, [
                DIV({'class': 'hdr_2line'}, 'Last'), 
                DIV({'class': 'hdr_2line'}, 'Connected')
            ]),
            DIV({'class':'dtr_col_time col_time_idle'}, [
                DIV({'class': 'hdr_2line'}, 'No'), 
                DIV({'class': 'hdr_2line'}, 'Connection')
            ]),
            DIV({'class':'clear'}, null)
        ]));

        var day_of_week = '';
        div_internet_conn_stat.push(DIV({'class': 'clear'}, null));
        var row_color = '';
        for (var i = 0; i < internet_connection_data.length; i++) {    //loop around days
            var idle_time_list = internet_connection_data[i]['idle_time_list'];
            var day_of = internet_connection_data[i]['date'];
            for (var j = 0; j < idle_time_list.length; j++) {   //loop around idle_time_list
                var last_post_time_ph = idle_time_list[j]['last_post_time_ph'];
                var last_post_time_au = idle_time_list[j]['last_post_time_au'];
                var seconds_idle = idle_time_list[j]['seconds_idle'];
                var seconds_str = FormatSeconds(seconds_idle);
                if (j == 0) {
                    var day_of_wk = DIV({'class':'dtr_col_day_of_week'}, day_of);
                }
                else {
                    var day_of_wk = DIV({'class':'dtr_col_day_of_week'}, null);
                }
                rows = [day_of_wk,
                    DIV({'class':'dtr_col_time'}, [
                        DIV({'class':'dtr_col_time_ph'}, last_post_time_ph),
                        DIV({'class':'dtr_col_time_au'}, last_post_time_au)
                    ]),
                    DIV({'class':'dtr_col_time col_time_idle' }, seconds_str),
                    DIV({'class':'clear'}, null)
                ];

                if (row_color == 'bg_color_row_1') {
                    row_color = 'bg_color_row_2';
                }
                else {
                    row_color = 'bg_color_row_1';
                }

                var div_row = DIV({'class':'dtr_rows ' + row_color}, rows);
                div_internet_conn_stat.push(div_row);
            }
        }

        replaceChildNodes('dtr_time_sheet', div_internet_conn_stat);
    }

    var OnSuccessGetInternetConnStatWithDate = function(e) {
        var available_months = e['months'];
        ProcessAvailableMonths(available_months);

        var internet_connection_data = e['internet_connection_data'];
        ProcessInternetConnectionData(internet_connection_data);

    }

    var OnFailGetInternetConnStatWithDate = function(e) {
        alert('Failed to get Internet Connection Status data...');
    }


    replaceChildNodes('subcon_main', DIV({'id':'time_sheet'}, [
        DIV({'id': 'available_months'}, null),
        DIV({'id': 'dtr_time_sheet'}, null),
    ]));


    var d_internet_conn_stat = loadJSONDoc(SCM_PATH + 'internetConnectionStatus.php', {'userid': userid});
    d_internet_conn_stat.addCallbacks(OnSuccessGetInternetConnStatWithDate, OnFailGetInternetConnStatWithDate);
}


function FormatSeconds(seconds) {
    return_string = '';
    //get total hour
    var hours = Math.floor(seconds / 3600);
    if (hours != 0) {
        if (hours < 10) {
            return_string += '0';
        }
        return_string += hours + ':';
        seconds = seconds - (hours * 3600);
    }
    else {
        return_string += '00:';
    }

    //get total minutes
    var mins = Math.floor(seconds / 60);
    if (mins != 0) {
        if (mins < 10) {
            return_string += '0';
        }
        return_string += mins + ':';
        seconds = seconds - (mins * 60);
    }
    else {
        return_string += '00:';
    }

    var secs = seconds;
    if (secs < 10) {
        return_string += '0';
    }
    return_string += secs;

    return return_string;
}
