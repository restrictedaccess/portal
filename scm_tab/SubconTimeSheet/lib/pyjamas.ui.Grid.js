/* start module: pyjamas.ui.Grid */
pyjamas.ui.Grid = $pyjs.loaded_modules["pyjamas.ui.Grid"] = function (__mod_name__) {
if(pyjamas.ui.Grid.__was_initialized__) return pyjamas.ui.Grid;
pyjamas.ui.Grid.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.ui.Grid';
var __name__ = pyjamas.ui.Grid.__name__ = __mod_name__;
var Grid = pyjamas.ui.Grid;

pyjslib.__import__(['pyjamas.ui.pyjamas.DOM', 'pyjamas.ui.pyjamas', 'pyjamas.DOM', 'pyjamas'], 'pyjamas.DOM', 'pyjamas.ui.Grid');
pyjamas.ui.Grid.DOM = $pyjs.__modules__.pyjamas.DOM;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui.pyjamas.ui.HTMLTable', 'pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui.HTMLTable'], 'pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui.Grid');
pyjamas.ui.Grid.HTMLTable = $pyjs.__modules__.pyjamas.ui.HTMLTable.HTMLTable;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.pyjamas.ui.CellFormatter', 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.CellFormatter'], 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.Grid');
pyjamas.ui.Grid.CellFormatter = $pyjs.__modules__.pyjamas.ui.CellFormatter.CellFormatter;
pyjslib.__import__(['pyjamas.ui.pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.pyjamas.ui.RowFormatter', 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.RowFormatter'], 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.Grid');
pyjamas.ui.Grid.RowFormatter = $pyjs.__modules__.pyjamas.ui.RowFormatter.RowFormatter;
pyjamas.ui.Grid.Grid = (function(){
	var cls_instance = pyjs__class_instance('Grid');
	var cls_definition = new Object();
	cls_definition.__md5__ = '06f9ceeb0e63327a412ada7b38cd15c2';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(rows, columns) {
		if (this.__is_instance__ === true) {
			var self = this;
			var kwargs = arguments.length >= 3 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		} else {
			var self = arguments[0];
			rows = arguments[1];
			columns = arguments[2];
			var kwargs = arguments.length >= 4 ? arguments[arguments.length-1] : arguments[arguments.length];
			if (typeof kwargs != 'object' || kwargs.__is_instance__ !== true || kwargs.__name__ != 'Dict') {
				kwargs = arguments[arguments.length+1];
			}
		}
		if (typeof kwargs == 'undefined') {
			kwargs = pyjslib.Dict({});
			if (typeof columns != 'undefined') {
				if (pyjslib.get_pyjs_classtype(columns) == 'Dict') {
					kwargs = columns;
					columns = arguments[3];
				}
			} else 			if (typeof rows != 'undefined') {
				if (pyjslib.get_pyjs_classtype(rows) == 'Dict') {
					kwargs = rows;
					rows = arguments[3];
				}
			} else 			if (typeof self != 'undefined') {
				if (pyjslib.get_pyjs_classtype(self) == 'Dict') {
					kwargs = self;
					self = arguments[3];
				}
			} else {
			}
		}
		if (typeof rows == 'undefined') rows=0;
		if (typeof columns == 'undefined') columns=0;

		self.numColumns = 0;
		self.numRows = 0;
		pyjs_kwargs_call(pyjamas.ui.Grid.HTMLTable, '__init__', null, kwargs, [{}, self]);
		if (pyjslib.bool(((pyjslib.cmp(rows, 0) == 1)) || ((pyjslib.cmp(columns, 0) == 1)))) {
			self.resize(rows, columns);
		}
		return null;
	}
	, 1, [null,'kwargs','self', 'rows', 'columns']);
	cls_definition.resize = pyjs__bind_method(cls_instance, 'resize', function(rows, columns) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			rows = arguments[1];
			columns = arguments[2];
		}

		self.resizeColumns(columns);
		self.resizeRows(rows);
		return null;
	}
	, 1, [null,null,'self', 'rows', 'columns']);
	cls_definition.resizeColumns = pyjs__bind_method(cls_instance, 'resizeColumns', function(columns) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			columns = arguments[1];
		}
		var i,j;
		if (pyjslib.bool(pyjslib.eq((typeof self.numColumns == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numColumns'):self.numColumns), columns))) {
			return null;
		}
		if (pyjslib.bool((pyjslib.cmp((typeof self.numColumns == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numColumns'):self.numColumns), columns) == 1))) {
			var __i = pyjslib.range(0, (typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows)).__iter__();
			try {
				while (true) {
					var i = __i.next();
					
					var __j = pyjslib.range( ( (typeof self.numColumns == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numColumns'):self.numColumns) - 1 ) ,  ( columns - 1 ) , -1).__iter__();
					try {
						while (true) {
							var j = __j.next();
							
							self.removeCell(i, j);
						}
					} catch (e) {
						if (e.__name__ != 'StopIteration') {
							throw e;
						}
					}
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
		}
		else {
			var __i = pyjslib.range((typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows)).__iter__();
			try {
				while (true) {
					var i = __i.next();
					
					var __j = pyjslib.range((typeof self.numColumns == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numColumns'):self.numColumns), columns).__iter__();
					try {
						while (true) {
							var j = __j.next();
							
							self.insertCell(i, j);
						}
					} catch (e) {
						if (e.__name__ != 'StopIteration') {
							throw e;
						}
					}
				}
			} catch (e) {
				if (e.__name__ != 'StopIteration') {
					throw e;
				}
			}
		}
		self.numColumns = columns;
		return null;
	}
	, 1, [null,null,'self', 'columns']);
	cls_definition.resizeRows = pyjs__bind_method(cls_instance, 'resizeRows', function(rows) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			rows = arguments[1];
		}

		if (pyjslib.bool(pyjslib.eq((typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows), rows))) {
			return null;
		}
		if (pyjslib.bool((pyjslib.cmp((typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows), rows) == -1))) {
			self.addRows(self.getBodyElement(),  ( rows - (typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows) ) , (typeof self.numColumns == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numColumns'):self.numColumns));
			self.numRows = rows;
		}
		else {
    while (pyjslib.bool((pyjslib.cmp((typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows), rows) == 1))) {
			self.numRows -= 1;
			self.removeRow((typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows));
    }
		}
		return null;
	}
	, 1, [null,null,'self', 'rows']);
	cls_definition.createCell = pyjs__bind_method(cls_instance, 'createCell', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var td;
		td = pyjamas.ui.Grid.HTMLTable.createCell(self);
		pyjamas.ui.Grid.DOM.setInnerHTML(td, String('\x26nbsp\x3B'));
		return td;
	}
	, 1, [null,null,'self']);
	cls_definition.clearCell = pyjs__bind_method(cls_instance, 'clearCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
		}
		var b,td;
		td = self.cellFormatter.getElement(row, column);
		b = pyjamas.ui.Grid.HTMLTable.internalClearCell(self, td);
		pyjamas.ui.Grid.DOM.setInnerHTML(td, String('\x26nbsp\x3B'));
		return b;
	}
	, 1, [null,null,'self', 'row', 'column']);
	cls_definition.prepareCell = pyjs__bind_method(cls_instance, 'prepareCell', function(row, column) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			row = arguments[1];
			column = arguments[2];
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

		return (typeof self.numColumns == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numColumns'):self.numColumns);
	}
	, 1, [null,null,'self', 'row']);
	cls_definition.getColumnCount = pyjs__bind_method(cls_instance, 'getColumnCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.numColumns == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numColumns'):self.numColumns);
	}
	, 1, [null,null,'self']);
	cls_definition.getRowCount = pyjs__bind_method(cls_instance, 'getRowCount', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.numRows == 'function' && self.__is_instance__?pyjslib.getattr(self, 'numRows'):self.numRows);
	}
	, 1, [null,null,'self']);
	cls_definition.addRows = pyjs__bind_method(cls_instance, 'addRows', function(table, numRows, columns) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			table = arguments[1];
			numRows = arguments[2];
			columns = arguments[3];
		}
		var cell,cellNum,td,rowNum,row;
		td = pyjamas.ui.Grid.DOM.createElement(String('td'));
		pyjamas.ui.Grid.DOM.setInnerHTML(td, String('\x26nbsp\x3B'));
		row = pyjamas.ui.Grid.DOM.createElement(String('tr'));
		var __cellNum = pyjslib.range(columns).__iter__();
		try {
			while (true) {
				var cellNum = __cellNum.next();
				
				cell = td.cloneNode(true);
				row.appendChild(cell);
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		var __rowNum = pyjslib.range(numRows).__iter__();
		try {
			while (true) {
				var rowNum = __rowNum.next();
				
				table.appendChild(row.cloneNode(true));
			}
		} catch (e) {
			if (e.__name__ != 'StopIteration') {
				throw e;
			}
		}
		return null;
	}
	, 1, [null,null,'self', 'table', 'numRows', 'columns']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjamas.ui.Grid.HTMLTable));
})();
return this;
}; /* end pyjamas.ui.Grid */
$pyjs.modules_hash['pyjamas.ui.Grid'] = $pyjs.loaded_modules['pyjamas.ui.Grid'];


 /* end module: pyjamas.ui.Grid */


/*
PYJS_DEPS: ['pyjamas.DOM', 'pyjamas', 'pyjamas.ui.HTMLTable.HTMLTable', 'pyjamas.ui', 'pyjamas.ui.HTMLTable', 'pyjamas.ui.CellFormatter.CellFormatter', 'pyjamas.ui.CellFormatter', 'pyjamas.ui.RowFormatter.RowFormatter', 'pyjamas.ui.RowFormatter']
*/
