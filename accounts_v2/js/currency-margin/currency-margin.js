function CurrencyMarginController($scope, $http, $modal, toaster){

	$scope.admin_allowed = "N";
	$scope.admin_allowed_msg = "Loading...";
	$scope.cm.reference_effective_date = formatDate(new Date());
	$scope.cm.reference_currency_rate = "0.00";
	$scope.cm.reference_currency = "AUD";
	$scope.cm.work_status = "Full-Time Staff Salary PHP 20,000.00 and up";
	$scope.work_statuses = Array(
			"Full-Time Staff Salary PHP 20,000.00 and up", 
			"Full-Time Staff Salary PHP 19,999.99 and below",
			"Part-Time Staff Salary PHP 14,000.00 and up",
			"Part-Time Staff Salary PHP 13,999.99 and below"
		);
	
	$scope.histories = null;
	$scope.results = null;
	
	$scope.add_new_currency_margin = function(){
		add_new_currency_margin($scope, $http, toaster);
	};
    	
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		var admin_id = jQuery("#ADMIN_ID").val();
		
		//Check First if the admin is allowed to view the page content
		$http.get(API_URL+"/currency-adjustment/admin-allowed/?admin_id="+admin_id).success(function(response){			
			$scope.admin_allowed = response.is_allowed;	
			$scope.admin_allowed_msg = response.msg;
			$scope.currencies = response.currencies;
		});
		
		
		get_latest_currency_rate_margin($scope, $http, toaster);
		get_all_currency_rate_margin($scope, $http, toaster);
	};
	
	$scope.initForm();	
}

function get_all_currency_rate_margin($scope, $http, toaster){
	var NJS_API_URL = jQuery("#NJS_API_URL").val();
	$http.get(NJS_API_URL + "/currency-adjustments/get-all-currency-rate-margin").success(function(response){
		//console.log(response);
		$scope.histories = response.result;
	});
}

function get_latest_currency_rate_margin($scope, $http, toaster){
	var NJS_API_URL = jQuery("#NJS_API_URL").val();
	$http.get(NJS_API_URL + "/currency-adjustments/get-latest-currency-rate-margin").success(function(response){
		//console.log(response);
		$scope.results = response.result;
	});
}

function add_new_currency_margin($scope, $http, toaster){
	var NJS_API_URL = jQuery("#NJS_API_URL").val();
	var admin_id = jQuery("#ADMIN_ID").val();
	//console.log($scope.loadingDemo);
	$scope.loadingDemo = true;
	
	var data = {};
	data.currency = $scope.cm.reference_currency;
	data.rate = $scope.cm.reference_currency_rate;	
	data.work_status = $scope.cm.work_status;	
	data.admin_id = admin_id;
	
	console.log(data);
	
	
	
	$http({
	  	method: 'POST',
	  	url: NJS_API_URL+"/currency-adjustments/add-currency-rate-margin/",
	  	data: data
	}).success(function(response) {
		$scope.loadingDemo = false;
		get_latest_currency_rate_margin($scope, $http, toaster);
		get_all_currency_rate_margin($scope, $http, toaster);
		toaster.pop({
	        type: 'success',
	        title: 'Add Notes',
	        body: "Added successfully",
	        showCloseButton: true,
	    });	
	}).error(function(response){
		$scope.loadingDemo = false;
		toaster.pop({
	        type: 'error',
	        title: 'Error',
	        body: "There's something wrong in "+NJS_API_URL+"/currency-adjustments/add-currency-rate-margin/ Please try again later.",
	        showCloseButton: true,
	    });
		//alert("There's something wrong in "+NJS_API_URL+"/currency-adjustments/add-currency-rate-margin/ Please try again later.");
	});
	
}

rs_module.controller('CurrencyMarginController',["$scope", "$http", "$modal", "toaster", CurrencyMarginController]);
