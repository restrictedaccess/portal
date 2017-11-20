
var API_URL = jQuery("#NJS_API_URL").val();
var BASE_URL = jQuery("#BASE_URL").val();
function FilesQuoteController($scope, $stateParams, $http, $modal, toaster){

  var ran = $stateParams.ran;
  $scope.isID = null;
  $scope.isAccepted = false;

  $scope.pdfPath = BASE_URL+"/portal/service-agreements/Service_Agreement.pdf";



    $scope.checkParams = function()
    {

        var objectData = {};

        objectData.sa_id = ran;

        $http({
            method: 'POST',
            url:API_URL+"/quote/get-sa-ran",
            data: objectData
        }).success(function(response) {

            if(response.success)
            {
                if(response.data)
                {
                    $scope.isID = response.data.ran;

                    window.location.href = "/portal/sc_v2/pro-forma.php#/files/quote/"+$scope.isID;

                }
            }
        }).error(function(response){

            $scope.loading10 = false;
        });

    }

    if(!isNaN(ran))
    {

        $scope.checkParams();
    }

  if(!ran)
  {
    alert("Error, please input service agreement ran");
    return false;
  }else {

$scope.getQuoteID = function(){

  $http.get(API_URL+"/quote/get-quoteid?ran="+ran).success(function(response){

        // console.log(response);

        if(response.success)
        {

             if(response.data)
             {
                 $scope.quote_id = response.data.quote_id;
                 getQuoteDetailsFiles($scope, $stateParams, $http, $modal, toaster);
             }

        }
        else {
            alert("Cannot get Details");
        }


  });
}


    $scope.getRsContact = function()
    {

      var item=[];

      $http.get(API_URL+"/quote/get-rs-contact").success(function(response){


            if(response.success)
            {
              var site="";
              angular.forEach(response.data,function(value,key){

                  if(value.type == "company number")
                  {
                    if(value.site != "uk")
                    {
                      if(value.site == "php")
                      {
                        site = "PHL";
                      }
                      else {
                        site = value.site;
                      }

                      item.push({
                        site:site,
                        contact_no:value.contact_no
                      });

                    }
                  }

              });


              $scope.rsContacts = item;
              // console.log($scope.rsContacts);
            }
            else {
                alert("Cannot get Contact Details");
            }


      });
    }


    $scope.acceptQuote = function()
    {
        var BASE_URL = jQuery("#BASE_URL").val();

        $scope.loading10 = true;
        $scope.formData = {};

        $scope.formData.sa_id = $scope.sa_id;
        $scope.formData.fname = $scope.sa_fname;
        $scope.formData.client_fname = $scope.quote.client.fname;
        $scope.formData.client_lname = $scope.quote.client.lname;
        $scope.formData.client_id = $scope.quote.client.id;
        $scope.formData.email = $scope.quote.quoted_by.admin_email;
        $scope.formData.created_by = $scope.quote.quoted_by.id;
        $scope.formData.quote_id = $scope.quote.id;
        $scope.formData.date_accepted = $scope.formatDate(new Date());
        $scope.formData.pdf_file = $scope.pdfPath;
        $scope.formData.sc_email = $scope.sc_email;

        //sc fname and lname
        $scope.formData.sc_fname = $scope.sc_fname;
        $scope.formData.sc_lname = $scope.sc_lname;

        $scope.formData.client_email = $scope.quote.client.email;
        $scope.formData.link = BASE_URL+"/portal/sc_v2/pro-forma.php#/files/quote/"+$scope.sa_ran;

        // console.log($scope.formData);exit();
        $http({
            method: 'POST',
            url:API_URL+"/quote/accept-sa",
            data: $scope.formData
        }).success(function(response) {
            // console.log(response);

            if(response.success){
                $scope.syncById();
                $scope.loading10 = false;
                $scope.isAccepted = true;
                $scope.date_accepted = new Date();

                $http({
                    method: 'POST',
                    url:API_URL+"/send/sa-client",
                    data: $scope.formData
                }).success(function(response) {
                    $http({
                        method: 'POST',
                        url:API_URL+"/send/sa-sc",
                        data: $scope.formData
                    }).success(function(response) {});
                });

            }else{

                $scope.loading10 = false;
            }


        }).error(function(response){

                $scope.loading10 = false;
        });
    }

    $scope.syncById = function()
    {
      var BASE_URL = jQuery("#BASE_API_URL").val();
          $http({
              method: 'GET',
              url:BASE_URL+"/mongo-index/sync-quote?quote_id="+$scope.quote_id
          }).success(function(response) {
              // console.log(response);

              if(response.success){

                  console.log('synced');
                  // localStorage.removeItem('All_leads_data');
                  // $http.get(API_URL+"/quote/get-all-leads").success(function(response){
                  // }).success(function(data){
                  //     console.log('naipasok');
                  //     localStorage.setItem('All_leads_data', JSON.stringify(data.data));
                  // });


                  // $scope.getRsContact();
                  // $scope.getQuoteID();
                  // $scope.getCurrencySettings();
                  // $scope.getCurrentCurr();

              }else{
                  console.log('!synced');
              }


          }).error(function(response){
              console.log('!synced')
          });

    }



      $scope.iterateItems = function(val){

          return val  = val +1;
      };


    $scope.getRsContact();
    $scope.getQuoteID();



  }
}

