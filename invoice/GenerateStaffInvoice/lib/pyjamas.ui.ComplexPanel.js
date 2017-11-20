/* start module: pyjamas.ui.ComplexPanel */
pyjamas.ui.ComplexPanel = $pyjs.loaded_modules["pyjamas.ui.ComplexPanel"] = function (__mod_name__) {
if(pyjamas.ui.ComplexPanel.__was_initialized__) return pyjamas.ui.ComplexPanel;
pyjamas.ui.ComplexPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.ComplexPanel';
var __name__ = pyjamas.ui.ComplexPanel.__name__ = __mod_name__;
var ComplexPanel = pyjamas.ui.ComplexPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.ComplexPanel');
pyjamas.ui.ComplexPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Panel.Panel', 'pyjamas.ui.pyjamas.ui.Panel', 'pyjamas.ui.Panel.Panel', 'pyjamas.ui.Panel'], 'pyjamas.ui.Panel.Panel', 'pyjamas.ui.ComplexPanel');
pyjamas.ui.ComplexPanel.Panel = $pyjs.__modules__.pyjamas.ui.Panel.Panel;
pyjamas.ui.ComplexPanel.ComplexPanel = (function(){
	var cls_instance = pyjs__class_instance('ComplexPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '5674f5e05ca2413cc88afc22b7edefc9';
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

		pyjs_kwargs_call(pyjamas.ui.ComplexPanel.Panel, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.add = pyjs__bind_method(cls_instance, 'add', function(widget, container) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			container = arguments[2];
		}

		self.insert(widget, container, pyjslib.len((typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children)));
		return null;
	}
	, 1, [null,null,'self', 'widget', 'container']);
	cls_definition.getChildren = pyjs__bind_method(cls_instance, 'getChildren', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children);
	}
	, 1, [null,null,'self']);
	cls_definition.insert = pyjs__bind_method(cls_instance, 'insert', function(widget, container, beforeIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			container = arguments[2];
			beforeIndex = arguments[3];
		}

		if (pyjslib.bool(pyjslib.eq(widget.getParent(), self))) {
			return null;
		}
		self.adopt(widget, container);
		self.children.insert(beforeIndex, widget);
		return null;
	}
	, 1, [null,null,'self', 'widget', 'container', 'beforeIndex']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(!(typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children).__contains__(widget))) {
			return false;
		}
		self.disown(widget);
		self.children.remove(widget);
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.ComplexPanel.Panel));
})();
return this;
}; /* end pyjamas.ui.ComplexPanel */
$pyjs.modules_hash['pyjamas.ui.ComplexPanel'] = $pyjs.loaded_modules['pyjamas.ui.ComplexPanel'];


 /* end module: pyjamas.ui.ComplexPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Panel.Panel', 'pyjamas.ui', 'pyjamas.ui.Panel']
*/
