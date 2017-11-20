/**
 * Controller for Invoice Management Client Account Details Page
 * Normaneil E. Macutay <normaneil.macutay@gmail.com>
 * @version 1 - Initial Commit
 * 2016-06-21
 */

function InvoiceDetailsController($scope, $stateParams, $http, $modal, $location,toaster){
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	//console.log(NJS_API);
	//console.log($stateParams.order_id);
	$scope.order_id = null;
	$scope.invoice = null;
	$scope.client_basic_info = null;
	$scope.history = null;
	$scope.invoice_notes = null;
	$scope.send_to_client_btn_status = true;
	$scope.staffing_consultant = null;
	$scope.sending_payment_receipt = false;



	function syncVersion(params) {
        $http.post(NJS_API + "/invoice-versioning/sync-version", params).success(function (response) {
            console.log("sync-version done..");
            console.log(response);
        });
	}

	function clearInvoiceModifiedStatus(order_id){
        $http.get(NJS_API + "/invoice-versioning/clear-invoice-modifications?order_id="+order_id).success(function (response) {
            console.log(response);

        });
	}

	$scope.sendReceipt = function(){
		$scope.sending_payment_receipt = true;
		var NJS_API = jQuery("#NJS_API_URL").val();
		//alert($scope.invoice.couch_id);
		//console.log(scope.invoice.couch_id);
		$http.get(NJS_API + "/send/manual-send-payment-receipt/?couch_id="+$scope.invoice.couch_id).success(function (response) {
            $scope.sending_payment_receipt = false;
        });
	};

    $scope.emailInvoice = function(){

    	if(confirm("Send invoice to client")){
			var NJS_API = jQuery("#NJS_API_URL").val();
			var version_to_mail = 1;
            var data = {
                mongo_id : $scope.invoice._id,
                admin : $scope.admin_name,
                version_to_mail : version_to_mail
            };

			var params = $scope.invoice;

            $http.get(NJS_API + "/invoice-versioning/has-modification?order_id="+$scope.invoice.order_id).success(function (response) {

                if(response.success){

                    $http.get(NJS_API + "/invoice-versioning/get-latest-version?order_id="+$scope.invoice.order_id).success(function (response) {
                        if(!response.success && response.result == "No record found"){
                            params.version = 1;
                            params.sent_on = new Date();
                            delete params._id;
                            syncVersion(params);
                            clearInvoiceModifiedStatus(params.order_id);
                            sendInvokeEmail();
                        } else {
                            var current_version = response.result.version;
                            var new_ver = parseInt(current_version) + 1;
                            data.version_to_mail = new_ver;
                            params.version = new_ver;
                            params.sent_on = new Date();
                            delete params._id;
                            syncVersion(params);
                            clearInvoiceModifiedStatus(params.order_id);
                            sendInvokeEmail();
                        }

                    });
				} else {
                    $http.get(NJS_API + "/invoice-versioning/get-latest-version?order_id="+$scope.invoice.order_id).success(function (response) {
                        if(response.success){
                            var current_version = response.result.version;
                            data.version_to_mail = parseInt(current_version);
                            sendInvokeEmail();
                        } else {
                            params.version = 1;
                            params.sent_on = new Date();
                            delete params._id;
                            syncVersion(params);
                            sendInvokeEmail();
						}
                    });

				}

				function sendInvokeEmail(){

                    console.log(data);
                    $scope.loading_email = true;
                    $scope.send_to_client_btn_status = false;
                    $http.post(NJS_API + "/send/invoice-with-attachment-per-recipient/", data).success(function(response){
                        if(response.success){
                            $scope.loading_email = false;
                            $scope.send_to_client_btn_status = true;
                            $scope.history = response.history;
                            toaster.pop({
                                type: 'success',
                                title: 'Send Invoice',
                                body: response.msg,
                                showCloseButton: true,
                            });


                            setTimeout(function() {
                                delete_pdf($scope, $http, $scope.invoice._id);
                            },5000);


                        }else{
                            $scope.loading_email = false;
                            $scope.send_to_client_btn_status = true;
                            toaster.pop({
                                type: 'error',
                                title: 'Send Invoice',
                                body: response.error,
                                showCloseButton: true,
                            });
                        }
                    }).error(function(response){
                        $scope.loading_email = false;
                        $scope.send_to_client_btn_status = true;
                        toaster.pop({
                            type: 'error',
                            title: 'Send Invoice',
                            body: response.error,
                            showCloseButton: true,
                        });
                    });
				}

			});
		}
    };
    
    $scope.openModalEmailCustomMessage = function(){
    	var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-details/modal_email_custom_message.html',
            controller: EmailCustomMessageUpModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{            	
            	$invoker:function(){
            		return $scope;
            	}            	
            }
        });
    };
    
	
	$scope.openModalDisableAutoFollowUp = function(){
		var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-details/modal_disable_auto_follow_up.html',
            controller: DisableAutoFollowUpModalInstanceCtrl,
            windowClass: "animated fadeIn",
            //size: "sm",
            resolve:{            	
            	$invoker:function(){
            		return $scope;
            	}            	
            }
        });
	};
	
	$scope.openModalAddPayment = function(){
		var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-details/modal_receive_payment.html',
            controller: AddPaymentModalInstanceCtrl,
            windowClass: "animated fadeIn",
            //size: "sm",
            resolve:{            	
            	$invoker:function(){
            		return $scope;
            	}            	
            }
        });        
	};
	
	$scope.openModalInvoiceHistory = function(){
		var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-details/modal_invoice_history.html',
            controller: InvoiceHistoryModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{            	
            	$invoker:function(){
            		return $scope;
            	}            	
            }
        });
	};
	
	$scope.openModalAddInvoiceNotes = function(){
		var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-details/modal_invoice_notes.html',
            controller: InvoiceNotesModalInstanceCtrl,
            windowClass: "animated fadeIn",
            //size: "lg",
            resolve:{            	
            	$invoker:function(){
            		return $scope;
            	}            	
            }
        });
	};
	
	$scope.openModalEmailTemplateDegree = function(degree){
		var modalInstance = $modal.open({
            templateUrl: 'views/common/invoice/invoice-details/modal_email_templates_degree.html',
            controller: InvoiceEmailTemplateModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "lg",
            resolve:{               	
            	$degree:function(){
            		return degree;
            	},         	
            	$invoker:function(){
            		return $scope;
            	}            	
            }
        });
	};
	
	$scope.updateStatusNew = function(){
		if(confirm("Are you sure you want to change the status of invoice into New?")){
			var NJS_API = jQuery("#NJS_API_URL").val();
			var data = {
				mongo_id : $scope.invoice._id,
				order_id : $scope.order_id,
				couch_id : $scope.invoice.couch_id,
				admin_id : $scope.admin_id,
				admin : $scope.admin_name,				
			};
			
			console.log(data);
			
			$http.post(NJS_API + "/invoice/update-status-invoice-new/", data).success(function(response){
				if(response.success){		
					$scope.invoice.status = response.invoice.status;
					$scope.invoice.date_paid = response.invoice.date_paid;
					$scope.history = response.invoice.history;
								
					toaster.pop({
			            type: 'success',
			            title: 'Update Status',
			            body: response.msg,
			            showCloseButton: true,
			        });								
				}
			}).error(function(response){
				toaster.pop({
		            type: 'error',
		            title: 'Update Status',
		            body: response.error,
		            showCloseButton: true,
		        });
			});	
				
		}
	};

	$scope.cancelInvoice = function(){
		if(confirm("Are you sure you want to cancel this invoice?")){
			var NJS_API = jQuery("#NJS_API_URL").val();
			var data = {
				mongo_id : $scope.invoice._id,
				order_id : $scope.order_id,
				couch_id : $scope.invoice.couch_id,
				admin_id : $scope.admin_id,
				admin : $scope.admin_name,				
			};
			
			console.log(data);
			
			$http.post(NJS_API + "/invoice/cancel-invoice/", data).success(function(response){
				if(response.success){		
					$scope.invoice.status = response.invoice.status;
					$scope.invoice.date_paid = response.invoice.date_paid;
					$scope.history = response.invoice.history;
								
					toaster.pop({
			            type: 'success',
			            title: 'Cancel Invoice',
			            body: response.msg,
			            showCloseButton: true,
			        });								
				}
			}).error(function(response){
				toaster.pop({
		            type: 'error',
		            title: 'Cancel Invoice',
		            body: response.error,
		            showCloseButton: true,
		        });
			});	
				
		}
		
	};
	
	
	//add split view rendering
	var PARAMS = $location.search();
	if (typeof PARAMS.split_view != "undefined"){
		$scope.split_view = true;
	}else{
		$scope.split_view = false;
	}

	$scope.initForm = function(){
		console.log($location.search());		
		if($stateParams.order_id){
			$scope.order_id = $stateParams.order_id;
			getInvoiceDetails($scope, $http);	
		}
	};
	
	$scope.initForm();
}

