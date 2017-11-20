/**
 * Controller for Invoice Management Client Account Details Page
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2017-09-06
 */

function InvoicePaymentsController($scope, $stateParams, $http, $modal, $location,toaster, DTOptionsBuilder){
	//var NJS_API = jQuery("#NJS_API_URL").val();
	//console.log(NJS_API);
	console.log("Invoice Payments Controller Started");

	$scope.dtOptions = DTOptionsBuilder.newOptions()
	.withDOM('<"html5buttons"B>lTfgitp')
	.withButtons([
		// {extend: 'copy'},
		{extend: 'csv'},
		{extend: 'excel', title: 'ExampleFile'},
		// {extend: 'pdf', title: 'ExampleFile'},

		// {extend: 'print',
		// 	customize: function (win){
		// 		$(win.document.body).addClass('white-bg');
		// 		$(win.document.body).css('font-size', '10px');

		// 		$(win.document.body).find('table')
		// 			.addClass('compact')
		// 			.css('font-size', 'inherit');
		// 	}
		// }
	]);

	$scope.result = null;

	$scope.initForm = function(){
		console.log("Invoice Payments Form Initialized");		
		search_paypal_invoice_payments($scope, $http);
	};
	
	$scope.initForm();
}

function search_paypal_invoice_payments($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	console.log(NJS_API);
	$scope.page = 0;

	var data = {
		page : $scope.page,
		payment_mode : "paypal"
	};
	console.log(data);

	$scope.loadingDemo = true;
	$http.post(NJS_API + "/invoice/invoice-payments/", data).success(function(response){
		if(response.success){
			$scope.result = response;
			console.log($scope.result.docs);	
		}else{
			alert(response.msg);
		}
		$scope.loadingDemo = false;
	}).error(function(response){
		alert("There's a problem in searching client");
		$scope.loadingDemo = false;
	});
}
rs_module.controller('InvoicePaymentsController',["$scope", "$stateParams","$http", "$modal", "$location",  "toaster","DTOptionsBuilder", InvoicePaymentsController]);