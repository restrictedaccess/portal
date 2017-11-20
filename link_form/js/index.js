var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function isIE(userAgent) {
    userAgent = userAgent || navigator.userAgent;
    return userAgent.indexOf("MSIE ") > -1 || userAgent.indexOf("Trident/") > -1 || userAgent.indexOf("Edge/") > -1;
}

var hashcode = getUrlParameter('hashcode');

$(document).ready(function(){



    var base_api_url = jQuery("#base_api_url").val();



    //  $("#cname").focusout(function(e){
    //
    // });


    // $('#hashcode_field').val(hashcode);
    // $.post(base_api_url+'/job-order/get-job-order-details-by-hash/', { hashcode: hashcode},
    //   function(returnedData){
    //
    //     var obj = jQuery.parseJSON(returnedData);
    //     console.log(returnedData);
    //
    //       $('#cname').val(obj[0].client_name);
    //       $('#additionalcomments').val(obj[0].add_comments);
    //       $('#education').val(obj[0].educ_experience);
    //       $('#personalskills').val(obj[0].personal_soft_skills);
    //       $('#requiredtasks').val(obj[0].responsibilities);
    //       $('#requiredskills').val(obj[0].required_skills);
    //       $('#eaddress').val(obj[0].email);
    //       $('#contactnumber').val(obj[0].mobile+"/"+obj[0].officenumber);
    //       $('#companywebsite').val(obj[0].company_name);
    //       $('#timezone').val(obj[0].timezone);
    //       $('#numberstaffrequired').val(obj[0].num_staff_req);
    //       $('#staffjobtitle').val(obj[0].sub_category_name);
    //       var $radios = $('input:radio[name=radio_budget]');
    //       if(obj[0].budget != "$5-$20") {
    //           $('#openbudgetfield').val(obj[0].budget);
    //           $radios.filter('[id=radio_budget_2]').prop('checked', true);
    //           $("#openBudgetField").css('display','block');
    //       } else {
    //         $radios.filter('[id=radio_budget_1]').prop('checked', true);
    //       }
    //       var $radios_exprt = $('input:radio[name=radio_expertise]');
    //       if(obj[0].lvl_of_exprt != "") {
    //         if(obj[0].lvl_of_exprt == "Jr.Level(1-2 Years)") {$radios_exprt.filter('[id=radio_expertise_1]').prop('checked', true);}
    //         if(obj[0].lvl_of_exprt == "Mid Level(3-4 Years)") {$radios_exprt.filter('[id=radio_expertise_2]').prop('checked', true);}
    //         if(obj[0].lvl_of_exprt == "Sr.Level(5 and Up Years)") {$radios_exprt.filter('[id=radio_expertise_3]').prop('checked', true);}
    //       }
    //
    //       var $radios_exprt = $('input:radio[name=radio_job_type]');
    //       if(obj[0].job_type_name != "") {
    //         if(obj[0].job_type_name == "Full Time") {$radios_exprt.filter('[id=radio_full_time_job_type]').prop('checked', true);}
    //         if(obj[0].job_type_name == "Part-Time") {$radios_exprt.filter('[id=radio_part_time_job_type]').prop('checked', true);}
    //       }
    //
    //       var $radios_loc = $('input:radio[name=radio_location]');
    //       if(obj[0].job_loc_name != "") {
    //         if(obj[0].job_loc_name == "Home Based") {$radios_loc.filter('[id=radio_location_home]').prop('checked', true);}
    //         if(obj[0].job_loc_name == "Office Based") {$radios_loc.filter('[id=radio_location_office]').prop('checked', true);}
    //       }
    //
    //       var $radios_shore = $('input:radio[name=radio_have_you_used]');
    //       if(obj[0].is_off_shore != "") {
    //         if(obj[0].is_off_shore == "Yes") {$radios_shore.filter('[value=Yes]').prop('checked', true);}
    //         if(obj[0].is_off_shore == "No") {$radios_shore.filter('[value=No]').prop('checked', true);}
    //       }
    //
    // }).fail(function(){
    //       console.log("error");
    // });

    $("div#blackOut").hide();

    var radio_budget = $("input:radio[name=radio_budget]");

    $("#openBudgetField").hide();

    radio_budget.change(function(){

        var value = $("input:radio[name=radio_budget]:checked").val();

        if(value == "Open Budget")
        {
            $("#openBudgetField").show();
        }
        else
        {
            $("#openBudgetField").hide();
        }

    });









});

$(function() {


    $.validator.setDefaults({
        highlight: function(element) {
            $(element).closest('.required-field').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.required-field').removeClass('has-error');
        },
        ignore: ":hidden:not(.chosen)",
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent().hasClass("radio-inline")||element.parent().hasClass("checkbox-inline")||element.parent().hasClass("dropdown-inline")||element.parent().hasClass("radio")||element.parent().hasClass("checkbox")){
                error.appendTo(element.parent().parent().parent());
            }else{
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }

        }
    });


