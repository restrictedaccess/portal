function SAInfoController($scope, $stateParams, $http, $modal, toaster){

    $scope.quote_id = $stateParams.quote_id;
    //$scope.sa_id = $stateParams.sa_id;
    $scope.admin_id = jQuery("#ADMIN_ID").val();
    var countItems = 0;

    $scope.initForm = function(){


        getQuoteDetailsFiles($scope, $stateParams, $http, $modal, toaster);

        //getSA($scope, $stateParams, $http, $modal, toaster);
    };

    $scope.iterateItems = function(val){

        return val  = val +1;
    };




    function getSA($scope, $stateParams, $http, $modal, toaster) {
        $scope.quote = null;
        var API_URL = jQuery("#NJS_API_URL").val();
        var item = [];
        if($scope.quote_id && $scope.sa_id)
        {
            $http.get(API_URL+"/quote/show/?id="+$scope.quote_id).success(function(response) {
                $scope.quote = response.data;
                $scope.totalSA = response.data.totalSA;
                $scope.sa = response.data.service_agreements;

                for(var i = 0 ; i < $scope.quote.quote_details.length ;i++ )
                {
                    if($scope.quote.quote_details[i].currency == "AUD")
                    {
                        $scope.quote.quote_details[i].currency_sign = "$";
                    }
                    else if($scope.quote.quote_details[i].currency == "GBP")
                    {
                        $scope.quote.quote_details[i].currency_sign = "£";
                    }
                    else {
                        $scope.quote.quote_details[i].currency_sign = "$";
                    }

                }


                if($scope.totalSA > 0 )
                {

                    for(var i = 0; i < $scope.totalSA ; i++) {
                        var value = $scope.sa[i];

                        if (value.id == $scope.sa_id) {
                            item.push({
                                status: value.status,
                                date_created: value.date_created,
                                date_posted: value.date_posted,
                                accepted: value.accepted,
                                date_accepted: value.date_accepted,
                                date_removed: value.date_removed,
                                ran: value.ran,
                                admin_fname: value.created_by.admin_fname,
                                admin_lname: value.created_by.admin_lname,
                                admin_email: value.created_by.admin_email
                            });

                            break;
                        }
                    }

                }
                else
                {
                    // console.log('pasok2');
                }


                $scope.SA = item[0];


            });

        }
        else {
            alert("Cannot find details.")
        }


    }

    $scope.getSADetails = function(){

        var API_URL = jQuery("#NJS_API_URL").val();
        $scope.SADetails = null;
        $http.get(API_URL+"/quote/get-sa-details/?sa_id="+$scope.sa_id).success(function(response) {

            if(response.success){
                $scope.SADetails = response.data;
            }

        });

    }


    $scope.getRsContact = function()
    {
        var API_URL = jQuery("#NJS_API_URL").val();
        var item=[];

        $http.get(API_URL+"/quote/get-rs-contact").success(function(response){


            if(response.success)
            {
                var site="";
                angular.forEach(response.data,function(value,key){

                    if(value.type == "company number")
                    {
                        if(value.site != "uk")
                        {
                            if(value.site == "php")
                            {
                                site = "PHL";
                            }
                            else {
                                site = value.site;
                            }

                            item.push({
                                site:site,
                                contact_no:value.contact_no
                            });

                        }
                    }

                });


                $scope.rsContacts = item;
                // console.log($scope.rsContacts);
            }
            else {
                alert("Cannot get Contact Details");
            }


        });
    }


    $scope.formatDate = function(unixtime) {
        var d = new Date(unixtime);
        var n =  d.toDateString();
        return n;
    };



    $scope.sendSA = function(){

        var BASE_URL = jQuery("#BASE_URL").val();
        $scope.formData = {};
        $scope.formData.quote_id = $scope.quote.id;
        $scope.formData.client_name = $scope.quote.client.fname;
        $scope.formData.client_email = $scope.quote.client.email;
        $scope.formData.admin_name = $scope.quote.quoted_by.admin_fname;
        $scope.formData.email = $scope.quote.quoted_by.admin_email;
        $scope.formData.link = BASE_URL+"/portal/sc_v2/pro-forma.php#/files/quote/"+$scope.sa_ran;

        // console.log( $scope.formData );
        $scope.loading5 = true;
        $http({
            method: 'POST',
            url:API_URL+"/send/quote",
            data: $scope.formData
        }).success(function(response) {
            // console.log(response);

            if(response.success){

                toaster.pop({
                    type: 'success',
                    title: 'Quote',
                    body: "Sending of Quote successfull",
                    showCloseButton: true,
                });
                $scope.loading5 = false;
            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Sending of email',
                    body: response.error,
                    showCloseButton: true,
                });

                $scope.loading5 = false;

            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem sending email to client. Please try again later.");
            $scope.loading5 = false;
        });



        // $scope.loading5 = true;
        // var API_URL = jQuery("#BASE_API_URL").val();
        // $http.get(API_URL+"/service-agreement/send-service-agreement/?service_agreement_id="+$scope.sa_id+"&id="+$scope.admin_id+"&type=admin").success(function(response) {
        //
        //     if(response.success){
        //         toaster.pop({
        //             type: 'success',
        //             title: 'Service Agreement',
        //             body: "Sent",
        //             showCloseButton: true,
        //         });
        //         $scope.loading5 = false;
        //     }else{
        //         toaster.pop({
        //             type: 'error',
        //             title: 'Sending of SA',
        //             body: response.error,
        //             showCloseButton: true,
        //         });
        //         $scope.loading5 = false;
        //     }
        //
        // });


    }



    $scope.sendSAModal = function(){


        var modalInstance = $modal.open({
            templateUrl: 'views/common/quote/details/modal_sending_quote.html',
            controller: SendSAModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{

                $invoker:function(){

                    return $scope;
                }

            }
        });


    };







    $scope.initForm();
    $scope.getSADetails();
    $scope.getRsContact();










}

