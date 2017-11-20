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


        .state('files', {
            abstract: true,
            url: "/files",
            templateUrl: "views/common/mainfile.html",
        })

        .state('files.quote_files', {
            url: "/quote/:ran",
            templateUrl: "views/files/quote.html",
            data: { pageTitle: 'Quote Pro forma' },
            resolve:{
            	loadPlugin:function($ocLazyLoad){
					return $ocLazyLoad.load([
						{
                            insertBefore: '#loadBefore',
                            name: 'toaster',
                            files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css','css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
                        },

						{
							serie: true,
							name: 'angular-ladda',
							files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css','js/plugins/ladda/angular-ladda.min.js','css/quote.css']
						},
					]);
            	}
            }
        })

}
angular
    .module('inspinia')
    .config(config)
    .run(function($rootScope, $state) {
        $rootScope.$state = $state;
    });
