define(["require", "exports", "controllers/quote/MainEngine"], function (require, exports, MainEngine_1) {
    "use strict";
    function QuoteController($scope, $stateParams, $sce, $location, $http, $modal, toaster) {
        var mainEngine = new MainEngine_1.MainEngine();
        mainEngine.setScope($scope);
        mainEngine.setHttp($http);
        mainEngine.setSce($sce);
        mainEngine.setModal($modal);
        mainEngine.setStateParams($stateParams);
        mainEngine.process();
    }
    rs_module.controller('QuoteController', ["$scope", "$stateParams", "$sce", "$location", "$http", "$modal", "toaster", QuoteController]);
});
//# sourceMappingURL=quote.js.map