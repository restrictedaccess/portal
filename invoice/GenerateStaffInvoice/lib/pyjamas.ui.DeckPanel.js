/* start module: pyjamas.ui.DeckPanel */
pyjamas.ui.DeckPanel = $pyjs.loaded_modules["pyjamas.ui.DeckPanel"] = function (__mod_name__) {
if(pyjamas.ui.DeckPanel.__was_initialized__) return pyjamas.ui.DeckPanel;
pyjamas.ui.DeckPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.DeckPanel';
var __name__ = pyjamas.ui.DeckPanel.__name__ = __mod_name__;
var DeckPanel = pyjamas.ui.DeckPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.DeckPanel');
pyjamas.ui.DeckPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.pyjamas.ui.ComplexPanel', 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.ComplexPanel'], 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui.DeckPanel');
pyjamas.ui.DeckPanel.ComplexPanel = $pyjs.__modules__.pyjamas.ui.ComplexPanel.ComplexPanel;
pyjamas.ui.DeckPanel.DeckPanel = (function(){
	var cls_instance = pyjs__class_instance('DeckPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '9aa5648995ce86e63d8a427deb806210';
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

		self.visibleWidget = null;
		self.setElement(pyjamas.ui.DeckPanel.DOM.createDiv());
		pyjs_kwargs_call(pyjamas.ui.DeckPanel.ComplexPanel, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.add = pyjs__bind_method(cls_instance, 'add', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		self.insert(widget, self.getWidgetCount());
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.getVisibleWidget = pyjs__bind_method(cls_instance, 'getVisibleWidget', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.getWidgetIndex((typeof self.visibleWidget == 'function' && self.__is_instance__?pyjslib.getattr(self, 'visibleWidget'):self.visibleWidget));
	}
	, 1, [null,null,'self']);
	cls_definition.getWidget = pyjs__bind_method(cls_instance, 'getWidget', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		return (typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children).__getitem__(index);
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.getWidgetCount = pyjs__bind_method(cls_instance, 'getWidgetCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjslib.len((typeof self.children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'children'):self.children));
	}
	, 1, [null,null,'self']);
	cls_definition.getWidgetIndex = pyjs__bind_method(cls_instance, 'getWidgetIndex', function(child) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			child = arguments[1];
		}

		return self.children.index(child);
	}
	, 1, [null,null,'self', 'child']);
	cls_definition.insert = pyjs__bind_method(cls_instance, 'insert', function(widget, beforeIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			beforeIndex = arguments[2];
		}
		if (typeof beforeIndex == 'undefined') beforeIndex=null;
		var child;
		if (pyjslib.bool(((pyjslib.cmp(beforeIndex, 0) == -1)) || ((pyjslib.cmp(beforeIndex, self.getWidgetCount()) == 1)))) {
			return null;
		}
		pyjamas.ui.DeckPanel.ComplexPanel.insert(self, widget, self.getElement(), beforeIndex);
		child = widget.getElement();
		pyjamas.ui.DeckPanel.DOM.setStyleAttribute(child, String('width'), String('100%'));
		pyjamas.ui.DeckPanel.DOM.setStyleAttribute(child, String('height'), String('100%'));
		widget.setVisible(false);
		return null;
	}
	, 1, [null,null,'self', 'widget', 'beforeIndex']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(pyjslib.isinstance(widget, pyjslib.int_))) {
			widget = self.getWidget(widget);
		}
		if (pyjslib.bool(!(pyjamas.ui.DeckPanel.ComplexPanel.remove(self, widget)))) {
			return false;
		}
		if (pyjslib.bool(pyjslib.eq((typeof self.visibleWidget == 'function' && self.__is_instance__?pyjslib.getattr(self, 'visibleWidget'):self.visibleWidget), widget))) {
			self.visibleWidget = null;
		}
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.showWidget = pyjs__bind_method(cls_instance, 'showWidget', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		self.checkIndex(index);
		if (pyjslib.bool(((typeof self.visibleWidget == 'function' && self.__is_instance__?pyjslib.getattr(self, 'visibleWidget'):self.visibleWidget) !== null))) {
			self.visibleWidget.setVisible(false);
		}
		self.visibleWidget = self.getWidget(index);
		self.visibleWidget.setVisible(true);
		return null;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.checkIndex = pyjs__bind_method(cls_instance, 'checkIndex', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		if (pyjslib.bool(((pyjslib.cmp(index, 0) == -1)) || ((pyjslib.cmp(index, self.getWidgetCount()) != -1)))) {
		}
		return null;
	}
	, 1, [null,null,'self', 'index']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.DeckPanel.ComplexPanel));
})();
return this;
}; /* end pyjamas.ui.DeckPanel */
$pyjs.modules_hash['pyjamas.ui.DeckPanel'] = $pyjs.loaded_modules['pyjamas.ui.DeckPanel'];


 /* end module: pyjamas.ui.DeckPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.ComplexPanel.ComplexPanel', 'pyjamas.ui', 'pyjamas.ui.ComplexPanel']
*/