//    $.validator.addMethod("phoneValidate", function(number, element) {
//    number = number.replace(/\s+/g, "");
//    return this.optional(element) || number.length > 9 &&
//    number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
//    }, "Please specify a valid phone number");



    // $(document).on('click', '#job_spec_form', function(e) {
    //
    //
    //     // console.log('pasok');
    //     //
    //     // if (!form_validate()) {
    //     // }else
    //     // {
    //     //     console.log(JSON.stringify($("#register-form")[0].serializeFormJSON()));
    //     // }
    //     //    e.preventDefault();
    // });

    //
    // $(document).on('change', '.radio', function(e) {
    //
    // });


    //standard form submit

    $("#register-form").submit(function(e){
        e.preventDefault();
    }).validate({
        ignore: ":hidden:not(.chosen)",
        rules: {
            cname: "required",
            eaddress: {
                required: true,
                email: true,
            },
            contactnumber: {
                required: true
            },
            companywebsite: "required",
            radio_have_you_used: "required",
            radio_job_type: "required",
            radio_location: "required",
            timezone: {
                required: function (element) {
                    moveToElement(element, "#timezone");
                    return true;
                }
            },
            staffjobtitle: {
                required: function (element) {
                    moveToElement(element, "#staffjobtitle");
                    return true;
                }
            },
            numberstaffrequired: "required",
            radio_budget: "required",
            radio_expertise: "required",
            raterange: "required",
            yrsofexperience: "required",
            requiredskills: "required",
            requiredtasks: "required",
            personalskills: "required",
            education: "required",
            openbudgetfield: {
                required: function () {
                    return $("input[name=radio_budget]:checked").val() == 'Open Budget';
                }
            }
        },
        messages: {
            cname: "Specify Name of Client",
            eaddress: {
                required: "Please enter a valid Email Address",
                email: "Please enter a valid Email Address"
            },
            contactnumber: "Please enter a contact number",
            companywebsite: "Please enter a company name or a website",
            radio_have_you_used: "Please select Yes or no",
            radio_job_type: "Please select between Full time or Part time",
            radio_location: "Please select between Home Based or Office Based",
            radio_budget: "Please specify your budget",
            radio_expertise: "Please select the level of expertise",
            timezone: {
                required: "Please select Timezone"
            },
            staffjobtitle: "Specify the job title for this job",
            numberstaffrequired: "Specify number of required staff members",
            raterange: "Specify hourly or monthly rate",
            yrsofexperience: "Specify minimum years of experience for this job",
            requiredskills: "Specify the core skills needed for this job",
            requiredtasks: "Specify tasks which need to be done",
            personalskills: "Specify culture fit and other personal skills required for the job",
            education: "Specify what education is required for this job",
            openbudgetfield: "Please specify your budget"

        },
        submitHandler: function(form) {


            var base_api_url = jQuery("#base_api_url").val();
            var hasWhiteSpace = $("#cname").val().indexOf(' ')>=0;
            var rv2 = jQuery('#rv2').val();
            var pass3 = jQuery('#pass3').val();
            var staffJobTitle = $("#staffjobtitle");
            var timeZone = $("#timezone");

            if(!hasWhiteSpace){
                alert("Please include your lastname separated with a space!");
                setTimeout(function(){
                    $("#cname").focus();
                }, 0);
            }
            else
            {
                jQuery.post('./job_specification_form.php',{rv2:rv2,pass3:pass3},function(resp) {

                    console.log(resp);

                    if(resp=="1")
                    {
                        alert('invalid captcha!');
                    }
                    else
                    {
                        var data = JSON.stringify($(form).serializeFormJSON());
                        var hashcode = getUrlParameter('hashcode');
                        $.LoadingOverlay("show");
                        $.ajax({
                            type : 'POST',
                            url : base_api_url + '/job-order/save-job-specification-form-new/',
                            data : data,
                            dataType : 'json',
                            success : function(response) {
                                jQuery.post("/portal/link_form/session_js.php", {leads_id:response.leads_id, number_of_staff:response.number_of_staff, staff_job_title:response.staff_job_title, years_of_experience:response.years_of_experience}, function(response_new){
                                    if (response.TransCode == 0) {
                                        //syncToMongo(response['data']['jo_spec_id']);
                                        hideLoading();
                                        $("#register-form").trigger('reset');
                                        window.location.href = "/portal/link_form/thank_you.php";
                                    } else {
                                        alert(response.TransCode);
                                    }
                                });

                            },
                            error : function(response){
                                console.log(response);
                                $("#register-form").trigger('reset');
                                hideLoading();
                            }
                        });

                        return false;

                    }
                });
            }

        }
    });

});


(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = '"'+[o[this.name]]+'"';
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);



