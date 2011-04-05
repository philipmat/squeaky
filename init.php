<?php
class a2{
	
	function encode($url){
		$url = strrev(base64_encode($url));
		$time = md5(time());
		$str = substr($time,0,rand(5,10));
		$rnd = rand(2,strlen($url)-2);
		$u1 = substr($url,0,$rnd);
		$u2 = substr($url,$rnd);
		$url = $u1 . $str . $u2;
		$rnd = (string)$rnd;
		if(strlen($rnd) == 1){
			$rnd = '0' . $rnd;
		}
		$timelen = strlen($str);
		if(strlen($timelen) == 1){
			$timelen = '0' . $timelen;
		}
		return strrev(base64_encode($timelen . str_rot13($rnd . $url)));

	}
	
	function decode($url){
		 $url = strrev($url);
		 $url = base64_decode($url);
		 $timelen = substr($url,0,2);
		 $url = substr_replace($url,'',0,2);
		 $url = str_rot13($url);
		 $offset = substr($url,0,2);
		 $url = substr_replace($url,'',0,2);
		 $url = substr_replace($url,'',(int)($offset),(int)($timelen));
		 $url = strrev($url);
		 $url = base64_decode($url);
		 return $url;
	}

	function strToCode($string){
		/*$scripts = a2::splitJS($string);
		$string = a2::removeJS($string);
		$coded = NULL;
		foreach ($scripts[0] as $script) {
		$coded .= $script . "\n";
		}*/
		$coded = '<script language="javascript" type="text/javascript"> document.write(Utf8.decode(String.fromCharCode(';
		for ($i = 0; $i < strlen($string); $i++) 
		{ 
			$coded .= ord($string{$i}) . ','; 
		}
		$coded = substr_replace($coded,'',-1,1);
		$coded .= '))); </script>';
		return($coded);
	}
	
	function splitJS($string){
		@preg_match_all('/<[\s\/]*script\b[^>]*>[^>]*<\/script>/i', $string, $scripts);
		return $scripts;
	}
	
	function removeJS($string){
		return @preg_replace('/<[\s\/]*script\b[^>]*>[^>]*<\/script>/i','',$string);
	}
	
	function _base64_encode($string){
		return base64_encode(strrev(base64_encode(strrev($string))));
	}
	
	function _base64_decode($string){
		return strrev(base64_decode(strrev(base64_decode($string))));
	}
	
	function _str_rot13_encode($string){
		return str_rot13(strrev($string));
	}
	function _str_rot13_decode($string){
		return strrev(str_rot13($string));
	}
	
	function encodeUrl4js($string){
		return base64_encode(str_rot13(base64_encode(strrev(rawurlencode($string)))));
	}
	
	function decodeUrl4js($string){
		return rawurldecode(strrev(base64_decode(str_rot13(base64_decode($string)))));
	}
	
}
?>