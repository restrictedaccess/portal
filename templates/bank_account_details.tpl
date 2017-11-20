<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$personal.fname} {$personal.lname} Payment Details</title>
<link rel=stylesheet type=text/css href="css/font.css">
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
{php}include("header.php"){/php}
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  {$personal.fname} {$personal.lname} </b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>	

<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   {php}include("subconleftnav.php"){/php}   
   </td>
<td width="1081" valign="top">
<form name="form" method="post">



<h2 align="center">{$personal.fname} {$personal.lname} Payment Details</h2>


<table width="50%" cellspacing="3" align="center">
	<tr>
    	<td align="right">Sterling Account Number</td>
        <td><input type="text" name="card_number" id="card_number" value="{$sterling.card_number|escape}" size="50"  /></td>
    </tr> 
    <tr>   
        <td align="right">Sterling Account Holders Name</td>
        <td><input type="text" name="account_holders_name" id="account_holders_name" value="{$sterling.account_holders_name|escape}"  size="50" /></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
    	<td align="right">Bank</td>
        <td><input type="text" name="bank_name" id="bank_name" value="{$bank.bank_name|escape}"  size="50" /></td>
    </tr>
    
    <tr>
    	<td align="right">Bank Branch</td>
        <td><input type="text" name="bank_branch" id="bank_branch" value="{$bank.bank_branch|escape}" size="50" /></td>
    </tr>
    
    <tr>
    	<td align="right">Bank Swift Address</td>
        <td><input type="text" name="swift_address" id="swift_address" value="{$bank.swift_address|escape}" size="50" /></td>
    </tr>
    
    <tr>
    	<td align="right">Bank Account Number</td>
        <td><input type="text" name="bank_account_number" id="bank_account_number" value="{$bank.bank_account_number|escape}" size="50"  /></td>
    </tr>
    
    <tr>
    	<td align="right">Bank Account Holders Name</td>
        <td><input type="text" name="bank_account_holders_name" id="bank_account_holders_name" value="{$bank.account_holders_name|escape}" size="50" /></td>
    </tr>
   
    <tr><td colspan="2" align="center">
    <input type="submit" name="update"  value="Save Changes" />
    </td></tr>
</table>




</form>
</td>
</tr>
</table>
</body>
</html>
