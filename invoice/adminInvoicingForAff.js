//2008-09-25 Lawrence Sunglao <locsunglao@yahoo.com>
//grabbed payment details from the personal table
var INVOICE_PATH = 'invoice/agents/';
connect(window, 'onload', OnLoadWindow);
var div_invoice_list = '';  //make it globally accessible. IE Snag!

function OnLoadWindow(e) {
    replaceChildNodes('invoice_pane', [
        DIV({'id': 'div_invoice_main_functions'}, null),
        DIV({'id': 'div_invoice_list'}, null),
        DIV({'id': 'invoice_right_pane'}, [
            DIV({}, 'Click the "Create Blank Invoice" to generate a blank invoice.'),
            DIV({}, 'Click the "Create Invoice From Time Records" to generate invoice from subcontractors time records.'),
            DIV({}, 'Select an Invoice on the left to view its details.')
        ]),
        DIV({'class': 'clear'}, null)
    ]);

    div_main_functions = new ClassInvoiceMainFunctions('div_invoice_main_functions');
    div_invoice_list = new ClassInvoiceList('div_invoice_list');
}


function ClassInvoiceMainFunctions(id) {
    this.id = id;

    replaceChildNodes(this.id, [
		DIV({'class' : 'affiliate_invoicing'}, 'Affiliate Invoicing'),
        BUTTON({'id': this.id + 'create_blank'}, 'Create Blank Invoice'),
        BUTTON({'id': this.id + 'create_from_time_records'}, 'Create Invoice From Time Records'),
    ]);

    bindMethods(this);
    connect(this.id + 'create_blank', 'onclick', OnClickCreateBlankInvoice)
    connect(this.id + 'create_from_time_records', 'onclick', OnClickCreateFromTimeRecord)

    function OnClickCreateFromTimeRecord(e) {
        replaceChildNodes('invoice_right_pane', 'Loading...');
        d_new_invoice = doSimpleXMLHttpRequest(INVOICE_PATH + 'adminAffGetNewInvoiceForm.php', {'mode': 'time_records'});
        d_new_invoice.addCallbacks(OnSuccessGetNewInvoiceFormBlank, OnFailGetNewInvoiceFormBlank);
    }

    function OnClickCreateBlankInvoice(e) {
        replaceChildNodes('invoice_right_pane', 'Loading...');
        d_new_invoice = doSimpleXMLHttpRequest(INVOICE_PATH + 'adminAffGetNewInvoiceForm.php', {'mode': 'blank'});
        d_new_invoice.addCallbacks(OnSuccessGetNewInvoiceFormBlank, OnFailGetNewInvoiceFormBlank);
    }

    function OnFailGetNewInvoiceFormBlank(e) {
        alert('Failed to retrieve form.\nPlease try again later.');
    }

    function OnClickCancelCreateInvoice(e) {
        replaceChildNodes('invoice_right_pane', [
            DIV({}, 'Click the "Create Blank Invoice" to generate a blank invoice.'),
            DIV({}, 'Click the "Create Invoice From Time Records" to generate invoice from subcontractors time records.'),
            DIV({}, 'Select an Invoice on the left to view its details.')
        ]);
    }

    function OnChangeSubcontractor(e) {
        var x = e.src().selectedIndex;
        $('text_area_payment_details').value = getNodeAttribute(e.src().options[x], 'payment_details');
        if ($('cal_start_date') != null) {
            $('description').value = getNodeAttribute(e.src().options[x], 'description');
        }
        else {
            $('description').value = getNodeAttribute(e.src().options[x], 'description_for_blank');
        }
    }

    function OnSuccessGetNewInvoiceFormBlank(e) {
        $('invoice_right_pane').innerHTML = e.responseText;

        //setup calendars
        if ($('cal_start_date') != null) {
            Calendar.setup( {
                  inputField  : "start_date",         // ID of the input field
                  ifFormat    : "%Y-%m-%d",    // the date format
                  button      : "cal_start_date"       // ID of the button
            });
        }

        if ($('cal_end_date') != null) {
            Calendar.setup( {
                  inputField  : "end_date",         // ID of the input field
                  ifFormat    : "%Y-%m-%d",    // the date format
                  button      : "cal_end_date"       // ID of the button
            });
        }

        if ($('cal_current_date') != null) {
            Calendar.setup( {
                  inputField  : "invoice_date",         // ID of the input field
                  ifFormat    : "%Y-%m-%d",    // the date format
                  button      : "cal_current_date"       // ID of the button
            });
        }

        if ($('btn_create_blank_invoice') != null) {
            connect('btn_create_blank_invoice', 'onclick', OnClickSubmitBlankInvoice);
        }

        if ($('btn_create_from_time_record') != null) {
            connect('btn_create_from_time_record', 'onclick', OnClickSubmitCreateInvoice);
        }

        if ($('btn_cancel_from_time_record') != null) {
            connect('btn_cancel_from_time_record', 'onclick', OnClickCancelCreateInvoice);
        }

        if ($('select_agent') != null) {
            connect('select_agent', 'onchange', OnChangeSubcontractor);
        }
    }

    function OnClickSubmitCreateInvoice(e) {
        var start_date = $('start_date').value;
        var end_date = $('end_date').value;
        var agentid = $('select_agent').value;
        var invoice_date = $('invoice_date').value;
        var description = $('description').value;
        var payment_details = $('text_area_payment_details').value;
        var mode = 'time_records';
        var query = queryString({'start_date': start_date, 'end_date': end_date, 'invoice_date': invoice_date, 'agentid': agentid, 'description': description, 'payment_details': payment_details, 'mode': mode});
        d_submit_blank = doXHR(INVOICE_PATH + 'adminCreateInvoice.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
        d_submit_blank.addCallbacks(OnSuccessCreateInvoice, OnFailCreateInvoice);
    }

    function OnClickSubmitBlankInvoice(e) {
        var invoice_date = $('invoice_date').value;
        var agentid = $('select_agent').value;
        var description = $('description').value;
        var payment_details = $('text_area_payment_details').value;
        var mode = 'blank';
        var query = queryString({'invoice_date': invoice_date, 'agentid': agentid, 'description': description, 'payment_details': payment_details, 'mode': mode});
        d_submit_blank = doXHR(INVOICE_PATH + 'adminCreateInvoice.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
        d_submit_blank.addCallbacks(OnSuccessCreateInvoice, OnFailCreateInvoice);
    }

    function OnSuccessCreateInvoice(e) {
        $('invoice_right_pane').innerHTML = e.responseText;
        var invoice_id = getNodeAttribute('invoice_id', 'invoice_id');
        invoice_details = new ClassInvoiceDetails('invoice_right_pane', invoice_id);
        div_invoice_list.GetInvoiceList(invoice_id);
	    
    }

    function OnFailCreateInvoice(e) {
        alert('Failed to create invoice.\nPlease try again later.');
    }
}


///////

function ClassInvoiceList(id) {
    this.id = id;
    var start_date_ref = getNodeAttribute('start_date_ref', 'value');
    var end_date_ref = getNodeAttribute('end_date_ref', 'value');
    replaceChildNodes(this.id, [
        DIV({'id': 'date-filter'}, [
            DIV({'class': 'admin-invoice-list-date'}, [
                DIV({'class': 'admin-invoice-label-date'}, LABEL({'for': this.id + 'start_date'}, 'Start Date : ')),
                INPUT({'id': this.id + 'start_date', 'class': 'input_date', 'value' : start_date_ref}, null),
                IMG({'id': this.id + 'cal_start_date', 'src':'images/calendar_ico.png', 'class': 'cal_img', 'title':'Date Selector'}, null),
            ]),
            DIV({'class': 'clear'}, null),
            DIV({'class': 'admin-invoice-list-date'}, [
                DIV({'class': 'admin-invoice-label-date'}, LABEL({'for': this.id + 'end_date'}, 'End Date : ')),
                INPUT({'id': this.id + 'end_date', 'class': 'input_date', 'value' : end_date_ref}, null),
                IMG({'id': this.id + 'cal_end_date', 'src':'images/calendar_ico.png', 'class': 'cal_img', 'title':'Date Selector'}, null),
            ]),
            DIV({'class': 'clear'}, null),
            DIV({'class': 'spacer'}, null),
            BUTTON({'id': this.id + 'btn_refresh_list'}, "Refresh List"),
			BUTTON({'id': this.id + 'btn_export'}, "Export to Excel"),
            DIV({'class': 'clear'}, null),
        ]),
        DIV({'id': this.id + 'all_invoice_list'}, null),
    ]);


    Calendar.setup( {
          inputField  : this.id + "start_date",         // ID of the input field
          ifFormat    : "%Y-%m-%d",    // the date format
          button      : this.id + "cal_start_date"       // ID of the button
    });
    Calendar.setup( {
          inputField  : this.id + "end_date",         // ID of the input field
          ifFormat    : "%Y-%m-%d",    // the date format
          button      : this.id + "cal_end_date"       // ID of the button
    });

    bindMethods(this);
    this.GetInvoiceList();
    connect(this.id + 'btn_refresh_list', 'onclick', this.OnClickRefreshList);
	connect(this.id + 'btn_export', 'onclick', this.OnClickExport);
}
ClassInvoiceList.prototype.OnClickExport = function(e) {
   if (confirm("Export to Excel this Current Month Payroll ?")) {
    var start_date = $(this.id + 'start_date').value;
    var end_date = $(this.id + 'end_date').value;
	 location.href ="current_month_payroll_export_excel.php?start_date="+start_date+"&end_date="+end_date;
	 //return true;
   }
   else
   {
	   	return false;
   }
}

ClassInvoiceList.prototype.OnClickRefreshList = function(e) {
    this.GetInvoiceList();
    replaceChildNodes('invoice_right_pane', [
            DIV({}, 'Click the "Create Blank Invoice" to generate a blank invoice.'),
            DIV({}, 'Click the "Create Invoice From Time Records" to generate invoice from subcontractors time records.'),
            DIV({}, 'Select an Invoice on the left to view its details.')
        ]);
}

ClassInvoiceList.prototype.GetInvoiceList = function(highlighted_invoice_id) {
    this.highlighted_invoice_id = highlighted_invoice_id;
    var start_date = $(this.id + 'start_date').value;
    var end_date = $(this.id + 'end_date').value;
    this.d_invoice_list = doSimpleXMLHttpRequest(INVOICE_PATH + 'adminGetInvoiceList.php', {'start_date': start_date, 'end_date': end_date});
    this.d_invoice_list.addCallbacks(this.OnSuccesGetInvoiceList, this.OnFailGetInvoiceList);
}


ClassInvoiceList.prototype.OnSuccesGetInvoiceList = function(e) {
    $(this.id + 'all_invoice_list').innerHTML = e.responseText;
    //assign onclicks
    var items = getElementsByTagAndClassName('div', 'invoice_list', 'invoice_listings');
    for (var item in items){
        connect(items[item], 'onclick', this.OnClickItem);
    }

    if (this.highlighted_invoice_id) {
        var items = getElementsByTagAndClassName('div', 'invoice_list', 'invoice_listings');
        for (var item in items) {
            var div = items[item];
            var current_invoice_id = getNodeAttribute(div, 'invoice_id');
            removeElementClass(div, 'invoice_list_highlighted');
            if (current_invoice_id == this.highlighted_invoice_id) {
                addElementClass(div, 'invoice_list_highlighted');
            }
        }
    }
}

ClassInvoiceList.prototype.OnClickItem = function(e) {
    if ($('form_add_edit') != null) {
        fade('form_add_edit');
    }
    var items = getElementsByTagAndClassName('div', 'invoice_list', 'invoice_listings');
    for (var item in items) {
        removeElementClass(items[item], 'invoice_list_highlighted');
    }
    addElementClass(e.src(), 'invoice_list_highlighted');
    var invoice_id = getNodeAttribute(e.src(), 'invoice_id');
    invoice_details = new ClassInvoiceDetails('invoice_right_pane', invoice_id);
}


ClassInvoiceList.prototype.OnFailGetInvoiceList = function(e) {
    alert('Failed to get invoice list.\nPlease try again later.');
}


function ClassInvoiceDetails(id, invoice_id) {
    this.id = id;
    this.invoice_id = invoice_id;
    bindMethods(this);
    this.GetDetails();
}

ClassInvoiceDetails.prototype.GetDetails = function() {
    replaceChildNodes(this.id, 'Loading...');
    this.d_invoice_details = doSimpleXMLHttpRequest(INVOICE_PATH + 'adminGetInvoiceDetails.php', {'invoice_id': this.invoice_id});
    this.d_invoice_details.addCallbacks(this.OnSuccessGetInvoiceDetails, this.OnFailGetInvoiceDetails);
}

ClassInvoiceDetails.prototype.OnSuccessGetInvoiceDetails = function(e) {
    $(this.id).innerHTML = e.responseText;
    this.invoice_id = getNodeAttribute('invoice_id', 'invoice_id');
    
    //assign signals
    if ($('btn_delete_invoice') != null) {
        connect('btn_delete_invoice', 'onclick', this.OnClickDeleteInvoice);
    }

    if ($('btn_add_item_to_invoice') != null) {
        connect('btn_add_item_to_invoice', 'onclick', this.OnClickAddItem);
    }

    if ($('btn_add_comment') != null) {
        connect('btn_add_comment', 'onclick', this.OnClickAddComment);
    }

    if ($('btn_approve_invoice') != null) {
        connect('btn_approve_invoice', 'onclick', this.OnClickApproveInvoice);
    }

    if ($('btn_paid_invoice') != null) {
        connect('btn_paid_invoice', 'onclick', this.OnClickPaidInvoice);
    }

    if ($('btn_full_payment_details') != null) {
        connect('btn_full_payment_details', 'onclick', this.OnClickFullPaymentDetails);
    }
	// Added by Norman  10/23/08
	 if ($('btn_save_conversion') != null) {
        connect('btn_save_conversion', 'onclick', this.OnClickSaveConversion);
    }
	//////
    this.ConnectEditDeleteSignal();
    connect('btn_cancel_item', 'onclick', this.OnClickCancelItem);
    connect('btn_save_item', 'onclick', this.OnClickSaveItem);
    connect('btn_cancel_edit_payment_details', 'onclick', this.OnClickCancelEditPaymentDetails);
    connect('btn_save_payment_details', 'onclick', this.OnClickSaveEditPaymentDetails);
}

// Added by Normaneil 10/23/2008
// OnClickSaveConversion
ClassInvoiceDetails.prototype.OnClickSaveConversion = function(e) {
    var converted_amount = ($('converted_amount').value);
	var input_currency = ($('input_currency').value);
	
    if (converted_amount == '') {
        alert('No Conversion Made !');
        return;
    }
	//alert(converted_amount +"\n"+input_currency);
	 var query = queryString({'converted_amount': converted_amount,'input_currency':input_currency ,'invoice_id': this.invoice_id});
this.d_add_conversion = doXHR(INVOICE_PATH + 'adminSaveConversion.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
 this.d_add_conversion.addCallbacks(this.OnSuccessSaveConversion, this.OnFailSaveConversion);
  $('btn_save_conversion').disabled = true;

}

ClassInvoiceDetails.prototype.OnSuccessSaveConversion = function(e) {
    $('btn_save_conversion').disabled = false;
    //alert("Conversion is successfully saved !");
	replaceChildNodes(this.id, 'Loading...');
    this.d_invoice_details = doSimpleXMLHttpRequest(INVOICE_PATH + 'adminGetInvoiceDetails.php', {'invoice_id': this.invoice_id});
    this.d_invoice_details.addCallbacks(this.OnSuccessGetInvoiceDetails, this.OnFailGetInvoiceDetails);
}

ClassInvoiceDetails.prototype.OnFailSaveConversion = function(e) {
    alert("Failed to save salary coversion.\nPlease try again later");
    $('btn_save_conversion').disabled = false;
}



//////////
ClassInvoiceDetails.prototype.OnClickFullPaymentDetails = function(e) {
    $('btn_full_payment_details').disabled = true;
    this.payment_details = $('text_area_payment_details').value;
    removeNodeAttribute('text_area_payment_details', 'readOnly');
    hideElement('full_payment_details');
    appear('full_payment_details');
    appear('full_payment_details_buttons');
}

ClassInvoiceDetails.prototype.OnClickSaveEditPaymentDetails = function(e) {
    $('btn_save_payment_details').disabled = true;
    $('btn_cancel_edit_payment_details').disabled = true;
    var payment_details = strip($('text_area_payment_details').value);
    var query = queryString({'invoice_id': this.invoice_id, 'payment_details': payment_details});
    this.d_add_comment = doXHR(INVOICE_PATH + 'adminUpdatePaymentDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    this.d_add_comment.addCallbacks(this.OnSuccessUpdatePaymentDetails, this.OnFailUpdatePaymentDetails);
}

ClassInvoiceDetails.prototype.OnSuccessUpdatePaymentDetails = function(e) {
    hideElement('full_payment_details');
    $('full_payment_details').innerHTML = e.responseText;
    appear('full_payment_details');
    $('btn_full_payment_details').disabled = false;
    $('btn_save_payment_details').disabled = false;
    $('btn_cancel_edit_payment_details').disabled = false;
    hideElement('full_payment_details_buttons');
}

ClassInvoiceDetails.prototype.OnFailUpdatePaymentDetails = function(e) {
    $('btn_save_payment_details').disabled = false;
    $('btn_cancel_edit_payment_details').disabled = false;
    alert('Failed to update payment details.\nPlease try again later.');

}

ClassInvoiceDetails.prototype.OnClickCancelEditPaymentDetails = function(e) {
    hideElement('full_payment_details');
    updateNodeAttributes('text_area_payment_details', {'readOnly': true});
    appear('full_payment_details');
    $('text_area_payment_details').value = this.payment_details;
    hideElement('full_payment_details_buttons');
    $('btn_full_payment_details').disabled = false;
}

ClassInvoiceDetails.prototype.OnClickPaidInvoice = function(e) {
    $('btn_paid_invoice').disabled = true;
    var query = queryString({'invoice_id': this.invoice_id});
    this.d_add_comment = doXHR(INVOICE_PATH + 'adminMoveInvoiceToPaid.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    this.d_add_comment.addCallbacks(this.OnSuccessMoveToPaid, this.OnFailMoveToPaid);
}

ClassInvoiceDetails.prototype.OnSuccessMoveToPaid = function(e) {
    $(this.id).innerHTML = e.responseText;
    var invoice_id = getNodeAttribute('invoice_id', 'invoice_id');
    div_invoice_list.GetInvoiceList(invoice_id);
}

ClassInvoiceDetails.prototype.OnFailMoveToPaid = function(e) {
    alert('Failed to move to paid.\nPlease try again later');
    $('btn_paid_invoice').disabled = false;
}

ClassInvoiceDetails.prototype.OnClickApproveInvoice = function(e) {
    $('btn_approve_invoice').disabled = true;
    var query = queryString({'invoice_id': this.invoice_id});
    this.d_add_comment = doXHR(INVOICE_PATH + 'adminMoveInvoiceToApproved.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    this.d_add_comment.addCallbacks(this.OnSuccessMoveToApproved, this.OnFailMoveToApproved);
}

ClassInvoiceDetails.prototype.OnSuccessMoveToApproved = function(e) {
    $(this.id).innerHTML = e.responseText;
    var invoice_id = getNodeAttribute('invoice_id', 'invoice_id');
    div_invoice_list.GetInvoiceList(invoice_id);
}

ClassInvoiceDetails.prototype.OnFailMoveToApproved = function(e) {
    alert('Failed to move to approve.\nPlease try again later');
    $('btn_approve_invoice').disabled = false;
}

ClassInvoiceDetails.prototype.ConnectEditDeleteSignal = function() {
    //loop over records for edit/delete function
    var edit_buttons = getElementsByTagAndClassName('button', 'btn_edit_invoice_detail');
    for (var btn in edit_buttons) {
        connect(edit_buttons[btn], 'onclick', this.OnClickEditItem);
    }

    var delete_buttons = getElementsByTagAndClassName('button', 'btn_delete_invoice_detail');
    for (var btn in delete_buttons) {
        connect(delete_buttons[btn], 'onclick', this.OnClickDeleteInvoiceDetail);
    }

}

ClassInvoiceDetails.prototype.OnClickAddComment = function(e) {
    var comment = strip($('input_comment').value);
    if (comment == '') {
        alert('No comment to submit');
        return;
    }

    var query = queryString({'comment': comment, 'invoice_id': this.invoice_id});
    this.d_add_comment = doXHR(INVOICE_PATH + 'adminAddComment.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    this.d_add_comment.addCallbacks(this.OnSuccessPostComment, this.OnFailPostComment);
    $('btn_add_comment').disabled = true;
}

ClassInvoiceDetails.prototype.OnSuccessPostComment = function(e) {
    $('btn_add_comment').disabled = false;
    $('input_comment').value = '';
    $('comment_div_container').innerHTML = e.responseText;
}

ClassInvoiceDetails.prototype.OnFailPostComment = function(e) {
    alert("Failed to post comment.\nPlease try again later");
    $('btn_add_comment').disabled = false;
}

ClassInvoiceDetails.prototype.OnClickDeleteInvoiceDetail = function(e) {
    var invoice_comment_id = getNodeAttribute(e.src(), 'invoice_comment_id');
    if (invoice_comment_id == null) {
        alert("Invalid Invoice comment id");
        return;
    }
    var confirm_delete = confirm("Are you sure you want to delete this Invoice item?");
    if (confirm_delete) {
        var query = queryString({'invoice_comment_id': invoice_comment_id, 'invoice_id': this.invoice_id});
        this.d_add_comment = doXHR(INVOICE_PATH + 'adminDeleteInvoiceItem.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
        this.d_add_comment.addCallbacks(this.OnSuccessModifyInvoiceDetail, this.OnFailDeleteInvoiceItem);
        
    }
}

ClassInvoiceDetails.prototype.OnFailDeleteInvoiceItem = function(e) {
    alert('Failed to delete item.\nPlease try again later');
}

ClassInvoiceDetails.prototype.OnClickEditItem = function(e) {
    var invoice_details_dimension = elementDimensions('invoice_details');
    var invoice_details_position = elementPosition('invoice_details');
    var description = getNodeAttribute(e.src(), 'description');
    var amount = getNodeAttribute(e.src(), 'amount');
    $('input_invoice_description').value = description;
    $('input_invoice_amt').value = amount;
    setElementDimensions('form_add_edit', invoice_details_dimension);
    setElementPosition('form_add_edit', invoice_details_position);
    replaceChildNodes('title_add_edit', 'Edit Item');
    this.mode_add_edit = 'edit';
    this.invoice_comment_id = getNodeAttribute(e.src(), 'invoice_comment_id');
    appear('form_add_edit');
}

ClassInvoiceDetails.prototype.OnClickDeleteInvoice = function(e) {
    var confirm_delete = confirm("Are you sure you want to delete this invoice?");
    if (confirm_delete) {
        this.d_confirm_delete_invoice = doSimpleXMLHttpRequest(INVOICE_PATH + 'adminDeleteInvoice.php', {'invoice_id': this.invoice_id});
        this.d_confirm_delete_invoice.addCallbacks(this.OnSuccessDeleteInvoice, this.OnFailDeleteInvoice);
    }
}

ClassInvoiceDetails.prototype.OnSuccessDeleteInvoice = function(e) {
    $(this.id).innerHTML = e.responseText;
    div_invoice_list.GetInvoiceList();
}

ClassInvoiceDetails.prototype.OnFailDeleteInvoice = function(e) {
    alert("Failed to delete invoice.\nPlease try again later.");
}

ClassInvoiceDetails.prototype.OnClickAddItem = function(e) {
    var invoice_details_dimension = elementDimensions('invoice_details');
    var invoice_details_position = elementPosition('invoice_details');
    $('input_invoice_description').value = '';
    $('input_invoice_amt').value = '';
    setElementDimensions('form_add_edit', invoice_details_dimension);
    setElementPosition('form_add_edit', invoice_details_position);
    replaceChildNodes('title_add_edit', 'Add Item');
    this.mode_add_edit = 'add';
    appear('form_add_edit');
}

ClassInvoiceDetails.prototype.OnClickCancelItem = function(e) {
    fade('form_add_edit');
}

ClassInvoiceDetails.prototype.OnClickSaveItem = function(e) {
    var description = strip($('input_invoice_description').value);
    var amount = strip($('input_invoice_amt').value);
    if (description == '') {
        alert('Please enter a description.');
        return;
    }
    if (amount == '') {
        alert('Please enter an amount.');
        return;
    }
    var invoice_comment_id = '';
    if (this.mode_add_edit == 'edit') {
        invoice_comment_id = this.invoice_comment_id;
    }
    var query = queryString({'description': description, 'invoice_id': this.invoice_id, 'mode': this.mode_add_edit, 'amount': amount, 'invoice_comment_id': invoice_comment_id});
    this.d_add_edit_invoice_detail = doXHR(INVOICE_PATH + 'adminAddEditInvoiceDetail.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    this.d_add_edit_invoice_detail.addCallbacks(this.OnSuccessModifyInvoiceDetail, this.OnFailAddEditInvoiceDetail);
    $('btn_save_item').disabled = true;
	
}

ClassInvoiceDetails.prototype.OnSuccessModifyInvoiceDetail = function(e) {
   
   	hideElement('invoice_details');
    $('invoice_details').innerHTML = e.responseText;
    $('btn_save_item').disabled = false;
    fade('form_add_edit');
    appear('invoice_details');
    this.ConnectEditDeleteSignal();
    var total_amount = getNodeAttribute("total_invoice_amount", "amount");
	var total_converted_amount = getNodeAttribute("total_converted_amount", "amount");
	//replaceChildNodes("invoice_total_amount", total_amount);
	//
	replaceChildNodes("invoice_sub_total", total_amount);
	replaceChildNodes("converted_amount", total_converted_amount);
	//converted_amount  total_converted_amount
	
	
}

ClassInvoiceDetails.prototype.OnFailAddEditInvoiceDetail = function(e) {
    alert('Failed to save invoice item.\nPlease try again later.');
    $('btn_save_item').disabled = false;
}

ClassInvoiceDetails.prototype.OnFailGetInvoiceDetails = function(e) {
    replaceChildNodes(this.id, 'Failed loading details.');
    alert('Failed to get invoice details.\nPlease try again later.');
}
