/* start module: pyjslib */
var pyjslib = $pyjs.loaded_modules["pyjslib"] = function (__mod_name__) {
if(pyjslib.__was_initialized__) return pyjslib;
pyjslib.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjslib';
var __name__ = pyjslib.__name__ = __mod_name__;
pyjslib.object = (function(){
	var cls_instance = pyjs__class_instance('object');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'd3dba22d06267294aa8ed4fd1efaad06';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array());
})();
pyjslib.__import__ = function(searchList, path, context, module_name) {
	if (typeof module_name == 'undefined') module_name=null;
	var available,importName,err,temp_i,mod_path,found,i,m,l,module,name,parts,pyjs_try_err,save_track_module;
	available = $pyjs.available_modules_dict;
	if (pyjslib.bool(pyjslib.isUndefined(available))) {
		available = new pyjslib.Dict([]);
		var __m = pyjslib.list($pyjs.available_modules).__iter__();
		try {
			while (true) {
				var m = __m.next();
				
				available.__setitem__(m, false);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
$pyjs.available_modules_dict = available;
	}
	searchList = pyjslib.list(searchList);
	found = false;
	var __mod_path = searchList.__iter__();
	try {
		while (true) {
			var mod_path = __mod_path.next();
			
			if (pyjslib.bool(available.__contains__(mod_path))) {
				found = true;
				break;
			}
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	if (pyjslib.bool(!(found))) {
		throw (pyjslib.ImportError( (  (  (  ( String('No module named ') + path )  + String(' (context=') )  + context )  + String(')') ) ));
	}
	module = null;
	try {
		module = $pyjs.loaded_modules[mod_path];
		if (pyjslib.bool(typeof module.__was_initialized__ != 'undefined')) {
			return null;
		}
	} catch(pyjs_try_err) {
		var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
		$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjslib, try_lineno: 75};
		{
			$pyjs.__last_exception__.except_lineno = 80;
			err = pyjs_try_err;
		} 	}
	save_track_module = $pyjs.track.module;
	importName = String('');
	parts = mod_path.split(String('.'));
	l = pyjslib.len(parts);
	var __temp_i = pyjslib.enumerate(parts).__iter__();
	try {
		while (true) {
			var temp_i = __temp_i.next();
				var i = temp_i.__getitem__(0);	var name = temp_i.__getitem__(1);
			importName += name;
module = $pyjs.loaded_modules[importName];
			if (pyjslib.bool(typeof module == 'undefined')) {
				throw (pyjslib.ImportError( (  (  (  (  ( String('No module named ') + importName )  + String(', ') )  + path )  + String(' in context ') )  + context ) ));
			}
			if (pyjslib.bool(pyjslib.eq(i, 0))) {
$pyjs.__modules__[importName] = module;
			}
			if (pyjslib.bool(pyjslib.eq(l,  ( i + 1 ) ))) {
				module(module_name);
			}
			else {
				module(null);
			}
			importName += String('.');
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
$pyjs.track.module = save_track_module;
};
pyjslib.__import__.__name__ = '__import__';

pyjslib.__import__.__bind_type__ = 0;
pyjslib.__import__.__args__ = [null,null,'searchList', 'path', 'context', 'module_name'];
pyjslib.load_module = function(path, parent_module, module_name, dynamic, async) {
	if (typeof dynamic == 'undefined') dynamic=1;
	if (typeof async == 'undefined') async=false;


        var cache_file;
        var module = $pyjs.modules_hash[module_name];
        if (typeof module == 'function') {
            return true;
        }

        if (!dynamic) {
            // There's no way we can load a none dynamic module
            return false;
        }

        if (path == null)
        {
            path = './';
        }

        var override_name = sys.platform + "." + module_name;
        if (((sys.overrides != null) &&
             (sys.overrides.has_key(override_name))))
        {
            cache_file =  sys.overrides.__getitem__(override_name) ;
        }
        else
        {
            cache_file =  module_name ;
        }

        cache_file = (path + cache_file + '.cache.js' ) ;

        //alert("cache " + cache_file + " " + module_name + " " + parent_module);

        onload_fn = '';

        // this one tacks the script onto the end of the DOM
        pyjs_load_script(cache_file, onload_fn, async);

        try {
            loaded = (typeof $pyjs.modules_hash[module_name] == 'function');
        } catch ( e ) {
        }
        if (loaded) {
            return true;
        }
        return false;
    
};
pyjslib.load_module.__name__ = 'load_module';

pyjslib.load_module.__bind_type__ = 0;
pyjslib.load_module.__args__ = [null,null,'path', 'parent_module', 'module_name', 'dynamic', 'async'];
pyjslib.load_module_wait = function(proceed_fn, parent_mod, module_list, dynamic) {

	module_list = module_list.getArray();

    var wait_count = 0;
    var timeoutperiod = 1;
    if (dynamic)
        var timeoutperiod = 1;

    var wait = function() {
        wait_count++;
        //write_dom(".");
        var loaded = true;
        for (var i in module_list) {
            if (typeof $pyjs.modules_hash[module_list[i]] != 'function') {
                loaded = false;
                break;
            }
        }
        if (!loaded) {
            setTimeout(wait, timeoutperiod);
        } else {
            if (proceed_fn.importDone)
                proceed_fn.importDone(proceed_fn);
            else
                proceed_fn();
            //$doc.body.removeChild(element);
        }
    };
    wait();

};
pyjslib.load_module_wait.__name__ = 'load_module_wait';

pyjslib.load_module_wait.__bind_type__ = 0;
pyjslib.load_module_wait.__args__ = [null,null,'proceed_fn', 'parent_mod', 'module_list', 'dynamic'];
pyjslib.Modload = (function(){
	var cls_instance = pyjs__class_instance('Modload');
	var cls_definition = new Object();
	cls_definition.__md5__ = '008a15ebcd1aa61ea5f3fd5abe9c6b1d';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(path, app_modlist, app_imported_fn, dynamic, parent_mod) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			path = arguments[1];
			app_modlist = arguments[2];
			app_imported_fn = arguments[3];
			dynamic = arguments[4];
			parent_mod = arguments[5];
		}
		var depth,mod,modlist;
		self.app_modlist = app_modlist;
		self.app_imported_fn = app_imported_fn;
		self.path = path;
		self.dynamic = dynamic;
		self.parent_mod = parent_mod;
		self.modules = new pyjslib.Dict([]);
		var __modlist = self.app_modlist.__iter__();
		try {
			while (true) {
				var modlist = __modlist.next();
				
				var __mod = modlist.__iter__();
				try {
					while (true) {
						var mod = __mod.next();
						
						depth = pyjslib.len(mod.split(String('.')));
						if (pyjslib.bool(!(self.modules.has_key(depth)))) {
							(typeof self.modules == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modules'):self.modules).__setitem__(depth, new pyjslib.List([]));
						}
						(typeof self.modules == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modules'):self.modules).__getitem__(depth).append(mod);
					}
				} catch (e) {
					if (e.__name__ != 'StopIteration') {
						throw e;
					}
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		self.depths = self.modules.keys();
		self.depths.sort();
		self.depths.reverse();
		return null;
	}
	, 1, [null,null,'self', 'path', 'app_modlist', 'app_imported_fn', 'dynamic', 'parent_mod']);
	cls_definition.next = pyjs__bind_method(cls_instance, 'next', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var app,depth;
		if (pyjslib.bool(!((typeof self.dynamic == 'function' && self.__is_instance__?pyjslib.getattr(self, 'dynamic'):self.dynamic)))) {
			self.app_imported_fn();
			return null;
		}
		depth = self.depths.pop();
		var __app = (typeof self.modules == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modules'):self.modules).__getitem__(depth).__iter__();
		try {
			while (true) {
				var app = __app.next();
				
				pyjslib.load_module((typeof self.path == 'function' && self.__is_instance__?pyjslib.getattr(self, 'path'):self.path), (typeof self.parent_mod == 'function' && self.__is_instance__?pyjslib.getattr(self, 'parent_mod'):self.parent_mod), app, (typeof self.dynamic == 'function' && self.__is_instance__?pyjslib.getattr(self, 'dynamic'):self.dynamic), true);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		if (pyjslib.bool(pyjslib.eq(pyjslib.len((typeof self.depths == 'function' && self.__is_instance__?pyjslib.getattr(self, 'depths'):self.depths)), 0))) {
			pyjslib.load_module_wait((typeof self.app_imported_fn == 'function' && self.__is_instance__?pyjslib.getattr(self, 'app_imported_fn'):self.app_imported_fn), (typeof self.parent_mod == 'function' && self.__is_instance__?pyjslib.getattr(self, 'parent_mod'):self.parent_mod), (typeof self.modules == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modules'):self.modules).__getitem__(depth), (typeof self.dynamic == 'function' && self.__is_instance__?pyjslib.getattr(self, 'dynamic'):self.dynamic));
		}
		else {
			pyjslib.load_module_wait(pyjslib.getattr(self, String('next')), (typeof self.parent_mod == 'function' && self.__is_instance__?pyjslib.getattr(self, 'parent_mod'):self.parent_mod), (typeof self.modules == 'function' && self.__is_instance__?pyjslib.getattr(self, 'modules'):self.modules).__getitem__(depth), (typeof self.dynamic == 'function' && self.__is_instance__?pyjslib.getattr(self, 'dynamic'):self.dynamic));
		}
		return null;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjslib.get_module = function(module_name) {
	var ev;
	ev = pyjslib.sprintf(String('__mod = %s\x3B'), module_name);
pyjs_eval(ev);
	return pyjslib.__mod;
};
pyjslib.get_module.__name__ = 'get_module';

pyjslib.get_module.__bind_type__ = 0;
pyjslib.get_module.__args__ = [null,null,'module_name'];
pyjslib.preload_app_modules = function(path, app_modnames, app_imported_fn, dynamic, parent_mod) {
	if (typeof parent_mod == 'undefined') parent_mod=null;
	var loader;
	loader = pyjslib.Modload(path, app_modnames, app_imported_fn, dynamic, parent_mod);
	loader.next();
	return null;
};
pyjslib.preload_app_modules.__name__ = 'preload_app_modules';

pyjslib.preload_app_modules.__bind_type__ = 0;
pyjslib.preload_app_modules.__args__ = [null,null,'path', 'app_modnames', 'app_imported_fn', 'dynamic', 'parent_mod'];
pyjslib.BaseException = (function(){
	var cls_instance = pyjs__class_instance('BaseException');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'f1d727002fa12d6dd2e8d09d79693975';
	cls_definition.message = String('');
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
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

		self.args = args;
		if (pyjslib.bool(pyjslib.eq(pyjslib.len(args), 1))) {
			self.message = args.__getitem__(0);
		}
		return null;
	}
	, 1, ['args',null,'self']);
	cls_definition.__getitem__ = pyjs__bind_method(cls_instance, '__getitem__', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

		return self.args.__getitem__(index);
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.__str__ = pyjs__bind_method(cls_instance, '__str__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((pyjslib.len((typeof self.args == 'function' && self.__is_instance__?pyjslib.getattr(self, 'args'):self.args)) === 0))) {
			return String('');
		}
		else if (pyjslib.bool((pyjslib.len((typeof self.args == 'function' && self.__is_instance__?pyjslib.getattr(self, 'args'):self.args)) === 1))) {
			return pyjslib.str((typeof self.message == 'function' && self.__is_instance__?pyjslib.getattr(self, 'message'):self.message));
		}
		return pyjslib.repr((typeof self.args == 'function' && self.__is_instance__?pyjslib.getattr(self, 'args'):self.args));
	}
	, 1, [null,null,'self']);
	cls_definition.__repr__ = pyjs__bind_method(cls_instance, '__repr__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return  ( (typeof self.__name__ == 'function' && self.__is_instance__?pyjslib.getattr(self, '__name__'):self.__name__) + pyjslib.repr((typeof self.args == 'function' && self.__is_instance__?pyjslib.getattr(self, 'args'):self.args)) ) ;
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjslib.Exception = (function(){
	var cls_instance = pyjs__class_instance('Exception');
	var cls_definition = new Object();
	cls_definition.__md5__ = '9508f85d2f22b22663319149c9964f06';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.BaseException));
})();
pyjslib.StandardError = (function(){
	var cls_instance = pyjs__class_instance('StandardError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '213b930f4906fde5d906fa662003b3c2';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.Exception));
})();
pyjslib.TypeError = (function(){
	var cls_instance = pyjs__class_instance('TypeError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '89693a26cd50bcd20fcf9c303b63dce0';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.StandardError));
})();
pyjslib.AttributeError = (function(){
	var cls_instance = pyjs__class_instance('AttributeError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '93d988c4d421ef5b62c9846e29d99ed5';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.StandardError));
})();
pyjslib.NameError = (function(){
	var cls_instance = pyjs__class_instance('NameError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '300907dcbb08b00428dd22a96a858802';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.StandardError));
})();
pyjslib.ValueError = (function(){
	var cls_instance = pyjs__class_instance('ValueError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '7493284ae4397433bf46f2f42cd1dafb';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.StandardError));
})();
pyjslib.ImportError = (function(){
	var cls_instance = pyjs__class_instance('ImportError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '5307eac7178fc380fad56988ac2736cc';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.StandardError));
})();
pyjslib.LookupError = (function(){
	var cls_instance = pyjs__class_instance('LookupError');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'c21926c80c3c6bb9275cd8d8e799253a';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.StandardError));
})();
pyjslib.RuntimeError = (function(){
	var cls_instance = pyjs__class_instance('RuntimeError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '2617eb57e03a2c46e8e339d9249c055b';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.StandardError));
})();
pyjslib.KeyError = (function(){
	var cls_instance = pyjs__class_instance('KeyError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '5675b861a8ea4c3633be50ae72ce774a';
	cls_definition.__str__ = pyjs__bind_method(cls_instance, '__str__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((pyjslib.len((typeof self.args == 'function' && self.__is_instance__?pyjslib.getattr(self, 'args'):self.args)) === 0))) {
			return String('');
		}
		else if (pyjslib.bool((pyjslib.len((typeof self.args == 'function' && self.__is_instance__?pyjslib.getattr(self, 'args'):self.args)) === 1))) {
			return pyjslib.repr((typeof self.message == 'function' && self.__is_instance__?pyjslib.getattr(self, 'message'):self.message));
		}
		return pyjslib.repr((typeof self.args == 'function' && self.__is_instance__?pyjslib.getattr(self, 'args'):self.args));
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.LookupError));
})();
pyjslib.IndexError = (function(){
	var cls_instance = pyjs__class_instance('IndexError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '30eec223583ad344b0f3f54815aad98d';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.LookupError));
})();
pyjslib.NotImplementedError = (function(){
	var cls_instance = pyjs__class_instance('NotImplementedError');
	var cls_definition = new Object();
	cls_definition.__md5__ = '463326706eddf9c8b49cb5fdb56595c8';
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.RuntimeError));
})();
pyjslib.init = function() {


pyjslib._errorMapping = function(err) {
    if (err instanceof(ReferenceError) || err instanceof(TypeError)) {
        var message = '';
        try {
            message = err.message;
        } catch ( e) {
        }
        return pyjslib.AttributeError(message);
    }
    return err;
};

pyjslib.TryElse = function () { };
pyjslib.TryElse.prototype = new Error();
pyjslib.TryElse.__name__ = 'TryElse';
pyjslib.TryElse.message = 'TryElse';

pyjslib.StopIteration = function () { };
pyjslib.StopIteration.prototype = new Error();
pyjslib.StopIteration.__name__ = 'StopIteration';
pyjslib.StopIteration.message = 'StopIteration';

pyjslib.String_find = function(sub, start, end) {
    var pos=this.indexOf(sub, start);
    if (pyjslib.isUndefined(end)) return pos;

    if (pos + sub.length>end) return -1;
    return pos;
};

pyjslib.String_join = function(data) {
    var text="";

    if (data.constructor == Array) {
        return data.join(this);
    }
    else if (data.prototype.__md5__ == pyjslib.List.prototype.__md5__) {
        return data.l.join(this);
    }
    else if (pyjslib.isIteratable(data)) {
        var iter=data.__iter__();
        try {
            text+=iter.next();
            while (true) {
                var item=iter.next();
                text+=this + item;
            }
        }
        catch (e) {
            if (e.__name__ != 'StopIteration') throw e;
        }
    }

    return text;
};

pyjslib.String_isdigit = function() {
    return (this.match(/^\d+$/g) != null);
};

pyjslib.String_replace = function(old, replace, count) {
    var do_max=false;
    var start=0;
    var new_str="";
    var pos=0;

    if (!pyjslib.isString(old)) return this.__replace(old, replace);
    if (!pyjslib.isUndefined(count)) do_max=true;

    while (start<this.length) {
        if (do_max && !count--) break;

        pos=this.indexOf(old, start);
        if (pos<0) break;

        new_str+=this.substring(start, pos) + replace;
        start=pos+old.length;
    }
    if (start<this.length) new_str+=this.substring(start);

    return new_str;
};

pyjslib.String___contains__ = function(s){
    return this.indexOf(s)>=0;
};

pyjslib.String_split = function(sep, maxsplit) {
    var items=new pyjslib.List();
    var do_max=false;
    var subject=this;
    var start=0;
    var pos=0;

    if (pyjslib.isUndefined(sep) || pyjslib.isNull(sep)) {
        sep=" ";
        subject=subject.strip();
        subject=subject.replace(/\s+/g, sep);
    }
    else if (!pyjslib.isUndefined(maxsplit)) do_max=true;

    if (subject.length == 0) {
        return items;
    }

    while (start<subject.length) {
        if (do_max && !maxsplit--) break;

        pos=subject.indexOf(sep, start);
        if (pos<0) break;

        items.append(subject.substring(start, pos));
        start=pos+sep.length;
    }
    if (start<=subject.length) items.append(subject.substring(start));

    return items;
};

pyjslib.String___iter__ = function() {
    var i = 0;
    var s = this;
    return {
        'next': function() {
            if (i >= s.length) {
                throw pyjslib.StopIteration;
            }
            return s.substring(i++, i, 1);
        },
        '__iter__': function() {
            return this;
        }
    };
};

pyjslib.String_strip = function(chars) {
    return this.lstrip(chars).rstrip(chars);
};

pyjslib.String_lstrip = function(chars) {
    if (pyjslib.isUndefined(chars)) return this.replace(/^\s+/, "");
    if (chars.length == 0) return this;
    return this.replace(new RegExp("^[" + chars + "]+"), "");
};

pyjslib.String_rstrip = function(chars) {
    if (pyjslib.isUndefined(chars)) return this.replace(/\s+$/, "");
    if (chars.length == 0) return this;
    return this.replace(new RegExp("[" + chars + "]+$"), "");
};

pyjslib.String_startswith = function(prefix, start, end) {
    // FIXME: accept tuples as suffix (since 2.5)
    if (pyjslib.isUndefined(start)) start = 0;
    if (pyjslib.isUndefined(end)) end = this.length;

    if ((end - start) < prefix.length) return false;
    if (this.substr(start, prefix.length) == prefix) return true;
    return false;
};

pyjslib.String_endswith = function(suffix, start, end) {
    // FIXME: accept tuples as suffix (since 2.5)
    if (pyjslib.isUndefined(start)) start = 0;
    if (pyjslib.isUndefined(end)) end = this.length;

    if ((end - start) < suffix.length) return false;
    if (this.substr(end - suffix.length, suffix.length) == suffix) return true;
    return false;
};

pyjslib.String_ljust = function(width, fillchar) {
    if (typeof(width) != 'number' ||
        parseInt(width) != width) {
        throw (pyjslib.TypeError("an integer is required"));
    }
    if (pyjslib.isUndefined(fillchar)) fillchar = ' ';
    if (typeof(fillchar) != 'string' ||
        fillchar.length != 1) {
        throw (pyjslib.TypeError("ljust() argument 2 must be char, not " + typeof(fillchar)));
    }
    if (this.length >= width) return this;
    return this + new Array(width+1 - this.length).join(fillchar);
};

pyjslib.String_rjust = function(width, fillchar) {
    if (typeof(width) != 'number' ||
        parseInt(width) != width) {
        throw (pyjslib.TypeError("an integer is required"));
    }
    if (pyjslib.isUndefined(fillchar)) fillchar = ' ';
    if (typeof(fillchar) != 'string' ||
        fillchar.length != 1) {
        throw (pyjslib.TypeError("rjust() argument 2 must be char, not " + typeof(fillchar)));
    }
    if (this.length >= width) return this;
    return new Array(width + 1 - this.length).join(fillchar) + this;
};

pyjslib.String_center = function(width, fillchar) {
    if (typeof(width) != 'number' ||
        parseInt(width) != width) {
        throw (pyjslib.TypeError("an integer is required"));
    }
    if (pyjslib.isUndefined(fillchar)) fillchar = ' ';
    if (typeof(fillchar) != 'string' ||
        fillchar.length != 1) {
        throw (pyjslib.TypeError("center() argument 2 must be char, not " + typeof(fillchar)));
    }
    if (this.length >= width) return this;
    padlen = width - this.length;
    right = Math.ceil(padlen / 2);
    left = padlen - right;
    return new Array(left+1).join(fillchar) + this + new Array(right+1).join(fillchar);
};

pyjslib.String___getitem__ = function(idx) {
    if (idx < 0) idx += this.length;
    if (idx < 0 || idx > this.length) {
        throw(pyjslib.IndexError("string index out of range"));
    }
    return this.charAt(idx);
};

pyjslib.abs = Math.abs;

String.prototype.__getitem__ = pyjslib.String___getitem__;
String.prototype.upper = String.prototype.toUpperCase;
String.prototype.lower = String.prototype.toLowerCase;
String.prototype.find=pyjslib.String_find;
String.prototype.join=pyjslib.String_join;
String.prototype.isdigit=pyjslib.String_isdigit;
String.prototype.__iter__=pyjslib.String___iter__;
String.prototype.__contains__=pyjslib.String___contains__;

String.prototype.__replace=String.prototype.replace;
String.prototype.replace=pyjslib.String_replace;

String.prototype.split=pyjslib.String_split;
String.prototype.strip=pyjslib.String_strip;
String.prototype.lstrip=pyjslib.String_lstrip;
String.prototype.rstrip=pyjslib.String_rstrip;
String.prototype.startswith=pyjslib.String_startswith;
String.prototype.endswith=pyjslib.String_endswith;
String.prototype.ljust=pyjslib.String_ljust;
String.prototype.rjust=pyjslib.String_rjust;
String.prototype.center=pyjslib.String_center;

var str = String;

};
pyjslib.init.__name__ = 'init';

pyjslib.init.__bind_type__ = 0;
pyjslib.init.__args__ = [null,null];
pyjslib.Class = (function(){
	var cls_instance = pyjs__class_instance('Class');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'fb75ea67a9c76c97a2201e52e795cd50';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(name) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			name = arguments[1];
		}

		self.name_ = name;
		return null;
	}
	, 1, [null,null,'self', 'name']);
	cls_definition.__str___ = pyjs__bind_method(cls_instance, '__str___', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.name_ == 'function' && self.__is_instance__?pyjslib.getattr(self, 'name_'):self.name_);
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjslib.eq = function(a, b) {


    if (a === null) {
        if (b === null) return true;
        return false;
    }
    if (b === null) {
        return false;
    }
    if ((typeof a == 'object' || typeof a == 'function') && typeof a.__cmp__ == 'function') {
        return a.__cmp__(b) == 0;
    } else if ((typeof b == 'object' || typeof b == 'function') && typeof b.__cmp__ == 'function') {
        return b.__cmp__(a) == 0;
    }
    return a == b;
    
};
pyjslib.eq.__name__ = 'eq';

pyjslib.eq.__bind_type__ = 0;
pyjslib.eq.__args__ = [null,null,'a', 'b'];
pyjslib.cmp = function(a, b) {


    if (a === null) {
        if (b === null) return 0;
        return -1;
    }
    if (b === null) {
        return 1;
    }
    if ((typeof a == 'object' || typeof a == 'function') && typeof a.__cmp__ == 'function') {
        return a.__cmp__(b);
    } else if ((typeof b == 'object' || typeof b == 'function') && typeof b.__cmp__ == 'function') {
        return -b.__cmp__(a);
    }
    if (a > b) return 1;
    if (b > a) return -1;
    return 0;
    
};
pyjslib.cmp.__name__ = 'cmp';

pyjslib.cmp.__bind_type__ = 0;
pyjslib.cmp.__args__ = [null,null,'a', 'b'];
pyjslib.bool = function(v) {


    if (!v) return false;
    switch(typeof v){
    case 'boolean':
        return v;
    case 'object':
        if (v.__nonzero__){
            return v.__nonzero__();
        }else if (v.__len__){
            return v.__len__()>0;
        }
        return true;
    }
    return Boolean(v);
    
};
pyjslib.bool.__name__ = 'bool';

pyjslib.bool.__bind_type__ = 0;
pyjslib.bool.__args__ = [null,null,'v'];
pyjslib.List = (function(){
	var cls_instance = pyjs__class_instance('List');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'd3cb75a1f509dc1e9f1aeaed88f2f06b';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		if (typeof data == 'undefined') data=null;


        this.l = [];
        this.extend(data);
        
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.append = pyjs__bind_method(cls_instance, 'append', function(item) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			item = arguments[1];
		}

    this.l[this.l.length] = item;
	}
	, 1, [null,null,'self', 'item']);
	cls_definition.extend = pyjs__bind_method(cls_instance, 'extend', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}


        if (pyjslib.isArray(data)) {
            n = this.l.length;
            for (var i=0; i < data.length; i++) {
                this.l[n+i]=data[i];
                }
            }
        else if (pyjslib.isIteratable(data)) {
            var iter=data.__iter__();
            var i=this.l.length;
            try {
                while (true) {
                    var item=iter.next();
                    this.l[i++]=item;
                    }
                }
            catch (e) {
                if (e.__name__ != 'StopIteration') throw e;
                }
            }
        
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.remove = pyjs__bind_method(cls_instance, 'remove', function(value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			value = arguments[1];
		}


        var index=this.index(value);
        if (index<0) return false;
        this.l.splice(index, 1);
        return true;
        
	}
	, 1, [null,null,'self', 'value']);
	cls_definition.index = pyjs__bind_method(cls_instance, 'index', function(value, start) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			value = arguments[1];
			start = arguments[2];
		}
		if (typeof start == 'undefined') start=0;


        var length=this.l.length;
        for (var i=start; i<length; i++) {
            if (this.l[i]==value) {
                return i;
                }
            }
        
		throw (pyjslib.ValueError(String('list.index(x): x not in list')));
		return null;
	}
	, 1, [null,null,'self', 'value', 'start']);
	cls_definition.insert = pyjs__bind_method(cls_instance, 'insert', function(index, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
			value = arguments[2];
		}

    var a = this.l; this.l=a.slice(0, index).concat(value, a.slice(index));
	}
	, 1, [null,null,'self', 'index', 'value']);
	cls_definition.pop = pyjs__bind_method(cls_instance, 'pop', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}
		if (typeof index == 'undefined') index=-1;


        if (index<0) index = this.l.length + index;
        var a = this.l[index];
        this.l.splice(index, 1);
        return a;
        
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.__cmp__ = pyjs__bind_method(cls_instance, '__cmp__', function(l) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			l = arguments[1];
		}
		var x,ll;
		if (pyjslib.bool(!(pyjslib.isinstance(l, pyjslib.List)))) {
			return -1;
		}
		ll =  ( pyjslib.len(self) - pyjslib.len(l) ) ;
		if (pyjslib.bool(!pyjslib.eq(ll, 0))) {
			return ll;
		}
		var __x = pyjslib.range(pyjslib.len(l)).__iter__();
		try {
			while (true) {
				var x = __x.next();
				
				ll = pyjslib.cmp(self.__getitem__(x), l.__getitem__(x));
				if (pyjslib.bool(!pyjslib.eq(ll, 0))) {
					return ll;
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return 0;
	}
	, 1, [null,null,'self', 'l']);
	cls_definition.slice = pyjs__bind_method(cls_instance, 'slice', function(lower, upper) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			lower = arguments[1];
			upper = arguments[2];
		}


        if (upper==null) return pyjslib.List(this.l.slice(lower));
        return pyjslib.List(this.l.slice(lower, upper));
        
	}
	, 1, [null,null,'self', 'lower', 'upper']);
	cls_definition.__getitem__ = pyjs__bind_method(cls_instance, '__getitem__', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}


        if (index<0) index = this.l.length + index;
        return this.l[index];
        
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.__setitem__ = pyjs__bind_method(cls_instance, '__setitem__', function(index, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
			value = arguments[2];
		}

    this.l[index]=value;
	}
	, 1, [null,null,'self', 'index', 'value']);
	cls_definition.__delitem__ = pyjs__bind_method(cls_instance, '__delitem__', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}

    this.l.splice(index, 1);
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.__len__ = pyjs__bind_method(cls_instance, '__len__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

    return this.l.length;
	}
	, 1, [null,null,'self']);
	cls_definition.__contains__ = pyjs__bind_method(cls_instance, '__contains__', function(value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			value = arguments[1];
		}
		var err,pyjs_try_err;
		try {
			self.index(value);
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjslib, try_lineno: 753};
			if (pyjs_try_err_name == pyjslib.ValueError.__name__) {
				$pyjs.__last_exception__.except_lineno = 755;
				err = pyjs_try_err;
				return false;
			} else { throw pyjs_try_err; }
		}
		return true;
	}
	, 1, [null,null,'self', 'value']);
	cls_definition.__iter__ = pyjs__bind_method(cls_instance, '__iter__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var i = 0;
        var l = this.l;
        return {
            'next': function() {
                if (i >= l.length) {
                    throw pyjslib.StopIteration;
                }
                return l[i++];
            },
            '__iter__': function() {
                return this;
            }
        };
        
	}
	, 1, [null,null,'self']);
	cls_definition.reverse = pyjs__bind_method(cls_instance, 'reverse', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

    this.l.reverse();
	}
	, 1, [null,null,'self']);
	cls_definition.sort = pyjs__bind_method(cls_instance, 'sort', function(compareFunc, keyFunc, reverse) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			compareFunc = arguments[1];
			keyFunc = arguments[2];
			reverse = arguments[3];
		}
		if (typeof compareFunc == 'undefined') compareFunc=null;
		if (typeof keyFunc == 'undefined') keyFunc=null;
		if (typeof reverse == 'undefined') reverse=false;
		var thisSort1,thisSort2,thisSort3;
		if (pyjslib.bool(!(compareFunc))) {
			compareFunc = pyjslib.cmp;
		}
		if (pyjslib.bool((keyFunc) && (reverse))) {
			thisSort1 = function(a, b) {

				return -compareFunc(keyFunc(a), keyFunc(b));
			};
			thisSort1.__name__ = 'thisSort1';

			thisSort1.__bind_type__ = 0;
			thisSort1.__args__ = [null,null,'a', 'b'];
			self.l.sort(thisSort1);
		}
		else if (pyjslib.bool(keyFunc)) {
			thisSort2 = function(a, b) {

				return compareFunc(keyFunc(a), keyFunc(b));
			};
			thisSort2.__name__ = 'thisSort2';

			thisSort2.__bind_type__ = 0;
			thisSort2.__args__ = [null,null,'a', 'b'];
			self.l.sort(thisSort2);
		}
		else if (pyjslib.bool(reverse)) {
			thisSort3 = function(a, b) {

				return -compareFunc(a, b);
			};
			thisSort3.__name__ = 'thisSort3';

			thisSort3.__bind_type__ = 0;
			thisSort3.__args__ = [null,null,'a', 'b'];
			self.l.sort(thisSort3);
		}
		else {
			self.l.sort(compareFunc);
		}
		return null;
	}
	, 1, [null,null,'self', 'compareFunc', 'keyFunc', 'reverse']);
	cls_definition.getArray = pyjs__bind_method(cls_instance, 'getArray', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.l == 'function' && self.__is_instance__?pyjslib.getattr(self, 'l'):self.l);
	}
	, 1, [null,null,'self']);
	cls_definition.__str__ = pyjs__bind_method(cls_instance, '__str__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.__repr__();
	}
	, 1, [null,null,'self']);
	cls_definition.__repr__ = pyjs__bind_method(cls_instance, '__repr__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var s = "[";
        for (var i=0; i < self.l.length; i++) {
            s += pyjslib.repr(self.l[i]);
            if (i < self.l.length - 1)
                s += ", ";
        }
        s += "]";
        return s;
        
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjslib.list = pyjslib.List;
pyjslib.Tuple = (function(){
	var cls_instance = pyjs__class_instance('Tuple');
	var cls_definition = new Object();
	cls_definition.__md5__ = '8f3d0cb2ad1fe72753d5dab745179235';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		if (typeof data == 'undefined') data=null;


        this.l = [];
        if (pyjslib.isArray(data)) {
            n = this.l.length;
            for (var i=0; i < data.length; i++) {
                this.l[n+i]=data[i];
                }
            }
        else if (pyjslib.isIteratable(data)) {
            var iter=data.__iter__();
            var i=this.l.length;
            try {
                while (true) {
                    var item=iter.next();
                    this.l[i++]=item;
                    }
                }
            catch (e) {
                if (e.__name__ != 'StopIteration') throw e;
                }
            }
        
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.__cmp__ = pyjs__bind_method(cls_instance, '__cmp__', function(l) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			l = arguments[1];
		}
		var x,ll;
		if (pyjslib.bool(!(pyjslib.isinstance(l, pyjslib.Tuple)))) {
			return 1;
		}
		ll =  ( pyjslib.len(self) - pyjslib.len(l) ) ;
		if (pyjslib.bool(!pyjslib.eq(ll, 0))) {
			return ll;
		}
		var __x = pyjslib.range(pyjslib.len(l)).__iter__();
		try {
			while (true) {
				var x = __x.next();
				
				ll = pyjslib.cmp(self.__getitem__(x), l.__getitem__(x));
				if (pyjslib.bool(!pyjslib.eq(ll, 0))) {
					return ll;
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return 0;
	}
	, 1, [null,null,'self', 'l']);
	cls_definition.slice = pyjs__bind_method(cls_instance, 'slice', function(lower, upper) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			lower = arguments[1];
			upper = arguments[2];
		}


        if (upper==null) return pyjslib.Tuple(this.l.slice(lower));
        return pyjslib.Tuple(this.l.slice(lower, upper));
        
	}
	, 1, [null,null,'self', 'lower', 'upper']);
	cls_definition.__getitem__ = pyjs__bind_method(cls_instance, '__getitem__', function(index) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			index = arguments[1];
		}


        if (index<0) index = this.l.length + index;
        return this.l[index];
        
	}
	, 1, [null,null,'self', 'index']);
	cls_definition.__len__ = pyjs__bind_method(cls_instance, '__len__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

    return this.l.length;
	}
	, 1, [null,null,'self']);
	cls_definition.__contains__ = pyjs__bind_method(cls_instance, '__contains__', function(value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			value = arguments[1];
		}


        var length=this.l.length;
        for (var i=0; i<length; i++) {
            if (this.l[i]===value) {
                return true;
                }
            }
        
		return false;
	}
	, 1, [null,null,'self', 'value']);
	cls_definition.__iter__ = pyjs__bind_method(cls_instance, '__iter__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var i = 0;
        var l = this.l;
        return {
            'next': function() {
                if (i >= l.length) {
                    throw pyjslib.StopIteration;
                }
                return l[i++];
            },
            '__iter__': function() {
                return this;
            }
        };
        
	}
	, 1, [null,null,'self']);
	cls_definition.getArray = pyjs__bind_method(cls_instance, 'getArray', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.l == 'function' && self.__is_instance__?pyjslib.getattr(self, 'l'):self.l);
	}
	, 1, [null,null,'self']);
	cls_definition.__str__ = pyjs__bind_method(cls_instance, '__str__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.__repr__();
	}
	, 1, [null,null,'self']);
	cls_definition.__repr__ = pyjs__bind_method(cls_instance, '__repr__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var s = "(";
        for (var i=0; i < self.l.length; i++) {
            s += pyjslib.repr(self.l[i]);
            if (i < self.l.length - 1)
                s += ", ";
        }
        if (self.l.length == 1)
            s += ",";
        s += ")";
        return s;
        
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjslib.tuple = pyjslib.Tuple;
pyjslib.Dict = (function(){
	var cls_instance = pyjs__class_instance('Dict');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'a70ac8e9cbf67304fa20d92007161d54';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(data) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			data = arguments[1];
		}
		if (typeof data == 'undefined') data=null;


        this.d = {};

        if (pyjslib.isArray(data)) {
            for (var i in data) {
                var item=data[i];
                this.__setitem__(item[0], item[1]);
                //var sKey=pyjslib.hash(item[0]);
                //this.d[sKey]=item[1];
                }
            }
        else if (pyjslib.isIteratable(data)) {
            var iter=data.__iter__();
            try {
                while (true) {
                    var item=iter.next();
                    this.__setitem__(item.__getitem__(0), item.__getitem__(1));
                    }
                }
            catch (e) {
                if (e.__name__ != 'StopIteration') throw e;
                }
            }
        else if (pyjslib.isObject(data)) {
            for (var key in data) {
                this.__setitem__(key, data[key]);
                }
            }
        
	}
	, 1, [null,null,'self', 'data']);
	cls_definition.__setitem__ = pyjs__bind_method(cls_instance, '__setitem__', function(key, value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
			value = arguments[2];
		}


        var sKey = pyjslib.hash(key);
        this.d[sKey]=[key, value];
        
	}
	, 1, [null,null,'self', 'key', 'value']);
	cls_definition.__getitem__ = pyjs__bind_method(cls_instance, '__getitem__', function(key) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
		}


        var sKey = pyjslib.hash(key);
        var value=this.d[sKey];
        if (pyjslib.isUndefined(value)){
            throw pyjslib.KeyError(key);
        }
        return value[1];
        
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.__nonzero__ = pyjs__bind_method(cls_instance, '__nonzero__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        for (var i in this.d){
            return true;
        }
        return false;
        
	}
	, 1, [null,null,'self']);
	cls_definition.__len__ = pyjs__bind_method(cls_instance, '__len__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var size=0;
        for (var i in this.d) size++;
        return size;
        
	}
	, 1, [null,null,'self']);
	cls_definition.has_key = pyjs__bind_method(cls_instance, 'has_key', function(key) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
		}

		return self.__contains__(key);
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.__delitem__ = pyjs__bind_method(cls_instance, '__delitem__', function(key) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
		}


        var sKey = pyjslib.hash(key);
        delete this.d[sKey];
        
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.__contains__ = pyjs__bind_method(cls_instance, '__contains__', function(key) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
		}


        var sKey = pyjslib.hash(key);
        return (pyjslib.isUndefined(this.d[sKey])) ? false : true;
        
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.keys = pyjs__bind_method(cls_instance, 'keys', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var keys=new pyjslib.List();
        for (var key in this.d) {
            keys.append(this.d[key][0]);
        }
        return keys;
        
	}
	, 1, [null,null,'self']);
	cls_definition.values = pyjs__bind_method(cls_instance, 'values', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var values=new pyjslib.List();
        for (var key in this.d) values.append(this.d[key][1]);
        return values;
        
	}
	, 1, [null,null,'self']);
	cls_definition.items = pyjs__bind_method(cls_instance, 'items', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var items = new pyjslib.List();
        for (var key in this.d) {
          var kv = this.d[key];
          items.append(new pyjslib.List(kv));
          }
          return items;
        
	}
	, 1, [null,null,'self']);
	cls_definition.__iter__ = pyjs__bind_method(cls_instance, '__iter__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.keys().__iter__();
	}
	, 1, [null,null,'self']);
	cls_definition.iterkeys = pyjs__bind_method(cls_instance, 'iterkeys', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.__iter__();
	}
	, 1, [null,null,'self']);
	cls_definition.itervalues = pyjs__bind_method(cls_instance, 'itervalues', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.values().__iter__();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.iteritems = pyjs__bind_method(cls_instance, 'iteritems', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.items().__iter__();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.setdefault = pyjs__bind_method(cls_instance, 'setdefault', function(key, default_value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
			default_value = arguments[2];
		}

		if (pyjslib.bool(!(self.has_key(key)))) {
			self.__setitem__(key, default_value);
		}
		return self.__getitem__(key);
	}
	, 1, [null,null,'self', 'key', 'default_value']);
	cls_definition.get = pyjs__bind_method(cls_instance, 'get', function(key, default_value) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
			default_value = arguments[2];
		}
		if (typeof default_value == 'undefined') default_value=null;

		if (pyjslib.bool(!(self.has_key(key)))) {
			return default_value;
		}
		return self.__getitem__(key);
	}
	, 1, [null,null,'self', 'key', 'default_value']);
	cls_definition.update = pyjs__bind_method(cls_instance, 'update', function(d) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			d = arguments[1];
		}
		var k,temp_k,v;
		var __temp_k = d.iteritems().__iter__();
		try {
			while (true) {
				var temp_k = __temp_k.next();
						var k = temp_k.__getitem__(0);		var v = temp_k.__getitem__(1);
				self.__setitem__(k, v);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'd']);
	cls_definition.pop = pyjs__bind_method(cls_instance, 'pop', function(k) {
		if (this.__is_instance__ === true) {
			var self = this;
			var d = new Array();
			for (var pyjs__va_arg = 1; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				d.push(pyjs__arg);
			}
			d = pyjslib.Tuple(d);

		} else {
			var self = arguments[0];
			k = arguments[1];
			var d = new Array();
			for (var pyjs__va_arg = 2; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				d.push(pyjs__arg);
			}
			d = pyjslib.Tuple(d);

		}
		var err,res,pyjs_try_err;
		if (pyjslib.bool((pyjslib.cmp(pyjslib.len(d), 1) == 1))) {
			throw (pyjslib.TypeError(pyjslib.sprintf(String('pop expected at most 2 arguments, got %s'),  ( 1 + pyjslib.len(d) ) )));
		}
		try {
			res = self.__getitem__(k);
    self.__delitem__(k);
			return res;
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjslib, try_lineno: 1101};
			if (pyjs_try_err_name == pyjslib.KeyError.__name__) {
				$pyjs.__last_exception__.except_lineno = 1105;
				err = pyjs_try_err;
				if (pyjslib.bool(d)) {
					return d.__getitem__(0);
				}
				else {
					throw ($pyjs.__last_exception__?$pyjs.__last_exception__.error:pyjslib.TypeError('exceptions must be classes, instances, or strings (deprecated), not NoneType'));
				}
			} else { throw pyjs_try_err; }
		}
		return null;
	}
	, 1, ['d',null,'self', 'k']);
	cls_definition.popitem = pyjs__bind_method(cls_instance, 'popitem', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var k,temp_k,v;
		var __temp_k = self.iteritems().__iter__();
		try {
			while (true) {
				var temp_k = __temp_k.next();
						var k = temp_k.__getitem__(0);		var v = temp_k.__getitem__(1);
				break;
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
    self.__delitem__(k);
		return new pyjslib.Tuple([k, v]);
	}
	, 1, [null,null,'self']);
	cls_definition.getObject = pyjs__bind_method(cls_instance, 'getObject', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.d == 'function' && self.__is_instance__?pyjslib.getattr(self, 'd'):self.d);
	}
	, 1, [null,null,'self']);
	cls_definition.copy = pyjs__bind_method(cls_instance, 'copy', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjslib.Dict(self.items());
	}
	, 1, [null,null,'self']);
	cls_definition.__str__ = pyjs__bind_method(cls_instance, '__str__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.__repr__();
	}
	, 1, [null,null,'self']);
	cls_definition.__repr__ = pyjs__bind_method(cls_instance, '__repr__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}


        var keys = new Array();
        for (var key in self.d)
            keys.push(key);

        var s = "{";
        for (var i=0; i<keys.length; i++) {
            var v = self.d[keys[i]];
            s += pyjslib.repr(v[0]) + ": " + pyjslib.repr(v[1]);
            if (i < keys.length-1)
                s += ", ";
        }
        s += "}";
        return s;
        
	}
	, 1, [null,null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjslib.dict = pyjslib.Dict;
pyjslib._super = function(type_, object_or_type) {
	if (typeof object_or_type == 'undefined') object_or_type=null;

	if (pyjslib.bool(!(pyjslib._issubtype(object_or_type, type_)))) {
		throw (pyjslib.TypeError(String('super(type, obj): obj must be an instance or subtype of type')));
	}

    var fn = pyjs_type('super', type_.__mro__.slice(1), {});
    fn.__new__ = fn.__mro__[1].__new__;
    fn.__init__ = fn.__mro__[1].__init__;
    if (object_or_type.__is_instance__ === false) {
        return fn;
    }
    var obj = new Object();
    function wrapper(obj, name) {
        var fnwrap = function() {
            var args = [];
            for (var i = 0; i < arguments.length; i++) {
              args.push(arguments[i]);
            }
            return obj[name].apply(object_or_type,args);
        };
        fnwrap.__name__ = name;
    	fnwrap.__args__ = obj.__args__;
    	fnwrap.__bind_type__ = obj.__bind_type__;
        return fnwrap;
    }
    for (var m in fn) {
        if (typeof fn[m] == 'function') {
            obj[m] = wrapper(fn, m);
        }
    }
    return obj;
    
};
pyjslib._super.__name__ = '_super';

pyjslib._super.__bind_type__ = 0;
pyjslib._super.__args__ = [null,null,'type_', 'object_or_type'];
pyjslib.range = function(start, stop, step) {
	if (typeof stop == 'undefined') stop=null;
	if (typeof step == 'undefined') step=1;

	if (pyjslib.bool((stop === null))) {
		stop = start;
		start = 0;
	}

    return {
        'next': function() {
            if ((step > 0 && start >= stop) || (step < 0 && start <= stop)) throw pyjslib.StopIteration;
            var rval = start;
            start += step;
            return rval;
            },
        '__iter__': function() {
            return this;
            }
        };
    
};
pyjslib.range.__name__ = 'range';

pyjslib.range.__bind_type__ = 0;
pyjslib.range.__args__ = [null,null,'start', 'stop', 'step'];
pyjslib.slice = function(object, lower, upper) {


    if (pyjslib.isString(object)) {
        if (lower < 0) {
           lower = object.length + lower;
        }
        if (upper < 0) {
           upper = object.length + upper;
        }
        if (pyjslib.isNull(upper)) upper=object.length;
        return object.substring(lower, upper);
    }
    if (pyjslib.isObject(object) && object.slice)
        return object.slice(lower, upper);

    return null;
    
};
pyjslib.slice.__name__ = 'slice';

pyjslib.slice.__bind_type__ = 0;
pyjslib.slice.__args__ = [null,null,'object', 'lower', 'upper'];
pyjslib.str = function(text) {


    if (pyjslib.hasattr(text,"__str__")) {
        return text.__str__();
    }
    return String(text);
    
};
pyjslib.str.__name__ = 'str';

pyjslib.str.__bind_type__ = 0;
pyjslib.str.__args__ = [null,null,'text'];
pyjslib.ord = function(x) {

	if (pyjslib.bool((pyjslib.isString(x)) && ((pyjslib.len(x) === 1)))) {

            return x.charCodeAt(0);
        
	}
	else {

            throw pyjslib.TypeError();
        
	}
	return null;
};
pyjslib.ord.__name__ = 'ord';

pyjslib.ord.__bind_type__ = 0;
pyjslib.ord.__args__ = [null,null,'x'];
pyjslib.chr = function(x) {


        return String.fromCharCode(x);
    
};
pyjslib.chr.__name__ = 'chr';

pyjslib.chr.__bind_type__ = 0;
pyjslib.chr.__args__ = [null,null,'x'];
pyjslib.is_basetype = function(x) {


       var t = typeof(x);
       return t == 'boolean' ||
       t == 'function' ||
       t == 'number' ||
       t == 'string' ||
       t == 'undefined';
    
};
pyjslib.is_basetype.__name__ = 'is_basetype';

pyjslib.is_basetype.__bind_type__ = 0;
pyjslib.is_basetype.__args__ = [null,null,'x'];
pyjslib.get_pyjs_classtype = function(x) {


        if (pyjslib.hasattr(x, "__is_instance__")) {
            var src = x.__name__;
            return src;
        }
        return null;
    
};
pyjslib.get_pyjs_classtype.__name__ = 'get_pyjs_classtype';

pyjslib.get_pyjs_classtype.__bind_type__ = 0;
pyjslib.get_pyjs_classtype.__args__ = [null,null,'x'];
pyjslib.repr = function(x) {

	if (pyjslib.bool(pyjslib.hasattr(x, String('__repr__')))) {
		return x.__repr__();
	}

       if (x === null)
           return "null";

       if (x === undefined)
           return "undefined";

       var t = typeof(x);

        //alert("repr typeof " + t + " : " + x);

       if (t == "boolean")
           return x.toString();

       if (t == "function")
           return "<function " + x.toString() + ">";

       if (t == "number")
           return x.toString();

       if (t == "string") {
           if (x.indexOf("'") == -1)
               return "'" + x + "'";
           if (x.indexOf('"') == -1)
               return '"' + x + '"';
           var s = x.replace(new RegExp('"', "g"), '\\"');
           return '"' + s + '"';
       }

       if (t == "undefined")
           return "undefined";

       // If we get here, x is an object.  See if it's a Pyjamas class.

       if (!pyjslib.hasattr(x, "__init__"))
           return "<" + x.toString() + ">";

       // Handle the common Pyjamas data types.

       var constructor = "UNKNOWN";

       constructor = pyjslib.get_pyjs_classtype(x);

        //alert("repr constructor: " + constructor);

       // If we get here, the class isn't one we know -> return the class name.
       // Note that we replace underscores with dots so that the name will
       // (hopefully!) look like the original Python name.

       //var s = constructor.replace(new RegExp('_', "g"), '.');
       return "<" + constructor + " object>";
    
};
pyjslib.repr.__name__ = 'repr';

pyjslib.repr.__bind_type__ = 0;
pyjslib.repr.__args__ = [null,null,'x'];
pyjslib.float_ = function(text) {


    return parseFloat(text);
    
};
pyjslib.float_.__name__ = 'float_';

pyjslib.float_.__bind_type__ = 0;
pyjslib.float_.__args__ = [null,null,'text'];
pyjslib.int_ = function(text, radix) {
	if (typeof radix == 'undefined') radix=null;
	var _radix;
	_radix = radix;

    if (radix === null) {
        _radix = 10
    } else {
        if (typeof text != 'string') {
            throw pyjslib.TypeError("int() can't convert non-string with explicit base");
        }
    }
    var i = parseInt(text, _radix);
    if (!isNaN(i)) {
        return i;
    }
    
	throw (pyjslib.ValueError(pyjslib.sprintf(String('invalid literal for int() with base %d: \x27%s\x27'), new pyjslib.Tuple([_radix, text]))));
	return null;
};
pyjslib.int_.__name__ = 'int_';

pyjslib.int_.__bind_type__ = 0;
pyjslib.int_.__args__ = [null,null,'text', 'radix'];
pyjslib.len = function(object) {


    if (typeof object.__len__ == 'function') return object.__len__();
    if (typeof object.length != 'undefined') return object.length;
    if (object === null) return 0;
    throw pyjslib.TypeError("object has no len()")
    
};
pyjslib.len.__name__ = 'len';

pyjslib.len.__bind_type__ = 0;
pyjslib.len.__args__ = [null,null,'object'];
pyjslib.isinstance = function(object_, classinfo) {
	var ci;
	if (pyjslib.bool(pyjslib.isUndefined(object_))) {
		return false;
	}
if (classinfo.__name__ == 'int_') {
            return pyjslib.isNumber(object_); /* XXX TODO: check rounded? */
            }
        
if (classinfo.__name__ == 'str') {
            return pyjslib.isString(object_);
            }
        
	if (pyjslib.bool(!(pyjslib.isObject(object_)))) {
		return false;
	}
	if (pyjslib.bool(pyjslib._isinstance(classinfo, pyjslib.Tuple))) {
		var __ci = classinfo.__iter__();
		try {
			while (true) {
				var ci = __ci.next();
				
				if (pyjslib.bool(pyjslib.isinstance(object_, ci))) {
					return true;
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return false;
	}
	else {
		return pyjslib._isinstance(object_, classinfo);
	}
	return null;
};
pyjslib.isinstance.__name__ = 'isinstance';

pyjslib.isinstance.__bind_type__ = 0;
pyjslib.isinstance.__args__ = [null,null,'object_', 'classinfo'];
pyjslib._isinstance = function(object_, classinfo) {


    if (object_.__is_instance__ !== true) {
        return false;
    }
    for (var c in object_.__mro__) {
        if (object_.__mro__[c].__md5__ == classinfo.prototype.__md5__) return true;
    }
    return false;
    
};
pyjslib._isinstance.__name__ = '_isinstance';

pyjslib._isinstance.__bind_type__ = 0;
pyjslib._isinstance.__args__ = [null,null,'object_', 'classinfo'];
pyjslib._issubtype = function(object_, classinfo) {


    if (object_.__is_instance__ == null || classinfo.__is_instance__ == null) {
        return false;
    }
    for (var c in object_.__mro__) {
        if (object_.__mro__[c] == classinfo.prototype) return true;
    }
    return false;
    
};
pyjslib._issubtype.__name__ = '_issubtype';

pyjslib._issubtype.__bind_type__ = 0;
pyjslib._issubtype.__args__ = [null,null,'object_', 'classinfo'];
pyjslib.getattr = function(obj, name, default_value) {
	if (typeof default_value == 'undefined') default_value=null;


    if ((!pyjslib.isObject(obj))||(pyjslib.isUndefined(obj[name]))){
        if (arguments.length != 3){
            throw pyjslib.AttributeError(obj, name);
        }else{
        return default_value;
        }
    }
    if (!pyjslib.isFunction(obj[name])) return obj[name];
    var method = obj[name];
    var fnwrap = function() {
        var args = [];
        for (var i = 0; i < arguments.length; i++) {
          args.push(arguments[i]);
        }
        return method.apply(obj,args);
    };
    fnwrap.__name__ = name;
    fnwrap.__args__ = obj.__args__;
    fnwrap.__bind_type__ = obj.__bind_type__;
    return fnwrap;
    
};
pyjslib.getattr.__name__ = 'getattr';

pyjslib.getattr.__bind_type__ = 0;
pyjslib.getattr.__args__ = [null,null,'obj', 'name', 'default_value'];
pyjslib.delattr = function(obj, name) {


    if (!pyjslib.isObject(obj)) {
       throw pyjslib.AttributeError("'"+typeof(obj)+"' object has no attribute '"+name+"%s'")
    }
    if ((pyjslib.isUndefined(obj[name])) ||(typeof(obj[name]) == "function") ){
        throw pyjslib.AttributeError(obj.__name__+" instance has no attribute '"+ name+"'");
    }
    delete obj[name];
    
};
pyjslib.delattr.__name__ = 'delattr';

pyjslib.delattr.__bind_type__ = 0;
pyjslib.delattr.__args__ = [null,null,'obj', 'name'];
pyjslib.setattr = function(obj, name, value) {


    if (!pyjslib.isObject(obj)) return null;

    obj[name] = value;

    
};
pyjslib.setattr.__name__ = 'setattr';

pyjslib.setattr.__bind_type__ = 0;
pyjslib.setattr.__args__ = [null,null,'obj', 'name', 'value'];
pyjslib.hasattr = function(obj, name) {


    if (!pyjslib.isObject(obj)) return false;
    if (pyjslib.isUndefined(obj[name])) return false;

    return true;
    
};
pyjslib.hasattr.__name__ = 'hasattr';

pyjslib.hasattr.__bind_type__ = 0;
pyjslib.hasattr.__args__ = [null,null,'obj', 'name'];
pyjslib.dir = function(obj) {


    var properties=new pyjslib.List();
    for (property in obj) properties.append(property);
    return properties;
    
};
pyjslib.dir.__name__ = 'dir';

pyjslib.dir.__bind_type__ = 0;
pyjslib.dir.__args__ = [null,null,'obj'];
pyjslib.filter = function(obj, method, sequence) {
	if (typeof sequence == 'undefined') sequence=null;
	var items,item;
	items = new pyjslib.List([]);
	if (pyjslib.bool((sequence === null))) {
		sequence = method;
		method = obj;
		var __item = sequence.__iter__();
		try {
			while (true) {
				var item = __item.next();
				
				if (pyjslib.bool(method(item))) {
					items.append(item);
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else {
		var __item = sequence.__iter__();
		try {
			while (true) {
				var item = __item.next();
				
				if (pyjslib.bool(method.call_(obj, item))) {
					items.append(item);
				}
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	return items;
};
pyjslib.filter.__name__ = 'filter';

pyjslib.filter.__bind_type__ = 0;
pyjslib.filter.__args__ = [null,null,'obj', 'method', 'sequence'];
pyjslib.map = function(obj, method, sequence) {
	if (typeof sequence == 'undefined') sequence=null;
	var items,item;
	items = new pyjslib.List([]);
	if (pyjslib.bool((sequence === null))) {
		sequence = method;
		method = obj;
		var __item = sequence.__iter__();
		try {
			while (true) {
				var item = __item.next();
				
				items.append(method(item));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	else {
		var __item = sequence.__iter__();
		try {
			while (true) {
				var item = __item.next();
				
				items.append(method.call_(obj, item));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
	return items;
};
pyjslib.map.__name__ = 'map';

pyjslib.map.__bind_type__ = 0;
pyjslib.map.__args__ = [null,null,'obj', 'method', 'sequence'];
pyjslib.enumerate = function(sequence) {
	var item,nextIndex,enumeration;
	enumeration = new pyjslib.List([]);
	nextIndex = 0;
	var __item = sequence.__iter__();
	try {
		while (true) {
			var item = __item.next();
			
			enumeration.append(new pyjslib.List([nextIndex, item]));
			nextIndex =  ( nextIndex + 1 ) ;
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return enumeration;
};
pyjslib.enumerate.__name__ = 'enumerate';

pyjslib.enumerate.__bind_type__ = 0;
pyjslib.enumerate.__args__ = [null,null,'sequence'];
pyjslib.min = function() {
	var sequence = new Array();
	for (var pyjs__va_arg = 0; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
		var pyjs__arg = arguments[pyjs__va_arg];
		sequence.push(pyjs__arg);
	}
	sequence = pyjslib.Tuple(sequence);

	var item,minValue;
	if (pyjslib.bool(pyjslib.eq(pyjslib.len(sequence), 1))) {
		sequence = sequence.__getitem__(0);
	}
	minValue = null;
	var __item = sequence.__iter__();
	try {
		while (true) {
			var item = __item.next();
			
			if (pyjslib.bool((minValue === null))) {
				minValue = item;
			}
			else if (pyjslib.bool(pyjslib.eq(pyjslib.cmp(item, minValue), -1))) {
				minValue = item;
			}
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return minValue;
};
pyjslib.min.__name__ = 'min';

pyjslib.min.__bind_type__ = 0;
pyjslib.min.__args__ = ['sequence',null];
pyjslib.max = function() {
	var sequence = new Array();
	for (var pyjs__va_arg = 0; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
		var pyjs__arg = arguments[pyjs__va_arg];
		sequence.push(pyjs__arg);
	}
	sequence = pyjslib.Tuple(sequence);

	var item,maxValue;
	if (pyjslib.bool(pyjslib.eq(pyjslib.len(sequence), 1))) {
		sequence = sequence.__getitem__(0);
	}
	maxValue = null;
	var __item = sequence.__iter__();
	try {
		while (true) {
			var item = __item.next();
			
			if (pyjslib.bool((maxValue === null))) {
				maxValue = item;
			}
			else if (pyjslib.bool(pyjslib.eq(pyjslib.cmp(item, maxValue), 1))) {
				maxValue = item;
			}
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return maxValue;
};
pyjslib.max.__name__ = 'max';

pyjslib.max.__bind_type__ = 0;
pyjslib.max.__args__ = ['sequence',null];
pyjslib.next_hash_id = 0;
pyjslib.hash = function(obj) {


    if (obj == null) return null;

    if (obj.$H) return obj.$H;
    if (obj.__hash__) return obj.__hash__();
    if (obj.constructor == String || obj.constructor == Number || obj.constructor == Date) return obj;

    try {
        obj.$H = ++pyjslib.next_hash_id;
        return obj.$H;
    } catch (e) {
        return obj;
    }
    
};
pyjslib.hash.__name__ = 'hash';

pyjslib.hash.__bind_type__ = 0;
pyjslib.hash.__args__ = [null,null,'obj'];
pyjslib.isObject = function(a) {


    return (a != null && (typeof a == 'object')) || pyjslib.isFunction(a);
    
};
pyjslib.isObject.__name__ = 'isObject';

pyjslib.isObject.__bind_type__ = 0;
pyjslib.isObject.__args__ = [null,null,'a'];
pyjslib.isFunction = function(a) {


    return typeof a == 'function';
    
};
pyjslib.isFunction.__name__ = 'isFunction';

pyjslib.isFunction.__bind_type__ = 0;
pyjslib.isFunction.__args__ = [null,null,'a'];
pyjslib.callable = pyjslib.isFunction;
pyjslib.isString = function(a) {


    return typeof a == 'string';
    
};
pyjslib.isString.__name__ = 'isString';

pyjslib.isString.__bind_type__ = 0;
pyjslib.isString.__args__ = [null,null,'a'];
pyjslib.isNull = function(a) {


    return typeof a == 'object' && !a;
    
};
pyjslib.isNull.__name__ = 'isNull';

pyjslib.isNull.__bind_type__ = 0;
pyjslib.isNull.__args__ = [null,null,'a'];
pyjslib.isArray = function(a) {


    return pyjslib.isObject(a) && a.constructor == Array;
    
};
pyjslib.isArray.__name__ = 'isArray';

pyjslib.isArray.__bind_type__ = 0;
pyjslib.isArray.__args__ = [null,null,'a'];
pyjslib.isUndefined = function(a) {


    return typeof a == 'undefined';
    
};
pyjslib.isUndefined.__name__ = 'isUndefined';

pyjslib.isUndefined.__bind_type__ = 0;
pyjslib.isUndefined.__args__ = [null,null,'a'];
pyjslib.isIteratable = function(a) {


    return pyjslib.isString(a) || (pyjslib.isObject(a) && a.__iter__);
    
};
pyjslib.isIteratable.__name__ = 'isIteratable';

pyjslib.isIteratable.__bind_type__ = 0;
pyjslib.isIteratable.__args__ = [null,null,'a'];
pyjslib.isNumber = function(a) {


    return typeof a == 'number' && isFinite(a);
    
};
pyjslib.isNumber.__name__ = 'isNumber';

pyjslib.isNumber.__bind_type__ = 0;
pyjslib.isNumber.__args__ = [null,null,'a'];
pyjslib.toJSObjects = function(x) {

	if (pyjslib.bool(pyjslib.isArray(x))) {

        var result = [];
        for(var k=0; k < x.length; k++) {
           var v = x[k];
           var tv = pyjslib.toJSObjects(v);
           result.push(tv);
        }
        return result;
        
	}
	if (pyjslib.bool(pyjslib.isObject(x))) {
		if (pyjslib.bool(pyjslib.isinstance(x, pyjslib.Dict))) {

            var o = x.getObject();
            var result = {};
            for (var i in o) {
               result[o[i][0].toString()] = o[i][1];
            }
            return pyjslib.toJSObjects(result)
            
		}
		else if (pyjslib.bool(pyjslib.isinstance(x, pyjslib.List))) {
			return pyjslib.toJSObjects((typeof x.l == 'function' && x.__is_instance__?pyjslib.getattr(x, 'l'):x.l));
		}
		else if (pyjslib.bool(pyjslib.hasattr(x, String('__class__')))) {
			return x;
		}
	}
	if (pyjslib.bool(pyjslib.isObject(x))) {

        var result = {};
        for(var k in x) {
            var v = x[k];
            var tv = pyjslib.toJSObjects(v);
            result[k] = tv;
            }
            return result;
         
	}
	return x;
};
pyjslib.toJSObjects.__name__ = 'toJSObjects';

pyjslib.toJSObjects.__bind_type__ = 0;
pyjslib.toJSObjects.__args__ = [null,null,'x'];
pyjslib.sprintf = function(strng, args) {
	var a,sprintf_dict,next_arg,remainder,nargs,argidx,formatarg,result,constructor,strlen,sprintf_list;
	constructor = pyjslib.get_pyjs_classtype(args);

    var re_dict = /([^%]*)%[(]([^)]+)[)]([#0  x2B-]*)(\d+)?(\.\d+)?[hlL]?(.)((.|\n)*)/;
    var re_list = /([^%]*)%([#0 +-]*)(\*|(\d+))?(\.\d+)?[hlL]?(.)((.|\n)*)/;
    var re_exp = /(.*)([+-])(.*)/;

	strlen = pyjslib.len(strng);
	argidx = 0;
	nargs = 0;
	result = new pyjslib.List([]);
	remainder = strng;
	next_arg = function() {
		var arg;
		if (pyjslib.bool(pyjslib.eq(argidx, nargs))) {
			throw (pyjslib.TypeError(String('not enough arguments for format string')));
		}
		arg = args.__getitem__(argidx);
		argidx += 1;
		return arg;
	};
	next_arg.__name__ = 'next_arg';

	next_arg.__bind_type__ = 0;
	next_arg.__args__ = [null,null];
	formatarg = function(flags, minlen, precision, conversion, param) {
		var subst,numeric,padchar,left_padding;
		subst = String('');
		numeric = true;
		if (pyjslib.bool(!(minlen))) {
			minlen = 0;
		}
		else {
			minlen = pyjslib.int_(minlen);
		}
		if (pyjslib.bool(!(precision))) {
			precision = null;
		}
		else {
			precision = pyjslib.int_(precision);
		}
		left_padding = 1;
		if (pyjslib.bool((pyjslib.cmp(flags.find(String('-')), 0) != -1))) {
			left_padding = 0;
		}
		if (pyjslib.bool(pyjslib.eq(conversion, String('%')))) {
			numeric = false;
			subst = String('%');
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('c')))) {
			numeric = false;
			subst = pyjslib.chr(pyjslib.int_(param));
		}
		else if (pyjslib.bool((pyjslib.eq(conversion, String('d'))) || (pyjslib.eq(conversion, String('i'))) || (pyjslib.eq(conversion, String('u'))))) {
			subst = pyjslib.str(pyjslib.int_(param));
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('e')))) {
			if (pyjslib.bool((precision === null))) {
				precision = 6;
			}

            subst = re_exp.exec(String(param.toExponential(precision)));
            if (subst[3].length == 1) {
                subst = subst[1] + subst[2] + '0' + subst[3];
            } else {
                subst = subst[1] + subst[2] + subst[3];
            }
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('E')))) {
			if (pyjslib.bool((precision === null))) {
				precision = 6;
			}

            subst = re_exp.exec(String(param.toExponential(precision)).toUpperCase());
            if (subst[3].length == 1) {
                subst = subst[1] + subst[2] + '0' + subst[3];
            } else {
                subst = subst[1] + subst[2] + subst[3];
            }
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('f')))) {
			if (pyjslib.bool((precision === null))) {
				precision = 6;
			}

            subst = String(parseFloat(param).toFixed(precision));
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('F')))) {
			if (pyjslib.bool((precision === null))) {
				precision = 6;
			}

            subst = String(parseFloat(param).toFixed(precision)).toUpperCase();
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('g')))) {
			if (pyjslib.bool((pyjslib.cmp(flags.find(String('#')), 0) != -1))) {
				if (pyjslib.bool((precision === null))) {
					precision = 6;
				}
			}
			if (pyjslib.bool(((pyjslib.cmp(param, 1000000.0) != -1)) || ((pyjslib.cmp(param, 1e-05) == -1)))) {

                subst = String(precision == null ? param.toExponential() : param.toExponential().toPrecision(precision));
			}
			else {

                subst = String(precision == null ? parseFloat(param) : parseFloat(param).toPrecision(precision));
			}
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('G')))) {
			if (pyjslib.bool((pyjslib.cmp(flags.find(String('#')), 0) != -1))) {
				if (pyjslib.bool((precision === null))) {
					precision = 6;
				}
			}
			if (pyjslib.bool(((pyjslib.cmp(param, 1000000.0) != -1)) || ((pyjslib.cmp(param, 1e-05) == -1)))) {

                subst = String(precision == null ? param.toExponential() : param.toExponential().toPrecision(precision)).toUpperCase();
			}
			else {

                subst = String(precision == null ? parseFloat(param) : parseFloat(param).toPrecision(precision)).toUpperCase().toUpperCase();
			}
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('r')))) {
			numeric = false;
			subst = pyjslib.repr(param);
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('s')))) {
			numeric = false;
			subst = pyjslib.str(param);
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('o')))) {
			param = pyjslib.int_(param);

            subst = param.toString(8);
			if (pyjslib.bool(((pyjslib.cmp(flags.find(String('#')), 0) != -1)) && (!pyjslib.eq(subst, String('0'))))) {
				subst =  ( String('0') + subst ) ;
			}
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('x')))) {
			param = pyjslib.int_(param);

            subst = param.toString(16);
			if (pyjslib.bool((pyjslib.cmp(flags.find(String('#')), 0) != -1))) {
				if (pyjslib.bool(left_padding)) {
					subst = subst.rjust( ( minlen - 2 ) , String('0'));
				}
				subst =  ( String('0x') + subst ) ;
			}
		}
		else if (pyjslib.bool(pyjslib.eq(conversion, String('X')))) {
			param = pyjslib.int_(param);

            subst = param.toString(16).toUpperCase();
			if (pyjslib.bool((pyjslib.cmp(flags.find(String('#')), 0) != -1))) {
				if (pyjslib.bool(left_padding)) {
					subst = subst.rjust( ( minlen - 2 ) , String('0'));
				}
				subst =  ( String('0X') + subst ) ;
			}
		}
		else {
			throw (pyjslib.ValueError( (  (  (  (  ( String('unsupported format character \x27') + conversion )  + String('\x27 (') )  + pyjslib.hex(pyjslib.ord(conversion)) )  + String(') at index ') )  +  (  ( strlen - pyjslib.len(remainder) )  - 1 )  ) ));
		}
		if (pyjslib.bool((minlen) && ((pyjslib.cmp(pyjslib.len(subst), minlen) == -1)))) {
			padchar = String(' ');
			if (pyjslib.bool((numeric) && (left_padding) && ((pyjslib.cmp(flags.find(String('0')), 0) != -1)))) {
				padchar = String('0');
			}
			if (pyjslib.bool(left_padding)) {
				subst = subst.rjust(minlen, padchar);
			}
			else {
				subst = subst.ljust(minlen, padchar);
			}
		}
		return subst;
	};
	formatarg.__name__ = 'formatarg';

	formatarg.__bind_type__ = 0;
	formatarg.__args__ = [null,null,'flags', 'minlen', 'precision', 'conversion', 'param'];
	sprintf_list = function(strng, args) {
		var a,conversion,minlen,precision,param,flags,minlen_type,left;
		a = null;
		left = null;
		flags = null;
		precision = null;
		conversion = null;
		minlen = null;
		minlen_type = null;
    while (pyjslib.bool(remainder)) {

            a = re_list.exec(remainder);
		if (pyjslib.bool((a === null))) {
			result.append(remainder);
			break;
		}

            left = a[1], flags = a[2];
            minlen = a[3], precision = a[5], conversion = a[6];
            remainder = a[7];
            if (typeof minlen == 'undefined') minlen = null;
            if (typeof precision == 'undefined') precision = null;
            if (typeof conversion == 'undefined') conversion = null;

		result.append(left);
		if (pyjslib.bool(pyjslib.eq(minlen, String('*')))) {
			minlen = next_arg();
minlen_type = typeof(minlen);
			if (pyjslib.bool((!pyjslib.eq(minlen_type, String('number'))) || (!pyjslib.eq(pyjslib.int_(minlen), minlen)))) {
				throw (pyjslib.TypeError(String('* wants int')));
			}
		}
		if (pyjslib.bool(!pyjslib.eq(conversion, String('%')))) {
			param = next_arg();
		}
		result.append(formatarg(flags, minlen, precision, conversion, param));
    }
		return null;
	};
	sprintf_list.__name__ = 'sprintf_list';

	sprintf_list.__bind_type__ = 0;
	sprintf_list.__args__ = [null,null,'strng', 'args'];
	sprintf_dict = function(strng, args) {
		var a,conversion,minlen,precision,param,flags,key,arg,left;
		arg = args;
		argidx += 1;
		a = null;
		key = null;
		left = null;
		flags = null;
		precision = null;
		conversion = null;
		minlen = null;
    while (pyjslib.bool(remainder)) {

            a = re_dict.exec(remainder);
		if (pyjslib.bool((a === null))) {
			result.append(remainder);
			break;
		}

            left = a[1], key = a[2], flags = a[3];
            minlen = a[4], precision = a[5], conversion = a[6];
            remainder = a[7];
            if (typeof minlen == 'undefined') minlen = null;
            if (typeof precision == 'undefined') precision = null;
            if (typeof conversion == 'undefined') conversion = null;

		result.append(left);
		if (pyjslib.bool(!(arg.has_key(key)))) {
			throw (pyjslib.KeyError(key));
		}
		else {
			param = arg.__getitem__(key);
		}
		result.append(formatarg(flags, minlen, precision, conversion, param));
    }
		return null;
	};
	sprintf_dict.__name__ = 'sprintf_dict';

	sprintf_dict.__bind_type__ = 0;
	sprintf_dict.__args__ = [null,null,'strng', 'args'];
	a = null;

    a = re_dict.exec(strng);

	if (pyjslib.bool((a === null))) {
		if (pyjslib.bool(!pyjslib.eq(constructor, String('Tuple')))) {
			args = new pyjslib.Tuple([args]);
		}
		nargs = pyjslib.len(args);
		sprintf_list(strng, args);
		if (pyjslib.bool(!pyjslib.eq(argidx, nargs))) {
			throw (pyjslib.TypeError(String('not all arguments converted during string formatting')));
		}
	}
	else {
		if (pyjslib.bool(!pyjslib.eq(constructor, String('Dict')))) {
			throw (pyjslib.TypeError(String('format requires a mapping')));
		}
		sprintf_dict(strng, args);
	}
	return String('').join(result);
};
pyjslib.sprintf.__name__ = 'sprintf';

pyjslib.sprintf.__bind_type__ = 0;
pyjslib.sprintf.__args__ = [null,null,'strng', 'args'];
pyjslib.printFunc = function(objs, newline) {


    if ($wnd.console==undefined)  return;
    var s = "";
    for(var i=0; i < objs.length; i++) {
        if(s != "") s += " ";
        s += objs[i];
    }
    console.debug(s)
    
};
pyjslib.printFunc.__name__ = 'printFunc';

pyjslib.printFunc.__bind_type__ = 0;
pyjslib.printFunc.__args__ = [null,null,'objs', 'newline'];
pyjslib.type = function(clsname, bases, methods) {
	if (typeof bases == 'undefined') bases=null;
	if (typeof methods == 'undefined') methods=null;
	var k,mth;
 var mths = {}; 
	if (pyjslib.bool(methods)) {
		var __k = methods.keys().__iter__();
		try {
			while (true) {
				var k = __k.next();
				
				mth = methods.__getitem__(k);
 mths[k] = mth; 
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
	}
 var bss = null; 
	if (pyjslib.bool(bases)) {
bss = bases.l;
	}
 return pyjs_type(clsname, bss, mths); 
};
pyjslib.type.__name__ = 'type';

pyjslib.type.__bind_type__ = 0;
pyjslib.type.__args__ = [null,null,'clsname', 'bases', 'methods'];
pyjslib.pow = function(x, y, z) {
	if (typeof z == 'undefined') z=null;
	var p;
	p = null;
p = Math.pow(x, y);
	if (pyjslib.bool((z === null))) {
		return pyjslib.float_(p);
	}
	return pyjslib.float_(p % z);
};
pyjslib.pow.__name__ = 'pow';

pyjslib.pow.__bind_type__ = 0;
pyjslib.pow.__args__ = [null,null,'x', 'y', 'z'];
pyjslib.hex = function(x) {
	var r;
	if (pyjslib.bool(!pyjslib.eq(pyjslib.int_(x), x))) {
		throw (pyjslib.TypeError(String('hex() argument can\x27t be converted to hex')));
	}
	r = null;
r = '0x'+x.toString(16);
	return pyjslib.str(r);
};
pyjslib.hex.__name__ = 'hex';

pyjslib.hex.__bind_type__ = 0;
pyjslib.hex.__args__ = [null,null,'x'];
pyjslib.oct = function(x) {
	var r;
	if (pyjslib.bool(!pyjslib.eq(pyjslib.int_(x), x))) {
		throw (pyjslib.TypeError(String('oct() argument can\x27t be converted to oct')));
	}
	r = null;
r = '0'+x.toString(8);
	return pyjslib.str(r);
};
pyjslib.oct.__name__ = 'oct';

pyjslib.oct.__bind_type__ = 0;
pyjslib.oct.__args__ = [null,null,'x'];
pyjslib.round = function(x, n) {
	if (typeof n == 'undefined') n=0;
	var r;
	n = pyjslib.pow(10, n);
	r = null;
r = Math.round(n*x)/n;
	return pyjslib.float_(r);
};
pyjslib.round.__name__ = 'round';

pyjslib.round.__bind_type__ = 0;
pyjslib.round.__args__ = [null,null,'x', 'n'];
pyjslib.divmod = function(x, y) {
	var f;
	if (pyjslib.bool((pyjslib.eq(pyjslib.int_(x), x)) && (pyjslib.eq(pyjslib.int_(y), y)))) {
		return new pyjslib.Tuple([pyjslib.int_( ( x / y ) ), pyjslib.int_(x % y)]);
	}
	f = null;
f = Math.floor(x / y);
	f = pyjslib.float_(f);
	return new pyjslib.Tuple([f,  ( x -  ( f * y )  ) ]);
};
pyjslib.divmod.__name__ = 'divmod';

pyjslib.divmod.__bind_type__ = 0;
pyjslib.divmod.__args__ = [null,null,'x', 'y'];
pyjslib.all = function(iterable) {
	var element;
	var __element = iterable.__iter__();
	try {
		while (true) {
			var element = __element.next();
			
			if (pyjslib.bool(!(element))) {
				return false;
			}
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return true;
};
pyjslib.all.__name__ = 'all';

pyjslib.all.__bind_type__ = 0;
pyjslib.all.__args__ = [null,null,'iterable'];
pyjslib.any = function(iterable) {
	var element;
	var __element = iterable.__iter__();
	try {
		while (true) {
			var element = __element.next();
			
			if (pyjslib.bool(element)) {
				return true;
			}
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return false;
};
pyjslib.any.__name__ = 'any';

pyjslib.any.__bind_type__ = 0;
pyjslib.any.__args__ = [null,null,'iterable'];
pyjslib.init();
pyjslib.__import__(['sys'], 'sys', 'pyjslib');
pyjslib.sys = $pyjs.__modules__.sys;
return this;
}; /* end pyjslib */
$pyjs.modules_hash['pyjslib'] = $pyjs.loaded_modules['pyjslib'];


 /* end module: pyjslib */


/*
PYJS_DEPS: ['sys']
*/
