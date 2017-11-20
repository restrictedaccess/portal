<div id="formCreateFromTimeRecord">
    <div class="invoice_title">Create Invoice From Time Records</div>
    <div>
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
        <div class="clear"></div>
        <div class="spacer"></div>
        <div>
            <label for="description">Description : </label>
            <input id="description" style="width: 280px;" value="Payroll {$current_month}"/>
        </div>
        <div class="clear"></div>
        <div><label for="text_area_payment_details">Full payment details :</label></div>
        <div id="full_payment_details">
            <textarea id="text_area_payment_details">{$payment_details|escape}</textarea>
        </div>
        <div class="clear"></div>
        <div style="text-align: center; padding-top: 8px;">
            <button id="btn_create_from_time_record_post">Create</button>
            <button id="btn_cancel_from_time_record_post">Cancel</button>
        </div>
        <div class="clear"/></div>
</div>
<div class="clear"/></div>
