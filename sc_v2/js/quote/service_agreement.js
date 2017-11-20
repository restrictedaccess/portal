function SAController($scope, $stateParams, $http, $modal, toaster){

    $scope.quote_id = $stateParams.quote_id;
    $scope.quote = null;
    $scope.admin_id = jQuery("#ADMIN_ID").val();
    $scope.sa = null;

    //for pagination
    $scope.currentPage = 1,
    $scope.numberPage = 5,
    $scope.maxSize = 5;


    $scope.initForm = function(){

        getQuoteDetails($scope, $stateParams, $http, $modal, toaster);
    };


    function getQuoteDetails($scope, $stateParams, $http, $modal, toaster) {
        $scope.quote = null;
        var API_URL = jQuery("#NJS_API_URL").val();

        if($scope.quote_id)
        {
            $http.get(API_URL+"/quote/show/?id="+$scope.quote_id).success(function(response) {
                $scope.quote = response.data;
                $scope.sa = response.data.service_agreements;

                //window.location.href = "/portal/sc_v2/#/quote/service_agreement_info/"+$scope.quote_id+"/"+$scope.sa[0].id

                // console.log($scope.sa[0].id);
            });

        }
        else {
            alert("Quote id is not found.")
        }


    }


    $scope.formatDate = function(unixtime) {
        var d = new Date(unixtime);
        var n =  d.toDateString();
        return n;
    };



    $scope.convertToSA = function(){

        $scope.loading5 = true;
        var BASE_URL = jQuery("#BASE_API_URL").val();
        $scope.formData = {quote_id : $scope.quote_id, id:$scope.admin_id, type:'admin'};

        // console.log($scope.formData);


        $http({
            method: 'GET',
            url:BASE_URL+"/quote/convert-quote-to-service-agreement/?quote_id="+$scope.quote_id+"&id="+$scope.admin_id+"&type=admin"
        }).success(function(response) {
            // console.log(response);

            if(response.success){

                toaster.pop({
                    type: 'success',
                    title: 'SA',
                    body: "Converted to SA",
                    showCloseButton: true,
                });
                $scope.syncSA();
                $scope.initForm();
                $scope.loading5 = false;

            }else{
                toaster.pop({
                    type: 'error',
                    title: 'Failed to convert',
                    body: response.error,
                    showCloseButton: true,
                });
                $scope.loading5 = false;
            }


        }).error(function(response){
            //$scope.loading5 = false;
            alert("There's a problem converting to SA.");
            $scope.loading5 = false;
        });


    };

    $scope.syncSA = function(){
    var BASE_URL = jQuery("#BASE_API_URL").val();
        $http({
            method: 'GET',
            url:BASE_URL+"/mongo-index/sync-quote?quote_id="+$scope.quote_id
        }).success(function(response) {
            // console.log(response);

            if(response.success){

                console.log('synced')

            }else{
                console.log('!synced')
            }


        }).error(function(response){
            console.log('!synced')
        });

    };

    $scope.initForm();

}


rs_module.controller('SAController',["$scope", "$stateParams","$http", "$modal", "toaster", SAController]);
