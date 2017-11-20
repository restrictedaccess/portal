Date.prototype.toISODate = function() {
	var month = (this.getMonth() + 1);
	if (month + 1 <= 9) {
		month = "0" + month;
	}
	var date = this.getDate();
	if (date + 1 <= 9) {
		date = "0" + date;
	}
	return this.getFullYear() + "-" + month + "-" + date;
};

/**
 * NewInvoiceController - Controller for creating new invoice
 */
function NewInvoiceController($scope, $location, $http, $modal, $toaster) {
	var NJS_API = jQuery("#NJS_API_URL").val();
	var PARAMS = $location.search();
	//customize Invoice Class to have database connection
	Invoice.prototype.getTaxInvoiceNo = function() {
		var me = this;
		setTimeout(function() {
			var data = {
				id : me.client.client_id
			};

			$http.post(NJS_API + "/clients/get-new-tax-invoice-no/", data).success(function(response) {
				me.tax_invoice_no = response.tax_invoice_no;
			});

		}, 500);

		//collect all commissions for the selected client
		setTimeout(function() {

			$http.get(NJS_API + "/commission/get-commision-by-leads-id?leads_id=" + me.client.client_id).success(function(response) {
				$scope.commissions = response.result;
				setTimeout(function() {
					jQuery(".commissions").trigger("chosen:updated");
				}, 500);
			});

		}, 500);

	};

	/**
	 * Sync invoice to database
	 */
	Invoice.prototype.sync = function() {
		var new_history;
		if (this.due_date==null){
			alert("Due Date is required");
			return;
		}
		//add history check
		if (moment(this.original_due_date).format() != moment(this.due_date).format()) {
			new_history = new History();
			new_history.timestamp = new Date();
			new_history.timestamp_unix = moment(new_history.timestamp).unix();
			new_history.changes = "Changed due date from " + moment(this.original_due_date).format() + " to " + moment(this.due_date).format();
			new_history.by = jQuery("#ADMIN_NAME").val() + " :" + jQuery("#ADMIN_ID").val();
			this.addHistory(new_history);
		}
		if (moment(this.original_invoice_date).format() != moment(this.invoice_date).format()) {
			new_history = new History();
			new_history.timestamp = new Date();
			new_history.timestamp_unix = moment(new_history.timestamp).unix();
			new_history.changes = "Changed due date from " + moment(this.original_invoice_date).format() + " to " + moment(this.invoice_date).format();
			new_history.by = jQuery("#ADMIN_NAME").val() + " :" + jQuery("#ADMIN_ID").val();
			this.addHistory(new_history);
		}
		var item_changes = [];
		for (var j = 0; j < this.original_items.length; j++) {
			for (var i = 0; i < this.items.length; i++) {
				var item = this.items[i];
				var original_item = this.original_items[i];
				var change_found = false;
				var description = "Changes found on item number " + item.item_no + "<br/>";
				try{
					if (item.item_no == original_item.item_no) {
						if (item_changes.indexOf(item.item_no)===-1){
							if (item.description != original_item.description) {
								change_found = true;
								description += "Description from <strong>" + original_item.description + "</strong> to <strong>" + item.description + "</strong><br/>";
							}
							if (item.item_type != original_item.item_type) {
								change_found = true;
								description += "Item Type from <strong>" + original_item.item_type + "</strong> to <strong>" + item.item_type + "</strong>";
							}
							console.log(item);
							if (item.quantity != original_item.quantity) {
								change_found = true;
								description += "Quantity from <strong>" + original_item.quantity + "</strong> to <strong>" + item.quantity + "</strong>";
							}
							if (item.unit_price != original_item.unit_price) {
								change_found = true;
								description += "Unit Price from <strong>" + original_item.unit_price + "</strong> to <strong>" + item.unit_price + "</strong>";
							}
							if (item.selected_date!=undefined){
								if (moment(item.selected_date.startDate).format()!=moment(original_item.selected_date.startDate).format()){
									change_found = true;
									description += "Start Date from <strong>" + moment(original_item.selected_date.startDate).format() + "</strong> to <strong>" + moment(item.selected_date.startDate).format() + "</strong>";
								}
								if (moment(item.selected_date.endDate).format()!=moment(original_item.selected_date.endDate).format()){
									change_found = true;
									description += "End Date from <strong>" + moment(original_item.selected_date.endDate).format() + "</strong> to <strong>" + moment(item.selected_date.endDate).format() + "</strong>";
								}
							}
							if (change_found) {
								new_history = new History();
								new_history.timestamp = new Date();
								new_history.timestamp_unix = moment(new_history.timestamp).unix();
								new_history.changes = description;
								new_history.by = jQuery("#ADMIN_NAME").val() + " :" + jQuery("#ADMIN_ID").val();
								this.addHistory(new_history);
								item_changes.push(item.item_no);
								break;
							}
						}

					}
				}catch(e){

				}


			}
		}
        var invoice = this.toJSON();
        if(typeof new_history != "undefined" || invoice.items.length != $scope.initialInvoice.items.length) {

            var me = this;
            $http({
                method : 'POST',
                url : NJS_API + "/invoice/save/",
                data : invoice
            }).success(function(response) {

                if (response.success) {
                    $http.get(NJS_API + "/invoice/sync-daily-rates?order_id=" + invoice.order_id).success(function(response) {
                        alert("Successfully save invoice " + invoice.order_id);
                        var sync_mod_data = {
                            "invoice_number" : invoice.order_id,
                            "date_updated" : new Date(),
                            "updated_by_admin_id" : $("#ADMIN_ID").val(),
                            "updated_by_admin_name" : invoice.added_by,
                            "status" : "Pending"
                        };
                        $http.post(NJS_API + "/invoice-versioning/sync-modification", sync_mod_data).success(function (response) {
                            if(response.success && response.result == "Invoice inserted"){
                                window.location.href = "/portal/accounts_v2/#/invoice/client-account/" + invoice.client_id;
                            } else {
                                alert("Error syncing Invoice Versioning Sync Modification");
                            }
                        });
                    });
                } else {
                    alert("Something went wrong! Please try again");
                }
            });
		} else {
			alert("No changes made.")
		}

	};

	Invoice.prototype.cancel = function(){
		if (this.client==null){
			window.location.href = "/portal/accounts_v2/#/invoice/clients";
		}else{
			window.location.href = "/portal/accounts_v2/#/invoice/client-account/" + this.client.client_id;	
	
		}
	};

	//item types
	$scope.item_types = ["Bonus", "Placement Fee", "Commission", "Reimbursement", "Gifts", "Office Fee", "Service Fee", "Training Room Fee", "Currency Adjustment", "Regular Rostered Hours", "Adjustment Credit Memo", "Adjustment Over Time Work", "Over Payment", "Final Invoice", "Others", "Referral Program"];

	//package selections
	$scope.package_selections = [];
	$scope.package_selections.push({
		value : "weekly_fulltime",
		label : "Full Time Weekly or 40 working hours",
		qty : 40,
		work_status : "Full-Time"
	});
	$scope.package_selections.push({
		value : "weekly_parttime",
		label : "Part Time Weekly or 20 working hours",
		qty : 20,
		work_status : "Part-Time"
	});
	$scope.package_selections.push({
		value : "fortnightly_fulltime",
		label : "Full Time Fortnightly or 80 working hours",
		qty : 80,
		work_status : "Full-Time"
	});
	$scope.package_selections.push({
		value : "fortnightly_parttime",
		label : "Part Time Fortnightly or 40 working hours",
		qty : 40,
		work_status : "Part-Time"
	});
	$scope.package_selections.push({
		value : "monthly_fulltime",
		label : "Full Time 22 working Days or 176 working hours",
		qty : 176,
		work_status : "Full-Time"
	});
	$scope.package_selections.push({
		value : "monthly_parttime",
		label : "Part Time 22 working Days or 88 working hours",
		qty : 88,
		work_status : "Part-Time"
	});
	$scope.package_selections.push({
		value : "trial1week_fulltime",
		label : "Full Time 1 week trial or 40 working hours",
		qty : 40,
		work_status : "Full-Time"
	});
	$scope.package_selections.push({
		value : "trial1week_parttime",
		label : "Part Time 1 week trial or 20 working hours",
		qty : 20,
		work_status : "Part-Time"
	});
	$scope.package_selections.push({
		value : "trial2week_fulltime",
		label : "Full Time 2 week trial or 80 working hours",
		qty : 80,
		work_status : "Full-Time"
	});
	$scope.package_selections.push({
		value : "trial2week_parttime",
		label : "Part Time 2 week trial or 40 working hours",
		qty : 40,
		work_status : "Part-Time"
	});

	//work status
	$scope.work_statuses = ["Full-Time", "Part-Time"];

	//invoice types
	$scope.invoice_types = [];
	$scope.invoice_types.push({
		value : "regular",
		label : "Regular Invoicing"
	});

	/**
	 * Event for Handling Adding Item from Staff List
	 */
	$scope.addItemFromStaffList = function() {
		if ($scope.invoice.client == null) {
			alert("Please select client!");
			return;
		}
		if ($scope.invoice.client.active_subcons.length == 0) {
			alert("The selected client has no active subcons!");
			return;
		}

		var modalInstance = $modal.open({
			templateUrl : 'views/common/new-invoice/add-item-from-staff-list.html',
			controller : AddItemFromStaffListModalController,
			size : "lg",
			resolve : {
				$invoker : function() {
					return $scope;
				}
			}
		});

	};

	/**
	 * Event for handling Adding Items from Timesheet
	 */
	$scope.addItemsFromTimesheet = function() {
		if ($scope.invoice.client == null) {
			alert("Please select client!");
			return;
		}
		if ($scope.invoice.client.active_subcons.length == 0) {
			alert("The selected client has no active subcons!");
			return;
		}
		var modalInstance = $modal.open({
			templateUrl : 'views/common/new-invoice/add-item-from-timesheet.html',
			controller : AddItemFromTimesheetModalController,
			size : "lg",
			resolve : {
				$invoker : function() {
					return $scope;
				}
			}
		});
	};

	$scope.addItemsCurrencyAdjustment = function(){
		if ($scope.invoice.client == null) {
			alert("Please select client!");
			return;
		}
		if ($scope.invoice.client.active_subcons.length == 0) {
			alert("The selected client has no active subcons!");
			return;
		}
		var modalInstance = $modal.open({
			templateUrl : 'views/common/new-invoice/add-item-currency-adjustment.html',
			controller : AddItemCurrencyAdjustmentModalController,
			size : "lg",
			resolve : {
				$invoker : function() {
					return $scope;
				}
			}
		});

		
	}

	//initialize Invoice Instance
	$scope.invoice = new Invoice();
	setTimeout(function() {
		if ($scope.invoice.due_date == null) {
			jQuery("#due_date").val("");
		}
	}, 5000);

	if ( typeof PARAMS.order_id != "undefined") {
		//load invoice details when updating invoice
		var order_id = PARAMS.order_id;
		$scope.invoice.tax_invoice_no = PARAMS.order_id;
		$http.get(NJS_API + "/invoice/get-invoice-details/?order_id=" + order_id).success(function(response) {
			if (response.result.status == "paid" || response.result.status == "cancelled") {
				window.location.href = "/portal/accounts_v2/#/invoice/details/" + PARAMS.order_id;
				return;
			}
			for (var i = 0; i < response.result.items.length; i++) {
				var item = $scope.invoice.getBlankItem(i + 1);
				var result_item = response.result.items[i];
				item.description = result_item.description;
				item.item_type = result_item.item_type;
				item.selected_date = {
					startDate : result_item.start_date,
					endDate : result_item.end_date
				};
				item.quantity = result_item.qty;
				item.subcontractors_id = result_item.subcontractors_id;
				item.unit_price = result_item.unit_price;
				item.commission_id = result_item.commission_id;
				$scope.invoice.addItem(item);
			}
			for (var i = 0; i < response.result.history.length; i++) {
				var result_history = response.result.history[i];
				var history = new History();
				history.timestamp = new Date(result_history.timestamp);
				history.timestamp_unix = moment(history.timestamp).unix();
				history.changes = result_history.changes;
				history.by = result_history.by;
				$scope.invoice.addHistory(history);
			}

			$scope.invoice.copyItems();
			$scope.invoice.due_date = new Date(response.result.pay_before_date);
			$scope.invoice.invoice_date = new Date(response.result.added_on);

			$scope.invoice.original_due_date = new Date(response.result.pay_before_date);
			$scope.invoice.original_invoice_date = new Date(response.result.added_on);
			$scope.initialInvoice = angular.copy($scope.invoice);

			PARAMS.client_id = parseInt(response.result.client_id);
			//console.log($scope.invoice.items);
			//collect all commissions for the selected client
			setTimeout(function() {

				$http.get(NJS_API + "/commission/get-commision-by-leads-id?leads_id=" + response.result.client_id).success(function(response) {
					$scope.commissions = response.result;
					setTimeout(function() {
						jQuery(".commissions").trigger("chosen:updated");
					}, 500);
				});

			}, 500);
			syncClients();

		});
	}

	$scope.invoice.selected_from_params = false;

	$scope.update_commission_item = function(item, commission){
		for(var i=0;i<$scope.commissions.length;i++){
			var commission = $scope.commissions[i];
			if (commission.commission_id == item.commission_id){
				item.unit_price = commission.commission_amount;
				item.description = commission.commission_title;
				item.item_type = "Commission";
				break;
			}
		}
	};
	/**
	 * Update forex rate from Server
	 */
	function updateForexRateFromServer() {
		$http({
			method : 'GET',
			url : NJS_API + "/currency-adjustments/get-all-active-forex-rate/"
		}).success(function(response) {
			console.log(response.result);
			window.localStorage.setItem("currency_rate", JSON.stringify(response.result));
		});
	}


	/**
	 * Sync all clients from DB
	 */
	function syncClients() {

		var clients = window.localStorage.getItem("clients");
		if ( typeof clients == "undefined" || clients == null || clients == "") {
			$http({
				method : 'POST',
				url : NJS_API + "/clients/get-all-clients/"
			}).success(function(response) {
				console.log(response);
				if (response.success) {
					$scope.clients = response.clients;
					for (var i = 0; i < response.clients.length; i++) {
						var client = response.clients[i];
						if ( typeof PARAMS.client_id != "undefined" && parseInt(PARAMS.client_id) == client.client_id) {
							$scope.invoice.client = client;
							$scope.invoice.selected_from_params = true;
							if ( typeof PARAMS.order_id == "undefined") {
								$scope.invoice.getTaxInvoiceNo();
							}
						}
						client.awaiting_invoices = [];
						window.localStorage.setItem("client_" + client.client_id, JSON.stringify(client));
						client.awaiting_invoices = [];
					}

					window.localStorage.setItem("clients", "");
					window.localStorage.setItem("clients", JSON.stringify(response.clients));
					setTimeout(function() {
						jQuery("#leads_id").trigger("chosen:updated");
					}, 500);

				}
			});
		} else {
			clients = jQuery.parseJSON(clients);
			$scope.clients = clients;

			for (var i = 0; i < $scope.clients.length; i++) {
				var client = $scope.clients[i];
				if ( typeof PARAMS.client_id != "undefined" && parseInt(PARAMS.client_id) == client.client_id) {
					$scope.invoice.client = client;
					$scope.invoice.selected_from_params = true;
					if ( typeof PARAMS.order_id == "undefined") {
						$scope.invoice.getTaxInvoiceNo();
					}
				}
			}
			setTimeout(function() {
				jQuery("#leads_id").trigger("chosen:updated");
			}, 500);

			$http({
				method : 'POST',
				url : NJS_API + "/clients/get-all-clients/"
			}).success(function(response) {
				console.log(response);
				if (response.success) {

					for (var i = 0; i < response.clients.length; i++) {
						var client = response.clients[i];

						window.localStorage.setItem("client_" + client.client_id, JSON.stringify(client));
						client.awaiting_invoices = [];
					}
					setTimeout(function() {
						jQuery("#leads_id").trigger("chosen:updated");
					}, 500);
					window.localStorage.setItem("clients", "");
					window.localStorage.setItem("clients", JSON.stringify(response.clients));
				}
			});
		}

	};
	if ( typeof PARAMS.order_id == "undefined") {
		syncClients();
	}
	updateForexRateFromServer();
}

