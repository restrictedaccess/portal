/**
 * INSPINIA - Responsive Admin Theme
 *
 */
(function () {
    angular.module('inspinia', [
        'ui.router',                    // Routing
        'oc.lazyLoad',                  // ocLazyLoad
        'ui.bootstrap',                 // Ui Bootstrap
        'pascalprecht.translate',       // Angular Translate
        'ngIdle',                       // Idle timer
        'ngSanitize',                    // ngSanitize
        'angularUtils.directives.dirPagination' //cutom pagination
    ]).filter('unique', function() {
        return function(collection, primaryKey) {
            var output = [],
                keys = [];
            var splitKeys = primaryKey.split('.');



            angular.forEach(collection, function(item) {
                var key = {};
                angular.copy(item, key);
                for(var i=0; i<splitKeys.length; i++){
                    key = key[splitKeys[i]];
                }

                if(keys.indexOf(key) === -1) {
                    keys.push(key);
                    output.push(item);
                }
            });

            return output;
        };
    });
})();

// Other libraries are loaded dynamically in the config.js file using the library ocLazyLoad