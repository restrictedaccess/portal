/* start module: pyjamas.ui.FlexCellFormatter */
pyjamas.ui.FlexCellFormatter = $pyjs.loaded_modules["pyjamas.ui.FlexCellFormatter"] = function (__mod_name__) {
if(pyjamas.ui.FlexCellFormatter.__was_initialized__) return pyjamas.ui.FlexCellFormatter;
pyjamas.ui.FlexCellFormatter.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.FlexCellFormatter';
var __name__ = pyjamas.ui.FlexCellFormatter.__name__ = __mod_name__;
var FlexCellFormatter = pyjamas.ui.FlexCellFormatter;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.FlexCellFormatter');
pyjamas.ui.FlexCellFormatter.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.pyjamas.ui.CellFormatter', 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.CellFormatter'], 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.FlexCellFormatter');
pyjamas.ui.FlexCellFormatter.CellFormatter = $pyjs.__modules__.pyjamas.ui.CellFormatter.CellFormatter;
pyjamas.ui.FlexCellFormatter.FlexCellFormatter = (function(){
	var cls_instance = pyjs__class_instance('FlexCellFormatter');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'ced9d5f74ffd2159aad4bf54d0606139';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(outer) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			outer = arguments[1];
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof outer != 'undefined') {
				if (pyjslib.get_pyjs_classtype(outer) == 'Dict') {
					kwargs = outer;
					outer = arguments[2];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[2];
				}
			} else {
			}
		}

		pyjs_kwargs_call(pyjamas.ui.FlexCellFormatter.CellFormatter, '__init__', null, kwargs, [{}, self, outer]);
		return null;
	}
	, 1, [null,'kwargs','self', 'outer']);
	cls_definition.getColSpan = pyjs__bind_method(cls_instance, 'getColSpan', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

		return pyjamas.ui.FlexCellFormatter.DOM.getIntAttribute(self.getElement(row, column), String('colSpan'));
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.getRowSpan = pyjs__bind_method(cls_instance, 'getRowSpan', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}

		return pyjamas.ui.FlexCellFormatter.DOM.getIntAttribute(self.getElement(row, column), String('rowSpan'));
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.setColSpan = pyjs__bind_method(cls_instance, 'setColSpan', function(row, column, colSpan) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			colSpan = arguments[3];
		}

		pyjamas.ui.FlexCellFormatter.DOM.setIntAttribute(self.ensureElement(row, column), String('colSpan'), colSpan);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'colSpan']);
	cls_definition.setRowSpan = pyjs__bind_method(cls_instance, 'setRowSpan', function(row, column, rowSpan) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			rowSpan = arguments[3];
		}

		pyjamas.ui.FlexCellFormatter.DOM.setIntAttribute(self.ensureElement(row, column), String('rowSpan'), rowSpan);
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'rowSpan']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.FlexCellFormatter.CellFormatter));
})();
return this;
}; /* end pyjamas.ui.FlexCellFormatter */
$pyjs.modules_hash['pyjamas.ui.FlexCellFormatter'] = $pyjs.loaded_modules['pyjamas.ui.FlexCellFormatter'];


 /* end module: pyjamas.ui.FlexCellFormatter */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui', 'pyjamas.ui.CellFormatter']
*/
