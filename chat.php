<?php
	session_start();
	include_once "configLocal.php";
	require_once('classes/BD.class.php');
	BD::conn();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bienvenido al chat</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
</head>
<body>

<div id="contactos">
	<ul>
	<?php
		//echo $_SESSION['usuario'];
		$usuarios = BD::conn()->prepare("SELECT * FROM `webchat_users` where name !='".$_SESSION['usuario']."'");
		$usuarios->execute(array($_SESSION['userid']));
		
		if($usuarios->rowCount()==0)
		{
			echo "No se encontrarón usuarios.";
		}else
		{
			
				$id = BD::conn()->prepare("SELECT a.userid,a.usuario,a.idioma,a.email as nickname FROM usuarios a INNER JOIN webchat_users b ON a.usuario = b.name WHERE b.name !='".$_SESSION['usuario']."'");
				$id->execute(array($_SESSION['userid']));

				while($usuario = $id->fetchObject())
				{

				//SELECT a.userid,a.usuario,a.idioma,a.email as nickname FROM usuarios a INNER JOIN webchat_users b ON a.usuario = b.name WHERE b.name !=  'test'

	?>
					<li><a href="javascript:void(0);" name="<?php echo $usuario->usuario; ?>" id="<?php echo $usuario->userid; ?>" class="comecar"><?php echo $usuario->usuario; ?></a> </li>				
	<?php
				}
		}
	?>
	</ul>
</div>

<div style="position:absolute; top:0; right:0px;" id="retorno"></div>
<div id="janelas"></div>


</body>
</html>