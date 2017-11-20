/**
 * Controller for Lock/Unlock Timesheet
 * 
 * @version 1 - Initial Commit
 */

function LockTimesheetController($scope, $http, $modal, toaster){

	//$scope.lock_unlock_timesheet = "N";
	$scope.lts.master_select = true;
	//initialize date range
	$scope.lts.selected_date_range = {startDate: new Date(), endDate: new Date()};
	$scope.lts.selected_sc = null;
	$scope.lts.exlude_inactive_clients = true;
	$scope.client_options = null;
	
	//Refresh client list
	$scope.refreshClients = function(){
		console.log($scope.lts.exlude_inactive_clients);
		if($scope.lts.exlude_inactive_clients == true){			
			$scope.client_options = $scope.clients;			
		}else{
			$scope.client_options = $scope.all_clients;
		}
		setTimeout(function() {
        	jQuery("#leads_id").trigger("chosen:updated");
		},500);
		
	};
	
	//On click of Search buttong
	$scope.searchWeek = function(){		
		searchTimesheetWeek($scope, $http);
	};
	
	//Initialize staffing consultants
	$scope.searchClients = function(){
		console.log($scope.lts.selected_staffing_consultant);
		$scope.lts.selected_sc = $scope.lts.selected_staffing_consultant;		
		searchScClients($scope, $http, $scope.lts.selected_staffing_consultant.admin_id);
	};
	
	//Initialize Client
	$scope.searchStaff = function(ctrl){
		//console.log(ctrl);
		searchClientStaffs($scope, $http, $scope.lts.client, ctrl);
	};

    $scope.searchStaff($scope.lts);

    $scope.getClientSc = function(sc_id) {
        var njs_url = jQuery("#NJS_API_URL").val();
		console.log(sc_id);
        $http.get(njs_url+"/timesheet-details-notes/timesheet-get-clients?sc_id="+sc_id).success(function(response){
            if (response.result) {
                var clientData = response.result.leads_detail;
                var hiring_coord_id = response.result.staffing_consultant_detail;
                $scope.lts.client = {
                    email: clientData.email,
                    fname: clientData.fname,
                    hiring_coordinator_id: hiring_coord_id.admin_id,
                    leads_id: clientData.id,
                    lname: clientData.lname
                };
            }else {
                $scope.lts.client = {};
                alert("No Client Available");
            }
        });
    };
	
	$scope.setDefaultDateRangeValue = function(){
		//console.log($scope.ts.selected_week);
		$scope.lts.selected_date_range = {startDate: $scope.lts.selected_week.start_date, endDate: $scope.lts.selected_week.end_date };
	};
	
	
	$scope.lockSelectedDates = function(){
		lockSelectedTimesheetDates($scope, $http, toaster);
				
	};
	
	$scope.unlockSelectedDates = function(){
		unlockSelectedTimesheetDates($scope, $http, toaster);
	};
	
	$scope.lockAllTimesheets = function(){
		lockAllSelectedDates($scope, $http, toaster);
		
	};
	$scope.unlockAllTimesheets = function(){
		unlockAllSelectedDates($scope, $http, toaster);		
	};
	
	$scope.lockAllSCTimesheets = function(){
		lockUnlockAllSCTimesheets($scope, $http, toaster, "Lock");
	};
	
	$scope.unlockAllSCTimesheets = function(){
		lockUnlockAllSCTimesheets($scope, $http, toaster, "Unlock");
	};
	
	$scope.select_all = function(){
		//console.log($scope.lts.master_select);
		//console.log($scope.ts_day_records);
		angular.forEach($scope.ts_day_records, function(record){
			record.selected = $scope.lts.master_select;
		});
    };
    	
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		var data = {};
		data.admin_id = jQuery("#ADMIN_ID").val();
		
		$http.get(API_URL+"/timesheet-weeks/load-defaults/?admin_id="+jQuery("#ADMIN_ID").val()).success(function(response){
			$scope.staffing_consultants = response.defaults.staffing_consultants;							
			$scope.clients = response.defaults.clients;
			$scope.all_clients = response.defaults.all_clients;			
			$scope.client_options = response.defaults.clients;
			
			$scope.lts.selected_staffing_consultant = "5";
			$scope.lock_unlock_timesheet = response.defaults.lock_unlock_timesheet;
			setTimeout(function() {
            	jQuery("#leads_id").trigger("chosen:updated");
			},500);
		});
		
		
		
		//Get current year available weeks
		$http.get(API_URL+"/timesheet-weeks/show-available-weeks-per-year/").success(function(response){
			$scope.weeks = response.result;
			
			setTimeout(function() {
            	jQuery("#week").trigger("chosen:updated");
			},500);
		});
		//Check if system busy
		$http.get(API_URL+"/timesheet-weeks/check-lock-unlock-status/").success(function(response){
			$scope.background_process_msg = response.msg;
		});
	};
	
	$scope.initForm();

	
}
function unlockSelectedTimesheetDates($scope, $http, toaster){
	
	//Check if no staff selected
	if(!$scope.lts.subcon){
		alert("Please select a staff");
		return false;
	}
	
	//Get all checked checkboxes of selected dates
	$scope.selectedDatesArray = [];
	angular.forEach($scope.ts_day_records, function(record){
  		if (record.selected) $scope.selectedDatesArray.push(record.timesheet_details_id);
	});	
	//console.log($scope.selectedDatesArray);
	
	//Check if there are no selected dates
	if ($scope.selectedDatesArray.length <1){
		alert("There are no selected dates.");
		return false;
	} 
	
	var API_URL = jQuery("#BASE_API_URL").val();
	$scope.unlockLoadingDemo = true;
	
	var data = {};
	data.selected_timesheet_details = $scope.selectedDatesArray;
	data.subcontractors_id = $scope.lts.subcon;
	data.admin_id = jQuery("#ADMIN_ID").val();
	
	
	$http({
	  	method: 'POST',
	  	url: API_URL+"/timesheet-weeks/unlock-selected-dates/ ",
	  	data: data
	}).success(function(response) {
		if(response.success){
			//alert(response.msg);
			toaster.pop({
	            type: 'success',
	            title: 'Unlock',
	            body: response.msg,
	            showCloseButton: true,
	            timeout: 3000
	        });
			searchTimesheetWeek($scope, $http);
		}else{
			//alert(response.error);
			toaster.pop({
	            type: 'error',
	            title: 'Unlock',
	            body: response.error,
	            showCloseButton: true,
	        });
		}
		$scope.unlockLoadingDemo = false;
	}).error(function(response){
		$scope.unlockLoadingDemo = false;
		alert("There's something wrong in unlocking timesheet selected dates. Please try again later.");
	});
}



