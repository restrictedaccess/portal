/**
 * Controller for Invoice Management
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2016-06-08
 */

function ComplianceDashboardController($scope, $stateParams, $http, $modal, toaster){
	var NJS_API = "test.njs.remotestaff.com.au";//jQuery("#NJS_API_URL").val();
	var WEBSOCKET_PORT = 8080;
	
	$scope.dashb.selected_date_range = {startDate: new Date(), endDate: new Date()};
	$scope.notifications = [];
	
	
	$scope.search = function(){
		searchGroupByClient($scope, $http);
	};
	
	
	$scope.initForm = function(){
		
				
		var API_URL = jQuery("#BASE_API_URL").val();
		var websocket = new WebSocket("ws://"+NJS_API+":"+WEBSOCKET_PORT, "echo-protocol");		
		console.log(websocket);
		
		
		// Send the msg object as a JSON-formatted string.;
		websocket.onopen = function(){
			var msg = {
			    key: $scope.admin_id,			    
			    app:"notifications"			    
			};
			websocket.send(JSON.stringify(msg));		
		};
		
		
		websocket.onmessage = function(event){
			console.log(event.data);
			var obj = JSON.parse(event.data);
			showCurrentNotifications($scope, $http, obj, toaster);
		};
		
		searchGroupByClient($scope, $http);
  
  		//showNotifications($scope, $http);
		
	};
	
	$scope.initForm();
	
	
}
function searchGroupByClient($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();	
	$scope.loadingDemo = true;
	$scope.records = null;

	//var data = {};
	//data.start_date = formatDate($scope.dashb.selected_date_range.startDate);
	//data.end_date = formatDate($scope.dashb.selected_date_range.endDate);
	
	var start_date = formatDate($scope.dashb.selected_date_range.startDate);
	var end_date = formatDate($scope.dashb.selected_date_range.endDate);
	
	
	//console.log(data);
	
	$http({
	  	method: 'GET',
	  	url: NJS_API+"/compliance/search-group-by-client/?start_date="+start_date+"&end_date="+end_date,	  	
	}).success(function(response) {
		$scope.loadingDemo = false;
		$scope.records = response.docs;	
	}).error(function(response){
		$scope.loadingDemo = false;
		alert("There's something wrong in "+NJS_API+"/compliance/search-group-by-client/?start_date="+start_date+"&end_date="+end_date+". Please try again later.");
	});
}

function showCurrentNotifications($scope, $http, obj, toaster){
	var message = obj.message;
	console.log(message);
	
	$scope.notifications.push(obj);
	
	
	toaster.pop({
        type: 'success',
        title: 'Notification',
        body: message,
        showCloseButton: true,
    });
    
    //$scope.$apply();
}





rs_module.controller('ComplianceDashboardController',["$scope", "$stateParams","$http", "$modal", "toaster", ComplianceDashboardController]);