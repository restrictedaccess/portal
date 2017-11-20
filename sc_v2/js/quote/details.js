/**
 * Controller for Client Setting
 *
 * @version 1 - Initial Commit
 */

var timeArray_value = ["01:00:00","01:30:00","02:00:00","02:30:00", "03:00:00" ,"03:30:00" ,"04:00:00" , "04:30:00" , "05:00:00" , "05:30:00" , "06:00:00" , "06:30:00" ,
    "07:00:00" , "07:30:00" , "08:00:00" , "08:30:00" , "09:00:00" , "09:30:00" , "10:00:00" , "10:30:00" , "11:00:00" , "11:30:00" , "12:00:00" , "12:30:00" , "13:00:00" , "13:30:00" ,
    "14:00:00" , "14:30:00" ,"15:00:00" , "15:30:00" , "16:00:00" , "16:30:00" , "17:00:00" , "17:30:00" , "18:00:00" , "18:30:00" , "19:00:00" , "19:30:00" , "20:00:00" , "20:30:00" ,
    "21:00:00" , "21:30:00" , "22:00:00" , "22:30:00" , "23:00:00" , "23:30:00" , "00:00:00" , "00:30:00" ];

var timeArray_display = [ "1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am","6:00 am","6:30 am","7:00 am","7:30 am", "8:00 am","8:30 am",
    "9:00 am","09:30 am", "10:00 am","10:30 am", "11:00 am", "11:30 am", "12:00 noon", "12:30 pm", "1:00 pm", "1:30 pm","2:00 pm", "2:30 pm","3:00 pm","3:30 pm", "4:00 pm","4:30 pm", "5:00 pm",
    "5:30 pm", "6:00 pm", "6:30 pm","7:00 pm","7:30 pm","8:00 pm","8:30 pm","9:00 pm","9:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 midnight", "12:30 am"];


var workDisplay = ["Full Time 8hrs a day, 5 days a week","Part Time 4hrs a day, 5 days a week","Full time 1 Week Trial","Part Time 1 Week Trial",
    "Full Time 2 Weeks Trial","Part Time 2 Weeks Trial","Special Arrangement"];

var workValue =  ["Full-Time","Part-Time","Full-Time","Part-Time","Full-Time","Part-Time","Part-Time"];

var margins = ["","w/ Margin","w/o Margin","Custom Margin"];
function QuoteDetailsController($scope, $stateParams, $http, $modal, toaster){

    $scope.quote_id = $stateParams.quote_id;
    $scope.quote = null;
    $scope.quote_details = null;
    $scope.totalAmount = 0;
    $scope.indexDetails = 0;
    $scope.admin_id = jQuery("#ADMIN_ID").val();


    if(!$stateParams.quote_id){
        alert("Quote Id is missing");
    }

    $scope.openModalQuoteDetails = function(index){

        if(!index)
        {
            $scope.quoteIndex=-1;
        }
        //console.log(ctrl);
        var modalInstance = $modal.open({
            templateUrl: 'views/common/quote/details/modal_quote_details_form.html',
            controller: QuoteDetailsModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{

                $invoker:function(){

                    return $scope;
                }

            }
        });


    };

    $scope.openModalSendQuote = function(index){

        if(!index)
        {
            $scope.quoteIndex=-1;
        }
        //console.log(ctrl);
        var modalInstance = $modal.open({
            templateUrl: 'views/common/quote/details/modal_sending_quote.html',
            controller: SendQuoteModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{

                $invoker:function(){

                    return $scope;
                }

            }
        });


    };

    $scope.initForm = function(){

        getHistory($scope, $stateParams, $http, $modal, toaster);

        $http.get(API_URL+"/quote/get-timezone").success(function(response){

            if(response.success)
            {
                $scope.timezone = response.data;

                $scope.$emit("get_quote_details");

            }
            else
            {
                $scope.$emit("get_quote_details");
            }

            // console.log($scope.timezone);
        }).catch(function(err){
            $scope.timezone = null;
            console.log(err);
            $scope.$emit("get_quote_details");
        });
    };


    $scope.formatDate = function(unixtime) {
        var d = new Date(unixtime);
        var n =  d.toDateString();
        return n;
    };



    $scope.getQuoteIndex = function(index)
    {
        $scope.quoteIndex = index;

        $scope.openModalQuoteDetails(-1);

    };


    $scope.deleteQuoteDetails = function(index)
    {
        var API_URL = jQuery("#NJS_API_URL").val();
        $scope.formData = {};
        $scope.formData.detail_status = 'deleted';
        $scope.formData.details = $scope.quote.quote_details[index];
        $scope.formData.quote_details_id = $scope.quote.quote_details[index].id;
        $scope.formData.quote_id = $scope.quote_id;
        $scope.formData.created_by = $scope.admin_id;
        $scope.formData.adminID = jQuery("#ADMIN_ID").val();
        // console.log($scope.formData);
        $http({
            method: 'POST',
            url:API_URL+"/quote/update-quote",
            data: $scope.formData
        }).success(function(response) {
            // console.log(response);

            if(response.success){
                toaster.pop({
                    type: 'success',
                    title: 'Quote',
                    body: "Quote Details Deleted",
                    showCloseButton: true,
                });
                $scope.getLatest($scope);
                $scope.leads_id = $scope.quote.client.id;
                $scope.getLatestSolr($scope);
                $scope.$emit("get_quote_details");
                getHistory($scope, $stateParams, $http, $modal, toaster);
            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Quote',
                    body: response.error,
                    showCloseButton: true,
                });
            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem deleting quote. Please try again later.");
        });

    }


    $scope.sendEmail = function(){
        $scope.loading6 = true;
        var API_URL = jQuery("#NJS_API_URL").val();
        var BASE_URL = jQuery("#BASE_URL").val();
        //console.log(BASE_URL);exit();
        $scope.formData = {};
        $scope.formData.quote_id = $scope.quote.id;
        $scope.formData.client_name = $scope.quote.client.fname;
        $scope.formData.client_email = $scope.quote.client.email;
        $scope.formData.link = BASE_URL+"/portal/sc_v2/pro-forma.php#/files/quote/"+$scope.quote.ran;
        $scope.admin_name = $scope.quote.quoted_by.admin_fname;
        $scope.email = $scope.quote.quoted_by.admin_email;
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


                $scope.loading6 = false;

            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Sending of email',
                    body: response.error,
                    showCloseButton: true,
                });
                $scope.loading6 = false;
            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem sending email to client. Please try again later.");
            $scope.loading6 = false;
        });



    }

    $scope.deleteQuote = function(){
        var API_URL = jQuery("#NJS_API_URL").val();
        $scope.formData = {};
        $scope.formData.quote_id = $scope.quote_id;
        $scope.formData.created_by = $scope.admin_id;
        $scope.formData.adminID = jQuery("#ADMIN_ID").val();
        $scope.formData.status = "deleted";
        $http({
            method: 'POST',
            url:API_URL+"/quote/delete-quote",
            data: $scope.formData
        }).success(function(response) {
            // console.log(response);

            if(response.success){

                toaster.pop({
                    type: 'success',
                    title: 'Quote Deleted',
                    body: "Quote Deleted",
                    showCloseButton: true,
                });
                $scope.loading5 = false;
                $scope.getLatest($scope);
                $scope.leads_id = $scope.quote.client.id;
                $scope.getLatestSolr($scope);
                $scope.$emit("get_quote_details");
                getHistory($scope, $stateParams, $http, $modal, toaster);
            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Deleting of Quote',
                    body: response.error,
                    showCloseButton: true,
                });
                $scope.loading5 = false;
            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem deleting of qupte. Please try again later.");
            $scope.loading5 = false;
        });

    }

    $scope.convertToSA = function(){


        $scope.loading7 = true;
        var BASE_URL = jQuery("#BASE_API_URL").val();
        $scope.formData = {quote_id : $scope.quote_id, id:$scope.admin_id, type:'admin'};

        // console.log($scope.formData);

        $http({
            method: 'GET',
            url:BASE_URL+"/quote/convert-quote-to-service-agreement/?quote_id="+$scope.quote_id+"&id="+$scope.admin_id+"&type=admin"
        }).success(function(response) {
            // console.log(response);

            if(response.success){

                toaster.pop({
                    type: 'success',
                    title: 'SA',
                    body: "Converted to SA",
                    showCloseButton: true,
                });
                $scope.getLatest($scope);
                $scope.leads_id = $scope.quote.client.id;
                $scope.getLatestSolr($scope);
                $scope.Posted(response.service_agreement_id);
                $scope.loading7 = false;

                window.setTimeout(function () {

                    window.location.href = "/portal/sc_v2/#/quote/service_agreement_info/"+$stateParams.quote_id+"/"+response.service_agreement_id;

                }, 2000);

            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Failed to convert',
                    body: response.error,
                    showCloseButton: true,
                });
                $scope.loading7 = false;
            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem converting to SA.");
            $scope.loading7 = false;
        });


    };




    $scope.initForm();


    $scope.Posted = function(sa_id){
        var API_URL = jQuery("#NJS_API_URL").val();
        $scope.formData2 = {};
        $scope.formData2.quote_id = $scope.quote.id;
        $scope.formData2.created_by = $scope.admin_id;
        $scope.formData2.adminID = jQuery("#ADMIN_ID").val();
        $scope.formData2.To = $scope.quote.client.email;
        $scope.formData2.status = "posted";

        $scope.formData2.sa_id = sa_id;


        $http({
            method: 'POST',
            url:API_URL+"/quote/update-quote-status",
            data: $scope.formData2
        }).success(function(response) {
            // console.log(response);
            // window.location.reload();
        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem deleting of qupte. Please try again later.");
        });
    };



    $scope.$on("get_quote_details", function(event) {
        getQuoteDetails($scope, $stateParams, $http, $modal, toaster);
    });




}

