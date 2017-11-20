/**
 * Controller for Leave Request Management
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2017-03-24
 */

function LeaveRequestController($scope, $location, $http, $modal, toaster){
	var NJS_API = jQuery("#NJS_API_URL").val();
    var API_URL = jQuery("#BASE_API_URL").val();
    
    $scope.param_status = null;
    $scope.param_start_date = new Date();
    $scope.param_end_date = new Date();
    
    $scope.staffs = null;
    
    if(typeof $location.search().status != "undefined"){
    	$scope.param_status = $location.search().status;     
    	console.log($scope.param_status);	
    }
    
    
    if(typeof $location.search().start_date != "undefined"){
    	$scope.param_start_date = $location.search().start_date;     
    	console.log($scope.param_start_date);	
    }
    
    if(typeof $location.search().end_date != "undefined"){
    	$scope.param_end_date = $location.search().end_date;     
    	console.log($scope.param_end_date);	
    }
    
    
    $scope.page = 0;
    //initialize date range
    $scope.records = null;
    
	$scope.lr.selected_date_range = {startDate: $scope.param_start_date, endDate: $scope.param_end_date};
	$scope.client_options = null;
	$scope.show_add_leave_btn = false;
	
	
	$scope.searchLRClients = function(){
		
		$scope.show_add_leave_btn = false;
		searchLRClients($scope, $http);
	};

	$scope.searchLRStaff = function(){
		$scope.staffs = null;
		$scope.show_add_leave_btn = false;
		searchLRStaff($scope, $http);
	};

	searchLRStaff($scope, $http);
	
	$scope.showAddLeave = function(subcon){
		if(typeof $scope.lr.subcon != "undefined"){
			//console.log($scope.lr.subcon);
			$scope.show_add_leave_btn = true;

            var njs_url = jQuery("#NJS_API_URL").val();
            $http.get(njs_url+"/timesheet-details-notes/timesheet-get-clients?sc_id="+subcon.id).success(function(response){
                if (response.result) {
                    var clientData = response.result.leads_detail;
                    var hiring_coord_id = response.result.staffing_consultant_detail;
                    $scope.lr.client = {
                        email: clientData.email,
                        fname: clientData.fname,
                        hiring_coordinator_id: hiring_coord_id.admin_id,
                        leads_id: clientData.id,
                        lname: clientData.lname
                    };
                }else {
                    $scope.lr.client = {};
                    alert("No Client Available");
                }
            });
		}
		
	};

	//Refresh client list
	$scope.refreshClients = function(){
		console.log($scope.lr.exlude_inactive_clients);
		$scope.show_add_leave_btn = false;
		if($scope.lr.exlude_inactive_clients == true){			
			$scope.client_options = $scope.clients;			
		}else{
			$scope.client_options = $scope.all_clients;
		}
		setTimeout(function() {
        	jQuery("#leads_id").trigger("chosen:updated");
		},500);
		
	};

	$scope.searchLeaveRequest = function(click){
		$scope.page = 0;
		searchLeaveRequest($scope, $http, click);
	};
	
	$scope.openModalAddLeaveForm = function(){
		var modalInstance = $modal.open({
            templateUrl: 'views/common/leave_request/modal_add_leave_form.html',
            controller: AddLeaveRequestFormModalInstanceCtrl,
            windowClass: "animated fadeIn",
            //size: "sm",
            resolve:{            	
            	$invoker:function(){
            		return $scope;
            	}            	
            }
        });
	};
	
	$scope.initForm = function(){
		var data = {};
		data.admin_id = jQuery("#ADMIN_ID").val();

		$http.get(API_URL+"/timesheet-weeks/load-defaults/?admin_id="+jQuery("#ADMIN_ID").val()).success(function(response){
			$scope.staffing_consultants = response.defaults.staffing_consultants;
			$scope.lr.selected_staffing_consultant = [];
			$scope.clients = response.defaults.clients;
			$scope.all_clients = response.defaults.all_clients;			
			$scope.client_options = response.defaults.all_clients;
			$scope.lock_unlock_timesheet = response.defaults.lock_unlock_timesheet;
			setTimeout(function() {
            	jQuery("#leads_id").trigger("chosen:updated");
			},500);
		});

		searchLeaveRequest($scope, $http, false);
		
	};
	
	$scope.initForm();
	
	
}