function getQuoteDetailsFiles($scope, $stateParams, $http, $modal, toaster)
{
    $scope.quote = null;
    $scope.totalAmount = 0;
    $scope.gstvalue = 0;
    $scope.totalAmountValue=0;
    if($scope.quote_id){

        //Leads Currency Setting
        $http.get(API_URL+"/quote/show/?id="+$scope.quote_id).success(function(response){
            $scope.quote = response.data;
            $scope.sa = response.data.service_agreements;



            console.log( $scope.quote);

            if($scope.quote.quote_details.length > 0 )
            {
                $scope.cand = "";
                var i = 0;
                angular.forEach($scope.quote.quote_details,function(value,key) {

                    if(i < ($scope.quote.quote_details.length -1))
                    {
                        $scope.cand+=value.candidate.fname+" for the "+value.work_position+", ";
                    }else
                    {
                        $scope.cand+=value.candidate.fname+" for the "+value.work_position;
                    }

                    i++;

                });

                // console.log($scope.cand);

            }


            if ($scope.sa.length > 0)
            {
                $scope.sa_id = ($scope.sa[0].id ? $scope.sa[0].id : null);
                $scope.sa_ran = ($scope.sa[0].ran ? $scope.sa[0].ran : null);
                $scope.SA = $scope.sa[0];
            }

            $scope.totalSA = response.data.totalSA;
            // console.log($scope.quote);

            $scope.lastIndex = ($scope.quote.quote_details.length - 1 );

            for(var i = 0 ; i< $scope.quote.quote_details.length ; i++)
            {

                $scope.quote.quote_details[i].total_price = $scope.quote.quote_details[i].total_price.replace(/,/g, '');

                if(!$scope.quote.quote_details[i].total_price)
                {
                    $scope.quote.quote_details[i].total_price = 0.00;
                }
                if(!$scope.quote.quote_details[i].service_fee)
                {
                    $scope.quote.quote_details[i].service_fee = 0.00;
                }
                if(!$scope.quote.quote_details[i].office_fee)
                {
                    $scope.quote.quote_details[i].office_fee = 0.00;
                }
                if(!$scope.quote.quote_details[i].currency_adjustment)
                {
                    $scope.quote.quote_details[i].currency_adjustment = 0.00;
                }
                if(!$scope.quote.quote_details[i].others)
                {
                    $scope.quote.quote_details[i].others = 0.00;
                }

                $scope.quote.quote_details[i].index = i;

                $scope.totalAmount += (parseFloat($scope.quote.quote_details[i].quoted_price)+parseFloat($scope.quote.quote_details[i].service_fee)+
                parseFloat($scope.quote.quote_details[i].office_fee)+parseFloat($scope.quote.quote_details[i].currency_adjustment)+
                parseFloat($scope.quote.quote_details[i].others));


                if($scope.quote.quote_details[i].work_status == "Full-Time")
                {
                    $scope.quote.quote_details[i].client_hr = (((parseFloat($scope.quote.quote_details[i].quoted_price)*12)/52)/5)/8;

                }
                else{
                    $scope.quote.quote_details[i].client_hr = (((parseFloat($scope.quote.quote_details[i].quoted_price)*12)/52)/5)/4;
                }

                $scope.currency = $scope.quote.quote_details[i].currency;

            }

            angular.forEach($scope.currentCurr,function(value,key){

                if(value.currency == $scope.currency)
                {
                    if(value.currency_rate_in == 'PHP')
                    {
                        $scope.currentRate = value.rate;
                        return;
                    }
                }

            });

            angular.forEach($scope.currencySettings,function(value,key){

                if(value.currency == $scope.currency)
                {

                    $scope.forexRate = value.rate;
                    $scope.effective_date = value.effective_date;
                    return;
                }


            });

            // console.log($scope.quote.quote_details);
            // console.log("Amount "+ $scope.totalAmount);
            $scope.gstvalue = parseFloat($scope.totalAmount)*.10;
            $scope.totalAmountValue = parseFloat($scope.totalAmount)+parseFloat($scope.gstvalue);
            $scope.getLeadsCurrencySetting(response.data.client.id);

            if($scope.quote)
            {
                $scope.getClientSettings();
            }

        });
    }


    $scope.getClientSettings = function()
    {
        $http.get(API_URL+"/clients/get-client-settings/?id="+$scope.quote.client.id).success(function(response){

            if(response.success)
            {
                $scope.client_setting = response.result;

                if( response.result.currency )
                {
                    if(response.result.apply_gst == 'Y')
                    {
                        $scope.apply_gst = "Yes";
                    }
                    else
                    {
                        $scope.apply_gst = "No";
                    }

                    $scope.currency = response.result.currency;
                }
            }
            else
            {

                if($scope.quote.quote_details.length > 0)
                {
                    $scope.client_setting=$scope.quote.quote_details;
                    angular.forEach($scope.quote.quote_details,function(value,key){

                        if(value.currency && value.gst_apply)
                        {
                            $scope.currency = value.currency;
                            $scope.apply_gst = value.gst_apply
                            $scope.client_setting.currency = value.currency;
                            $scope.client_setting.apply_gst = value.gst_apply;
                            return;
                        }else {
                            $scope.client_setting.currency = 'AUD';
                            $scope.client_setting.apply_gst = 'No';
                            $scope.apply_gst = "No";
                            $scope.currency = "AUD";
                        }
                    });


                }
                else {
                    $scope.client_setting = null;
                    //console.log($scope.currency +"- "+ $scope.apply_gst );
                }
            }

        });
    };

    $scope.getLeadsCurrencySetting = function(leads_id){
        var API_URL = jQuery("#BASE_API_URL").val();

        $http.get(API_URL+"/leads/get-client-currency-settings-by-id?id="+leads_id).success(function(response){

            $scope.leads_currency_setting = response.client_currency_setting;
            // console.log($scope.leads_currency_setting);
            if($scope.leads_currency_setting.currency_gst_apply || $scope.leads_currency_setting.currency_gst_apply != "")
            {
                // console.log("pasok1");
                if($scope.leads_currency_setting.currency_gst_apply == "Y" || $scope.leads_currency_setting.currency_gst_apply == "y")
                {
                    $scope.leads_currency_setting.currency_gst_apply = "Yes";
                }
                else
                {
                    $scope.leads_currency_setting.currency_gst_apply = "No";
                }


                if($scope.leads_currency_setting.currency_code == 'AUD')
                {
                    $scope.leads_currency_setting.currency_sign = '$';
                }
                else if($scope.leads_currency_setting.currency_code == 'GBP')
                {
                    $scope.leads_currency_setting.currency_sign = '£';
                }
                else
                {
                    $scope.leads_currency_setting.currency_sign = '$';
                }


            }
            else {


                if($scope.quote.quote_details.length > 0)
                {   console.log('pasok2');
                    $scope.leads_currency_setting=$scope.quote.quote_details;
                    // console.log($scope.leads_currency_setting);
                    angular.forEach($scope.quote.quote_details,function(value,key){

                        if(value.currency)
                        {


                            $scope.leads_currency_setting.currency_gst_apply = value.gst_apply;
                            $scope.leads_currency_setting.currency_code = value.currency;

                            if(value.currency == 'AUD')
                            {
                                $scope.leads_currency_setting.currency_sign = '$';
                            }
                            else if(value.currency == 'GBP')
                            {
                                $scope.leads_currency_setting.currency_sign = '£';
                            }
                            else
                            {
                                $scope.leads_currency_setting.currency_sign = '$';
                            }

                            return;
                        }
                    });


                    // console.log($scope.leads_currency_setting);
                }
                else {
                    $scope.leads_currency_setting = null;
                    // console.log("pasok3");
                    // console.log($scope.leads_currency_setting);
                }

            }


            //
            // }
            // else {


            // console.log($scope.leads_currency_setting);

            //$scope.getTotalServiceAgreement();

        });

    };







    $scope.getDecimal = function(value)
    {
        if(value != null)
        {

            value = parseFloat(value);
            if((value) % 1 == 0)
            {
                value = addComma(value);
                value+=".00";
            }
            else
            {
                value = parseFloat(value).toFixed(2);
                value=addComma(value);
                var dec = value.toString().split(".")[1];

                if(dec)
                {
                    if(dec.length <= 1)
                    {
                        value+="0";
                    }
                }
                else
                {
                    value+=".00";
                }

            }
        }
        else
        {
            value = "0.00";
        }

        return value;
    };


    $scope.formatDate = function(unixtime) {
        var d = new Date(unixtime);
        var n =  d.toDateString();
        return n;
    };





}


