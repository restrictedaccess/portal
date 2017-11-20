var API_URL = jQuery("#NJS_API_URL").val();
var ADMIN_NAME = jQuery("#ADMIN_NAME").val();
var ADMIN_ID = jQuery("#ADMIN_ID").val();

var Invoice_Type = ["Bonus", "Placement Fee", "Commission",
    "Reimbursement", "Gifts", "Office Fee",
    "Service Fee", "Training Room Fee", "Currency Adjustment",
    "Regular Rostered Hours", "Adjusted Credit Memo", "Adjusted Over Time Work",
    "Over Payment", "Final Invoice", "Others", "Referral Program"];

var Invoice_Status = ["New", "Paid", "Cancelled"];


function InvoiceSummaryReportingController($scope, $stateParams, $http, $modal, $location, toaster, SweetAlert) {

    $scope.dataSummary = null;//1st tab
    $scope.dataSummary2 = null;//2nd tab
    $scope.dataSummary3 = null;//3rd tab
    $scope.dataSummary4 = null;//4th tab
    $scope.dataSummary5 = null;//5th tab
    $scope.dataSummary6 = null;//6th tab
    $scope.tempData5 = [];
    $scope.flagTab2InitialLoad = false;

    $scope.tab1usd = 0;
    $scope.tab1aud = 0;
    $scope.tab1gbp = 0;

    $scope.tab2usd = 0;
    $scope.tab2aud = 0;
    $scope.tab2gbp = 0;

    $scope.tab3usd = 0;
    $scope.tab3aud = 0;
    $scope.tab3gbp = 0;

    $scope.tab4usd = 0;
    $scope.tab4aud = 0;
    $scope.tab4gbp = 0;

    $scope.tab5usd = 0;
    $scope.tab5aud = 0;
    $scope.tab5gbp = 0;

    $scope.tab6usd = 0;
    $scope.tab6aud = 0;
    $scope.tab6gbp = 0;

    $scope.pagination = {currentPage: 1, maxSize: 10};

    $scope.admin_id = ADMIN_ID;

    $scope.limitSize = 40;
    $scope.tabs = 1;


    $scope.query = {};
    $scope.queryBy = '$';


    $scope.query2 = {};
    $scope.queryBy2 = '$';

    $scope.TotalNumberofDocs1 = 0;//mainly for tab1
    $scope.pageNumber1 = 1;//for tab 1 pagination

    $scope.TotalNumberofDocs = 0;//mainly for tab2
    $scope.pageNumber = 1;//for tab 2 pagination

    $scope.TotalNumberofDocs3 = 0;//mainly for tab3
    $scope.pageNumber3 = 1;//for tab 3 pagination

    $scope.TotalNumberofDocs4 = 0;//mainly for tab4
    $scope.pageNumber4 = 1;//for tab 4 pagination

    $scope.TotalNumberofDocs5 = 0;//mainly for tab5
    $scope.pageNumber5 = 1;//for tab 5 pagination

    $scope.TotalNumberofDocs6 = 0;//mainly for tab6
    $scope.pageNumber6 = 1;//for tab 6 pagination

    $scope.formData = {};

    $scope.formData.exclude = true;//tab 1
    $scope.formData.searchBox = "";//tab 1

    $scope.formData.remarks = [];

    $scope.formData.searchBox2 = "";//tab 2
    $scope.formData.active = true;//tab 2
    $scope.formData.inactive = false;//tab 2

    // Prepaid Client Checkbox
    $scope.formData.awaitingInvoiceCheckbox = false;
    $scope.formData.paidInvoiceCheckbox = false;
    $scope.formData.agedRecievablesCheckbox = false;
    $scope.formData.firstMonthCheckbox = false;
    $scope.formData.finalInvoiceCheckbox = false;
    $scope.formData.prepaidReadyReleaseCheckbox = false;

    // View Only This Month
    $scope.formData.awaitingInvoiceViewThisMonthCheckbox = true;
    $scope.formData.paidInvoiceThisMonthCheckbox = true;
    $scope.formData.agedRecievablesThisMonthCheckbox = false;
    $scope.formData.firstMonthThisMonthCheckbox = true;
    $scope.formData.finalInvoiceThisMonthCheckbox = false;
    $scope.formData.readyReleaseThisMonthCheckbox = true;

    // Monthly Client
    $scope.formData.awaitingInvoiceViewMonthlyClientCheckbox = false;
    $scope.formData.paidInvoiceMonthlyClientCheckbox = false;
    $scope.formData.agedRecievablesMonthlyClientCheckbox = false;
    $scope.formData.firstMonthMonthlyClientCheckbox = false;
    $scope.formData.finalInvoiceMonthlyClientCheckbox = false;
    $scope.formData.readyReleaseMonthlyClientCheckbox = false;


    $scope.exclude_count = 0;

    $scope.isMonthlyClient = true;

    //for tab1

    $scope.invoice_data_summary_report.selected_date_range_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_due_date = {startDate: null, endDate: null};

    //for tab2
    $scope.invoice_data_summary_report.selected_date_range_2_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_2_due_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_2_last_updated = {startDate: null, endDate: null};


    $scope.invtype = null;
    $scope.invstat = null;


    $scope.invoice_data_summary_report.optionsDateRange = {
        autoApply: true,
        locale: {
            format: "M/D/YYYY"
        },
        dateLimit: {
            "days": 90
        }
    };

    $scope.initForm = function () {
        $scope.report_data = null;
        syncLastDateUpdated($scope, $http);
        getNumberDocs($scope, $http);
        populateDropdown($scope, $http);
    };

    $scope.initForm();

    //modal for notes/comments

    $scope.openModalForComments = function (index) {
        $scope.indexDataReport = index;

        var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-summary-reporting/modal-reporting/modal-reporting-add-notes.html',
            controller: AddNotesModal,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve: {

                $invoker: function () {

                    return $scope;
                }

            }
        });

    };

    //modal for ready for release notes

    $scope.openModalForNotesReadyForRelease = function (item) {
        $scope.readyForReleaseDataItem = item;
        var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-summary-reporting/modal-reporting/modal-reporting-add-notes-ready-for-release.html',
            controller: AddNotesReadyForReleaseModal,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve: {
                $invoker: function () {
                    return $scope;
                }
            }
        });

    };


    //searching

    $scope.checkIfChecked = function(){
        var filters = [];
        var check = false;

        if ($scope.tabs == 1) {
            if($scope.formData.awaitingInvoiceViewThisMonthCheckbox && $scope.invoice_data_summary_report.selected_date_range_order_date.startDate != null && $scope.invoice_data_summary_report.selected_date_range_order_date.endDate != null){
                check = true;
            }
        }
        else if ($scope.tabs == 2) {
            if($scope.formData.agedRecievablesThisMonthCheckbox && $scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate != null && $scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate != null){
                check = true;
            }
        }
        else if ($scope.tabs == 3 ){
            if($scope.formData.readyReleaseThisMonthCheckbox && $scope.invoice_data_summary_report.selected_date_range_order_date.startDate != null && $scope.invoice_data_summary_report.selected_date_range_order_date.endDate != null){
                check = true;
            }

        } else if ($scope.tabs == 4 ){
            if($scope.formData.firstMonthThisMonthCheckbox && $scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate != null && $scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate != null){
                check = true;
            }

        } else if ($scope.tabs == 5 ){
            if($scope.formData.finalInvoiceThisMonthCheckbox && $scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate != null && $scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate != null){
                check = true;
            }

        } else if ($scope.tabs == 6 ){
            filters.push($scope.formData.paidInvoiceThisMonthCheckbox);
            if($scope.formData.paidInvoiceThisMonthCheckbox && $scope.invoice_data_summary_report.selected_date_range_order_date.startDate != null && $scope.invoice_data_summary_report.selected_date_range_order_date.endDate != null){
                check = true;
            }
        }
        
        return check;

    }

    $scope.globalSearchBtn = function(){
        if($scope.checkIfChecked()){
            alert("Please uncheck the checkbox filters first!");
        } else {
            $scope.searchTab();
        }
    }

    $scope.searchTab = function () {
        if ($scope.tabs == 1) {
            $scope.tab1usd = 0;
            $scope.tab1aud = 0;
            $scope.tab1gbp = 0;
            searchTab1($scope, $http);
        }
        else if ($scope.tabs == 2) {
            $scope.tab2usd = 0;
            $scope.tab2aud = 0;
            $scope.tab2gbp = 0;
            searchTab2($scope, $http);
        }
        else if ($scope.tabs == 3 ){
            $scope.tab3usd = 0;
            $scope.tab3aud = 0;
            $scope.tab3gbp = 0;
            searchTab3($scope, $http);
        } else if ($scope.tabs == 4 ){
            $scope.tab4usd = 0;
            $scope.tab4aud = 0;
            $scope.tab4gbp = 0;
            searchTab4($scope, $http);
        } else if ($scope.tabs == 5 ){
            $scope.tab5usd = 0;
            $scope.tab5aud = 0;
            $scope.tab5gbp = 0;
            searchTab5($scope, $http);
        } else if ($scope.tabs == 6 ){
            $scope.tab6usd = 0;
            $scope.tab6aud = 0;
            $scope.tab6gbp = 0;
            searchTab6($scope, $http);
        }
    }

    // View only this month checkbox
    $scope.view_this_month = function(){
        //getNumberDocs($scope, $http);
        $scope.searchTab();
    };
    // Prepaid client checkbox
    $scope.prepaid_clients = function () {
        //getNumberDocs($scope, $http);
        $scope.searchTab();
    };

    // Monthly client checkbox
    $scope.exclude_client =  function(){
        //getNumberDocs($scope, $http);
        $scope.searchTab();
    };
    // $scope.exclude_client = function () {
    //
    //
    //     if($scope.tabs == 1){
    //         if ($scope.formData.exclude) {
    //             $scope.exclude_count = 0;
    //             $scope.query.$ = '-30';
    //
    //             console.log($scope.dataSummary.length + " Length");
    //
    //             for (var j = 0; j < $scope.dataSummary.length; j++) {
    //                 item = $scope.dataSummary[j];
    //                 item = $scope.dataSummary[j];
    //
    //                 if (item.days_before_suspension == -30) {
    //                     $scope.exclude_count = $scope.exclude_count + 1;
    //                 }
    //             }
    //             console.log($scope.exclude_count);
    //             if ($scope.TotalNumberofDocs1 > 0) {
    //                 $scope.TotalNumberofDocs1 = $scope.TotalNumberofDocs1 - $scope.exclude_count;
    //             }
    //
    //
    //         }
    //         else {
    //             $scope.query.$ = "";
    //
    //             if ($scope.TotalNumberofDocs1 > 0) {
    //                 $scope.TotalNumberofDocs1 = $scope.TotalNumberofDocs1 + $scope.exclude_count;
    //             }
    //
    //         }
    //     } else if($scope.tabs == 2){
    //         if ($scope.formData.exclude) {
    //             $scope.exclude_count = 0;
    //             $scope.query.$ = '-30';
    //
    //             console.log($scope.dataSummary2.length + " Length");
    //
    //             for (var j = 0; j < $scope.dataSummary2.length; j++) {
    //                 item = $scope.dataSummary2[j];
    //
    //                 if (item.days_before_suspension == -30) {
    //                     $scope.exclude_count = $scope.exclude_count + 1;
    //                 }
    //             }
    //             console.log($scope.exclude_count);
    //             if ($scope.TotalNumberofDocs2 > 0) {
    //                 $scope.TotalNumberofDocs2 = $scope.TotalNumberofDocs2 - $scope.exclude_count;
    //             }
    //
    //
    //         }
    //         else {
    //             $scope.query.$ = "";
    //
    //             if ($scope.TotalNumberofDocs2 > 0) {
    //                 $scope.TotalNumberofDocs2 = $scope.TotalNumberofDocs2 + $scope.exclude_count;
    //             }
    //
    //         }
    //     } else if($scope.tabs == 3){
    //         if ($scope.formData.exclude) {
    //             console.log("MONTHLY CLIENT");
    //             console.log("MONTHLY CLIENT");
    //             console.log("MONTHLY CLIENT");
    //             console.log($scope.formData.exclude);
    //             $scope.exclude_count = 0;
    //             $scope.query.$ = '-30';
    //
    //             console.log($scope.dataSummary3.length + " Length");
    //
    //             for (var j = 0; j < $scope.dataSummary3.length; j++) {
    //                 item = $scope.dataSummary3[j];
    //
    //                 if (item.days_before_suspension == -30) {
    //                     $scope.exclude_count = $scope.exclude_count + 1;
    //                 }
    //             }
    //             console.log($scope.exclude_count);
    //             if ($scope.TotalNumberofDocs3 > 0) {
    //                 $scope.TotalNumberofDocs3 = $scope.TotalNumberofDocs3 - $scope.exclude_count;
    //             }
    //
    //
    //         }
    //         else {
    //             $scope.query.$ = "";
    //
    //             if ($scope.TotalNumberofDocs3 > 0) {
    //                 $scope.TotalNumberofDocs3 = $scope.TotalNumberofDocs3 + $scope.exclude_count;
    //             }
    //
    //         }
    //     } else if($scope.tabs == 4){
    //         if ($scope.formData.exclude) {
    //             $scope.exclude_count = 0;
    //             $scope.query.$ = '-30';
    //
    //             console.log($scope.dataSummary4.length + " Length");
    //
    //             for (var j = 0; j < $scope.dataSummary4.length; j++) {
    //                 item = $scope.dataSummary4[j];
    //
    //                 if (item.days_before_suspension == -30) {
    //                     $scope.exclude_count = $scope.exclude_count + 1;
    //                 }
    //             }
    //             console.log($scope.exclude_count);
    //             if ($scope.TotalNumberofDocs4 > 0) {
    //                 $scope.TotalNumberofDocs4 = $scope.TotalNumberofDocs4 - $scope.exclude_count;
    //             }
    //
    //
    //         }
    //         else {
    //             $scope.query.$ = "";
    //
    //             if ($scope.TotalNumberofDocs4 > 0) {
    //                 $scope.TotalNumberofDocs4 = $scope.TotalNumberofDocs4 + $scope.exclude_count;
    //             }
    //
    //         }
    //     } else if($scope.tabs == 5){
    //         if ($scope.formData.exclude) {
    //             $scope.exclude_count = 0;
    //             $scope.query.$ = '-30';
    //
    //             console.log($scope.dataSummary5.length + " Length");
    //
    //             for (var j = 0; j < $scope.dataSummary5.length; j++) {
    //                 item = $scope.dataSummary5[j];
    //
    //                 if (item.days_before_suspension == -30) {
    //                     $scope.exclude_count = $scope.exclude_count + 1;
    //                 }
    //             }
    //             console.log($scope.exclude_count);
    //             if ($scope.TotalNumberofDocs5 > 0) {
    //                 $scope.TotalNumberofDocs5 = $scope.TotalNumberofDocs5 - $scope.exclude_count;
    //             }
    //
    //
    //         }
    //         else {
    //             $scope.query.$ = "";
    //
    //             if ($scope.TotalNumberofDocs5 > 0) {
    //                 $scope.TotalNumberofDocs5 = $scope.TotalNumberofDocs5 + $scope.exclude_count;
    //             }
    //
    //         }
    //     } else if($scope.tabs == 6){
    //         if ($scope.formData.exclude) {
    //             $scope.exclude_count = 0;
    //             $scope.query.$ = '-30';
    //
    //             console.log($scope.dataSummary6.length + " Length");
    //
    //             for (var j = 0; j < $scope.dataSummary6.length; j++) {
    //                 item = $scope.dataSummary6[j];
    //
    //                 if (item.days_before_suspension == -30) {
    //                     $scope.exclude_count = $scope.exclude_count + 1;
    //                 }
    //             }
    //             console.log($scope.exclude_count);
    //             if ($scope.TotalNumberofDocs6 > 0) {
    //                 $scope.TotalNumberofDocs6 = $scope.TotalNumberofDocs6 - $scope.exclude_count;
    //             }
    //
    //
    //         }
    //         else {
    //             $scope.query.$ = "";
    //
    //             if ($scope.TotalNumberofDocs6 > 0) {
    //                 $scope.TotalNumberofDocs6 = $scope.TotalNumberofDocs6 + $scope.exclude_count;
    //             }
    //
    //         }
    //     }
    //
    // }



    //active and inactive clients

    $scope.active_clients = function () {


        if ($scope.formData.active) {
            $scope.query2.$ = 'yes_client';
            console.log($scope.query2.$);
            if ($scope.formData.inactive) {
                $scope.formData.inactive = false;

            }
        }

    }

    $scope.inactive_clients = function () {
        if ($scope.formData.inactive) {

            $scope.query2.$ = 'not_client';
            console.log($scope.query2.$);
            if ($scope.formData.active) {
                $scope.formData.active = false;

            }
        }
    }


    //refresh
    $scope.refreshTab = function () {

        $scope.pagination.currentPage = 1;

        // Prepaid Client Checkbox
        $scope.formData.awaitingInvoiceCheckbox = false;
        $scope.formData.paidInvoiceCheckbox = false;
        $scope.formData.agedRecievablesCheckbox = false;
        $scope.formData.firstMonthCheckbox = false;
        $scope.formData.finalInvoiceCheckbox = false;
        $scope.formData.prepaidReadyReleaseCheckbox = false;

        // View Only This Month
        //$scope.formData.awaitingInvoiceViewThisMonthCheckbox = false;
        //$scope.formData.paidInvoiceThisMonthCheckbox = false;
        $scope.formData.agedRecievablesThisMonthCheckbox = false;
        //$scope.formData.firstMonthThisMonthCheckbox = false;
        $scope.formData.finalInvoiceThisMonthCheckbox = false;
        //$scope.formData.readyReleaseThisMonthCheckbox = false;

        // Monthly Client
        $scope.formData.awaitingInvoiceViewMonthlyClientCheckbox = false;
        $scope.formData.paidInvoiceMonthlyClientCheckbox = false;
        $scope.formData.agedRecievablesMonthlyClientCheckbox = false;
        $scope.formData.firstMonthMonthlyClientCheckbox = false;
        $scope.formData.finalInvoiceMonthlyClientCheckbox = false;
        $scope.formData.readyReleaseMonthlyClientCheckbox = false;

        if ($scope.tabs == 1) {
            refreshtab1($scope, $http);
        }
        else if ($scope.tabs == 2) {
            refreshtab2($scope, $http);
        }
        else if ($scope.tabs == 3){
            refreshtab3($scope, $http, false);
        }
        else if ($scope.tabs == 4){
            refreshtab4($scope, $http, false);
        }
        else if ($scope.tabs == 5){
            refreshtab5($scope, $http, false);
        }
        else if ($scope.tabs == 6){
            refreshtab6($scope, $http, false);
        }
    }


    //format Date

    $scope.formatDate = function (unixtime) {

        if (!unixtime || typeof unixtime == 'undefined') {
            return "";
        }

        var d = new Date(unixtime).toUTCString();
        var da = d.split(" ");
        return da[(da.length - (da.length - 2))] + " " + da[(da.length - (da.length - 1))] + " " + da[(da.length - 3)];

        // var d = new Date(unixtime);
        // var n =  d.toDateString();
        // var da = n.split(" ");
        // return da[(da.length - (da.length -1))]+" "+da[(da.length - (da.length - 2))]+" "+da[(da.length-1)];
    };


    $scope.formatDateTime = function (unixtime) {

        if (!unixtime || typeof unixtime == 'undefined') {
            return "";
        }

        var date = new Date(Date.parse(unixtime));
        var n = date.toDateString();
        // return n;

        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        if (n == "Invalid Date") {
            return null;
        }
        return date.getFullYear() + "-" + (parseInt(date.getMonth()) + 1) + "-" + date.getDate() + " " + strTime;

    };

    //getdecimal
    $scope.getDecimal = function (value) {
        if (value != null) {

            value = parseFloat(value);
            if ((value) % 1 == 0) {
                value = addComma(value);
                value += ".00";
            }
            else {
                value = parseFloat(value).toFixed(2);
                value = addComma(value);
                var dec = value.toString().split(".")[1];

                if (dec) {
                    if (dec.length <= 1) {
                        value += "0";
                    }
                }
                else {
                    value += ".00";
                }

            }
        }
        else {
            value = "0.00";
        }

        return value;
    };


    //sort

    //tab 1
    $scope.sort = ["-order_date"];
    $scope.sortFunc = function (column) {

        var current_index = null;

        $scope.sort.forEach(function (value, index) {

            if (value.search(column) !== -1) {
                current_index = index;
            }
        });


        if (current_index != null) {
            var first_char = $scope.sort[current_index].charAt(0);

            if (first_char == "-") {
                $scope.sort[current_index] = column;
            } else {
                $scope.sort[current_index] = "-" + column;
            }
        } else {
            $scope.sort = [];
            $scope.sort.push(column);
        }

    }

    //tab2
    $scope.sort2 = ["client_fname"];
    $scope.sortFunc2 = function (column) {

        var current_index = null;

        console.log(column);

        $scope.sort2.forEach(function (value, index) {

            if (value.search(column) !== -1) {
                current_index = index;
            }
        });


        if (current_index != null) {
            var first_char = $scope.sort2[current_index].charAt(0);

            if (first_char == "-") {
                $scope.sort2[current_index] = column;
            } else {
                $scope.sort2[current_index] = "-" + column;
            }
        } else {
            $scope.sort2 = [];
            $scope.sort2.push(column);
        }

    }

    //tab 3
    $scope.sort3 = ["client_fname"];
    $scope.sortFunc3 = function (column) {

        var current_index = null;

        $scope.sort3.forEach(function (value, index) {
            if (value.search(column) !== -1) {
                current_index = index;
            }
        });

        if (current_index != null) {
            var first_char = $scope.sort3[current_index].charAt(0);
            if (first_char == "-") {
                $scope.sort3[current_index] = column;
            } else {
                $scope.sort3[current_index] = "-" + column;
            }

        } else {
            $scope.sort3 = [];
            $scope.sort3.push(column);
        }
    }

    $scope.loadMore = function()
    {

        $scope.export = null;

        if($scope.tabs == 1)
        {

            if($scope.dataSummary.limit < $scope.TotalNumberofDocs1)
            {
                $scope.dataSummary.limit = $scope.dataSummary.limit + $scope.limitSize;

                if(($scope.dataSummary.limit >= $scope.dataSummary.length) && ($scope.dataSummary.length < $scope.TotalNumberofDocs1))
                {
                    $scope.loading0 = true;
                    $scope.pageNumber1 = $scope.pageNumber1 + 1;
                    $scope.refreshTable = false;
                    getNumberDocs($scope,$http);
                    //populateSummaryTable1($scope,$http);
                }

            }
        }
        else if($scope.tabs == 2)
        {
            if($scope.dataSummary2.limit < $scope.TotalNumberofDocs)
            {
                $scope.dataSummary2.limit = $scope.dataSummary2.limit + $scope.limitSize;

                if(($scope.dataSummary2.limit >= $scope.dataSummary2.length) && ($scope.dataSummary2.length < $scope.TotalNumberofDocs))
                {

                    $scope.loading0 = true;
                    $scope.pageNumber = $scope.pageNumber + 1;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    populateSummaryTable1($scope,$http);
                }

            }
        }
        else if($scope.tabs == 3)
        {
            if($scope.dataSummary3.limit < $scope.TotalNumberofDocs3)
            {
                $scope.dataSummary3.limit = $scope.dataSummary3.limit + $scope.limitSize;

                if(($scope.dataSummary3.limit >= $scope.dataSummary3.length) && ($scope.dataSummary3.length < $scope.TotalNumberofDocs3))
                {
                    $scope.loading0 = true;
                    $scope.pageNumber3 = $scope.pageNumber3 + 1;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    populateSummaryTable1($scope,$http);
                }

            }
        }
        else if($scope.tabs == 4)
        {
            if($scope.dataSummary4.limit < $scope.TotalNumberofDocs3)
            {
                $scope.dataSummary4.limit = $scope.dataSummary4.limit + $scope.limitSize;

                if(($scope.dataSummary4.limit >= $scope.dataSummary4.length) && ($scope.dataSummary4.length < $scope.TotalNumberofDocs4))
                {
                    $scope.loading0 = true;
                    $scope.pageNumber4 = $scope.pageNumber4 + 1;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    populateSummaryTable1($scope,$http);
                }

            }
        }
        else if($scope.tabs == 5)
        {
            if($scope.dataSummary5.limit < $scope.TotalNumberofDocs3)
            {
                $scope.dataSummary5.limit = $scope.dataSummary5.limit + $scope.limitSize;

                if(($scope.dataSummary5.limit >= $scope.dataSummary5.length) && ($scope.dataSummary5.length < $scope.TotalNumberofDocs5))
                {
                    $scope.loading0 = true;
                    $scope.pageNumber5 = $scope.pageNumber5 + 1;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    populateSummaryTable1($scope,$http);
                }

            }
        }
        else if($scope.tabs == 6)
        {
            if($scope.dataSummary6.limit < $scope.TotalNumberofDocs3)
            {
                $scope.dataSummary6.limit = $scope.dataSummary6.limit + $scope.limitSize;

                if(($scope.dataSummary6.limit >= $scope.dataSummary6.length) && ($scope.dataSummary6.length < $scope.TotalNumberofDocs6))
                {
                    $scope.loading0 = true;
                    $scope.pageNumber6 = $scope.pageNumber6 + 1;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    populateSummaryTable1($scope,$http);
                }

            }
        }

    }

    $scope.loadLess = function()
    {


        if($scope.tabs == 1)
        {
            if($scope.dataSummary.limit >= $scope.dataSummary.length)
            {
                $scope.dataSummary.limit = $scope.limitSize;
            }
        }
        else if($scope.tabs == 2)
        {
            if($scope.dataSummary2.limit >= $scope.dataSummary2.length)
            {
                $scope.dataSummary2.limit = $scope.limitSize;
            }
        }
        else if($scope.tabs == 3)
        {
            if($scope.dataSummary3.limit >= $scope.dataSummary3.length)
            {
                $scope.dataSummary3.limit = $scope.limitSize;
            }
        }
        else if($scope.tabs == 4)
        {
            if($scope.dataSummary4.limit >= $scope.dataSummary4.length)
            {
                $scope.dataSummary4.limit = $scope.limitSize;
            }
        }
        else if($scope.tabs == 5)
        {
            if($scope.dataSummary5.limit >= $scope.dataSummary5.length)
            {
                $scope.dataSummary5.limit = $scope.limitSize;
            }
        }
        else if($scope.tabs == 6)
        {
            if($scope.dataSummary6.limit >= $scope.dataSummary6.length)
            {
                $scope.dataSummary6.limit = $scope.limitSize;
            }
        }


    }

    $scope.loadLess = function()
    {


        if($scope.tabs == 1)
        {
            if($scope.dataSummary.limit >= $scope.dataSummary.length)
            {
                $scope.dataSummary.limit = $scope.limitSize;
            }
        }
        else if($scope.tabs == 2)
        {
            if($scope.dataSummary2.limit >= $scope.dataSummary2.length)
            {
                $scope.dataSummary2.limit = $scope.limitSize;
            }
        }
        else
        {
            if($scope.dataSummary3.limit >= $scope.dataSummary3.length)
            {
                $scope.dataSummary3.limit = $scope.limitSize;
            }
        }

    }

    $scope.loadNextPage = function (page) {

        if ($scope.tabs == 1) {

            $scope.pageNumber1 = page;

            if ($scope.dataSummary.limit < $scope.TotalNumberofDocs1) {
                $scope.dataSummary.limit = $scope.dataSummary.limit + $scope.limitSize;

                if (($scope.dataSummary.limit >= $scope.dataSummary.length) && ($scope.dataSummary.length < $scope.TotalNumberofDocs1)) {
                    $scope.loading0 = true;
                    $scope.refreshTable = false;
                    $scope.dataSummary = null;
                    getNumberDocs($scope, $http);
                }
            }

        } else if ($scope.tabs == 2) {

            $scope.pageNumber = page;

            if ($scope.dataSummary2.limit < $scope.TotalNumberofDocs) {
                $scope.dataSummary2.limit = $scope.dataSummary2.limit + $scope.limitSize;

                if (($scope.dataSummary2.limit >= $scope.dataSummary2.length) && ($scope.dataSummary2.length < $scope.TotalNumberofDocs)) {
                    $scope.loading0 = true;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    $scope.dataSummary2 = null;
                    populateSummaryTable1($scope, $http);
                }

            }

        } else if ($scope.tabs == 3) {

            $scope.pageNumber3 = page;

            if ($scope.dataSummary3.limit < $scope.TotalNumberofDocs3) {
                $scope.dataSummary3.limit = $scope.dataSummary3.limit + $scope.limitSize;
                if (($scope.dataSummary3.limit >= $scope.dataSummary3.length) && ($scope.dataSummary3.length < $scope.TotalNumberofDocs3)) {
                    $scope.loading0 = true;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    $scope.dataSummary3 = null;
                    populateSummaryTable1($scope, $http);
                }
            }

        } else if ($scope.tabs == 4) {
            $scope.pageNumber4 = page;
            if ($scope.dataSummary4.limit < $scope.TotalNumberofDocs4) {
                console.log("Stage 1");
                $scope.dataSummary4.limit = $scope.dataSummary4.limit + $scope.limitSize;
                if (($scope.dataSummary4.limit >= $scope.dataSummary4.length) && ($scope.dataSummary4.length < $scope.TotalNumberofDocs4)) {
                    console.log("Re Populate");
                    $scope.loading0 = true;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    $scope.dataSummary4 = null;
                    populateSummaryTable1($scope, $http);
                }
            }
        } else if ($scope.tabs == 5) {
            $scope.pageNumber4 = page;
            if ($scope.dataSummary5.limit < $scope.TotalNumberofDocs5) {
                $scope.dataSummary5.limit = $scope.dataSummary5.limit + $scope.limitSize;
                if (($scope.dataSummary5.limit >= $scope.dataSummary5.length) && ($scope.dataSummary5.length < $scope.TotalNumberofDocs5)) {
                    $scope.loading0 = true;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    $scope.dataSummary5 = null;
                    populateSummaryTable1($scope, $http);
                }
            }
        } else if ($scope.tabs == 6) {
            $scope.pageNumber6 = page;
            if ($scope.dataSummary6.limit < $scope.TotalNumberofDocs6) {
                $scope.dataSummary6.limit = $scope.dataSummary6.limit + $scope.limitSize;
                if (($scope.dataSummary6.limit >= $scope.dataSummary6.length) && ($scope.dataSummary6.length < $scope.TotalNumberofDocs6)) {
                    $scope.loading0 = true;
                    $scope.refreshTable = false;
                    $scope.export = null;
                    $scope.dataSummary6 = null;
                    populateSummaryTable1($scope, $http);
                }
            }
        }
    };



    //change tab
    $scope.changeTab = function (tab) {
        $scope.tabs = tab;


        if (tab == 1) {
            $scope.formDataSearch = null;
            $scope.export = null;
            if (!$scope.dataSummary) {
                getNumberDocs($scope, $http);
            }
        }
        else if (tab == 2) {
            $scope.formDataSearch = null;
            $scope.export = null;
            if (!$scope.dataSummary2) {

                getNumberDocs($scope, $http);
            }
        }
        else if (tab == 3) {
            $scope.formDataSearch = null;
            $scope.export = null;
            if (!$scope.dataSummary3) {

                getNumberDocs($scope, $http);
            }
        }
        else if (tab == 4) {
            $scope.formDataSearch = null;
            $scope.export = null;
            if (!$scope.dataSummary4) {

                getNumberDocs($scope, $http);
            }
        }
        else if (tab == 5) {
            $scope.formDataSearch = null;
            $scope.export = null;
            if (!$scope.dataSummary5) {

                getNumberDocs($scope, $http);
            }
        }
        else if (tab == 6) {
            $scope.formDataSearch = null;
            $scope.export = null;
            if (!$scope.dataSummary6) {

                getNumberDocs($scope, $http);
            }
        }
    };


    //for remarks
    $scope.remarksCheck = function (index) {

        console.log($scope.formData.remarks[index]);


        $scope.dataRemarks = $scope.dataSummary3[index];

        if (!$scope.dataSummary3[index].remarks) {
            if ($scope.formData.remarks[index]) {
                SweetAlert.swal({
                        title: "Add Remarks to Ready to Release,",
                        text: "For client, " + $scope.dataSummary3[index].client_fname,
                        showCancelButton: true,
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {

                            addRemarks($scope, $http, toaster);


                        } else {
                            $scope.formData.remarks[index] = false;
                        }
                    });
            }
        }
        else {
            if (!$scope.formData.remarks[index]) {
                SweetAlert.swal({
                        title: "Remove Remarks,",
                        text: "For client, " + $scope.dataSummary3[index].client_fname,
                        showCancelButton: true,
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {

                            removeRemarks($scope, $http, toaster);

                        } else {
                            $scope.formData.remarks[index] = true;
                        }
                    });
            }
        }
    }


    //inistialize icheck
    $scope.initiCheck = function (index) {

        var history = $scope.dataSummary3[index].history;
        var uservalcheck = false;
        var checkfield = false;
        angular.forEach(history,function(val,key){
            if(typeof val.action != "undefined" && val.action == "remarks"){
                uservalcheck = true;
                checkfield = true;
            } else if (typeof val.action != "undefined" && val.action == "remove-remarks"){
                uservalcheck = false;
                checkfield = true;
            }
        });

        if(!checkfield){
            if($scope.dataSummary3[index].payment_advice == true || $scope.dataSummary3[index].status == "paid"){
                $scope.formData.remarks[index] = true;
            } else {
                $scope.formData.remarks[index] = false;
            }
        } else {
            $scope.formData.remarks[index] = uservalcheck;
        }

    }


    //value change for tab 2 dropdown (invoice_type and invoice_status

    $scope.invocieTypeVal = function () {
        $scope.invtype = Invoice_Type[$scope.formData.Invoice_Type];

        console.log($scope.invtype);
    }

    $scope.invocieStatVal = function () {
        $scope.invstat = Invoice_Status[$scope.formData.Invoice_Status];

        console.log($scope.invstat);
    }


    $scope.export_data = function () {

        console.log('exporting');

        exportData($scope, $http);


    };

}


