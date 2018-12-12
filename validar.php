<?php
	session_start();
	/*
		IP 			Que me esta visitando
		SO  		Que me esta visitando
		BROWSER 	Que me esta visitando
	*/



	include("tools/tools.php");


	if(isset($_POST['correo']) && isset($_POST['clave']))
	{
		$consulta = "select * from usuario where correo='".$_POST['correo']."' and pwd=password('".$_POST['clave']."')";
		$db->consulta($consulta);

		if($db->numeroRegistros == 1)
		{
			$datos = $db->obtenerRegistro();
			$_SESSION['nombre'] = $datos['apellidos'].' '.$datos['nombre'];
			$_SESSION['tipoUsuario'] = $datos['id_tipo'];
			$_SESSION['correo'] = $datos['correo'];
			$_SESSION['id'] = $datos['id'];

			header("location: home.php");
		}
		else
			header("location: index.php?m=1");
	}
	else
		header("location: index.php?m=2");
?>