function getInvoiceDetails($scope, $http){
	var NJS_API = jQuery("#NJS_API_URL").val();
	console.log($scope.order_id);

    $scope.hasModified = "";

	var url = NJS_API + "/invoice/get-invoice-details/?order_id="+$scope.order_id;

	if ($scope.split_view){
		url = NJS_API + "/invoice/split-view/?order_id="+$scope.order_id;
	}
	$http.get(url).success(function(response){
		if(response.success){
			$scope.invoice = response.result;
			$scope.history = response.result.history;			
			$scope.client_basic_info = response.client_basic_info;
			$scope.staffing_consultant = response.staffing_consultant;
			jQuery("#export-link").attr("href", NJS_API+"/invoice/export-pdf-invoice/?mongo_id="+response.result._id);

		}
	});


	$http.get(NJS_API + "/invoice-versioning/get-latest-version?order_id="+$scope.order_id).success(function (response) {
		console.log(response);
		if(response.success){
			var ver = response.result.version;
			if(ver > 1){
                $scope.hasModified = "This invoice has been modified";
			}
		}

	});

}


function AddPaymentModalInstanceCtrl ($scope, $modalInstance, $http, $invoker , toaster) {
	var NJS_API = jQuery("#NJS_API_URL").val();
	$scope.order_id = $invoker.order_id;
	$scope.transaction_type = "Credit";
	$scope.account_type = "REG";
	$scope.amount = $invoker.invoice.total_amount;
	
	$scope.payment_date = new Date();
	    
	$scope.addPayment = function() {
		
		$scope.payment_date = $("#payment_date").val();
		
		if( parseFloat($scope.amount) < parseFloat($invoker.invoice.total_amount) ){
			alert("Amount entered "+ $scope.amount+" is less than the invoice total amount "+$invoker.invoice.total_amount);
			return false;
		}
		
		if(confirm("This will set invoice status to paid")){
			
			var data = {
				mongo_id : $invoker.invoice._id,
				couch_id : $invoker.invoice.couch_id,
				admin_id : $invoker.admin_id,
				admin : $invoker.admin_name,
				payment_date : $scope.payment_date,
				transaction_type : $scope.transaction_type,
				account_type : $scope.account_type,
				particular : $scope.particular,
				remarks : $scope.remarks,
				amount : $scope.amount
			};
			
			console.log(data);	
			
			
			$scope.loading5 = true;			
			$http.post(NJS_API + "/invoice/add-payment/", data).success(function(response){
				if(response.success){
					$invoker.invoice.status = response.invoice.status;
					$invoker.invoice.date_paid = response.invoice.date_paid;
					$invoker.history = response.invoice.history;
					
					$modalInstance.dismiss('cancel');
					$scope.loading5 = false;
					toaster.pop({
			            type: 'success',
			            title: 'Receive Payment',
			            body: response.msg,
			            showCloseButton: true,
			        });			
					
				}
			}).error(function(response){
				toaster.pop({
		            type: 'error',
		            title: 'Receive Payment',
		            body: response.error,
		            showCloseButton: true,
		        });
			});
			
			
		}
        
    };    
    
	$scope.close_add_payment_form = function () {
        $modalInstance.dismiss('cancel');
    };
	  
}

