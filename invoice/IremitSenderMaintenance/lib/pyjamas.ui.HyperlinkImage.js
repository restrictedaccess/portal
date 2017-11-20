/* start module: pyjamas.ui.HyperlinkImage */
pyjamas.ui.HyperlinkImage = $pyjs.loaded_modules["pyjamas.ui.HyperlinkImage"] = function (__mod_name__) {
if(pyjamas.ui.HyperlinkImage.__was_initialized__) return pyjamas.ui.HyperlinkImage;
pyjamas.ui.HyperlinkImage.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.HyperlinkImage';
var __name__ = pyjamas.ui.HyperlinkImage.__name__ = __mod_name__;
var HyperlinkImage = pyjamas.ui.HyperlinkImage;

pyjslib.__import__(['pyjamas.ui.pyjd', 'pyjd'], 'pyjd', 'pyjamas.ui.HyperlinkImage');
pyjamas.ui.HyperlinkImage.pyjd = $pyjs.__modules__.pyjd;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas.ui.pyjamas.ui.Hyperlink', 'pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas.ui.Hyperlink'], 'pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas.ui.HyperlinkImage');
pyjamas.ui.HyperlinkImage.Hyperlink = $pyjs.__modules__.pyjamas.ui.Hyperlink.Hyperlink;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Image.Image', 'pyjamas.ui.pyjamas.ui.Image', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image'], 'pyjamas.ui.Image.Image', 'pyjamas.ui.HyperlinkImage');
pyjamas.ui.HyperlinkImage.Image = $pyjs.__modules__.pyjamas.ui.Image.Image;
pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.HyperlinkImage');
pyjamas.ui.HyperlinkImage.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.HyperlinkImage');
pyjamas.ui.HyperlinkImage.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.MouseListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.MouseListener', 'pyjamas.ui'], 'pyjamas.ui.MouseListener', 'pyjamas.ui.HyperlinkImage');
pyjamas.ui.HyperlinkImage.MouseListener = $pyjs.__modules__.pyjamas.ui.MouseListener;
pyjamas.ui.HyperlinkImage.HyperlinkImage = (function(){
	var cls_instance = pyjs__class_instance('HyperlinkImage');
	var cls_definition = new Object();
	cls_definition.__md5__ = '77a994a91d01344cccffe3b4d2c44ec1';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(img) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			img = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof img != 'undefined') {
				if (pyjslib.get_pyjs_classtype(img) == 'Dict') {
					kwargs = img;
					img = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}

		self.mouseListeners = new pyjslib.List([]);
		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-HyperlinkImage'));
		}
		pyjs_kwargs_call(pyjamas.ui.HyperlinkImage.Hyperlink, '__init__', null, kwargs, [{}, self]);
		pyjamas.ui.HyperlinkImage.DOM.appendChild(pyjamas.ui.HyperlinkImage.DOM.getFirstChild(self.getElement()), img.getElement());
		img.unsinkEvents((((typeof pyjamas.ui.HyperlinkImage.Event.ONCLICK == 'function' && pyjamas.ui.HyperlinkImage.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.HyperlinkImage.Event, 'ONCLICK'):pyjamas.ui.HyperlinkImage.Event.ONCLICK) | (typeof pyjamas.ui.HyperlinkImage.Event.MOUSEEVENTS == 'function' && pyjamas.ui.HyperlinkImage.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.HyperlinkImage.Event, 'MOUSEEVENTS'):pyjamas.ui.HyperlinkImage.Event.MOUSEEVENTS))));
		self.sinkEvents((((typeof pyjamas.ui.HyperlinkImage.Event.ONCLICK == 'function' && pyjamas.ui.HyperlinkImage.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.HyperlinkImage.Event, 'ONCLICK'):pyjamas.ui.HyperlinkImage.Event.ONCLICK) | (typeof pyjamas.ui.HyperlinkImage.Event.MOUSEEVENTS == 'function' && pyjamas.ui.HyperlinkImage.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.HyperlinkImage.Event, 'MOUSEEVENTS'):pyjamas.ui.HyperlinkImage.Event.MOUSEEVENTS))));
		return null;
	}
	, 1, [null,'kwargs','self', 'img']);
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
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var type;
		type = pyjamas.ui.HyperlinkImage.DOM.eventGetType(event);
		if (pyjslib.bool((pyjslib.eq(type, String('mousedown'))) || (pyjslib.eq(type, String('mouseup'))) || (pyjslib.eq(type, String('mousemove'))) || (pyjslib.eq(type, String('mouseover'))) || (pyjslib.eq(type, String('mouseout'))))) {
			pyjamas.ui.HyperlinkImage.MouseListener.fireMouseEvent((typeof self.mouseListeners == 'function' && self.__is_instance__?pyjslib.getattr(self, 'mouseListeners'):self.mouseListeners), self, event);
			pyjamas.ui.HyperlinkImage.DOM.eventPreventDefault(event);
		}
		else {
			pyjamas.ui.HyperlinkImage.Hyperlink.onBrowserEvent(self, event);
		}
		return null;
	}
	, 1, [null,null,'self', 'event']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.HyperlinkImage.Hyperlink));
})();
return this;
}; /* end pyjamas.ui.HyperlinkImage */
$pyjs.modules_hash['pyjamas.ui.HyperlinkImage'] = $pyjs.loaded_modules['pyjamas.ui.HyperlinkImage'];


 /* end module: pyjamas.ui.HyperlinkImage */


/*
PYJS_DEPS: ['pyjd', 'pyjamas.ui.Hyperlink.Hyperlink', 'pyjamas', 'pyjamas.ui', 'pyjamas.ui.Hyperlink', 'pyjamas.ui.Image.Image', 'pyjamas.ui.Image', 'pyjamas.DOM', 'pyjamas.ui.Event', 'pyjamas.ui.MouseListener']
*/
