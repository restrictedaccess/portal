/* start module: pyjamas.ui.ListBox */
pyjamas.ui.ListBox = $pyjs.loaded_modules["pyjamas.ui.ListBox"] = function (__mod_name__) {
if(pyjamas.ui.ListBox.__was_initialized__) return pyjamas.ui.ListBox;
pyjamas.ui.ListBox.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.ListBox';
var __name__ = pyjamas.ui.ListBox.__name__ = __mod_name__;
var ListBox = pyjamas.ui.ListBox;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.ListBox');
pyjamas.ui.ListBox.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.pyjamas.ui.FocusWidget', 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.FocusWidget'], 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui.ListBox');
pyjamas.ui.ListBox.FocusWidget = $pyjs.__modules__.pyjamas.ui.FocusWidget.FocusWidget;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.ListBox');
pyjamas.ui.ListBox.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjamas.ui.ListBox.ListBox = (function(){
	var cls_instance = pyjs__class_instance('ListBox');
	var cls_definition = new Object();
	cls_definition.__md5__ = '7cb70660556a4fe2e8b11a6af4406881';
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
			kwargs.__setitem__(String('StyleName'), String('gwt-ListBox'));
		}
		self.changeListeners = new pyjslib.List([]);
		self.INSERT_AT_END = -1;
		pyjs_kwargs_call(pyjamas.ui.ListBox.FocusWidget, '__init__', null, kwargs, [{}, self, pyjamas.ui.ListBox.DOM.createSelect()]);
		self.sinkEvents((typeof pyjamas.ui.ListBox.Event.ONCHANGE == 'function' && pyjamas.ui.ListBox.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.ListBox.Event, 'ONCHANGE'):pyjamas.ui.ListBox.Event.ONCHANGE));
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.addChangeListener = pyjs__bind_method(cls_instance, 'addChangeListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.changeListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.addItem = pyjs__bind_method(cls_instance, 'addItem', function(item, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			item = arguments[1];
			value = arguments[2];
		}
		if (typeof value == 'undefined') value=null;

		self.insertItem(item, value, (typeof self.INSERT_AT_END == 'function' && self.__is_instance__?pyjslib.getattr(self, 'INSERT_AT_END'):self.INSERT_AT_END));
		return null;
	}
	, 1, [null,null,'self', 'item', 'value']);
	cls_definition.clear = pyjs__bind_method(cls_instance, 'clear', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var h;
		h = self.getElement();
    while (pyjslib.bool((pyjslib.cmp(pyjamas.ui.ListBox.DOM.getChildCount(h), 0) == 1))) {
		pyjamas.ui.ListBox.DOM.removeChild(h, pyjamas.ui.ListBox.DOM.getChild(h, 0));
    }
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getItemCount = pyjs__bind_method(cls_instance, 'getItemCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ListBox.DOM.getChildCount(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.getItemText = pyjs__bind_method(cls_instance, 'getItemText', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}
		var child;
		child = pyjamas.ui.ListBox.DOM.getChild(self.getElement(), index);
		return pyjamas.ui.ListBox.DOM.getInnerText(child);
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.getName = pyjs__bind_method(cls_instance, 'getName', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ListBox.DOM.getAttribute(self.getElement(), String('name'));
	}
	, 1, [null,null,'self']);
	cls_definition.getSelectedIndex = pyjs__bind_method(cls_instance, 'getSelectedIndex', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ListBox.DOM.getIntAttribute(self.getElement(), String('selectedIndex'));
	}
	, 1, [null,null,'self']);
	cls_definition.getValue = pyjs__bind_method(cls_instance, 'getValue', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}
		var option;
		self.checkIndex(index);
		option = pyjamas.ui.ListBox.DOM.getChild(self.getElement(), index);
		return pyjamas.ui.ListBox.DOM.getAttribute(option, String('value'));
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.getVisibleItemCount = pyjs__bind_method(cls_instance, 'getVisibleItemCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ListBox.DOM.getIntAttribute(self.getElement(), String('size'));
	}
	, 1, [null,null,'self']);
	cls_definition.insertItem = pyjs__bind_method(cls_instance, 'insertItem', function(item, value, index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			item = arguments[1];
			value = arguments[2];
			index = arguments[3];
		}
		if (typeof index == 'undefined') index=null;

		if (pyjslib.bool((index === null))) {
			index = value;
			value = null;
		}
		pyjamas.ui.ListBox.DOM.insertListItem(self.getElement(), item, value, index);
		return null;
	}
	, 1, [null,null,'self', 'item', 'value', 'index']);
	cls_definition.isItemSelected = pyjs__bind_method(cls_instance, 'isItemSelected', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}
		var option;
		self.checkIndex(index);
		option = pyjamas.ui.ListBox.DOM.getChild(self.getElement(), index);
		return pyjamas.ui.ListBox.DOM.getBooleanAttribute(option, String('selected'));
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.isMultipleSelect = pyjs__bind_method(cls_instance, 'isMultipleSelect', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.ListBox.DOM.getBooleanAttribute(self.getElement(), String('multiple'));
	}
	, 1, [null,null,'self']);
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var listener;
		if (pyjslib.bool(pyjslib.eq(pyjamas.ui.ListBox.DOM.eventGetType(event), String('change')))) {
			var __listener = self.changeListeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					if (pyjslib.bool(pyjslib.hasattr(listener, String('onChange')))) {
						listener.onChange(self);
					}
					else {
						listener(self);
					}
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
		}
		else {
			pyjamas.ui.ListBox.FocusWidget.onBrowserEvent(self, event);
		}
		return null;
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.removeChangeListener = pyjs__bind_method(cls_instance, 'removeChangeListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.changeListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.removeItem = pyjs__bind_method(cls_instance, 'removeItem', function(idx) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			idx = arguments[1];
		}
		var child;
		child = pyjamas.ui.ListBox.DOM.getChild(self.getElement(), idx);
		pyjamas.ui.ListBox.DOM.removeChild(self.getElement(), child);
		return null;
	}
	, 1, [null,null,'self', 'idx']);
	cls_definition.setItemSelected = pyjs__bind_method(cls_instance, 'setItemSelected', function(index, selected) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
			selected = arguments[2];
		}
		var option;
		self.checkIndex(index);
		option = pyjamas.ui.ListBox.DOM.getChild(self.getElement(), index);
		pyjamas.ui.ListBox.DOM.setIntAttribute(option, String('selected'), ((selected) && (1)) || (0));
		return null;
	}
	, 1, [null,null,'self', 'index', 'selected']);
	cls_definition.setMultipleSelect = pyjs__bind_method(cls_instance, 'setMultipleSelect', function(multiple) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			multiple = arguments[1];
		}

		pyjamas.ui.ListBox.DOM.setBooleanAttribute(self.getElement(), String('multiple'), multiple);
		return null;
	}
	, 1, [null,null,'self', 'multiple']);
	cls_definition.setName = pyjs__bind_method(cls_instance, 'setName', function(name) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			name = arguments[1];
		}

		pyjamas.ui.ListBox.DOM.setAttribute(self.getElement(), String('name'), name);
		return null;
	}
	, 1, [null,null,'self', 'name']);
	cls_definition.setSelectedIndex = pyjs__bind_method(cls_instance, 'setSelectedIndex', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		pyjamas.ui.ListBox.DOM.setIntAttribute(self.getElement(), String('selectedIndex'), index);
		return null;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.selectValue = pyjs__bind_method(cls_instance, 'selectValue', function(value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			value = arguments[1];
		}
		var n;
		var __n = pyjslib.range(self.getItemCount()).__iter__();
		try {
			while (true) {
				var n = __n.next();
				
				if (pyjslib.bool(pyjslib.eq(self.getItemText(n), value))) {
					self.setSelectedIndex(n);
					return n;
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'value']);
	cls_definition.setItemText = pyjs__bind_method(cls_instance, 'setItemText', function(index, text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
			text = arguments[2];
		}

		self.checkIndex(index);
		if (pyjslib.bool((text === null))) {
			console.error(String('Cannot set an option to have null text'));
			return null;
		}
		pyjamas.ui.ListBox.DOM.setOptionText(self.getElement(), text, index);
		return null;
	}
	, 1, [null,null,'self', 'index', 'text']);
	cls_definition.setValue = pyjs__bind_method(cls_instance, 'setValue', function(index, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
			value = arguments[2];
		}
		var option;
		self.checkIndex(index);
		option = pyjamas.ui.ListBox.DOM.getChild(self.getElement(), index);
		pyjamas.ui.ListBox.DOM.setAttribute(option, String('value'), value);
		return null;
	}
	, 1, [null,null,'self', 'index', 'value']);
	cls_definition.setVisibleItemCount = pyjs__bind_method(cls_instance, 'setVisibleItemCount', function(visibleItems) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			visibleItems = arguments[1];
		}

		pyjamas.ui.ListBox.DOM.setIntAttribute(self.getElement(), String('size'), visibleItems);
		return null;
	}
	, 1, [null,null,'self', 'visibleItems']);
	cls_definition.checkIndex = pyjs__bind_method(cls_instance, 'checkIndex', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}
		var elem;
		elem = self.getElement();
		if (pyjslib.bool(((pyjslib.cmp(index, 0) == -1)) || ((pyjslib.cmp(index, pyjamas.ui.ListBox.DOM.getChildCount(elem)) != -1)))) {
		}
		return null;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.getSelectedItemText = pyjs__bind_method(cls_instance, 'getSelectedItemText', function(ignore_first_value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			ignore_first_value = arguments[1];
		}
		if (typeof ignore_first_value == 'undefined') ignore_first_value=false;
		var i,selected,start_idx;
		selected = new pyjslib.List([]);
		if (pyjslib.bool(ignore_first_value)) {
			start_idx = 1;
		}
		else {
			start_idx = 0;
		}
		var __i = pyjslib.range(start_idx, self.getItemCount()).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(self.isItemSelected(i))) {
					selected.append(self.getItemText(i));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return selected;
	}
	, 1, [null,null,'self', 'ignore_first_value']);
	cls_definition.getSelectedValues = pyjs__bind_method(cls_instance, 'getSelectedValues', function(ignore_first_value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			ignore_first_value = arguments[1];
		}
		if (typeof ignore_first_value == 'undefined') ignore_first_value=false;
		var i,selected,start_idx;
		selected = new pyjslib.List([]);
		if (pyjslib.bool(ignore_first_value)) {
			start_idx = 1;
		}
		else {
			start_idx = 0;
		}
		var __i = pyjslib.range(start_idx, self.getItemCount()).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(self.isItemSelected(i))) {
					selected.append(self.getValue(i));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return selected;
	}
	, 1, [null,null,'self', 'ignore_first_value']);
	cls_definition.setItemTextSelection = pyjs__bind_method(cls_instance, 'setItemTextSelection', function(values) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			values = arguments[1];
		}
		var i;
		if (pyjslib.bool(!(values))) {
			values = new pyjslib.List([]);
			self.setSelectedIndex(0);
		}
		var __i = pyjslib.range(0, self.getItemCount()).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(values.__contains__(self.getItemText(i)))) {
					self.setItemSelected(i, String('selected'));
				}
				else {
					self.setItemSelected(i, String(''));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'values']);
	cls_definition.setValueSelection = pyjs__bind_method(cls_instance, 'setValueSelection', function(values) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			values = arguments[1];
		}
		var i;
		if (pyjslib.bool(!(values))) {
			values = new pyjslib.List([]);
			self.setSelectedIndex(0);
		}
		var __i = pyjslib.range(0, self.getItemCount()).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(values.__contains__(self.getValue(i)))) {
					self.setItemSelected(i, String('selected'));
				}
				else {
					self.setItemSelected(i, String(''));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'values']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.ListBox.FocusWidget));
})();
return this;
}; /* end pyjamas.ui.ListBox */
$pyjs.modules_hash['pyjamas.ui.ListBox'] = $pyjs.loaded_modules['pyjamas.ui.ListBox'];


 /* end module: pyjamas.ui.ListBox */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.FocusWidget.FocusWidget', 'pyjamas.ui', 'pyjamas.ui.FocusWidget', 'pyjamas.ui.Event']
*/
