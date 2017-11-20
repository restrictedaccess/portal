/**

 *
 * @version 1 - Initial Commit
 */
var API_URL = jQuery("#NJS_API_URL").val();
var BASE_URL = jQuery("#BASE_API_URL").val();
var param_status = "";
function ClientQuoteController($scope, $stateParams, $http, $modal, toaster){

	// console.log($stateParams);

	$scope.leads_id = ($stateParams.leads_id ? $stateParams.leads_id : null);
	$scope.quoteStatus = ($stateParams.status ? $stateParams.status : "");
	param_status = $scope.quoteStatus;
	$scope.temp = "";
	//$scope.profile = null;
	$scope.setting = null;
	$scope.quotes = null;
	$scope.id="";
	$scope.Details = null;
	if(!$stateParams.leads_id){
		alert("Leads Id is missing");
	}

	$scope.generateQuote = function(){

		generate_quote($scope, $stateParams,$http, toaster);

	};

	$scope.getQuoteDetails = function(quote_id){

		$scope.quote_id = quote_id;
		if($scope.id != quote_id)
		{
			$scope.Details=null;
			$scope.id = quote_id;
		}
		getQuoteDetailsClient($scope, $stateParams, $http, $modal, toaster);
	}



	$scope.initForm = function(){

		if($stateParams.leads_id){
			get_leads_quote($scope,$http)
		}
		else
		{
			console.log("no leads id");
		}

	};

	$scope.formatDate = function(unixtime) {
		var d = new Date(unixtime);
		var n =  d.toDateString();
		return n;
	};



	$scope.initForm();


	$scope.$on("synced", function(event) {

		$scope.getLatestSolr($scope);
		if(param_status !== "draft")
		{
			window.location.href = "/portal/sc_v2/#/quote/client/"+$scope.leads_id+"/draft";
		}
		else
		{
			get_leads_quote($scope,$http)
		}

	});


}

function get_leads_quote($scope,$http){

	$scope.filteredResults=[],
		$scope.results=[],
		$scope.currentPage = 1,
		$scope.numberPage = 10,
		$scope.maxSize = 5;
	//Get Leads generated quotes
	$scope.quotes = null;

	var uri = API_URL+"/quote/get-all-leads?leads_id="+$scope.leads_id;
	$http({
		method: "GET",
		url:uri
	}).success(function (response) {
		if(response.success){
			$scope.quotes = response.data[0];
			console.log($scope.quotes);
			console.log(param_status);
			var quote_data = $scope.quotes.quote_data;
			var perStatus = [];
			if(quote_data.length > 0)
			{
				angular.forEach(quote_data,function(value,key){

					if(param_status == value.status)
					{
						var q_details = value.quote_details;

						if(q_details.length > 0)
						{
							var desc = "";

							if(q_details.length == 1) {
								details = q_details[0];

								if (details.detail_status == "displayed")
								{
									if(details.work_description == "" || !details.work_description)
									{
										desc = details.work_status+" "+details.working_hours+"hr(s)"+details.work_status_description;
									}
									else
									{
										desc = details.work_description;
									}

									var fname =(details.user_fname ? details.user_fname : "");
									var lname = (details.user_lname ? details.user_lname : "");
									var work_position = (details.work_position ? details.work_position : "");

									value.Details = "<table style='table-layout:fixed;width:300px;text-align:left;'><tr><td style='text-align:center'>Staff Name:</td><td>"+fname+"&nbsp;"+lname+"</td></tr>"
										+"<tr><td style='text-align:center'>Job Title:</td><td>"+work_position+"</td></tr>"
										+"<tr><td style='text-align:center'>Work Schedule:</td><td>"+desc+"</td></tr></table>";
								}
								else
								{
									value.Details = "Click to add quote details.";
								}


							}
							else if(q_details.length > 1)
							{
								value.Details = "Quote has more than one details,click to view all..";
							}
						}
						else
						{
							value.Details = "Click to add quote details.";
						}

						perStatus.push(value);
					}
				});

				$scope.quotes.quote_data = perStatus;
			}
			else {
				$scope.Details = "Click to add quote details.";
			}

			console.log($scope.quotes);

		}

	}).error(function(response, status) {
		console.log("Error...");
		console.log(response);
	});


}
function generate_quote($scope,$stateParams, $http, toaster){


	var API_URL = jQuery("#NJS_API_URL").val();
	if(confirm("This will generate a draft Quote.")){
		$scope.loading5 = true;
		var data = {
			created_by : jQuery("#ADMIN_ID").val(),
			created_by_type:"admin",
			leads_id : $scope.leads_id
		};

		$http({
			method: 'POST',
			url:API_URL+"/quote/generate-quote",
			data: data
		}).success(function(response) {
			// console.log(response);

			//console.log(response);
			$scope.loading5 = false;
//
			if(response.success){

				toaster.pop({
					type: 'success',
					title: 'Quote',
					body: response.msg,
					showCloseButton: true,
				});

				$scope.quote_id = response.quote_id;
				$scope.getLatest($scope);

			}else{
				toaster.pop({
					type: 'error',
					title: 'Quote',
					body: response.error,
					showCloseButton: true,
				});
			}

		}).error(function(response){
			$scope.loading5 = false;
			alert("There's a problem in generating new quote. Please try again later.");
		});
	}
	//$scope.loading5 = true;
}

function getQuoteDetailsClient($scope, $stateParams, $http, $modal, toaster)
{

}


function getDecimalFunc(value)
{
	if(value != null)
	{

		value = parseFloat(value);
		if((value) % 1 == 0)
		{
			value = addComma(value);
			value+=".00";
		}
		else
		{
			value = parseFloat(value).toFixed(2);
			value=addComma(value);
			var dec = value.toString().split(".")[1];

			if(dec)
			{
				if(dec.length <= 1)
				{
					value+="0";
				}
			}
			else
			{
				value+=".00";
			}

		}
	}
	else
	{
		value = "0.00";
	}

	return value;
}



rs_module.controller('ClientQuoteController',["$scope", "$stateParams","$http", "$modal", "toaster", ClientQuoteController]);
