/* start module: SubconActivityTrackerNotes */
var SubconActivityTrackerNotes = $pyjs.loaded_modules["SubconActivityTrackerNotes"] = function (__mod_name__) {
if(SubconActivityTrackerNotes.__was_initialized__) return SubconActivityTrackerNotes;
SubconActivityTrackerNotes.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'SubconActivityTrackerNotes';
var __name__ = SubconActivityTrackerNotes.__name__ = __mod_name__;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjslib.__import__(['pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox'], 'pyjamas.ui.DialogBox.DialogBox', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.DialogBox = $pyjs.__modules__.pyjamas.ui.DialogBox.DialogBox;
pyjslib.__import__(['pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel'], 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.AbsolutePanel = $pyjs.__modules__.pyjamas.ui.AbsolutePanel.AbsolutePanel;
pyjslib.__import__(['pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.Calendar', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.Calendar = $pyjs.__modules__.pyjamas.ui.Calendar.Calendar;
pyjslib.__import__(['pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.DateField', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.DateField = $pyjs.__modules__.pyjamas.ui.Calendar.DateField;
pyjslib.__import__(['pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.CalendarPopup', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.CalendarPopup = $pyjs.__modules__.pyjamas.ui.Calendar.CalendarPopup;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'SubconActivityTrackerNotes');
SubconActivityTrackerNotes.log = $pyjs.__modules__.pyjamas.log;
SubconActivityTrackerNotes.NOTES_PER_PAGE = 28;
SubconActivityTrackerNotes.SubconTimeSheet = (function(){
	var cls_instance = pyjs__class_instance('SubconTimeSheet');
	var cls_definition = new Object();
	cls_definition.__md5__ = '9ecec915bcaaddc2f355fb372524c321';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var vp,button_retrieve_notes,panel_date_filter;
		self.remote_service = SubconActivityTrackerNotes.SubconActivityTrackerNotesService();
		self.cal = SubconActivityTrackerNotes.Calendar();
		self.datefield_from = pyjs_kwargs_call(SubconActivityTrackerNotes, 'DateField', null, null, [{format:String('%Y-%m-%d')}]);
		self.datefield_from.onTodayClicked();
		self.datefield_to = pyjs_kwargs_call(SubconActivityTrackerNotes, 'DateField', null, null, [{format:String('%Y-%m-%d')}]);
		self.datefield_to.onTodayClicked();
		button_retrieve_notes = SubconActivityTrackerNotes.Button(String('Retrieve Activity Notes'), (typeof self.RetrieveNotes == 'function' && self.__is_instance__?pyjslib.getattr(self, 'RetrieveNotes'):self.RetrieveNotes));
		self.listbox_pager = SubconActivityTrackerNotes.ListBox();
		self.listbox_pager.addChangeListener((typeof self.OnChangePage == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnChangePage'):self.OnChangePage));
		self.grid_header = self.GetHeaderGrid();
		self.status = SubconActivityTrackerNotes.Label();
		panel_date_filter = SubconActivityTrackerNotes.HorizontalPanel();
		panel_date_filter.setSpacing(8);
		panel_date_filter.setVerticalAlignment(String('middle'));
		panel_date_filter.add(SubconActivityTrackerNotes.Label(String('Inclusive Dates : From')));
		panel_date_filter.add((typeof self.datefield_from == 'function' && self.__is_instance__?pyjslib.getattr(self, 'datefield_from'):self.datefield_from));
		panel_date_filter.add(SubconActivityTrackerNotes.Label(String('To')));
		panel_date_filter.add((typeof self.datefield_to == 'function' && self.__is_instance__?pyjslib.getattr(self, 'datefield_to'):self.datefield_to));
		panel_date_filter.add(button_retrieve_notes);
		self.panel_pager = SubconActivityTrackerNotes.HorizontalPanel();
		self.panel_pager.setVerticalAlignment(String('middle'));
		self.panel_notes = pyjs_kwargs_call(SubconActivityTrackerNotes, 'ScrollPanel', null, null, [{Size:new pyjslib.Tuple([String('856px'), String('280px')])}]);
		vp = SubconActivityTrackerNotes.VerticalPanel();
		vp.add(panel_date_filter);
		vp.add((typeof self.panel_pager == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_pager'):self.panel_pager));
		vp.add((typeof self.grid_header == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_header'):self.grid_header));
		vp.add((typeof self.panel_notes == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel_notes'):self.panel_notes));
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		SubconActivityTrackerNotes.RootPanel().add(vp);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RetrieveNotes = pyjs__bind_method(cls_instance, 'RetrieveNotes', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var start_date,end_date;
		self.panel_notes.clear();
		self.panel_pager.clear();
		start_date = self.datefield_from.getTextBox().getText();
		end_date = self.datefield_to.getTextBox().getText();
		self.id_get_notes = self.remote_service.get_notes(start_date, end_date, self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.GetHeaderGrid = pyjs__bind_method(cls_instance, 'GetHeaderGrid', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_client,label_time_in,grid,label_date,label_notes;
		grid = SubconActivityTrackerNotes.Grid(1, 4);
		grid.setBorderWidth(1);
		grid.setCellSpacing(0);
		grid.setStyleName(String('grid_header'));
		label_date = SubconActivityTrackerNotes.Label(String('Date'));
		label_date.addStyleName(String('col_date'));
		grid.setWidget(0, 0, label_date);
		label_time_in = SubconActivityTrackerNotes.Label(String('Time'));
		label_time_in.addStyleName(String('col_time'));
		grid.setWidget(0, 1, label_time_in);
		label_client = SubconActivityTrackerNotes.Label(String('Client'));
		label_client.addStyleName(String('col_client'));
		grid.setWidget(0, 2, label_client);
		label_notes = SubconActivityTrackerNotes.Label(String('Notes'));
		label_notes.addStyleName(String('col_notes'));
		grid.setWidget(0, 3, label_notes);
		return grid;
	}
	, 1, [null,null,'self']);
	cls_definition.OnChangePage = pyjs__bind_method(cls_instance, 'OnChangePage', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.panel_notes.clear();
		self.DisplaySelectedPage();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.DisplaySelectedPage = pyjs__bind_method(cls_instance, 'DisplaySelectedPage', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var month_day_prev,current_row_format,label_note,first_index,last_index,month_day,row_formatter,note,i,label_month_day_display,grid,label_time,month_day_display,page,label_client_name;
		page = self.listbox_pager.getSelectedIndex();
		first_index =  ( page * SubconActivityTrackerNotes.NOTES_PER_PAGE ) ;
		if (pyjslib.bool(pyjslib.eq(page, self.listbox_pager.getItemCount()))) {
			last_index = pyjslib.len((typeof self.notes == 'function' && self.__is_instance__?pyjslib.getattr(self, 'notes'):self.notes));
		}
		else {
			last_index =  ( first_index + SubconActivityTrackerNotes.NOTES_PER_PAGE ) ;
		}
		grid = SubconActivityTrackerNotes.Grid( ( last_index - first_index ) , 4);
		grid.setWidth(String('804'));
		row_formatter = grid.getRowFormatter();
		current_row_format = String('row_even');
		month_day_prev = String('');
		i = 0;
		var __note = pyjslib.slice((typeof self.notes == 'function' && self.__is_instance__?pyjslib.getattr(self, 'notes'):self.notes), first_index, last_index).__iter__();
		try {
			while (true) {
				var note = __note.next();
				
				month_day = note.__getitem__(String('month_day'));
				if (pyjslib.bool(pyjslib.eq(month_day_prev, month_day))) {
					month_day_display = String('');
				}
				else {
					month_day_display = month_day;
					month_day_prev = month_day;
				}
				label_month_day_display = SubconActivityTrackerNotes.Label(month_day_display);
				label_month_day_display.setStyleName(String('col_date'));
				grid.setWidget(i, 0, label_month_day_display);
				label_time = SubconActivityTrackerNotes.Label(note.__getitem__(String('time')));
				label_time.setStyleName(String('col_time'));
				grid.setWidget(i, 1, label_time);
				label_client_name = SubconActivityTrackerNotes.Label( (  ( note.__getitem__(String('client_fname')) + String(' ') )  + note.__getitem__(String('client_lname')) ) );
				label_client_name.setStyleName(String('col_client'));
				grid.setWidget(i, 2, label_client_name);
				label_note = SubconActivityTrackerNotes.Label(note.__getitem__(String('note')));
				label_note.setStyleName(String('col_notes'));
				grid.setWidget(i, 3, label_note);
				if (pyjslib.bool(pyjslib.eq(current_row_format, String('row_even')))) {
					current_row_format = String('row_odd');
				}
				else {
					current_row_format = String('row_even');
				}
				row_formatter.addStyleName(i, current_row_format);
				row_formatter.addStyleName(i, String('size_12'));
				i += 1;
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.panel_notes.add(grid);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.ShowPager = pyjs__bind_method(cls_instance, 'ShowPager', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var i,pages;
		pages =  ( pyjslib.len((typeof self.notes == 'function' && self.__is_instance__?pyjslib.getattr(self, 'notes'):self.notes)) / SubconActivityTrackerNotes.NOTES_PER_PAGE ) ;

            pages = Math.ceil(pages);
        
		self.listbox_pager.clear();
		var __i = pyjslib.range(pages).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.listbox_pager.addItem( ( i + 1 ) , i);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.panel_pager.add(SubconActivityTrackerNotes.Label(String('Pages : ')));
		self.panel_pager.add((typeof self.listbox_pager == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_pager'):self.listbox_pager));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.RenderTimeSheetNotes = pyjs__bind_method(cls_instance, 'RenderTimeSheetNotes', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}

		self.notes = data.__getitem__(String('notes'));
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len((typeof self.notes == 'function' && self.__is_instance__?pyjslib.getattr(self, 'notes'):self.notes)), SubconActivityTrackerNotes.NOTES_PER_PAGE) == 1))) {
			self.ShowPager();
		}
		else {
			self.listbox_pager.clear();
			self.listbox_pager.addItem(1, 0);
		}
		self.DisplaySelectedPage();
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_notes == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_notes'):self.id_get_notes)))) {
			self.RenderTimeSheetNotes(response);
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
SubconActivityTrackerNotes.SubconActivityTrackerNotesService = (function(){
	var cls_instance = pyjs__class_instance('SubconActivityTrackerNotesService');
	var cls_definition = new Object();
	cls_definition.__md5__ = '9a08304c6199339d9ed4cfb48d60519d';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		SubconActivityTrackerNotes.JSONProxy.__init__(self, String('/portal/subcon/SubconActivityTrackerNotesService.php'), new pyjslib.List([String('get_notes')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(SubconActivityTrackerNotes.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(SubconActivityTrackerNotes.__name__, String('__main__')))) {
	SubconActivityTrackerNotes.app = SubconActivityTrackerNotes.SubconTimeSheet();
	SubconActivityTrackerNotes.app.onModuleLoad();
}
return this;
}; /* end SubconActivityTrackerNotes */
$pyjs.modules_hash['SubconActivityTrackerNotes'] = $pyjs.loaded_modules['SubconActivityTrackerNotes'];


 /* end module: SubconActivityTrackerNotes */


/*
PYJS_DEPS: ['pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.DialogBox.DialogBox', 'pyjamas.ui.DialogBox', 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel', 'pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar', 'pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.log']
*/
