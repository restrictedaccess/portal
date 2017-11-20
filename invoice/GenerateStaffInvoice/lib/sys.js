/* start module: sys */
var sys = $pyjs.loaded_modules["sys"] = function (__mod_name__) {
if(sys.__was_initialized__) return sys;
sys.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'sys';
var __name__ = sys.__name__ = __mod_name__;
sys.overrides = null;
sys.loadpath = null;
sys.stacktrace = null;
sys.appname = null;
sys.setloadpath = function(lp) {

	sys.loadpath = lp;
	return null;
};
sys.setloadpath.__name__ = 'setloadpath';

sys.setloadpath.__bind_type__ = 0;
sys.setloadpath.__args__ = [null,null,'lp'];
sys.setappname = function(an) {

	sys.appname = an;
	return null;
};
sys.setappname.__name__ = 'setappname';

sys.setappname.__bind_type__ = 0;
sys.setappname.__args__ = [null,null,'an'];
sys.getloadpath = function() {

	return sys.loadpath;
};
sys.getloadpath.__name__ = 'getloadpath';

sys.getloadpath.__bind_type__ = 0;
sys.getloadpath.__args__ = [null,null];
sys.addoverride = function(module_name, path) {

	sys.overrides.__setitem__(module_name, path);
	return null;
};
sys.addoverride.__name__ = 'addoverride';

sys.addoverride.__bind_type__ = 0;
sys.addoverride.__args__ = [null,null,'module_name', 'path'];
sys.exc_info = function() {
	var le,cls;
	le = $pyjs.__last_exception__;
	if (pyjslib.bool(!(le))) {
		return new pyjslib.Tuple([null, null, null]);
	}
	if (pyjslib.bool(!(pyjslib.hasattr((typeof le.error == 'function' && le.__is_instance__?pyjslib.getattr(le, 'error'):le.error), String('__class__'))))) {
		cls = null;
	}
	else {
		cls = (typeof le.error.__class__ == 'function' && le.error.__is_instance__?pyjslib.getattr(le.error, '__class__'):le.error.__class__);
	}
	return new pyjslib.Tuple([cls, (typeof le.error == 'function' && le.__is_instance__?pyjslib.getattr(le, 'error'):le.error), null]);
};
sys.exc_info.__name__ = 'exc_info';

sys.exc_info.__bind_type__ = 0;
sys.exc_info.__args__ = [null,null];
sys.exc_clear = function() {

$pyjs.__last_exception__ = null;
};
sys.exc_clear.__name__ = 'exc_clear';

sys.exc_clear.__bind_type__ = 0;
sys.exc_clear.__args__ = [null,null];
sys.save_exception_stack = function () {
    var save_stack = [];
    for (var needle in $pyjs.trackstack) {
        var t = new Object();
        for (var p in $pyjs.trackstack[needle]) {
            t[p] = $pyjs.trackstack[needle][p];
        }
        save_stack.push(t);
        $pyjs.__last_exception_stack__ = save_stack;
    }
return null;
}
sys.trackstackstr = function(stack) {
	if (typeof stack == 'undefined') stack=null;
	var msg,s,stackstrings;
	if (pyjslib.bool((stack === null))) {
		stack = $pyjs.__last_exception_stack__;
	}
	if (pyjslib.bool(!(stack))) {
		return String('');
	}
	stackstrings = new pyjslib.List([]);
	msg = String('');
	var __s = pyjslib.list(stack).__iter__();
	try {
		while (true) {
			var s = __s.next();
			
msg = eval(s.module + '.__track_lines__[' + s.lineno + ']');
			if (pyjslib.bool(msg)) {
				stackstrings.append(msg);
			}
			else {
				stackstrings.append(pyjslib.sprintf(String('%s.py, line %d'), new pyjslib.Tuple([(typeof s.module == 'function' && s.__is_instance__?pyjslib.getattr(s, 'module'):s.module), (typeof s.lineno == 'function' && s.__is_instance__?pyjslib.getattr(s, 'lineno'):s.lineno)])));
			}
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return String('\x0A').join(stackstrings);
};
sys.trackstackstr.__name__ = 'trackstackstr';

sys.trackstackstr.__bind_type__ = 0;
sys.trackstackstr.__args__ = [null,null,'stack'];
sys.platform = $pyjs.platform;
sys.byteorder = String('little');
return this;
}; /* end sys */
$pyjs.modules_hash['sys'] = $pyjs.loaded_modules['sys'];


 /* end module: sys */


