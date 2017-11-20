$(document).ready(function () {

    $("div#blackOut").hide();
    $("div#whiteBox").hide();

    var img = '<img src="./img/loading.gif" height=20px width=20px>';

    var radio_budget = $("input:radio[name=budget]");
    var specify_budget = $("#specifybudget");
    specify_budget.hide();

    var radio_issOffShore = $("input:radio[name=shore]");
    var radio_jobType = $("input:radio[name=jobtype]");
    var radio_loc = $("input:radio[name=locworker]");
    var radio_lvlExprt = $("input:radio[name=lvl_exprt]");
    var budgetVal = "";
    var hasEmail = "0";


    radio_budget.change(function () {
        var val = $("input:radio[name=budget]:checked").val();


        if (val == '1') {
            budgetVal = '1';
            specify_budget.show();
        }
        else {
            budgetVal = '0';
            $("#SpecifyBudget").val("");
            specify_budget.hide();
        }

    });


    $("#InputEmail").on('blur', function () {

        var EmailVal = $("#InputEmail").val();

        if (EmailVal != "") {
            $.ajax({
                url: "http://test.api.remotestaff.com.au/job-order/get-client-email/",
                type: 'post',
                dataType: 'json',
                async: false,
                data: {
                    data: function () {
                        return 'saveForm';
                    },
                    email: function () {
                        return EmailVal;
                    }
                },
                success: function (data) {


                    if (JSON.stringify(data['TransCode']) == '2') {
                        $('#email_message').text(JSON.stringify(data['TransMsg']));
                        $("#InputEmail").focus();
                        hasEmail == "1"


                    }
                    else {
                        $('#email_message').text('');
                        hasEmail == "0"

                    }


                }
            });
        }
        else {
            $('#email_message').text('');
            hasEmail == "0"
        }

    });


    $("#job_spec_form").click(function () {

        //lytbox(img);

        processForm();

    });


    function processForm() {
        var client_name = $("#InputName").val();
        var client_email = $("#InputEmail").val();
        var client_number = $("#InputNumber").val();
        var comp_name = $("#InputCompName").val();
        var job_position = $("#InputJobTitle").val();
        var isOffShore = $("input:radio[name=shore]:checked").val();
        var jobType = $("input:radio[name=jobtype]:checked").val();
        var loc = $("input:radio[name=locworker]:checked").val();
        var reqStaff = $("#InputStaffReq").val();
        var timezone = $("#timezone option:selected").text();
        var budgetValue = "";
        if (budgetVal == "1") {
            budgetValue = $("#SpecifyBudget").val();
        }
        else {
            budgetValue = "$5-$20 Hourly";
        }
        var lvl_exprt_val = $("input:radio[name=lvl_exprt]:checked").val();
        var req_skills = $("#RequiredSkills").val();
        var req_tasks = $("#RequiredTasks").val();
        var personal_skills = $("#PersonalSoftSkills").val();
        var educ_exp = $("#EducationExperience").val();
        var add_com = $("#AddComments").val();

        //alert(loc);

//                
//            alert(client_name+"-"+client_email+"-"+client_number+"-"+comp_name+"-"
//                    +job_position+"-"+isOffShore+"-"+jobType+"-"+loc
//                    +"-"+reqStaff+"-"+timezone+"-"+budgetValue+"-"+lvl_exprt_val
//                    +"-"+req_skills+"-"+req_tasks+"-"+personal_skills+"-"+educ_exp
//                    +"-"+add_com+"-"+hasEmail);

        if (client_name != "" && client_email != "" && client_number != "" && comp_name != ""
            && job_position != "" && isOffShore && jobType && loc && reqStaff != ""
            && timezone != "" && budgetValue && lvl_exprt_val != "" && req_skills != ""
            && req_tasks != "" && personal_skills != "" && educ_exp != "" && add_com != "" && hasEmail != "1") {

            $.ajax({
                url: "http://test.api.remotestaff.com.au/job-order/save-job-specification-form/",
                type: 'post',
                dataType: 'json',
                async: false,
                data: {
                    data: function () {
                        return 'saveForm';
                    },
                    client_name: function () {
                        return client_name;
                    },
                    contact_num: function () {
                        return client_number;
                    },
                    comp_name: function () {
                        return comp_name;
                    },
                    email: function () {
                        return client_email;
                    },
                    isOffshore: function () {
                        return isOffShore;
                    },
                    jobTitle: function () {
                        return job_position;
                    },
                    jobType: function () {
                        return jobType;
                    },
                    loc_name: function () {
                        return loc;
                    },
                    staff_num: function () {
                        return reqStaff;
                    },
                    time_zone: function () {
                        return timezone;
                    },
                    budget: function () {
                        return budgetValue;
                    },
                    lvl_exprt: function () {
                        return lvl_exprt_val;
                    },
                    req_skills: function () {
                        return req_skills;
                    },
                    responsibilities: function () {
                        return req_tasks;
                    },
                    personal_skills: function () {
                        return personal_skills;
                    },
                    educ_exp: function () {
                        return educ_exp;
                    },
                    add_com: function () {
                        return add_com;
                    }
                },
                success: function (data) {


                    if (JSON.stringify(data['TransCode']) == '0') {
                        $.prompt('Form submitted successfully!');
                        window.location.replace("http://www.remotestaff.com.au/");
                    }
                    else {
                        alert(data['TransMsg']);
                    }

                }
            });
//            


        }
        else {
            $("div#blackOut").hide();
            $("div#whiteBox").hide();


            $.prompt('Please complete required fields');


            setTimeout(function () {
                    $("div#blackOut").hide();
                    $("#prompt").hide();
                },
                2000);


            field_validate();
            radio_validate();

        }
    }


    function field_validate() {
        var client_name = $("#InputName").val();
        var client_email = $("#InputEmail").val();
        var client_number = $("#InputNumber").val();
        var comp_name = $("#InputCompName").val();
        var job_position = $("#InputJobTitle").val();
        var reqStaff = $("#InputStaffReq").val();
        var timezone = $("#timezone option:selected").text();
        var req_skills = $("#RequiredSkills").val();
        var req_tasks = $("#RequiredTasks").val();
        var personal_skills = $("#PersonalSoftSkills").val();
        var educ_exp = $("#EducationExperience").val();
        var add_com = $("#AddComments").val();


        if (client_name == "") {
            $("#InputName").focus();
            $('#name_message').text('Please specify your name');

        }

        $("#InputName").change(function () {
            if ($("#InputName").val() != "") {
                $('#name_message').text('');
            }
        });

        if (client_email == "") {
            $("#InputEmail").focus();
            $('#email_message').text('Please specify your email');

        }
        else if (hasEmail == "1") {
            $("#InputEmail").focus();
            $('#email_message').text('Email address already exists');
        }

        $("#InputEmail").change(function () {

            if ($("#InputEmail").val() != "") {
                $('#email_message').text('');
            }

        });

        if (client_number == "") {
            $("#InputNumber").focus();
            $('#number_message').text('Please specify your contact number');

        }
        $("#InputNumber").change(function () {
            if ($("#InputNumber").val() != "") {
                $('#number_message').text('');
            }
        });

        if (comp_name == "") {

            $("#InputCompName").focus();
            $('#company_message').text('Please specify your company name');

        }
        $("#InputCompName").change(function () {
            if ($("#InputCompName").val() != "") {
                $('#company_message').text('');
            }
        });


        if (job_position == "") {
            $("#InputJobTitle").focus();
            $('#job_cat_message').text('Please specify your job position');

        }
        $("#InputJobTitle").change(function () {
            if ($("#InputJobTitle").val() != "") {
                $('#job_cat_message').text('');
            }

        });

        if (reqStaff == "") {

            $("#InputStaffReq").focus();
            $('#staff_message').text('Please specify number of staff');

        }
        $("#InputStaffReq").change(function () {
            if ($("#InputStaffReq").val() != "") {
                $('#staff_message').text('');
            }

        });

        if (timezone == "") {
            $("#timezone").focus();
            $('#time_message').text('Please select time zone');


        }
        $("#timezone").change(function () {

            if ($("#timezone").val() != "") {
                $('#time_message').text('');
            }
        });


        if (req_skills == "") {
            $("#RequiredSkills").focus();
            $('#reqskills_message').text('Please specify required skill(s)');

        }
        $("#RequiredSkills").change(function () {
            if ($("#RequiredSkills").val() != "") {
                $('#reqskills_message').text('');
            }
        });

        if (req_tasks == "") {
            $("#RequiredTasks").focus();
            $('#reqtask_message').text('Please specify required task(s)');

        }
        $("#RequiredTasks").change(function () {
            if ($("#RequiredTasks").val() != "") {
                $('#reqtask_message').text('');
            }
        });

        if (personal_skills == "") {
            $("#PersonalSoftSkills").focus();
            $('#personal_message').text('Please specify personal soft skill(s)');

        }
        $("#PersonalSoftSkills").change(function () {
            if ($("#PersonalSoftSkills").val() != "") {
                $('#personal_message').text('');
            }
        });


        if (educ_exp == "") {
            $("#EducationExperience").focus();
            $('#educational_message').text('Please specify educational experience(s)');

        }
        $("#EducationExperience").change(function () {
            if ($("#EducationExperience").val() != "") {
                $('#educational_message').text('');
            }
        });

        if (add_com == "") {

            $("#AddComments").focus();
            $('#addcom_message').text('Please put some additional comment(s)');

        }
        $("#AddComments").change(function () {
            if ($("#AddComments").val() != "") {
                $('#addcom_message').text('');
            }
        });


    }


    function radio_validate() {
        var isChecked_radio_have_you_used = $("input[name=shore]:checked").val();
        var isChecked_radio_job_type = $("input[name=jobtype]:checked").val();
        var isChecked_radio_location = $("input[name=locworker]:checked").val();
        var isChecked_radio_budget = $("input[name=budget]:checked").val();
        var isChecked_radio_expertise = $("input[name=lvl_exprt]:checked").val();


        if (!isChecked_radio_have_you_used) {
            radio_issOffShore.focus();
            $('#have_you_message').text('Please select Yes or No');
        }


        radio_issOffShore.change(function () {

            $('#have_you_message').text(' ');
        });

        if (!isChecked_radio_job_type) {
            radio_jobType.focus();
            $('#job_type_message').text('Please select between Full time or Part time');

        }
        radio_jobType.change(function () {

            $('#job_type_message').text(' ');
        });

        if (!isChecked_radio_have_you_used) {
            radio_issOffShore.focus();
            $('#location_message').text('Please select between Home Based or Office Based');

        }

        radio_issOffShore.change(function () {

            $('#location_message').text(' ');
        });


        if (!isChecked_radio_budget) {
            radio_budget.focus();
            $('#budget_message').text('Please select between the options');

        }

        radio_budget.change(function () {

            $('#budget_message').text(' ');
        });


        if (!isChecked_radio_have_you_used) {
            radio_lvlExprt.focus();
            $('#expertise_message').text('Please select between the options');

        }


        radio_lvlExprt.change(function () {

            $('#expertise_message').text(' ');
        });

    }


    function reset() {

        $("#InputName").val('');
        $("#InputEmail").val('');
        $("#InputNumber").val('');
        $("#InputCompName").val('');
        $("#InputJobTitle").val('');
        $("#InputStaffReq").val('');
        $("#timezone option:selected").text('Please Select Timezone');
        $("#RequiredSkills").val('');
        $("#RequiredTasks").val('');
        $("#PersonalSoftSkills").val('');
        $("#EducationExperience").val('');
        $("#AddComments").val('');

    }


    function lytbox(variable) {


        $("div#blackOut").fadeTo(550, 0.8);
        $("div#whiteBox").fadeTo(550, 1);

        var divHeight = $("div#whiteBox").height();
        var divWidth = $("div#whiteBox").width();


        divHeight += 88;
        var marginTop = -(divHeight / 2);
        divWidth += 30;
        var marginLeft = -(divWidth / 2);


        marginTop += "px";
        marginLeft += "px";

        $("#whiteBox").css("margin-top", marginTop);
        $("#whiteBox").css("margin-left", marginLeft);

        $("#whiteBox").html(variable);


    }

    $("#close").click(function () {
        //close/hide lightbox
        $("div#blackOut").hide();
        $("div#whiteBox").hide();

    });


});