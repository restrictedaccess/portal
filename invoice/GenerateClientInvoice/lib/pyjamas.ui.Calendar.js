/* start module: pyjamas.ui.Calendar */
pyjamas.ui.Calendar = $pyjs.loaded_modules["pyjamas.ui.Calendar"] = function (__mod_name__) {
if(pyjamas.ui.Calendar.__was_initialized__) return pyjamas.ui.Calendar;
pyjamas.ui.Calendar.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Calendar';
var __name__ = pyjamas.ui.Calendar.__name__ = __mod_name__;
var Calendar = pyjamas.ui.Calendar;

pyjslib.__import__(['pyjamas.ui.pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.pyjamas.ui.SimplePanel', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.SimplePanel'], 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.SimplePanel = $pyjs.__modules__.pyjamas.ui.SimplePanel.SimplePanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.pyjamas.ui.VerticalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.pyjamas.ui.HorizontalPanel', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.pyjamas.ui.PopupPanel', 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.PopupPanel'], 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.PopupPanel = $pyjs.__modules__.pyjamas.ui.PopupPanel.PopupPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Grid.Grid', 'pyjamas.ui.pyjamas.ui.Grid', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid'], 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.Grid = $pyjs.__modules__.pyjamas.ui.Grid.Grid;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Composite.Composite', 'pyjamas.ui.pyjamas.ui.Composite', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.Composite'], 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.Composite = $pyjs.__modules__.pyjamas.ui.Composite.Composite;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Label.Label', 'pyjamas.ui.pyjamas.ui.Label', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas.ui.pyjamas.ui.Hyperlink', 'pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas.ui.Hyperlink'], 'pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.Hyperlink = $pyjs.__modules__.pyjamas.ui.Hyperlink.Hyperlink;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HyperlinkImage.HyperlinkImage', 'pyjamas.ui.pyjamas.ui.HyperlinkImage', 'pyjamas.ui.HyperlinkImage.HyperlinkImage', 'pyjamas.ui.HyperlinkImage'], 'pyjamas.ui.HyperlinkImage.HyperlinkImage', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.HyperlinkImage = $pyjs.__modules__.pyjamas.ui.HyperlinkImage.HyperlinkImage;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HTML.HTML', 'pyjamas.ui.pyjamas.ui.HTML', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FocusPanel.FocusPanel', 'pyjamas.ui.pyjamas.ui.FocusPanel', 'pyjamas.ui.FocusPanel.FocusPanel', 'pyjamas.ui.FocusPanel'], 'pyjamas.ui.FocusPanel.FocusPanel', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.FocusPanel = $pyjs.__modules__.pyjamas.ui.FocusPanel.FocusPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.pyjamas.ui.TextBox', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Image.Image', 'pyjamas.ui.pyjamas.ui.Image', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasAlignment', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.HasAlignment = $pyjs.__modules__.pyjamas.ui.HasAlignment;
pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.time', 'time'], 'time', 'pyjamas.ui.Calendar');
pyjamas.ui.Calendar.time = $pyjs.__modules__.time;
pyjamas.ui.Calendar.Calendar = (function(){
	var cls_instance = pyjs__class_instance('Calendar');
	var cls_definition = new Object();
	cls_definition.__md5__ = '791dc426eaff7266255fce081516bf9c';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var yr,mth,day;
		pyjamas.ui.Calendar.FocusPanel.__init__(self);
		self.monthsOfYear = new pyjslib.List([String('Jan'), String('Feb'), String('Mar'), String('Apr'), String('May'), String('Jun'), String('Jul'), String('Aug'), String('Sep'), String('Oct'), String('Nov'), String('Dec')]);
		self.daysOfWeek = new pyjslib.List([String('S'), String('M'), String('T'), String('W'), String('T'), String('F'), String('S')]);
		var __tupleassign__000001 = pyjamas.ui.Calendar.time.strftime(String('%Y-%m-%d')).split(String('-'));
		yr = __tupleassign__000001.__getitem__(0);
		mth = __tupleassign__000001.__getitem__(1);
		day = __tupleassign__000001.__getitem__(2);
		self.todayYear = pyjslib.int_(yr);
		self.todayMonth = pyjslib.int_(mth);
		self.todayDay = pyjslib.int_(day);
		self.currentMonth = (typeof self.todayMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayMonth'):self.todayMonth);
		self.currentYear = (typeof self.todayYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayYear'):self.todayYear);
		self.currentDay = (typeof self.todayDay == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayDay'):self.todayDay);
		self.selectedDateListeners = new pyjslib.List([]);
		self.defaultGrid = null;
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.addSelectedDateListener = pyjs__bind_method(cls_instance, 'addSelectedDateListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.selectedDateListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.removeSelectedDateListener = pyjs__bind_method(cls_instance, 'removeSelectedDateListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.selectedDateListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.isLeapYear = pyjs__bind_method(cls_instance, 'isLeapYear', function(year) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			year = arguments[1];
		}

		if (pyjslib.bool(((pyjslib.eq(year % 4, 0)) && (!pyjslib.eq(year % 100, 0))) || (pyjslib.eq(year % 400, 0)))) {
			return true;
		}
		else {
			return false;
		}
		return null;
	}
	, 1, [null,null,'self', 'year']);
	cls_definition.getDaysInMonth = pyjs__bind_method(cls_instance, 'getDaysInMonth', function(mth, year) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			mth = arguments[1];
			year = arguments[2];
		}
		var days;
		days = 0;
		if (pyjslib.bool((pyjslib.eq(mth, 1)) || (pyjslib.eq(mth, 3)) || (pyjslib.eq(mth, 5)) || (pyjslib.eq(mth, 7)) || (pyjslib.eq(mth, 8)) || (pyjslib.eq(mth, 10)) || (pyjslib.eq(mth, 12)))) {
			days = 31;
		}
		else if (pyjslib.bool((pyjslib.eq(mth, 4)) || (pyjslib.eq(mth, 6)) || (pyjslib.eq(mth, 8)) || (pyjslib.eq(mth, 11)))) {
			days = 30;
		}
		else if (pyjslib.bool((pyjslib.eq(mth, 2)) && (self.isLeapYear(year)))) {
			days = 29;
		}
		else {
			days = 28;
		}
		return days;
	}
	, 1, [null,null,'self', 'mth', 'year']);
	cls_definition.setPosition = pyjs__bind_method(cls_instance, 'setPosition', function(left, top) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			left = arguments[1];
			top = arguments[2];
		}
		var element;
		element = self.getElement();
		pyjamas.ui.Calendar.DOM.setStyleAttribute(element, String('left'), pyjslib.sprintf(String('%dpx'), left));
		pyjamas.ui.Calendar.DOM.setStyleAttribute(element, String('top'), pyjslib.sprintf(String('%dpx'), top));
		return null;
	}
	, 1, [null,null,'self', 'left', 'top']);
	cls_definition.show = pyjs__bind_method(cls_instance, 'show', function(left, top) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			left = arguments[1];
			top = arguments[2];
		}

		if (pyjslib.bool((pyjslib.cmp(left, 0) == -1))) {
			left = 0;
		}
		if (pyjslib.bool((pyjslib.cmp(top, 0) == -1))) {
			top = 0;
		}
		self.setPosition(left, top);
		self.drawCurrent();
		self.setVisible(true);
		return null;
	}
	, 1, [null,null,'self', 'left', 'top']);
	cls_definition.drawCurrent = pyjs__bind_method(cls_instance, 'drawCurrent', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var yr,mth,day;
		var __tupleassign__000002 = pyjamas.ui.Calendar.time.strftime(String('%Y-%m-%d')).split(String('-'));
		yr = __tupleassign__000002.__getitem__(0);
		mth = __tupleassign__000002.__getitem__(1);
		day = __tupleassign__000002.__getitem__(2);
		self.draw(pyjslib.int_(mth), pyjslib.int_(yr));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.draw = pyjs__bind_method(cls_instance, 'draw', function(month, year) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			month = arguments[1];
			year = arguments[2];
		}
		var g,mm,yy,hasChangeMonth,tod;
		tod = pyjamas.ui.Calendar.time.localtime();
		mm = (typeof tod.tm_mon == 'function' && tod.__is_instance__?pyjslib.getattr(tod, 'tm_mon'):tod.tm_mon);
		yy = (typeof tod.tm_year == 'function' && tod.__is_instance__?pyjslib.getattr(tod, 'tm_year'):tod.tm_year);
		hasChangeMonth = false;
		if (pyjslib.bool((!pyjslib.eq(yy, (typeof self.todayYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayYear'):self.todayYear))) || (!pyjslib.eq(mm, (typeof self.todayMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayMonth'):self.todayMonth))))) {
			hasChangeMonth = true;
			self.todayYear = yy;
			self.todayMonth = mm;
		}
		if (pyjslib.bool(((typeof self.defaultGrid == 'function' && self.__is_instance__?pyjslib.getattr(self, 'defaultGrid'):self.defaultGrid) === null))) {
			self.drawFull(month, year);
		}
		else {
			if (pyjslib.bool((!(hasChangeMonth)) && (pyjslib.eq(month, (typeof self.todayMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayMonth'):self.todayMonth))) && (pyjslib.eq(year, (typeof self.todayYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayYear'):self.todayYear))))) {
				self.middlePanel.setWidget((typeof self.defaultGrid == 'function' && self.__is_instance__?pyjslib.getattr(self, 'defaultGrid'):self.defaultGrid));
				self.currentMonth = (typeof self.todayMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayMonth'):self.todayMonth);
				self.currentYear = (typeof self.todayYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayYear'):self.todayYear);
			}
			else {
				g = self.drawGrid(month, year);
				if (pyjslib.bool(hasChangeMonth)) {
					self.defaultGrid = pyjamas.ui.Calendar.grid;
				}
			}
			self.titlePanel.setWidget(pyjamas.ui.Calendar.HTML( (  (  (  ( String('\x3Cb\x3E') + (typeof self.monthsOfYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'monthsOfYear'):self.monthsOfYear).__getitem__( ( month - 1 ) ) )  + String(' ') )  + pyjslib.str(year) )  + String('\x3C/b\x3E') ) ));
			self.setVisible(true);
		}
		return null;
	}
	, 1, [null,null,'self', 'month', 'year']);
	cls_definition.drawFull = pyjs__bind_method(cls_instance, 'drawFull', function(month, year) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			month = arguments[1];
			year = arguments[2];
		}
		var h5,bh2,h2,h1,tvp,tp,mth,b,grid,h4,b2,bh1,bh3,yr,bh4;
		self.vp = pyjamas.ui.Calendar.VerticalPanel();
		self.vp.setSpacing(2);
		self.vp.addStyleName(String('calendarbox calendar-module calendar'));
		self.setWidget((typeof self.vp == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vp'):self.vp));
		self.setVisible(false);
		mth = pyjslib.int_(month);
		yr = pyjslib.int_(year);
		tp = pyjamas.ui.Calendar.HorizontalPanel();
		tp.addStyleName(String('calendar-top-panel'));
		tp.setSpacing(5);
		h1 = pyjamas.ui.Calendar.Hyperlink(String('\x3C\x3C'));
		h1.addClickListener(pyjslib.getattr(self, String('onPreviousYear')));
		h2 = pyjamas.ui.Calendar.Hyperlink(String('\x3C'));
		h2.addClickListener(pyjslib.getattr(self, String('onPreviousMonth')));
		h4 = pyjamas.ui.Calendar.Hyperlink(String('\x3E'));
		h4.addClickListener(pyjslib.getattr(self, String('onNextMonth')));
		h5 = pyjamas.ui.Calendar.Hyperlink(String('\x3E\x3E'));
		h5.addClickListener(pyjslib.getattr(self, String('onNextYear')));
		tp.add(h1);
		tp.add(h2);
		self.titlePanel = pyjamas.ui.Calendar.SimplePanel();
		self.titlePanel.setWidget(pyjamas.ui.Calendar.HTML( (  (  (  ( String('\x3Cb\x3E') + (typeof self.monthsOfYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'monthsOfYear'):self.monthsOfYear).__getitem__( ( mth - 1 ) ) )  + String(' ') )  + pyjslib.str(yr) )  + String('\x3C/b\x3E') ) ));
		self.titlePanel.setStyleName(String('calendar-center'));
		tp.add((typeof self.titlePanel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'titlePanel'):self.titlePanel));
		tp.add(h4);
		tp.add(h5);
		tvp = pyjamas.ui.Calendar.VerticalPanel();
		tvp.setSpacing(10);
		tvp.add(tp);
		self.vp.add(tvp);
		self.middlePanel = pyjamas.ui.Calendar.SimplePanel();
		grid = self.drawGrid(mth, yr);
		self.middlePanel.setWidget(grid);
		self.vp.add((typeof self.middlePanel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'middlePanel'):self.middlePanel));
		self.defaultGrid = grid;
		bh1 = pyjamas.ui.Calendar.Hyperlink(String('Yesterday'));
		bh1.addClickListener(pyjslib.getattr(self, String('onYesterday')));
		bh2 = pyjamas.ui.Calendar.Hyperlink(String('Today'));
		bh2.addClickListener(pyjslib.getattr(self, String('onToday')));
		bh3 = pyjamas.ui.Calendar.Hyperlink(String('Tomorrow'));
		bh3.addClickListener(pyjslib.getattr(self, String('onTomorrow')));
		bh4 = pyjamas.ui.Calendar.Hyperlink(String('Cancel'));
		bh4.addClickListener(pyjslib.getattr(self, String('onCancel')));
		b = pyjamas.ui.Calendar.HorizontalPanel();
		b.add(bh1);
		b.add(bh2);
		b.add(bh3);
		b.addStyleName(String('calendar-shortcuts'));
		self.vp.add(b);
		b2 = pyjamas.ui.Calendar.SimplePanel();
		b2.add(bh4);
		b2.addStyleName(String('calendar-cancel'));
		self.vp.add(b2);
		self.setVisible(true);
		return null;
	}
	, 1, [null,null,'self', 'month', 'year']);
	cls_definition.drawGrid = pyjs__bind_method(cls_instance, 'drawGrid', function(month, year) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			month = arguments[1];
			year = arguments[2];
		}
		var rows,struct,i,pos,secs,col,grid,daysInMonth,startPos,slots,day,row;
		daysInMonth = self.getDaysInMonth(month, year);
		secs = pyjamas.ui.Calendar.time.mktime(new pyjslib.Tuple([year, month, 1, 0, 0, 0, 0, 0, -1]));
		struct = pyjamas.ui.Calendar.time.localtime(secs);
		startPos =  ( (typeof struct.tm_wday == 'function' && struct.__is_instance__?pyjslib.getattr(struct, 'tm_wday'):struct.tm_wday) + 1 )  % 7;
		slots =  (  ( startPos + daysInMonth )  - 1 ) ;
		rows =  ( pyjslib.int_( ( slots / 7 ) ) + 1 ) ;
		grid = pyjamas.ui.Calendar.Grid( ( rows + 1 ) , 7);
		grid.setWidth(String('100%'));
		grid.addTableListener(self);
		self.middlePanel.setWidget(grid);
		var __i = pyjslib.range(7).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				grid.setText(0, i, (typeof self.daysOfWeek == 'function' && self.__is_instance__?pyjslib.getattr(self, 'daysOfWeek'):self.daysOfWeek).__getitem__(i));
				grid.cellFormatter.addStyleName(0, i, String('calendar-header'));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		day = 0;
		pos = 0;
    while (pyjslib.bool((pyjslib.cmp(pos, startPos) == -1))) {
		grid.setText(1, pos, String(' '));
		grid.cellFormatter.setStyleAttr(1, pos, String('background'), String('#f3f3f3'));
		grid.cellFormatter.addStyleName(1, pos, String('calendar-blank-cell'));
		pos += 1;
    }
		row = 1;
		day = 1;
		col = startPos;
    while (pyjslib.bool((pyjslib.cmp(day, daysInMonth) != 1))) {
		if (pyjslib.bool((pyjslib.eq(pos % 7, 0)) && (!pyjslib.eq(day, 1)))) {
			row += 1;
		}
		col = pos % 7;
		grid.setText(row, col, pyjslib.str(day));
		if (pyjslib.bool((pyjslib.eq((typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear), (typeof self.todayYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayYear'):self.todayYear))) && (pyjslib.eq((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), (typeof self.todayMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayMonth'):self.todayMonth))) && (pyjslib.eq(day, (typeof self.todayDay == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayDay'):self.todayDay))))) {
			grid.cellFormatter.addStyleName(row, col, String('calendar-cell-today'));
		}
		else {
			grid.cellFormatter.addStyleName(row, col, String('calendar-day-cell'));
		}
		day += 1;
		pos += 1;
    }
		col += 1;
    while (pyjslib.bool((pyjslib.cmp(col, 7) == -1))) {
		grid.setText(row, col, String(' '));
		grid.cellFormatter.setStyleAttr(row, col, String('background'), String('#f3f3f3'));
		grid.cellFormatter.addStyleName(row, col, String('calendar-blank-cell'));
		col += 1;
    }
		return grid;
	}
	, 1, [null,null,'self', 'month', 'year']);
	cls_definition.onCellClicked = pyjs__bind_method(cls_instance, 'onCellClicked', function(grid, row, col) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			grid = arguments[1];
			row = arguments[2];
			col = arguments[3];
		}
		var selectedDay,text,listener;
		if (pyjslib.bool(pyjslib.eq(row, 0))) {
			return null;
		}
		text = grid.getText(row, col);
		if (pyjslib.bool(pyjslib.eq(text, String('')))) {
			return null;
		}
		selectedDay = pyjslib.int_(text);
		var __listener = self.selectedDateListeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				if (pyjslib.bool(pyjslib.hasattr(listener, String('onDateSelected')))) {
					listener.onDateSelected((typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear), (typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), selectedDay);
				}
				else {
					listener((typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear), (typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), selectedDay);
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.setVisible(false);
		return null;
	}
	, 1, [null,null,'self', 'grid', 'row', 'col']);
	cls_definition.onPreviousYear = pyjs__bind_method(cls_instance, 'onPreviousYear', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.drawPreviousYear();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onPreviousMonth = pyjs__bind_method(cls_instance, 'onPreviousMonth', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.drawPreviousMonth();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onNextMonth = pyjs__bind_method(cls_instance, 'onNextMonth', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.drawNextMonth();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onNextYear = pyjs__bind_method(cls_instance, 'onNextYear', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.drawNextYear();
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onDate = pyjs__bind_method(cls_instance, 'onDate', function(event, yy, mm, dd) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
			yy = arguments[2];
			mm = arguments[3];
			dd = arguments[4];
		}
		var listener;
		var __listener = self.selectedDateListeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				if (pyjslib.bool(pyjslib.hasattr(listener, String('onDateSelected')))) {
					listener.onDateSelected(yy, mm, dd);
				}
				else {
					listener(yy, mm, dd);
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.setVisible(false);
		return null;
	}
	, 1, [null,null,'self', 'event', 'yy', 'mm', 'dd']);
	cls_definition.onYesterday = pyjs__bind_method(cls_instance, 'onYesterday', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var mm,yesterday,yy,dd;
		yesterday = pyjamas.ui.Calendar.time.localtime( ( pyjamas.ui.Calendar.time.time() -  ( 3600 * 24 )  ) );
		mm = (typeof yesterday.tm_mon == 'function' && yesterday.__is_instance__?pyjslib.getattr(yesterday, 'tm_mon'):yesterday.tm_mon);
		dd = (typeof yesterday.tm_mday == 'function' && yesterday.__is_instance__?pyjslib.getattr(yesterday, 'tm_mday'):yesterday.tm_mday);
		yy = (typeof yesterday.tm_year == 'function' && yesterday.__is_instance__?pyjslib.getattr(yesterday, 'tm_year'):yesterday.tm_year);
		self.onDate(event, yy, mm, dd);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onToday = pyjs__bind_method(cls_instance, 'onToday', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var mm,yy,dd,tod;
		tod = pyjamas.ui.Calendar.time.localtime();
		mm = (typeof tod.tm_mon == 'function' && tod.__is_instance__?pyjslib.getattr(tod, 'tm_mon'):tod.tm_mon);
		dd = (typeof tod.tm_mday == 'function' && tod.__is_instance__?pyjslib.getattr(tod, 'tm_mday'):tod.tm_mday);
		yy = (typeof tod.tm_year == 'function' && tod.__is_instance__?pyjslib.getattr(tod, 'tm_year'):tod.tm_year);
		self.onDate(event, yy, mm, dd);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onTomorrow = pyjs__bind_method(cls_instance, 'onTomorrow', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var mm,yy,tom,dd;
		tom = pyjamas.ui.Calendar.time.localtime( ( pyjamas.ui.Calendar.time.time() +  ( 3600 * 24 )  ) );
		mm = (typeof tom.tm_mon == 'function' && tom.__is_instance__?pyjslib.getattr(tom, 'tm_mon'):tom.tm_mon);
		dd = (typeof tom.tm_mday == 'function' && tom.__is_instance__?pyjslib.getattr(tom, 'tm_mday'):tom.tm_mday);
		yy = (typeof tom.tm_year == 'function' && tom.__is_instance__?pyjslib.getattr(tom, 'tm_year'):tom.tm_year);
		self.onDate(event, yy, mm, dd);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onCancel = pyjs__bind_method(cls_instance, 'onCancel', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.setVisible(false);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.drawCurrent = pyjs__bind_method(cls_instance, 'drawCurrent', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var yr,mth,day;
		var __tupleassign__000003 = pyjamas.ui.Calendar.time.strftime(String('%Y-%m-%d')).split(String('-'));
		yr = __tupleassign__000003.__getitem__(0);
		mth = __tupleassign__000003.__getitem__(1);
		day = __tupleassign__000003.__getitem__(2);
		self.draw(pyjslib.int_(mth), pyjslib.int_(yr));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.drawDate = pyjs__bind_method(cls_instance, 'drawDate', function(month, year) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			month = arguments[1];
			year = arguments[2];
		}

		self.currentMonth = month;
		self.currentYear = year;
		self.draw((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), (typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear));
		return null;
	}
	, 1, [null,null,'self', 'month', 'year']);
	cls_definition.drawPreviousMonth = pyjs__bind_method(cls_instance, 'drawPreviousMonth', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(pyjslib.eq(pyjslib.int_((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth)), 1))) {
			self.currentMonth = 12;
			self.currentYear =  ( pyjslib.int_((typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear)) - 1 ) ;
		}
		else {
			self.currentMonth =  ( pyjslib.int_((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth)) - 1 ) ;
		}
		self.draw((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), (typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.drawNextMonth = pyjs__bind_method(cls_instance, 'drawNextMonth', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(pyjslib.eq(pyjslib.int_((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth)), 12))) {
			self.currentMonth = 1;
			self.currentYear =  ( pyjslib.int_((typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear)) + 1 ) ;
		}
		else {
			self.currentMonth =  ( pyjslib.int_((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth)) + 1 ) ;
		}
		self.draw((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), (typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.drawPreviousYear = pyjs__bind_method(cls_instance, 'drawPreviousYear', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.currentYear =  ( pyjslib.int_((typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear)) - 1 ) ;
		self.draw((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), (typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.drawNextYear = pyjs__bind_method(cls_instance, 'drawNextYear', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.currentYear =  ( pyjslib.int_((typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear)) + 1 ) ;
		self.draw((typeof self.currentMonth == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentMonth'):self.currentMonth), (typeof self.currentYear == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentYear'):self.currentYear));
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Calendar.FocusPanel));
})();
pyjamas.ui.Calendar.DateField = (function(){
	var cls_instance = pyjs__class_instance('DateField');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'c3e343a16db29034fa5327100511f9cc';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(format) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			format = arguments[1];
		}
		if (typeof format == 'undefined') format=String('%d-%m-%Y');
		var vp,hp,img;
		self.format = format;
		self.tbox = pyjamas.ui.Calendar.TextBox();
		self.tbox.setVisibleLength(10);
		if (pyjslib.bool((pyjslib.cmp(format.find(String('-')), 0) != -1))) {
			self.sep = String('-');
		}
		else if (pyjslib.bool((pyjslib.cmp(format.find(String('/')), 0) != -1))) {
			self.sep = String('/');
		}
		else if (pyjslib.bool((pyjslib.cmp(format.find(String('.')), 0) != -1))) {
			self.sep = String('.');
		}
		else {
			self.sep = String('');
		}
		self.calendar = pyjamas.ui.Calendar.Calendar();
		img = pyjamas.ui.Calendar.Image(String('icon_calendar.gif'));
		img.addStyleName(String('calendar-img'));
		self.calendarLink = pyjamas.ui.Calendar.HyperlinkImage(img);
		self.todayLink = pyjamas.ui.Calendar.Hyperlink(String('Today'));
		self.todayLink.addStyleName(String('calendar-today-link'));
		hp = pyjamas.ui.Calendar.HorizontalPanel();
		hp.setSpacing(2);
		vp = pyjamas.ui.Calendar.VerticalPanel();
		hp.add((typeof self.tbox == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tbox'):self.tbox));
		vp.add((typeof self.calendarLink == 'function' && self.__is_instance__?pyjslib.getattr(self, 'calendarLink'):self.calendarLink));
		vp.add((typeof self.todayLink == 'function' && self.__is_instance__?pyjslib.getattr(self, 'todayLink'):self.todayLink));
		hp.add(vp);
		pyjamas.ui.Calendar.Composite.__init__(self);
		self.initWidget(hp);
		self.tbox.addFocusListener(self);
		self.calendar.addSelectedDateListener(pyjslib.getattr(self, String('onDateSelected')));
		self.todayLink.addClickListener(pyjslib.getattr(self, String('onTodayClicked')));
		self.calendarLink.addClickListener(pyjslib.getattr(self, String('onShowCalendar')));
		return null;
	}
	, 1, [null,null,'self', 'format']);
	cls_definition.getTextBox = pyjs__bind_method(cls_instance, 'getTextBox', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.tbox == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tbox'):self.tbox);
	}
	, 1, [null,null,'self']);
	cls_definition.getCalendar = pyjs__bind_method(cls_instance, 'getCalendar', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.calendar == 'function' && self.__is_instance__?pyjslib.getattr(self, 'calendar'):self.calendar);
	}
	, 1, [null,null,'self']);
	cls_definition.setID = pyjs__bind_method(cls_instance, 'setID', function(id) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			id = arguments[1];
		}

		self.tbox.setID(id);
		return null;
	}
	, 1, [null,null,'self', 'id']);
	cls_definition.onDateSelected = pyjs__bind_method(cls_instance, 'onDateSelected', function(yyyy, mm, dd) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			yyyy = arguments[1];
			mm = arguments[2];
			dd = arguments[3];
		}
		var d,secs;
		secs = pyjamas.ui.Calendar.time.mktime(new pyjslib.Tuple([pyjslib.int_(yyyy), pyjslib.int_(mm), pyjslib.int_(dd), 0, 0, 0, 0, 0, -1]));
		d = pyjamas.ui.Calendar.time.strftime((typeof self.format == 'function' && self.__is_instance__?pyjslib.getattr(self, 'format'):self.format), pyjamas.ui.Calendar.time.localtime(secs));
		self.tbox.setText(d);
		return null;
	}
	, 1, [null,null,'self', 'yyyy', 'mm', 'dd']);
	cls_definition.onLostFocus = pyjs__bind_method(cls_instance, 'onLostFocus', function(sender) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
		}
		var text;
		text = self.tbox.getText().strip();
		if (pyjslib.bool((text) && (pyjslib.eq(pyjslib.len(text), 8)))) {
			self.tbox.setText( (  (  (  ( pyjslib.slice(text, 0, 2) + (typeof self.sep == 'function' && self.__is_instance__?pyjslib.getattr(self, 'sep'):self.sep) )  + pyjslib.slice(text, 2, 4) )  + (typeof self.sep == 'function' && self.__is_instance__?pyjslib.getattr(self, 'sep'):self.sep) )  + pyjslib.slice(text, 4, 8) ) );
		}
		return null;
	}
	, 1, [null,null,'self', 'sender']);
	cls_definition.onFocus = pyjs__bind_method(cls_instance, 'onFocus', function(sender) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
		}

 		return null;
	}
	, 1, [null,null,'self', 'sender']);
	cls_definition.onTodayClicked = pyjs__bind_method(cls_instance, 'onTodayClicked', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var today;
		today = pyjamas.ui.Calendar.time.strftime((typeof self.format == 'function' && self.__is_instance__?pyjslib.getattr(self, 'format'):self.format));
		self.tbox.setText(today);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onShowCalendar = pyjs__bind_method(cls_instance, 'onShowCalendar', function(sender) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
		}
		var y,p,x;
		p = pyjamas.ui.Calendar.CalendarPopup((typeof self.calendar == 'function' && self.__is_instance__?pyjslib.getattr(self, 'calendar'):self.calendar));
		x =  ( self.tbox.getAbsoluteLeft() + 10 ) ;
		y =  ( self.tbox.getAbsoluteTop() + 10 ) ;
		p.setPopupPosition(x, y);
		p.show();
		return null;
	}
	, 1, [null,null,'self', 'sender']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Calendar.Composite));
})();
pyjamas.ui.Calendar.CalendarPopup = (function(){
	var cls_instance = pyjs__class_instance('CalendarPopup');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'cef15b605e68ff0b289811f88d4efe0d';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(c) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			c = arguments[1];
		}
		var p;
		pyjamas.ui.Calendar.PopupPanel.__init__(self, true);
		p = pyjamas.ui.Calendar.SimplePanel();
		p.add(c);
		c.show(10, 10);
		p.setWidth(String('100%'));
		self.setWidget(p);
		return null;
	}
	, 1, [null,null,'self', 'c']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Calendar.PopupPanel));
})();
return this;
}; /* end pyjamas.ui.Calendar */
$pyjs.modules_hash['pyjamas.ui.Calendar'] = $pyjs.loaded_modules['pyjamas.ui.Calendar'];


 /* end module: pyjamas.ui.Calendar */


/*
PYJS_DEPS: ['pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas', 'pyjamas.ui', 'pyjamas.ui.SimplePanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.PopupPanel', 'pyjamas.ui.Grid.Grid', 'pyjamas.ui.Grid', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.Composite', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas.ui.Hyperlink', 'pyjamas.ui.HyperlinkImage.HyperlinkImage', 'pyjamas.ui.HyperlinkImage', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.FocusPanel.FocusPanel', 'pyjamas.ui.FocusPanel', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.ui.HasAlignment', 'pyjamas.DOM', 'time']
*/
