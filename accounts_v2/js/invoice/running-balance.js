/**
 * Controller for Client Running Balance Sheet
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2016-07-24
 */

function RunningBalanceController($scope, $stateParams, $http, $modal, $location,toaster){
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	$scope.transactions = [];
	$scope.client_id = null;
	$scope.page = 0;
	
	//initialize date range
	var today = new Date();
	var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
	var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth()+1, 0);

	$scope.rbs.selected_date_range = {startDate: firstDayOfMonth, endDate: lastDayOfMonth};
	
	$scope.searchRBS = function(){
		get_client_transactions($scope, $http);
	};
	
	$scope.show_more_transactions = function(){
		show_more_transactions($scope, $http);
	};
	
	$scope.initForm = function(){
				
		if($stateParams.client_id){
			$scope.client_id = $stateParams.client_id;
			getClientInvoices($scope, $http);
			get_client_transactions($scope, $http);
		}
			
	};
	
	$scope.initForm();
}

function get_client_transactions($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	var start_date = formatDate($scope.rbs.selected_date_range.startDate);
	var end_date = formatDate($scope.rbs.selected_date_range.endDate);
	$scope.page = 0;
	
		
	var data = {
		client_id : $scope.client_id,
		start_date : start_date,
		end_date : end_date,
		page : $scope.page
	};
	
	console.log(data);	
	
	
	var url = NJS_API+ "/running-balance/get-client-transactions/?client_id="+$scope.client_id+"&start_date="+start_date+"&end_date="+end_date+"&page="+$scope.page;	
	$scope.loadingDemo = true;
	$scope.loadingTransactions = true;			
	
		
	$http.get(url).success(function(response){
		$scope.transactions = response.docs;
		$scope.total_docs = response.total_docs;
		$scope.page = response.next_page;
		$scope.loadingDemo = false;
		$scope.loadingTransactions = false;
	});
}

function show_more_transactions($scope, $http){
	
	
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	var start_date = formatDate($scope.rbs.selected_date_range.startDate);
	var end_date = formatDate($scope.rbs.selected_date_range.endDate);
	
	
		
	var data = {
		client_id : $scope.client_id,
		start_date : start_date,
		end_date : end_date,
		page : $scope.page
	};
	
	console.log(data);	
	
	
	var url = NJS_API+ "/running-balance/get-client-transactions/?client_id="+$scope.client_id+"&start_date="+start_date+"&end_date="+end_date+"&page="+$scope.page;	
	$scope.loadingDemo = true;
	$scope.loadingTransactions = true;			
	
		
	$http.get(url).success(function(response){
		$scope.transactions.push.apply($scope.transactions, response.docs);
		$scope.total_docs = response.total_docs;
		$scope.page = response.next_page;
		$scope.loadingDemo = false;
		$scope.loadingTransactions =false;
	});
}





rs_module.controller('RunningBalanceController',["$scope", "$stateParams","$http", "$modal", "$location",  "toaster", RunningBalanceController]);

