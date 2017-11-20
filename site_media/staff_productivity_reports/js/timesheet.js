var loadedTimesheets = [];
var njs_url = jQuery('#njs_input').val();
var reqScreenshot = true;
var loggedID = null;

jQuery(document).ready(function(){
    console.log(window.location.pathname);
    CURRENT_PAGE = "timesheet";

    get_time_sheets();
    get_timezones();

    jQuery("#timesheet_id").on("change", function(){
        get_timesheet_by_id();
    });

    jQuery("#timezone_id").on("change", function(){
        set_time_zone();
    });

    $("#add_notes_form_modal").modal("hide");
})

function set_time_zone(){
    var timezone_id = jQuery("#timezone_id" ).val();
    var data = {json_rpc:"2.0", id:"ID9", method:"set_time_zone", params:[timezone_id]};
    jQuery.ajax({
        url: STAFF_SERVICE_RPC,
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function(response) {
            console.log(response.result)
            if(response.result == 'ok'){
                get_timesheet_by_id();
            }
        }
    });
}
function add_note(){
    var timesheet_details_id = jQuery("#timesheet_details_id").val();
    var note_str = jQuery("#note_str").val();
    if(note_str == "" || note_str == " "){
        alert("Please type your message.");
        return false;
    }
    var data = {json_rpc:"2.0", id:"ID9", method:"add_note", params:[timesheet_details_id, note_str]};
    jQuery.ajax({
        url: STAFF_SERVICE_RPC,
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function(response) {
            console.log(response.result)
            notepad.unloadpad("timesheet_notepad");
            if(response.result == 'ok'){
                get_timesheet_by_id();
            }
        }
    });

}

