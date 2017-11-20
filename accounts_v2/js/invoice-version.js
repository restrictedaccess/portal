/**
 * Created by Ganja on 27/06/2017.
 */
/**
 * Created by Ganja on 05/06/2017.
 */
var njs_url = angular.element("#NJS_API_URL").val();
var api_url = angular.element("#BASE_API_URL").val();
var django_url = angular.element("#DJANGO_URL").val();

function InvoiceVersionController($scope, $http, $modal, toaster, $timeout, $location) {
    var NJS_API = jQuery("#NJS_API_URL").val();
    var paramValue = $location.search();
    $scope.allVersions = [];
    $scope.latestVersion = null;
    $scope.toVersionData = null;
    $scope.fromVersionData = null;
    $scope.btnLayout = 'List View';


    $scope.changeLayout = function() {
        switch($scope.btnLayout) {
            case 'List View':
                $scope.btnLayout = 'Grid View';
                angular.element("#layoutIcon").removeClass("fa-list-ul").addClass("fa-th-large");
                angular.element("#divFrom").removeClass("col-lg-6 col-md-6 col-sm-6 col-xs-6").addClass("col-lg-12 col-md-12 col-sm-12 col-xs-12");
                angular.element("#divTo").removeClass("col-lg-6 col-md-6 col-sm-6 col-xs-6").addClass("col-lg-12 col-md-12 col-sm-12 col-xs-12");
                break;
            case 'Grid View':
                $scope.btnLayout = 'List View';
                angular.element("#layoutIcon").removeClass("fa-th-large").addClass("fa-list-ul");
                angular.element("#divFrom").removeClass("col-lg-12 col-md-12 col-sm-12 col-xs-12").addClass("col-lg-6 col-md-6 col-sm-6 col-xs-6");
                angular.element("#divTo").removeClass("col-lg-12 col-md-12 col-sm-12 col-xs-12").addClass("col-lg-6 col-md-6 col-sm-6 col-xs-6");
                break;
            default:
        }
    };

    $scope.fetchDataByOrderIdVersion = function (version, position) {
        getDataByOrderIdVersion(paramValue.order_id, version.version, position);
    }


    function initData(position, data){
        console.log(data);
        var items = [];
        // Init Items
        angular.forEach(data.items, function(value, key) {
            items.push({
                amount: value.amount.toFixed(2),
                unit_price: value.unit_price.toFixed(2),
                qty: value.qty,
                description: value.description,
                description: value.description,
                cover_date: {start: value.start_date, end: value.end_date},
                item_id: value.item_id
            });
        });
        var dataInfoTo = {
            updated_on: data.sent_on,
            updated_by: data.added_by,
            sent_on: data.sent_on,
            to: data.client_fname + " " + data.client_lname,
            date_created: data.added_on,
            due_date: data.pay_before_date,
            total_amount_due: data.total_amount.toFixed(2),
            sub_total: data.sub_total.toFixed(2),
            gst: data.gst_amount.toFixed(2),
            items: items
        };

        if(position == "left"){
            $scope.fromVersionData = dataInfoTo;
        } else {
            $scope.toVersionData = dataInfoTo;
        }

    }

    function getAllVersions(order_id) {
        $http.get(NJS_API + "/invoice-versioning/get-all-versions?order_id=" + order_id).success(function(response) {
            console.log(response);
            // Init version list
            angular.forEach(response.result, function(value, key) {
                var versionStr = value.order_id + "-" + value.version;
                $scope.allVersions.push(
                    {
                        version: value.version,
                        versionStr: versionStr
                    }
                );
            });
            console.log($scope.allVersions);
        });
    }

    function getDataByOrderIdVersion(order_id, version, position){
        $http.get(NJS_API + "/invoice-versioning/get-data-by-version?order_id=" + order_id + "&version="+ version).success(function(response) {
            console.log("Data for fetch record via order_id and version "+version + " pos: "+position);
            console.log(response);
            console.log(position);
            if(response.success) {
                if(position == "left"){
                    initData("left", response.result);
                } else {
                    initData("right", response.result);
                }
            } else {
                toaster.pop({
                    type: 'error',
                    title: 'Success',
                    body: "No version record found on the "+position + " pane",
                    showCloseButton: true,
                    timeout: 3000
                });
            }

        });
    }

    function getLatestVersionOnLoad(order_id){
        $http.get(NJS_API + "/invoice-versioning/get-latest-version?order_id=" + order_id).success(function(response) {
            console.log("Latest version");
            console.log(response);

            if(response.success){
                var data = response.result;
                var latest_version = data.version;
                //var previous_version = parseInt(latest_version) - 1;
                // Init Right Items on Load
                initData("right", data);
                // Init Left Items on Load
                $scope.fetchDataByOrderIdVersion({version: 1}, "left");
                // Init Selected Versions
                $scope.fromVersion =
                    {
                        version: 1,
                        versionStr: paramValue.order_id + "-" + 1
                    };

                $scope.toVersion =
                    {
                        version: latest_version,
                        versionStr: paramValue.order_id + "-" + latest_version
                    };
            } else {
                toaster.pop({
                    type: 'error',
                    title: 'Success',
                    body: "No version record found",
                    showCloseButton: true,
                    timeout: 3000
                });
            }




        });
    }

    getAllVersions(paramValue.order_id);
    getLatestVersionOnLoad(paramValue.order_id);
}

rs_module.controller('InvoiceVersionController',["$scope", "$http", "$modal", "toaster", "$timeout", "$location", InvoiceVersionController]);