function getQuoteDetailsFiles($scope, $stateParams, $http, $modal, toaster)
{
  $scope.quote = null;
  $scope.totalAmount = 0;
  $scope.gstvalue = 0;
  $scope.totalAmountValue=0;
  if($scope.quote_id){

    //Leads Currency Setting
    $http.get(API_URL+"/quote/show/?id="+$scope.quote_id).success(function(response){
      $scope.quote = response.data;
      $scope.client = $scope.quote.client;
      $scope.hiring_coordinator = $scope.client.hiring_coordinator;
      $scope.sc_email = $scope.client.hiring_coordinator.admin_email;
      $scope.sc_fname =  $scope.client.hiring_coordinator.admin_fname;
      $scope.sc_lname =  $scope.client.hiring_coordinator.admin_lname;
      $scope.sa = response.data.service_agreements;
      $scope.accepted =  ($scope.sa[0].accepted ? $scope.sa[0].accepted : null);

    if ($scope.sa.length > 0)
    {
        $scope.sa_id = ($scope.sa[0].id ? $scope.sa[0].id : null);
        $scope.sa_fname = $scope.sa[0].created_by.admin_fname;
        $scope.sa_ran = $scope.sa[0].ran;
    }

      if($scope.accepted)
      {
          if($scope.accepted == "yes")
          {
              $scope.isAccepted = true;
              $scope.date_accepted = ($scope.sa[0].date_accepted ? $scope.sa[0].date_accepted : null);
          }
      }

      $scope.sa_id = ($scope.sa[0].id ? $scope.sa[0].id : null);
      $scope.totalSA = response.data.totalSA;
      // console.log($scope.quote);

      $scope.lastIndex = ($scope.quote.quote_details.length - 1 );

      for(var i = 0 ; i< $scope.quote.quote_details.length ; i++)
      {

        $scope.quote.quote_details[i].total_price = $scope.quote.quote_details[i].total_price.replace(/,/g, '');

        if(!$scope.quote.quote_details[i].total_price)
        {
          $scope.quote.quote_details[i].total_price = 0.00;
        }
        if(!$scope.quote.quote_details[i].service_fee)
        {
          $scope.quote.quote_details[i].service_fee = 0.00;
        }
        if(!$scope.quote.quote_details[i].office_fee)
        {
          $scope.quote.quote_details[i].office_fee = 0.00;
        }
        if(!$scope.quote.quote_details[i].currency_adjustment)
        {
          $scope.quote.quote_details[i].currency_adjustment = 0.00;
        }
        if(!$scope.quote.quote_details[i].others)
        {
          $scope.quote.quote_details[i].others = 0.00;
        }

        $scope.quote.quote_details[i].index = i;

        $scope.totalAmount += (parseFloat($scope.quote.quote_details[i].quoted_price)+parseFloat($scope.quote.quote_details[i].service_fee)+
                  parseFloat($scope.quote.quote_details[i].office_fee)+parseFloat($scope.quote.quote_details[i].currency_adjustment)+
                  parseFloat($scope.quote.quote_details[i].others));


        if($scope.quote.quote_details[i].work_status == "Full-Time")
        {
          $scope.quote.quote_details[i].client_hr = (((parseFloat($scope.quote.quote_details[i].quoted_price)*12)/52)/5)/8;

        }
        else{
          $scope.quote.quote_details[i].client_hr = (((parseFloat($scope.quote.quote_details[i].quoted_price)*12)/52)/5)/4;
        }

        $scope.currency = $scope.quote.quote_details[i].currency;

      }

     /* angular.forEach($scope.currentCurr,function(value,key){

    				if(value.currency == $scope.currency)
    				{
    						if(value.currency_rate_in == 'PHP')
    						{
    							$scope.currentRate = value.rate;
    							return;
    						}
    				}

    	});

    	angular.forEach($scope.currencySettings,function(value,key){

    				if(value.currency == $scope.currency)
    				{

    						$scope.forexRate = value.rate;
                $scope.effective_date = value.effective_date;
    						return;
    				}


    	});*/

      // console.log($scope.quote.quote_details);
      // console.log("Amount "+ $scope.totalAmount);
      $scope.gstvalue = parseFloat($scope.totalAmount)*.10;
      $scope.totalAmountValue = parseFloat($scope.totalAmount)+parseFloat($scope.gstvalue);
      $scope.getLeadsCurrencySetting(response.data.client.id);

      if($scope.quote)
      {
        $scope.getClientSettings();
      }

    });
}


$scope.getClientSettings = function()
{
    $http.get(API_URL+"/clients/get-client-settings/?id="+$scope.quote.client.id).success(function(response){

    if(response.success)
    {
      $scope.client_setting = response.result;

      if( response.result.currency )
      {
        if(response.result.apply_gst == 'Y')
        {
          $scope.apply_gst = "Yes";
        }
        else
        {
          $scope.apply_gst = "No";
        }

        $scope.currency = response.result.currency;
        getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
        getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
      }
    }
    else
    {

      if($scope.quote.quote_details.length > 0)
      {
        $scope.client_setting=$scope.quote.quote_details;
        angular.forEach($scope.quote.quote_details,function(value,key){

              if(value.currency && value.gst_apply)
              {
                $scope.currency = value.currency;
                $scope.apply_gst = value.gst_apply
                $scope.client_setting.currency = value.currency;
                $scope.client_setting.apply_gst = value.gst_apply;
                getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
                getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
                return;
              }else {
                $scope.client_setting.currency = 'AUD';
                $scope.client_setting.apply_gst = 'No';
                $scope.apply_gst = "No";
                $scope.currency = "AUD";
                getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
                getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
              }
        });


      }
      else {
          $scope.client_setting = null;
          getCurrencySetting($scope, $stateParams, $http, $modal, toaster);
          getCurrentCurrency($scope, $stateParams, $http, $modal, toaster);
        //console.log($scope.currency +"- "+ $scope.apply_gst );
      }
    }

  });
};

  $scope.getLeadsCurrencySetting = function(leads_id){
  var API_URL = jQuery("#BASE_API_URL").val();

  $http.get(API_URL+"/leads/get-client-currency-settings-by-id?id="+leads_id).success(function(response){

      $scope.leads_currency_setting = response.client_currency_setting;
      // console.log($scope.leads_currency_setting);
      if($scope.leads_currency_setting.currency_gst_apply || $scope.leads_currency_setting.currency_gst_apply != "")
      {
        if($scope.leads_currency_setting.currency_gst_apply == "Y" || $scope.leads_currency_setting.currency_gst_apply == "y")
        {
          $scope.leads_currency_setting.currency_gst_apply = "Yes";
        }
        else
        {
          $scope.leads_currency_setting.currency_gst_apply = "No";
        }


          if($scope.leads_currency_setting.currency_code == 'AUD')
          {
              $scope.leads_currency_setting.currency_sign = '$';
          }
          else if($scope.leads_currency_setting.currency_code == 'GBP')
          {
              $scope.leads_currency_setting.currency_sign = '£';
          }
          else
          {
              $scope.leads_currency_setting.currency_sign = '$';
          }


      }
      else {


        if($scope.quote.quote_details.length > 0)
        {
          $scope.leads_currency_setting=$scope.quote.quote_details;
            // console.log($scope.leads_currency_setting);
          angular.forEach($scope.quote.quote_details,function(value,key){

                if(value.currency)
                {


                  $scope.leads_currency_setting.currency_gst_apply = value.gst_apply;
                  $scope.leads_currency_setting.currency_code = value.currency;

                  if(value.currency == 'AUD')
                  {
                    $scope.leads_currency_setting.currency_sign = '$';
                  }
                  else if(value.currency == 'GBP')
                  {
                    $scope.leads_currency_setting.currency_sign = '£';
                  }
                  else
                  {
                    $scope.leads_currency_setting.currency_sign = '$';
                  }

                  return;
                }
          });
        }
        else {
            $scope.leads_currency_setting = null;
            // console.log($scope.leads_currency_setting);
        }

      }


        //
        // }
        // else {


      // console.log($scope.leads_currency_setting);

      //$scope.getTotalServiceAgreement();

  });

};







$scope.getDecimal = function(value)
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
  };


  $scope.formatDate = function(unixtime) {
       var d = new Date(unixtime);
       var n =  d.toDateString();
       return n;
  };



}
function getCurrencySetting($scope, $stateParams, $http, $modal, toaster)
{
    var API_URL = jQuery("#BASE_API_URL").val();
    $http({
        method: 'GET',
        url:API_URL+"/currency-adjustment/current-currency-rates"
    }).success(function(response) {
        // console.log(response);
        if(response.success){

            $scope.currencySettings = response.results;

            angular.forEach($scope.currencySettings,function(value,key){

                if($scope.client_setting)
                {
                    if(value.currency == $scope.currency)
                    {

                        $scope.forexRate = value.rate;
                        $scope.effective_date = value.effective_date;

                        // console.log(value);

                        return;
                    }
                }
                else
                {
                    if(value.currency == "AUD")
                    {

                        $scope.forexRate = value.rate;
                        $scope.effective_date = value.effective_date;
                        // console.log(value);
                        return;
                    }
                }




            });

        }
    }).error(function(response){
        alert("error on getting staff price");
    });
}

function getCurrentCurrency($scope, $stateParams, $http, $modal, toaster)
{
    var NJS_URL = jQuery("#NJS_API_URL").val();
    $http({
        method: 'GET',
        url:NJS_URL+"/quote/get-current-currency"
    }).success(function(response) {
        // console.log(response);
        if(response.success)
        {
            $scope.currentCurr = response.data;

            angular.forEach($scope.currentCurr,function(value,key){

                if($scope.client_setting) {

                    if (value.currency == $scope.currency) {
                        if (value.currency_rate_in == 'PHP') {
                            $scope.currentRate = value.rate;
                            return;
                        }
                    }
                }
                else
                {
                    if (value.currency == "AUD") {
                        if (value.currency_rate_in == 'PHP') {
                            $scope.currentRate = value.rate;
                            $scope.currency = "AUD";
                            return;
                        }
                    }
                }



            });

        }


    }).error(function(response){

        alert("error on getting current currency");
    });
}



function addComma(value)
{

	return Number(value).toLocaleString('en');
}


rs_module.controller('FilesQuoteController',["$scope", "$stateParams","$http", "$modal", "toaster", FilesQuoteController]);