function InvoiceHistoryModalInstanceCtrl($scope, $modalInstance, $http, $invoker , toaster) {
	
    console.log($invoker.history);
    
	$scope.order_id = $invoker.order_id;
	$scope.history = $invoker.history;    
    console.log($scope.history);
	$scope.close_invoice_history = function () {
        $modalInstance.dismiss('cancel');
    };
	  
}

function InvoiceNotesModalInstanceCtrl($scope, $modalInstance, $http, $invoker , toaster) {
	
    var NJS_API = jQuery("#NJS_API_URL").val();
    $scope.order_id = $invoker.order_id;
    
    $scope.addInvoiceNote = function() {
		//console.log($invoker);
		//console.log($scope);	
		
		if(!$scope.invoice_note || $scope.invoice_note == ""){
			alert("Notes cannot be null");
			return false;	
		}
		
        var data = {
			couch_id : $invoker.invoice.couch_id,
			mongo_id : $invoker.invoice._id,			
			admin : $invoker.admin_name,			
			comment : $scope.invoice_note
		};
		
		console.log(data);
		
		
		$scope.loading5 = true;
		$http.post(NJS_API + "/invoice/add-invoice-comment/", data).success(function(response){
			if(response.success){
				$invoker.invoice.comments = response.comments;
				$modalInstance.dismiss('cancel');
				$scope.loading5 = false;
				toaster.pop({
		            type: 'success',
		            title: 'Add Note',
		            body: "Added successfully",
		            showCloseButton: true,
		        });			
				
			}
		}).error(function(response){
			$modalInstance.dismiss('cancel');
			alert("There's a problem in adding invoice note. Please try again.");
		});
		
	
    };
    
	$scope.close_invoice_notes = function () {
        $modalInstance.dismiss('cancel');
    };
	  
}

