/* start module: pyjamas.ui.CaptionPanel */
pyjamas.ui.CaptionPanel = $pyjs.loaded_modules["pyjamas.ui.CaptionPanel"] = function (__mod_name__) {
if(pyjamas.ui.CaptionPanel.__was_initialized__) return pyjamas.ui.CaptionPanel;
pyjamas.ui.CaptionPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.CaptionPanel';
var __name__ = pyjamas.ui.CaptionPanel.__name__ = __mod_name__;
var CaptionPanel = pyjamas.ui.CaptionPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.CaptionPanel');
pyjamas.ui.CaptionPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.pyjamas.ui.SimplePanel', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.SimplePanel'], 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.CaptionPanel');
pyjamas.ui.CaptionPanel.SimplePanel = $pyjs.__modules__.pyjamas.ui.SimplePanel.SimplePanel;
pyjamas.ui.CaptionPanel.CaptionPanel = (function(){
	var cls_instance = pyjs__class_instance('CaptionPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'a65e484a01760d81ebfc6c3c8a64d215';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(caption, widget) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			caption = arguments[1];
			widget = arguments[2];
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof widget != 'undefined') {
				if (pyjslib.get_pyjs_classtype(widget) == 'Dict') {
					kwargs = widget;
					widget = arguments[3];
				}
			} else 			if (typeof caption != 'undefined') {
				if (pyjslib.get_pyjs_classtype(caption) == 'Dict') {
					kwargs = caption;
					caption = arguments[3];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[3];
				}
			} else {
			}
		}
		if (typeof widget == 'undefined') widget=null;
		var element;
		element = pyjamas.ui.CaptionPanel.DOM.createElement(String('fieldset'));
		self.legend = pyjamas.ui.CaptionPanel.DOM.createElement(String('legend'));
		pyjamas.ui.CaptionPanel.DOM.appendChild(element, (typeof self.legend == 'function' && self.__is_instance__?pyjslib.getattr(self, 'legend'):self.legend));
		kwargs.__setitem__(String('Caption'), caption);
		if (pyjslib.bool((widget !== null))) {
			kwargs.__setitem__(String('Widget'), widget);
		}
		pyjs_kwargs_call(pyjamas.ui.CaptionPanel.SimplePanel, '__init__', null, kwargs, [{}, self, element]);
		return null;
	}
	, 1, [null,'kwargs','self', 'caption', 'widget']);
	cls_definition.getCaption = pyjs__bind_method(cls_instance, 'getCaption', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.caption == 'function' && self.__is_instance__?pyjslib.getattr(self, 'caption'):self.caption);
	}
	, 1, [null,null,'self']);
	cls_definition.setCaption = pyjs__bind_method(cls_instance, 'setCaption', function(caption) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			caption = arguments[1];
		}

		self.caption = caption;
		if (pyjslib.bool(((caption !== null)) && (!(pyjslib.eq(caption, String('')))))) {
			pyjamas.ui.CaptionPanel.DOM.setInnerHTML((typeof self.legend == 'function' && self.__is_instance__?pyjslib.getattr(self, 'legend'):self.legend), caption);
			pyjamas.ui.CaptionPanel.DOM.insertChild(self.getElement(), (typeof self.legend == 'function' && self.__is_instance__?pyjslib.getattr(self, 'legend'):self.legend), 0);
		}
		else if (pyjslib.bool((pyjamas.ui.CaptionPanel.DOM.getParent((typeof self.legend == 'function' && self.__is_instance__?pyjslib.getattr(self, 'legend'):self.legend)) !== null))) {
			pyjamas.ui.CaptionPanel.DOM.removeChild(self.getElement(), (typeof self.legend == 'function' && self.__is_instance__?pyjslib.getattr(self, 'legend'):self.legend));
		}
		return null;
	}
	, 1, [null,null,'self', 'caption']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.CaptionPanel.SimplePanel));
})();
return this;
}; /* end pyjamas.ui.CaptionPanel */
$pyjs.modules_hash['pyjamas.ui.CaptionPanel'] = $pyjs.loaded_modules['pyjamas.ui.CaptionPanel'];


 /* end module: pyjamas.ui.CaptionPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui', 'pyjamas.ui.SimplePanel']
*/
