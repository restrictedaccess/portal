/**
 * Controller for Invoice Printable version
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2016-11-09
 */

function PrintInvoiceController($scope, $stateParams, $http, $modal, $location,toaster){
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	//console.log(NJS_API);
	console.log($stateParams.order_id);
	$scope.order_id = null;
	$scope.invoice = null;
	$scope.client_basic_info = null;
	$scope.print_invoice_controller.total_amount = null;
	$scope.rs_numbers = null;

	$scope.initForm = function(){
				
		if($stateParams.order_id){
			$scope.order_id = $stateParams.order_id;
			
			getRsNumbers($scope, $http);
			//getInvoiceDetails($scope, $http);	
		}
	};
	
	$scope.initForm();
}

function getRsNumbers($scope, $http){
	var BASE_API_URL = jQuery("#BASE_API_URL").val();
	//console.log($scope.order_id);	

	var url = BASE_API_URL + "/utilities/rs-company-phone-numbers";

	$http.get(url).success(function(response){
		console.log(response);
		if(response.success){
			$scope.rs_numbers = response.result;
			getInvoiceDetails($scope, $http);
		}
	});
}


function getInvoiceDetails($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	//console.log($scope.order_id);	

	var url = NJS_API + "/invoice/get-invoice-details/?order_id="+$scope.order_id;

	$http.get(url).success(function(response){
		if(response.success){
			$scope.invoice = response.result;
			$scope.history = response.result.history;
			$scope.client_basic_info = response.client_basic_info;
			//		
				
			
			$scope.print_invoice_controller.total_amount = 	$scope.invoice.total_amount;
			
			if($scope.print_invoice_controller.total_amount != null)
			{
				console.log("Document ready " + $scope.print_invoice_controller.total_amount);
				//setTimeout(function() {
	            //	window.print();
				//},1000);
				
			}
		}
	});
}


rs_module.controller('PrintInvoiceController',["$scope", "$stateParams","$http", "$modal", "$location",  "toaster", PrintInvoiceController]);