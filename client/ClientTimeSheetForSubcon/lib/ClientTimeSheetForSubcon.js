/* start module: ClientTimeSheetForSubcon */
var ClientTimeSheetForSubcon = $pyjs.loaded_modules["ClientTimeSheetForSubcon"] = function (__mod_name__) {
if(ClientTimeSheetForSubcon.__was_initialized__) return ClientTimeSheetForSubcon;
ClientTimeSheetForSubcon.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'ClientTimeSheetForSubcon';
var __name__ = ClientTimeSheetForSubcon.__name__ = __mod_name__;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.TextArea.TextArea', 'pyjamas.ui.TextArea'], 'pyjamas.ui.TextArea.TextArea', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.TextArea = $pyjs.__modules__.pyjamas.ui.TextArea.TextArea;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox'], 'pyjamas.ui.DialogBox.DialogBox', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.DialogBox = $pyjs.__modules__.pyjamas.ui.DialogBox.DialogBox;
pyjslib.__import__(['pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel'], 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.AbsolutePanel = $pyjs.__modules__.pyjamas.ui.AbsolutePanel.AbsolutePanel;
pyjslib.__import__(['pyjamas.ui.FlexTable.FlexTable', 'pyjamas.ui.FlexTable'], 'pyjamas.ui.FlexTable.FlexTable', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.FlexTable = $pyjs.__modules__.pyjamas.ui.FlexTable.FlexTable;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.log = $pyjs.__modules__.pyjamas.log;
pyjslib.__import__(['pygwt'], 'pygwt', 'ClientTimeSheetForSubcon');
ClientTimeSheetForSubcon.pygwt = $pyjs.__modules__.pygwt;
ClientTimeSheetForSubcon.DialogTimeSheetNotes = (function(){
	var cls_instance = pyjs__class_instance('DialogTimeSheetNotes');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f69be2e974d492278d8880268a2ebb68';
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
		var panel_button,contents;
		self.parent = parent;
		self.remote_service = ClientTimeSheetForSubcon.ClientTimeSheetForSubconService();
		self.timesheet_details_id = timesheet_details_id;
		self.row = row;
		self.scroll_panel = pyjs_kwargs_call(ClientTimeSheetForSubcon, 'ScrollPanel', null, null, [{Width:String('100%'), Height:String('88px')}]);
		self.button_close = ClientTimeSheetForSubcon.Button(String('Close'), (typeof self.onClickClose == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickClose'):self.onClickClose));
		contents = ClientTimeSheetForSubcon.VerticalPanel();
		contents.setSpacing(4);
		contents.setWidth(String('400px'));
		contents.add((typeof self.scroll_panel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'scroll_panel'):self.scroll_panel));
		panel_button = ClientTimeSheetForSubcon.HorizontalPanel();
		panel_button.add((typeof self.button_close == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_close'):self.button_close));
		contents.add(panel_button);
		self.LoadNotes();
		self.dialog = ClientTimeSheetForSubcon.DialogBox();
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
		grid_notes = ClientTimeSheetForSubcon.Grid(pyjslib.len(notes), 3);
		row_formatter = grid_notes.getRowFormatter();
		grid_notes.setWidth(String('100%'));
		current_row_format = String('row_even');
		var __i = pyjslib.range(pyjslib.len(notes)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				grid_notes.setWidget(i, 0, ClientTimeSheetForSubcon.Label(notes.__getitem__(i).__getitem__(String('fname'))));
				grid_notes.setWidget(i, 1, ClientTimeSheetForSubcon.Label(notes.__getitem__(i).__getitem__(String('note'))));
				grid_notes.setWidget(i, 2, ClientTimeSheetForSubcon.Label(notes.__getitem__(i).__getitem__(String('timestamp'))));
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
		notes = pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false}, notes_display]);
		notes.setStyleName(String('col_notes'));
		self.parent.grid_timesheet.setWidget((typeof self.row == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row'):self.row), 11, notes);
		return null;
	}
	, 1, [null,null,'self', 'data']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
ClientTimeSheetForSubcon.ClientTimeSheetForSubcon = (function(){
	var cls_instance = pyjs__class_instance('ClientTimeSheetForSubcon');
	var cls_definition = new Object();
	cls_definition.__md5__ = '06c2e3e15da24e5066d1121439fb04b1';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var grid_diff_charged,label_definition_of_terms,label_select_time_sheet,i,grid_diff_charged_cell_formatter,hostname,grid_definition_of_terms_row_formatter,label_select_subcon,panel_grid_header,vp,current_row_format,label_this_page,grid_definition_of_terms_cell_formatter,label_any_questions,grid_definition_of_terms,grid_select,email,label_this_will;
		self.remote_service = ClientTimeSheetForSubcon.ClientTimeSheetForSubconService();
		label_select_subcon = ClientTimeSheetForSubcon.Label(String('Select Sub-contractor'));
		label_select_subcon.addStyleName(String('size_12'));
		self.list_box_select_subcon = ClientTimeSheetForSubcon.ListBox();
		self.list_box_select_subcon.addChangeListener((typeof self.OnSelectSubconTimeSheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnSelectSubconTimeSheet'):self.OnSelectSubconTimeSheet));
		label_select_time_sheet = ClientTimeSheetForSubcon.Label(String('Select Time Sheet:'));
		label_select_time_sheet.addStyleName(String('size_12'));
		self.list_box_select_month = ClientTimeSheetForSubcon.ListBox();
		self.list_box_select_month.addChangeListener((typeof self.OnSelectSubconTimeSheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnSelectSubconTimeSheet'):self.OnSelectSubconTimeSheet));
		self.status = ClientTimeSheetForSubcon.Label();
		label_this_page = pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{StyleName:String('label_style')}, String('This page allows you to view any adjustments made on you staff member\x27s time sheet along with explanatory note.')]);
		label_this_will = pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{StyleName:String('label_style')}, String('This will also give you more details on the number of hours invoiced to you at the beginning of each month.')]);
		label_definition_of_terms = pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{StyleName:String('definition_of_terms')}, String('Definition of Terms')]);
		hostname = ClientTimeSheetForSubcon.Window.getLocation().getHostname();
		if (pyjslib.bool(pyjslib.eq(hostname, String('www.remotestaff.co.uk')))) {
			email = String('admin@remotestaff.co.uk');
		}
		else {
			email = String('admin@remotestaff.com.au');
		}
		label_any_questions = ClientTimeSheetForSubcon.HTML(pyjslib.sprintf(String('Should you have any questions please don\x27t hesitate to contact \x3Ca href=\x27mailto:%s\x27\x3E%s\x3C/a\x3E'), new pyjslib.Tuple([email, email])));
		self.grid_header = self.GetHeaderGrid();
		panel_grid_header = ClientTimeSheetForSubcon.AbsolutePanel();
		panel_grid_header.setWidth(String('892px'));
		panel_grid_header.setHeight(String('38px'));
		panel_grid_header.add((typeof self.grid_header == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_header'):self.grid_header), 0, 0);
		self.panel_timesheet = pyjs_kwargs_call(ClientTimeSheetForSubcon, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('910px'), String('208px')])}]);
		self.footer_grid = self.GetFooterGrid();
		self.panel_grid_footer = ClientTimeSheetForSubcon.AbsolutePanel();
		self.panel_grid_footer.setWidth(String('892px'));
		self.panel_grid_footer.setHeight(String('24px'));
		self.panel_grid_footer.add((typeof self.footer_grid == 'function' && self.__is_instance__?pyjslib.getattr(self, 'footer_grid'):self.footer_grid), 0, 0);
		grid_select = ClientTimeSheetForSubcon.Grid(2, 2);
		grid_select.setWidget(0, 0, label_select_subcon);
		grid_select.setWidget(0, 1, (typeof self.list_box_select_subcon == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_select_subcon'):self.list_box_select_subcon));
		grid_select.setWidget(1, 0, label_select_time_sheet);
		grid_select.setWidget(1, 1, (typeof self.list_box_select_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_select_month'):self.list_box_select_month));
		grid_diff_charged = ClientTimeSheetForSubcon.FlexTable();
		grid_diff_charged_cell_formatter = grid_diff_charged.getCellFormatter();
		grid_diff_charged.setWidget(0, 0, ClientTimeSheetForSubcon.Label(String('Can be 2 things :')));
		grid_diff_charged_cell_formatter.setColSpan(0, 0, 2);
		grid_diff_charged.setText(1, 0, String('a.'));
		grid_diff_charged.setText(1, 1, String('Hours not worked by your staff members at any given day. If your staff member is supposed to work 8 hours a day and have only worked 5 hours, you will see a \x22-3\x22 on this column which represents the number of hours you paid for not worked by your staff. '));
		grid_diff_charged.setText(2, 1, String('These hours (or negative hours) will be given to you as a credit memo on your next month invoice if not used within the month via over time work or offset work.'));
		grid_diff_charged.setText(3, 0, String('b.'));
		grid_diff_charged.setText(3, 1, String('Hours worked above and beyond the Regular Rostered Hours, also known as Over Time. Over Time approved by you , the client, will reflect as a positive number of this column. If your staff member is supposed to work 8 hours a day and have worked 12 hour (approved and requested by you), the number \x223\x22 will reflect the number of hours worked above and beyond the agreed hours.'));
		grid_diff_charged_cell_formatter.setVerticalAlignment(1, 0, String('top'));
		grid_diff_charged_cell_formatter.setVerticalAlignment(3, 0, String('top'));
		grid_definition_of_terms = ClientTimeSheetForSubcon.Grid(6, 2);
		grid_definition_of_terms.setCellPadding(4);
		grid_definition_of_terms.setWidget(0, 0, pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false, StyleName:String('word_key')}, String('Total Hrs :')]));
		grid_definition_of_terms.setText(0, 1, String('Total number of hours your staff member is logged in to the system'));
		grid_definition_of_terms.setWidget(1, 0, pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false, StyleName:String('word_key')}, String('Adj Hrs :')]));
		grid_definition_of_terms.setText(1, 1, String('Adjusted hours by admin payable by you and to the staff member. Adjusted hours is necessary to account for unexpected disconnections,  un-authorised over time work made by your staff and paid leaves approved by you.'));
		grid_definition_of_terms.setWidget(2, 0, pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false, StyleName:String('word_key')}, String('Reg Ros Hrs :')]));
		grid_definition_of_terms.setText(2, 1, String('Regular Rostered Hours . This is the regular working hours agreed to work on by your staff member on a daily basis.'));
		grid_definition_of_terms.setWidget(3, 0, pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false, StyleName:String('word_key')}, String('Hrs Charged :')]));
		grid_definition_of_terms.setText(3, 1, String('Hours charged to you on your invoice at the beginning of each month. This is always equal to Reg Ros Hrs.'));
		grid_definition_of_terms.setWidget(4, 0, pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false, StyleName:String('word_key')}, String('Diff Charged :')]));
		grid_definition_of_terms.setWidget(4, 1, grid_diff_charged);
		grid_definition_of_terms.setWidget(5, 0, pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false, StyleName:String('word_key')}, String('Notes :')]));
		grid_definition_of_terms.setText(5, 1, String('Notes from Admin and your staff members'));
		grid_definition_of_terms_cell_formatter = grid_definition_of_terms.getCellFormatter();
		grid_definition_of_terms_row_formatter = grid_definition_of_terms.getRowFormatter();
		current_row_format = String('row_even');
		var __i = pyjslib.range(6).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(pyjslib.eq(current_row_format, String('row_even')))) {
					current_row_format = String('row_odd');
				}
				else {
					current_row_format = String('row_even');
				}
				grid_definition_of_terms_cell_formatter.setVerticalAlignment(i, 0, String('top'));
				grid_definition_of_terms_row_formatter.addStyleName(i, current_row_format);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		vp = ClientTimeSheetForSubcon.VerticalPanel();
		vp.add(grid_select);
		vp.add(panel_grid_header);
		vp.add((typeof self.panel_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_timesheet'):self.panel_timesheet));
		vp.add((typeof self.panel_grid_footer == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_grid_footer'):self.panel_grid_footer));
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		vp.add(label_this_page);
		vp.add(label_this_will);
		vp.add(label_definition_of_terms);
		vp.add(grid_definition_of_terms);
		vp.add(label_any_questions);
		ClientTimeSheetForSubcon.RootPanel().add(vp);
		self.GetSubcontractors();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.GetHeaderGrid = pyjs__bind_method(cls_instance, 'GetHeaderGrid', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_lunch_hrs,label_time_out,label_fin_lunch,label_hrs_chrg_to_client,label_day,label_reg_ros_hrs,label_time_in,grid,label_adj_hrs,label_date,label_notes,label_total_hrs,label_start_lunch;
		grid = ClientTimeSheetForSubcon.Grid(1, 13);
		grid.setBorderWidth(1);
		grid.setCellSpacing(0);
		grid.setStyleName(String('grid_header'));
		label_day = ClientTimeSheetForSubcon.Label(String('Day'));
		label_day.addStyleName(String('col_day'));
		grid.setWidget(0, 0, label_day);
		label_date = ClientTimeSheetForSubcon.Label(String('Date'));
		label_date.addStyleName(String('col_date'));
		grid.setWidget(0, 1, label_date);
		label_time_in = ClientTimeSheetForSubcon.Label(String('Time In'));
		label_time_in.addStyleName(String('col_time'));
		grid.setWidget(0, 2, label_time_in);
		label_time_out = ClientTimeSheetForSubcon.Label(String('Time Out'));
		label_time_out.addStyleName(String('col_time'));
		grid.setWidget(0, 3, label_time_out);
		label_total_hrs = ClientTimeSheetForSubcon.Label(String('Total Hrs'));
		label_total_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 4, label_total_hrs);
		label_adj_hrs = ClientTimeSheetForSubcon.Label(String('Adj Hrs'));
		label_adj_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 5, label_adj_hrs);
		label_reg_ros_hrs = ClientTimeSheetForSubcon.Label(String('Reg Ros Hrs'));
		label_reg_ros_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 6, label_reg_ros_hrs);
		label_hrs_chrg_to_client = ClientTimeSheetForSubcon.Label(String('Hrs Charged'));
		label_hrs_chrg_to_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 7, label_hrs_chrg_to_client);
		label_hrs_chrg_to_client = ClientTimeSheetForSubcon.Label(String('Diff Charged'));
		label_hrs_chrg_to_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 8, label_hrs_chrg_to_client);
		label_lunch_hrs = ClientTimeSheetForSubcon.Label(String('Lunch Hours'));
		label_lunch_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 9, label_lunch_hrs);
		label_start_lunch = ClientTimeSheetForSubcon.Label(String('Start Lunch'));
		label_start_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 10, label_start_lunch);
		label_fin_lunch = ClientTimeSheetForSubcon.Label(String('Fin Lunch'));
		label_fin_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 11, label_fin_lunch);
		label_notes = ClientTimeSheetForSubcon.Label(String('Notes'));
		label_notes.addStyleName(String('col_notes'));
		grid.setWidget(0, 12, label_notes);
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
		grid = ClientTimeSheetForSubcon.Grid(1, 13);
		grid.setBorderWidth(1);
		grid.setCellSpacing(0);
		grid.setStyleName(String('grid_header'));
		label_day = ClientTimeSheetForSubcon.Label(String(''));
		label_day.addStyleName(String('col_day'));
		grid.setWidget(0, 0, label_day);
		label_date = ClientTimeSheetForSubcon.Label(String(''));
		label_date.addStyleName(String('col_date'));
		grid.setWidget(0, 1, label_date);
		label_time_in = ClientTimeSheetForSubcon.Label(String(''));
		label_time_in.addStyleName(String('col_time'));
		grid.setWidget(0, 2, label_time_in);
		label_time_out = ClientTimeSheetForSubcon.Label(String(''));
		label_time_out.addStyleName(String('col_time'));
		grid.setWidget(0, 3, label_time_out);
		self.label_total_hrs = ClientTimeSheetForSubcon.Label(String('0.00'));
		self.label_total_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 4, (typeof self.label_total_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_total_hrs'):self.label_total_hrs));
		self.label_adj_hrs = ClientTimeSheetForSubcon.Label(String('0.00'));
		self.label_adj_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 5, (typeof self.label_adj_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_adj_hrs'):self.label_adj_hrs));
		self.label_reg_ros_hrs = ClientTimeSheetForSubcon.Label(String('0.00'));
		self.label_reg_ros_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 6, (typeof self.label_reg_ros_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_reg_ros_hrs'):self.label_reg_ros_hrs));
		self.label_hrs_chrg_to_client = ClientTimeSheetForSubcon.Label(String('0.00'));
		self.label_hrs_chrg_to_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 7, (typeof self.label_hrs_chrg_to_client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_hrs_chrg_to_client'):self.label_hrs_chrg_to_client));
		self.label_diff_hrs_chrg_to_client = ClientTimeSheetForSubcon.Label(String('0.00'));
		self.label_diff_hrs_chrg_to_client.addStyleName(String('col_hrs'));
		grid.setWidget(0, 8, (typeof self.label_diff_hrs_chrg_to_client == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_diff_hrs_chrg_to_client'):self.label_diff_hrs_chrg_to_client));
		self.label_lunch_hrs = ClientTimeSheetForSubcon.Label(String('0.00'));
		self.label_lunch_hrs.addStyleName(String('col_hrs'));
		grid.setWidget(0, 9, (typeof self.label_lunch_hrs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'label_lunch_hrs'):self.label_lunch_hrs));
		label_start_lunch = ClientTimeSheetForSubcon.Label(String(''));
		label_start_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 10, label_start_lunch);
		label_fin_lunch = ClientTimeSheetForSubcon.Label(String(''));
		label_fin_lunch.addStyleName(String('col_time'));
		grid.setWidget(0, 11, label_fin_lunch);
		label_col = ClientTimeSheetForSubcon.Label(String(''));
		label_col.addStyleName(String('col_notes'));
		grid.setWidget(0, 12, label_col);
		return grid;
	}
	, 1, [null,null,'self']);
	cls_definition.OnSelectSubconTimeSheet = pyjs__bind_method(cls_instance, 'OnSelectSubconTimeSheet', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var date,userid;
		self.ClearTimesheetDetails();
		userid = self.list_box_select_subcon.getValue(self.list_box_select_subcon.getSelectedIndex());
		if (pyjslib.bool(pyjslib.eq(userid, String('')))) {
			self.panel_timesheet.add(ClientTimeSheetForSubcon.Label(String('Please select a Sub-contractor')));
			return null;
		}
		self.panel_timesheet.add(ClientTimeSheetForSubcon.Label(String('Please wait...')));
		date = self.list_box_select_month.getValue(self.list_box_select_month.getSelectedIndex());
		self.id_get_timesheet = self.remote_service.get_timesheet(userid, date, self);
		return null;
	}
	, 1, [null,null,'self', 'evt']);
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
		if (pyjslib.bool(pyjslib.eq(col, 12))) {
			w = sender.getWidget(row, col);
			top = w.getAbsoluteTop();
			left = w.getAbsoluteLeft();
			timesheet_details_id = (typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details).__getitem__(row).__getitem__(String('id'));
			dialog = ClientTimeSheetForSubcon.DialogTimeSheetNotes(self, top, left, timesheet_details_id, row);
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
		self.label_hrs_chrg_to_client.setText(String('0.00'));
		self.label_diff_hrs_chrg_to_client.setText(String('0.00'));
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
		var notes_display,current_row_format,ros_hrs,vp_lunch_in,adjusted_hrs,i,lunch_hours,j,row_formatter,day,diff_charged_to_client,vp_timeout,hrs_charged_to_client,vp_lunch_out,vp_timein,date,notes,total_hrs,data;
		self.ClearTimesheetDetails();
		if (pyjslib.bool(response.keys().__contains__(String('error message')))) {
			self.panel_timesheet.add(ClientTimeSheetForSubcon.Label(response.__getitem__(String('error message'))));
			return null;
		}
		self.UpdateTotals(response.__getitem__(String('timesheet_totals')));
		self.timesheet_status = response.__getitem__(String('timesheet_status'));
		self.status.setText(String('Please Wait...'));
		self.timesheet_details = response.__getitem__(String('timesheet_details'));
		self.grid_timesheet = ClientTimeSheetForSubcon.Grid(pyjslib.len((typeof self.timesheet_details == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_details'):self.timesheet_details)), 13);
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
				day = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('day')));
				day.setStyleName(String('col_day'));
				self.grid_timesheet.setWidget(i, 0, day);
				date = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('date')));
				date.setStyleName(String('col_date'));
				self.grid_timesheet.setWidget(i, 1, date);
				vp_timein = ClientTimeSheetForSubcon.VerticalPanel();
				vp_timein.setStyleName(String('col_time'));
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('time_in')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_timein.add(ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('time_in')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_timesheet.setWidget(i, 2, vp_timein);
				vp_timeout = ClientTimeSheetForSubcon.VerticalPanel();
				vp_timeout.setStyleName(String('col_time'));
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('time_out')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_timeout.add(ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('time_out')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				self.grid_timesheet.setWidget(i, 3, vp_timeout);
				total_hrs = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('total_hrs')));
				total_hrs.setStyleName(String('col_hrs'));
				total_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 4, total_hrs);
				adjusted_hrs = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('adjusted_hrs')));
				adjusted_hrs.setStyleName(String('col_hrs'));
				adjusted_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 5, adjusted_hrs);
				ros_hrs = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('regular_rostered_hrs')));
				ros_hrs.setStyleName(String('col_hrs'));
				ros_hrs.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 6, ros_hrs);
				hrs_charged_to_client = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('hrs_charged_to_client')));
				hrs_charged_to_client.setStyleName(String('col_hrs'));
				hrs_charged_to_client.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 7, hrs_charged_to_client);
				diff_charged_to_client = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('diff_charged_to_client')));
				diff_charged_to_client.setStyleName(String('col_hrs'));
				diff_charged_to_client.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 8, diff_charged_to_client);
				lunch_hours = ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('lunch_hours')));
				lunch_hours.setStyleName(String('col_hrs'));
				lunch_hours.setHorizontalAlignment(String('right'));
				self.grid_timesheet.setWidget(i, 9, lunch_hours);
				vp_lunch_in = ClientTimeSheetForSubcon.VerticalPanel();
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('lunch_in')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_lunch_in.add(ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('lunch_in')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				vp_lunch_in.setStyleName(String('col_time'));
				self.grid_timesheet.setWidget(i, 10, vp_lunch_in);
				vp_lunch_out = ClientTimeSheetForSubcon.VerticalPanel();
				var __j = pyjslib.range(pyjslib.len(data.__getitem__(i).__getitem__(String('lunch_out')))).__iter__();
				try {
					while (true) {
						var j = __j.next();
						
						vp_lunch_out.add(ClientTimeSheetForSubcon.Label(data.__getitem__(i).__getitem__(String('lunch_out')).__getitem__(j)));
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
				vp_lunch_out.setStyleName(String('col_time'));
				self.grid_timesheet.setWidget(i, 11, vp_lunch_out);
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
				notes = pyjs_kwargs_call(ClientTimeSheetForSubcon, 'Label', null, null, [{wordWrap:false}, notes_display]);
				notes.setStyleName(String('col_notes'));
				self.grid_timesheet.setWidget(i, 12, notes);
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
		self.label_hrs_chrg_to_client.setText(totals.__getitem__(String('grand_total_hrs_charged_to_client')));
		self.label_diff_hrs_chrg_to_client.setText(totals.__getitem__(String('grand_total_diff_charged_to_client')));
		self.label_lunch_hrs.setText(totals.__getitem__(String('grand_total_lunch_hrs')));
		return null;
	}
	, 1, [null,null,'self', 'totals']);
	cls_definition.GetSubcontractors = pyjs__bind_method(cls_instance, 'GetSubcontractors', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.id_get_subcontractors = self.remote_service.get_subcontractors(self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderSubconList = pyjs__bind_method(cls_instance, 'RenderSubconList', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var subcon;
		self.list_box_select_subcon.clear();
		self.list_box_select_subcon.addItem(String('Select Sub-contractor'), String(''));
		var __subcon = data.__iter__();
		try {
			while (true) {
				var subcon = __subcon.next();
				
				self.list_box_select_subcon.addItem( (  ( subcon.__getitem__(String('fname')) + String(' ') )  + subcon.__getitem__(String('lname')) ) , subcon.__getitem__(String('userid')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.id_get_months = self.remote_service.get_months(self);
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.RenderMonths = pyjs__bind_method(cls_instance, 'RenderMonths', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var i,month;
		self.list_box_select_month.clear();
		i = 0;
		var __month = data.__iter__();
		try {
			while (true) {
				var month = __month.next();
				
				self.list_box_select_month.addItem(month.__getitem__(String('label')), month.__getitem__(String('date')));
				self.list_box_select_month.setItemSelected(i, month.__getitem__(String('selected')));
				i += 1;
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_subcontractors == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_subcontractors'):self.id_get_subcontractors)))) {
			self.RenderSubconList(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_months == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_months'):self.id_get_months)))) {
			self.RenderMonths(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_timesheet'):self.id_get_timesheet)))) {
			self.RenderTimesheetDetails(response);
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
ClientTimeSheetForSubcon.ClientTimeSheetForSubconService = (function(){
	var cls_instance = pyjs__class_instance('ClientTimeSheetForSubconService');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f5d30a7e123d66dd4277fb9274eb451b';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		ClientTimeSheetForSubcon.JSONProxy.__init__(self, String('/portal/client/ClientTimeSheetForSubconService.php'), new pyjslib.List([String('get_subcontractors'), String('get_months'), String('get_timesheet')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(ClientTimeSheetForSubcon.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(ClientTimeSheetForSubcon.__name__, String('__main__')))) {
	ClientTimeSheetForSubcon.app = ClientTimeSheetForSubcon.ClientTimeSheetForSubcon();
	ClientTimeSheetForSubcon.app.onModuleLoad();
}
return this;
}; /* end ClientTimeSheetForSubcon */
$pyjs.modules_hash['ClientTimeSheetForSubcon'] = $pyjs.loaded_modules['ClientTimeSheetForSubcon'];


 /* end module: ClientTimeSheetForSubcon */


/*
PYJS_DEPS: ['pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.TextArea.TextArea', 'pyjamas.ui.TextArea', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox', 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel', 'pyjamas.ui.FlexTable.FlexTable', 'pyjamas.ui.FlexTable', 'pyjamas.log', 'pygwt']
*/
