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
	cls_definition.__md5__ = 'a0f823a32f317a4c33659c998d14323b';
	cls_definition.asyncPost = pyjs__bind_method(cls_instance, 'asyncPost', function(user, pwd, url, postData, handler, returnxml, content_type) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			postData = arguments[4];
			handler = arguments[5];
			returnxml = arguments[6];
			content_type = arguments[7];
		}
		if (typeof postData == 'undefined') postData=null;
		if (typeof handler == 'undefined') handler=null;
		if (typeof returnxml == 'undefined') returnxml=0;
		if (typeof content_type == 'undefined') content_type=String('text/plain charset=utf8');

		if (pyjslib.bool((postData === null))) {
			return self.asyncPostImpl(null, null, user, pwd, url, returnxml, content_type);
		}
		return self.asyncPostImpl(user, pwd, url, postData, handler, returnxml, content_type);
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'postData', 'handler', 'returnxml', 'content_type']);
	cls_definition.asyncGet = pyjs__bind_method(cls_instance, 'asyncGet', function(user, pwd, url, handler, returnxml) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			handler = arguments[4];
			returnxml = arguments[5];
		}
		if (typeof returnxml == 'undefined') returnxml=0;

		if (pyjslib.bool((url === null))) {
			return self.asyncGetImpl(null, null, user, pwd, returnxml);
		}
		return self.asyncGetImpl(user, pwd, url, handler, returnxml);
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'handler', 'returnxml']);
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


        return new XMLHttpRequest();
        
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
	cls_definition.asyncPostImpl = pyjs__bind_method(cls_instance, 'asyncPostImpl', function(user, pwd, url, postData, handler, returnxml, content_type) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			postData = arguments[4];
			handler = arguments[5];
			returnxml = arguments[6];
			content_type = arguments[7];
		}
		var pdlen;
		pdlen = pyjslib.str(pyjslib.len(postData));

        var xmlHttp = this.doCreateXmlHTTPRequest();
        try {
            xmlHttp.open("POST", url, true);
            xmlHttp.setRequestHeader("Content-Type", content_type);
            xmlHttp.setRequestHeader("Content-Length", pdlen);
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4) {
                    delete xmlHttp.onreadystatechange;
                    var localHandler = handler;
                    var response;
                    var status = xmlHttp.status;
                    if (returnxml)
                        response = xmlHttp.responseXML;
                    else
                        response = xmlHttp.responseText;
                    handler = null;
                    xmlHttp = null;
                    if(status == 200) {
                        localHandler.onCompletion(response);
                    } else {
                        localHandler.onError(response, status);
                    }
                }
            };
            xmlHttp.send(postData);
            return true;
        }
        catch (e) {
            delete xmlHttp.onreadystatechange;
            var localHandler = handler;
            handler = null;
            xmlHttp = null;
            localHandler.onError(String(e), "");
            return false;
        }
        
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'postData', 'handler', 'returnxml', 'content_type']);
	cls_definition.asyncGetImpl = pyjs__bind_method(cls_instance, 'asyncGetImpl', function(user, pwd, url, handler, returnxml) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			user = arguments[1];
			pwd = arguments[2];
			url = arguments[3];
			handler = arguments[4];
			returnxml = arguments[5];
		}
		if (typeof returnxml == 'undefined') returnxml=0;


        var xmlHttp = this.doCreateXmlHTTPRequest();
        try {
            xmlHttp.open("GET", url, true);
            if (returnxml)
                xmlHttp.setRequestHeader("Content-Type", "application/xml; charset=utf-8");
            else
                xmlHttp.setRequestHeader("Content-Type", "text/plain; charset=utf-8");
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4) {
                    delete xmlHttp.onreadystatechange;
                    var localHandler = handler;
                    var response;
                    var status = xmlHttp.status;
                    if (returnxml)
                        response = xmlHttp.responseXML;
                    else
                        response = xmlHttp.responseText;
                    handler = null;
                    xmlHttp = null;
                    if(status == 200) {
                        localHandler.onCompletion(response);
                    } else {
                        localHandler.onError(response, status);
                    }
                }
            };
            xmlHttp.send('');
            return true;
        }
        catch (e) {
            delete xmlHttp.onreadystatechange;
            var localHandler = handler;
            handler = null;
            xmlHttp = null;
            localHandler.onError(String(e), "");
            return false;
        }
        
	}
	, 1, [null,null,'self', 'user', 'pwd', 'url', 'handler', 'returnxml']);
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