/**
 * Modal for Adding Items from Staff List
 */
function AddItemFromStaffListModalController($scope, $modalInstance, $http, $invoker) {

	//initialize custom method for view rendering
	$scope.currency = $invoker.invoice.client.currency;
	$scope.subcontractors = $invoker.invoice.client.active_subcons;
	function getInvoiceItem() {
		return this.fname + " " + this.lname + " [" + this.job_designation + "]";
	}

	function toInvoiceItem(seq) {
		var item = $invoker.invoice.getBlankItem(seq);
		item.description = this.getInvoiceItem();
		item.item_type = "Regular Rostered Hours";
		item.selected_date = jQuery.extend(true, {}, $scope.selected_date_range);
		item.commission_id = null;
		item.quantity = Math.round(this.qty * 100) / 100;
		item.unit_price = Math.round(this.hourly_rate * 100) / 100;
		item.subcontractors_id = this.subcontractors_id;
		console.log(item);
		return item;
	}

	for (var i = 0; i < $scope.subcontractors.length; i++) {
		$scope.subcontractors[i].getInvoiceItem = getInvoiceItem;
		$scope.subcontractors[i].toInvoiceItem = toInvoiceItem;
	}

	$scope.package_selections = $invoker.package_selections;
	$scope.work_statuses = $invoker.work_statuses;

	$scope.selected_package = null;
	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	};
	$scope.add_items = function() {
		var subcontractors = $scope.getComputedSelectedStaff();
		var history = [];
		var currency_rates = jQuery.parseJSON(window.localStorage.getItem("currency_rate"));
		var currency_rate = {};
		for (var j = 0; j < currency_rates.length; j++) {
			if (currency_rates[j].currency == $invoker.invoice.client.currency) {
				currency_rate = currency_rates[j];
			}
		}
		console.log(currency_rate);
		for (var i = 0; i < subcontractors.length; i++) {
			var subcontractor = subcontractors[i];
			var invoice_item = subcontractor.toInvoiceItem(i);
			history.push(invoice_item.toHistory());
			$invoker.invoice.addItem(invoice_item);

			//add currency adjustment
			var currency_difference = Math.round((parseFloat(subcontractor.current_rate) - currency_rate.rate) * 10000) / 10000;
			var currency_adjustment_item = new InvoiceItem(0);
			currency_adjustment_item.description = "Currency Adjustment (Contract Rate 1 " + $invoker.invoice.client.currency + " = " + subcontractor.current_rate + " PESO VS Current Rate 1 " + $invoker.invoice.client.currency + " = " + currency_rate.rate + " PESO, Currency Difference of " + currency_difference + "  PESO for your staff " + subcontractor.fname + " " + subcontractor.lname + ")";
			currency_adjustment_item.item_type = "Currency Adjustment";
			currency_adjustment_item.unit_price = Number(Math.round(subcontractor.currency_adjustment * 10000) / 10000);
			currency_adjustment_item.quantity = invoice_item.quantity;
			currency_adjustment_item.subcontractors_id = invoice_item.subcontractors_id;
			currency_adjustment_item.selected_date = jQuery.extend(true, {}, invoice_item.selected_date);
			//$invoker.invoice.addItem(currency_adjustment_item);

		}

		var new_history = new History();
		new_history.timestamp = new Date();
		new_history.timestamp_unix = moment(new_history.timestamp).unix();
		new_history.changes = "Added items from staff list: <br/>" + history.join("<br/>");
		new_history.by = jQuery("#ADMIN_NAME").val() + " :" + jQuery("#ADMIN_ID").val();
		$invoker.invoice.addHistory(new_history);
		$modalInstance.dismiss('cancel');

	};
	$scope.select_all = function() {

		for (var i = 0; i < $scope.subcontractors.length; i++) {
			$scope.subcontractors[i].selected = true;
		}
	};
	$scope.select_all();

	$scope.deselect_all = function() {
		for (var i = 0; i < $scope.subcontractors.length; i++) {
			$scope.subcontractors[i].selected = false;
		}
	};

	$scope.getStaffFromSelectedPackage = function() {
		var subcontractors = $scope.subcontractors;
		var result = [];
		for (var i = 0; i < subcontractors.length; i++) {
			if ($scope.selected_package == null) {
				return subcontractors;
			} else {
				if (subcontractors[i].work_status == $scope.selected_package) {
					result.push(subcontractors[i]);
				}
			}

		}
		return result;

	};


	$scope.getComputedSelectedStaff = function() {
		function isDate(dateArg) {
			var t = (dateArg instanceof Date) ? dateArg : (new Date(dateArg));
			return !isNaN(t.valueOf());
		}
		
		function isValidRange(minDate, maxDate) {
			return (new Date(minDate) <= new Date(maxDate));
		}
		
		function betweenDate(startDt, endDt) {
			var error = ((isDate(endDt)) && (isDate(startDt)) && isValidRange(startDt, endDt)) ? false : true;
			var between = [];
			if (error) console.log('error occured!!!... Please Enter Valid Dates');
			else {
				var currentDate = new Date(startDt),
					end = new Date(endDt);
				while (currentDate <= end) {
					between.push(new Date(currentDate));
					currentDate.setDate(currentDate.getDate() + 1);
				}
			}
			return between;
		}
		var qty;
		if ($scope.selected_package == null || $scope.selected_date_range == null) {
			qty = 0;
		} else {
			var start = $scope.selected_date_range.startDate.toDate();
			var end = $scope.selected_date_range.endDate.toDate();
			var between_dates = betweenDate(start, end);
			var business_days = 0;
			for(var j=0;j<between_dates.length;j++){
				var between_date = between_dates[j];
				var day_of_week = moment(between_date).weekday();
				if (day_of_week==0||day_of_week==6){
					continue;
				}
				business_days++;
			}
			if ($scope.selected_package=="Full-Time"){
				qty = business_days * 8;
			}else{
				qty = business_days * 4;
			}
		}

		var result = [];
		var package_staff = $scope.getStaffFromSelectedPackage();
		for (var i = 0; i < package_staff.length; i++) {
			var subcontractor = package_staff[i];
			if (subcontractor.selected) {
				var total = subcontractor.hourly_rate * qty;
				subcontractor.total = total;
				subcontractor.qty = qty;
				result.push(subcontractor);
			}
		}
		return result;
	};

}


