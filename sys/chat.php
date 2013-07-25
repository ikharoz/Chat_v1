<?php
session_start();
include_once "../files/funciones.php";
include_once "../configLocal.php";
require_once('../classes/BD.class.php');
BD::conn();

	$accion=$_REQUEST['acc'];
	if (isset($accion) && $accion!="")
	{
		switch($accion)
		{  	
			case 'insertar':
				//echo "<script>alert('hola');</script>";
				$para = $_POST['para'];
				$mensaje=strip_tags($_POST['mensaje']);
				$nombre = BD::conn()->prepare("SELECT usuario FROM `usuarios` where userid= ?");
				$nombre->execute(array($_SESSION['userid']));
				
				$ft = $nombre->fetchObject();
					
				$inserir = BD::conn()->prepare("INSERT INTO `webchat_lines_users`(id_de,id_para,data,mensaje,idioma) VALUES (?,?,NOW(),?,?)");
				if($inserir->execute(array($_SESSION['userid'],$para,$mensaje,$_SESSION['idioma'])))
				{

					echo '<li><span>'.$ft->usuario.' dice:</span><p>'.$mensaje.'</p></li>';
				}
			break;
			
			case 'actualizar':
				$arreglo = $_REQUEST['arreglo'];
				//echo $arreglo;
				//print_r($arreglo);
				if($arreglo !="")
				{
					//echo "<script>alert('array ok');</script>";
					foreach($arreglo as $indice =>$id)
					{
						//echo $id.'-'.$_SESSION['userid'];
						$seleccionar = BD::conn()->prepare("SELECT * FROM `webchat_lines_users` WHERE (id_de = ? OR id_de = ?) AND (id_para = ? OR id_para = ?)");
						$seleccionar->execute(array($_SESSION['userid'],$id,$id,$_SESSION['userid']));
						
						//print_r(array($_SESSION['id_user'],$id,$id,$_SESSION['id_user']));
						$mensaje='';
						
					
						while($dd = $seleccionar->fetchObject())
						{
							//echo $dd->mensaje;
							//print_r($id);
							$nombre= BD::conn()->prepare("SELECT * FROM `usuarios` WHERE userid = ?");
							$nombre->execute(array($dd->id_de));
							
							$nmbre = $nombre->fetchObject();
							//idiomaLocal -> a este se traducira el texto
							//idioma -> idioma en que el msg fue enviado
							
							if($dd->idioma == $_SESSION['idioma'] )
							{
								$conversion = $dd->mensaje;
							}else
							{
								//$conversion = Traducir($dd->mensaje,$dd->idioma,$_SESSION['idioma']);
								$conversion = $dd->mensaje." - ".$dd->idioma." - ".$_SESSION['idioma'];	
							}
							
							//$mensaje.='<li><span>'.$nmbre->nombre.' dice:</span><p>'.$dd->mensaje.'</p></li>';
							$mensaje.='<li><span>'.$nmbre->usuario.' dice:</span><p>'.$conversion.'</p></li>';
							$new[$id] = $mensaje;
							//echo $mensaje;
						}
						
						
					}
					$new = json_encode($new);
					echo $new;
			}
			break;
		}
	}
		
		
?>