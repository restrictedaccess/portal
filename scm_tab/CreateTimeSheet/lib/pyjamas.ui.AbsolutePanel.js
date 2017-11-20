/* start module: pyjamas.ui.AbsolutePanel */
pyjamas.ui.AbsolutePanel = $pyjs.loaded_modules["pyjamas.ui.AbsolutePanel"] = function (__mod_name__) {
if(pyjamas.ui.AbsolutePanel.__was_initialized__) return pyjamas.ui.AbsolutePanel;
pyjamas.ui.AbsolutePanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.AbsolutePanel';
var __name__ = pyjamas.ui.AbsolutePanel.__name__ = __mod_name__;
var AbsolutePanel = pyjamas.ui.AbsolutePanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.AbsolutePanel');
pyjamas.ui.AbsolutePanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.pyjamas.ui.ComplexPanel', 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.ComplexPanel'], 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.AbsolutePanel');
pyjamas.ui.AbsolutePanel.ComplexPanel = $pyjs.__modules__.pyjamas.ui.ComplexPanel.ComplexPanel;
pyjamas.ui.AbsolutePanel.AbsolutePanel = (function(){
	var cls_instance = pyjs__class_instance('AbsolutePanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'b39ad9087e118e428381f1e9fa57412b';
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

		self.setElement(pyjamas.ui.AbsolutePanel.DOM.createDiv());
		pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(self.getElement(), String('position'), String('relative'));
		pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(self.getElement(), String('overflow'), String('hidden'));
		pyjs_kwargs_call(pyjamas.ui.AbsolutePanel.ComplexPanel, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.add = pyjs__bind_method(cls_instance, 'add', function(widget, left, top) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			left = arguments[2];
			top = arguments[3];
		}
		if (typeof left == 'undefined') left=null;
		if (typeof top == 'undefined') top=null;

		pyjamas.ui.AbsolutePanel.ComplexPanel.add(self, widget, self.getElement());
		if (pyjslib.bool((left !== null))) {
			self.setWidgetPosition(widget, left, top);
		}
		return null;
	}
	, 1, [null,null,'self', 'widget', 'left', 'top']);
	cls_definition.setWidgetPosition = pyjs__bind_method(cls_instance, 'setWidgetPosition', function(widget, left, top) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			left = arguments[2];
			top = arguments[3];
		}
		var h;
		self.checkWidgetParent(widget);
		h = widget.getElement();
		if (pyjslib.bool((pyjslib.eq(left, -1)) && (pyjslib.eq(top, -1)))) {
			pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(h, String('left'), String(''));
			pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(h, String('top'), String(''));
			pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(h, String('position'), String('static'));
		}
		else {
			pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(h, String('position'), String('absolute'));
			pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(h, String('left'), pyjslib.sprintf(String('%dpx'), left));
			pyjamas.ui.AbsolutePanel.DOM.setStyleAttribute(h, String('top'), pyjslib.sprintf(String('%dpx'), top));
		}
		return null;
	}
	, 1, [null,null,'self', 'widget', 'left', 'top']);
	cls_definition.getWidgetLeft = pyjs__bind_method(cls_instance, 'getWidgetLeft', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		self.checkWidgetParent(widget);
		return pyjamas.ui.AbsolutePanel.DOM.getIntAttribute(widget.getElement(), String('offsetLeft'));
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.getWidgetTop = pyjs__bind_method(cls_instance, 'getWidgetTop', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		self.checkWidgetParent(widget);
		return pyjamas.ui.AbsolutePanel.DOM.getIntAttribute(widget.getElement(), String('offsetTop'));
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.checkWidgetParent = pyjs__bind_method(cls_instance, 'checkWidgetParent', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(!pyjslib.eq(widget.getParent(), self))) {
			console.error(String('Widget must be a child of this panel.'));
		}
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.AbsolutePanel.ComplexPanel));
})();
return this;
}; /* end pyjamas.ui.AbsolutePanel */
$pyjs.modules_hash['pyjamas.ui.AbsolutePanel'] = $pyjs.loaded_modules['pyjamas.ui.AbsolutePanel'];


 /* end module: pyjamas.ui.AbsolutePanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui', 'pyjamas.ui.ComplexPanel']
*/
