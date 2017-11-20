/**
 * Controllers for Manage Payment Advise Modal
 */
function SendPaymentNoticeModalInstanceController ($scope, $modalInstance, $http, $order_id, $payment_advise, $payment_advise_amount,$client_name, $client_email,$invoice, $invoker,toaster) {
	var api_url = jQuery("#BASE_API_URL").val();
	
	$scope.editor_options = {
	    height: 300,
	    focus: true,
	    airMode: true,
	    toolbar: [
	            ['style', ['bold', 'italic', 'underline']]
	            
	           
	        ]
	  };
	
	//initialise drop zone
	$scope.files = [];
	
	var addedDropzone = null;
	
	$scope.config_dropzone = {
	    url: api_url+"/invoices/attach-payment-notice/",
	    maxFilesize: 100,
	    paramName: "uploadfile",
	    maxThumbnailFilesize: 5,
	    method:"post",
	    autoProcessQueue: false,
	    uploadMultiple:true,
	    init: function() {
	        var scope = $scope;
	        scope.files.push({file: 'added'});
	        this.on('success', function(file, json) {
	        	//payment_notice();
	        });
	        this.on('addedfile', function(file) {
	            addedDropzone = this;
	            scope.$apply(function(){
	                
	                scope.files.push({file: 'added'});
	            });
	        });
	        this.on('drop', function(file) {
	            
	        });
	        this.on('sending',function(file, xhr, formData){
	        	formData.append("subject", $scope.email_subject);
	        	formData.append("to", $scope.client_email);
	        	formData.append("content", $scope.emailText);
	        	formData.append("admin_id", jQuery("#ADMIN_ID").val());
	        	if (typeof $scope.email_cc != "undefined"&&$scope.email_cc){
		    		formData.append("cc", $scope.email_cc);
		    	}
	            formData.append("order_id", $order_id);
	        });
	        
	    }
	};
	
	if ($invoice.payment_advise_amount>$invoice.total_amount){
			
		$scope.emailText = "Dear "+$client_name+",<br/><br/>Thanks for your payment amounting to "+$payment_advise_amount;
		$scope.emailText += "<br/><br/>The amount you paid is over the invoice "+$invoice.order_id+" amount as your invoice amount is "+$invoice.total_amount_money+". We created a new invoice to account your overpayment against Invoice "+$invoice.order_id+"; this has been mark as PAID as well.";
		$scope.emailText += "<br/><br/>Should you have any questions, please don't hesitate to contact us. <a href=\"mailto:accounts@remotestaff.com.au\">accounts@remotestaff.com.au</a><br/><br/>International Clients:<br/>USA ph: +1(415) 376 1472<br/>UK ph: +44(020) 3286 9010<br/>AUS ph: +61(02) 8014 9196";
	}else{	
		$scope.emailText = "Hi "+$client_name+",<br/><br/>This is to confirm receipt of your payment of "+$payment_advise_amount;
		$scope.emailText += " through EFT on [date of payment]. We have allocated this payment to the number of hours of your staff.<br/><br/>Please see below and attached Invoice for your reference, this has been mark as PAID already. We have now cancelled your Invoice ";
		$scope.emailText += $order_id+".<br/><br/>Thank you for your payment.<br/><br/>Should you have any questions, please don't hesitate to contact us. <a href=\"mailto:accounts@remotestaff.com.au\">accounts@remotestaff.com.au</a><br/><br/>International Clients:<br/>USA ph: +1(415) 376 1472<br/>UK ph: +44(020) 3286 9010<br/>AUS ph: +61(02) 8014 9196";		
	}

	
	if (typeof $invoice.date_paid_full != "undefined"){
		$scope.emailText = $scope.emailText.replace("[date of payment]", $invoice.date_paid_full);	
	}
	
	
	$scope.email_subject = "Payment Received for Invoice "+$order_id;
	
    $scope.payment_notice_cancel = function () {
    	
    	$modalInstance.dismiss('cancel');
    };
    
    function payment_notice(){
    	var data = {
    		subject:$scope.email_subject,
    		to:$scope.client_email,
    		
    		content:$scope.emailText,
    		admin_id:jQuery("#ADMIN_ID").val()
    	};
    	
    	if (typeof $scope.email_cc != "undefined"&&$scope.email_cc){
    		data.cc = $scope.email_cc;
    	}
    	
    	data.order_id = $order_id;
    	
    	$scope.process_button = "Processing...";
        $http({
		  method: 'POST',
		  url: api_url + "/invoices/send-payment-notice/",
		  data: data
		}).success(function(response) {
				if (response.success){
					toaster.pop({
			            type: 'success',
			            title: 'Process Complete',
			            body: 'Payment Notice Sent!',
			            showCloseButton: true,
			            timeout: 1000
			        });
				  	
				  	setTimeout(function(){			  		
				        $modalInstance.close();
				        $invoker.search();
				  	}, 600);	  					
				}else{
					$scope.errors = response.errors;
				}
				$scope.process_button = "Send";
			
		});
    }
    
    $scope.send_payment_notice = function(){
    	
    	if (addedDropzone!=null){
    		addedDropzone.processQueue();
    	}else{
    		payment_notice();
    	}

    	
    };
   	$scope.payment_advise = $payment_advise;
	$scope.process_button = "Send";
	$scope.client_name = $client_name;
	$scope.client_email = $client_email;
	$scope.payment_advise_amount = $payment_advise_amount;
	$scope.order_id = $order_id;
	$scope.invoice = $invoice;
}