function show_note(){
    //console.log(obj)
    var timesheet_details_id = jQuery(this).attr('data-timesheet-id');
    var ts_notes = jQuery('#note_'+timesheet_details_id).html();

    return false;
    notepad.unloadpad("timesheet_notepad");
    notepad.loadpad("timesheet_notepad", ['center','center']);
    jQuery("#timesheet_details_id").val(timesheet_details_id);
    jQuery("#ts_notes").html(ts_notes);
    jQuery("#add_note_btn").on("click", function(e){
        add_note();
        e.preventDefault()
    });
}
function get_timesheet_by_id(){
    var timezone_str = "Asia/Manila";
    var id = jQuery("#timesheet_id").val();
    timezone_str = jQuery("#timezone_id option:selected" ).text();

    if(!timezone_str){
        timezone_str = jQuery('#staff_timezone_id').attr("timezone");
    }

    if(id != ""){
        var data = {json_rpc:"2.0", id:"ID9", method:"get_timesheet_by_id", params:[id, timezone_str]};
        jQuery("#timesheet_table tbody").html('<tr><td colspan=\'13\' align="center"><small>Loading Timesheet</small></td></tr>')
        jQuery("#grand_total_hrs").html("0");
        jQuery("#grand_total_adj_hrs").html("0");
        jQuery("#grand_total_hrs_charged_to_client").html("0");
        jQuery("#grand_total_reg_ros_hrs").html("0");
        //jQuery("#grand_total_diff_charged_to_client").html("0");
        jQuery("#grand_total_lunch_hrs").html("0");
        var valDate = jQuery("#timesheet_id").val();
		var selectedDate = jQuery("#timesheet_id option[value='" + valDate + "']").text();

		var selMonthYear = selectedDate.split(":")[0].trim();
        jQuery.ajax({
            url: STAFF_SERVICE_RPC,
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                var output = "";
                if (response.result) {
                    loggedID = response.result.leads_id;
                    if (loggedID == 11) {
                        reqScreenshot = false;
                        jQuery('#fileuploadInput').parents().eq(3).hide();
                        jQuery('#add_notes_category').parents().eq(2).hide();
                    }
                    var dateList = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December'];
                    var dateArr = response.result.month_year.split('-');
                    var year = dateArr[0];
                    dateArr[0] = dateList[Number(dateArr[1]) - 1];
                    dateArr[1] = year;
                    jQuery.each(response.result.timesheet_details, function (i, item) {
                        var ifLocked = false;
                        if (item.notes_locked_date != null) {
                            ifLocked = true;
                        }
                        output += "<tr>";
                        output += "<td class='ts_day'>" + item.day + "</td>";
                        output += "<td>" + item.date + "</td>";
                        output += "<td>";
                        jQuery.each(item.time_in, function (j, time) {
                            output += time + "<br/>";
                        });
                        output += "</td>";
                        output += "<td>";

                        jQuery.each(item.time_out, function (j, time) {
                            output += time + "<br/>";
                        });

                        var hrs_pay_to_subcon = parseFloat(item.hrs_charged_to_client) + parseFloat(item.diff_charged_to_client);
                        output += "</td>";
                        output += "<td>" + item.total_hrs + "</td>";
                        output += "<td>" + item.adjusted_hrs + "</td>";
                        output += "<td>" + item.regular_rostered_hrs + "</td>";
                        output += "<td>" + formatNumber(hrs_pay_to_subcon) + "</td>";
                        //output += "<td>"+item.diff_charged_to_client+"</td>";
                        output += "<td>" + item.lunch_hours + "</td>";
                        output += "<td>";
                        jQuery.each(item.lunch_in, function (j, time) {
                            output += time + "<br/>";
                        });
                        output += "</td>";
                        output += "<td>";
                        jQuery.each(item.lunch_out, function (j, time) {
                            output += time + "<br/>";
                        });
                        output += "</td>";

                        var thisDateArr = selMonthYear.split("-");
                        var noteDate = dateArr[0] + ' ' + item.date + ' ' + dateArr[1];
                        output += "<td>" +
                            "<button id='note_" + item.id + "' data-timesheet-id='" + id + "' data-date='" + noteDate + "' data-lock='" + ifLocked + "' type='button' class='btn btn-primary btn-add-notes' title='Add Notes' style='background-color:#16987e !important; border-color: #16987e !important; background-image: none !important;'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>" +
                            "&nbsp;" +
                            "<div style='position: relative; display: inline-block;'>" +
                            "<button id='note_" + item.id + "' data-timesheet-id='" + id + "' data-date='" + noteDate + "' type='button' data-totalhours='" + item.total_hrs + "' class='btn btn-primary btn-view-notes' style='background-color:#1872ab !important; border-color: #1872ab !important; background-image: none !important;'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>" +
                            "<span id='" + item.id + "' style='position: absolute; top: -6px; right: -10px; background-color: #f8ac59; border-radius: 10px; font-size: 12px; font-weight: 600; padding-bottom: 1px; padding-left: 6px; padding-right: 6px;'>" + item.notes.length + "</span>" +
                            "</div>" +
                            "</td></tr>";
                    });
                    jQuery('#timesheet_id_str').html("Timesheet Id : " + id);
                    jQuery("#timesheet_table tbody").html(output);
                    jQuery("#assigned_timezone").html(response.result.timezone);
                    jQuery("#grand_total_hrs").html(response.result.timesheet_totals.grand_total_hrs);
                    jQuery("#grand_total_adj_hrs").html(response.result.timesheet_totals.grand_total_adj_hrs);
                    jQuery("#grand_total_hrs_charged_to_client").html(response.result.timesheet_totals.grand_total_hrs_charged_to_client);
                    jQuery("#grand_total_reg_ros_hrs").html(response.result.timesheet_totals.grand_total_adj_hrs);
                    //jQuery("#grand_total_diff_charged_to_client").html(response.result.timesheet_totals.grand_total_diff_charged_to_client);
                    jQuery("#grand_total_lunch_hrs").html(response.result.timesheet_totals.grand_total_lunch_hrs);
                    jQuery("#userid").val(response.result.userid);
                }
                jQuery(".btn-add-notes").on("click", function(e) {
                    var checkLock = $(this).attr('data-lock');
                    var curDate = jQuery(this).attr('data-date');
                    if (loggedID != 11 && checkLock == "true") {
                        var emailLink = "mailto:compliance@remotestaff.com.ph?subject=OT Approval for " + curDate;
                        jQuery("#emailHref").attr("href", emailLink);
                        jQuery("#lock_notes_modal").modal("show");
                    }else {
                        // var curMonth = curDate.getMonth(), curDay = curDate.getDate(), curYear = curDate.getFullYear();
                        jQuery('#appendDate').html(curDate);
                        jQuery("#add_notes_form_modal").modal("show");
                        var tsID = this.id.replace('note_', '').trim();
                        jQuery("#save_hours_notes, #save_add_hours_notes, #save_notes").attr('data-id', id);
                        jQuery("#save_hours_notes, #save_add_hours_notes, #save_notes").attr('data-timesheet-id', tsID);
                    }

                });
                jQuery(".add_notes_close").on("click", function(e) {
                    jQuery("#add_notes_form_modal").modal("hide");
                });
                jQuery(".btn-view-notes").on("click", function(e) {
                    var totalHours = jQuery(this).attr('data-totalhours').trim();
                    var timesheetDetailsIDBtn = jQuery(this).attr('id').replace('note_', '').trim();
                    var curDate = jQuery(this).attr('data-date');

                    fetchNotes(timesheetDetailsIDBtn);
                    jQuery("#save_notes").attr("data-timesheet-id", timesheetDetailsIDBtn).attr("data-date", curDate);
                    jQuery("#view_notes_form_modal").modal("show");
                });
                jQuery(".view_notes_close").on("click", function(e) {
                    jQuery("#view_notes_form_modal").modal("hide");
                });
                jQuery(".lock_notes_close").on("click", function(e) {
                    jQuery("#lock_notes_modal").modal("hide");
                });
            }
        });
    }
}

