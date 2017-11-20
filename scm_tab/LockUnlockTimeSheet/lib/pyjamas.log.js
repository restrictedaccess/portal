/* start module: pyjamas.log */
pyjamas.log = $pyjs.loaded_modules["pyjamas.log"] = function (__mod_name__) {
if(pyjamas.log.__was_initialized__) return pyjamas.log;
pyjamas.log.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.log';
var __name__ = pyjamas.log.__name__ = __mod_name__;
var log = pyjamas.log;

pyjslib.__import__(['pyjamas.pyjamas.DOM', 'pyjamas.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.log');
pyjamas.log.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjamas.log.getBodyElement = function() {

	return (typeof $doc.body == 'function' && $doc.__is_instance__?pyjslib.getattr($doc, 'body'):$doc.body);
};
pyjamas.log.getBodyElement.__name__ = 'getBodyElement';

pyjamas.log.getBodyElement.__bind_type__ = 0;
pyjamas.log.getBodyElement.__args__ = [null,null];
pyjamas.log.write = function(text) {

	pyjamas.log.add_elem();
	text = text.replace(String('\x0A'), String('\x3Cbr /\x3E\x0A'));
	pyjamas.log.data += text;
	pyjamas.log.DOM.setInnerHTML(pyjamas.log.element, pyjamas.log.data);
	return null;
};
pyjamas.log.write.__name__ = 'write';

pyjamas.log.write.__bind_type__ = 0;
pyjamas.log.write.__args__ = [null,null,'text'];
pyjamas.log.writebr = function(text) {

	pyjamas.log.write( ( text + String('\x0A') ) );
	return null;
};
pyjamas.log.writebr.__name__ = 'writebr';

pyjamas.log.writebr.__bind_type__ = 0;
pyjamas.log.writebr.__args__ = [null,null,'text'];
pyjamas.log.data = String('');
pyjamas.log.element = null;
pyjamas.log.add_elem = function() {

	if (pyjslib.bool((pyjamas.log.element !== null))) {
		return null;
	}
	pyjamas.log.element = pyjamas.log.DOM.createDiv();
	pyjamas.log.DOM.appendChild(pyjamas.log.getBodyElement(), pyjamas.log.element);
	return null;
};
pyjamas.log.add_elem.__name__ = 'add_elem';

pyjamas.log.add_elem.__bind_type__ = 0;
pyjamas.log.add_elem.__args__ = [null,null];
return this;
}; /* end pyjamas.log */
$pyjs.modules_hash['pyjamas.log'] = $pyjs.loaded_modules['pyjamas.log'];


 /* end module: pyjamas.log */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas']
*/
