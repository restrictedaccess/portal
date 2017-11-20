/* start module: pyjamas.ui.ButtonBase */
pyjamas.ui.ButtonBase = $pyjs.loaded_modules["pyjamas.ui.ButtonBase"] = function (__mod_name__) {
if(pyjamas.ui.ButtonBase.__was_initialized__) return pyjamas.ui.ButtonBase;
pyjamas.ui.ButtonBase.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.ButtonBase';
var __name__ = pyjamas.ui.ButtonBase.__name__ = __mod_name__;
var ButtonBase = pyjamas.ui.ButtonBase;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.ButtonBase');
pyjamas.ui.ButtonBase.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.pyjamas.ui.FocusWidget', 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.FocusWidget'], 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.ButtonBase');
pyjamas.ui.ButtonBase.FocusWidget = $pyjs.__modules__.pyjamas.ui.FocusWidget.FocusWidget;
pyjamas.ui.ButtonBase.ButtonBase = (function(){
	var cls_instance = pyjs__class_instance('ButtonBase');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f951fc32a47c4da19b548786a86af478';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(element) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			element = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof element != 'undefined') {
				if (pyjslib.get_pyjs_classtype(element) == 'Dict') {
					kwargs = element;
					element = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}

		pyjs_kwargs_call(pyjamas.ui.ButtonBase.FocusWidget, '__init__', null, kwargs, [{}, self, element]);
		return null;
	}
	, 1, [null,'kwargs','self', 'element']);
	cls_definition.getHTML = pyjs__bind_method(cls_instance, 'getHTML', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ButtonBase.DOM.getInnerHTML(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.getText = pyjs__bind_method(cls_instance, 'getText', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ButtonBase.DOM.getInnerText(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.setHTML = pyjs__bind_method(cls_instance, 'setHTML', function(html) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			html = arguments[1];
		}

		pyjamas.ui.ButtonBase.DOM.setInnerHTML(self.getElement(), html);
		return null;
	}
	, 1, [null,null,'self', 'html']);
	cls_definition.setText = pyjs__bind_method(cls_instance, 'setText', function(text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
		}

		pyjamas.ui.ButtonBase.DOM.setInnerText(self.getElement(), text);
		return null;
	}
	, 1, [null,null,'self', 'text']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.ButtonBase.FocusWidget));
})();
return this;
}; /* end pyjamas.ui.ButtonBase */
$pyjs.modules_hash['pyjamas.ui.ButtonBase'] = $pyjs.loaded_modules['pyjamas.ui.ButtonBase'];


 /* end module: pyjamas.ui.ButtonBase */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui', 'pyjamas.ui.FocusWidget']
*/