function get_time_sheets(){
    var data = {json_rpc:"2.0", id:"ID1", method:"get_time_sheets", params:[]};
    jQuery.ajax({
        url: STAFF_SERVICE_RPC,
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function(response) {
            timesheets = response.result;
            //console.log(timesheets);
            var options = [];
            var output="";
            jQuery.each(timesheets, function(i, item){
                options.push(item);
            });
            jQuery.each(options, function(j, item){
                //options.push(item);
                output += "<option value='"+item.timesheet_id+"'>";
                if(item.selected == true){
                    output += "Current Month-Year";
                }else{
                    output += item.month_year;
                }
                output += " : "+item.job_designation;
                output += " : "+item.client_name;
                output += "</option>";
            });
            //console.log(output);
            jQuery("#timesheet_id").html(output);
            var lastItem = options[options.length-1];
            jQuery("#timesheet_id").val(lastItem.timesheet_id);
            get_timesheet_by_id();
        }


    });
}

function get_timezones(){
    var data = {json_rpc:"2.0", id:"ID1", method:"get_timezones", params:[]};
    jQuery.ajax({
        url: STAFF_SERVICE_RPC,
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function(response) {
            var staff_timezone_id = jQuery('#staff_timezone_id').val();
            console.log(staff_timezone_id);
            timezones = response.result;
            var options = [];
            var output="";
            jQuery.each(timezones, function(i, item){
                options.push(item);
            });
            jQuery.each(options, function(j, item){
                if(staff_timezone_id == item.id){
                    output += "<option selected value='"+item.id+"'>";
                }else{
                    output += "<option value='"+item.id+"'>";
                }
                //output += "<option value='"+item.id+"'>";
                output += item.timezone;
                output += "</option>";
            });
            //console.log(output);
            jQuery("#timezone_id").html(output);

        }


    });
}

function formatNumber(num){
    var num = Math.round(num*100)/100;
    return num.toFixed(2);
}

function fetchNotes(noteID) {
    var timezone_str = "Asia/Manila";
    var id = jQuery("#timesheet_id").val();
    var outputNotesArr = [];
    var appendOutput = '';
    if (id) {
        var data = {json_rpc:"2.0", id:"ID9", method:"get_timesheet_by_id", params:[id, timezone_str]};
        // console.log(sta);
        jQuery.ajax({
            url: STAFF_SERVICE_RPC,
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            success: function(response) {
                console.log(response.result);
                jQuery.each(response.result.timesheet_details, function(i, item) {
                    var lockDate = Date.parse(item.notes_locked_date);
                    if (item.id == noteID) {
                        if (item.notes.length > 0) {
                            jQuery.each(item.notes, function (index, value) {
                                var notesArr = [];
                                var d = new Date(value.timestamp);
                                var day = d.getDate();
                                var month = parseInt(d.getMonth()) + 1;
                                var year = d.getFullYear();
                                var hours = d.getHours();
                                var min = d.getMinutes();
                                var secs = d.getSeconds();
                                var dDate = year + '-' + month + '-' + day + ' ' + hours + ':' + min + ':' + secs;

                                notesArr[0] = value.note;
                                notesArr[1] = value.id;
                                notesArr[2] = value.file_name;
                                notesArr[3] = value.notes_category;
                                notesArr[4] = value.fname + ' ' + value.lname;
                                notesArr[5] = dDate;

                                outputNotesArr.push(notesArr);
                            });
                        }
                    }
                });
                console.log(outputNotesArr);
                if (outputNotesArr) {
                    jQuery.each(outputNotesArr, function (index, value) {
                        appendOutput += '<div class="row">';
                        jQuery.each(value, function (inOut, valOut) {
                            if (inOut == 0) {
                                appendOutput += '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">';
                            }
                            if (inOut != 0 && inOut != 2) {
                                appendOutput += '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">';
                            }
                            if (inOut == 1 && value[2]) {
                                appendOutput += '<a target="_blank" href="' + njs_url + '/timesheet-details/fetch-screenshot-ts?ts_notes_id=' + valOut;
                            }
                            if (valOut && inOut != 1 && inOut != 2) {
                                appendOutput += valOut;
                            } else if (!valOut && inOut != 1) {
                                appendOutput += '-';
                            }
                            if (inOut == 2 && valOut) {
                                appendOutput += '">' + valOut + '</a>';
                            }
                            if (inOut != 1) {
                                appendOutput += '</div>';
                            }
                        });
                        appendOutput += '</div>';
                    });
                }
                jQuery('#append_data_view_notes').html(appendOutput);
            }
        });
    }
}