function getQuoteDetails($scope, $stateParams, $http, $modal, toaster)
{
    $scope.quote = null;
    $scope.totalAmount = 0;
    $scope.gstvalue = 0;
    $scope.totalAmountValue=0;
    var API_URL = jQuery("#NJS_API_URL").val();
    if($scope.quote_id){

        //Leads Currency Setting
        $http.get(API_URL+"/quote/show/?id="+$scope.quote_id).success(function(response) {

            console.log(response.data);

            $scope.quote = response.data;
            $scope.sa = response.data.service_agreements;
            if ($scope.sa.length > 0)
            {
                $scope.sa_id = ($scope.sa[0].id ? $scope.sa[0].id : null);
                $scope.isAccepted = ($scope.sa[0].accepted ? $scope.sa[0].accepted : "no");
            }

            $scope.totalSA = response.data.totalSA;


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

            }

            // console.log($scope.quote.quote_details);

            $scope.gstvalue = parseFloat($scope.totalAmount)*.10;
            $scope.totalAmountValue = parseFloat($scope.totalAmount)+parseFloat($scope.gstvalue);
            //$scope.getLeadsCurrencySetting(response.data.client.id);

            if($scope.quote)
            {
                $scope.$emit("get_client_settings");
            }

        }).catch(function(err){
            console.log(err);
        });
    }



    $scope.getClientSettings = function()
    {
        $http.get(API_URL+"/clients/get-client-settings/?id="+$scope.quote.client.id).success(function(response){
            // console.log(response);
            if(response.success)
            {
                $scope.client_setting = response.result;

                if( response.result.currency )
                {

                    if(response.result.currency == "AUD")
                    {

                        $scope.currency_sign = "$";
                    }
                    else if(response.result.currency == "GBP")
                    {
                        $scope.currency_sign = "£";
                    }
                    else
                    {
                        $scope.currency_sign = "$";
                    }


                    if(response.result.apply_gst == 'Y')
                    {
                        $scope.apply_gst = "Yes";
                    }
                    else
                    {
                        $scope.apply_gst = "No";
                    }

                    $scope.currency = response.result.currency;
                    getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
                    getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
                }

                $scope.$emit("get_jobtitle");

            }
            else
            {

                if($scope.quote.quote_details.length > 0)
                {
                    $scope.client_setting=$scope.quote.quote_details;
                    angular.forEach($scope.quote.quote_details,function(value,key){

                        if(value.currency && value.gst_apply)
                        {

                            if(value.currency == "AUD")
                            {

                                $scope.currency_sign = "$";
                            }
                            else if(value.currency == "GBP")
                            {
                                $scope.currency_sign = "£";
                            }
                            else
                            {
                                $scope.currency_sign = "$";
                            }


                            $scope.currency = value.currency;
                            $scope.apply_gst = value.gst_apply
                            $scope.client_setting.currency = value.currency;
                            $scope.client_setting.apply_gst = value.gst_apply;
                            getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
                            getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
                            $scope.$emit("get_jobtitle");

                            return;
                        }else {
                            $scope.client_setting.currency = 'AUD';
                            $scope.client_setting.apply_gst = 'No';
                            $scope.apply_gst = "No";
                            $scope.currency = "AUD";
                            $scope.currency_sign = "$";
                            getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
                            getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
                            $scope.$emit("get_jobtitle");

                        }
                    });

                    // $scope.$emit("get_leads_settings");
                }
                else {
                    $scope.client_setting = null;
                    getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
                    getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
                    //console.log($scope.currency +"- "+ $scope.apply_gst );

                    $scope.$emit("get_jobtitle");

                }
            }

        });
    };


    $scope.getJobOrder = function()
    {
        $http.get(API_URL+"/quote/get-job-order/?leads_id="+$scope.quote.client.id).success(function(response){
            //$scope.jobOrder = null;
            if(response.length > 0){
                $scope.jobOrder = response;
            }
            else
            {
                $scope.jobOrder = null;
            }
        });
    }


    // $scope.getLeadsCurrencySetting = function(){
    //         var API_URL = jQuery("#BASE_API_URL").val();
    //         var leads_id = $scope.quote.client.id;
    //         $http.get(API_URL+"/leads/get-client-currency-settings-by-id?id="+leads_id).success(function(response){
    //
    //             $scope.leads_currency_setting = response.client_currency_setting;
    //
    //             if($scope.leads_currency_setting.currency_gst_apply || $scope.leads_currency_setting.currency_gst_apply != "")
    //             {
    //                 if($scope.leads_currency_setting.currency_gst_apply == "Y" || $scope.leads_currency_setting.currency_gst_apply == "y")
    //                 {
    //                     $scope.leads_currency_setting.currency_gst_apply = "Yes";
    //                 }
    //                 else
    //                 {
    //                     $scope.leads_currency_setting.currency_gst_apply = "No";
    //                 }
    //
    //
    //                 if($scope.leads_currency_setting.currency_code == 'AUD')
    //                 {
    //                     $scope.leads_currency_setting.currency_sign = '$';
    //                 }
    //
    //                 else if($scope.leads_currency_setting.currency_code == 'GBP')
    //                 {
    //                     $scope.leads_currency_setting.currency_sign = '£';
    //                 }
    //                 else
    //                 {
    //                     $scope.leads_currency_setting.currency_sign = '$';
    //                 }
    //
    //
    //             }
    //             else {
    //
    //                 if($scope.quote.quote_details.length > 0)
    //                 {
    //
    //
    //
    //                     $scope.leads_currency_setting=$scope.quote.quote_details;
    //                     angular.forEach($scope.quote.quote_details,function(value,key){
    //
    //                         // console.log(value);
    //
    //                         if(value.currency)
    //                         {
    //
    //
    //                             $scope.leads_currency_setting.currency_gst_apply = value.gst_apply;
    //                             $scope.leads_currency_setting.currency_code = value.currency;
    //
    //                             if(value.currency == 'AUD')
    //                             {
    //                                 $scope.leads_currency_setting.currency_sign = '$';
    //                             }
    //                             else if(value.currency == 'GBP')
    //                             {
    //                                 $scope.leads_currency_setting.currency_sign = '£';
    //                             }
    //                             else
    //                             {
    //                                 $scope.leads_currency_setting.currency_sign = '$';
    //                             }
    //
    //                             return;
    //                         }
    //                     });
    //
    //                     // console.log($scope.leads_currency_setting.currency_sign);
    //                 }
    //                 else {
    //                     $scope.leads_currency_setting = null;
    //                 }
    //
    //             }
    //
    //         });
    //
    //     };



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




    $scope.$on("get_client_settings", function(event) {
        if(!$scope.client_setting)
        {
            $scope.getClientSettings();
        }


    });

    $scope.$on("get_jobtitle", function(event) {
        if(!$scope.jobOrder)
        {
            $scope.getJobOrder();
        }

    });

}



function getCurrencySetting($scope, $stateParams, $http, $modal, toaster)
{
    var API_URL = jQuery("#BASE_API_URL").val();
    $http({
        method: 'GET',
        url:API_URL+"/currency-adjustment/current-currency-rates"
    }).success(function(response) {
        // console.log(response);
        if(response.success){

            $scope.currencySettings = response.results;

            angular.forEach($scope.currencySettings,function(value,key){

                if($scope.client_setting)
                {
                    if(value.currency == $scope.currency)
                    {

                        $scope.forexRate = value.rate;
                        $scope.effective_date = value.effective_date;

                        return;
                    }
                }
                else
                {
                    if(value.currency == "AUD")
                    {

                        $scope.forexRate = value.rate;
                        $scope.effective_date = value.effective_date;
                        return;
                    }
                }




            });

        }
    }).error(function(response){
        alert("error on getting staff price");
    });
}