function unlockAllSelectedDates($scope, $http, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	var start_date = formatDate($scope.lts.selected_date_range.startDate);
	var end_date = formatDate($scope.lts.selected_date_range.endDate);
	
	if(confirm("Unlock All Timesheets between "+start_date+" and "+end_date)){
		$scope.unlockAllTimesheetsLoading = true;
		var data = {};
		data.start_date = start_date;
		data.end_date = end_date;
		data.admin_id = jQuery("#ADMIN_ID").val();
		//console.log(data);
		
		$http({
		  	method: 'POST',
		  	url: API_URL+"/timesheet-weeks/unlock-all-selected-dates/ ",
		  	data: data
		}).success(function(response) {
			if(response.success){
				//alert("Unlocking of timesheets is now on process. This may take a while.");
				toaster.pop({
		            type: 'success',
		            title: 'Unlock All Timesheets',
		            body: "Unlocking of timesheets is now on process. This may take a while.",
		            showCloseButton: true,
		        });
			}else{
				//alert(response.error);
				toaster.pop({
		            type: 'error',
		            title: 'Unlock All Timesheets',
		            body: response.error,
		            showCloseButton: true,
		        });
			}
			$scope.unlockAllTimesheetsLoading = false;
		}).error(function(response){
			$scope.unlockAllTimesheetsLoading = false;
			alert("There's something wrong in unlocking all timesheet selected dates. Please try again later.");
		});	
	}
	

}
function lockAllSelectedDates($scope, $http, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	var start_date = formatDate($scope.lts.selected_date_range.startDate);
	var end_date = formatDate($scope.lts.selected_date_range.endDate);
	
	if(confirm("Lock All Timesheets between "+start_date+" and "+end_date)){
		$scope.lockAllTimesheetsLoading = true;
		var data = {};
		data.start_date = start_date;
		data.end_date = end_date;
		data.admin_id = jQuery("#ADMIN_ID").val();
		//console.log(data);
		
		$http({
		  	method: 'POST',
		  	url: API_URL+"/timesheet-weeks/lock-all-selected-dates/ ",
		  	data: data
		}).success(function(response) {
			if(response.success){
				//alert("Locking of timesheets is now on process. This may take a while.");
				toaster.pop({
		            type: 'success',
		            title: 'Lock All Timesheets',
		            body: "Locking of timesheets is now on process. This may take a while.",
		            showCloseButton: true,
		        });
			}else{
				//alert(response.error);
				toaster.pop({
		            type: 'error',
		            title: 'Lock All Timesheets',
		            body: response.error,
		            showCloseButton: true,
		        });
			}
			$scope.lockAllTimesheetsLoading = false;
		}).error(function(response){
			$scope.lockAllTimesheetsLoading = false;
			alert("There's something wrong in locking all timesheet selected dates. Please try again later.");
		});	
	}
	
}

