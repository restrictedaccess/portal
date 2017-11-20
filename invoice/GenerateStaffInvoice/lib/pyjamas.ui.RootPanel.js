/* start module: pyjamas.ui.RootPanel */
pyjamas.ui.RootPanel = $pyjs.loaded_modules["pyjamas.ui.RootPanel"] = function (__mod_name__) {
if(pyjamas.ui.RootPanel.__was_initialized__) return pyjamas.ui.RootPanel;
pyjamas.ui.RootPanel.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.RootPanel';
var __name__ = pyjamas.ui.RootPanel.__name__ = __mod_name__;
var RootPanel = pyjamas.ui.RootPanel;

pyjslib.__import__(['pyjamas.ui.sys', 'sys'], 'sys', 'pyjamas.ui.RootPanel');
pyjamas.ui.RootPanel.sys = $pyjs.__modules__.sys;
pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.RootPanel');
pyjamas.ui.RootPanel.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.Window', 'pyjamas.ui.pyjamas', 'pyjamas.Window', 'pyjamas'], 'pyjamas.Window', 'pyjamas.ui.RootPanel');
pyjamas.ui.RootPanel.Window = $pyjs.__modules__.pyjamas.Window;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.pyjamas.ui.AbsolutePanel', 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.AbsolutePanel'], 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui.RootPanel');
pyjamas.ui.RootPanel.AbsolutePanel = $pyjs.__modules__.pyjamas.ui.AbsolutePanel.AbsolutePanel;
pyjamas.ui.RootPanel.rootPanels = new pyjslib.Dict([]);
pyjamas.ui.RootPanel.RootPanelCls = (function(){
	var cls_instance = pyjs__class_instance('RootPanelCls');
	var cls_definition = new Object();
	cls_definition.__md5__ = '1d703ca666480705014639f4993d4e20';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(element) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			element = arguments[1];
		}
		if (typeof element == 'undefined') element=null;

		pyjamas.ui.RootPanel.AbsolutePanel.__init__(self);
		if (pyjslib.bool((element === null))) {
			element = self.getBodyElement();
		}
		self.setElement(element);
		self.onAttach();
		return null;
	}
	, 1, [null,null,'self', 'element']);
	cls_definition.getBodyElement = pyjs__bind_method(cls_instance, 'getBodyElement', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof $doc.body == 'function' && $doc.__is_instance__?pyjslib.getattr($doc, 'body'):$doc.body);
	}
	, 1, [null,null,'self']);
	cls_definition.get = pyjs__bind_method(cls_instance, 'get', function(id) {
    var cls = this.prototype;
		if (typeof id == 'undefined') id=null;
		var element,panel;
		if (pyjslib.bool(pyjamas.ui.RootPanel.rootPanels.has_key(id))) {
			return pyjamas.ui.RootPanel.rootPanels.__getitem__(id);
		}
		element = null;
		if (pyjslib.bool(id)) {
			element = pyjamas.ui.RootPanel.DOM.getElementById(id);
			if (pyjslib.bool(!(element))) {
				return null;
			}
		}
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len(pyjamas.ui.RootPanel.rootPanels), 1) == -1))) {
			cls.hookWindowClosing();
		}
		panel = pyjamas.ui.RootPanel.RootPanel(element);
		pyjamas.ui.RootPanel.rootPanels.__setitem__(id, panel);
		return panel;
	}
	, 2, [null,null,'cls', 'id']);
	cls_definition.hookWindowClosing = pyjs__bind_method(cls_instance, 'hookWindowClosing', function() {
    var cls = this.prototype;

		pyjamas.ui.RootPanel.Window.addWindowCloseListener(cls);
		return null;
	}
	, 2, [null,null,'cls']);
	cls_definition.onWindowClosed = pyjs__bind_method(cls_instance, 'onWindowClosed', function() {
    var cls = this.prototype;
		var panel;
		var __panel = pyjamas.ui.RootPanel.rootPanels.itervalues().__iter__();
		try {
			while (true) {
				var panel = __panel.next();
				
				panel.onDetach();
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 2, [null,null,'cls']);
	cls_definition.onWindowClosing = pyjs__bind_method(cls_instance, 'onWindowClosing', function() {
    var cls = this.prototype;

		return null;
	}
	, 2, [null,null,'cls']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.RootPanel.AbsolutePanel));
})();
pyjamas.ui.RootPanel.RootPanel = function(element) {
	if (typeof element == 'undefined') element=null;

	if (pyjslib.bool(pyjslib.isinstance(element, pyjslib.str))) {
		return pyjamas.ui.RootPanel.RootPanelCls().get(element);
	}
	return pyjamas.ui.RootPanel.RootPanelCls(element);
};
pyjamas.ui.RootPanel.RootPanel.__name__ = 'RootPanel';

pyjamas.ui.RootPanel.RootPanel.__bind_type__ = 0;
pyjamas.ui.RootPanel.RootPanel.__args__ = [null,null,'element'];
return this;
}; /* end pyjamas.ui.RootPanel */
$pyjs.modules_hash['pyjamas.ui.RootPanel'] = $pyjs.loaded_modules['pyjamas.ui.RootPanel'];


 /* end module: pyjamas.ui.RootPanel */


/*
PYJS_DEPS: ['sys', 'pyjamas.DOM', 'pyjamas', 'pyjamas.Window', 'pyjamas.ui.AbsolutePanel.AbsolutePanel', 'pyjamas.ui', 'pyjamas.ui.AbsolutePanel']
*/
