/* start module: pyjamas.ui.Widget */
pyjamas.ui.Widget = $pyjs.loaded_modules["pyjamas.ui.Widget"] = function (__mod_name__) {
if(pyjamas.ui.Widget.__was_initialized__) return pyjamas.ui.Widget;
pyjamas.ui.Widget.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Widget';
var __name__ = pyjamas.ui.Widget.__name__ = __mod_name__;
var Widget = pyjamas.ui.Widget;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Widget');
pyjamas.ui.Widget.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.log', 'pyjamas.ui.pyjamas', 'pyjamas.log', 'pyjamas'], 'pyjamas.log', 'pyjamas.ui.Widget');
pyjamas.ui.Widget.log = $pyjs.__modules__.pyjamas.log;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.UIObject.UIObject', 'pyjamas.ui.pyjamas.ui.UIObject', 'pyjamas.ui.UIObject.UIObject', 'pyjamas.ui.UIObject'], 'pyjamas.ui.UIObject.UIObject', 'pyjamas.ui.Widget');
pyjamas.ui.Widget.UIObject = $pyjs.__modules__.pyjamas.ui.UIObject.UIObject;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.Widget');
pyjamas.ui.Widget.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjamas.ui.Widget.Widget = (function(){
	var cls_instance = pyjs__class_instance('Widget');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'eb8a38383d6d19253d4ab38a9a4d2caf';
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

		self.attached = false;
		self.parent = null;
		self.layoutData = null;
		self.contextMenu = null;
		pyjs_kwargs_call(pyjamas.ui.Widget.UIObject, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.getLayoutData = pyjs__bind_method(cls_instance, 'getLayoutData', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.layoutData == 'function' && self.__is_instance__?pyjslib.getattr(self, 'layoutData'):self.layoutData);
	}
	, 1, [null,null,'self']);
	cls_definition.getParent = pyjs__bind_method(cls_instance, 'getParent', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.parent == 'function' && self.__is_instance__?pyjslib.getattr(self, 'parent'):self.parent);
	}
	, 1, [null,null,'self']);
	cls_definition.isAttached = pyjs__bind_method(cls_instance, 'isAttached', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.attached == 'function' && self.__is_instance__?pyjslib.getattr(self, 'attached'):self.attached);
	}
	, 1, [null,null,'self']);
	cls_definition.setContextMenu = pyjs__bind_method(cls_instance, 'setContextMenu', function(menu) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			menu = arguments[1];
		}

		self.contextMenu = menu;
		if (pyjslib.bool(menu)) {
			self.sinkEvents((typeof pyjamas.ui.Widget.Event.ONCONTEXTMENU == 'function' && pyjamas.ui.Widget.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Widget.Event, 'ONCONTEXTMENU'):pyjamas.ui.Widget.Event.ONCONTEXTMENU));
		}
		else {
			self.unsinkEvents((typeof pyjamas.ui.Widget.Event.ONCONTEXTMENU == 'function' && pyjamas.ui.Widget.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Widget.Event, 'ONCONTEXTMENU'):pyjamas.ui.Widget.Event.ONCONTEXTMENU));
		}
		return null;
	}
	, 1, [null,null,'self', 'menu']);
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var type;
		if (pyjslib.bool(((typeof self.contextMenu == 'function' && self.__is_instance__?pyjslib.getattr(self, 'contextMenu'):self.contextMenu) === null))) {
			return true;
		}
		type = pyjamas.ui.Widget.DOM.eventGetType(event);
		if (pyjslib.bool(pyjslib.eq(type, String('contextmenu')))) {
			pyjamas.ui.Widget.DOM.eventCancelBubble(event, true);
			pyjamas.ui.Widget.DOM.eventPreventDefault(event);
			self.contextMenu.onContextMenu(self);
			return false;
		}
		return true;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onLoad = pyjs__bind_method(cls_instance, 'onLoad', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

 		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.doDetachChildren = pyjs__bind_method(cls_instance, 'doDetachChildren', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

 		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.doAttachChildren = pyjs__bind_method(cls_instance, 'doAttachChildren', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

 		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.onAttach = pyjs__bind_method(cls_instance, 'onAttach', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(self.isAttached())) {
			return null;
		}
		self.attached = true;
		pyjamas.ui.Widget.DOM.setEventListener(self.getElement(), self);
		self.doAttachChildren();
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

		if (pyjslib.bool(!(self.isAttached()))) {
			return null;
		}
		self.doDetachChildren();
		self.attached = false;
		pyjamas.ui.Widget.DOM.setEventListener(self.getElement(), null);
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.setLayoutData = pyjs__bind_method(cls_instance, 'setLayoutData', function(layoutData) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			layoutData = arguments[1];
		}

		self.layoutData = layoutData;
		return null;
	}
	, 1, [null,null,'self', 'layoutData']);
	cls_definition.setParent = pyjs__bind_method(cls_instance, 'setParent', function(parent) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			parent = arguments[1];
		}
		var oldparent;
		oldparent = (typeof self.parent == 'function' && self.__is_instance__?pyjslib.getattr(self, 'parent'):self.parent);
		self.parent = parent;
		if (pyjslib.bool((parent === null))) {
			if (pyjslib.bool(((oldparent !== null)) && ((typeof oldparent.attached == 'function' && oldparent.__is_instance__?pyjslib.getattr(oldparent, 'attached'):oldparent.attached)))) {
				self.onDetach();
			}
		}
		else if (pyjslib.bool((typeof parent.attached == 'function' && parent.__is_instance__?pyjslib.getattr(parent, 'attached'):parent.attached))) {
			self.onAttach();
		}
		return null;
	}
	, 1, [null,null,'self', 'parent']);
	cls_definition.removeFromParent = pyjs__bind_method(cls_instance, 'removeFromParent', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(pyjslib.hasattr((typeof self.parent == 'function' && self.__is_instance__?pyjslib.getattr(self, 'parent'):self.parent), String('remove')))) {
			self.parent.remove(self);
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getID = pyjs__bind_method(cls_instance, 'getID', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.Widget.DOM.getAttribute(self.getElement(), String('id'));
	}
	, 1, [null,null,'self']);
	cls_definition.setID = pyjs__bind_method(cls_instance, 'setID', function(id) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			id = arguments[1];
		}

		pyjamas.ui.Widget.DOM.setAttribute(self.getElement(), String('id'), id);
		return null;
	}
	, 1, [null,null,'self', 'id']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Widget.UIObject));
})();
return this;
}; /* end pyjamas.ui.Widget */
$pyjs.modules_hash['pyjamas.ui.Widget'] = $pyjs.loaded_modules['pyjamas.ui.Widget'];


 /* end module: pyjamas.ui.Widget */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.log', 'pyjamas.ui.UIObject.UIObject', 'pyjamas.ui', 'pyjamas.ui.UIObject', 'pyjamas.ui.Event']
*/