function addNotes(paramType, thisObj) {
    var userid = jQuery("#userid").val();
    var timesheet_details_id = jQuery(thisObj).attr('data-timesheet-id');
    var timesheet_comment = jQuery("#timesheet_comment").val().trim();
    var work_hours = jQuery("#work_hours").val().trim();
    var add_notes_category = jQuery("#add_notes_category").val();

    var formData = new FormData();

    var imageFile = null;
    var checkImg = jQuery('input[type=file]')[0].files.length;

    if (reqScreenshot) {
        if (checkImg) {
            imageFile = jQuery('input[type=file]')[0].files[0];

            if (imageFile.type != 'image/png' && imageFile.type != 'image/jpeg' && imageFile.type != 'image/jpg') {
                alert("Please upload image only");
                return false;
            }
        }else {
            alert("Please upload an image");
            return false;
        }
    }
    if (work_hours == "") {
        alert("Please enter your work hours");
        return false;
    }
    if(timesheet_comment == ""){
        alert("Please type your message.");
        return false;
    }
    var params = {
        'timesheet_details_id': timesheet_details_id,
        'note_str': timesheet_comment,
        'userid': userid,
        'work_hours': work_hours,
        'add_notes_category': add_notes_category
    };

    var spanNum = jQuery("#" + timesheet_details_id).text();

    formData.append('image', jQuery('input[type=file]')[0].files[0]);
    formData.append('params', JSON.stringify(params));
    formData.append('json_rpc', '2.0');
    formData.append('id', 'ID9');
    formData.append('method', 'add_note');

    var data = {json_rpc:"2.0", id:"ID9", method:"add_note", params:formData};
    jQuery.ajax({
        url: njs_url + '/timesheet-details/timesheet-add-notes',
        type: 'POST',
        data: formData,
        // contentType: 'application/json; charset=utf-8',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.success == true) {
                resetFormModal();
                spanNum = parseInt(spanNum) + 1;
                jQuery("#" + timesheet_details_id).text(spanNum);
                if (paramType) {
                    jQuery("#add_notes_form_modal").modal("hide");
                }
            }
        }
    });
}

jQuery(document).on('click', '#save_hours_notes', function() {
    addNotes(1, this);
});

jQuery(document).on('click', '#save_add_hours_notes', function() {
    addNotes(0, this);
});

jQuery(document).on('click', '#btn_change_file', function() {
    console.log('change file');
});

jQuery(document).on('click', '#save_notes', function() {
    var tsNotesID = jQuery(this).attr("data-timesheet-id");
    var curDate = jQuery(this).attr("data-date");

    jQuery('#appendDate').html(curDate);
    jQuery("#save_hours_notes").attr('data-timesheet-id', tsNotesID);
    jQuery("#save_add_hours_notes").attr('data-timesheet-id', tsNotesID);
    jQuery("#view_notes_form_modal").modal("hide");
    jQuery("#add_notes_form_modal").modal("show");
});

jQuery(document).on('change', '#fileuploadInput', function() {
    var filename = jQuery(this).val().replace(/.*[\/\\]/, '');
    jQuery('#filenameUpload').html(filename);
});

jQuery(document).on('hidden.bs.modal', '#add_notes_form_modal', function() {
    resetFormModal();
});

jQuery(document).on('hidden.bs.modal', '#view_notes_form_modal', function() {
    jQuery("#append_data_view_notes").empty();
});

jQuery(document).on('change', '#add_notes_category', function() {
    if (jQuery(this).val() == 'RSSC Issue') {
        reqScreenshot = false;
        jQuery('#fileuploadInput').parents().eq(3).hide();
    }else {
        reqScreenshot = true;
        jQuery('#fileuploadInput').parents().eq(3).show();
    }
});

function resetFormModal() {
    jQuery("#add_notes_form")[0].reset();
    jQuery("#filenameUpload").html("");
    if (loggedID == 11) {
        reqScreenshot = false;
        jQuery('#fileuploadInput').parents().eq(3).hide();
        jQuery('#add_notes_category').parents().eq(2).hide();
    }else {
        reqScreenshot = true;
        jQuery('#fileuploadInput').parents().eq(3).show();
    }
}