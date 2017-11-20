/* start module: pyjamas.ui.ScrollPanel */
pyjamas.ui.ScrollPanel = $pyjs.loaded_modules["pyjamas.ui.ScrollPanel"] = function (__mod_name__) {
if(pyjamas.ui.ScrollPanel.__was_initialized__) return pyjamas.ui.ScrollPanel;
pyjamas.ui.ScrollPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.ScrollPanel';
var __name__ = pyjamas.ui.ScrollPanel.__name__ = __mod_name__;
var ScrollPanel = pyjamas.ui.ScrollPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.ScrollPanel');
pyjamas.ui.ScrollPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.pyjamas.ui.SimplePanel', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.SimplePanel'], 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.ScrollPanel');
pyjamas.ui.ScrollPanel.SimplePanel = $pyjs.__modules__.pyjamas.ui.SimplePanel.SimplePanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.ScrollPanel');
pyjamas.ui.ScrollPanel.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjamas.ui.ScrollPanel.ScrollPanel = (function(){
	var cls_instance = pyjs__class_instance('ScrollPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'c6706b9f049c55bef2111229a2d3e82f';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(child) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			child = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof child != 'undefined') {
				if (pyjslib.get_pyjs_classtype(child) == 'Dict') {
					kwargs = child;
					child = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}
		if (typeof child == 'undefined') child=null;

		self.scrollListeners = new pyjslib.List([]);
		if (pyjslib.bool((child !== null))) {
			kwargs.__setitem__(String('Widget'), child);
		}
		if (pyjslib.bool(!(kwargs.has_key(String('AlwaysShowScrollBars'))))) {
			kwargs.__setitem__(String('AlwaysShowScrollBars'), false);
		}
		pyjs_kwargs_call(pyjamas.ui.ScrollPanel.SimplePanel, '__init__', null, kwargs, [{}, self]);
		self.sinkEvents((typeof pyjamas.ui.ScrollPanel.Event.ONSCROLL == 'function' && pyjamas.ui.ScrollPanel.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.ScrollPanel.Event, 'ONSCROLL'):pyjamas.ui.ScrollPanel.Event.ONSCROLL));
		return null;
	}
	, 1, [null,'kwargs','self', 'child']);
	cls_definition.addScrollListener = pyjs__bind_method(cls_instance, 'addScrollListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.scrollListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.ensureVisible = pyjs__bind_method(cls_instance, 'ensureVisible', function(item) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			item = arguments[1];
		}
		var scroll,element;
		scroll = self.getElement();
		element = item.getElement();
		self.ensureVisibleImpl(scroll, element);
		return null;
	}
	, 1, [null,null,'self', 'item']);
	cls_definition.getScrollPosition = pyjs__bind_method(cls_instance, 'getScrollPosition', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ScrollPanel.DOM.getIntAttribute(self.getElement(), String('scrollTop'));
	}
	, 1, [null,null,'self']);
	cls_definition.getHorizontalScrollPosition = pyjs__bind_method(cls_instance, 'getHorizontalScrollPosition', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ScrollPanel.DOM.getIntAttribute(self.getElement(), String('scrollLeft'));
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
		type = pyjamas.ui.ScrollPanel.DOM.eventGetType(event);
		if (pyjslib.bool(pyjslib.eq(type, String('scroll')))) {
			var __listener = self.scrollListeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					listener.onScroll(self, self.getHorizontalScrollPosition(), self.getScrollPosition());
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
	cls_definition.removeScrollListener = pyjs__bind_method(cls_instance, 'removeScrollListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.scrollListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.setAlwaysShowScrollBars = pyjs__bind_method(cls_instance, 'setAlwaysShowScrollBars', function(alwaysShow) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			alwaysShow = arguments[1];
		}
		var style;
		if (pyjslib.bool(alwaysShow)) {
			style = String('scroll');
		}
		else {
			style = String('auto');
		}
		pyjamas.ui.ScrollPanel.DOM.setStyleAttribute(self.getElement(), String('overflow'), style);
		return null;
	}
	, 1, [null,null,'self', 'alwaysShow']);
	cls_definition.setScrollPosition = pyjs__bind_method(cls_instance, 'setScrollPosition', function(position) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			position = arguments[1];
		}

		pyjamas.ui.ScrollPanel.DOM.setIntAttribute(self.getElement(), String('scrollTop'), position);
		return null;
	}
	, 1, [null,null,'self', 'position']);
	cls_definition.setHorizontalScrollPosition = pyjs__bind_method(cls_instance, 'setHorizontalScrollPosition', function(position) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			position = arguments[1];
		}

		pyjamas.ui.ScrollPanel.DOM.setIntAttribute(self.getElement(), String('scrollLeft'), position);
		return null;
	}
	, 1, [null,null,'self', 'position']);
	cls_definition.ensureVisibleImpl = pyjs__bind_method(cls_instance, 'ensureVisibleImpl', function(scroll, e) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			scroll = arguments[1];
			e = arguments[2];
		}
		var item,realOffset;
		if (pyjslib.bool(!(e))) {
			return null;
		}
		item = e;
		realOffset = 0;
    while (pyjslib.bool((item) && (!pyjslib.eq(item, scroll)))) {
		realOffset += (typeof item.offsetTop == 'function' && item.__is_instance__?pyjslib.getattr(item, 'offsetTop'):item.offsetTop);
		item = (typeof item.offsetParent == 'function' && item.__is_instance__?pyjslib.getattr(item, 'offsetParent'):item.offsetParent);
    }
		scroll.scrollTop =  ( realOffset -  ( (typeof scroll.offsetHeight == 'function' && scroll.__is_instance__?pyjslib.getattr(scroll, 'offsetHeight'):scroll.offsetHeight) / 2 )  ) ;
		return null;
	}
	, 1, [null,null,'self', 'scroll', 'e']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.ScrollPanel.SimplePanel));
})();
return this;
}; /* end pyjamas.ui.ScrollPanel */
$pyjs.modules_hash['pyjamas.ui.ScrollPanel'] = $pyjs.loaded_modules['pyjamas.ui.ScrollPanel'];


 /* end module: pyjamas.ui.ScrollPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui', 'pyjamas.ui.SimplePanel', 'pyjamas.ui.Event']
*/
