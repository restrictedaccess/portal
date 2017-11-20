var API_URL = jQuery("#NJS_API_URL").val();
var Toaster = null;
var SweetAlert = null;
function TrackController($scope, $stateParams, $http, $modal, $location,toaster,SweetAlert){
    Toaster = toaster;
    $scope.track_data = null;
    $scope.page = 1;
    $scope.totalPages = 0;
    $scope.limit = 20;
    $scope.pagination = {currentPage:1,maxSize:10};
    $scope.numPerPage = 20;
    $scope.formData = {};
    $scope.isCount = true;
    $scope.noData = false;
    $scope.formData.ready_to_send = [];
    $scope.data_send = [];
    $scope.order_id_list = [];
    $scope.isSearch = false;
    $scope.invoiceAmountResultPerCurrency = null;
    $scope.loading = [];


    $scope.AUD_total = getDecimal(0);
    $scope.USD_total = getDecimal(0);
    $scope.GBP_total = getDecimal(0);

    $scope.pendingCount = 0;
    $scope.sentCount = 0;

    $scope.invoice_tracking_controller.selected_date_range_order_date = {startDate: null, endDate: null};
    $scope.invoice_tracking_controller.selected_date_range_due_date = {startDate: null, endDate: null};


    $scope.pageChanged = function(page) {
        $scope.page  = page;
        $scope.pagination.currentPage = page;
        $scope.track_data=null;

        $scope.isCount = false;
        $scope.formData.check_all = false;
        getTrackData($scope,$http);
    };



    $scope.searchTrack = function()
    {
        $scope.page  = 1;
        $scope.pagination.currentPage = 1;
        $scope.track_data=null;

        $scope.isSearch = true;
        $scope.isCount = true;

        $scope.AUD_total = getDecimal(0);
        $scope.USD_total =getDecimal(0);
        $scope.GBP_total = getDecimal(0);

        $scope.pendingCount = 0;
        $scope.sentCount = 0;


        searchParams($scope,$http);


    };


    $scope.refreshTrack = function()
    {
        $scope.page  = 1;
        $scope.pagination.currentPage = 1;
        $scope.track_data=null;

        $scope.isSearch = false;
        $scope.isCount = true;

        $scope.data_send = [];

        $scope.formData = {};
        $scope.formData.ready_to_send = [];
        $scope.invoice_tracking_controller.selected_date_range_order_date = {startDate: null, endDate: null};
        $scope.invoice_tracking_controller.selected_date_range_due_date = {startDate: null, endDate: null};

        $scope.AUD_total = getDecimal(0);
        $scope.USD_total = getDecimal(0);
        $scope.GBP_total = getDecimal(0);

        $scope.pendingCount = 0;
        $scope.sentCount = 0;

        $scope.totalPages = 0;

        getTrackData($scope,$http);
    };


    $scope.sendInvoice = function(i)
    {
        $scope.invoice_index = i;
        send_invoice($scope,$http,SweetAlert);
    };


    $scope.re_sendEmail = function(data)
    {
        $scope.resend_data = data;

        reSendEmail($scope,$http);
    };


    $scope.storeInvoice = function(data)
    {
        var temp = [];
        var temp_order_list = [];
       data.isSend = $scope.formData.ready_to_send[data.order_id];

        if( $scope.data_send.length > 0)
        {
            for(var i = 0 ; i < $scope.data_send.length ; i++)
            {
                value = $scope.data_send[i];

                if(value.order_id == data.order_id)
                {
                    if(data.isSend)
                    {
                        value = data;
                        temp.push(value);
                        temp_order_list.push(value.order_id);
                    }
                }
                else
                {
                    temp.push(value);
                    temp_order_list.push(value.order_id);
                }
            }
            $scope.data_send = temp;
            $scope.order_id_list = temp_order_list;

            if($scope.order_id_list.indexOf(data.order_id) == -1)
            {
                if(data.isSend )
                {
                    $scope.data_send.push(data);
                    $scope.order_id_list.push(data.order_id);
                }

            }

        }else
        {
            $scope.data_send.push(data);
            $scope.order_id_list.push(data.order_id);
        }
    };


    $scope.checkAll = function()
    {
        if($scope.track_data.length > 0 )
        {
            angular.forEach($scope.track_data,function(value,key){

                if($scope.formData.check_all)
                {
                    if(value.queue == "pending")
                    {
                        $scope.formData.ready_to_send[value.order_id] = true;
                        $scope.storeInvoice(value);
                    }
                }
                else
                {
                    $scope.formData.ready_to_send[value.order_id] = false;
                    $scope.data_send = [];
                    $scope.order_id_list = [];
                }
            });
        }


    };


    $scope.checkStatus = function(data)
    {
        if(data)
        {
            data.color = "#3366cc";

            if(data.queue == "sent")
            {
                data.color = "#00cc99";
            }
        }


    };


    $scope.checkCurrency = function(data)
    {
        var amount = "";

            if(data.invoice_currency == "AUD" || data.invoice_currency == "USD")
            {

                amount = "$"+ getDecimal(parseFloat(data.invoice_amount));
            }

            else if(data.invoice_currency == "GBP")
            {
                amount = "£"+getDecimal(parseFloat(data.invoice_amount));
            }

        return amount;
    }

    $scope.sendAll = function()
    {
        if($scope.data_send.length > 0 )
        {
            send_invoice($scope,$http);
        }

    };


    $scope.init = function () {
        getTrackData($scope,$http)
    };


    $scope.init();
}