// function AlertModal($scope, $modalInstance, $http, $invoker,toaster)
// {
//     var alertIndex = $invoker.indexAlertReport;
//     $scope.report_data = $invoker.dataSummary3[alertIndex];
//     var remarks = $invoker.formData.remarks[alertIndex];
//
//
//
//
//     $scope.close_alert = function () {
//         $modalInstance.dismiss('cancel');
//         remarks = false;
//     };
//
// }


function AddNotesModal($scope, $modalInstance, $http, $invoker, toaster) {


    var index = $invoker.indexDataReport;
    var tabNum = $invoker.tabs;

    if (tabNum == 1) {
        $scope.report_data = $invoker.dataSummary[index];
    }
    else if (tabNum == 2) {
        $scope.report_data = $invoker.dataSummary2[index];
    }
    else if (tabNum == 3) {
        $scope.report_data = $invoker.dataSummary3[index];
    }
    else if (tabNum == 4) {
        $scope.report_data = $invoker.dataSummary4[index];
    }
    else if (tabNum == 5) {
        $scope.report_data = $invoker.dataSummary5[index];
    }
    else if (tabNum == 6) {
        $scope.report_data = $invoker.dataSummary6[index];
    }



    $scope.formData = {};

    $scope.formData.admin_name = ADMIN_NAME;
    $scope.formData.mongo_id = $scope.report_data._id;

    $scope.comments = [];

    //for pagination
    $scope.currentPage = 1,
    $scope.numberPage = 10,
    $scope.maxSize = 5;


    $scope.initForm = function () {

        if (typeof $scope.report_data.comments != "undefined") {
            for (var i = $scope.report_data.comments.length - 1; i >= 0; i--) {


                item = $scope.report_data.comments[i];


                $scope.comments.push({

                    comments: item.comment,
                    admin: item.name,
                    date: item.date
                });


                if (!item) {
                    $scope.report_data.comments.splice(i, 1);
                }


            }
        }
        else {
            $scope.comments = [];
        }
    };


    $scope.addNotes = function () {

        $scope.formData.couch_id = $scope.report_data.couch_id;
        $scope.formData.order_id = $scope.report_data.order_id;
        $scope.formData.isInvoiceReporting = true;

        $scope.loading5 = true;

        $http({
            method: 'POST',
            url: API_URL + "/invoice/add-invoice-notes",
            data: $scope.formData
        }).success(function (response) {
            $scope.loading5 = false;
            //console.log(response);

            if (response.success) {
                $scope.comments = [];
                for (var i = response.comments.length - 1; i >= 0; i--) {


                    item = response.comments[i];

                    $scope.comments.push({

                        comments: item.comment,
                        admin: item.name,
                        date: item.date
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


                if (tabNum == 1) {
                    $invoker.dataSummary[index].comments.length += 1;
                }
                else if (tabNum == 2) {
                    $invoker.dataSummary2[index].comments.length += 1;
                }
                else {

                }

                $invoker.formDataSearch = null;
                $invoker.refreshTable = null;
                getNumberDocs($invoker, $http);
                syncLastDateUpdated($scope, $http);//for last_date_updated

                $scope.formData.comments = "";
            }
            else {
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

    };


    $scope.close_add_comments = function () {
        $modalInstance.dismiss('cancel');
    };


    $scope.initForm();


    $scope.formatDate = function (unixtime) {
        return $invoker.formatDate(unixtime);
    };

    $scope.formatDateTime = function (unixtime) {
        return $invoker.formatDateTime(unixtime);
    };


};

function AddNotesReadyForReleaseModal($scope, $modalInstance, $http, $invoker, toaster)
{
    var data = (typeof $invoker.readyForReleaseDataItem !== "undefined" ? $invoker.readyForReleaseDataItem : null );

    $scope.notes = [];

    if(data)
    {
        $scope.order_id =  data.order_id;

        if(data.ready_for_release_notes.length > 0 )
        {
            $scope.notes = data.ready_for_release_notes;
        }


        $scope.addNotesReadyForRelease = function()
        {

            $scope.loadingNotes = true;


            var formData = {};

            formData.object = {
                order_id:data.order_id,
                admin:{
                    id:parseInt(ADMIN_ID),
                    name:ADMIN_NAME
                },
                notes:$scope.objectField.notes
            }

            $http({
                method: 'POST',
                url: API_URL + "/invoice-reporting/add-notes-ready-for-release",
                data: formData
            }).success(function (response) {
                $scope.loadingNotes = false;
                if(response.success)
                {
                    if(data.ready_for_release_notes.length > 0 )
                    {
                        console.log('pasok');
                        notes = (typeof response.document !== "undefined" ? response.document : null);
                        if(notes)
                        {
                            $scope.notes.push(notes);
                        }
                    }
                    else
                    {
                        formData.object.date = new Date();
                        $scope.notes.push(formData.object);
                        $invoker.readyForReleaseDataItem.ready_for_release_notes.push(formData.object);
                        //$invoker.readyForReleaseDataItem.ready_for_release_notes.length = $invoker.readyForReleaseDataItem.ready_for_release_notes.length + 1;
                    }

                    toaster.pop({
                        type: 'success',
                        title: 'Note(s) Successfully Added!',
                        body: response.msg,
                        showCloseButton: true,
                    });
                }
                else
                {
                    toaster.pop({
                        type: 'warning',
                        title: 'Adding of notes failed!',
                        body: response.msg,
                        showCloseButton: true,
                    });
                }

                $scope.objectField.notes = "";

            });

        }


    }





    $scope.close_add_notes_ready_for_release = function () {
        $modalInstance.dismiss('cancel');
    };

    $scope.formatDate = function (unixtime) {
        return $invoker.formatDate(unixtime);
    };

    $scope.formatDateTime = function (unixtime) {
        return $invoker.formatDateTime(unixtime);
    };

}


function addComma(value) {

    return Number(value).toLocaleString('en');
}

function populateSummaryTable1($scope, $http) {

    var tabNumber = $scope.tabs;
    var form_data = {};


    if (tabNumber == 1) {
        if ($scope.formDataSearch) {
            form_data = $scope.formDataSearch;

            if (!$scope.export) {
                $scope.loading6 = true;
            }
        }

        if ($scope.export) {

            form_data.export = 1;
            form_data.exclude = $scope.formData.exclude;
        }

    }

    else if (tabNumber == 2) {
        if ($scope.formDataSearch) {
            form_data = $scope.formDataSearch;

            if (!$scope.export) {
                $scope.loading20 = true;
            }

        }

        if ($scope.export) {
            form_data.export = 1;
            form_data.active = $scope.formData.active;
            form_data.inactive = $scope.formData.inactive;
        }
    }
    else if (tabNumber == 3) {
        if ($scope.formDataSearch) {
            form_data = $scope.formDataSearch;

            if (!$scope.export) {
                $scope.loading21 = true;
            }

        }

        if ($scope.export) {
            form_data.export = 1;
            form_data.admin_id = $scope.admin_id;
        }
    }
    else if (tabNumber == 4) {
        if ($scope.formDataSearch) {
            form_data = $scope.formDataSearch;
            if (!$scope.export) {
                $scope.loading22 = true;
            }
        }

        if ($scope.export) {
            form_data.export = 1;
            form_data.admin_id = $scope.admin_id;
        }
    }
    else if (tabNumber == 5) {
        if ($scope.formDataSearch) {
            form_data = $scope.formDataSearch;
            if (!$scope.export) {
                $scope.loading23 = true;
            }
        }

        if ($scope.export) {
            form_data.export = 1;
            form_data.admin_id = $scope.admin_id;
        }
    }
    else if (tabNumber == 6) {
        if ($scope.formDataSearch) {
            form_data = $scope.formDataSearch;
            if (!$scope.export) {
                $scope.loading23 = true;
            }
        }

        if ($scope.export) {
            form_data.export = 1;
            form_data.admin_id = $scope.admin_id;
        }
    }

    form_data.tab = tabNumber;

    if (!$scope.refreshTable) {

        if (tabNumber == 1) {

            console.log($scope.TotalNumberofDocs1);
            if ($scope.TotalNumberofDocs1 > 0) {


                form_data.page = $scope.pageNumber1;

                // url = "/invoice-reporting/get-invoice-summary-data?tab="+tabNumber+"&page="+$scope.pageNumber1;
            }
        }
        else if (tabNumber == 2) {
            if ($scope.TotalNumberofDocs > 0) {
                form_data.page = $scope.pageNumber;

                // url = "/invoice-reporting/get-invoice-summary-data?tab="+tabNumber+"&page="+$scope.pageNumber;
            }
        }
        else if (tabNumber == 3) {
            if ($scope.TotalNumberofDocs3 > 0) {
                form_data.page = $scope.pageNumber3;
                // url = "/invoice-reporting/get-invoice-summary-data?tab="+tabNumber+"&page="+$scope.pageNumber3;
            }
        }
        else if (tabNumber == 4) {
            if ($scope.TotalNumberofDocs4 > 0) {
                form_data.page = $scope.pageNumber4;
                // url = "/invoice-reporting/get-invoice-summary-data?tab="+tabNumber+"&page="+$scope.pageNumber3;
            }
        }
        else if (tabNumber == 5) {
            if ($scope.TotalNumberofDocs5 > 0) {
                form_data.page = $scope.pageNumber5;
                // url = "/invoice-reporting/get-invoice-summary-data?tab="+tabNumber+"&page="+$scope.pageNumber3;
            }
        }
        else if (tabNumber == 6) {
            if ($scope.TotalNumberofDocs6 > 0) {
                form_data.page = $scope.pageNumber6;
                // url = "/invoice-reporting/get-invoice-summary-data?tab="+tabNumber+"&page="+$scope.pageNumber3;
            }
        }

    } else {
        if (tabNumber == 1) {
            $scope.pageNumber1 = 1;
        }
        else if (tabNumber == 2) {
            $scope.pageNumber = 1;
        }
        else if (tabNumber == 3) {
            $scope.pageNumbe3 = 1;
        }
        else if (tabNumber == 4) {
            $scope.pageNumbe4 = 1;
        }
        else if (tabNumber == 5) {
            $scope.pageNumbe5 = 1;
        }
        else if (tabNumber == 6) {
            $scope.pageNumbe6 = 1;
        }
    }

    // if(tabNumber == 5){
    //     form_data.tab = 2;
    // }


    if(tabNumber == 6){
        form_data.status = "paid";
    }


    if(tabNumber == 1){
        form_data.status = "new";
        form_data.tab = 1;
    }

    form_data.awaitingInvoiceCheckbox = $scope.formData.awaitingInvoiceCheckbox;
    form_data.paidInvoiceCheckbox = $scope.formData.paidInvoiceCheckbox;
    form_data.agedRecievablesCheckbox = $scope.formData.agedRecievablesCheckbox;
    form_data.firstMonthCheckbox = $scope.formData.firstMonthCheckbox;
    form_data.finalInvoiceCheckbox = $scope.formData.finalInvoiceCheckbox;
    form_data.prepaidReadyReleaseCheckbox = $scope.formData.prepaidReadyReleaseCheckbox;

    form_data.awaitingInvoiceViewThisMonthCheckbox = $scope.formData.awaitingInvoiceViewThisMonthCheckbox;
    form_data.paidInvoiceThisMonthCheckbox = $scope.formData.paidInvoiceThisMonthCheckbox;
    form_data.agedRecievablesThisMonthCheckbox = $scope.formData.agedRecievablesThisMonthCheckbox;
    form_data.firstMonthThisMonthCheckbox = $scope.formData.firstMonthThisMonthCheckbox;
    form_data.finalInvoiceThisMonthCheckbox = $scope.formData.finalInvoiceThisMonthCheckbox;
    form_data.readyReleaseThisMonthCheckbox = $scope.formData.readyReleaseThisMonthCheckbox;

    form_data.awaitingInvoiceViewMonthlyClientCheckbox = $scope.formData.awaitingInvoiceViewMonthlyClientCheckbox;
    form_data.paidInvoiceMonthlyClientCheckbox = $scope.formData.paidInvoiceMonthlyClientCheckbox;
    form_data.agedRecievablesMonthlyClientCheckbox = $scope.formData.agedRecievablesMonthlyClientCheckbox;
    form_data.firstMonthMonthlyClientCheckbox = $scope.formData.firstMonthMonthlyClientCheckbox;
    form_data.finalInvoiceMonthlyClientCheckbox = $scope.formData.finalInvoiceMonthlyClientCheckbox;
    form_data.readyReleaseMonthlyClientCheckbox = $scope.formData.readyReleaseMonthlyClientCheckbox;


    $http({
        method: 'POST',
        url: API_URL + "/invoice-reporting/get-invoice-summary-data",
        data: form_data
    }).success(function (response) {
        console.log("Resonse from /invoice-reporting/get-invoice-summary-data");
        console.log(response);
        console.log(tabNumber);
        console.log(form_data);
        if (response.success) {
            $scope.loading6 = false;//search button tab 1
            $scope.loadingSearch6 = false;//search button tab 6
            $scope.loading_tab1 = false;//refresh button tab 1
            $scope.loading_tab2 = false;//refresh button tab 2
            $scope.loading_tab3 = false;//refresh button tab 3
            $scope.loading_tab4 = false;//refresh button tab 4
            $scope.loading_tab5 = false;//refresh button tab 5
            $scope.loading_tab6 = false;//refresh button tab 6
            $scope.loading20 = false;//refresh button tab 2
            $scope.loading21 = false;//refresh button tab 3
            $scope.loading22 = false;//search button tab 4
            $scope.loading23 = false;//search button tab 5

            if (tabNumber == 1) {
                if (!$scope.export) {

                    console.log(response.data_report);
                    $scope.dataSummary = response.data_report;
                    $scope.dataSummary.limit = $scope.limitSize;
                    console.log($scope.query);
                    console.log($scope.dataSummary.limit);

                    if (!$scope.formDataSearch) {
                        //for tab 3
                        angular.forEach(response.data_report, function (value, key) {

                            var remarks = false;
                            if (value.status != "cancelled") {
                                if (value.history.length > 0) {

                                    for (var i = (value.history.length - 1); i >= 0; i--) {
                                        item = value.history[i]

                                        if (item.action) {
                                            if (item.action == "remove-remarks") {
                                                remarks = false;
                                                break;
                                            }

                                            if (item.action == "remarks") {
                                                remarks = true;
                                                break;
                                            }

                                        }

                                    }
                                }

                            }

                            value.remarks = remarks;
                        });

                    }

                    //$scope.exclude_client();
                }
                else {
                    console.log(response);
                    if (response.success) {
                        $scope.export_loading = false;
                        var grid_id = response.grid_data._id;
                        var url = API_URL + "/invoice-reporting/exports-by-id?id=" + grid_id;
                        window.location.assign(url);
                    }
                    else {
                        $scope.export_loading = false;
                        alert('Failed to export data, please try again.');
                    }
                }

                console.log("dataSummary value is..");
                console.log($scope.dataSummary);
            }
            else if (tabNumber == 2) {

                if (!$scope.export) {

                    $scope.loading0 = false;
                    $scope.dataSummary2 = response.data_report;
                    $scope.dataSummary2.limit = $scope.limitSize;
                    console.log($scope.dataSummary2);
                    reStructureAgedReceivables($scope.dataSummary2);
                    $scope.active_clients();

                }
                else {
                    console.log(response);

                    if (response.success) {

                        $scope.export_loading = false;

                        var grid_id = response.grid_data._id;

                        var url = API_URL + "/invoice-reporting/exports-by-id?id=" + grid_id;

                        window.location.assign(url);
                    }
                    else {
                        $scope.export_loading = false;

                        alert('Failed to export data, please try again.');
                    }
                }

            }
            else if (tabNumber == 3) {

                if (!$scope.export) {

                    angular.forEach(response.data_report, function (value, key) {
                        var remarks = false;
                        if (value.status != "cancelled") {
                            if (value.history.length > 0) {
                                for (var i = (value.history.length - 1); i >= 0; i--) {
                                    item = value.history[i]
                                    if (item.action) {
                                        if (item.action == "remove-remarks") {
                                            remarks = false;
                                            break;
                                        }
                                        if (item.action == "remarks") {
                                            remarks = true;
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                        value.remarks = remarks;
                    });

                    $scope.dataSummary3 = response.data_report;
                    $scope.dataSummary3.limit = $scope.limitSize;

                    reStructureReadyRelease($scope.dataSummary3);


                }
                else {
                    console.log(response);
                    if (response.success) {
                        $scope.export_loading = false;
                        var grid_id = response.grid_data._id;
                        var url = API_URL + "/invoice-reporting/exports-by-id?id=" + grid_id;
                        window.location.assign(url);
                    }
                    else {
                        $scope.export_loading = false;
                        alert('Failed to export data, please try again.');
                    }
                }
            }
            else if (tabNumber == 4) {
                if (!$scope.export) {

                    $scope.dataSummary4 = response.data_report;
                    $scope.dataSummary4.limit = $scope.limitSize;

                }
            }
            else if (tabNumber == 5) {

                if (!$scope.export) {

                    $scope.dataSummary5 = response.data_report;

                }

            }
            else if (tabNumber == 6) {
                if (!$scope.export) {

                    console.log("Rendering Tab 6..");
                    console.log(response.data_report);
                    $scope.dataSummary6 = response.data_report;
                    $scope.dataSummary6.limit = $scope.limitSize;
                    if (!$scope.formDataSearch) {
                        $scope.dataSummary6 = response.data_report;
                        $scope.dataSummary6.limit = $scope.limitSize;
                        console.log($scope.dataSummary6);
                    }

                    //$scope.exclude_client();

                }
                else {
                    console.log(response);
                    if (response.success) {
                        $scope.export_loading = false;
                        var grid_id = response.grid_data._id;
                        var url = API_URL + "/invoice-reporting/exports-by-id?id=" + grid_id;
                        window.location.assign(url);
                    }
                    else {
                        $scope.export_loading = false;
                        alert('Failed to export data, please try again.');
                    }
                }
            }
        }



    }).error(function (response) {
        console.log(response);
        $scope.loading6 = false;//search button tab 1
        $scope.loadingSearch6 = false;//search button tab 6
        $scope.loading_tab1 = false;//refresh button tab 1
        $scope.loading_tab2 = false;//refresh button tab 2
        $scope.loading_tab3 = false;//refresh button tab 3
        $scope.loading_tab4 = false;//refresh button tab 4
        $scope.loading_tab5 = false;//refresh button tab 5
        $scope.loading_tab6 = false;//refresh button tab 5
        $scope.loading20 = false;//search button tab 2
        $scope.loading21 = false;//search button tab 2
        $scope.export_loading = false;//export button
    });

    // if(!$scope.flagTab2InitialLoad){
    //     // Render Tab 2 data
    //     var temp_params = {};
    //     temp_params.tab = 2;
    //     temp_params.page = 1;
    //
    //     $http({
    //         method: 'POST',
    //         url: API_URL + "/invoice-reporting/get-invoice-summary-data",
    //         data: temp_params
    //     }).success(function (response) {
    //         console.log("Resonse from /invoice-reporting/get-invoice-summary-data");
    //         console.log(response);
    //         console.log(tabNumber);
    //         if (response.success) {
    //             if (tabNumber == 1) {
    //                 if (!$scope.export) {
    //
    //                     $scope.loading0 = false;
    //                     if($scope.pageNumber == 1)
    //                     {
    //                         $scope.dataSummary2 = response.data_report;
    //                         $scope.dataSummary2.limit = $scope.limitSize;
    //                         console.log($scope.dataSummary2);
    //                     }
    //                     reStructureAgedReceivables($scope.dataSummary2);
    //                     $scope.active_clients();
    //                 }
    //                 // For Tab 5
    //                 if($scope.pageNumber5 == 1) {
    //                     var temp_dataSummary5 = response.data_report;
    //                     $scope.dataSummary5 = [];
    //                     getFinalInvoice(0);
    //                 } else {
    //                     var temp_dataSummary5 = response.data_report;
    //                     getFinalInvoice(0);
    //                 }
    //                 function getFinalInvoice(i)
    //                 {
    //
    //                     if(i < temp_dataSummary5.length)
    //                     {
    //                         items = temp_dataSummary5[i];
    //                         if(items.items_all.length > 0)
    //                         {
    //                             function getItemtype(x)
    //                             {
    //
    //                                 if(x < items.items_all.length)
    //                                 {
    //                                     value = items.items_all[x];
    //                                     if(value.item_type == "Final Invoice")
    //                                     {
    //                                         items.index = x;
    //                                         $scope.dataSummary5.push(items);
    //                                         getFinalInvoice(i+1);
    //                                     }
    //                                     else
    //                                     {
    //                                         getItemtype(x+1);
    //                                     }
    //                                 }
    //                                 else
    //                                 {
    //                                     getFinalInvoice(i+1);
    //                                 }
    //                             }
    //                         }
    //                         else
    //                         {
    //                             getFinalInvoice(i+1);
    //                         }
    //
    //                         getItemtype(0);
    //                     }
    //                     else
    //                     {
    //                         $scope.TotalNumberofDocs5 = $scope.dataSummary5.length;
    //                     }
    //                 }
    //
    //                 $scope.flagTab2InitialLoad = true;
    //
    //             }
    //         }
    //
    //     }).error(function (response) {
    //         console.log(response);
    //     });
    // }

}

function getAge(order_date){
    var days = moment().diff(order_date, 'days');
    return days;
};

function reStructureAgedReceivables(data){

    if(typeof data != "undefined" && data.length > 0){
        angular.forEach(data, function(value, key) {
            value.age = getAge(value.order_date);
        });
    } else {
        console.log("Invalid Aged Recievable Array");
    }
}

function reStructureReadyRelease(data){
    if(typeof data != "undefined" && data.length > 0){
        angular.forEach(data, function(value, key) {
            if(value.status == "paid" || value.payment_advice == true){
                value.remarks_eval = true;
            } else {
                value.remarks_eval = false;
            }
        });
    } else {
        console.log("Invalid Ready Release Array");
    }
}

function addRemarks($scope, $http, toaster) {

    console.log($scope.dataRemarks);

    var formData = {
        order_id: $scope.dataRemarks.order_id,
        client_id: $scope.dataRemarks.client_id,
        couch_id: $scope.dataRemarks.couch_id
    };

    $scope.report_data = $scope.dataRemarks;

    console.log(formData);

    $http({
        method: 'POST',
        url: API_URL + "/invoice-reporting/add-invoice-remarks",
        data: formData
    }).success(function (response) {
        console.log(response);
        if (response.success) {
            toaster.pop({
                type: 'success',
                title: 'Add remark(s) success',
                showCloseButton: true,
            });
            $scope.rmrks = true;
            refreshtab3($scope, $http, true);
            syncLastDateUpdated($scope, $http);

        }
        else {
            toaster.pop({
                type: 'error',
                title: 'Add remark(s) failed',
                showCloseButton: true,
            });
        }

    });

}

function removeRemarks($scope, $http, toaster) {

    console.log($scope.dataRemarks);

    var formData = {
        order_id: $scope.dataRemarks.order_id,
        client_id: $scope.dataRemarks.client_id,
        couch_id: $scope.dataRemarks.couch_id
    }
    $scope.report_data = $scope.dataRemarks;

    $http({
        method: 'POST',
        url: API_URL + "/invoice-reporting/del-invoice-remarks",
        data: formData
    }).success(function (response) {
        console.log(response);
        if (response.success) {
            toaster.pop({
                type: 'success',
                title: 'Removed remark(s) success',
                showCloseButton: true,
            });

            refreshtab3($scope, $http, true);
            syncLastDateUpdated($scope, $http);
        }
        else {
            toaster.pop({
                type: 'error',
                title: 'Add remark(s) failed',
                showCloseButton: true,
            });
        }

    });


}


function getNumberDocs($scope, $http) {

    console.log($scope.export);

    var param = {};
    var tab = $scope.tabs;


    if ($scope.refreshTable) {

        if (tab == 1) {
            $scope.loading_tab1 = true;
        }
        else if (tab == 2) {

            $scope.loading_tab2 = true;
        }
        else if (tab == 3) {
            $scope.loading_tab3 = true;
        }
        else if (tab == 4) {
            $scope.loading_tab4 = true;
        }
        else if (tab == 5) {
            $scope.loading_tab5 = true;
        }
        else if (tab == 6) {
            $scope.loading_tab6 = true;
        }
    }

    if ($scope.formDataSearch) {
        param = $scope.formDataSearch;
    }

    param.tab = tab;


    $http({
        method: 'POST',
        url: API_URL + "/invoice-reporting/count-documents",
        data: param
    }).success(function (response) {

        console.log("/invoice-reporting/count-documents");
        console.log(response);

        if (response.success) {

            if(param.search != 1){
                angular.forEach(response.result[0].amount, function (value, key) {
                    if(value._id == "USD") {$scope.tab1usd = value.total_amount.toFixed(2)}
                    if(value._id == "AUD") {$scope.tab1aud = value.total_amount.toFixed(2)}
                    if(value._id == "GBP") {$scope.tab1gbp = value.total_amount.toFixed(2)}
                });

                angular.forEach(response.result[1].amount, function (value, key) {
                    if(value._id == "USD") {$scope.tab2usd = value.total_amount.toFixed(2)}
                    if(value._id == "AUD") {$scope.tab2aud = value.total_amount.toFixed(2)}
                    if(value._id == "GBP") {$scope.tab2gbp = value.total_amount.toFixed(2)}
                });

                angular.forEach(response.result[2].amount, function (value, key) {
                    if(value._id == "USD") {$scope.tab3usd = value.total_amount.toFixed(2)}
                    if(value._id == "AUD") {$scope.tab3aud = value.total_amount.toFixed(2)}
                    if(value._id == "GBP") {$scope.tab3gbp = value.total_amount.toFixed(2)}
                });

                angular.forEach(response.result[3].amount, function (value, key) {
                    if(value._id == "USD") {$scope.tab4usd = value.total_amount.toFixed(2)}
                    if(value._id == "AUD") {$scope.tab4aud = value.total_amount.toFixed(2)}
                    if(value._id == "GBP") {$scope.tab4gbp = value.total_amount.toFixed(2)}
                });

                angular.forEach(response.result[4].amount, function (value, key) {
                    if(value._id == "USD") {$scope.tab5usd = value.total_amount.toFixed(2)}
                    if(value._id == "AUD") {$scope.tab5aud = value.total_amount.toFixed(2)}
                    if(value._id == "GBP") {$scope.tab5gbp = value.total_amount.toFixed(2)}
                });

                angular.forEach(response.result[5].amount, function (value, key) {
                    if(value._id == "USD") {$scope.tab6usd = value.total_amount.toFixed(2)}
                    if(value._id == "AUD") {$scope.tab6aud = value.total_amount.toFixed(2)}
                    if(value._id == "GBP") {$scope.tab6gbp = value.total_amount.toFixed(2)}
                });

                $scope.TotalNumberofDocs1 = response.result[0].count;
                $scope.TotalNumberofDocs = response.result[1].count;
                $scope.TotalNumberofDocs3 = response.result[2].count;
                $scope.TotalNumberofDocs4 = response.result[3].count;
                $scope.TotalNumberofDocs5 = response.result[4].count;
                $scope.TotalNumberofDocs6 = response.result[5].count;
            } else {
                if (tab == 1) {
                    angular.forEach(response.result[0].amount, function (value, key) {
                        if(value._id == "USD") {$scope.tab1usd = value.total_amount.toFixed(2)}
                        if(value._id == "AUD") {$scope.tab1aud = value.total_amount.toFixed(2)}
                        if(value._id == "GBP") {$scope.tab1gbp = value.total_amount.toFixed(2)}
                    });
                    $scope.TotalNumberofDocs1 = response.result[0].count;
                }
                else if (tab == 2) {
                    angular.forEach(response.result[0].amount, function (value, key) {
                        if(value._id == "USD") {$scope.tab2usd = value.total_amount.toFixed(2)}
                        if(value._id == "AUD") {$scope.tab2aud = value.total_amount.toFixed(2)}
                        if(value._id == "GBP") {$scope.tab2gbp = value.total_amount.toFixed(2)}
                    });
                    $scope.TotalNumberofDocs = response.result[0].count;
                }
                else if (tab == 3) {
                    angular.forEach(response.result[0].amount, function (value, key) {
                        if(value._id == "USD") {$scope.tab3usd = value.total_amount.toFixed(2)}
                        if(value._id == "AUD") {$scope.tab3aud = value.total_amount.toFixed(2)}
                        if(value._id == "GBP") {$scope.tab3gbp = value.total_amount.toFixed(2)}
                    });
                    $scope.TotalNumberofDocs3 = response.result[0].count;
                }
                else if (tab == 4) {
                    angular.forEach(response.result[0].amount, function (value, key) {
                        if(value._id == "USD") {$scope.tab4usd = value.total_amount.toFixed(2)}
                        if(value._id == "AUD") {$scope.tab4aud = value.total_amount.toFixed(2)}
                        if(value._id == "GBP") {$scope.tab4gbp = value.total_amount.toFixed(2)}
                    });
                    $scope.TotalNumberofDocs4 = response.result[0].count;
                }
                else if (tab == 5) {
                    angular.forEach(response.result[0].amount, function (value, key) {
                        if(value._id == "USD") {$scope.tab5usd = value.total_amount.toFixed(2)}
                        if(value._id == "AUD") {$scope.tab5aud = value.total_amount.toFixed(2)}
                        if(value._id == "GBP") {$scope.tab5gbp = value.total_amount.toFixed(2)}
                    });
                    $scope.TotalNumberofDocs5 = response.result[0].count;
                }
                else if (tab == 6) {
                    angular.forEach(response.result[0].amount, function (value, key) {
                        if(value._id == "USD") {$scope.tab6usd = value.total_amount.toFixed(2)}
                        if(value._id == "AUD") {$scope.tab6aud = value.total_amount.toFixed(2)}
                        if(value._id == "GBP") {$scope.tab6gbp = value.total_amount.toFixed(2)}
                    });
                    $scope.TotalNumberofDocs6 = response.result[0].count;
                }
            }


            populateSummaryTable1($scope, $http)
        }


    }).error(function (response) {
        $scope.loading20 = false;
        $scope.loading7 = false;
    });
}


//for searching

//tab1
function searchTab1($scope, $http) {
    //order_date

    if ($scope.invoice_data_summary_report.selected_date_range_order_date.startDate &&
        $scope.invoice_data_summary_report.selected_date_range_order_date.endDate) {
        var start_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_order_date.startDate);
        var end_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_order_date.endDate);


        var isOrderDate = 1;
    }
    else {
        var start_date_order_date = null;
        var end_date_order_date = null;

        var isOrderDate = null;
    }


    //due_date
    if ($scope.invoice_data_summary_report.selected_date_range_due_date.startDate
        && $scope.invoice_data_summary_report.selected_date_range_due_date.endDate) {
        var start_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_due_date.startDate);
        var end_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_due_date.endDate);

        var isDueDate = 1;
    }
    else {
        var start_date_due_date = null;
        var end_date_due_date = null;

        var isDueDate = null;
    }


    var searchBox = $scope.formData.searchBox;
    //var excludeBox = $scope.formData.exclude;



    $scope.formDataSearch =
        {
            search: 1,
            tab: $scope.tabs,
            start_date_order_date: start_date_order_date,
            end_date_order_date: end_date_order_date,
            start_date_due_date: start_date_due_date,
            end_date_due_date: end_date_due_date,
            searchBox: searchBox,
            //excludeBox: excludeBox,
            excludeBox: false, // Always set excludeBox to false for filter
            isOrderDate: isOrderDate,
            isDueDate: isDueDate,
            status: $scope.invstat,
            awaitingInvoiceCheckbox: $scope.formData.awaitingInvoiceCheckbox,
            awaitingInvoiceViewThisMonthCheckbox: $scope.formData.awaitingInvoiceViewThisMonthCheckbox,
            awaitingInvoiceViewMonthlyClientCheckbox: $scope.formData.awaitingInvoiceViewMonthlyClientCheckbox
        };


    console.log($scope.formDataSearch);
    $scope.refreshTable = false;
    $scope.export = null;

    $scope.loading6 = true;
    getNumberDocs($scope, $http)


}
//tab 2
function searchTab2($scope, $http) {

    //order_date

    if ($scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate &&
        $scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate) {
        var start_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate);
        var end_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate);


        var isOrderDate = 1;
    }
    else {
        var start_date_order_date = null;
        var end_date_order_date = null;

        var isOrderDate = null;
    }


    //due_date
    if ($scope.invoice_data_summary_report.selected_date_range_2_due_date.startDate
        && $scope.invoice_data_summary_report.selected_date_range_2_due_date.endDate) {
        var start_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_due_date.startDate);
        var end_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_due_date.endDate);

        var isDueDate = 1;
    }
    else {
        var start_date_due_date = null;
        var end_date_due_date = null;

        var isDueDate = null;
    }


    //last_updated

    if ($scope.invoice_data_summary_report.selected_date_range_2_last_updated.startDate
        && $scope.invoice_data_summary_report.selected_date_range_2_last_updated.endDate) {
        var start_date_last_updated = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_last_updated.startDate);
        var end_date_last_updated = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_last_updated.endDate);

        var isLastUpdated = 1;
    }
    else {
        var start_date_last_updated = null;
        var end_date_last_updated = null;

        var isLastUpdated = null;
    }


    var searchBox = $scope.formData.searchBox2;


    $scope.formDataSearch =
        {
            search: 1,
            tab: $scope.tabs,
            start_date_order_date: start_date_order_date,
            end_date_order_date: end_date_order_date,
            start_date_due_date: start_date_due_date,
            end_date_due_date: end_date_due_date,
            start_date_last_updated: start_date_last_updated,
            end_date_last_updated: end_date_last_updated,
            searchBox: searchBox,
            isOrderDate: isOrderDate,
            isDueDate: isDueDate,
            isLastUpdated: isLastUpdated,
            type: $scope.invtype,
            status: $scope.invstat,
            agedRecievablesCheckbox: $scope.formData.agedRecievablesCheckbox,
            agedRecievablesThisMonthCheckbox: $scope.formData.agedRecievablesThisMonthCheckbox,
            agedRecievablesMonthlyClientCheckbox: $scope.formData.agedRecievablesMonthlyClientCheckbox
        }


    console.log($scope.formDataSearch2);

    $scope.refreshTable = false;

    $scope.loading20 = true;
    $scope.export = null;
    getNumberDocs($scope, $http);

    // populateSummaryTable1($scope,$http);

    // filtersTab2($scope);

}

function searchTab3($scope, $http) {
    if ($scope.invoice_data_summary_report.selected_date_range_order_date.startDate &&
        $scope.invoice_data_summary_report.selected_date_range_order_date.endDate) {
        var start_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_order_date.startDate);
        var end_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_order_date.endDate);


        var isOrderDate = 1;
    }
    else {
        var start_date_order_date = null;
        var end_date_order_date = null;

        var isOrderDate = null;
    }


    //due_date
    if ($scope.invoice_data_summary_report.selected_date_range_due_date.startDate
        && $scope.invoice_data_summary_report.selected_date_range_due_date.endDate) {
        var start_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_due_date.startDate);
        var end_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_due_date.endDate);

        var isDueDate = 1;
    }
    else {
        var start_date_due_date = null;
        var end_date_due_date = null;

        var isDueDate = null;
    }


    var searchBox = $scope.formData.searchBox;
    //var excludeBox = $scope.formData.exclude;

    $scope.formDataSearch =
        {
            search: 1,
            tab: $scope.tabs,
            start_date_order_date: start_date_order_date,
            end_date_order_date: end_date_order_date,
            start_date_due_date: start_date_due_date,
            end_date_due_date: end_date_due_date,
            searchBox: searchBox,
            //excludeBox: excludeBox,
            excludeBox: false, // Always set excludeBox to false for filter
            isOrderDate: isOrderDate,
            isDueDate: isDueDate,
            status: $scope.invstat,
            prepaidReadyReleaseCheckbox: $scope.formData.prepaidReadyReleaseCheckbox,
            readyReleaseThisMonthCheckbox: $scope.formData.readyReleaseThisMonthCheckbox,
            readyReleaseMonthlyClientCheckbox: $scope.formData.readyReleaseMonthlyClientCheckbox
        };

    $scope.refreshTable = false;

    $scope.loading21 = true;
    $scope.export = null;

    getNumberDocs($scope, $http);

}

