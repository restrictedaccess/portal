requirejs.config({
    shim: {
        "dropzone": ["jquery/jquery-2.1.1.min"],
        "plugins/jquery-ui/jquery-ui": ["jquery/jquery-2.1.1.min"],
        "bootstrap/bootstrap.min": ["jquery/jquery-2.1.1.min"],
        "plugins/daterangepicker/daterangepicker": ["jquery/jquery-2.1.1.min"],
        "plugins/metisMenu/jquery.metisMenu": ["jquery/jquery-2.1.1.min"],
        "plugins/slimscroll/jquery.slimscroll.min": ["jquery/jquery-2.1.1.min"],
        "inspinia": ["plugins/slimscroll/jquery.slimscroll.min"],
        "angular/angular-sanitize": ["angular/angular.min", "inspinia"],
        "angular/angular.min": ["inspinia"],
        "plugins/oclazyload/dist/ocLazyLoad.min": ["angular/angular.min"],
        "angular-translate/angular-translate.min": ["angular/angular.min"],
        "plugins/daterangepicker/angular-daterangepicker": ["angular/angular.min"],
        "plugins/summernote/summernote.min": ["jquery/jquery-2.1.1.min"],
        "plugins/summernote/angular-summernote.min": ["jquery/jquery-2.1.1.min", "angular/angular.min"],
        "ui-router/angular-ui-router.min": ["angular/angular.min"],
        "bootstrap/ui-bootstrap-tpls-0.12.0.min": ["angular/angular.min"],
        "plugins/angular-idle/angular-idle": ["angular/angular.min"],
        "app": ["angular/angular.min", "angular/angular-sanitize", "plugins/oclazyload/dist/ocLazyLoad.min", "angular-translate/angular-translate.min", "ui-router/angular-ui-router.min", "bootstrap/ui-bootstrap-tpls-0.12.0.min", "plugins/angular-idle/angular-idle"],
        "accounts_config": ["app"],
        "directives": ["accounts_config"],
        "translations": ["directives"],
        "accounts_controllers": ["translations"],
        "quote": ["accounts_controllers"]
    }
});
var dependencies = ["plugins/moment/moment.min", "plugins/daterangepicker/daterangepicker", "plugins/daterangepicker/angular-daterangepicker", "jquery/jquery-2.1.1.min", "plugins/jquery-ui/jquery-ui", "bootstrap/bootstrap.min", "plugins/metisMenu/jquery.metisMenu", "plugins/slimscroll/jquery.slimscroll.min",
    "dropzone", "inspinia", "angular/angular.min", "angular/angular-sanitize",
    "plugins/oclazyload/dist/ocLazyLoad.min",
    "plugins/summernote/summernote.min",
    "plugins/summernote/angular-summernote.min",
    "ui-router/angular-ui-router.min", "bootstrap/ui-bootstrap-tpls-0.12.0.min", "plugins/angular-idle/angular-idle",
    "app", "accounts_config", "directives", "translations", "accounts_controllers", "quote"];
requirejs(dependencies, function () {
    angular.bootstrap($('html'), ['inspinia']);
});
//# sourceMappingURL=bootstrap.js.map