/* start module: LockUnlockTimeSheet */
var LockUnlockTimeSheet = $pyjs.loaded_modules["LockUnlockTimeSheet"] = function (__mod_name__) {
if(LockUnlockTimeSheet.__was_initialized__) return LockUnlockTimeSheet;
LockUnlockTimeSheet.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'LockUnlockTimeSheet';
var __name__ = LockUnlockTimeSheet.__name__ = __mod_name__;
pyjslib.__import__(['pyjd'], 'pyjd', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pygwt'], 'pygwt', 'LockUnlockTimeSheet');
LockUnlockTimeSheet.pygwt = $pyjs.__modules__.pygwt;
LockUnlockTimeSheet.LockUnlockTimeSheet = (function(){
	var cls_instance = pyjs__class_instance('LockUnlockTimeSheet');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'cf145d577e82b80a5763441cf8b9556e';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var vp,hp_buttons,hp_top;
		self.remote_service = LockUnlockTimeSheet.LockUnlockTimeSheetService();
		vp = LockUnlockTimeSheet.VerticalPanel();
		vp.setWidth(String('100%'));
		vp.setHorizontalAlignment(String('center'));
		vp.add(LockUnlockTimeSheet.HTML(String('\x3Ch2\x3ELock - Unlock Time Sheets\x3C/h2\x3E')));
		hp_top = LockUnlockTimeSheet.HorizontalPanel();
		hp_top.setSpacing(4);
		hp_top.setHorizontalAlignment(String('center'));
		self.list_box_month = LockUnlockTimeSheet.ListBox();
		self.list_box_month.addChangeListener((typeof self.OnMonthSelected == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnMonthSelected'):self.OnMonthSelected));
		self.list_box_status = LockUnlockTimeSheet.ListBox();
		self.list_box_status.addItem(String('open'), String('open'));
		self.list_box_status.addItem(String('locked'), String('locked'));
		self.list_box_status.setItemSelected(0, String('selected'));
		self.list_box_status.addChangeListener((typeof self.OnListStatusChange == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnListStatusChange'):self.OnListStatusChange));
		self.button_refresh = LockUnlockTimeSheet.Button(String('Refresh'), (typeof self.OnClickRefresh == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickRefresh'):self.OnClickRefresh));
		hp_top.add(LockUnlockTimeSheet.Label(String('Select Month')));
		hp_top.add((typeof self.list_box_month == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_month'):self.list_box_month));
		hp_top.add(LockUnlockTimeSheet.Label(String('Status')));
		hp_top.add((typeof self.list_box_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_status'):self.list_box_status));
		hp_top.add((typeof self.button_refresh == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_refresh'):self.button_refresh));
		vp.add(hp_top);
		self.list_box_time_sheets = pyjs_kwargs_call(LockUnlockTimeSheet, 'ListBox', null, null, [{MultipleSelect:true, VisibleItemCount:12}]);
		self.list_box_time_sheets.setWidth(String('480px'));
		vp.add((typeof self.list_box_time_sheets == 'function' && self.__is_instance__?pyjslib.getattr(self, 'list_box_time_sheets'):self.list_box_time_sheets));
		hp_buttons = LockUnlockTimeSheet.HorizontalPanel();
		hp_buttons.setSpacing(String('4px'));
		self.button_select_all = pyjs_kwargs_call(LockUnlockTimeSheet, 'Button', null, null, [{Width:String('128px')}, String('Select All'), (typeof self.OnClickSelectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickSelectAll'):self.OnClickSelectAll)]);
		self.button_unselect_all = pyjs_kwargs_call(LockUnlockTimeSheet, 'Button', null, null, [{Width:String('128px')}, String('Unselect All'), (typeof self.OnClickUnselectAll == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickUnselectAll'):self.OnClickUnselectAll)]);
		self.button_lock_unlock = pyjs_kwargs_call(LockUnlockTimeSheet, 'Button', null, null, [{Width:String('128px')}, String('Lock'), (typeof self.OnClickLockUnlock == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickLockUnlock'):self.OnClickLockUnlock), (typeof self.onClickLockUnlock == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onClickLockUnlock'):self.onClickLockUnlock)]);
		hp_buttons.add((typeof self.button_select_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_select_all'):self.button_select_all));
		hp_buttons.add((typeof self.button_unselect_all == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_unselect_all'):self.button_unselect_all));
		hp_buttons.add((typeof self.button_lock_unlock == 'function' && self.__is_instance__?pyjslib.getattr(self, 'button_lock_unlock'):self.button_lock_unlock));
		vp.add(hp_buttons);
		self.status = LockUnlockTimeSheet.Label();
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		LockUnlockTimeSheet.RootPanel().add(vp);
		self.id_get_months = self.remote_service.get_months(String(''), self);
		if (pyjslib.bool((pyjslib.cmp((typeof self.id_get_months == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_months'):self.id_get_months), 0) == -1))) {
			self.status.setText(String('Server Error'));
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickSelectAll = pyjs__bind_method(cls_instance, 'OnClickSelectAll', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var i;
		var __i = pyjslib.range(self.list_box_time_sheets.getItemCount()).__iter__();
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
	cls_definition.OnClickUnselectAll = pyjs__bind_method(cls_instance, 'OnClickUnselectAll', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var i;
		var __i = pyjslib.range(self.list_box_time_sheets.getItemCount()).__iter__();
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
	cls_definition.EnableWidgets = pyjs__bind_method(cls_instance, 'EnableWidgets', function(status) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			status = arguments[1];
		}

		self.list_box_month.setEnabled(status);
		self.list_box_status.setEnabled(status);
		self.list_box_time_sheets.setEnabled(status);
		self.button_refresh.setEnabled(status);
		self.button_select_all.setEnabled(status);
		self.button_unselect_all.setEnabled(status);
		self.button_lock_unlock.setEnabled(status);
		return null;
	}
	, 1, [null,null,'self', 'status']);
	cls_definition.onRemoteResponse = pyjs__bind_method(cls_instance, 'onRemoteResponse', function(response, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
			request_info = arguments[2];
		}

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_months == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_months'):self.id_get_months)))) {
			self.RenderMonthList(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_time_sheet == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_time_sheet'):self.id_get_time_sheet)))) {
			self.RenderTimeSheet(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_change_status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_change_status'):self.id_change_status)))) {
			if (pyjslib.bool((pyjslib.cmp((typeof self.time_sheet_ids_x == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_sheet_ids_x'):self.time_sheet_ids_x),  ( pyjslib.len((typeof self.time_sheet_ids == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_sheet_ids'):self.time_sheet_ids)) - 1 ) ) == -1))) {
				self.time_sheet_ids_x += 1;
				self.UpdateTimeSheetStatus();
			}
			else {
				self.EnableWidgets(true);
				self.GetTimeSheet();
				self.status.setText(String('Time sheets updated.'));
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
	cls_definition.RenderTimeSheet = pyjs__bind_method(cls_instance, 'RenderTimeSheet', function(response) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
		}
		var i,item;
		var __i = pyjslib.range(pyjslib.len(response)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				item = pyjslib.sprintf(String('%s %s :: %s %s'), new pyjslib.Tuple([response.__getitem__(i).__getitem__(String('staff_fname')), response.__getitem__(i).__getitem__(String('staff_lname')), response.__getitem__(i).__getitem__(String('client_fname')), response.__getitem__(i).__getitem__(String('client_lname'))]));
				self.list_box_time_sheets.addItem(item, response.__getitem__(i).__getitem__(String('id')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'response']);
	cls_definition.OnClickRefresh = pyjs__bind_method(cls_instance, 'OnClickRefresh', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.GetTimeSheet();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.RenderMonthList = pyjs__bind_method(cls_instance, 'RenderMonthList', function(response) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
		}
		var i,selected_month_index;
		var __i = pyjslib.range(pyjslib.len(response)).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(pyjslib.eq(response.__getitem__(i).__getitem__(String('selected')), String('selected')))) {
					selected_month_index = i;
				}
				self.list_box_month.addItem(response.__getitem__(i).__getitem__(String('label')), response.__getitem__(i).__getitem__(String('date')));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.list_box_month.setItemSelected(selected_month_index, String('selected'));
		self.GetTimeSheet();
		return null;
	}
	, 1, [null,null,'self', 'response']);
	cls_definition.GetTimeSheet = pyjs__bind_method(cls_instance, 'GetTimeSheet', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var date,status;
		self.list_box_time_sheets.clear();
		date = self.list_box_month.getSelectedValues().__getitem__(0);
		status = self.list_box_status.getSelectedValues().__getitem__(0);
		self.id_get_time_sheet = self.remote_service.get_time_sheet(date, status, self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnMonthSelected = pyjs__bind_method(cls_instance, 'OnMonthSelected', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.GetTimeSheet();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnListStatusChange = pyjs__bind_method(cls_instance, 'OnListStatusChange', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var status;
		status = self.list_box_status.getSelectedValues().__getitem__(0);
		if (pyjslib.bool(pyjslib.eq(status, String('open')))) {
			self.button_lock_unlock.setText(String('Lock'));
		}
		else {
			self.button_lock_unlock.setText(String('Re Open'));
		}
		self.GetTimeSheet();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.OnClickLockUnlock = pyjs__bind_method(cls_instance, 'OnClickLockUnlock', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var confirm;
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(self.list_box_time_sheets.getSelectedValues()), 0))) {
			LockUnlockTimeSheet.Window.alert(String('Nothing to update.\x0APlease select from the list.'));
			return null;
		}
		confirm = LockUnlockTimeSheet.Window.confirm(pyjslib.sprintf(String('Are you sure you want to %s?'), self.button_lock_unlock.getText()));
		if (pyjslib.bool(pyjslib.eq(confirm, false))) {
			return null;
		}
		self.EnableWidgets(false);
		self.time_sheet_ids_x = 0;
		self.time_sheet_ids = self.list_box_time_sheets.getSelectedValues();
		self.UpdateTimeSheetStatus();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.UpdateTimeSheetStatus = pyjs__bind_method(cls_instance, 'UpdateTimeSheetStatus', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var status,new_status;
		self.status.setText(pyjslib.sprintf(String('Updating %d of %d'), new pyjslib.Tuple([ ( (typeof self.time_sheet_ids_x == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_sheet_ids_x'):self.time_sheet_ids_x) + 1 ) , pyjslib.len((typeof self.time_sheet_ids == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_sheet_ids'):self.time_sheet_ids))])));
		status = self.list_box_status.getSelectedValues().__getitem__(0);
		if (pyjslib.bool(pyjslib.eq(status, String('open')))) {
			new_status = String('locked');
		}
		else {
			new_status = String('open');
		}
		self.id_change_status = self.remote_service.change_status((typeof self.time_sheet_ids == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_sheet_ids'):self.time_sheet_ids).__getitem__((typeof self.time_sheet_ids_x == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_sheet_ids_x'):self.time_sheet_ids_x)), new_status, self);
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
LockUnlockTimeSheet.LockUnlockTimeSheetService = (function(){
	var cls_instance = pyjs__class_instance('LockUnlockTimeSheetService');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f8c2f9cebe6f6d9824e9894507a2f197';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		LockUnlockTimeSheet.JSONProxy.__init__(self, String('/portal/scm_tab/LockUnlockTimeSheetService.php'), new pyjslib.List([String('get_months'), String('get_time_sheet'), String('change_status')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(LockUnlockTimeSheet.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(LockUnlockTimeSheet.__name__, String('__main__')))) {
	LockUnlockTimeSheet.app = LockUnlockTimeSheet.LockUnlockTimeSheet();
	LockUnlockTimeSheet.app.onModuleLoad();
}
return this;
}; /* end LockUnlockTimeSheet */
$pyjs.modules_hash['LockUnlockTimeSheet'] = $pyjs.loaded_modules['LockUnlockTimeSheet'];


 /* end module: LockUnlockTimeSheet */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pygwt']
*/
