<?php
 include('config.php');
	/*
	    Uso;
	      Traducir("Texto","IdiomaPrincipal","IdiomaATraducir");
	*/

	function TraSQL($author,$gravatar,$word,$conversionDe,$conversionA)
	{
		//$sexo = stripslashes($sexo);  
		//$idioma = mysql_real_escape_string($idioma);
		//if-> contiene ". " -> reemplazar por "."
		$word =  str_replace(". ",".",$word);
		$word = urlencode($word);
		$url = 'http://translate.google.com/translate_a/t?client=t&text='.$word.'&hl='.$conversionDe.'&sl='.$conversionDe.'&tl='.$conversionA.'&ie=UTF-8&oe=UTF-8&multires=1&otf=1&ssel=3&tsel=3&sc=1';
	
		$name_en = curl($url);
		$name_en = str_replace(".",". ",$name_en);
		$name_en = explode('"',$name_en);
			
			
		
	
		$query = "INSERT INTO `dbDGTest`.`webchat_lines_fullcontent` (`id`,`author`, `gravatar`, `text`,`idioma`,`idiomaatraducir`,`textotraducido`) VALUES (NULL,'".$author."', '.$gravatar.', '".$word."','".$conversionDe."','".$conversionA."','".$name_en[1]."')";
			echo $query;
		
		$resultado = mysql_query($query);

		if (!$resultado) {
		  echo 'Error';
		} else 
		{
		  $ultimoID = mysql_insert_id(); 
		  	echo 'De:'.$author.'<br>Lng: '.$conversionDe.'<br>ToLng: '.$conversionA.'<br>Orig: '.$word.'<br>Trad: '.$name_en[1].'<br>';
		
			echo 'Ok.. id:'.$ultimoID;
		}

	}

	function TraSQL2($author,$word,$conversionDe,$conversionA,$traducido)
	{
		
		$query = "INSERT INTO `dbDGTest`.`webchat_lines_fullcontent` (`id`,`author`, `gravatar`, `text`,`idioma`,`idiomaatraducir`,`textotraducido`) VALUES (NULL,'".$author."', '55e9849e1422dff329e5ca8230bedaae', '".$word."','".$conversionDe."','".$conversionA."','".$traducido."')";
		//	echo $query;
		
		$resultado = mysql_query($query);

		if (!$resultado) {
		  echo 'Error';
		} else 
		{
		  $ultimoID = mysql_insert_id(); 
//		  	echo 'De:'.$author.'<br>Lng: '.$conversionDe.'<br>ToLng: '.$conversionA.'<br>Orig: '.$word.'<br>Trad: '.$traducido.'<br>';
//		
			echo 'Ok.. id:'.$ultimoID;
		}

	}
	
	
?>
