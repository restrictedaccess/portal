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
	return null;
};
pyjamas.History.back.__name__ = 'back';

pyjamas.History.back.__bind_type__ = 0;
pyjamas.History.back.__args__ = [null,null];
pyjamas.History.forward = function() {

	$wnd.history.forward();
	return null;
};
pyjamas.History.forward.__name__ = 'forward';

pyjamas.History.forward.__bind_type__ = 0;
pyjamas.History.forward.__args__ = [null,null];
pyjamas.History.getToken = function() {

	return pyjamas.History.historyToken;
};
pyjamas.History.getToken.__name__ = 'getToken';

pyjamas.History.getToken.__bind_type__ = 0;
pyjamas.History.getToken.__args__ = [null,null];
pyjamas.History.newItem = function(historyToken) {

	pyjslib.printFunc([String('History - new item'), historyToken], 1);
	pyjamas.History.onHistoryChanged(historyToken);
	return null;

    if(historyToken == "" || historyToken == null){
        historyToken = "#";
    }
    $wnd.location.hash = encodeURIComponent(historyToken);
    
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

	pyjslib.printFunc([String('history: TODO')], 1);
	pyjamas.History.__historyToken = String('');
	pyjamas.History.onHistoryChanged(pyjamas.History.__historyToken);
	return null;

    $wnd.__historyToken = '';

    // Get the initial token from the url's hash component.
    var hash = $wnd.location.hash;
    if (hash.length > 0)
        $wnd.__historyToken = decodeURIComponent(hash.substring(1));

    // Create the timer that checks the browser's url hash every 1/4 s.
    $wnd.__checkHistory = function() {
        var token = '', hash = $wnd.location.hash;
        if (hash.length > 0)
            token = decodeURIComponent(hash.substring(1));

        if (token != $wnd.__historyToken) {
            $wnd.__historyToken = token;
            // TODO - move init back into History
            // this.onHistoryChanged(token);
            var h = new __History_History();
            h.onHistoryChanged(token);
        }

        $wnd.setTimeout('__checkHistory()', 250);
    };

    // Kick off the timer.
    $wnd.__checkHistory();

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
