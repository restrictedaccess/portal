/**
 * Controller for Client Setting
 * 
 * @version 1 - Initial Commit
 */

function QuoteIndexController($scope, $stateParams, $http, $modal, toaster){

	
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		console.log("Hello World");
	};
	
	$scope.initForm();
}




rs_module.controller('QuoteIndexController',["$scope", "$stateParams","$http", "$modal", "toaster", QuoteIndexController]);