function searchTab4($scope, $http){

    if ($scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate &&
        $scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate) {
        var start_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate);
        var end_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate);


        var isOrderDate = 1;
    }
    else {
        var start_date_order_date = null;
        var end_date_order_date = null;

        var isOrderDate = null;
    }

    //due_date
    if ($scope.invoice_data_summary_report.selected_date_range_2_due_date.startDate
        && $scope.invoice_data_summary_report.selected_date_range_2_due_date.endDate) {
        var start_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_due_date.startDate);
        var end_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_due_date.endDate);

        var isDueDate = 1;
    }
    else {
        var start_date_due_date = null;
        var end_date_due_date = null;

        var isDueDate = null;
    }

    //last_updated

    if ($scope.invoice_data_summary_report.selected_date_range_2_last_updated.startDate
        && $scope.invoice_data_summary_report.selected_date_range_2_last_updated.endDate) {
        var start_date_last_updated = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_last_updated.startDate);
        var end_date_last_updated = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_last_updated.endDate);

        var isLastUpdated = 1;
    }
    else {
        var start_date_last_updated = null;
        var end_date_last_updated = null;

        var isLastUpdated = null;
    }

    var searchBox = $scope.formData.searchBox2;

    $scope.formDataSearch =
    {
        search: 1,
        tab: $scope.tabs,
        start_date_order_date: start_date_order_date,
        end_date_order_date: end_date_order_date,
        start_date_due_date: start_date_due_date,
        end_date_due_date: end_date_due_date,
        start_date_last_updated: start_date_last_updated,
        end_date_last_updated: end_date_last_updated,
        searchBox: searchBox,
        isOrderDate: isOrderDate,
        isDueDate: isDueDate,
        isLastUpdated: isLastUpdated,
        type: $scope.invtype,
        status: $scope.invstat,
        firstMonthCheckbox: $scope.formData.firstMonthCheckbox,
        firstMonthThisMonthCheckbox: $scope.formData.firstMonthThisMonthCheckbox,
        firstMonthMonthlyClientCheckbox: $scope.formData.firstMonthMonthlyClientCheckbox

    }


    $scope.refreshTable = false;

    $scope.loading22 = true;
    $scope.export = null;
    getNumberDocs($scope, $http);

}

