

var email_status = ["Opened","Not Opened", "Bounce", "Invalid", "Block", "Spam",  "All"];

var API_URL = jQuery("#NJS_API_URL").val();
var ADMIN_NAME = jQuery("#ADMIN_NAME").val();
function InvoiceReportingController($scope, $stateParams, $http, $modal, $location,toaster){



    $scope.data_report = null;
    $scope.limitSize = 50;
    $scope.formData = {};
    $scope.query = {};
    $scope.queryBy = '$';

    $scope.search = {
        searchQuery: ""
    };

    $scope.initForm = function(){
        populateEmailStatus($scope);

        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        //var lastDay = new Date(y, m + 1, 0);


        $scope.formData.daterange = {
            startDate:moment(firstDay),
            endDate:moment()
        };
        populateTable($scope,$http);
    };



    $scope.initForm();

    //console.log("Invoice Email Reporting Page");




    $scope.openModalAddComments = function(index){

        $scope.indexData = index;

        var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-reporting/modal_add_comments.html',
            controller: AddCommentsModal,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{

                $invoker:function(){

                    return $scope;
                }

            }
        });


    };



    $scope.openModalHistory = function(_order_id){

        $scope.order_id = _order_id;

        var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-reporting/modal_invoice_history.html',
            controller: HistoryInvoice,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{

                $invoker:function(){

                    return $scope;
                }

            }
        });


    };

    $scope.formatDate = function(unixtime) {
        var date = new Date(Date.parse(unixtime));
        var n =  date.toDateString();
        // return n;

        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        if(n == "Invalid Date"){
            return null;
        }
        return date.getFullYear() + "-" + (parseInt(date.getMonth())+1) + "-" +  date.getDate();

    };

    $scope.formatDateTime = function(unixtime) {
        var date = new Date(Date.parse(unixtime));
        var n =  date.toDateString();
        // return n;

        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        if(n == "Invalid Date"){
            return null;
        }
        return date.getFullYear() + "-" + (parseInt(date.getMonth())+1) + "-" +  date.getDate() + " " + strTime;

    };




    $scope.loadMore = function()
    {

        if($scope.data_report.limit < $scope.data_report.length)
        {
            $scope.data_report.limit = $scope.data_report.limit + $scope.limitSize;
        }

    }

    $scope.loadLess = function()
    {

        if($scope.data_report.limit > $scope.data_report.length)
        {
            $scope.data_report.limit = $scope.limitSize;
        }

    }


    $scope.$watch("query.$",function(newValue,oldValue){


    });



    //filters
    $scope.searchData = function()
    {
        searchTable($scope,$http);
    }



    $scope.refresh = function()
    {
        $scope.loading7 = true;
        $scope.query.$ = "";
        $scope.formData.emailStatus = "";
        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        //var lastDay = new Date(y, m + 1, 0);


        $scope.formData.daterange = {
            startDate:moment(firstDay),
            endDate:moment()
        };
        $scope.search.searchQuery = "";
        $scope.sort = ["email_status", "-client_docs.invoice_amount"];
        populateTable($scope,$http);


    }



    //sort

    $scope.sort = {
        column: 'client_docs.invoice_amount',
        descending: true
    };

    $scope.sort = ["email_status", "-client_docs.invoice_amount"];

    $scope.sortFunc = function(column)
    {

        var current_index = null;

        $scope.sort.forEach(function (value, index) {

            if (value.search(column) !== -1){
                current_index = index;
            }
        });


        if(current_index != null){
            var first_char = $scope.sort[current_index].charAt(0);

            if(first_char == "-"){
                $scope.sort[current_index] = column;
            } else{
                $scope.sort[current_index] = "-" + column;
            }
        } else{
            $scope.sort = [];
            $scope.sort.push(column);
        }

    }

    $scope.getBGColor = function(data){
        var str_class = "";

        if(typeof data.suppression_type != "undefined"){
            str_class = "danger-red";
        }
        if(data.email_status == "Opened"){
            str_class = "info";
        }

        //console.log(str_class);
        return str_class;
    }


    $scope.getTooltipText = function(data){
        //invalid
        var str = "Email delivered but not opened - call client";

        if(data.suppression_type == "bounces"){
            str = "Email bounced - email address is wrong - check with client";
        } else if(data.suppression_type == "blocks"){
            str = "Email is being blocked - ask client for alternative email address";
        } else if(data.suppression_type == "spam_report"){
            str = "Email is blocked by spam filter - check with client";
        } else if(data.suppression_type == "invalid_emails"){
            str = "Something wrong with the email address - check with client";
        }

        return str;

    }

}



