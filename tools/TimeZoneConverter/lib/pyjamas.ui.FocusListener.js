/* start module: pyjamas.ui.FocusListener */
pyjamas.ui.FocusListener = $pyjs.loaded_modules["pyjamas.ui.FocusListener"] = function (__mod_name__) {
if(pyjamas.ui.FocusListener.__was_initialized__) return pyjamas.ui.FocusListener;
pyjamas.ui.FocusListener.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.FocusListener';
var __name__ = pyjamas.ui.FocusListener.__name__ = __mod_name__;
var FocusListener = pyjamas.ui.FocusListener;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.FocusListener');
pyjamas.ui.FocusListener.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjamas.ui.FocusListener.fireFocusEvent = function(listeners, sender, event) {
	var listener,type;
	type = pyjamas.ui.FocusListener.DOM.eventGetType(event);
	if (pyjslib.bool(pyjslib.eq(type, String('focus')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onFocus(sender);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else if (pyjslib.bool(pyjslib.eq(type, String('blur')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onLostFocus(sender);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	return null;
};
pyjamas.ui.FocusListener.fireFocusEvent.__name__ = 'fireFocusEvent';

pyjamas.ui.FocusListener.fireFocusEvent.__bind_type__ = 0;
pyjamas.ui.FocusListener.fireFocusEvent.__args__ = [null,null,'listeners', 'sender', 'event'];
return this;
}; /* end pyjamas.ui.FocusListener */
$pyjs.modules_hash['pyjamas.ui.FocusListener'] = $pyjs.loaded_modules['pyjamas.ui.FocusListener'];


 /* end module: pyjamas.ui.FocusListener */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas']
*/