function DisableAutoFollowUpModalInstanceCtrl($scope, $modalInstance, $http, $invoker , toaster) {
	
    var NJS_API = jQuery("#NJS_API_URL").val();
    $scope.order_id = $invoker.order_id;
    $scope.disable_auto_follow_up = $invoker.invoice.disable_auto_follow_up;
    
    $scope.updateDisableAutoFollowUp = function() {
		console.log($invoker);
		console.log($scope);	
        var data = {
			couch_id : $invoker.invoice.couch_id,
			mongo_id : $invoker.invoice._id,			
			admin : $invoker.admin_name,			
			disable_auto_follow_up : $scope.disable_auto_follow_up
		};
		console.log(data);
		
		$scope.loading5 = true;
		$http.post(NJS_API + "/invoice/disable-auto-follow-up/", data).success(function(response){
			if(response.success){
				$invoker.invoice.disable_auto_follow_up = response.disable_auto_follow_up;
				$invoker.history = response.history;
				$modalInstance.dismiss('cancel');
				$scope.loading5 = false;
				toaster.pop({
		            type: 'success',
		            title: 'Auto Follow Up',
		            body: "Updated successfully",
		            showCloseButton: true,
		        });			
				
			}
		}).error(function(response){
			$modalInstance.dismiss('cancel');
			alert("There's a problem in updating invoice auto follow up. Please try again.");
		});
			
    };
    
	$scope.close_disable_auto_follow_up = function () {
        $modalInstance.dismiss('cancel');
    };
	  
}

