/* start module: pyjamas.ui.Label */
pyjamas.ui.Label = $pyjs.loaded_modules["pyjamas.ui.Label"] = function (__mod_name__) {
if(pyjamas.ui.Label.__was_initialized__) return pyjamas.ui.Label;
pyjamas.ui.Label.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Label';
var __name__ = pyjamas.ui.Label.__name__ = __mod_name__;
var Label = pyjamas.ui.Label;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Label');
pyjamas.ui.Label.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Widget.Widget', 'pyjamas.ui.pyjamas.ui.Widget', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Widget'], 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Label');
pyjamas.ui.Label.Widget = $pyjs.__modules__.pyjamas.ui.Widget.Widget;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.Label');
pyjamas.ui.Label.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.MouseListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.MouseListener', 'pyjamas.ui'], 'pyjamas.ui.MouseListener', 'pyjamas.ui.Label');
pyjamas.ui.Label.MouseListener = $pyjs.__modules__.pyjamas.ui.MouseListener;
pyjamas.ui.Label.Label = (function(){
	var cls_instance = pyjs__class_instance('Label');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'ac8001ab601f3cf31a8614cbddf18d57';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(text, wordWrap) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			text = arguments[1];
			wordWrap = arguments[2];
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof wordWrap != 'undefined') {
				if (pyjslib.get_pyjs_classtype(wordWrap) == 'Dict') {
					kwargs = wordWrap;
					wordWrap = arguments[3];
				}
			} else 			if (typeof text != 'undefined') {
				if (pyjslib.get_pyjs_classtype(text) == 'Dict') {
					kwargs = text;
					text = arguments[3];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[3];
				}
			} else {
			}
		}
		if (typeof text == 'undefined') text=null;
		if (typeof wordWrap == 'undefined') wordWrap=true;

		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-Label'));
		}
		if (pyjslib.bool(text)) {
			kwargs.__setitem__(String('Text'), text);
		}
		kwargs.__setitem__(String('WordWrap'), wordWrap);
		self.setElement(pyjamas.ui.Label.DOM.createDiv());
		self.horzAlign = String('');
		self.clickListeners = new pyjslib.List([]);
		self.mouseListeners = new pyjslib.List([]);
		pyjs_kwargs_call(pyjamas.ui.Label.Widget, '__init__', null, kwargs, [{}, self]);
		self.sinkEvents((((typeof pyjamas.ui.Label.Event.ONCLICK == 'function' && pyjamas.ui.Label.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Label.Event, 'ONCLICK'):pyjamas.ui.Label.Event.ONCLICK) | (typeof pyjamas.ui.Label.Event.MOUSEEVENTS == 'function' && pyjamas.ui.Label.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Label.Event, 'MOUSEEVENTS'):pyjamas.ui.Label.Event.MOUSEEVENTS))));
		return null;
	}
	, 1, [null,'kwargs','self', 'text', 'wordWrap']);
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
	cls_definition.getHorizontalAlignment = pyjs__bind_method(cls_instance, 'getHorizontalAlignment', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.horzAlign == 'function' && self.__is_instance__?pyjslib.getattr(self, 'horzAlign'):self.horzAlign);
	}
	, 1, [null,null,'self']);
	cls_definition.getText = pyjs__bind_method(cls_instance, 'getText', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.Label.DOM.getInnerText(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.getWordWrap = pyjs__bind_method(cls_instance, 'getWordWrap', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return !(pyjslib.eq(pyjamas.ui.Label.DOM.getStyleAttribute(self.getElement(), String('whiteSpace')), String('nowrap')));
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
		type = pyjamas.ui.Label.DOM.eventGetType(event);
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
			pyjamas.ui.Label.MouseListener.fireMouseEvent((typeof self.mouseListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'mouseListeners'):self.mouseListeners), self, event);
		}
		else {
			pyjamas.ui.Label.Widget.onBrowserEvent(self, event);
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
	cls_definition.setHorizontalAlignment = pyjs__bind_method(cls_instance, 'setHorizontalAlignment', function(align) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			align = arguments[1];
		}

		self.horzAlign = align;
		pyjamas.ui.Label.DOM.setStyleAttribute(self.getElement(), String('textAlign'), align);
		return null;
	}
	, 1, [null,null,'self', 'align']);
	cls_definition.setText = pyjs__bind_method(cls_instance, 'setText', function(text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
		}

		pyjamas.ui.Label.DOM.setInnerText(self.getElement(), text);
		return null;
	}
	, 1, [null,null,'self', 'text']);
	cls_definition.setWordWrap = pyjs__bind_method(cls_instance, 'setWordWrap', function(wrap) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			wrap = arguments[1];
		}
		var style;
		if (pyjslib.bool(wrap)) {
			style = String('normal');
		}
		else {
			style = String('nowrap');
		}
		pyjamas.ui.Label.DOM.setStyleAttribute(self.getElement(), String('whiteSpace'), style);
		return null;
	}
	, 1, [null,null,'self', 'wrap']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Label.Widget));
})();
return this;
}; /* end pyjamas.ui.Label */
$pyjs.modules_hash['pyjamas.ui.Label'] = $pyjs.loaded_modules['pyjamas.ui.Label'];


 /* end module: pyjamas.ui.Label */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui', 'pyjamas.ui.Widget', 'pyjamas.ui.Event', 'pyjamas.ui.MouseListener']
*/
