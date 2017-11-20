/* start module: pyjamas.ui.TabPanel */
pyjamas.ui.TabPanel = $pyjs.loaded_modules["pyjamas.ui.TabPanel"] = function (__mod_name__) {
if(pyjamas.ui.TabPanel.__was_initialized__) return pyjamas.ui.TabPanel;
pyjamas.ui.TabPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.TabPanel';
var __name__ = pyjamas.ui.TabPanel.__name__ = __mod_name__;
var TabPanel = pyjamas.ui.TabPanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.TabPanel');
pyjamas.ui.TabPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Composite.Composite', 'pyjamas.ui.pyjamas.ui.Composite', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.Composite'], 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.TabPanel');
pyjamas.ui.TabPanel.Composite = $pyjs.__modules__.pyjamas.ui.Composite.Composite;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.DeckPanel.DeckPanel', 'pyjamas.ui.pyjamas.ui.DeckPanel', 'pyjamas.ui.DeckPanel.DeckPanel', 'pyjamas.ui.DeckPanel'], 'pyjamas.ui.DeckPanel.DeckPanel', 'pyjamas.ui.TabPanel');
pyjamas.ui.TabPanel.DeckPanel = $pyjs.__modules__.pyjamas.ui.DeckPanel.DeckPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.pyjamas.ui.VerticalPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel'], 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.TabPanel');
pyjamas.ui.TabPanel.VerticalPanel = $pyjs.__modules__.pyjamas.ui.VerticalPanel.VerticalPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.TabBar.TabBar', 'pyjamas.ui.pyjamas.ui.TabBar', 'pyjamas.ui.TabBar.TabBar', 'pyjamas.ui.TabBar'], 'pyjamas.ui.TabBar.TabBar', 'pyjamas.ui.TabPanel');
pyjamas.ui.TabPanel.TabBar = $pyjs.__modules__.pyjamas.ui.TabBar.TabBar;
pyjamas.ui.TabPanel.TabPanel = (function(){
	var cls_instance = pyjs__class_instance('TabPanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'fee6f11126277c311c80f4f6d5ad4b7d';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(tabBar) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			tabBar = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof tabBar != 'undefined') {
				if (pyjslib.get_pyjs_classtype(tabBar) == 'Dict') {
					kwargs = tabBar;
					tabBar = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}
		if (typeof tabBar == 'undefined') tabBar=null;
		var panel;
		self.tab_children = new pyjslib.List([]);
		self.deck = pyjs_kwargs_call(pyjamas.ui.TabPanel, 'DeckPanel', null, null, [{StyleName:String('gwt-TabPanelBottom')}]);
		if (pyjslib.bool((tabBar === null))) {
			self.tabBar = pyjamas.ui.TabPanel.TabBar();
		}
		else {
			self.tabBar = tabBar;
		}
		self.tabListeners = new pyjslib.List([]);
		panel = pyjamas.ui.TabPanel.VerticalPanel();
		panel.add((typeof self.tabBar == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tabBar'):self.tabBar));
		panel.add((typeof self.deck == 'function' && self.__is_instance__?pyjslib.getattr(self, 'deck'):self.deck));
		panel.setCellHeight((typeof self.deck == 'function' && self.__is_instance__?pyjslib.getattr(self, 'deck'):self.deck), String('100%'));
		self.tabBar.setWidth(String('100%'));
		self.tabBar.addTabListener(self);
		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-TabPanel'));
		}
		pyjs_kwargs_call(pyjamas.ui.TabPanel.Composite, '__init__', null, kwargs, [{}, self, panel]);
		return null;
	}
	, 1, [null,'kwargs','self', 'tabBar']);
	cls_definition.add = pyjs__bind_method(cls_instance, 'add', function(widget, tabText, asHTML) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			tabText = arguments[2];
			asHTML = arguments[3];
		}
		if (typeof tabText == 'undefined') tabText=null;
		if (typeof asHTML == 'undefined') asHTML=false;

		if (pyjslib.bool((tabText === null))) {
			console.error(String('A tabText parameter must be specified with add().'));
		}
		self.insert(widget, tabText, asHTML, self.getWidgetCount());
		return null;
	}
	, 1, [null,null,'self', 'widget', 'tabText', 'asHTML']);
	cls_definition.addTabListener = pyjs__bind_method(cls_instance, 'addTabListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.tabListeners.append(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.clear = pyjs__bind_method(cls_instance, 'clear', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

    while (pyjslib.bool((pyjslib.cmp(self.getWidgetCount(), 0) == 1))) {
		self.remove(self.getWidget(0));
    }
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getDeckPanel = pyjs__bind_method(cls_instance, 'getDeckPanel', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.deck == 'function' && self.__is_instance__?pyjslib.getattr(self, 'deck'):self.deck);
	}
	, 1, [null,null,'self']);
	cls_definition.getTabBar = pyjs__bind_method(cls_instance, 'getTabBar', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.tabBar == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tabBar'):self.tabBar);
	}
	, 1, [null,null,'self']);
	cls_definition.getWidget = pyjs__bind_method(cls_instance, 'getWidget', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		return (typeof self.tab_children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tab_children'):self.tab_children).__getitem__(index);
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.getWidgetCount = pyjs__bind_method(cls_instance, 'getWidgetCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjslib.len((typeof self.tab_children == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tab_children'):self.tab_children));
	}
	, 1, [null,null,'self']);
	cls_definition.getWidgetIndex = pyjs__bind_method(cls_instance, 'getWidgetIndex', function(child) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			child = arguments[1];
		}

		return self.tab_children.index(child);
	}
	, 1, [null,null,'self', 'child']);
	cls_definition.insert = pyjs__bind_method(cls_instance, 'insert', function(widget, tabText, asHTML, beforeIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			tabText = arguments[2];
			asHTML = arguments[3];
			beforeIndex = arguments[4];
		}
		if (typeof asHTML == 'undefined') asHTML=false;
		if (typeof beforeIndex == 'undefined') beforeIndex=null;

		if (pyjslib.bool((beforeIndex === null))) {
			beforeIndex = asHTML;
			asHTML = false;
		}
		self.tab_children.insert(beforeIndex, widget);
		self.tabBar.insertTab(tabText, asHTML, beforeIndex);
		self.deck.insert(widget, beforeIndex);
		return null;
	}
	, 1, [null,null,'self', 'widget', 'tabText', 'asHTML', 'beforeIndex']);
	cls_definition.__iter__ = pyjs__bind_method(cls_instance, '__iter__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.tab_children.__iter__();
	}
	, 1, [null,null,'self']);
	cls_definition.onBeforeTabSelected = pyjs__bind_method(cls_instance, 'onBeforeTabSelected', function(sender, tabIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
			tabIndex = arguments[2];
		}
		var listener;
		var __listener = self.tabListeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				if (pyjslib.bool(!(listener.onBeforeTabSelected(sender, tabIndex)))) {
					return false;
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return true;
	}
	, 1, [null,null,'self', 'sender', 'tabIndex']);
	cls_definition.onTabSelected = pyjs__bind_method(cls_instance, 'onTabSelected', function(sender, tabIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
			tabIndex = arguments[2];
		}
		var listener;
		self.deck.showWidget(tabIndex);
		var __listener = self.tabListeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onTabSelected(sender, tabIndex);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'sender', 'tabIndex']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}
		var index;
		if (pyjslib.bool(pyjslib.isinstance(widget, pyjslib.int_))) {
			widget = self.getWidget(widget);
		}
		index = self.getWidgetIndex(widget);
		if (pyjslib.bool(pyjslib.eq(index, -1))) {
			return false;
		}
		self.tab_children.remove(widget);
		self.tabBar.removeTab(index);
		self.deck.remove(widget);
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.removeTabListener = pyjs__bind_method(cls_instance, 'removeTabListener', function(listener) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			listener = arguments[1];
		}

		self.tabListeners.remove(listener);
		return null;
	}
	, 1, [null,null,'self', 'listener']);
	cls_definition.selectTab = pyjs__bind_method(cls_instance, 'selectTab', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		self.tabBar.selectTab(index);
		return null;
	}
	, 1, [null,null,'self', 'index']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.TabPanel.Composite));
})();
return this;
}; /* end pyjamas.ui.TabPanel */
$pyjs.modules_hash['pyjamas.ui.TabPanel'] = $pyjs.loaded_modules['pyjamas.ui.TabPanel'];


 /* end module: pyjamas.ui.TabPanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui', 'pyjamas.ui.Composite', 'pyjamas.ui.DeckPanel.DeckPanel', 'pyjamas.ui.DeckPanel', 'pyjamas.ui.VerticalPanel.VerticalPanel', 'pyjamas.ui.VerticalPanel', 'pyjamas.ui.TabBar.TabBar', 'pyjamas.ui.TabBar']
*/