function getCurrentCurrency($scope, $stateParams, $http, $modal, toaster)
{
    var NJS_URL = jQuery("#NJS_API_URL").val();
    $http({
        method: 'GET',
        url:NJS_URL+"/quote/get-current-currency"
    }).success(function(response) {
        // console.log(response);
        if(response.success)
        {
            $scope.currentCurr = response.data;

            angular.forEach($scope.currentCurr,function(value,key){

                if($scope.client_setting) {

                    if (value.currency == $scope.currency) {
                        if (value.currency_rate_in == 'PHP') {
                            $scope.currentRate = value.rate;
                            return;
                        }
                    }
                }
                else
                {
                    if (value.currency == "AUD") {
                        if (value.currency_rate_in == 'PHP') {
                            $scope.currentRate = value.rate;
                            return;
                        }
                    }
                }



            });

        }

    }).error(function(response){

        alert("error on getting current currency");
    });
}




function getHistory($scope, $stateParams, $http, $modal, toaster)
{

    $scope.filteredHistory = [];
    $scope.currentPage = 1;
    $scope.numberPage = 5;
    $scope.maxSize = 5;

    var API_URL = jQuery("#NJS_API_URL").val();


    $http({
        method: 'get',
        url:API_URL+"/quote/get-quote-history/?quote_id="+$scope.quote_id,
    }).success(function(response) {
        // console.log(response);
        $scope.history = null;
        if(response.success){

            // angular.forEach(response.data,function(value,key){
            //
            //     $scope.history.push({
            //         created_by: value.created_by,
            //         admin_fname: value.admin_fname,
            //         admin_lname: value.admin_lname,
            //         description: value.description,
            //         action: value.action,
            //         date_created: value.date_created
            //     });
            //
            // });


            // //pagination
            // $scope.numPages = Math.ceil($scope.history.length / $scope.numberPage);
            //
            //
            // $scope.$watch('currentPage + numberPage', function() {
            //     var begin = (($scope.currentPage - 1) * $scope.numberPage)
            //         , end = begin + $scope.numberPage;
            //
            //     $scope.filteredHistory = $scope.history.slice(begin, end);
            // });

            $scope.history = response.data;
            // console.log($scope.history.length);

        }else{

            // console.log("history failed"+ response.data);


        }


    }).error(function(response){
        //$scope.loading5 = false;
        // console.log("problem getting the history")

    });




}


function addComma(value)
{

    return Number(value).toLocaleString('en');
}


function getCurrencyAdjustment($scope)
{

    var work_status = workValue[$scope.formData.work_status];
    // console.log(workValue[$scope.formData.work_status]);
    var wok_stat_index = parseInt($scope.formData.work_status);
    var staff_working_hrs = 0,hourly_rate=0;
    var client_full_time_hr = (((parseFloat($scope.formData.quoted_price)*12)/52)/5)/8;
    var client_party_time_hr = (((parseFloat($scope.formData.quoted_price)*12)/52)/5)/4;

    // console.log(client_full_time_hr);

    var currencyAdjustmentAmount = 0;
    if(work_status == 'Full-Time')
    {
        staff_working_hrs = client_full_time_hr
        hourly_rate= 8 * 22;
    }
    else if(work_status == 'Part-Time')
    {
        if(wok_stat_index == 6)
        {
            if($scope.formData.work_status_special == "Full-Time")
            {
                staff_working_hrs = client_full_time_hr;
                hourly_rate = $scope.formData.specialArrangement_requiredHours * 22;
            }
            else {
                staff_working_hrs = client_party_time_hr;
                hourly_rate = $scope.formData.specialArrangement_requiredHours * 22;
            }


        }else
        {
            staff_working_hrs = client_party_time_hr;
            hourly_rate = 4*22;
        }

    }
    else {
        staff_working_hrs = 0;
        hourly_rate = 0;
    }

    currencyAdjustmentAmount = parseFloat(staff_working_hrs*(hourly_rate*($scope.currentRate - $scope.forexRate)/$scope.forexRate));
    return getDecimalFunc(currencyAdjustmentAmount);
    //console.log(staff_working_hrs+"-"+hourly_rate+"-"+$scope.currentRate+"-"+$scope.forexRate);



    //console.log($scope.forexRate);
}


// function syncQuoteDetails($scope, $stateParams, $http, $modal, toaster,num)
// {
//
//     var BASE_URL = jQuery("#BASE_API_URL").val();
//     var API_URL = jQuery("#NJS_API_URL").val();
//     $http({
//         method: 'GET',
//         url:BASE_URL+"/mongo-index/sync-quote?quote_id="+$scope.quote_id
//     }).success(function(response) {
//         // console.log(response);
//
//         if(response.success){
//         }else{
//             console.log('!synced')
//         }
//
//
//     }).error(function(response){
//         console.log('!synced')
//     });
//
// }