/**
 * Modal for Adding Items from Timesheet
 */
function AddItemFromTimesheetModalController($scope, $modalInstance, $http, $invoker) {
	var NJS_API = jQuery("#NJS_API_URL").val();
	var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	$scope.currency = $invoker.invoice.client.currency;
	var today = new Date();

	var months = [];
	for (var i = 6; i <= monthNames.length; i++) {
		var value = "";
		if (i < 9) {
			value = (today.getFullYear()-1) + "-0" + i + "-01";
		} else {
			value = (today.getFullYear()-1) + "-" + i + "-01";
		}

		months.push({
			value : value,
			label : monthNames[i - 1] + " " + (today.getFullYear()-1)
		});
	}
	
	for (var i = 1; i <= monthNames.length; i++) {
		var value = "";
		if (i < 9) {
			value = today.getFullYear() + "-0" + i + "-01";
		} else {
			value = today.getFullYear() + "-" + i + "-01";
		}

		months.push({
			value : value,
			label : monthNames[i - 1] + " " + today.getFullYear()
		});
	}

	$scope.months = months;
	//console.log($scope.months);

	$scope.loadTimesheetItems = function() {

		$http.get(NJS_API + "/timesheet/invoice-items?client_id=" + $invoker.invoice.client.client_id + "&month_year=" + $scope.selected_timesheet_date.value).success(function(response) {
			//convert to InvoiceItem object
			var invoice_items = [];
			for (var i = 0; i < response.result.length; i++) {
				var result_item = response.result[i];
				var invoice_item = new InvoiceItem(0);
				invoice_item.description = result_item.description;
				invoice_item.item_type = result_item.item_type;
				invoice_item.quantity = result_item.qty;
				invoice_item.unit_price = result_item.staff_hourly_rate;
				invoice_item.selected_date = {
					startDate : new Date(result_item.start_date),
					endDate : new Date(result_item.end_date)
				};
				invoice_item.selected = true;
				invoice_item.subcontractors_id = result_item.subcontractors_id;
				invoice_item.current_rate = result_item.current_rate;
				invoice_item.staff_name = result_item.staff_name;
				invoice_items.push(invoice_item);
			}
			$scope.items = invoice_items;
			$scope.select_all();
		});

	};

	$scope.select_all = function() {

		for (var i = 0; i < $scope.items.length; i++) {
			$scope.items[i].selected = true;
		}

	};

	$scope.deselect_all = function() {
		for (var i = 0; i < $scope.items.length; i++) {
			$scope.items[i].selected = false;
		}

	};

	$scope.getSelectedTimesheetItems = function() {
		var selected = [];
		for (var i = 0; i < $scope.items.length; i++) {
			if ($scope.items[i].selected) {
				selected.push($scope.items[i]);
			}
		}
		return selected;
	};

	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	};
	$scope.add_items = function() {
		var timesheet_items = $scope.getSelectedTimesheetItems();
		var history = [];
		var currency_rates = jQuery.parseJSON(window.localStorage.getItem("currency_rate"));
		var currency_rate = {};
		for (var j = 0; j < currency_rates.length; j++) {
			if (currency_rates[j].currency == $invoker.invoice.client.currency) {
				currency_rate = currency_rates[j];
			}

		}


		for (var i = 0; i < timesheet_items.length; i++) {
			var found = false;
			var currency_adjustment = 0;
			var timesheet_item = timesheet_items[i];

			/**
			 * Removed by Josef Balisalisa to resolve bug report:
			 * https://remotestaff.atlassian.net/browse/ER-56
			 * Please refer to pull request
			 */
			// for (var j = 0; j < $invoker.invoice.client.active_subcons.length; j++) {
			// 	var subcon_detail = $invoker.invoice.client.active_subcons[j];
            //
			// 	if (subcon_detail.subcontractors_id == timesheet_item.subcontractors_id) {
			// 		found = true;
			// 		currency_adjustment = Math.round(Number(subcon_detail.currency_adjustment) * 10000) / 10000;
			// 		break;
			// 	}
			// }
			// if (!found) {
			// 	continue;
			// }
			history.push(timesheet_item.toHistory());
			$invoker.invoice.addItem(timesheet_item);
			/**
			 * Removed by Josef Balisalisa to resolve bug report:
			 * https://remotestaff.atlassian.net/browse/ER-56
			 *
			 * Please refer to pull request
			 */
			// if (timesheet_item.item_type == "Regular Rostered Hours") {
			// 	var currency_difference = Math.round((parseFloat(timesheet_item.current_rate) - currency_rate.rate) * 10000) / 10000;
			// 	var currency_adjustment_item = new InvoiceItem(0);
			// 	currency_adjustment_item.description = "Currency Adjustment (Contract Rate 1 " + $invoker.invoice.client.currency + " = " + timesheet_item.current_rate + " PESO VS Current Rate 1 " + $invoker.invoice.client.currency + " = " + currency_rate.rate + " PESO, Currency Difference of " + currency_difference + "  PESO for your staff " + timesheet_item.staff_name + ")";
			// 	currency_adjustment_item.item_type = "Currency Adjustment";
			// 	currency_adjustment_item.unit_price = Number(currency_adjustment);
			// 	currency_adjustment_item.quantity = timesheet_item.quantity;
			// 	currency_adjustment_item.subcontractors_id = timesheet_item.subcontractors_id;
			// 	currency_adjustment_item.selected_date = jQuery.extend(true, {}, timesheet_item.selected_date);
			// 	//$invoker.invoice.addItem(currency_adjustment_item);
			// }

		}

		var new_history = new History();
		new_history.timestamp = new Date();
		new_history.timestamp_unix = moment(new_history.timestamp).unix();
		new_history.changes = "Added items from timesheet: <br/>" + history.join("<br/>");
		new_history.by = jQuery("#ADMIN_NAME").val() + " :" + jQuery("#ADMIN_ID").val();
		$invoker.invoice.addHistory(new_history);

		$modalInstance.dismiss('cancel');
	};
}

