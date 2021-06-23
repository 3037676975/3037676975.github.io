<script type="text/javascript" src="static/crypto-js.js"></script>
<script type="text/javascript" src="static/md5.min.js"></script>
<script type="text/javascript" src="static/tools.js"></script>
<script type="text/javascript">
var __0x2bbcb=['MRfChw==', 'Y0LDoMKSQXPCocOG', 'wpgXwo/DisKWYMOpPQ==', 'wpwMwpjDm8KRM8KpfMKRwqHCnTbDgzLDnMObwp7DssOBQsKuwp5XExPChSNvGVRkacK/wpDDqA5O', 'w5E9BsOD', 'wqTDs8OLw5Qo', 'D8KLccK6bGhUNg==', 'BcKMwoLCug==', 'w67DqcOaw5lhHWcG', 'BSbDgMKDwq3ChXMWVcOTwrp7woQ=', 'ViHCtMOODsK5w5FqeCvCr35xwpgUw7A=', 'w7RxwpvDok3CosOBE3/Cn2pMwqUvwrPDnA==', 'wrk8w5k=', 'asORwro=', 'czR0w6oe', 'WcOlw7U=', 'wpHDqsK/woE=', 'woQZwp7DmMKH', 'cyFOJQ==', 'SsOWwpw='];
(function(_0x4af14a, _0x5c227b) {
    var _0x594ced = function(_0x41c181) {
        while (--_0x41c181) {
            _0x4af14a['push'](_0x4af14a['shift']());
        }
    };
    _0x594ced(++_0x5c227b);
}(__0x2bbcb, 0x1ac));
var xxxxxxxx = function(_0xbfa860, _0x4fb412) {
    _0xbfa860 = _0xbfa860 - 0x0;
    var result = __0x2bbcb[_0xbfa860];
    if (xxxxxxxx['initialized'] === undefined) {
        (function() {
            var _0x52633c = typeof window !== 'undefined' ? window : typeof process === 'object' && typeof require === 'function' && typeof global === 'object' ? global : this;
            var _0x295ce4 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
            _0x52633c['atob'] || (_0x52633c['atob'] = function(_0x4f21c9) {
                var _0x59c802 = String(_0x4f21c9)['replace'](/=+$/, '');
                for (var _0x51bc11 = 0x0, _0x352379, _0x2e87cb, _0x28d0b0 = 0x0, _0x5a78c5 = ''; _0x2e87cb = _0x59c802['charAt'](_0x28d0b0++); ~_0x2e87cb && (_0x352379 = _0x51bc11 % 0x4 ? _0x352379 * 0x40 + _0x2e87cb : _0x2e87cb,
                _0x51bc11++ % 0x4) ? _0x5a78c5 += String['fromCharCode'](0xff & _0x352379 >> (-0x2 * _0x51bc11 & 0x6)) : 0x0) {
                    _0x2e87cb = _0x295ce4['indexOf'](_0x2e87cb);
                }
                return _0x5a78c5;
            }
            );
        }());
        var _0x159a83 = function(_0x43efa4, _0x24f6b3) {
            var _0x58e448 = [], _0x580f34 = 0x0, _0x154017, _0x142838 = '', _0x277119 = '';
            _0x43efa4 = atob(_0x43efa4);
            for (var _0x48a6ee = 0x0, _0x17bc14 = _0x43efa4['length']; _0x48a6ee < _0x17bc14; _0x48a6ee++) {
                _0x277119 += '%' + ('00' + _0x43efa4['charCodeAt'](_0x48a6ee)['toString'](0x10))['slice'](-0x2);
            }
            _0x43efa4 = decodeURIComponent(_0x277119);
            for (var _0x3e766f = 0x0; _0x3e766f < 0x100; _0x3e766f++) {
                _0x58e448[_0x3e766f] = _0x3e766f;
            }
            for (_0x3e766f = 0x0; _0x3e766f < 0x100; _0x3e766f++) {
                _0x580f34 = (_0x580f34 + _0x58e448[_0x3e766f] + _0x24f6b3['charCodeAt'](_0x3e766f % _0x24f6b3['length'])) % 0x100;
                _0x154017 = _0x58e448[_0x3e766f];
                _0x58e448[_0x3e766f] = _0x58e448[_0x580f34];
                _0x58e448[_0x580f34] = _0x154017;
            }
            _0x3e766f = 0x0;
            _0x580f34 = 0x0;
            for (var _0x1962b3 = 0x0; _0x1962b3 < _0x43efa4['length']; _0x1962b3++) {
                _0x3e766f = (_0x3e766f + 0x1) % 0x100;
                _0x580f34 = (_0x580f34 + _0x58e448[_0x3e766f]) % 0x100;
                _0x154017 = _0x58e448[_0x3e766f];
                _0x58e448[_0x3e766f] = _0x58e448[_0x580f34];
                _0x58e448[_0x580f34] = _0x154017;
                _0x142838 += String['fromCharCode'](_0x43efa4['charCodeAt'](_0x1962b3) ^ _0x58e448[(_0x58e448[_0x3e766f] + _0x58e448[_0x580f34]) % 0x100]);
            }
            return _0x142838;
        };
        xxxxxxxx['rc4'] = _0x159a83;
        xxxxxxxx['data'] = {};
        xxxxxxxx['initialized'] = !![];
    }
    var _0x2b7546 = xxxxxxxx['data'][_0xbfa860];
    if (_0x2b7546 === undefined) {
        if (xxxxxxxx['once'] === undefined) {
            xxxxxxxx['once'] = !![];
        }
        result = xxxxxxxx['rc4'](result, _0x4fb412);
        xxxxxxxx['data'][_0xbfa860] = result;
    } else {
        result = _0x2b7546;
    }
    return result;
};
var key_base = xxxxxxxx('0x2', 'm01N');
var iv_base = xxxxxxxx('0x3', 'QhCB');
var sigu = function(_0x863dc6) {
    var _0xdd9192 = CryptoJS[xxxxxxxx('0x4', '&LS2')](key_base);
    var _0xabb2bf = CryptoJS[xxxxxxxx('0x5', '47Bi')]['Utf8'][xxxxxxxx('0x6', '$(m!')](_0xdd9192);
    var _0x4a40eb = CryptoJS[xxxxxxxx('0x7', '6*j!')][xxxxxxxx('0x8', 'LxXq')][xxxxxxxx('0x9', '&LS2')](iv_base);
    var _0x524343 = CryptoJS['AES']['encrypt'](_0x863dc6, _0xabb2bf, {
        'iv': _0x4a40eb,
        'mode': CryptoJS[xxxxxxxx('0xa', 'xfpS')][xxxxxxxx('0xb', '7$dT')],
        'padding': CryptoJS[xxxxxxxx('0xc', 'kYzH')]['ZeroPadding']
    });
    return _0x524343[xxxxxxxx('0xd', 'TR7Y')]();
};

layui.use(['layer'], function(){
	var layer = layui.layer
		$ = layui.jquery;
	$.ajax({
		url:'{:url('index/video/x')}',
		data:{key:sigu('{$key[1]}'),url:'{$url[1]}'},
		type:'POST',
		success:function(s){
			var x = s;
			console.log(s);
			$.ajax({
				url:'{:url('index/video/x2')}',
				data:{id:x.id,md5:sign(x.md5)},
				type:'POST',
				success:function(s){
					console.log(s);
				}
			});
		}
	});
});
</script>