/**
 * Controllers for Manage Payment Advise Modal
 */
function UpdatePaymentAdviseModalInstanceController ($scope, $modalInstance, $http, $order_id, $payment_advise, $payment_advise_amount,$invoker,toaster) {
	var api_url = jQuery("#BASE_API_URL").val();
	$scope.order_id = $order_id;
	if ($payment_advise=="No"){
		$scope.payment_advise_amount = "0.00";
	
	}else{
		$scope.payment_advise_amount = $payment_advise_amount;	
	}
	
	
	$scope.payment_advise = $payment_advise;
	$scope.process_button = "Save changes";
	$scope.payment_advise_ok = function () {
		
		var data = {
			order_id:$scope.order_id,
			payment_advise_amount:$scope.payment_advise_amount,
			payment_advise:$scope.payment_advise,
			admin_id:jQuery("#ADMIN_ID").val()
			
		};
		
		$scope.process_button = "Processing...";
        $http({
		  method: 'POST',
		  url: api_url + "/invoices/update-payment-advise/",
		  data: data
		}).success(function(response) {
				if (response.success){
					toaster.pop({
			            type: 'success',
			            title: 'Update Complete',
			            body: 'Payment Advised Received!',
			            showCloseButton: true,
			            timeout: 1000
			        });
				  	
				  	setTimeout(function(){			  		
				        $modalInstance.close();
				        $invoker.search();
				  	}, 600);	  					
				}else{
					$scope.errors = response.errors;
				}
				$scope.process_button = "Save changes";
			
		});
        
    };

    $scope.payment_advise_cancel = function () {
    	
    	$modalInstance.dismiss('cancel');
    };
    
}


/**
 * Manage Payment Advise Controller
 */
function ManagePaymentAdviseController($scope, $http, $modal,$toaster){
	$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	var api_url = jQuery("#BASE_API_URL").val();
	$scope.view.query = "";
	$scope.view.selected_date_range = {startDate: null, endDate: null};
	$scope.current_page = 1;
	$scope.new_invoices = [];
	$scope.paid_invoices = [];
	$scope.cancelled_invoices = [];
	$scope.next_new_page = 2;
	$scope.next_paid_page = 2;
	$scope.next_cancelled_page = 2;
	
	
	//added payment advise filters
	var payment_choices = [{value:"", label:"All"}, {value:"yes", label:"Yes"}, {value:"no", label:"No"}];
	$scope.payment_advise_options = payment_choices;
	
	
	$scope.view.selected_payment_advise = "";
	
	$scope.view.payment_advise_yes = false;
	$scope.view.payment_advise_no = true;
	$scope.view.payment_advise_amount = "0.00";
	$scope.view.disabled_payment_advise_amount = false;
	
	$scope.search = function(){
		searchInvoices($scope,$http,"new");
		searchInvoices($scope,$http,"paid");
		searchInvoices($scope,$http,"cancelled");
	};
	
	
	$scope.updatePaymentAdvise = function(order_id,payment_advise,payment_advise_amount){
		 var modalInstance = $modal.open({
            templateUrl: 'views/common/accounts/update-payment-advise.html',
            controller: UpdatePaymentAdviseModalInstanceController,
            resolve:{
            	$order_id:function(){
            		return order_id;
            	},
            	$payment_advise:function(){
            		return payment_advise;
            	},
            	$payment_advise_amount:function(){
            		return payment_advise_amount;
            	},
            	$invoker:function(){
            		return $scope;
            	}
            	
            }
        });
        
	};
	
	$scope.sendPaymentNotice = function(order_id,payment_advise,payment_advise_amount,client_name,client_email,invoice){
		var modalInstance = $modal.open({
            templateUrl: 'views/common/accounts/send-payment-advise-notice.html',
            controller: SendPaymentNoticeModalInstanceController,
            size:"lg",
            resolve:{
            	$order_id:function(){
            		return order_id;
            	},
            	$payment_advise:function(){
            		return payment_advise;
            	},
            	$payment_advise_amount:function(){
            		return payment_advise_amount;
            	},
				$client_name:function(){
					return client_name;
				},
				$client_email:function(){
					return client_email;
				},
				$invoice:function(){
					return invoice;
				},
            	$invoker:function(){
            		return $scope;
            	}
            	
            }
        });
		
	};
	
	$scope.show_more_invoices = function(status){
		
		searchAppendInvoices($scope,$http,status);
	};
	$scope.search();
}