function searchTab5($scope, $http){

    if ($scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate &&
        $scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate) {
        var start_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_order_date.startDate);
        var end_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_order_date.endDate);


        var isOrderDate = 1;
    }
    else {
        var start_date_order_date = null;
        var end_date_order_date = null;

        var isOrderDate = null;
    }

    //due_date
    if ($scope.invoice_data_summary_report.selected_date_range_2_due_date.startDate
        && $scope.invoice_data_summary_report.selected_date_range_2_due_date.endDate) {
        var start_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_due_date.startDate);
        var end_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_due_date.endDate);

        var isDueDate = 1;
    }
    else {
        var start_date_due_date = null;
        var end_date_due_date = null;

        var isDueDate = null;
    }

    //last_updated

    if ($scope.invoice_data_summary_report.selected_date_range_2_last_updated.startDate
        && $scope.invoice_data_summary_report.selected_date_range_2_last_updated.endDate) {
        var start_date_last_updated = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_last_updated.startDate);
        var end_date_last_updated = formatpicker($scope.invoice_data_summary_report.selected_date_range_2_last_updated.endDate);

        var isLastUpdated = 1;
    }
    else {
        var start_date_last_updated = null;
        var end_date_last_updated = null;

        var isLastUpdated = null;
    }

    var searchBox = $scope.formData.searchBox2;

    $scope.formDataSearch =
        {
            search: 1,
            tab: $scope.tabs,
            start_date_order_date: start_date_order_date,
            end_date_order_date: end_date_order_date,
            start_date_due_date: start_date_due_date,
            end_date_due_date: end_date_due_date,
            start_date_last_updated: start_date_last_updated,
            end_date_last_updated: end_date_last_updated,
            searchBox: searchBox,
            isOrderDate: isOrderDate,
            isDueDate: isDueDate,
            isLastUpdated: isLastUpdated,
            type: $scope.invtype,
            status: $scope.invstat,
            finalInvoiceCheckbox: $scope.formData.finalInvoiceCheckbox,
            finalInvoiceThisMonthCheckbox: $scope.formData.finalInvoiceThisMonthCheckbox,
            finalInvoiceMonthlyClientCheckbox: $scope.formData.finalInvoiceMonthlyClientCheckbox
        }


    $scope.refreshTable = false;

    $scope.loading23 = true;
    $scope.export = null;
    getNumberDocs($scope, $http);

}


