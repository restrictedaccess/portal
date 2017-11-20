function CurrencyAdjustmentController($scope, $http, $modal, toaster){

	//$scope.lts.master_select = true;
	
	
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
		
		$http.get(API_URL+"/currency-adjustment/show-all/").success(function(response){			
			$scope.histories = response.histories;	
		});
	};
	
	$scope.initForm();

	
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
		  	method: 'POST',
		  	url: API_URL+"/currency-adjustment/save/",
		  	data: data
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




