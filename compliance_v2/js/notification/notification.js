/**
 * Controller for Invoice Management
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2016-06-08
 */

function DashboardController($scope, $stateParams, $http, $modal, toaster){
	var NJS_API = "test.njs.remotestaff.com.au";//jQuery("#NJS_API_URL").val();
	var WS_URL = jQuery("#WS_URL").val();
	
	var WEBSOCKET_PORT = 8080;
	
	$scope.notifications = [];
	
	$scope.initForm = function(){
		
				
		var API_URL = jQuery("#BASE_API_URL").val();
		var websocket = new WebSocket(WS_URL+":"+WEBSOCKET_PORT, "echo-protocol");		
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
		
		
	};
	
	$scope.initForm();
	
	
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





rs_module.controller('DashboardController',["$scope", "$stateParams","$http", "$modal", "toaster", DashboardController]);