/* start module: pyjamas.ui.TabBar */
pyjamas.ui.TabBar = $pyjs.loaded_modules["pyjamas.ui.TabBar"] = function (__mod_name__) {
if(pyjamas.ui.TabBar.__was_initialized__) return pyjamas.ui.TabBar;
pyjamas.ui.TabBar.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.TabBar';
var __name__ = pyjamas.ui.TabBar.__name__ = __mod_name__;
var TabBar = pyjamas.ui.TabBar;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Composite.Composite', 'pyjamas.ui.pyjamas.ui.Composite', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.Composite'], 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.Composite = $pyjs.__modules__.pyjamas.ui.Composite.Composite;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HTML.HTML', 'pyjamas.ui.pyjamas.ui.HTML', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Label.Label', 'pyjamas.ui.pyjamas.ui.Label', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.pyjamas.ui.HorizontalPanel', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel'], 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.HorizontalPanel = $pyjs.__modules__.pyjamas.ui.HorizontalPanel.HorizontalPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.ClickDelegatePanel.ClickDelegatePanel', 'pyjamas.ui.pyjamas.ui.ClickDelegatePanel', 'pyjamas.ui.ClickDelegatePanel.ClickDelegatePanel', 'pyjamas.ui.ClickDelegatePanel'], 'pyjamas.ui.ClickDelegatePanel.ClickDelegatePanel', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.ClickDelegatePanel = $pyjs.__modules__.pyjamas.ui.ClickDelegatePanel.ClickDelegatePanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasAlignment', 'pyjamas.ui.TabBar');
pyjamas.ui.TabBar.HasAlignment = $pyjs.__modules__.pyjamas.ui.HasAlignment;
pyjamas.ui.TabBar.TabBar = (function(){
	var cls_instance = pyjs__class_instance('TabBar');
	var cls_definition = new Object();
	cls_definition.__md5__ = '69b2761064242c4ec08fbd9ae5df47f7';
	cls_definition.STYLENAME_DEFAULT = String('gwt-TabBarItem');
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
		var first,rest;
		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-TabBar'));
		}
		self.panel = pyjamas.ui.TabBar.HorizontalPanel();
		self.selectedTab = null;
		self.tabListeners = new pyjslib.List([]);
		self.panel.setVerticalAlignment((typeof pyjamas.ui.TabBar.HasAlignment.ALIGN_BOTTOM == 'function' && pyjamas.ui.TabBar.HasAlignment.__is_instance__?pyjslib.getattr(pyjamas.ui.TabBar.HasAlignment, 'ALIGN_BOTTOM'):pyjamas.ui.TabBar.HasAlignment.ALIGN_BOTTOM));
		first = pyjamas.ui.TabBar.HTML(String('\x26nbsp\x3B'), true);
		rest = pyjamas.ui.TabBar.HTML(String('\x26nbsp\x3B'), true);
		first.setStyleName(String('gwt-TabBarFirst'));
		rest.setStyleName(String('gwt-TabBarRest'));
		first.setHeight(String('100%'));
		rest.setHeight(String('100%'));
		self.panel.add(first);
		self.panel.add(rest);
		first.setHeight(String('100%'));
		self.panel.setCellHeight(first, String('100%'));
		self.panel.setCellWidth(rest, String('100%'));
		pyjs_kwargs_call(pyjamas.ui.TabBar.Composite, '__init__', null, kwargs, [{}, self, (typeof self.panel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel'):self.panel)]);
		self.sinkEvents((typeof pyjamas.ui.TabBar.Event.ONCLICK == 'function' && pyjamas.ui.TabBar.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.TabBar.Event, 'ONCLICK'):pyjamas.ui.TabBar.Event.ONCLICK));
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.addTab = pyjs__bind_method(cls_instance, 'addTab', function(text, asHTML) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
			asHTML = arguments[2];
		}
		if (typeof asHTML == 'undefined') asHTML=false;

		self.insertTab(text, asHTML, self.getTabCount());
		return null;
	}
	, 1, [null,null,'self', 'text', 'asHTML']);
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
	cls_definition.getSelectedTab = pyjs__bind_method(cls_instance, 'getSelectedTab', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(((typeof self.selectedTab == 'function' && self.__is_instance__?pyjslib.getattr(self, 'selectedTab'):self.selectedTab) === null))) {
			return -1;
		}
		return  ( self.panel.getWidgetIndex((typeof self.selectedTab == 'function' && self.__is_instance__?pyjslib.getattr(self, 'selectedTab'):self.selectedTab)) - 1 ) ;
	}
	, 1, [null,null,'self']);
	cls_definition.getTabCount = pyjs__bind_method(cls_instance, 'getTabCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return  ( self.panel.getWidgetCount() - 2 ) ;
	}
	, 1, [null,null,'self']);
	cls_definition.getTabHTML = pyjs__bind_method(cls_instance, 'getTabHTML', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}
		var fpe,widget,delPanel,focusablePanel;
		if (pyjslib.bool((pyjslib.cmp(index, self.getTabCount()) != -1))) {
			return null;
		}
		delPanel = self.panel.getWidget( ( index + 1 ) );
		focusablePanel = delPanel.getFocusablePanel();
		widget = focusablePanel.getWidget();
		if (pyjslib.bool(pyjslib.hasattr(widget, String('getHTML')))) {
			return widget.getHTML();
		}
		else if (pyjslib.bool(pyjslib.hasattr(widget, String('getText')))) {
			return widget.getText();
		}
		else {
			fpe = pyjamas.ui.TabBar.DOM.getParent(self.focusablePanel.getElement());
			return pyjamas.ui.TabBar.DOM.getInnerHTML(fpe);
		}
		return null;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.createTabTextWrapper = pyjs__bind_method(cls_instance, 'createTabTextWrapper', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.insertTab = pyjs__bind_method(cls_instance, 'insertTab', function(text, asHTML, beforeIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
			asHTML = arguments[2];
			beforeIndex = arguments[3];
		}
		if (typeof beforeIndex == 'undefined') beforeIndex=null;
		var item;
		if (pyjslib.bool((beforeIndex === null))) {
			beforeIndex = asHTML;
			asHTML = false;
		}
		if (pyjslib.bool(((pyjslib.cmp(beforeIndex, 0) == -1)) || ((pyjslib.cmp(beforeIndex, self.getTabCount()) == 1)))) {
		}
		if (pyjslib.bool(pyjslib.isinstance(text, pyjslib.str))) {
			if (pyjslib.bool(asHTML)) {
				item = pyjamas.ui.TabBar.HTML(text);
			}
			else {
				item = pyjamas.ui.TabBar.Label(text);
			}
			item.setWordWrap(false);
		}
		else {
			item = text;
		}
		self.insertTabWidget(item, beforeIndex);
		return null;
	}
	, 1, [null,null,'self', 'text', 'asHTML', 'beforeIndex']);
	cls_definition.insertTabWidget = pyjs__bind_method(cls_instance, 'insertTabWidget', function(widget, beforeIndex) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
			beforeIndex = arguments[2];
		}
		var focusablePanel,delWidget;
		delWidget = pyjamas.ui.TabBar.ClickDelegatePanel(self, widget, self, self);
		delWidget.setStyleName((typeof self.STYLENAME_DEFAULT == 'function' && self.__is_instance__?pyjslib.getattr(self, 'STYLENAME_DEFAULT'):self.STYLENAME_DEFAULT));
		focusablePanel = delWidget.getFocusablePanel();
		self.panel.insert(delWidget,  ( beforeIndex + 1 ) );
		self.setStyleName(pyjamas.ui.TabBar.DOM.getParent(delWidget.getElement()),  ( (typeof self.STYLENAME_DEFAULT == 'function' && self.__is_instance__?pyjslib.getattr(self, 'STYLENAME_DEFAULT'):self.STYLENAME_DEFAULT) + String('-wrapper') ) , true);
		return null;
	}
	, 1, [null,null,'self', 'widget', 'beforeIndex']);
	cls_definition.onClick = pyjs__bind_method(cls_instance, 'onClick', function(sender) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
		}
		if (typeof sender == 'undefined') sender=null;
		var i;
		var __i = pyjslib.range(1,  ( self.panel.getWidgetCount() - 1 ) ).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				if (pyjslib.bool(pyjamas.ui.TabBar.DOM.isOrHasChild(self.panel.getWidget(i).getElement(), sender.getElement()))) {
					return self.selectTab( ( i - 1 ) );
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return false;
	}
	, 1, [null,null,'self', 'sender']);
	cls_definition.removeTab = pyjs__bind_method(cls_instance, 'removeTab', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}
		var toRemove;
		self.checkTabIndex(index);
		toRemove = self.panel.getWidget( ( index + 1 ) );
		if (pyjslib.bool(pyjslib.eq(toRemove, (typeof self.selectedTab == 'function' && self.__is_instance__?pyjslib.getattr(self, 'selectedTab'):self.selectedTab)))) {
			self.selectedTab = null;
		}
		self.panel.remove(toRemove);
		return null;
	}
	, 1, [null,null,'self', 'index']);
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
		var listener;
		self.checkTabIndex(index);
		var __listener = self.tabListeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				if (pyjslib.bool(!(listener.onBeforeTabSelected(self, index)))) {
					return false;
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.setSelectionStyle((typeof self.selectedTab == 'function' && self.__is_instance__?pyjslib.getattr(self, 'selectedTab'):self.selectedTab), false);
		if (pyjslib.bool(pyjslib.eq(index, -1))) {
			self.selectedTab = null;
			return true;
		}
		self.selectedTab = self.panel.getWidget( ( index + 1 ) );
		self.setSelectionStyle((typeof self.selectedTab == 'function' && self.__is_instance__?pyjslib.getattr(self, 'selectedTab'):self.selectedTab), true);
		var __listener = self.tabListeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onTabSelected(self, index);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return true;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.checkTabIndex = pyjs__bind_method(cls_instance, 'checkTabIndex', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		if (pyjslib.bool(((pyjslib.cmp(index, -1) == -1)) || ((pyjslib.cmp(index, self.getTabCount()) != -1)))) {
		}
		return null;
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.setSelectionStyle = pyjs__bind_method(cls_instance, 'setSelectionStyle', function(item, selected) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			item = arguments[1];
			selected = arguments[2];
		}

		if (pyjslib.bool((item !== null))) {
			if (pyjslib.bool(selected)) {
				item.addStyleName(String('gwt-TabBarItem-selected'));
				self.setStyleName(pyjamas.ui.TabBar.DOM.getParent(item.getElement()), String('gwt-TabBarItem-wrapper-selected'), true);
			}
			else {
				item.removeStyleName(String('gwt-TabBarItem-selected'));
				self.setStyleName(pyjamas.ui.TabBar.DOM.getParent(item.getElement()), String('gwt-TabBarItem-wrapper-selected'), false);
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'item', 'selected']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.TabBar.Composite));
})();
return this;
}; /* end pyjamas.ui.TabBar */
$pyjs.modules_hash['pyjamas.ui.TabBar'] = $pyjs.loaded_modules['pyjamas.ui.TabBar'];


 /* end module: pyjamas.ui.TabBar */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui', 'pyjamas.ui.Composite', 'pyjamas.ui.Event', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label', 'pyjamas.ui.HorizontalPanel.HorizontalPanel', 'pyjamas.ui.HorizontalPanel', 'pyjamas.ui.ClickDelegatePanel.ClickDelegatePanel', 'pyjamas.ui.ClickDelegatePanel', 'pyjamas.ui.HasAlignment']
*/
