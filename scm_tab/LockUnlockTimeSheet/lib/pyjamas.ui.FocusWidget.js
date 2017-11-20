/* start module: pyjamas.ui.FocusWidget */
pyjamas.ui.FocusWidget = $pyjs.loaded_modules["pyjamas.ui.FocusWidget"] = function (__mod_name__) {
if(pyjamas.ui.FocusWidget.__was_initialized__) return pyjamas.ui.FocusWidget;
pyjamas.ui.FocusWidget.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.FocusWidget';
var __name__ = pyjamas.ui.FocusWidget.__name__ = __mod_name__;
var FocusWidget = pyjamas.ui.FocusWidget;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.FocusWidget');
pyjamas.ui.FocusWidget.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Widget.Widget', 'pyjamas.ui.pyjamas.ui.Widget', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Widget'], 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.FocusWidget');
pyjamas.ui.FocusWidget.Widget = $pyjs.__modules__.pyjamas.ui.Widget.Widget;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Focus', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Focus', 'pyjamas.ui'], 'pyjamas.ui.Focus', 'pyjamas.ui.FocusWidget');
pyjamas.ui.FocusWidget.Focus = $pyjs.__modules__.pyjamas.ui.Focus;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.FocusWidget');
pyjamas.ui.FocusWidget.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FocusListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.FocusListener', 'pyjamas.ui'], 'pyjamas.ui.FocusListener', 'pyjamas.ui.FocusWidget');
pyjamas.ui.FocusWidget.FocusListener = $pyjs.__modules__.pyjamas.ui.FocusListener;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.KeyboardListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.FocusWidget');
pyjamas.ui.FocusWidget.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjamas.ui.FocusWidget.FocusWidget = (function(){
	var cls_instance = pyjs__class_instance('FocusWidget');
	var cls_definition = new Object();
	cls_definition.__md5__ = '58af1403d17845718b5c671fb6a7ea3f';
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

		self.setElement(element);
		pyjs_kwargs_call(pyjamas.ui.FocusWidget.Widget, '__init__', null, kwargs, [{}, self]);
		self.clickListeners = new pyjslib.List([]);
		self.focusListeners = new pyjslib.List([]);
		self.keyboardListeners = new pyjslib.List([]);
		self.sinkEvents((((typeof pyjamas.ui.FocusWidget.Event.ONCLICK == 'function' && pyjamas.ui.FocusWidget.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.FocusWidget.Event, 'ONCLICK'):pyjamas.ui.FocusWidget.Event.ONCLICK) | (typeof pyjamas.ui.FocusWidget.Event.FOCUSEVENTS == 'function' && pyjamas.ui.FocusWidget.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.FocusWidget.Event, 'FOCUSEVENTS'):pyjamas.ui.FocusWidget.Event.FOCUSEVENTS) | (typeof pyjamas.ui.FocusWidget.Event.KEYEVENTS == 'function' && pyjamas.ui.FocusWidget.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.FocusWidget.Event, 'KEYEVENTS'):pyjamas.ui.FocusWidget.Event.KEYEVENTS))));
		return null;
	}
	, 1, [null,'kwargs','self', 'element']);
	cls_definition.addClickListener = pyjs__bind_method(cls_instance, 'addClickListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.clickListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.addFocusListener = pyjs__bind_method(cls_instance, 'addFocusListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.focusListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.addKeyboardListener = pyjs__bind_method(cls_instance, 'addKeyboardListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.keyboardListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.getTabIndex = pyjs__bind_method(cls_instance, 'getTabIndex', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.FocusWidget.Focus.getTabIndex(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.isEnabled = pyjs__bind_method(cls_instance, 'isEnabled', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var err,pyjs_try_err;
		try {
			return !(pyjamas.ui.FocusWidget.DOM.getBooleanAttribute(self.getElement(), String('disabled')));
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjamas.ui.FocusWidget, try_lineno: 45};
			if (pyjs_try_err_name == pyjslib.TypeError.__name__) {
				$pyjs.__last_exception__.except_lineno = 47;
				err = pyjs_try_err;
				return true;
			} else if (pyjs_try_err_name == pyjslib.AttributeError.__name__) {
				$pyjs.__last_exception__.except_lineno = 49;
				err = pyjs_try_err;
				return true;
			} else { throw pyjs_try_err; }
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var listener,type;
		type = pyjamas.ui.FocusWidget.DOM.eventGetType(event);
		if (pyjslib.bool(pyjslib.eq(type, String('click')))) {
			var __listener = self.clickListeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					if (pyjslib.bool(pyjslib.hasattr(listener, String('onClick')))) {
						listener.onClick(self);
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
		else if (pyjslib.bool((pyjslib.eq(type, String('blur'))) || (pyjslib.eq(type, String('focus'))))) {
			pyjamas.ui.FocusWidget.FocusListener.fireFocusEvent((typeof self.focusListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'focusListeners'):self.focusListeners), self, event);
		}
		else if (pyjslib.bool((pyjslib.eq(type, String('keydown'))) || (pyjslib.eq(type, String('keypress'))) || (pyjslib.eq(type, String('keyup'))))) {
			pyjamas.ui.FocusWidget.KeyboardListener.fireKeyboardEvent((typeof self.keyboardListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keyboardListeners'):self.keyboardListeners), self, event);
		}
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.removeClickListener = pyjs__bind_method(cls_instance, 'removeClickListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.clickListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.removeFocusListener = pyjs__bind_method(cls_instance, 'removeFocusListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.focusListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.removeKeyboardListener = pyjs__bind_method(cls_instance, 'removeKeyboardListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.keyboardListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.setAccessKey = pyjs__bind_method(cls_instance, 'setAccessKey', function(key) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
		}

		pyjamas.ui.FocusWidget.DOM.setAttribute(self.getElement(), String('accessKey'), pyjslib.str(key));
		return null;
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.setEnabled = pyjs__bind_method(cls_instance, 'setEnabled', function(enabled) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			enabled = arguments[1];
		}

		pyjamas.ui.FocusWidget.DOM.setBooleanAttribute(self.getElement(), String('disabled'), !(enabled));
		return null;
	}
	, 1, [null,null,'self', 'enabled']);
	cls_definition.setFocus = pyjs__bind_method(cls_instance, 'setFocus', function(focused) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			focused = arguments[1];
		}

		if (pyjslib.bool(focused)) {
			pyjamas.ui.FocusWidget.Focus.focus(self.getElement());
		}
		else {
			pyjamas.ui.FocusWidget.Focus.blur(self.getElement());
		}
		return null;
	}
	, 1, [null,null,'self', 'focused']);
	cls_definition.setTabIndex = pyjs__bind_method(cls_instance, 'setTabIndex', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		pyjamas.ui.FocusWidget.Focus.setTabIndex(self.getElement(), index);
		return null;
	}
	, 1, [null,null,'self', 'index']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.FocusWidget.Widget));
})();
return this;
}; /* end pyjamas.ui.FocusWidget */
$pyjs.modules_hash['pyjamas.ui.FocusWidget'] = $pyjs.loaded_modules['pyjamas.ui.FocusWidget'];


 /* end module: pyjamas.ui.FocusWidget */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui', 'pyjamas.ui.Widget', 'pyjamas.ui.Focus', 'pyjamas.ui.Event', 'pyjamas.ui.FocusListener', 'pyjamas.ui.KeyboardListener']
*/
