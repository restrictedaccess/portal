/* start module: UpdateTimeSheet */
var UpdateTimeSheet = $pyjs.loaded_modules["UpdateTimeSheet"] = function (__mod_name__) {
if(UpdateTimeSheet.__was_initialized__) return UpdateTimeSheet;
UpdateTimeSheet.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'UpdateTimeSheet';
var __name__ = UpdateTimeSheet.__name__ = __mod_name__;
pyjslib.__import__(['pyjd'], 'pyjd', 'UpdateTimeSheet');
UpdateTimeSheet.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'UpdateTimeSheet');
UpdateTimeSheet.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'UpdateTimeSheet');
UpdateTimeSheet.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'UpdateTimeSheet');
UpdateTimeSheet.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'UpdateTimeSheet');
UpdateTimeSheet.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'UpdateTimeSheet');
UpdateTimeSheet.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'UpdateTimeSheet');
UpdateTimeSheet.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'UpdateTimeSheet');
UpdateTimeSheet.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'UpdateTimeSheet');
UpdateTimeSheet.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'UpdateTimeSheet');
UpdateTimeSheet.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'UpdateTimeSheet');
UpdateTimeSheet.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'UpdateTimeSheet');
UpdateTimeSheet.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.ui.AutoComplete.AutoCompleteTextBox', 'pyjamas.ui.AutoComplete'], 'pyjamas.ui.AutoComplete.AutoCompleteTextBox', 'UpdateTimeSheet');
UpdateTimeSheet.AutoCompleteTextBox = $pyjs.__modules__.pyjamas.ui.AutoComplete.AutoCompleteTextBox;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'UpdateTimeSheet');
UpdateTimeSheet.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'UpdateTimeSheet');
UpdateTimeSheet.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'UpdateTimeSheet');
UpdateTimeSheet.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'UpdateTimeSheet');
UpdateTimeSheet.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox'], 'pyjamas.ui.DialogBox.DialogBox', 'UpdateTimeSheet');
UpdateTimeSheet.DialogBox = $pyjs.__modules__.pyjamas.ui.DialogBox.DialogBox;
pyjslib.__import__(['pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel'], 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'UpdateTimeSheet');
UpdateTimeSheet.AbsolutePanel = $pyjs.__modules__.pyjamas.ui.AbsolutePanel.AbsolutePanel;
pyjslib.__import__(['pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox'], 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'UpdateTimeSheet');
UpdateTimeSheet.PasswordTextBox = $pyjs.__modules__.pyjamas.ui.PasswordTextBox.PasswordTextBox;
pyjslib.__import__(['pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel'], 'pyjamas.ui.TabPanel.TabPanel', 'UpdateTimeSheet');
UpdateTimeSheet.TabPanel = $pyjs.__modules__.pyjamas.ui.TabPanel.TabPanel;
pyjslib.__import__(['pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel'], 'pyjamas.ui.CaptionPanel.CaptionPanel', 'UpdateTimeSheet');
UpdateTimeSheet.CaptionPanel = $pyjs.__modules__.pyjamas.ui.CaptionPanel.CaptionPanel;
pyjslib.__import__(['pyjamas.ui.TextArea.TextArea', 'pyjamas.ui.TextArea'], 'pyjamas.ui.TextArea.TextArea', 'UpdateTimeSheet');
UpdateTimeSheet.TextArea = $pyjs.__modules__.pyjamas.ui.TextArea.TextArea;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'UpdateTimeSheet');
UpdateTimeSheet.log = $pyjs.__modules__.pyjamas.log;
pyjslib.__import__(['pygwt'], 'pygwt', 'UpdateTimeSheet');
UpdateTimeSheet.pygwt = $pyjs.__modules__.pygwt;
UpdateTimeSheet.DialogAdminLogin = (function(){
	var cls_instance = pyjs__class_instance('DialogAdminLogin');
	var cls_definition = new Object();
	cls_definition.__md5__ = '119a72caa821a6728def7fd0b212de8f';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var cell_format,label_email,grid,label_password;
		self.parent = parent;
		self.remote_service = UpdateTimeSheet.UpdateTimeSheetService();
		grid = UpdateTimeSheet.Grid(3, 2);
		label_email = UpdateTimeSheet.Label(String('Email :'));
		label_password = UpdateTimeSheet.Label(String('Password :'));
		self.text_box_email = UpdateTimeSheet.TextBox();
		self.text_box_password = UpdateTimeSheet.PasswordTextBox();
		self.button_login = UpdateTimeSheet.Button(String('Login'), (typeof self.OnClickLogin == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickLogin'):self.OnClickLogin));
		self.button_close = UpdateTimeSheet.Button(String('Close'), (typeof self.RedirectToMainPage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'RedirectToMainPage'):self.RedirectToMainPage));
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
		self.dialog_login = UpdateTimeSheet.DialogBox();
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

		UpdateTimeSheet.Window.setLocation(String('/portal/'));
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
		width = UpdateTimeSheet.Window.getClientWidth();
		height = UpdateTimeSheet.Window.getClientHeight();
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
			self.parent.GetMonths();
		}
		else {
			UpdateTimeSheet.Window.alert(String('Invalid Login!'));
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
UpdateTimeSheet.DialogTimeSheetNotes = (function(){
	var cls_instance = pyjs__class_instance('DialogTimeSheetNotes');
	var cls_definition = new Object();
	cls_definition.__md5__ = '371f53a51b0bb840055b1b28a4c069fe';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent, top, left, timesheet_details_id, row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
			top = arguments[2];
			left = arguments[3];
			timesheet_details_id = arguments[4];
			row = arguments[5];
		}
		var panel_button,contents,label_new_note;
		self.parent = parent;
		self.remote_service = UpdateTimeSheet.UpdateTimeSheetService();
		self.timesheet_details_id = timesheet_details_id;
		self.row = row;
		self.scroll_panel = pyjs_kwargs_call(UpdateTimeSheet, 'ScrollPanel', null, null, [{Width:String('100%'), Height:String('88px')}]);
		label_new_note = UpdateTimeSheet.Label(String('New Note'));
		self.new_note = pyjs_kwargs_call(UpdateTimeSheet, 'TextArea', null, null, [{VisibleLines:4}]);
		self.new_note.setWidth(String('100%'));
		self.button_add_note = UpdateTimeSheet.Button(String('Add Note'), (typeof self.onClickAddNote == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickAddNote'):self.onClickAddNote));
		self.button_close = UpdateTimeSheet.Button(String('Close'), (typeof self.onClickClose == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickClose'):self.onClickClose));
		contents = UpdateTimeSheet.VerticalPanel();
		contents.setSpacing(4);
		contents.setWidth(String('400px'));
		contents.add((typeof self.scroll_panel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'scroll_panel'):self.scroll_panel));
		contents.add(label_new_note);
		contents.add((typeof self.new_note == 'function' && self.__is_instance__?pyjslib.getattr(self, 'new_note'):self.new_note));
		panel_button = UpdateTimeSheet.HorizontalPanel();
		panel_button.add((typeof self.button_add_note == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_add_note'):self.button_add_note));
		panel_button.add((typeof self.button_close == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_close'):self.button_close));
		contents.add(panel_button);
		self.LoadNotes();
		self.dialog = UpdateTimeSheet.DialogBox();
		self.dialog.setHTML(String('\x3Cb\x3ENotes\x3C/b\x3E'));
		self.dialog.setWidget(contents);
		self.dialog.setPopupPosition(left, top);
		self.dialog.show();
		return null;
	}
	, 1, [null,null,'self', 'parent', 'top', 'left', 'timesheet_details_id', 'row']);
	cls_definition.LoadNotes = pyjs__bind_method(cls_instance, 'LoadNotes', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var current_row_format,i,row_formatter,grid_notes,notes;
		notes = (typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details).__getitem__((typeof self.row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row'):self.row)).__getitem__(String('notes'));
		grid_notes = UpdateTimeSheet.Grid(pyjslib.len(notes), 3);
		row_formatter = grid_notes.getRowFormatter();
		grid_notes.setWidth(String('100%'));
		current_row_format = String('row_even');
		var __i = pyjslib.range(pyjslib.len(notes)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				grid_notes.setWidget(i, 0, UpdateTimeSheet.Label(notes.__getitem__(i).__getitem__(String('fname'))));
				grid_notes.setWidget(i, 1, UpdateTimeSheet.Label(notes.__getitem__(i).__getitem__(String('note'))));
				grid_notes.setWidget(i, 2, UpdateTimeSheet.Label(notes.__getitem__(i).__getitem__(String('timestamp'))));
				if (pyjslib.bool(pyjslib.eq(current_row_format, String('row_even')))) {
					current_row_format = String('row_odd');
				}
				else {
					current_row_format = String('row_even');
				}
				row_formatter.addStyleName(i, current_row_format);
				row_formatter.addStyleName(i, String('size_12'));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.scroll_panel.setWidget(grid_notes);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onClickClose = pyjs__bind_method(cls_instance, 'onClickClose', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.dialog.hide();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onClickAddNote = pyjs__bind_method(cls_instance, 'onClickAddNote', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var note;
		note = self.new_note.getText();
		if (pyjslib.bool(pyjslib.eq(note, String('')))) {
			UpdateTimeSheet.Window.alert(String('Blank note not allowed!'));
			return null;
		}
		self.button_add_note.setEnabled(false);
		self.button_close.setEnabled(false);
		self.new_note.setEnabled(false);
		self.id_add_note = self.remote_service.add_note((typeof self.timesheet_details_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details_id'):self.timesheet_details_id), note, self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.NewTimesheetNotes = pyjs__bind_method(cls_instance, 'NewTimesheetNotes', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i,notes_display,notes;
		(typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details).__getitem__((typeof self.row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row'):self.row)).__setitem__(String('notes'), data);
		self.dialog.hide();
		notes_display = String('');
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				notes_display += pyjslib.sprintf(String(' %s'), data.__getitem__(i).__getitem__(String('note')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(pyjslib.eq(notes_display, String('')))) {
			notes_display = String('\x3CClick to add notes\x3E');
		}
		notes = pyjs_kwargs_call(UpdateTimeSheet, 'Label', null, null, [{wordWrap:false}, notes_display]);
		notes.setStyleName(String('col_notes'));
		self.parent.grid_timesheet.setWidget((typeof self.row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row'):self.row), 14, notes);
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_add_note == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_add_note'):self.id_add_note)))) {
			self.NewTimesheetNotes(response);
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
UpdateTimeSheet.DialogUpdateHrs = (function(){
	var cls_instance = pyjs__class_instance('DialogUpdateHrs');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'fd45559d7edf1a73b31f9eabcb8ed277';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent, title, top, left, id, field_name) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
			title = arguments[2];
			top = arguments[3];
			left = arguments[4];
			id = arguments[5];
			field_name = arguments[6];
		}
		var panel_button,contents;
		self.remote_service = UpdateTimeSheet.UpdateTimeSheetService();
		self.id = id;
		self.field_name = field_name;
		self.parent = parent;
		contents = UpdateTimeSheet.VerticalPanel();
		contents.setSpacing(4);
		self.edit_new_time = UpdateTimeSheet.TextBox();
		self.edit_new_time.setWidth(String('48px'));
		contents.add((typeof self.edit_new_time == 'function' && self.__is_instance__?pyjslib.getattr(self, 'edit_new_time'):self.edit_new_time));
		contents.setCellHorizontalAlignment((typeof self.edit_new_time == 'function' && self.__is_instance__?pyjslib.getattr(self, 'edit_new_time'):self.edit_new_time), String('CENTER'));
		panel_button = UpdateTimeSheet.HorizontalPanel();
		self.button_click_adjust = UpdateTimeSheet.Button(String('Adjust'), (typeof self.onClickAdjustHrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickAdjustHrs'):self.onClickAdjustHrs));
		self.button_close = UpdateTimeSheet.Button(String('Close'), (typeof self.onClickClose == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickClose'):self.onClickClose));
		panel_button.add((typeof self.button_click_adjust == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_click_adjust'):self.button_click_adjust));
		panel_button.add((typeof self.button_close == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_close'):self.button_close));
		contents.add(panel_button);
		contents.setStyleName(String('Contents'));
		self.dialog = UpdateTimeSheet.DialogBox();
		self.dialog.setHTML(pyjslib.sprintf(String('\x3Cb\x3E%s\x3C/b\x3E'), title));
		self.dialog.setWidget(contents);
		self.dialog.setPopupPosition(left, top);
		self.dialog.show();
		self.edit_new_time.setFocus(true);
		return null;
	}
	, 1, [null,null,'self', 'parent', 'title', 'top', 'left', 'id', 'field_name']);
	cls_definition.onClickClose = pyjs__bind_method(cls_instance, 'onClickClose', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.dialog.hide();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onClickAdjustHrs = pyjs__bind_method(cls_instance, 'onClickAdjustHrs', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var hrs;
		self.button_click_adjust.setEnabled(false);
		self.button_close.setEnabled(false);
		self.edit_new_time.setEnabled(false);
		self.dialog.setHTML(String('Please Wait...'));
		hrs = self.edit_new_time.getText();
		self.id_remote_service = self.remote_service.update_hrs((typeof self.id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id'):self.id), hrs, (typeof self.field_name == 'function' && self.__is_instance__?pyjslib.getattr(self, 'field_name'):self.field_name), self);
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_remote_service == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_remote_service'):self.id_remote_service)))) {
			self.parent.UpdateAdjustedHours(response);
			self.dialog.hide();
		}
		else {
			self.dialog.hide();
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
UpdateTimeSheet.DialogAutoUpdateHrs = (function(){
	var cls_instance = pyjs__class_instance('DialogAutoUpdateHrs');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'a7e230afd820f3eeaa4a4210f937dd80';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var cell_format,height,width,grid_mode,contents;
		self.parent = parent;
		self.remote_service = UpdateTimeSheet.UpdateTimeSheetService();
		contents = UpdateTimeSheet.VerticalPanel();
		contents.setSpacing(4);
		contents.setHorizontalAlignment(String('center'));
		grid_mode = UpdateTimeSheet.Grid(4, 2);
		grid_mode.setWidget(0, 0, UpdateTimeSheet.Label(String('Select Field to Adjust:')));
		self.list_box_field_adjust = UpdateTimeSheet.ListBox();
		self.list_box_field_adjust.addItem(String('Adj Hrs'), String('adj_hrs'));
		self.list_box_field_adjust.addItem(String('Hrs Pay to Sub Con'), String('hrs_to_be_subcon'));
		self.list_box_field_adjust.addItem(String('Hrs Chrg to Client'), String('hrs_charged_to_client'));
		grid_mode.setWidget(0, 1, (typeof self.list_box_field_adjust == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_field_adjust'):self.list_box_field_adjust));
		grid_mode.setWidget(1, 0, UpdateTimeSheet.Label(String('Select Basis:')));
		self.list_box_basis = UpdateTimeSheet.ListBox();
		self.list_box_basis.addItem(String('Regular Rostered Hours'), String('regular_rostered'));
		self.list_box_basis.addItem(String('Adj Hrs'), String('adj_hrs'));
		self.list_box_basis.addItem(String('Total Hours'), String('total_hrs'));
		grid_mode.setWidget(1, 1, (typeof self.list_box_basis == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_basis'):self.list_box_basis));
		self.scrollpanel_log = UpdateTimeSheet.ScrollPanel();
		self.scrollpanel_log.setHeight(0);
		grid_mode.setWidget(2, 0, (typeof self.scrollpanel_log == 'function' && self.__is_instance__?pyjslib.getattr(self, 'scrollpanel_log'):self.scrollpanel_log));
		self.button_auto_adjust = UpdateTimeSheet.Button(String('Auto Adjust'), (typeof self.OnClickAutoAdjust == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickAutoAdjust'):self.OnClickAutoAdjust));
		self.button_close = UpdateTimeSheet.Button(String('Close'), (typeof self.OnClickClose == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickClose'):self.OnClickClose));
		grid_mode.setWidget(3, 0, (typeof self.button_auto_adjust == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_auto_adjust'):self.button_auto_adjust));
		grid_mode.setWidget(3, 1, (typeof self.button_close == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_close'):self.button_close));
		cell_format = grid_mode.getCellFormatter();
		cell_format.setHorizontalAlignment(0, 0, String('right'));
		cell_format.setHorizontalAlignment(1, 0, String('right'));
		cell_format.setAttr(2, 0, String('colSpan'), String('2'));
		cell_format.setHorizontalAlignment(3, 0, String('right'));
		grid_mode.setCellFormatter(cell_format);
		contents.add(grid_mode);
		self.dialog = UpdateTimeSheet.DialogBox();
		self.dialog.setHTML(String('\x3Cb\x3EAuto Adjust Hrs\x3C/b\x3E'));
		self.dialog.setWidget(contents);
		width = UpdateTimeSheet.Window.getClientWidth();
		height = UpdateTimeSheet.Window.getClientHeight();
		self.dialog.setPopupPosition( (  ( width - 200 )  / 2 ) ,  (  ( height - 100 )  / 2 ) );
		self.dialog.show();
		return null;
	}
	, 1, [null,null,'self', 'parent']);
	cls_definition.OnClickAutoAdjust = pyjs__bind_method(cls_instance, 'OnClickAutoAdjust', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var confirm;
		if (pyjslib.bool(pyjslib.eq(self.list_box_field_adjust.getValue(self.list_box_field_adjust.getSelectedIndex()), self.list_box_basis.getValue(self.list_box_basis.getSelectedIndex())))) {
			UpdateTimeSheet.Window.alert(String('There\x27s no point in adjusting the same columns/field'));
			return null;
		}
		confirm = UpdateTimeSheet.Window.confirm(String('Are you sure you want to Auto Adjust?'));
		if (pyjslib.bool(!pyjslib.eq(confirm, true))) {
			return null;
		}
		self.scrollpanel_log.setHeight(80);
		self.vp_logs = UpdateTimeSheet.VerticalPanel();
		self.scrollpanel_log.add((typeof self.vp_logs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp_logs'):self.vp_logs));
		self.current_row = 0;
		self.AdjustHrs();
		self.DisableWidgets();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.DisableWidgets = pyjs__bind_method(cls_instance, 'DisableWidgets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.list_box_field_adjust.setEnabled(false);
		self.list_box_basis.setEnabled(false);
		self.button_auto_adjust.setEnabled(false);
		self.button_close.setEnabled(false);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.EnableWidgets = pyjs__bind_method(cls_instance, 'EnableWidgets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.list_box_field_adjust.setEnabled(true);
		self.list_box_basis.setEnabled(true);
		self.button_auto_adjust.setEnabled(true);
		self.button_close.setEnabled(true);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.AdjustHrs = pyjs__bind_method(cls_instance, 'AdjustHrs', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var field_name,id,hrs;
		id = (typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details).__getitem__((typeof self.current_row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'current_row'):self.current_row)).__getitem__(String('id'));
		if (pyjslib.bool(pyjslib.eq(self.list_box_basis.getValue(self.list_box_basis.getSelectedIndex()), String('regular_rostered')))) {
			hrs = (typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details).__getitem__((typeof self.current_row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'current_row'):self.current_row)).__getitem__(String('regular_rostered_hrs'));
		}
		else if (pyjslib.bool(pyjslib.eq(self.list_box_basis.getValue(self.list_box_basis.getSelectedIndex()), String('total_hrs')))) {
			hrs = (typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details).__getitem__((typeof self.current_row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'current_row'):self.current_row)).__getitem__(String('total_hrs'));
		}
		else if (pyjslib.bool(pyjslib.eq(self.list_box_basis.getValue(self.list_box_basis.getSelectedIndex()), String('adj_hrs')))) {
			hrs = (typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details).__getitem__((typeof self.current_row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'current_row'):self.current_row)).__getitem__(String('adjusted_hrs'));
		}
		else {
			hrs = 0;
		}
		field_name = self.list_box_field_adjust.getValue(self.list_box_field_adjust.getSelectedIndex());
		self.id_adj_hrs = self.remote_service.update_hrs(id, hrs, field_name, self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickClose = pyjs__bind_method(cls_instance, 'OnClickClose', function() {
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
		var label;
		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_adj_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_adj_hrs'):self.id_adj_hrs)))) {
			label = UpdateTimeSheet.Label(pyjslib.sprintf(String('Adjusted date %s'), (typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details).__getitem__((typeof self.current_row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'current_row'):self.current_row)).__getitem__(String('date'))));
			self.vp_logs.add(label);
			self.scrollpanel_log.ensureVisible(label);
			self.current_row += 1;
			if (pyjslib.bool((pyjslib.cmp((typeof self.current_row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'current_row'):self.current_row), pyjslib.len((typeof self.parent.timesheet_details == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_details'):self.parent.timesheet_details))) == -1))) {
				self.AdjustHrs();
			}
			else {
				UpdateTimeSheet.Window.alert(String('Updating finished.'));
				self.EnableWidgets();
				self.dialog.hide();
				self.parent.GetTimesheetDetails((typeof self.parent.timesheet_id == 'function' && self.parent.__is_instance__?pyjslib.getattr(self.parent, 'timesheet_id'):self.parent.timesheet_id));
			}
		}
		else {
			self.dialog.hide();
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
UpdateTimeSheet.TabPanelListByClient = (function(){
	var cls_instance = pyjs__class_instance('TabPanelListByClient');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f04c7b4395901e71b7a5f7b2ca65b4be';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var cell_format,panel_client,panel_month,panel_staff;
		self.parent = parent;
		self.hp = UpdateTimeSheet.Grid(1, 3);
		self.remote_service = UpdateTimeSheet.UpdateTimeSheetService();
		panel_month = UpdateTimeSheet.CaptionPanel(String('Select Month'));
		self.list_box_month = pyjs_kwargs_call(UpdateTimeSheet, 'ListBox', null, null, [{Width:String('100%')}]);
		self.list_box_month.setVisibleItemCount(8);
		self.list_box_month.addChangeListener((typeof self.OnMonthSelect == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnMonthSelect'):self.OnMonthSelect));
		panel_month.add((typeof self.list_box_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_month'):self.list_box_month));
		self.hp.setWidget(0, 0, panel_month);
		cell_format = self.hp.getCellFormatter();
		cell_format.setWidth(0, 0, String('20%'));
		cell_format.setWidth(0, 1, String('40%'));
		cell_format.setWidth(0, 2, String('40%'));
		self.hp.setCellFormatter(cell_format);
		panel_client = UpdateTimeSheet.CaptionPanel(String('Select Client'));
		self.list_box_client = pyjs_kwargs_call(UpdateTimeSheet, 'ListBox', null, null, [{Width:String('100%')}]);
		self.list_box_client.setVisibleItemCount(8);
		self.list_box_client.addChangeListener((typeof self.OnClientSelect == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClientSelect'):self.OnClientSelect));
		panel_client.add((typeof self.list_box_client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_client'):self.list_box_client));
		self.hp.setWidget(0, 1, panel_client);
		panel_staff = UpdateTimeSheet.CaptionPanel(String('Select Staff'));
		self.list_box_staff = pyjs_kwargs_call(UpdateTimeSheet, 'ListBox', null, null, [{Width:String('100%')}]);
		self.list_box_staff.setVisibleItemCount(8);
		self.list_box_staff.addChangeListener((typeof self.OnStaffSelect == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnStaffSelect'):self.OnStaffSelect));
		panel_staff.add((typeof self.list_box_staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_staff'):self.list_box_staff));
		self.hp.setWidget(0, 2, panel_staff);
		return null;
	}
	, 1, [null,null,'self', 'parent']);
	cls_definition.getWidget = pyjs__bind_method(cls_instance, 'getWidget', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.hp == 'function' && self.__is_instance__?pyjslib.getattr(self, 'hp'):self.hp);
	}
	, 1, [null,null,'self']);
	cls_definition.RenderMonthSelection = pyjs__bind_method(cls_instance, 'RenderMonthSelection', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i;
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_month.addItem(data.__getitem__(i).__getitem__(String('label')), data.__getitem__(i).__getitem__(String('date')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.ClearLists = pyjs__bind_method(cls_instance, 'ClearLists', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var i;
		self.list_box_client.clear();
		self.list_box_staff.clear();
		var __i = pyjslib.range(self.list_box_month.getItemCount()).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_month.setItemSelected(i, String(''));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClientSelect = pyjs__bind_method(cls_instance, 'OnClientSelect', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var date,leads_id;
		self.list_box_staff.clear();
		self.list_box_staff.addItem(String('Please wait...'), String(''));
		date = self.list_box_month.getValue(self.list_box_month.getSelectedIndex());
		leads_id = self.list_box_client.getValue(self.list_box_client.getSelectedIndex());
		self.id_get_client_staff_by_month = self.remote_service.get_client_staff_by_month(date, leads_id, self);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.OnMonthSelect = pyjs__bind_method(cls_instance, 'OnMonthSelect', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var date;
		self.list_box_client.clear();
		self.list_box_staff.clear();
		self.list_box_client.addItem(String('Please wait...'), String(''));
		date = self.list_box_month.getValue(self.list_box_month.getSelectedIndex());
		self.id_get_client_names_by_month = self.remote_service.get_client_names_by_month(date, self);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.RenderClients = pyjs__bind_method(cls_instance, 'RenderClients', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i;
		self.list_box_client.clear();
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.list_box_client.addItem(String('No Timesheets found.'));
			return null;
		}
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_client.addItem(pyjslib.sprintf(String('%s %s :: %s'), new pyjslib.Tuple([data.__getitem__(i).__getitem__(String('fname')), data.__getitem__(i).__getitem__(String('lname')), data.__getitem__(i).__getitem__(String('leads_id'))])), data.__getitem__(i).__getitem__(String('leads_id')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.parent.status.setText(String(''));
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.RenderStaffNames = pyjs__bind_method(cls_instance, 'RenderStaffNames', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i;
		self.list_box_staff.clear();
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_staff.addItem(pyjslib.sprintf(String('%s %s :: %s'), new pyjslib.Tuple([data.__getitem__(i).__getitem__(String('fname')), data.__getitem__(i).__getitem__(String('lname')), data.__getitem__(i).__getitem__(String('id'))])), data.__getitem__(i).__getitem__(String('id')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.parent.status.setText(String(''));
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.OnStaffSelect = pyjs__bind_method(cls_instance, 'OnStaffSelect', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var timesheet_id;
		timesheet_id = self.list_box_staff.getValue(self.list_box_staff.getSelectedIndex());
		self.parent.ClearTimesheetDetails();
		self.parent.GetTimesheetDetails(timesheet_id);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onRemoteResponse = pyjs__bind_method(cls_instance, 'onRemoteResponse', function(response, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
			request_info = arguments[2];
		}

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_client_names_by_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_client_names_by_month'):self.id_get_client_names_by_month)))) {
			self.RenderClients(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_client_staff_by_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_client_staff_by_month'):self.id_get_client_staff_by_month)))) {
			self.RenderStaffNames(response);
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
UpdateTimeSheet.TabPanelListByStaff = (function(){
	var cls_instance = pyjs__class_instance('TabPanelListByStaff');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'b72618b3c405db7f67f09f360dae375c';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var cell_format,panel_client,panel_month,panel_staff;
		self.parent = parent;
		self.hp = UpdateTimeSheet.Grid(1, 3);
		self.remote_service = UpdateTimeSheet.UpdateTimeSheetService();
		panel_month = UpdateTimeSheet.CaptionPanel(String('Select Month'));
		self.list_box_month = pyjs_kwargs_call(UpdateTimeSheet, 'ListBox', null, null, [{Width:String('100%')}]);
		self.list_box_month.setVisibleItemCount(8);
		self.list_box_month.addChangeListener((typeof self.OnMonthSelect == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnMonthSelect'):self.OnMonthSelect));
		panel_month.add((typeof self.list_box_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_month'):self.list_box_month));
		self.hp.setWidget(0, 0, panel_month);
		cell_format = self.hp.getCellFormatter();
		cell_format.setWidth(0, 0, String('20%'));
		cell_format.setWidth(0, 1, String('40%'));
		cell_format.setWidth(0, 2, String('40%'));
		self.hp.setCellFormatter(cell_format);
		panel_staff = UpdateTimeSheet.CaptionPanel(String('Select Staff'));
		self.list_box_staff = pyjs_kwargs_call(UpdateTimeSheet, 'ListBox', null, null, [{Width:String('100%')}]);
		self.list_box_staff.setVisibleItemCount(8);
		self.list_box_staff.addChangeListener((typeof self.OnStaffSelect == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnStaffSelect'):self.OnStaffSelect));
		panel_staff.add((typeof self.list_box_staff == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_staff'):self.list_box_staff));
		self.hp.setWidget(0, 1, panel_staff);
		panel_client = UpdateTimeSheet.CaptionPanel(String('Select Client'));
		self.list_box_client = pyjs_kwargs_call(UpdateTimeSheet, 'ListBox', null, null, [{Width:String('100%')}]);
		self.list_box_client.setVisibleItemCount(8);
		self.list_box_client.addChangeListener((typeof self.OnClientSelect == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClientSelect'):self.OnClientSelect));
		panel_client.add((typeof self.list_box_client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_client'):self.list_box_client));
		self.hp.setWidget(0, 2, panel_client);
		return null;
	}
	, 1, [null,null,'self', 'parent']);
	cls_definition.getWidget = pyjs__bind_method(cls_instance, 'getWidget', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.hp == 'function' && self.__is_instance__?pyjslib.getattr(self, 'hp'):self.hp);
	}
	, 1, [null,null,'self']);
	cls_definition.OnClientSelect = pyjs__bind_method(cls_instance, 'OnClientSelect', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var timesheet_id;
		timesheet_id = self.list_box_client.getValue(self.list_box_client.getSelectedIndex());
		self.parent.ClearTimesheetDetails();
		self.parent.GetTimesheetDetails(timesheet_id);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderMonthSelection = pyjs__bind_method(cls_instance, 'RenderMonthSelection', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i;
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_month.addItem(data.__getitem__(i).__getitem__(String('label')), data.__getitem__(i).__getitem__(String('date')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.OnMonthSelect = pyjs__bind_method(cls_instance, 'OnMonthSelect', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var date;
		self.list_box_staff.clear();
		self.list_box_client.clear();
		self.list_box_staff.addItem(String('Please wait...'), String(''));
		date = self.list_box_month.getValue(self.list_box_month.getSelectedIndex());
		self.id_get_staff_names_by_month = self.remote_service.get_staff_names_by_month(date, self);
		self.parent.ClearTimesheetDetails();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.RenderStaffNames = pyjs__bind_method(cls_instance, 'RenderStaffNames', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i;
		self.list_box_staff.clear();
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.list_box_staff.addItem(String('No Timesheets found.'), String(''));
		}
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_staff.addItem(pyjslib.sprintf(String('%s %s :: %s'), new pyjslib.Tuple([data.__getitem__(i).__getitem__(String('fname')), data.__getitem__(i).__getitem__(String('lname')), data.__getitem__(i).__getitem__(String('userid'))])), data.__getitem__(i).__getitem__(String('userid')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.OnStaffSelect = pyjs__bind_method(cls_instance, 'OnStaffSelect', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var date,userid;
		self.list_box_client.clear();
		date = self.list_box_month.getValue(self.list_box_month.getSelectedIndex());
		userid = self.list_box_staff.getValue(self.list_box_staff.getSelectedIndex());
		if (pyjslib.bool(pyjslib.eq(userid, String('')))) {
			return null;
		}
		self.list_box_client.addItem(String('Please wait...'));
		self.id_get_staff_clients = self.remote_service.get_staff_clients(date, userid, self);
		self.parent.ClearTimesheetDetails();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.RenderClients = pyjs__bind_method(cls_instance, 'RenderClients', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i;
		self.list_box_client.clear();
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_client.addItem(pyjslib.sprintf(String('%s %s :: %s'), new pyjslib.Tuple([data.__getitem__(i).__getitem__(String('fname')), data.__getitem__(i).__getitem__(String('lname')), data.__getitem__(i).__getitem__(String('id'))])), data.__getitem__(i).__getitem__(String('id')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.parent.status.setText(String(''));
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.ClearLists = pyjs__bind_method(cls_instance, 'ClearLists', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var i;
		self.list_box_client.clear();
		self.list_box_staff.clear();
		var __i = pyjslib.range(self.list_box_month.getItemCount()).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_month.setItemSelected(i, String(''));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_staff_names_by_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_staff_names_by_month'):self.id_get_staff_names_by_month)))) {
			self.RenderStaffNames(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_staff_clients == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_staff_clients'):self.id_get_staff_clients)))) {
			self.RenderClients(response);
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
UpdateTimeSheet.UpdateTimeSheet = (function(){
	var cls_instance = pyjs__class_instance('UpdateTimeSheet');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'd3a03aa8654042bd0cb795a4802f6c1c';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var vp,panel_stats,hp_timesheet_status,hp_special;
		self.userid = String('');
		self.clientid = String('');
		self.timesheet_id = String('');
		self.timesheet_status = String('');
		self.remote_service = UpdateTimeSheet.UpdateTimeSheetService();
		self.label_timesheet_id = UpdateTimeSheet.Label(String(''));
		self.label_timesheet_status = UpdateTimeSheet.Label(String(''));
		self.panel_invoice_link = UpdateTimeSheet.VerticalPanel();
		self.panel_client_invoice_link = UpdateTimeSheet.VerticalPanel();
		self.button_refresh_details = UpdateTimeSheet.Button(String('Refresh Details'), (typeof self.OnClickRefreshDetails == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickRefreshDetails'):self.OnClickRefreshDetails));
		self.button_refresh_details.setVisible(false);
		self.button_auto_adjust_hrs = UpdateTimeSheet.Button(String('Auto Adjust Hrs'), (typeof self.OnClickAutoAdjustHrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickAutoAdjustHrs'):self.OnClickAutoAdjustHrs));
		self.button_auto_adjust_hrs.setVisible(false);
		self.button_recompute_diff_chrg = UpdateTimeSheet.Button(String('Recompute Diff Charge to Client'), (typeof self.OnClickRecomputeDiffChrgToClient == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickRecomputeDiffChrgToClient'):self.OnClickRecomputeDiffChrgToClient));
		self.button_recompute_diff_chrg.setVisible(false);
		self.footer_grid = self.GetFooterGrid();
		self.panel_timesheet = pyjs_kwargs_call(UpdateTimeSheet, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('1024px'), String('288px')])}]);
		vp = UpdateTimeSheet.VerticalPanel();
		vp.setWidth(String('100%'));
		vp.setHorizontalAlignment(String('center'));
		vp.add(UpdateTimeSheet.HTML(String('\x3Ch2\x3EUpdate Time Sheet\x3C/h2\x3E')));
		self.tab_panel_top = UpdateTimeSheet.TabPanel();
		self.tab_panel_top.addTabListener(self);
		self.tab_panel_top.setID(String('tab_panel_top'));
		self.tab_panel_list_by_staff = UpdateTimeSheet.TabPanelListByStaff(self);
		self.tab_panel_top.add(self.tab_panel_list_by_staff.getWidget(), String('List By Staff'));
		self.tab_panel_list_by_client = UpdateTimeSheet.TabPanelListByClient(self);
		self.tab_panel_top.add(self.tab_panel_list_by_client.getWidget(), String('List By Client'));
		self.tab_panel_top.selectTab(0);
		self.tab_panel_top.setWidth(String('1024px'));
		vp.add((typeof self.tab_panel_top == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tab_panel_top'):self.tab_panel_top));
		self.panel_grid_header = UpdateTimeSheet.AbsolutePanel();
		self.panel_grid_header.setWidth(String('1024px'));
		self.panel_grid_header.setHeight(String('52px'));
		self.grid_header = self.GetHeaderGrid();
		self.panel_grid_header.add((typeof self.grid_header == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_header'):self.grid_header), 0, 0);
		vp.add((typeof self.panel_grid_header == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_grid_header'):self.panel_grid_header));
		self.panel_timesheet.setID(String('panel_timesheet'));
		vp.add((typeof self.panel_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_timesheet'):self.panel_timesheet));
		self.panel_grid_footer = UpdateTimeSheet.AbsolutePanel();
		self.panel_grid_footer.setWidth(String('1024px'));
		self.panel_grid_footer.setHeight(String('24px'));
		self.panel_grid_footer.add((typeof self.footer_grid == 'function' && self.__is_instance__?pyjslib.getattr(self, 'footer_grid'):self.footer_grid), 0, 0);
		vp.add((typeof self.panel_grid_footer == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_grid_footer'):self.panel_grid_footer));
		self.button_create_staff_invoice = UpdateTimeSheet.Button(String('Create Staff Invoice'), (typeof self.OnClickCreateStaffInvoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickCreateStaffInvoice'):self.OnClickCreateStaffInvoice));
		self.button_create_client_invoice = UpdateTimeSheet.Button(String('Create Client Invoice'), (typeof self.OnClickCreateClientInvoice == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickCreateClientInvoice'):self.OnClickCreateClientInvoice));
		self.button_create_client_invoice.setVisible(false);
		hp_timesheet_status = UpdateTimeSheet.HorizontalPanel();
		hp_timesheet_status.setSpacing(4);
		hp_timesheet_status.setWidth(String('1024px'));
		panel_stats = UpdateTimeSheet.VerticalPanel();
		panel_stats.add((typeof self.label_timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_timesheet_id'):self.label_timesheet_id));
		panel_stats.add((typeof self.label_timesheet_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_timesheet_status'):self.label_timesheet_status));
		hp_timesheet_status.add(panel_stats);
		hp_timesheet_status.add((typeof self.panel_invoice_link == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_invoice_link'):self.panel_invoice_link));
		hp_timesheet_status.add((typeof self.panel_client_invoice_link == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_client_invoice_link'):self.panel_client_invoice_link));
		vp.add(hp_timesheet_status);
		hp_special = UpdateTimeSheet.HorizontalPanel();
		hp_special.setSpacing(2);
		hp_special.add((typeof self.button_refresh_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_refresh_details'):self.button_refresh_details));
		hp_special.add((typeof self.button_auto_adjust_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_auto_adjust_hrs'):self.button_auto_adjust_hrs));
		hp_special.add((typeof self.button_recompute_diff_chrg == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_recompute_diff_chrg'):self.button_recompute_diff_chrg));
		vp.add(hp_special);
		self.status = UpdateTimeSheet.Label();
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		UpdateTimeSheet.RootPanel().add(vp);
		self.GetMonths();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickRecomputeDiffChrgToClient = pyjs__bind_method(cls_instance, 'OnClickRecomputeDiffChrgToClient', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), String('')))) {
			self.status.setText(String('No Time Sheet Available'));
			return null;
		}
		if (pyjslib.bool(pyjslib.eq(UpdateTimeSheet.Window.confirm(String('Are you sure you want to recompute Diff Charge to Client?')), false))) {
			return null;
		}
		self.button_refresh_details.setVisible(false);
		self.button_auto_adjust_hrs.setVisible(false);
		self.button_recompute_diff_chrg.setVisible(false);
		self.panel_timesheet.clear();
		self.panel_timesheet.add(UpdateTimeSheet.HTML(String('\x3Ch4\x3EPlease wait...\x3C/h4\x3E')));
		self.ClearTotals();
		self.id_recompute_diff_chrge_to_client = self.remote_service.recompute_diff_chrge_to_client((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), self);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.GetMonths = pyjs__bind_method(cls_instance, 'GetMonths', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.id_get_months = self.remote_service.get_months(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onTabSelected = pyjs__bind_method(cls_instance, 'onTabSelected', function(event, tabIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
			tabIndex = arguments[2];
		}

		self.ClearTimesheetDetails();
		self.tab_panel_list_by_staff.ClearLists();
		self.tab_panel_list_by_client.ClearLists();
		return null;
	}
	, 1, [null,null,'self', 'event', 'tabIndex']);
	cls_definition.onBeforeTabSelected = pyjs__bind_method(cls_instance, 'onBeforeTabSelected', function(event, tabIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
			tabIndex = arguments[2];
		}

		return true;
	}
	, 1, [null,null,'self', 'event', 'tabIndex']);
	cls_definition.OnClickAutoAdjustHrs = pyjs__bind_method(cls_instance, 'OnClickAutoAdjustHrs', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var dialog;
		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), String('')))) {
			UpdateTimeSheet.Window.alert(String('Nothing to update'));
			return null;
		}
		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details), String('')))) {
			UpdateTimeSheet.Window.alert(String('Nothing to update'));
			return null;
		}
		dialog = UpdateTimeSheet.DialogAutoUpdateHrs(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickCreateStaffInvoice = pyjs__bind_method(cls_instance, 'OnClickCreateStaffInvoice', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		UpdateTimeSheet.Window.alert(String('Not yet implemented.'));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickCreateClientInvoice = pyjs__bind_method(cls_instance, 'OnClickCreateClientInvoice', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		UpdateTimeSheet.Window.alert(String('Not yet implemented.'));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickRefreshDetails = pyjs__bind_method(cls_instance, 'OnClickRefreshDetails', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.button_refresh_details.setEnabled(false);
		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), String('')))) {
			UpdateTimeSheet.Window.alert(String('No Timesheet Selected'));
			return null;
		}
		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details), String('')))) {
			UpdateTimeSheet.Window.alert(String('No Timesheet Selected'));
			return null;
		}
		self.GetTimesheetDetails((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.GetFooterGrid = pyjs__bind_method(cls_instance, 'GetFooterGrid', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_time_out,label_fin_lunch,label_day,label_time_in,grid,label_date,label_notes,label_start_lunch;
		grid = UpdateTimeSheet.Grid(1, 15);
		grid.setBorderWidth(1);
		grid.setCellSpacing(0);
		grid.setStyleName(String('grid_header'));
		label_day = UpdateTimeSheet.Label(String(''));
		label_day.addStyleName(String('col_day'));
		grid.setWidget(0, 0, label_day);
		label_date = UpdateTimeSheet.Label(String(''));
		label_date.addStyleName(String('col_date'));
		grid.setWidget(0, 1, label_date);
		label_time_in = UpdateTimeSheet.Label(String(''));
		label_time_in.addStyleName(String('col_time'));
		grid.setWidget(0, 2, label_time_in);
		label_time_out = UpdateTimeSheet.Label(String(''));
		label_time_out.addStyleName(String('col_time'));
		grid.setWidget(0, 3, label_time_out);
		self.label_total_hrs = UpdateTimeSheet.Label(String('0.00'));
		self.label_total_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 4, (typeof self.label_total_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_total_hrs'):self.label_total_hrs));
		self.label_adj_hrs = UpdateTimeSheet.Label(String('0.00'));
		self.label_adj_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 5, (typeof self.label_adj_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_adj_hrs'):self.label_adj_hrs));
		self.label_reg_ros_hrs = UpdateTimeSheet.Label(String('0.00'));
		self.label_reg_ros_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 6, (typeof self.label_reg_ros_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_reg_ros_hrs'):self.label_reg_ros_hrs));
		self.label_hrs_chrg_client = UpdateTimeSheet.Label(String('0.00'));
		self.label_hrs_chrg_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 7, (typeof self.label_hrs_chrg_client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_hrs_chrg_client'):self.label_hrs_chrg_client));
		self.label_diff_chrg_client = UpdateTimeSheet.Label(String('0.00'));
		self.label_diff_chrg_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 8, (typeof self.label_diff_chrg_client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_diff_chrg_client'):self.label_diff_chrg_client));
		self.label_hrs_to_be_subcon = UpdateTimeSheet.Label(String('0.00'));
		self.label_hrs_to_be_subcon.addStyleName(String('col_hrs'));
		grid.setWidget(0, 9, (typeof self.label_hrs_to_be_subcon == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_hrs_to_be_subcon'):self.label_hrs_to_be_subcon));
		self.label_label_diff_pay_adj = UpdateTimeSheet.Label(String('0.00'));
		self.label_label_diff_pay_adj.addStyleName(String('col_hrs'));
		grid.setWidget(0, 10, (typeof self.label_label_diff_pay_adj == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_label_diff_pay_adj'):self.label_label_diff_pay_adj));
		self.label_lunch_hrs = UpdateTimeSheet.Label(String('0.00'));
		self.label_lunch_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 11, (typeof self.label_lunch_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_lunch_hrs'):self.label_lunch_hrs));
		label_start_lunch = UpdateTimeSheet.Label(String(''));
		label_start_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 12, label_start_lunch);
		label_fin_lunch = UpdateTimeSheet.Label(String(''));
		label_fin_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 13, label_fin_lunch);
		label_notes = UpdateTimeSheet.Label(String(''));
		label_notes.addStyleName(String('col_notes'));
		grid.setWidget(0, 14, label_notes);
		return grid;
	}
	, 1, [null,null,'self']);
	cls_definition.GetHeaderGrid = pyjs__bind_method(cls_instance, 'GetHeaderGrid', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_label_diff_pay_adj,label_lunch_hrs,label_notes,label_time_out,label_fin_lunch,label_hrs_chrg_client,label_day,label_reg_ros_hrs,label_time_in,grid,label_adj_hrs,label_date,label_start_lunch,label_hrs_to_be_subcon,label_total_hrs,label_diff_chrg_client;
		grid = UpdateTimeSheet.Grid(1, 15);
		grid.setBorderWidth(1);
		grid.setCellSpacing(0);
		grid.setStyleName(String('grid_header'));
		label_day = UpdateTimeSheet.Label(String('Day'));
		label_day.addStyleName(String('col_day'));
		grid.setWidget(0, 0, label_day);
		label_date = UpdateTimeSheet.Label(String('Date'));
		label_date.addStyleName(String('col_date'));
		grid.setWidget(0, 1, label_date);
		label_time_in = UpdateTimeSheet.Label(String('Time In'));
		label_time_in.addStyleName(String('col_time'));
		grid.setWidget(0, 2, label_time_in);
		label_time_out = UpdateTimeSheet.Label(String('Time Out'));
		label_time_out.addStyleName(String('col_time'));
		grid.setWidget(0, 3, label_time_out);
		label_total_hrs = UpdateTimeSheet.Label(String('Total Hrs'));
		label_total_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 4, label_total_hrs);
		label_adj_hrs = UpdateTimeSheet.Label(String('Adj Hrs'));
		label_adj_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 5, label_adj_hrs);
		label_reg_ros_hrs = UpdateTimeSheet.Label(String('Reg Ros Hrs'));
		label_reg_ros_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 6, label_reg_ros_hrs);
		label_hrs_chrg_client = UpdateTimeSheet.Label(String('Hrs Chrg to Client'));
		label_hrs_chrg_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 7, label_hrs_chrg_client);
		label_diff_chrg_client = UpdateTimeSheet.Label(String('Diff Chrg to Client'));
		label_diff_chrg_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 8, label_diff_chrg_client);
		label_hrs_to_be_subcon = UpdateTimeSheet.Label(String('Hrs Pay to Sub Con'));
		label_hrs_to_be_subcon.addStyleName(String('col_hrs'));
		grid.setWidget(0, 9, label_hrs_to_be_subcon);
		label_label_diff_pay_adj = UpdateTimeSheet.Label(String('Diff Paid vs Adj Hrs'));
		label_label_diff_pay_adj.addStyleName(String('col_hrs'));
		grid.setWidget(0, 10, label_label_diff_pay_adj);
		label_lunch_hrs = UpdateTimeSheet.Label(String('Lunch Hours'));
		label_lunch_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 11, label_lunch_hrs);
		label_start_lunch = UpdateTimeSheet.Label(String('Start Lunch'));
		label_start_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 12, label_start_lunch);
		label_fin_lunch = UpdateTimeSheet.Label(String('Fin Lunch'));
		label_fin_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 13, label_fin_lunch);
		label_notes = UpdateTimeSheet.Label(String('Notes'));
		label_notes.addStyleName(String('col_notes'));
		grid.setWidget(0, 14, label_notes);
		return grid;
	}
	, 1, [null,null,'self']);
	cls_definition.GetTimesheetDetails = pyjs__bind_method(cls_instance, 'GetTimesheetDetails', function(timesheet_id) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			timesheet_id = arguments[1];
		}

		self.timesheet_id = timesheet_id;
		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), String('')))) {
			self.status.setText(String('No Time Sheet Available'));
			return null;
		}
		self.panel_timesheet.clear();
		self.panel_timesheet.add(UpdateTimeSheet.HTML(String('\x3Ch4\x3EPlease wait...\x3C/h4\x3E')));
		self.ClearTotals();
		self.id_timesheet_details = self.remote_service.get_timesheet_details((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), self);
		return null;
	}
	, 1, [null,null,'self', 'timesheet_id']);
	cls_definition.ClearTimesheetDetails = pyjs__bind_method(cls_instance, 'ClearTimesheetDetails', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.ClearTotals();
		self.panel_timesheet.clear();
		self.timesheet_details = String('');
		self.timesheet_id = String('');
		self.timesheet_status = String('');
		self.label_timesheet_id.setText(String(''));
		self.label_timesheet_status.setText(String(''));
		self.button_refresh_details.setVisible(false);
		self.button_auto_adjust_hrs.setVisible(false);
		self.button_recompute_diff_chrg.setVisible(false);
		self.panel_invoice_link.clear();
		self.panel_client_invoice_link.clear();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.ClearTotals = pyjs__bind_method(cls_instance, 'ClearTotals', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.label_total_hrs.setText(String('0.00'));
		self.label_adj_hrs.setText(String('0.00'));
		self.label_reg_ros_hrs.setText(String('0.00'));
		self.label_hrs_chrg_client.setText(String('0.00'));
		self.label_diff_chrg_client.setText(String('0.00'));
		self.label_hrs_to_be_subcon.setText(String('0.00'));
		self.label_lunch_hrs.setText(String('0.00'));
		self.label_label_diff_pay_adj.setText(String('0.00'));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onCellClicked = pyjs__bind_method(cls_instance, 'onCellClicked', function(sender, row, col) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
			row = arguments[2];
			col = arguments[3];
		}
		var top,dialog,w,id,left;
		if (pyjslib.bool(!pyjslib.eq((typeof self.timesheet_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_status'):self.timesheet_status), String('open')))) {
			return null;
		}
		w = sender.getWidget(row, col);
		top = w.getAbsoluteTop();
		left = w.getAbsoluteLeft();
		self.row_selected = row;
		self.col_selected = col;
		id = (typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details).__getitem__((typeof self.row_selected == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row_selected'):self.row_selected)).__getitem__(String('id'));
		if (pyjslib.bool(pyjslib.eq(col, 5))) {
			dialog = UpdateTimeSheet.DialogUpdateHrs(self, String('Update Adj Hrs'), top, left, id, String('adj_hrs'));
		}
		else if (pyjslib.bool(pyjslib.eq(col, 6))) {
			dialog = UpdateTimeSheet.DialogUpdateHrs(self, String('Update Regular Rostered Hrs'), top, left, id, String('regular_rostered'));
		}
		else if (pyjslib.bool(pyjslib.eq(col, 7))) {
			dialog = UpdateTimeSheet.DialogUpdateHrs(self, String('Update Hours Charged to Client'), top, left, id, String('hrs_charged_to_client'));
		}
		else if (pyjslib.bool(pyjslib.eq(col, 9))) {
			dialog = UpdateTimeSheet.DialogUpdateHrs(self, String('Update Hrs Pay to Sub Con'), top, left, id, String('hrs_to_be_subcon'));
		}
		else if (pyjslib.bool(pyjslib.eq(col, 14))) {
			w = sender.getWidget(row, col);
			top = w.getAbsoluteTop();
			left = w.getAbsoluteLeft();
			dialog = UpdateTimeSheet.DialogTimeSheetNotes(self, top, left, id, row);
		}
		return null;
	}
	, 1, [null,null,'self', 'sender', 'row', 'col']);
	cls_definition.UpdateTotals = pyjs__bind_method(cls_instance, 'UpdateTotals', function(totals) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			totals = arguments[1];
		}

		self.label_total_hrs.setText(totals.__getitem__(String('grand_total_hrs')));
		self.label_adj_hrs.setText(totals.__getitem__(String('grand_total_adj_hrs')));
		self.label_reg_ros_hrs.setText(totals.__getitem__(String('grand_total_reg_ros_hrs')));
		self.label_hrs_chrg_client.setText(totals.__getitem__(String('grand_total_hrs_chrg_client')));
		self.label_diff_chrg_client.setText(totals.__getitem__(String('grand_total_diff_chrg_client')));
		self.label_hrs_to_be_subcon.setText(totals.__getitem__(String('grand_total_hrs_to_be_subcon')));
		self.label_lunch_hrs.setText(totals.__getitem__(String('grand_total_lunch_hrs')));
		self.label_label_diff_pay_adj.setText(totals.__getitem__(String('grand_total_diff_pay_adj')));
		return null;
	}
	, 1, [null,null,'self', 'totals']);
	cls_definition.RenderInvoices = pyjs__bind_method(cls_instance, 'RenderInvoices', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var row_color,i,row_formatter,grid_invoices,cell_formatter;
		self.panel_invoice_link.clear();
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.panel_invoice_link.add(UpdateTimeSheet.Label(String('No Subcon Invoices found for this timesheet.')));
			return null;
		}
		self.panel_invoice_link.add(UpdateTimeSheet.Label(String('Subcon Invoices for this timesheet:')));
		grid_invoices = UpdateTimeSheet.Grid( ( pyjslib.len(data) + 1 ) , 5);
		row_formatter = grid_invoices.getRowFormatter();
		cell_formatter = grid_invoices.getCellFormatter();
		grid_invoices.setWidget(0, 0, UpdateTimeSheet.Label(String('Invoice ID')));
		grid_invoices.setWidget(0, 1, UpdateTimeSheet.Label(String('Invoiced Hrs')));
		grid_invoices.setWidget(0, 2, UpdateTimeSheet.Label(String('Sum Adj Hrs')));
		grid_invoices.setWidget(0, 3, UpdateTimeSheet.Label(String('Sum Hrs Pay to Subcon')));
		grid_invoices.setWidget(0, 4, UpdateTimeSheet.Label(String('Sum Diff Paid vs Adj Hrs')));
		row_formatter.setStyleName(0, String('grid_header '));
		row_color = String('');
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				grid_invoices.setWidget( ( i + 1 ) , 0, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('subcon_invoice_id'))));
				grid_invoices.setWidget( ( i + 1 ) , 1, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('invoiced_hrs'))));
				grid_invoices.setWidget( ( i + 1 ) , 2, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('sum_adj_hrs'))));
				grid_invoices.setWidget( ( i + 1 ) , 3, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('sum_hrs_to_be_subcon'))));
				grid_invoices.setWidget( ( i + 1 ) , 4, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('sum_diff_pay_adj'))));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 0, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 1, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 2, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 3, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 4, String('right'));
				if (pyjslib.bool(pyjslib.eq(row_color, String('row_even_invoices')))) {
					row_color = String('row_odd_invoices');
				}
				else {
					row_color = String('row_even_invoices');
				}
				row_formatter.setStyleName( ( i + 1 ) , row_color);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.panel_invoice_link.add(grid_invoices);
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.RenderClientInvoices = pyjs__bind_method(cls_instance, 'RenderClientInvoices', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var row_color,i,row_formatter,grid_invoices,cell_formatter;
		self.panel_client_invoice_link.clear();
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.panel_client_invoice_link.add(UpdateTimeSheet.Label(String('No Client Invoices found for this timesheet.')));
			return null;
		}
		self.panel_client_invoice_link.add(UpdateTimeSheet.Label(String('Client Invoices for this timesheet:')));
		grid_invoices = UpdateTimeSheet.Grid( ( pyjslib.len(data) + 1 ) , 5);
		row_formatter = grid_invoices.getRowFormatter();
		cell_formatter = grid_invoices.getCellFormatter();
		grid_invoices.setWidget(0, 0, UpdateTimeSheet.Label(String('Invoice Number')));
		grid_invoices.setWidget(0, 1, UpdateTimeSheet.Label(String('Invoiced Hrs')));
		grid_invoices.setWidget(0, 2, UpdateTimeSheet.Label(String('Sum Adj Hrs')));
		grid_invoices.setWidget(0, 3, UpdateTimeSheet.Label(String('Sum Hrs Chrg to Client')));
		grid_invoices.setWidget(0, 4, UpdateTimeSheet.Label(String('Adjustment')));
		row_formatter.setStyleName(0, String('grid_header '));
		row_color = String('');
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				grid_invoices.setWidget( ( i + 1 ) , 0, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('invoice_number'))));
				grid_invoices.setWidget( ( i + 1 ) , 1, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('invoiced_hrs'))));
				grid_invoices.setWidget( ( i + 1 ) , 2, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('sum_adj_hrs'))));
				grid_invoices.setWidget( ( i + 1 ) , 3, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('sum_hrs_chrge_to_client'))));
				grid_invoices.setWidget( ( i + 1 ) , 4, UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('adjustment'))));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 0, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 1, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 2, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 3, String('right'));
				cell_formatter.setHorizontalAlignment( ( i + 1 ) , 4, String('center'));
				if (pyjslib.bool(pyjslib.eq(row_color, String('row_even_invoices')))) {
					row_color = String('row_odd_invoices');
				}
				else {
					row_color = String('row_even_invoices');
				}
				row_formatter.setStyleName( ( i + 1 ) , row_color);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.panel_client_invoice_link.add(grid_invoices);
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.RenderTimesheetDetails = pyjs__bind_method(cls_instance, 'RenderTimesheetDetails', function(response) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
		}
		var notes_display,j,vp_lunch_in,label_diff_pay_adj,hrs_to_be_subcon,vp_timeout,hrs_charged,current_row_format,row_formatter,vp_lunch_out,vp_timein,date,lunch_hours,data,day,adjusted_hrs,i,notes,ros_hrs,diff_charged,total_hrs;
		self.panel_timesheet.clear();
		self.UpdateTotals(response.__getitem__(String('timesheet_totals')));
		self.button_refresh_details.setVisible(true);
		self.timesheet_status = response.__getitem__(String('timesheet_status'));
		self.label_timesheet_id.setText(pyjslib.sprintf(String('Time Sheet ID : %s'), (typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id)));
		self.label_timesheet_status.setText(pyjslib.sprintf(String('Status : %s'), (typeof self.timesheet_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_status'):self.timesheet_status)));
		self.RenderInvoices(response.__getitem__(String('invoices')));
		self.RenderClientInvoices(response.__getitem__(String('client_invoices')));
		self.status.setText(String('Please Wait...'));
		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_status'):self.timesheet_status), String('open')))) {
			self.button_auto_adjust_hrs.setVisible(true);
			self.button_recompute_diff_chrg.setVisible(true);
		}
		else {
			self.button_auto_adjust_hrs.setVisible(false);
			self.button_recompute_diff_chrg.setVisible(false);
		}
		self.timesheet_details = response.__getitem__(String('timesheet_details'));
		self.grid_timesheet = UpdateTimeSheet.Grid(pyjslib.len((typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details)), 15);
		self.grid_timesheet.setID(String('grid_records'));
		self.grid_timesheet.addTableListener(self);
		self.panel_timesheet.add((typeof self.grid_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_timesheet'):self.grid_timesheet));
		data = (typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details);
		row_formatter = self.grid_timesheet.getRowFormatter();
		current_row_format = String('row_even');
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(pyjslib.eq(current_row_format, String('row_even')))) {
					current_row_format = String('row_odd');
				}
				else {
					current_row_format = String('row_even');
				}
				if (pyjslib.bool(pyjslib.eq(data.__getitem__(i).__getitem__(String('day')), String('Sun')))) {
					current_row_format = String('row_sun');
				}
				if (pyjslib.bool(pyjslib.eq(data.__getitem__(i).__getitem__(String('day')), String('Sat')))) {
					current_row_format = String('row_sat');
				}
				row_formatter.addStyleName(i, current_row_format);
				day = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('day')));
				day.setStyleName(String('col_day'));
				self.grid_timesheet.setWidget(i, 0, day);
				date = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('date')));
				date.setStyleName(String('col_date'));
				self.grid_timesheet.setWidget(i, 1, date);
				vp_timein = UpdateTimeSheet.VerticalPanel();
				vp_timein.setStyleName(String('col_time'));
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('time_in')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_timein.add(UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('time_in')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_timesheet.setWidget(i, 2, vp_timein);
				vp_timeout = UpdateTimeSheet.VerticalPanel();
				vp_timeout.setStyleName(String('col_time'));
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('time_out')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_timeout.add(UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('time_out')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_timesheet.setWidget(i, 3, vp_timeout);
				total_hrs = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('total_hrs')));
				total_hrs.setStyleName(String('col_hrs'));
				total_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 4, total_hrs);
				adjusted_hrs = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('adjusted_hrs')));
				adjusted_hrs.setStyleName(String('col_hrs'));
				adjusted_hrs.addStyleName(String('cursor_pointer'));
				adjusted_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 5, adjusted_hrs);
				ros_hrs = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('regular_rostered_hrs')));
				ros_hrs.setStyleName(String('col_hrs'));
				ros_hrs.addStyleName(String('cursor_pointer'));
				ros_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 6, ros_hrs);
				hrs_charged = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('hrs_charged_to_client')));
				hrs_charged.setStyleName(String('col_hrs'));
				hrs_charged.addStyleName(String('cursor_pointer'));
				hrs_charged.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 7, hrs_charged);
				diff_charged = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('diff_charged_to_client')));
				diff_charged.setStyleName(String('col_hrs'));
				diff_charged.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 8, diff_charged);
				hrs_to_be_subcon = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('hrs_to_be_subcon')));
				hrs_to_be_subcon.setStyleName(String('col_hrs'));
				hrs_to_be_subcon.addStyleName(String('cursor_pointer'));
				hrs_to_be_subcon.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 9, hrs_to_be_subcon);
				label_diff_pay_adj = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('diff_pay_adj')));
				label_diff_pay_adj.setStyleName(String('col_hrs'));
				label_diff_pay_adj.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 10, label_diff_pay_adj);
				lunch_hours = UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('lunch_hours')));
				lunch_hours.setStyleName(String('col_hrs'));
				lunch_hours.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 11, lunch_hours);
				vp_lunch_in = UpdateTimeSheet.VerticalPanel();
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('lunch_in')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_lunch_in.add(UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('lunch_in')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				vp_lunch_in.setStyleName(String('col_time'));
				self.grid_timesheet.setWidget(i, 12, vp_lunch_in);
				vp_lunch_out = UpdateTimeSheet.VerticalPanel();
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('lunch_out')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_lunch_out.add(UpdateTimeSheet.Label(data.__getitem__(i).__getitem__(String('lunch_out')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				vp_lunch_out.setStyleName(String('col_time'));
				self.grid_timesheet.setWidget(i, 13, vp_lunch_out);
				notes_display = String('');
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('notes')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						notes_display += pyjslib.sprintf(String(' %s'), data.__getitem__(i).__getitem__(String('notes')).__getitem__(j).__getitem__(String('note')));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				if (pyjslib.bool(pyjslib.eq(notes_display, String('')))) {
					notes_display = String('\x3CClick to add notes\x3E');
				}
				notes = pyjs_kwargs_call(UpdateTimeSheet, 'Label', null, null, [{wordWrap:false}, notes_display]);
				notes.setStyleName(String('col_notes'));
				self.grid_timesheet.setWidget(i, 14, notes);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.grid_timesheet.setRowFormatter(row_formatter);
		self.status.setText(String(''));
		self.button_refresh_details.setEnabled(true);
		return null;
	}
	, 1, [null,null,'self', 'response']);
	cls_definition.UpdateAdjustedHours = pyjs__bind_method(cls_instance, 'UpdateAdjustedHours', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var updated_data,adjusted_hrs,i,ros_hrs,diff_charged,timesheet_detail,hrs_to_be_subcon,diff_pay_adj,hrs_charged;
		updated_data = data.__getitem__(String('updated_data'));
		i = (typeof self.row_selected == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row_selected'):self.row_selected);
		adjusted_hrs = UpdateTimeSheet.Label(updated_data.__getitem__(String('adj_hrs')));
		adjusted_hrs.setStyleName(String('col_hrs'));
		adjusted_hrs.addStyleName(String('cursor_pointer'));
		adjusted_hrs.setHorizontalAlignment(String('right'));
		self.grid_timesheet.setWidget(i, 5, adjusted_hrs);
		ros_hrs = UpdateTimeSheet.Label(updated_data.__getitem__(String('regular_rostered')));
		ros_hrs.setStyleName(String('col_hrs'));
		ros_hrs.addStyleName(String('cursor_pointer'));
		ros_hrs.setHorizontalAlignment(String('right'));
		self.grid_timesheet.setWidget(i, 6, ros_hrs);
		hrs_charged = UpdateTimeSheet.Label(updated_data.__getitem__(String('hrs_charged_to_client')));
		hrs_charged.setStyleName(String('col_hrs'));
		hrs_charged.addStyleName(String('cursor_pointer'));
		hrs_charged.setHorizontalAlignment(String('right'));
		self.grid_timesheet.setWidget(i, 7, hrs_charged);
		diff_charged = UpdateTimeSheet.Label(updated_data.__getitem__(String('diff_charged_to_client')));
		diff_charged.setStyleName(String('col_hrs'));
		diff_charged.setHorizontalAlignment(String('right'));
		self.grid_timesheet.setWidget(i, 8, diff_charged);
		hrs_to_be_subcon = UpdateTimeSheet.Label(updated_data.__getitem__(String('hrs_to_be_subcon')));
		hrs_to_be_subcon.setStyleName(String('col_hrs'));
		hrs_to_be_subcon.addStyleName(String('cursor_pointer'));
		hrs_to_be_subcon.setHorizontalAlignment(String('right'));
		self.grid_timesheet.setWidget(i, 9, hrs_to_be_subcon);
		diff_pay_adj = UpdateTimeSheet.Label(updated_data.__getitem__(String('diff_pay_adj')));
		diff_pay_adj.setStyleName(String('col_hrs'));
		diff_pay_adj.setHorizontalAlignment(String('right'));
		self.grid_timesheet.setWidget(i, 10, diff_pay_adj);
		timesheet_detail = (typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details).__getitem__(i);
		timesheet_detail.__setitem__(String('adjusted_hrs'), updated_data.__getitem__(String('adj_hrs')));
		timesheet_detail.__setitem__(String('regular_rostered_hrs'), updated_data.__getitem__(String('regular_rostered')));
		timesheet_detail.__setitem__(String('hrs_charged_to_client'), updated_data.__getitem__(String('hrs_charged_to_client')));
		timesheet_detail.__setitem__(String('diff_charged_to_client'), updated_data.__getitem__(String('diff_charged_to_client')));
		timesheet_detail.__setitem__(String('hrs_to_be_subcon'), updated_data.__getitem__(String('hrs_to_be_subcon')));
		(typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details).__setitem__(i, timesheet_detail);
		self.UpdateTotals(data.__getitem__(String('timesheet_totals')));
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_months == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_months'):self.id_get_months)))) {
			self.tab_panel_list_by_staff.RenderMonthSelection(response);
			self.tab_panel_list_by_client.RenderMonthSelection(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_timesheet_details'):self.id_timesheet_details)))) {
			self.RenderTimesheetDetails(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_login == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_login'):self.id_login)))) {
			self.CheckLogin(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_recompute_diff_chrge_to_client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_recompute_diff_chrge_to_client'):self.id_recompute_diff_chrge_to_client)))) {
			self.RenderTimesheetDetails(response);
			UpdateTimeSheet.Window.alert(String('Diff chrarge to client updated.'));
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
			self.admin_login_dialog = UpdateTimeSheet.DialogAdminLogin(self);
			return null;
		}
		self.status.setText(pyjslib.sprintf(String('Server Error or Invalid Response: ERROR %d - %s'), new pyjslib.Tuple([code, message])));
		return null;
	}
	, 1, [null,null,'self', 'code', 'message', 'request_info']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
UpdateTimeSheet.UpdateTimeSheetService = (function(){
	var cls_instance = pyjs__class_instance('UpdateTimeSheetService');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'e02d0b5487bc48a55ecd13439d7b6fc9';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		UpdateTimeSheet.JSONProxy.__init__(self, String('/portal/scm_tab/UpdateTimeSheetService.php'), new pyjslib.List([String('get_months'), String('get_timesheet_details'), String('update_hrs'), String('login'), String('get_staff_names_by_month'), String('get_staff_clients'), String('get_client_names_by_month'), String('get_client_staff_by_month'), String('recompute_diff_chrge_to_client'), String('add_note')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(UpdateTimeSheet.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(UpdateTimeSheet.__name__, String('__main__')))) {
	UpdateTimeSheet.app = UpdateTimeSheet.UpdateTimeSheet();
	UpdateTimeSheet.app.onModuleLoad();
}
return this;
}; /* end UpdateTimeSheet */
$pyjs.modules_hash['UpdateTimeSheet'] = $pyjs.loaded_modules['UpdateTimeSheet'];


 /* end module: UpdateTimeSheet */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.ui.AutoComplete.AutoCompleteTextBox', 'pyjamas.ui.AutoComplete', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox', 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel', 'pyjamas.ui.PasswordTextBox.PasswordTextBox', 'pyjamas.ui.PasswordTextBox', 'pyjamas.ui.TabPanel.TabPanel', 'pyjamas.ui.TabPanel', 'pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel', 'pyjamas.ui.TextArea.TextArea', 'pyjamas.ui.TextArea', 'pyjamas.log', 'pygwt']
*/
