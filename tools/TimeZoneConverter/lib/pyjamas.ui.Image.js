/* start module: pyjamas.ui.Image */
pyjamas.ui.Image = $pyjs.loaded_modules["pyjamas.ui.Image"] = function (__mod_name__) {
if(pyjamas.ui.Image.__was_initialized__) return pyjamas.ui.Image;
pyjamas.ui.Image.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Image';
var __name__ = pyjamas.ui.Image.__name__ = __mod_name__;
var Image = pyjamas.ui.Image;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Image');
pyjamas.ui.Image.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Widget.Widget', 'pyjamas.ui.pyjamas.ui.Widget', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Widget'], 'pyjamas.ui.Widget.Widget', 'pyjamas.ui.Image');
pyjamas.ui.Image.Widget = $pyjs.__modules__.pyjamas.ui.Widget.Widget;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.Image');
pyjamas.ui.Image.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.MouseListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.MouseListener', 'pyjamas.ui'], 'pyjamas.ui.MouseListener', 'pyjamas.ui.Image');
pyjamas.ui.Image.MouseListener = $pyjs.__modules__.pyjamas.ui.MouseListener;
pyjamas.ui.Image.prefetchImages = new pyjslib.Dict([]);
pyjamas.ui.Image.Image = (function(){
	var cls_instance = pyjs__class_instance('Image');
	var cls_definition = new Object();
	cls_definition.__md5__ = '09548406bdbe2060632d1827cbed81da';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(url) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			url = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof url != 'undefined') {
				if (pyjslib.get_pyjs_classtype(url) == 'Dict') {
					kwargs = url;
					url = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}
		if (typeof url == 'undefined') url=String('');

		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-Image'));
		}
		if (pyjslib.bool(url)) {
			kwargs.__setitem__(String('Url'), url);
		}
		self.setElement(pyjamas.ui.Image.DOM.createImg());
		self.clickListeners = new pyjslib.List([]);
		self.loadListeners = new pyjslib.List([]);
		self.mouseListeners = new pyjslib.List([]);
		self.sinkEvents((((typeof pyjamas.ui.Image.Event.ONCLICK == 'function' && pyjamas.ui.Image.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Image.Event, 'ONCLICK'):pyjamas.ui.Image.Event.ONCLICK) | (typeof pyjamas.ui.Image.Event.MOUSEEVENTS == 'function' && pyjamas.ui.Image.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Image.Event, 'MOUSEEVENTS'):pyjamas.ui.Image.Event.MOUSEEVENTS) | (typeof pyjamas.ui.Image.Event.ONLOAD == 'function' && pyjamas.ui.Image.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Image.Event, 'ONLOAD'):pyjamas.ui.Image.Event.ONLOAD) | (typeof pyjamas.ui.Image.Event.ONERROR == 'function' && pyjamas.ui.Image.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.Image.Event, 'ONERROR'):pyjamas.ui.Image.Event.ONERROR))));
		pyjs_kwargs_call(pyjamas.ui.Image.Widget, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self', 'url']);
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
	cls_definition.addLoadListener = pyjs__bind_method(cls_instance, 'addLoadListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.loadListeners.append(listener);
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
	cls_definition.getUrl = pyjs__bind_method(cls_instance, 'getUrl', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.Image.DOM.getAttribute(self.getElement(), String('src'));
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
		type = pyjamas.ui.Image.DOM.eventGetType(event);
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
			pyjamas.ui.Image.MouseListener.fireMouseEvent((typeof self.mouseListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'mouseListeners'):self.mouseListeners), self, event);
		}
		else if (pyjslib.bool(pyjslib.eq(type, String('load')))) {
			var __listener = self.loadListeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					listener.onLoad(self);
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
		}
		else if (pyjslib.bool(pyjslib.eq(type, String('error')))) {
			var __listener = self.loadListeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					listener.onError(self);
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
	cls_definition.prefetch = pyjs__bind_method(cls_instance, 'prefetch', function(url) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			url = arguments[1];
		}
		var img;
		img = pyjamas.ui.Image.DOM.createImg();
		pyjamas.ui.Image.DOM.setAttribute(img, String('src'), url);
		pyjamas.ui.Image.prefetchImages.__setitem__(url, img);
		return null;
	}
	, 1, [null,null,'self', 'url']);
	cls_definition.setUrl = pyjs__bind_method(cls_instance, 'setUrl', function(url) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			url = arguments[1];
		}

		pyjamas.ui.Image.DOM.setAttribute(self.getElement(), String('src'), url);
		return null;
	}
	, 1, [null,null,'self', 'url']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Image.Widget));
})();
return this;
}; /* end pyjamas.ui.Image */
$pyjs.modules_hash['pyjamas.ui.Image'] = $pyjs.loaded_modules['pyjamas.ui.Image'];


 /* end module: pyjamas.ui.Image */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Widget.Widget', 'pyjamas.ui', 'pyjamas.ui.Widget', 'pyjamas.ui.Event', 'pyjamas.ui.MouseListener']
*/