function searchTab6($scope, $http){

    if ($scope.invoice_data_summary_report.selected_date_range_order_date.startDate &&
        $scope.invoice_data_summary_report.selected_date_range_order_date.endDate) {
        var start_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_order_date.startDate);
        var end_date_order_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_order_date.endDate);


        var isOrderDate = 1;
    }
    else {
        var start_date_order_date = null;
        var end_date_order_date = null;

        var isOrderDate = null;
    }


    //due_date
    if ($scope.invoice_data_summary_report.selected_date_range_due_date.startDate
        && $scope.invoice_data_summary_report.selected_date_range_due_date.endDate) {
        var start_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_due_date.startDate);
        var end_date_due_date = formatpicker($scope.invoice_data_summary_report.selected_date_range_due_date.endDate);

        var isDueDate = 1;
    }
    else {
        var start_date_due_date = null;
        var end_date_due_date = null;

        var isDueDate = null;
    }

    var searchBox = $scope.formData.searchBox6;

    $scope.formDataSearch =
        {
            search: 1,
            tab: $scope.tabs,
            start_date_order_date: start_date_order_date,
            end_date_order_date: end_date_order_date,
            start_date_due_date: start_date_due_date,
            end_date_due_date: end_date_due_date,
            searchBox: searchBox,
            //excludeBox: excludeBox,
            excludeBox: false, // Always set excludeBox to false for filter
            isOrderDate: isOrderDate,
            isDueDate: isDueDate,
            status: $scope.invstat,
            paidInvoiceCheckbox: $scope.formData.paidInvoiceCheckbox,
            paidInvoiceThisMonthCheckbox: $scope.formData.paidInvoiceThisMonthCheckbox,
            paidInvoiceMonthlyClientCheckbox: $scope.formData.paidInvoiceMonthlyClientCheckbox
        }


    console.log($scope.formDataSearch);
    console.log("Searching tab 6..");
    console.log($scope);

    $scope.refreshTable = false;

    $scope.loadingSearch6 = true;
    $scope.export = null;
    getNumberDocs($scope, $http);

}


