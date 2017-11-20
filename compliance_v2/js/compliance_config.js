/**
 * INSPINIA - Responsive Admin Theme
 *
 * Inspinia theme use AngularUI Router to manage routing and views
 * Each view are defined as state.
 * Initial there are written state for all view in theme.
 *
 */
function config($stateProvider, $urlRouterProvider, $ocLazyLoadProvider, IdleProvider, KeepaliveProvider) {

    // Configure Idle settings
    IdleProvider.idle(5); // in seconds
    IdleProvider.timeout(120); // in seconds


	var DEFAULT_PAGE = jQuery("#DEFAULT_PAGE").val();
	/*
	if (DEFAULT_PAGE!=""){
		$urlRouterProvider.otherwise(DEFAULT_PAGE);
	}else{
		$urlRouterProvider.otherwise("/accounts/manage-payment-advise");
	}
*/
    $ocLazyLoadProvider.config({
        // Set to true if you want to see what and when is dynamically loaded
        debug: false
    });

    $stateProvider

        .state('leave-request', {
            abstract: true,
            url: "/leave-request",
            templateUrl: "views/common/content.html",
        })
        
        .state('leave-request.search', {
            url: "/search",
            templateUrl: "views/leave_request/leave_request.html",
            data: { pageTitle: 'Leave Request Management Page' },
            resolve:{
            	loadPlugin:function($ocLazyLoad){
					return $ocLazyLoad.load([
						{
							name: 'datePicker',
							files: ['css/plugins/datapicker/angular-datapicker.css','js/plugins/datapicker/angular-datepicker.js']
						},
						
						{
							insertBefore: '#loadBefore',
							name: 'localytics.directives',
							files: ['css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
						},
						
						{
                            insertBefore: '#loadBefore',
                            name: 'toaster',
                            files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css']
                        },
						
						{
							serie: true,
							files: ['js/plugins/moment/moment.min.js', 'js/plugins/daterangepicker/daterangepicker.js', 'css/plugins/daterangepicker/daterangepicker-bs3.css']
						},
						
						{
							name: 'daterangepicker',
							files: ['js/plugins/daterangepicker/angular-daterangepicker.js']
						},
						   
						{
							serie: true,
							name: 'angular-ladda',
							files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css','js/plugins/ladda/angular-ladda.min.js']
						},
						
						{
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        },
                        
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                        
                        
						
					]);
            	}
            }
        })
        
        .state('leave-request.dashboard', {
            url: "/dashboard",
            templateUrl: "views/leave_request/dashboard.html",
            data: { pageTitle: 'Leave Request Management Dashboard' },
            resolve:{
            	loadPlugin:function($ocLazyLoad){
					return $ocLazyLoad.load([
						{
							name: 'datePicker',
							files: ['css/plugins/datapicker/angular-datapicker.css','js/plugins/datapicker/angular-datepicker.js']
						},
						
						{
							insertBefore: '#loadBefore',
							name: 'localytics.directives',
							files: ['css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
						},
						
						{
                            insertBefore: '#loadBefore',
                            name: 'toaster',
                            files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css']
                        },
						
						{
							serie: true,
							files: ['js/plugins/moment/moment.min.js', 'js/plugins/daterangepicker/daterangepicker.js', 'css/plugins/daterangepicker/daterangepicker-bs3.css']
						},
						
						{
							name: 'daterangepicker',
							files: ['js/plugins/daterangepicker/angular-daterangepicker.js']
						},
						   
						{
							serie: true,
							name: 'angular-ladda',
							files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css','js/plugins/ladda/angular-ladda.min.js']
						},
						
						{
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        },
                        
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                        
                        
						
					]);
            	}
            }
        })

        .state('leave-request.details', {
            url: "/details/:id",
            templateUrl: "views/leave_request/leave_request_details.html",
            data: { pageTitle: 'Leave Request Details' },
            resolve:{
            	loadPlugin:function($ocLazyLoad){
					return $ocLazyLoad.load([
						{
							name: 'datePicker',
							files: ['css/plugins/datapicker/angular-datapicker.css','js/plugins/datapicker/angular-datepicker.js']
						},
						
						{
							insertBefore: '#loadBefore',
							name: 'localytics.directives',
							files: ['css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
						},
						
						{
                            insertBefore: '#loadBefore',
                            name: 'toaster',
                            files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css']
                        },
						
						{
							serie: true,
							files: ['js/plugins/moment/moment.min.js', 'js/plugins/daterangepicker/daterangepicker.js', 'css/plugins/daterangepicker/daterangepicker-bs3.css']
						},
						
						{
							name: 'daterangepicker',
							files: ['js/plugins/daterangepicker/angular-daterangepicker.js']
						},
						   
						{
							serie: true,
							name: 'angular-ladda',
							files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css','js/plugins/ladda/angular-ladda.min.js']
						},
						
						{
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        },
                        
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        },
                        
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        }
                        
                        
						
					]);
            	}
            }
        })
        
        .state('notification', {
            abstract: true,
            url: "/notification",
            templateUrl: "views/common/content.html",
        })
        
        .state('notification.dashboard', {
            url: "/dashboard",
            templateUrl: "views/notification/dashboard.html",
            data: { pageTitle: 'Dashboard Page' },
            resolve:{
            	loadPlugin:function($ocLazyLoad){
					return $ocLazyLoad.load([
						{
							name: 'datePicker',
							files: ['css/plugins/datapicker/angular-datapicker.css','js/plugins/datapicker/angular-datepicker.js']
						},
						
						{
							insertBefore: '#loadBefore',
							name: 'localytics.directives',
							files: ['css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
						},
						
						{
                            insertBefore: '#loadBefore',
                            name: 'toaster',
                            files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css']
                        },
						
						{
							serie: true,
							files: ['js/plugins/moment/moment.min.js', 'js/plugins/daterangepicker/daterangepicker.js', 'css/plugins/daterangepicker/daterangepicker-bs3.css']
						},
						
						{
							name: 'daterangepicker',
							files: ['js/plugins/daterangepicker/angular-daterangepicker.js']
						},
						   
						{
							serie: true,
							name: 'angular-ladda',
							files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css','js/plugins/ladda/angular-ladda.min.js']
						},
						
						{
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        },
                        
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                        
                        
						
					]);
            	}
            }
        });

}
angular
    .module('inspinia')
    .config(config)
    .run(function($rootScope, $state) {
        $rootScope.$state = $state;
    });
