//2009-05-13 Lawrence Sunglao <locsunglao@yahoo.com>
//  -removed Online Presence Tab
//2009-02-21 Lawrence Sunglao, <locsunglao@yahoo.com>
//  -add the activity tracker notes
//2009-02-02 Lawrence Sunglao, <locsunglao@yahoo.com>
//  -bugfix, subcon timesheet not showing upon selecting previous month
//2008-10-07 Lawrence Sunglao, <locsunglao@yahoo.com>
//  retrieve screenshots relative to client only
//2008-09-12 Lawrence Sunglao, <locsunglao@yahoo.com>
//Show notes on time records
//make Saturdays/Sundays different background color
var SCREENSHOT_PATH = 'screenshots/';
var SCM_PATH = 'scm_tab/';

var URL_JSON_GET_SUBCON_LIST = SCM_PATH + 'getSubconForClient.php';
var URL_JSON_GET_AVAILABLE_DAYS = SCREENSHOT_PATH + 'getAvailableDays.php';
var URL_JSON_GET_IMAGE_LIST = SCREENSHOT_PATH + 'clientGetImageList.php';
var SCREENSHOT_DIR = SCREENSHOT_PATH + 'images/';

var USER_TYPE = 'subcon';

connect(window, "onload", OnLoadScmTab);

function OnLoadScmTab() {
    replaceChildNodes('div_scm_tab', [
        DIV({'class': 'clear'}, null),
        DIV({'id': 'div_select_subcon'}, [
            DIV({},
                SPAN({},
                    'Click ',
                    A({'href': '/portal/client/ScreenShotsViewer/ScreenShotsViewer.html', 'target': '_blank'}, "HERE"),
                    ' to view the new screenshot with thumbnails.'
                )
            ),
            SPAN({}, 'Select Sub-contractor : '),
            SPAN({'id' : 'span_subcontractor_list'}, null),
        ]),
        DIV({'id': 'subcon_status'}, null),
        DIV({'id': 'subcon_tabs'}, [
            DIV({'id': 'tab_time_sheet', 'class':'scm_tab'}, 'Time Sheet'),
            DIV({'id': 'tab_screen_shots', 'class':'scm_tab'}, 'Screen Shots'),
            DIV({'id': 'tab_workflow', 'class':'scm_tab scm_tab_last'}, 'Workflow'),
        ]),
        DIV({'class': 'clear'}, null),
        DIV({'id': 'subcon_main'}, null),
    ]);

    connect('tab_time_sheet', 'onclick', OnClickSCMTab);
    connect('tab_screen_shots', 'onclick', OnClickSCMTab);
    connect('tab_workflow', 'onclick', OnClickSCMTab);

    GetSubContractorList();
}


function OnClickSCMTab(evt) {
    replaceChildNodes('subcon_main', null);
    removeElementClass('tab_time_sheet', 'scm_tab_selected');
    removeElementClass('tab_screen_shots', 'scm_tab_selected');
    removeElementClass('tab_workflow', 'scm_tab_selected');
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
    var d_subcon_status = loadJSONDoc(SCM_PATH + 'subconStatusForClient.php?userid=' + userid);
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
    
    if (hasElementClass('tab_workflow', 'scm_tab_selected')) {
        RenderWorkFlow();
    }
}


function RenderWorkFlow() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }
    replaceChildNodes('subcon_main', createDOM('IFRAME', {'id': 'iframe_work_flow', 'src': 'workflow.php?userid=' + userid}, null));
}


