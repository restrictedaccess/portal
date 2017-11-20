/**
 * Created by Ganja on 05/06/2017.
 */
var njs_url = angular.element("#NJS_API_URL").val();
var api_url = angular.element("#BASE_API_URL").val();
var django_url = angular.element("#DJANGO_URL").val();

function SubconlistReportingController($scope, $http, $modal, toaster, $timeout) {
    var django = django_url + "/subcontractors/search_subconlist_reporting/";
    $scope.loading = false;
    $scope.exportShow = false;
    $scope.sc = [];
    $scope.clients = {};

    $scope.selected_date_range = {};

    $scope.refreshForm = function() {
        $scope.selectedSC = null;
        $scope.selectedClient = [];
        $scope.selected_date_range = {};
    };

    $scope.getClientSc = function(data) {
        if (!$scope.loading) {
            $scope.loading = true;

            $http({
                method: 'POST',
                url: django,
                data: {Query: data}
            }).success(function (response) {
                console.log(response);
                if (response.success) {
                    var docID = response.doc_id;
                    callRender(docID);
                }
            }).error(function (response) {
                alert("There's something wrong in updating adjusted hours. Please try again later.");
                angular.element("#submitSearch").text("Search");
                $scope.loading = false;
            });
        }else {
            console.log("disabled");
            return false;
        }
    };

    var admin_id = null;

    function callRender(docID) {
        renderDataTable(docID);
    }

    function renderDataTable(docID) {
        $timeout( function(){
            $http({
                method: 'GET',
                url: django_url + "/subcontractors/render_subconlist_reporting_result/" + docID
            }).success(function(response) {
                console.log(response);
                if (response) {
                    if (response != 'total_log_hrs' && response != 'total_adj_hrs') {
                        toaster.success("Table has been rendered");
                        $scope.exportShow = true;
                        var dl_url = django_url + '/subcontractors/subconlist_reporting/export_subconlist_reporting/' + docID;
                        angular.element('#exportBtn').attr('href', dl_url);
                        angular.element("#appendTable").html(response);

                        $scope.loading = false;
                        angular.element("#submitSearch").text("Search");
                    }else {
                        callRender(docID);
                    }
                }else {
                    $scope.loading = false;
                    toaster.warning("No data to be rendered");
                }
            }).error(function(response){
                alert("There's something wrong in updating adjusted hours. Please try again later.");
            });
        }, 3000 );
    }

    $scope.getClientAndSc = function() {
        $http({
            method: 'GET',
            // url: "http://devs.remotestaff.com.au/portal/django/subcontractors/subconlist_reporting/"
            url: api_url + "/timesheet-weeks/load-defaults/?admin_id=" + admin_id
        }).success(function(response) {
            console.log(response);
            if (response.success) {
                $scope.selectedSC = null;
                $scope.selectedClient = [];
                $scope.sc = response.defaults.staffing_consultants;
                $scope.clients = response.defaults.all_clients;
            }
        }).error(function(response){
            alert("There's something wrong in updating adjusted hours. Please try again later.");
        });
    };
    $scope.getClientAndSc();

    $scope.submitSearch = function() {
        var adminID = angular.element("#ADMIN_ID").val();
        angular.element("#submitSearch").text("Loading ...");
        var start = $scope.selected_date_range.startDate;
        var end = $scope.selected_date_range.endDate;
        if (start && end) {
            var sString = start.format("YYYY-MM-DD");
            var eString = end.format("YYYY-MM-DD");
        }else {
            angular.element("#submitSearch").text("Search");
            toaster.warning("Date range is required and shouldn't have the same day");
            return false;
        }
        var range = moment.range(start, end);
        var selected_months = range.diff('months', true);
        if (selected_months <= 3) {
            var staff = '';
            // var staff = $scope.selectedSC.admin_id;
            var clients = [];
            angular.forEach($scope.selectedClient, function(value, index) {
                clients.push(value.leads_id);
            });

            var data = {
                "clients": clients,
                "csro_id": staff,
                "end_date": eString,
                "start_date": sString,
                "admin_id": adminID
            };
            $scope.getClientSc(data);
        }else {
            angular.element("#submitSearch").text("Search");
            toaster.warning("Start date and End date are not within 3 months");
        }
    }
}

rs_module.controller('SubconlistReportingController',["$scope", "$http", "$modal", "toaster", "$timeout", SubconlistReportingController]);