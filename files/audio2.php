<!DOCTYPE html>
<?php
require "tts.php";
require "funciones.php";

$your_domain = "php/files/";
$tts = new TextToSpeech();
$file_name = time();

if ( isset($_GET['query']) ) $texto = $_GET['query'];
//if ( isset($_GET['idioma']) ) $idioma = $_GET['idioma'];

$idioma = $_SESSION['user']['idioma'];

$tts->setText(urlencode(Traducir2($texto,$idioma)),$file_name,$idioma);
$mp3 = $your_domain.$file_name.".mp3";
$ogg = $your_domain.$file_name.".ogg";


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