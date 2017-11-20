/**
 * Controller for Timesheet page
 *
 * @version 1 - Initial Commit
 */

function TimesheetController($scope, $http, $modal, toaster){

	$scope.selectedAdjArray = [];
	$scope.records = null;
	$scope.special_arrangements = "";
	$scope.requestCheck = false;
	//SAMPLE HELLO WORLD
	//$scope.ts.query = "Type anything under the sun!";

	//initialize date range
	$scope.ts.selected_date_range = {startDate: new Date(), endDate: new Date()};
	$scope.ts.exlude_inactive_clients = true;
	$scope.client_options = null;


	$scope.backgroundColors = {};
	$scope.backgroundColors.record = [];

	//On click of Search buttong
	$scope.search = function(){
		//console.log($scope.ts.selected_date_range);

		searchTimesheet($scope, $http, toaster);
	};

	//Refresh client list
	$scope.refreshClients = function(){
		console.log($scope.ts.exlude_inactive_clients);
		if($scope.ts.exlude_inactive_clients == true){
			$scope.client_options = $scope.clients;
		}else{
			$scope.client_options = $scope.all_clients;
		}
		setTimeout(function() {
        	jQuery("#leads_id").trigger("chosen:updated");
		},500);

	};

	//Initialize staffing consultants
	//$scope.ts.selected_staffing_consultant
	$scope.searchClients = function(){
		//console.log("Hello World");
		//console.log($scope.ts.selected_staffing_consultant);
		searchScClients($scope, $http, $scope.ts.selected_staffing_consultant);
	};

	//Initialize Client
    $scope.searchStaff = function(ctrl){
        searchClientStaffs($scope, $http, $scope.ts.client, ctrl);
    };
    // initialize retrieval of subcons on page load
    $scope.searchStaff($scope.ts);

    $scope.getClientSc = function(sc_id) {
    	var njs_url = jQuery("#NJS_API_URL").val();

        $http.get(njs_url+"/timesheet-details-notes/timesheet-get-clients?sc_id="+sc_id.id).success(function(response){
        	if (response.result) {
        		var clientData = response.result.leads_detail;
        		var hiring_coord_id = response.result.staffing_consultant_detail;
        		$scope.ts.client = {
        			email: clientData.email,
					fname: clientData.fname,
					hiring_coordinator_id: hiring_coord_id.admin_id,
					leads_id: clientData.id,
                    lname: clientData.lname
        		};
			}else {
                $scope.ts.client = {};
        		alert("No Client Available");
			}
        });
	};

	$scope.setDefaultDateRangeValue = function(){
		console.log($scope.ts.selected_week);
		$scope.ts.selected_date_range = {startDate: $scope.ts.selected_week.start_date, endDate: $scope.ts.selected_week.end_date };
	};

	$scope.runLoadingDemo = function() {
        // start loading
        $scope.loadingDemo = true;
        setTimeout(function() {
            	$scope.loadingDemo = false;
			},2000);
    };

    $scope.openModalHrsChrgClient = function(record){
    	var modalInstance = $modal.open({
            templateUrl: 'views/common/timesheet/modal_hrs_chrg_client.html',
            controller: HrsChrgClientModalInstanceCtrl,
            windowClass: "animated fadeIn",
            resolve:{
            	$record:function(){
            		return record;
            	},
            	$invoker:function(){
            		return $scope;
            	}

            }
        });
    };

    $scope.openModalNote = function(record){
    	var modalInstance = $modal.open({
            templateUrl: 'views/common/timesheet/modal_notes.html',
            controller: NotesModalInstanceCtrl,
            windowClass: "animated fadeIn",
            resolve:{
            	$record:function(){
            		return record;
            	},
            	$invoker:function(){
            		return $scope;
            	}

            }
        });
    };

    $scope.openModalAdjHrs = function(id, reference_date, record){
    	var modalInstance = $modal.open({
            templateUrl: 'views/common/timesheet/modal_adj_hrs.html',
            controller: AdjHrsModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "sm",
            resolve:{
            	$id:function(){
            		return id;
            	},
            	$reference_date:function(){
            		return reference_date;
            	},
            	$record:function(){
            		return record;
            	},
            	$invoker:function(){
            		return $scope;
            	}

            }
        });
    };

	$scope.openModalAutoAdjustHrs = function(ctrl){

		if(!ctrl.subcon.id){
			alert("Please select a staff.");
			return false;
		}
		var modalInstance = $modal.open({
            templateUrl: 'views/common/timesheet/modal_auto_adj_hrs.html',
            controller: AutoAdjHrsModalInstanceCtrl,
            windowClass: "animated fadeIn",
            size: "sm",
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


	$scope.openModalHistory = function(ctrl){
		if(!ctrl.subcon.id){
			alert("Please select a staff.");
			return false;
		}
		var modalInstance = $modal.open({
            templateUrl: 'views/common/timesheet/modal_history.html',
            controller: HistoryModalInstanceCtrl,
            windowClass: "animated fadeIn",
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

	$scope.openModalCommunicationRecords = function(ctrl){
		if(!ctrl.subcon.id){
			alert("Please select a staff.");
			return false;
		}
		var modalInstance = $modal.open({
            templateUrl: 'views/common/timesheet/modal_communication_records.html',
            controller: CommunicationRecordsModalInstanceCtrl,
            windowClass: "animated fadeIn",
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

	$scope.recompute = function(){
		recomputeDiffChargeToClient($scope, $http, toaster);
	};


	$scope.lodge = function(){
		if ($scope.requestCheck) {
            toaster.pop({
				type: 'warning',
				title: 'Lodge to RBS',
				body: "Request is still on process",
				showCloseButton: true
			});
            return false;
		} else {
            $scope.requestCheck = true;
		}
		if( confirm("Are you sure you want to save your changes in adjusted hours?") ){
			lodgeToRBS($scope, $http, toaster);
		} else {
            $scope.requestCheck = false;
		}
	};

	$scope.initForm = function(){
		var API_URL = jQuery("#BASE_API_URL").val();

		var data = {};
		data.admin_id = jQuery("#ADMIN_ID").val();

		$http.get(API_URL+"/timesheet-weeks/load-defaults/?admin_id="+jQuery("#ADMIN_ID").val()).success(function(response){
			$scope.staffing_consultants = response.defaults.staffing_consultants;
			$scope.ts.selected_staffing_consultant = "5";
			$scope.clients = response.defaults.clients;
			$scope.all_clients = response.defaults.all_clients;
			$scope.client_options = response.defaults.clients;

			$scope.lock_unlock_timesheet = response.defaults.lock_unlock_timesheet;
			setTimeout(function() {
            	jQuery("#leads_id").trigger("chosen:updated");
			},500);
		});

		//Get current year available weeks
		//
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

		/*
		$scope.options = [
	        {
	          name: 'Active',
	          value: 'active'
	        },
	        {
	          name: 'Inactive',
	          value: 'inactive'
	        }
	    ];

	    //$scope.ts.selectedClientStatus = $scope.options[0];
		*/

	};

	

	$scope.checkTimesheetStatus = function(data)
	{

		$scope.backgroundColors.record[data.timesheet_details_id] = "#ed5565";

		if(data.timesheet_details_id == "")
		{
			$scope.backgroundColors.record[data.timesheet_details_id] = "#ed5565";
		}
		else
		{
			if(data.date_status === "locked")
				{

					$scope.backgroundColors.record[data.timesheet_details_id] = "#f8ac59";
				}
				else
				{

					$scope.backgroundColors.record[data.timesheet_details_id] = "#1c84c6";
				}
		}


	};


	$scope.formatDateTime= function(date)
	{
		var formatted_d = "";
		if(date)
		{
			var d = date.split("-");
			if(d.length > 0)
			{
				formatted_d = d[1]+"/"+d[2];
			}
		}

		return formatted_d;
	}


	$scope.initForm();


}

function lodgeToRBS($scope, $http, toaster){


	var API_URL = jQuery("#BASE_API_URL").val();
	$scope.selectedObjArray = [];

	angular.forEach($scope.records, function(record){
  		if(parseFloat(record.adj_hrs) != parseFloat(record.original_adj_hrs)){
  			//console.log(record);
  			$scope.selectedObjArray.push(record);
  		}

	});

	if(!$scope.ts.subcon.id){
		alert("Please select a staff");
        $scope.requestCheck = false;
		return false;
	}

	if ($scope.selectedObjArray.length <1){
		alert("There are no changes made in adjusted hours.");
        $scope.requestCheck = false;
		return false;
	}



	$scope.loadingLodgeDemo = true;
	//console.log($scope.selectedObjArray);
	$scope.counter = 0;
	
	
	for(var i=0; i<$scope.selectedObjArray.length; i++){
		var data = {};
		data.records = [];
		data.records.push($scope.selectedObjArray[i]);
	 	data.admin_id = jQuery("#ADMIN_ID").val();
	 	data.subcontractors_id = $scope.ts.subcon.id;
	 	
	 	//console.log(data);
	 	$http({
			method: 'POST',
		  	url: API_URL+"/timesheet-adjustments/mass-update-adj-hrs/",
		  	data: data
		}).success(function(response) {
            $scope.requestCheck = false;
			console.log(response);				
		}).error(function(response){
            $scope.requestCheck = false;
			alert("There's something wrong in updating adjusted hours. Please try again later.");
		});
	 	
	 	$scope.counter = $scope.counter + 1;
	}
	// $scope.loadingLodgeDemo = false;
	// console.log("$scope.counter :" + $scope.counter);
	// console.log("$scope.selectedObjArray.length : "+ $scope.selectedObjArray.length);
	// if($scope.counter == $scope.selectedObjArray.length){
		// $scope.loadingLodgeDemo = false;
		// console.log("All finished");
		// toaster.pop({
            // type: 'success',
            // title: 'Lodge to RBS',
            // body: "Successfully lodge to client's Running Balance",
            // showCloseButton: true,
        // });
		// searchTimesheet($scope, $http);
	// }
	
	setTimeout(function() {
    	$scope.loadingLodgeDemo = false;
    	console.log("All finished");
    	toaster.pop({
            type: 'success',
            title: 'Lodge to RBS',
            body: "Successfully lodge to client's Running Balance",
            showCloseButton: true,
        });
		searchTimesheet($scope, $http, toaster);
    },3000);

}

function recomputeDiffChargeToClient($scope, $http, toaster){
	if(confirm("Are you sure you want to recompute Diff Charge to Client?")){
		var API_URL = jQuery("#BASE_API_URL").val();
		if(!$scope.ts.subcon.id){
			alert("Please select a Staff");
			return false;
		}

		$scope.loadingDemo2 = true;
		var data = {};
		data.start_date = formatDate($scope.ts.selected_date_range.startDate);
		data.end_date = formatDate($scope.ts.selected_date_range.endDate);
		data.subcontractors_id = $scope.ts.subcon.id;
		data.admin_id = jQuery("#ADMIN_ID").val();

		$http({
			method: 'POST',
		  	url: API_URL+"/timesheet-adjustments/recompute-diff-charge-to-client/",
		  	data: data
		}).success(function(response) {
			if(response.success){
				toaster.pop({
		            type: 'success',
		            title: 'Recompute Diff Charge to Client',
		            body: "Process completed",
		            showCloseButton: true,
		        });
			}else{
				toaster.pop({
		            type: 'error',
		            title: 'Recompute Diff Charge to Client',
		            body: response.error,
		            showCloseButton: true,
		        });
			}
			$scope.loadingDemo2 = false;
			searchTimesheet($scope, $http, toaster);
		}).error(function(response){
			$scope.loadingDemo2 = false;
			alert("There's something wrong in recomputing. Please try again later.");
		});

	}
}
function searchTimesheet($scope, $http, toaster){
    $scope.requestCheck = false;
	var API_URL = jQuery("#BASE_API_URL").val();
	/*
	if(!$scope.ts.selected_date_range.startDate){
		alert("Start Date cannot be NULL");
		return false;
	}

	if(!$scope.ts.selected_date_range.endDate){
		alert("End Date cannot be NULL");
		return false;
	}
	*/
	//console.log($scope.ts.selected_date_range);
	if (typeof $scope.ts.subcon == 'undefined') {
        toaster.pop({
            type: 'error',
            title: 'Search Timesheet',
            body: 'Please select staff',
            showCloseButton: true
        });
        return false;
    }

	$scope.loadingDemo = true;
	$scope.records = null;
	$scope.special_arrangements = "";


	var data = {};
	data.start_date = $scope.ts.selected_date_range.startDate;
	data.end_date = $scope.ts.selected_date_range.endDate;
	data.subcontractors_id = $scope.ts.subcon.id;




	$http({
	  	method: 'POST',
	  	url: API_URL+"/timesheet-weeks/get-timesheet-by-date-range/ ",
	  	data: data
	}).success(function(response) {
		if(response.success){
			$scope.loadingDemo = false;
			$scope.records = response.records;
			$scope.locked_dates_counter = response.locked_dates_counter;
            $scope.userID = response.userid;
			angular.forEach($scope.records, function(record){
				//if (record.selected) $scope.selectedDatesArray.push(record.timesheet_details_id);
				//console.log(record);
				if(record.adj_hrs == "" || typeof record.adj_hrs == "undefined"){
					record.adj_hrs = 0.00;
				}

				record.original_adj_hrs = record.adj_hrs;
			});

			$scope.totals = response.totals;
			$scope.special_arrangements = response.special_arrangements;
		}else{
			if(response.error == "OPTIONS"){
				$scope.loadingDemo = true;
				searchTimesheet($scope, $http, toaster);
			}else {
				$scope.loadingDemo = false;
				toaster.pop({
					type: 'error',
					title: 'Fetch Timesheet by date range',
					body: response.error,
					showCloseButton: true,
				});
			}

		}


	}).error(function(response){
		$scope.loadingDemo = false;
		alert("There's something wrong in retrieving timesheet. Please try again later.");
	});
}

function searchClientStaffs($scope, $http, client,  ctrl){
    var API_URL = jQuery("#BASE_API_URL").val();
    
    var data = {};
    if (client) {
        data.leads_id = client.leads_id;
        ctrl.selected_staffing_consultant =  client.hiring_coordinator_id;
    }else {
        data.leads_id = '';
    }

    $http.get(API_URL+"/timesheet-weeks/get-client-staffs/?leads_id="+data.leads_id).success(function(response){
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
function searchScClients($scope, $http, admin_id){
	var API_URL = jQuery("#BASE_API_URL").val();
	//console.log(admin_id);
	var data = {};
	data.admin_id = admin_id;
	/*
	$http({
	  method: 'POST',
	  url: API_URL+"/timesheet-weeks/get-sc-clients/",
	  data: data
	}).success(function(response) {
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
	*/
	
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

function HrsChrgClientModalInstanceCtrl($scope, $modalInstance, $http, $record, $invoker, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	//console.log("Modal open");
	//$scope.timesheet_details_id = $record.timesheet_details_id;
	$scope.reference_date = $record.reference_date;
	$scope.hrs_charged_to_client = $record.hrs_charged_to_client;	
	//console.log($record.timesheet_details_id+" "+$scope.reference_date);
	
	
	$scope.update_timesheet_hrs_charge_to_client = function(){
		update_timesheet_hrs_charge_to_client($scope, $modalInstance, $http, $record, $invoker, toaster);	
	};
	
	$scope.close_hrs_chrg_client = function () {
        $modalInstance.dismiss('cancel');
    };
}

function update_timesheet_hrs_charge_to_client($scope, $modalInstance, $http, $record, $invoker, toaster){
	var API_URL = jQuery("#BASE_API_URL").val();
	if(!$.isNumeric($scope.hrs_charged_to_client)){					
		alert("Please enter a valid amount");
		return false;
	}

	var data = {
		timesheet_details_id : $record.timesheet_details_id,
		hrs_charged_to_client : $scope.hrs_charged_to_client,
		admin_id:jQuery("#ADMIN_ID").val()
	};
	
	// console.log(data);
	
	$scope.loading5 = true;
	$http({
		method: 'POST',
	  	url: API_URL+"/timesheet-adjustments/update-hours-charge-client/",
	  	data: data
	}).success(function(response) {
		
		if(response.success){			
			toaster.pop({
	            type: 'success',
	            title: 'Adjust Timesheet Hrs Chrg Client',
	            body: "Successfully adjusted",
	            showCloseButton: true,
	        });        
			$record.hrs_charged_to_client = $scope.hrs_charged_to_client;
			$scope.loading5 = false;
			$modalInstance.dismiss('cancel');			
		}else{
			
			if(response.error == "OPTIONS"){
				$scope.loading5 = true;
				update_timesheet_hrs_charge_to_client($scope, $modalInstance, $http, $record, $invoker);
			}else {
				$scope.loading5 = false;
				toaster.pop({
					type: 'error',
					title: 'Adjust Timesheet Hrs Chrg Client',
					body: response.error,
					showCloseButton: true,
				});
			}
		}
		
	});
}


function NotesModalInstanceCtrl ($scope, $modalInstance, $http, $record, $invoker) {
	var API_URL = jQuery("#BASE_API_URL").val();

	//console.log($record);

	//$scope.timesheet_details_id = $record.timesheet_details_id;
	//$scope.notes_selected_reference_date = $record.reference_date;
	//console.log($id+" "+$reference_date);


	var data = {};
	data.timesheet_details_id = $record.timesheet_details_id;
	$http({
	  method: 'POST',
	  url: API_URL+"/timesheet-weeks/show-timesheet-notes/",
	  data: data
	}).success(function(response) {
		$scope.notes = response.notes;
	});


	$scope.add_timesheet_notes = function(){

		if(!$scope.reference_date_note){
			alert("Blank note is not allowed.");
			return false;
		}
		var data = {
			timesheet_details_id : $record.timesheet_details_id,
			note:$scope.reference_date_note,
			admin_id:jQuery("#ADMIN_ID").val()
		};

		$scope.loading5 = true;
		$http({
		  method: 'POST',
		  url: API_URL+"/timesheet-weeks/add-timesheet-notes/",
		  data: data
		}).success(function(response) {
			if(response.success){
				$scope.reference_date_note = "";
				//jQuery("#ts_note_"+$scope.timesheet_details_id).html(response.total_notes);
				$record.total_notes = response.total_notes;
			}
			$scope.loading5 = false;
			$modalInstance.dismiss('cancel');
		});


	};

	$scope.close_notes = function () {
        $modalInstance.dismiss('cancel');
    };
}

function AdjHrsModalInstanceCtrl ($scope, $modalInstance, $http, $id, $reference_date, $record, $invoker) {
	var API_URL = jQuery("#BASE_API_URL").val();

	//console.log($scope);
	$scope.timesheet_details_id = $id;
	$scope.adj_hrs_selected_reference_date = $reference_date;

	var data = {};
	data.timesheet_details_id = $id;
	$http({
	  method: 'POST',
	  url: API_URL+"/timesheet-weeks/get-timesheet-details/",
	  data: data
	}).success(function(response) {
		$scope.ts_details_data = response.data;
		$scope.ts_details_adj_hours = $scope.ts_details_data.adj_hrs;
		$scope.ts_details_regular_rostered = $scope.ts_details_data.regular_rostered;
		$scope.ts_details_hrs_charged_to_client = $scope.ts_details_data.hrs_charged_to_client;
	});

	$scope.update_timesheet_adj_hrs = function(){
		// console.log($scope.selectedAdjArray);
		$record.adj_hrs = $scope.ts_details_adj_hours;
		$modalInstance.dismiss('cancel');
		/*
		$scope.loading5 = true;
		if(!$scope.ts_details_adj_hours){
			alert("Null or Blank value is not allowed.");
			return false;
		}
		var data = {
			timesheet_id : $scope.ts_details_data.timesheet_id,
			timesheet_details_id : $scope.timesheet_details_id,
			adj_hrs:$scope.ts_details_adj_hours,
			current_admin_id:jQuery("#ADMIN_ID").val()
		};

		//console.log(data);
		$http({
		  method: 'POST',
		  url: API_URL+"/timesheet-adjustments/update-adjusted-hours/",
		  data: data
		}).success(function(response) {
			if(response.success){
				//do nothing for the moment
				$record.date_status = "locked";
				$record.adj_hrs = $scope.ts_details_adj_hours;
			}else{
				alert(response.error);
			}

			$scope.loading5 = false;
			$modalInstance.dismiss('cancel');
		}).error(function(response){
			alert("There's something wrong in adjusting. Please try again later");
			$scope.loading5 = false;
			$modalInstance.dismiss('cancel');
		});
		*/
	};

	$scope.close_adj_hrs = function () {
        $modalInstance.dismiss('cancel');
    };
}

function AutoAdjHrsModalInstanceCtrl ($scope, $modalInstance, $http, $ctrl, $invoker , SweetAlert, toaster) {
	var API_URL = jQuery("#BASE_API_URL").val();

	//console.log($ctrl.selected_date_range.startDate +" to "+$ctrl.selected_date_range.endDate);
	$scope.adj_hrs_selected_date_range = formatDate2($ctrl.selected_date_range.startDate) +" to "+formatDate2($ctrl.selected_date_range.endDate);
	$scope.selected_adj_hrs_start_date = formatDate($ctrl.selected_date_range.startDate);
	$scope.selected_adj_hrs_end_date = formatDate($ctrl.selected_date_range.endDate);
	$scope.subcon_id = $ctrl.subcon.id;

	$scope.adjustForm = function() {
        if ($scope.auto_adjust_form.$valid) {
            // Submit as normal
            //console.log("Form submission here");
            var data = {
				subcon_id : $scope.subcon_id,
				start_date : $scope.selected_adj_hrs_start_date,
				end_date : $scope.selected_adj_hrs_end_date,
				admin_id : jQuery("#ADMIN_ID").val(),
				field : $scope.selected_adjusted_field,
				basis : $scope.selected_basis
			};

			//console.log(data);
            $scope.loading5 = true;

            $http({
			  method: 'POST',
			  url: API_URL+"/timesheet-adjustments/auto-adjustments/",
			  data: data
			}).success(function(response) {
				if(response.success){

					searchTimesheet($invoker, $http, toaster);
					//Display warnings
					if(response.warning){

						var warning_msg = "";
						angular.forEach(response.warning, function(value, key) {
							//console.log(key + ': ' + value);
							warning_msg += value+"\n";
						});
						if(warning_msg != ""){
							SweetAlert.swal({
					            title: "Warning : Failed to Adjust Timesheet.",
					            text: warning_msg,
					            type: "warning"
					        });
						}
			       }else{
				       	toaster.pop({
				            type: 'success',
				            title: 'Auto Adjustments',
				            body: "Process completed",
				            showCloseButton: true,
				        });
			       }

				}else{
					if(response.error == "OPTIONS"){
						AutoAdjHrsModalInstanceCtrl ($scope, $modalInstance, $http, $ctrl, $invoker , SweetAlert, toaster);
					} else{
						//alert(response.error);
						toaster.pop({
							type: 'error',
							title: 'Auto Adjustments',
							body: response.error,
							showCloseButton: true,
						});
					}

				}
				$scope.loading5 = false;
				$modalInstance.dismiss('cancel');
			}).error(function(response){
				$scope.loading5 = false;
				alert("There's a problem in adjusting timesheet. Please try again later.");
			});

        } else {
            $scope.auto_adjust_form.submitted = true;
            //console.log("Hello World");
            //Do nothing. Form was submitted but with error.
        }
    };

	$scope.close_auto_adj_hrs = function () {
        $modalInstance.dismiss('cancel');
    };


}

function HistoryModalInstanceCtrl($scope, $modalInstance, $http, $ctrl, $invoker) {
	var API_URL = jQuery("#BASE_API_URL").val();

	if(!$ctrl.subcon){
		alert("Please select a Staff.");
		return false;
	}

	//console.log("Hello World");
	var data = {
		subcontractors_id : $ctrl.subcon.id,
		start_date : formatDate($ctrl.selected_date_range.startDate),
		end_date : formatDate($ctrl.selected_date_range.endDate),
	};


	$http({
	  method: 'POST',
	  url: API_URL+"/timesheet-weeks/show-timesheet-history-by-date-range",
	  data: data
	}).success(function(response) {
		if(response.success){
			$scope.histories = response.histories;
		}else{
			alert(response.error);
		}

	}).error(function(response){
		alert("There's a problem in parsing timesheet history. Please try again later.");
	});


	$scope.close_history = function () {
        $modalInstance.dismiss('cancel');
    };
}

function CommunicationRecordsModalInstanceCtrl($scope, $modalInstance, $http, $ctrl, $invoker, toaster) {

	var API_URL = jQuery("#BASE_API_URL").val();

	if(!$ctrl.subcon.id){
		alert("Please select a Staff.");
		return false;
	}

	var data = {
		subcontractors_id : $ctrl.subcon.id,
		start_date : formatDate($ctrl.selected_date_range.startDate),
		end_date : formatDate($ctrl.selected_date_range.endDate),
	};


	$http({
	  method: 'POST',
	  url: API_URL+"/timesheet-weeks/show-timesheet-communication-records",
	  data: data
	}).success(function(response) {
		if(response.success){
			$scope.records = response.records;
		}else{
			//alert(response.error);
			toaster.pop({
	            type: 'error',
	            title: 'Error Special Arrangements',
	            body: response.error,
	            showCloseButton: true,
	        });
		}

	}).error(function(response){
		alert("There's a problem in parsing timesheet communication records. Please try again later.");
	});

	$scope.add_communication_record = function(){
		if(!$scope.reference_communication_note){
			alert("Blank note is not allowed.");
			return false;
		}

		var data = {
			subcontractors_id : $ctrl.subcon.id,
			start_date : formatDate($ctrl.selected_date_range.startDate),
			end_date : formatDate($ctrl.selected_date_range.endDate),
			admin_id : jQuery("#ADMIN_ID").val(),
			note:$scope.reference_communication_note,
		};

		//console.log(data);
        $scope.loading6 = true;

        $http({
		  method: 'POST',
		  url: API_URL+"/timesheet-weeks/add-communication-record/",
		  data: data
		}).success(function(response) {
			if(response.success){
				//console.log(response);
				$scope.reference_communication_note = "";
				$scope.records = response.records;
				$invoker.special_arrangements = response.special_arrangements;


				if(response.msg){
					toaster.pop({
			            type: 'error',
			            title: 'Warning Special Arrangements',
			            body: response.msg,
			            showCloseButton: true,
			        });
				}else{
					toaster.pop({
			            type: 'success',
			            title: 'Special Arrangements',
			            body: "Successfully Added",
			            showCloseButton: true,
			        });
				}

			}else{
				//alert(response.error);
				toaster.pop({
		            type: 'error',
		            title: 'Error Special Arrangements',
		            body: response.error,
		            showCloseButton: true,
		        });
			}
			$scope.loading6 = false;
			$modalInstance.dismiss('cancel');
		}).error(function(response){
			$scope.loading6 = false;
			alert("There's a problem in adding communication record. Please try again later.");
		});
	};


	$scope.close_records = function () {
        $modalInstance.dismiss('cancel');
    };
}


rs_module.controller('TimesheetController',["$scope", "$http", "$modal", "toaster", TimesheetController]);
rs_module.controller('NotesModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$record","$invoker",NotesModalInstanceCtrl]);
rs_module.controller('AdjHrsModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$id","$reference_date", "$record", "$invoker",AdjHrsModalInstanceCtrl]);
rs_module.controller('AutoAdjHrsModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$ctrl", "$invoker", "toaster", AutoAdjHrsModalInstanceCtrl]);
rs_module.controller('HistoryModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$ctrl", "$invoker",HistoryModalInstanceCtrl]);
rs_module.controller('CommunicationRecordsModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$ctrl", "$invoker", "toaster",CommunicationRecordsModalInstanceCtrl]);
rs_module.controller('HrsChrgClientModalInstanceCtrl',["$scope", "$modalInstance", "$http", "$ctrl", "$invoker", "toaster",HrsChrgClientModalInstanceCtrl]);

