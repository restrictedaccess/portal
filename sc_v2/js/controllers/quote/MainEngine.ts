import {QuoteEngine} from "./QuoteEngine";
declare var jQuery:any;
declare let angular:any;

class MainEngine extends QuoteEngine
{
    public process(){

        let $scope = this.getScope();

        let $http = this.getHttp();

        let $sce = this.getSce();

        let $modal = this.getModal();

        let $toaster = this.getToaster();

        let $stateParams = this.getStateParams();

        var API_URL = jQuery("#NJS_API_URL").val();
        $scope.currentPage = 1,
        $scope.numberPage = 20,
        $scope.maxSize = 10;
        $scope.totalItems = 20;
        $scope.bigItems = 175;
        $scope.leads=null;
        $scope.linkEnabled = false;
        $scope.query = {};
        $scope.queryBy = '$';

        $scope.searchData={};
        $scope.quote_controller.selected_date_range = {startDate: new Date(), endDate: new Date()};

        $scope.initForm = function(){
            console.log("test");
            $scope.leads = null;
            $http.get(API_URL+"/quote/get-all-leads").success(function(response){
            }).success(function(data){
                $scope.leads = data.data;
                $scope.loading6 = false;
            });


        };

        $scope.generateQuoteMain = function(id:any){

            //console.log(id);
            generate_quote_main(id,$http,$modal, $toaster);
        };


        $scope.search = function(){

            search($scope, $stateParams, $http, $modal, $toaster);
        };


        $scope.refresh = function(){

            refresh($scope, $stateParams, $http, $modal, $toaster);
        };


        $scope.initForm();



        //functions for search,refresh data and to generate a quote

        //search function
        function search($scope:any, $stateParams:any, $http:any, $modal:any, toaster:any)
        {
            $scope.loading5 = true;
            var sendParams:any = {};
            var startDate= new Date().toISOString().slice(0,10);
            var endDate= new Date().toISOString().slice(0,10);

            if($scope.quote_controller.selected_date_range.startDate._d && $scope.quote_controller.selected_date_range.endDate._d){
                startDate = new Date($scope.quote_controller.selected_date_range.startDate._d).toISOString().slice(0,10);
                endDate = new Date($scope.quote_controller.selected_date_range.endDate._d).toISOString().slice(0,10);
            }
            if(	$scope.query.$)
            {
                sendParams.filter = $scope.query.$;
            }

            sendParams.startDate = startDate;
            sendParams.endDate = endDate;

            $http({
                method: 'POST',
                url:API_URL+"/quote/search-main",
                data: sendParams
            }).success(function(response) {
                console.log(response);
                $scope.loading5 = false;
                if(response.success){

                    $scope.leads = response.data;

                }else{

                }


            }).error(function(response){
                //$scope.loading5 = false;
                $scope.loading5 = false;
                alert("error on getting your search");
            });

        }


        //refresh function
        function refresh($scope:any, $stateParams:any, $http:any, $modal:any, toaster:any)
        {
            console.log('refresh');
            $scope.quote_controller.selected_date_range = {startDate: new Date(), endDate: new Date()};
            $scope.query.$ = "";
            $scope.loading6 = true;

            $scope.leads = null;
            $scope.initForm();
        }


        //generate quote function
        function generate_quote_main(id:any,$http:any,$modal:any, toaster:any){

            console.log(id);

            // var API_URL = jQuery("#NJS_API_URL").val();
            // if(confirm("This will generate a draft Quote.")){
            //$scope.loading5 = true;
            var data = {
                created_by : jQuery("#ADMIN_ID").val(),
                created_by_type:"admin",
                leads_id : id
            };


            $http({
                method: 'POST',
                url:API_URL+"/quote/generate-quote",
                data: data
            }).success(function(response) {
                console.log(response);

                //console.log(response);
                //$scope.loading5 = false;
//
                if(response.success){
                    toaster.pop({
                        type: 'success',
                        title: 'Quote',
                        body: response.msg,
                        showCloseButton: true,
                    });


                    syncQ(id,$http,$modal, toaster);
                    window.location.href = "/portal/sc_v2/#/quote/details/?quote_id="+response.quote_id;

                    // get_leads_quote($scope,$stateParams, $http, toaster);
                }else{
                    toaster.pop({
                        type: 'error',
                        title: 'Quote',
                        body: response.error,
                        showCloseButton: true,
                    });
                }


            }).error(function(response){
                //$scope.loading5 = false;
                alert("There's a problem in generating new quote. Please try again later.");
            });
            // }
            //$scope.loading5 = true;
        }

        function syncQ(id:any,$http:any,$modal:any, toaster:any){

            var BASE_URL = jQuery("#BASE_API_URL").val();
            $http({
                method: 'GET',
                url:BASE_URL+"/mongo-index/sync-quote"
            }).success(function(response) {
                console.log(response);

                if(response.success){

                    console.log('synced');
                }else{
                    console.log('!synced')
                }


            }).error(function(response){
                console.log('!synced')
            });

        }

    }
}
export {MainEngine}