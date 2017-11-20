/* start module: pyjamas.ui.Panel */
pyjamas.ui.Panel = $pyjs.loaded_modules["pyjamas.ui.Panel"] = function (__mod_name__) {
if(pyjamas.ui.Panel.__was_initialized__) return pyjamas.ui.Panel;
pyjamas.ui.Panel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Panel';
var __name__ = pyjamas.ui.Panel.__name__ = __mod_name__;
var Panel = pyjamas.ui.Panel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Panel');
pyjamas.ui.Panel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Widget.Widget', 'pyjamas.ui.pyjamas.ui.Widget', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Widget'], 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Panel');
pyjamas.ui.Panel.Widget = $pyjs.__modules__.pyjamas.ui.Widget.Widget;
pyjamas.ui.Panel.Panel = (function(){
	var cls_instance = pyjs__class_instance('Panel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '93ef64a0f0ab32e3914011ce88595102';
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

		self.children = new pyjslib.List([]);
		pyjs_kwargs_call(pyjamas.ui.Panel.Widget, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.add = pyjs__bind_method(cls_instance, 'add', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		console.error(String('This panel does not support no-arg add()'));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.clear = pyjs__bind_method(cls_instance, 'clear', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var children,child;
		children = new pyjslib.List([]);
		var __child = self.children.__iter__();
		try {
			while (true) {
				var child = __child.next();
				
				children.append(child);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		var __child = children.__iter__();
		try {
			while (true) {
				var child = __child.next();
				
				self.remove(child);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.disown = pyjs__bind_method(cls_instance, 'disown', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}
		var parentElement,element;
		if (pyjslib.bool(!pyjslib.eq(widget.getParent(), self))) {
			console.error(String('widget %o is not a child of this panel %o'), widget, self);
		}
		else {
			element = widget.getElement();
			widget.setParent(null);
			parentElement = pyjamas.ui.Panel.DOM.getParent(element);
			if (pyjslib.bool(parentElement)) {
				pyjamas.ui.Panel.DOM.removeChild(parentElement, element);
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.adopt = pyjs__bind_method(cls_instance, 'adopt', function(widget, container) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			container = arguments[2];
		}

		if (pyjslib.bool(container)) {
			widget.removeFromParent();
			pyjamas.ui.Panel.DOM.appendChild(container, widget.getElement());
		}
		widget.setParent(self);
		return null;
	}
	, 1, [null,null,'self', 'widget', 'container']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

 		return null;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.doAttachChildren = pyjs__bind_method(cls_instance, 'doAttachChildren', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var child;
		var __child = self.__iter__();
		try {
			while (true) {
				var child = __child.next();
				
				child.onAttach();
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
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
		var child;
		var __child = self.__iter__();
		try {
			while (true) {
				var child = __child.next();
				
				child.onDetach();
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.__iter__ = pyjs__bind_method(cls_instance, '__iter__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.children.__iter__();
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Panel.Widget));
})();
return this;
}; /* end pyjamas.ui.Panel */
$pyjs.modules_hash['pyjamas.ui.Panel'] = $pyjs.loaded_modules['pyjamas.ui.Panel'];


 /* end module: pyjamas.ui.Panel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui', 'pyjamas.ui.Widget']
*/
