/**
 * Controller for Create Timesheet
 * 
 * @version 1 - Initial Commit
 */

function CreateTimesheetController($scope, $http, $modal, toaster){

	$scope.blank_time_sheets = null;
	$scope.num_records = 0;
	$scope.current_month_year_str = null;
	
    $scope.select_all = function(){
		angular.forEach($scope.records, function(record){
			record.selected = $scope.create_timesheet.master_select;
		});
    };
    
    $scope.create = function(){
    	create_timesheet($scope, $http, toaster);	
    };
    	
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		
		
		//Get current year available weeks
		$http.get(API_URL+"/timesheet/get-blank-timesheet").success(function(response){
			$scope.records = response.records;
			angular.forEach(response.records, function(record){
				record.selected = true;
			});
			$scope.num_records = response.num_records;
			$scope.current_month_year_str = response.current_month_year_str;
		});
	};
	
	$scope.initForm();
}

function create_timesheet($scope, $http, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	
	if(confirm("Are you sue you want to create new timesheet?")){
		//Get all checked checkboxes of selected dates
		$scope.selectedSubconsArray = [];
		angular.forEach($scope.records, function(record){
	  		if (record.selected) $scope.selectedSubconsArray.push(record.subcontractors_id);
		});	
		//console.log($scope.selectedDatesArray);
		
		//Check if there are no selected dates
		if ($scope.selectedSubconsArray.length <1){
			alert("There are no selected staff.");
			return false;
		} 
		
		var API_URL = jQuery("#BASE_API_URL").val();
		$scope.createLoading = true;
		
		var data = {};
		data.records = $scope.selectedSubconsArray;
		data.admin_id = jQuery("#ADMIN_ID").val();
		console.log(data);
		
		$http({
		  	method: 'POST',
		  	url: API_URL+"/timesheet/create/",
		  	data: data
		}).success(function(response) {
			if(response.success){
				//alert(response.msg);
				toaster.pop({
		            type: 'success',
		            title: 'Create Timesheet',
		            body: response.msg,
		            showCloseButton: true,
		        });
				
				if(response.warnings){
					toaster.pop({
			            type: 'warning',
			            title: 'Create Timesheet',
			            body: response.warnings,
			            showCloseButton: true,
			        });
				}
				
				$scope.records = response.records;
				$scope.num_records = response.num_records;
			}else{
				toaster.pop({
		            type: 'error',
		            title: 'Create Timesheet',
		            body: response.error,
		            showCloseButton: true,
		        });
			}
			$scope.createLoading = false;
		}).error(function(response){
			$scope.createLoading = false;
			alert("There's something wrong in creating timesheets. Please try again later.");
		});
		
		
	}
}

rs_module.controller('CreateTimesheetController',["$scope", "$http", "$modal", "toaster", CreateTimesheetController]);