//refresh
function refreshtab1($scope, $http) {
    $scope.formData.searchBox = "";
    //$scope.formData.exclude = true;
    $scope.formData.exclude = false;


    $scope.invoice_data_summary_report.selected_date_range_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_due_date = {startDate: null, endDate: null};

    $scope.refreshTable = true;
    $scope.formDataSearch = null;
    $scope.export = null;


    $scope.formData.Invoice_Status = null;

    $scope.invstat = "";
    $scope.invstat = null;


    //loading
    $scope.export_loading = false;
    $scope.loading6 = false;//search button tab 1
    $scope.loading20 = false;//search button tab 2

    getNumberDocs($scope, $http);

}

function refreshtab2($scope, $http) {
    $scope.formData.searchBox2 = "";
    $scope.formData.active = true;//tab 2
    $scope.formData.inactive = false;//tab 2

    $scope.invoice_data_summary_report.selected_date_range_2_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_2_due_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_2_last_updated = {startDate: null, endDate: null};

    $scope.refreshTable = true;
    $scope.formDataSearch = null;


    $scope.formData.Invoice_Type = null;
    $scope.formData.Invoice_Status = null;


    $scope.invtype = "";
    $scope.invstat = "";
    $scope.invtype = null;
    $scope.invstat = null;

    $scope.export = null;

    //loading
    $scope.export_loading = false;
    $scope.loading6 = false;//search button tab 1
    $scope.loading20 = false;//search button tab 2

    getNumberDocs($scope, $http);

}

