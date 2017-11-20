/* start module: pyjamas.ui.CheckBox */
pyjamas.ui.CheckBox = $pyjs.loaded_modules["pyjamas.ui.CheckBox"] = function (__mod_name__) {
if(pyjamas.ui.CheckBox.__was_initialized__) return pyjamas.ui.CheckBox;
pyjamas.ui.CheckBox.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.CheckBox';
var __name__ = pyjamas.ui.CheckBox.__name__ = __mod_name__;
var CheckBox = pyjamas.ui.CheckBox;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.CheckBox');
pyjamas.ui.CheckBox.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui.pyjamas.ui.ButtonBase', 'pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui.ButtonBase'], 'pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui.CheckBox');
pyjamas.ui.CheckBox.ButtonBase = $pyjs.__modules__.pyjamas.ui.ButtonBase.ButtonBase;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.CheckBox');
pyjamas.ui.CheckBox.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjamas.ui.CheckBox._CheckBox_unique_id = 0;
pyjamas.ui.CheckBox.CheckBox = (function(){
	var cls_instance = pyjs__class_instance('CheckBox');
	var cls_definition = new Object();
	cls_definition.__md5__ = '871aa81518004940c76eaae41cf7e0a2';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(label, asHTML) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			label = arguments[1];
			asHTML = arguments[2];
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof asHTML != 'undefined') {
				if (pyjslib.get_pyjs_classtype(asHTML) == 'Dict') {
					kwargs = asHTML;
					asHTML = arguments[3];
				}
			} else 			if (typeof label != 'undefined') {
				if (pyjslib.get_pyjs_classtype(label) == 'Dict') {
					kwargs = label;
					label = arguments[3];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[3];
				}
			} else {
			}
		}
		if (typeof label == 'undefined') label=null;
		if (typeof asHTML == 'undefined') asHTML=false;

		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-CheckBox'));
		}
		if (pyjslib.bool(label)) {
			if (pyjslib.bool(asHTML)) {
				kwargs.__setitem__(String('HTML'), label);
			}
			else {
				kwargs.__setitem__(String('Text'), label);
			}
		}
		pyjs_kwargs_call(self, 'initElement', null, kwargs, [{}, pyjamas.ui.CheckBox.DOM.createInputCheck()]);
		return null;
	}
	, 1, [null,'kwargs','self', 'label', 'asHTML']);
	cls_definition.initElement = pyjs__bind_method(cls_instance, 'initElement', function(element) {
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
		var uid;
		self.inputElem = element;
		self.labelElem = pyjamas.ui.CheckBox.DOM.createLabel();
		pyjs_kwargs_call(pyjamas.ui.CheckBox.ButtonBase, '__init__', null, kwargs, [{}, self, pyjamas.ui.CheckBox.DOM.createSpan()]);
		self.unsinkEvents((((typeof pyjamas.ui.CheckBox.Event.FOCUSEVENTS == 'function' && pyjamas.ui.CheckBox.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.CheckBox.Event, 'FOCUSEVENTS'):pyjamas.ui.CheckBox.Event.FOCUSEVENTS) | (typeof pyjamas.ui.CheckBox.Event.ONCLICK == 'function' && pyjamas.ui.CheckBox.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.CheckBox.Event, 'ONCLICK'):pyjamas.ui.CheckBox.Event.ONCLICK))));
		pyjamas.ui.CheckBox.DOM.sinkEvents((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), (((typeof pyjamas.ui.CheckBox.Event.FOCUSEVENTS == 'function' && pyjamas.ui.CheckBox.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.CheckBox.Event, 'FOCUSEVENTS'):pyjamas.ui.CheckBox.Event.FOCUSEVENTS) | (typeof pyjamas.ui.CheckBox.Event.ONCLICK == 'function' && pyjamas.ui.CheckBox.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.CheckBox.Event, 'ONCLICK'):pyjamas.ui.CheckBox.Event.ONCLICK) | pyjamas.ui.CheckBox.DOM.getEventsSunk((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem)))));
		pyjamas.ui.CheckBox.DOM.appendChild(self.getElement(), (typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem));
		pyjamas.ui.CheckBox.DOM.appendChild(self.getElement(), (typeof self.labelElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'labelElem'):self.labelElem));
		uid = pyjslib.sprintf(String('check%d'), self.getUniqueID());
		pyjamas.ui.CheckBox.DOM.setAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), String('id'), uid);
		pyjamas.ui.CheckBox.DOM.setAttribute((typeof self.labelElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'labelElem'):self.labelElem), String('htmlFor'), uid);
		return null;
	}
	, 1, [null,'kwargs','self', 'element']);
	cls_definition.getUniqueID = pyjs__bind_method(cls_instance, 'getUniqueID', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		pyjamas.ui.CheckBox._CheckBox_unique_id += 1;
		return pyjamas.ui.CheckBox._CheckBox_unique_id;
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getHTML = pyjs__bind_method(cls_instance, 'getHTML', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.CheckBox.DOM.getInnerHTML((typeof self.labelElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'labelElem'):self.labelElem));
	}
	, 1, [null,null,'self']);
	cls_definition.getName = pyjs__bind_method(cls_instance, 'getName', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.CheckBox.DOM.getAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), String('name'));
	}
	, 1, [null,null,'self']);
	cls_definition.getText = pyjs__bind_method(cls_instance, 'getText', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.CheckBox.DOM.getInnerText((typeof self.labelElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'labelElem'):self.labelElem));
	}
	, 1, [null,null,'self']);
	cls_definition.setChecked = pyjs__bind_method(cls_instance, 'setChecked', function(checked) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			checked = arguments[1];
		}

		pyjamas.ui.CheckBox.DOM.setBooleanAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), String('checked'), checked);
		pyjamas.ui.CheckBox.DOM.setBooleanAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), String('defaultChecked'), checked);
		return null;
	}
	, 1, [null,null,'self', 'checked']);
	cls_definition.isChecked = pyjs__bind_method(cls_instance, 'isChecked', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var propName;
		if (pyjslib.bool(self.isAttached())) {
			propName = String('checked');
		}
		else {
			propName = String('defaultChecked');
		}
		return pyjamas.ui.CheckBox.DOM.getBooleanAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), propName);
	}
	, 1, [null,null,'self']);
	cls_definition.isEnabled = pyjs__bind_method(cls_instance, 'isEnabled', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return !(pyjamas.ui.CheckBox.DOM.getBooleanAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), String('disabled')));
	}
	, 1, [null,null,'self']);
	cls_definition.setEnabled = pyjs__bind_method(cls_instance, 'setEnabled', function(enabled) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			enabled = arguments[1];
		}

		pyjamas.ui.CheckBox.DOM.setBooleanAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), String('disabled'), !(enabled));
		return null;
	}
	, 1, [null,null,'self', 'enabled']);
	cls_definition.setFocus = pyjs__bind_method(cls_instance, 'setFocus', function() {
		if (this.__is_instance__ === true) {
			var focused = this;
		} else {
			var focused = arguments[0];
		}

		if (pyjslib.bool(focused)) {
			pyjamas.ui.CheckBox.Focus.focus((typeof pyjamas.ui.CheckBox.self.inputElem == 'function' && pyjamas.ui.CheckBox.self.__is_instance__?pyjslib.getattr(pyjamas.ui.CheckBox.self, 'inputElem'):pyjamas.ui.CheckBox.self.inputElem));
		}
		else {
			pyjamas.ui.CheckBox.Focus.blur((typeof pyjamas.ui.CheckBox.self.inputElem == 'function' && pyjamas.ui.CheckBox.self.__is_instance__?pyjslib.getattr(pyjamas.ui.CheckBox.self, 'inputElem'):pyjamas.ui.CheckBox.self.inputElem));
		}
		return null;
	}
	, 1, [null,null,'focused']);
	cls_definition.setHTML = pyjs__bind_method(cls_instance, 'setHTML', function(html) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			html = arguments[1];
		}

		pyjamas.ui.CheckBox.DOM.setInnerHTML((typeof self.labelElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'labelElem'):self.labelElem), html);
		return null;
	}
	, 1, [null,null,'self', 'html']);
	cls_definition.setName = pyjs__bind_method(cls_instance, 'setName', function(name) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			name = arguments[1];
		}

		pyjamas.ui.CheckBox.DOM.setAttribute((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), String('name'), name);
		return null;
	}
	, 1, [null,null,'self', 'name']);
	cls_definition.setTabIndex = pyjs__bind_method(cls_instance, 'setTabIndex', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		pyjamas.ui.CheckBox.Focus.setTabIndex((typeof self.inputElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'inputElem'):self.inputElem), index);
		return null;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.setText = pyjs__bind_method(cls_instance, 'setText', function(text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
		}

		pyjamas.ui.CheckBox.DOM.setInnerText((typeof self.labelElem == 'function' && self.__is_instance__?pyjslib.getattr(self, 'labelElem'):self.labelElem), text);
		return null;
	}
	, 1, [null,null,'self', 'text']);
	cls_definition.onDetach = pyjs__bind_method(cls_instance, 'onDetach', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.setChecked(self.isChecked());
		pyjamas.ui.CheckBox.ButtonBase.onDetach(self);
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.CheckBox.ButtonBase));
})();
return this;
}; /* end pyjamas.ui.CheckBox */
$pyjs.modules_hash['pyjamas.ui.CheckBox'] = $pyjs.loaded_modules['pyjamas.ui.CheckBox'];


 /* end module: pyjamas.ui.CheckBox */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.ButtonBase.ButtonBase', 'pyjamas.ui', 'pyjamas.ui.ButtonBase', 'pyjamas.ui.Event']
*/
