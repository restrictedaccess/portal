/* start module: pyjamas.ui.UIObject */
pyjamas.ui.UIObject = $pyjs.loaded_modules["pyjamas.ui.UIObject"] = function (__mod_name__) {
if(pyjamas.ui.UIObject.__was_initialized__) return pyjamas.ui.UIObject;
pyjamas.ui.UIObject.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.UIObject';
var __name__ = pyjamas.ui.UIObject.__name__ = __mod_name__;
var UIObject = pyjamas.ui.UIObject;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.UIObject');
pyjamas.ui.UIObject.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.Window', 'pyjamas.ui.pyjamas', 'pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'pyjamas.ui.UIObject');
pyjamas.ui.UIObject.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Applier', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Applier', 'pyjamas.ui'], 'pyjamas.ui.Applier', 'pyjamas.ui.UIObject');
pyjamas.ui.UIObject.Applier = $pyjs.__modules__.pyjamas.ui.Applier;
pyjamas.ui.UIObject.setStyleName = function(element, style, add) {
	var last,idx,lastPos,oldStyle,begin,end;
	oldStyle = pyjamas.ui.UIObject.DOM.getAttribute(element, String('className'));
	if (pyjslib.bool((oldStyle === null))) {
		oldStyle = String('');
	}
	idx = oldStyle.find(style);
	lastPos = pyjslib.len(oldStyle);
    while (pyjslib.bool(!pyjslib.eq(idx, -1))) {
	if (pyjslib.bool((pyjslib.eq(idx, 0)) || (pyjslib.eq(oldStyle.__getitem__( ( idx - 1 ) ), String(' '))))) {
		last =  ( idx + pyjslib.len(style) ) ;
		if (pyjslib.bool((pyjslib.eq(last, lastPos)) || (((pyjslib.cmp(last, lastPos) == -1)) && (pyjslib.eq(oldStyle.__getitem__(last), String(' ')))))) {
			break;
		}
	}
	idx = oldStyle.find(style,  ( idx + 1 ) );
    }
	if (pyjslib.bool(add)) {
		if (pyjslib.bool(pyjslib.eq(idx, -1))) {
			pyjamas.ui.UIObject.DOM.setAttribute(element, String('className'),  (  ( oldStyle + String(' ') )  + style ) );
		}
	}
	else {
		if (pyjslib.bool(!pyjslib.eq(idx, -1))) {
			begin = pyjslib.slice(oldStyle, null,  ( idx - 1 ) );
			end = pyjslib.slice(oldStyle,  ( idx + pyjslib.len(style) ) , null);
			pyjamas.ui.UIObject.DOM.setAttribute(element, String('className'),  ( begin + end ) );
		}
	}
	return null;
};
pyjamas.ui.UIObject.setStyleName.__name__ = 'setStyleName';

