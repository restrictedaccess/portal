(function () {
    angular.module('inspinia', [
        'ui.router',
        'oc.lazyLoad',
        'ui.bootstrap',
        'pascalprecht.translate',
        'ngIdle',
        'ngSanitize',
        'angularUtils.directives.dirPagination'
    ]).filter('startFrom', function () {
        return function (data, start) {
            if (!data || !data.length) {
                return;
            }
            start = +start;
            return data.slice(start);
        };
    });
})();

// Other libraries are loaded dynamically in the config.js file using the library ocLazyLoad