/* start module: pyjamas.Location */
pyjamas.Location = $pyjs.loaded_modules["pyjamas.Location"] = function (__mod_name__) {
if(pyjamas.Location.__was_initialized__) return pyjamas.Location;
pyjamas.Location.__was_initialized__ = true;
if (__mod_name__ == null) __mod_name__ = 'pyjamas.Location';
var __name__ = pyjamas.Location.__name__ = __mod_name__;
var Location = pyjamas.Location;

pyjamas.Location.makeUrlDict = function(s) {
	var pair,dict,pairs,kv;
	dict = new pyjslib.Dict([]);
	pairs = s.split(String('\x26'));
	var __pair = pairs.__iter__();
	try {
		while (true) {
			var pair = __pair.next();
			
			if (pyjslib.bool((pyjslib.cmp(pyjslib.len(pair), 3) == -1))) {
				continue;
			}
			kv = pair.split(String('='), 1);
			dict.__setitem__(kv.__getitem__(0), kv.__getitem__(1));
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return dict;
};
pyjamas.Location.makeUrlDict.__name__ = 'makeUrlDict';

pyjamas.Location.makeUrlDict.__bind_type__ = 0;
pyjamas.Location.makeUrlDict.__args__ = [null,null,'s'];
pyjamas.Location.makeUrlStringFromDict = function(d) {
	var k,pairs,temp_k,v;
	pairs = new pyjslib.List([]);
	var __temp_k = d.iteritems().__iter__();
	try {
		while (true) {
			var temp_k = __temp_k.next();
				var k = temp_k.__getitem__(0);	var v = temp_k.__getitem__(1);
			pairs.append( (  ( k + String('=') )  + v ) );
		}
	} catch (e) {
		if (e.__name__ != 'StopIteration') {
			throw e;
		}
	}
	return String('\x26').join(pairs);
};
pyjamas.Location.makeUrlStringFromDict.__name__ = 'makeUrlStringFromDict';

pyjamas.Location.makeUrlStringFromDict.__bind_type__ = 0;
pyjamas.Location.makeUrlStringFromDict.__args__ = [null,null,'d'];
pyjamas.Location.Location = (function(){
	var cls_instance = pyjs__class_instance('Location');
	var cls_definition = new Object();
	cls_definition.__md5__ = 'a4fcff30ca40a643570eae7172c36034';
	cls_definition.__init__ = pyjs__bind_method(cls_instance, '__init__', function(location) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			location = arguments[1];
		}

		self.location = location;
		self.searchDict = null;
		return null;
	}
	, 1, [null,null,'self', 'location']);
	cls_definition.getHash = pyjs__bind_method(cls_instance, 'getHash', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.location.hash == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'hash'):self.location.hash);
	}
	, 1, [null,null,'self']);
	cls_definition.getHashDict = pyjs__bind_method(cls_instance, 'getHashDict', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool((!((typeof self.hashDict == 'function' && self.__is_instance__?pyjslib.getattr(self, 'hashDict'):self.hashDict))) || (!pyjslib.eq((typeof self.hashDictHash == 'function' && self.__is_instance__?pyjslib.getattr(self, 'hashDictHash'):self.hashDictHash), self.getHash())))) {
			self.hashDictHash = self.getHash();
			self.hashDict = pyjamas.Location.makeUrlDict(pyjslib.slice(self.getHash(), 1, null));
		}
		return (typeof self.hashDict == 'function' && self.__is_instance__?pyjslib.getattr(self, 'hashDict'):self.hashDict);
	}
	, 1, [null,null,'self']);
	cls_definition.getHost = pyjs__bind_method(cls_instance, 'getHost', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.location.host == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'host'):self.location.host);
	}
	, 1, [null,null,'self']);
	cls_definition.getHostname = pyjs__bind_method(cls_instance, 'getHostname', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.location.hostname == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'hostname'):self.location.hostname);
	}
	, 1, [null,null,'self']);
	cls_definition.getHref = pyjs__bind_method(cls_instance, 'getHref', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.location.href == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'href'):self.location.href);
	}
	, 1, [null,null,'self']);
	cls_definition.getPageHref = pyjs__bind_method(cls_instance, 'getPageHref', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}
		var href;
		href = (typeof self.location.href == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'href'):self.location.href);
		if (pyjslib.bool(href.find(String('?')))) {
			href = href.split(String('?')).__getitem__(0);
		}
		if (pyjslib.bool(href.find(String('#')))) {
			href = href.split(String('#')).__getitem__(0);
		}
		return href;
	}
	, 1, [null,null,'self']);
	cls_definition.getPathname = pyjs__bind_method(cls_instance, 'getPathname', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.location.pathname == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'pathname'):self.location.pathname);
	}
	, 1, [null,null,'self']);
	cls_definition.getPort = pyjs__bind_method(cls_instance, 'getPort', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.location.port == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'port'):self.location.port);
	}
	, 1, [null,null,'self']);
	cls_definition.getProtocol = pyjs__bind_method(cls_instance, 'getProtocol', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return (typeof self.location.protocol == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'protocol'):self.location.protocol);
	}
	, 1, [null,null,'self']);
	cls_definition.getSearch = pyjs__bind_method(cls_instance, 'getSearch', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		return  ( String('') + (typeof self.location.search == 'function' && self.location.__is_instance__?pyjslib.getattr(self.location, 'search'):self.location.search) ) ;
	}
	, 1, [null,null,'self']);
	cls_definition.getSearchDict = pyjs__bind_method(cls_instance, 'getSearchDict', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		if (pyjslib.bool(pyjslib.isinstance((typeof self.location == 'function' && self.__is_instance__?pyjslib.getattr(self, 'location'):self.location), pyjslib.str))) {
			return new pyjslib.Dict([]);
		}
		if (pyjslib.bool(!((typeof self.searchDict == 'function' && self.__is_instance__?pyjslib.getattr(self, 'searchDict'):self.searchDict)))) {
			self.searchDict = pyjamas.Location.makeUrlDict(pyjslib.slice(self.getSearch(), 1, null));
		}
		return (typeof self.searchDict == 'function' && self.__is_instance__?pyjslib.getattr(self, 'searchDict'):self.searchDict);
	}
	, 1, [null,null,'self']);
	cls_definition.getSearchVar = pyjs__bind_method(cls_instance, 'getSearchVar', function(key) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			key = arguments[1];
		}
		var searchDict;
		searchDict = self.getSearchDict();
		return searchDict.get(key);
	}
	, 1, [null,null,'self', 'key']);
	cls_definition.reload = pyjs__bind_method(cls_instance, 'reload', function() {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
		}

		self.location.reload();
		return null;
	}
	, 1, [null,null,'self']);
	cls_definition.setHref = pyjs__bind_method(cls_instance, 'setHref', function(href) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			href = arguments[1];
		}

		self.location.href = href;
		return null;
	}
	, 1, [null,null,'self', 'href']);
	cls_definition.setSearch = pyjs__bind_method(cls_instance, 'setSearch', function(search) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			search = arguments[1];
		}

		self.location.search = search;
		return null;
	}
	, 1, [null,null,'self', 'search']);
	cls_definition.setSearchDict = pyjs__bind_method(cls_instance, 'setSearchDict', function(searchDict) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			searchDict = arguments[1];
		}

		self.setSearch(pyjamas.Location.makeUrlStringFromDict(searchDict));
		return null;
	}
	, 1, [null,null,'self', 'searchDict']);
	cls_definition.setHash = pyjs__bind_method(cls_instance, 'setHash', function(hash) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			hash = arguments[1];
		}

		self.location.hash = hash;
		return null;
	}
	, 1, [null,null,'self', 'hash']);
	cls_definition.setHashDict = pyjs__bind_method(cls_instance, 'setHashDict', function(hashDict) {
		if (this.__is_instance__ === true) {
			var self = this;
		} else {
			var self = arguments[0];
			hashDict = arguments[1];
		}

		self.setHash(pyjamas.Location.makeUrlStringFromDict(hashDict));
		return null;
	}
	, 1, [null,null,'self', 'hashDict']);
	return pyjs__class_function(cls_instance, cls_definition, 
	                            new Array(pyjslib.object));
})();
return this;
}; /* end pyjamas.Location */
$pyjs.modules_hash['pyjamas.Location'] = $pyjs.loaded_modules['pyjamas.Location'];


 /* end module: pyjamas.Location */


