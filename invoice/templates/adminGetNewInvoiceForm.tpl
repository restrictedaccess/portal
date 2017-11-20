{*  2010-03-03  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
    -   removed "Full Payment Details"
*}
<div id="formCreateFromTimeRecord">
    {if $mode eq 'blank'}
        <div class="invoice_title">Create Blank Invoice</div>
    {else}
        <div class="invoice_title">Create Invoice From Time Records</div>
    {/if}
    <div>
        {if $mode eq 'blank'}
            <div>
                <label for="invoice_date">Invoice Date (YYYY-MM-DD) : </label>
                <input id="invoice_date" class="input_date" value="{$now_str}"/>
                <img id="cal_current_date" src="images/calendar_ico.png" class="cal_img" title="Date Selector"/>
            </div>
        {else}
            <div class="div_date">
                <input id="start_date" class="input_date" value="{$date_start}"/>
                <img id="cal_start_date" src="images/calendar_ico.png" class="cal_img" title="Date Selector"/>
                <div>
                    <label for="start_date">Start Date : (YYYY-MM-DD)</label>
                </div>
            </div>
            <div class="div_date">
                <input id="end_date" class="input_date" value="{$date_end}"/>
                <img id="cal_end_date" src="images/calendar_ico.png" class="cal_img" title="Date Selector"/>
                <div>
                    <label for="end_date">End Date : (YYYY-MM-DD)</label>
                </div>
            </div>
            <div class="div_date">
                <input id="invoice_date" class="input_date" value="{$now_str}"/>
                <img id="cal_current_date" src="images/calendar_ico.png" class="cal_img" title="Date Selector"/>
                <div>
                    <label for="invoice_date">Invoice Date : (YYYY-MM-DD)</label>
                </div>
            </div>
        {/if}
        <div class="clear"></div>
        <div class="spacer"></div>
        <div>
            <label for='select_subcontractor'>Select Subcontractor :</label>
            <select id='select_subcontractor' name='select_subcontractor'>
                {section name=j loop=$subcontractor_ids}
                {strip}
                    <option value="{$subcontractor_ids[j]}" label="{$subcontractor_names[j]|escape}" payment_details="{$subcontractor_payment_details[j]|escape}" description="{$subcontractor_fnames[j]|escape} Payroll {$current_month}" description_for_blank="{$subcontractor_fnames[j]|escape} Blank Invoice">
                        {$subcontractor_names[j]|escape}
                    </option>
                {/strip}
                {/section}
            </select>
        </div>
        <div class="spacer"></div>
        <div>
            <label for="description">Description : </label>
            {if $mode eq 'blank'}
                <input id="description" style="width: 280px;" value="Type your invoice description here."/>
            {else}
                <input id="description" style="width: 280px;" value="Payroll {$current_month}"/>
            {/if}
        </div>
        <div class="clear"></div>
        <div style="text-align: center;">
            {if $mode eq 'blank'}
                <button id="btn_create_blank_invoice">Create</button>
            {else}
                <button id="btn_create_from_time_record">Create</button>
            {/if}
            <button id="btn_cancel_from_time_record">Cancel</button>
        </div>
        <div class="clear"/></div>
</div>
<div class="clear"/></div>
