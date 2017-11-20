/* start module: pyjamas.JSONParser */
pyjamas.JSONParser = $pyjs.loaded_modules["pyjamas.JSONParser"] = function (__mod_name__) {
if(pyjamas.JSONParser.__was_initialized__) return pyjamas.JSONParser;
pyjamas.JSONParser.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.JSONParser';
var __name__ = pyjamas.JSONParser.__name__ = __mod_name__;
var JSONParser = pyjamas.JSONParser;

pyjslib.__import__(['pyjamas.math', 'math'], 'math', 'pyjamas.JSONParser');
pyjamas.JSONParser.math = $pyjs.__modules__.math;
pyjamas.JSONParser.JSONParser = (function(){
	var cls_instance = pyjs__class_instance('JSONParser');
	var cls_definition = new Object();
	cls_definition.__md5__ = '47c6b9c5ac131702d03f5a6ea21bf8a6';
	cls_definition.decode = pyjs__bind_method(cls_instance, 'decode', function(str) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			str = arguments[1];
		}

		return self.jsObjectToPy(self.parseJSON(str));
	}
	, 1, [null,null,'self', 'str']);
	cls_definition.decodeAsObject = pyjs__bind_method(cls_instance, 'decodeAsObject', function(str) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			str = arguments[1];
		}

		return self.jsObjectToPyObject(self.parseJSON(str));
	}
	, 1, [null,null,'self', 'str']);
	cls_definition.encode = pyjs__bind_method(cls_instance, 'encode', function(obj) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			obj = arguments[1];
		}

		return self.toJSONString(obj);
	}
	, 1, [null,null,'self', 'obj']);
	cls_definition.jsObjectToPy = pyjs__bind_method(cls_instance, 'jsObjectToPy', function(obj) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			obj = arguments[1];
		}


        if (pyjslib.isArray(obj)) {
            for (var i in obj) obj[i] = this.jsObjectToPy(obj[i]);
            obj=new pyjslib.List(obj);
            }
        else if (pyjslib.isObject(obj)) {
            for (var i in obj) obj[i]=this.jsObjectToPy(obj[i]);
            obj=new pyjslib.Dict(obj);
            }
        
        return obj;
        
	}
	, 1, [null,null,'self', 'obj']);
	cls_definition.jsObjectToPyObject = pyjs__bind_method(cls_instance, 'jsObjectToPyObject', function(obj) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			obj = arguments[1];
		}


        if (pyjslib.isArray(obj)) {
            for (var i in obj) obj[i] = this.jsObjectToPyObject(obj[i]);
            obj=new pyjslib.List(obj);
            }
        else if (pyjslib.isObject(obj)) {
            if (obj["__jsonclass__"]) {
                var class_name = obj["__jsonclass__"][0];
                //class_name = class_name.replace(".", "_");
                
                var new_obj = eval("new " + class_name + "()");
                delete obj["__jsonclass__"];
                for (var i in obj) new_obj[i] = this.jsObjectToPyObject(obj[i]);
                obj = new_obj;
                }
            else {
                for (var i in obj) obj[i]=this.jsObjectToPyObject(obj[i]);
                obj=new pyjslib.Dict(obj);
                }       
            }
        
        return obj;
        
	}
	, 1, [null,null,'self', 'obj']);
	cls_definition.toJSONString = pyjs__bind_method(cls_instance, 'toJSONString', function(obj) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			obj = arguments[1];
		}


   var m = {
            '\b': '\\b',
            '\t': '\\t',
            '\n': '\\n',
            '\f': '\\f',
            '\r': '\\r',
            '"' : '\\"',
            '\\': '\\\\'
        },
        s = {
            array: function (x) {
                var a = ['['], b, f, i, l = x.length, v;
                for (i = 0; i < l; i += 1) {
                    v = x[i];
                    f = s[typeof v];
                    if (f) {
                        v = f(v);
                        if (typeof v == 'string') {
                            if (b) {
                                a[a.length] = ',';
                            }
                            a[a.length] = v;
                            b = true;
                        }
                    }
                }
                a[a.length] = ']';
                return a.join('');
            },
            'boolean': function (x) {
                return String(x);
            },
            'undefined':function (x) {
               return "null";
            },
            'null': function (x) {
                return "null";
            },
            number: function (x) {
                return isFinite(x) ? String(x) : 'null';
            },
            object: function (x) {
                if (x) {
                    if (x instanceof Array) {
                        return s.array(x);
                    }
                    if (x instanceof pyjslib.List) {
                        return s.array(x.l);
                    }
                    if (x instanceof pyjslib.Dict) {
                        return s.object(pyjslib.toJSObjects(x));
                    }
                    var a = ['{'], b, f, i, v;
                    for (i in x) {
                        v = x[i];
                        f = s[typeof v];
                        if (f) {
                            v = f(v);
                            if (typeof v == 'string') {
                                if (b) {
                                    a[a.length] = ',';
                                }
                                a.push(s.string(i), ':', v);
                                b = true;
                            }
                        }
                    }
                    a[a.length] = '}';
                    return a.join('');
                }
                return 'null';
            },
            string: function (x) {
                if (/["\\\x00-\x1f]/.test(x)) {
                    x = x.replace(/([\x00-\x1f\\"])/g, function(a, b) {
                        var c = m[b];
                        if (c) {
                            return c;
                        }
                        c = b.charCodeAt();
                        return '\\u00' +
                            math.floor(c / 16).toString(16) +
                            (c % 16).toString(16);
                    });
                }
                return '"' + x + '"';
            }
        };

        typ = typeof obj;
        f=s[typ];
        return f(obj);
        
	}
	, 1, [null,null,'self', 'obj']);
	cls_definition.parseJSON = pyjs__bind_method(cls_instance, 'parseJSON', function(str) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			str = arguments[1];
		}


        try {
            return (/^("(\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/.test(str)) &&
                eval('(' + str + ')');
        } catch (e) {
            return false;
        }
        
	}
	, 1, [null,null,'self', 'str']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
return this;
}; /* end pyjamas.JSONParser */
$pyjs.modules_hash['pyjamas.JSONParser'] = $pyjs.loaded_modules['pyjamas.JSONParser'];


 /* end module: pyjamas.JSONParser */


/*
PYJS_DEPS: ['math']
*/
