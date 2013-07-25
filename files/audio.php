<!DOCTYPE html>
<?php
require "tts.php";
require "config.php";
require "funciones.php";

$your_domain = "php/files/";
$tts = new TextToSpeech();
$file_name = time();

if ( isset($_GET['query']) ) $texto = $_GET['query'];
if ( isset($_GET['u']) ) $usuario = $_GET['u'];

  
  /*MySsql Real Escape String*/
  
$idioma = $_SESSION['user']['idioma'];

$usuario = mysql_real_escape_string($usuario);
$idioma = mysql_real_escape_string($idioma);

$usuario = stripslashes($usuario);
$idioma = stripslashes($idioma);

$query = "select idioma from  .`usuarios`  where `usuario` = '".$usuario."'";
  $resultado = mysql_query($query); 
  $count=mysql_num_rows($resultado);
	$row = mysql_fetch_array($resultado) or die(mysql_error());
	//echo $row['idioma'];
	
  // If result matched $myusername and $mypassword, table row must be 1 row
  if($count==1){
	
		$tts->setText(Traducir2($texto,$row['idioma']),$file_name,$row['idioma']);		
		$mp3 = $your_domain.$file_name.".mp3";
	
  }else
  {	//Si no se puede obtener el idioma lo reproduce en el idioma del usuario que lo envio
    //$tts->setText(urlencode(Traducir2($texto,$idioma)),$file_name,$idioma);
	$tts->setText(Traducir2($texto,$idioma),$file_name,$idioma);
	$mp3 = $your_domain.$file_name.".mp3";
  }
?>
<br/>
<body bgcolor="#212121";>
<audio controls="controls" autoplay="autoplay">
  <source src="<?=$mp3?>" type="audio/mp3" />
  <!-- <source src="<?//=$ogg?>" type="audio/ogg" /> -->
  Your browser does not support the audio tag.
</audio> 

<br/><br/>

</body>
</html>