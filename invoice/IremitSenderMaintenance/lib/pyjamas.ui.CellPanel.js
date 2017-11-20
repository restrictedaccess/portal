/* start module: pyjamas.ui.CellPanel */
pyjamas.ui.CellPanel = $pyjs.loaded_modules["pyjamas.ui.CellPanel"] = function (__mod_name__) {
if(pyjamas.ui.CellPanel.__was_initialized__) return pyjamas.ui.CellPanel;
pyjamas.ui.CellPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.CellPanel';
var __name__ = pyjamas.ui.CellPanel.__name__ = __mod_name__;
var CellPanel = pyjamas.ui.CellPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.CellPanel');
pyjamas.ui.CellPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.pyjamas.ui.ComplexPanel', 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.ComplexPanel'], 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.CellPanel');
pyjamas.ui.CellPanel.ComplexPanel = $pyjs.__modules__.pyjamas.ui.ComplexPanel.ComplexPanel;
pyjamas.ui.CellPanel.CellPanel = (function(){
	var cls_instance = pyjs__class_instance('CellPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f8fd4249edc593bc63bafa679f239064';
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

		self.table = pyjamas.ui.CellPanel.DOM.createTable();
		self.setElement((typeof self.table == 'function' && self.__is_instance__?pyjslib.getattr(self, 'table'):self.table));
		self.body = pyjamas.ui.CellPanel.DOM.createTBody();
		self.spacing = null;
		self.padding = null;
		pyjamas.ui.CellPanel.DOM.appendChild((typeof self.table == 'function' && self.__is_instance__?pyjslib.getattr(self, 'table'):self.table), (typeof self.body == 'function' && self.__is_instance__?pyjslib.getattr(self, 'body'):self.body));
		pyjs_kwargs_call(pyjamas.ui.CellPanel.ComplexPanel, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.getTable = pyjs__bind_method(cls_instance, 'getTable', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.table == 'function' && self.__is_instance__?pyjslib.getattr(self, 'table'):self.table);
	}
	, 1, [null,null,'self']);
	cls_definition.getBody = pyjs__bind_method(cls_instance, 'getBody', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.body == 'function' && self.__is_instance__?pyjslib.getattr(self, 'body'):self.body);
	}
	, 1, [null,null,'self']);
	cls_definition.getSpacing = pyjs__bind_method(cls_instance, 'getSpacing', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.spacing == 'function' && self.__is_instance__?pyjslib.getattr(self, 'spacing'):self.spacing);
	}
	, 1, [null,null,'self']);
	cls_definition.getPadding = pyjs__bind_method(cls_instance, 'getPadding', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.padding == 'function' && self.__is_instance__?pyjslib.getattr(self, 'padding'):self.padding);
	}
	, 1, [null,null,'self']);
	cls_definition.getWidgetTd = pyjs__bind_method(cls_instance, 'getWidgetTd', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(!pyjslib.eq(widget.getParent(), self))) {
			return null;
		}
		return pyjamas.ui.CellPanel.DOM.getParent(widget.getElement());
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.setBorderWidth = pyjs__bind_method(cls_instance, 'setBorderWidth', function(width) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			width = arguments[1];
		}

		pyjamas.ui.CellPanel.DOM.setAttribute((typeof self.table == 'function' && self.__is_instance__?pyjslib.getattr(self, 'table'):self.table), String('border'), pyjslib.sprintf(String('%d'), width));
		return null;
	}
	, 1, [null,null,'self', 'width']);
	cls_definition.setCellHeight = pyjs__bind_method(cls_instance, 'setCellHeight', function(widget, height) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			height = arguments[2];
		}
		var td;
		td = pyjamas.ui.CellPanel.DOM.getParent(widget.getElement());
		pyjamas.ui.CellPanel.DOM.setAttribute(td, String('height'), height);
		return null;
	}
	, 1, [null,null,'self', 'widget', 'height']);
	cls_definition.setCellHorizontalAlignment = pyjs__bind_method(cls_instance, 'setCellHorizontalAlignment', function(widget, align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			align = arguments[2];
		}
		var td;
		td = self.getWidgetTd(widget);
		if (pyjslib.bool((td !== null))) {
			pyjamas.ui.CellPanel.DOM.setAttribute(td, String('align'), align);
		}
		return null;
	}
	, 1, [null,null,'self', 'widget', 'align']);
	cls_definition.setCellVerticalAlignment = pyjs__bind_method(cls_instance, 'setCellVerticalAlignment', function(widget, align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			align = arguments[2];
		}
		var td;
		td = self.getWidgetTd(widget);
		if (pyjslib.bool((td !== null))) {
			pyjamas.ui.CellPanel.DOM.setStyleAttribute(td, String('verticalAlign'), align);
		}
		return null;
	}
	, 1, [null,null,'self', 'widget', 'align']);
	cls_definition.setCellWidth = pyjs__bind_method(cls_instance, 'setCellWidth', function(widget, width) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			width = arguments[2];
		}
		var td;
		td = pyjamas.ui.CellPanel.DOM.getParent(widget.getElement());
		pyjamas.ui.CellPanel.DOM.setAttribute(td, String('width'), width);
		return null;
	}
	, 1, [null,null,'self', 'widget', 'width']);
	cls_definition.setSpacing = pyjs__bind_method(cls_instance, 'setSpacing', function(spacing) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			spacing = arguments[1];
		}

		self.spacing = spacing;
		pyjamas.ui.CellPanel.DOM.setAttribute((typeof self.table == 'function' && self.__is_instance__?pyjslib.getattr(self, 'table'):self.table), String('cellSpacing'), pyjslib.str(spacing));
		return null;
	}
	, 1, [null,null,'self', 'spacing']);
	cls_definition.setPadding = pyjs__bind_method(cls_instance, 'setPadding', function(padding) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			padding = arguments[1];
		}

		self.padding = padding;
		pyjamas.ui.CellPanel.DOM.setAttribute((typeof self.table == 'function' && self.__is_instance__?pyjslib.getattr(self, 'table'):self.table), String('cellPadding'), pyjslib.str(padding));
		return null;
	}
	, 1, [null,null,'self', 'padding']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.CellPanel.ComplexPanel));
})();
return this;
}; /* end pyjamas.ui.CellPanel */
$pyjs.modules_hash['pyjamas.ui.CellPanel'] = $pyjs.loaded_modules['pyjamas.ui.CellPanel'];


 /* end module: pyjamas.ui.CellPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui', 'pyjamas.ui.ComplexPanel']
*/
