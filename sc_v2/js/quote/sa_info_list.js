function ServiceAgreementList($scope, $stateParams, $http, $modal, toaster){


    $scope.leads_id = ($stateParams.leads_id ? $stateParams.leads_id : null);
    $scope.quoteStatus = ($stateParams.status ? $stateParams.status : "");


    $scope.initForm = function(){
        var API_URL = jQuery("#NJS_API_URL").val();
        if($stateParams.leads_id){

            $http.get(API_URL+"/quote/get-lead-info/?id="+$stateParams.leads_id).success(function(response){
                $scope.setting = response.data;
                // console.log($scope.setting );

            }).success(function(){

                getSAPending($scope,$stateParams, $http, toaster);
            });

        }
    };


    $scope.formatDate = function(unixtime) {
        var d = new Date(unixtime);
        var n =  d.toDateString();
        return n;
    };

    if($scope.leads_id)
    {
        $scope.initForm();
    }
    else
    {
        console.log("no leads id");
    }


}


function getSAPending($scope, $stateParams, $http, $modal, toaster)
{

    var API_URL = jQuery("#NJS_API_URL").val();
    $scope.filteredResults=[],
        $scope.results=[],
        $scope.currentPage = 1,
        $scope.numberPage = 10,
        $scope.maxSize = 10;
    //Get Leads generated quotes
    $scope.quotes = null;
    var status = "";
    if($stateParams.status || $stateParams.status!="")
    {
        status=$stateParams.status;
    }
    // console.log(status);
    $http.get(API_URL+"/quote/get-leads-quote/?leads_id="+$stateParams.leads_id+"&status="+status).success(function(response){

    }).success(function(data){

        $scope.quotes = data.data;
        console.log($scope.quotes);

    });

}


rs_module.controller('ServiceAgreementList',["$scope", "$stateParams","$http", "$modal", "toaster", ServiceAgreementList]);
