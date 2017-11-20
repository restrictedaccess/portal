/**
 * Controller for Invoice Management
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2017-02-22
 */

function SubconSuspensionLogsController($scope, $stateParams, $http, $modal, toaster){

	var NJS_API = jQuery("#NJS_API_URL").val();
    var API_URL = jQuery("#BASE_API_URL").val();
    //initialize date range
    $scope.records = null;
	$scope.ss.selected_date_range = {startDate: new Date(), endDate: new Date()};
	$scope.client_options = null;
	
	//Initialize Staffing Consultant
	$scope.searchClients2 = function(){	
		searchScClients2($scope, $http, $scope.ss.selected_staffing_consultant);
	};
	
	//Initialize Client
	$scope.searchStaff2 = function(ctrl){		
		searchClientStaffs2($scope, $http);
	};
	
	$scope.search2 = function(){
		searchSubconSuspensionLogs($scope, $http);
	};
	
	$scope.initForm = function(){
		var data = {};
		data.admin_id = jQuery("#ADMIN_ID").val();

		$http.get(API_URL+"/timesheet-weeks/load-defaults/?admin_id="+jQuery("#ADMIN_ID").val()).success(function(response){
			$scope.staffing_consultants = response.defaults.staffing_consultants;
			$scope.ss.selected_staffing_consultant = "";
			$scope.clients = response.defaults.clients;
			$scope.all_clients = response.defaults.all_clients;			
			$scope.client_options = response.defaults.clients;
			
			$scope.lock_unlock_timesheet = response.defaults.lock_unlock_timesheet;
			setTimeout(function() {
            	jQuery("#leads_id").trigger("chosen:updated");
			},500);
		});

		searchSubconSuspensionLogs($scope, $http);
		
	};
	
	$scope.initForm();	
}

function searchClientStaffs2($scope, $http){
	var API_URL = jQuery("#BASE_API_URL").val();
	
	var leads_id = $scope.ss.client.leads_id;
	console.log($scope.ss.client.hiring_coordinator_id);	
	$scope.ss.selected_staffing_consultant =  $scope.ss.client.hiring_coordinator_id;
	
	
	
	$http.get(API_URL+"/timesheet-weeks/get-client-staffs/?leads_id="+leads_id).success(function(response){
		if(response.success){			
			$scope.staffs = response.staffs;
			setTimeout(function() {
            	jQuery("#userid").trigger("chosen:updated");
			},500);
		}else{
			alert("Ooops there's an error occured!");
		}
	});
	
}

function searchScClients2($scope, $http, admin_id){
	console.log(admin_id);	
	var API_URL = jQuery("#BASE_API_URL").val();					
	$http.get(API_URL+"/timesheet-weeks/get-sc-clients/?admin_id="+admin_id).success(function(response){
		if(response.success){
			$scope.clients = response.clients;
			$scope.all_clients = response.all_clients;			
			$scope.client_options = response.clients;
			
			setTimeout(function() {
            	jQuery("#leads_id").trigger("chosen:updated");
			},500);

		}else{
			alert("Ooops there's an error occured!");
		}
	});
	
}
function searchSubconSuspensionLogs($scope, $http){

	
	
	var NJS_API = jQuery("#NJS_API_URL").val();	
	$scope.loadingDemo = true;
	$scope.records = null;

	var data = {};
	data.start_date = formatDate($scope.ss.selected_date_range.startDate);
	data.end_date = formatDate($scope.ss.selected_date_range.endDate);
	
	data.csro_id = "";
	data.subcon_id = "";
	data.client_id = "";
	
	
	
	if(typeof $scope.ss.selected_staffing_consultant != "undefined"){
		console.log($scope.ss.selected_staffing_consultant);
		data.csro_id = $scope.ss.selected_staffing_consultant;
	}
	
	if(typeof $scope.ss.client != "undefined"){
		console.log($scope.ss.client.leads_id);
		data.client_id = $scope.ss.client.leads_id;
	}
	
	if(typeof $scope.ss.subcon != "undefined"){
		console.log($scope.ss.subcon.id);
		data.subcon_id = $scope.ss.subcon.id;
	}
	
	console.log(data);
	
	$http({
	  	method: 'POST',
	  	url: NJS_API+"/compliance/search/ ",
	  	data: data
	}).success(function(response) {
		$scope.loadingDemo = false;
		$scope.records = response.docs;	
	}).error(function(response){
		$scope.loadingDemo = false;
		alert("There's something wrong in "+NJS_API+"/compliance/subcon-suspension-logs/ Please try again later.");
	});
	
}


rs_module.controller('SubconSuspensionLogsController',["$scope", "$stateParams","$http", "$modal", "toaster", SubconSuspensionLogsController]);