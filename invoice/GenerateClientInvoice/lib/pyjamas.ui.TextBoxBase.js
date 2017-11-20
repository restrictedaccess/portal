/* start module: pyjamas.ui.TextBoxBase */
pyjamas.ui.TextBoxBase = $pyjs.loaded_modules["pyjamas.ui.TextBoxBase"] = function (__mod_name__) {
if(pyjamas.ui.TextBoxBase.__was_initialized__) return pyjamas.ui.TextBoxBase;
pyjamas.ui.TextBoxBase.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.TextBoxBase';
var __name__ = pyjamas.ui.TextBoxBase.__name__ = __mod_name__;
var TextBoxBase = pyjamas.ui.TextBoxBase;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.TextBoxBase');
pyjamas.ui.TextBoxBase.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.pyjamas.ui.FocusWidget', 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.FocusWidget'], 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.TextBoxBase');
pyjamas.ui.TextBoxBase.FocusWidget = $pyjs.__modules__.pyjamas.ui.FocusWidget.FocusWidget;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.TextBoxBase');
pyjamas.ui.TextBoxBase.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjamas.ui.TextBoxBase.TextBoxBase = (function(){
	var cls_instance = pyjs__class_instance('TextBoxBase');
	var cls_definition = new Object();
	cls_definition.__md5__ = '95ee594670aa0a7e795194342a907225';
	cls_definition.ALIGN_CENTER = String('center');
	cls_definition.ALIGN_JUSTIFY = String('justify');
	cls_definition.ALIGN_LEFT = String('left');
	cls_definition.ALIGN_RIGHT = String('right');
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

		self.changeListeners = new pyjslib.List([]);
		self.clickListeners = new pyjslib.List([]);
		self.currentEvent = null;
		pyjs_kwargs_call(pyjamas.ui.TextBoxBase.FocusWidget, '__init__', null, kwargs, [{}, self, element]);
		self.sinkEvents((typeof pyjamas.ui.TextBoxBase.Event.ONCHANGE == 'function' && pyjamas.ui.TextBoxBase.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.TextBoxBase.Event, 'ONCHANGE'):pyjamas.ui.TextBoxBase.Event.ONCHANGE));
		return null;
	}
	, 1, [null,'kwargs','self', 'element']);
	cls_definition.addChangeListener = pyjs__bind_method(cls_instance, 'addChangeListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.changeListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
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
	cls_definition.cancelKey = pyjs__bind_method(cls_instance, 'cancelKey', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(((typeof self.currentEvent == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentEvent'):self.currentEvent) !== null))) {
			pyjamas.ui.TextBoxBase.DOM.eventPreventDefault((typeof self.currentEvent == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentEvent'):self.currentEvent));
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getCursorPos = pyjs__bind_method(cls_instance, 'getCursorPos', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var err,pyjs_try_err,element;
		element = self.getElement();
		try {
			return (typeof element.selectionStart == 'function' && element.__is_instance__?pyjslib.getattr(element, 'selectionStart'):element.selectionStart);
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjamas.ui.TextBoxBase, try_lineno: 45};
			{
				$pyjs.__last_exception__.except_lineno = 48;
				err = pyjs_try_err;
				return 0;
			} 		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getName = pyjs__bind_method(cls_instance, 'getName', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.TextBoxBase.DOM.getAttribute(self.getElement(), String('name'));
	}
	, 1, [null,null,'self']);
	cls_definition.getSelectedText = pyjs__bind_method(cls_instance, 'getSelectedText', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var start,length,text;
		start = self.getCursorPos();
		length = self.getSelectionLength();
		text = self.getText();
		return pyjslib.slice(text, start,  ( start + length ) );
	}
	, 1, [null,null,'self']);
	cls_definition.getSelectionLength = pyjs__bind_method(cls_instance, 'getSelectionLength', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var err,pyjs_try_err,element;
		element = self.getElement();
		try {
			return  ( (typeof element.selectionEnd == 'function' && element.__is_instance__?pyjslib.getattr(element, 'selectionEnd'):element.selectionEnd) - (typeof element.selectionStart == 'function' && element.__is_instance__?pyjslib.getattr(element, 'selectionStart'):element.selectionStart) ) ;
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjamas.ui.TextBoxBase, try_lineno: 61};
			{
				$pyjs.__last_exception__.except_lineno = 64;
				err = pyjs_try_err;
				return 0;
			} 		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getText = pyjs__bind_method(cls_instance, 'getText', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.TextBoxBase.DOM.getAttribute(self.getElement(), String('value'));
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
		pyjamas.ui.TextBoxBase.FocusWidget.onBrowserEvent(self, event);
		type = pyjamas.ui.TextBoxBase.DOM.eventGetType(event);
		if (pyjslib.bool(pyjslib.eq(type, String('change')))) {
			var __listener = self.changeListeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					if (pyjslib.bool(pyjslib.hasattr(listener, String('onChange')))) {
						listener.onChange(self);
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
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.removeChangeListener = pyjs__bind_method(cls_instance, 'removeChangeListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.changeListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
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
	cls_definition.selectAll = pyjs__bind_method(cls_instance, 'selectAll', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var length;
		length = pyjslib.len(self.getText());
		if (pyjslib.bool((pyjslib.cmp(length, 0) == 1))) {
			self.setSelectionRange(0, length);
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.setCursorPos = pyjs__bind_method(cls_instance, 'setCursorPos', function(pos) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			pos = arguments[1];
		}

		self.setSelectionRange(pos, 0);
		return null;
	}
	, 1, [null,null,'self', 'pos']);
	cls_definition.setKey = pyjs__bind_method(cls_instance, 'setKey', function(key) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
		}

		if (pyjslib.bool(((typeof self.currentEvent == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentEvent'):self.currentEvent) !== null))) {
			pyjamas.ui.TextBoxBase.DOM.eventSetKeyCode((typeof self.currentEvent == 'function' && self.__is_instance__?pyjslib.getattr(self, 'currentEvent'):self.currentEvent), key);
		}
		return null;
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.setName = pyjs__bind_method(cls_instance, 'setName', function(name) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			name = arguments[1];
		}

		pyjamas.ui.TextBoxBase.DOM.setAttribute(self.getElement(), String('name'), name);
		return null;
	}
	, 1, [null,null,'self', 'name']);
	cls_definition.setSelectionRange = pyjs__bind_method(cls_instance, 'setSelectionRange', function(pos, length) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			pos = arguments[1];
			length = arguments[2];
		}
		var element;
		if (pyjslib.bool((pyjslib.cmp(length, 0) == -1))) {
			console.error( ( String('Length must be a positive integer. Length: ') + length ) );
		}
		if (pyjslib.bool(((pyjslib.cmp(pos, 0) == -1)) || ((pyjslib.cmp( ( length + pos ) , pyjslib.len(self.getText())) == 1)))) {
			console.error( (  (  (  (  ( String('From Index: ') + pos )  + String('  To Index: ') )  +  ( pos + length )  )  + String('  Text Length: ') )  + pyjslib.len(self.getText()) ) );
		}
		element = self.getElement();
		element.setSelectionRange(pos,  ( pos + length ) );
		return null;
	}
	, 1, [null,null,'self', 'pos', 'length']);
	cls_definition.setText = pyjs__bind_method(cls_instance, 'setText', function(text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
		}

		pyjamas.ui.TextBoxBase.DOM.setAttribute(self.getElement(), String('value'), pyjslib.str(text));
		return null;
	}
	, 1, [null,null,'self', 'text']);
	cls_definition.setTextAlignment = pyjs__bind_method(cls_instance, 'setTextAlignment', function(align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			align = arguments[1];
		}

		pyjamas.ui.TextBoxBase.DOM.setStyleAttribute(self.getElement(), String('textAlign'), align);
		return null;
	}
	, 1, [null,null,'self', 'align']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.TextBoxBase.FocusWidget));
})();
return this;
}; /* end pyjamas.ui.TextBoxBase */
$pyjs.modules_hash['pyjamas.ui.TextBoxBase'] = $pyjs.loaded_modules['pyjamas.ui.TextBoxBase'];


 /* end module: pyjamas.ui.TextBoxBase */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui', 'pyjamas.ui.FocusWidget', 'pyjamas.ui.Event']
*/
