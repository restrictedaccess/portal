/**
 * Controller for RSSC Issue
 * 
 * @version 1 - Initial Commit
 */

function RSSCIssueController($scope, $http, $modal, toaster){

	$scope.buttonText = null;
	$scope.rssc_issue_msg = null;
	$scope.records = null;
	
	$scope.save = function() {
		var API_URL = jQuery("#BASE_API_URL").val();
		$scope.loadingDemo = true;

	    var data = {};
		data.admin_id = jQuery("#ADMIN_ID").val();
		
		$http({
		  	method: 'POST',
		  	url: API_URL+"/rssc/lodge-issue/",
		  	data: data
		}).success(function(response) {
			$scope.loadingDemo = false;
			$scope.buttonText = response.button_text;	
			$scope.rssc_issue_msg = response.rssc_issue_msg;
			getAllRsscIssues($scope, $http);
		}).error(function(response){
			$scope.loadingDemo = false;
			alert("There's something wrong in retrieving timesheet. Please try again later.");
		});
	};
    	
	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();
		$scope.loadingDemo = true;
		
		//Check if there's a current RSSC lodge
		$http.get(API_URL+"/rssc/check-rssc-issue/").success(function(response){
			//console.log(response);
			if(response.success){
				
				if(response.result){
					$scope.buttonText = "Stop";	
					$scope.rssc_issue_msg = response.result.msg;
				}else{
					$scope.buttonText = "Start";
				}
			}
			$scope.loadingDemo = false;	
		});
		
		getAllRsscIssues($scope, $http);
		
		
	};
	
	$scope.initForm();

	
}

function getAllRsscIssues($scope, $http){
	//Check if there's a current RSSC lodge
	var API_URL = jQuery("#BASE_API_URL").val();
	$http.get(API_URL+"/rssc/get-all-rssc-issues").success(function(response){
		$scope.records = response.records;
	});
}

rs_module.controller('RSSCIssueController',["$scope", "$http", "$modal", "toaster", RSSCIssueController]);