function lockUnlockAllSCTimesheets($scope, $http, toaster, mode){
	var API_URL = jQuery("#BASE_API_URL").val();
	var start_date = formatDate($scope.lts.selected_date_range.startDate);
	var end_date = formatDate($scope.lts.selected_date_range.endDate);
	var staffing_consultant_id = $scope.lts.selected_staffing_consultant.admin_id;
	
	
	
	
	if(confirm( mode + " All Timesheets between "+start_date+" and "+end_date + " by SC "+ $scope.lts.selected_staffing_consultant.admin_fname +" "+$scope.lts.selected_staffing_consultant.admin_lname)){
		if(mode == "Lock"){
			$scope.lockAllSCTimesheetsLoading = true;	
		}else{
			$scope.unlockAllSCTimesheetsLoading = true;
		}
		
		var data = {};
		data.start_date = start_date;
		data.end_date = end_date;
		data.admin_id = jQuery("#ADMIN_ID").val();
		data.staffing_consultant_id = staffing_consultant_id;
		data.mode = mode;
		console.log(data);
		
		$http({
		  	method: 'POST',
		  	url: API_URL+"/timesheet-weeks/lock-unlock-all-sc-timesheets/ ",
		  	data: data
		}).success(function(response) {
			
			if(response.success){
				//alert("Locking of timesheets is now on process. This may take a while.");
				toaster.pop({
		            type: 'success',
		            title: mode + ' All Timesheets',
		            body: mode + " of timesheets is now on process. This may take a while.",
		            showCloseButton: true,
		        });
			}else{
				//alert(response.error);
				toaster.pop({
		            type: 'error',
		            title: mode + ' All Timesheets',
		            body: response.error,
		            showCloseButton: true,
		        });
			}
			
			if(mode == "Lock"){
				$scope.lockAllSCTimesheetsLoading = false;	
			}else{
				$scope.unlockAllSCTimesheetsLoading = false;
			}
			
		}).error(function(response){
			if(mode == "Lock"){
				$scope.lockAllSCTimesheetsLoading = false;	
			}else{
				$scope.unlockAllSCTimesheetsLoading = false;
			}
			alert("There's something wrong in locking/unlocking all timesheet Staffing Consultant. Please try again later.");
		});	
	}
	
}

function lockSelectedTimesheetDates($scope, $http, toaster){
	
	
	//Check if no staff selected
	if(!$scope.lts.subcon){
		alert("Please select a staff");
		return false;
	}
	
	//Get all checked checkboxes of selected dates
	$scope.selectedDatesArray = [];
	angular.forEach($scope.ts_day_records, function(record){
  		if (record.selected) $scope.selectedDatesArray.push(record.timesheet_details_id);
	});	
	//console.log($scope.selectedDatesArray);
	
	//Check if there are no selected dates
	if ($scope.selectedDatesArray.length <1){
		alert("There are no selected dates.");
		return false;
	} 
	
	var API_URL = jQuery("#BASE_API_URL").val();
	$scope.lockLoadingDemo = true;
	
	var data = {};
	data.selected_timesheet_details = $scope.selectedDatesArray;
	data.subcontractors_id = $scope.lts.subcon;
	data.admin_id = jQuery("#ADMIN_ID").val();
	
	
	$http({
	  	method: 'POST',
	  	url: API_URL+"/timesheet-weeks/lock-selected-dates/ ",
	  	data: data
	}).success(function(response) {
		if(response.success){
			//alert(response.msg);
			toaster.pop({
	            type: 'success',
	            title: 'Lock',
	            body: response.msg,
	            showCloseButton: true,
	            timeout: 3000
	        });
			searchTimesheetWeek($scope, $http);
		}else{
			toaster.pop({
	            type: 'error',
	            title: 'Lock',
	            body: response.error,
	            showCloseButton: true,
	        });
		}
		$scope.lockLoadingDemo = false;
	}).error(function(response){
		$scope.lockLoadingDemo = false;
		alert("There's something wrong in locking timesheet selected dates. Please try again later.");
	});
	
}

function searchTimesheetWeek($scope, $http){
	var API_URL = jQuery("#BASE_API_URL").val();
	
	if(!$scope.lts.subcon){
		alert("Please select a Staff");
		return false;
	}
	
	$scope.loadingDemo = true;


        
        
	var data = {};
	data.start_date = formatDate($scope.lts.selected_date_range.startDate);
	data.end_date = formatDate($scope.lts.selected_date_range.endDate);
	data.subcontractors_id = $scope.lts.subcon;
	

    
	
	$http({
	  	method: 'POST',
	  	url: API_URL+"/timesheet-weeks/show-timesheet-days/ ",
	  	data: data
	}).success(function(response) {
		$scope.loadingDemo = false;
		angular.forEach(response.records, function(record){
			record.selected = true;
		});
		$scope.ts_day_records = response.records;
		
	}).error(function(response){
		$scope.loadingDemo = false;
		alert("There's something wrong in retrieving timesheet days. Please try again later.");
	});	
}

rs_module.controller('LockTimesheetController',["$scope", "$http", "$modal", "toaster", LockTimesheetController]);