function searchLeaveRequest($scope, $http, click){
	var NJS_API = jQuery("#NJS_API_URL").val();	
	$scope.loadingDemo = true;
	$scope.records = null;
	$scope.page = 0;

	if(click == true || click == "true"){
		$scope.param_status = null;
	}
	
	var data = {};
	data.start_date = formatDate($scope.lr.selected_date_range.startDate);
	data.end_date = formatDate($scope.lr.selected_date_range.endDate);
	
	data.csro_id = "";
	data.userid = "";
	data.leads_id = "";
	
	
	 
	if(typeof $scope.lr.selected_staffing_consultant != "undefined"){
		//console.log($scope.lr.selected_staffing_consultant);
		data.csro_id = $scope.lr.selected_staffing_consultant;
	}
	if (!data.csro_id) {
        data.csro_id = "";
	}

	if(typeof $scope.lr.client != "undefined"){
		//console.log($scope.lr.client.leads_id);
		data.leads_id = $scope.lr.client.leads_id;
	}
	
	if(typeof $scope.lr.subcon != "undefined"){
		//console.log($scope.lr.subcon.userid);
		data.userid = parseInt($scope.lr.subcon.userid);
	}
	
	//data.page =$scope.page;
	if($scope.param_status != null){
		data.status = $scope.param_status;
	}
	console.log(data);
	
	$http({
	  	method: 'POST',
	  	url: NJS_API+"/leave-request/search-mongodb ",
	  	data: data
	}).success(function(response) {
		$scope.loadingDemo = false;		
		$scope.records = response.result;		
	}).error(function(response){
		$scope.loadingDemo = false;
		alert("There's something wrong in "+NJS_API+"/leave-request/search-mongodb.\n Please try again later.");
	});
	
}

function searchLRClients($scope, $http){
	
	
		
	var admin_id =  $scope.lr.selected_staffing_consultant;
	var API_URL = jQuery("#BASE_API_URL").val();					
	$http.get(API_URL+"/timesheet-weeks/get-sc-clients/?admin_id="+admin_id).success(function(response){
		if(response.success){
			$scope.clients = response.clients;
			$scope.all_clients = response.all_clients;			
			$scope.client_options = response.all_clients;
			$scope.staffs = null;
			setTimeout(function() {
            	jQuery("#leads_id").trigger("chosen:updated");
			},500);
			
			
			setTimeout(function() {
		    	jQuery("#userid").trigger("chosen:updated");
			},500);

		}else{
			alert("Ooops there's an error occured!");
		}
	});
}


function searchLRStaff($scope, $http){
	console.log('search staff');
	setTimeout(function() {
    	jQuery("#leads_id").trigger("chosen:updated");
	},500);
	
	var API_URL = jQuery("#BASE_API_URL").val();
	console.log($scope.lr);
	var leads_id = (typeof $scope.lr.client !== "undefined" ? $scope.lr.client.leads_id : '');
	console.log(leads_id);
	// console.log($scope.lr.client.hiring_coordinator_id);
    $scope.lr.selected_staffing_consultant = (typeof $scope.lr.client !== "undefined" ? $scope.lr.client.hiring_coordinator_id : '');
	// $scope.lr.selected_staffing_consultant =  $scope.lr.client.hiring_coordinator_id;
	
	
	
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

function AddLeaveRequestFormModalInstanceCtrl($scope, $modalInstance, $http, $invoker , toaster) {
	$scope.selected_staff = $invoker.lr.subcon;
	$scope.selected_client = $invoker.lr.client;
	$scope.selected_date_range = {startDate: new Date(), endDate: new Date()};	
	
	//console.log($scope.selected_staff);
	
	$scope.addLeaveRequest = function(){
		
		var NJS_API = jQuery("#NJS_API_URL").val();
		
		if(typeof $scope.leave_type == "undefined"){
			alert("Please select a Leave Type");
			return false;
		}
		
		if(typeof $scope.leave_duration == "undefined"){
			alert("Please select a Leave Duration");
			return false;
		}
		
		var data = {
			staff : $scope.selected_staff,
			client : $scope.selected_client,			
			admin : jQuery("#ADMIN_ID").val(),						
			start_date : formatDate($scope.selected_date_range.startDate),
			end_date : formatDate($scope.selected_date_range.endDate),
			leave_type : $scope.leave_type,
			leave_duration : $scope.leave_duration,
			reason_for_leave : $scope.reason_for_leave
		};
		console.log(data);
		$scope.loadingEmailCustom = true;
		
		$http.post(NJS_API + "/leave-request/add-leave-request", data).success(function(response){
			if(response.success){
				$scope.loadingEmailCustom = false;
				toaster.pop({
		            type: 'success',
		            title: 'Add Leave Request',
		            body: response.msg,
		            showCloseButton: true,
		        });
		        $modalInstance.dismiss('cancel');
		        $invoker.lr.selected_date_range.startDate = $scope.selected_date_range.startDate;
				$invoker.lr.selected_date_range.endDate = $scope.selected_date_range.endDate;
		        searchLeaveRequest($invoker, $http);
		        
			}
		}).error(function(response){
			$scope.loadingEmailCustom = false;
			$modalInstance.dismiss('cancel');
			alert("There's a problem in adding leave request. Please try again.");
		});
		
	};
	
	
	
	$scope.close_add_leave_form = function(){
		$modalInstance.dismiss('cancel');
	};  
}

rs_module.controller('LeaveRequestController',["$scope", "$location","$http", "$modal", "toaster", LeaveRequestController]);
rs_module.controller('AddLeaveRequestFormModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker", "toaster", AddLeaveRequestFormModalInstanceCtrl]);