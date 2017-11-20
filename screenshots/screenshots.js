//var SCREENSHOT_PATH = '/rs/screenshots/';
var SCREENSHOT_PATH = '/dev/norman/Chris/screenshots/';
var URL_JSON_GET_IMAGE_LIST = SCREENSHOT_PATH + 'getImageList.php';
var URL_JSON_GET_SUBCON_LIST = SCREENSHOT_PATH + 'getAllSubcon.php';
var URL_JSON_GET_AVAILABLE_DAYS = SCREENSHOT_PATH + 'getAvailableDays.php';
var SCREENSHOT_DIR = SCREENSHOT_PATH + 'images/';
var USER_TYPE = 'subcon';
var uid = 0;
connect(window, "onload", OnLoadScreenShotViewer);

function OnLoadScreenShotViewer(e) {
//    Calendar.setup({ inputField : "input_date",
//        ifFormat : "%Y-%m-%d",
//        button : "on_click_date",
//        }
//    );

    replaceChildNodes('div_screenshots', [
        DIV({'id':'top_screenshots'}, [
            'Sub-Contractors Desktop Screenshots ',
            SPAN({'id' : 'span_subcontractor_list'}, null),
            SPAN({'id': 'span_day_select'}, null)
        ]),
        DIV({'id':'div_bottom_screenshots'}, [
            DIV({'id' : 'div_image_list'}, ' '),
            DIV({'id' : 'div_screen_shot_img'}, ' ')
        ])
    ]);

   GetSubContractorList();
   GetAvailableDays()
}

function GetAvailableDays() {
    var d_available_days = loadJSONDoc(URL_JSON_GET_AVAILABLE_DAYS);
    d_available_days.addCallbacks(OnSuccessGetAvailableDays, OnFailGetAvailableDays);
}

function OnSuccessGetAvailableDays(e) {
    option_list = [];
    for (i = 0; i < e.length; i++) {
        option_list.push(OPTION({'value':e[i][1]}, e[i][0]));
    }
    replaceChildNodes('span_day_select', SELECT({'id':'day_list'}, option_list));
    connect('day_list', 'onchange', GetImageList);
}

function OnFailGetAvailableDays(e) {
    alert('Failed to get days.\nPlease try again later.');
}

function GetSubContractorList() {
    var d_subcon_list = loadJSONDoc(URL_JSON_GET_SUBCON_LIST);
    d_subcon_list.addCallbacks(OnSuccessGetSubConList, OnFailGetSubConList);
}

function OnSuccessGetSubConList(e){
    option_list = [OPTION({'value': ''}, 'Please select sub-contractor...')];
    for (i = 0; i < e.length; i++) {
        option_list.push(OPTION({'value':e[i].userid}, e[i].lname + ', ' + e[i].fname));
    }
    replaceChildNodes('span_subcontractor_list', SELECT({'id':'subcontractor_list'}, option_list));
    connect('subcontractor_list', 'onchange', GetImageList);
}

function OnFailGetSubConList(e){
    alert('Failed to get Subcontractors.\nPlease try again later.');
}

function GetImageList(e) {
    replaceChildNodes('div_image_list', null);
    replaceChildNodes('div_screen_shot_img', null);
    userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }
    date_param = $('day_list').value;
    var d_image_list = loadJSONDoc(URL_JSON_GET_IMAGE_LIST, {'userid': userid, 'user_type': USER_TYPE, 'date_param': date_param});
    d_image_list.addCallbacks(OnSuccessGetImageList, OnFailGetImageList);
}

function OnSuccessGetImageList(e) {
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

function OnFailGetImageList(e) {
    alert('Failed to get image list.\n Please try again later.');
}

function FetchImage(e) {
    var date_time = $('image_list').value;
    var date_str = date_time.substring(0, 10);
    var time_str = date_time.substring(11);
    var time_str = time_str.replace(/:/g, '-');
    var uid = $('subcontractor_list').value;
    img_src = SCREENSHOT_DIR + USER_TYPE + '/' + date_str + '/' + uid + '/' + time_str + '.jpg';
    log(img_src);
    img = IMG({'src': img_src, 'width': 640}, null);
    replaceChildNodes('div_screen_shot_img', img);
}
