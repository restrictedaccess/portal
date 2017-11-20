import {MainEngine} from "controllers/quote/MainEngine";

declare let rs_module: any;
declare let jQuery: any;

function QuoteController($scope: any, $stateParams:any, $sce: any, $location: any, $http: any, $modal: any, toaster: any)
{
    let mainEngine = new MainEngine();
    mainEngine.setScope($scope);
    mainEngine.setHttp($http);
    mainEngine.setSce($sce);
    mainEngine.setModal($modal);
    mainEngine.setStateParams($stateParams);
    mainEngine.process();

}

rs_module.controller('QuoteController', ["$scope", "$stateParams", "$sce", "$location", "$http", "$modal", "toaster", QuoteController]);

