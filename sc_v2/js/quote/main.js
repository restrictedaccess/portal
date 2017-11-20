

var API_URL = jQuery("#NJS_API_URL").val();
var BASE_API = jQuery("#BASE_API_URL").val();

function MainDetailsController($scope, $stateParams, $http, $modal, toaster){

    // $scope.quote_id = $stateParams.quote_id;
    if($stateParams.leads_id)
    {
        $scope.leads_id = $stateParams.leads_id;
    }
    $scope.page = 1;
    $scope.totalPages = null;
    $scope.leads_data = null;
    $scope.limit = 50;
    $scope.pagination = {currentPage:1,maxSize:10};
    $scope.numPerPage = 50;
    $scope.formData = {};
    $scope.totalLeadsCount = null;
    $scope.isSearch = false;
    $scope.main_details_controller.selected_date_range = {startDate: null, endDate: null};
    $scope.isFound = true;

    $scope.pageChanged = function(page) {
        console.log(page);
        $scope.page  = page;
        $scope.pagination.currentPage = page;
        $scope.leads_data=null;

        if(!$scope.isSearch)
        {
            $scope.count = 'no';
            getLeadsData($scope,$http);
        }
        else
        {
            globalSearch($scope,$http);
        }


    };

    $scope.initPage = function()
    {
        $scope.getLatest($scope);
    };


    $scope.searchQuote = function()
    {
        //global search
        $scope.loading5 = true;
        $scope.isSearch = true;
        $scope.pagination.currentPage = 1;
        globalSearch($scope,$http);
    };

    $scope.refresh = function(){
        $scope.loading6 = true;
        $scope.leads_data=null;
        $scope.page  = 1;
        $scope.pagination.currentPage = 1;
        $scope.count = 'yes';
        $scope.formData.q = "";
        $scope.main_details_controller.selected_date_range = {startDate: null, endDate: null};
        $scope.isSearch = false;
        $scope.isFound = true;
        $scope.initPage();
    };




    $scope.initPage();

    $scope.$on("synced", function(event) {
        $scope.count = 'yes';
        getLeadsData($scope,$http);
        $scope.getLatestSolr($scope);
    });


    $scope.main_details_controller.optionsDateRange = {
        autoApply: true,
        locale: {
            format: "M/D/YYYY"
        }
    };

    $scope.generateQuoteMain = function(id)
    {
        $scope.leads_id = id;
        generate_quote_main($scope,$http,toaster);
    };

}


function getLeadsData($scope,$http)
{

    var uri = API_URL+"/quote/get-all-leads?page="+$scope.page+"&count="+$scope.count;

    if($scope.leads_id)
    {
        uri = API_URL+"/quote/get-all-leads?page="+$scope.page+"&count="+$scope.count+"&leads_id="+$scope.leads_id;
    }

    $http({
        method: "GET",
        url:uri
    }).success(function (response) {
        if(response.success){
            if(response.data || response.data.length > 0)
            {
                $scope.leads_data = response.data;
                if(response.totalCount)
                {
                    if(!$scope.leads_id)
                    {
                        // $scope.totalPages = (response.totalCount/50)*10;
                        $scope.totalPages = response.totalCount;
                        $scope.totalLeadsCount = response.totalCount;
                    }
                    else
                    {
                        $scope.totalPages = response.totalCount
                    }
                }
            }
            else
            {
                $scope.isFound = false;
            }
        }
        else
        {
            $scope.isFound = false;

        }
        switchOffLoading($scope)
    }).error(function(response, status) {
        console.log("Error...");
        console.log(response);
        switchOffLoading($scope)
    });

}