function QuoteDetailsModalInstanceCtrl($scope, $modalInstance, $http, $invoker,toaster) {
    var API_URL = jQuery("#NJS_API_URL").val();
    $scope.formData = {};
    var Temp = {};

    $scope.currencySettings = $invoker.currencySettings;
    $scope.currentCurr = $invoker.currentCurr;
    $scope.currentRate = $invoker.currentRate;
    $scope.forexRate = $invoker.forexRate;
    $scope.effective_date = $invoker.effective_date;
    $scope.formData.currency = $invoker.currency;
    $scope.currency = $invoker.currency;
    $scope.formData.apply_gst = (typeof $invoker.apply_gst != "undefined" ? $invoker.apply_gst : "No" );
    $scope.quoteIndex = $invoker.quoteIndex;
    $scope.formData.work_status = null;
    $scope.formData.client_timezone = "Australia/Sydney";
    $scope.formData.staff_timezone = "Asia/Manila";
    $scope.quote_id = $invoker.quote_id;
    $scope.formData.quote_id = $invoker.quote_id;
    $scope.formData.staff_currency = "PHP";
    $scope.onlyNumbers = /^\d+$/;
    $scope.client_setting = $invoker.client_setting;
    // $scope.client_setting = $invoker.quote.client_setting;
    $scope.salaryBreakDown  = null;
    $scope.jobOrder = null;
    $scope.hired = null;
    $scope.GBP_cur = "0.00";
    $scope.AUD_cur = "0.00";
    $scope.USD_cur = "0.00";
    $scope.AUD = "0.00";
    $scope.USD = "0.00";
    $scope.GBP = "0.00";
    $scope.formData.margin = "1";
    $scope.formData.others_amount = null;
    $scope.formData.others_description = null;
    $scope.isUpdate = null;
    $scope.formData.selected_start_work=null;
    $scope.sdate = null;
    $scope.timezone = $invoker.timezone;
    $scope.jobOrder = $invoker.jobOrder
    var changeVar = {};
    var addedVar = {};
    var marginAdder = 0;
    var adder = 18;


    //initialize as null

    $scope.formData.tracking_code = null;
    $scope.formData.userid = null;
    $scope.formData.work_status = null;
    $scope.formData.date = null;
    $scope.formData.work_start = null;

    //initialize all numeric fields as 0;
    var service_fee = 0,office_fee=0,others=0;




    $scope.formatDate = function(unixtime) {
        var d = new Date(unixtime);
        var n =  d.toDateString();
        return n;
    };




    function getHiredName(id)
    {
        var namevalue="";
        angular.forEach($scope.hired,function(value,key){

            if(value.userid == id)
            {
                namevalue = value.fullname+" - #"+value.userid;
                return;
            }


        });

        return namevalue;
    }



    $scope.$watch("formData.tracking_code",function(newValue,oldValue){


        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue))
        {
            changeVar["change1"]="Job Order => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added1"]="Job Order => "+newValue+"\n";}

    });
    $scope.$watch("formData.userid",function(newValue,oldValue){


        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue))
        {
            changeVar["change2"]="candidate => From: "+getHiredName(oldValue)+" TO: "+getHiredName(newValue)+"\n";

            // console.log(changeVar["change2"]);
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added2"]="Candidate => "+getHiredName(newValue)+"\n";}

    });
    $scope.$watch("formData.work_position",function(newValue,oldValue){

        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change3"]="Job Title => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added3"]="Job Title => "+newValue+"\n";}

    });
    $scope.$watch("formData.work_status",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change4"]="Work Status => From: "+workDisplay[oldValue]+" TO: "+workDisplay[newValue]+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added4"]="Work Status => "+workDisplay[newValue]+"\n";}
    });
    $scope.$watch("formData.specialArrangement",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change5"]="Special Arrangement => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added5"]="Special Arrangement => "+newValue+"\n";}
    });
    $scope.$watch("formData.work_status_special",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change6"]="Special Arrangement Work Status => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added6"]="Special Arrangement Work Status =>"+newValue+"\n";}
    });
    $scope.$watch("formData.specialArrangement_workingDays",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change7"]="Special Arrangement Working Days => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added7"]="Special Arrangement Working Days => "+newValue+"\n";}
    });
    $scope.$watch("formData.specialArrangement_requiredHours",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change8"]="Special Arrangement # of Hours => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added8"]="Special Arrangement # of Hours => "+newValue+"\n";}
    });
    $scope.$watch("formData.lanceApproval",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change9"]="Special Arrangement Lance Approval => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added9"]="Special Arrangement Lance Approval => "+newValue+"\n";}
    });
    $scope.$watch("formData.client_timezone",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change10"]="Client Timeznone => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added10"]="Client Timeznone => "+newValue+"\n";}
    });
    $scope.$watch("formData.work_start",function(newValue,oldValue){

        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change11"]="Client Start Work => From: "+timeArray_display[oldValue]+" TO: "+timeArray_display[newValue]+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added11"]="Client Start Work => "+timeArray_display[newValue]+"\n";}

    });
    $scope.$watch("formData.work_finish",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change12"]="Client Finish Work => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added12"]="Client Finish Work => "+newValue+"\n";}
    });
    $scope.$watch("formData.staff_timezone",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change13"]="Staff Timezone => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added13"]="Staff Timezone => "+newValue+"\n";}
    });
    $scope.$watch("formData.work_start_staff",function(newValue,oldValue){

        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change14"]="Staff Start Work => From: "+timeArray_display[oldValue]+" TO: "+timeArray_display[newValue]+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added14"]="Staff Start Work => "+timeArray_display[newValue]+"\n";}
    });
    $scope.$watch("formData.work_finish_staff",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change15"]="Staff Finish Work => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added15"]="Staff Finish Work => "+newValue+"\n";}
    });
    $scope.$watch("formData.staff_currency",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change16"]="Staff Currency => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added16"]="Staff Currency => "+newValue+"\n";}
    });
    $scope.$watch("formData.salary",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change17"]="Salary => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added17"]="Salary => "+newValue+"\n";}
    });
    $scope.$watch("formData.quoted_price",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change18"]="Client Price => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added18"]="Client Price => "+newValue+"\n";}
    });
    $scope.$watch("formData.service_fee",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            if(service_fee != 0 )
            {
                changeVar["change19"]="Service Fee => From: "+service_fee+" TO: "+newValue+"\n";
            }
            else
            {
                changeVar["change19"]="Service Fee => From: 0 TO: "+newValue+"\n";
            }

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added19"]="Service Fee => "+newValue+"\n";}
    });
    $scope.$watch("formData.office_fee",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            if(office_fee != 0)
            {
                changeVar["change20"]="Office Fee => From: "+office_fee+" TO: "+newValue+"\n";
            }
            else
            {
                changeVar["change20"]="Office Fee => From: 0 TO: "+newValue+"\n";
            }


        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added20"]="Office Fee => "+newValue+"\n";}
    });
    $scope.$watch("formData.currency_adjustment",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change21"]="Currency Fluctuation => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added21"]="Currency Fluctuation => "+newValue+"\n";}
    });
    $scope.$watch("formData.others_amount",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            if(others != 0)
            {
                changeVar["change22"]="Additional equipment funded by client => From: "+others+" TO: "+newValue+"\n";
            }
            else
            {
                changeVar["change22"]="Additional equipment funded by client => From: 0 TO: "+newValue+"\n";
            }


        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added22"]="Additional equipment funded by client => "+newValue+"\n";}
    });
    $scope.$watch("formData.others_description",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change23"]="Office Equipment => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added23"]="Office Equipment => "+newValue+"\n";}

    });

    $scope.$watch("formData.currency",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change24"]="Client Currency => From: "+oldValue+" TO: "+newValue+"\n";
        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added24"]="Client Currency => "+newValue+"\n";}
    });
    $scope.$watch("formData.apply_gst",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change25"]="GST => From: "+oldValue+" TO: "+newValue+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added25"]="GST => "+newValue+"\n";}
    });

    $scope.$watch("formData.margin",function(newValue,oldValue){
        if(oldValue!=newValue && !angular.isUndefined(oldValue) && !angular.isUndefined(newValue)){

            changeVar["change26"]="Margin => From: "+margins[oldValue]+" TO: "+margins[newValue]+"\n";

        }
        if(!angular.isUndefined(newValue) && newValue != null){addedVar["added26"]="Margin => "+margins[newValue]+"\n";}
    });

    $scope.$watch("date",function(newVal,oldVal){

        $scope.sdate = new Date(newVal);

        if(oldVal!=newVal && !angular.isUndefined(oldVal) && !angular.isUndefined(newVal))
        {
            changeVar["change27"]="Selected Start Date => From: "+$scope.formatDate(new Date(oldVal))+" TO: "+$scope.formatDate(new Date(newVal))+"\n";

        }
        if(!angular.isUndefined(newVal) && newVal != null){addedVar["added27"]="Selected Start Date => "+$scope.formatDate(new Date(newVal))+"\n";}


    });




    $scope.getJobtitle = function()
    {
        var val = $scope.formData.tracking_code.split("_");
        $scope.formData.work_position = val[1];

        //get hired candidates
        $http.get(API_URL+"/quote/get-job-order/?leads_id="+$invoker.quote.client.id+"&tracking_code="+val[0]).success(function(response){
            //$scope.jobOrder = null;
            $scope.hired = null;
            if(response.length > 0){

                var item = [];
                for(var i = 0 ; i < response.length ; i++)
                {
                    if(response[i].hired.length > 0)
                    {
                        for(var j = 0 ; j < response[i].hired.length;j++ )
                        {
                            item.push({

                                userid:response[i].hired[j].userid,
                                fullname:response[i].hired[j].fullname
                            });
                        }
                    }
                    else
                    {
                        $scope.hired = null;
                        break;
                    }


                }
                if(item.length > 0 )
                {
                    $scope.hired = item;
                }
                else
                {
                    $scope.hired = null;
                }

            }
            else
            {
                $scope.jobOrder = null;
            }
        });


    };

    $scope.add_details = function() {

        // console.log($scope.formData.tracking_code);
        // console.log($scope.formData.userid);
        // console.log(workValue[$scope.formData.work_status]);
        // console.log($scope.formData.work_start);
        // console.log(isNaN($scope.sdate));

        // exit();

        if(!$scope.formData.tracking_code || !$scope.formData.userid || !workValue[$scope.formData.work_status]
            || isNaN($scope.sdate) || !timeArray_value[$scope.formData.work_start])
        {
            alert("Please complete required fields");

        }else
        {


            var d = $scope.sdate.getDate();
            var m =  $scope.sdate.getMonth()+1;
            var y = $scope.sdate.getFullYear();



            if($scope.formData.others_amount != null)
            {

                if($scope.formData.others_description)
                {

                    $scope.loading5 = true;
                    $scope.formData.selected_start_work = y +"-"+(m < 10? "0": "") + m + "-" + (d < 10? "0": "") + d;

                    if($scope.quoteIndex != -1)
                    {
                        $scope.checkUpdate();
                    }
                    else {

                        var added ="";

                        for(var i = 1; i <= 27 ; i++)
                        {
                            if(!angular.isUndefined(addedVar["added"+i]))
                            {

                                added+=addedVar["added"+i]+"<br>";
                            }

                        }

                        $scope.formData.added = added;

                        //console.log($scope.formData.added);exit();
                        $scope.formData.created_by = $invoker.admin_id;
                        $scope.formData.adminID = jQuery("#ADMIN_ID").val();
                        // console.log($scope.formData);
                        // exit();

                        var API_URL = jQuery("#NJS_API_URL").val();

                        $http({
                            method: 'POST',
                            url:API_URL+"/quote/add-quote-details",
                            data: $scope.formData
                        }).success(function(response) {
                            // console.log(response);
                            $scope.loading5 = false;
                            //
                            if(response.success){
                                toaster.pop({
                                    type: 'success',
                                    title: 'Quote',
                                    body: "Quote Details added",
                                    showCloseButton: true,
                                });
                                $invoker.getLatest($invoker);
                                $invoker.leads_id = $invoker.quote.client.id;
                                $invoker.getLatestSolr($invoker);
                                $invoker.$emit("get_quote_details");
                                getHistory($invoker, $modalInstance, $http, $invoker,toaster);
                                $modalInstance.dismiss('cancel');
                            }else{
                                toaster.pop({
                                    type: 'error',
                                    title: 'Quote',
                                    body: response.error,
                                    showCloseButton: true,
                                });
                            }


                        }).error(function(response){
                            //$scope.loading5 = false;
                            alert("There's a problem adding new quote. Please try again later.");
                            $modalInstance.dismiss('cancel');
                        });
                    }
                }
                else
                {
                    alert("Please Input Description for the Additional equipment");
                }
            }
            else
            {
                $scope.loading5 = true;
                $scope.formData.selected_start_work = y +"-"+(m < 10? "0": "") + m + "-" + (d < 10? "0": "") + d;

                if($scope.quoteIndex != -1)
                {
                    $scope.checkUpdate();
                }
                else {

                    var added ="";

                    for(var i = 1; i <= 27 ; i++)
                    {
                        if(!angular.isUndefined(addedVar["added"+i]))
                        {

                            added+=addedVar["added"+i]+"<br>";
                        }

                    }

                    $scope.formData.added = added;

                    //console.log($scope.formData.added);exit();
                    $scope.formData.created_by = $invoker.admin_id;
                    $scope.formData.adminID = jQuery("#ADMIN_ID").val();
                    // console.log($scope.formData);
                    // exit();

                    var API_URL = jQuery("#NJS_API_URL").val();

                    $http({
                        method: 'POST',
                        url:API_URL+"/quote/add-quote-details",
                        data: $scope.formData
                    }).success(function(response) {
                        console.log(response);
                        $scope.loading5 = false;
                        //
                        if(response.success){
                            toaster.pop({
                                type: 'success',
                                title: 'Quote',
                                body: "Quote Details added",
                                showCloseButton: true,
                            });

                            $invoker.getLatest($invoker);
                            $invoker.leads_id = $invoker.quote.client.id;
                            $invoker.getLatestSolr($invoker);
                            $invoker.$emit("get_quote_details");
                            getHistory($invoker, $modalInstance, $http, $invoker,toaster);
                            $modalInstance.dismiss('cancel');
                        }else{
                            toaster.pop({
                                type: 'error',
                                title: 'Quote',
                                body: response.error,
                                showCloseButton: true,
                            });
                        }


                    }).error(function(response){
                        //$scope.loading5 = false;
                        alert("There's a problem adding new quote. Please try again later.");
                        $modalInstance.dismiss('cancel');
                    });
                }
            }


        }


    };



    $scope.close_quote_details = function () {
        $modalInstance.dismiss('cancel');
    };


    $scope.salaryChange = function() {


        var API_URL = jQuery("#BASE_API_URL").val();
        var status = "";
        var toBeAdded = 0;
        if ($scope.formData.salary && $scope.formData.work_status >= 0) {

            if ($scope.formData.work_status != 6) {
                $scope.formData.specialArrangement = null;
                $scope.formData.work_status_special = null;
                $scope.formData.specialArrangement_workingDays = null;
                $scope.formData.specialArrangement_requiredHours = null;
            }

            if ($scope.formData.work_status_special) {
                status = $scope.formData.work_status_special;
                $scope.workStatus = status;
            }
            else {
                status = workValue[$scope.formData.work_status];
                $scope.workStatus = workValue[$scope.formData.work_status];
            }


            $http.get(API_URL + "/utilities/breakdown-salary/?work_status=" + status + "&staff_currency=" + $scope.formData.staff_currency + "&salary=" + $scope.formData.salary).success(function (response) {


                $scope.salaryBreakDown = response;

                console.log($scope.salaryBreakDown);
                var adderVal = 8;
                if (status == "Full-Time") {
                    adderVal = 8;
                    if (parseInt($scope.formData.salary) <= 19999) {
                        $scope.AUD = "370";
                        $scope.USD = "285";
                        $scope.GBP = "220";
                    }
                    else {
                        $scope.AUD = "460";
                        $scope.USD = "355";
                        $scope.GBP = "275";
                    }

                }
                else if (status == "Part-Time") {
                    adderVal = 4;
                    if (parseInt($scope.formData.salary) <= 13999) {
                        $scope.AUD = "230";
                        $scope.USD = "180";
                        $scope.GBP = "135";
                    }
                    else {
                        $scope.AUD = "275";
                        $scope.USD = "210";
                        $scope.GBP = "165";
                    }

                }


                if ($scope.formData.margin == "1") {

                    $scope.formData.service_fee = "";
                    $scope.formData.service_fee = null;


                    angular.forEach($scope.salaryBreakDown.result,function(value,key){

                        if(value.currency == "GBP")
                        {

                            value.monthly = (parseFloat(value.monthly) + parseInt($scope.GBP));
                            value.yearly = (parseFloat(value.monthly * 12));
                            value.weekly = (parseFloat(value.yearly / 52));
                            value.daily = (parseFloat(value.weekly / 5));
                            value.hourly = (parseFloat(value.daily / adderVal));

                            $scope.GBP_cur = value.currency_rate;
                            $scope.salaryBreakDown.gbp = $scope.salaryBreakDown.result[key];


                        }

                        else if(value.currency == "AUD")
                        {


                            value.monthly = (parseFloat(value.monthly) + parseInt($scope.AUD));
                            value.yearly = (parseFloat(value.monthly * 12));
                            value.weekly = (parseFloat(value.yearly / 52));
                            value.daily = (parseFloat(value.weekly / 5));
                            value.hourly = (parseFloat(value.daily / adderVal));


                            $scope.AUD_cur = value.currency_rate;


                            $scope.formData.quoted_price = (parseFloat(value.monthly).toFixed(2));

                            $scope.salaryBreakDown.aud = $scope.salaryBreakDown.result[key];
                        }

                        else if(value.currency == "USD")
                        {


                            value.monthly = (parseFloat(value.monthly) + parseInt($scope.USD));
                            value.yearly = (parseFloat(value.monthly * 12));
                            value.weekly = (parseFloat(value.yearly / 52));
                            value.daily = (parseFloat(value.weekly / 5));
                            value.hourly = (parseFloat(value.daily / adderVal));


                            $scope.USD_cur = value.currency_rate;
                            $scope.salaryBreakDown.usd = $scope.salaryBreakDown.result[key];

                        }
                        else
                        {
                            $scope.salaryBreakDown.php = $scope.salaryBreakDown.result[key];
                        }

                    });

                }
                else if ($scope.formData.margin == "2") {
                    $scope.formData.service_fee = "0.00";
                    $scope.formData.service_fee = null;


                    angular.forEach($scope.salaryBreakDown.result,function(value,key){

                        if(value.currency == "GBP")
                        {
                            value.monthly = (parseFloat(value.monthly));
                            value.yearly = (parseFloat(value.yearly));
                            value.weekly = (parseFloat(value.weekly));
                            value.daily = (parseFloat(value.daily));
                            value.hourly = (parseFloat(value.hourly));

                            $scope.GBP_cur = value.currency_rate;
                            $scope.salaryBreakDown.gbp = $scope.salaryBreakDown.result[key];


                        }

                        else if(value.currency == "AUD")
                        {
                            value.monthly = (parseFloat(value.monthly));
                            value.yearly = (parseFloat(value.yearly));
                            value.weekly = (parseFloat(value.weekly));
                            value.daily = (parseFloat(value.daily));
                            value.hourly = (parseFloat(value.hourly));

                            $scope.AUD_cur = value.currency_rate;

                            $scope.formData.quoted_price = (parseFloat(value.monthly).toFixed(2));

                            $scope.salaryBreakDown.aud = $scope.salaryBreakDown.result[key];
                        }

                        else if(value.currency == "USD")
                        {
                            value.monthly = (parseFloat(value.monthly));
                            value.yearly = (parseFloat(value.yearly));
                            value.weekly = (parseFloat(value.weekly));
                            value.daily = (parseFloat(value.daily));
                            value.hourly = (parseFloat(value.hourly));

                            $scope.USD_cur = value.currency_rate;
                            $scope.salaryBreakDown.usd = $scope.salaryBreakDown.result[key];


                        }
                        else
                        {
                            $scope.salaryBreakDown.php = $scope.salaryBreakDown.result[key];
                        }

                    });


                }

                else {
                    if (!$scope.formData.service_fee) {



                        angular.forEach($scope.salaryBreakDown.result,function(value,key){

                            if(value.currency == "GBP")
                            {
                                value.monthly = (parseFloat(value.monthly));
                                value.yearly = (parseFloat(value.yearly));
                                value.weekly = (parseFloat(value.weekly));
                                value.daily = (parseFloat(value.daily));
                                value.hourly = (parseFloat(value.hourly));

                                $scope.GBP_cur = value.currency_rate;
                                $scope.salaryBreakDown.gbp = $scope.salaryBreakDown.result[key];


                            }

                            else if(value.currency == "AUD")
                            {
                                value.monthly = (parseFloat(value.monthly));
                                value.yearly = (parseFloat(value.yearly));
                                value.weekly = (parseFloat(value.weekly));
                                value.daily = (parseFloat(value.daily));
                                value.hourly = (parseFloat(value.hourly));

                                $scope.AUD_cur = value.currency_rate;

                                $scope.formData.quoted_price = (parseFloat(value.monthly).toFixed(2));
                                $scope.salaryBreakDown.aud = $scope.salaryBreakDown.result[key];
                            }

                            else if(value.currency == "USD")
                            {
                                value.monthly = (parseFloat(value.monthly));
                                value.yearly = (parseFloat(value.yearly));
                                value.weekly = (parseFloat(value.weekly));
                                value.daily = (parseFloat(value.daily));
                                value.hourly = (parseFloat(value.hourly));

                                $scope.USD_cur = value.currency_rate;
                                $scope.salaryBreakDown.usd = $scope.salaryBreakDown.result[key];
                            }

                            else
                            {
                                $scope.salaryBreakDown.php = $scope.salaryBreakDown.result[key];
                            }

                        });



                    }
                    else {


                        angular.forEach($scope.salaryBreakDown.result,function(value,key){

                            if(value.currency == "GBP")
                            {
                                value.monthly = (parseFloat(value.monthly) + parseFloat($scope.formData.service_fee));
                                value.yearly = (parseFloat(value.monthly * 12));
                                value.weekly = (parseFloat(value.yearly / 52));
                                value.daily = (parseFloat(value.weekly / 5));
                                value.hourly = (parseFloat(value.daily / adderVal));
                                $scope.GBP_cur = value.currency_rate;


                                $scope.salaryBreakDown.gbp = $scope.salaryBreakDown.result[key];

                            }

                            else if(value.currency == "AUD")
                            {
                                value.monthly = (parseFloat(value.monthly) + parseFloat($scope.formData.service_fee));
                                value.yearly = (parseFloat(value.monthly * 12));
                                value.weekly = (parseFloat(value.yearly / 52));
                                value.daily = (parseFloat(value.weekly / 5));
                                value.hourly = (parseFloat(value.daily / adderVal));

                                $scope.AUD_cur = value.currency_rate;

                                $scope.formData.quoted_price = (parseFloat(value.monthly) - parseFloat($scope.formData.service_fee)).toFixed(2);

                                $scope.salaryBreakDown.aud = $scope.salaryBreakDown.result[key];
                            }


                            else if(value.currency == "USD")
                            {
                                value.monthly = (parseFloat(value.monthly) + parseFloat($scope.formData.service_fee));
                                value.yearly = (parseFloat(value.monthly * 12));
                                value.weekly = (parseFloat(value.yearly / 52));
                                value.daily = (parseFloat(value.weekly / 5));
                                value.hourly = (parseFloat(value.daily / adderVal));

                                $scope.USD_cur = value.currency_rate;
                                $scope.salaryBreakDown.usd = $scope.salaryBreakDown.result[key];


                            }
                            else
                            {
                                $scope.salaryBreakDown.php = $scope.salaryBreakDown.result[key];
                            }

                        });



                    }

                }

                $scope.formData.currency_adjustment = getCurrencyAdjustment($scope);


                if ($scope.formData.currency) {

                    $scope.currency = $scope.formData.currency;

                    angular.forEach($scope.currentCurr, function (value, key) {

                        if (value.currency == $scope.formData.currency) {
                            if (value.currency_rate_in == 'PHP') {
                                $scope.currentRate = value.rate;

                                return;
                            }
                        }

                    });

                    angular.forEach($scope.currencySettings, function (value, key) {

                        if (value.currency == $scope.formData.currency) {

                            $scope.forexRate = value.rate;
                            $scope.effective_date = value.effective_date;
                            return;
                        }


                    });
                }


            });
        } else
        {
            if($scope.formData.currency)
            {
                $scope.currency = $scope.formData.currency;
                angular.forEach($scope.currentCurr,function(value,key){

                    if(value.currency == $scope.formData.currency)
                    {
                        if(value.currency_rate_in == 'PHP')
                        {
                            $scope.currentRate = value.rate;

                            return;
                        }
                    }

                });

                angular.forEach($scope.currencySettings,function(value,key){

                    if(value.currency == $scope.formData.currency)
                    {

                        $scope.forexRate = value.rate;
                        $scope.effective_date = value.effective_date;
                        return;
                    }


                });
            }
        }


    };


    $scope.workStatusValue = function(){



        $scope.workStatusVal = [];
        for(var i = 0 ; i<workDisplay.length ; i++)
        {
            $scope.workStatusVal.push({
                value:i,
                display:workDisplay[i]
            });
        }

    };

    $scope.getTimeDisplay = function()
    {

        $scope.timeArray = [];

        for(var i = 0 ; i<timeArray_value.length ; i++)
        {
            $scope.timeArray.push({

                value:timeArray_value[i],
                display:timeArray_display[i],
                count:i
            });
        }

        // console.log($scope.timeArray);

    };




    $scope.workStatusValue();
    $scope.getTimeDisplay();


    $scope.workStartChange = function(){

        if(workValue[$scope.formData.work_status] == 'Part-Time')
        {
            adder=8;
        }else {
            adder=18;
        }
        //console.log($scope.formData.work_start);

        //var index = $scope.formData.work_start.split("-");
        var indexValue = $scope.formData.work_start;

        // console.log(indexValue);
        var len = timeArray_display.length - 1;
        // console.log(len);
        var indexChecker = (parseInt(indexValue)+parseInt(adder));

        if(parseInt(indexChecker) > parseInt(len))
        {
            indexValue = (parseInt(indexChecker) - parseInt(len))-1;
            $scope.workfinish = timeArray_display[(parseInt(indexValue))];
        }
        else
        {
            $scope.workfinish = timeArray_display[(parseInt(indexValue)+parseInt(adder))];
        }

        $scope.timezoneGet();
        //$scope.formData.work_start = index[0];
        $scope.formData.work_finish = $scope.workfinish;

        // console.log(indexChecker+" - "+indexValue);

    };

    $scope.workStartChangeStaff = function(){

        // console.log(workValue[$scope.formData.work_status]);


        if(workValue[$scope.formData.work_status] == 'Part-Time')
        {
            adder=8;
        }else {
            adder=18;
        }

        //var index = $scope.formData.work_start_staff.split("-");
        var indexValue = $scope.formData.work_start_staff;
        var len = timeArray_display.length - 1;

        var indexChecker = (parseInt(indexValue)+parseInt(adder));
        if(parseInt(indexChecker) > parseInt(len))
        {
            indexValue = (parseInt(indexChecker) - parseInt(len))-1;
            $scope.workfinish_staff = timeArray_display[(parseInt(indexValue))];
        }
        else
        {
            $scope.workfinish_staff = timeArray_display[(parseInt(indexValue)+parseInt(adder))];
        }


        //$scope.formData.work_start = index[0];
        $scope.formData.work_finish_staff = $scope.workfinish_staff;

        // console.log(indexChecker+" - "+indexValue);

    };

    $scope.marginChanged = function(){

        //var isMargin = $scope.formData.margin;
        //$scope.formData.margin = isMargin;
        // console.log($scope.formData.margin);
        $scope.salaryChange();
    };


    $scope.showDetails = function(){
        $invoker.quote = null;
        $invoker.totalSA = null;
        $invoker.totalAmount = 0;
        $invoker.gstvalue = 0;
        $invoker.totalAmountValue=0;
        var API_URL = jQuery("#NJS_API_URL").val();
        if($scope.formData.quote_id){

            //Leads Currency Setting
            $http.get(API_URL+"/quote/show/?id="+$scope.formData.quote_id).success(function(response){

            }).success(function(data){
                $invoker.quote = data.data;

                $invoker.totalSA = data.data.totalSA;

                for(var i = 0 ; i< $invoker.quote.quote_details.length ; i++)
                {

                    $invoker.quote.quote_details[i].total_price = $invoker.quote.quote_details[i].total_price.replace(/,/g, '');

                    if(!$invoker.quote.quote_details[i].total_price)
                    {
                        $invoker.quote.quote_details[i].total_price = 0;
                    }
                    if(!$invoker.quote.quote_details[i].service_fee)
                    {
                        $invoker.quote.quote_details[i].service_fee = 0;
                    }
                    if(!$invoker.quote.quote_details[i].office_fee)
                    {
                        $invoker.quote.quote_details[i].office_fee = 0;
                    }
                    if(!$invoker.quote.quote_details[i].currency_adjustment)
                    {
                        $invoker.quote.quote_details[i].currency_adjustment = 0;
                    }
                    if(!$invoker.quote.quote_details[i].others)
                    {
                        $invoker.quote.quote_details[i].others = 0;
                    }


                    $invoker.quote.quote_details[i].index = i;

                    $invoker.totalAmount += (parseFloat($invoker.quote.quote_details[i].quoted_price)+parseFloat($invoker.quote.quote_details[i].service_fee)+
                    parseFloat($invoker.quote.quote_details[i].office_fee)+parseFloat($invoker.quote.quote_details[i].currency_adjustment)+
                    parseFloat($invoker.quote.quote_details[i].others));


                    if($invoker.quote.quote_details[i].work_status == "Full-Time")
                    {
                        $invoker.quote.quote_details[i].client_hr = (((parseFloat($invoker.quote.quote_details[i].quoted_price)*12)/52)/5)/8;

                    }
                    else{
                        $invoker.quote.quote_details[i].client_hr = (((parseFloat($invoker.quote.quote_details[i].quoted_price)*12)/52)/5)/4;
                    }

                }
                $invoker.gstvalue = parseFloat($invoker.totalAmount)*.10;
                $invoker.totalAmountValue = parseFloat($invoker.totalAmount)+parseFloat($invoker.gstvalue);

                // console.log($invoker.quote);
                // $scope.getLeadsCurrencySetting(data.data.client.id);

                if($invoker.quote)
                {
                    $scope.getClientSettings(data.data.client.id);
                }
            });
        }
    };



    $scope.getClientSettings = function(leads_id)
    {
        var API_URL = jQuery("#NJS_API_URL").val();
        $http.get(API_URL+"/clients/get-client-settings/?id="+leads_id).success(function(response){

            if(response.success)
            {
                $invoker.client_setting = response.result;

                if( response.result.currency )
                {

                    if(response.result.currency == "AUD")
                    {

                        $invoker.currency_sign = "$";
                    }
                    else if(response.result.currency == "GBP")
                    {
                        $invoker.currency_sign = "£";
                    }
                    else
                    {
                        $invoker.currency_sign = "$";
                    }



                    if(response.result.apply_gst == 'Y')
                    {
                        $invoker.apply_gst = "Yes";
                    }
                    else
                    {
                        $invoker.apply_gst = "No";
                    }

                    $invoker.currency = response.result.currency;
                }
            }
            else
            {

                if($invoker.quote.quote_details.length > 0)
                {
                    $invoker.client_setting=$invoker.quote.quote_details;
                    angular.forEach($invoker.quote.quote_details,function(value,key){

                        if(value.currency && value.gst_apply)
                        {
                            if(value.currency == "AUD")
                            {

                                $invoker.currency_sign = "$";
                            }
                            else if(value.currency == "GBP")
                            {
                                $invoker.currency_sign = "£";
                            }
                            else
                            {
                                $invoker.currency_sign = "$";
                            }



                            $invoker.currency = value.currency;
                            $invoker.apply_gst = value.gst_apply
                            $invoker.client_setting.currency = value.currency;
                            $invoker.client_setting.apply_gst = value.gst_apply;

                            $invoker.currentRate = $scope.currentRate;
                            $invoker.forexRate = $scope.forexRate;
                            $invoker.effective_date = $scope.effective_date;

                            return;
                        }else {
                            $invoker.client_setting.currency = 'AUD';
                            $invoker.client_setting.apply_gst = 'No';
                            $invoker.apply_gst = "No";
                            $invoker.currency = "AUD";
                            $invoker.currency_sign = "$";
                            $invoker.currentRate = $scope.currentRate;
                            $invoker.forexRate = $scope.forexRate;
                            $invoker.effective_date = $scope.effective_date;
                        }
                    });


                }
                else {
                    $invoker.client_setting = null;
                }
            }

            $modalInstance.dismiss('cancel');

        });
    };




    // $scope.getLeadsCurrencySetting = function(leads_id){
    //     var API_URL = jQuery("#BASE_API_URL").val();
    //     $invoker.leads_currency_setting=null;
    //     $http.get(API_URL+"/leads/get-client-currency-settings-by-id?id="+leads_id).success(function(response){
    //
    //     }).success(function(data){
    //
    //         $invoker.leads_currency_setting = data.client_currency_setting;
    //
    //         if($invoker.leads_currency_setting.currency_gst_apply || $invoker.leads_currency_setting.currency_gst_apply != "")
    //         {
    //             if($invoker.leads_currency_setting.currency_gst_apply == "Y" || $invoker.leads_currency_setting.currency_gst_apply == "y")
    //             {
    //                 $invoker.leads_currency_setting.currency_gst_apply = "Yes";
    //             }
    //             else
    //             {
    //                 $invoker.leads_currency_setting.currency_gst_apply = "No";
    //             }
    //
    //
    //             if($invoker.leads_currency_setting.currency_code == 'AUD')
    //             {
    //                 $invoker.leads_currency_setting.currency_sign = '$';
    //             }
    //             else if($invoker.leads_currency_setting.currency_code == 'GBP')
    //             {
    //                 $invoker.leads_currency_setting.currency_sign = '£';
    //             }
    //             else
    //             {
    //                 $invoker.leads_currency_setting.currency_sign = '$';
    //             }
    //
    //         }
    //         else {
    //             if($invoker.quote.quote_details.length > 0)
    //             {
    //                 $invoker.leads_currency_setting = $invoker.quote.quote_details;
    //                 angular.forEach($invoker.quote.quote_details,function(value,key){
    //                     if(value.currency && value.gst_apply)
    //                     {
    //
    //
    //                         $invoker.leads_currency_setting.currency_gst_apply = value.gst_apply
    //                         $invoker.leads_currency_setting.currency_code = value.currency;
    //
    //                         if(value.currency == 'AUD')
    //                         {
    //                             $invoker.leads_currency_setting.currency_sign = '$';
    //                         }
    //                         else if(value.currency == 'GBP')
    //                         {
    //                             $invoker.leads_currency_setting.currency_sign = '£';
    //                         }
    //                         else
    //                         {
    //                             $invoker.leads_currency_setting.currency_sign = '$';
    //                         }
    //
    //                         return;
    //                     }
    //                 });
    //             }
    //         }
    //         $scope.formData.apply_gst = $invoker.leads_currency_setting.currency_gst_apply;
    //         $scope.formData.currency = $invoker.leads_currency_setting.currency_code;
    //         // console.log($scope.formData.apply_gst);
    //         // console.log($scope.formData.currency);
    //         $modalInstance.dismiss('cancel');
    //     });
    // };



    $scope.formatDecimal = function(decimal)
    {

        return parseFloat(decimal).toFixed(2);
    };


    $scope.checkStaffPrice = function(){

        var formData = {};
        var price="",priceVal="";
        formData.userid = $scope.formData.userid;

        $http({
            method: 'POST',
            url:API_URL+"/quote/get-staff-salary",
            data: formData
        }).success(function(response) {
            console.log(response);

            if(response.success){

                if(response.data || typeof response.data != "undefined")
                {
                    price = response.data.code.split("-");

                    if(price[2])
                    {
                        priceVal = price[2].split(".");
                    }
                    else
                    {
                        formData.partTime = 1;
                        $http({
                            method: 'POST',
                            url:API_URL+"/quote/get-staff-salary",
                            data: formData
                        }).success(function(response) {
                            price = response.data.code.split("-");
                            priceVal = price[2].split(".");


                        }).error(function(response){
                            //$scope.loading5 = false;
                            alert("Failed to get staff price.");
                        });

                    }


                    $scope.formData.salary = priceVal[0].replace(/,/g, '');
                    $scope.salaryChange();
                }else
                {
                    console.log("staff salary not found!");
                }


            }else{

            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("Failed to get staff price.");
        });

    };



    $scope.timezoneGet = function()
    {
        var API_URL = jQuery("#BASE_API_URL").val();
        var status = (workValue[$scope.formData.work_status] ? workValue[$scope.formData.work_status] : "");

        var formDataVal={};
        var val = timeArray_value[$scope.formData.work_start];
        //console.log(val);
        formDataVal.staff_timezone = $scope.formData.staff_timezone;
        formDataVal.work_start = "08:00:00";
        formDataVal.work_status = status;
        formDataVal.client_timezone = $scope.formData.client_timezone;
        formDataVal.client_start_work_hour = val;
        formDataVal.mode = "client";


        $http({
            method: 'GET',
            url:API_URL+"/utilities/configure-time/?staff_timezone="+formDataVal.staff_timezone+"&work_start=08:00:00&work_status="+formDataVal.work_status+"&client_timezone="+formDataVal.client_timezone+"&client_start_work_hour="+formDataVal.client_start_work_hour+"&mode=client"
        }).success(function(response) {
            // console.log(response);

            if(response.success){

                var val="";
                for( var i = 0 ; i < $scope.timeArray.length ; i++)
                {
                    if($scope.timeArray[i].value == response.result.work_start)
                    {
                        $scope.formData.work_start_staff = $scope.timeArray[i].count;

                        break;
                    }
                }
                $scope.workStartChangeStaff();
            }else{

            }


        }).error(function(response){
            //$scope.loading5 = false;
            console.log("error getting staff timezone");
        });


    };





    $scope.othersChange = function()
    {
        if($scope.formData.others_amount == "")
        {
            $scope.formData.others_amount = null;
            $scope.formData.others_description = null;
        }
    }



    $scope.checkUpdate = function()
    {
        var API_URL = jQuery("#NJS_API_URL").val();
        var changes ="";

        for(var i = 1; i <= 27 ; i++)
        {
            if(!angular.isUndefined(changeVar["change"+i]))
            {

                changes+= changeVar["change"+i]+"<br>";
            }

        }
        // changes.replace(/,\s*$/, "");
        $scope.formData.changes = changes;
        $scope.formData.adminID = jQuery("#ADMIN_ID").val();

        $invoker.data_isUpdate = 1;
        // console.log($scope.formData);
        // console.log(changes);exit();
        $http({
            method: 'POST',
            url:API_URL+"/quote/update-quote",
            data: $scope.formData
        }).success(function(response) {


            // console.log(response);
            //exit();
            $scope.loading5 = false;

            if(response.success){
                toaster.pop({
                    type: 'success',
                    title: 'Quote',
                    body: "Quote Details Updated",
                    showCloseButton: true,
                });
                $invoker.getLatest($invoker);
                $invoker.leads_id = $invoker.quote.client.id;
                $invoker.getLatestSolr($invoker);
                $scope.showDetails();
                getHistory($invoker, $modalInstance, $http, $invoker,toaster);

            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Quote',
                    body: response.error,
                    showCloseButton: true,
                });
            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem updating quote. Please try again later.");
        });

    }