pyjamas.ui.UIObject.setStyleName.__bind_type__ = 0;
pyjamas.ui.UIObject.setStyleName.__args__ = [null,null,'element', 'style', 'add'];
pyjamas.ui.UIObject.UIObject = (function(){
	var cls_instance = pyjs__class_instance('UIObject');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'b8c96dc4384c32fcdb1c0326528e800f';
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

		pyjs_kwargs_call(pyjamas.ui.UIObject.Applier, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.getAbsoluteLeft = pyjs__bind_method(cls_instance, 'getAbsoluteLeft', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getAbsoluteLeft(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.getAbsoluteTop = pyjs__bind_method(cls_instance, 'getAbsoluteTop', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getAbsoluteTop(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.getElement = pyjs__bind_method(cls_instance, 'getElement', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element);
	}
	, 1, [null,null,'self']);
	cls_definition.getOffsetHeight = pyjs__bind_method(cls_instance, 'getOffsetHeight', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getIntAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('offsetHeight'));
	}
	, 1, [null,null,'self']);
	cls_definition.getOffsetWidth = pyjs__bind_method(cls_instance, 'getOffsetWidth', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getIntAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('offsetWidth'));
	}
	, 1, [null,null,'self']);
	cls_definition.getStyleName = pyjs__bind_method(cls_instance, 'getStyleName', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('className'));
	}
	, 1, [null,null,'self']);
	cls_definition.getStylePrimaryName = pyjs__bind_method(cls_instance, 'getStylePrimaryName', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var fullClassName;
		fullClassName = self.getStyleName();
		if (pyjslib.bool(fullClassName)) {
			return fullClassName.split().__getitem__(0);
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getTitle = pyjs__bind_method(cls_instance, 'getTitle', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('title'));
	}
	, 1, [null,null,'self']);
	cls_definition.setElement = pyjs__bind_method(cls_instance, 'setElement', function(element) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
		}

		self.element = element;
		return null;
	}
	, 1, [null,null,'self', 'element']);
	cls_definition.setHeight = pyjs__bind_method(cls_instance, 'setHeight', function(height) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			height = arguments[1];
		}

		pyjamas.ui.UIObject.DOM.setStyleAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('height'), pyjslib.str(height));
		return null;
	}
	, 1, [null,null,'self', 'height']);
	cls_definition.getHeight = pyjs__bind_method(cls_instance, 'getHeight', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getStyleAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('height'));
	}
	, 1, [null,null,'self']);
	cls_definition.setPixelSize = pyjs__bind_method(cls_instance, 'setPixelSize', function(width, height) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			width = arguments[1];
			height = arguments[2];
		}

		if (pyjslib.bool((pyjslib.cmp(width, 0) != -1))) {
			self.setWidth(pyjslib.sprintf(String('%dpx'), width));
		}
		if (pyjslib.bool((pyjslib.cmp(height, 0) != -1))) {
			self.setHeight(pyjslib.sprintf(String('%dpx'), height));
		}
		return null;
	}
	, 1, [null,null,'self', 'width', 'height']);
	cls_definition.setSize = pyjs__bind_method(cls_instance, 'setSize', function(width, height) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			width = arguments[1];
			height = arguments[2];
		}

		self.setWidth(width);
		self.setHeight(height);
		return null;
	}
	, 1, [null,null,'self', 'width', 'height']);
	cls_definition.addStyleName = pyjs__bind_method(cls_instance, 'addStyleName', function(style) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			style = arguments[1];
		}

		self.setStyleName((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), style, true);
		return null;
	}
	, 1, [null,null,'self', 'style']);
	cls_definition.addStyleDependentName = pyjs__bind_method(cls_instance, 'addStyleDependentName', function(styleSuffix) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			styleSuffix = arguments[1];
		}

		self.addStyleName( (  ( self.getStylePrimaryName() + String('-') )  + styleSuffix ) );
		return null;
	}
	, 1, [null,null,'self', 'styleSuffix']);
	cls_definition.removeStyleName = pyjs__bind_method(cls_instance, 'removeStyleName', function(style) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			style = arguments[1];
		}

		self.setStyleName((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), style, false);
		return null;
	}
	, 1, [null,null,'self', 'style']);
	cls_definition.removeStyleDependentName = pyjs__bind_method(cls_instance, 'removeStyleDependentName', function(styleSuffix) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			styleSuffix = arguments[1];
		}

		self.removeStyleName( (  ( self.getStylePrimaryName() + String('-') )  + styleSuffix ) );
		return null;
	}
	, 1, [null,null,'self', 'styleSuffix']);
	cls_definition.setStyleName = pyjs__bind_method(cls_instance, 'setStyleName', function(element, style, add) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
			style = arguments[2];
			add = arguments[3];
		}
		if (typeof style == 'undefined') style=null;
		if (typeof add == 'undefined') add=true;

		if (pyjslib.bool((style === null))) {
			style = element;
			pyjamas.ui.UIObject.DOM.setAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('className'), style);
			return null;
		}
		pyjamas.ui.UIObject.setStyleName(element, style, add);
		return null;
	}
	, 1, [null,null,'self', 'element', 'style', 'add']);
	cls_definition.setTitle = pyjs__bind_method(cls_instance, 'setTitle', function(title) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			title = arguments[1];
		}

		pyjamas.ui.UIObject.DOM.setAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('title'), title);
		return null;
	}
	, 1, [null,null,'self', 'title']);
	cls_definition.setWidth = pyjs__bind_method(cls_instance, 'setWidth', function(width) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			width = arguments[1];
		}

		pyjamas.ui.UIObject.DOM.setStyleAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('width'), pyjslib.str(width));
		return null;
	}
	, 1, [null,null,'self', 'width']);
	cls_definition.getWidth = pyjs__bind_method(cls_instance, 'getWidth', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.UIObject.DOM.getStyleAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('width'));
	}
	, 1, [null,null,'self']);
	cls_definition.sinkEvents = pyjs__bind_method(cls_instance, 'sinkEvents', function(eventBitsToAdd) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			eventBitsToAdd = arguments[1];
		}

		if (pyjslib.bool((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element))) {
			pyjamas.ui.UIObject.DOM.sinkEvents(self.getElement(), ((eventBitsToAdd | pyjamas.ui.UIObject.DOM.getEventsSunk(self.getElement()))));
		}
		return null;
	}
	, 1, [null,null,'self', 'eventBitsToAdd']);
	cls_definition.setzIndex = pyjs__bind_method(cls_instance, 'setzIndex', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		pyjamas.ui.UIObject.DOM.setIntStyleAttribute((typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element), String('zIndex'), index);
		return null;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.isVisible = pyjs__bind_method(cls_instance, 'isVisible', function(element) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
		}
		if (typeof element == 'undefined') element=null;
		var err,pyjs_try_err;
		if (pyjslib.bool(!(element))) {
			element = (typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element);
		}
		try {
			return !pyjslib.eq((typeof element.style.display == 'function' && element.style.__is_instance__?pyjslib.getattr(element.style, 'display'):element.style.display), String('none'));
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjamas.ui.UIObject, try_lineno: 166};
			if (pyjs_try_err_name == pyjslib.AttributeError.__name__) {
				$pyjs.__last_exception__.except_lineno = 168;
				err = pyjs_try_err;
				return true;
			} else { throw pyjs_try_err; }
		}
		return null;
	}
	, 1, [null,null,'self', 'element']);
	cls_definition.setVisible = pyjs__bind_method(cls_instance, 'setVisible', function(element, visible) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
			visible = arguments[2];
		}
		if (typeof visible == 'undefined') visible=null;

		if (pyjslib.bool((visible === null))) {
			visible = element;
			element = (typeof self.element == 'function' && self.__is_instance__?pyjslib.getattr(self, 'element'):self.element);
		}
		if (pyjslib.bool(visible)) {
			pyjamas.ui.UIObject.DOM.setStyleAttribute(element, String('display'), String(''));
		}
		else {
			pyjamas.ui.UIObject.DOM.setStyleAttribute(element, String('display'), String('none'));
		}
		return null;
	}
	, 1, [null,null,'self', 'element', 'visible']);
	cls_definition.unsinkEvents = pyjs__bind_method(cls_instance, 'unsinkEvents', function(eventBitsToRemove) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			eventBitsToRemove = arguments[1];
		}

		pyjamas.ui.UIObject.DOM.sinkEvents(self.getElement(), (((~eventBitsToRemove) & pyjamas.ui.UIObject.DOM.getEventsSunk(self.getElement()))));
		return null;
	}
	, 1, [null,null,'self', 'eventBitsToRemove']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.UIObject.Applier));
})();
return this;
}; /* end pyjamas.ui.UIObject */
$pyjs.modules_hash['pyjamas.ui.UIObject'] = $pyjs.loaded_modules['pyjamas.ui.UIObject'];


 /* end module: pyjamas.ui.UIObject */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.Window', 'pyjamas.ui.Applier', 'pyjamas.ui']
*/