function RenderTimeSheet() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    var OnSuccessGetNotes = function(e) {
        $(div).innerHTML = e.responseText;
    }

    var OnFailGetNotes = function(e) {
        replaceChildNodes(div, 'Failed to fetch notes.');
    }

    var OnClickNotes = function(e) {
        var record_id = getNodeAttribute(e.src(), 'record_id');
        div = 'notes_' + record_id;
        replaceChildNodes(div, 'Loading...');
        toggle(div);

        var blank = getNodeAttribute(e.src(), 'blank');
        var record_id = getNodeAttribute(e.src(), 'record_id');

        var userid = $('subcontractor_list').value;
        var d_div_notes = doSimpleXMLHttpRequest(SCM_PATH + 'clientGetNote.php', {'blank': blank, 'record_id': record_id, 'userid': userid});
        d_div_notes.addCallbacks(OnSuccessGetNotes, OnFailGetNotes);
    }

    var ConnectClickNotes = function() {
        var span_notes = getElementsByTagAndClassName('span', 'span_add_notes');
        for (span_note in span_notes) {
            connect(span_notes[span_note], 'onclick', OnClickNotes);
        }
    }

    var OnSuccessGetTimeSheet = function(e) {
        $('dtr_time_sheet_client').innerHTML = e.responseText;
        ConnectClickNotes();
    }

    var OnFailGetTimeSheet = function(e) {
        alert('Failed to retrieve time sheet data.\NPlease try again later.');
    }

    var GetTimeSheet = function() {
        var userid = $('subcontractor_list').value;
        var d_time_sheet = doSimpleXMLHttpRequest(SCM_PATH + 'timeSheetForClient.php', {'userid':userid, 'date': $('month_list').value});
        d_time_sheet.addCallbacks(OnSuccessGetTimeSheet, OnFailGetTimeSheet);
    }

    var OnSuccessGetTimeSheetWithMonths = function(e) {
        $('subcon_main').innerHTML = e.responseText;
        connect('month_list', 'onchange', GetTimeSheet);
        ConnectClickNotes();
    }

    var OnFailGetTimeSheetWithMonths = function(e) {
        alert("Failed to retrieve time-sheet. Please try again later...");
    }

    replaceChildNodes('subcon_main', DIV({'id':'time_sheet'}, [
        DIV({'id': 'available_months'}, null),
        DIV({'id': 'dtr_time_sheet'}, null),
    ]));

    var d_dtr_time_sheet = doSimpleXMLHttpRequest(SCM_PATH + 'timeSheetForClient.php', {'userid': userid});
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


    var OnSuccessGetActivityNote = function(e) {
        replaceChildNodes('span_activity_note', e['note']);
        replaceChildNodes('div_activity_note_time_requested', "Activity note time requested : " + e['expected_time']);
        replaceChildNodes('div_activity_note_time_responded', "Time to respond : " + e['response_time']);
    }

    var OnFailGetActivityNote = function(e) {
        alert('Failed to retrieve Activity Note!');
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

        replaceChildNodes('div_activity_note_time_requested', "Activity note time requested : ");
        replaceChildNodes('div_activity_note_time_responded', "Time to respond : ");

        var d_activity_note = loadJSONDoc(SCM_PATH + 'getActivityNote.php', {'userid': uid, 'date_time_str' : date_time, 'user_type' : USER_TYPE});
        d_activity_note.addCallbacks(OnSuccessGetActivityNote, OnFailGetActivityNote);
    }


    replaceChildNodes('subcon_main', [
        DIV({}, [
            'Select Day : ',
            SPAN({'id': 'span_day_select'}, null),
        ]),
        DIV({'class': 'clear'}, null),
        DIV({'id':'div_bottom_screenshots'}, [
            DIV({'id' : 'div_image_list'}, ' '),
            DIV({'id' : 'div_screen_shot_img_with_activity'}, [
                DIV({'id': 'div_activity_note'}, [
                    'Activity Note : ',
                    SPAN({'id' : 'span_activity_note'}, ' '),
                ]),
                DIV({'id' : 'div_screen_shot_img'}, ' '),
                DIV({'id' : 'div_activity_note_time_requested'}, 'Activity Note time requested : '),
                DIV({'id' : 'div_activity_note_time_responded'}, 'Time to respond : ')
            ])
        ]),
        DIV({'class': 'clear'}, null),
    ]);

    GetAvailableDays();
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
