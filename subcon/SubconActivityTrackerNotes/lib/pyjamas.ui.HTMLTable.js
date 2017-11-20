/* start module: pyjamas.ui.HTMLTable */
pyjamas.ui.HTMLTable = $pyjs.loaded_modules["pyjamas.ui.HTMLTable"] = function (__mod_name__) {
if(pyjamas.ui.HTMLTable.__was_initialized__) return pyjamas.ui.HTMLTable;
pyjamas.ui.HTMLTable.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.HTMLTable';
var __name__ = pyjamas.ui.HTMLTable.__name__ = __mod_name__;
var HTMLTable = pyjamas.ui.HTMLTable;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.HTMLTable');
pyjamas.ui.HTMLTable.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Panel.Panel', 'pyjamas.ui.pyjamas.ui.Panel', 'pyjamas.ui.Panel.Panel', 'pyjamas.ui.Panel'], 'pyjamas.ui.Panel.Panel', 'pyjamas.ui.HTMLTable');
pyjamas.ui.HTMLTable.Panel = $pyjs.__modules__.pyjamas.ui.Panel.Panel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.HTMLTable');
pyjamas.ui.HTMLTable.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.pyjamas.ui.CellFormatter', 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.CellFormatter'], 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.HTMLTable');
pyjamas.ui.HTMLTable.CellFormatter = $pyjs.__modules__.pyjamas.ui.CellFormatter.CellFormatter;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.pyjamas.ui.RowFormatter', 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.RowFormatter'], 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.HTMLTable');
pyjamas.ui.HTMLTable.RowFormatter = $pyjs.__modules__.pyjamas.ui.RowFormatter.RowFormatter;
pyjamas.ui.HTMLTable.widgethash = new pyjslib.Dict([]);
pyjamas.ui.HTMLTable.HTMLTable = (function(){
	var cls_instance = pyjs__class_instance('HTMLTable');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'b72d52d63d8782d45900e5e30cc7e1af';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 1 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[1];
				}
			} else {
			}
		}

		if (pyjslib.bool(!(kwargs.has_key(String('CellFormatter'))))) {
			kwargs.__setitem__(String('CellFormatter'), pyjamas.ui.HTMLTable.CellFormatter(self));
		}
		if (pyjslib.bool(!(kwargs.has_key(String('RowFormatter'))))) {
			kwargs.__setitem__(String('RowFormatter'), pyjamas.ui.HTMLTable.RowFormatter(self));
		}
		self.tableListeners = new pyjslib.List([]);
		self.widgetMap = new pyjslib.Dict([]);
		self.tableElem = pyjamas.ui.HTMLTable.DOM.createTable();
		self.bodyElem = pyjamas.ui.HTMLTable.DOM.createTBody();
		pyjamas.ui.HTMLTable.DOM.appendChild((typeof self.tableElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableElem'):self.tableElem), (typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem));
		self.setElement((typeof self.tableElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableElem'):self.tableElem));
		self.sinkEvents((typeof pyjamas.ui.HTMLTable.Event.ONCLICK == 'function' && pyjamas.ui.HTMLTable.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.HTMLTable.Event, 'ONCLICK'):pyjamas.ui.HTMLTable.Event.ONCLICK));
		pyjs_kwargs_call(pyjamas.ui.HTMLTable.Panel, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.addTableListener = pyjs__bind_method(cls_instance, 'addTableListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.tableListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.clear = pyjs__bind_method(cls_instance, 'clear', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var child,col,row;
		var __row = pyjslib.range(self.getRowCount()).__iter__();
		try {
			while (true) {
				var row = __row.next();
				
				var __col = pyjslib.range(self.getCellCount(row)).__iter__();
				try {
					while (true) {
						var col = __col.next();
						
						child = self.getWidget(row, col);
						if (pyjslib.bool((child !== null))) {
							self.removeWidget(child);
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
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.clearCell = pyjs__bind_method(cls_instance, 'clearCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var td;
		td = self.cellFormatter.getElement(row, column);
		return self.internalClearCell(td);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.getCellCount = pyjs__bind_method(cls_instance, 'getCellCount', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}

		return 0;
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.getCellFormatter = pyjs__bind_method(cls_instance, 'getCellFormatter', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.cellFormatter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'cellFormatter'):self.cellFormatter);
	}
	, 1, [null,null,'self']);
	cls_definition.getCellPadding = pyjs__bind_method(cls_instance, 'getCellPadding', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.HTMLTable.DOM.getIntAttribute((typeof self.tableElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableElem'):self.tableElem), String('cellPadding'));
	}
	, 1, [null,null,'self']);
	cls_definition.getCellSpacing = pyjs__bind_method(cls_instance, 'getCellSpacing', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.HTMLTable.DOM.getIntAttribute((typeof self.tableElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableElem'):self.tableElem), String('cellSpacing'));
	}
	, 1, [null,null,'self']);
	cls_definition.getHTML = pyjs__bind_method(cls_instance, 'getHTML', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var element;
		element = self.cellFormatter.getElement(row, column);
		return pyjamas.ui.HTMLTable.DOM.getInnerHTML(element);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.getRowCount = pyjs__bind_method(cls_instance, 'getRowCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return 0;
	}
	, 1, [null,null,'self']);
	cls_definition.getRowFormatter = pyjs__bind_method(cls_instance, 'getRowFormatter', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.rowFormatter == 'function' && self.__is_instance__?pyjslib.getattr(self, 'rowFormatter'):self.rowFormatter);
	}
	, 1, [null,null,'self']);
	cls_definition.getText = pyjs__bind_method(cls_instance, 'getText', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var element;
		self.checkCellBounds(row, column);
		element = self.cellFormatter.getElement(row, column);
		return pyjamas.ui.HTMLTable.DOM.getInnerText(element);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.getWidget = pyjs__bind_method(cls_instance, 'getWidget', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		if (typeof column == 'undefined') column=null;
		var key;
		if (pyjslib.bool((column === null))) {
			key = self.computeKeyForElement(row);
		}
		else {
			self.checkCellBounds(row, column);
			key = self.computeKey(row, column);
		}
		if (pyjslib.bool((key === null))) {
			return null;
		}
		return (typeof self.widgetMap == 'function' && self.__is_instance__?pyjslib.getattr(self, 'widgetMap'):self.widgetMap).__getitem__(key);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.isCellPresent = pyjs__bind_method(cls_instance, 'isCellPresent', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

		if (pyjslib.bool(((pyjslib.cmp(row, self.getRowCount()) != -1)) || ((pyjslib.cmp(row, 0) == -1)))) {
			return false;
		}
		if (pyjslib.bool(((pyjslib.cmp(column, 0) == -1)) || ((pyjslib.cmp(column, self.getCellCount(row)) != -1)))) {
			return false;
		}
		return true;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.__iter__ = pyjs__bind_method(cls_instance, '__iter__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.widgetMap.itervalues();
	}
	, 1, [null,null,'self']);
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var body,column,tr,listener,td,row;
		if (pyjslib.bool(pyjslib.eq(pyjamas.ui.HTMLTable.DOM.eventGetType(event), String('click')))) {
			td = self.getEventTargetCell(event);
			if (pyjslib.bool(!(td))) {
				return null;
			}
			tr = pyjamas.ui.HTMLTable.DOM.getParent(td);
			body = pyjamas.ui.HTMLTable.DOM.getParent(tr);
			row = pyjamas.ui.HTMLTable.DOM.getChildIndex(body, tr);
			column = pyjamas.ui.HTMLTable.DOM.getChildIndex(tr, td);
			var __listener = self.tableListeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					if (pyjslib.bool(pyjslib.hasattr(listener, String('onCellClicked')))) {
						listener.onCellClicked(self, row, column);
					}
					else {
						listener(self);
					}
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(!pyjslib.eq(widget.getParent(), self))) {
			return false;
		}
		self.removeWidget(widget);
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.removeTableListener = pyjs__bind_method(cls_instance, 'removeTableListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.tableListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.setBorderWidth = pyjs__bind_method(cls_instance, 'setBorderWidth', function(width) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			width = arguments[1];
		}

		pyjamas.ui.HTMLTable.DOM.setAttribute((typeof self.tableElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableElem'):self.tableElem), String('border'), pyjslib.str(width));
		return null;
	}
	, 1, [null,null,'self', 'width']);
	cls_definition.setCellPadding = pyjs__bind_method(cls_instance, 'setCellPadding', function(padding) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			padding = arguments[1];
		}

		pyjamas.ui.HTMLTable.DOM.setAttribute((typeof self.tableElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableElem'):self.tableElem), String('cellPadding'), pyjslib.str(padding));
		return null;
	}
	, 1, [null,null,'self', 'padding']);
	cls_definition.setCellSpacing = pyjs__bind_method(cls_instance, 'setCellSpacing', function(spacing) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			spacing = arguments[1];
		}

		pyjamas.ui.HTMLTable.DOM.setAttribute((typeof self.tableElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableElem'):self.tableElem), String('cellSpacing'), pyjslib.str(spacing));
		return null;
	}
	, 1, [null,null,'self', 'spacing']);
	cls_definition.setHTML = pyjs__bind_method(cls_instance, 'setHTML', function(row, column, html) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			html = arguments[3];
		}
		var td;
		self.prepareCell(row, column);
		td = self.cleanCell(row, column);
		if (pyjslib.bool((html !== null))) {
			pyjamas.ui.HTMLTable.DOM.setInnerHTML(td, html);
		}
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'html']);
	cls_definition.setText = pyjs__bind_method(cls_instance, 'setText', function(row, column, text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			text = arguments[3];
		}
		var td;
		self.prepareCell(row, column);
		td = self.cleanCell(row, column);
		if (pyjslib.bool((text !== null))) {
			pyjamas.ui.HTMLTable.DOM.setInnerText(td, text);
		}
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'text']);
	cls_definition.setWidget = pyjs__bind_method(cls_instance, 'setWidget', function(row, column, widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			widget = arguments[3];
		}
		var widget_hash,element,td;
		self.prepareCell(row, column);
		if (pyjslib.bool((widget === null))) {
			return null;
		}
		widget.removeFromParent();
		td = self.cleanCell(row, column);
		widget_hash = widget;
		element = widget.getElement();
		pyjamas.ui.HTMLTable.widgethash.__setitem__(element, widget_hash);
		(typeof self.widgetMap == 'function' && self.__is_instance__?pyjslib.getattr(self, 'widgetMap'):self.widgetMap).__setitem__(widget_hash, widget);
		self.adopt(widget, td);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'widget']);
	cls_definition.cleanCell = pyjs__bind_method(cls_instance, 'cleanCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var td;
		td = self.cellFormatter.getRawElement(row, column);
		self.internalClearCell(td);
		return td;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.computeKey = pyjs__bind_method(cls_instance, 'computeKey', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var element,child;
		element = self.cellFormatter.getRawElement(row, column);
		child = pyjamas.ui.HTMLTable.DOM.getFirstChild(element);
		if (pyjslib.bool((child === null))) {
			return null;
		}
		return self.computeKeyForElement(child);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.computeKeyForElement = pyjs__bind_method(cls_instance, 'computeKeyForElement', function(widgetElement) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widgetElement = arguments[1];
		}

		return pyjamas.ui.HTMLTable.widgethash.get(widgetElement);
	}
	, 1, [null,null,'self', 'widgetElement']);
	cls_definition.removeWidget = pyjs__bind_method(cls_instance, 'removeWidget', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}
		var element;
		self.disown(widget);
		element = widget.getElement();
    (typeof self.widgetMap == 'function' && self.__is_instance__?pyjslib.getattr(self, 'widgetMap'):self.widgetMap).__delitem__(self.computeKeyForElement(element));
    pyjamas.ui.HTMLTable.widgethash.__delitem__(element);
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.checkCellBounds = pyjs__bind_method(cls_instance, 'checkCellBounds', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var cellSize;
		self.checkRowBounds(row);
		cellSize = self.getCellCount(row);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.checkRowBounds = pyjs__bind_method(cls_instance, 'checkRowBounds', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}
		var rowSize;
		rowSize = self.getRowCount();
		return null;
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.createCell = pyjs__bind_method(cls_instance, 'createCell', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.HTMLTable.DOM.createTD();
	}
	, 1, [null,null,'self']);
	cls_definition.getBodyElement = pyjs__bind_method(cls_instance, 'getBodyElement', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem);
	}
	, 1, [null,null,'self']);
	cls_definition.getDOMCellCount = pyjs__bind_method(cls_instance, 'getDOMCellCount', function(element, row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
			row = arguments[2];
		}
		if (typeof row == 'undefined') row=null;

		if (pyjslib.bool((row === null))) {
			return self.getDOMCellCountImpl((typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem), element);
		}
		return self.getDOMCellCountImpl(element, row);
	}
	, 1, [null,null,'self', 'element', 'row']);
	cls_definition.getDOMCellCountImpl = pyjs__bind_method(cls_instance, 'getDOMCellCountImpl', function(element, row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
			row = arguments[2];
		}

		return (typeof element.rows.item(row).cells.length == 'function' && element.rows.item(row).cells.__is_instance__?pyjslib.getattr(element.rows.item(row).cells, 'length'):element.rows.item(row).cells.length);
	}
	, 1, [null,null,'self', 'element', 'row']);
	cls_definition.getDOMRowCount = pyjs__bind_method(cls_instance, 'getDOMRowCount', function(element) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
		}
		if (typeof element == 'undefined') element=null;

		if (pyjslib.bool((element === null))) {
			element = (typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem);
		}
		return self.getDOMRowCountImpl(element);
	}
	, 1, [null,null,'self', 'element']);
	cls_definition.getDOMRowCountImpl = pyjs__bind_method(cls_instance, 'getDOMRowCountImpl', function(element) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
		}

		return (typeof element.rows.length == 'function' && element.rows.__is_instance__?pyjslib.getattr(element.rows, 'length'):element.rows.length);
	}
	, 1, [null,null,'self', 'element']);
	cls_definition.getEventTargetCell = pyjs__bind_method(cls_instance, 'getEventTargetCell', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var body,td,tr;
		td = pyjamas.ui.HTMLTable.DOM.eventGetTarget(event);
    while (pyjslib.bool((td !== null))) {
		if (pyjslib.bool(pyjslib.eq(pyjamas.ui.HTMLTable.DOM.getAttribute(td, String('tagName')).lower(), String('td')))) {
			tr = pyjamas.ui.HTMLTable.DOM.getParent(td);
			body = pyjamas.ui.HTMLTable.DOM.getParent(tr);
			if (pyjslib.bool(pyjamas.ui.HTMLTable.DOM.compare(body, (typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem)))) {
				return td;
			}
		}
		if (pyjslib.bool(pyjamas.ui.HTMLTable.DOM.compare(td, (typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem)))) {
			return null;
		}
		td = pyjamas.ui.HTMLTable.DOM.getParent(td);
    }
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.insertCell = pyjs__bind_method(cls_instance, 'insertCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var tr,td;
		tr = self.rowFormatter.getRow((typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem), row);
		td = self.createCell();
		pyjamas.ui.HTMLTable.DOM.insertChild(tr, td, column);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.insertCells = pyjs__bind_method(cls_instance, 'insertCells', function(row, column, count) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			count = arguments[3];
		}
		var tr,i,td;
		tr = self.rowFormatter.getRow((typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem), row);
		var __i = pyjslib.range(column,  ( column + count ) ).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				td = self.createCell();
				pyjamas.ui.HTMLTable.DOM.insertChild(tr, td, i);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'count']);
	cls_definition.insertRow = pyjs__bind_method(cls_instance, 'insertRow', function(beforeRow) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			beforeRow = arguments[1];
		}
		var tr;
		if (pyjslib.bool(!pyjslib.eq(beforeRow, self.getRowCount()))) {
			self.checkRowBounds(beforeRow);
		}
		tr = pyjamas.ui.HTMLTable.DOM.createTR();
		pyjamas.ui.HTMLTable.DOM.insertChild((typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem), tr, beforeRow);
		return beforeRow;
	}
	, 1, [null,null,'self', 'beforeRow']);
	cls_definition.internalClearCell = pyjs__bind_method(cls_instance, 'internalClearCell', function(td) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			td = arguments[1];
		}
		var widget,maybeChild;
		maybeChild = pyjamas.ui.HTMLTable.DOM.getFirstChild(td);
		widget = null;
		if (pyjslib.bool((maybeChild !== null))) {
			widget = self.getWidget(maybeChild);
		}
		if (pyjslib.bool((widget !== null))) {
			self.removeWidget(widget);
			return true;
		}
		pyjamas.ui.HTMLTable.DOM.setInnerHTML(td, String(''));
		return false;
	}
	, 1, [null,null,'self', 'td']);
	cls_definition.prepareCell = pyjs__bind_method(cls_instance, 'prepareCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

 		return null;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.prepareRow = pyjs__bind_method(cls_instance, 'prepareRow', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}

 		return null;
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.removeCell = pyjs__bind_method(cls_instance, 'removeCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var tr,td;
		self.checkCellBounds(row, column);
		td = self.cleanCell(row, column);
		tr = self.rowFormatter.getRow((typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem), row);
		pyjamas.ui.HTMLTable.DOM.removeChild(tr, td);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.removeRow = pyjs__bind_method(cls_instance, 'removeRow', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}
		var column;
		var __column = pyjslib.range(self.getCellCount(row)).__iter__();
		try {
			while (true) {
				var column = __column.next();
				
				self.cleanCell(row, column);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		pyjamas.ui.HTMLTable.DOM.removeChild((typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem), self.rowFormatter.getRow((typeof self.bodyElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'bodyElem'):self.bodyElem), row));
		return null;
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.setCellFormatter = pyjs__bind_method(cls_instance, 'setCellFormatter', function(cellFormatter) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			cellFormatter = arguments[1];
		}

		self.cellFormatter = cellFormatter;
		return null;
	}
	, 1, [null,null,'self', 'cellFormatter']);
	cls_definition.setRowFormatter = pyjs__bind_method(cls_instance, 'setRowFormatter', function(rowFormatter) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			rowFormatter = arguments[1];
		}

		self.rowFormatter = rowFormatter;
		return null;
	}
	, 1, [null,null,'self', 'rowFormatter']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.HTMLTable.Panel));
})();
return this;
}; /* end pyjamas.ui.HTMLTable */
$pyjs.modules_hash['pyjamas.ui.HTMLTable'] = $pyjs.loaded_modules['pyjamas.ui.HTMLTable'];


 /* end module: pyjamas.ui.HTMLTable */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Panel.Panel', 'pyjamas.ui', 'pyjamas.ui.Panel', 'pyjamas.ui.Event', 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.CellFormatter', 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.RowFormatter']
*/
