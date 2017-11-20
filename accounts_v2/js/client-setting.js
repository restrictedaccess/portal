/**
 * Controller for Client Setting
 * 
 * @version 1 - Initial Commit
 */

function ClientSettingController($scope, $stateParams, $http, $modal, $location, toaster){

	$scope.client_id = null;
	$scope.result = null;
	
	console.log($location.search());
	
	if($location.search().client_id){
		$scope.client_id = $location.search().client_id;	
	}
		
	$scope.set_currency = function(){
		set_currency($scope);	
	};
	
	
	$scope.save = function(){
		save_setting($scope, $http, toaster);
	};
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		console.log($scope.client_id);
		if($scope.client_id){
			$http.get(API_URL+"/running-balance/get-client-settings/?leads_id="+$scope.client_id).success(function(response){
				if(response.success){
					$scope.result = response.result;	
				}else{
					toaster.pop({
			            type: 'error',
			            title: 'Client Setting',
			            body: response.error,
			            showCloseButton: true,
			        });
				}				
			});
		}
	};
	
	$scope.initForm();
}

function set_currency($scope){
	//console.log($scope.result.apply_gst);
	var gst = $scope.result.apply_gst;
	if(gst == "Y"){
		$scope.result.currency = "AUD";
	}	
}

function save_setting($scope, $http, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	//console.log($scope.result);
	if(confirm("Save Client Setting?")){
		$scope.loading5 = true;
		var data = {
			result : $scope.result,
			admin_id : jQuery("#ADMIN_ID").val(),
			leads_id : $scope.client_id
		};
		
		$http({
			  method: 'POST',
			  url: API_URL+"/running-balance/save-client-setting/",
			  data: data
			}).success(function(response) {								
				
				$scope.loading5 = false;
				
				if(response.success){
					toaster.pop({
			            type: 'success',
			            title: 'Client Setting',
			            body: response.msg,
			            showCloseButton: true,
			        });	
				}else{
					toaster.pop({
			            type: 'error',
			            title: 'Client Setting',
			            body: response.error,
			            showCloseButton: true,
			        });
				}
				//$scope.result = response.result;
				$scope.result.history = response.history;
			}).error(function(response){
				$scope.loading5 = false;
				alert("There's a problem in adjusting timesheet. Please try again later.");
			});
	}	
	//$scope.loading5 = true;
}


rs_module.controller('ClientSettingController',["$scope", "$stateParams","$http", "$modal", "$location", "toaster", ClientSettingController]);