function form_validate() {

    var base_api_url = jQuery("#base_api_url").val();

    jQuery.validator.setDefaults({ ignore: ":hidden:not(.chosen)" });



    return $("#register-form").validate({
        ignore: ":hidden:not(.chosen)",
        rules : {
            cname : "required",
            eaddress : {
                required : true,
                email : true,
            },
            contactnumber: {
                required:true
            },
            companywebsite: "required",
            radio_have_you_used: "required",
            radio_job_type : "required",
            radio_location : "required",
            timezone : {
                required : function(element){
                    //var hashcode = getUrlParameter('hashcode');
                    console.log("yeah");
                    //console.log(hashcode);
                    moveToElement(element, "#timezone");
                    return true;
                }
            },
            /*
             shift_time_start : {
             required : function(element){
             moveToElement(element, "shift_time_start");
             return true;
             }
             },
             shift_time_end : {
             required : function(element){
             moveToElement(element, "shift_time_end");
             return true;
             }
             },
             jobType : "required",
             */
            staffjobtitle : "required",
            expected_terms : "required",
            numberstaffrequired : "required",
            radio_budget : "required",
            radio_expertise : "required",
            raterange : "required",
            yrsofexperience : "required",
            requiredskills : "required",
            requiredtasks : "required",
            personalskills : "required",
            education : "required",
            openbudgetfield : {required: function () {
                return $("input[name=radio_budget]:checked").val() == 'Open Budget';
            }
            }
        },
        messages : {
            cname : "Specify Name of Client",
            eaddress : {
                required : "Please enter a valid Email Address",
                email : "Please enter a valid Email Address"
            },
            contactnumber : "Please enter a contact number",
            companywebsite : "Please enter a company name or a website",
            radio_have_you_used : "Please select Yes or no",
            radio_job_type : "Please select between Full time or Part time",
            radio_location : "Please select between Home Based or Office Based",
            radio_budget : "Please specify your budget",
            radio_expertise : "Please select the level of expertise",
            timezone : {
                required : "Please select Timezone"
            },
            /*
             shift_time_start : "Select shift start time",
             shift_time_end : "Select shift end time",
             */
            staffjobtitle : "Specify the job title for this job",
            expected_terms : "Specify the expected terms of agreement",
            numberstaffrequired : "Specify number of required staff members",
            raterange : "Specify hourly or monthly rate",
            yrsofexperience : "Specify minimum years of experience for this job",
            requiredskills : "Specify the core skills needed for this job",
            requiredtasks : "Specify tasks which need to be done",
            personalskills : "Specify culture fit and other personal skills required for the job",
            education : "Specify what education is required for this job",
            openbudgetfield : "Please specify your budget"

        },

        submitHandler : function(form,event) {


            var data = JSON.stringify($(form).serializeFormJSON());
            var hashcode = getUrlParameter('hashcode');

            $.LoadingOverlay("show");
            $.ajax({
                type : 'POST',
                url : base_api_url + '/job-order/save-job-specification-form-new/',
                data : data,
                dataType : 'json',
                success : function(response) {

                    console.log('/job-order/save-job-specification-form-new/');
                    console.log(response.TransCode);

                    jQuery.post("/portal/link_form/session_js.php", {leads_id:response.leads_id, number_of_staff:response.number_of_staff, staff_job_title:response.staff_job_title, years_of_experience:response.years_of_experience}, function(response_new){
                        if (response.TransCode == 0) {
                            //syncToMongo(response['data']['jo_spec_id']);
                            hideLoading();
                            $("#register-form").trigger('reset');
                            window.location.href = "/portal/link_form/thank_you.php";
                        } else {
                            alert(response.TransCode);
                        }
                    });

                },
                error : function(response){
                    console.log(response);
                    $("#register-form").trigger('reset');
                    hideLoading();
                }
            });

        }
    });

}


$('.chosen').chosen({
    width:"100%",
    no_results_text:"Oops, nothing found!",
    allow_single_deselect:true,
});


function moveToElement(element, id){

    var selected_value = jQuery(element).val();
    if (selected_value == "") {
        jQuery(id).chosen().filter('[autofocus]').trigger('chosen:activate');
        jQuery(id).trigger('chosen:activate');
    }
}



function center(){
    var top, left;

    top = Math.max($(window).height() - $("div#prompt").outerHeight(), 0) / 2;
    left = Math.max($(window).width() - $("div#prompt").outerWidth(), 0) / 2;

    $("div#prompt").css({
        top:top + $(window).scrollTop(),
        left:left + $(window).scrollLeft()
    });
}

function prompt(msg)
{

    var contetnt = "";

    contetnt+='<label style="font-size:1.3em;color:#000;"><strong>'+msg+'</strong></label>';
    $("#prompt").html(contetnt);

    $("div#prompt").css({
        width: msg.width || 'auto',
        height: msg.height || 'auto'
    });

    center();

    $("div#blackOut").fadeTo(550, 0.8);
    //$("div#blackOut").show();
    $("div#prompt").show();

}

function hideLoading()
{
    $("#prompt").hide();
    $("div#blackOut").hide();
}

//for mongo

function syncToMongo(id)
{
    var base_api_url = jQuery("#base_api_url").val();
    var syncerUrl = base_api_url+"/mongo-index/sync-client-data-entry/";

    $.ajax({
        type : 'POST',
        url : syncerUrl,
        async:false,
        dataType : 'json',
        data:{action:function(){return 'sync';},
            id:function(){return id;}},
        success : function(response) {


        },
        error : function(response){
            hideLoader();
            console.log(response);
            alert(JSON.stringify(response));
        }
    });
}
