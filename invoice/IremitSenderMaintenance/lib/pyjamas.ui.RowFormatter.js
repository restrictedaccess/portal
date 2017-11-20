/* start module: pyjamas.ui.RowFormatter */
pyjamas.ui.RowFormatter = $pyjs.loaded_modules["pyjamas.ui.RowFormatter"] = function (__mod_name__) {
if(pyjamas.ui.RowFormatter.__was_initialized__) return pyjamas.ui.RowFormatter;
pyjamas.ui.RowFormatter.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.RowFormatter';
var __name__ = pyjamas.ui.RowFormatter.__name__ = __mod_name__;
var RowFormatter = pyjamas.ui.RowFormatter;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.RowFormatter');
pyjamas.ui.RowFormatter.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Applier', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Applier', 'pyjamas.ui'], 'pyjamas.ui.Applier', 'pyjamas.ui.RowFormatter');
pyjamas.ui.RowFormatter.Applier = $pyjs.__modules__.pyjamas.ui.Applier;
pyjamas.ui.RowFormatter.RowFormatter = (function(){
	var cls_instance = pyjs__class_instance('RowFormatter');
	var cls_definition = new Object();
	cls_definition.__md5__ = '9f6154cea53011ce4b6f2880f97ac973';
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
		pyjs_kwargs_call(pyjamas.ui.RowFormatter.Applier, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self', 'outer']);
	cls_definition.addStyleName = pyjs__bind_method(cls_instance, 'addStyleName', function(row, styleName) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			styleName = arguments[2];
		}

		self.outer.setStyleName(self.ensureElement(row), styleName, true);
		return null;
	}
	, 1, [null,null,'self', 'row', 'styleName']);
	cls_definition.getElement = pyjs__bind_method(cls_instance, 'getElement', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}

		self.outer.checkRowBounds(row);
		return self.getRow((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row);
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.getStyleName = pyjs__bind_method(cls_instance, 'getStyleName', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}

		return pyjamas.ui.RowFormatter.DOM.getAttribute(self.getElement(row), String('className'));
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.isVisible = pyjs__bind_method(cls_instance, 'isVisible', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}
		var element;
		element = self.getElement(row);
		return self.outer.isVisible(element);
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.removeStyleName = pyjs__bind_method(cls_instance, 'removeStyleName', function(row, styleName) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			styleName = arguments[2];
		}

		self.outer.setStyleName(self.getElement(row), styleName, false);
		return null;
	}
	, 1, [null,null,'self', 'row', 'styleName']);
	cls_definition.setStyleName = pyjs__bind_method(cls_instance, 'setStyleName', function(row, styleName) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			styleName = arguments[2];
		}
		var elem;
		elem = self.ensureElement(row);
		pyjamas.ui.RowFormatter.DOM.setAttribute(elem, String('className'), styleName);
		return null;
	}
	, 1, [null,null,'self', 'row', 'styleName']);
	cls_definition.setVerticalAlign = pyjs__bind_method(cls_instance, 'setVerticalAlign', function(row, align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			align = arguments[2];
		}

		pyjamas.ui.RowFormatter.DOM.setStyleAttribute(self.ensureElement(row), String('verticalAlign'), align);
		return null;
	}
	, 1, [null,null,'self', 'row', 'align']);
	cls_definition.setVisible = pyjs__bind_method(cls_instance, 'setVisible', function(row, visible) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			visible = arguments[2];
		}
		var element;
		element = self.ensureElement(row);
		self.outer.setVisible(element, visible);
		return null;
	}
	, 1, [null,null,'self', 'row', 'visible']);
	cls_definition.ensureElement = pyjs__bind_method(cls_instance, 'ensureElement', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}

		self.outer.prepareRow(row);
		return self.getRow((typeof self.outer.bodyElem == 'function' && self.outer.__is_instance__?pyjslib.getattr(self.outer, 'bodyElem'):self.outer.bodyElem), row);
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.getRow = pyjs__bind_method(cls_instance, 'getRow', function(element, row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
			row = arguments[2];
		}

		return element.rows.item(row);
	}
	, 1, [null,null,'self', 'element', 'row']);
	cls_definition.setStyleAttr = pyjs__bind_method(cls_instance, 'setStyleAttr', function(row, attrName, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			attrName = arguments[2];
			value = arguments[3];
		}
		var element;
		element = self.ensureElement(row);
		pyjamas.ui.RowFormatter.DOM.setStyleAttribute(element, attrName, value);
		return null;
	}
	, 1, [null,null,'self', 'row', 'attrName', 'value']);
	cls_definition.setAttr = pyjs__bind_method(cls_instance, 'setAttr', function(row, attrName, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			attrName = arguments[2];
			value = arguments[3];
		}
		var element;
		element = self.ensureElement(row);
		pyjamas.ui.RowFormatter.DOM.setAttribute(element, attrName, value);
		return null;
	}
	, 1, [null,null,'self', 'row', 'attrName', 'value']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.RowFormatter.Applier));
})();
return this;
}; /* end pyjamas.ui.RowFormatter */
$pyjs.modules_hash['pyjamas.ui.RowFormatter'] = $pyjs.loaded_modules['pyjamas.ui.RowFormatter'];


 /* end module: pyjamas.ui.RowFormatter */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Applier', 'pyjamas.ui']
*/
