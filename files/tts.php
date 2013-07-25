<?php
// FileName: tts.php
/*
 *  A PHP Class that converts Text into Speech using Google's Text to Speech API
 *
 * Author:
 * Abu Ashraf Masnun
 * http://masnun.com
 *
 */
 
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

	
	function Traducir2($word,$conversionA)
	{
		$word =  str_replace(". ",".",$word);
		$word = urlencode($word);
		$url = 'http://translate.google.com.mx/translate_a/t?client=t&text='.$word.'&hl=en&sl=auto&tl='.$conversionA.'&ie=UTF-8&oe=UTF-8&multires=1&otf=1&ssel=0&tsel=0&uptl='.$conversionA;			
		$name_en = curl($url);
		$name_en = str_replace(".",". ",$name_en);
		$name_en = explode('"',$name_en);		
		return $name_en[1];
	}

class TextToSpeech {

    public $mp3data;
    public $ogg;
    
    function __construct($text="") {

	//FOR MP3 TO OGG
    require "audioconvert_class_inc.php";
       
        $text = trim($text);
        if(!empty($text)) {
            $text = urlencode($text);
            //http://translate.google.com/translate_tts?tl=en&q=text
            //$this->mp3data = file_get_contents("http://translate.google.com/translate_tts?tl=en&ie=UTF-8&q={$text}");
			$this->mp3data = curl("http://translate.google.com/translate_tts?tl=en&q={$text}");
            //echo "data: " . $this->mp3data;
        }
    }
 
 
//////////////////////////////////////
//									//
// 	ONLY USING THIS SECTION OF TTS  //
//									//
//////////////////////////////////////
 
 
    function setText($text,$file_name,$idioma) {
        $text = trim($text);
        if(!empty($text)) {
            $text = urlencode($text);
            
           // $this->mp3data = file_get_contents("http://translate.google.com/translate_tts?tl={$idioma}&q={$text}");   
			$this->mp3data = curl("http://translate.google.com/translate_tts?tl={$idioma}&ie=UTF-8&q={$text}&total=1&idx=0&prev=input");
			//$this->mp3data = curl("http://translate.google.com/translate_tts?ie=UTF-8&q=%E3%81%93%E3%82%93%E3%81%AB%E3%81%A1%E3%81%AF%E3%81%93%E3%82%93%E3%81%AB%E3%81%A1%E3%81%AF%E3%81%93%E3%82%93%E3%81%AB%E3%81%A1%E3%81%AF&tl=ja&total=1&idx=0&textlen=15&prev=input");
			$put_file = "files/".$file_name.".mp3";
			//echo "put: ". $put_file;
			file_put_contents($put_file, $this->mp3data);
			chmod($put_file, 0777); 
			
			$convert = new audioconvert();
			$this->ogg = $convert->mp32OggFile($put_file,false);
			///var/www/vhosts/heckleonline.com/httpdocs/
			$put_file = "files/".$file_name.".ogg";
			file_put_contents($put_file, $this->ogg);
			chmod($put_file, 0777); 
         	
           // echo "data: " . $this->mp3data;            
            return $mp3data;
        } else { return false; }
    }
 
    function saveToFile($filename) {
        $filename = trim($filename);
        if(!empty($filename)) {
            return file_put_contents($filename,"files/".$this->mp3data);
        } else { return false; }
    }
 
}
?>