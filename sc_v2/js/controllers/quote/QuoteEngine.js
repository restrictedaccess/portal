define(["require", "exports"], function (require, exports) {
    "use strict";
    var QuoteEngine = (function () {
        function QuoteEngine() {
        }
        QuoteEngine.prototype.setApiUrl = function (apiUrl) {
            this.api_url = apiUrl;
        };
        ;
        QuoteEngine.prototype.getApiUrl = function () {
            return this.api_url;
        };
        ;
        QuoteEngine.prototype.setScope = function ($scope) {
            this.$scope = $scope;
        };
        QuoteEngine.prototype.setStateParams = function ($stateParams) {
            this.$stateParams = $stateParams;
        };
        QuoteEngine.prototype.getScope = function () {
            return this.$scope;
        };
        QuoteEngine.prototype.getStateParams = function () {
            return this.$stateParams;
        };
        QuoteEngine.prototype.setHttp = function ($http) {
            this.$http = $http;
        };
        ;
        QuoteEngine.prototype.getHttp = function () {
            return this.$http;
        };
        ;
        QuoteEngine.prototype.setSce = function ($sce) {
            this.$sce = $sce;
        };
        ;
        QuoteEngine.prototype.getSce = function () {
            return this.$sce;
        };
        ;
        QuoteEngine.prototype.setModal = function ($modal) {
            this.$modal = $modal;
        };
        ;
        QuoteEngine.prototype.getModal = function () {
            return this.$modal;
        };
        ;
        QuoteEngine.prototype.setController = function ($controller) {
            this.$controller = $controller;
        };
        ;
        QuoteEngine.prototype.getController = function () {
            return this.$controller;
        };
        ;
        QuoteEngine.prototype.setToaster = function (toaster) {
            this.toaster = toaster;
        };
        QuoteEngine.prototype.getToaster = function () {
            return this.toaster;
        };
        return QuoteEngine;
    }());
    exports.QuoteEngine = QuoteEngine;
});
//# sourceMappingURL=QuoteEngine.js.map