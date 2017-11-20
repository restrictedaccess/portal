/**
 * MainCtrl - controller
 * Contains severals global data used in diferent view
 *
 */
function MainCtrl($scope, $http) {
	var admin_name = jQuery("#ADMIN_NAME").val();
	var admin_id = jQuery("#ADMIN_ID").val();
	var admin_userid = jQuery("#ADMIN_USERID").val();
	
	$scope.admin_name = admin_name;
	$scope.admin_id = admin_id;
	$scope.admin_userid = admin_userid;
	

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
