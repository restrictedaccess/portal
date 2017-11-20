/* start module: pyjamas.ui.DialogBox */
pyjamas.ui.DialogBox = $pyjs.loaded_modules["pyjamas.ui.DialogBox"] = function (__mod_name__) {
if(pyjamas.ui.DialogBox.__was_initialized__) return pyjamas.ui.DialogBox;
pyjamas.ui.DialogBox.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.DialogBox';
var __name__ = pyjamas.ui.DialogBox.__name__ = __mod_name__;
var DialogBox = pyjamas.ui.DialogBox;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.DialogBox');
pyjamas.ui.DialogBox.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.pyjamas.ui.PopupPanel', 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.PopupPanel'], 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui.DialogBox');
pyjamas.ui.DialogBox.PopupPanel = $pyjs.__modules__.pyjamas.ui.PopupPanel.PopupPanel;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HTML.HTML', 'pyjamas.ui.pyjamas.ui.HTML', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML'], 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.DialogBox');
pyjamas.ui.DialogBox.HTML = $pyjs.__modules__.pyjamas.ui.HTML.HTML;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FlexTable.FlexTable', 'pyjamas.ui.pyjamas.ui.FlexTable', 'pyjamas.ui.FlexTable.FlexTable', 'pyjamas.ui.FlexTable'], 'pyjamas.ui.FlexTable.FlexTable', 'pyjamas.ui.DialogBox');
pyjamas.ui.DialogBox.FlexTable = $pyjs.__modules__.pyjamas.ui.FlexTable.FlexTable;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.DialogBox');
pyjamas.ui.DialogBox.HasHorizontalAlignment = $pyjs.__modules__.pyjamas.ui.HasHorizontalAlignment;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui'], 'pyjamas.ui.HasVerticalAlignment', 'pyjamas.ui.DialogBox');
pyjamas.ui.DialogBox.HasVerticalAlignment = $pyjs.__modules__.pyjamas.ui.HasVerticalAlignment;
pyjamas.ui.DialogBox.DialogBox = (function(){
	var cls_instance = pyjs__class_instance('DialogBox');
	var cls_definition = new Object();
	cls_definition.__md5__ = '4c9314fc5ba2f73c4f6d7a29d8bbbd62';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(autoHide, modal) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			autoHide = arguments[1];
			modal = arguments[2];
		}
		if (typeof autoHide == 'undefined') autoHide=null;
		if (typeof modal == 'undefined') modal=true;

		pyjamas.ui.DialogBox.PopupPanel.__init__(self, autoHide, modal);
		self.caption = pyjamas.ui.DialogBox.HTML();
		self.child = null;
		self.dragging = false;
		self.dragStartX = 0;
		self.dragStartY = 0;
		self.panel = pyjs_kwargs_call(pyjamas.ui.DialogBox, 'FlexTable', null, null, [{Height:String('100%'), BorderWidth:String('0'), CellPadding:String('0'), CellSpacing:String('0')}]);
		self.panel.setWidget(0, 0, (typeof self.caption == 'function' && self.__is_instance__?pyjslib.getattr(self, 'caption'):self.caption));
		self.panel.getCellFormatter().setHeight(1, 0, String('100%'));
		self.panel.getCellFormatter().setWidth(1, 0, String('100%'));
		self.panel.getCellFormatter().setAlignment(1, 0, (typeof pyjamas.ui.DialogBox.HasHorizontalAlignment.ALIGN_CENTER == 'function' && pyjamas.ui.DialogBox.HasHorizontalAlignment.__is_instance__?pyjslib.getattr(pyjamas.ui.DialogBox.HasHorizontalAlignment, 'ALIGN_CENTER'):pyjamas.ui.DialogBox.HasHorizontalAlignment.ALIGN_CENTER), (typeof pyjamas.ui.DialogBox.HasVerticalAlignment.ALIGN_MIDDLE == 'function' && pyjamas.ui.DialogBox.HasVerticalAlignment.__is_instance__?pyjslib.getattr(pyjamas.ui.DialogBox.HasVerticalAlignment, 'ALIGN_MIDDLE'):pyjamas.ui.DialogBox.HasVerticalAlignment.ALIGN_MIDDLE));
		pyjamas.ui.DialogBox.PopupPanel.setWidget(self, (typeof self.panel == 'function' && self.__is_instance__?pyjslib.getattr(self, 'panel'):self.panel));
		self.setStyleName(String('gwt-DialogBox'));
		self.caption.setStyleName(String('Caption'));
		self.caption.addMouseListener(self);
		return null;
	}
	, 1, [null,null,'self', 'autoHide', 'modal']);
	cls_definition.getHTML = pyjs__bind_method(cls_instance, 'getHTML', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.caption.getHTML();
	}
	, 1, [null,null,'self']);
	cls_definition.getText = pyjs__bind_method(cls_instance, 'getText', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.caption.getText();
	}
	, 1, [null,null,'self']);
	cls_definition.onEventPreview = pyjs__bind_method(cls_instance, 'onEventPreview', function(event) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			event = arguments[1];
		}
		var target,event_targets_popup,elem,type;
		type = pyjamas.ui.DialogBox.DOM.eventGetType(event);
		if (pyjslib.bool(pyjslib.eq(type, String('mousedown')))) {
			target = pyjamas.ui.DialogBox.DOM.eventGetTarget(event);
			elem = self.caption.getElement();
			event_targets_popup = (target) && (pyjamas.ui.DialogBox.DOM.isOrHasChild(elem, target));
			if (pyjslib.bool(event_targets_popup)) {
				pyjamas.ui.DialogBox.DOM.eventPreventDefault(event);
			}
		}
		return pyjamas.ui.DialogBox.PopupPanel.onEventPreview(self, event);
	}
	, 1, [null,null,'self', 'event']);
	cls_definition.onMouseDown = pyjs__bind_method(cls_instance, 'onMouseDown', function(sender, x, y) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
			x = arguments[2];
			y = arguments[3];
		}

		self.dragging = true;
		pyjamas.ui.DialogBox.DOM.setCapture(self.caption.getElement());
		self.dragStartX = x;
		self.dragStartY = y;
		return null;
	}
	, 1, [null,null,'self', 'sender', 'x', 'y']);
	cls_definition.onMouseEnter = pyjs__bind_method(cls_instance, 'onMouseEnter', function(sender) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
		}

 		return null;
	}
	, 1, [null,null,'self', 'sender']);
	cls_definition.onMouseLeave = pyjs__bind_method(cls_instance, 'onMouseLeave', function(sender) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
		}

 		return null;
	}
	, 1, [null,null,'self', 'sender']);
	cls_definition.onMouseMove = pyjs__bind_method(cls_instance, 'onMouseMove', function(sender, x, y) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
			x = arguments[2];
			y = arguments[3];
		}
		var absX,absY;
		if (pyjslib.bool((typeof self.dragging == 'function' && self.__is_instance__?pyjslib.getattr(self, 'dragging'):self.dragging))) {
			absX =  ( x + self.getAbsoluteLeft() ) ;
			absY =  ( y + self.getAbsoluteTop() ) ;
			self.setPopupPosition( ( absX - (typeof self.dragStartX == 'function' && self.__is_instance__?pyjslib.getattr(self, 'dragStartX'):self.dragStartX) ) ,  ( absY - (typeof self.dragStartY == 'function' && self.__is_instance__?pyjslib.getattr(self, 'dragStartY'):self.dragStartY) ) );
		}
		return null;
	}
	, 1, [null,null,'self', 'sender', 'x', 'y']);
	cls_definition.onMouseUp = pyjs__bind_method(cls_instance, 'onMouseUp', function(sender, x, y) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
			x = arguments[2];
			y = arguments[3];
		}

		self.dragging = false;
		pyjamas.ui.DialogBox.DOM.releaseCapture(self.caption.getElement());
		return null;
	}
	, 1, [null,null,'self', 'sender', 'x', 'y']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(!pyjslib.eq((typeof self.child == 'function' && self.__is_instance__?pyjslib.getattr(self, 'child'):self.child), widget))) {
			return false;
		}
		self.panel.remove(widget);
		self.child = null;
		return true;
	}
	, 1, [null,null,'self', 'widget']);
	cls_definition.setHTML = pyjs__bind_method(cls_instance, 'setHTML', function(html) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			html = arguments[1];
		}

		self.caption.setHTML(html);
		return null;
	}
	, 1, [null,null,'self', 'html']);
	cls_definition.setText = pyjs__bind_method(cls_instance, 'setText', function(text) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			text = arguments[1];
		}

		self.caption.setText(text);
		return null;
	}
	, 1, [null,null,'self', 'text']);
	cls_definition.doAttachChildren = pyjs__bind_method(cls_instance, 'doAttachChildren', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		pyjamas.ui.DialogBox.PopupPanel.doAttachChildren(self);
		self.caption.onAttach();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.doDetachChildren = pyjs__bind_method(cls_instance, 'doDetachChildren', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		pyjamas.ui.DialogBox.PopupPanel.doDetachChildren(self);
		self.caption.onDetach();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.setWidget = pyjs__bind_method(cls_instance, 'setWidget', function(widget) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			widget = arguments[1];
		}

		if (pyjslib.bool(((typeof self.child == 'function' && self.__is_instance__?pyjslib.getattr(self, 'child'):self.child) !== null))) {
			self.panel.remove((typeof self.child == 'function' && self.__is_instance__?pyjslib.getattr(self, 'child'):self.child));
		}
		if (pyjslib.bool((widget !== null))) {
			self.panel.setWidget(1, 0, widget);
		}
		self.child = widget;
		return null;
	}
	, 1, [null,null,'self', 'widget']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.DialogBox.PopupPanel));
})();
return this;
}; /* end pyjamas.ui.DialogBox */
$pyjs.modules_hash['pyjamas.ui.DialogBox'] = $pyjs.loaded_modules['pyjamas.ui.DialogBox'];


 /* end module: pyjamas.ui.DialogBox */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.PopupPanel.PopupPanel', 'pyjamas.ui', 'pyjamas.ui.PopupPanel', 'pyjamas.ui.HTML.HTML', 'pyjamas.ui.HTML', 'pyjamas.ui.FlexTable.FlexTable', 'pyjamas.ui.FlexTable', 'pyjamas.ui.HasHorizontalAlignment', 'pyjamas.ui.HasVerticalAlignment']
*/
