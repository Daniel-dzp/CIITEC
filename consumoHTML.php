<?php


/*
	$bloque = file_get_contents('https://soloautos.mx/Autos/ford/guanajuato-estado/mas-grande-que-175001/');

	$datos = explode('<div class="col-xs-12">
<div class="col-xs-12">',$bloque);
	$datos = explode('<a class="left carousel-control" href="#carousel-SA-AD-89147809" data-slide="prev">',$datos[1]);

	echo ''.$datos[0];
	*/

	$correo = 'akagami_dzp@hotmail.com';
	$clave = 'akagami123';

	$client = new SoapClient('http://tigger.itc.mx/ws/soapserver_conacad.php?wsdl');
	$resultado = $client->login($correo, $clave);

	echo $resultado;

	$resultado = json_decode($resultado);

	if($resultado->login[0]->valido == 'true')
	{
		echo "<br/>Es valido<br/>";
		echo "<br/>";
		$nombre = $resultado->login[0]->nmbr;
		$apellidos = $resultado->login[0]->apllds;
		$email = $resultado->login[0]->email;
		$tipo = $resultado->login[0]->tpo;
		$usuario = $resultado->login[0]->user;

		echo $nombre." ".$apellidos;
		echo "<br/>";
		echo $usuario;
		echo "<br/>";
		echo $email;

	}
	else
	{
		echo "<br/>No es valido";
	}

?>