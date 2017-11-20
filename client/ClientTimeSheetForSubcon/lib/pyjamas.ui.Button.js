/* start module: pyjamas.ui.Button */
pyjamas.ui.Button = $pyjs.loaded_modules["pyjamas.ui.Button"] = function (__mod_name__) {
if(pyjamas.ui.Button.__was_initialized__) return pyjamas.ui.Button;
pyjamas.ui.Button.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Button';
var __name__ = pyjamas.ui.Button.__name__ = __mod_name__;
var Button = pyjamas.ui.Button;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Button');
pyjamas.ui.Button.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui.pyjamas.ui.ButtonBase', 'pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui.ButtonBase'], 'pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui.Button');
pyjamas.ui.Button.ButtonBase = $pyjs.__modules__.pyjamas.ui.ButtonBase.ButtonBase;
pyjamas.ui.Button.Button = (function(){
	var cls_instance = pyjs__class_instance('Button');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'b6aa18a4312507e0468d07df92877f06';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(html, listener) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			html = arguments[1];
			listener = arguments[2];
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof listener != 'undefined') {
				if (pyjslib.get_pyjs_classtype(listener) == 'Dict') {
					kwargs = listener;
					listener = arguments[3];
				}
			} else 			if (typeof html != 'undefined') {
				if (pyjslib.get_pyjs_classtype(html) == 'Dict') {
					kwargs = html;
					html = arguments[3];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[3];
				}
			} else {
			}
		}
		if (typeof html == 'undefined') html=null;
		if (typeof listener == 'undefined') listener=null;
		var element;
		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-Button'));
		}
		if (pyjslib.bool(html)) {
			kwargs.__setitem__(String('HTML'), html);
		}
		element = pyjamas.ui.Button.DOM.createButton();
		pyjs_kwargs_call(pyjamas.ui.Button.ButtonBase, '__init__', null, kwargs, [{}, self, element]);
		self.adjustType(self.getElement());
		if (pyjslib.bool(listener)) {
			self.addClickListener(listener);
		}
		return null;
	}
	, 1, [null,'kwargs','self', 'html', 'listener']);
	cls_definition.adjustType = pyjs__bind_method(cls_instance, 'adjustType', function(button) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			button = arguments[1];
		}
		var err,pyjs_try_err;
		if (pyjslib.bool(pyjslib.eq((typeof button.type == 'function' && button.__is_instance__?pyjslib.getattr(button, 'type'):button.type), String('submit')))) {
			try {
				pyjamas.ui.Button.DOM.setAttribute(button, String('type'), String('button'));
			} catch(pyjs_try_err) {
				var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
				$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjamas.ui.Button, try_lineno: 39};
				{
					$pyjs.__last_exception__.except_lineno = 42;
					err = pyjs_try_err;
				} 			}
		}
		return null;
	}
	, 1, [null,null,'self', 'button']);
	cls_definition.click = pyjs__bind_method(cls_instance, 'click', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.getElement().click();
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Button.ButtonBase));
})();
return this;
}; /* end pyjamas.ui.Button */
$pyjs.modules_hash['pyjamas.ui.Button'] = $pyjs.loaded_modules['pyjamas.ui.Button'];


 /* end module: pyjamas.ui.Button */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui', 'pyjamas.ui.ButtonBase']
*/