function refreshtab4($scope, $http){
    $scope.formData.searchBox2 = "";


    $scope.invoice_data_summary_report.selected_date_range_2_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_2_due_date = {startDate: null, endDate: null};

    $scope.refreshTable = true;
    $scope.formDataSearch = null;


    $scope.formData.Invoice_Type = null;
    $scope.formData.Invoice_Status = null;


    $scope.invtype = "";
    $scope.invstat = "";
    $scope.invtype = null;
    $scope.invstat = null;

    $scope.export = null;

    //loading
    $scope.export_loading = false;

    getNumberDocs($scope, $http);
}

function refreshtab5($scope, $http) {
    $scope.formData.searchBox2 = "";


    $scope.invoice_data_summary_report.selected_date_range_2_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_2_due_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_2_last_updated = {startDate: null, endDate: null};

    $scope.refreshTable = true;
    $scope.formDataSearch = null;


    $scope.formData.Invoice_Type = null;
    $scope.formData.Invoice_Status = null;


    $scope.invtype = "";
    $scope.invstat = "";
    $scope.invtype = null;
    $scope.invstat = null;

    $scope.export = null;

    //loading
    $scope.export_loading = false;

    getNumberDocs($scope, $http);

}

function refreshtab6($scope, $http) {
    $scope.formData.searchBox6 = "";

    $scope.invoice_data_summary_report.selected_date_range_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_due_date = {startDate: null, endDate: null};

    $scope.refreshTable = true;
    $scope.formDataSearch = null;
    $scope.export = null;


    $scope.formData.Invoice_Status = null;

    $scope.invtype = null;
    $scope.invstat = null;

    $scope.export = null;

    //loading
    $scope.export_loading = false;
    $scope.loading6 = false;//search button tab 1
    $scope.loading20 = false;//search button tab 2
    $scope.loadingSearch6 = false;//search button tab 6

    getNumberDocs($scope, $http);

}