function searchAppendInvoices($scope, $http, status){
	var api_url = jQuery("#BASE_API_URL").val();
	
	var data = {};
	data.status = status;
	
	if (status=="new"){
		data.page = $scope.next_new_page;

	}else if (status=="paid"){
		data.page = $scope.next_paid_page;
	}else{
		data.page = $scope.next_cancelled_page;

	}

	data.limit = 1;
	data.q = $scope.view.query;
	if ($scope.view.selected_date_range.startDate!=null){
		try{
			data.date_from = formatDate($scope.view.selected_date_range.startDate);
			data.date_to = formatDate($scope.view.selected_date_range.endDate);
			
		}catch(e){
			
		}
		
	}
	
	$http({
	  method: 'POST',
	  url: api_url + "/invoices/get-invoices",
	  data: data
	}).success(function(response) {
			if (status=="new"){
				$scope.new_invoices.push.apply($scope.new_invoices, response.result);
				$scope.next_new_page = response.next_page;

			}else if (status=="paid"){
				$scope.paid_invoices.push.apply($scope.paid_invoices, response.result);
				$scope.next_paid_page = response.next_page;			
			}else{
				$scope.cancelled_invoices.push.apply($scope.cancelled_invoices, response.result);
				$scope.next_cancelled_page = response.next_page;
			}
		if (status=="new"){
			$scope.hide_more_new = response.max_page<=$scope.next_new_page;
		}else if (status=="paid"){
			$scope.hide_more_paid = response.max_page<=$scope.next_paid_page;
		}else{
			$scope.hide_more_cancelled = response.max_page<=$scope.next_cancelled_page;
		}
		
	});
}
function searchInvoices($scope, $http, status){
	var api_url = jQuery("#BASE_API_URL").val();
	$scope.current_page = 1;
	var data = {};
	data.status = status;
	data.page = $scope.current_page;
	data.limit = 1;
	data.q = $scope.view.query;
	if ($scope.view.selected_date_range.startDate!=null){
		try{
			data.date_from = formatDate($scope.view.selected_date_range.startDate);
			data.date_to = formatDate($scope.view.selected_date_range.endDate);
			
		}catch(e){
			
		}
		
	}
	if ($scope.view.selected_payment_advise!=""){
		data.payment_advise = $scope.view.selected_payment_advise;
	}
	$http({
	  method: 'POST',
	  url: api_url + "/invoices/get-invoices",
	  data: data
	}).success(function(response) {
			if (status=="new"){
			  	$scope.new_invoices = response.result;
			  	$scope.new_invoice_count = response.count;
				
			}else if (status=="paid"){
			  	$scope.paid_invoices = response.result;
				$scope.paid_invoice_count = response.count;
			}else{
		  		$scope.cancelled_invoices = response.result;
		  		$scope.cancelled_invoice_count = response.count;
		  		
				
			}
			$scope.next_new_page = 2;
			$scope.next_paid_page = 2;
			$scope.next_cancelled_page = 2;
		
		if (status=="new"){
			$scope.hide_more_new = response.max_page<=$scope.next_new_page;
		}else if (status=="paid"){
			$scope.hide_more_paid = response.max_page<=$scope.next_paid_page;
		}else{
			$scope.hide_more_cancelled = response.max_page<=$scope.next_cancelled_page;
		}
	});
}


/**
 * translateCtrl - Controller for translate
 */
function translateCtrl($translate, $scope) {
    $scope.changeLanguage = function (langKey) {
        $translate.use(langKey);
        $scope.language = langKey;
    };
}



function toastrCtrl($scope, toaster){


}
rs_module.controller('ManagePaymentAdviseController',["$scope", "$http", "$modal", ManagePaymentAdviseController]);
rs_module.controller('UpdatePaymentAdviseModalInstanceController',["$scope", "$modalInstance", "$http", "$order_id","$payment_advise","$payment_advise_amount","$invoker",UpdatePaymentAdviseModalInstanceController]);
rs_module.controller('SendPaymentNoticeModalInstanceController',["$scope", "$modalInstance", "$http", "$order_id","$payment_advise","$payment_advise_amount","$client_name","$client_email","$invoice","$invoker",UpdatePaymentAdviseModalInstanceController]);

rs_module.controller('translateCtrl',translateCtrl);
rs_module.controller('toastrCtrl', toastrCtrl);
