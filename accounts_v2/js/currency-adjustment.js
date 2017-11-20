function CurrencyAdjustmentController($scope, $http, $modal, toaster){

	$scope.admin_allowed = "N";
	$scope.admin_allowed_msg = "Loading...";
	$scope.ca.reference_effective_date = new Date();
	$scope.ca.reference_currency_rate = 0.00;
	$scope.ca.reference_currency = "AUD";
	
	$scope.histories = null;
	$scope.results = null;
	
	$scope.add_new_currency_rate = function () {
		var API_URL = jQuery("#BASE_API_URL").val();
		
		if(!$scope.ca.reference_currency_rate){
			alert("Please enter currency rate");
			return false;
		}
		
		if(parseFloat($scope.ca.reference_currency_rate) <= 0 ){
			alert("Currency Rate cannot be zero");
			return false;
		}
		
		if(!$scope.ca.reference_effective_date){
			alert("Please specify effective date of the new currency rate");
			return false;
		}
		
		if(confirm("Save new currency rate?")){
			$scope.loading5 = true;
		
			var data = {};
			data.currency = $scope.ca.reference_currency;
			data.rate = $scope.ca.reference_currency_rate;
			data.admin_id = jQuery("#ADMIN_ID").val(); 
			data.effective_date = $scope.ca.reference_effective_date;
			
			console.log(data);
			
			$http({
			  	// method: 'POST',
			  	method: 'GET',
			  	// url: API_URL+"/currency-adjustment/save/",
			  	url: jQuery("#NJS_API_URL").val()+"/currency-adjustments/save/",
			  	// data: data
                params: data
			}).success(function(response) {
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
					
					//Get Current Currency Rates
					current_currency_rates($scope, $http);
					
					//Get All Rates
					currency_history($scope, $http);
		
				}else{
					toaster.pop({
			            type: 'error',
			            title: 'Warning',
			            body: response.msg,
			            showCloseButton: true,
			        });
				}
				$scope.loading5 = false;
				
			}).error(function(response){
				$scope.loading5 = false;
				alert("There's something wrong in saving new currency rate. Please try again later.");
			});
			
		}
		
        
		
		
    };
	
	
	$scope.openModalCurrencyAdj = function(record){
    	var modalInstance = $modal.open({
            templateUrl: 'views/common/currency-adjustment/modal_add_currency_adjustment.html',
            controller: CurrencyAdjModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "sm",
            resolve:{
            	$record:function(){
            		return record;
            	},
            	$invoker:function(){
            		return $scope;
            	}
            	
            }
        });
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
		current_currency_rates($scope, $http);
		
		
		//Get All Rates
		currency_history($scope, $http);
		
		
	};
	
	$scope.initForm();

	
}

function currency_history($scope, $http){
	var API_URL = jQuery("#BASE_API_URL").val();
	// $http.get(API_URL+"/currency-adjustment/history/").success(function(response){
	$http.get(jQuery("#NJS_API_URL").val()+"/currency-adjustments/history/").success(function(response){
		$scope.histories = response.histories;
	});
}

function current_currency_rates($scope, $http){
	
	var API_URL = jQuery("#BASE_API_URL").val();
	$http.get(API_URL+"/currency-adjustment/current-currency-rates").success(function(response){
			
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

function CurrencyAdjModalInstanceCtrl ($scope, $modalInstance, $http, $record, $invoker, toaster) {
	var API_URL = jQuery("#BASE_API_URL").val();
	
	//console.log($scope);
	$scope.selected_currency = $record.currency;
	$scope.reference_currency_rate = $record.rate;
	$scope.selected_currency_sign = $record.sign;
	
	$scope.add_new_currency_rate = function () {
		if(!$scope.reference_currency_rate){
			alert("Please enter currency rate");
			return false;
		}
		
		if(parseFloat($scope.reference_currency_rate) <= 0 ){
			alert("Currency Rate cannot be zero");
			return false;
		}
		
		//console.log($scope.selected_currency+" "+$scope.reference_currency_rate);
        $scope.loading5 = true;
		
		var data = {};
		data.currency = $scope.selected_currency;
		data.rate = $scope.reference_currency_rate;
		data.admin_id = jQuery("#ADMIN_ID").val();
		
		
		$http({
		  	// method: 'POST',
		  	method: 'GET',
		  	// url: API_URL+"/currency-adjustment/save/",
		  	url: jQuery("#NJS_API_URL").val()+"/currency-adjustments/save/",
		  	// data: data
		  	params: data
		}).success(function(response) {
			if(response.success){
				//alert(response.msg);
				toaster.pop({
		            type: 'success',
		            title: 'Success',
		            body: response.msg,
		            showCloseButton: true,
		            timeout: 3000
		        });
				$record.rate = response.rate;
				$record.date_added = response.date_added;
				$invoker.histories = response.histories;
			}else{
				toaster.pop({
		            type: 'error',
		            title: 'Warning',
		            body: response.msg,
		            showCloseButton: true,
		        });
			}
			$scope.loading5 = false;
			$modalInstance.dismiss('cancel');
		}).error(function(response){
			$scope.loading5 = false;
			alert("There's something wrong in saving new currency rate. Please try again later.");
		});
        
        
    };
    
    $scope.close_modal_currency_adj = function () {
        $modalInstance.dismiss('cancel');
    };
}


rs_module.controller('CurrencyAdjustmentController',["$scope", "$http", "$modal", "toaster", CurrencyAdjustmentController]);
rs_module.controller('CurrencyAdjModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$record", "$invoker" , "toaster", CurrencyAdjModalInstanceCtrl]);
