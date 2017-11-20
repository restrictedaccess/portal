//2008-09-25 Lawrence Sunglao <locsunglao@yahoo.com>
//  Removed the option for the subcon to create their invoice
//  delete invoice/subconDeleteInvoice.php
//  delete invoice/subconCreateInvoice.php
//  delete invoice/subconGetNewInvoiceForm.php
var INVOICE_PATH = 'invoice/agents/';
var invoice_list = null; //the whole invoice list div as an object

connect(window, 'onload', OnLoadWindow);

function OnLoadWindow(e) {
    replaceChildNodes('invoice_pane', DIV({'id':'div_invoice'}, [
        DIV({'id': 'invoice_functions'}, [
            BUTTON({'id' : 'btn_refresh_list'}, 'Refresh List'),
        ]),
        DIV({'id': 'invoice_bottom'}, [
            DIV({'id': 'invoice_listings'}, null),
            DIV({'id': 'invoice_right_pane'}, 'Select an Invoice on the left to view its details.'),
            DIV({'class': 'clear'}, null),
        ]),
        DIV({'class': 'clear'}, null),
    ]));

    this.OnClickRefreshList = function(e) {
        replaceChildNodes('invoice_listings', 'Loading...');
        invoice_list.GetInvoiceList();
        replaceChildNodes('invoice_right_pane', 'Select an Invoice on the left to view its details.');
    }

    invoice_list = new ClassInvoiceList('invoice_listings');
    invoice_list.GetInvoiceList();
    connect('btn_refresh_list', 'onclick', this.OnClickRefreshList);
}

function ClassInvoiceList(id) {
    this.RemoveAllHighlightedInvoice = function() {
        var divs = getElementsByTagAndClassName('div', 'invoice_list', 'invoice_listings'); 
        for (var div in divs) {
            removeElementClass(divs[div], 'invoice_list_highlighted');
        }
    }

    this.OnClickInvoiceList = function(e) {
        this.RemoveAllHighlightedInvoice();
        addElementClass(e.src(), 'invoice_list_highlighted');
        var invoice_id = getNodeAttribute(e.src(), 'invoice_id');
        invoice_details = new ClassInvoiceDetails('invoice_right_pane', invoice_id);
    }

    this.OnSuccesGetInvoiceList = function(e) {
        $(id).innerHTML = e.responseText;
        var divs = getElementsByTagAndClassName('div', 'invoice_list', 'invoice_listings'); 
        for (var div in divs) {
            var invoice_div_list = divs[div];
            connect(invoice_div_list, 'onclick', this.OnClickInvoiceList);
            var invoice_id = getNodeAttribute(invoice_div_list, 'invoice_id');
            if (this.highlighted_invoice_id == invoice_id) {
                addElementClass(invoice_div_list, 'invoice_list_highlighted');
            }
        }
    }

    this.OnFailGetInvoiceList = function(e) {
        alert('Failed to retrieve invoice list.\nPlease try again later.');
        replaceChildNodes(id, null)
    }

    this.GetInvoiceList = function(highlighted_invoice_id) {
        this.highlighted_invoice_id = highlighted_invoice_id;
        d_invoice_list = doSimpleXMLHttpRequest(INVOICE_PATH + 'affGetInvoiceList.php');
        d_invoice_list.addCallbacks(this.OnSuccesGetInvoiceList, this.OnFailGetInvoiceList);
    }

    bindMethods(this);
}


function ClassInvoiceDetails(id, invoice_id) {
    this.id = id;
    this.invoice_id = invoice_id;
    bindMethods(this);
    this.GetDetails();
}

ClassInvoiceDetails.prototype.GetDetails = function() {
    replaceChildNodes(this.id, 'Loading...');
    this.d_invoice_details = doSimpleXMLHttpRequest(INVOICE_PATH + 'affGetInvoiceDetails.php', {'invoice_id': this.invoice_id});
    this.d_invoice_details.addCallbacks(this.OnSuccessGetInvoiceDetails, this.OnFailGetInvoiceDetails);
}

ClassInvoiceDetails.prototype.OnSuccessGetInvoiceDetails = function(e) {
    $(this.id).innerHTML = e.responseText;
    this.invoice_id = getNodeAttribute('invoice_id', 'invoice_id');
    
    //assign signals
    if ($('btn_add_comment') != null) {
        connect('btn_add_comment', 'onclick', this.OnClickAddComment);
    }

    if ($('btn_full_payment_details') != null) {
        connect('btn_full_payment_details', 'onclick', this.OnClickFullPaymentDetails);
    }

    connect('btn_cancel_edit_payment_details', 'onclick', this.OnClickCancelEditPaymentDetails);
    connect('btn_save_payment_details', 'onclick', this.OnClickSaveEditPaymentDetails);
}

ClassInvoiceDetails.prototype.OnClickFullPaymentDetails = function(e) {
    $('btn_full_payment_details').disabled = true;
    this.payment_details = $('text_area_payment_details').value;
    removeNodeAttribute('text_area_payment_details', 'readOnly');
    hideElement('full_payment_details');
    appear('full_payment_details');
    appear('full_payment_details_buttons');
}

ClassInvoiceDetails.prototype.OnClickSaveEditPaymentDetails = function(e) {
    var payment_details = strip($('text_area_payment_details').value);
    if (payment_details == '') {
        alert('Blank payment details.\nPlease input your payment details.');
        return;
    }
    $('btn_save_payment_details').disabled = true;
    $('btn_cancel_edit_payment_details').disabled = true;
    var query = queryString({'invoice_id': this.invoice_id, 'payment_details': payment_details});
    this.d_add_comment = doXHR(INVOICE_PATH + 'affUpdatePaymentDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
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

ClassInvoiceDetails.prototype.OnClickAddComment = function(e) {
    var comment = strip($('input_comment').value);
    if (comment == '') {
        alert('No comment to submit');
        return;
    }

    var query = queryString({'comment': comment, 'invoice_id': this.invoice_id});
    this.d_add_comment = doXHR(INVOICE_PATH + 'affAddComment.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    this.d_add_comment.addCallbacks(this.OnSuccessPostComment, this.OnFailPostComment);
    $('btn_add_comment').disabled = true;
}

ClassInvoiceDetails.prototype.OnSuccessPostComment = function(e) {
    $('btn_add_comment').disabled = false;
    $('input_comment').value = '';
    $('comment_div_container').innerHTML = e.responseText;
	//alert("hhere");
}

ClassInvoiceDetails.prototype.OnFailPostComment = function(e) {
    alert("Failed to post comment.\nPlease try again later");
    $('btn_add_comment').disabled = false;
}


ClassInvoiceDetails.prototype.OnFailGetInvoiceDetails = function(e) {
    replaceChildNodes(this.id, 'Failed loading details.');
    alert('Failed to get invoice details.\nPlease try again later.');
}
