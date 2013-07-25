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
<title>Index Chat</title>
	<style type="text/css">
		*{
			margin:0;
			padding:0;
		}
		body
		{
			background:#f4f4f4;
		}
		div#formulario
		{
			width:500px;
			padding:5px;
			height:90px;
			background:#white; border: 1px solid #333;
			position:absolute;
			left: 50%;
			top: 50%;
			margin-left:-250px;
			margin-top:-45px;
		}
		div#formulario span
		{
			font:18px "Trebuchet MS", tahoma, arial; 
			color:#036; 
			float:left; 
			width:100%;
			margin-bottom:10px;
		}
		div#formulario input[type=text]
		{
			padding:5px; 
			widht:485px; 
			border: 1px solid #ccc;
			outline:none; font:16px Tahoma, arial;
			color: #666;
		}
		div#formulario input[type=text]:focus
		{
			border-color:#036;
		}
		div#formulario input[type=submit]
		{
			padding:4px 6px; 
			background:#069;
			font:15px tahoma,arial;
			color:#fff;
			border: 1px solid #fff;
			float:leftM
			margin-top:5px;
			text-align:center;
			width:95px;
			text-shadow:#000 0 1px 0 0;
		}
		div#formulario input[type=submit]:hover
		{
			cursor:pointer;
			background:#09f;
		}
	</style>
</head>
<body>
<?php
	if(isset($_POST['acao']) && $_POST['acao'] == 'logar')
	{
		$email = strip_tags(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING));
			
		
		if($email == ''){}
		else
		{
			$pegar_user= BD::conn()->prepare("SELECT userid,idioma,usuario FROM `Biixa`.`usuarios` where usuario = ?");
			$pegar_user->execute(array($email));
			if($pegar_user ->rowCount()==0)
			{
				echo '<script>alert("usuario no encontrado");</script>';
			}else
			{
				$fetch = $pegar_user-> fetchObject();

				$pegar_user= BD::conn()->prepare("INSERT INTO `Biixa`.`webchat_users`(`name` ,`gravatar`,`idioma`) values(?,?,?)");
				$pegar_user->execute(array($fetch->usuario,"55e9849e1422dff329e5ca8230bedaae",$fetch->idioma));

				$_SESSION['userid'] = $fetch->userid;
				$_SESSION['idioma']=$fetch->idioma;
				$_SESSION['usuario']=$fetch->usuario;
				//<script>alert("usuario aceptado"); </script
				echo '<script>location.href="chat.php";</script>';
			}
		}
}
?>

	<div id="formulario">
	<span>Correo: </span>
		<form action="" method="post" enctype="multipart/form-data">
			<label>
				<input type="text" name="email"  value="test"/>
			</label>
				<input type="hidden" name="acao" value="logar">
				<input type="submit" value="iniciar">
		</form>
	</div>

</body>
</html>