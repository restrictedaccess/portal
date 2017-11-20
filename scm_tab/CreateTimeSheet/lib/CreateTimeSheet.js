/* start module: CreateTimeSheet */
var CreateTimeSheet = $pyjs.loaded_modules["CreateTimeSheet"] = function (__mod_name__) {
if(CreateTimeSheet.__was_initialized__) return CreateTimeSheet;
CreateTimeSheet.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'CreateTimeSheet';
var __name__ = CreateTimeSheet.__name__ = __mod_name__;
pyjslib.__import__(['pyjd'], 'pyjd', 'CreateTimeSheet');
CreateTimeSheet.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'CreateTimeSheet');
CreateTimeSheet.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'CreateTimeSheet');
CreateTimeSheet.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'CreateTimeSheet');
CreateTimeSheet.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'CreateTimeSheet');
CreateTimeSheet.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'CreateTimeSheet');
CreateTimeSheet.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'CreateTimeSheet');
CreateTimeSheet.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'CreateTimeSheet');
CreateTimeSheet.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'CreateTimeSheet');
CreateTimeSheet.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'CreateTimeSheet');
CreateTimeSheet.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'CreateTimeSheet');
CreateTimeSheet.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'CreateTimeSheet');
CreateTimeSheet.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pygwt'], 'pygwt', 'CreateTimeSheet');
CreateTimeSheet.pygwt = $pyjs.__modules__.pygwt;
CreateTimeSheet.CreateTimeSheet = (function(){
	var cls_instance = pyjs__class_instance('CreateTimeSheet');
	var cls_definition = new Object();
	cls_definition.__md5__ = '26711f1be08916aab3c03989254359ed';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var vp,hp_buttons,hp_top;
		self.remote_service = CreateTimeSheet.CreateTimeSheetService();
		vp = CreateTimeSheet.VerticalPanel();
		vp.setWidth(String('100%'));
		vp.setHorizontalAlignment(String('center'));
		vp.add(CreateTimeSheet.HTML(String('\x3Ch2\x3ECreate Timesheets\x3C/h2\x3E')));
		hp_top = CreateTimeSheet.HorizontalPanel();
		hp_top.setSpacing(4);
		hp_top.setHorizontalAlignment(String('center'));
		self.list_box_month = CreateTimeSheet.ListBox();
		self.list_box_month.addChangeListener((typeof self.onMonthSelected == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onMonthSelected'):self.onMonthSelected));
		self.list_box_status = CreateTimeSheet.ListBox();
		self.list_box_status.addChangeListener((typeof self.onStatusSelected == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onStatusSelected'):self.onStatusSelected));
		self.button_refresh = CreateTimeSheet.Button(String('Refresh'), (typeof self.onClickRefresh == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickRefresh'):self.onClickRefresh));
		hp_top.add(CreateTimeSheet.Label(String('Select Month')));
		hp_top.add((typeof self.list_box_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_month'):self.list_box_month));
		hp_top.add(CreateTimeSheet.Label(String('Status')));
		hp_top.add((typeof self.list_box_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_status'):self.list_box_status));
		hp_top.add((typeof self.button_refresh == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_refresh'):self.button_refresh));
		vp.add(hp_top);
		self.list_box_time_sheets = pyjs_kwargs_call(CreateTimeSheet, 'ListBox', null, null, [{MultipleSelect:true, VisibleItemCount:12}]);
		self.list_box_time_sheets.setWidth(String('480px'));
		vp.add((typeof self.list_box_time_sheets == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_time_sheets'):self.list_box_time_sheets));
		hp_buttons = CreateTimeSheet.HorizontalPanel();
		hp_buttons.setSpacing(String('4px'));
		self.button_select_all = pyjs_kwargs_call(CreateTimeSheet, 'Button', null, null, [{Width:String('128px')}, String('Select All'), (typeof self.onClickSelectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickSelectAll'):self.onClickSelectAll)]);
		self.button_unselect_all = pyjs_kwargs_call(CreateTimeSheet, 'Button', null, null, [{Width:String('128px')}, String('Unselect All'), (typeof self.onClickUnselectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickUnselectAll'):self.onClickUnselectAll)]);
		self.button_create_timesheet = pyjs_kwargs_call(CreateTimeSheet, 'Button', null, null, [{Width:String('128px')}, String('Create'), (typeof self.onClickCreateTimeSheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickCreateTimeSheet'):self.onClickCreateTimeSheet)]);
		hp_buttons.add((typeof self.button_select_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_select_all'):self.button_select_all));
		hp_buttons.add((typeof self.button_unselect_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_unselect_all'):self.button_unselect_all));
		hp_buttons.add((typeof self.button_create_timesheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_create_timesheet'):self.button_create_timesheet));
		vp.add(hp_buttons);
		self.status = CreateTimeSheet.Label();
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		CreateTimeSheet.RootPanel().add(vp);
		self.id_get_months = self.remote_service.get_months(String(''), self);
		if (pyjslib.bool((pyjslib.cmp((typeof self.id_get_months == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_months'):self.id_get_months), 0) == -1))) {
			self.status.setText(String('Server Error'));
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onClickRefresh = pyjs__bind_method(cls_instance, 'onClickRefresh', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.getBlankTimeSheets();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onMonthSelected = pyjs__bind_method(cls_instance, 'onMonthSelected', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.getBlankTimeSheets();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onStatusSelected = pyjs__bind_method(cls_instance, 'onStatusSelected', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.getBlankTimeSheets();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.renderMonthList = pyjs__bind_method(cls_instance, 'renderMonthList', function(month_list) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			month_list = arguments[1];
		}
		var i;
		var __i = pyjslib.range(pyjslib.len(month_list)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_month.addItem(month_list.__getitem__(i).__getitem__(String('label')), month_list.__getitem__(i).__getitem__(String('date')));
				if (pyjslib.bool(pyjslib.eq(month_list.__getitem__(i).__getitem__(String('selected')), String('selected')))) {
					self.list_box_month.setItemSelected(i, String('selected'));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.id_get_distinct_status = self.remote_service.get_distinct_status(String(''), self);
		return null;
	}
	, 1, [null,null,'self', 'month_list']);
	cls_definition.DisableWidgets = pyjs__bind_method(cls_instance, 'DisableWidgets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.list_box_month.setEnabled(false);
		self.list_box_status.setEnabled(false);
		self.list_box_time_sheets.setEnabled(false);
		self.button_select_all.setEnabled(false);
		self.button_unselect_all.setEnabled(false);
		self.button_create_timesheet.setEnabled(false);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.EnableWidgets = pyjs__bind_method(cls_instance, 'EnableWidgets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.list_box_month.setEnabled(true);
		self.list_box_status.setEnabled(true);
		self.list_box_time_sheets.setEnabled(true);
		self.button_select_all.setEnabled(true);
		self.button_unselect_all.setEnabled(true);
		self.button_create_timesheet.setEnabled(true);
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

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_months == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_months'):self.id_get_months)))) {
			self.renderMonthList(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_blank_time_sheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_blank_time_sheet'):self.id_get_blank_time_sheet)))) {
			self.renderBlankTimeSheet(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_distinct_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_distinct_status'):self.id_get_distinct_status)))) {
			self.renderStatus(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_create_time_sheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_create_time_sheet'):self.id_create_time_sheet)))) {
			if (pyjslib.bool((pyjslib.cmp(pyjslib.len((typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue)),  ( (typeof self.send_data_i == 'function' && self.__is_instance__?pyjslib.getattr(self, 'send_data_i'):self.send_data_i) + 1 ) ) == 1))) {
				self.send_data_i += 1;
				self.sendData();
			}
			else {
				self.status.setText(String('Creating timesheet completed.'));
				self.EnableWidgets();
				self.getBlankTimeSheets();
			}
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
	cls_definition.getBlankTimeSheets = pyjs__bind_method(cls_instance, 'getBlankTimeSheets', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var date,status;
		self.list_box_time_sheets.clear();
		date = self.list_box_month.getSelectedValues().__getitem__(0);
		status = self.list_box_status.getSelectedValues().__getitem__(0);
		if (pyjslib.bool(pyjslib.eq(status, CreateTimeSheet.Null))) {
			return null;
		}
		self.id_get_blank_time_sheet = self.remote_service.get_blank_time_sheet(date, status, self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.renderStatus = pyjs__bind_method(cls_instance, 'renderStatus', function(response) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
		}
		var status;
		self.list_box_status.addItem(String('ALL'), String('ALL'));
		var __status = response.__iter__();
		try {
			while (true) {
				var status = __status.next();
				
				self.list_box_status.addItem(status, status);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.list_box_status.selectValue(String('ACTIVE'));
		self.getBlankTimeSheets();
		return null;
	}
	, 1, [null,null,'self', 'response']);
	cls_definition.renderBlankTimeSheet = pyjs__bind_method(cls_instance, 'renderBlankTimeSheet', function(response) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
		}
		var i;
		self.list_box_time_sheets.clear();
		self.timesheet_data = response;
		var __i = pyjslib.range(pyjslib.len((typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data))).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_time_sheets.addItem( (  (  (  ( (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('staff')) + String(' :: ') )  + (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('client')) )  + String(' :: ') )  + (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('status')) ) , i);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'response']);
	cls_definition.onClickSelectAll = pyjs__bind_method(cls_instance, 'onClickSelectAll', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var i;
		var __i = pyjslib.range(pyjslib.len((typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data))).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_time_sheets.setItemSelected(i, String('selected'));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onClickUnselectAll = pyjs__bind_method(cls_instance, 'onClickUnselectAll', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var i;
		var __i = pyjslib.range(pyjslib.len((typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data))).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.list_box_time_sheets.setItemSelected(i, String(''));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onClickCreateTimeSheet = pyjs__bind_method(cls_instance, 'onClickCreateTimeSheet', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var i,confirm;
		confirm = CreateTimeSheet.Window.confirm(String('Are you sure you want to create timesheets?'));
		if (pyjslib.bool(pyjslib.eq(confirm, false))) {
			return null;
		}
		self.status.setText(String('Please wait... Generating Timesheets...'));
		self.DisableWidgets();
		self.timesheet_data_queue = new pyjslib.List([]);
		var __i = pyjslib.range(pyjslib.len((typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data))).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(self.list_box_time_sheets.isItemSelected(i))) {
					self.timesheet_data_queue.append(new pyjslib.Dict([[String('userid'), (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('userid'))], [String('leads_id'), (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('leads_id'))], [String('subcontractors_id'), (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('subcontractors_id'))], [String('staff'), (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('staff'))], [String('client'), (typeof self.timesheet_data == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data'):self.timesheet_data).__getitem__(i).__getitem__(String('client'))]]));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(pyjslib.eq(pyjslib.len((typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue)), 0))) {
			CreateTimeSheet.Window.alert(String('Nothing selected.\x0APlease select a Staff :: Client from the list.'));
			self.EnableWidgets();
			return null;
		}
		self.send_data_i = 0;
		self.sendData();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.sendData = pyjs__bind_method(cls_instance, 'sendData', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var leads_id,userid,client,subcontractors_id,date,staff;
		date = self.list_box_month.getSelectedValues().__getitem__(0);
		userid = (typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue).__getitem__((typeof self.send_data_i == 'function' && self.__is_instance__?pyjslib.getattr(self, 'send_data_i'):self.send_data_i)).__getitem__(String('userid'));
		leads_id = (typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue).__getitem__((typeof self.send_data_i == 'function' && self.__is_instance__?pyjslib.getattr(self, 'send_data_i'):self.send_data_i)).__getitem__(String('leads_id'));
		subcontractors_id = (typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue).__getitem__((typeof self.send_data_i == 'function' && self.__is_instance__?pyjslib.getattr(self, 'send_data_i'):self.send_data_i)).__getitem__(String('subcontractors_id'));
		staff = (typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue).__getitem__((typeof self.send_data_i == 'function' && self.__is_instance__?pyjslib.getattr(self, 'send_data_i'):self.send_data_i)).__getitem__(String('staff'));
		client = (typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue).__getitem__((typeof self.send_data_i == 'function' && self.__is_instance__?pyjslib.getattr(self, 'send_data_i'):self.send_data_i)).__getitem__(String('client'));
		self.status.setText(pyjslib.sprintf(String('Generating timesheet %s for client %s. %d of %d.'), new pyjslib.Tuple([staff, client,  ( (typeof self.send_data_i == 'function' && self.__is_instance__?pyjslib.getattr(self, 'send_data_i'):self.send_data_i) + 1 ) , pyjslib.len((typeof self.timesheet_data_queue == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timesheet_data_queue'):self.timesheet_data_queue))])));
		self.id_create_time_sheet = self.remote_service.create_time_sheet(date, userid, leads_id, subcontractors_id, self);
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
CreateTimeSheet.CreateTimeSheetService = (function(){
	var cls_instance = pyjs__class_instance('CreateTimeSheetService');
	var cls_definition = new Object();
	cls_definition.__md5__ = '398a540969a8bc7e4293a851d9de3183';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		CreateTimeSheet.JSONProxy.__init__(self, String('/portal/scm_tab/CreateTimeSheetService.php'), new pyjslib.List([String('get_months'), String('get_distinct_status'), String('get_blank_time_sheet'), String('create_time_sheet')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(CreateTimeSheet.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(CreateTimeSheet.__name__, String('__main__')))) {
	CreateTimeSheet.app = CreateTimeSheet.CreateTimeSheet();
	CreateTimeSheet.app.onModuleLoad();
}
return this;
}; /* end CreateTimeSheet */
$pyjs.modules_hash['CreateTimeSheet'] = $pyjs.loaded_modules['CreateTimeSheet'];


 /* end module: CreateTimeSheet */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pygwt']
*/
