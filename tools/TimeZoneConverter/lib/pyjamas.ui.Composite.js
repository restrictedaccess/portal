/* start module: pyjamas.ui.Composite */
pyjamas.ui.Composite = $pyjs.loaded_modules["pyjamas.ui.Composite"] = function (__mod_name__) {
if(pyjamas.ui.Composite.__was_initialized__) return pyjamas.ui.Composite;
pyjamas.ui.Composite.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Composite';
var __name__ = pyjamas.ui.Composite.__name__ = __mod_name__;
var Composite = pyjamas.ui.Composite;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Composite');
pyjamas.ui.Composite.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Widget.Widget', 'pyjamas.ui.pyjamas.ui.Widget', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Widget'], 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Composite');
pyjamas.ui.Composite.Widget = $pyjs.__modules__.pyjamas.ui.Widget.Widget;
pyjamas.ui.Composite.Composite = (function(){
	var cls_instance = pyjs__class_instance('Composite');
	var cls_definition = new Object();
	cls_definition.__md5__ = '96ee54547f229c058c438b8dfaf0ff10';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			widget = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof widget != 'undefined') {
				if (pyjslib.get_pyjs_classtype(widget) == 'Dict') {
					kwargs = widget;
					widget = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}
		if (typeof widget == 'undefined') widget=null;

		self.widget = null;
		self.attached = null;
		if (pyjslib.bool(widget)) {
			self.initWidget(widget);
		}
		pyjs_kwargs_call(pyjamas.ui.Composite.Widget, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self', 'widget']);
	cls_definition.initWidget = pyjs__bind_method(cls_instance, 'initWidget', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(((typeof self.widget == 'function' && self.__is_instance__?pyjslib.getattr(self, 'widget'):self.widget) !== null))) {
			return null;
		}
		widget.removeFromParent();
		self.setElement(widget.getElement());
		self.widget = widget;
		widget.setParent(self);
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.isAttached = pyjs__bind_method(cls_instance, 'isAttached', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((typeof self.widget == 'function' && self.__is_instance__?pyjslib.getattr(self, 'widget'):self.widget))) {
			return self.widget.isAttached();
		}
		return false;
	}
	, 1, [null,null,'self']);
	cls_definition.onAttach = pyjs__bind_method(cls_instance, 'onAttach', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.widget.onAttach();
		pyjamas.ui.Composite.DOM.setEventListener(self.getElement(), self);
		self.onLoad();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onDetach = pyjs__bind_method(cls_instance, 'onDetach', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.widget.onDetach();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.setWidget = pyjs__bind_method(cls_instance, 'setWidget', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		self.initWidget(widget);
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}

		self.widget.onBrowserEvent(event);
		return null;
	}
	, 1, [null,null,'self', 'event']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Composite.Widget));
})();
return this;
}; /* end pyjamas.ui.Composite */
$pyjs.modules_hash['pyjamas.ui.Composite'] = $pyjs.loaded_modules['pyjamas.ui.Composite'];


 /* end module: pyjamas.ui.Composite */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui', 'pyjamas.ui.Widget']
*/
