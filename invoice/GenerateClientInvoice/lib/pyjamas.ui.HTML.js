/* start module: pyjamas.ui.HTML */
pyjamas.ui.HTML = $pyjs.loaded_modules["pyjamas.ui.HTML"] = function (__mod_name__) {
if(pyjamas.ui.HTML.__was_initialized__) return pyjamas.ui.HTML;
pyjamas.ui.HTML.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.HTML';
var __name__ = pyjamas.ui.HTML.__name__ = __mod_name__;
var HTML = pyjamas.ui.HTML;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.HTML');
pyjamas.ui.HTML.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Label.Label', 'pyjamas.ui.pyjamas.ui.Label', 'pyjamas.ui.Label.Label', 'pyjamas.ui.Label'], 'pyjamas.ui.Label.Label', 'pyjamas.ui.HTML');
pyjamas.ui.HTML.Label = $pyjs.__modules__.pyjamas.ui.Label.Label;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.Event', 'pyjamas.ui.pyjamas.ui', 'pyjamas.ui.Event', 'pyjamas.ui'], 'pyjamas.ui.Event', 'pyjamas.ui.HTML');
pyjamas.ui.HTML.Event = $pyjs.__modules__.pyjamas.ui.Event;
pyjamas.ui.HTML.HTML = (function(){
	var cls_instance = pyjs__class_instance('HTML');
	var cls_definition = new Object();
	cls_definition.__md5__ = '798cbd3ced816069e80070e4f581c775';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(html, wordWrap, element) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			html = arguments[1];
			wordWrap = arguments[2];
			element = arguments[3];
			var kwargs = arguments.length >= 5 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof element != 'undefined') {
				if (pyjslib.get_pyjs_classtype(element) == 'Dict') {
					kwargs = element;
					element = arguments[4];
				}
			} else 			if (typeof wordWrap != 'undefined') {
				if (pyjslib.get_pyjs_classtype(wordWrap) == 'Dict') {
					kwargs = wordWrap;
					wordWrap = arguments[4];
				}
			} else 			if (typeof html != 'undefined') {
				if (pyjslib.get_pyjs_classtype(html) == 'Dict') {
					kwargs = html;
					html = arguments[4];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[4];
				}
			} else {
			}
		}
		if (typeof html == 'undefined') html=null;
		if (typeof wordWrap == 'undefined') wordWrap=true;
		if (typeof element == 'undefined') element=null;

		if (pyjslib.bool(!(kwargs.has_key(String('StyleName'))))) {
			kwargs.__setitem__(String('StyleName'), String('gwt-HTML'));
		}
		if (pyjslib.bool(html)) {
			kwargs.__setitem__(String('HTML'), html);
		}
		kwargs.__setitem__(String('WordWrap'), wordWrap);
		if (pyjslib.bool((element === null))) {
			element = pyjamas.ui.HTML.DOM.createDiv();
		}
		self.setElement(element);
		pyjs_kwargs_call(pyjamas.ui.HTML.Label, '__init__', null, kwargs, [{}, self]);
		self.sinkEvents((((typeof pyjamas.ui.HTML.Event.ONCLICK == 'function' && pyjamas.ui.HTML.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.HTML.Event, 'ONCLICK'):pyjamas.ui.HTML.Event.ONCLICK) | (typeof pyjamas.ui.HTML.Event.MOUSEEVENTS == 'function' && pyjamas.ui.HTML.Event.__is_instance__?pyjslib.getattr(pyjamas.ui.HTML.Event, 'MOUSEEVENTS'):pyjamas.ui.HTML.Event.MOUSEEVENTS))));
		return null;
	}
	, 1, [null,'kwargs','self', 'html', 'wordWrap', 'element']);
	cls_definition.getHTML = pyjs__bind_method(cls_instance, 'getHTML', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return pyjamas.ui.HTML.DOM.getInnerHTML(self.getElement());
	}
	, 1, [null,null,'self']);
	cls_definition.setHTML = pyjs__bind_method(cls_instance, 'setHTML', function(html) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			html = arguments[1];
		}

		pyjamas.ui.HTML.DOM.setInnerHTML(self.getElement(), html);
		return null;
	}
	, 1, [null,null,'self', 'html']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.HTML.Label));
})();
return this;
}; /* end pyjamas.ui.HTML */
$pyjs.modules_hash['pyjamas.ui.HTML'] = $pyjs.loaded_modules['pyjamas.ui.HTML'];


 /* end module: pyjamas.ui.HTML */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.Label.Label', 'pyjamas.ui', 'pyjamas.ui.Label', 'pyjamas.ui.Event']
*/
