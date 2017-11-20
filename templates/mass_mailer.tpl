<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Mass Mailer</title>
<script src="./media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">
</head>
<body style="margin-top:0; margin-left:0">
<div align="center"><img src="./images/remote-staff-logo2.jpg" ></div>
<form method="post"  accept-charset = "utf-8">
<table align="center" width="70%" cellpadding="5" cellspacing="5" style='font-family: "lucida grande",tahoma,verdana,arial,sans-serif;font-size: 11px;'>

<tr>
<td width="10%" align="right" >Options  </td>
<td width="90%"><input type="button" value="Send Email to All Clients" onclick="javascrip: location.href='mass_mailer.php?section=clients'" /> <input type="button" value="Send Email to All Subcontractors" onclick="javascrip: location.href='mass_mailer.php?section=subcon'" /> <input type="button" value="Blank" onclick="javascrip: location.href='mass_mailer.php'" /></td>
</tr>

<tr>
<td align="right" valign="top">Emails</td>
<td ><input type="text" name="emails" id="emails" style='font-family: "lucida grande",tahoma,verdana,arial,sans-serif;font-size: 11px; width:96%;' value="{$emails}"></td>
</tr>

<tr>
<td align="right">Subject</td>
<td><input type="text" name="subject" style='width:96%; font-family: "lucida grande",tahoma,verdana,arial,sans-serif;font-size: 11px;' /></td>
</tr>

<tr>
<td valign="top" align="right">Message</td>
<td><textarea name="message" id="message" style="height: 200px; width:97%;"></textarea></td>
</tr>

<tr>
<td>&nbsp;</td>
<td><input type="submit" id="save" name="save" value="Send" /> <input type="reset" value="Cancel" /></td>
</tr>
</table>




{literal}
<script type="text/javascript">
	<!--
	//tinyMCE.execCommand("mceAddControl", false, 'message')
	tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
	-->
	</script>
{/literal}

</form>
</body>
</html>