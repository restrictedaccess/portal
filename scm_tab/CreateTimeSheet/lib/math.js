/* start module: math */
var math = $pyjs.loaded_modules["math"] = function (__mod_name__) {
if(math.__was_initialized__) return math;
math.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'math';
var __name__ = math.__name__ = __mod_name__;

math.ceil = Math.ceil;
math.fabs = Math.abs;
math.floor = Math.floor;
math.exp = Math.exp;
math.log = Math.log;
math.pow = Math.pow;
math.sqrt = Math.sqrt;
math.cos = Math.cos;
math.sin = Math.sin;
math.tan = Math.tan;
math.acos = Math.acos;
math.asin = Math.asin;
math.atan = Math.atan;
math.atan2 = Math.atan2;
math.pi = Math.PI;
math.e = Math.E;

math.ldexp = function(x, i) {

	return  ( x * Math.pow(2,i) ) ;
};
math.ldexp.__name__ = 'ldexp';

math.ldexp.__bind_type__ = 0;
math.ldexp.__args__ = [null,null,'x', 'i'];
math.__log2__ = math.log(2);
math.frexp = function(x) {
	var e,m;
	if (pyjslib.bool(pyjslib.eq(x, 0))) {
		return new pyjslib.Tuple([0.0, 0]);
	}
	e =  ( pyjslib.int_( ( math.log(pyjslib.abs(x)) / math.__log2__ ) ) + 1 ) ;
	m =  ( x / Math.pow(2.0,e) ) ;
	return new pyjslib.Tuple([m, e]);
};
math.frexp.__name__ = 'frexp';

math.frexp.__bind_type__ = 0;
math.frexp.__args__ = [null,null,'x'];
return this;
}; /* end math */
$pyjs.modules_hash['math'] = $pyjs.loaded_modules['math'];


 /* end module: math */


