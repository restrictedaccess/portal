/* start module: pyjamas.ui.PopupPanel */
pyjamas.ui.PopupPanel = $pyjs.loaded_modules["pyjamas.ui.PopupPanel"] = function (__mod_name__) {
if(pyjamas.ui.PopupPanel.__was_initialized__) return pyjamas.ui.PopupPanel;
pyjamas.ui.PopupPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.PopupPanel';
var __name__ = pyjamas.ui.PopupPanel.__name__ = __mod_name__;
var PopupPanel = pyjamas.ui.PopupPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.PopupPanel');
pyjamas.ui.PopupPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.pyjamas.ui.SimplePanel', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.SimplePanel'], 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.PopupPanel');
pyjamas.ui.PopupPanel.SimplePanel = $pyjs.__modules__.pyjamas.ui.SimplePanel.SimplePanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.pyjamas.ui.RootPanel', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.PopupPanel');
pyjamas.ui.PopupPanel.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.MouseListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.MouseListener', 'pyjamas.ui'], 'pyjamas.ui.MouseListener', 'pyjamas.ui.PopupPanel');
pyjamas.ui.PopupPanel.MouseListener = $pyjs.__modules__.pyjamas.ui.MouseListener;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.KeyboardListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.PopupPanel');
pyjamas.ui.PopupPanel.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjamas.ui.PopupPanel.PopupPanel = (function(){
	var cls_instance = pyjs__class_instance('PopupPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '482cc81b5f8ca6210a6476f7a6997941';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(autoHide, modal, rootpanel) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			autoHide = arguments[1];
			modal = arguments[2];
			rootpanel = arguments[3];
			var kwargs = arguments.length >= 5 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof rootpanel != 'undefined') {
				if (pyjslib.get_pyjs_classtype(rootpanel) == 'Dict') {
					kwargs = rootpanel;
					rootpanel = arguments[4];
				}
			} else 			if (typeof modal != 'undefined') {
				if (pyjslib.get_pyjs_classtype(modal) == 'Dict') {
					kwargs = modal;
					modal = arguments[4];
				}
			} else 			if (typeof autoHide != 'undefined') {
				if (pyjslib.get_pyjs_classtype(autoHide) == 'Dict') {
					kwargs = autoHide;
					autoHide = arguments[4];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[4];
				}
			} else {
			}
		}
		if (typeof autoHide == 'undefined') autoHide=false;
		if (typeof modal == 'undefined') modal=true;
		if (typeof rootpanel == 'undefined') rootpanel=null;
		var element;
		self.popupListeners = new pyjslib.List([]);
		self.showing = false;
		self.autoHide = autoHide;
		self.modal = modal;
		if (pyjslib.bool((rootpanel === null))) {
			rootpanel = pyjamas.ui.PopupPanel.RootPanel();
		}
		self.rootpanel = rootpanel;
		element = self.createElement();
		pyjamas.ui.PopupPanel.DOM.setStyleAttribute(element, String('position'), String('absolute'));
		pyjs_kwargs_call(pyjamas.ui.PopupPanel.SimplePanel, '__init__', null, kwargs, [{}, self, element]);
		return null;
	}
	, 1, [null,'kwargs','self', 'autoHide', 'modal', 'rootpanel']);
	cls_definition.addPopupListener = pyjs__bind_method(cls_instance, 'addPopupListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.popupListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.getPopupLeft = pyjs__bind_method(cls_instance, 'getPopupLeft', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.PopupPanel.DOM.getIntAttribute(self.getElement(), String('offsetLeft'));
	}
	, 1, [null,null,'self']);
	cls_definition.getPopupTop = pyjs__bind_method(cls_instance, 'getPopupTop', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.PopupPanel.DOM.getIntAttribute(self.getElement(), String('offsetTop'));
	}
	, 1, [null,null,'self']);
	cls_definition.createElement = pyjs__bind_method(cls_instance, 'createElement', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.PopupPanel.DOM.createDiv();
	}
	, 1, [null,null,'self']);
	cls_definition.hide = pyjs__bind_method(cls_instance, 'hide', function(autoClosed) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			autoClosed = arguments[1];
		}
		if (typeof autoClosed == 'undefined') autoClosed=false;
		var listener;
		if (pyjslib.bool(!((typeof self.showing == 'function' && self.__is_instance__?pyjslib.getattr(self, 'showing'):self.showing)))) {
			return null;
		}
		self.showing = false;
		pyjamas.ui.PopupPanel.DOM.removeEventPreview(self);
		self.rootpanel.remove(self);
		self.onHideImpl(self.getElement());
		var __listener = self.popupListeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				if (pyjslib.bool(pyjslib.hasattr(listener, String('onPopupClosed')))) {
					listener.onPopupClosed(self, autoClosed);
				}
				else {
					listener(self, autoClosed);
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'autoClosed']);
	cls_definition.isModal = pyjs__bind_method(cls_instance, 'isModal', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.modal == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modal'):self.modal);
	}
	, 1, [null,null,'self']);
	cls_definition._event_targets_popup = pyjs__bind_method(cls_instance, '_event_targets_popup', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var target;
		target = pyjamas.ui.PopupPanel.DOM.eventGetTarget(event);
		return (target) && (pyjamas.ui.PopupPanel.DOM.isOrHasChild(self.getElement(), target));
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onEventPreview = pyjs__bind_method(cls_instance, 'onEventPreview', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var type;
		type = pyjamas.ui.PopupPanel.DOM.eventGetType(event);
		if (pyjslib.bool(pyjslib.eq(type, String('keydown')))) {
			return (self.onKeyDownPreview(pyjamas.ui.PopupPanel.DOM.eventGetKeyCode(event), pyjamas.ui.PopupPanel.KeyboardListener.getKeyboardModifiers(event))) && ((!((typeof self.modal == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modal'):self.modal))) || (self._event_targets_popup(event)));
		}
		else if (pyjslib.bool(pyjslib.eq(type, String('keyup')))) {
			return (self.onKeyUpPreview(pyjamas.ui.PopupPanel.DOM.eventGetKeyCode(event), pyjamas.ui.PopupPanel.KeyboardListener.getKeyboardModifiers(event))) && ((!((typeof self.modal == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modal'):self.modal))) || (self._event_targets_popup(event)));
		}
		else if (pyjslib.bool(pyjslib.eq(type, String('keypress')))) {
			return (self.onKeyPressPreview(pyjamas.ui.PopupPanel.DOM.eventGetKeyCode(event), pyjamas.ui.PopupPanel.KeyboardListener.getKeyboardModifiers(event))) && ((!((typeof self.modal == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modal'):self.modal))) || (self._event_targets_popup(event)));
		}
		else if (pyjslib.bool((pyjslib.eq(type, String('mousedown'))) || (pyjslib.eq(type, String('blur'))))) {
			if (pyjslib.bool((pyjamas.ui.PopupPanel.DOM.getCaptureElement() !== null))) {
				return true;
			}
			if (pyjslib.bool(((typeof self.autoHide == 'function' && self.__is_instance__?pyjslib.getattr(self, 'autoHide'):self.autoHide)) && (!(self._event_targets_popup(event))))) {
				self.hide(true);
				return true;
			}
		}
		else if (pyjslib.bool((pyjslib.eq(type, String('mouseup'))) || (pyjslib.eq(type, String('click'))) || (pyjslib.eq(type, String('mousemove'))) || (pyjslib.eq(type, String('dblclick'))))) {
			if (pyjslib.bool((pyjamas.ui.PopupPanel.DOM.getCaptureElement() !== null))) {
				return true;
			}
		}
		return (!((typeof self.modal == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modal'):self.modal))) || (self._event_targets_popup(event));
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onKeyDownPreview = pyjs__bind_method(cls_instance, 'onKeyDownPreview', function(key, modifiers) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
			modifiers = arguments[2];
		}

		return true;
	}
	, 1, [null,null,'self', 'key', 'modifiers']);
	cls_definition.onKeyPressPreview = pyjs__bind_method(cls_instance, 'onKeyPressPreview', function(key, modifiers) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
			modifiers = arguments[2];
		}

		return true;
	}
	, 1, [null,null,'self', 'key', 'modifiers']);
	cls_definition.onKeyUpPreview = pyjs__bind_method(cls_instance, 'onKeyUpPreview', function(key, modifiers) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
			modifiers = arguments[2];
		}

		return true;
	}
	, 1, [null,null,'self', 'key', 'modifiers']);
	cls_definition.onHideImpl = pyjs__bind_method(cls_instance, 'onHideImpl', function(popup) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			popup = arguments[1];
		}


        var frame = popup.__frame;
        frame.parentElement.removeChild(frame);
        popup.__frame = null;
        frame.__popup = null;
        
	}
	, 1, [null,null,'self', 'popup']);
	cls_definition.onShowImpl = pyjs__bind_method(cls_instance, 'onShowImpl', function(popup) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			popup = arguments[1];
		}


        var frame = $doc.createElement('iframe');
        frame.scrolling = 'no';
        frame.frameBorder = 0;
        frame.style.position = 'absolute';
        
        popup.__frame = frame;
        frame.__popup = popup;
        frame.style.setExpression('left', 'this.__popup.offsetLeft');
        frame.style.setExpression('top', 'this.__popup.offsetTop');
        frame.style.setExpression('width', 'this.__popup.offsetWidth');
        frame.style.setExpression('height', 'this.__popup.offsetHeight');
        popup.parentElement.insertBefore(frame, popup);
        
	}
	, 1, [null,null,'self', 'popup']);
	cls_definition.removePopupListener = pyjs__bind_method(cls_instance, 'removePopupListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.popupListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.setPopupPosition = pyjs__bind_method(cls_instance, 'setPopupPosition', function(left, top) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			left = arguments[1];
			top = arguments[2];
		}
		var element;
		if (pyjslib.bool((pyjslib.cmp(left, 0) == -1))) {
			left = 0;
		}
		if (pyjslib.bool((pyjslib.cmp(top, 0) == -1))) {
			top = 0;
		}
		left -= pyjamas.ui.PopupPanel.DOM.getBodyOffsetLeft();
		top -= pyjamas.ui.PopupPanel.DOM.getBodyOffsetTop();
		element = self.getElement();
		pyjamas.ui.PopupPanel.DOM.setStyleAttribute(element, String('left'), pyjslib.sprintf(String('%dpx'), left));
		pyjamas.ui.PopupPanel.DOM.setStyleAttribute(element, String('top'), pyjslib.sprintf(String('%dpx'), top));
		return null;
	}
	, 1, [null,null,'self', 'left', 'top']);
	cls_definition.show = pyjs__bind_method(cls_instance, 'show', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((typeof self.showing == 'function' && self.__is_instance__?pyjslib.getattr(self, 'showing'):self.showing))) {
			return null;
		}
		self.showing = true;
		pyjamas.ui.PopupPanel.DOM.addEventPreview(self);
		self.rootpanel.add(self);
		self.onShowImpl(self.getElement());
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.PopupPanel.SimplePanel));
})();
return this;
}; /* end pyjamas.ui.PopupPanel */
$pyjs.modules_hash['pyjamas.ui.PopupPanel'] = $pyjs.loaded_modules['pyjamas.ui.PopupPanel'];


 /* end module: pyjamas.ui.PopupPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui', 'pyjamas.ui.SimplePanel', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel', 'pyjamas.ui.MouseListener', 'pyjamas.ui.KeyboardListener']
*/
