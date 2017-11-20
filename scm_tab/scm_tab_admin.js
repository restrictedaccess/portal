//2011-06-30    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  add button for first month time sheet
//2009-11-03 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  added total number of screenshots
//2009-05-14 Lawrence Sunglao <locsunglao@yahoo.com>
//  remove Internet Connection Status and Online Presence tab
var SCREENSHOT_PATH = 'screenshots/';
var SCM_PATH = 'scm_tab/';

var URL_JSON_GET_SUBCON_LIST = SCM_PATH + 'getSubconForAdmin.php';
var URL_JSON_GET_AVAILABLE_DAYS = SCREENSHOT_PATH + 'getAvailableDays.php';
var URL_JSON_GET_IMAGE_LIST = SCREENSHOT_PATH + 'getImageList.php';
var SCREENSHOT_DIR = SCREENSHOT_PATH + 'images/';

var USER_TYPE = 'subcon';

connect(window, "onload", OnLoadScmTab);

function OnLoadScmTab() {
    replaceChildNodes('div_scm_tab', [
        DIV({'class': 'clear'}, null),
        DIV({'id': 'div_add_notes', 'class': 'invisible'}, [
            DIV({'id':'div_title_add_notes'}, 'Add Notes'),
            DIV(null, TEXTAREA({'rows': '4', 'id': 'input_add_notes'}, null)),
            INPUT({'type':'hidden', 'id': 'add_notes_blank'}, null),
            INPUT({'type':'hidden', 'id': 'add_notes_record_id'}, null),
            INPUT({'type':'hidden', 'id': 'add_notes_date'}, null),
            INPUT({'type':'checkbox', 'id': 'add_notes_broadcast', 'name': 'add_notes_broadcast'}, null),
            LABEL({'for': 'add_notes_broadcast'}, 'Send this note to everybody.'),
            DIV(null, [
                BUTTON({'id': 'button_save_notes'}, 'Save'),
                ' ',
                BUTTON({'id': 'button_cancel_notes'}, 'Cancel')
            ])
        ]),
        DIV(null, [
            BUTTON({'id': 'btn_create_time_sheet'}, 'Create Time Sheets'),
            BUTTON({'id': 'btn_lock_unlock_time_sheet'}, 'Lock/Unlock Time Sheets'),
            BUTTON({'id': 'btn_update_time_sheet'}, 'Update Time Sheets'),
            BUTTON({'id': 'btn_first_month_timesheet'}, 'First Month Time Sheets'),
        ]),
        DIV({'id': 'div_select_subcon'}, [
            SPAN({}, 'Select Sub-contractor : '),
            SPAN({'id' : 'span_subcontractor_list'}, null),
        ]),
        DIV({'id': 'subcon_status'}, null),
        DIV({'id': 'subcon_tabs'}, [
            DIV({'id': 'tab_time_sheet', 'class':'scm_tab'}, 'Time Sheet'),
            DIV({'id': 'tab_screen_shots', 'class':'scm_tab scm_tab_last'}, 'Screen Shots'),
        ]),
        DIV({'class': 'clear'}, null),
        DIV({'id': 'subcon_main'}, null),
    ]);

    connect('tab_time_sheet', 'onclick', OnClickSCMTab);
    connect('tab_screen_shots', 'onclick', OnClickSCMTab);
    connect('btn_create_time_sheet', 'onclick', OnClickCreateTimeSheet);
    connect('btn_lock_unlock_time_sheet', 'onclick', OnClickLockUnlockTimeSheet);
    connect('btn_update_time_sheet', 'onclick', OnClickUpdateTimeSheet);
    connect('btn_first_month_timesheet', 'onclick', OnClickFirstMonthTimeSheet);

    GetSubContractorList();
}


function OnClickFirstMonthTimeSheet(evt) {
    window.open('/portal/AdminFirstMonthInvoice/AdminFirstMonthInvoice.html', 'AdminFirstMonthInvoice');
}


function OnClickUpdateTimeSheet(evt) {
    window.open('/portal/scm_tab/UpdateTimeSheet/UpdateTimeSheet.html', 'UpdateTimeSheet');
}


function OnClickLockUnlockTimeSheet(evt) {
    window.open('/portal/scm_tab/LockUnlockTimeSheet/LockUnlockTimeSheet.html', 'LockUnlockTimeSheet');
}


function OnClickCreateTimeSheet(evt) {
    window.open('/portal/scm_tab/CreateTimeSheet/CreateTimeSheet.html', 'CreateTimeSheet');
}


function OnClickSCMTab(evt) {
    replaceChildNodes('subcon_main', null);
    removeElementClass('tab_time_sheet', 'scm_tab_selected');
    removeElementClass('tab_screen_shots', 'scm_tab_selected');
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
    var d_subcon_status = loadJSONDoc(SCM_PATH + 'subconStatusForAdmin.php', {'userid': userid});
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
    
}