function getTrackData($scope,$http)
{
       $scope.formData.page = $scope.page;
       if($scope.isCount) {$scope.formData.count = "yes";}
       var uri = API_URL+"/invoice-auto-creation/fetch-track";

       $http({
           method: "POST",
           url:uri,
           data:$scope.formData
       }).success(function (response) {

           if(response.success)
           {
               if(response.data && response.data.length > 0)
               {
                   $scope.noData = false;
                   $scope.track_data = response.data;
                   if($scope.isCount)
                   {
                       $scope.totalPages = response.count;
                       $scope.invoiceAmountResultPerCurrency = response.total_invoice_amount;

                        if($scope.invoiceAmountResultPerCurrency.length > 0 )
                          {
                              angular.forEach($scope.invoiceAmountResultPerCurrency,function(value,key){

                                  if(value._id == "AUD")
                                  {
                                      $scope.AUD_total = getDecimal(parseFloat(value.total_amount));
                                  }

                                  else if(value._id == "GBP")
                                  {
                                      $scope.GBP_total = getDecimal(parseFloat(value.total_amount));
                                  }

                                  else if(value._id == "USD")
                                  {
                                      $scope.USD_total = getDecimal(parseFloat(value.total_amount));
                                  }

                                  else if(value._id == "pending")
                                  {
                                      $scope.pendingCount = value.total_amount;
                                  }
                                  else if(value._id == "sent")
                                  {
                                      $scope.sentCount = value.total_amount;
                                  }

                              });

                          }

                      // else
                      // {
                      //     angular.forEach($scope.track_data,function(value,key){
                      //
                      //         if(value.invoice_currency == "AUD" )
                      //         {
                      //
                      //             $scope.AUD_total = (parseFloat($scope.AUD_total) + parseFloat(value.invoice_amount));
                      //
                      //         }
                      //
                      //         else if (value.invoice_currency == "USD"){
                      //
                      //             $scope.USD_total = (parseFloat($scope.USD_total) + parseFloat(value.invoice_amount));
                      //
                      //         }
                      //         else if(value.invoice_currency == "GBP")
                      //         {
                      //             $scope.GBP_total = (parseFloat($scope.GBP_total) + parseFloat(value.invoice_amount));
                      //         }
                      //
                      //         $scope.checkStatus(value);
                      //
                      //     });
                      //
                      //     $scope.AUD_total = getDecimal($scope.AUD_total);
                      //     $scope.USD_total = getDecimal($scope.USD_total);
                      //     $scope.GBP_total = getDecimal($scope.GBP_total);
                      //
                      // }

                   }

               }
               else
               {
                   $scope.noData = true;
                   $scope.totalPages = 0;
                   $scope.pendingCount = 0;
                   $scope.sentCount = 0;
                   $scope.AUD_total = getDecimal(0);
                   $scope.USD_total = getDecimal(0);
                   $scope.GBP_total = getDecimal(0);
               }

           }
           else {
               console.log(response);
               $scope.noData = true;
               $scope.totalPages = 0;
               $scope.pendingCount = 0;
               $scope.sentCount = 0;
               $scope.AUD_total = getDecimal(0);
               $scope.USD_total = getDecimal(0);
               $scope.GBP_total = getDecimal(0);
           }

       }).error(function(response, status) {
           console.log("Error...");
           console.log(response);
           $scope.noData = true;
           $scope.totalPages = 0;
           $scope.pendingCount = 0;
           $scope.sentCount = 0;
           $scope.AUD_total = getDecimal(0);
           $scope.USD_total = getDecimal(0);
           $scope.GBP_total = getDecimal(0);

       });



}


