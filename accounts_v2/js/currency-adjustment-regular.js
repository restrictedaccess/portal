function CurrencyAdjustmentControllerRegular($scope, $http, $modal, toaster){

	$scope.admin_allowed = "N";
	$scope.admin_allowed_msg = "Loading...";
	$scope.results = null;	
	$scope.month_options = [{num : "01",name : "January"}, {num : "02", name : "February"},{num : "03", name : "March"},{num : "04", name : "April"},{num : "05", name : "May"},{num : "06", name : "June"},{num : "07", name : "July"},{num : "08", name : "August"},{num : "09", name : "September"}, {num : "10", name : "October"},{num : "11", name : "November"},{num : "12", name : "December"}];
	var new_date = new Date();	
	$scope.current_year = parseInt(new_date.getFullYear());
	$scope.year_options=[
		$scope.current_year - 1,
		$scope.current_year,
		$scope.current_year + 1
	];
	//console.log($scope.year_options);
	
	$scope.add_new_currency_rate_regular = function(){		
		saveCurrencyRateRegular($scope, $http, toaster);		
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
		
		//Get Current Currency Rates
		current_currency_rates_regular($scope, $http);
		currency_history_regular_invoicing($scope, $http);
	};
	
	$scope.initForm();

	
}

function saveCurrencyRateRegular($scope, $http, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	var NJS_API_URL = jQuery("#NJS_API_URL").val();
	console.log(NJS_API_URL);	
	if(!$scope.ca.reference_currency){
		alert("Please select a currency");
		return false;
	}
	
	if(!$scope.ca.reference_currency_rate){
		alert("Please enter currency rate");
		return false;
	}
	
	if(parseFloat($scope.ca.reference_currency_rate) <= 0 ){
		alert("Currency Rate cannot be zero");
		return false;
	}
	
	if(!$scope.ca.effective_month){
		alert("Please specify effective month");
		return false;
	}
	
	if(!$scope.ca.effective_year){
		alert("Please specify effective year");
		return false;
	}
	
	if(confirm("Save new currency rate?")){
		$scope.loading5 = true;
		
		var data = {};
		data.currency = $scope.ca.reference_currency;
		data.rate = $scope.ca.reference_currency_rate;
		data.admin_id = jQuery("#ADMIN_ID").val(); 
		data.effective_month = $scope.ca.effective_month;
		data.effective_year = $scope.ca.effective_year;
		console.log(data);
		
		
		$http({
			url: NJS_API_URL+"/currency-adjustments/save-currency-rate-regular/",			
		  	method: 'POST',
		  	data: data
		}).success(function(response) {
			//console.log(response);
			
			if(response.success){
				//alert(response.msg);
				toaster.pop({
		            type: 'success',
		            title: 'Success',
		            body: response.msg,
		            showCloseButton: true,
		            timeout: 3000
		        });
				
				$scope.ca.reference_currency_rate = 0.00;
				current_currency_rates_regular($scope, $http);
				currency_history_regular_invoicing($scope, $http);
				
			}else{
				toaster.pop({
		            type: 'error',
		            title: 'Warning',
		            body: response.msg,
		            showCloseButton: true,
		        });	
		        $scope.loading5 = false;
				
			}
			$scope.loading5 = false;

		}).error(function(response){
			console.log(response);
			$scope.loading5 = false;
			alert("There's something wrong in saving new currency rate. Please try again later.");
		});
		
	}
}

function current_currency_rates_regular($scope, $http){
	
	var API_URL = jQuery("#BASE_API_URL").val();
	$http.get(API_URL+"/currency-adjustment/current-currency-rates-regular-invoicing").success(function(response){
			
		angular.forEach(response.results, function(result){
			if(result.currency == "AUD"){
				result.html_icon = "fa-dollar";
				result.bg_color = "navy-bg";
			}				
			if(result.currency == "GBP"){
				result.html_icon = "fa-gbp";
				result.bg_color = "lazur-bg";
			}				
			if(result.currency == "USD"){
				result.html_icon = "fa-usd";
				result.bg_color = "yellow-bg";
			}
			
		});
		
		$scope.results = response.results;	
			
	});
	
}


function currency_history_regular_invoicing($scope, $http){
	var API_URL = jQuery("#BASE_API_URL").val();
	$http.get(API_URL+"/currency-adjustment/history-regular/").success(function(response){			
		$scope.histories = response.histories;	
	});
}


rs_module.controller('CurrencyAdjustmentControllerRegular',["$scope", "$http", "$modal", "toaster", CurrencyAdjustmentControllerRegular]);

