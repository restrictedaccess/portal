/* start module: GenerateStaffInvoice */
var GenerateStaffInvoice = $pyjs.loaded_modules["GenerateStaffInvoice"] = function (__mod_name__) {
if(GenerateStaffInvoice.__was_initialized__) return GenerateStaffInvoice;
GenerateStaffInvoice.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'GenerateStaffInvoice';
var __name__ = GenerateStaffInvoice.__name__ = __mod_name__;
pyjslib.__import__(['pyjd'], 'pyjd', 'GenerateStaffInvoice');
GenerateStaffInvoice.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'GenerateStaffInvoice');
GenerateStaffInvoice.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'GenerateStaffInvoice');
GenerateStaffInvoice.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'GenerateStaffInvoice');
GenerateStaffInvoice.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'GenerateStaffInvoice');
GenerateStaffInvoice.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'GenerateStaffInvoice');
GenerateStaffInvoice.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'GenerateStaffInvoice');
GenerateStaffInvoice.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'GenerateStaffInvoice');
GenerateStaffInvoice.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'GenerateStaffInvoice');
GenerateStaffInvoice.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'GenerateStaffInvoice');
GenerateStaffInvoice.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'GenerateStaffInvoice');
GenerateStaffInvoice.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'GenerateStaffInvoice');
GenerateStaffInvoice.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'GenerateStaffInvoice');
GenerateStaffInvoice.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'GenerateStaffInvoice');
GenerateStaffInvoice.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'GenerateStaffInvoice');
GenerateStaffInvoice.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox'], 'pyjamas.ui.DialogBox.DialogBox', 'GenerateStaffInvoice');
GenerateStaffInvoice.DialogBox = $pyjs.__modules__.pyjamas.ui.DialogBox.DialogBox;
pyjslib.__import__(['pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox'], 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'GenerateStaffInvoice');
GenerateStaffInvoice.PasswordTextBox = $pyjs.__modules__.pyjamas.ui.PasswordTextBox.PasswordTextBox;
pyjslib.__import__(['pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel'], 'pyjamas.ui.TabPanel.TabPanel', 'GenerateStaffInvoice');
GenerateStaffInvoice.TabPanel = $pyjs.__modules__.pyjamas.ui.TabPanel.TabPanel;
pyjslib.__import__(['pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel'], 'pyjamas.ui.CaptionPanel.CaptionPanel', 'GenerateStaffInvoice');
GenerateStaffInvoice.CaptionPanel = $pyjs.__modules__.pyjamas.ui.CaptionPanel.CaptionPanel;
pyjslib.__import__(['pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.Calendar', 'GenerateStaffInvoice');
GenerateStaffInvoice.Calendar = $pyjs.__modules__.pyjamas.ui.Calendar.Calendar;
pyjslib.__import__(['pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.DateField', 'GenerateStaffInvoice');
GenerateStaffInvoice.DateField = $pyjs.__modules__.pyjamas.ui.Calendar.DateField;
pyjslib.__import__(['pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.CalendarPopup', 'GenerateStaffInvoice');
GenerateStaffInvoice.CalendarPopup = $pyjs.__modules__.pyjamas.ui.Calendar.CalendarPopup;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'GenerateStaffInvoice');
GenerateStaffInvoice.log = $pyjs.__modules__.pyjamas.log;
pyjslib.__import__(['pygwt'], 'pygwt', 'GenerateStaffInvoice');
GenerateStaffInvoice.pygwt = $pyjs.__modules__.pygwt;
GenerateStaffInvoice.STAFF_PER_PAGE = 10;
GenerateStaffInvoice.DialogAdminLogin = (function(){
	var cls_instance = pyjs__class_instance('DialogAdminLogin');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'd502583e410132920c4edab77cb7500e';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var cell_format,label_email,grid,label_password;
		self.parent = parent;
		self.remote_service = GenerateStaffInvoice.GenerateStaffInvoiceService();
		grid = GenerateStaffInvoice.Grid(3, 2);
		label_email = GenerateStaffInvoice.Label(String('Email :'));
		label_password = GenerateStaffInvoice.Label(String('Password :'));
		self.text_box_email = GenerateStaffInvoice.TextBox();
		self.text_box_password = GenerateStaffInvoice.PasswordTextBox();
		self.button_login = GenerateStaffInvoice.Button(String('Login'), (typeof self.OnClickLogin == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickLogin'):self.OnClickLogin));
		self.button_close = GenerateStaffInvoice.Button(String('Close'), (typeof self.RedirectToMainPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'RedirectToMainPage'):self.RedirectToMainPage));
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
		self.dialog_login = GenerateStaffInvoice.DialogBox();
		self.dialog_login.setHTML(String('\x3Cb\x3EPlease Login\x3C/b\x3E'));
		self.dialog_login.setWidget(grid);
		self.Show();
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

		GenerateStaffInvoice.Window.setLocation(String('/portal/index.php'));
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
		width = GenerateStaffInvoice.Window.getClientWidth();
		height = GenerateStaffInvoice.Window.getClientHeight();
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
			GenerateStaffInvoice.Window.alert(String('Invalid Login!'));
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
GenerateStaffInvoice.DialogInvoiceGenerationProgress = (function(){
	var cls_instance = pyjs__class_instance('DialogInvoiceGenerationProgress');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'd93c3e6c54c8082784e6702d93f5903b';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var scroll_panel,cell_formatter,grid_top,panel_button,main_panel;
		self.parent = parent;
		self.remote_service = GenerateStaffInvoice.GenerateStaffInvoiceService();
		self.dialog = GenerateStaffInvoice.DialogBox();
		self.cal = GenerateStaffInvoice.Calendar();
		self.df1 = pyjs_kwargs_call(GenerateStaffInvoice, 'DateField', null, null, [{format:String('%Y-%m-%d')}]);
		self.df1.onTodayClicked();
		scroll_panel = pyjs_kwargs_call(GenerateStaffInvoice, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('400px'), String('200px')])}]);
		self.vp = GenerateStaffInvoice.VerticalPanel();
		self.label_status = GenerateStaffInvoice.Label(String(''));
		grid_top = GenerateStaffInvoice.Grid(1, 2);
		cell_formatter = grid_top.getCellFormatter();
		grid_top.setWidget(0, 0, GenerateStaffInvoice.Label(String('Invoice Date:')));
		grid_top.setWidget(0, 1, (typeof self.df1 == 'function' && self.__is_instance__?pyjslib.getattr(self, 'df1'):self.df1));
		cell_formatter.setHorizontalAlignment(0, 0, String('right'));
		cell_formatter.setHorizontalAlignment(0, 1, String('right'));
		grid_top.setCellFormatter(cell_formatter);
		main_panel = GenerateStaffInvoice.VerticalPanel();
		main_panel.setHorizontalAlignment(String('center'));
		main_panel.add(grid_top);
		main_panel.add(scroll_panel);
		scroll_panel.add((typeof self.vp == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp'):self.vp));
		main_panel.add((typeof self.label_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_status'):self.label_status));
		self.dialog.setHTML(String('\x3Cb\x3EGenerating Draft RCTI...\x3C/b\x3E'));
		self.dialog.setWidget(main_panel);
		self.button_generate_invoice = GenerateStaffInvoice.Button(String('Generate RCTI'), (typeof self.ProcessInvoices == 'function' && self.__is_instance__?pyjslib.getattr(self, 'ProcessInvoices'):self.ProcessInvoices));
		self.button_close_dialog = GenerateStaffInvoice.Button(String('Close'), (typeof self.CloseDialog == 'function' && self.__is_instance__?pyjslib.getattr(self, 'CloseDialog'):self.CloseDialog));
		panel_button = GenerateStaffInvoice.HorizontalPanel();
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
		self.keys = self.parent.staff.keys();
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
		var checked,total_amount,invoice_date,invoice_details,userid,client,key,main_description,staff_clients,description;
		if (pyjslib.bool((pyjslib.cmp((typeof self.key_counter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'key_counter'):self.key_counter), pyjslib.len((typeof self.keys == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keys'):self.keys))) != -1))) {
			self.CloseDialog();
			GenerateStaffInvoice.Window.alert(String('Finished Creating Draft RCTI.'));
			self.parent.GetDraftedInvoices();
			return null;
		}
		key = (typeof self.keys == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keys'):self.keys).__getitem__((typeof self.key_counter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'key_counter'):self.key_counter));
		staff_clients = (typeof self.parent.staff == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'staff'):self.parent.staff).__getitem__(key);
		userid = staff_clients.__getitem__(0).__getitem__(String('userid'));
		checked = 0;
		total_amount = 0;
		invoice_details = new pyjslib.List([]);
		var __client = staff_clients.__iter__();
		try {
			while (true) {
				var client = __client.next();
				
				if (pyjslib.bool(client.__getitem__(String('check_box')).isChecked())) {
					checked += 1;
					total_amount += client.__getitem__(String('amount'));
					description = pyjslib.sprintf(String('%s - %shrs@%s/hr'), new pyjslib.Tuple([client.__getitem__(String('description')), client.__getitem__(String('invoiced_hrs')), client.__getitem__(String('php_hourly'))]));
					invoice_details.append(new pyjslib.Dict([[String('id'), client.__getitem__(String('id'))], [String('description'), description], [String('subcontractors_id'), client.__getitem__(String('subcontractors_id'))], [String('qty'), client.__getitem__(String('invoiced_hrs'))], [String('unit_price'), client.__getitem__(String('php_hourly'))], [String('sum_adj_hrs'), client.__getitem__(String('sum_adj_hrs'))], [String('sum_hrs_to_be_subcon'), client.__getitem__(String('sum_hrs_to_be_subcon'))], [String('adjustment'), client.__getitem__(String('adjustment'))]]));
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
		main_description = pyjslib.sprintf(String('%s %s RCTI '), new pyjslib.Tuple([staff_clients.__getitem__(0).__getitem__(String('personal_fname')), staff_clients.__getitem__(0).__getitem__(String('personal_lname'))]));
		invoice_date = self.df1.getTextBox().getText();
		self.label_rcti = GenerateStaffInvoice.Label(pyjslib.sprintf(String('Creating RCTI for %s %s'), new pyjslib.Tuple([staff_clients.__getitem__(0).__getitem__(String('personal_fname')), staff_clients.__getitem__(0).__getitem__(String('personal_lname'))])));
		self.vp.insert((typeof self.label_rcti == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_rcti'):self.label_rcti), 0);
		self.id_create_invoice = self.remote_service.create_invoice(userid, main_description, invoice_date, total_amount, invoice_details, self);
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
		width = GenerateStaffInvoice.Window.getClientWidth();
		height = GenerateStaffInvoice.Window.getClientHeight();
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
GenerateStaffInvoice.GenerateStaffInvoice = (function(){
	var cls_instance = pyjs__class_instance('GenerateStaffInvoice');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'e3e2709d91ddd9df96a8cd0ee16f6b20';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var cp_drafts,cp_timesheets,vp,sp_drafts,main_panel,hp_invoices,panel_timesheet_buttons,sp_timesheets,vp_staff_timesheet,pager_panel;
		self.remote_service = GenerateStaffInvoice.GenerateStaffInvoiceService();
		self.staff = new pyjslib.Dict([]);
		main_panel = GenerateStaffInvoice.VerticalPanel();
		main_panel.setWidth(String('100%'));
		main_panel.setHorizontalAlignment(String('center'));
		vp = GenerateStaffInvoice.VerticalPanel();
		vp.setWidth(String('960px'));
		vp.setHorizontalAlignment(String('center'));
		hp_invoices = GenerateStaffInvoice.HorizontalPanel();
		vp.add(hp_invoices);
		cp_drafts = GenerateStaffInvoice.CaptionPanel(String('Drafted RCTI'));
		sp_drafts = pyjs_kwargs_call(GenerateStaffInvoice, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('260px'), String('380px')])}]);
		cp_drafts.add(sp_drafts);
		self.vp_drafts = pyjs_kwargs_call(GenerateStaffInvoice, 'VerticalPanel', null, null, [{Size:new pyjslib.Tuple([String('100%'), String('100%')])}]);
		sp_drafts.add((typeof self.vp_drafts == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp_drafts'):self.vp_drafts));
		hp_invoices.add(cp_drafts);
		cp_timesheets = GenerateStaffInvoice.CaptionPanel(String('Staff Timesheets'));
		vp_staff_timesheet = GenerateStaffInvoice.VerticalPanel();
		self.button_prev = GenerateStaffInvoice.Button(String('Prev'), (typeof self.OnClickPrevPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickPrevPage'):self.OnClickPrevPage));
		self.listbox_pages = GenerateStaffInvoice.ListBox();
		self.listbox_pages.addChangeListener((typeof self.RenderStaffTimeSheetPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'RenderStaffTimeSheetPage'):self.RenderStaffTimeSheetPage));
		self.button_next = GenerateStaffInvoice.Button(String('Next'), (typeof self.OnClickNextPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickNextPage'):self.OnClickNextPage));
		pager_panel = GenerateStaffInvoice.HorizontalPanel();
		pager_panel.add((typeof self.button_prev == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_prev'):self.button_prev));
		pager_panel.add((typeof self.listbox_pages == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_pages'):self.listbox_pages));
		pager_panel.add((typeof self.button_next == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_next'):self.button_next));
		vp_staff_timesheet.add(pager_panel);
		sp_timesheets = pyjs_kwargs_call(GenerateStaffInvoice, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('640px'), String('380px')])}]);
		vp_staff_timesheet.add(sp_timesheets);
		panel_timesheet_buttons = GenerateStaffInvoice.HorizontalPanel();
		vp_staff_timesheet.add(panel_timesheet_buttons);
		self.button_select_all = GenerateStaffInvoice.Button(String('Select All'), (typeof self.OnClickSelectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickSelectAll'):self.OnClickSelectAll));
		panel_timesheet_buttons.add((typeof self.button_select_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_select_all'):self.button_select_all));
		self.button_unselect_all = GenerateStaffInvoice.Button(String('Unselect All'), (typeof self.OnClickUnselectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickUnselectAll'):self.OnClickUnselectAll));
		panel_timesheet_buttons.add((typeof self.button_unselect_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_unselect_all'):self.button_unselect_all));
		self.button_generate_invoice = GenerateStaffInvoice.Button(String('Generate Draft RCTI'), (typeof self.OnClickGenerateDraftInvoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickGenerateDraftInvoice'):self.OnClickGenerateDraftInvoice));
		panel_timesheet_buttons.add((typeof self.button_generate_invoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_generate_invoice'):self.button_generate_invoice));
		self.button_remove_from_list = GenerateStaffInvoice.Button(String('Remove From List'), (typeof self.OnClickRemoveFromList == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickRemoveFromList'):self.OnClickRemoveFromList));
		panel_timesheet_buttons.add((typeof self.button_remove_from_list == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_remove_from_list'):self.button_remove_from_list));
		cp_timesheets.add(vp_staff_timesheet);
		self.vp_timesheets = pyjs_kwargs_call(GenerateStaffInvoice, 'VerticalPanel', null, null, [{Size:new pyjslib.Tuple([String('100%'), String('100%')])}]);
		sp_timesheets.add((typeof self.vp_timesheets == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp_timesheets'):self.vp_timesheets));
		hp_invoices.add(cp_timesheets);
		self.status = GenerateStaffInvoice.Label();
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		main_panel.add(vp);
		GenerateStaffInvoice.RootPanel().add(main_panel);
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
		dialog_invoice_generation_progress = GenerateStaffInvoice.DialogInvoiceGenerationProgress(self);
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
		var __key = self.staff.keys().__iter__();
		try {
			while (true) {
				var key = __key.next();
				
				total_amt = 0;
				var __client = (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(key).__iter__();
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
				(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(key).__getitem__(String('label_total_amount')).setText(total_amt_str);
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
		var __key = self.staff.keys().__iter__();
		try {
			while (true) {
				var key = __key.next();
				
				total_amt = 0;
				var __client = (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(key).__iter__();
				try {
					while (true) {
						var client = __client.next();
						
						client.__getitem__(String('check_box')).setChecked(true);
						total_amt += pyjslib.float_(client.__getitem__(String('amount')));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				total_amt_str = self.CurrencyFormat(total_amt);
				(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(key).__getitem__(String('label_total_amount')).setText(total_amt_str);
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
		self.RenderStaffTimeSheetPage(evt);
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
		self.RenderStaffTimeSheetPage(evt);
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
		var __i = pyjslib.range(pyjslib.len(self.staff.keys())).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				clients = (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(i);
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
			GenerateStaffInvoice.Window.alert(String('Please select from the list'));
			return null;
		}
		confirm = GenerateStaffInvoice.Window.confirm(String('Are you sure you want to remove them from the list?'));
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
		self.vp_timesheets.add(GenerateStaffInvoice.Label(String('Loading...')));
		self.id_get_time_sheets = self.remote_service.get_time_sheets(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderStaffTimeSheets = pyjs__bind_method(cls_instance, 'RenderStaffTimeSheets', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i,j,userid,pages,check_box_client,x,new_records,userids;
		self.status.setText(String(''));
		self.vp_timesheets.clear();
		self.staff = new pyjslib.Dict([]);
		self.button_prev.setEnabled(false);
		self.button_next.setEnabled(false);
		self.listbox_pages.clear();
		userids = new pyjslib.Dict([]);
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.vp_timesheets.add(GenerateStaffInvoice.HTML(String('No Timesheets Found.')));
			return null;
		}
		self.EnableWidgets(true);
		j = 0;
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				userid = data.__getitem__(i).__getitem__(String('userid'));
				check_box_client = GenerateStaffInvoice.CheckBox(data.__getitem__(i).__getitem__(String('description')));
				check_box_client.addClickListener((typeof self.OnClickCheckBoxClient == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickCheckBoxClient'):self.OnClickCheckBoxClient));
				check_box_client.setStyleName(String('check_box_client'));
				check_box_client.setWidth(180);
				data.__getitem__(i).__setitem__(String('check_box'), check_box_client);
				data.__getitem__(i).__setitem__(String('label_invoice_description'), GenerateStaffInvoice.Label(pyjslib.sprintf(String('%shrs @ %s/hr'), new pyjslib.Tuple([data.__getitem__(i).__getitem__(String('invoiced_hrs')), data.__getitem__(i).__getitem__(String('php_hourly'))]))));
				data.__getitem__(i).__getitem__(String('label_invoice_description')).setStyleName(String('label_hours'));
				data.__getitem__(i).__setitem__(String('label_amount'), GenerateStaffInvoice.Label(data.__getitem__(i).__getitem__(String('amount_str'))));
				data.__getitem__(i).__getitem__(String('label_amount')).setStyleName(String('label_total_per_client'));
				if (pyjslib.bool(userids.keys().__contains__(userid))) {
					x = userids.__getitem__(userid);
					new_records = (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(x);
					new_records.append(data.__getitem__(i));
					(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__setitem__(x, new_records);
				}
				else {
					(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__setitem__(j, new pyjslib.List([data.__getitem__(i)]));
					(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__setitem__(String('label_staff_name'), GenerateStaffInvoice.Label(pyjslib.sprintf(String('%s %s'), new pyjslib.Tuple([(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(0).__getitem__(String('personal_fname')), (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(0).__getitem__(String('personal_lname'))]))));
					(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(String('label_staff_name')).setStyleName(String('label_staff_name'));
					(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__setitem__(String('label_total_amount'), GenerateStaffInvoice.Label(String('0.00')));
					(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(String('label_total_amount')).setStyleName(String('label_total_amt'));
					userids.__setitem__(userid, j);
					j += 1;
				}
				check_box_client.inputElem.setAttribute(String('key'),  ( j - 1 ) );
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		pages =  ( pyjslib.int_( ( pyjslib.len((typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff)) / GenerateStaffInvoice.STAFF_PER_PAGE ) ) + 1 ) ;
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
		self.RenderStaffTimeSheetPage();
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.RenderStaffTimeSheetPage = pyjs__bind_method(cls_instance, 'RenderStaffTimeSheetPage', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var grid_clients_col_formatter,i,cell_format_staff,j,bg_color,row_format_staff,grid_clients,y,x,page,k;
		page = pyjslib.int_(self.listbox_pages.getValue(self.listbox_pages.getSelectedIndex()));
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len((typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff)), GenerateStaffInvoice.STAFF_PER_PAGE) != 1))) {
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
			if (pyjslib.bool((pyjslib.cmp(page, pyjslib.int_( ( pyjslib.len((typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff)) / GenerateStaffInvoice.STAFF_PER_PAGE ) )) != -1))) {
				self.button_next.setEnabled(false);
			}
			else {
				self.button_next.setEnabled(true);
			}
		}
		x =  ( page * GenerateStaffInvoice.STAFF_PER_PAGE ) ;
		y =  ( x + GenerateStaffInvoice.STAFF_PER_PAGE ) ;
		if (pyjslib.bool((pyjslib.cmp(y, pyjslib.len((typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff))) != -1))) {
			y = pyjslib.len((typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff));
		}
		self.grid_staff_timesheet = GenerateStaffInvoice.Grid( ( y - x ) , 3);
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
				grid_clients = GenerateStaffInvoice.Grid(pyjslib.len((typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j)), 3);
				grid_clients.setWidth(String('100%'));
				grid_clients_col_formatter = grid_clients.getCellFormatter();
				var __k = pyjslib.range(pyjslib.len((typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j))).__iter__();
				try {
					while (true) {
						var k = __k.next();
						
						grid_clients.setWidget(k, 0, (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(k).__getitem__(String('check_box')));
						grid_clients.setWidget(k, 1, (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(k).__getitem__(String('label_invoice_description')));
						grid_clients.setWidget(k, 2, (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(k).__getitem__(String('label_amount')));
						grid_clients_col_formatter.setHorizontalAlignment(k, 1, String('right'));
						grid_clients_col_formatter.setHorizontalAlignment(k, 2, String('right'));
						grid_clients_col_formatter.setAttr(k, 0, String('width'), String('188px'));
						grid_clients_col_formatter.setAttr(k, 1, String('width'), String('148px'));
						grid_clients_col_formatter.setAttr(k, 2, String('width'), String('68px'));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_staff_timesheet.setWidget(i, 0, (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(String('label_staff_name')));
				self.grid_staff_timesheet.setWidget(i, 1, grid_clients);
				self.grid_staff_timesheet.setWidget(i, 2, (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(j).__getitem__(String('label_total_amount')));
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
		clients = (typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(key);
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
		(typeof self.staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'staff'):self.staff).__getitem__(key).__getitem__(String('label_total_amount')).setText(total_amt_str);
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

		amt = amt.toFixed(2);
		amt = pyjslib.sprintf(String('%s'), amt);
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len(amt), 7) == -1))) {
			return amt;
		}
		else if (pyjslib.bool(pyjslib.eq(pyjslib.len(amt), 7))) {
			return  (  ( pyjslib.slice(amt, null, 1) + String(',') )  + pyjslib.slice(amt, 1, null) ) ;
		}
		else if (pyjslib.bool(pyjslib.eq(pyjslib.len(amt), 8))) {
			return  (  ( pyjslib.slice(amt, null, 2) + String(',') )  + pyjslib.slice(amt, 2, null) ) ;
		}
		else if (pyjslib.bool(pyjslib.eq(pyjslib.len(amt), 9))) {
			return  (  ( pyjslib.slice(amt, null, 3) + String(',') )  + pyjslib.slice(amt, 3, null) ) ;
		}
		else if (pyjslib.bool(pyjslib.eq(pyjslib.len(amt), 10))) {
			return  (  (  (  ( pyjslib.slice(amt, null, 1) + String(',') )  + pyjslib.slice(amt, 1, 4) )  + String(',') )  + pyjslib.slice(amt, 4, null) ) ;
		}
		else if (pyjslib.bool(pyjslib.eq(pyjslib.len(amt), 11))) {
			return  (  (  (  ( pyjslib.slice(amt, null, 2) + String(',') )  + pyjslib.slice(amt, 2, 5) )  + String(',') )  + pyjslib.slice(amt, 5, null) ) ;
		}
		else if (pyjslib.bool(pyjslib.eq(pyjslib.len(amt), 12))) {
			return  (  (  (  ( pyjslib.slice(amt, null, 3) + String(',') )  + pyjslib.slice(amt, 3, 6) )  + String(',') )  + pyjslib.slice(amt, 6, null) ) ;
		}
		else {
			return amt;
		}
		return null;
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
		self.vp_drafts.add(GenerateStaffInvoice.Label(String('Loading...')));
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
			self.vp_drafts.add(GenerateStaffInvoice.HTML(String('No Draft RCTI Found.')));
			self.GetStaffTimeSheets();
			return null;
		}
		grid_draft = GenerateStaffInvoice.Grid(pyjslib.len(data), 2);
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
				grid_draft.setWidget(i, 0, GenerateStaffInvoice.HTML(data.__getitem__(i).__getitem__(String('id'))));
				grid_draft.setWidget(i, 1, GenerateStaffInvoice.HTML(data.__getitem__(i).__getitem__(String('description'))));
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
			self.RenderStaffTimeSheets(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_remove_from_list == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_remove_from_list'):self.id_remove_from_list)))) {
			GenerateStaffInvoice.Window.alert(String('Succesfully removed from list.'));
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
			self.admin_login_dialog = GenerateStaffInvoice.DialogAdminLogin(self);
			return null;
		}
		self.status.setText(pyjslib.sprintf(String('Server Error or Invalid Response: ERROR %d - %s'), new pyjslib.Tuple([code, message])));
		return null;
	}
	, 1, [null,null,'self', 'code', 'message', 'request_info']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
GenerateStaffInvoice.GenerateStaffInvoiceService = (function(){
	var cls_instance = pyjs__class_instance('GenerateStaffInvoiceService');
	var cls_definition = new Object();
	cls_definition.__md5__ = '52dd32187d7f5c594045c699088b518b';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		GenerateStaffInvoice.JSONProxy.__init__(self, String('/portal/invoice/GenerateStaffInvoiceService.php'), new pyjslib.List([String('login'), String('get_draft_invoice'), String('get_time_sheets'), String('create_invoice'), String('remove_from_list')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(GenerateStaffInvoice.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(GenerateStaffInvoice.__name__, String('__main__')))) {
	GenerateStaffInvoice.app = GenerateStaffInvoice.GenerateStaffInvoice();
	GenerateStaffInvoice.app.onModuleLoad();
}
return this;
}; /* end GenerateStaffInvoice */
$pyjs.modules_hash['GenerateStaffInvoice'] = $pyjs.loaded_modules['GenerateStaffInvoice'];


 /* end module: GenerateStaffInvoice */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox', 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox', 'pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel', 'pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel', 'pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar', 'pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.log', 'pygwt']
*/