function RenderTimeSheet() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    var OnSuccessGetTimeSheet = function(e) {
        $('dtr_time_sheet').innerHTML = e.responseText;
        ConnectAddButtons();
    }

    var OnFailGetTimeSheet = function(e) {
        alert('Failed to retrieve time sheet data.\nPlease try again later.');
    }

    var GetTimeSheet = function() {
        var userid = $('subcontractor_list').value;
        var d_time_sheet = doSimpleXMLHttpRequest(SCM_PATH + 'timeSheetForAdmin.php', {'userid':userid, 'date': $('month_list').value});
        d_time_sheet.addCallbacks(OnSuccessGetTimeSheet, OnFailGetTimeSheet);
    }

    var OnClickAddButton = function(e) {
        var pos = getElementPosition(e.src());
        hideElement('div_add_notes');
        appear('div_add_notes');
        setElementPosition('div_add_notes', pos);
        var add_notes = getNodeAttribute(e.src(), 'day_of');
        replaceChildNodes('div_title_add_notes', 'Add notes for: ' + add_notes);
        $('button_cancel_notes').disabled = false;
        $('button_save_notes').disabled = false;
        $('input_add_notes').disabled = false;
        $('input_add_notes').value = '';
        $('add_notes_broadcast').checked = false;

        var add_notes_blank = getNodeAttribute(e.src(), 'blank');
        var add_notes_record_id = getNodeAttribute(e.src(), 'record_id');
        var add_notes_date = getNodeAttribute(e.src(), 'date');
        setNodeAttribute('add_notes_blank', 'value', add_notes_blank);
        setNodeAttribute('add_notes_record_id', 'value', add_notes_record_id);
        setNodeAttribute('add_notes_date', 'value', add_notes_date);
    }

    var OnClickButtonCancelNotes = function(e) {
        hideElement('div_add_notes');
    }

    var OnSuccessSaveNotes = function(e) {
        replaceChildNodes('span_add_notes_'+record_id, e.responseText);
        hideElement('div_add_notes');
        hideElement('notes_'+record_id);
    }


    var OnFailSendNotes = function(e) {
        hideElement('div_add_notes');
        alert("Failed to save note!");
    }

    var OnClickButtonSaveNotes = function(e) {
        var note = strip($('input_add_notes').value);
        if (note == '') {
            alert('Please enter a note!');
            return;
        }
        $('button_cancel_notes').disabled = true;
        $('button_save_notes').disabled = true;
        $('input_add_notes').disabled = true;
        var blank = getNodeAttribute('add_notes_blank', 'value');
        record_id = getNodeAttribute('add_notes_record_id', 'value');
        var date = getNodeAttribute('add_notes_date', 'value');
        if ($('add_notes_broadcast').checked) {
            var broadcast = 'yes';
        }
        else {
            var broadcast = 'no';
        }
        var userid = $('subcontractor_list').value;
        var query = queryString({'blank': blank, 'record_id': record_id, 'note': note, 'date': date, 'broadcast': broadcast, 'userid': userid});
        var d_post_save_notes = doXHR(SCM_PATH  + 'adminAddNote.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
        d_post_save_notes.addCallbacks(OnSuccessSaveNotes, OnFailSendNotes);
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
        var d_div_notes = doSimpleXMLHttpRequest(SCM_PATH + 'adminGetNote.php', {'blank': blank, 'record_id': record_id, 'userid': userid});
        d_div_notes.addCallbacks(OnSuccessGetNotes, OnFailGetNotes);
    }


    var ConnectAddButtons = function() {
        var add_buttons = getElementsByTagAndClassName('button', 'button_add_notes');
        for (add_button in add_buttons) {
            connect(add_buttons[add_button], 'onclick', OnClickAddButton);
        }

        disconnectAll('button_cancel_notes');
        disconnectAll('button_save_notes');
        connect('button_cancel_notes', 'onclick', OnClickButtonCancelNotes);
        connect('button_save_notes', 'onclick', OnClickButtonSaveNotes);
        hideElement('div_add_notes');

        var span_notes = getElementsByTagAndClassName('span', 'span_add_notes');
        for (span_note in span_notes) {
            connect(span_notes[span_note], 'onclick', OnClickNotes);
        }
    }

    var OnSuccessGetTimeSheetWithMonths = function(e) {
        $('subcon_main').innerHTML = e.responseText;
        connect('month_list', 'onchange', GetTimeSheet);
        ConnectAddButtons();
    }

    var OnFailGetTimeSheetWithMonths = function(e) {
        alert("Failed to retrieve time-sheet. Please try again later...");
    }

    replaceChildNodes('subcon_main', DIV({'id':'time_sheet'}, [
        DIV({'id': 'available_months'}, null),
        DIV({'id': 'dtr_time_sheet'}, null),
    ]));

    var d_dtr_time_sheet = doSimpleXMLHttpRequest(SCM_PATH + 'timeSheetForAdmin.php', {'userid': userid});
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
            var image_count = 0;
            for (var i = 0; i < image_list.length; i++) {
                var images = [];
                var json_images_list = image_list[i]['images'];
                for (var j = 0; j < json_images_list.length; j++) {
                    var label = json_images_list[j].substr(11,5);
                    images.push(OPTION({'value':json_images_list[j]}, label));
                    image_count += 1;
                }
                opt_group_list.push(OPTGROUP({'label': image_list[i]['time_span']}, images));
            }
            replaceChildNodes('div_image_list', [
                SELECT({'id':'image_list', 'size':24}, opt_group_list),
                SPAN({'style' : 'margin: 8px; font-weight: bold;'}, 'TOTAL SCREEN SHOTS : ' + image_count)
            ]);
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
