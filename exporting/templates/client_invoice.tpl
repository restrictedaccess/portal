<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Export Client Invoice</title>
      
    <script src="/portal/site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/portal/js/jscal2.js"></script> 
    <script type="text/javascript" src="/portal/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="/portal/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="/portal/css/gold/gold.css" />
        
    
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="/portal/favicon.ico">

</head>    
<body>
    <form name="form" id="frm-client-invoice" method="post">
    <p>Currency : 
    <select name="currency" id="currency"   >
            <option value="AUD" >($) AUD-Australian dollar</option>
            <option value="GBP" >(£) GBP-Pound sterling</option>
            <option value="USD" >($) USD-United States dollar</option>
    </select>  
    </p>
    
    <p>Applied GST  : 
    <select name="apply_gst" id="apply_gst"   >
            
            <option value="Y" >Yes</option>
            <option value="N" >No</option>
            
    </select>  
    </p>
    
    <p>
        
        From : <input type="text" id="from" name="from" readonly   style="width:80px; cursor:pointer;" value="{$from}" >
        
        To : <input type="text" id="to" name="to" readonly   style="width:80px; cursor:pointer;" value="{$to}" >
    </p>
    <p><button>Submit</button></p>
    </form>
{literal}
<script>
jQuery(document).ready(function() {
    jQuery(window).load(function (e) {
       console.log(window.location.pathname);
        
       Calendar.setup({
           inputField : "from",
           trigger    : "from",
           onSelect   : function() { this.hide()  },
           fdow  : 0,
           dateFormat : "%Y-%m-%d",
        });
        
        Calendar.setup({
           inputField : "to",
           trigger    : "to",
           onSelect   : function() { this.hide()  },
           fdow  : 0,
           dateFormat : "%Y-%m-%d",
        });
        
    });
    /*
    jQuery("#apply_gst").removeAttr("disabled");
    $( "#currency" ).change(function() {
        var currency = jQuery("#currency").val();
        if(currency == "AUD"){
            jQuery("#apply_gst").removeAttr("disabled");    
        }else{
            jQuery("#apply_gst").attr("disabled", "disabled");
            jQuery("#apply_gst").val("N");
        }
    });
    */
    jQuery( "#frm-client-invoice" ).submit(function( event ) {
        var from = jQuery("#from").val();
        var to = jQuery("#to").val();
        if(from == ""){
            alert("Please select 'From' date range.");
            event.preventDefault();
        }
        
        if(to == ""){
            alert("Please select 'To' date range.");
            event.preventDefault();
        }
    });
        
});


</script>
{/literal}
</body>
    
</html>    