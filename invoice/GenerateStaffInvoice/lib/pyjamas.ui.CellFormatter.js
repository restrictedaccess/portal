/* start module: pyjamas.ui.CellFormatter */
pyjamas.ui.CellFormatter = $pyjs.loaded_modules["pyjamas.ui.CellFormatter"] = function (__mod_name__) {
if(pyjamas.ui.CellFormatter.__was_initialized__) return pyjamas.ui.CellFormatter;
pyjamas.ui.CellFormatter.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.CellFormatter';
var __name__ = pyjamas.ui.CellFormatter.__name__ = __mod_name__;
var CellFormatter = pyjamas.ui.CellFormatter;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.CellFormatter');
pyjamas.ui.CellFormatter.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Applier', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Applier', 'pyjamas.ui'], 'pyjamas.ui.Applier', 'pyjamas.ui.CellFormatter');
pyjamas.ui.CellFormatter.Applier = $pyjs.__modules__.pyjamas.ui.Applier;
pyjamas.ui.CellFormatter.CellFormatter = (function(){
	var cls_instance = pyjs__class_instance('CellFormatter');
	var cls_definition = new Object();
	cls_definition.__md5__ = '32d2f0d0d0e0015afb7ed681fd595e2c';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(outer) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			outer = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof outer != 'undefined') {
				if (pyjslib.get_pyjs_classtype(outer) == 'Dict') {
					kwargs = outer;
					outer = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}

		self.outer = outer;
		pyjs_kwargs_call(pyjamas.ui.CellFormatter.Applier, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self', 'outer']);
	cls_definition.addStyleName = pyjs__bind_method(cls_instance, 'addStyleName', function(row, column, styleName) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			styleName = arguments[3];
		}

		self.outer.prepareCell(row, column);
		self.outer.setStyleName(self.getElement(row, column), styleName, true);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'styleName']);
	cls_definition.getElement = pyjs__bind_method(cls_instance, 'getElement', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

		self.outer.checkCellBounds(row, column);
		return pyjamas.ui.CellFormatter.DOM.getChild(self.outer.rowFormatter.getRow((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row), column);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.getStyleName = pyjs__bind_method(cls_instance, 'getStyleName', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

		return pyjamas.ui.CellFormatter.DOM.getAttribute(self.getElement(row, column), String('className'));
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.isVisible = pyjs__bind_method(cls_instance, 'isVisible', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var element;
		element = self.getElement(row, column);
		return self.outer.isVisible(element);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.removeStyleName = pyjs__bind_method(cls_instance, 'removeStyleName', function(row, column, styleName) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			styleName = arguments[3];
		}

		self.outer.checkCellBounds(row, column);
		self.outer.setStyleName(self.getElement(row, column), styleName, false);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'styleName']);
	cls_definition.setAlignment = pyjs__bind_method(cls_instance, 'setAlignment', function(row, column, hAlign, vAlign) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			hAlign = arguments[3];
			vAlign = arguments[4];
		}

		self.setHorizontalAlignment(row, column, hAlign);
		self.setVerticalAlignment(row, column, vAlign);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'hAlign', 'vAlign']);
	cls_definition.setHeight = pyjs__bind_method(cls_instance, 'setHeight', function(row, column, height) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			height = arguments[3];
		}
		var element;
		self.outer.prepareCell(row, column);
		element = self.getCellElement((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row, column);
		pyjamas.ui.CellFormatter.DOM.setStyleAttribute(element, String('height'), height);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'height']);
	cls_definition.setHorizontalAlignment = pyjs__bind_method(cls_instance, 'setHorizontalAlignment', function(row, column, align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			align = arguments[3];
		}
		var element;
		self.outer.prepareCell(row, column);
		element = self.getCellElement((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row, column);
		pyjamas.ui.CellFormatter.DOM.setAttribute(element, String('align'), align);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'align']);
	cls_definition.setStyleName = pyjs__bind_method(cls_instance, 'setStyleName', function(row, column, styleName) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			styleName = arguments[3];
		}

		self.outer.prepareCell(row, column);
		self.setAttr(row, column, String('className'), styleName);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'styleName']);
	cls_definition.setVerticalAlignment = pyjs__bind_method(cls_instance, 'setVerticalAlignment', function(row, column, align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			align = arguments[3];
		}

		self.outer.prepareCell(row, column);
		pyjamas.ui.CellFormatter.DOM.setStyleAttribute(self.getCellElement((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row, column), String('verticalAlign'), align);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'align']);
	cls_definition.setVisible = pyjs__bind_method(cls_instance, 'setVisible', function(row, column, visible) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			visible = arguments[3];
		}
		var element;
		element = self.ensureElement(row, column);
		self.outer.setVisible(element, visible);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'visible']);
	cls_definition.setWidth = pyjs__bind_method(cls_instance, 'setWidth', function(row, column, width) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			width = arguments[3];
		}

		self.outer.prepareCell(row, column);
		pyjamas.ui.CellFormatter.DOM.setStyleAttribute(self.getCellElement((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row, column), String('width'), width);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'width']);
	cls_definition.setWordWrap = pyjs__bind_method(cls_instance, 'setWordWrap', function(row, column, wrap) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			wrap = arguments[3];
		}
		var wrap_str;
		self.outer.prepareCell(row, column);
		if (pyjslib.bool(wrap)) {
			wrap_str = String('');
		}
		else {
			wrap_str = String('nowrap');
		}
		pyjamas.ui.CellFormatter.DOM.setStyleAttribute(self.getElement(row, column), String('whiteSpace'), wrap_str);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'wrap']);
	cls_definition.getCellElement = pyjs__bind_method(cls_instance, 'getCellElement', function(table, row, col) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			table = arguments[1];
			row = arguments[2];
			col = arguments[3];
		}
		var cols,item,length;
		length = (typeof table.rows.length == 'function' && table.rows.__is_instance__?pyjslib.getattr(table.rows, 'length'):table.rows.length);
		if (pyjslib.bool((pyjslib.cmp(row, length) != -1))) {
			return null;
		}
		cols = (typeof table.rows.item(row).cells == 'function' && table.rows.item(row).__is_instance__?pyjslib.getattr(table.rows.item(row), 'cells'):table.rows.item(row).cells);
		length = (typeof cols.length == 'function' && cols.__is_instance__?pyjslib.getattr(cols, 'length'):cols.length);
		if (pyjslib.bool((pyjslib.cmp(col, length) != -1))) {
			return null;
		}
		item = cols.item(col);
		return item;
	}
	, 1, [null,null,'self', 'table', 'row', 'col']);
	cls_definition.getRawElement = pyjs__bind_method(cls_instance, 'getRawElement', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

		return self.getCellElement((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row, column);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.ensureElement = pyjs__bind_method(cls_instance, 'ensureElement', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

		self.outer.prepareCell(row, column);
		return pyjamas.ui.CellFormatter.DOM.getChild(self.outer.rowFormatter.ensureElement(row), column);
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.getStyleAttr = pyjs__bind_method(cls_instance, 'getStyleAttr', function(row, column, attr) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			attr = arguments[3];
		}
		var elem;
		elem = self.getElement(row, column);
		return pyjamas.ui.CellFormatter.DOM.getStyleAttribute(elem, attr);
	}
	, 1, [null,null,'self', 'row', 'column', 'attr']);
	cls_definition.setStyleAttr = pyjs__bind_method(cls_instance, 'setStyleAttr', function(row, column, attrName, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			attrName = arguments[3];
			value = arguments[4];
		}
		var elem;
		elem = self.getElement(row, column);
		pyjamas.ui.CellFormatter.DOM.setStyleAttribute(elem, attrName, value);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'attrName', 'value']);
	cls_definition.getAttr = pyjs__bind_method(cls_instance, 'getAttr', function(row, column, attr) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			attr = arguments[3];
		}
		var elem;
		elem = self.getElement(row, column);
		return pyjamas.ui.CellFormatter.DOM.getAttribute(elem, attr);
	}
	, 1, [null,null,'self', 'row', 'column', 'attr']);
	cls_definition.setAttr = pyjs__bind_method(cls_instance, 'setAttr', function(row, column, attrName, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			attrName = arguments[3];
			value = arguments[4];
		}
		var elem;
		elem = self.getElement(row, column);
		pyjamas.ui.CellFormatter.DOM.setAttribute(elem, attrName, value);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'attrName', 'value']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.CellFormatter.Applier));
})();
return this;
}; /* end pyjamas.ui.CellFormatter */
$pyjs.modules_hash['pyjamas.ui.CellFormatter'] = $pyjs.loaded_modules['pyjamas.ui.CellFormatter'];


 /* end module: pyjamas.ui.CellFormatter */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Applier', 'pyjamas.ui']
*/
