/* start module: pyjamas.ui.Focus */
pyjamas.ui.Focus = $pyjs.loaded_modules["pyjamas.ui.Focus"] = function (__mod_name__) {
if(pyjamas.ui.Focus.__was_initialized__) return pyjamas.ui.Focus;
pyjamas.ui.Focus.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Focus';
var __name__ = pyjamas.ui.Focus.__name__ = __mod_name__;
var Focus = pyjamas.ui.Focus;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Focus');
pyjamas.ui.Focus.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjamas.ui.Focus.blur = function(elem) {

	elem.blur();
	return null;
};
pyjamas.ui.Focus.blur.__name__ = 'blur';

pyjamas.ui.Focus.blur.__bind_type__ = 0;
pyjamas.ui.Focus.blur.__args__ = [null,null,'elem'];
pyjamas.ui.Focus.createFocusable = function() {
	var e;
	e = pyjamas.ui.Focus.DOM.createDiv();
	e.tabIndex = 0;
	return e;
};
pyjamas.ui.Focus.createFocusable.__name__ = 'createFocusable';

pyjamas.ui.Focus.createFocusable.__bind_type__ = 0;
pyjamas.ui.Focus.createFocusable.__args__ = [null,null];
pyjamas.ui.Focus.focus = function(elem) {


        try {
            elem.focus();
        } catch (e) {
            // Only trap the exception if the attempt was mostly legit
            if (!elem || !elem.focus) {
                // Rethrow the probable NPE or invalid type
                throw e;
            }
        }
    
};
pyjamas.ui.Focus.focus.__name__ = 'focus';

pyjamas.ui.Focus.focus.__bind_type__ = 0;
pyjamas.ui.Focus.focus.__args__ = [null,null,'elem'];
pyjamas.ui.Focus.getTabIndex = function(elem) {

	return (typeof elem.tabIndex == 'function' && elem.__is_instance__?pyjslib.getattr(elem, 'tabIndex'):elem.tabIndex);
};
pyjamas.ui.Focus.getTabIndex.__name__ = 'getTabIndex';

pyjamas.ui.Focus.getTabIndex.__bind_type__ = 0;
pyjamas.ui.Focus.getTabIndex.__args__ = [null,null,'elem'];
pyjamas.ui.Focus.setAccessKey = function(elem, key) {

	elem.accessKey = key;
	return null;
};
pyjamas.ui.Focus.setAccessKey.__name__ = 'setAccessKey';

pyjamas.ui.Focus.setAccessKey.__bind_type__ = 0;
pyjamas.ui.Focus.setAccessKey.__args__ = [null,null,'elem', 'key'];
pyjamas.ui.Focus.setTabIndex = function(elem, index) {

	elem.tabIndex = index;
	return null;
};
pyjamas.ui.Focus.setTabIndex.__name__ = 'setTabIndex';

pyjamas.ui.Focus.setTabIndex.__bind_type__ = 0;
pyjamas.ui.Focus.setTabIndex.__args__ = [null,null,'elem', 'index'];
return this;
}; /* end pyjamas.ui.Focus */
$pyjs.modules_hash['pyjamas.ui.Focus'] = $pyjs.loaded_modules['pyjamas.ui.Focus'];


 /* end module: pyjamas.ui.Focus */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas']
*/