function EmailCustomMessageUpModalInstanceCtrl($scope, $modalInstance, $http, $invoker , toaster) {
	
    var NJS_API = jQuery("#NJS_API_URL").val();
    
    //$scope.multiple_emails = ['Blue','Red']; 
    $scope.multiple_emails = [];
   
    if($invoker.invoice.client_email || $invoker.invoice.client_email !=""){    
    	$scope.multiple_emails.push($invoker.invoice.client_email);
    }
    
    
    if($invoker.client_basic_info.supervisor_email || $invoker.client_basic_info.supervisor_email !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.supervisor_email);
    }
    
    if($invoker.client_basic_info.acct_dept_email1 || $invoker.client_basic_info.acct_dept_email1 !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.acct_dept_email1);
    }
    
    if($invoker.client_basic_info.acct_dept_email2 || $invoker.client_basic_info.acct_dept_email2 !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.acct_dept_email2);
    }
    
    if($invoker.client_basic_info.sec_email || $invoker.client_basic_info.sec_email !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.sec_email);
    }

	if($invoker.staffing_consultant.admin_email || $invoker.staffing_consultant.admin_email !=""){
    	$scope.multiple_emails.push($invoker.staffing_consultant.admin_email);
    }

	$scope.multiple_emails.push("accounts@remotestaff.com.au");	
	
	
	/**
     * summernoteText - used for Summernote plugin
     */
    $scope.summernoteText = ["Hi "+ $invoker.invoice.client_fname +" "+ $invoker.invoice.client_lname +", <br><br>",
    "Please type you custom message here<br><br>"].join('');
    
    
    $scope.options = {
        height: 300,
        toolbar: []
    };
    
    
    
    $scope.onSelected = function (selectedItem) {
  		console.log(selectedItem);
  		$scope.multiple_emails.push(selectedItem);
	};
	
	$scope.onRemove = function(selectedItem){
		var index = $scope.multiple_emails.indexOf(selectedItem);
		console.log(index);
		if (index > -1) {
    		$scope.multiple_emails.splice(index, 1);
		}
	};

           
    $scope.emailCustomMessage = function() {
		console.log($scope.multiple_emails);
		//console.log($scope);	
        var data = {
			couch_id : $invoker.invoice.couch_id,
			mongo_id : $invoker.invoice._id,			
			admin : $invoker.admin_name,			
			custom_message : $scope.summernoteText,
			multiple_emails : $scope.multiple_emails,
			custom : true
		};
		console.log(data);
		
		$scope.loadingEmailCustom = true;
		$http.post(NJS_API + "/send/invoice-with-attachment-per-recipient/", data).success(function(response){
			if(response.success){
				$scope.loadingEmailCustom = false;
				$invoker.history = response.history;								
				toaster.pop({
		            type: 'success',
		            title: 'Custom Message',
		            body: response.msg,
		            showCloseButton: true,
		        });
		        $modalInstance.dismiss('cancel');
		        
		        setTimeout(function() {
	        		delete_pdf($scope, $http, $invoker.invoice._id);
				},5000);
		        
			}
		}).error(function(response){
			$scope.loadingEmailCustom = false;
			$modalInstance.dismiss('cancel');
			alert("There's a problem in sending invoice. Please try again.");
		});
		
			
    };
    
	$scope.close_email_custom_message = function () {
        $modalInstance.dismiss('cancel');
    };
	  
}

