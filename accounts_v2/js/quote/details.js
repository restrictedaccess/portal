/**
 * Controller for Client Setting
 * 
 * @version 1 - Initial Commit
 */

function QuoteDetailsController($scope, $stateParams, $http, $modal, toaster){

	$scope.quote_id = $stateParams.quote_id;
	$scope.quote = null;
	$scope.quote_details = null;
	
	if(!$stateParams.quote_id){
		alert("Quote Id is missing");
	}
	
	$scope.openModalQuoteDetails = function(){
		
		//console.log(ctrl);
		
		var modalInstance = $modal.open({
            templateUrl: 'views/common/quote/details/modal_quote_details_form.html',
            controller: QuoteDetailsModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{
            	
            	$invoker:function(){
            		return $scope;
            	}
            	
            }
        });
        
        
	};
	
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		if($stateParams.quote_id){
			
					
			//Leads Currency Setting
			$http.get(API_URL+"/quote/show/?quote_id="+$stateParams.quote_id).success(function(response){
				$scope.quote = response.quote;				
			});
			

			
			
			
		}
	};
	
	$scope.initForm();
}


function QuoteDetailsModalInstanceCtrl($scope, $modalInstance, $http, $invoker) {
	var API_URL = jQuery("#BASE_API_URL").val();
	
	$scope.formData = {};
	
	$scope.quote_id = $invoker.quote_id;
	$scope.client_setting = $invoker.quote.client_setting;
	console.log($invoker.quote.client_setting);
	
	//get all endorsed and interviewed candidates for this lead.
	$http.get(API_URL+"/utilities/get-endorsed-interviewed-candidates/?leads_id="+$invoker.quote.client.id).success(function(response){
		$scope.endorsed_candidates = response.applicants;				
	});
	
	
	$scope.add_details = function() {
		//$scope.loading5 = true;
		console.log($scope.formData);
	};
	
	
	$scope.close_quote_details = function () {
        $modalInstance.dismiss('cancel');
    };
}

rs_module.controller('QuoteDetailsController',["$scope", "$stateParams","$http", "$modal", "toaster", QuoteDetailsController]);
rs_module.controller('QuoteDetailsModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker",QuoteDetailsModalInstanceCtrl]);

