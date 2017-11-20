/* start module: pyjamas.ui.VerticalPanel */
pyjamas.ui.VerticalPanel = $pyjs.loaded_modules["pyjamas.ui.VerticalPanel"] = function (__mod_name__) {
if(pyjamas.ui.VerticalPanel.__was_initialized__) return pyjamas.ui.VerticalPanel;
pyjamas.ui.VerticalPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.VerticalPanel';
var __name__ = pyjamas.ui.VerticalPanel.__name__ = __mod_name__;
var VerticalPanel = pyjamas.ui.VerticalPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.VerticalPanel');
pyjamas.ui.VerticalPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui.pyjamas.ui.CellPanel', 'pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui.CellPanel'], 'pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui.VerticalPanel');
pyjamas.ui.VerticalPanel.CellPanel = $pyjs.__modules__.pyjamas.ui.CellPanel.CellPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.VerticalPanel');
pyjamas.ui.VerticalPanel.HasHorizontalAlignment = $pyjs.__modules__.pyjamas.ui.HasHorizontalAlignment;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui.VerticalPanel');
pyjamas.ui.VerticalPanel.HasVerticalAlignment = $pyjs.__modules__.pyjamas.ui.HasVerticalAlignment;
pyjamas.ui.VerticalPanel.VerticalPanel = (function(){
	var cls_instance = pyjs__class_instance('VerticalPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '334b45491289015b8fb7e6046aec14b2';
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
		self.horzAlign = (typeof pyjamas.ui.VerticalPanel.HasHorizontalAlignment.ALIGN_LEFT == 'function' && pyjamas.ui.VerticalPanel.HasHorizontalAlignment.__is_instance__?pyjslib.getattr(pyjamas.ui.VerticalPanel.HasHorizontalAlignment, 'ALIGN_LEFT'):pyjamas.ui.VerticalPanel.HasHorizontalAlignment.ALIGN_LEFT);
		self.vertAlign = (typeof pyjamas.ui.VerticalPanel.HasVerticalAlignment.ALIGN_TOP == 'function' && pyjamas.ui.VerticalPanel.HasVerticalAlignment.__is_instance__?pyjslib.getattr(pyjamas.ui.VerticalPanel.HasVerticalAlignment, 'ALIGN_TOP'):pyjamas.ui.VerticalPanel.HasVerticalAlignment.ALIGN_TOP);
		pyjs_kwargs_call(pyjamas.ui.VerticalPanel.CellPanel, '__init__', null, kwargs, [{}, self]);
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
	cls_definition.setWidget = pyjs__bind_method(cls_instance, 'setWidget', function(index, widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
			widget = arguments[2];
		}
		var existing;
		existing = self.getWidget(index);
		if (pyjslib.bool(existing)) {
			self.remove(existing);
		}
		self.insert(widget, index);
		return null;
	}
	, 1, [null,null,'self', 'index', 'widget']);
	cls_definition.insert = pyjs__bind_method(cls_instance, 'insert', function(widget, beforeIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			beforeIndex = arguments[2];
		}
		var td,tr;
		widget.removeFromParent();
		tr = pyjamas.ui.VerticalPanel.DOM.createTR();
		td = pyjamas.ui.VerticalPanel.DOM.createTD();
		pyjamas.ui.VerticalPanel.DOM.insertChild(self.getBody(), tr, beforeIndex);
		pyjamas.ui.VerticalPanel.DOM.appendChild(tr, td);
		pyjamas.ui.VerticalPanel.CellPanel.insert(self, widget, td, beforeIndex);
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
		var td,tr;
		if (pyjslib.bool(pyjslib.isinstance(widget, pyjslib.int_))) {
			widget = self.getWidget(widget);
		}
		if (pyjslib.bool(!pyjslib.eq(widget.getParent(), self))) {
			return false;
		}
		td = pyjamas.ui.VerticalPanel.DOM.getParent(widget.getElement());
		tr = pyjamas.ui.VerticalPanel.DOM.getParent(td);
		pyjamas.ui.VerticalPanel.DOM.removeChild(self.getBody(), tr);
		pyjamas.ui.VerticalPanel.CellPanel.remove(self, widget);
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
	                            new Array(pyjamas.ui.VerticalPanel.CellPanel));
})();
return this;
}; /* end pyjamas.ui.VerticalPanel */
$pyjs.modules_hash['pyjamas.ui.VerticalPanel'] = $pyjs.loaded_modules['pyjamas.ui.VerticalPanel'];


 /* end module: pyjamas.ui.VerticalPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.CellPanel.CellPanel', 'pyjamas.ui', 'pyjamas.ui.CellPanel', 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.HasVerticalAlignment']
*/
