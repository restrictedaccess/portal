function config($stateProvider, $urlRouterProvider, $ocLazyLoadProvider, IdleProvider, KeepaliveProvider) {
    IdleProvider.idle(5);
    IdleProvider.timeout(120);
    var DEFAULT_PAGE = jQuery("#DEFAULT_PAGE").val();
    $ocLazyLoadProvider.config({
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
        data: { pageTitle: 'Quote Pre forma' },
        resolve: {
            loadPlugin: function ($ocLazyLoad) {
                return $ocLazyLoad.load([
                    {
                        insertBefore: '#loadBefore',
                        name: 'toaster',
                        files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css', 'css/plugins/chosen/chosen.css', 'js/plugins/chosen/chosen.jquery.js', 'js/plugins/chosen/chosen.js']
                    },
                    {
                        serie: true,
                        name: 'angular-ladda',
                        files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css', 'js/plugins/ladda/angular-ladda.min.js', 'css/quote.css']
                    },
                ]);
            }
        }
    })
        .state('quote', {
        abstract: true,
        url: "/quote",
        templateUrl: "views/common/content.html",
    })
        .state('quote.dashboard', {
        url: "/dashboard",
        templateUrl: "views/quote/dashboard.html",
        data: { pageTitle: 'Quote Dashboard' },
        resolve: {
            loadPlugin: function ($ocLazyLoad) {
                return $ocLazyLoad.load([
                    {
                        insertBefore: '#loadBefore',
                        name: 'toaster',
                        files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css']
                    },
                    {
                        serie: true,
                        name: 'angular-ladda',
                        files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css', 'js/plugins/ladda/angular-ladda.min.js']
                    },
                ]);
            }
        }
    })
        .state('quote.client', {
        url: "/client/:leads_id/:status",
        templateUrl: "views/quote/client.html",
        data: { pageTitle: 'Client Quote' },
        resolve: {
            loadPlugin: function ($ocLazyLoad) {
                return $ocLazyLoad.load([
                    {
                        insertBefore: '#loadBefore',
                        name: 'toaster',
                        files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css', 'css/plugins/chosen/chosen.css', 'js/plugins/chosen/chosen.jquery.js', 'js/plugins/chosen/chosen.js']
                    },
                    {
                        serie: true,
                        name: 'angular-ladda',
                        files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css', 'js/plugins/ladda/angular-ladda.min.js', 'css/quote.css']
                    },
                ]);
            }
        }
    })
        .state('quote.info', {
        url: "/details/?quote_id",
        templateUrl: "views/quote/details.html",
        data: { pageTitle: 'Quote Details' },
        resolve: {
            loadPlugin: function ($ocLazyLoad) {
                return $ocLazyLoad.load([
                    {
                        insertBefore: '#loadBefore',
                        name: 'toaster',
                        files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css', 'css/plugins/chosen/chosen.css', 'js/plugins/chosen/chosen.jquery.js', 'js/plugins/chosen/chosen.js']
                    },
                    {
                        serie: true,
                        name: 'angular-ladda',
                        files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css', 'js/plugins/ladda/angular-ladda.min.js', 'css/quote.css']
                    },
                ]);
            }
        }
    })
        .state('quote.main', {
        url: "/main/:leads_id",
        templateUrl: "views/quote/main.html",
        data: { pageTitle: 'Quote Details' },
        resolve: {
            loadPlugin: function ($ocLazyLoad) {
                return $ocLazyLoad.load([
                    {
                        name: 'datePicker',
                        files: ['css/plugins/datapicker/angular-datapicker.css', 'js/plugins/datapicker/angular-datepicker.js']
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
                        insertBefore: '#loadBefore',
                        name: 'toaster',
                        files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css', 'css/plugins/chosen/chosen.css', 'js/plugins/chosen/chosen.jquery.js', 'js/plugins/chosen/chosen.js']
                    },
                    {
                        serie: true,
                        files: ['css/quote.css']
                    },
                    {
                        serie: true,
                        name: 'angular-ladda',
                        files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css', 'js/plugins/ladda/angular-ladda.min.js', 'css/quote.css']
                    },
                ]);
            }
        }
    })
        .state('quote.service_agreement', {
        url: "/service_agreement/:leads_id/:status",
        templateUrl: "views/quote/service_agreement.html",
        data: { pageTitle: 'Service Agreement' },
        resolve: {
            loadPlugin: function ($ocLazyLoad) {
                return $ocLazyLoad.load([
                    {
                        name: 'datePicker',
                        files: ['css/plugins/datapicker/angular-datapicker.css', 'js/plugins/datapicker/angular-datepicker.js']
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
                        insertBefore: '#loadBefore',
                        name: 'toaster',
                        files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css', 'css/plugins/chosen/chosen.css', 'js/plugins/chosen/chosen.jquery.js', 'js/plugins/chosen/chosen.js']
                    },
                    {
                        serie: true,
                        name: 'angular-ladda',
                        files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css', 'js/plugins/ladda/angular-ladda.min.js', 'css/quote.css']
                    },
                ]);
            }
        }
    })
        .state('quote.service_agreement_info', {
        url: "/service_agreement_info/:quote_id/:sa_id",
        templateUrl: "views/quote/service_agreement_info.html",
        data: { pageTitle: 'Service Agreement' },
        resolve: {
            loadPlugin: function ($ocLazyLoad) {
                return $ocLazyLoad.load([
                    {
                        name: 'datePicker',
                        files: ['css/plugins/datapicker/angular-datapicker.css', 'js/plugins/datapicker/angular-datepicker.js']
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
                        insertBefore: '#loadBefore',
                        name: 'toaster',
                        files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css', 'css/plugins/chosen/chosen.css', 'js/plugins/chosen/chosen.jquery.js', 'js/plugins/chosen/chosen.js']
                    },
                    {
                        serie: true,
                        name: 'angular-ladda',
                        files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css', 'js/plugins/ladda/angular-ladda.min.js', 'css/quote.css']
                    },
                    {
                        name: 'summernote',
                        files: ['css/plugins/summernote/summernote.css', 'css/plugins/summernote/summernote-bs3.css', 'js/plugins/summernote/summernote.min.js', 'js/plugins/summernote/angular-summernote.min.js']
                    },
                ]);
            }
        }
    });
}
angular
    .module('inspinia')
    .config(config)
    .run(function ($rootScope, $state) {
    $rootScope.$state = $state;
});
//# sourceMappingURL=accounts_config.js.map