//console.log($invoker.quoteIndex);
    if($invoker.quoteIndex != -1)
    {
        $scope.isUpdate = $invoker.quoteIndex;


        $scope.formData.created_by = $invoker.admin_id;
        $scope.formData.quote_details_id = $invoker.quote.quote_details[$invoker.quoteIndex].id;
        $scope.formData.tracking_code = $invoker.quote.quote_details[$invoker.quoteIndex].tracking_code+"_"+$invoker.quote.quote_details[$invoker.quoteIndex].work_position;
        $scope.formData.userid = $invoker.quote.quote_details[$invoker.quoteIndex].userid;
        $scope.getJobtitle();
        $scope.formData.work_status = $invoker.quote.quote_details[$invoker.quoteIndex].work_status_index;
        // console.log($scope.formData.work_status);
        if($invoker.quote.quote_details[$invoker.quoteIndex].selected_start_work !== 'NaN-NaN-NaN')
        {
            $scope.date = $invoker.quote.quote_details[$invoker.quoteIndex].selected_start_work;
        }

        if($invoker.quote.quote_details[$invoker.quoteIndex].work_status_index == 6)
        {
            $scope.formData.specialArrangement = $invoker.quote.quote_details[$invoker.quoteIndex].special_arrangement_description;
            $scope.formData.work_status_special = $invoker.quote.quote_details[$invoker.quoteIndex].special_arrangement_work_status;
            $scope.formData.specialArrangement_workingDays = $invoker.quote.quote_details[$invoker.quoteIndex].special_arrangement_working_days;
            $scope.formData.specialArrangement_requiredHours = $invoker.quote.quote_details[$invoker.quoteIndex].special_arrangement_working_hrs;
            $scope.formData.lanceApproval = $invoker.quote.quote_details[$invoker.quoteIndex].special_arrangement_approval;
        }
        $scope.formData.client_timezone = $invoker.quote.quote_details[$invoker.quoteIndex].client_timezone;
        $scope.formData.work_start = timeArray_display.indexOf($invoker.quote.quote_details[$invoker.quoteIndex].client_work_start);
        $scope.formData.work_finish = $invoker.quote.quote_details[$invoker.quoteIndex].client_work_finish;
        //
        $scope.workStartChange();
        //
        $scope.formData.staff_timezone = $invoker.quote.quote_details[$invoker.quoteIndex].staff_timezone;
        $scope.formData.margin = $invoker.quote.quote_details[$invoker.quoteIndex].margin;
        $scope.formData.salary = $invoker.quote.quote_details[$invoker.quoteIndex].salary;
        $scope.formData.currency_adjustment = $invoker.quote.quote_details[$invoker.quoteIndex].currency_adjustment;
        //
        // $scope.formData.work_start_staff = timeArray_display.indexOf($invoker.quote.quote_details[$invoker.quoteIndex].staff_work_start);
        // $scope.formData.work_finish_staff = $invoker.quote.quote_details[$invoker.quoteIndex].staff_work_finish;
        $scope.formData.quoted_price = $invoker.quote.quote_details[$invoker.quoteIndex].quoted_price;
        if($invoker.quote.quote_details[$invoker.quoteIndex].office_fee || $invoker.quote.quote_details[$invoker.quoteIndex].office_fee > 0)
        {
            $scope.formData.office_fee = $invoker.quote.quote_details[$invoker.quoteIndex].office_fee;
            office_fee = $invoker.quote.quote_details[$invoker.quoteIndex].office_fee;
        }
        else
        {
            office_fee = 0;
        }

        if($invoker.quote.quote_details[$invoker.quoteIndex].service_fee || $invoker.quote.quote_details[$invoker.quoteIndex].service_fee > 0)
        {
            $scope.formData.service_fee = $invoker.quote.quote_details[$invoker.quoteIndex].service_fee;
            service_fee = $invoker.quote.quote_details[$invoker.quoteIndex].service_fee;
        }
        else
        {
            service_fee = 0;
        }

        if($invoker.quote.quote_details[$invoker.quoteIndex].others_description || $invoker.quote.quote_details[$invoker.quoteIndex].others_description != '')
        {
            $scope.formData.others_description = $invoker.quote.quote_details[$invoker.quoteIndex].others_description;
            $scope.formData.others_amount =($invoker.quote.quote_details[$invoker.quoteIndex].others ? $invoker.quote.quote_details[$invoker.quoteIndex].others : null);
            others = ($invoker.quote.quote_details[$invoker.quoteIndex].others ? $invoker.quote.quote_details[$invoker.quoteIndex].others : 0);
        }
        else
        {
            others = 0;
        }



        $scope.salaryChange();


        if(!$scope.currencySettings || !$scope.currentRate)
        {
            $scope.formData.currency_adjustment = $invoker.quote.quote_details[$invoker.quoteIndex].currency_adjustment;
            // console.log("walang laman CA");
        }

        Temp = $scope.formData ;

        // console.log($scope.formData);
    }
