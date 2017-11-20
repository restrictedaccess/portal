/* start module: pyjamas.History */
pyjamas.History = $pyjs.loaded_modules["pyjamas.History"] = function (__mod_name__) {
if(pyjamas.History.__was_initialized__) return pyjamas.History;
pyjamas.History.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.History';
var __name__ = pyjamas.History.__name__ = __mod_name__;
var History = pyjamas.History;

pyjslib.__import__(['pyjamas.sys', 'sys'], 'sys', 'pyjamas.History');
pyjamas.History.sys = $pyjs.__modules__.sys;
if (pyjslib.bool(!new pyjslib.List([String('mozilla'), String('ie6'), String('opera'), String('oldmoz'), String('safari')]).__contains__((typeof pyjamas.History.sys.platform == 'function' && pyjamas.History.sys.__is_instance__?pyjslib.getattr(pyjamas.History.sys, 'platform'):pyjamas.History.sys.platform)))) {
}
pyjamas.History.historyToken = String('');
pyjamas.History.historyListeners = new pyjslib.List([]);
pyjamas.History.addHistoryListener = function(listener) {

	pyjamas.History.historyListeners.append(listener);
	return null;
};
pyjamas.History.addHistoryListener.__name__ = 'addHistoryListener';

pyjamas.History.addHistoryListener.__bind_type__ = 0;
pyjamas.History.addHistoryListener.__args__ = [null,null,'listener'];
pyjamas.History.back = function() {


    $wnd.history.back();
    
};
pyjamas.History.back.__name__ = 'back';

pyjamas.History.back.__bind_type__ = 0;
pyjamas.History.back.__args__ = [null,null];
pyjamas.History.forward = function() {


    $wnd.history.forward();
    
};
pyjamas.History.forward.__name__ = 'forward';

pyjamas.History.forward.__bind_type__ = 0;
pyjamas.History.forward.__args__ = [null,null];
pyjamas.History.getToken = function() {


    return $wnd.__historyToken;
    
};
pyjamas.History.getToken.__name__ = 'getToken';

pyjamas.History.getToken.__bind_type__ = 0;
pyjamas.History.getToken.__args__ = [null,null];
pyjamas.History.newItem = function(historyToken) {


    var iframe = $doc.getElementById('__pygwt_historyFrame');
    iframe.contentWindow.location.href = 'history.html?' + historyToken;
    
};
pyjamas.History.newItem.__name__ = 'newItem';

pyjamas.History.newItem.__bind_type__ = 0;
pyjamas.History.newItem.__args__ = [null,null,'historyToken'];
pyjamas.History.onHistoryChanged = function(historyToken) {

	pyjamas.History.fireHistoryChangedImpl(historyToken);
	return null;
};
pyjamas.History.onHistoryChanged.__name__ = 'onHistoryChanged';

pyjamas.History.onHistoryChanged.__bind_type__ = 0;
pyjamas.History.onHistoryChanged.__args__ = [null,null,'historyToken'];
pyjamas.History.fireHistoryChangedAndCatch = function() {

 	return null;
};
pyjamas.History.fireHistoryChangedAndCatch.__name__ = 'fireHistoryChangedAndCatch';

pyjamas.History.fireHistoryChangedAndCatch.__bind_type__ = 0;
pyjamas.History.fireHistoryChangedAndCatch.__args__ = [null,null];
pyjamas.History.fireHistoryChangedImpl = function(historyToken) {
	var listener;
	var __listener = pyjamas.History.historyListeners.__iter__();
	try {
		while (true) {
			var listener = __listener.next();
			
			listener.onHistoryChanged(historyToken);
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return null;
};
pyjamas.History.fireHistoryChangedImpl.__name__ = 'fireHistoryChangedImpl';

pyjamas.History.fireHistoryChangedImpl.__bind_type__ = 0;
pyjamas.History.fireHistoryChangedImpl.__args__ = [null,null,'historyToken'];
pyjamas.History.removeHistoryListener = function(listener) {

	pyjamas.History.historyListeners.remove(listener);
	return null;
};
pyjamas.History.removeHistoryListener.__name__ = 'removeHistoryListener';

pyjamas.History.removeHistoryListener.__bind_type__ = 0;
pyjamas.History.removeHistoryListener.__args__ = [null,null,'listener'];
pyjamas.History.init = function() {


    // Check for existence of the history frame.
    var historyFrame = $doc.getElementById('__pygwt_historyFrame');
    if (!historyFrame)
        return false;

    // Get the initial token from the url's hash component.
    var hash = $wnd.location.hash;
    if (hash.length > 0)
        $wnd.__historyToken = decodeURIComponent(hash.substring(1));
    else
        $wnd.__historyToken = '';

    // Initialize the history iframe.  If '__historyToken' already exists, then
    // we're probably backing into the app, so _don't_ set the iframe's location.
    var tokenElement = null;
    if (historyFrame.contentWindow) {
        var doc = historyFrame.contentWindow.document;
        tokenElement = doc ? doc.getElementById('__historyToken') : null;
    }

    if (tokenElement)
        $wnd.__historyToken = tokenElement.value;
    else
        historyFrame.src = 'history.html?' + encodeURIComponent($wnd.__historyToken);

    // Expose the '__onHistoryChanged' function, which will be called by
    // the history frame when it loads.
    $wnd.__onHistoryChanged = function(token) {
        // Change the URL and notify the application that its history frame
        // is changing.
        if (token != $wnd.__historyToken) {
            $wnd.__historyToken = token;

            // TODO(jgw): fix the bookmark update, if possible.  The following code
            // screws up the browser by (a) making it pretend that it's loading the
            // page indefinitely, and (b) causing all text to disappear (!)
            //        var base = $wnd.location.href;
            //        var hashIdx = base.indexOf('#');
            //        if (hashIdx != -1)
            //          base = base.substring(0, hashIdx);
            //        $wnd.location.replace(base + '#' + token);

            // TODO - move init back into History
            // this.onHistoryChanged(token);
            pyjamas.History.onHistoryChanged(token);
        }
    };

    return true;
    
};
pyjamas.History.init.__name__ = 'init';

pyjamas.History.init.__bind_type__ = 0;
pyjamas.History.init.__args__ = [null,null];
pyjamas.History.init();
return this;
}; /* end pyjamas.History */
$pyjs.modules_hash['pyjamas.History'] = $pyjs.loaded_modules['pyjamas.History'];


 /* end module: pyjamas.History */


/*
PYJS_DEPS: ['sys']
*/
