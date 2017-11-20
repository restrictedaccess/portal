/**
 * Controller for Invoice Management Client List Page
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2016-06-08
 */

function ClientListController($scope, $stateParams, $http, $modal, toaster){

	$scope.clients = null;
	$scope.client_list = [];
	$scope.page = 0;
	$scope.client_list_controller.isActive = true;
	$scope.client_list_controller.oldClientExcluded = true;
	/*
	$scope.ngData = [
        {	
        	Client_Id : null,
        	Name: null, 
        	Email: null, 
        	Currency: null, 
        	Days_Before_Suspension: null, 
        	Available_Balance: null, 
        	Credit_Low : null,
        	They_Owe_Us: null
        }
        
    ];
	
    
    
    $scope.ngOptions = { 
        data: 'ngData',
        headerRowHeight : 35,
        rowHeight : 35,
        columnDefs: [
        		{field: 'Client_Id', displayName: 'Client Id', cellTemplate: '<div class="ngCellText"><a class="" href="/portal/accounts_v2/#/invoice/client-account/{{row.getProperty(col.field)}}">{{row.getProperty(col.field)}}</a></div>', minWidth:70,
width:'auto'},
        		{field: 'Name', displayName: 'Name'},
                {field: 'Email', displayName:'Email'},
                {field: 'Currency', displayName:'Currency', minWidth:60, width:'auto'},
                {field:'Days_Before_Suspension', displayName:'Days Before Suspension'},
                {field:'Available_Balance', displayName:'Available Balance'},
                {field:'Credit_Low', displayName:'Credit Low', minWidth:70, width:'auto'},
                {field:'They_Owe_Us', displayName:'They Owe Us'},  
            ],  
    };
	*/
	
	//On click of Search button
	$scope.search = function(){
		$scope.page = 0;		
		search($scope, $http);
	};
	
	$scope.show_more = function(){
		show_more($scope, $http);
	};
	
	$scope.initForm = function(){
		search($scope, $http);
		
		
	};
	
	$scope.initForm();
}

function search($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	console.log(NJS_API);
	$scope.client_list = null;
	$scope.page = 0;
	//console.log($scope.client_list_controller.isActive);
	var exclude_old_client = "yes";
	var client_status = "active";	
	
	if($scope.client_list_controller.isActive == true && $scope.client_list_controller.isInactive == true){
		var client_status = "all";
	}
	
	if($scope.client_list_controller.isActive == false && $scope.client_list_controller.isInactive == false){
		var client_status = "all";
	}
	
	if($scope.client_list_controller.isActive == true && $scope.client_list_controller.isInactive == false){
		var client_status = "active";
	}
	
	if($scope.client_list_controller.isActive == false && $scope.client_list_controller.isInactive == true){
		var client_status = "inactive";
	}
	
	if($scope.client_list_controller.oldClientExcluded == false){
		var exclude_old_client = "no";
	}
	
	var data = {
		keyword : $scope.client_list_controller.param,
		client_status : client_status,
		page : $scope.page,
		exclude_old_client : exclude_old_client
	};
	console.log(data);
	//return false;
	
	$scope.loadingDemo = true;
	$http.post(NJS_API + "/invoice/search/", data).success(function(response){
		if(response.success){
			$scope.client_list = response.clients;
			$scope.total_docs = response.total_docs;
			$scope.page = response.next_page;				
			
			//display_client_list_grid($scope);
				
		}else{
			alert("There's a problem in searching client");
		}
		$scope.loadingDemo = false;
	}).error(function(response){
		alert("There's a problem in searching client");
		$scope.loadingDemo = false;
	});
	
}

function show_more($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	var client_status = "active";
	var exclude_old_client = "yes";
		
	if($scope.client_list_controller.isActive == true && $scope.client_list_controller.isInactive == true){
		var client_status = "all";
	}
	
	if($scope.client_list_controller.isActive == false && $scope.client_list_controller.isInactive == false){
		var client_status = "all";
	}
	
	if($scope.client_list_controller.isActive == true && $scope.client_list_controller.isInactive == false){
		var client_status = "active";
	}
	
	if($scope.client_list_controller.isActive == false && $scope.client_list_controller.isInactive == true){
		var client_status = "inactive";
	}
	
	if($scope.client_list_controller.oldClientExcluded == false){
		var exclude_old_client = "no";
	}
	
	var data = {
		keyword : $scope.client_list_controller.param,
		client_status : client_status,
		page : $scope.page,
		exclude_old_client : exclude_old_client
	};
	
	console.log(data);
	$scope.loadingDemo = true;
	$scope.loadingDemo2 = true;
	$http.post(NJS_API + "/invoice/search/", data).success(function(response){
		if(response.success){			
			$scope.client_list.push.apply($scope.client_list, response.clients);	
			$scope.total_docs = response.total_docs;
			$scope.page = response.next_page;
			
			//display_client_list_grid($scope);
								
		}else{
			alert("There's a problem in searching client");
		}
		$scope.loadingDemo = false;
		$scope.loadingDemo2 = false;
	}).error(function(response){
		alert("There's a problem in searching client");
		$scope.loadingDemo = false;
		$scope.loadingDemo2 = false;
	});
}

function display_client_list_grid($scope){
	
    var client_objects=[];
   
    for(var i = 0; i<$scope.client_list.length; i++ ){
    	var obj = $scope.client_list[i];
    	//console.log(obj);
    	var sign = "$";
    	if(obj.currency == "GBP"){
    		var sign = "£";
    	}
    	
    	client_objects.push({	
    			Client_Id : obj.client_id,
	        	Name: obj.fname+" "+obj.lname, 
	        	Email: obj.email, 
	        	Currency: obj.currency, 
	        	Days_Before_Suspension: obj.days_before_suspension, 
	        	Available_Balance: money_format(obj.available_balance), 
	        	Credit_Low: obj.credit_low,
	        	They_Owe_Us: money_format(obj.they_owe_us)
	     });
    }
    $scope.ngData = client_objects;
    
}
function searchClient($scope, $http, client){
	//var API_URL = jQuery("#BASE_API_URL").val();
	console.log(client);
	$scope.client_list = null;
	$scope.loadingDemo = true;
	
	var url = "http://test.njs.remotestaff.com.au/clients/get-all-clients/";
	if(client){
		var url = "http://test.njs.remotestaff.com.au/clients/get-all-clients/?id="+client.client_id;
	}
	
	$http({
	  method: 'POST',
	  url: url
	}).success(function(response) {
		if(response.success){
			$scope.client_list = response.clients;			
		}else{
			alert("There's a problem in searching client");
		}
		$scope.loadingDemo = false;
	}).error(function(response){
		alert("There's a problem in searching client");
		$scope.loadingDemo = false;
	});
}




rs_module.controller('ClientListController',["$scope", "$stateParams","$http", "$modal", "toaster", ClientListController]);