function delete_pdf($scope, $http, mongo_id){
	var NJS_API = jQuery("#NJS_API_URL").val();
	$http.get(NJS_API + "/send/delete-file/?mongo_id="+mongo_id).success(function(response){
		console.log(response);
	});
}
function InvoiceEmailTemplateModalInstanceCtrl($scope, $modalInstance, $http, $degree, $invoker , toaster) {
	var NJS_API = jQuery("#NJS_API_URL").val();
	
	$scope.multiple_emails = [];
   
    if($invoker.invoice.client_email || $invoker.invoice.client_email !=""){    
    	$scope.multiple_emails.push($invoker.invoice.client_email);
    }
    
    
    if($invoker.client_basic_info.supervisor_email || $invoker.client_basic_info.supervisor_email !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.supervisor_email);
    }
    
    if($invoker.client_basic_info.acct_dept_email1 || $invoker.client_basic_info.acct_dept_email1 !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.acct_dept_email1);
    }
    
    if($invoker.client_basic_info.acct_dept_email2 || $invoker.client_basic_info.acct_dept_email2 !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.acct_dept_email2);
    }
    
    if($invoker.client_basic_info.sec_email || $invoker.client_basic_info.sec_email !=""){
    	$scope.multiple_emails.push($invoker.client_basic_info.sec_email);
    }
	
	if($invoker.staffing_consultant.admin_email || $invoker.staffing_consultant.admin_email !=""){
    	$scope.multiple_emails.push($invoker.staffing_consultant.admin_email);
    }

	$scope.multiple_emails.push("accounts@remotestaff.com.au");

	var template_hdr = [
		"", 
		"Payment Request (1st Degree)",
		"Urgent Payment Request (2nd Degree)",
		"Payment Required (3rd Degree)",
		"Cancellation Letter (4th Degree)"
	];	
	$scope.template_header = template_hdr[$degree];
	$scope.degree = $degree;
	$scope.invoice = $invoker.invoice;


    $scope.options = {
        height: 300,
        toolbar: []
    };
    
   	$http.get(NJS_API + "/invoice/get-invoice-email-degree-template/?mongo_id="+$invoker.invoice._id+"&degree="+$scope.degree).success(function(response){
		$scope.email_template_degree_content = response;
	});
	
	
	$scope.onSelected = function (selectedItem) {
  		console.log(selectedItem);
  		$scope.multiple_emails.push(selectedItem);
	};
	
	$scope.onRemove = function(selectedItem){
		var index = $scope.multiple_emails.indexOf(selectedItem);
		console.log(index);
		if (index > -1) {
    		$scope.multiple_emails.splice(index, 1);
		}
	};
	
	
	$scope.send_email_degree_template = function(){
		console.log($scope.multiple_emails);
			
        var data = {
			couch_id : $invoker.invoice.couch_id,
			mongo_id : $invoker.invoice._id,			
			admin : $invoker.admin_name,			
			custom_message : $scope.email_template_degree_content,
			multiple_emails : $scope.multiple_emails,
			custom : true
		};
		console.log(data);
		
		$scope.loadingEmailDegree = true;
		$http.post(NJS_API + "/send/invoice-with-attachment-per-recipient/", data).success(function(response){
			
			if(response.success){
				$scope.loadingEmailDegree = false;
				$invoker.history = response.history;								
				toaster.pop({
		            type: 'success',
		            title: 'Custom Message',
		            body: response.msg,
		            showCloseButton: true,
		        });
		        $modalInstance.dismiss('cancel');
		        setTimeout(function() {
		        	delete_pdf($scope, $http, $invoker.invoice._id);
				},5000);

		        
			}
		}).error(function(response){
			$scope.loadingEmailDegree = false;
			$modalInstance.dismiss('cancel');
			alert("There's a problem in sending invoice. Please try again.");
		});
		
	};
	
	$scope.close_email_degree_template = function () {
        $modalInstance.dismiss('cancel');
    };
	
	
}

rs_module.controller('InvoiceDetailsController',["$scope", "$stateParams","$http", "$modal", "$location",  "toaster", InvoiceDetailsController]);
rs_module.controller('AddPaymentModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker", "toaster", AddPaymentModalInstanceCtrl]);
rs_module.controller('InvoiceHistoryModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker", "toaster", InvoiceHistoryModalInstanceCtrl]);
rs_module.controller('InvoiceNotesModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker", "toaster", InvoiceNotesModalInstanceCtrl]);
rs_module.controller('DisableAutoFollowUpModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker", "toaster", DisableAutoFollowUpModalInstanceCtrl]);
rs_module.controller('EmailCustomMessageUpModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$invoker", "toaster", EmailCustomMessageUpModalInstanceCtrl]);
rs_module.controller('InvoiceEmailTemplateModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$degree", "$invoker", "toaster", InvoiceEmailTemplateModalInstanceCtrl]);

