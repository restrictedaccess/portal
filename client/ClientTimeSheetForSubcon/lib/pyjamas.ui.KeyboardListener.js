/* start module: pyjamas.ui.KeyboardListener */
pyjamas.ui.KeyboardListener = $pyjs.loaded_modules["pyjamas.ui.KeyboardListener"] = function (__mod_name__) {
if(pyjamas.ui.KeyboardListener.__was_initialized__) return pyjamas.ui.KeyboardListener;
pyjamas.ui.KeyboardListener.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.KeyboardListener';
var __name__ = pyjamas.ui.KeyboardListener.__name__ = __mod_name__;
var KeyboardListener = pyjamas.ui.KeyboardListener;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.KeyboardListener');
pyjamas.ui.KeyboardListener.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjamas.ui.KeyboardListener.KEY_ALT = 18;
pyjamas.ui.KeyboardListener.KEY_BACKSPACE = 8;
pyjamas.ui.KeyboardListener.KEY_CTRL = 17;
pyjamas.ui.KeyboardListener.KEY_DELETE = 46;
pyjamas.ui.KeyboardListener.KEY_DOWN = 40;
pyjamas.ui.KeyboardListener.KEY_END = 35;
pyjamas.ui.KeyboardListener.KEY_ENTER = 13;
pyjamas.ui.KeyboardListener.KEY_ESCAPE = 27;
pyjamas.ui.KeyboardListener.KEY_HOME = 36;
pyjamas.ui.KeyboardListener.KEY_LEFT = 37;
pyjamas.ui.KeyboardListener.KEY_PAGEDOWN = 34;
pyjamas.ui.KeyboardListener.KEY_PAGEUP = 33;
pyjamas.ui.KeyboardListener.KEY_RIGHT = 39;
pyjamas.ui.KeyboardListener.KEY_SHIFT = 16;
pyjamas.ui.KeyboardListener.KEY_TAB = 9;
pyjamas.ui.KeyboardListener.KEY_UP = 38;
pyjamas.ui.KeyboardListener.MODIFIER_ALT = 4;
pyjamas.ui.KeyboardListener.MODIFIER_CTRL = 2;
pyjamas.ui.KeyboardListener.MODIFIER_SHIFT = 1;
pyjamas.ui.KeyboardListener.getKeyboardModifiers = function(event) {
	var shift,alt,ctrl;
	shift = 0;
	ctrl = 0;
	alt = 0;
	if (pyjslib.bool(pyjamas.ui.KeyboardListener.DOM.eventGetShiftKey(event))) {
		shift = pyjamas.ui.KeyboardListener.MODIFIER_SHIFT;
	}
	if (pyjslib.bool(pyjamas.ui.KeyboardListener.DOM.eventGetCtrlKey(event))) {
		ctrl = pyjamas.ui.KeyboardListener.MODIFIER_CTRL;
	}
	if (pyjslib.bool(pyjamas.ui.KeyboardListener.DOM.eventGetAltKey(event))) {
		alt = pyjamas.ui.KeyboardListener.MODIFIER_ALT;
	}
	return ((shift | ctrl | alt));
};
pyjamas.ui.KeyboardListener.getKeyboardModifiers.__name__ = 'getKeyboardModifiers';

pyjamas.ui.KeyboardListener.getKeyboardModifiers.__bind_type__ = 0;
pyjamas.ui.KeyboardListener.getKeyboardModifiers.__args__ = [null,null,'event'];
pyjamas.ui.KeyboardListener.fireKeyboardEvent = function(listeners, sender, event) {
	var modifiers,listener,type,keycode;
	modifiers = pyjamas.ui.KeyboardListener.getKeyboardModifiers(event);
	keycode = pyjamas.ui.KeyboardListener.DOM.eventGetKeyCode(event);
	type = pyjamas.ui.KeyboardListener.DOM.eventGetType(event);
	if (pyjslib.bool(pyjslib.eq(type, String('keydown')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onKeyDown(sender, keycode, modifiers);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else if (pyjslib.bool(pyjslib.eq(type, String('keyup')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onKeyUp(sender, keycode, modifiers);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else if (pyjslib.bool(pyjslib.eq(type, String('keypress')))) {
		var __listener = listeners.__iter__();
		try {
			while (true) {
				var listener = __listener.next();
				
				listener.onKeyPress(sender, keycode, modifiers);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	return null;
};
pyjamas.ui.KeyboardListener.fireKeyboardEvent.__name__ = 'fireKeyboardEvent';

pyjamas.ui.KeyboardListener.fireKeyboardEvent.__bind_type__ = 0;
pyjamas.ui.KeyboardListener.fireKeyboardEvent.__args__ = [null,null,'listeners', 'sender', 'event'];
return this;
}; /* end pyjamas.ui.KeyboardListener */
$pyjs.modules_hash['pyjamas.ui.KeyboardListener'] = $pyjs.loaded_modules['pyjamas.ui.KeyboardListener'];


 /* end module: pyjamas.ui.KeyboardListener */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas']
*/
