/* start module: pyjamas.ui.HorizontalPanel */
pyjamas.ui.HorizontalPanel = $pyjs.loaded_modules["pyjamas.ui.HorizontalPanel"] = function (__mod_name__) {
if(pyjamas.ui.HorizontalPanel.__was_initialized__) return pyjamas.ui.HorizontalPanel;
pyjamas.ui.HorizontalPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.HorizontalPanel';
var __name__ = pyjamas.ui.HorizontalPanel.__name__ = __mod_name__;
var HorizontalPanel = pyjamas.ui.HorizontalPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.HorizontalPanel');
pyjamas.ui.HorizontalPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui.pyjamas.ui.CellPanel', 'pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui.CellPanel'], 'pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui.HorizontalPanel');
pyjamas.ui.HorizontalPanel.CellPanel = $pyjs.__modules__.pyjamas.ui.CellPanel.CellPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.HorizontalPanel');
pyjamas.ui.HorizontalPanel.HasHorizontalAlignment = $pyjs.__modules__.pyjamas.ui.HasHorizontalAlignment;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui.HorizontalPanel');
pyjamas.ui.HorizontalPanel.HasVerticalAlignment = $pyjs.__modules__.pyjamas.ui.HasVerticalAlignment;
pyjamas.ui.HorizontalPanel.HorizontalPanel = (function(){
	var cls_instance = pyjs__class_instance('HorizontalPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'a44d5afd3c2fd43b4437e1f94670d13a';
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

		if (pyjslib.bool(!(kwargs.has_key(String('Spacing'))))) {
			kwargs.__setitem__(String('Spacing'), 0);
		}
		if (pyjslib.bool(!(kwargs.has_key(String('Padding'))))) {
			kwargs.__setitem__(String('Padding'), 0);
		}
		self.horzAlign = (typeof pyjamas.ui.HorizontalPanel.HasHorizontalAlignment.ALIGN_LEFT == 'function' && pyjamas.ui.HorizontalPanel.HasHorizontalAlignment.__is_instance__?pyjslib.getattr(pyjamas.ui.HorizontalPanel.HasHorizontalAlignment, 'ALIGN_LEFT'):pyjamas.ui.HorizontalPanel.HasHorizontalAlignment.ALIGN_LEFT);
		self.vertAlign = (typeof pyjamas.ui.HorizontalPanel.HasVerticalAlignment.ALIGN_TOP == 'function' && pyjamas.ui.HorizontalPanel.HasVerticalAlignment.__is_instance__?pyjslib.getattr(pyjamas.ui.HorizontalPanel.HasVerticalAlignment, 'ALIGN_TOP'):pyjamas.ui.HorizontalPanel.HasVerticalAlignment.ALIGN_TOP);
		pyjs_kwargs_call(pyjamas.ui.HorizontalPanel.CellPanel, '__init__', null, kwargs, [{}, self]);
		self.tableRow = pyjamas.ui.HorizontalPanel.DOM.createTR();
		pyjamas.ui.HorizontalPanel.DOM.appendChild(self.getBody(), (typeof self.tableRow == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableRow'):self.tableRow));
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.add = pyjs__bind_method(cls_instance, 'add', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		self.insert(widget, self.getWidgetCount());
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.getHorizontalAlignment = pyjs__bind_method(cls_instance, 'getHorizontalAlignment', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.horzAlign == 'function' && self.__is_instance__?pyjslib.getattr(self, 'horzAlign'):self.horzAlign);
	}
	, 1, [null,null,'self']);
	cls_definition.getVerticalAlignment = pyjs__bind_method(cls_instance, 'getVerticalAlignment', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.vertAlign == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vertAlign'):self.vertAlign);
	}
	, 1, [null,null,'self']);
	cls_definition.getWidget = pyjs__bind_method(cls_instance, 'getWidget', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		return (typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children).__getitem__(index);
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.getWidgetCount = pyjs__bind_method(cls_instance, 'getWidgetCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjslib.len((typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children));
	}
	, 1, [null,null,'self']);
	cls_definition.getWidgetIndex = pyjs__bind_method(cls_instance, 'getWidgetIndex', function(child) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			child = arguments[1];
		}

		return self.children.index(child);
	}
	, 1, [null,null,'self', 'child']);
	cls_definition.insert = pyjs__bind_method(cls_instance, 'insert', function(widget, beforeIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			beforeIndex = arguments[2];
		}
		var td;
		widget.removeFromParent();
		td = pyjamas.ui.HorizontalPanel.DOM.createTD();
		pyjamas.ui.HorizontalPanel.DOM.insertChild((typeof self.tableRow == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableRow'):self.tableRow), td, beforeIndex);
		pyjamas.ui.HorizontalPanel.CellPanel.insert(self, widget, td, beforeIndex);
		self.setCellHorizontalAlignment(widget, (typeof self.horzAlign == 'function' && self.__is_instance__?pyjslib.getattr(self, 'horzAlign'):self.horzAlign));
		self.setCellVerticalAlignment(widget, (typeof self.vertAlign == 'function' && self.__is_instance__?pyjslib.getattr(self, 'vertAlign'):self.vertAlign));
		return null;
	}
	, 1, [null,null,'self', 'widget', 'beforeIndex']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}
		var td;
		if (pyjslib.bool(pyjslib.isinstance(widget, pyjslib.int_))) {
			widget = self.getWidget(widget);
		}
		if (pyjslib.bool(!pyjslib.eq(widget.getParent(), self))) {
			return false;
		}
		td = pyjamas.ui.HorizontalPanel.DOM.getParent(widget.getElement());
		pyjamas.ui.HorizontalPanel.DOM.removeChild((typeof self.tableRow == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tableRow'):self.tableRow), td);
		pyjamas.ui.HorizontalPanel.CellPanel.remove(self, widget);
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.setHorizontalAlignment = pyjs__bind_method(cls_instance, 'setHorizontalAlignment', function(align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			align = arguments[1];
		}

		self.horzAlign = align;
		return null;
	}
	, 1, [null,null,'self', 'align']);
	cls_definition.setVerticalAlignment = pyjs__bind_method(cls_instance, 'setVerticalAlignment', function(align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			align = arguments[1];
		}

		self.vertAlign = align;
		return null;
	}
	, 1, [null,null,'self', 'align']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.HorizontalPanel.CellPanel));
})();
return this;
}; /* end pyjamas.ui.HorizontalPanel */
$pyjs.modules_hash['pyjamas.ui.HorizontalPanel'] = $pyjs.loaded_modules['pyjamas.ui.HorizontalPanel'];


 /* end module: pyjamas.ui.HorizontalPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui', 'pyjamas.ui.CellPanel', 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.HasVerticalAlignment']
*/
