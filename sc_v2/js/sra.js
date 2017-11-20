/**
 * Controller for Script Report Audit
 *
 * @version 1 - Initial Commit
 */

function ScriptReportAuditController($scope, $http, $modal, toaster) {

	var API_URL = jQuery("#BASE_API_URL").val();
	$scope.records = [];
	var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var years = [2016];

	var month_years = [];
	angular.forEach(years, function(year, key_year) {
		angular.forEach(months, function(month, key_month) {

			var month_year = {
				month : month,
				year : year,
				label : month + " " + year,
				key_month : key_month + 1,
			};

			month_years.push(month_year);
		});
	});

	$scope.month_years = month_years;

	//load all Clients
	var data = {};
	data.admin_id = jQuery("#ADMIN_ID").val();

	$http.post(API_URL + "/timesheet-weeks/load-defaults", data).success(function(response) {
		$scope.clients = response.defaults.clients;
		setTimeout(function() {
			jQuery("#leads_id").trigger("chosen:updated");
		}, 500);

	});

	$scope.loadClientCurrencyAdjustment = function() {

	};
	
	$scope.loadingSearch = false;
	$scope.loadingApplyCurrency = false;
	$scope.applyCurrencyAdjustment = function() {

		if ( typeof $scope.sra_view.client == "undefined") {
			alert("Select Client");
			return false;
		}
		if ( typeof $scope.sra_view.selected_month_year == "undefined") {
			alert("Select Month and Year");
			return false;
		}

		var data = {
			leads_id : $scope.sra_view.client.leads_id,
			month : $scope.sra_view.selected_month_year.key_month,
			year : $scope.sra_view.selected_month_year.year,

		};
		data.admin_id = jQuery("#ADMIN_ID").val();

		$scope.loadingApplyCurrency = true;
		$http({
			method : 'POST',
			url : API_URL + "/currency-adjustment/apply-currency-adjustment/",
			data : data
		}).success(function(response) {
		
			$scope.loadingApplyCurrency = false;
			if (!response.success){
				var error_msg = "";
				angular.forEach(response.errors, function(error, key){
					error_msg+=error+"\n";
				});
				alert(error_msg);
			}
		});

	};
	$scope.filterCurrencyAdjustments = function() {
		
		if ( typeof $scope.sra_view.client == "undefined") {
			return false;
		}
		if ( typeof $scope.sra_view.selected_month_year == "undefined") {
			return false;
		}

		var data = {
			leads_id : $scope.sra_view.client.leads_id,
			month : $scope.sra_view.selected_month_year.key_month,
			year : $scope.sra_view.selected_month_year.year,

		};
		$scope.loadingSearch = true;
		
		$http.get(API_URL + "/currency-adjustment/get-currency-adjustments/?leads_id="+data.leads_id+"&month="+data.month+"&year="+data.year).success(function(response) {
			$scope.records = response.result;
			$scope.loadingSearch = false;
		});
		
		connectToWebsocket(data.leads_id + "-" + data.month + "-" + data.year + "-" + jQuery("#ADMIN_ID").val());
		console.log(data);
		


	};

	function connectToWebsocket(hash) {
		var WS_URL = jQuery("#WS_URL").val();
		var conn = new ab.Session(WS_URL + '/ws-currency-adjustment', function() {

			conn.subscribe(hash, function(topic, data) {
				var records = [];
				angular.forEach($scope.records, function(item,key){
					records.push(item);
				});
				records.push(data.message);
				$scope.records = records;				
				//$scope.filterCurrencyAdjustments();
				$scope.$apply();
			});
			
			
			
		}, function() {
			console.log("Reconnecting to Websocket...");
			connectToWebsocket(hash);
		}, {
			'skipSubprotocolCheck' : true
		});

	}

}

rs_module.controller('ScriptReportAuditController', ["$scope", "$http", "$modal", "toaster", ScriptReportAuditController]); 