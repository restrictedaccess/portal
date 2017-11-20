/* start module: pyjamas.JSONService */
pyjamas.JSONService = $pyjs.loaded_modules["pyjamas.JSONService"] = function (__mod_name__) {
if(pyjamas.JSONService.__was_initialized__) return pyjamas.JSONService;
pyjamas.JSONService.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.JSONService';
var __name__ = pyjamas.JSONService.__name__ = __mod_name__;
var JSONService = pyjamas.JSONService;

pyjslib.__import__(['pyjamas.sys', 'sys'], 'sys', 'pyjamas.JSONService');
pyjamas.JSONService.sys = $pyjs.__modules__.sys;
pyjslib.__import__(['pyjamas.pyjamas.HTTPRequest.HTTPRequest', 'pyjamas.pyjamas.HTTPRequest', 'pyjamas.HTTPRequest.HTTPRequest', 'pyjamas.HTTPRequest'], 'pyjamas.HTTPRequest.HTTPRequest', 'pyjamas.JSONService');
pyjamas.JSONService.HTTPRequest = $pyjs.__modules__.pyjamas.HTTPRequest.HTTPRequest;
pyjslib.__import__(['pyjamas.pygwt', 'pygwt'], 'pygwt', 'pyjamas.JSONService');
pyjamas.JSONService.pygwt = $pyjs.__modules__.pygwt;
pyjamas.JSONService.JSONService = (function(){
	var cls_instance = pyjs__class_instance('JSONService');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'b52e416baa6699a7b769870192d1fd05';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(url, handler) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			url = arguments[1];
			handler = arguments[2];
		}
		if (typeof handler == 'undefined') handler=null;

		self.url = url;
		self.handler = handler;
		return null;
	}
	, 1, [null,null,'self', 'url', 'handler']);
	cls_definition.callMethod = pyjs__bind_method(cls_instance, 'callMethod', function(method, params, handler) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			method = arguments[1];
			params = arguments[2];
			handler = arguments[3];
		}
		if (typeof handler == 'undefined') handler=null;

		if (pyjslib.bool((handler === null))) {
			handler = (typeof self.handler == 'function' && self.__is_instance__?pyjslib.getattr(self, 'handler'):self.handler);
		}
		if (pyjslib.bool((handler === null))) {
			return self.__sendNotify(method, params);
		}
		else {
			return self.__sendRequest(method, params, handler);
		}
		return null;
	}
	, 1, [null,null,'self', 'method', 'params', 'handler']);
	cls_definition.onCompletion = pyjs__bind_method(cls_instance, 'onCompletion', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

 		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.sendNotify = pyjs__bind_method(cls_instance, 'sendNotify', function(method, params) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			method = arguments[1];
			params = arguments[2];
		}
		var dumps,msg_data,msg;
		pyjslib.__import__(['pyjamas.jsonrpc.json.dumps', 'pyjamas.jsonrpc.json', 'jsonrpc.json.dumps', 'jsonrpc.json'], 'jsonrpc.json.dumps', 'pyjamas.JSONService');
		dumps = $pyjs.__modules__.jsonrpc.json.dumps;
		msg = new pyjslib.Dict([[String('id'), null], [String('method'), method], [String('params'), params]]);
		msg_data = dumps(msg);
		if (pyjslib.bool(!(pyjs_kwargs_call(pyjamas.JSONService.HTTPRequest(), 'asyncPost', null, null, [{content_type:String('text/x-json')}, (typeof self.url == 'function' && self.__is_instance__?pyjslib.getattr(self, 'url'):self.url), msg_data, self])))) {
			return -1;
		}
		return 1;
	}
	, 1, [null,null,'self', 'method', 'params']);
	cls_definition.sendRequest = pyjs__bind_method(cls_instance, 'sendRequest', function(method, params, handler) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			method = arguments[1];
			params = arguments[2];
			handler = arguments[3];
		}
		var dumps,id,msg_data,msg,request_info;
		pyjslib.__import__(['pyjamas.jsonrpc.json.dumps', 'pyjamas.jsonrpc.json', 'jsonrpc.json.dumps', 'jsonrpc.json'], 'jsonrpc.json.dumps', 'pyjamas.JSONService');
		dumps = $pyjs.__modules__.jsonrpc.json.dumps;
		id = pyjamas.JSONService.pygwt.getNextHashId();
		msg = new pyjslib.Dict([[String('id'), id], [String('method'), method], [String('params'), params]]);
		msg_data = dumps(msg);
		request_info = pyjamas.JSONService.JSONRequestInfo(id, method, handler);
		if (pyjslib.bool(!(pyjs_kwargs_call(pyjamas.JSONService.HTTPRequest(), 'asyncPost', null, null, [{content_type:String('text/x-json')}, (typeof self.url == 'function' && self.__is_instance__?pyjslib.getattr(self, 'url'):self.url), msg_data, pyjamas.JSONService.JSONResponseTextHandler(request_info)])))) {
			return -1;
		}
		return id;
	}
	, 1, [null,null,'self', 'method', 'params', 'handler']);
	cls_definition.__sendNotify = pyjs__bind_method(cls_instance, '__sendNotify', function(method, params) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			method = arguments[1];
			params = arguments[2];
		}

 		return null;
	}
	, 1, [null,null,'self', 'method', 'params']);
	cls_definition.__sendRequest = pyjs__bind_method(cls_instance, '__sendRequest', function(method, params, handler) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			method = arguments[1];
			params = arguments[2];
			handler = arguments[3];
		}

 		return null;
	}
	, 1, [null,null,'self', 'method', 'params', 'handler']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjamas.JSONService.JSONRequestInfo = (function(){
	var cls_instance = pyjs__class_instance('JSONRequestInfo');
	var cls_definition = new Object();
	cls_definition.__md5__ = '92a699fa1c4eac189af358aeb28e2f09';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(id, method, handler) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			id = arguments[1];
			method = arguments[2];
			handler = arguments[3];
		}

		self.id = id;
		self.method = method;
		self.handler = handler;
		return null;
	}
	, 1, [null,null,'self', 'id', 'method', 'handler']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjamas.JSONService.JSONResponseTextHandler = (function(){
	var cls_instance = pyjs__class_instance('JSONResponseTextHandler');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'c10c2b4dc64acc2ff8089fbb64ccfea0';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(request) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			request = arguments[1];
		}

		self.request = request;
		return null;
	}
	, 1, [null,null,'self', 'request']);
	cls_definition.onCompletion = pyjs__bind_method(cls_instance, 'onCompletion', function(json_str) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			json_str = arguments[1];
		}
		var JSONDecodeException,err,pyjs_try_err,error,loads,response;
		pyjslib.__import__(['pyjamas.jsonrpc.json.loads', 'pyjamas.jsonrpc.json', 'jsonrpc.json.loads', 'jsonrpc.json'], 'jsonrpc.json.loads', 'pyjamas.JSONService');
		loads = $pyjs.__modules__.jsonrpc.json.loads;
		pyjslib.__import__(['pyjamas.jsonrpc.json.JSONDecodeException', 'pyjamas.jsonrpc.json', 'jsonrpc.json.JSONDecodeException', 'jsonrpc.json'], 'jsonrpc.json.JSONDecodeException', 'pyjamas.JSONService');
		JSONDecodeException = $pyjs.__modules__.jsonrpc.json.JSONDecodeException;
		try {
			response = loads(json_str);
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjamas.JSONService, try_lineno: 79};
			if (pyjs_try_err_name == JSONDecodeException.__name__) {
				$pyjs.__last_exception__.except_lineno = 81;
				err = pyjs_try_err;
				self.request.handler.onRemoteError(0, String('decode failure'), null);
				return null;
			} else { throw pyjs_try_err; }
		}
		if (pyjslib.bool(!(response))) {
			self.request.handler.onRemoteError(0, String('Server Error or Invalid Response'), (typeof self.request == 'function' && self.__is_instance__?pyjslib.getattr(self, 'request'):self.request));
		}
		else if (pyjslib.bool(response.get(String('error')))) {
			error = response.__getitem__(String('error'));
			self.request.handler.onRemoteError(error.__getitem__(String('code')), error.__getitem__(String('message')), (typeof self.request == 'function' && self.__is_instance__?pyjslib.getattr(self, 'request'):self.request));
		}
		else {
			self.request.handler.onRemoteResponse(response.__getitem__(String('result')), (typeof self.request == 'function' && self.__is_instance__?pyjslib.getattr(self, 'request'):self.request));
		}
		return null;
	}
	, 1, [null,null,'self', 'json_str']);
	cls_definition.onError = pyjs__bind_method(cls_instance, 'onError', function(error_str, error_code) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			error_str = arguments[1];
			error_code = arguments[2];
		}

		self.request.handler.onRemoteError(error_code, error_str, (typeof self.request == 'function' && self.__is_instance__?pyjslib.getattr(self, 'request'):self.request));
		return null;
	}
	, 1, [null,null,'self', 'error_str', 'error_code']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
