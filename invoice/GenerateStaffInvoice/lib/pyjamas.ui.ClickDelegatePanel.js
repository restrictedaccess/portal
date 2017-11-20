/* start module: pyjamas.ui.ClickDelegatePanel */
pyjamas.ui.ClickDelegatePanel = $pyjs.loaded_modules["pyjamas.ui.ClickDelegatePanel"] = function (__mod_name__) {
if(pyjamas.ui.ClickDelegatePanel.__was_initialized__) return pyjamas.ui.ClickDelegatePanel;
pyjamas.ui.ClickDelegatePanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.ClickDelegatePanel';
var __name__ = pyjamas.ui.ClickDelegatePanel.__name__ = __mod_name__;
var ClickDelegatePanel = pyjamas.ui.ClickDelegatePanel;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.ClickDelegatePanel');
pyjamas.ui.ClickDelegatePanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Composite.Composite', 'pyjamas.ui.pyjamas.ui.Composite', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.Composite'], 'pyjamas.ui.Composite.Composite', 'pyjamas.ui.ClickDelegatePanel');
pyjamas.ui.ClickDelegatePanel.Composite = $pyjs.__modules__.pyjamas.ui.Composite.Composite;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.ClickDelegatePanel');
pyjamas.ui.ClickDelegatePanel.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Focus', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Focus', 'pyjamas.ui'], 'pyjamas.ui.Focus', 'pyjamas.ui.ClickDelegatePanel');
pyjamas.ui.ClickDelegatePanel.Focus = $pyjs.__modules__.pyjamas.ui.Focus;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.pyjamas.ui.SimplePanel', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.SimplePanel'], 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.ClickDelegatePanel');
pyjamas.ui.ClickDelegatePanel.SimplePanel = $pyjs.__modules__.pyjamas.ui.SimplePanel.SimplePanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.KeyboardListener', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.KeyboardListener', 'pyjamas.ui'], 'pyjamas.ui.KeyboardListener', 'pyjamas.ui.ClickDelegatePanel');
pyjamas.ui.ClickDelegatePanel.KeyboardListener = $pyjs.__modules__.pyjamas.ui.KeyboardListener;
pyjamas.ui.ClickDelegatePanel.ClickDelegatePanel = (function(){
	var cls_instance = pyjs__class_instance('ClickDelegatePanel');
	var cls_definition = new Object();
	cls_definition.__md5__ = '9361bbc8e19be0f528e5f5b1e282438d';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(p, child, cDelegate, kDelegate) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			p = arguments[1];
			child = arguments[2];
			cDelegate = arguments[3];
			kDelegate = arguments[4];
		}
		var wrapperWidget;
		pyjamas.ui.ClickDelegatePanel.Composite.__init__(self);
		self.clickDelegate = cDelegate;
		self.keyDelegate = kDelegate;
		self.focusablePanel = pyjamas.ui.ClickDelegatePanel.SimplePanel(pyjamas.ui.ClickDelegatePanel.Focus.createFocusable());
		self.focusablePanel.setWidget(child);
		wrapperWidget = p.createTabTextWrapper();
		if (pyjslib.bool((wrapperWidget === null))) {
			self.initWidget((typeof self.focusablePanel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'focusablePanel'):self.focusablePanel));
		}
		else {
			wrapperWidget.setWidget((typeof self.focusablePanel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'focusablePanel'):self.focusablePanel));
			self.initWidget(wrapperWidget);
		}
		if (pyjslib.bool(pyjslib.hasattr(child, String('addKeyboardListener')))) {
			child.addKeyboardListener(kDelegate);
		}
		self.sinkEvents((((typeof pyjamas.ui.ClickDelegatePanel.Event.ONCLICK == 'function' && pyjamas.ui.ClickDelegatePanel.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.ClickDelegatePanel.Event, 'ONCLICK'):pyjamas.ui.ClickDelegatePanel.Event.ONCLICK) | (typeof pyjamas.ui.ClickDelegatePanel.Event.ONKEYDOWN == 'function' && pyjamas.ui.ClickDelegatePanel.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.ClickDelegatePanel.Event, 'ONKEYDOWN'):pyjamas.ui.ClickDelegatePanel.Event.ONKEYDOWN))));
		return null;
	}
	, 1, [null,null,'self', 'p', 'child', 'cDelegate', 'kDelegate']);
	cls_definition.onClick = pyjs__bind_method(cls_instance, 'onClick', function(sender) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
		}
		if (typeof sender == 'undefined') sender=null;

		self.clickDelegate.onClick(sender);
		return null;
	}
	, 1, [null,null,'self', 'sender']);
	cls_definition.getFocusablePanel = pyjs__bind_method(cls_instance, 'getFocusablePanel', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.focusablePanel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'focusablePanel'):self.focusablePanel);
	}
	, 1, [null,null,'self']);
	cls_definition.onBrowserEvent = pyjs__bind_method(cls_instance, 'onBrowserEvent', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var modifiers,type;
		type = pyjamas.ui.ClickDelegatePanel.DOM.eventGetType(event);
		if (pyjslib.bool(pyjslib.eq(type, String('click')))) {
			self.onClick(self);
		}
		else if (pyjslib.bool(pyjslib.eq(type, String('keydown')))) {
			modifiers = pyjamas.ui.ClickDelegatePanel.KeyboardListener.getKeyboardModifiers(event);
			if (pyjslib.bool(pyjslib.hasattr((typeof self.keyDelegate == 'function' && self.__is_instance__?pyjslib.getattr(self, 'keyDelegate'):self.keyDelegate), String('onKeyDown')))) {
				self.keyDelegate.onKeyDown(self, pyjamas.ui.ClickDelegatePanel.DOM.eventGetKeyCode(event), modifiers);
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'event']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.ClickDelegatePanel.Composite));
})();
return this;
}; /* end pyjamas.ui.ClickDelegatePanel */
$pyjs.modules_hash['pyjamas.ui.ClickDelegatePanel'] = $pyjs.loaded_modules['pyjamas.ui.ClickDelegatePanel'];


 /* end module: pyjamas.ui.ClickDelegatePanel */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Composite.Composite', 'pyjamas.ui', 'pyjamas.ui.Composite', 'pyjamas.ui.Event', 'pyjamas.ui.Focus', 'pyjamas.ui.SimplePanel.SimplePanel', 'pyjamas.ui.SimplePanel', 'pyjamas.ui.KeyboardListener']
*/
