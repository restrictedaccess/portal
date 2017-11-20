/* start module: pyjamas.ui.MouseListener */
pyjamas.ui.MouseListener = $pyjs.loaded_modules["pyjamas.ui.MouseListener"] = function (__mod_name__) {
if(pyjamas.ui.MouseListener.__was_initialized__) return pyjamas.ui.MouseListener;
pyjamas.ui.MouseListener.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.MouseListener';
var __name__ = pyjamas.ui.MouseListener.__name__ = __mod_name__;
var MouseListener = pyjamas.ui.MouseListener;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.MouseListener');
pyjamas.ui.MouseListener.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjamas.ui.MouseListener.fireMouseEvent = function(listeners, sender, event) {
	var from_element,listener,to_element,y,x,type;
	x =  ( pyjamas.ui.MouseListener.DOM.eventGetClientX(event) - pyjamas.ui.MouseListener.DOM.getAbsoluteLeft(sender.getElement()) ) ;
	y =  ( pyjamas.ui.MouseListener.DOM.eventGetClientY(event) - pyjamas.ui.MouseListener.DOM.getAbsoluteTop(sender.getElement()) ) ;
	type = pyjamas.ui.MouseListener.DOM.eventGetType(event);
	if (pyjslib.bool(pyjslib.eq(type, String('mousedown')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onMouseDown(sender, x, y);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else if (pyjslib.bool(pyjslib.eq(type, String('mouseup')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onMouseUp(sender, x, y);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else if (pyjslib.bool(pyjslib.eq(type, String('mousemove')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onMouseMove(sender, x, y);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else if (pyjslib.bool(pyjslib.eq(type, String('mouseover')))) {
		from_element = pyjamas.ui.MouseListener.DOM.eventGetFromElement(event);
		if (pyjslib.bool(!(pyjamas.ui.MouseListener.DOM.isOrHasChild(sender.getElement(), from_element)))) {
			var __listener = listeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					listener.onMouseEnter(sender);
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
		}
	}
	else if (pyjslib.bool(pyjslib.eq(type, String('mouseout')))) {
		to_element = pyjamas.ui.MouseListener.DOM.eventGetToElement(event);
		if (pyjslib.bool(!(pyjamas.ui.MouseListener.DOM.isOrHasChild(sender.getElement(), to_element)))) {
			var __listener = listeners.__iter__();
			try {
				while (true) {
					var listener = __listener.next();
					
					listener.onMouseLeave(sender);
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
		}
	}
	return null;
};
pyjamas.ui.MouseListener.fireMouseEvent.__name__ = 'fireMouseEvent';

pyjamas.ui.MouseListener.fireMouseEvent.__bind_type__ = 0;
pyjamas.ui.MouseListener.fireMouseEvent.__args__ = [null,null,'listeners', 'sender', 'event'];
return this;
}; /* end pyjamas.ui.MouseListener */
$pyjs.modules_hash['pyjamas.ui.MouseListener'] = $pyjs.loaded_modules['pyjamas.ui.MouseListener'];


 /* end module: pyjamas.ui.MouseListener */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas']
*/