function globalSearch($scope,$http)
{
    var q = (typeof $scope.formData.q !== 'undefined' ? $scope.formData.q : null);
    var page = $scope.pagination.currentPage;


    var uri = "";
    var start_date = "";
    var end_date = "";

    if(q && !$scope.main_details_controller.selected_date_range.startDate && !$scope.main_details_controller.selected_date_range.endDate)
    {
        uri = API_URL+"/search/search-quote?q="+q+"&page="+page;
    }
    else if($scope.main_details_controller.selected_date_range.startDate && $scope.main_details_controller.selected_date_range.endDate && !q)
    {
        start_date = formatpicker($scope.main_details_controller.selected_date_range.startDate);
        end_date = formatpicker($scope.main_details_controller.selected_date_range.endDate);

        uri = API_URL+"/search/search-quote-by-date?from="+start_date+"&to="+end_date+"&page="+page;

    }
    else if(q && $scope.main_details_controller.selected_date_range.startDate && $scope.main_details_controller.selected_date_range.endDate)
    {
        start_date = formatpicker($scope.main_details_controller.selected_date_range.startDate);
        end_date = formatpicker($scope.main_details_controller.selected_date_range.endDate);

        uri = API_URL+"/search/search-quote-by-date?&text="+q+"&from="+start_date+"&to="+end_date+"&page="+page;

    }
    else{};


    $http({
        method: "GET",
        url: uri
    }).success(function (response) {
        if(response.success){
            if(response.data.docs.length > 0)
            {
                var tempDeatils = [];
                var docs = response.data.docs;
                var toTaldocs =response.data.numFound;


                //uncomment this if resyncing of data to solr is finished (add sa_data )

                angular.forEach(docs,function(value,key){

                    var posted = 0,
                        draft = 0,
                        New = 0,
                        deleted = 0,
                        sa_accepted = 0,
                        sa_pending = 0;



                    if(typeof value.quote_data_status !== 'undefined') {

                        if (value.quote_data_status.length > 0) {

                            value.quote_data_status.forEach(function(item){
                                status = item;

                                if (status == "posted") {
                                    posted = posted + 1;
                                }
                                else if (status == "draft") {
                                    draft = draft + 1;
                                }
                                else if (status == "new") {
                                    New = New + 1;
                                }
                                else if (status == "deleted") {
                                    deleted = deleted + 1;
                                }
                                else {
                                }
                            });


                        }
                    }

                    if(typeof value.sa_data_status !== 'undefined')
                    {
                        if(value.sa_data_status.length > 0)
                        {

                            value.sa_data_status.forEach(function(item){
                                status = item;
                                if(status == "yes"){sa_accepted = sa_accepted + 1;}
                                else if(status == "no"){sa_pending = sa_pending + 1;}
                            });


                        }

                    }

                    value.leads = {
                        id:value.id,
                        fname:value.fname,
                        lname:value.lname,
                        fullName:value.fullName,
                        email:value.email,
                        status:value.status
                    }

                    value.count_data = {
                        postedCount : posted,
                        draftCount : draft,
                        newCount : New,
                        deletedCount : deleted,
                        acceptedCount : sa_accepted,
                        pendingCount : sa_pending
                    }

                    tempDeatils.push(value);

                });

                $scope.leads_data = tempDeatils;
                $scope.totalPages = parseInt(toTaldocs);
                $scope.isFound = true;
            }else
            {
                $scope.leads_data = null;
                $scope.totalPages = 0;
                $scope.isFound = false;
            }

        }

        switchOffLoading($scope);

    }).error(function(response, status) {
        console.log("Error...");
        console.log(response);
        switchOffLoading($scope);
    });


}


function generate_quote_main($scope,$http,toaster){

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
        if(response.success){
            toaster.pop({
                type: 'success',
                title: 'Quote',
                body: response.msg,
                showCloseButton: true,
            });
            $scope.quote_id = response.quote_id;
            $scope.getLatest($scope);

            window.location.href = "/portal/sc_v2/#/quote/details/?quote_id="+response.quote_id;
        }else{
            toaster.pop({
                type: 'error',
                title: 'Quote',
                body: response.error,
                showCloseButton: true,
            });
        }
    }).error(function(response){
        alert("There's a problem in generating new quote. Please try again later.");
    });

}


function switchOffLoading($scope)
{
    $scope.loading5 = false;
    $scope.loading6 = false;

}

function formatpicker(date)
{
    var formattedDate = new Date(date);
    var d = formattedDate.getDate();
    var m =  formattedDate.getMonth();
    m += 1;
    var y = formattedDate.getFullYear();

    return y+"-"+m+"-"+d;
}


rs_module.controller('MainDetailsController',["$scope", "$stateParams","$http", "$modal", "toaster", MainDetailsController]);
