/* start module: pyjamas.ui.Hyperlink */
pyjamas.ui.Hyperlink = $pyjs.loaded_modules["pyjamas.ui.Hyperlink"] = function (__mod_name__) {
if(pyjamas.ui.Hyperlink.__was_initialized__) return pyjamas.ui.Hyperlink;
pyjamas.ui.Hyperlink.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Hyperlink';
var __name__ = pyjamas.ui.Hyperlink.__name__ = __mod_name__;
var Hyperlink = pyjamas.ui.Hyperlink;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Hyperlink');
pyjamas.ui.Hyperlink.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.History', 'pyjamas.ui.pyjamas', 'pyjamas.History', 'pyjamas'], 'pyjamas.History', 'pyjamas.ui.Hyperlink');
pyjamas.ui.Hyperlink.History = $pyjs.__modules__.pyjamas.History;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Widget.Widget', 'pyjamas.ui.pyjamas.ui.Widget', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Widget'], 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Hyperlink');
pyjamas.ui.Hyperlink.Widget = $pyjs.__modules__.pyjamas.ui.Widget.Widget;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.Hyperlink');
pyjamas.ui.Hyperlink.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjamas.ui.Hyperlink.Hyperlink = (function(){
	var cls_instance = pyjs__class_instance('Hyperlink');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f3d9f0d811de8fc72fd6acfe36248986';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(text, asHTML, targetHistoryToken) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			text = arguments[1];
			asHTML = arguments[2];
			targetHistoryToken = arguments[3];
			var kwargs = arguments.length >= 5 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof targetHistoryToken != 'undefined') {
				if (pyjslib.get_pyjs_classtype(targetHistoryToken) == 'Dict') {
					kwargs = targetHistoryToken;
					targetHistoryToken = arguments[4];
				}
			} else 			if (typeof asHTML != 'undefined') {
				if (pyjslib.get_pyjs_classtype(asHTML) == 'Dict') {
					kwargs = asHTML;
					asHTML = arguments[4];
				}
			} else 			if (typeof text != 'undefined') {
				if (pyjslib.get_pyjs_classtype(text) == 'Dict') {
					kwargs = text;
					text = arguments[4];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[4];
				}
			} else {
			}
		}
		if (typeof text == 'undefined') text=String('');
		if (typeof asHTML == 'undefined') asHTML=false;
		if (typeof targetHistoryToken == 'undefined') targetHistoryToken=String('');

		self.clickListeners = new pyjslib.List([]);
		self.targetHistoryToken = String('');
		self.setElement(pyjamas.ui.Hyperlink.DOM.createDiv());
		self.anchorElem = pyjamas.ui.Hyperlink.DOM.createAnchor();
		pyjamas.ui.Hyperlink.DOM.appendChild(self.getElement(), (typeof self.anchorElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'anchorElem'):self.anchorElem));
		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-Hyperlink'));
		}
		if (pyjslib.bool(text)) {
			if (pyjslib.bool(asHTML)) {
				kwargs.__setitem__(String('HTML'), text);
			}
			else {
				kwargs.__setitem__(String('Text'), text);
			}
		}
		if (pyjslib.bool(targetHistoryToken)) {
			kwargs.__setitem__(String('TargetHistoryToken'), targetHistoryToken);
		}
		pyjs_kwargs_call(pyjamas.ui.Hyperlink.Widget, '__init__', null, kwargs, [{}, self]);
		self.sinkEvents((typeof pyjamas.ui.Hyperlink.Event.ONCLICK == 'function' && pyjamas.ui.Hyperlink.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Hyperlink.Event, 'ONCLICK'):pyjamas.ui.Hyperlink.Event.ONCLICK));
		return null;
	}
	, 1, [null,'kwargs','self', 'text', 'asHTML', 'targetHistoryToken']);
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
	cls_definition.getHTML = pyjs__bind_method(cls_instance, 'getHTML', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.Hyperlink.DOM.getInnerHTML((typeof self.anchorElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'anchorElem'):self.anchorElem));
	}
	, 1, [null,null,'self']);
	cls_definition.getTargetHistoryToken = pyjs__bind_method(cls_instance, 'getTargetHistoryToken', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.targetHistoryToken == 'function' && self.__is_instance__?pyjslib.getattr(self, 'targetHistoryToken'):self.targetHistoryToken);
	}
	, 1, [null,null,'self']);
	cls_definition.getText = pyjs__bind_method(cls_instance, 'getText', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.Hyperlink.DOM.getInnerText((typeof self.anchorElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'anchorElem'):self.anchorElem));
	}
	, 1, [null,null,'self']);
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var listener;
		if (pyjslib.bool(pyjslib.eq(pyjamas.ui.Hyperlink.DOM.eventGetType(event), String('click')))) {
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
			pyjamas.ui.Hyperlink.History.newItem((typeof self.targetHistoryToken == 'function' && self.__is_instance__?pyjslib.getattr(self, 'targetHistoryToken'):self.targetHistoryToken));
			pyjamas.ui.Hyperlink.DOM.eventPreventDefault(event);
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
	cls_definition.setHTML = pyjs__bind_method(cls_instance, 'setHTML', function(html) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			html = arguments[1];
		}

		pyjamas.ui.Hyperlink.DOM.setInnerHTML((typeof self.anchorElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'anchorElem'):self.anchorElem), html);
		return null;
	}
	, 1, [null,null,'self', 'html']);
	cls_definition.setTargetHistoryToken = pyjs__bind_method(cls_instance, 'setTargetHistoryToken', function(targetHistoryToken) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			targetHistoryToken = arguments[1];
		}

		self.targetHistoryToken = targetHistoryToken;
		pyjamas.ui.Hyperlink.DOM.setAttribute((typeof self.anchorElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'anchorElem'):self.anchorElem), String('href'),  ( String('#') + targetHistoryToken ) );
		return null;
	}
	, 1, [null,null,'self', 'targetHistoryToken']);
	cls_definition.setText = pyjs__bind_method(cls_instance, 'setText', function(text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
		}

		pyjamas.ui.Hyperlink.DOM.setInnerText((typeof self.anchorElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'anchorElem'):self.anchorElem), text);
		return null;
	}
	, 1, [null,null,'self', 'text']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Hyperlink.Widget));
})();
return this;
}; /* end pyjamas.ui.Hyperlink */
$pyjs.modules_hash['pyjamas.ui.Hyperlink'] = $pyjs.loaded_modules['pyjamas.ui.Hyperlink'];


 /* end module: pyjamas.ui.Hyperlink */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.History', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui', 'pyjamas.ui.Widget', 'pyjamas.ui.Event']
*/
