/**
 * Controller for Invoice Management Client Account Details Page
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2016-06-21
 */

function ClientAccountController($scope, $stateParams, $http, $modal, $location,toaster){
	var NJS_API = jQuery("#NJS_API_URL").val();	
	console.log(NJS_API);
	
	$scope.API_URL = jQuery("#BASE_API_URL").val();	
	$scope.client_id = null;
	$scope.running_balance = 0;
	$scope.they_owe_us = 0;
	$scope.awaiting_invoices = null;
	$scope.total_no_awaiting_invoices = 0;	
	$scope.all_invoices = null;
	$scope.daily_rate = null;
	$scope.staffing_consultant = {admin_fname : null, admin_lname : null, admin_email : null};
	
	$scope.openModalAddNotes = function(ctrl){
		
		
		var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/client-account/modal_add_notes.html',
            controller: AddNotesModalInstanceCtrl,
            windowClass: "animated fadeIn",
            //size: "sm",
            resolve:{
            	$ctrl:function(){
            		return ctrl;
            	},
            	$invoker:function(){
            		return $scope;
            	}
            	
            }
        });
        
	};
	
	$scope.initForm = function(){
		console.log("Hello World");
		console.log($location.search());
		
		if($stateParams.client_id){
			$scope.client_id = $stateParams.client_id;
			//getClientSettings($scope, $http);
			getClientInvoices($scope, $http);
		}
		/*
		if($location.search().client_id){
			$scope.client_id = $location.search().client_id;
			//getClientSettings($scope, $http);
			getClientInvoices($scope, $http);	
		}
		*/	
	};
	
	$scope.initForm();
}

function getClientSettings($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	console.log($scope.client_id);	
	var data = {
		id:$scope.client_id
	};
	
	$http.post(NJS_API + "/invoice/get-client-settings/", data).success(function(response){
		if(response.success){			
			$scope.client = response.client;
		}
	});
}

function getClientInvoices($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
		
	$http.get(NJS_API + "/invoice/get-client-invoices/?id="+$scope.client_id).success(function(response){
		if(response.success){
			var result = response.result;
			//console.log(result.lead.company_address);
			$scope.client = {
				client_id : result.client_id,
				fname : result.fname,
				lname : result.lname,
				email : result.email,
			};
			
			$scope.client_settings = {
				currency : result.currency,
				apply_gst : result.apply_gst,
				autodebit : result.autodebit,
				days_before_invoice : result.days_before_invoice,
				days_before_suspension : result.days_before_suspension,
				days_to_invoice : result.days_to_invoice,
				send_invoice_reminder : result.send_invoice_reminder
			};
			
			$scope.running_balance = result.running_balance;
			$scope.they_owe_us = result.they_owe_us;
			$scope.awaiting_invoices = result.awaiting_invoices;
			$scope.total_no_awaiting_invoices = result.awaiting_invoices.length;	
			$scope.all_invoices = result.invoice_list;	
			$scope.daily_rate = result.daily_rate;
			
			var basic_info = {
				fname : result.lead.fname,
				lname : result.lead.lname,
				email : result.lead.email,
				company_name : result.lead.company_name,
				company_address : result.lead.company_address,
				officenumber : result.lead.officenumber,
				mobile : result.lead.mobile,
				
				supervisor_staff_name : result.lead.supervisor_staff_name,
				supervisor_email : result.lead.supervisor_email,
				supervisor_contact : result.lead.supervisor_contact,
				
				acct_dept_name1 : result.lead.acct_dept_name1,
				acct_dept_email1 : result.lead.acct_dept_email1,
				acct_dept_contact1 : result.lead.acct_dept_contact1,
				
				acct_dept_name2 : result.lead.acct_dept_name2,
				acct_dept_email2 : result.lead.acct_dept_email2,
				acct_dept_contact2 : result.lead.acct_dept_contact2,
				
				sec_email : result.lead.sec_email,
				days_before_suspension : result.days_before_suspension,
			};
			
			$scope.client_basic_info = basic_info;
			$scope.staffing_consultant = result.staffing_consultant;
			
			getClientAccountNotes($scope, $http);		
		}
	});
	
	
}

function getClientAccountNotes($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	console.log($scope.client_id);	
	var data = {
		id:$scope.client_id
	};
	
	$http.get(NJS_API + "/invoice/get-client-account-notes/?id="+$scope.client_id).success(function(response){
		if(response.success){			
			$scope.notes = response.docs;
		}
	});
}


function AddNotesModalInstanceCtrl ($scope, $modalInstance, $http, $ctrl, $invoker , SweetAlert, toaster) {
	var NJS_API = jQuery("#NJS_API_URL").val();

	
	
	$scope.addNote = function() {
		console.log($invoker);
		console.log($scope);	
		
		if(!$scope.client_account_notes || $scope.client_account_notes == ""){
			alert("Notes cannot be null");
			return false;	
		}
		
        var data = {
			client_id : $invoker.client_id,
			admin_id : $invoker.admin_id,
			admin : $invoker.admin_name,			
			note : $scope.client_account_notes
		};
		
		console.log(data);
		
		
		$scope.loading5 = true;
		$http.post(NJS_API + "/invoice/add-client-account-notes/", data).success(function(response){
			if(response.success){
				$modalInstance.dismiss('cancel');
				$scope.loading5 = false;
				toaster.pop({
		            type: 'success',
		            title: 'Add Notes',
		            body: "Added successfully",
		            showCloseButton: true,
		        });			
				getClientAccountNotes($invoker, $http);
			}
		}).error(function(response){
			toaster.pop({
	            type: 'error',
	            title: 'Add Notes',
	            body: response.error,
	            showCloseButton: true,
	        });
		});
	
    };
	
	$scope.close_auto_adj_hrs = function () {
        $modalInstance.dismiss('cancel');
    };
	  
}

rs_module.controller('ClientAccountController',["$scope", "$stateParams","$http", "$modal", "$location",  "toaster", ClientAccountController]);
rs_module.controller('AddNotesModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$ctrl", "$invoker", "toaster", AddNotesModalInstanceCtrl]);