var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
define(["require", "exports", "./QuoteEngine"], function (require, exports, QuoteEngine_1) {
    "use strict";
    var MainEngine = (function (_super) {
        __extends(MainEngine, _super);
        function MainEngine() {
            _super.apply(this, arguments);
        }
        MainEngine.prototype.process = function () {
            var $scope = this.getScope();
            var $http = this.getHttp();
            var $sce = this.getSce();
            var $modal = this.getModal();
            var $toaster = this.getToaster();
            var $stateParams = this.getStateParams();
            var API_URL = jQuery("#NJS_API_URL").val();
            $scope.currentPage = 1,
                $scope.numberPage = 20,
                $scope.maxSize = 10;
            $scope.totalItems = 20;
            $scope.bigItems = 175;
            $scope.leads = null;
            $scope.linkEnabled = false;
            $scope.query = {};
            $scope.queryBy = '$';
            $scope.searchData = {};
            $scope.quote_controller.selected_date_range = { startDate: new Date(), endDate: new Date() };
            $scope.initForm = function () {
                console.log("test");
                $scope.leads = null;
                $http.get(API_URL + "/quote/get-all-leads").success(function (response) {
                }).success(function (data) {
                    $scope.leads = data.data;
                    $scope.loading6 = false;
                });
            };
            $scope.generateQuoteMain = function (id) {
                generate_quote_main(id, $http, $modal, $toaster);
            };
            $scope.search = function () {
                search($scope, $stateParams, $http, $modal, $toaster);
            };
            $scope.refresh = function () {
                refresh($scope, $stateParams, $http, $modal, $toaster);
            };
            $scope.initForm();
            function search($scope, $stateParams, $http, $modal, toaster) {
                $scope.loading5 = true;
                var sendParams = {};
                var startDate = new Date().toISOString().slice(0, 10);
                var endDate = new Date().toISOString().slice(0, 10);
                if ($scope.quote_controller.selected_date_range.startDate._d && $scope.quote_controller.selected_date_range.endDate._d) {
                    startDate = new Date($scope.quote_controller.selected_date_range.startDate._d).toISOString().slice(0, 10);
                    endDate = new Date($scope.quote_controller.selected_date_range.endDate._d).toISOString().slice(0, 10);
                }
                if ($scope.query.$) {
                    sendParams.filter = $scope.query.$;
                }
                sendParams.startDate = startDate;
                sendParams.endDate = endDate;
                $http({
                    method: 'POST',
                    url: API_URL + "/quote/search-main",
                    data: sendParams
                }).success(function (response) {
                    console.log(response);
                    $scope.loading5 = false;
                    if (response.success) {
                        $scope.leads = response.data;
                    }
                    else {
                    }
                }).error(function (response) {
                    $scope.loading5 = false;
                    alert("error on getting your search");
                });
            }
            function refresh($scope, $stateParams, $http, $modal, toaster) {
                console.log('refresh');
                $scope.quote_controller.selected_date_range = { startDate: new Date(), endDate: new Date() };
                $scope.query.$ = "";
                $scope.loading6 = true;
                $scope.leads = null;
                $scope.initForm();
            }
            function generate_quote_main(id, $http, $modal, toaster) {
                console.log(id);
                var data = {
                    created_by: jQuery("#ADMIN_ID").val(),
                    created_by_type: "admin",
                    leads_id: id
                };
                $http({
                    method: 'POST',
                    url: API_URL + "/quote/generate-quote",
                    data: data
                }).success(function (response) {
                    console.log(response);
                    if (response.success) {
                        toaster.pop({
                            type: 'success',
                            title: 'Quote',
                            body: response.msg,
                            showCloseButton: true,
                        });
                        syncQ(id, $http, $modal, toaster);
                        window.location.href = "/portal/sc_v2/#/quote/details/?quote_id=" + response.quote_id;
                    }
                    else {
                        toaster.pop({
                            type: 'error',
                            title: 'Quote',
                            body: response.error,
                            showCloseButton: true,
                        });
                    }
                }).error(function (response) {
                    alert("There's a problem in generating new quote. Please try again later.");
                });
            }
            function syncQ(id, $http, $modal, toaster) {
                var BASE_URL = jQuery("#BASE_API_URL").val();
                $http({
                    method: 'GET',
                    url: BASE_URL + "/mongo-index/sync-quote"
                }).success(function (response) {
                    console.log(response);
                    if (response.success) {
                        console.log('synced');
                    }
                    else {
                        console.log('!synced');
                    }
                }).error(function (response) {
                    console.log('!synced');
                });
            }
        };
        return MainEngine;
    }(QuoteEngine_1.QuoteEngine));
    exports.MainEngine = MainEngine;
});
//# sourceMappingURL=MainEngine.js.map