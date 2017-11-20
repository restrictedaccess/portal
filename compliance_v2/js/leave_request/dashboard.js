/**
 * Controller for Leave Request Management
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2017-03-24
 */

function LeaveRequestDashboardController($scope, $stateParams, $http, $modal, toaster){
	var NJS_API = jQuery("#NJS_API_URL").val();
    
    //initialize date range
    $scope.counters = null;
    $scope.start_date = new Date();
    $scope.end_date = new Date();
	$scope.lrdash.selected_date_range = {startDate: $scope.start_date, endDate: $scope.end_date};
	
	$scope.refreshLeaverRequestDashboard = function(){
		get_total_number_of_leaves_per_status_by_date_range($scope, $http);
	};	
	$scope.initForm = function(){
		var data = {};
		data.admin_id = jQuery("#ADMIN_ID").val();
		//console.log("Leave Request Dashboard");	
		get_total_number_of_leaves_per_status_by_date_range($scope, $http);	
	};
	
	$scope.initForm();
	
	
}

function get_total_number_of_leaves_per_status_by_date_range($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	var start_date = formatDate($scope.lrdash.selected_date_range.startDate);
	var end_date = formatDate($scope.lrdash.selected_date_range.endDate);
	
	$http.get(NJS_API+"/leave-request/total-number-leaves-per-status-by-date-range/?start_date="+start_date+"&end_date="+end_date).success(function(response){
		//console.log(response);
		$scope.start_date = start_date;
    	$scope.end_date = end_date;		
		$scope.counters = response.result;
	});
}

rs_module.controller('LeaveRequestDashboardController',["$scope", "$stateParams","$http", "$modal", "toaster", LeaveRequestDashboardController]);