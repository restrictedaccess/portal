/**
 * Controller for Leave Request Management
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2017-03-24
 */

function LeaveRequestDetailsController($scope, $stateParams, $http, $modal, toaster){
	var NJS_API = jQuery("#NJS_API_URL").val();
    var API_URL = jQuery("#BASE_API_URL").val();
    
    $scope.lrd.master_select = false;
    $scope.leave_request = null;
	$scope.date_items = null;
	$scope.history = null;
	$scope.update_process = false;
	
    $scope.leave_request_id = null;
    
    $scope.select_all = function(){		
		angular.forEach($scope.date_items, function(d){
			if(d.status == "pending" || d.status == "approved" ){
				d.selected = $scope.lrd.master_select;	
			}
			
		});
    };
    
    
    $scope.updateLeaveRequestStaus = function(status){
    	updateLeaveRequestStaus($scope, $http, status);
    };
    	
	$scope.initForm = function(){		
		if($stateParams.id){
			$scope.leave_request_id = $stateParams.id;			
		}
		
		get_leave_request_details($scope, $http);
				
	};	
	$scope.initForm();		
}

function updateLeaveRequestStaus($scope, $http, status){
	
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	console.log(status);
	
	//Get all checked checkboxes of selected dates
	$scope.selectedDatesArray = [];
	angular.forEach($scope.date_items, function(d){
		
  		if (d.selected){
  			console.log(d.date_of_leave_str);
  			$scope.selectedDatesArray.push(d);
  		} 
	});	
	console.log($scope.selectedDatesArray);
	
	//Check if there are no selected dates
	if ($scope.selectedDatesArray.length <1){
		alert("There are no selected dates.");
		return false;
	}
	
	
	var data = {};
	data.admin_id = jQuery("#ADMIN_ID").val();
	data.leave_request_id = $scope.leave_request_id;	
	data.status = status;
	data.selected_dates_id = $scope.selectedDatesArray;
	console.log(data);
	
	$scope.update_process = true;
	
	$http({
	  	method: 'POST',
	  	url: NJS_API+"/leave-request/update-leave-request-dates-status",
	  	data: data
	}).success(function(response) {
		$scope.update_process = false;
		$scope.lrd.master_select = false;	
		get_leave_request_details($scope, $http);	
			
	}).error(function(response){
		$scope.update_process = false;
		alert("There's something wrong in "+NJS_API+"/leave-request/update-leave-request-dates-status.\n Please try again later.");
	});
	
}


function get_leave_request_details($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	$http.get(NJS_API+"/leave-request/details/?leave_request_id="+$scope.leave_request_id).success(function(response){
		//console.log(response);
		$scope.leave_request = response.result;
		$scope.date_items = response.result.date_items;
		console.log($scope.date_items);
		$scope.history = response.result.history;
	});
}





rs_module.controller('LeaveRequestDetailsController',["$scope", "$stateParams","$http", "$modal", "toaster", LeaveRequestDetailsController]);