function AddCommentsModal($scope, $modalInstance, $http, $invoker,toaster) {


    var index = $invoker.indexData

    $scope.reportData = $invoker.data_report[index];
    //console.log($scope.reportData);

    $scope.formData = {};

    $scope.formData.admin_name = ADMIN_NAME;
    $scope.formData.mongo_id = $scope.reportData.client_docs._id;

    $scope.comments = [];



    //for pagination
    $scope.currentPage = 1,
    $scope.numberPage = 10,
    $scope.maxSize = 5;

    $scope.initForm = function()
    {

        if(typeof $scope.reportData.client_docs.comments != "undefined")
        {
            for (var i = $scope.reportData.client_docs.comments.length - 1; i >= 0; i--) {


                item = $scope.reportData.client_docs.comments[i];



                $scope.comments.push({

                    comments:item.comment,
                    admin:item.name,
                    date:item.date
                });


                if (!item) {
                    $scope.reportData.client_docs.comments.splice(i, 1);
                }


            }
        }
        else
        {
            $scope.comments = [];
        }
    };


    $scope.addNotes = function()
    {

        $scope.loading5 = true;

        $http({
            method: 'POST',
            url:API_URL+"/invoice/add-invoice-notes",
            data:$scope.formData
        }).success(function(response) {
            $scope.loading5 = false;
            //console.log(response);

            if(response.success)
            {
                $scope.comments = [];
                for (var i = response.comments.length - 1; i >= 0; i--) {


                    item = response.comments[i];

                        $scope.comments.push({

                            comments:item.comment,
                            admin:item.name,
                            date:item.date
                        });

                    if (!item) {
                        response.comments.splice(i, 1);
                    }


                }



                toaster.pop({
                    type: 'success',
                    title: 'Note(s) Successfully Added!',
                    body: response.msg,
                    showCloseButton: true,
                });

                $invoker.data_report[index].client_docs.comments.length += 1;
                populateTable($invoker,$http);


                $scope.formData.comments = "";

            }
            else
            {
                $scope.loading5 = false;
                toaster.pop({
                    type: 'error',
                    title: 'Adding of note(s) failed.',
                    body: response.msg,
                    showCloseButton: true,
                });

                $modalInstance.dismiss('cancel');
            }

        });

    }



    $scope.close_add_comments = function () {
        $modalInstance.dismiss('cancel');
    };


    $scope.initForm();





    $scope.formatDate = function(unixtime) {
        return $invoker.formatDate(unixtime);
    };

    $scope.formatDateTime = function(unixtime) {
        return $invoker.formatDateTime(unixtime);
    };

}




function HistoryInvoice($scope, $modalInstance, $http, $invoker,toaster) {


    $scope.orderId = $invoker.order_id;

    var url = API_URL+"/invoice/get-invoice-details/?order_id="+$scope.orderId;



    $scope.initForm = function()
    {
        $http.get(url).success(function(response){
            if(response.success){
                $scope.history = response.result.history;
            }
        });
    };


    $scope.close_history = function () {
        $modalInstance.dismiss('cancel');
    };



    $scope.initForm();

}



function populateEmailStatus($scope)
{
    $scope.emailStatus = [];

    for(var i = 0 ; i<email_status.length ; i++)
    {
        $scope.emailStatus.push({

            value:email_status[i],
            display:email_status[i],
            count:i
        });
    }

}


