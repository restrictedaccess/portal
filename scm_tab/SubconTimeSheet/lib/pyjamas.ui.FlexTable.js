/* start module: pyjamas.ui.FlexTable */
pyjamas.ui.FlexTable = $pyjs.loaded_modules["pyjamas.ui.FlexTable"] = function (__mod_name__) {
if(pyjamas.ui.FlexTable.__was_initialized__) return pyjamas.ui.FlexTable;
pyjamas.ui.FlexTable.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.FlexTable';
var __name__ = pyjamas.ui.FlexTable.__name__ = __mod_name__;
var FlexTable = pyjamas.ui.FlexTable;

pyjslib.__import__(['pyjamas.ui.sys', 'sys'], 'sys', 'pyjamas.ui.FlexTable');
pyjamas.ui.FlexTable.sys = $pyjs.__modules__.sys;
if (pyjslib.bool(!new pyjslib.List([String('mozilla'), String('ie6'), String('opera'), String('oldmoz'), String('safari')]).__contains__((typeof pyjamas.ui.FlexTable.sys.platform == 'function' && pyjamas.ui.FlexTable.sys.__is_instance__?pyjslib.getattr(pyjamas.ui.FlexTable.sys, 'platform'):pyjamas.ui.FlexTable.sys.platform)))) {
}
pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.FlexTable');
pyjamas.ui.FlexTable.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui.pyjamas.ui.HTMLTable', 'pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui.HTMLTable'], 'pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui.FlexTable');
pyjamas.ui.FlexTable.HTMLTable = $pyjs.__modules__.pyjamas.ui.HTMLTable.HTMLTable;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.pyjamas.ui.RowFormatter', 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.RowFormatter'], 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.FlexTable');
pyjamas.ui.FlexTable.RowFormatter = $pyjs.__modules__.pyjamas.ui.RowFormatter.RowFormatter;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.FlexCellFormatter.FlexCellFormatter', 'pyjamas.ui.pyjamas.ui.FlexCellFormatter', 'pyjamas.ui.FlexCellFormatter.FlexCellFormatter', 'pyjamas.ui.FlexCellFormatter'], 'pyjamas.ui.FlexCellFormatter.FlexCellFormatter', 'pyjamas.ui.FlexTable');
pyjamas.ui.FlexTable.FlexCellFormatter = $pyjs.__modules__.pyjamas.ui.FlexCellFormatter.FlexCellFormatter;
pyjamas.ui.FlexTable.FlexTable = (function(){
	var cls_instance = pyjs__class_instance('FlexTable');
	var cls_definition = new Object();
	cls_definition.__md5__ = '057440f64a417c9a6b329a540302c722';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function() {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 1 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			var kwargs = arguments.length >= 2 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[1];
				}
			} else {
			}
		}

		if (pyjslib.bool(!(kwargs.has_key(String('CellFormatter'))))) {
			kwargs.__setitem__(String('CellFormatter'), pyjamas.ui.FlexTable.FlexCellFormatter(self));
		}
		pyjs_kwargs_call(pyjamas.ui.FlexTable.HTMLTable, '__init__', null, kwargs, [{}, self]);
		return null;
	}
	, 1, [null,'kwargs','self']);
	cls_definition.addCell = pyjs__bind_method(cls_instance, 'addCell', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}

		self.insertCell(row, self.getCellCount(row));
		return null;
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.getCellCount = pyjs__bind_method(cls_instance, 'getCellCount', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}

		self.checkRowBounds(row);
		return self.getDOMCellCount(self.getBodyElement(), row);
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.getFlexCellFormatter = pyjs__bind_method(cls_instance, 'getFlexCellFormatter', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.getCellFormatter();
	}
	, 1, [null,null,'self']);
	cls_definition.getRowCount = pyjs__bind_method(cls_instance, 'getRowCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return self.getDOMRowCount();
	}
	, 1, [null,null,'self']);
	cls_definition.removeCells = pyjs__bind_method(cls_instance, 'removeCells', function(row, column, num) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
			num = arguments[3];
		}
		var i;
		var __i = pyjslib.range(num).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.removeCell(row, column);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'row', 'column', 'num']);
	cls_definition.prepareCell = pyjs__bind_method(cls_instance, 'prepareCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var cellCount,required;
		self.prepareRow(row);
		cellCount = self.getCellCount(row);
		required =  (  ( column + 1 )  - cellCount ) ;
		if (pyjslib.bool((pyjslib.cmp(required, 0) == 1))) {
			self.addCells(self.getBodyElement(), row, required);
		}
		return null;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.prepareRow = pyjs__bind_method(cls_instance, 'prepareRow', function(row) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
		}
		var i,rowCount;
		rowCount = self.getRowCount();
		var __i = pyjslib.range(rowCount,  ( row + 1 ) ).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				self.insertRow(i);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.addCells = pyjs__bind_method(cls_instance, 'addCells', function(table, row, num) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			table = arguments[1];
			row = arguments[2];
			num = arguments[3];
		}
		var rowElem,i,cell;
		rowElem = table.rows.item(row);
		var __i = pyjslib.range(num).__iter__();
		try {
			while (true) {
				var i = __i.next();
				
				cell = $doc.createElement(String('td'));
				rowElem.appendChild(cell);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'table', 'row', 'num']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.FlexTable.HTMLTable));
})();
return this;
}; /* end pyjamas.ui.FlexTable */
$pyjs.modules_hash['pyjamas.ui.FlexTable'] = $pyjs.loaded_modules['pyjamas.ui.FlexTable'];


 /* end module: pyjamas.ui.FlexTable */


/*
PYJS_DEPS: ['sys', 'pyjamas.DOM', 'pyjamas', 'pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui', 'pyjamas.ui.HTMLTable', 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.RowFormatter', 'pyjamas.ui.FlexCellFormatter.FlexCellFormatter', 'pyjamas.ui.FlexCellFormatter']
*/
