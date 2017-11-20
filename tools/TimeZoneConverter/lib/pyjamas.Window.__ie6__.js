/* start module: pyjamas.Window */
pyjamas.Window = $pyjs.loaded_modules["pyjamas.Window"] = function (__mod_name__) {
if(pyjamas.Window.__was_initialized__) return pyjamas.Window;
pyjamas.Window.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.Window';
var __name__ = pyjamas.Window.__name__ = __mod_name__;
var Window = pyjamas.Window;

pyjamas.Window.closingListeners = new pyjslib.List([]);
pyjamas.Window.resizeListeners = new pyjslib.List([]);
pyjslib.__import__(['pyjamas.pyjamas.Location', 'pyjamas.pyjamas', 'pyjamas.Location', 'pyjamas'], 'pyjamas.Location', 'pyjamas.Window');
pyjamas.Window.Location = $pyjs.__modules__.pyjamas.Location;
pyjamas.Window.init_listeners = function() {

	if (pyjslib.bool(!(pyjamas.Window.closingListeners))) {
		pyjamas.Window.closingListeners = new pyjslib.List([]);
	}
	if (pyjslib.bool(!(pyjamas.Window.resizeListeners))) {
		pyjamas.Window.resizeListeners = new pyjslib.List([]);
	}
	return null;
};
pyjamas.Window.init_listeners.__name__ = 'init_listeners';

pyjamas.Window.init_listeners.__bind_type__ = 0;
pyjamas.Window.init_listeners.__args__ = [null,null];
pyjamas.Window.addWindowCloseListener = function(listener) {

	pyjamas.Window.closingListeners.append(listener);
	return null;
};
pyjamas.Window.addWindowCloseListener.__name__ = 'addWindowCloseListener';

pyjamas.Window.addWindowCloseListener.__bind_type__ = 0;
pyjamas.Window.addWindowCloseListener.__args__ = [null,null,'listener'];
pyjamas.Window.addWindowResizeListener = function(listener) {

	pyjamas.Window.resizeListeners.append(listener);
	return null;
};
pyjamas.Window.addWindowResizeListener.__name__ = 'addWindowResizeListener';

pyjamas.Window.addWindowResizeListener.__bind_type__ = 0;
pyjamas.Window.addWindowResizeListener.__args__ = [null,null,'listener'];
pyjamas.Window.removeWindowCloseListener = function(listener) {

	pyjamas.Window.closingListeners.remove(listener);
	return null;
};
pyjamas.Window.removeWindowCloseListener.__name__ = 'removeWindowCloseListener';

pyjamas.Window.removeWindowCloseListener.__bind_type__ = 0;
pyjamas.Window.removeWindowCloseListener.__args__ = [null,null,'listener'];
pyjamas.Window.removeWindowResizeListener = function(listener) {

	pyjamas.Window.resizeListeners.remove(listener);
	return null;
};
pyjamas.Window.removeWindowResizeListener.__name__ = 'removeWindowResizeListener';

pyjamas.Window.removeWindowResizeListener.__bind_type__ = 0;
pyjamas.Window.removeWindowResizeListener.__args__ = [null,null,'listener'];
pyjamas.Window.alert = function(msg) {

	$wnd.alert(msg);
	return null;
};
pyjamas.Window.alert.__name__ = 'alert';

pyjamas.Window.alert.__bind_type__ = 0;
pyjamas.Window.alert.__args__ = [null,null,'msg'];
pyjamas.Window.confirm = function(msg) {

	return $wnd.confirm(msg);
};
pyjamas.Window.confirm.__name__ = 'confirm';

pyjamas.Window.confirm.__bind_type__ = 0;
pyjamas.Window.confirm.__args__ = [null,null,'msg'];
pyjamas.Window.prompt = function(msg, defaultReply) {
	if (typeof defaultReply == 'undefined') defaultReply=String('');

	return $wnd.prompt(msg, defaultReply);
};
pyjamas.Window.prompt.__name__ = 'prompt';

pyjamas.Window.prompt.__bind_type__ = 0;
pyjamas.Window.prompt.__args__ = [null,null,'msg', 'defaultReply'];
pyjamas.Window.enableScrolling = function(enable) {

	$doc.body.style.overflow = ((enable) && (String('auto'))) || (String('hidden'));
	return null;
};
pyjamas.Window.enableScrolling.__name__ = 'enableScrolling';

pyjamas.Window.enableScrolling.__bind_type__ = 0;
pyjamas.Window.enableScrolling.__args__ = [null,null,'enable'];
pyjamas.Window.scrollBy = function(x, y) {

	$wnd.scrollBy(x, y);
	return null;
};
pyjamas.Window.scrollBy.__name__ = 'scrollBy';

pyjamas.Window.scrollBy.__bind_type__ = 0;
pyjamas.Window.scrollBy.__args__ = [null,null,'x', 'y'];
pyjamas.Window.scroll = function(x, y) {

	$wnd.scroll(x, y);
	return null;
};
pyjamas.Window.scroll.__name__ = 'scroll';

pyjamas.Window.scroll.__bind_type__ = 0;
pyjamas.Window.scroll.__args__ = [null,null,'x', 'y'];
pyjamas.Window.getClientHeight = function() {

	return (typeof $doc.body.clientHeight == 'function' && $doc.body.__is_instance__?pyjslib.getattr($doc.body, 'clientHeight'):$doc.body.clientHeight);
};
pyjamas.Window.getClientHeight.__name__ = 'getClientHeight';

pyjamas.Window.getClientHeight.__bind_type__ = 0;
pyjamas.Window.getClientHeight.__args__ = [null,null];
pyjamas.Window.getClientWidth = function() {

	return (typeof $doc.body.clientWidth == 'function' && $doc.body.__is_instance__?pyjslib.getattr($doc.body, 'clientWidth'):$doc.body.clientWidth);
};
pyjamas.Window.getClientWidth.__name__ = 'getClientWidth';

pyjamas.Window.getClientWidth.__bind_type__ = 0;
pyjamas.Window.getClientWidth.__args__ = [null,null];
pyjamas.Window.setLocation = function(url) {
	var w;
	w = $wnd;
	w.location = url;
	return null;
};
pyjamas.Window.setLocation.__name__ = 'setLocation';

pyjamas.Window.setLocation.__bind_type__ = 0;
pyjamas.Window.setLocation.__args__ = [null,null,'url'];
pyjamas.Window.location = null;
pyjamas.Window.getLocation = function() {

	if (pyjslib.bool(!(pyjamas.Window.location))) {
		pyjamas.Window.location = pyjamas.Window.Location.Location((typeof $wnd.location == 'function' && $wnd.__is_instance__?pyjslib.getattr($wnd, 'location'):$wnd.location));
	}
	return pyjamas.Window.location;
};
pyjamas.Window.getLocation.__name__ = 'getLocation';

pyjamas.Window.getLocation.__bind_type__ = 0;
pyjamas.Window.getLocation.__args__ = [null,null];
pyjamas.Window.getTitle = function() {

	return $doc.title;
};
pyjamas.Window.getTitle.__name__ = 'getTitle';

pyjamas.Window.getTitle.__bind_type__ = 0;
pyjamas.Window.getTitle.__args__ = [null,null];
pyjamas.Window.open = function(url, name, features) {

	pyjamas.Window.document.parent.open(url, name, features);
	return null;
};
pyjamas.Window.open.__name__ = 'open';

pyjamas.Window.open.__bind_type__ = 0;
pyjamas.Window.open.__args__ = [null,null,'url', 'name', 'features'];
pyjamas.Window.setMargin = function(size) {

	$doc.body.style.margin = size;
	return null;
};
pyjamas.Window.setMargin.__name__ = 'setMargin';

pyjamas.Window.setMargin.__bind_type__ = 0;
pyjamas.Window.setMargin.__args__ = [null,null,'size'];
pyjamas.Window.setTitle = function(title) {
	var d;
	d = $doc;
	d.title = title;
	return null;
};
pyjamas.Window.setTitle.__name__ = 'setTitle';

pyjamas.Window.setTitle.__bind_type__ = 0;
pyjamas.Window.setTitle.__args__ = [null,null,'title'];
pyjamas.Window.setOnError = function(onError) {

	if (pyjslib.bool(!(pyjslib.callable(onError)))) {
		throw (pyjslib.TypeError(String('object is not callable')));
	}
    $wnd.onerror=function(msg, url, linenumber){
        return onError(msg, url, linenumber);
    }
    
};
pyjamas.Window.setOnError.__name__ = 'setOnError';

pyjamas.Window.setOnError.__bind_type__ = 0;
pyjamas.Window.setOnError.__args__ = [null,null,'onError'];
pyjamas.Window.onError = function(msg, url, linenumber) {
	var tracestr,dialog;
	dialog = $doc.createElement(String('div'));
	dialog.className = String('errordialog');
	tracestr = pyjamas.Window.sys.trackstackstr($pyjs.trackstack.slice(0,-1));
	tracestr = tracestr.replace(String('\x0A'), String('\x3Cbr /\x3E\x0A\x26nbsp\x3B\x26nbsp\x3B\x26nbsp\x3B'));
	dialog.innerHTML =  (  (  (  (  (  ( String('\x26nbsp\x3B\x3Cb style=\x22color:red\x22\x3EJavaScript Error: \x3C/b\x3E') + msg )  + String(' at line number ') )  + linenumber )  + String('. Please inform webmaster.') )  + String('\x3Cbr /\x3E\x26nbsp\x3B\x26nbsp\x3B\x26nbsp\x3B') )  + tracestr ) ;
	$doc.body.appendChild(dialog);
	return true;
};
pyjamas.Window.onError.__name__ = 'onError';

pyjamas.Window.onError.__bind_type__ = 0;
pyjamas.Window.onError.__args__ = [null,null,'msg', 'url', 'linenumber'];
pyjamas.Window.onClosed = function() {

	pyjamas.Window.fireClosedImpl();
	return null;
};
pyjamas.Window.onClosed.__name__ = 'onClosed';

pyjamas.Window.onClosed.__bind_type__ = 0;
pyjamas.Window.onClosed.__args__ = [null,null];
pyjamas.Window.onClosing = function() {

	pyjamas.Window.fireClosingImpl();
	return null;
};
pyjamas.Window.onClosing.__name__ = 'onClosing';

pyjamas.Window.onClosing.__bind_type__ = 0;
pyjamas.Window.onClosing.__args__ = [null,null];
pyjamas.Window.onResize = function() {

	pyjamas.Window.fireResizedImpl();
	return null;
};
pyjamas.Window.onResize.__name__ = 'onResize';

pyjamas.Window.onResize.__bind_type__ = 0;
pyjamas.Window.onResize.__args__ = [null,null];
pyjamas.Window.fireClosedAndCatch = function(handler) {

 	return null;
};
pyjamas.Window.fireClosedAndCatch.__name__ = 'fireClosedAndCatch';

pyjamas.Window.fireClosedAndCatch.__bind_type__ = 0;
pyjamas.Window.fireClosedAndCatch.__args__ = [null,null,'handler'];
pyjamas.Window.fireClosedImpl = function() {
	var listener;
	var __listener = pyjamas.Window.closingListeners.__iter__();
	try {
		while (true) {
			var listener = __listener.next();
			
			listener.onWindowClosed();
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return null;
};
pyjamas.Window.fireClosedImpl.__name__ = 'fireClosedImpl';

pyjamas.Window.fireClosedImpl.__bind_type__ = 0;
pyjamas.Window.fireClosedImpl.__args__ = [null,null];
pyjamas.Window.fireClosingAndCatch = function(handler) {

 	return null;
};
pyjamas.Window.fireClosingAndCatch.__name__ = 'fireClosingAndCatch';

pyjamas.Window.fireClosingAndCatch.__bind_type__ = 0;
pyjamas.Window.fireClosingAndCatch.__args__ = [null,null,'handler'];
pyjamas.Window.resize = function(width, height) {

	$wnd.resizeTo(width, height);
	return null;
};
pyjamas.Window.resize.__name__ = 'resize';

pyjamas.Window.resize.__bind_type__ = 0;
pyjamas.Window.resize.__args__ = [null,null,'width', 'height'];
pyjamas.Window.resizeBy = function(width, height) {

	$wnd.resizeBy(width, height);
	return null;
};
pyjamas.Window.resizeBy.__name__ = 'resizeBy';

pyjamas.Window.resizeBy.__bind_type__ = 0;
pyjamas.Window.resizeBy.__args__ = [null,null,'width', 'height'];
pyjamas.Window.fireClosingImpl = function() {
	var listener,msg,ret;
	ret = null;
	var __listener = pyjamas.Window.closingListeners.__iter__();
	try {
		while (true) {
			var listener = __listener.next();
			
			msg = listener.onWindowClosing();
			if (pyjslib.bool((ret === null))) {
				ret = msg;
			}
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return ret;
};
pyjamas.Window.fireClosingImpl.__name__ = 'fireClosingImpl';

pyjamas.Window.fireClosingImpl.__bind_type__ = 0;
pyjamas.Window.fireClosingImpl.__args__ = [null,null];
pyjamas.Window.fireResizedAndCatch = function(handler) {

 	return null;
};
pyjamas.Window.fireResizedAndCatch.__name__ = 'fireResizedAndCatch';

pyjamas.Window.fireResizedAndCatch.__bind_type__ = 0;
pyjamas.Window.fireResizedAndCatch.__args__ = [null,null,'handler'];
pyjamas.Window.fireResizedImpl = function() {
	var listener;
	var __listener = pyjamas.Window.resizeListeners.__iter__();
	try {
		while (true) {
			var listener = __listener.next();
			
			listener.onWindowResized(pyjamas.Window.getClientWidth(), pyjamas.Window.getClientHeight());
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return null;
};
pyjamas.Window.fireResizedImpl.__name__ = 'fireResizedImpl';

pyjamas.Window.fireResizedImpl.__bind_type__ = 0;
pyjamas.Window.fireResizedImpl.__args__ = [null,null];
pyjamas.Window.init = function() {

	pyjslib.__import__(['pyjamas.sys', 'sys'], 'sys', 'pyjamas.Window');
	pyjamas.Window.sys = $pyjs.__modules__.sys;
	pyjamas.Window.init_listeners();

    $wnd.__pygwt_initHandlers(
        function() {
            Window.onResize();
        },
        function() {
            return Window.onClosing();
        },
        function() {
            Window.onClosed();
            /*$wnd.onresize = null;
            $wnd.onbeforeclose = null;
            $wnd.onclose = null;*/
        }
    );
    
	pyjamas.Window.setOnError(pyjamas.Window.onError);
	return null;
};
pyjamas.Window.init.__name__ = 'init';

pyjamas.Window.init.__bind_type__ = 0;
pyjamas.Window.init.__args__ = [null,null];
pyjamas.Window.init();
return this;
}; /* end pyjamas.Window */
$pyjs.modules_hash['pyjamas.Window'] = $pyjs.loaded_modules['pyjamas.Window'];


 /* end module: pyjamas.Window */


/*
PYJS_DEPS: ['pyjamas.Location', 'pyjamas', 'sys']
*/
