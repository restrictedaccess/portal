From : <input type="text" name="from" id="from_str" class="text" style=" width:72px;" value="{$start_date_ref}" readonly  > <img align="absmiddle" src="./images/calendar_ico.png"   id="bd_str" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />

To : <input type="text" name="to" id="to_str" class="text" style=" width:72px;" value="{$end_date_ref}" readonly  > <img align="absmiddle" src="./images/calendar_ico.png"   id="bd2_str" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />


<input type="button" value="Go" onclick="AccountRenderInvoices()" id="go"  />
<div id="invoice_result"></div>
