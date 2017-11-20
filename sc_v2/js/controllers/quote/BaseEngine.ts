interface BaseEngine{

    process():void;

    setApiUrl(apiUrl:string):void;

    getApiUrl():string;

    setScope($scope:any):void;

    setStateParams($stateParams:any):void;

    setToaster(toaster:any):void;

    getToaster():any;

    getScope():any;

    getStateParams():any;

    setHttp($http:any):void;

    getHttp():any;

    setModal($modal:any):void;

    getModal():any;

    setSce($sce:any):void;

    getSce():any;


}


export {BaseEngine};