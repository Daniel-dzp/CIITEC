<?php
	session_start();

	if(!isset($_SESSION['nombre']))
		header("location: index.php?m=3");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("cssGeneral.php"); ?>
	<title></title>
</head>
<body>
	<?php include("menu.php"); ?>

	<br/>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="card text-white bg-primary mb-3" >
	  				<div class="card-header">Acerca de mi</div>
	  				<div class="card-body">
	  					<div class="row">
	  						<div class="col-sm-5">
	  							<img src="img/logo.jpg" width="100%">
	  							<P>INSTITUTO TECNOLOGICO DE CELAYA.</P>
	  						</div>
	  						<div class="col-sm-7">
	  							TODOS LOS DERECHOS RESERVADOS<br/>
	  							Copyright &copy;<br/><br/>
	  							Autor: Daniel Zamudio Pichardo (dzp)<br/>
	  							Email: daniel.zamudio.pichardo@gmail.com<br/>
	  							Fecha: 2018
							</div>
	  					</div>
	  				</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>


</body>
</html>