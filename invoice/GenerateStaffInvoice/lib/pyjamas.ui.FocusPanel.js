/* start module: pyjamas.ui.FocusPanel */
pyjamas.ui.FocusPanel = $pyjs.loaded_modules["pyjamas.ui.FocusPanel"] = function (__mod_name__) {
if(pyjamas.ui.FocusPanel.__was_initialized__) return pyjamas.ui.FocusPanel;
pyjamas.ui.FocusPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.FocusPanel';
var __name__ = pyjamas.ui.FocusPanel.__name__ = __mod_name__;
var FocusPanel = pyjamas.ui.FocusPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.FocusPanel');
pyjamas.ui.FocusPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.pyjamas.ui.SimplePanel', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.SimplePanel'], 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.FocusPanel');
pyjamas.ui.FocusPanel.SimplePanel = $pyjs.__modules__.pyjamas.ui.SimplePanel.SimplePanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Focus', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Focus', 'pyjamas.ui'], 'pyjamas.ui.Focus', 'pyjamas.ui.FocusPanel');
pyjamas.ui.FocusPanel.Focus = $pyjs.__modules__.pyjamas.ui.Focus;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.FocusPanel');
pyjamas.ui.FocusPanel.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FocusListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.FocusListener', 'pyjamas.ui'], 'pyjamas.ui.FocusListener', 'pyjamas.ui.FocusPanel');
pyjamas.ui.FocusPanel.FocusListener = $pyjs.__modules__.pyjamas.ui.FocusListener;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.MouseListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.MouseListener', 'pyjamas.ui'], 'pyjamas.ui.MouseListener', 'pyjamas.ui.FocusPanel');
pyjamas.ui.FocusPanel.MouseListener = $pyjs.__modules__.pyjamas.ui.MouseListener;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.KeyboardListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.FocusPanel');
pyjamas.ui.FocusPanel.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjamas.ui.FocusPanel.FocusPanel = (function(){
	var cls_instance = pyjs__class_instance('FocusPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '8144a78e5af4c84fce83951588a37cff';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(child) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			child = arguments[1];
		}
		if (typeof child == 'undefined') child=null;

		self.clickListeners = new pyjslib.List([]);
		self.focusListeners = new pyjslib.List([]);
		self.keyboardListeners = new pyjslib.List([]);
		self.mouseListeners = new pyjslib.List([]);
		pyjamas.ui.FocusPanel.SimplePanel.__init__(self, pyjamas.ui.FocusPanel.Focus.createFocusable());
		self.sinkEvents((((typeof pyjamas.ui.FocusPanel.Event.FOCUSEVENTS == 'function' && pyjamas.ui.FocusPanel.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.FocusPanel.Event, 'FOCUSEVENTS'):pyjamas.ui.FocusPanel.Event.FOCUSEVENTS) | (typeof pyjamas.ui.FocusPanel.Event.KEYEVENTS == 'function' && pyjamas.ui.FocusPanel.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.FocusPanel.Event, 'KEYEVENTS'):pyjamas.ui.FocusPanel.Event.KEYEVENTS) | (typeof pyjamas.ui.FocusPanel.Event.ONCLICK == 'function' && pyjamas.ui.FocusPanel.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.FocusPanel.Event, 'ONCLICK'):pyjamas.ui.FocusPanel.Event.ONCLICK) | (typeof pyjamas.ui.FocusPanel.Event.MOUSEEVENTS == 'function' && pyjamas.ui.FocusPanel.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.FocusPanel.Event, 'MOUSEEVENTS'):pyjamas.ui.FocusPanel.Event.MOUSEEVENTS))));
		if (pyjslib.bool(child)) {
			self.setWidget(child);
		}
		return null;
	}
	, 1, [null,null,'self', 'child']);
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
	cls_definition.addMouseListener = pyjs__bind_method(cls_instance, 'addMouseListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.mouseListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.getTabIndex = pyjs__bind_method(cls_instance, 'getTabIndex', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.FocusPanel.Focus.getTabIndex(self.getElement());
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
		type = pyjamas.ui.FocusPanel.DOM.eventGetType(event);
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
		else if (pyjslib.bool((pyjslib.eq(type, String('mousedown'))) || (pyjslib.eq(type, String('mouseup'))) || (pyjslib.eq(type, String('mousemove'))) || (pyjslib.eq(type, String('mouseover'))) || (pyjslib.eq(type, String('mouseout'))))) {
			pyjamas.ui.FocusPanel.MouseListener.fireMouseEvent((typeof self.mouseListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'mouseListeners'):self.mouseListeners), self, event);
		}
		else if (pyjslib.bool((pyjslib.eq(type, String('blur'))) || (pyjslib.eq(type, String('focus'))))) {
			pyjamas.ui.FocusPanel.FocusListener.fireFocusEvent((typeof self.focusListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'focusListeners'):self.focusListeners), self, event);
		}
		else if (pyjslib.bool((pyjslib.eq(type, String('keydown'))) || (pyjslib.eq(type, String('keypress'))) || (pyjslib.eq(type, String('keyup'))))) {
			pyjamas.ui.FocusPanel.KeyboardListener.fireKeyboardEvent((typeof self.keyboardListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keyboardListeners'):self.keyboardListeners), self, event);
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
	cls_definition.removeMouseListener = pyjs__bind_method(cls_instance, 'removeMouseListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.mouseListeners.remove(listener);
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

		pyjamas.ui.FocusPanel.Focus.setAccessKey(self.getElement(), key);
		return null;
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.setFocus = pyjs__bind_method(cls_instance, 'setFocus', function(focused) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			focused = arguments[1];
		}

		if (pyjslib.bool(focused)) {
			pyjamas.ui.FocusPanel.Focus.focus(self.getElement());
		}
		else {
			pyjamas.ui.FocusPanel.Focus.blur(self.getElement());
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

		pyjamas.ui.FocusPanel.Focus.setTabIndex(self.getElement(), index);
		return null;
	}
	, 1, [null,null,'self', 'index']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.FocusPanel.SimplePanel));
})();
return this;
}; /* end pyjamas.ui.FocusPanel */
$pyjs.modules_hash['pyjamas.ui.FocusPanel'] = $pyjs.loaded_modules['pyjamas.ui.FocusPanel'];


 /* end module: pyjamas.ui.FocusPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui', 'pyjamas.ui.SimplePanel', 'pyjamas.ui.Focus', 'pyjamas.ui.Event', 'pyjamas.ui.FocusListener', 'pyjamas.ui.MouseListener', 'pyjamas.ui.KeyboardListener']
*/
