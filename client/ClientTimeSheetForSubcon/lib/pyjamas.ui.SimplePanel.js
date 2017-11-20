/* start module: pyjamas.ui.SimplePanel */
pyjamas.ui.SimplePanel = $pyjs.loaded_modules["pyjamas.ui.SimplePanel"] = function (__mod_name__) {
if(pyjamas.ui.SimplePanel.__was_initialized__) return pyjamas.ui.SimplePanel;
pyjamas.ui.SimplePanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.SimplePanel';
var __name__ = pyjamas.ui.SimplePanel.__name__ = __mod_name__;
var SimplePanel = pyjamas.ui.SimplePanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.SimplePanel');
pyjamas.ui.SimplePanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Panel.Panel', 'pyjamas.ui.pyjamas.ui.Panel', 'pyjamas.ui.Panel.Panel', 'pyjamas.ui.Panel'], 'pyjamas.ui.Panel.Panel', 'pyjamas.ui.SimplePanel');
pyjamas.ui.SimplePanel.Panel = $pyjs.__modules__.pyjamas.ui.Panel.Panel;
pyjamas.ui.SimplePanel.SimplePanel = (function(){
	var cls_instance = pyjs__class_instance('SimplePanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '7a0848ea1fb2a7d57a1d675302f8cb78';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(element) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			element = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof element != 'undefined') {
				if (pyjslib.get_pyjs_classtype(element) == 'Dict') {
					kwargs = element;
					element = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}
		if (typeof element == 'undefined') element=null;

		if (pyjslib.bool((element === null))) {
			element = pyjamas.ui.SimplePanel.DOM.createDiv();
		}
		self.setElement(element);
		pyjs_kwargs_call(pyjamas.ui.SimplePanel.Panel, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self', 'element']);
	cls_definition.add = pyjs__bind_method(cls_instance, 'add', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool((self.getWidget() !== null))) {
			console.error(String('SimplePanel can only contain one child widget'));
			return null;
		}
		self.setWidget(widget);
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.getWidget = pyjs__bind_method(cls_instance, 'getWidget', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(pyjslib.len((typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children)))) {
			return (typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children).__getitem__(0);
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(!pyjslib.eq(self.getWidget(), widget))) {
			return false;
		}
		self.disown(widget);
    (typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children).__delitem__(0);
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.getContainerElement = pyjs__bind_method(cls_instance, 'getContainerElement', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.getElement();
	}
	, 1, [null,null,'self']);
	cls_definition.setWidget = pyjs__bind_method(cls_instance, 'setWidget', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(pyjslib.eq(self.getWidget(), widget))) {
			return null;
		}
		if (pyjslib.bool((self.getWidget() !== null))) {
			self.remove(self.getWidget());
		}
		if (pyjslib.bool((widget !== null))) {
			self.adopt(widget, self.getContainerElement());
			self.children.append(widget);
		}
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.SimplePanel.Panel));
})();
return this;
}; /* end pyjamas.ui.SimplePanel */
$pyjs.modules_hash['pyjamas.ui.SimplePanel'] = $pyjs.loaded_modules['pyjamas.ui.SimplePanel'];


 /* end module: pyjamas.ui.SimplePanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Panel.Panel', 'pyjamas.ui', 'pyjamas.ui.Panel']
*/
