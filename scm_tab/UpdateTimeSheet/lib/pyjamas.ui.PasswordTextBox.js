/* start module: pyjamas.ui.PasswordTextBox */
pyjamas.ui.PasswordTextBox = $pyjs.loaded_modules["pyjamas.ui.PasswordTextBox"] = function (__mod_name__) {
if(pyjamas.ui.PasswordTextBox.__was_initialized__) return pyjamas.ui.PasswordTextBox;
pyjamas.ui.PasswordTextBox.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.PasswordTextBox';
var __name__ = pyjamas.ui.PasswordTextBox.__name__ = __mod_name__;
var PasswordTextBox = pyjamas.ui.PasswordTextBox;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.PasswordTextBox');
pyjamas.ui.PasswordTextBox.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.pyjamas.ui.TextBoxBase', 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.TextBoxBase'], 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.PasswordTextBox');
pyjamas.ui.PasswordTextBox.TextBoxBase = $pyjs.__modules__.pyjamas.ui.TextBoxBase.TextBoxBase;
pyjamas.ui.PasswordTextBox.PasswordTextBox = (function(){
	var cls_instance = pyjs__class_instance('PasswordTextBox');
	var cls_definition = new Object();
	cls_definition.__md5__ = '8d8fe11b2c5bb5383991b80f782fb042';
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
			kwargs.__setitem__(String('StyleName'), String('gwt-PasswordTextBox'));
		}
		pyjs_kwargs_call(pyjamas.ui.PasswordTextBox.TextBoxBase, '__init__', null, kwargs, [{}, self, pyjamas.ui.PasswordTextBox.DOM.createInputPassword()]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.PasswordTextBox.TextBoxBase));
})();
return this;
}; /* end pyjamas.ui.PasswordTextBox */
$pyjs.modules_hash['pyjamas.ui.PasswordTextBox'] = $pyjs.loaded_modules['pyjamas.ui.PasswordTextBox'];


 /* end module: pyjamas.ui.PasswordTextBox */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui', 'pyjamas.ui.TextBoxBase']
*/
