/* start module: pygwt */
var pygwt = $pyjs.loaded_modules["pygwt"] = function (__mod_name__) {
if(pygwt.__was_initialized__) return pygwt;
pygwt.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pygwt';
var __name__ = pygwt.__name__ = __mod_name__;
pygwt.sNextHashId = 0;
pygwt.getNextHashId = function() {

	pygwt.sNextHashId += 1;
	return pygwt.sNextHashId;
};
pygwt.getNextHashId.__name__ = 'getNextHashId';

pygwt.getNextHashId.__bind_type__ = 0;
pygwt.getNextHashId.__args__ = [null,null];
pygwt.getHashCode = function(o) {


    return (o == null) ? 0 :
        (o.$H ? o.$H : (o.$H = pygwt_getNextHashId()))
    
};
pygwt.getHashCode.__name__ = 'getHashCode';

pygwt.getHashCode.__bind_type__ = 0;
pygwt.getHashCode.__args__ = [null,null,'o'];
pygwt.getModuleName = function() {
	var sys,os,mod_name;
	pyjslib.__import__(['os'], 'os', 'pygwt');
	os = $pyjs.__modules__.os;
	pyjslib.__import__(['sys'], 'sys', 'pygwt');
	sys = $pyjs.__modules__.sys;
	mod_name = (typeof sys.argv == 'function' && sys.__is_instance__?pyjslib.getattr(sys, 'argv'):sys.argv).__getitem__(0);
	mod_name = os.path.split(mod_name).__getitem__(1);
	mod_name = os.path.spliext(mod_name).__getitem__(0);
	return mod_name;
};
pygwt.getModuleName.__name__ = 'getModuleName';

pygwt.getModuleName.__bind_type__ = 0;
pygwt.getModuleName.__args__ = [null,null];
pygwt.getModuleBaseURL = function() {
	var i,s;
	s = pygwt.get_main_frame().getUri();
	i = s.find(String('#'));
	if (pyjslib.bool(!pyjslib.eq(i, -1))) {
		s = pyjslib.slice(s, null, i);
	}
	i = s.find(String('?'));
	if (pyjslib.bool(!pyjslib.eq(i, -1))) {
		s = pyjslib.slice(s, null, i);
	}
	i = s.rfind(String('/'));
	if (pyjslib.bool(!pyjslib.eq(i, -1))) {
		s = pyjslib.slice(s, null, i);
	}
	if (pyjslib.bool((pyjslib.cmp(pyjslib.len(s), 0) == 1))) {
		return  ( s + String('/') ) ;
	}
	return String('');
};
pygwt.getModuleBaseURL.__name__ = 'getModuleBaseURL';

pygwt.getModuleBaseURL.__bind_type__ = 0;
pygwt.getModuleBaseURL.__args__ = [null,null];
return this;
}; /* end pygwt */
$pyjs.modules_hash['pygwt'] = $pyjs.loaded_modules['pygwt'];


 /* end module: pygwt */


/*
PYJS_DEPS: ['os', 'sys']
*/
