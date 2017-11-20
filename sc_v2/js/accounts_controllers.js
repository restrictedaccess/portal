/**
 * MainCtrl - controller
 * Contains severals global data used in diferent view
 *
 */

var API_URL = jQuery("#NJS_API_URL").val();
var BASE_API = jQuery("#BASE_API_URL").val();

function MainCtrl($scope, $http) {
    var admin_name = jQuery("#ADMIN_NAME").val();
    var admin_id = jQuery("#ADMIN_ID").val();
    var admin_userid = jQuery("#ADMIN_USERID").val();

    $scope.admin_name = admin_name;
    $scope.admin_id = admin_id;
    $scope.admin_userid = admin_userid;



    //resync quote_data
    $scope.getLatest = function($scope)
    {
        getLatest($scope,$http);
    }


    //resync solr
    $scope.getLatestSolr = function($scope){

        getLatestSolr($scope,$http);
    };


}
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function formatDate2(unixtime){
    var d = new Date(unixtime);
    var n =  d.toDateString();
    return n;
}


function getLatest($scope,$http)
{
    var uri = BASE_API+"/mongo-index/sync-quote";
    if(typeof $scope.quote_id !== "undefined" || $scope.quote_id)
    {
        uri = BASE_API+"/mongo-index/sync-quote?quote_id="+$scope.quote_id;
    }
    $http({
        method: "GET",
        url:uri
    }).success(function (response) {
        if(response.success){
            $scope.$emit("synced");
        }
    }).error(function(response, status) {
        console.log("Error...");
        console.log(response);
    });
}

function getLatestSolr($scope,$http)
{

    var uri = API_URL+"/sync/solr-sync-quote";
    if(typeof $scope.leads_id !== "undefined" || $scope.leads_id)
    {
        uri = API_URL+"/sync/solr-sync-quote?leads_id="+$scope.leads_id;
    }

    $http({
        method: "GET",
        url: uri
    }).success(function (response) {
        if(response.success){

            console.log("solr syncing started");
        }
    }).error(function(response, status) {
        console.log("Error...");
        console.log(response);
    });
}

/**
 *
 * Pass all functions into module
 */
var rs_module = angular.module('inspinia');
rs_module.controller('MainCtrl', ["$scope", "$http", MainCtrl]);

rs_module.directive("chosen", function(){
    var linker = function (scope, element, attrs) {
        var list = attrs['chosen'];

        scope.$watch(list, function () {
            element.trigger('chosen:updated');
        });

        scope.$watch(attrs['ngModel'], function() {
            element.trigger('chosen:updated');
        });

        element.chosen({ width: '100%'});
    };

    return {
        restrict: 'A',
        link: linker
    };
});
rs_module.directive('select', function($interpolate) {

    return {
        restrict: 'E',
        require: 'ngModel',
        link: function(scope, elem, attrs, ctrl) {
            console.log(attrs.placeholder);
            var defaultOptionTemplate;
            scope.defaultOptionText = attrs.placeholder || 'Select...';
            defaultOptionTemplate = '<option value="" disabled selected style="display: none;">{{defaultOptionText}}</option>';
            elem.prepend($interpolate(defaultOptionTemplate)(scope));
        }
    };
});

rs_module.directive('onlyNum', function() {
    return function(scope, element, attrs) {

        var keyCode = [8,9,37,39,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105,110,190];
        element.bind("keydown", function(event) {
            console.log($.inArray(event.which,keyCode));
            if($.inArray(event.which,keyCode) == -1) {
                scope.$apply(function(){
                    scope.$eval(attrs.onlyNum);
                    event.preventDefault();
                });
                event.preventDefault();
            }

        });
    };
});

rs_module.directive('myLink', function() {
    return {
        scope: {
            enabled: '=myLink'
        },
        link: function(scope, element, attrs) {
            element.bind('click', function(event) {
                if(!scope.enabled) {
                    event.preventDefault();
                }
            });

        }
    };
});

rs_module.directive('toggle', function(){
    return {
        restrict: 'A',
        link: function(scope, element, attrs){
            if (attrs.toggle=="tooltip"){
                $(element).tooltip();
            }
            if (attrs.toggle=="popover"){
                $(element).popover();
            }
        }
    };
});

rs_module.directive('jqdatepicker', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            element.datepicker({
                dateFormat: 'DD, d  MM, yy',
                onSelect: function (date) {
                    scope.date = date;
                    scope.$apply();
                }
            });
        }
    };
});


rs_module.directive('fileModel',['$parse',function($parse){

    return{
        restrict: 'A',
        link: function(scope,element,attrs){

            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change',function(){

                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);

                });

            });

        }


    }


}]);