function searchParams($scope,$http)
{

    //order_date

    if($scope.invoice_tracking_controller.selected_date_range_order_date.startDate &&
        $scope.invoice_tracking_controller.selected_date_range_order_date.endDate)
    {
        var start_date_order_date = $scope.invoice_tracking_controller.selected_date_range_order_date.startDate;
        var end_date_order_date = $scope.invoice_tracking_controller.selected_date_range_order_date.endDate;


        var isOrderDate = 1;
    }
    else
    {
        var start_date_order_date = null;
        var end_date_order_date = null;

        var isOrderDate = null;
    }



    //due_date
    if($scope.invoice_tracking_controller.selected_date_range_due_date.startDate
        && $scope.invoice_tracking_controller.selected_date_range_due_date.endDate)
    {
        var start_date_due_date = $scope.invoice_tracking_controller.selected_date_range_due_date.startDate;
        var end_date_due_date = $scope.invoice_tracking_controller.selected_date_range_due_date.endDate;

        var isDueDate = 1;
    }
    else
    {
        var start_date_due_date = null;
        var end_date_due_date = null;

        var isDueDate = null;
    }


    var searchBox = $scope.formData.searchBox;



    $scope.formData =
    {
        search:1,
        start_date_order_date : start_date_order_date,
        end_date_order_date : end_date_order_date,
        start_date_due_date : start_date_due_date,
        end_date_due_date : end_date_due_date,
        searchBox : searchBox,
        isOrderDate : isOrderDate,
        isDueDate : isDueDate,
        status: $scope.formData.Invoice_Status
    }


    console.log($scope.formData);
    getTrackData($scope,$http);


}



function send_invoice($scope,$http,SweetAlert)
{
    var uri = API_URL+"/invoice-auto-creation/send-invoice";

    function loopSending(i)
    {
        $scope.send_loading = true;
        if(i < $scope.data_send.length)
        {
            var data = $scope.data_send[i];
            var formData = {};
            formData.invoice_data = data;

               if(data.queue == "pending")
               {
                   $http({
                       method: "POST",
                       url:uri,
                       data:formData
                   }).success(function (response) {

                       if(response.success)
                       {
                           data.queue = "sent";
                           loopSending(i+1);
                           $scope.sentCount = $scope.sentCount + 1;
                           $scope.checkStatus(data);
                       }
                       else
                       {
                           loopSending(i+1);
                       }

                   }).error(function(response, status) {
                       console.log("Error...");
                       console.log(response);
                       loopSending(i+1);
                       $scope.send_loading = false;
                   });
               }
               else
               {
                   loopSending(i+1);
               }
        }
        else
        {

            console.log('Done Sending');
            alert("Done sending of invoice(s)");
            $scope.send_loading = false;
            $scope.refreshTrack();

        }
    }
    loopSending(0);

}


function reSendEmail($scope,$http)
{
    var uri = API_URL+"/invoice-auto-creation/send-invoice";

    var formData = {};
    formData.invoice_data = $scope.resend_data;

    console.log(formData.invoice_data.client_id);

    $scope.loading[formData.invoice_data.client_id] = true;

    $http({
        method: "POST",
        url:uri,
        data:formData
    }).success(function (response) {

        if(response.success)
        {
            alert("Done re-sending of invoice(s).");

        }
        else
        {
            alert("Failed to resend invoice.");
        }

        $scope.loading[formData.invoice_data.client_id] = false;

    }).error(function(response, status) {
        console.log("Error...");
        console.log(response);
        $scope.loading[formData.invoice_data.client_id] = false;

    });



}

function formatpicker2(date)
{
    var formattedDate = new Date(date);
    var d = formattedDate.getDate();
    var m =  formattedDate.getMonth();
    m += 1;
    var y = formattedDate.getFullYear();


    return y+"-"+m+"-"+d;
}

function getDecimal(value)
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




rs_module.controller('TrackController',["$scope", "$stateParams","$http", "$modal", "$location",  "toaster", "SweetAlert",TrackController]);