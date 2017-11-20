/* start module: pyjamas.Timer */
pyjamas.Timer = $pyjs.loaded_modules["pyjamas.Timer"] = function (__mod_name__) {
if(pyjamas.Timer.__was_initialized__) return pyjamas.Timer;
pyjamas.Timer.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.Timer';
var __name__ = pyjamas.Timer.__name__ = __mod_name__;
var Timer = pyjamas.Timer;

pyjslib.__import__(['pyjamas.sys', 'sys'], 'sys', 'pyjamas.Timer');
pyjamas.Timer.sys = $pyjs.__modules__.sys;
pyjamas.Timer.timeout_add = null;
pyjamas.Timer.timeout_end = null;
if (pyjslib.bool(!new pyjslib.List([String('mozilla'), String('ie6'), String('opera'), String('oldmoz'), String('safari')]).__contains__((typeof pyjamas.Timer.sys.platform == 'function' && pyjamas.Timer.sys.__is_instance__?pyjslib.getattr(pyjamas.Timer.sys, 'platform'):pyjamas.Timer.sys.platform)))) {
	pyjslib.__import__(['pyjamas.gobject.timeout_add', 'pyjamas.gobject', 'gobject.timeout_add', 'gobject'], 'gobject.timeout_add', 'pyjamas.Timer');
	pyjamas.Timer.timeout_add = $pyjs.__modules__.gobject.timeout_add;
	pyjslib.__import__(['pyjamas.pyjd', 'pyjd'], 'pyjd', 'pyjamas.Timer');
	pyjamas.Timer.pyjd = $pyjs.__modules__.pyjd;
}
pyjamas.Timer.timers = null;
pyjamas.Timer.set_timer = function(interval, fn) {

 	return null;
};
pyjamas.Timer.set_timer.__name__ = 'set_timer';

pyjamas.Timer.set_timer.__bind_type__ = 0;
pyjamas.Timer.set_timer.__args__ = [null,null,'interval', 'fn'];
pyjamas.Timer.kill_timer = function(timer) {

 	return null;
};
pyjamas.Timer.kill_timer.__name__ = 'kill_timer';

pyjamas.Timer.kill_timer.__bind_type__ = 0;
pyjamas.Timer.kill_timer.__args__ = [null,null,'timer'];
pyjamas.Timer.init = function() {

	pyjamas.Timer.timers = new pyjslib.List([]);
	return null;
};
pyjamas.Timer.init.__name__ = 'init';

pyjamas.Timer.init.__bind_type__ = 0;
pyjamas.Timer.init.__args__ = [null,null];
pyjamas.Timer.init();
pyjamas.Timer.Timer = (function(){
	var cls_instance = pyjs__class_instance('Timer');
	var cls_definition = new Object();
	cls_definition.__md5__ = '0096ef651820085ed9e27fb6e2d72457';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(delay, object) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			delay = arguments[1];
			object = arguments[2];
		}
		if (typeof delay == 'undefined') delay=0;
		if (typeof object == 'undefined') object=null;

		self.isRepeating = false;
		self.timerId = 0;
		self.listener = object;
		if (pyjslib.bool((pyjslib.cmp(delay, (typeof pyjamas.Timer.Timer.MIN_PERIOD == 'function' && pyjamas.Timer.Timer.__is_instance__?pyjslib.getattr(pyjamas.Timer.Timer, 'MIN_PERIOD'):pyjamas.Timer.Timer.MIN_PERIOD)) != -1))) {
			self.schedule(delay);
		}
		return null;
	}
	, 1, [null,null,'self', 'delay', 'object']);
	cls_definition.clearInterval = pyjs__bind_method(cls_instance, 'clearInterval', function(id) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			id = arguments[1];
		}


        $wnd.clearInterval(id);
        
	}
	, 1, [null,null,'self', 'id']);
	cls_definition.clearTimeout = pyjs__bind_method(cls_instance, 'clearTimeout', function(id) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			id = arguments[1];
		}


        $wnd.clearTimeout(id);
        
	}
	, 1, [null,null,'self', 'id']);
	cls_definition.createInterval = pyjs__bind_method(cls_instance, 'createInterval', function(timer, period) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			timer = arguments[1];
			period = arguments[2];
		}


        return $wnd.setInterval(function() { timer.fire(); }, period);
        
	}
	, 1, [null,null,'self', 'timer', 'period']);
	cls_definition.createTimeout = pyjs__bind_method(cls_instance, 'createTimeout', function(timer, delay) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			timer = arguments[1];
			delay = arguments[2];
		}


        return $wnd.setTimeout(function() { timer.fire(); }, delay);
        
	}
	, 1, [null,null,'self', 'timer', 'delay']);
	cls_definition.hookWindowClosing = pyjs__bind_method(cls_instance, 'hookWindowClosing', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

 		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.notify = pyjs__bind_method(cls_instance, 'notify', function() {
		if (this.__is_instance__ === true) {
			var self = this;
			var args = new Array();
			for (var pyjs__va_arg = 0; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				args.push(pyjs__arg);
			}
			args = pyjslib.Tuple(args);

		} else {
			var self = arguments[0];
			var args = new Array();
			for (var pyjs__va_arg = 1; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				args.push(pyjs__arg);
			}
			args = pyjslib.Tuple(args);

		}

		pyjs_kwargs_call(self, '_notify', args, null, [{}]);
		return null;
	}
	, 1, ['args',null,'self']);
	cls_definition._notify = pyjs__bind_method(cls_instance, '_notify', function() {
		if (this.__is_instance__ === true) {
			var self = this;
			var args = new Array();
			for (var pyjs__va_arg = 0; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				args.push(pyjs__arg);
			}
			args = pyjslib.Tuple(args);

		} else {
			var self = arguments[0];
			var args = new Array();
			for (var pyjs__va_arg = 1; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				args.push(pyjs__arg);
			}
			args = pyjslib.Tuple(args);

		}

		if (pyjslib.bool(!((typeof self.notify_fn == 'function' && self.__is_instance__?pyjslib.getattr(self, 'notify_fn'):self.notify_fn)))) {
			return false;
		}
		if (pyjslib.bool(pyjslib.eq((typeof self.notify_fn.func_code.co_argcount == 'function' && self.notify_fn.func_code.__is_instance__?pyjslib.getattr(self.notify_fn.func_code, 'co_argcount'):self.notify_fn.func_code.co_argcount), 2))) {
			self.notify_fn((typeof self.timer_id == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timer_id'):self.timer_id));
		}
		else {
			self.notify_fn();
		}
		return false;
	}
	, 1, ['args',null,'self']);
	cls_definition.cancel = pyjs__bind_method(cls_instance, 'cancel', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((typeof self.isRepeating == 'function' && self.__is_instance__?pyjslib.getattr(self, 'isRepeating'):self.isRepeating))) {
			self.clearInterval((typeof self.timerId == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timerId'):self.timerId));
		}
		else {
			self.clearTimeout((typeof self.timerId == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timerId'):self.timerId));
		}
		if (pyjslib.bool(pyjamas.Timer.timers.__contains__(self))) {
			pyjamas.Timer.timers.remove(self);
		}
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.run = pyjs__bind_method(cls_instance, 'run', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.listener.onTimer((typeof self.timerId == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timerId'):self.timerId));
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.schedule = pyjs__bind_method(cls_instance, 'schedule', function(delayMillis) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			delayMillis = arguments[1];
		}

		if (pyjslib.bool((pyjslib.cmp(delayMillis, (typeof pyjamas.Timer.Timer.MIN_PERIOD == 'function' && pyjamas.Timer.Timer.__is_instance__?pyjslib.getattr(pyjamas.Timer.Timer, 'MIN_PERIOD'):pyjamas.Timer.Timer.MIN_PERIOD)) == -1))) {
			pyjamas.Timer.alert(String('Timer delay must be positive'));
		}
		if (pyjslib.bool(pyjamas.Timer.timers.__contains__(self))) {
			self.cancel();
		}
		self.isRepeating = false;
		self.timerId = self.createTimeout(self, delayMillis);
		pyjamas.Timer.timers.append(self);
		return null;
	}
	, 1, [null,null,'self', 'delayMillis']);
	cls_definition.scheduleRepeating = pyjs__bind_method(cls_instance, 'scheduleRepeating', function(periodMillis) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			periodMillis = arguments[1];
		}

		if (pyjslib.bool((pyjslib.cmp(periodMillis, (typeof pyjamas.Timer.Timer.MIN_PERIOD == 'function' && pyjamas.Timer.Timer.__is_instance__?pyjslib.getattr(pyjamas.Timer.Timer, 'MIN_PERIOD'):pyjamas.Timer.Timer.MIN_PERIOD)) == -1))) {
			pyjamas.Timer.alert(String('Timer period must be positive'));
		}
		if (pyjslib.bool(pyjamas.Timer.timers.__contains__(self))) {
			self.cancel();
		}
		self.isRepeating = true;
		self.timerId = self.createInterval(self, periodMillis);
		pyjamas.Timer.timers.append(self);
		return null;
	}
	, 1, [null,null,'self', 'periodMillis']);
	cls_definition.fire = pyjs__bind_method(cls_instance, 'fire', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.fireImpl();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.fireImpl = pyjs__bind_method(cls_instance, 'fireImpl', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((!((typeof self.isRepeating == 'function' && self.__is_instance__?pyjslib.getattr(self, 'isRepeating'):self.isRepeating))) && (pyjamas.Timer.timers.__contains__(self)))) {
			pyjamas.Timer.timers.remove(self);
		}
		self.run();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.getID = pyjs__bind_method(cls_instance, 'getID', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.timerId == 'function' && self.__is_instance__?pyjslib.getattr(self, 'timerId'):self.timerId);
	}
	, 1, [null,null,'self']);
	cls_definition.MIN_PERIOD = 1;
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
return this;
}; /* end pyjamas.Timer */
$pyjs.modules_hash['pyjamas.Timer'] = $pyjs.loaded_modules['pyjamas.Timer'];


 /* end module: pyjamas.Timer */


/*
PYJS_DEPS: ['sys', 'gobject.timeout_add', 'gobject', 'pyjd']
*/
