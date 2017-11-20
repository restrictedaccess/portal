/* start module: TimeZoneConverter */
var TimeZoneConverter = $pyjs.loaded_modules["TimeZoneConverter"] = function (__mod_name__) {
if(TimeZoneConverter.__was_initialized__) return TimeZoneConverter;
TimeZoneConverter.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'TimeZoneConverter';
var __name__ = TimeZoneConverter.__name__ = __mod_name__;
pyjslib.__import__(['pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'TimeZoneConverter');
TimeZoneConverter.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'TimeZoneConverter');
TimeZoneConverter.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'TimeZoneConverter');
TimeZoneConverter.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'TimeZoneConverter');
TimeZoneConverter.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.Button.Button', 'pyjamas.ui.Button'], 'pyjamas.ui.Button.Button', 'TimeZoneConverter');
TimeZoneConverter.Button = $pyjs.__modules__.pyjamas.ui.Button.Button;
pyjslib.__import__(['pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'TimeZoneConverter');
TimeZoneConverter.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'TimeZoneConverter');
TimeZoneConverter.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'TimeZoneConverter');
TimeZoneConverter.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'TimeZoneConverter');
TimeZoneConverter.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'TimeZoneConverter');
TimeZoneConverter.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox'], 'pyjamas.ui.CheckBox.CheckBox', 'TimeZoneConverter');
TimeZoneConverter.CheckBox = $pyjs.__modules__.pyjamas.ui.CheckBox.CheckBox;
pyjslib.__import__(['pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService'], 'pyjamas.JSONService.JSONProxy', 'TimeZoneConverter');
TimeZoneConverter.JSONProxy = $pyjs.__modules__.pyjamas.JSONService.JSONProxy;
pyjslib.__import__(['pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel'], 'pyjamas.ui.CaptionPanel.CaptionPanel', 'TimeZoneConverter');
TimeZoneConverter.CaptionPanel = $pyjs.__modules__.pyjamas.ui.CaptionPanel.CaptionPanel;
pyjslib.__import__(['pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.Calendar', 'TimeZoneConverter');
TimeZoneConverter.Calendar = $pyjs.__modules__.pyjamas.ui.Calendar.Calendar;
pyjslib.__import__(['pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.DateField', 'TimeZoneConverter');
TimeZoneConverter.DateField = $pyjs.__modules__.pyjamas.ui.Calendar.DateField;
pyjslib.__import__(['pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.ui.Calendar'], 'pyjamas.ui.Calendar.CalendarPopup', 'TimeZoneConverter');
TimeZoneConverter.CalendarPopup = $pyjs.__modules__.pyjamas.ui.Calendar.CalendarPopup;
pyjslib.__import__(['pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'TimeZoneConverter');
TimeZoneConverter.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel'], 'pyjamas.ui.ScrollPanel.ScrollPanel', 'TimeZoneConverter');
TimeZoneConverter.ScrollPanel = $pyjs.__modules__.pyjamas.ui.ScrollPanel.ScrollPanel;
pyjslib.__import__(['pyjamas.DOM.getElementById', 'pyjamas.DOM'], 'pyjamas.DOM.getElementById', 'TimeZoneConverter');
TimeZoneConverter.getElementById = $pyjs.__modules__.pyjamas.DOM.getElementById;
pyjslib.__import__(['pyjamas.Timer.Timer', 'pyjamas.Timer'], 'pyjamas.Timer.Timer', 'TimeZoneConverter');
TimeZoneConverter.Timer = $pyjs.__modules__.pyjamas.Timer.Timer;
pyjslib.__import__(['pyjamas.log', 'pyjamas'], 'pyjamas.log', 'TimeZoneConverter');
TimeZoneConverter.log = $pyjs.__modules__.pyjamas.log;
TimeZoneConverter.TimeZoneConverter = (function(){
	var cls_instance = pyjs__class_instance('TimeZoneConverter');
	var cls_definition = new Object();
	cls_definition.__md5__ = '28237963a8228ade31546a9be698269b';
	cls_definition.onModuleLoad = pyjs__bind_method(cls_instance, 'onModuleLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var label_select_ref_tz_ref,caption_input,height,hp_tz_ref_dest,label_date,hp_tz_ref_ref,caption_output,label_select_dest_tz_ref,label_to,min,vp_output,button_clear,hr,cell_format_grid,panel,vp,hp_time,label_select_time,i,label_from,button_convert,label_action,grid_input,hp_output_header,hp_caption;
		self.remote_service = TimeZoneConverter.TimeZoneConverterService();
		self.results = new pyjslib.List([]);
		self.status = TimeZoneConverter.Label();
		caption_input = TimeZoneConverter.CaptionPanel(String('Time Zone Input'));
		caption_output = TimeZoneConverter.CaptionPanel(String('Time Zone Outputs'));
		self.cal = TimeZoneConverter.Calendar();
		label_date = TimeZoneConverter.Label(String('Select Date:'));
		self.df1 = pyjs_kwargs_call(TimeZoneConverter, 'DateField', null, null, [{format:String('%Y-%m-%d')}]);
		self.df1.onTodayClicked();
		label_select_time = TimeZoneConverter.Label(String('Select Time:'));
		self.listbox_hr = TimeZoneConverter.ListBox();
		self.listbox_min = TimeZoneConverter.ListBox();
		self.listbox_ampm = TimeZoneConverter.ListBox();
		label_select_ref_tz_ref = TimeZoneConverter.Label(String('From Time Zone:'));
		self.listbox_continent_ref = TimeZoneConverter.ListBox();
		self.listbox_city_ref = TimeZoneConverter.ListBox();
		self.listbox_subcity_ref = TimeZoneConverter.ListBox();
		label_select_dest_tz_ref = TimeZoneConverter.Label(String('To Time Zone:'));
		self.listbox_continent_dest = TimeZoneConverter.ListBox();
		self.listbox_city_dest = TimeZoneConverter.ListBox();
		self.listbox_subcity_dest = TimeZoneConverter.ListBox();
		button_convert = TimeZoneConverter.Button(String('Convert'), (typeof self.Convert == 'function' && self.__is_instance__?pyjslib.getattr(self, 'Convert'):self.Convert));
		button_clear = TimeZoneConverter.Button(String('Clear All Outputs'), (typeof self.ClearAllOutputs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'ClearAllOutputs'):self.ClearAllOutputs));
		self.listbox_continent_ref.addChangeListener((typeof self.OnChangeContinentRef == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnChangeContinentRef'):self.OnChangeContinentRef));
		self.listbox_city_ref.addChangeListener((typeof self.OnChangeCityRef == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnChangeCityRef'):self.OnChangeCityRef));
		self.listbox_continent_dest.addChangeListener((typeof self.OnChangeContinentDest == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnChangeContinentDest'):self.OnChangeContinentDest));
		self.listbox_city_dest.addChangeListener((typeof self.OnChangeCityDest == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnChangeCityDest'):self.OnChangeCityDest));
		var __i = pyjslib.range(1, 13).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				hr = pyjslib.sprintf(String('%02d'), i);
				self.listbox_hr.addItem(hr, hr);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		var __i = pyjslib.range(60).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				min = pyjslib.sprintf(String('%02d'), i);
				self.listbox_min.addItem(min, min);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.listbox_ampm.addItem(String('AM'), String('AM'));
		self.listbox_ampm.addItem(String('PM'), String('PM'));
		self.listbox_continent_ref.addItem(String('Australia/Sydney'), String('Australia/Sydney'));
		self.listbox_continent_ref.addItem(String('Asia/Manila'), String('Asia/Manila'));
		self.listbox_continent_dest.addItem(String('Asia/Manila'), String('Asia/Manila'));
		self.listbox_continent_dest.addItem(String('Australia/Sydney'), String('Australia/Sydney'));
		vp = TimeZoneConverter.VerticalPanel();
		vp.setWidth(String('100%'));
		vp.setHorizontalAlignment(String('center'));
		vp.add(TimeZoneConverter.HTML(String('\x3Ch2\x3ETime Zone Converter\x3C/h2\x3E')));
		hp_caption = TimeZoneConverter.HorizontalPanel();
		hp_caption.setWidth(String('960px'));
		hp_caption.add(caption_input);
		hp_caption.add(caption_output);
		caption_input.setWidth(String('520px'));
		caption_input.setID(String('caption_input'));
		caption_output.setWidth(String('400px'));
		caption_output.setID(String('caption_output'));
		grid_input = TimeZoneConverter.Grid(5, 2);
		hp_time = TimeZoneConverter.HorizontalPanel();
		hp_time.add((typeof self.listbox_hr == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_hr'):self.listbox_hr));
		hp_time.add(TimeZoneConverter.Label(String(':')));
		hp_time.add((typeof self.listbox_min == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_min'):self.listbox_min));
		hp_time.add((typeof self.listbox_ampm == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_ampm'):self.listbox_ampm));
		self.listbox_continent_ref.setVisibleItemCount(8);
		self.listbox_city_ref.setVisibleItemCount(8);
		self.listbox_subcity_ref.setVisibleItemCount(8);
		self.listbox_city_ref.setVisible(false);
		self.listbox_subcity_ref.setVisible(false);
		self.listbox_continent_dest.setVisibleItemCount(8);
		self.listbox_city_dest.setVisibleItemCount(8);
		self.listbox_subcity_dest.setVisibleItemCount(8);
		self.listbox_city_dest.setVisible(false);
		self.listbox_subcity_dest.setVisible(false);
		hp_tz_ref_ref = TimeZoneConverter.HorizontalPanel();
		hp_tz_ref_ref.add((typeof self.listbox_continent_ref == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_continent_ref'):self.listbox_continent_ref));
		hp_tz_ref_ref.add((typeof self.listbox_city_ref == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_city_ref'):self.listbox_city_ref));
		hp_tz_ref_ref.add((typeof self.listbox_subcity_ref == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_subcity_ref'):self.listbox_subcity_ref));
		hp_tz_ref_dest = TimeZoneConverter.HorizontalPanel();
		hp_tz_ref_dest.add((typeof self.listbox_continent_dest == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_continent_dest'):self.listbox_continent_dest));
		hp_tz_ref_dest.add((typeof self.listbox_city_dest == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_city_dest'):self.listbox_city_dest));
		hp_tz_ref_dest.add((typeof self.listbox_subcity_dest == 'function' && self.__is_instance__?pyjslib.getattr(self, 'listbox_subcity_dest'):self.listbox_subcity_dest));
		grid_input.setWidget(0, 0, label_date);
		grid_input.setWidget(0, 1, (typeof self.df1 == 'function' && self.__is_instance__?pyjslib.getattr(self, 'df1'):self.df1));
		grid_input.setWidget(1, 0, label_select_time);
		grid_input.setWidget(1, 1, hp_time);
		grid_input.setWidget(2, 0, label_select_ref_tz_ref);
		grid_input.setWidget(2, 1, hp_tz_ref_ref);
		grid_input.setWidget(3, 0, label_select_dest_tz_ref);
		grid_input.setWidget(3, 1, hp_tz_ref_dest);
		grid_input.setWidget(4, 1, button_convert);
		cell_format_grid = grid_input.getCellFormatter();
		cell_format_grid.setHorizontalAlignment(0, 0, String('right'));
		cell_format_grid.setHorizontalAlignment(1, 0, String('right'));
		cell_format_grid.setHorizontalAlignment(2, 0, String('right'));
		cell_format_grid.setVerticalAlignment(2, 0, String('top'));
		cell_format_grid.setHorizontalAlignment(3, 0, String('right'));
		cell_format_grid.setVerticalAlignment(3, 0, String('top'));
		grid_input.setCellFormatter(cell_format_grid);
		caption_input.add(grid_input);
		vp_output = TimeZoneConverter.VerticalPanel();
		self.scroll_panel_output = TimeZoneConverter.ScrollPanel();
		hp_output_header = TimeZoneConverter.HorizontalPanel();
		hp_output_header.setWidth(String('372px'));
		hp_output_header.setHeight(String('38px'));
		label_from = TimeZoneConverter.Label(String('From Time Zone'));
		label_to = TimeZoneConverter.Label(String('To Time Zone'));
		label_action = TimeZoneConverter.Label(String('Action'));
		hp_output_header.add(label_from);
		hp_output_header.add(label_to);
		hp_output_header.add(label_action);
		vp_output.add(hp_output_header);
		vp_output.add((typeof self.scroll_panel_output == 'function' && self.__is_instance__?pyjslib.getattr(self, 'scroll_panel_output'):self.scroll_panel_output));
		vp_output.add(button_clear);
		caption_output.add(vp_output);
		vp.add(hp_caption);
		vp.add((typeof self.status == 'function' && self.__is_instance__?pyjslib.getattr(self, 'status'):self.status));
		TimeZoneConverter.RootPanel().add(vp);
		panel = TimeZoneConverter.getElementById(String('caption_input'));
		height = (typeof panel.clientHeight == 'function' && panel.__is_instance__?pyjslib.getattr(panel, 'clientHeight'):panel.clientHeight);
		caption_output.setHeight( ( height + String('px') ) );
		caption_input.setHeight( ( height + String('px') ) );
		self.scroll_panel_output.setHeight( (  (  ( height - 40 )  - 38 )  + String('px') ) );
		self.scroll_panel_output.setWidth(String('398px'));
		self.id_get_time_zones = self.remote_service.get_time_zones(String(''), self);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.ClearAllOutputs = pyjs__bind_method(cls_instance, 'ClearAllOutputs', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}

		self.results = new pyjslib.List([]);
		self.RenderOutputs();
		self.status.setText(String(''));
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.Convert = pyjs__bind_method(cls_instance, 'Convert', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var city,text_box,am_pm,min,hr,tz_ref,selected_date,subcity,date_time,tz_dest,continent_index,subcity_index,continent,city_index;
		continent_index = self.listbox_continent_ref.getSelectedIndex();
		if (pyjslib.bool(pyjslib.eq(continent_index, -1))) {
			TimeZoneConverter.Window.alert(String('Please select a Reference Continent'));
			return null;
		}
		tz_ref = self.listbox_continent_ref.getValue(continent_index);
		if (pyjslib.bool(pyjslib.eq(tz_ref, String('')))) {
			continent = self.listbox_continent_ref.getItemText(continent_index);
			city_index = self.listbox_city_ref.getSelectedIndex();
			if (pyjslib.bool(pyjslib.eq(city_index, -1))) {
				TimeZoneConverter.Window.alert(String('Please Select a Reference City'));
				return null;
			}
			city = self.listbox_city_ref.getValue(city_index);
			if (pyjslib.bool(pyjslib.eq(city, String('')))) {
				city = self.listbox_city_ref.getItemText(city_index);
				subcity_index = self.listbox_subcity_ref.getSelectedIndex();
				if (pyjslib.bool(pyjslib.eq(subcity_index, -1))) {
					TimeZoneConverter.Window.alert(String('Please Select a Reference Sub City'));
					return null;
				}
				subcity = self.listbox_subcity_ref.getValue(subcity_index);
				if (pyjslib.bool(pyjslib.eq(subcity, String('')))) {
					TimeZoneConverter.Window.alert(String('Please Select a Reference Sub City'));
					return null;
				}
				else {
					tz_ref = pyjslib.sprintf(String('%s/%s/%s'), new pyjslib.Tuple([continent, city, subcity]));
				}
			}
			else {
				tz_ref = pyjslib.sprintf(String('%s/%s'), new pyjslib.Tuple([continent, city]));
			}
		}
		continent_index = self.listbox_continent_dest.getSelectedIndex();
		if (pyjslib.bool(pyjslib.eq(continent_index, -1))) {
			TimeZoneConverter.Window.alert(String('Please select a Destination Continent'));
			return null;
		}
		tz_dest = self.listbox_continent_dest.getValue(continent_index);
		if (pyjslib.bool(pyjslib.eq(tz_dest, String('')))) {
			continent = self.listbox_continent_dest.getItemText(continent_index);
			city_index = self.listbox_city_dest.getSelectedIndex();
			if (pyjslib.bool(pyjslib.eq(city_index, -1))) {
				TimeZoneConverter.Window.alert(String('Please Select a Destination City'));
				return null;
			}
			city = self.listbox_city_dest.getValue(city_index);
			if (pyjslib.bool(pyjslib.eq(city, String('')))) {
				city = self.listbox_city_dest.getItemText(city_index);
				subcity_index = self.listbox_subcity_dest.getSelectedIndex();
				if (pyjslib.bool(pyjslib.eq(subcity_index, -1))) {
					TimeZoneConverter.Window.alert(String('Please Select a Destination Sub City'));
					return null;
				}
				subcity = self.listbox_subcity_dest.getValue(subcity_index);
				if (pyjslib.bool(pyjslib.eq(subcity, String('')))) {
					TimeZoneConverter.Window.alert(String('Please Select a Destination Sub City'));
					return null;
				}
				else {
					tz_dest = pyjslib.sprintf(String('%s/%s/%s'), new pyjslib.Tuple([continent, city, subcity]));
				}
			}
			else {
				tz_dest = pyjslib.sprintf(String('%s/%s'), new pyjslib.Tuple([continent, city]));
			}
		}
		text_box = self.df1.getTextBox();
		selected_date = text_box.getText();
		hr = self.listbox_hr.getValue(self.listbox_hr.getSelectedIndex());
		min = self.listbox_min.getValue(self.listbox_min.getSelectedIndex());
		am_pm = self.listbox_ampm.getValue(self.listbox_ampm.getSelectedIndex());
		if (pyjslib.bool(pyjslib.eq(am_pm, String('AM')))) {
			if (pyjslib.bool(pyjslib.eq(hr, String('12')))) {
				hr = String('00');
			}
		}
		else {
			if (pyjslib.bool(!pyjslib.eq(hr, String('12')))) {
				hr = pyjslib.int_(hr);
				hr += 12;
			}
		}
		date_time = pyjslib.sprintf(String('%s %s:%s:00'), new pyjslib.Tuple([selected_date, hr, min]));
		self.id_convert = self.remote_service.convert(tz_ref, tz_dest, date_time, self);
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.OnChangeContinentDest = pyjs__bind_method(cls_instance, 'OnChangeContinentDest', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var city,subcities,continent;
		self.listbox_city_dest.setVisible(false);
		self.listbox_subcity_dest.setVisible(false);
		continent = self.listbox_continent_dest.getValue(self.listbox_continent_dest.getSelectedIndex());
		if (pyjslib.bool(!pyjslib.eq(continent, String('')))) {
			return null;
		}
		continent = self.listbox_continent_dest.getItemText(self.listbox_continent_dest.getSelectedIndex());
		self.listbox_city_dest.setVisible(true);
		self.listbox_city_dest.clear();
		var __city = (typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__iter__();
		try {
			while (true) {
				var city = __city.next();
				
				subcities = (typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__getitem__(city).keys();
				if (pyjslib.bool(pyjslib.eq(pyjslib.len(subcities), 0))) {
					self.listbox_city_dest.addItem(city, city);
				}
				else {
					self.listbox_city_dest.addItem(city, String(''));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.OnChangeContinentRef = pyjs__bind_method(cls_instance, 'OnChangeContinentRef', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var city,subcities,continent;
		self.listbox_city_ref.setVisible(false);
		self.listbox_subcity_ref.setVisible(false);
		continent = self.listbox_continent_ref.getValue(self.listbox_continent_ref.getSelectedIndex());
		if (pyjslib.bool(!pyjslib.eq(continent, String('')))) {
			return null;
		}
		continent = self.listbox_continent_ref.getItemText(self.listbox_continent_ref.getSelectedIndex());
		self.listbox_city_ref.setVisible(true);
		self.listbox_city_ref.clear();
		var __city = (typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__iter__();
		try {
			while (true) {
				var city = __city.next();
				
				subcities = (typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__getitem__(city).keys();
				if (pyjslib.bool(pyjslib.eq(pyjslib.len(subcities), 0))) {
					self.listbox_city_ref.addItem(city, city);
				}
				else {
					self.listbox_city_ref.addItem(city, String(''));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.OnChangeCityDest = pyjs__bind_method(cls_instance, 'OnChangeCityDest', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var city,selected_city,continent,subcity,subcities;
		self.listbox_subcity_dest.setVisible(false);
		city = self.listbox_city_dest.getValue(self.listbox_city_dest.getSelectedIndex());
		if (pyjslib.bool(pyjslib.eq(city, String('')))) {
			self.listbox_subcity_dest.setVisible(true);
			self.listbox_subcity_dest.clear();
			continent = self.listbox_continent_dest.getItemText(self.listbox_continent_dest.getSelectedIndex());
			selected_city = self.listbox_city_dest.getItemText(self.listbox_city_dest.getSelectedIndex());
			subcities = (typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__getitem__(selected_city).keys();
			var __subcity = subcities.__iter__();
			try {
				while (true) {
					var subcity = __subcity.next();
					
					self.listbox_subcity_dest.addItem(subcity, subcity);
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
			return null;
		}
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.OnChangeCityRef = pyjs__bind_method(cls_instance, 'OnChangeCityRef', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var city,selected_city,continent,subcity,subcities;
		self.listbox_subcity_ref.setVisible(false);
		city = self.listbox_city_ref.getValue(self.listbox_city_ref.getSelectedIndex());
		if (pyjslib.bool(pyjslib.eq(city, String('')))) {
			self.listbox_subcity_ref.setVisible(true);
			self.listbox_subcity_ref.clear();
			continent = self.listbox_continent_ref.getItemText(self.listbox_continent_ref.getSelectedIndex());
			selected_city = self.listbox_city_ref.getItemText(self.listbox_city_ref.getSelectedIndex());
			subcities = (typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__getitem__(selected_city).keys();
			var __subcity = subcities.__iter__();
			try {
				while (true) {
					var subcity = __subcity.next();
					
					self.listbox_subcity_ref.addItem(subcity, subcity);
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
			return null;
		}
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.RenderTimeZoneList = pyjs__bind_method(cls_instance, 'RenderTimeZoneList', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var city,d,subcity,subcities,cities,continent;
		self.time_zones = new pyjslib.Dict([]);
		continent = false;
		var __d = data.values().__iter__();
		try {
			while (true) {
				var d = __d.next();
				
				if (pyjslib.bool(!pyjslib.eq(continent, d.__getitem__(String('continent'))))) {
					continent = d.__getitem__(String('continent'));
					cities = new pyjslib.Dict([]);
					city = false;
					subcities = new pyjslib.Dict([]);
					subcity = false;
					(typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__setitem__(continent, cities);
				}
				if (pyjslib.bool(!pyjslib.eq(city, d.__getitem__(String('city'))))) {
					city = d.__getitem__(String('city'));
					subcities = new pyjslib.Dict([]);
					subcity = false;
					(typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__setitem__(city, subcities);
				}
				if (pyjslib.bool(!pyjslib.eq(subcity, d.__getitem__(String('subcity'))))) {
					subcity = d.__getitem__(String('subcity'));
					(typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent).__getitem__(city).__setitem__(subcity, subcity);
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		var __continent = self.time_zones.keys().__iter__();
		try {
			while (true) {
				var continent = __continent.next();
				
				if (pyjslib.bool(pyjslib.eq(pyjslib.len((typeof self.time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'time_zones'):self.time_zones).__getitem__(continent)), 0))) {
					self.listbox_continent_ref.addItem(continent, continent);
					self.listbox_continent_dest.addItem(continent, continent);
				}
				else {
					self.listbox_continent_ref.addItem(continent, String(''));
					self.listbox_continent_dest.addItem(continent, String(''));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.AddResults = pyjs__bind_method(cls_instance, 'AddResults', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		var e;
		self.results.append(data);
		self.RenderOutputs();
		self.timer_x = 0;
		self.row_formatter = self.grid_outputs.getRowFormatter();
		e = self.row_formatter.getElement(0);
		self.row_formatter.setStyleAttr(0, String('background'), String('rgb(255, 255, 0)'));
		self.grid_outputs.setRowFormatter((typeof self.row_formatter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row_formatter'):self.row_formatter));
		TimeZoneConverter.Timer(2000, self);
		return null;
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.onTimer = pyjs__bind_method(cls_instance, 'onTimer', function(t) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			t = arguments[1];
		}

		if (pyjslib.bool((pyjslib.cmp((typeof self.timer_x == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timer_x'):self.timer_x), 10) == -1))) {
			TimeZoneConverter.Timer(100, self);
			self.timer_x += 1;
			self.row_formatter.setStyleAttr(0, String('background'), pyjslib.sprintf(String('rgb(255, 255, %s)'),  ( (typeof self.timer_x == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timer_x'):self.timer_x) * 25 ) ));
			self.grid_outputs.setRowFormatter((typeof self.row_formatter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row_formatter'):self.row_formatter));
		}
		else {
			self.row_formatter.setStyleAttr(0, String('background'), String('rgb(255, 255, 255)'));
			self.grid_outputs.setRowFormatter((typeof self.row_formatter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'row_formatter'):self.row_formatter));
		}
		return null;
	}
	, 1, [null,null,'self', 't']);
	cls_definition.RenderOutputs = pyjs__bind_method(cls_instance, 'RenderOutputs', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var vp_to,i,j,ref_dst,button,btn_element,dest_dst,vp_from;
		self.grid_outputs = TimeZoneConverter.Grid(pyjslib.len((typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results)), 3);
		self.grid_outputs.setWidth(String('380px'));
		self.scroll_panel_output.clear();
		self.scroll_panel_output.add((typeof self.grid_outputs == 'function' && self.__is_instance__?pyjslib.getattr(self, 'grid_outputs'):self.grid_outputs));
		j = 0;
		var __i = pyjslib.range( ( pyjslib.len((typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results)) - 1 ) , -1, -1).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				vp_from = TimeZoneConverter.VerticalPanel();
				if (pyjslib.bool(pyjslib.eq((typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results).__getitem__(i).__getitem__(String('ref_dst')), String('1')))) {
					ref_dst = String('DST : Yes');
				}
				else {
					ref_dst = String('DST : No');
				}
				vp_from.add(TimeZoneConverter.HTML(pyjslib.sprintf(String('\x3Cspan class=\x27tz\x27\x3E%s\x3C/span\x3E'), (typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results).__getitem__(i).__getitem__(String('ref_time_zone')))));
				vp_from.add(TimeZoneConverter.HTML(pyjslib.sprintf(String('\x3Cspan class=\x27time\x27\x3E%s\x3C/span\x3E'), (typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results).__getitem__(i).__getitem__(String('ref_date_time')))));
				vp_from.add(TimeZoneConverter.HTML(pyjslib.sprintf(String('\x3Cspan class=\x27dst\x27\x3E%s\x3C/span\x3E'), ref_dst)));
				self.grid_outputs.setWidget(j, 0, vp_from);
				vp_to = TimeZoneConverter.VerticalPanel();
				if (pyjslib.bool(pyjslib.eq((typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results).__getitem__(i).__getitem__(String('dest_dst')), String('1')))) {
					dest_dst = String('DST : Yes');
				}
				else {
					dest_dst = String('DST : No');
				}
				vp_to.add(TimeZoneConverter.HTML(pyjslib.sprintf(String('\x3Cspan class=\x27tz\x27\x3E %s\x3C/span\x3E'), (typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results).__getitem__(i).__getitem__(String('dest_time_zone')))));
				vp_to.add(TimeZoneConverter.HTML(pyjslib.sprintf(String('\x3Cspan class=\x27time\x27\x3E%s\x3C/span\x3E'), (typeof self.results == 'function' && self.__is_instance__?pyjslib.getattr(self, 'results'):self.results).__getitem__(i).__getitem__(String('dest_date_time')))));
				vp_to.add(TimeZoneConverter.HTML(pyjslib.sprintf(String('\x3Cspan class=\x27dst\x27\x3E%s\x3C/span\x3E'), dest_dst)));
				self.grid_outputs.setWidget(j, 1, vp_to);
				button = TimeZoneConverter.Button(String('Clear'), (typeof self.OnClickDeleteOutput == 'function' && self.__is_instance__?pyjslib.getattr(self, 'OnClickDeleteOutput'):self.OnClickDeleteOutput));
				btn_element = button.getElement();
				btn_element.setAttribute(String('i'), i);
				self.grid_outputs.setWidget(j, 2, button);
				j += 1;
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.OnClickDeleteOutput = pyjs__bind_method(cls_instance, 'OnClickDeleteOutput', function(evt) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			evt = arguments[1];
		}
		var i,button;
		button = evt.getElement();
		i = button.getAttribute(String('i'));
		self.results.pop(i);
		self.RenderOutputs();
		return null;
	}
	, 1, [null,null,'self', 'evt']);
	cls_definition.onRemoteResponse = pyjs__bind_method(cls_instance, 'onRemoteResponse', function(response, request_info) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			response = arguments[1];
			request_info = arguments[2];
		}

		if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_get_time_zones == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_get_time_zones'):self.id_get_time_zones)))) {
			self.RenderTimeZoneList(response);
		}
		else if (pyjslib.bool(pyjslib.eq((typeof request_info.id == 'function' && request_info.__is_instance__?pyjslib.getattr(request_info, 'id'):request_info.id), (typeof self.id_convert == 'function' && self.__is_instance__?pyjslib.getattr(self, 'id_convert'):self.id_convert)))) {
			self.AddResults(response);
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
TimeZoneConverter.TimeZoneConverterService = (function(){
	var cls_instance = pyjs__class_instance('TimeZoneConverterService');
	var cls_definition = new Object();
	cls_definition.__md5__ = '51e6c627395d9219e0767787b9b7f67c';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		TimeZoneConverter.JSONProxy.__init__(self, String('/portal/TimeZoneConverterService.php'), new pyjslib.List([String('get_time_zones'), String('convert')]));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(TimeZoneConverter.JSONProxy));
})();
if (pyjslib.bool(pyjslib.eq(TimeZoneConverter.__name__, String('__main__')))) {
	TimeZoneConverter.app = TimeZoneConverter.TimeZoneConverter();
	TimeZoneConverter.app.onModuleLoad();
}
return this;
}; /* end TimeZoneConverter */
$pyjs.modules_hash['TimeZoneConverter'] = $pyjs.loaded_modules['TimeZoneConverter'];


 /* end module: TimeZoneConverter */


/*
PYJS_DEPS: ['pyjamas.Window', 'pyjamas', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui', 'pyjamas.ui.RootPanel', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Button.Button', 'pyjamas.ui.Button', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.CheckBox.CheckBox', 'pyjamas.ui.CheckBox', 'pyjamas.JSONService.JSONProxy', 'pyjamas.JSONService', 'pyjamas.ui.CaptionPanel.CaptionPanel', 'pyjamas.ui.CaptionPanel', 'pyjamas.ui.Calendar.Calendar', 'pyjamas.ui.Calendar', 'pyjamas.ui.Calendar.DateField', 'pyjamas.ui.Calendar.CalendarPopup', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.ui.ScrollPanel.ScrollPanel', 'pyjamas.ui.ScrollPanel', 'pyjamas.DOM.getElementById', 'pyjamas.DOM', 'pyjamas.Timer.Timer', 'pyjamas.Timer', 'pyjamas.log']
*/