//console.log($invoker.quote.quote_details[$invoker.quoteIndex]);


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



}

function SendQuoteModalInstanceCtrl($scope, $modalInstance, $http, $invoker,toaster)
{
    var BASE_URL = jQuery("#BASE_URL").val();
    $scope.formData = {};
    $scope.quote = $invoker.quote;
    $scope.formData.quote_id = $invoker.quote.id;
    $scope.formData.client_name = $invoker.quote.client.fname;
    $scope.formData.client_email = $invoker.quote.client.email;
    $scope.formData.admin_name = $invoker.quote.quoted_by.admin_fname;
    $scope.formData.email = $invoker.quote.quoted_by.admin_email;
    $scope.formData.link = BASE_URL+"/portal/sc_v2/pro-forma.php#/files/quote/"+$invoker.quote.ran;

    $scope.formData.To = $invoker.quote.client.email;
    $scope.formData.body ="Hi "+$scope.quote.client.fname+",\n"
        +"\n\n\n\n\n"
        +"Quote Link: "+$scope.formData.link;


    $scope.SendMail = function()
    {

        // console.log($scope.formData);
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


                $modalInstance.dismiss('cancel');
                $scope.Posted();
            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Sending of email',
                    body: response.error,
                    showCloseButton: true,
                });

            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem sending email to client. Please try again later.");
        });

    }

    $scope.close_quote_details = function () {
        $modalInstance.dismiss('cancel');
    };






}

function timeTo12HrFormat(time)
{

    // Take a time in 24 hour format and format it in 12 hour format
    var time_part_array = time.split(":");
    var ampm = 'AM';

    if (time_part_array[0] >= 12) {
        ampm = 'PM';
    }

    if (time_part_array[0] > 12) {
        time_part_array[0] = time_part_array[0] - 12;
    }

    formatted_time = time_part_array[0] + ':' + time_part_array[1] + ':' + time_part_array[2] + ' ' + ampm;

    return formatted_time;
}

function getDecimalFunc(value)
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
}



rs_module.controller('QuoteDetailsController',["$scope", "$stateParams","$http", "$modal", "toaster", QuoteDetailsController]);
rs_module.controller('QuoteDetailsModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker",QuoteDetailsModalInstanceCtrl]);
rs_module.controller('SendQuoteModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker",SendQuoteModalInstanceCtrl]);
