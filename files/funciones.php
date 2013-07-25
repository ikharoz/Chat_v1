<?php
	function curl($url,$params = array(),$is_coockie_set = false)
	{

		if(!$is_coockie_set){
			/* STEP 1. let’s create a cookie file */
			$ckfile = tempnam ("/tmp", "CURLCOOKIE");

			/* STEP 2. visit the homepage to set the cookie properly */
			$ch = curl_init ($url);
			curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec ($ch);
		}

		$str = ''; $str_arr= array();
		foreach($params as $key => $value)
		{
			$str_arr[] = urlencode($key)."=".urlencode($value);
		}
		if(!empty($str_arr))
			$str = '?'.implode('&',$str_arr);

		/* STEP 3. visit cookiepage.php */

		$Url = $url.$str;

		$ch = curl_init ($Url);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");

		$output = curl_exec ($ch);
		return $output;
	}

?>
