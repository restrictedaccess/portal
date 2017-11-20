/* start module: pyjamas.ui.TextBox */
pyjamas.ui.TextBox = $pyjs.loaded_modules["pyjamas.ui.TextBox"] = function (__mod_name__) {
if(pyjamas.ui.TextBox.__was_initialized__) return pyjamas.ui.TextBox;
pyjamas.ui.TextBox.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.TextBox';
var __name__ = pyjamas.ui.TextBox.__name__ = __mod_name__;
var TextBox = pyjamas.ui.TextBox;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.TextBox');
pyjamas.ui.TextBox.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.pyjamas.ui.TextBoxBase', 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.TextBoxBase'], 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.TextBox');
pyjamas.ui.TextBox.TextBoxBase = $pyjs.__modules__.pyjamas.ui.TextBoxBase.TextBoxBase;
pyjamas.ui.TextBox.TextBox = (function(){
	var cls_instance = pyjs__class_instance('TextBox');
	var cls_definition = new Object();
	cls_definition.__md5__ = '6628e5cf272b76bae957daae9fd5a725';
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

		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-TextBox'));
		}
		pyjs_kwargs_call(pyjamas.ui.TextBox.TextBoxBase, '__init__', null, kwargs, [{}, self, pyjamas.ui.TextBox.DOM.createInputText()]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.getMaxLength = pyjs__bind_method(cls_instance, 'getMaxLength', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.TextBox.DOM.getIntAttribute(self.getElement(), String('maxLength'));
	}
	, 1, [null,null,'self']);
	cls_definition.getVisibleLength = pyjs__bind_method(cls_instance, 'getVisibleLength', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.TextBox.DOM.getIntAttribute(self.getElement(), String('size'));
	}
	, 1, [null,null,'self']);
	cls_definition.setMaxLength = pyjs__bind_method(cls_instance, 'setMaxLength', function(length) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			length = arguments[1];
		}

		pyjamas.ui.TextBox.DOM.setIntAttribute(self.getElement(), String('maxLength'), length);
		return null;
	}
	, 1, [null,null,'self', 'length']);
	cls_definition.setVisibleLength = pyjs__bind_method(cls_instance, 'setVisibleLength', function(length) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			length = arguments[1];
		}

		pyjamas.ui.TextBox.DOM.setIntAttribute(self.getElement(), String('size'), length);
		return null;
	}
	, 1, [null,null,'self', 'length']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.TextBox.TextBoxBase));
})();
return this;
}; /* end pyjamas.ui.TextBox */
$pyjs.modules_hash['pyjamas.ui.TextBox'] = $pyjs.loaded_modules['pyjamas.ui.TextBox'];


 /* end module: pyjamas.ui.TextBox */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui', 'pyjamas.ui.TextBoxBase']
*/