function populateTable($scope,$http)
{

    $http({
        method: 'POST',
        url:API_URL+"/invoice/get-invoice-email-report",
        data:{
            daterange: $scope.formData.daterange
        }
    }).success(function(response) {

        if(response.success)
        {
            $scope.data_report = response.data_report;

            angular.forEach(response.data_report,function(value,key){

                // $scope.dataTest.data.push({
                //
                //     added_by:value.added_by,
                //     age_in_days:value.age_in_days,
                //     client_docs:{ _id :value.client_docs[0]._id,
                //         client_id : value.client_docs[0].client_id,
                //         client_email : value.client_docs[0].client_email,
                //         invoice_amount : value.client_docs[0].total_amount,
                //         due_date :  value.client_docs[0].pay_before_date,
                //         currency : value.client_docs[0].currency,
                //         comments : value.client_docs[0].comments},
                //     client_fname:value.client_fname,
                //     client_lname:value.client_lname,
                //     client_mobile:value.client_mobile,
                //     date_clicked:value.date_clicked,
                //     date_delivered:value.date_delivered,
                //     date_opened:value.date_opened,
                //     date_updated:value.date_updated,
                //     days_before_suspension:value.days_before_suspension,
                //     email_status:value.email_status,
                //     invoice_date_created:value.invoice_date_created,
                //     order_id:value.order_id,
                //     index:key
                //
                //
                // });

                //
                var client_doc = {

                    _id :value.client_docs[0]._id,
                    client_id : value.client_docs[0].client_id,
                    client_email : value.client_docs[0].client_email,
                    invoice_amount : value.client_docs[0].total_amount,
                    due_date :  value.client_docs[0].pay_before_date,
                    currency : value.client_docs[0].currency,
                    comments : value.client_docs[0].comments
                };

                value.client_docs = client_doc;
                value.index = key;
            });

            //console.log( $scope.data_report);
            $scope.data_report.limit = $scope.limitSize;
            $scope.loading7 = false;
        }
        else
        {
            $scope.data_report = null;
            alert(response.msg);
            $scope.loading7 = false;
        }

    }).error(function(response){
        console.log(response);
        $scope.loading7 = false;

    });

}


function searchTable($scope,$http)
{

    var formData = {};

    if($scope.formData.emailStatus != "All"){
        formData.filter = $scope.formData.emailStatus
    }

    formData.q = $scope.search.searchQuery;
    // if(!formData.q || formData.q == ""){
    // }
    formData.daterange = $scope.formData.daterange;


    $scope.loading6 = true;

    $http({
        method: 'POST',
        url:API_URL+"/invoice/get-invoice-email-report",
        data:formData
    }).success(function(response) {

        if(response.success)
        {

            $scope.loading6 = false;
            $scope.data_report = response.data_report;


            angular.forEach(response.data_report,function(value,key){

                //
                var client_doc = {

                    _id :value.client_docs[0]._id,
                    client_id : value.client_docs[0].client_id,
                    client_email : value.client_docs[0].client_email,
                    invoice_amount : value.client_docs[0].total_amount,
                    due_date :  value.client_docs[0].pay_before_date,
                    currency : value.client_docs[0].currency,
                    comments : value.client_docs[0].comments
                };

                value.client_docs = client_doc;
                value.index = key;
            });

            //console.log($scope.data_report);
            $scope.data_report.limit = $scope.limitSize;


        }
        else
        {
            $scope.loading6 = false;
            $scope.data_report = null;
            alert(response.msg);
        }

    }).error(function(response){
        $scope.loading6 = false;
        console.log(response);
    });



}


rs_module.controller('InvoiceReportingController',["$scope", "$stateParams","$http", "$modal", "$location",  "toaster", InvoiceReportingController]);
rs_module.controller('AddCommentsModal',["$scope", "$modalInstance", "$http", "$invoker",AddCommentsModal]);
rs_module.controller('HistoryInvoice',["$scope", "$modalInstance", "$http", "$invoker",HistoryInvoice]);