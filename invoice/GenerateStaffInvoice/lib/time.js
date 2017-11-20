/* start module: time */
var time = $pyjs.loaded_modules["time"] = function (__mod_name__) {
if(time.__was_initialized__) return time;
time.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'time';
var __name__ = time.__name__ = __mod_name__;
time.altzone = null;
time.timezone = 60 * (new Date()).getTimezoneOffset();
time.tzname = new pyjslib.Tuple([null, null]);
time.__c__days = new pyjslib.List([String('Sunday'), String('Monday'), String('Tuesday'), String('Wednesday'), String('Thursday'), String('Friday'), String('Saturday')]);
time.__c__months = new pyjslib.List([String('Januari'), String('Februari'), String('March'), String('April'), String('May'), String('June'), String('July'), String('August'), String('September'), String('October'), String('November'), String('December')]);
time.time = function() {

 return new Date().getTime() / 1000.0; 
};
time.time.__name__ = 'time';

time.time.__bind_type__ = 0;
time.time.__args__ = [null,null];
time.struct_time = (function(){
	var cls_instance = pyjs__class_instance('struct_time');
	var cls_definition = new Object();
	cls_definition.__md5__ = '9053637c4f7f74009ccec63ba2dde7a8';
	cls_definition.n_fields = 9;
	cls_definition.n_sequence_fields = 9;
	cls_definition.n_unnamed_fields = 0;
	cls_definition.tm_year = null;
	cls_definition.tm_mon = null;
	cls_definition.tm_mday = null;
	cls_definition.tm_hour = null;
	cls_definition.tm_min = null;
	cls_definition.tm_sec = null;
	cls_definition.tm_wday = null;
	cls_definition.tm_yday = null;
	cls_definition.tm_isdst = null;
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(ttuple) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			ttuple = arguments[1];
		}
		if (typeof ttuple == 'undefined') ttuple=null;

		if (pyjslib.bool(!((ttuple === null)))) {
			self.tm_year = ttuple.__getitem__(0);
			self.tm_mon = ttuple.__getitem__(1);
			self.tm_mday = ttuple.__getitem__(2);
			self.tm_hour = ttuple.__getitem__(3);
			self.tm_min = ttuple.__getitem__(4);
			self.tm_sec = ttuple.__getitem__(5);
			self.tm_wday = ttuple.__getitem__(6);
			self.tm_yday = ttuple.__getitem__(7);
			self.tm_isdst = ttuple.__getitem__(8);
		}
		return null;
	}
	, 1, [null,null,'self', 'ttuple']);
	cls_definition.__getitem__ = pyjs__bind_method(cls_instance, '__getitem__', function(idx) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			idx = arguments[1];
		}

		return new pyjslib.List([(typeof self.tm_year == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_year'):self.tm_year), (typeof self.tm_mon == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_mon'):self.tm_mon), (typeof self.tm_mday == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_mday'):self.tm_mday), (typeof self.tm_hour == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_hour'):self.tm_hour), (typeof self.tm_min == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_min'):self.tm_min), (typeof self.tm_sec == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_sec'):self.tm_sec), (typeof self.tm_wday == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_wday'):self.tm_wday), (typeof self.tm_yday == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_yday'):self.tm_yday), (typeof self.tm_isdst == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_isdst'):self.tm_isdst)]).__getitem__(idx);
	}
	, 1, [null,null,'self', 'idx']);
	cls_definition.__getslice__ = pyjs__bind_method(cls_instance, '__getslice__', function(lower, upper) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			lower = arguments[1];
			upper = arguments[2];
		}

		return pyjslib.slice(new pyjslib.List([(typeof self.tm_year == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_year'):self.tm_year), (typeof self.tm_mon == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_mon'):self.tm_mon), (typeof self.tm_mday == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_mday'):self.tm_mday), (typeof self.tm_hour == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_hour'):self.tm_hour), (typeof self.tm_min == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_min'):self.tm_min), (typeof self.tm_sec == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_sec'):self.tm_sec), (typeof self.tm_wday == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_wday'):self.tm_wday), (typeof self.tm_yday == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_yday'):self.tm_yday), (typeof self.tm_isdst == 'function' && self.__is_instance__?pyjslib.getattr(self, 'tm_isdst'):self.tm_isdst)]), lower, upper);
	}
	, 1, [null,null,'self', 'lower', 'upper']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
