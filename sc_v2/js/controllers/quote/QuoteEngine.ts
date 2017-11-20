import {BaseEngine} from "./BaseEngine";
declare var jQuery:any;


abstract class QuoteEngine implements BaseEngine{
    /**
     * VARIABLES
     */
    private $scope:any;

    private $stateParams:any;

    private $http:any;

    private $sce:any;

    private $modal:any;

    private api_url:string;

    private $controller:any;

    private toaster:any;

    /**
     * Abstract functions
     */
    abstract process():any;


    /**
     * Function Definitions
     */
    public setApiUrl(apiUrl:string):void{
        this.api_url = apiUrl;
    };

    public getApiUrl():string{
        return this.api_url;
    };

    public setScope($scope:any):void{
        this.$scope = $scope;
    }

    public setStateParams($stateParams:any):void{
        this.$stateParams = $stateParams;
    }

    public getScope():any{
        return this.$scope;
    }

    public getStateParams():any{
        return this.$stateParams;
    }

    public setHttp($http:any):void{
        this.$http = $http;
    };

    public getHttp():any{
        return this.$http;
    };

    public setSce($sce:any):void{
        this.$sce = $sce;
    };

    public getSce():any{
        return this.$sce;
    };


    public setModal($modal:any):void{
        this.$modal = $modal;
    };

    public getModal():any{
        return this.$modal;
    };

    public setController($controller:any):void{
        this.$controller = $controller;
    };

    public getController():any{
        return this.$controller;
    };

    public setToaster(toaster:any){
        this.toaster = toaster;
    }

    public getToaster():any{
        return this.toaster;
    }
}

export {QuoteEngine};
