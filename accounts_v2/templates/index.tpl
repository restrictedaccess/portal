<!DOCTYPE html>
<html ng-app="inspinia">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title set in pageTitle directive -->
    <title page-title></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Font awesome -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Main Inspinia CSS files -->
    <link href="css/animate.css" rel="stylesheet">
    <link id="loadBefore" href="css/style.css" rel="stylesheet">
    <link href="css/timesheet.css" rel="stylesheet">
    <link href="css/invoice-report.css" rel="stylesheet">
    
	



</head>

<!-- ControllerAs syntax -->
<!-- Main controller with serveral data used in Inspinia theme on diferent view -->





{literal}
<body ng-controller="MainCtrl as main" class="{{$state.current.data.specialClass}} md-skin mini-navbar mini-bar" landing-scrollspy id="page-top">
{/literal}
<link href="css/new-invoice.css" rel="stylesheet">
<input type="hidden" name="BASE_API_URL" id="BASE_API_URL" value="{$BASE_API_URL}"/>
<input type="hidden" name="BASE_URL" id="BASE_URL" value="{$BASE_URL}"/>
<input type="hidden" name="NJS_API_URL" id="NJS_API_URL" value="{$NJS_API_URL}"/>
<input type="hidden" name="ADMIN_ID" id="ADMIN_ID" value="{$admin.admin_id}"/>
<input type="hidden" name="ADMIN_USERID" id="ADMIN_USERID" value="{$admin.userid}"/>
<input type="hidden" name="DEFAULT_PAGE" id="DEFAULT_PAGE" value="{$DEFAULT_PAGE}"/>
<input type="hidden" name="WS_URL" id="WS_URL" value="{$WS_URL}"/>
<input type="hidden" name="ADMIN_NAME" id="ADMIN_NAME" value="{$admin.admin_fname} {$admin.admin_lname}"/>
<input type="hidden" name="DJANGO_URL" id="DJANGO_URL" value="{$DJANGO_URL}"/>
<!-- Main view  -->
<div ui-view></div>

<!-- Bower Components -->
<script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>

<!--Autobahn -->
<script src="//autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>

<!-- jQuery and Bootstrap -->
<script src="js/jquery/jquery-2.1.1.min.js"></script>
<script src="js/plugins/jquery-ui/jquery-ui.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>

<!-- MetsiMenu -->
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- SlimScroll -->
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Peace JS -->
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>

<!-- Main Angular scripts-->
<script src="js/angular/angular.min.js"></script>
<script src="js/angular/angular-sanitize.js"></script>
<script src="js/plugins/moment/moment.min.js"></script>
<script src="js/plugins/moment/moment-range.min.js"></script>
<script src="js/plugins/oclazyload/dist/ocLazyLoad.min.js"></script>
<script src="js/angular-translate/angular-translate.min.js"></script>
<script src="js/ui-router/angular-ui-router.min.js"></script>
<script src="js/bootstrap/ui-bootstrap-tpls-0.12.0.min.js"></script>
<script src="js/plugins/angular-idle/angular-idle.js"></script>


<!-- Model Class -->
<script src="js/models/Invoice.js"></script>




<!-- Anglar App Script -->
<script src="js/app.js"></script>
<script src="js/accounts_config.js"></script>
<script src="js/translations.js"></script>
<script src="js/directives.js"></script>
<script src="js/accounts_controllers.js"></script>
<script src="js/manage_payment_advise.js"></script>
<script src="js/dirPagination.js"></script>
<script src="js/test.js"></script>
<script src="js/timesheet.js"></script>
<script src="js/lock-timesheet.js"></script>
<script src="js/currency-adjustment.js"></script>
<script src="js/rssc-issue.js"></script>
<script src="js/create-timesheet.js"></script>
<script src="js/client-setting.js"></script>
<script src="js/sra.js"></script>
<script src="js/new-invoice.js"></script>
<script src="js/subconlist-reporting.js"></script>

<script src="js/invoice/dashboard.js"></script>
<script src="js/invoice/client-list.js"></script>
<script src="js/invoice/client-account.js"></script>
<script src="js/invoice/invoice-details.js"></script>
<script src="js/invoice/running-balance.js"></script>
<script src="js/invoice/invoice-email-reporting.js"></script>
<script src="js/currency-adjustment-regular.js"></script>
<script src="js/invoice/invoice-summary-reporting.js"></script>
<script src="js/invoice/invoice-track.js"></script>
<script src="js/invoice-version.js"></script>
<script src="js/invoice/invoice-payments.js"></script>

<script src="js/compliance/dashboard.js"></script>
<script src="js/compliance/subcon-suspension-logs.js"></script>
<script src="js/currency-margin/currency-margin.js"></script>

{literal}
<script>
    jQuery(document).ready(function() {
        window['moment-range'].extendMoment(moment);
    });
</script>
{/literal}
</body>
</html>