pyjamas.JSONService.ServiceProxy = (function(){
	var cls_instance = pyjs__class_instance('ServiceProxy');
	var cls_definition = new Object();
	cls_definition.__md5__ = '4067ccae1177a3b6757d3ad509d57bc0';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(serviceURL, serviceName) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			serviceURL = arguments[1];
			serviceName = arguments[2];
		}
		if (typeof serviceName == 'undefined') serviceName=null;

		pyjamas.JSONService.JSONService.__init__(self, serviceURL);
		self.__serviceName = serviceName;
		return null;
	}
	, 1, [null,null,'self', 'serviceURL', 'serviceName']);
	cls_definition.__call__ = pyjs__bind_method(cls_instance, '__call__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
			var params = new Array();
			for (var pyjs__va_arg = 0; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				params.push(pyjs__arg);
			}
			params = pyjslib.Tuple(params);

		} else {
			var self = arguments[0];
			var params = new Array();
			for (var pyjs__va_arg = 1; pyjs__va_arg < arguments.length; pyjs__va_arg++) {
				var pyjs__arg = arguments[pyjs__va_arg];
				params.push(pyjs__arg);
			}
			params = pyjslib.Tuple(params);

		}
		var handler;
		if (pyjslib.bool(pyjslib.hasattr(params.__getitem__(-1), String('onRemoteResponse')))) {
			handler = params.__getitem__(-1);
			return pyjamas.JSONService.JSONService.sendRequest(self, (typeof self.__serviceName == 'function' && self.__is_instance__?pyjslib.getattr(self, '__serviceName'):self.__serviceName), pyjslib.slice(params, null, -1), handler);
		}
		else {
			return pyjamas.JSONService.JSONService.sendNotify(self, (typeof self.__serviceName == 'function' && self.__is_instance__?pyjslib.getattr(self, '__serviceName'):self.__serviceName), params);
		}
		return null;
	}
	, 1, ['params',null,'self']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.JSONService.JSONService));
})();
pyjamas.JSONService.JSONProxy = (function(){
	var cls_instance = pyjs__class_instance('JSONProxy');
	var cls_definition = new Object();
	cls_definition.__md5__ = '034af4cc2cc936211c2661a17d63b4a5';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(url, methods) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			url = arguments[1];
			methods = arguments[2];
		}
		if (typeof methods == 'undefined') methods=null;

		self._serviceURL = url;
		return null;
	}
	, 1, [null,null,'self', 'url', 'methods']);
	cls_definition.__createMethod = pyjs__bind_method(cls_instance, '__createMethod', function(method) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			method = arguments[1];
		}

 		return null;
	}
	, 1, [null,null,'self', 'method']);
	cls_definition.__registerMethods = pyjs__bind_method(cls_instance, '__registerMethods', function(methods) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			methods = arguments[1];
		}

 		return null;
	}
	, 1, [null,null,'self', 'methods']);
	cls_definition.__getattr__ = pyjs__bind_method(cls_instance, '__getattr__', function(name) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			name = arguments[1];
		}

		return pyjamas.JSONService.ServiceProxy((typeof self._serviceURL == 'function' && self.__is_instance__?pyjslib.getattr(self, '_serviceURL'):self._serviceURL), name);
	}
	, 1, [null,null,'self', 'name']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.JSONService.JSONService));
})();
return this;
}; /* end pyjamas.JSONService */
$pyjs.modules_hash['pyjamas.JSONService'] = $pyjs.loaded_modules['pyjamas.JSONService'];


 /* end module: pyjamas.JSONService */


/*
PYJS_DEPS: ['sys', 'pyjamas.HTTPRequest.HTTPRequest', 'pyjamas', 'pyjamas.HTTPRequest', 'pygwt', 'jsonrpc.json.dumps', 'jsonrpc', 'jsonrpc.json', 'jsonrpc.json.loads', 'jsonrpc.json.JSONDecodeException']
*/