time.gmtime = function(t) {
	if (typeof t == 'undefined') t=null;
	var date,tm,startOfYear;
	if (pyjslib.bool(pyjslib.eq(t, null))) {
		t = time.time();
	}
	date = new Date(t*1000);
	tm = time.struct_time();
	tm.tm_year = date.getUTCFullYear();
	tm.tm_mon =  ( date.getUTCMonth() + 1 ) ;
	tm.tm_mday = date.getUTCDate();
	tm.tm_hour = date.getUTCHours();
	tm.tm_min = date.getUTCMinutes();
	tm.tm_sec = date.getUTCSeconds();
	tm.tm_wday =  ( date.getUTCDay() + 6 )  % 7;
	startOfYear = pyjslib.int_( ( new Date(tm.tm_year,0,1) / 1000 ) );
	tm.tm_yday =  ( 1 + pyjslib.int_( (  ( t - startOfYear )  / 86400 ) ) ) ;
	tm.tm_isdst = 0;
	return tm;
};
time.gmtime.__name__ = 'gmtime';

time.gmtime.__bind_type__ = 0;
time.gmtime.__args__ = [null,null,'t'];
time.localtime = function(t) {
	if (typeof t == 'undefined') t=null;
	var date,tm,startOfYear;
	if (pyjslib.bool(pyjslib.eq(t, null))) {
		t = time.time();
	}
	date = new Date(t*1000);
	tm = time.struct_time();
	tm.tm_year = date.getFullYear();
	tm.tm_mon =  ( date.getMonth() + 1 ) ;
	tm.tm_mday = date.getDate();
	tm.tm_hour = date.getHours();
	tm.tm_min = date.getMinutes();
	tm.tm_sec = date.getSeconds();
	tm.tm_wday =  ( date.getDay() + 6 )  % 7;
	startOfYear = pyjslib.int_( ( new Date(tm.tm_year,0,1) / 1000 ) );
	tm.tm_yday =  ( 1 + pyjslib.int_( (  ( t - startOfYear )  / 86400 ) ) ) ;
	tm.tm_isdst = date.getTimezoneOffset();
	return tm;
};
time.localtime.__name__ = 'localtime';

time.localtime.__bind_type__ = 0;
time.localtime.__args__ = [null,null,'t'];
time.mktime = function(t) {
	var tm_sec,tm_hour,tm_mday,tm_year,tm_mon,tm_min;
	tm_year = t.__getitem__(0);
	tm_mon =  ( t.__getitem__(1) - 1 ) ;
	tm_mday = t.__getitem__(2);
	tm_hour = t.__getitem__(3);
	tm_min = t.__getitem__(4);
	tm_sec = t.__getitem__(5);
return new Date(tm_year, tm_mon, tm_mday, tm_hour, tm_min, tm_sec).getTime()/1000;
};
time.mktime.__name__ = 'mktime';

