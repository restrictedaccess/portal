/* start module: SubconTimeSheet */
var SubconTimeSheet = $pyjs.loaded_modules["SubconTimeSheet"] = function (__mod_name__) {
if(SubconTimeSheet.__was_initialized__) return SubconTimeSheet;
SubconTimeSheet.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'SubconTimeSheet';
var __name__ = SubconTimeSheet.__name__ = __mod_name__;
pyjslib.__import__(['pyjd'], 'pyjd', 'SubconTimeSheet');
SubconTimeSheet.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'SubconTimeSheet');
SubconTimeSheet.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'SubconTimeSheet');
SubconTimeSheet.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'SubconTimeSheet');
SubconTimeSheet.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'SubconTimeSheet');
SubconTimeSheet.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'SubconTimeSheet');
SubconTimeSheet.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'SubconTimeSheet');
SubconTimeSheet.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'SubconTimeSheet');
SubconTimeSheet.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'SubconTimeSheet');
SubconTimeSheet.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'SubconTimeSheet');
SubconTimeSheet.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.TextArea.TextArea', 'pyjamas.ui.TextArea'], 'pyjamas.ui.TextArea.TextArea', 'SubconTimeSheet');
SubconTimeSheet.TextArea = $pyjs.__modules__.pyjamas.ui.TextArea.TextArea;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'SubconTimeSheet');
SubconTimeSheet.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'SubconTimeSheet');
SubconTimeSheet.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'SubconTimeSheet');
SubconTimeSheet.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'SubconTimeSheet');
SubconTimeSheet.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'SubconTimeSheet');
SubconTimeSheet.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox'], 'pyjamas.ui.DialogBox.DialogBox', 'SubconTimeSheet');
SubconTimeSheet.DialogBox = $pyjs.__modules__.pyjamas.ui.DialogBox.DialogBox;
pyjslib.__import__(['pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel'], 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'SubconTimeSheet');
SubconTimeSheet.AbsolutePanel = $pyjs.__modules__.pyjamas.ui.AbsolutePanel.AbsolutePanel;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'SubconTimeSheet');
SubconTimeSheet.log = $pyjs.__modules__.pyjamas.log;
pyjslib.__import__(['pygwt'], 'pygwt', 'SubconTimeSheet');
SubconTimeSheet.pygwt = $pyjs.__modules__.pygwt;
SubconTimeSheet.DialogTimeSheetNotes = (function(){
	var cls_instance = pyjs__class_instance('DialogTimeSheetNotes');
	var cls_definition = new Object();
	cls_definition.__md5__ = '1b9ca976a314f122b56be32cb248c226';
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
		self.remote_service = SubconTimeSheet.SubconTimeSheetService();
		self.timesheet_details_id = timesheet_details_id;
		self.row = row;
		self.scroll_panel = pyjs_kwargs_call(SubconTimeSheet, 'ScrollPanel', null, null, [{Width:String('100%'), Height:String('88px')}]);
		label_new_note = SubconTimeSheet.Label(String('New Note'));
		self.new_note = pyjs_kwargs_call(SubconTimeSheet, 'TextArea', null, null, [{VisibleLines:4}]);
		self.new_note.setWidth(String('100%'));
		self.button_add_note = SubconTimeSheet.Button(String('Add Note'), (typeof self.onClickAddNote == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickAddNote'):self.onClickAddNote));
		self.button_close = SubconTimeSheet.Button(String('Close'), (typeof self.onClickClose == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickClose'):self.onClickClose));
		contents = SubconTimeSheet.VerticalPanel();
		contents.setSpacing(4);
		contents.setWidth(String('400px'));
		contents.add((typeof self.scroll_panel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'scroll_panel'):self.scroll_panel));
		contents.add(label_new_note);
		contents.add((typeof self.new_note == 'function' && self.__is_instance__?pyjslib.getattr(self, 'new_note'):self.new_note));
		panel_button = SubconTimeSheet.HorizontalPanel();
		panel_button.add((typeof self.button_add_note == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_add_note'):self.button_add_note));
		panel_button.add((typeof self.button_close == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_close'):self.button_close));
		contents.add(panel_button);
		self.LoadNotes();
		self.dialog = SubconTimeSheet.DialogBox();
		self.dialog.setHTML(String('\x3Cb\x3ENotes\x3C/b\x3E'));
		self.dialog.setWidget(contents);
		top = self.parent.grid_header.getAbsoluteTop();
		self.dialog.setPopupPosition(238, top);
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
		grid_notes = SubconTimeSheet.Grid(pyjslib.len(notes), 3);
		row_formatter = grid_notes.getRowFormatter();
		grid_notes.setWidth(String('100%'));
		current_row_format = String('row_even');
		var __i = pyjslib.range(pyjslib.len(notes)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				grid_notes.setWidget(i, 0, SubconTimeSheet.Label(notes.__getitem__(i).__getitem__(String('fname'))));
				grid_notes.setWidget(i, 1, SubconTimeSheet.Label(notes.__getitem__(i).__getitem__(String('note'))));
				grid_notes.setWidget(i, 2, SubconTimeSheet.Label(notes.__getitem__(i).__getitem__(String('timestamp'))));
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
			SubconTimeSheet.Window.alert(String('Blank note not allowed!'));
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
		notes = pyjs_kwargs_call(SubconTimeSheet, 'Label', null, null, [{wordWrap:false}, notes_display]);
		notes.setStyleName(String('col_notes'));
		self.parent.grid_timesheet.setWidget((typeof self.row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row'):self.row), 11, notes);
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
SubconTimeSheet.SubconTimeSheet = (function(){
	var cls_instance = pyjs__class_instance('SubconTimeSheet');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'e8343c24f567d9f360e17fa1b83a5c22';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var vp,panel_select_timesheet,panel_grid_header,label_time_sheet;
		self.remote_service = SubconTimeSheet.SubconTimeSheetService();
		label_time_sheet = SubconTimeSheet.Label(String('Select Time Sheet:'));
		label_time_sheet.addStyleName(String('size_12'));
		self.list_box_select_timesheet = SubconTimeSheet.ListBox();
		self.status = SubconTimeSheet.Label();
		self.grid_header = self.GetHeaderGrid();
		panel_grid_header = SubconTimeSheet.AbsolutePanel();
		panel_grid_header.setWidth(String('838px'));
		panel_grid_header.setHeight(String('52px'));
		panel_grid_header.add((typeof self.grid_header == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_header'):self.grid_header), 0, 0);
		self.panel_timesheet = pyjs_kwargs_call(SubconTimeSheet, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('856px'), String('208px')])}]);
		self.footer_grid = self.GetFooterGrid();
		self.panel_grid_footer = SubconTimeSheet.AbsolutePanel();
		self.panel_grid_footer.setWidth(String('838px'));
		self.panel_grid_footer.setHeight(String('24px'));
		self.panel_grid_footer.add((typeof self.footer_grid == 'function' && self.__is_instance__?pyjslib.getattr(self, 'footer_grid'):self.footer_grid), 0, 0);
		panel_select_timesheet = SubconTimeSheet.HorizontalPanel();
		panel_select_timesheet.setVerticalAlignment(String('middle'));
		panel_select_timesheet.setPadding(String('2px'));
		panel_select_timesheet.add(label_time_sheet);
		panel_select_timesheet.add((typeof self.list_box_select_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_select_timesheet'):self.list_box_select_timesheet));
		vp = SubconTimeSheet.VerticalPanel();
		vp.add(panel_select_timesheet);
		vp.add(panel_grid_header);
		vp.add((typeof self.panel_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_timesheet'):self.panel_timesheet));
		vp.add((typeof self.panel_grid_footer == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_grid_footer'):self.panel_grid_footer));
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		SubconTimeSheet.RootPanel().add(vp);
		self.GetTimeSheets();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.GetHeaderGrid = pyjs__bind_method(cls_instance, 'GetHeaderGrid', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_lunch_hrs,label_time_out,label_fin_lunch,label_day,label_reg_ros_hrs,label_time_in,grid,label_adj_hrs,label_date,label_notes,label_hrs_to_be_subcon,label_total_hrs,label_start_lunch;
		grid = SubconTimeSheet.Grid(1, 12);
		grid.setBorderWidth(1);
		grid.setCellSpacing(0);
		grid.setStyleName(String('grid_header'));
		label_day = SubconTimeSheet.Label(String('Day'));
		label_day.addStyleName(String('col_day'));
		grid.setWidget(0, 0, label_day);
		label_date = SubconTimeSheet.Label(String('Date'));
		label_date.addStyleName(String('col_date'));
		grid.setWidget(0, 1, label_date);
		label_time_in = SubconTimeSheet.Label(String('Time In'));
		label_time_in.addStyleName(String('col_time'));
		grid.setWidget(0, 2, label_time_in);
		label_time_out = SubconTimeSheet.Label(String('Time Out'));
		label_time_out.addStyleName(String('col_time'));
		grid.setWidget(0, 3, label_time_out);
		label_total_hrs = SubconTimeSheet.Label(String('Total Hrs'));
		label_total_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 4, label_total_hrs);
		label_adj_hrs = SubconTimeSheet.Label(String('Adj Hrs'));
		label_adj_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 5, label_adj_hrs);
		label_reg_ros_hrs = SubconTimeSheet.Label(String('Reg Ros Hrs'));
		label_reg_ros_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 6, label_reg_ros_hrs);
		label_hrs_to_be_subcon = SubconTimeSheet.Label(String('Hrs Pay to Sub Con'));
		label_hrs_to_be_subcon.addStyleName(String('col_hrs'));
		grid.setWidget(0, 7, label_hrs_to_be_subcon);
		label_lunch_hrs = SubconTimeSheet.Label(String('Lunch Hours'));
		label_lunch_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 8, label_lunch_hrs);
		label_start_lunch = SubconTimeSheet.Label(String('Start Lunch'));
		label_start_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 9, label_start_lunch);
		label_fin_lunch = SubconTimeSheet.Label(String('Fin Lunch'));
		label_fin_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 10, label_fin_lunch);
		label_notes = SubconTimeSheet.Label(String('Notes'));
		label_notes.addStyleName(String('col_notes'));
		grid.setWidget(0, 11, label_notes);
		return grid;
	}
	, 1, [null,null,'self']);
	cls_definition.GetFooterGrid = pyjs__bind_method(cls_instance, 'GetFooterGrid', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_time_out,label_fin_lunch,label_col,label_day,label_time_in,grid,label_date,label_start_lunch;
		grid = SubconTimeSheet.Grid(1, 12);
		grid.setBorderWidth(1);
		grid.setCellSpacing(0);
		grid.setStyleName(String('grid_header'));
		label_day = SubconTimeSheet.Label(String(''));
		label_day.addStyleName(String('col_day'));
		grid.setWidget(0, 0, label_day);
		label_date = SubconTimeSheet.Label(String(''));
		label_date.addStyleName(String('col_date'));
		grid.setWidget(0, 1, label_date);
		label_time_in = SubconTimeSheet.Label(String(''));
		label_time_in.addStyleName(String('col_time'));
		grid.setWidget(0, 2, label_time_in);
		label_time_out = SubconTimeSheet.Label(String(''));
		label_time_out.addStyleName(String('col_time'));
		grid.setWidget(0, 3, label_time_out);
		self.label_total_hrs = SubconTimeSheet.Label(String('0.00'));
		self.label_total_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 4, (typeof self.label_total_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_total_hrs'):self.label_total_hrs));
		self.label_adj_hrs = SubconTimeSheet.Label(String('0.00'));
		self.label_adj_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 5, (typeof self.label_adj_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_adj_hrs'):self.label_adj_hrs));
		self.label_reg_ros_hrs = SubconTimeSheet.Label(String('0.00'));
		self.label_reg_ros_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 6, (typeof self.label_reg_ros_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_reg_ros_hrs'):self.label_reg_ros_hrs));
		self.label_hrs_to_be_subcon = SubconTimeSheet.Label(String('0.00'));
		self.label_hrs_to_be_subcon.addStyleName(String('col_hrs'));
		grid.setWidget(0, 7, (typeof self.label_hrs_to_be_subcon == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_hrs_to_be_subcon'):self.label_hrs_to_be_subcon));
		self.label_lunch_hrs = SubconTimeSheet.Label(String('0.00'));
		self.label_lunch_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 8, (typeof self.label_lunch_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_lunch_hrs'):self.label_lunch_hrs));
		label_start_lunch = SubconTimeSheet.Label(String(''));
		label_start_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 9, label_start_lunch);
		label_fin_lunch = SubconTimeSheet.Label(String(''));
		label_fin_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 10, label_fin_lunch);
		label_col = SubconTimeSheet.Label(String(''));
		label_col.addStyleName(String('col_notes'));
		grid.setWidget(0, 11, label_col);
		return grid;
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
		var top,dialog,w,timesheet_details_id,left;
		if (pyjslib.bool(pyjslib.eq(col, 11))) {
			w = sender.getWidget(row, col);
			top = w.getAbsoluteTop();
			left = w.getAbsoluteLeft();
			timesheet_details_id = (typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details).__getitem__(row).__getitem__(String('id'));
			dialog = SubconTimeSheet.DialogTimeSheetNotes(self, top, left, timesheet_details_id, row);
		}
		return null;
	}
	, 1, [null,null,'self', 'sender', 'row', 'col']);
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
		self.label_hrs_to_be_subcon.setText(String('0.00'));
		self.label_lunch_hrs.setText(String('0.00'));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderTimesheetDetails = pyjs__bind_method(cls_instance, 'RenderTimesheetDetails', function(response) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
		}
		var notes_display,current_row_format,ros_hrs,vp_lunch_in,adjusted_hrs,i,j,row_formatter,day,lunch_hours,vp_timeout,hrs_to_be_subcon,vp_lunch_out,vp_timein,date,notes,total_hrs,data;
		self.panel_timesheet.clear();
		self.UpdateTotals(response.__getitem__(String('timesheet_totals')));
		self.timesheet_status = response.__getitem__(String('timesheet_status'));
		self.status.setText(String('Please Wait...'));
		self.timesheet_details = response.__getitem__(String('timesheet_details'));
		self.grid_timesheet = SubconTimeSheet.Grid(pyjslib.len((typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details)), 12);
		self.grid_timesheet.addTableListener(self);
		self.grid_timesheet.setID(String('grid_records'));
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
				day = SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('day')));
				day.setStyleName(String('col_day'));
				self.grid_timesheet.setWidget(i, 0, day);
				date = SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('date')));
				date.setStyleName(String('col_date'));
				self.grid_timesheet.setWidget(i, 1, date);
				vp_timein = SubconTimeSheet.VerticalPanel();
				vp_timein.setStyleName(String('col_time'));
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('time_in')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_timein.add(SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('time_in')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_timesheet.setWidget(i, 2, vp_timein);
				vp_timeout = SubconTimeSheet.VerticalPanel();
				vp_timeout.setStyleName(String('col_time'));
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('time_out')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_timeout.add(SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('time_out')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_timesheet.setWidget(i, 3, vp_timeout);
				total_hrs = SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('total_hrs')));
				total_hrs.setStyleName(String('col_hrs'));
				total_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 4, total_hrs);
				adjusted_hrs = SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('adjusted_hrs')));
				adjusted_hrs.setStyleName(String('col_hrs'));
				adjusted_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 5, adjusted_hrs);
				ros_hrs = SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('regular_rostered_hrs')));
				ros_hrs.setStyleName(String('col_hrs'));
				ros_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 6, ros_hrs);
				hrs_to_be_subcon = SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('hrs_to_be_subcon')));
				hrs_to_be_subcon.setStyleName(String('col_hrs'));
				hrs_to_be_subcon.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 7, hrs_to_be_subcon);
				lunch_hours = SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('lunch_hours')));
				lunch_hours.setStyleName(String('col_hrs'));
				lunch_hours.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 8, lunch_hours);
				vp_lunch_in = SubconTimeSheet.VerticalPanel();
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('lunch_in')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_lunch_in.add(SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('lunch_in')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				vp_lunch_in.setStyleName(String('col_time'));
				self.grid_timesheet.setWidget(i, 9, vp_lunch_in);
				vp_lunch_out = SubconTimeSheet.VerticalPanel();
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('lunch_out')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_lunch_out.add(SubconTimeSheet.Label(data.__getitem__(i).__getitem__(String('lunch_out')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				vp_lunch_out.setStyleName(String('col_time'));
				self.grid_timesheet.setWidget(i, 10, vp_lunch_out);
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
				notes = pyjs_kwargs_call(SubconTimeSheet, 'Label', null, null, [{wordWrap:false}, notes_display]);
				notes.setStyleName(String('col_notes'));
				self.grid_timesheet.setWidget(i, 11, notes);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.status.setText(String(''));
		return null;
	}
	, 1, [null,null,'self', 'response']);
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
		self.label_hrs_to_be_subcon.setText(totals.__getitem__(String('grand_total_hrs_to_be_subcon')));
		self.label_lunch_hrs.setText(totals.__getitem__(String('grand_total_lunch_hrs')));
		return null;
	}
	, 1, [null,null,'self', 'totals']);
	cls_definition.GetTimeSheets = pyjs__bind_method(cls_instance, 'GetTimeSheets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.id_get_time_sheets = self.remote_service.get_time_sheets(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderTimeSheetSelection = pyjs__bind_method(cls_instance, 'RenderTimeSheetSelection', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i;
		self.list_box_select_timesheet.clear();
		var __i = pyjslib.range(pyjslib.len(data)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_select_timesheet.addItem(data.__getitem__(i).__getitem__(String('item')), data.__getitem__(i).__getitem__(String('value')));
				self.list_box_select_timesheet.setItemSelected(i, data.__getitem__(i).__getitem__(String('selected')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(data), 0))) {
			self.panel_timesheet.clear();
			self.panel_timesheet.add(SubconTimeSheet.Label(String('No Time Sheets Available.')));
		}
		else {
			self.list_box_select_timesheet.addChangeListener((typeof self.GetTimesheetDetails == 'function' && self.__is_instance__?pyjslib.getattr(self, 'GetTimesheetDetails'):self.GetTimesheetDetails));
			self.GetTimesheetDetails();
		}
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.GetTimesheetDetails = pyjs__bind_method(cls_instance, 'GetTimesheetDetails', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.timesheet_id = self.list_box_select_timesheet.getValue(self.list_box_select_timesheet.getSelectedIndex());
		if (pyjslib.bool(pyjslib.eq((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), String('')))) {
			self.status.setText(String('No Time Sheet Available'));
			return null;
		}
		self.panel_timesheet.clear();
		self.panel_timesheet.add(SubconTimeSheet.HTML(String('\x3Ch4\x3EPlease wait...\x3C/h4\x3E')));
		self.ClearTotals();
		self.id_timesheet_details = self.remote_service.get_timesheet_details((typeof self.timesheet_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_id'):self.timesheet_id), self);
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_time_sheets == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_time_sheets'):self.id_get_time_sheets)))) {
			self.RenderTimeSheetSelection(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_timesheet_details'):self.id_timesheet_details)))) {
			self.RenderTimesheetDetails(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_login == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_login'):self.id_login)))) {
			self.CheckLogin(response);
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

		self.status.setText(pyjslib.sprintf(String('Server Error or Invalid Response: ERROR %d - %s'), new pyjslib.Tuple([code, message])));
		return null;
	}
	, 1, [null,null,'self', 'code', 'message', 'request_info']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
SubconTimeSheet.SubconTimeSheetService = (function(){
	var cls_instance = pyjs__class_instance('SubconTimeSheetService');
	var cls_definition = new Object();
	cls_definition.__md5__ = '13eed6cc3fe71834c62e1ffac3b388ed';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		SubconTimeSheet.JSONProxy.__init__(self, String('/portal/scm_tab/SubconTimeSheetService.php'), new pyjslib.List([String('get_time_sheets'), String('get_timesheet_details'), String('add_note')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(SubconTimeSheet.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(SubconTimeSheet.__name__, String('__main__')))) {
	SubconTimeSheet.app = SubconTimeSheet.SubconTimeSheet();
	SubconTimeSheet.app.onModuleLoad();
}
return this;
}; /* end SubconTimeSheet */
$pyjs.modules_hash['SubconTimeSheet'] = $pyjs.loaded_modules['SubconTimeSheet'];


 /* end module: SubconTimeSheet */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.TextArea.TextArea', 'pyjamas.ui.TextArea', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox', 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel', 'pyjamas.log', 'pygwt']
*/
