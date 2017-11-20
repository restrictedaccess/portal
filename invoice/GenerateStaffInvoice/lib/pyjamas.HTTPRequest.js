/* start module: pyjamas.HTTPRequest */
pyjamas.HTTPRequest = $pyjs.loaded_modules["pyjamas.HTTPRequest"] = function (__mod_name__) {
if(pyjamas.HTTPRequest.__was_initialized__) return pyjamas.HTTPRequest;
pyjamas.HTTPRequest.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.HTTPRequest';
var __name__ = pyjamas.HTTPRequest.__name__ = __mod_name__;
var HTTPRequest = pyjamas.HTTPRequest;

pyjslib.__import__(['pyjamas.sys', 'sys'], 'sys', 'pyjamas.HTTPRequest');
pyjamas.HTTPRequest.sys = $pyjs.__modules__.sys;
pyjslib.__import__(['pyjamas.pygwt', 'pygwt'], 'pygwt', 'pyjamas.HTTPRequest');
pyjamas.HTTPRequest.pygwt = $pyjs.__modules__.pygwt;
if (pyjslib.bool(!new pyjslib.List([String('mozilla'), String('ie6'), String('opera'), String('oldmoz'), String('safari')]).__contains__((typeof pyjamas.HTTPRequest.sys.platform == 'function' && pyjamas.HTTPRequest.sys.__is_instance__?pyjslib.getattr(pyjamas.HTTPRequest.sys, 'platform'):pyjamas.HTTPRequest.sys.platform)))) {
}
pyjamas.HTTPRequest.handlers = new pyjslib.Dict([]);
pyjamas.HTTPRequest.HTTPRequest = (function(){
	var cls_instance = pyjs__class_instance('HTTPRequest');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'afe5605b7dd591af6232870b83939797';
	cls_definition.asyncPost = pyjs__bind_method(cls_instance, 'asyncPost', function(user, pwd, url, postData, handler, return_xml, content_type) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			postData = arguments[4];
			handler = arguments[5];
			return_xml = arguments[6];
			content_type = arguments[7];
		}
		if (typeof postData == 'undefined') postData=null;
		if (typeof handler == 'undefined') handler=null;
		if (typeof return_xml == 'undefined') return_xml=0;
		if (typeof content_type == 'undefined') content_type=String('text/plain charset=utf8');

		if (pyjslib.bool((postData === null))) {
			return self.asyncPostImpl(null, null, user, pwd, url, return_xml, content_type);
		}
		return self.asyncPostImpl(user, pwd, url, postData, handler, return_xml, content_type);
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'postData', 'handler', 'return_xml', 'content_type']);
	cls_definition.asyncGet = pyjs__bind_method(cls_instance, 'asyncGet', function(user, pwd, url, handler) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			handler = arguments[4];
		}
		if (typeof url == 'undefined') url=null;
		if (typeof handler == 'undefined') handler=null;

		if (pyjslib.bool((url === null))) {
			return self.asyncGetImpl(null, null, user, pwd);
		}
		return self.asyncGetImpl(user, pwd, url, handler);
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'handler']);
	cls_definition.createXmlHTTPRequest = pyjs__bind_method(cls_instance, 'createXmlHTTPRequest', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.doCreateXmlHTTPRequest();
	}
	, 1, [null,null,'self']);
	cls_definition.doCreateXmlHTTPRequest = pyjs__bind_method(cls_instance, 'doCreateXmlHTTPRequest', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.HTTPRequest.get_main_frame().getXmlHttpRequest();
	}
	, 1, [null,null,'self']);
	cls_definition.onLoad = pyjs__bind_method(cls_instance, 'onLoad', function(sender, event, ignorearg) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			sender = arguments[1];
			event = arguments[2];
			ignorearg = arguments[3];
		}
		var status,localHandler,xmlHttp,handler,responseText;
		xmlHttp = (typeof event.target == 'function' && event.__is_instance__?pyjslib.getattr(event, 'target'):event.target);
		localHandler = pyjamas.HTTPRequest.handlers.get(xmlHttp);
    pyjamas.HTTPRequest.handlers.__delitem__(xmlHttp);
		responseText = (typeof xmlHttp.responseText == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'responseText'):xmlHttp.responseText);
		status = (typeof xmlHttp.status == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'status'):xmlHttp.status);
		handler = null;
		xmlHttp = null;
		if (pyjslib.bool(pyjslib.eq(status, 0))) {
			pyjslib.printFunc([String('HACK ALERT! webkit wrapper returns 0 not 200!')], 1);
		}
		if (pyjslib.bool((pyjslib.eq(status, 200)) || (pyjslib.eq(status, 0)))) {
			localHandler.onCompletion(responseText);
		}
		else {
			localHandler.onError(responseText, status);
		}
		return null;
	}
	, 1, [null,null,'self', 'sender', 'event', 'ignorearg']);
	cls_definition.onReadyStateChange = pyjs__bind_method(cls_instance, 'onReadyStateChange', function(xmlHttp, event, ignorearg) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			xmlHttp = arguments[1];
			event = arguments[2];
			ignorearg = arguments[3];
		}
		var status,localHandler,err,handler,pyjs_try_err,responseText;
		try {
			xmlHttp = pyjamas.HTTPRequest.get_main_frame().gobject_wrap(xmlHttp);
		} catch(pyjs_try_err) {
			var pyjs_try_err_name = (typeof pyjs_try_err.__name__ == 'undefined' ? pyjs_try_err.name : pyjs_try_err.__name__ );
			$pyjs.__last_exception__ = {error: pyjs_try_err, module: pyjamas.HTTPRequest, try_lineno: 51};
			{
				$pyjs.__last_exception__.except_lineno = 54;
				err = pyjs_try_err;
			} 		}
		pyjslib.printFunc([(typeof xmlHttp.readyState == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'readyState'):xmlHttp.readyState)], 1);
		if (pyjslib.bool(!pyjslib.eq((typeof xmlHttp.readyState == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'readyState'):xmlHttp.readyState), 4))) {
			return null;
		}
		localHandler = pyjamas.HTTPRequest.handlers.get(xmlHttp);
    pyjamas.HTTPRequest.handlers.__delitem__(xmlHttp);
		responseText = (typeof xmlHttp.responseText == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'responseText'):xmlHttp.responseText);
		pyjslib.printFunc([String('headers'), xmlHttp.getAllResponseHeaders()], 1);
		status = (typeof xmlHttp.status == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'status'):xmlHttp.status);
		handler = null;
		xmlHttp = null;
		pyjslib.printFunc([String('status'), status], 1);
		pyjslib.printFunc([String('local handler'), localHandler], 1);
		if (pyjslib.bool(pyjslib.eq(status, 0))) {
			pyjslib.printFunc([String('HACK ALERT! webkit wrapper returns 0 not 200!')], 1);
		}
		if (pyjslib.bool((pyjslib.eq(status, 200)) || (pyjslib.eq(status, 0)))) {
			localHandler.onCompletion(responseText);
		}
		else {
			localHandler.onError(responseText, status);
		}
		return null;
	}
	, 1, [null,null,'self', 'xmlHttp', 'event', 'ignorearg']);
	cls_definition._convertUrlToAbsolute = pyjs__bind_method(cls_instance, '_convertUrlToAbsolute', function(url) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			url = arguments[1];
		}
		var uri,slash,sep;
		uri = pyjamas.HTTPRequest.pygwt.getModuleBaseURL();
		if (pyjslib.bool(pyjslib.eq(url.__getitem__(0), String('/')))) {
			sep = uri.find(String('://'));
			if (pyjslib.bool(!(uri.startswith(String('file://'))))) {
				slash = uri.find(String('/'),  ( sep + 3 ) );
				if (pyjslib.bool((pyjslib.cmp(slash, 0) == 1))) {
					uri = pyjslib.slice(uri, null, slash);
				}
			}
			return pyjslib.sprintf(String('%s%s'), new pyjslib.Tuple([uri, url]));
		}
		else {
			if (pyjslib.bool((!pyjslib.eq(pyjslib.slice(url, null, 7), String('file://'))) && (!pyjslib.eq(pyjslib.slice(url, null, 7), String('http://'))) && (!pyjslib.eq(pyjslib.slice(url, null, 8), String('https://'))))) {
				slash = uri.rfind(String('/'));
				return  ( pyjslib.slice(uri, null,  ( slash + 1 ) ) + url ) ;
			}
		}
		return url;
	}
	, 1, [null,null,'self', 'url']);
	cls_definition.asyncPostImpl = pyjs__bind_method(cls_instance, 'asyncPostImpl', function(user, pwd, url, postData, handler, return_xml, content_type) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			postData = arguments[4];
			handler = arguments[5];
			return_xml = arguments[6];
			content_type = arguments[7];
		}
		var mf,xmlHttp;
		mf = pyjamas.HTTPRequest.get_main_frame();
		xmlHttp = self.doCreateXmlHTTPRequest();
		url = self._convertUrlToAbsolute(url);
		pyjslib.printFunc([String('xmlHttp'), user, pwd, url, postData, handler, pyjslib.dir(xmlHttp)], 1);
		if (pyjslib.bool((pyjslib.eq((typeof mf.platform == 'function' && mf.__is_instance__?pyjslib.getattr(mf, 'platform'):mf.platform), String('webkit'))) || (pyjslib.eq((typeof mf.platform == 'function' && mf.__is_instance__?pyjslib.getattr(mf, 'platform'):mf.platform), String('mshtml'))))) {
			xmlHttp.open(String('POST'), url, true, String(''), String(''));
		}
		else {
			pyjslib.printFunc([(typeof xmlHttp.open == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'open'):xmlHttp.open), pyjslib.dir((typeof xmlHttp.open == 'function' && xmlHttp.__is_instance__?pyjslib.getattr(xmlHttp, 'open'):xmlHttp.open))], 1);
			pyjslib.printFunc([url, xmlHttp.open(String('POST'), url)], 1);
		}
		xmlHttp.setRequestHeader(String('Content-Type'), content_type);
		xmlHttp.setRequestHeader(String('Content-Length'), pyjslib.str(pyjslib.len(postData)));
		if (pyjslib.bool((pyjslib.eq((typeof mf.platform == 'function' && mf.__is_instance__?pyjslib.getattr(mf, 'platform'):mf.platform), String('webkit'))) || (pyjslib.eq((typeof mf.platform == 'function' && mf.__is_instance__?pyjslib.getattr(mf, 'platform'):mf.platform), String('mshtml'))))) {
			mf._addXMLHttpRequestEventListener(xmlHttp, String('onreadystatechange'), (typeof self.onReadyStateChange == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onReadyStateChange'):self.onReadyStateChange));
		}
		else {
			mf._addXMLHttpRequestEventListener(xmlHttp, String('load'), (typeof self.onLoad == 'function' && self.__is_instance__?pyjslib.getattr(self, 'onLoad'):self.onLoad));
		}
		pyjamas.HTTPRequest.handlers.__setitem__(xmlHttp, handler);
		xmlHttp.send(postData);
		return true;
		handler = null;
		xmlHttp = null;
		pyjamas.HTTPRequest.localHandler.onError(pyjslib.str(pyjamas.HTTPRequest.e));
		return false;
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'postData', 'handler', 'return_xml', 'content_type']);
	cls_definition.asyncGetImpl = pyjs__bind_method(cls_instance, 'asyncGetImpl', function(user, pwd, url, handler) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			handler = arguments[4];
		}
		var mf,xmlHttp;
		mf = pyjamas.HTTPRequest.get_main_frame();
		url = self._convertUrlToAbsolute(url);
		xmlHttp = self.doCreateXmlHTTPRequest();
		pyjslib.printFunc([pyjslib.dir(xmlHttp)], 1);
		pyjslib.printFunc([user, pwd, url, handler], 1);
		if (pyjslib.bool(pyjslib.eq((typeof mf.platform == 'function' && mf.__is_instance__?pyjslib.getattr(mf, 'platform'):mf.platform), String('webkit')))) {
			xmlHttp.open(String('GET'), url, true, user, pwd);
		}
		else {
			xmlHttp.open(String('GET'), url);
		}
		xmlHttp.setRequestHeader(String('Content-Type'), String('text/plain charset=utf-8'));
		xmlHttp.send(String(''));
		return true;
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'handler']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
return this;
}; /* end pyjamas.HTTPRequest */
$pyjs.modules_hash['pyjamas.HTTPRequest'] = $pyjs.loaded_modules['pyjamas.HTTPRequest'];


 /* end module: pyjamas.HTTPRequest */


/*
PYJS_DEPS: ['sys', 'pygwt']
*/