function SendSAModalInstanceCtrl($scope, $modalInstance, $http, $invoker,toaster)
{

    var BASE_URL = jQuery("#BASE_URL").val();
    var API_URL = jQuery("#NJS_API_URL").val();

    var admin_name = jQuery("#ADMIN_NAME").val();
    var adminID = jQuery("#ADMIN_ID").val();

    $scope.emailFiles = [];
    $scope.objectFile = [];
    var addedDropzone = null;
    var accept = ".pdf,.doc,.docx,.odt";


    $scope.formData={};

    var fd = new FormData();

    $scope.quote = $invoker.quote;
    $scope.client = $invoker.quote.client;
    $scope.hiring_coordinator = null;
    var signature_company = "" , signature_contact="";

    if($scope.client.hiring_coordinator)
    {
        $scope.hiring_coordinator = $scope.client.hiring_coordinator;

        signature_company = $scope.hiring_coordinator.signature_company;
        signature_contact = $scope.hiring_coordinator.signature_contact_nos;
    }

    var signature = "";

    if(signature_company != "" && signature_contact != "")
    {
        signature = "<strong>"+signature_company+"</strong><br>"
            +"<strong>"+signature_contact+"</strong>";
    }
    else if(signature_company != "" && signature_contact == "")
    {
        signature = "<strong>"+signature_company+"</strong>";
    }
    else if (signature_company == "" && signature_contact != "")
    {
        signature = "<strong>"+signature_contact+"</strong>";
    }
    else
    {
        signature = "";
    }



    $scope.cand = $invoker.cand;
    $scope.SA = $invoker.quote.service_agreements[0];
    var link = BASE_URL+"/portal/sc_v2/pro-forma.php#/files/quote/"+$scope.SA.ran;
    //auto populate
    $scope.formData.Subject = "Quotation and Service Agreement Acceptance";
    $scope.formData.To = $scope.client.email;

    // $scope.formData.sa_semail = "Dear "+$scope.client.fname+",<br><br>"
    //                             +"Please click <a href='"+link+"'>here</a> to view and accept the Service Agreement.<br><br>"
    //                             +"Kind Regards,<br>"
    //                             +"<strong>"+$scope.quote.quoted_by.admin_fname+"</strong><br><br>"
    //                             +"<strong>"+signature+"</strong>";


    $scope.formData.Cc = ($scope.hiring_coordinator ? $scope.hiring_coordinator.admin_email : "" );




    //get email template
    $scope.getEmailtemplate = function()
    {

        var objectData = {};
        objectData.client_fname = $scope.quote.client.fname;
        objectData.client_lname = $scope.quote.client.lname;
        objectData.client_email = $scope.quote.client.email;
        objectData.created_by = $scope.quote.created_by;
        objectData.admin_name = ($scope.hiring_coordinator ? $scope.hiring_coordinator.admin_fname : "" );
        objectData.admin_lname = ($scope.hiring_coordinator ? $scope.hiring_coordinator.admin_lname : "" );
        objectData.email = $scope.quote.quoted_by.admin_email;
        objectData.link = link;
        objectData.Subject = ($scope.formData.Subject ? $scope.formData.Subject : "" );
        objectData.signature = signature;
        objectData.cand = $scope.cand;



        $http({
            method: 'POST',
            url:API_URL+"/quote/get-emailTemplate",
            data: objectData
        }).success(function(response) {
            if(response.success)
            {
                $scope.formData.sa_semail = response.data;
            }
            else
            {
                console.log("error getting email template");
            }


        }).error(function(response){
            //$scope.loading5 = false;
            console.log("error getting email template");
        });
    }

    // console.log($scope.quote);


    $scope.close_quote_details = function () {
        $modalInstance.dismiss('cancel');
    };




    $scope.saEmail_dropzone = {
        url: API_URL+"/send/quote",
        maxFilesize: 100,
        paramName: "uploadfile",
        maxThumbnailFilesize: 1,
        method: "post",
        acceptedFiles: accept,
        autoProcessQueue: false,
        uploadMultiple: true,
        addRemoveLinks: true,
        removedfile: function (file) {
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        headers: {
            "Accept": "application/json",
            "Cache-Control": null,
            "X-Requested-With": null
        },
        init: function () {
            var scope = $scope;
            scope.emailFiles.push({ file: 'added' });
            this.on('success', function (file, json) {
                //json = JSON.parse(json);
                if (json.success) {
                    toaster.pop({
                        type: 'success',
                        title: '',
                        body: 'Email Sent!',
                        showCloseButton: true,
                        timeout: 5000
                    });
                    setTimeout(function () {
                        $modalInstance.close();
                    }, 600);
                    scope.showErrors = false;
                    scope.errors = [];
                }
                else {
                    scope.showErrors = true;
                    scope.errors = json.errors;
                    if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                    addedDropzone = null;
                    scope.emailFiles = [];
                }
            });
            this.on('addedfile', function (file) {
                addedDropzone = this;

                scope.$apply(function () {
                    scope.emailFiles.push({ file: 'added' });
                });
            });
            this.on('drop', function (file) {
            });
            this.on('sending', function (file, xhr, formData) {
                formData.append("objectData", JSON.stringify($scope.saEmailfields));
            });
        }
    };



    //file uplaod

    $scope.uploadFile = function(files) {

        var extension = "";
        var size = 0;

        var label =  $("#choose");
        var close = $("#close");


        label.html("Choose a file&hellip;");
        if(files[0])
        {
            var ext = files[0].name.split(".");

            extension = ext[1];
            size = files[0].size;

            label.html(files[0].name);
            close.css( "display", "inline");
            close.show();

        }


        if(parseInt(size) <= 50000000)//50 mb
        {
            for(var i=0 ; i < files.length ; i++ )
            {
                $scope.objectFile.push(files[i]);
            }

            console.log(size);
        }
        else
        {
            alert("Please upload a file less than 50mb in size.");
            $('input[type=file]').val('');
            label.html("Choose a file&hellip;");
            close.hide();

        }

        console.log($scope.objectFile);

    };


    //close
    $scope.close = function(){

        var label =  $("#choose");
        var close = $("#close");
        $('input[type=file]').val('');
        label.html("Choose a file&hellip;");
        close.hide();

    };

    //sending of email

    $scope.SendMail = function()
    {

        var BASE_URL = jQuery("#BASE_URL").val();

        var objectData = {};

        $scope.formData.quote_id = $scope.quote.id;
        $scope.formData.sa_id = $scope.SA.id;
        $scope.formData.client_name = $scope.quote.client.fname;
        $scope.formData.client_email = $scope.quote.client.email;
        $scope.formData.created_by = $scope.quote.created_by;
        $scope.formData.adminID = adminID;
        $scope.formData.admin_name = ($scope.hiring_coordinator ? $scope.hiring_coordinator.admin_fname: "" );
        $scope.formData.admin_lname =($scope.hiring_coordinator ? $scope.hiring_coordinator.admin_lname: "" );
        $scope.formData.email = ($scope.hiring_coordinator ? $scope.hiring_coordinator.admin_email : "" );
        $scope.formData.link = link;
        $scope.formData.Subject = ($scope.formData.Subject ? $scope.formData.Subject : "" );
        $scope.formData.body_email =  $scope.formData.sa_semail;
        $scope.formData.Cc = $scope.formData.Cc;


        //
        // var resp = multipartForm.post(API_URL+"/send/quote",$scope.formData);
        //
        //
        // console.log(resp);





        // fd.append("objectData", JSON.stringify(objectData));


        // if (addedDropzone != null) {
        //     $scope.saEmailfields = objectData;
        //     addedDropzone.processQueue();
        // }
        //
        // else
        // {



        if(objectData.Subject || objectData.Subject != "")
        {
            $scope.loading6 = true;

            var fd = new FormData();
            var resp;
            for(var key in $scope.formData)
                fd.append(key,$scope.formData[key]);

            for(var key2 in $scope.objectFile)
                fd.append(key,$scope.objectFile[key2]);


            $http({
                method: 'POST',
                url:API_URL+"/send/quote",
                data: fd,
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            }).success(function(response) {
                // console.log(response);

                if(response.success){

                    toaster.pop({
                        type: 'success',
                        title: 'Quote',
                        body: "Sending of Quote successfull",
                        showCloseButton: true,
                    });
                    $scope.loading6 = false;
                    $modalInstance.dismiss('cancel');
                }else{
                    toaster.pop({
                        type: 'error',
                        title: 'Sending of email',
                        body: response.error,
                        showCloseButton: true,
                    });

                    $scope.loading6 = false;
                    $modalInstance.dismiss('cancel');

                }


            }).error(function(response){
                //$scope.loading5 = false;
                alert("There's a problem sending email to client. Please try again later.");
                $scope.loading6 = false;
                $modalInstance.dismiss('cancel');
            });
        }
        else
        {
            alert("Please fill in subject field.");
        }

    };


    $scope.optionsSendEmail = {
        height: 300,
        color: "white",
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    };



    $scope.uploadChange = function(){

        $scope.formData.uploadName = this.value;

    };



    $scope.getEmailtemplate();

}



function addComma(value)
{

    return Number(value).toLocaleString('en');
}



rs_module.controller('SAInfoController',["$scope", "$stateParams","$http", "$modal", "toaster", SAInfoController]);
rs_module.controller('SendSAModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker",SendSAModalInstanceCtrl]);



