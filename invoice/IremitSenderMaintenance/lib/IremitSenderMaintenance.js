/* start module: IremitSenderMaintenance */
var IremitSenderMaintenance = $pyjs.loaded_modules["IremitSenderMaintenance"] = function (__mod_name__) {
if(IremitSenderMaintenance.__was_initialized__) return IremitSenderMaintenance;
IremitSenderMaintenance.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'IremitSenderMaintenance';
var __name__ = IremitSenderMaintenance.__name__ = __mod_name__;
pyjslib.__import__(['pyjd'], 'pyjd', 'IremitSenderMaintenance');
IremitSenderMaintenance.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'IremitSenderMaintenance');
IremitSenderMaintenance.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'IremitSenderMaintenance');
IremitSenderMaintenance.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'IremitSenderMaintenance');
IremitSenderMaintenance.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'IremitSenderMaintenance');
IremitSenderMaintenance.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'IremitSenderMaintenance');
IremitSenderMaintenance.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'IremitSenderMaintenance');
IremitSenderMaintenance.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'IremitSenderMaintenance');
IremitSenderMaintenance.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'IremitSenderMaintenance');
IremitSenderMaintenance.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'IremitSenderMaintenance');
IremitSenderMaintenance.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'IremitSenderMaintenance');
IremitSenderMaintenance.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'IremitSenderMaintenance');
IremitSenderMaintenance.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'IremitSenderMaintenance');
IremitSenderMaintenance.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'IremitSenderMaintenance');
IremitSenderMaintenance.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'IremitSenderMaintenance');
IremitSenderMaintenance.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox'], 'pyjamas.ui.DialogBox.DialogBox', 'IremitSenderMaintenance');
IremitSenderMaintenance.DialogBox = $pyjs.__modules__.pyjamas.ui.DialogBox.DialogBox;
pyjslib.__import__(['pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox'], 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'IremitSenderMaintenance');
IremitSenderMaintenance.PasswordTextBox = $pyjs.__modules__.pyjamas.ui.PasswordTextBox.PasswordTextBox;
pyjslib.__import__(['pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel'], 'pyjamas.ui.TabPanel.TabPanel', 'IremitSenderMaintenance');
IremitSenderMaintenance.TabPanel = $pyjs.__modules__.pyjamas.ui.TabPanel.TabPanel;
pyjslib.__import__(['pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel'], 'pyjamas.ui.CaptionPanel.CaptionPanel', 'IremitSenderMaintenance');
IremitSenderMaintenance.CaptionPanel = $pyjs.__modules__.pyjamas.ui.CaptionPanel.CaptionPanel;
pyjslib.__import__(['pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.Calendar', 'IremitSenderMaintenance');
IremitSenderMaintenance.Calendar = $pyjs.__modules__.pyjamas.ui.Calendar.Calendar;
pyjslib.__import__(['pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.DateField', 'IremitSenderMaintenance');
IremitSenderMaintenance.DateField = $pyjs.__modules__.pyjamas.ui.Calendar.DateField;
pyjslib.__import__(['pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.CalendarPopup', 'IremitSenderMaintenance');
IremitSenderMaintenance.CalendarPopup = $pyjs.__modules__.pyjamas.ui.Calendar.CalendarPopup;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'IremitSenderMaintenance');
IremitSenderMaintenance.log = $pyjs.__modules__.pyjamas.log;
pyjslib.__import__(['pygwt'], 'pygwt', 'IremitSenderMaintenance');
IremitSenderMaintenance.pygwt = $pyjs.__modules__.pygwt;
IremitSenderMaintenance.DialogAdminLogin = (function(){
	var cls_instance = pyjs__class_instance('DialogAdminLogin');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f705ce8a1d011b2da8052e1c77bc417b';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var cell_format,label_email,grid,label_password;
		self.parent = parent;
		self.remote_service = IremitSenderMaintenance.IremitSenderMaintenanceService();
		grid = IremitSenderMaintenance.Grid(3, 2);
		label_email = IremitSenderMaintenance.Label(String('Email :'));
		label_password = IremitSenderMaintenance.Label(String('Password :'));
		self.text_box_email = IremitSenderMaintenance.TextBox();
		self.text_box_password = IremitSenderMaintenance.PasswordTextBox();
		self.button_login = IremitSenderMaintenance.Button(String('Login'), (typeof self.OnClickLogin == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickLogin'):self.OnClickLogin));
		self.button_close = IremitSenderMaintenance.Button(String('Close'), (typeof self.RedirectToMainPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'RedirectToMainPage'):self.RedirectToMainPage));
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
		self.dialog_login = IremitSenderMaintenance.DialogBox();
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

		IremitSenderMaintenance.Window.setLocation(String('/portal/index.php'));
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
		width = IremitSenderMaintenance.Window.getClientWidth();
		height = IremitSenderMaintenance.Window.getClientHeight();
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
			self.parent.GetStaffAndSender();
		}
		else {
			IremitSenderMaintenance.Window.alert(String('Invalid Login!'));
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
IremitSenderMaintenance.IremitSenderMaintenance = (function(){
	var cls_instance = pyjs__class_instance('IremitSenderMaintenance');
	var cls_definition = new Object();
	cls_definition.__md5__ = '0e8521b727b0cff1fd0884f24c5e1a43';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_staff_name,label_select_staff,label_select_sender,vp,main_panel,panel_header,label_sender;
		self.remote_service = IremitSenderMaintenance.IremitSenderMaintenanceService();
		main_panel = IremitSenderMaintenance.VerticalPanel();
		main_panel.setWidth(String('100%'));
		main_panel.setHorizontalAlignment(String('center'));
		label_select_staff = IremitSenderMaintenance.Label(String('Select staff(s), select the sender below, then click the \x22Save\x22 button'));
		label_staff_name = IremitSenderMaintenance.Label(String('Staff Name'));
		label_sender = IremitSenderMaintenance.Label(String('Sender'));
		label_select_sender = IremitSenderMaintenance.Label(String('Select sender :'));
		self.listbox_sender = IremitSenderMaintenance.ListBox();
		self.button_save = IremitSenderMaintenance.Button(String('Save'), (typeof self.OnClickSave == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickSave'):self.OnClickSave));
		self.button_save.setEnabled(false);
		self.status = IremitSenderMaintenance.Label();
		panel_header = IremitSenderMaintenance.HorizontalPanel();
		panel_header.setWidth(String('100%'));
		panel_header.add(label_staff_name);
		panel_header.add(label_sender);
		self.scroll_panel_staff = IremitSenderMaintenance.ScrollPanel();
		self.scroll_panel_staff.setWidth(String('100%'));
		self.scroll_panel_staff.setHeight(String('380'));
		self.panel_select_sender = IremitSenderMaintenance.HorizontalPanel();
		self.panel_select_sender.setVerticalAlignment(String('middle'));
		self.panel_select_sender.setSpacing(8);
		self.panel_select_sender.add(label_select_sender);
		self.panel_select_sender.add((typeof self.listbox_sender == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_sender'):self.listbox_sender));
		self.panel_select_sender.add((typeof self.button_save == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_save'):self.button_save));
		vp = IremitSenderMaintenance.VerticalPanel();
		vp.setWidth(String('480px'));
		vp.setHorizontalAlignment(String('center'));
		vp.add(label_select_staff);
		vp.add(panel_header);
		vp.add((typeof self.scroll_panel_staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'scroll_panel_staff'):self.scroll_panel_staff));
		vp.add((typeof self.panel_select_sender == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_select_sender'):self.panel_select_sender));
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		main_panel.add(vp);
		IremitSenderMaintenance.RootPanel().add(main_panel);
		self.admin_login_dialog = IremitSenderMaintenance.DialogAdminLogin(self);
		self.GetStaffAndSender();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.GetStaffAndSender = pyjs__bind_method(cls_instance, 'GetStaffAndSender', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.id_get_staff_and_senders = self.remote_service.get_staff_and_sender_list(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickSave = pyjs__bind_method(cls_instance, 'OnClickSave', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var selected_staffs,checkbox,sender_id;
		sender_id = self.listbox_sender.getValue(self.listbox_sender.getSelectedIndex());
		selected_staffs = new pyjslib.List([]);
		var __checkbox = self.checkbox_staffs.__iter__();
		try {
			while (true) {
				var checkbox = __checkbox.next();
				
				if (pyjslib.bool(checkbox.isChecked())) {
					selected_staffs.append(checkbox.getName());
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(selected_staffs), 0))) {
			IremitSenderMaintenance.Window.alert(String('Please select staff to assign its sender.'));
			return null;
		}
		self.id_set_sender = self.remote_service.set_sender(sender_id, selected_staffs, self);
		self.button_save.setEnabled(false);
		self.scroll_panel_staff.clear();
		self.scroll_panel_staff.setWidget(IremitSenderMaintenance.Label(String('Please Wait...')));
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.RenderSender = pyjs__bind_method(cls_instance, 'RenderSender', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var sender;
		self.listbox_sender.clear();
		self.senders = new pyjslib.Dict([]);
		var __sender = data.__iter__();
		try {
			while (true) {
				var sender = __sender.next();
				
				(typeof self.senders == 'function' && self.__is_instance__?pyjslib.getattr(self, 'senders'):self.senders).__setitem__(sender.__getitem__(String('id')),  (  ( sender.__getitem__(String('first_name')) + String(' ') )  + sender.__getitem__(String('last_name')) ) );
				self.listbox_sender.addItem( (  ( sender.__getitem__(String('first_name')) + String(' ') )  + sender.__getitem__(String('last_name')) ) , sender.__getitem__(String('id')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.RenderStaffGrid = pyjs__bind_method(cls_instance, 'RenderStaffGrid', function(not_on_the_list, on_the_list) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			not_on_the_list = arguments[1];
			on_the_list = arguments[2];
		}
		var staff_name,checkbox,i,current_row_format,row_formatter,label_sender;
		self.scroll_panel_staff.clear();
		self.grid_staff = IremitSenderMaintenance.Grid( ( pyjslib.len(not_on_the_list) + pyjslib.len(on_the_list) ) , 2);
		self.grid_staff.setWidth(String('100%'));
		self.scroll_panel_staff.setWidget((typeof self.grid_staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_staff'):self.grid_staff));
		self.checkbox_staffs = new pyjslib.List([]);
		var __i = pyjslib.range(pyjslib.len(not_on_the_list)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				staff_name =  (  ( not_on_the_list.__getitem__(i).__getitem__(String('fname')) + String(' ') )  + not_on_the_list.__getitem__(i).__getitem__(String('lname')) ) ;
				checkbox = IremitSenderMaintenance.CheckBox(staff_name);
				checkbox.setName(not_on_the_list.__getitem__(i).__getitem__(String('userid')));
				self.checkbox_staffs.append(checkbox);
				self.grid_staff.setWidget(i, 0, checkbox);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		var __i = pyjslib.range(pyjslib.len(on_the_list)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				staff_name =  (  ( on_the_list.__getitem__(i).__getitem__(String('fname')) + String(' ') )  + on_the_list.__getitem__(i).__getitem__(String('lname')) ) ;
				checkbox = IremitSenderMaintenance.CheckBox(staff_name);
				checkbox.setName(on_the_list.__getitem__(i).__getitem__(String('userid')));
				self.checkbox_staffs.append(checkbox);
				self.grid_staff.setWidget( ( i + pyjslib.len(not_on_the_list) ) , 0, checkbox);
				label_sender = IremitSenderMaintenance.Label((typeof self.senders == 'function' && self.__is_instance__?pyjslib.getattr(self, 'senders'):self.senders).__getitem__(on_the_list.__getitem__(i).__getitem__(String('sender_id'))));
				self.grid_staff.setWidget( ( i + pyjslib.len(not_on_the_list) ) , 1, label_sender);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		row_formatter = self.grid_staff.getRowFormatter();
		current_row_format = String('row_even');
		var __i = pyjslib.range( ( pyjslib.len(on_the_list) + pyjslib.len(not_on_the_list) ) ).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(pyjslib.eq(current_row_format, String('row_even')))) {
					current_row_format = String('row_odd');
				}
				else {
					current_row_format = String('row_even');
				}
				row_formatter.addStyleName(i, current_row_format);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'not_on_the_list', 'on_the_list']);
	cls_definition.onRemoteResponse = pyjs__bind_method(cls_instance, 'onRemoteResponse', function(response, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
			request_info = arguments[2];
		}

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_staff_and_senders == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_staff_and_senders'):self.id_get_staff_and_senders)))) {
			self.RenderSender(response.__getitem__(String('senders')));
			self.RenderStaffGrid(response.__getitem__(String('not_on_the_list')), response.__getitem__(String('staff_on_list')));
			self.button_save.setEnabled(true);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_set_sender == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_set_sender'):self.id_set_sender)))) {
			self.GetStaffAndSender();
		}
		else {
			pyjslib.printFunc([response], 1);
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
IremitSenderMaintenance.IremitSenderMaintenanceService = (function(){
	var cls_instance = pyjs__class_instance('IremitSenderMaintenanceService');
	var cls_definition = new Object();
	cls_definition.__md5__ = '4614772cc6584118064b1c42f9562269';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		IremitSenderMaintenance.JSONProxy.__init__(self, String('/portal/invoice/IremitSenderMaintenanceService.php'), new pyjslib.List([String('login'), String('get_staff_and_sender_list'), String('set_sender')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(IremitSenderMaintenance.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(IremitSenderMaintenance.__name__, String('__main__')))) {
	IremitSenderMaintenance.app = IremitSenderMaintenance.IremitSenderMaintenance();
	IremitSenderMaintenance.app.onModuleLoad();
}
return this;
}; /* end IremitSenderMaintenance */
$pyjs.modules_hash['IremitSenderMaintenance'] = $pyjs.loaded_modules['IremitSenderMaintenance'];


 /* end module: IremitSenderMaintenance */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox', 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox', 'pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel', 'pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel', 'pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar', 'pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.log', 'pygwt']
*/
