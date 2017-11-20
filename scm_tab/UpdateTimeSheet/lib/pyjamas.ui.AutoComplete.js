/* start module: pyjamas.ui.AutoComplete */
pyjamas.ui.AutoComplete = $pyjs.loaded_modules["pyjamas.ui.AutoComplete"] = function (__mod_name__) {
if(pyjamas.ui.AutoComplete.__was_initialized__) return pyjamas.ui.AutoComplete;
pyjamas.ui.AutoComplete.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.AutoComplete';
var __name__ = pyjamas.ui.AutoComplete.__name__ = __mod_name__;
var AutoComplete = pyjamas.ui.AutoComplete;

pyjslib.__import__(['pyjamas.ui.pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.pyjamas.ui.TextBox', 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.TextBox'], 'pyjamas.ui.TextBox.TextBox', 'pyjamas.ui.AutoComplete');
pyjamas.ui.AutoComplete.TextBox = $pyjs.__modules__.pyjamas.ui.TextBox.TextBox;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.pyjamas.ui.PopupPanel', 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.PopupPanel'], 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.AutoComplete');
pyjamas.ui.AutoComplete.PopupPanel = $pyjs.__modules__.pyjamas.ui.PopupPanel.PopupPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.pyjamas.ui.ListBox', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox'], 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.AutoComplete');
pyjamas.ui.AutoComplete.ListBox = $pyjs.__modules__.pyjamas.ui.ListBox.ListBox;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.KeyboardListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.AutoComplete');
pyjamas.ui.AutoComplete.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.pyjamas.ui.RootPanel', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel'], 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.AutoComplete');
pyjamas.ui.AutoComplete.RootPanel = $pyjs.__modules__.pyjamas.ui.RootPanel.RootPanel;
pyjamas.ui.AutoComplete.AutoCompleteTextBox = (function(){
	var cls_instance = pyjs__class_instance('AutoCompleteTextBox');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'aaf623283fa1adcd9efc15c283eab4d3';
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

		self.choicesPopup = pyjamas.ui.AutoComplete.PopupPanel(true, false);
		self.choices = pyjamas.ui.AutoComplete.ListBox();
		self.items = pyjamas.ui.AutoComplete.SimpleAutoCompletionItems();
		self.popupAdded = false;
		self.visible = false;
		self.choices.addChangeListener(self);
		self.choicesPopup.add((typeof self.choices == 'function' && self.__is_instance__?pyjslib.getattr(self, 'choices'):self.choices));
		self.choicesPopup.addStyleName(String('AutoCompleteChoices'));
		self.choices.setStyleName(String('list'));
		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-AutoCompleteTextBox'));
		}
		pyjs_kwargs_call(pyjamas.ui.AutoComplete.TextBox, '__init__', null, kwargs, [{}, self]);
		self.addKeyboardListener(self);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.setCompletionItems = pyjs__bind_method(cls_instance, 'setCompletionItems', function(items) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			items = arguments[1];
		}

		if (pyjslib.bool(!(pyjslib.hasattr(items, String('getCompletionItems'))))) {
			items = pyjamas.ui.AutoComplete.SimpleAutoCompletionItems(items);
		}
		self.items = items;
		return null;
	}
	, 1, [null,null,'self', 'items']);
	cls_definition.getCompletionItems = pyjs__bind_method(cls_instance, 'getCompletionItems', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.items == 'function' && self.__is_instance__?pyjslib.getattr(self, 'items'):self.items);
	}
	, 1, [null,null,'self']);
	cls_definition.onKeyDown = pyjs__bind_method(cls_instance, 'onKeyDown', function(arg0, arg1, arg2) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			arg0 = arguments[1];
			arg1 = arguments[2];
			arg2 = arguments[3];
		}

 		return null;
	}
	, 1, [null,null,'self', 'arg0', 'arg1', 'arg2']);
	cls_definition.onKeyPress = pyjs__bind_method(cls_instance, 'onKeyPress', function(arg0, arg1, arg2) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			arg0 = arguments[1];
			arg1 = arguments[2];
			arg2 = arguments[3];
		}

 		return null;
	}
	, 1, [null,null,'self', 'arg0', 'arg1', 'arg2']);
	cls_definition.onKeyUp = pyjs__bind_method(cls_instance, 'onKeyUp', function(arg0, arg1, arg2) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			arg0 = arguments[1];
			arg1 = arguments[2];
			arg2 = arguments[3];
		}
		var i,matches,text,selectedIndex;
		if (pyjslib.bool(pyjslib.eq(arg1, (typeof pyjamas.ui.AutoComplete.KeyboardListener.KEY_DOWN == 'function' && pyjamas.ui.AutoComplete.KeyboardListener.__is_instance__?pyjslib.getattr(pyjamas.ui.AutoComplete.KeyboardListener, 'KEY_DOWN'):pyjamas.ui.AutoComplete.KeyboardListener.KEY_DOWN)))) {
			selectedIndex = self.choices.getSelectedIndex();
			selectedIndex += 1;
			if (pyjslib.bool((pyjslib.cmp(selectedIndex, self.choices.getItemCount()) == 1))) {
				selectedIndex = 0;
			}
			self.choices.setSelectedIndex(selectedIndex);
			return null;
		}
		if (pyjslib.bool(pyjslib.eq(arg1, (typeof pyjamas.ui.AutoComplete.KeyboardListener.KEY_UP == 'function' && pyjamas.ui.AutoComplete.KeyboardListener.__is_instance__?pyjslib.getattr(pyjamas.ui.AutoComplete.KeyboardListener, 'KEY_UP'):pyjamas.ui.AutoComplete.KeyboardListener.KEY_UP)))) {
			selectedIndex = self.choices.getSelectedIndex();
			selectedIndex -= 1;
			if (pyjslib.bool((pyjslib.cmp(selectedIndex, 0) == -1))) {
				selectedIndex = self.choices.getItemCount();
			}
			self.choices.setSelectedIndex(selectedIndex);
			return null;
		}
		if (pyjslib.bool(pyjslib.eq(arg1, (typeof pyjamas.ui.AutoComplete.KeyboardListener.KEY_ENTER == 'function' && pyjamas.ui.AutoComplete.KeyboardListener.__is_instance__?pyjslib.getattr(pyjamas.ui.AutoComplete.KeyboardListener, 'KEY_ENTER'):pyjamas.ui.AutoComplete.KeyboardListener.KEY_ENTER)))) {
			if (pyjslib.bool((typeof self.visible == 'function' && self.__is_instance__?pyjslib.getattr(self, 'visible'):self.visible))) {
				self.complete();
			}
			return null;
		}
		if (pyjslib.bool(pyjslib.eq(arg1, (typeof pyjamas.ui.AutoComplete.KeyboardListener.KEY_ESCAPE == 'function' && pyjamas.ui.AutoComplete.KeyboardListener.__is_instance__?pyjslib.getattr(pyjamas.ui.AutoComplete.KeyboardListener, 'KEY_ESCAPE'):pyjamas.ui.AutoComplete.KeyboardListener.KEY_ESCAPE)))) {
			self.choices.clear();
			self.choicesPopup.hide();
			self.visible = false;
			return null;
		}
		text = self.getText();
		matches = new pyjslib.List([]);
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len(text), 0) == 1))) {
			matches = self.items.getCompletionItems(text);
		}
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len(matches), 0) == 1))) {
			self.choices.clear();
			var __i = pyjslib.range(pyjslib.len(matches)).__iter__();
			try {
				while (true) {
					var i = __i.next();
					
					self.choices.addItem(matches.__getitem__(i));
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
			if (pyjslib.bool((pyjslib.eq(pyjslib.len(matches), 1)) && (pyjslib.eq(matches.__getitem__(0), text)))) {
				self.choicesPopup.hide();
			}
			else {
				self.choices.setSelectedIndex(0);
				self.choices.setVisibleItemCount( ( pyjslib.len(matches) + 1 ) );
				if (pyjslib.bool(!((typeof self.popupAdded == 'function' && self.__is_instance__?pyjslib.getattr(self, 'popupAdded'):self.popupAdded)))) {
					pyjamas.ui.AutoComplete.RootPanel().add((typeof self.choicesPopup == 'function' && self.__is_instance__?pyjslib.getattr(self, 'choicesPopup'):self.choicesPopup));
					self.popupAdded = true;
				}
				self.choicesPopup.show();
				self.visible = true;
				self.choicesPopup.setPopupPosition(self.getAbsoluteLeft(),  ( self.getAbsoluteTop() + self.getOffsetHeight() ) );
				self.choices.setWidth(pyjslib.sprintf(String('%dpx'), self.getOffsetWidth()));
			}
		}
		else {
			self.visible = false;
			self.choicesPopup.hide();
		}
		return null;
	}
	, 1, [null,null,'self', 'arg0', 'arg1', 'arg2']);
	cls_definition.onChange = pyjs__bind_method(cls_instance, 'onChange', function(arg0) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			arg0 = arguments[1];
		}

		self.complete();
		return null;
	}
	, 1, [null,null,'self', 'arg0']);
	cls_definition.onClick = pyjs__bind_method(cls_instance, 'onClick', function(arg0) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			arg0 = arguments[1];
		}

		self.complete();
		return null;
	}
	, 1, [null,null,'self', 'arg0']);
	cls_definition.complete = pyjs__bind_method(cls_instance, 'complete', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((pyjslib.cmp(self.choices.getItemCount(), 0) == 1))) {
			self.setText(self.choices.getItemText(self.choices.getSelectedIndex()));
		}
		self.choices.clear();
		self.choicesPopup.hide();
		self.setFocus(true);
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.AutoComplete.TextBox));
})();
pyjamas.ui.AutoComplete.SimpleAutoCompletionItems = (function(){
	var cls_instance = pyjs__class_instance('SimpleAutoCompletionItems');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'c4b0611a655bc9f6c26cb10f04f0e7db';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(items) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			items = arguments[1];
		}
		if (typeof items == 'undefined') items=null;

		if (pyjslib.bool((items === null))) {
			items = new pyjslib.List([]);
		}
		self.completions = items;
		return null;
	}
	, 1, [null,null,'self', 'items']);
	cls_definition.getCompletionItems = pyjs__bind_method(cls_instance, 'getCompletionItems', function(match) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			match = arguments[1];
		}
		var matches,i,lower;
		matches = new pyjslib.List([]);
		match = match.lower();
		var __i = pyjslib.range(pyjslib.len((typeof self.completions == 'function' && self.__is_instance__?pyjslib.getattr(self, 'completions'):self.completions))).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				lower = (typeof self.completions == 'function' && self.__is_instance__?pyjslib.getattr(self, 'completions'):self.completions).__getitem__(i).lower();
				if (pyjslib.bool(lower.startswith(match))) {
					matches.append((typeof self.completions == 'function' && self.__is_instance__?pyjslib.getattr(self, 'completions'):self.completions).__getitem__(i));
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return matches;
	}
	, 1, [null,null,'self', 'match']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
return this;
}; /* end pyjamas.ui.AutoComplete */
$pyjs.modules_hash['pyjamas.ui.AutoComplete'] = $pyjs.loaded_modules['pyjamas.ui.AutoComplete'];


 /* end module: pyjamas.ui.AutoComplete */


/*
PYJS_DEPS: ['pyjamas.ui.TextBox.TextBox', 'pyjamas', 'pyjamas.ui', 'pyjamas.ui.TextBox', 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.PopupPanel', 'pyjamas.ui.ListBox.ListBox', 'pyjamas.ui.ListBox', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.RootPanel.RootPanel', 'pyjamas.ui.RootPanel']
*/