time.mktime.__bind_type__ = 0;
time.mktime.__args__ = [null,null,'t'];
time.strftime = function(fmt, t) {
	if (typeof t == 'undefined') t=null;
	var firstMonday,remainder,tm_sec,re_pct,format,tm_hour,tm_mday,firstWeek,tm_year,tm_mon,tm_yday,startOfYear,date,weekNo,tm_wday,tm_min,result;
	if (pyjslib.bool((t === null))) {
		t = time.localtime();
	}
	else {
		if (pyjslib.bool((!(pyjslib.isinstance(t, time.struct_time))) && (!pyjslib.eq(pyjslib.len(t), 9)))) {
			throw (pyjslib.TypeError(String('argument must be 9-item sequence, not float')));
		}
	}
	tm_year = t.__getitem__(0);
	tm_mon = t.__getitem__(1);
	tm_mday = t.__getitem__(2);
	tm_hour = t.__getitem__(3);
	tm_min = t.__getitem__(4);
	tm_sec = t.__getitem__(5);
	tm_wday = t.__getitem__(6);
	tm_yday = t.__getitem__(7);
	date = new Date(tm_year, tm_mon - 1, tm_mday, tm_hour, tm_min, tm_sec);
	startOfYear = new Date(tm_year,0,1);
	firstMonday =  (  ( 1 -  ( startOfYear.getDay() + 6 )  % 7 )  + 7 ) ;
	firstWeek = new Date(tm_year,0,firstMonday);
	weekNo =  ( date.getTime() - firstWeek.getTime() ) ;
	if (pyjslib.bool((pyjslib.cmp(weekNo, 0) == -1))) {
		weekNo = 0;
	}
	else {
		weekNo =  ( 1 + pyjslib.int_( ( weekNo / 604800000 ) ) ) ;
	}
	format = function(c) {

		if (pyjslib.bool(pyjslib.eq(c, String('%')))) {
			return String('%');
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('a')))) {
			throw (pyjslib.NotImplementedError(pyjslib.sprintf(String('strftime format character \x27%s\x27'), c)));
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('A')))) {
			throw (pyjslib.NotImplementedError(pyjslib.sprintf(String('strftime format character \x27%s\x27'), c)));
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('b')))) {
			throw (pyjslib.NotImplementedError(pyjslib.sprintf(String('strftime format character \x27%s\x27'), c)));
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('B')))) {
			throw (pyjslib.NotImplementedError(pyjslib.sprintf(String('strftime format character \x27%s\x27'), c)));
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('c')))) {
			return date.toLocaleString();
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('d')))) {
			return pyjslib.sprintf(String('%02d'), tm_mday);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('H')))) {
			return pyjslib.sprintf(String('%02d'), tm_hour);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('I')))) {
			return pyjslib.sprintf(String('%02d'), tm_hour % 12);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('j')))) {
			return pyjslib.sprintf(String('%03d'), tm_yday);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('m')))) {
			return pyjslib.sprintf(String('%02d'), tm_mon);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('M')))) {
			return pyjslib.sprintf(String('%02d'), tm_min);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('p')))) {
			if (pyjslib.bool((pyjslib.cmp(tm_hour, 12) == -1))) {
				return String('AM');
			}
			return String('PM');
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('S')))) {
			return pyjslib.sprintf(String('%02d'), tm_sec);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('U')))) {
			throw (pyjslib.NotImplementedError(pyjslib.sprintf(String('strftime format character \x27%s\x27'), c)));
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('w')))) {
			return pyjslib.sprintf(String('%d'),  ( tm_wday + 1 )  % 7);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('W')))) {
			return pyjslib.sprintf(String('%d'), weekNo);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('x')))) {
			return pyjslib.sprintf(String('%s'), date.toLocaleDateString());
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('X')))) {
			return pyjslib.sprintf(String('%s'), date.toLocaleTimeString());
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('y')))) {
			return pyjslib.sprintf(String('%02d'), tm_year % 100);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('Y')))) {
			return pyjslib.sprintf(String('%04d'), tm_year);
		}
		else if (pyjslib.bool(pyjslib.eq(c, String('Z')))) {
			throw (pyjslib.NotImplementedError(pyjslib.sprintf(String('strftime format character \x27%s\x27'), c)));
		}
		return  ( String('%') + c ) ;
	};
	format.__name__ = 'format';

	format.__bind_type__ = 0;
	format.__args__ = [null,null,'c'];
	result = String('');
	remainder = fmt;
	re_pct = /([^%]*)%(.)(.*)/;
var a, fmtChar;
    while (pyjslib.bool(remainder)) {

        a = re_pct.exec(remainder);
        if (!a) {
            result += remainder;
            remainder = null;
        } else {
            result += a[1];
            fmtChar = a[2];
            remainder = a[3];
            if (typeof fmtChar != 'undefined') {
                result += format(fmtChar)
            }
        }
        
    }
	return result;
};
time.strftime.__name__ = 'strftime';

time.strftime.__bind_type__ = 0;
time.strftime.__args__ = [null,null,'fmt', 't'];
time.asctime = function(t) {
	if (typeof t == 'undefined') t=null;

	if (pyjslib.bool(pyjslib.eq(t, null))) {
		t = time.localtime();
	}
	return pyjslib.sprintf(String('%s %s %02d %02d:%02d:%02d %04d'), new pyjslib.Tuple([pyjslib.slice(time.__c__days.__getitem__((typeof t.tm_wday == 'function' && t.__is_instance__?pyjslib.getattr(t, 'tm_wday'):t.tm_wday)), null, 3), time.__c__months.__getitem__( ( (typeof t.tm_mon == 'function' && t.__is_instance__?pyjslib.getattr(t, 'tm_mon'):t.tm_mon) - 1 ) ), (typeof t.tm_hour == 'function' && t.__is_instance__?pyjslib.getattr(t, 'tm_hour'):t.tm_hour), (typeof t.tm_min == 'function' && t.__is_instance__?pyjslib.getattr(t, 'tm_min'):t.tm_min), (typeof t.tm_sec == 'function' && t.__is_instance__?pyjslib.getattr(t, 'tm_sec'):t.tm_sec), (typeof t.tm_year == 'function' && t.__is_instance__?pyjslib.getattr(t, 'tm_year'):t.tm_year)]));
};
time.asctime.__name__ = 'asctime';

time.asctime.__bind_type__ = 0;
time.asctime.__args__ = [null,null,'t'];
time.ctime = function(t) {
	if (typeof t == 'undefined') t=null;

	t = time.localtime();
	return time.asctime(t);
};
time.ctime.__name__ = 'ctime';

time.ctime.__bind_type__ = 0;
time.ctime.__args__ = [null,null,'t'];
return this;
}; /* end time */
$pyjs.modules_hash['time'] = $pyjs.loaded_modules['time'];


 /* end module: time */


