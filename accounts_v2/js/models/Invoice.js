//define Invoice Class
function Invoice() {
	this.items = [];
	//default Invoice
	for (var i = 0; i < 5; i++) {
		this.items.push(this.getBlankItem(i + 1));
	}
	this.due_date = null;
	this.invoice_date = new Date();
	this.client = null;
	this.tax_invoice_no = "";
	this.invoice_type = {
		value : "regular",
		label : "Regular Invoicing"
	};
	this.original_items = [];
	this.history = [];
}

function InvoiceItem(i) {
	this.item_no = i;
	this.description = "";
	this.item_type = "";
	this.selected_date = null;
	this.commission_id = null;
	this.quantity = 1;
	this.unit_price = 0;
	this.subcontractors_id = false;
}

function History(){
	this.timestamp = null;
	this.changes = "";
	this.by = "";
}

Invoice.prototype.copyItems = function(){
	this.original_items = [];
	for(var i=0;i<this.items.length;i++){
		var cloned = jQuery.extend(true, {}, this.items[i]);
		console.log(this.items[i].selected_date);
		if (typeof this.items[i].selected_date!="undefined"){
			cloned.selected_date = {
				startDate : moment(this.items[i].selected_date.startDate).clone().toDate(),
				endDate : moment(this.items[i].selected_date.endDate).clone().toDate()
			}
		}
		this.original_items.push(cloned);		
	}
	
	

};

Invoice.prototype.addHistory = function(history){
	this.history.push(history);
};

InvoiceItem.prototype.clone = function() {
	var item = new InvoiceItem();
	item.item_no = this.item_no;
	item.description = this.description;
	item.item_type = this.item_type;
	item.selected_date = jQuery.extend(true, {}, this.selected_date);
	item.commission_id = this.commission_id;
	item.quantity = Math.round(this.quantity * 100)/100;
	item.unit_price = Math.round(this.unit_price * 100)/100;
	item.subcontractors_id = this.subcontractors_id;
	
	return item;
};

InvoiceItem.prototype.getAmount = function() {
	return this.quantity * this.unit_price;
};

InvoiceItem.prototype.toHistory = function(){

	var history = "Item No. "+this.item_no+"<br/><br/>";
	history+= "Description from None to "+this.description+"<br/>";
	history+="Date from None to "+this.selected_date.startDate+" - "+this.selected_date.endDate+"<br/>";
	history+= "Quantity from None to "+this.quantity+"<br/>";
	history+= "Unit Price from None to "+this.unit_price+"<br/>";
	history+= "Amount from None to "+this.getAmount()+"<br/>";
	return history;
};


InvoiceItem.prototype.toJSON = function(){
	var output = {
		item_id:this.item_no,
		description:this.description,
		amount:this.getAmount(),
		unit_price:this.unit_price,
		qty:this.quantity,
		subcontractors_id:this.subcontractors_id,
		item_type:this.item_type,
		commission_id:this.commission_id
	};
	
	if (this.selected_date!=null){
		output.start_date = this.selected_date.startDate;
		output.end_date = this.selected_date.endDate;	
	}

	return output;
};

Invoice.prototype.getInvoiceTypes = function() {
	var unique_items = [];
	angular.forEach(this.items, function(item) {
		if (item.item_type == "") {
			return true;
		}
		if (unique_items.indexOf(item.item_type) === -1) {
			unique_items.push(item.item_type);
		}
	});
	return unique_items;
};


InvoiceItem.prototype.fresh = function() {
	return jQuery.trim(this.description) == "" && this.item_type == "" && this.selected_date == null && this.commission_id == null && this.quantity == 1;
};

Invoice.prototype.getBlankItem = function(i) {

	var me = this;

	InvoiceItem.prototype.remove = function() {
		var self = this;
		var new_items = [];
		var i = 1;
		angular.forEach(me.items, function(item) {
			if (self.item_no != item.item_no) {
				item.item_no = i;
				new_items.push(item);
				i++;
			}
		});
		me.items = new_items;
		
		var new_history = new History();
		new_history.timestamp = new Date();
		new_history.timestamp_unix = moment(new_history.timestamp).unix();
		new_history.changes = "Removed "+self.toHistory();
		new_history.by = jQuery("#ADMIN_NAME").val() + " :" + jQuery("#ADMIN_ID").val();
		me.addHistory(new_history);
	};

	return new InvoiceItem(i);
};

Invoice.prototype.getSubtotal = function() {
	var me = this;
	var total = 0;
	angular.forEach(me.items, function(item) {
		total += item.getAmount();
	});
	return total;
};

/**
 * Get the GST of the invoice instance
 */
Invoice.prototype.getGST = function() {
	
	if (this.client != null) {
		//if currency is AUD
		if (this.client.apply_gst == "Y") {
			return this.getSubtotal() * .1;
		} else {
			return 0;
		}
	} else {
		return 0;
	}

};
/**
 * Get the total of the invoice instance
 */
Invoice.prototype.getTotal = function() {
	return this.getSubtotal() + this.getGST();
};

Invoice.prototype.addBlankItem = function() {
	this.items.push(this.getBlankItem(this.items.length + 1));
};

Invoice.prototype.addItem = function(new_item) {
	//check existing items, swap fresh items with new items if available
	var hasFresh = false;

	var new_items = [];

	for (var i = 0; i < this.items.length; i++) {
		var item = this.items[i];
		if (item.fresh()) {
			hasFresh = true;
			new_item.item_no = i + 1;
			new_items.push(new_item);
			break;
		} else {
			new_items.push(item.clone());
		}
	}
	if (!hasFresh) {
		new_item.item_no = this.items.length + 1;
		new_items.push(new_item);
	}
	this.items = new_items;
};
Invoice.prototype.toJSON = function(){
	var output = {};
	output.added_on = moment(this.invoice_date).toDate();
	output.added_on_unix = moment(this.invoice_date).unix();
	output.disable_auto_follow_up = "N";
	
	output.apply_gst = this.client.apply_gst;
	output.order_id = this.tax_invoice_no;
	output.client_email = this.client.email;	
	output.client_fname = this.client.fname;
	output.client_lname = this.client.lname;
	output.type = "order";
	output.payment_advise = false;
	output.mongo_synced = true;
	output.client_id = this.client.client_id;
	if (this.due_date!=null){
		output.pay_before_date = moment(this.due_date).toDate();
		output.pay_before_date_unix = moment(this.due_date).unix();		
	}else{
		throw new Error("Due Date is required");
	}
	output.sub_total = this.getSubtotal();
	output.gst_amount = this.getGST();
	output.total_amount = this.getTotal();
	output.currency = this.client.currency;
	output.added_by = jQuery("#ADMIN_NAME").val()+" :"+jQuery("#ADMIN_ID").val();
	output.invoice_setup = "margin";
	output.disable_auto_follow_up = "N";
	output.items = [];
	output.status = "new";
	for(var i=0;i<this.items.length;i++){
		output.items.push(this.items[i].toJSON());
	}
	output.client_names = [this.client.fname.toLowerCase(), this.client.lname.toLowerCase()];
	output.history = this.history;
	
	return output;
};