/**
 * Modal for Adding Items from Timesheet
 */
function AddItemCurrencyAdjustmentModalController($scope, $modalInstance, $http, $invoker) {
	var NJS_API = jQuery("#NJS_API_URL").val();
	var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	$scope.currency = $invoker.invoice.client.currency;
	var today = new Date();

	var months = [];
	for (var i = 6; i <= monthNames.length; i++) {
		var value = "";
		if (i < 9) {
			value = (today.getFullYear()-1) + "-0" + i + "-01";
		} else {
			value = (today.getFullYear()-1) + "-" + i + "-01";
		}

		months.push({
			value : value,
			label : monthNames[i - 1] + " " + (today.getFullYear()-1)
		});
	}
	
	for (var i = 1; i <= monthNames.length; i++) {
		var value = "";
		if (i < 9) {
			value = today.getFullYear() + "-0" + i + "-01";
		} else {
			value = today.getFullYear() + "-" + i + "-01";
		}

		months.push({
			value : value,
			label : monthNames[i - 1] + " " + today.getFullYear()
		});
	}

	$scope.months = months;

	$scope.select_all = function() {

		for (var i = 0; i < $scope.items.length; i++) {
			$scope.items[i].selected = true;
		}

	};

	$scope.deselect_all = function() {
		for (var i = 0; i < $scope.items.length; i++) {
			$scope.items[i].selected = false;
		}

	};

	$scope.loadCurrencyAdjustmentItems = function(){
		$http.get(NJS_API + "/timesheet/currency-adjustments?client_id=" + $invoker.invoice.client.client_id + "&month_year=" + $scope.selected_timesheet_date.value).success(function(response) {
			//convert to InvoiceItem object

			if (response.success){

				var invoice_items = [];
				for (var i = 0; i < response.result.length; i++) {
					var result_item = response.result[i];
					var invoice_item = new InvoiceItem(0);
					invoice_item.description = result_item.description;
					invoice_item.item_type = result_item.item_type;
					invoice_item.quantity = result_item.qty;
					invoice_item.unit_price = parseFloat(result_item.currency_adjustment.toFixed(4));
					invoice_item.selected_date = {
						startDate : new Date(result_item.start_date),
						endDate : new Date(result_item.end_date)
					};
					invoice_item.selected = true;
					invoice_item.subcontractors_id = result_item.subcontractors_id;
					invoice_item.current_rate = result_item.current_rate;
					invoice_item.staff_name = result_item.staff_name;
					invoice_items.push(invoice_item);
				}
				$scope.items = invoice_items;
				$scope.select_all();
			}else{
				alert("The following failed to load because of the following: \n"+response.errors);
			}

		});
	};

	$scope.getSelectedTimesheetItems = function() {
		var selected = [];
		for (var i = 0; i < $scope.items.length; i++) {
			if ($scope.items[i].selected) {
				selected.push($scope.items[i]);
			}
		}
		return selected;
	};

	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	};
	$scope.add_items = function() {
		var timesheet_items = $scope.getSelectedTimesheetItems();
		var history = [];
		


		for (var i = 0; i < timesheet_items.length; i++) {
			var timesheet_item = timesheet_items[i];
			history.push(timesheet_item.toHistory());
			$invoker.invoice.addItem(timesheet_item);
		}

		var new_history = new History();
		new_history.timestamp = new Date();
		new_history.timestamp_unix = moment(new_history.timestamp).unix();
		new_history.changes = "Added items from timesheet: <br/>" + history.join("<br/>");
		new_history.by = jQuery("#ADMIN_NAME").val() + " :" + jQuery("#ADMIN_ID").val();
		$invoker.invoice.addHistory(new_history);

		$modalInstance.dismiss('cancel');
	};
}

rs_module.controller('AddItemFromStaffListModalController', ["$scope", "$modalInstance", "$http", "$invoker", AddItemFromStaffListModalController]);
rs_module.controller('AddItemFromTimesheetModalController', ["$scope", "$modalInstance", "$http", "$invoker", AddItemFromTimesheetModalController]);
rs_module.controller('AddItemCurrencyAdjustmentModalController', ["$scope", "$modalInstance", "$http", "$invoker", AddItemCurrencyAdjustmentModalController]);

rs_module.controller('NewInvoiceController', ["$scope", "$location", "$http", "$modal", NewInvoiceController]);
