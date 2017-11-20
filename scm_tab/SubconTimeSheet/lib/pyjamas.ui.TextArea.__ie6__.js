/* start module: pyjamas.ui.TextArea */
pyjamas.ui.TextArea = $pyjs.loaded_modules["pyjamas.ui.TextArea"] = function (__mod_name__) {
if(pyjamas.ui.TextArea.__was_initialized__) return pyjamas.ui.TextArea;
pyjamas.ui.TextArea.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.TextArea';
var __name__ = pyjamas.ui.TextArea.__name__ = __mod_name__;
var TextArea = pyjamas.ui.TextArea;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.TextArea');
pyjamas.ui.TextArea.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.pyjamas.ui.TextBoxBase', 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.TextBoxBase'], 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui.TextArea');
pyjamas.ui.TextArea.TextBoxBase = $pyjs.__modules__.pyjamas.ui.TextBoxBase.TextBoxBase;
pyjamas.ui.TextArea.TextArea = (function(){
	var cls_instance = pyjs__class_instance('TextArea');
	var cls_definition = new Object();
	cls_definition.__md5__ = '951720afefa074f5a1de4f5a2b537fc6';
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
			kwargs.__setitem__(String('StyleName'), String('gwt-TextArea'));
		}
		pyjs_kwargs_call(pyjamas.ui.TextArea.TextBoxBase, '__init__', null, kwargs, [{}, self, pyjamas.ui.TextArea.DOM.createTextArea()]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.getCharacterWidth = pyjs__bind_method(cls_instance, 'getCharacterWidth', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.TextArea.DOM.getIntAttribute(self.getElement(), String('cols'));
	}
	, 1, [null,null,'self']);
	cls_definition.getCursorPos = pyjs__bind_method(cls_instance, 'getCursorPos', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        try {
            var elem = this.getElement();
            var tr = elem.document.selection.createRange();
            var tr2 = tr.duplicate();
            tr2.moveToElementText(elem);
            tr.setEndPoint('EndToStart', tr2);
            return tr.text.length;
        }
        catch (e) {
            return 0;
        }
        
	}
	, 1, [null,null,'self']);
	cls_definition.getVisibleLines = pyjs__bind_method(cls_instance, 'getVisibleLines', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.TextArea.DOM.getIntAttribute(self.getElement(), String('rows'));
	}
	, 1, [null,null,'self']);
	cls_definition.setCharacterWidth = pyjs__bind_method(cls_instance, 'setCharacterWidth', function(width) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			width = arguments[1];
		}

		pyjamas.ui.TextArea.DOM.setIntAttribute(self.getElement(), String('cols'), width);
		return null;
	}
	, 1, [null,null,'self', 'width']);
	cls_definition.setVisibleLines = pyjs__bind_method(cls_instance, 'setVisibleLines', function(lines) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			lines = arguments[1];
		}

		pyjamas.ui.TextArea.DOM.setIntAttribute(self.getElement(), String('rows'), lines);
		return null;
	}
	, 1, [null,null,'self', 'lines']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.TextArea.TextBoxBase));
})();
return this;
}; /* end pyjamas.ui.TextArea */
$pyjs.modules_hash['pyjamas.ui.TextArea'] = $pyjs.loaded_modules['pyjamas.ui.TextArea'];


 /* end module: pyjamas.ui.TextArea */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.TextBoxBase.TextBoxBase', 'pyjamas.ui', 'pyjamas.ui.TextBoxBase']
*/
