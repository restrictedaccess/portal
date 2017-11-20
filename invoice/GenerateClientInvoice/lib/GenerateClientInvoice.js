/* start module: GenerateClientInvoice */
var GenerateClientInvoice = $pyjs.loaded_modules["GenerateClientInvoice"] = function (__mod_name__) {
if(GenerateClientInvoice.__was_initialized__) return GenerateClientInvoice;
GenerateClientInvoice.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'GenerateClientInvoice';
var __name__ = GenerateClientInvoice.__name__ = __mod_name__;
pyjslib.__import__(['pyjd'], 'pyjd', 'GenerateClientInvoice');
GenerateClientInvoice.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'GenerateClientInvoice');
GenerateClientInvoice.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'GenerateClientInvoice');
GenerateClientInvoice.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'GenerateClientInvoice');
GenerateClientInvoice.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'GenerateClientInvoice');
GenerateClientInvoice.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'GenerateClientInvoice');
GenerateClientInvoice.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'GenerateClientInvoice');
GenerateClientInvoice.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'GenerateClientInvoice');
GenerateClientInvoice.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'GenerateClientInvoice');
GenerateClientInvoice.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'GenerateClientInvoice');
GenerateClientInvoice.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'GenerateClientInvoice');
GenerateClientInvoice.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'GenerateClientInvoice');
GenerateClientInvoice.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'GenerateClientInvoice');
GenerateClientInvoice.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'GenerateClientInvoice');
GenerateClientInvoice.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'GenerateClientInvoice');
GenerateClientInvoice.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox'], 'pyjamas.ui.DialogBox.DialogBox', 'GenerateClientInvoice');
GenerateClientInvoice.DialogBox = $pyjs.__modules__.pyjamas.ui.DialogBox.DialogBox;
pyjslib.__import__(['pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox'], 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'GenerateClientInvoice');
GenerateClientInvoice.PasswordTextBox = $pyjs.__modules__.pyjamas.ui.PasswordTextBox.PasswordTextBox;
pyjslib.__import__(['pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel'], 'pyjamas.ui.TabPanel.TabPanel', 'GenerateClientInvoice');
GenerateClientInvoice.TabPanel = $pyjs.__modules__.pyjamas.ui.TabPanel.TabPanel;
pyjslib.__import__(['pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel'], 'pyjamas.ui.CaptionPanel.CaptionPanel', 'GenerateClientInvoice');
GenerateClientInvoice.CaptionPanel = $pyjs.__modules__.pyjamas.ui.CaptionPanel.CaptionPanel;
pyjslib.__import__(['pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.Calendar', 'GenerateClientInvoice');
GenerateClientInvoice.Calendar = $pyjs.__modules__.pyjamas.ui.Calendar.Calendar;
pyjslib.__import__(['pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.DateField', 'GenerateClientInvoice');
GenerateClientInvoice.DateField = $pyjs.__modules__.pyjamas.ui.Calendar.DateField;
pyjslib.__import__(['pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.CalendarPopup', 'GenerateClientInvoice');
GenerateClientInvoice.CalendarPopup = $pyjs.__modules__.pyjamas.ui.Calendar.CalendarPopup;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'GenerateClientInvoice');
GenerateClientInvoice.log = $pyjs.__modules__.pyjamas.log;
pyjslib.__import__(['pygwt'], 'pygwt', 'GenerateClientInvoice');
GenerateClientInvoice.pygwt = $pyjs.__modules__.pygwt;
GenerateClientInvoice.CLIENT_PER_PAGE = 10;
GenerateClientInvoice.DialogAdminLogin = (function(){
	var cls_instance = pyjs__class_instance('DialogAdminLogin');
	var cls_definition = new Object();
	cls_definition.__md5__ = '19d6c313cc960d30609c75651e55d5a2';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var cell_format,label_email,grid,label_password;
		self.parent = parent;
		self.remote_service = GenerateClientInvoice.GenerateClientInvoiceService();
		grid = GenerateClientInvoice.Grid(3, 2);
		label_email = GenerateClientInvoice.Label(String('Email :'));
		label_password = GenerateClientInvoice.Label(String('Password :'));
		self.text_box_email = GenerateClientInvoice.TextBox();
		self.text_box_password = GenerateClientInvoice.PasswordTextBox();
		self.button_login = GenerateClientInvoice.Button(String('Login'), (typeof self.OnClickLogin == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickLogin'):self.OnClickLogin));
		self.button_close = GenerateClientInvoice.Button(String('Close'), (typeof self.RedirectToMainPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'RedirectToMainPage'):self.RedirectToMainPage));
		grid.setWidget(0, 0, label_email);
		grid.setWidget(0, 1, (typeof self.text_box_email == 'function' && self.__is_instance__?pyjslib.getattr(self, 'text_box_email'):self.text_box_email));
		grid.setWidget(1, 0, label_password);
		grid.setWidget(1, 1, (typeof self.text_box_password == 'function' && self.__is_instance__?pyjslib.getattr(self, 'text_box_password'):self.text_box_password));
		grid.setWidget(2, 0, (typeof self.button_login == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_login'):self.button_login));
		grid.setWidget(2, 1, (typeof self.button_close == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_close'):self.button_close));
		cell_format = grid.getCellFormatter();
		cell_format.setHorizontalAlignment(0, 0, String('right'));
		cell_format.setHorizontalAlignment(1, 0, String('right'));
		cell_format.setHorizontalAlignment(2, 0, String('right'));
		grid.setCellFormatter(cell_format);
		self.dialog_login = GenerateClientInvoice.DialogBox();
		self.dialog_login.setHTML(String('\x3Cb\x3EPlease Login\x3C/b\x3E'));
		self.dialog_login.setWidget(grid);
		self.dialog_login.hide();
		return null;
	}
	, 1, [null,null,'self', 'parent']);
	cls_definition.OnClickLogin = pyjs__bind_method(cls_instance, 'OnClickLogin', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var password,email;
		email = self.text_box_email.getText();
		password = self.text_box_password.getText();
		self.id_login = self.remote_service.login(email, password, self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RedirectToMainPage = pyjs__bind_method(cls_instance, 'RedirectToMainPage', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		GenerateClientInvoice.Window.setLocation(String('/portal/index.php'));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.Show = pyjs__bind_method(cls_instance, 'Show', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var width,height;
		width = GenerateClientInvoice.Window.getClientWidth();
		height = GenerateClientInvoice.Window.getClientHeight();
		self.dialog_login.show();
		self.dialog_login.setPopupPosition( (  ( width - 200 )  / 2 ) ,  (  ( height - 100 )  / 2 ) );
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.CloseDialog = pyjs__bind_method(cls_instance, 'CloseDialog', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.dialog_login.hide();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.CheckLogin = pyjs__bind_method(cls_instance, 'CheckLogin', function(response) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
		}

		if (pyjslib.bool(pyjslib.eq(response, String('OK')))) {
			self.CloseDialog();
		}
		else {
			GenerateClientInvoice.Window.alert(String('Invalid Login!'));
		}
		return null;
	}
	, 1, [null,null,'self', 'response']);
	cls_definition.onRemoteResponse = pyjs__bind_method(cls_instance, 'onRemoteResponse', function(response, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
			request_info = arguments[2];
		}

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_login == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_login'):self.id_login)))) {
			self.CheckLogin(response);
			self.parent.GetDraftedInvoices();
		}
		else {
			self.parent.status.setText(response);
		}
		return null;
	}
	, 1, [null,null,'self', 'response', 'request_info']);
	cls_definition.onRemoteError = pyjs__bind_method(cls_instance, 'onRemoteError', function(code, message, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			code = arguments[1];
			message = arguments[2];
			request_info = arguments[3];
		}

		self.parent.status.setText(pyjslib.sprintf(String('Server Error or Invalid Response: ERROR %d - %s'), new pyjslib.Tuple([code, message])));
		return null;
	}
	, 1, [null,null,'self', 'code', 'message', 'request_info']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
GenerateClientInvoice.DialogInvoiceGenerationProgress = (function(){
	var cls_instance = pyjs__class_instance('DialogInvoiceGenerationProgress');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'df568eef794f96c1d74458d0cf4dcd8a';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var scroll_panel,cell_formatter,grid_top,panel_button,main_panel;
		self.parent = parent;
		self.remote_service = GenerateClientInvoice.GenerateClientInvoiceService();
		self.dialog = GenerateClientInvoice.DialogBox();
		self.cal = GenerateClientInvoice.Calendar();
		self.df1 = pyjs_kwargs_call(GenerateClientInvoice, 'DateField', null, null, [{format:String('%Y-%m-%d')}]);
		self.df1.onTodayClicked();
		scroll_panel = pyjs_kwargs_call(GenerateClientInvoice, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('400px'), String('200px')])}]);
		self.vp = GenerateClientInvoice.VerticalPanel();
		self.label_status = GenerateClientInvoice.Label(String(''));
		grid_top = GenerateClientInvoice.Grid(1, 2);
		cell_formatter = grid_top.getCellFormatter();
		grid_top.setWidget(0, 0, GenerateClientInvoice.Label(String('Invoice Date:')));
		grid_top.setWidget(0, 1, (typeof self.df1 == 'function' && self.__is_instance__?pyjslib.getattr(self, 'df1'):self.df1));
		cell_formatter.setHorizontalAlignment(0, 0, String('right'));
		cell_formatter.setHorizontalAlignment(0, 1, String('right'));
		grid_top.setCellFormatter(cell_formatter);
		main_panel = GenerateClientInvoice.VerticalPanel();
		main_panel.setHorizontalAlignment(String('center'));
		main_panel.add(grid_top);
		main_panel.add(scroll_panel);
		scroll_panel.add((typeof self.vp == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp'):self.vp));
		main_panel.add((typeof self.label_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_status'):self.label_status));
		self.dialog.setHTML(String('\x3Cb\x3EGenerating Draft Tax Invoice...\x3C/b\x3E'));
		self.dialog.setWidget(main_panel);
		self.button_generate_invoice = GenerateClientInvoice.Button(String('Generate Tax Invoice'), (typeof self.ProcessInvoices == 'function' && self.__is_instance__?pyjslib.getattr(self, 'ProcessInvoices'):self.ProcessInvoices));
		self.button_close_dialog = GenerateClientInvoice.Button(String('Close'), (typeof self.CloseDialog == 'function' && self.__is_instance__?pyjslib.getattr(self, 'CloseDialog'):self.CloseDialog));
		panel_button = GenerateClientInvoice.HorizontalPanel();
		panel_button.add((typeof self.button_generate_invoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_generate_invoice'):self.button_generate_invoice));
		panel_button.add((typeof self.button_close_dialog == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_close_dialog'):self.button_close_dialog));
		main_panel.add(panel_button);
		self.Show();
		return null;
	}
	, 1, [null,null,'self', 'parent']);
	cls_definition.DisableWidgets = pyjs__bind_method(cls_instance, 'DisableWidgets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.df1.setVisible(false);
		self.button_generate_invoice.setEnabled(false);
		self.button_close_dialog.setEnabled(false);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.ProcessInvoices = pyjs__bind_method(cls_instance, 'ProcessInvoices', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.DisableWidgets();
		self.keys = self.parent.client.keys();
		self.key_counter = 0;
		self.CreateInvoice();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.CreateInvoice = pyjs__bind_method(cls_instance, 'CreateInvoice', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var checked,total_amount,invoice_details,invoice_date,client_staffs,key,leads_id,main_description,staffs,description;
		if (pyjslib.bool((pyjslib.cmp((typeof self.key_counter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'key_counter'):self.key_counter), pyjslib.len((typeof self.keys == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keys'):self.keys))) != -1))) {
			self.CloseDialog();
			GenerateClientInvoice.Window.alert(String('Finished Creating Draft Invoice.'));
			self.parent.GetDraftedInvoices();
			return null;
		}
		key = (typeof self.keys == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keys'):self.keys).__getitem__((typeof self.key_counter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'key_counter'):self.key_counter));
		client_staffs = (typeof self.parent.client == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'client'):self.parent.client).__getitem__(key);
		leads_id = client_staffs.__getitem__(0).__getitem__(String('leads_id'));
		checked = 0;
		total_amount = 0;
		invoice_details = new pyjslib.List([]);
		var __staffs = client_staffs.__iter__();
		try {
			while (true) {
				var staffs = __staffs.next();
				
				if (pyjslib.bool(staffs.__getitem__(String('check_box')).isChecked())) {
					checked += 1;
					total_amount += staffs.__getitem__(String('amount'));
					description = pyjslib.sprintf(String('%s - %shrs@%s/hr'), new pyjslib.Tuple([staffs.__getitem__(String('description')), staffs.__getitem__(String('invoiced_hrs')), staffs.__getitem__(String('client_hourly_rate'))]));
					invoice_details.append(new pyjslib.Dict([[String('id'), staffs.__getitem__(String('id'))], [String('start_date'), staffs.__getitem__(String('start_date'))], [String('start_date'), staffs.__getitem__(String('start_date'))], [String('end_date'), staffs.__getitem__(String('end_date'))], [String('description'), description], [String('total_days_work'), staffs.__getitem__(String('total_days_work'))], [String('subcontractors_id'), staffs.__getitem__(String('subcontractors_id'))], [String('qty'), staffs.__getitem__(String('invoiced_hrs'))], [String('unit_price'), staffs.__getitem__(String('client_hourly_rate'))], [String('sum_adj_hrs'), staffs.__getitem__(String('sum_adj_hrs'))], [String('sum_hrs_chrge_to_client'), staffs.__getitem__(String('sum_hrs_charged_to_client'))], [String('adjustment'), staffs.__getitem__(String('adjustment'))]]));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(pyjslib.eq(checked, 0))) {
			self.CreateNextInvoice();
			return null;
		}
		main_description = pyjslib.sprintf(String('%s %s '), new pyjslib.Tuple([client_staffs.__getitem__(0).__getitem__(String('leads_fname')), client_staffs.__getitem__(0).__getitem__(String('leads_lname'))]));
		invoice_date = self.df1.getTextBox().getText();
		self.label_rcti = GenerateClientInvoice.Label(pyjslib.sprintf(String('Creating Draft Invoice for %s %s'), new pyjslib.Tuple([client_staffs.__getitem__(0).__getitem__(String('leads_fname')), client_staffs.__getitem__(0).__getitem__(String('leads_lname'))])));
		self.vp.insert((typeof self.label_rcti == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_rcti'):self.label_rcti), 0);
		self.id_create_invoice = self.remote_service.create_invoice(leads_id, main_description, invoice_date, total_amount, invoice_details, self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.CreateNextInvoice = pyjs__bind_method(cls_instance, 'CreateNextInvoice', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.key_counter += 1;
		self.label_status.setText(pyjslib.sprintf(String('Generated: %s of %s'), new pyjslib.Tuple([(typeof self.key_counter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'key_counter'):self.key_counter), pyjslib.len((typeof self.keys == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keys'):self.keys))])));
		self.CreateInvoice();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.Show = pyjs__bind_method(cls_instance, 'Show', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var width,height;
		width = GenerateClientInvoice.Window.getClientWidth();
		height = GenerateClientInvoice.Window.getClientHeight();
		self.dialog.show();
		self.dialog.setPopupPosition( (  ( width - 400 )  / 2 ) ,  (  ( height - 200 )  / 2 ) );
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.CloseDialog = pyjs__bind_method(cls_instance, 'CloseDialog', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.dialog.hide();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onRemoteResponse = pyjs__bind_method(cls_instance, 'onRemoteResponse', function(response, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
			request_info = arguments[2];
		}

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_create_invoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_create_invoice'):self.id_create_invoice)))) {
			self.CreateNextInvoice();
		}
		else {
			self.parent.status.setText(response);
		}
		return null;
	}
	, 1, [null,null,'self', 'response', 'request_info']);
	cls_definition.onRemoteError = pyjs__bind_method(cls_instance, 'onRemoteError', function(code, message, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			code = arguments[1];
			message = arguments[2];
			request_info = arguments[3];
		}

		self.parent.status.setText(pyjslib.sprintf(String('Server Error or Invalid Response: ERROR %d - %s'), new pyjslib.Tuple([code, message])));
		self.CloseDialog();
		return null;
	}
	, 1, [null,null,'self', 'code', 'message', 'request_info']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
GenerateClientInvoice.GenerateClientInvoice = (function(){
	var cls_instance = pyjs__class_instance('GenerateClientInvoice');
	var cls_definition = new Object();
	cls_definition.__md5__ = '4d332c3242aee9a09fa2f634503763e4';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var image_different_currency_flag,cp_drafts,cp_legend,cp_timesheets,vp,sp_drafts,main_panel,hp_invoices,label_diff_currency,panel_timesheet_buttons,sp_timesheets,panel_legend,vp_staff_timesheet,pager_panel;
		self.remote_service = GenerateClientInvoice.GenerateClientInvoiceService();
		self.client = new pyjslib.Dict([]);
		main_panel = GenerateClientInvoice.VerticalPanel();
		main_panel.setWidth(String('100%'));
		main_panel.setHorizontalAlignment(String('center'));
		vp = GenerateClientInvoice.VerticalPanel();
		vp.setWidth(String('960px'));
		vp.setHorizontalAlignment(String('center'));
		hp_invoices = GenerateClientInvoice.HorizontalPanel();
		vp.add(hp_invoices);
		cp_drafts = GenerateClientInvoice.CaptionPanel(String('Draft Tax Invoice'));
		sp_drafts = pyjs_kwargs_call(GenerateClientInvoice, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('260px'), String('380px')])}]);
		cp_drafts.add(sp_drafts);
		self.vp_drafts = pyjs_kwargs_call(GenerateClientInvoice, 'VerticalPanel', null, null, [{Size:new pyjslib.Tuple([String('100%'), String('100%')])}]);
		sp_drafts.add((typeof self.vp_drafts == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp_drafts'):self.vp_drafts));
		hp_invoices.add(cp_drafts);
		cp_timesheets = GenerateClientInvoice.CaptionPanel(String('Staff Timesheets'));
		vp_staff_timesheet = GenerateClientInvoice.VerticalPanel();
		self.button_prev = GenerateClientInvoice.Button(String('Prev'), (typeof self.OnClickPrevPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickPrevPage'):self.OnClickPrevPage));
		self.listbox_pages = GenerateClientInvoice.ListBox();
		self.listbox_pages.addChangeListener((typeof self.RenderClientTimeSheetPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'RenderClientTimeSheetPage'):self.RenderClientTimeSheetPage));
		self.button_next = GenerateClientInvoice.Button(String('Next'), (typeof self.OnClickNextPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickNextPage'):self.OnClickNextPage));
		cp_legend = GenerateClientInvoice.CaptionPanel(String('Legend'));
		image_different_currency_flag = GenerateClientInvoice.Image(String('/portal/media/img/folder_red.png'));
		label_diff_currency = GenerateClientInvoice.Label(String('Subcontracts have different currencies.'));
		label_diff_currency.setStyleName(String('label_legend'));
		panel_legend = GenerateClientInvoice.HorizontalPanel();
		panel_legend.setVerticalAlignment(String('middle'));
		panel_legend.add(image_different_currency_flag);
		panel_legend.add(label_diff_currency);
		cp_legend.add(panel_legend);
		pager_panel = GenerateClientInvoice.HorizontalPanel();
		pager_panel.setVerticalAlignment(String('middle'));
		pager_panel.add((typeof self.button_prev == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_prev'):self.button_prev));
		pager_panel.add((typeof self.listbox_pages == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_pages'):self.listbox_pages));
		pager_panel.add((typeof self.button_next == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_next'):self.button_next));
		pager_panel.add(cp_legend);
		vp_staff_timesheet.add(pager_panel);
		sp_timesheets = pyjs_kwargs_call(GenerateClientInvoice, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('640px'), String('380px')])}]);
		vp_staff_timesheet.add(sp_timesheets);
		panel_timesheet_buttons = GenerateClientInvoice.HorizontalPanel();
		vp_staff_timesheet.add(panel_timesheet_buttons);
		self.button_select_all = GenerateClientInvoice.Button(String('Select All'), (typeof self.OnClickSelectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickSelectAll'):self.OnClickSelectAll));
		panel_timesheet_buttons.add((typeof self.button_select_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_select_all'):self.button_select_all));
		self.button_unselect_all = GenerateClientInvoice.Button(String('Unselect All'), (typeof self.OnClickUnselectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickUnselectAll'):self.OnClickUnselectAll));
		panel_timesheet_buttons.add((typeof self.button_unselect_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_unselect_all'):self.button_unselect_all));
		self.button_generate_invoice = GenerateClientInvoice.Button(String('Generate Tax Invoice'), (typeof self.OnClickGenerateDraftInvoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickGenerateDraftInvoice'):self.OnClickGenerateDraftInvoice));
		panel_timesheet_buttons.add((typeof self.button_generate_invoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_generate_invoice'):self.button_generate_invoice));
		self.button_remove_from_list = GenerateClientInvoice.Button(String('Remove From List'), (typeof self.OnClickRemoveFromList == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickRemoveFromList'):self.OnClickRemoveFromList));
		panel_timesheet_buttons.add((typeof self.button_remove_from_list == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_remove_from_list'):self.button_remove_from_list));
		cp_timesheets.add(vp_staff_timesheet);
		self.vp_timesheets = pyjs_kwargs_call(GenerateClientInvoice, 'VerticalPanel', null, null, [{Size:new pyjslib.Tuple([String('100%'), String('100%')])}]);
		sp_timesheets.add((typeof self.vp_timesheets == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp_timesheets'):self.vp_timesheets));
		hp_invoices.add(cp_timesheets);
		self.status = GenerateClientInvoice.Label();
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		main_panel.add(vp);
		GenerateClientInvoice.RootPanel().add(main_panel);
		self.admin_login_dialog = GenerateClientInvoice.DialogAdminLogin(self);
		self.GetDraftedInvoices();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickGenerateDraftInvoice = pyjs__bind_method(cls_instance, 'OnClickGenerateDraftInvoice', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var dialog_invoice_generation_progress;
		dialog_invoice_generation_progress = GenerateClientInvoice.DialogInvoiceGenerationProgress(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickUnselectAll = pyjs__bind_method(cls_instance, 'OnClickUnselectAll', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var total_amt,client,total_amt_str,key;
		var __key = self.client.keys().__iter__();
		try {
			while (true) {
				var key = __key.next();
				
				total_amt = 0;
				var __client = (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(key).__iter__();
				try {
					while (true) {
						var client = __client.next();
						
						client.__getitem__(String('check_box')).setChecked(false);
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				total_amt_str = self.CurrencyFormat(total_amt);
				(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(key).__getitem__(String('label_total_amount')).setText(total_amt_str);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickSelectAll = pyjs__bind_method(cls_instance, 'OnClickSelectAll', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var total_amt,client,total_amt_str,key;
		var __key = self.client.keys().__iter__();
		try {
			while (true) {
				var key = __key.next();
				
				total_amt = 0;
				var __client = (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(key).__iter__();
				try {
					while (true) {
						var client = __client.next();
						
						if (pyjslib.bool(client.__getitem__(String('check_box')).isEnabled())) {
							client.__getitem__(String('check_box')).setChecked(true);
							total_amt += pyjslib.float_(client.__getitem__(String('amount')));
						}
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				total_amt_str = self.CurrencyFormat(total_amt);
				(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(key).__getitem__(String('label_total_amount')).setText(total_amt_str);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickPrevPage = pyjs__bind_method(cls_instance, 'OnClickPrevPage', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var x;
		x = self.listbox_pages.getSelectedIndex();
		self.listbox_pages.setSelectedIndex( ( x - 1 ) );
		self.RenderClientTimeSheetPage(evt);
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.OnClickNextPage = pyjs__bind_method(cls_instance, 'OnClickNextPage', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var x;
		x = self.listbox_pages.getSelectedIndex();
		self.listbox_pages.setSelectedIndex( ( x + 1 ) );
		self.RenderClientTimeSheetPage(evt);
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.OnClickRemoveFromList = pyjs__bind_method(cls_instance, 'OnClickRemoveFromList', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var timesheet_ids,confirm,i,clients,client;
		timesheet_ids = new pyjslib.List([]);
		var __i = pyjslib.range(pyjslib.len(self.client.keys())).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				clients = (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(i);
				var __client = clients.__iter__();
				try {
					while (true) {
						var client = __client.next();
						
						if (pyjslib.bool(client.__getitem__(String('check_box')).isChecked())) {
							timesheet_ids.append(client.__getitem__(String('id')));
						}
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(timesheet_ids), 0))) {
			GenerateClientInvoice.Window.alert(String('Please select from the list'));
			return null;
		}
		confirm = GenerateClientInvoice.Window.confirm(String('Are you sure you want to remove them from the list?'));
		if (pyjslib.bool(pyjslib.eq(confirm, false))) {
			return null;
		}
		self.status.setText(String('Please Wait...'));
		self.EnableWidgets(false);
		self.id_remove_from_list = self.remote_service.remove_from_list(timesheet_ids, self);
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.EnableWidgets = pyjs__bind_method(cls_instance, 'EnableWidgets', function(enabled) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			enabled = arguments[1];
		}

		self.button_select_all.setEnabled(enabled);
		self.button_unselect_all.setEnabled(enabled);
		self.button_generate_invoice.setEnabled(enabled);
		self.button_remove_from_list.setEnabled(enabled);
		return null;
	}
	, 1, [null,null,'self', 'enabled']);
	cls_definition.GetStaffTimeSheets = pyjs__bind_method(cls_instance, 'GetStaffTimeSheets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.vp_timesheets.clear();
		self.vp_timesheets.add(GenerateClientInvoice.Label(String('Loading...')));
		self.id_get_time_sheets = self.remote_service.get_time_sheets(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderClientTimeSheets = pyjs__bind_method(cls_instance, 'RenderClientTimeSheets', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i,j,pages,leads_id,x,new_records,lead_ids,check_box_staff;
		self.status.setText(String(''));
		self.vp_timesheets.clear();
		self.client = new pyjslib.Dict([]);
		self.button_prev.setEnabled(false);
		self.button_next.setEnabled(false);
		self.listbox_pages.clear();
		lead_ids = new pyjslib.Dict([]);
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.vp_timesheets.add(GenerateClientInvoice.HTML(String('No Timesheets Found.')));
			return null;
		}
		self.EnableWidgets(true);
		j = 0;
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				leads_id = data.__getitem__(i).__getitem__(String('leads_id'));
				check_box_staff = GenerateClientInvoice.CheckBox(data.__getitem__(i).__getitem__(String('description')));
				check_box_staff.addClickListener((typeof self.OnClickCheckBoxClient == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickCheckBoxClient'):self.OnClickCheckBoxClient));
				check_box_staff.setStyleName(String('check_box_staff'));
				check_box_staff.setWidth(180);
				data.__getitem__(i).__setitem__(String('check_box'), check_box_staff);
				data.__getitem__(i).__setitem__(String('label_invoice_description'), GenerateClientInvoice.Label(pyjslib.sprintf(String('%shrs @ %s/hr'), new pyjslib.Tuple([data.__getitem__(i).__getitem__(String('invoiced_hrs')), data.__getitem__(i).__getitem__(String('client_hourly_rate'))]))));
				data.__getitem__(i).__getitem__(String('label_invoice_description')).setStyleName(String('label_hours'));
				data.__getitem__(i).__setitem__(String('label_amount'), GenerateClientInvoice.Label(data.__getitem__(i).__getitem__(String('amount_str'))));
				data.__getitem__(i).__getitem__(String('label_amount')).setStyleName(String('label_total_per_client'));
				if (pyjslib.bool(lead_ids.keys().__contains__(leads_id))) {
					x = lead_ids.__getitem__(leads_id);
					new_records = (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(x);
					new_records.append(data.__getitem__(i));
					(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__setitem__(x, new_records);
				}
				else {
					(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__setitem__(j, new pyjslib.List([data.__getitem__(i)]));
					(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__setitem__(String('label_client_name'), GenerateClientInvoice.Label(pyjslib.sprintf(String('%s %s'), new pyjslib.Tuple([(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(0).__getitem__(String('leads_fname')), (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(0).__getitem__(String('leads_lname'))]))));
					(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(String('label_client_name')).setStyleName(String('label_client_name'));
					(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__setitem__(String('label_total_amount'), GenerateClientInvoice.Label(String('0.00')));
					(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(String('label_total_amount')).setStyleName(String('label_total_amt'));
					lead_ids.__setitem__(leads_id, j);
					j += 1;
				}
				check_box_staff.inputElem.setAttribute(String('key'),  ( j - 1 ) );
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		pages =  ( pyjslib.int_( ( pyjslib.len((typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client)) / GenerateClientInvoice.CLIENT_PER_PAGE ) ) + 1 ) ;
		self.listbox_pages.clear();
		var __i = pyjslib.range(pages).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.listbox_pages.addItem( ( i + 1 ) , i);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.RenderClientTimeSheetPage();
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.RenderClientTimeSheetPage = pyjs__bind_method(cls_instance, 'RenderClientTimeSheetPage', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var grid_clients_col_formatter,currency,i,cell_format_staff,j,currency_different,client,bg_color,image_different_currency_flag,row_format_staff,grid_clients,y,x,page,k;
		page = pyjslib.int_(self.listbox_pages.getValue(self.listbox_pages.getSelectedIndex()));
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len((typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client)), GenerateClientInvoice.CLIENT_PER_PAGE) != 1))) {
			self.button_prev.setEnabled(false);
			self.button_next.setEnabled(false);
		}
		else {
			if (pyjslib.bool(pyjslib.eq(page, 0))) {
				self.button_prev.setEnabled(false);
			}
			else {
				self.button_prev.setEnabled(true);
			}
			if (pyjslib.bool((pyjslib.cmp(page, pyjslib.int_( ( pyjslib.len((typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client)) / GenerateClientInvoice.CLIENT_PER_PAGE ) )) != -1))) {
				self.button_next.setEnabled(false);
			}
			else {
				self.button_next.setEnabled(true);
			}
		}
		x =  ( page * GenerateClientInvoice.CLIENT_PER_PAGE ) ;
		y =  ( x + GenerateClientInvoice.CLIENT_PER_PAGE ) ;
		if (pyjslib.bool((pyjslib.cmp(y, pyjslib.len((typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client))) != -1))) {
			y = pyjslib.len((typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client));
		}
		self.grid_staff_timesheet = GenerateClientInvoice.Grid( ( y - x ) , 4);
		self.grid_staff_timesheet.setWidth(String('100%'));
		row_format_staff = self.grid_staff_timesheet.getRowFormatter();
		cell_format_staff = self.grid_staff_timesheet.getCellFormatter();
		bg_color = String('');
		i = 0;
		var __j = pyjslib.range(x, y).__iter__();
		try {
			while (true) {
				var j = __j.next();
				
				if (pyjslib.bool(pyjslib.eq(bg_color, String('row_odd')))) {
					bg_color = String('row_even');
				}
				else {
					bg_color = String('row_odd');
				}
				row_format_staff.setStyleName(i, bg_color);
				grid_clients = GenerateClientInvoice.Grid(pyjslib.len((typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j)), 3);
				grid_clients.setWidth(String('100%'));
				grid_clients_col_formatter = grid_clients.getCellFormatter();
				currency = (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(0).__getitem__(String('currency_rate'));
				currency_different = 0;
				var __k = pyjslib.range(pyjslib.len((typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j))).__iter__();
				try {
					while (true) {
						var k = __k.next();
						
						grid_clients.setWidget(k, 0, (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(k).__getitem__(String('check_box')));
						grid_clients.setWidget(k, 1, (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(k).__getitem__(String('label_invoice_description')));
						grid_clients.setWidget(k, 2, (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(k).__getitem__(String('label_amount')));
						grid_clients_col_formatter.setHorizontalAlignment(k, 1, String('right'));
						grid_clients_col_formatter.setHorizontalAlignment(k, 2, String('right'));
						grid_clients_col_formatter.setAttr(k, 0, String('width'), String('188px'));
						grid_clients_col_formatter.setAttr(k, 1, String('width'), String('148px'));
						grid_clients_col_formatter.setAttr(k, 2, String('width'), String('68px'));
						if (pyjslib.bool(!pyjslib.eq(currency, (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(k).__getitem__(String('currency_rate'))))) {
							currency_different += 1;
						}
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_staff_timesheet.setWidget(i, 0, (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(String('label_client_name')));
				if (pyjslib.bool(!pyjslib.eq(currency_different, 0))) {
					image_different_currency_flag = GenerateClientInvoice.Image(String('/portal/media/img/folder_red.png'));
					self.grid_staff_timesheet.setWidget(i, 1, image_different_currency_flag);
					var __client = (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__iter__();
					try {
						while (true) {
							var client = __client.next();
							
							client.__getitem__(String('check_box')).setEnabled(false);
						}
					} catch (e) {
						if (e.__name__ != 'StopIteration') {
							throw e;
						}
					}
				}
				self.grid_staff_timesheet.setWidget(i, 2, grid_clients);
				self.grid_staff_timesheet.setWidget(i, 3, (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(j).__getitem__(String('label_total_amount')));
				cell_format_staff.setHorizontalAlignment(i, 2, String('right'));
				i += 1;
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.vp_timesheets.clear();
		self.vp_timesheets.add((typeof self.grid_staff_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_staff_timesheet'):self.grid_staff_timesheet));
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.OnClickCheckBoxClient = pyjs__bind_method(cls_instance, 'OnClickCheckBoxClient', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var total_amt,total_amt_str,clients,client,key;
		key = pyjslib.int_(evt.inputElem.getAttribute(String('key')));
		clients = (typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(key);
		total_amt = 0;
		var __client = clients.__iter__();
		try {
			while (true) {
				var client = __client.next();
				
				if (pyjslib.bool(client.__getitem__(String('check_box')).isChecked())) {
					total_amt += pyjslib.float_(client.__getitem__(String('amount')));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		total_amt_str = self.CurrencyFormat(total_amt);
		(typeof self.client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'client'):self.client).__getitem__(key).__getitem__(String('label_total_amount')).setText(total_amt_str);
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.CurrencyFormat = pyjs__bind_method(cls_instance, 'CurrencyFormat', function(amt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			amt = arguments[1];
		}
		var final_int_amt_str,i,int_amount_str,amount_is_negative,int_amount,x,decimal_amt_str;
		amt = amt.toFixed(2);
		int_amount = pyjslib.int_(amt);
		decimal_amt_str = pyjslib.sprintf(String('%s'), amt);
		decimal_amt_str = pyjslib.slice(decimal_amt_str, -2, null);
		amount_is_negative = false;
		if (pyjslib.bool((pyjslib.cmp(int_amount, 0) == -1))) {
			amount_is_negative = true;
			int_amount *= -1;
		}
		int_amount_str = pyjslib.sprintf(String('%s'), int_amount);
		final_int_amt_str = String('');
		x = 0;
		var __i = pyjslib.range( ( pyjslib.len(int_amount_str) - 1 ) , -1, -1).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(pyjslib.eq(x, 2))) {
					if (pyjslib.bool(pyjslib.eq(i, 0))) {
						final_int_amt_str =  ( int_amount_str.__getitem__(i) + final_int_amt_str ) ;
					}
					else {
						final_int_amt_str =  (  ( String(',') + int_amount_str.__getitem__(i) )  + final_int_amt_str ) ;
					}
					x = 0;
				}
				else {
					final_int_amt_str =  ( int_amount_str.__getitem__(i) + final_int_amt_str ) ;
					x += 1;
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(amount_is_negative)) {
			final_int_amt_str =  ( String('-') + final_int_amt_str ) ;
		}
		return  (  ( final_int_amt_str + String('.') )  + decimal_amt_str ) ;
	}
	, 1, [null,null,'self', 'amt']);
	cls_definition.GetDraftedInvoices = pyjs__bind_method(cls_instance, 'GetDraftedInvoices', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.vp_drafts.clear();
		self.vp_timesheets.clear();
		self.vp_drafts.add(GenerateClientInvoice.Label(String('Loading...')));
		self.id_get_draft_invoice = self.remote_service.get_draft_invoice(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderDraftedInvoices = pyjs__bind_method(cls_instance, 'RenderDraftedInvoices', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var grid_draft,i,row_formatter,bg_color;
		self.vp_drafts.clear();
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.vp_drafts.add(GenerateClientInvoice.HTML(String('No Draft Tax Invoice Found.')));
			self.GetStaffTimeSheets();
			return null;
		}
		grid_draft = GenerateClientInvoice.Grid(pyjslib.len(data), 2);
		row_formatter = grid_draft.getRowFormatter();
		grid_draft.setStyleName(String('grid_draft'));
		self.vp_drafts.add(grid_draft);
		bg_color = String('');
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(!pyjslib.eq(bg_color, String('row_even')))) {
					bg_color = String('row_even');
				}
				else {
					bg_color = String('row_odd');
				}
				row_formatter.setStyleName(i, bg_color);
				grid_draft.setWidget(i, 0, GenerateClientInvoice.HTML(data.__getitem__(i).__getitem__(String('id'))));
				grid_draft.setWidget(i, 1, GenerateClientInvoice.HTML(data.__getitem__(i).__getitem__(String('description'))));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		grid_draft.setRowFormatter(row_formatter);
		self.GetStaffTimeSheets();
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.onRemoteResponse = pyjs__bind_method(cls_instance, 'onRemoteResponse', function(response, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
			request_info = arguments[2];
		}

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_draft_invoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_draft_invoice'):self.id_get_draft_invoice)))) {
			self.RenderDraftedInvoices(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_time_sheets == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_time_sheets'):self.id_get_time_sheets)))) {
			self.RenderClientTimeSheets(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_remove_from_list == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_remove_from_list'):self.id_remove_from_list)))) {
			GenerateClientInvoice.Window.alert(String('Succesfully removed from list.'));
			self.GetDraftedInvoices();
		}
		else {
			self.status.setText(response);
		}
		return null;
	}
	, 1, [null,null,'self', 'response', 'request_info']);
	cls_definition.onRemoteError = pyjs__bind_method(cls_instance, 'onRemoteError', function(code, message, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			code = arguments[1];
			message = arguments[2];
			request_info = arguments[3];
		}

		if (pyjslib.bool(pyjslib.eq(message.__getitem__(String('message')), String('Please Login')))) {
			self.admin_login_dialog.Show();
			return null;
		}
		self.status.setText(pyjslib.sprintf(String('Server Error or Invalid Response: ERROR %d - %s'), new pyjslib.Tuple([code, message])));
		return null;
	}
	, 1, [null,null,'self', 'code', 'message', 'request_info']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
GenerateClientInvoice.GenerateClientInvoiceService = (function(){
	var cls_instance = pyjs__class_instance('GenerateClientInvoiceService');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'eaf67e0332acb73da43c254095f4ab5e';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		GenerateClientInvoice.JSONProxy.__init__(self, String('/portal/invoice/GenerateClientInvoiceService.php'), new pyjslib.List([String('login'), String('get_draft_invoice'), String('get_time_sheets'), String('create_invoice'), String('remove_from_list')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(GenerateClientInvoice.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(GenerateClientInvoice.__name__, String('__main__')))) {
	GenerateClientInvoice.app = GenerateClientInvoice.GenerateClientInvoice();
	GenerateClientInvoice.app.onModuleLoad();
}
return this;
}; /* end GenerateClientInvoice */
$pyjs.modules_hash['GenerateClientInvoice'] = $pyjs.loaded_modules['GenerateClientInvoice'];


 /* end module: GenerateClientInvoice */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox', 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox', 'pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel', 'pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel', 'pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar', 'pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.log', 'pygwt']
*/
