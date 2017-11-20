<?php /* Smarty version 2.6.19, created on 2012-04-25 08:16:28
         compiled from invoice.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'invoice.tpl', 32, false),array('modifier', 'capitalize', 'invoice.tpl', 35, false),array('modifier', 'number_format', 'invoice.tpl', 49, false),)), $this); ?>
<table width="800" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" style="font-family: tahoma; font-size: 12px; color:#333333;" >
<tr bgcolor="#FFFFFF">
<td valign="top" width="50%">
<img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='254' height='76'  />
<div >
<strong>AUS</strong> : PO Box 1211 Double Bay NSW Australia 1360<br>
<strong>UK</strong> : Remote Staff Limited, 2 Martin House, 179 - 181 North End Road, London W14 9NL<br>
<strong>Phone</strong>: 02 8003 4694 (Tam) , 02 8005 1383 (Angel) <br>
<strong>Fax</strong>: 02 8088 7247<br>
<strong>USA Fax</strong> : (650) 745 1088<br>
<strong>Email</strong>: accounts@remotestaff.com.au
</div>
</td>
<td valign="top" width="50%" align="right">
<img src='http://remotestaff.com.au/portal/images/think_innovations_logo.png' width='224' height='98'  />
<div >
Think Inovations Pty. Ltd. ABN 37 094 364 511<br>
<strong>Websites</strong>: <br>
www.remotestaff.com.au<br>
www.remotestaff.co.uk<br>
www.remotestaff.biz
</div>
</td>
</tr>

<tr bgcolor="#FFFFFF"><td colspan="2" valign="top">
<h2 align="center" >Tax Invoice No <?php echo $this->_tpl_vars['invoice']['invoice_number']; ?>
</h2>
<div style="margin-bottom: 20px; margin-top: 10px;">
    <div style="float: right; text-align:right;">
        Invoice No. <?php echo $this->_tpl_vars['invoice']['invoice_number']; ?>
<br />
        <p style="margin-bottom: 4px; margin-top: 4px;">Invoice ID. <strong><?php echo $this->_tpl_vars['invoice']['id']; ?>
</strong></p>
        <p style="margin-bottom: 4px; margin-top: 4px;">Date Created : <?php echo ((is_array($_tmp=$this->_tpl_vars['invoice']['draft_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B %e, %Y") : smarty_modifier_date_format($_tmp, "%B %e, %Y")); ?>
</p>
    </div>
		
<p style="margin-bottom: 4px; margin-top: 4px;">Name : <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['client_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</strong></p>
<!-- <p style="margin-bottom: 4px; margin-top: 4px;">Email : <?php echo $this->_tpl_vars['invoice']['email']; ?>
</p>-->
<p style="margin-bottom: 4px; margin-top: 4px;">Company : <?php echo $this->_tpl_vars['invoice']['company_name']; ?>
</p>
<p style="margin-bottom: 4px; margin-top: 4px;">Address : <small><?php echo $this->_tpl_vars['invoice']['company_address']; ?>
</small></p>	
</div>



<table width="100%" cellpadding="4" cellspacing="0" border="1" style="font-family: tahoma; font-size: 12px; color:#333333;">
<tr>
<td colspan="2"><strong>Client Tax Invoice to be paid in <?php echo ((is_array($_tmp=$this->_tpl_vars['currency']['currency'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</strong></td>
</tr>
<tr>
<td width="20%">Sub Total</td>
<td width="70%"  align="right" style='font-family: "Courier New",Courier,monospace; font-size: 14px;'><?php echo $this->_tpl_vars['currency']['code']; ?>
 <?php echo $this->_tpl_vars['currency']['sign']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['invoice']['sub_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
</td>
</tr>
<?php if ($this->_tpl_vars['currency']['code'] == 'AUD'): ?>
<tr>
<td>GST</td>
<td align="right" style='font-family: "Courier New",Courier,monospace; font-size: 14px;'><?php echo $this->_tpl_vars['currency']['code']; ?>
 <?php echo $this->_tpl_vars['currency']['sign']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['invoice']['gst'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
</td>
</tr>
<?php endif; ?>
<tr>
<td>Total Amount</td>
<td align="right" style='font-family: "Courier New",Courier,monospace; font-size: 14px;'><span style="background:#FFFF00; font-weight:bold;"><?php echo $this->_tpl_vars['currency']['code']; ?>
 <?php echo $this->_tpl_vars['currency']['sign']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['invoice']['total_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
</span></td>
</tr>
<tr><td colspan="2"><div align="right" style="font-weight:bold;">Invoice Payment Due Date : <?php echo ((is_array($_tmp=$this->_tpl_vars['invoice']['invoice_payment_due_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B %e, %Y") : smarty_modifier_date_format($_tmp, "%B %e, %Y")); ?>
</div>
<div style="font-weight:bold; margin-top:10px; margin-bottom:10px;">PAYMENT METHODS</div>
<div>
<div style="float: right; text-align:right;">
<div style="text-align:left; margin-bottom:10px;"><strong><u> 2. Credit Card Payment</u></strong></div>
Number and Card Type : --------------------------------------<br />
Credit Card Name : --------------------------------------<br />
Expiration Date : --------------------------------------<br />
CVV Code : --------------------------------------<br />

<div style="text-align:left; margin-top:10px; margin-bottom:10px;"><strong><u> 
3. Direct Debit Payment through EZI Debit</u></strong></div>


</div>

<strong><u>1. Electronic Transfer</u></strong><br /><br />
<span style="color:#FF0000; font-weight:bold; display:block;">Australia</span>
Account Name: Think Innovations Pty. Ltd.<br />
BSB: 082 973<br />
Account Number: 49 058 9267<br />
Bank Branch: Darling Street, Balmain NSW 2041<br />
Swift Code: NATAAU3302S
<span style="color:#FF0000; font-weight:bold; display:block;">United Kingdom</span>
Account Name: Think Innovations Pty. Ltd.<br />
UK Bank Address: HSBC. 25 Nothing Hill Gate.London. W11 3JJ<br />
Sort code: 40-05-09<br />
Acc: 61-50-63-23<br />
Swift Code: MIDLGB22<br />
IBAN Number: GB54MIDL40050961506323
<span style="color:#FF0000; font-weight:bold; display:block;">United States</span>
Account Name: Think Innovations Pty. Ltd.<br />
Bank Branch: HSBC Bank USA NA 452 Fifth Avenue, New York, NY 10018<br />
Account number: 048-984-515<br />
Routing Number: 021001088<br />
SWIFT code: MRMDUS33
</div>
</td></tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="color:#333333;font-family: tahoma; font-size: 12px;">
<tr bgcolor="#0000FF" style=" background: url(http://test.remotestaff.com.au/portal/invoice/client/media/images/staffbox-hdr-bg.png) repeat-x scroll left top transparent;" >
<td width="5%" style=" background-color:#0000FF; color: #FFFFFF;font-weight: bold;height: 29px !important;line-height: 29px !important;text-align: center;">#</td>
<td width="15%" style="background-color:#0000FF; color: #FFFFFF;font-weight: bold;height: 29px !important;line-height: 29px !important;text-align: center;">Date</td>
<td width="60%" style="background-color:#0000FF; color: #FFFFFF;font-weight: bold;height: 29px !important;line-height: 29px !important;text-align: center;">Description</td>
<td width="20%" style="background-color:#0000FF; color: #FFFFFF;font-weight: bold;height: 29px !important;line-height: 29px !important;text-align: center;">Amount</td>
</tr>
<?php $_from = $this->_tpl_vars['invoice_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['item']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['item']['iteration']++;
?>
<tr bgcolor="#FFFFFF" >
<td  style="color: #333333;font-family: tahoma; font-size: 12px; padding: 4px;"><?php echo $this->_foreach['item']['iteration']; ?>
</td>
<td align="left" style="color: #333333;font-family: tahoma; font-size: 12px; padding: 4px;" ><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%b. %e, %Y") : smarty_modifier_date_format($_tmp, "%b. %e, %Y")); ?>
 <br /> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%b. %e, %Y") : smarty_modifier_date_format($_tmp, "%b. %e, %Y")); ?>
</td>
<td align="center" style="color: #333333;font-family: tahoma; font-size: 12px; padding: 4px;" ><?php echo $this->_tpl_vars['item']['decription']; ?>
</td>
<td align="right" style='color: #333333;font-family: "Courier New",Courier,monospace; font-size: 12px; padding: 4px;'  ><?php echo $this->_tpl_vars['currency']['sign']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
 </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br />
<em>Think
 Innovations
- Remote
Staff only issues 
electronic
 invoices.You will 
need to
 print this 
invoice if 
you
 require a 
paper
 invoice.</em>
<br /><br />
For Invoices in Australian Dollar a Merchant facility fees apply for the following credit card holders:<br /><br />
AMEX : 2%  <br />
Visa / MasterCard : 1% <br /><br />
    
For Invoices in Pounds and USD, 2% Merchant facility fees apply for all credit card payments. <br /><br />
Note that we prefer payments made via bank transfer or direct debit.<br />
</td></tr>

</table>