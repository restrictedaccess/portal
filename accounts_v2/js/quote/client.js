/**
 * Controller for Client Setting
 * 
 * @version 1 - Initial Commit
 */

function ClientQuoteController($scope, $stateParams, $http, $modal, toaster){

	console.log($stateParams);

	$scope.leads_id = $stateParams.leads_id;
	//$scope.profile = null;
	$scope.setting = null;
	
	if(!$stateParams.leads_id){
		alert("Leads Id is missing");
	}
	
	$scope.generateQuote = function(){
		generate_quote($scope, $http, toaster);
	};
	
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		if($stateParams.leads_id){
			
			//Leads Profile
			//$http.get(API_URL+"/leads/get-leads-profile-by-id?id="+$stateParams.leads_id).success(function(response){
			//	$scope.profile = response.profile;				
			//});
			
			//Leads Currency Setting
			$http.get(API_URL+"/running-balance/get-client-settings/?leads_id="+$stateParams.leads_id).success(function(response){
				$scope.setting = response.result;				
			});
			
			get_leads_quote($scope, $http, toaster);
			
			
			
		}
	};
	
	$scope.initForm();
}

function get_leads_quote($scope, $http, toaster){
	$scope.filteredResults=[],
	$scope.currentPage = 1,
	$scope.numberPage = 10,
	$scope.masSize = 5;
	//Get Leads generated quotes
	$scope.quotes = null;
	var API_URL = jQuery("#BASE_API_URL").val();
	$http.get(API_URL+"/quote/get-leads-quote/?leads_id="+$scope.leads_id).success(function(response){
		$scope.quotes = response.quotes;
		
			$scope.$watch('currentPage + numberPage',function(){
				var begin = (($scope.currentPage -1)*$scope.numberPage),
				end = begin + $scope.numberPage;
				
				$scope.filteredResults = $scope.quotes.slice(begin,end);
			});			
	});
	
}
function generate_quote($scope, $http, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	if(confirm("This will generate a draft Quote.")){
		$scope.loading5 = true;
		var data = {
			admin_id : jQuery("#ADMIN_ID").val(),
			leads_id : $scope.leads_id
		};
		
		$http({
			  method: 'POST',
			  url: API_URL+"/quote/generate/",
			  data: data
			}).success(function(response) {								
				
				$scope.loading5 = false;
				
				if(response.success){
					toaster.pop({
			            type: 'success',
			            title: 'Quote',
			            body: response.msg,
			            showCloseButton: true,
			        });	
			        get_leads_quote($scope, $http, toaster);
				}else{
					toaster.pop({
			            type: 'error',
			            title: 'Quote',
			            body: response.error,
			            showCloseButton: true,
			        });
				}

			}).error(function(response){
				$scope.loading5 = false;
				alert("There's a problem in generating new quote. Please try again later.");
			});
	}	
	//$scope.loading5 = true;
}



rs_module.controller('ClientQuoteController',["$scope", "$stateParams","$http", "$modal", "toaster", ClientQuoteController]);