function refreshtab3($scope, $http, rmrks) {


    if (!rmrks) {
        $scope.refreshTable = true;
    }


    $scope.formData.searchBox = "";
    //$scope.formData.exclude = true;
    $scope.formData.exclude = false;


    $scope.invoice_data_summary_report.selected_date_range_order_date = {startDate: null, endDate: null};
    $scope.invoice_data_summary_report.selected_date_range_due_date = {startDate: null, endDate: null};

    $scope.refreshTable = true;
    $scope.formDataSearch = null;
    $scope.export = null;


    $scope.formData.Invoice_Status = null;

    $scope.invstat = "";
    $scope.invstat = null;

    //loading
    $scope.export_loading = false;
    $scope.loading6 = false;//search button tab 1
    $scope.loading20 = false;//search button tab 2
    $scope.loading21 = false;
    $scope.loading22 = false; //search button tab 4

    getNumberDocs($scope, $http);
}


//dropdown for tab 2

function populateDropdown($scope, $http) {
    $scope.invoice_type = [];
    $scope.invoice_status = [];

    angular.forEach(Invoice_Type, function (value, key) {

        $scope.invoice_type.push({
            value: key,
            display: value
        });

    });

    angular.forEach(Invoice_Status, function (value, key) {

        $scope.invoice_status.push({
            value: key,
            display: value
        });
    });


}


function syncLastDateUpdated($scope, $http) {

    var url = ($scope.report_data ? "/invoice-reporting/loop-client-docs?order_id=" + $scope.report_data.order_id
        : "/invoice-reporting/loop-client-docs");


    $http({
        method: 'GET',
        url: API_URL + url,
    }).success(function (response) {
        console.log(response);
    }).error(function (response) {
        console.log(response);
    });

}


function formatpicker(date) {
    var formattedDate = new Date(date);
    var d = formattedDate.getDate();
    var m = formattedDate.getMonth();
    m += 1;
    var y = formattedDate.getFullYear();


    return m + "/" + d + "/" + y;


}

function filtersTab2($scope) {

    var temp = [];

    angular.forEach($scope.dataSummary2, function (value, key) {

        if ($scope.formData.active) {
            if ($scope.invtype) {
                if (value.active == 'active' && value.items.item_type == $scope.invtype) {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }

            }
            else if ($scope.invstat) {
                if (value.active == 'active' && value.status == $scope.invstat) {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }
            }
            else if ($scope.invtype && $scope.invstat) {
                if (value.active == 'active' && (value.status == $scope.invstat || value.items.item_type == $scope.invtype)) {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }
            }
            else {
                if (value.active == 'active') {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }
            }
        } else {
            if ($scope.invtype) {
                if (value.active == 'inactive' && value.items.item_type == $scope.invtype) {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }

            }
            else if ($scope.invstat) {
                if (value.active == 'inactive' && value.status == $scope.invstat) {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }
            }
            else if ($scope.invtype && $scope.invstat) {
                if (value.active == 'inactive' && (value.status == $scope.invstat || value.items.item_type == $scope.invtype)) {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }
            }
            else {
                if (value.active == 'inactive') {
                    temp.push({

                        _id: value._id,
                        active: value.active,
                        apply_gst: value.apply_gst,
                        available_balance: value.available_balance,
                        client_fname: value.client_fname,
                        client_lname: value.client_lname,
                        comments: value.comments,
                        currency: value.currency,
                        due_date: value.due_date,
                        index: value.index,
                        items: value.items,
                        order_date: value.order_date,
                        order_id: value.order_id,
                        payment_advice: value.payment_advice,
                        status: value.status,
                        total_amount: value.total_amount
                    });
                }
            }
        }

    });


    //$scope.dataSummary2 = temp;
    //
    // console.log(temp);
    // console.log($scope.dataSummary2);
    //
    // $scope.dataSummary2 = temp;
    //

}


function exportData($scope, $http) {
    $scope.export = 1;

    $scope.export_loading = true;


    exportDataTab2($scope, $http)

    // if($scope.tabs == 2)
    // {
    //     exportDataTab2($scope,$http)
    // }
    // else
    // {   populateSummaryTable1($scope,$http);
    // }

}

function exportDataTab2($scope, $http) {
    var tabNumber = $scope.tabs;
    var form_data = {};


    form_data.export = 1;

    if ($scope.formDataSearch) {
        form_data = $scope.formDataSearch;

    }


    if (tabNumber == 1) {
        form_data.exclude = $scope.formData.exclude;
    }
    else if (tabNumber == 2) {
        form_data.active = $scope.formData.active;
        form_data.inactive = $scope.formData.inactive;
    }
    else {
        form_data.admin_id = $scope.admin_id;
    }


    form_data.tab = tabNumber;

    console.log("Exporting data..");
    console.log(form_data);
    form_data.exclude = false; // Remove exclusion.
    form_data.active = false; // Remove exclusion.
    $http({
        method: 'POST',
        url: API_URL + "/invoice-reporting/export-tab2",
        data: form_data
    }).success(function (response) {
        console.log(response);

        if (response.success) {

            $scope.export_loading = false;

            var grid_id = response.grid_data._id;

            var url = API_URL + "/invoice-reporting/exports-by-id?id=" + grid_id;

            window.location.assign(url);
        }
        else {
            $scope.export_loading = false;

            alert('Failed to export data, please try again.');
        }

    });


}


rs_module.controller('InvoiceSummaryReportingController', ["$scope", "$stateParams", "$http", "$modal", "$location", "toaster", "SweetAlert", InvoiceSummaryReportingController]);
rs_module.controller('AddNotesModal', ["$scope", "$modalInstance", "$http", "$invoker", AddNotesModal]);
// rs_module.controller('AlertModal',["$scope", "$modalInstance", "$http", "$invoker",AlertModal]);