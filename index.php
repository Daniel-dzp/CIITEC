<?php
	session_start();

	session_unset();
	session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("cssGeneral.php"); ?>
	<title>SIITEC</title>
</head>
<body >

	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="#">CIITEC 2018</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="#">About</a>
				</li>
			</ul>
		</div>
	</nav>
<?php
	$mensaje = "";
	if(isset($_GET['m']))
		switch ($_GET['m']) {
			case 1:
				$mensaje = '<div class="alert alert-dismissible alert-warning">
							Usuario o clave erroneas
							</div>';
				break;
			case 2:
				$mensaje = '<div class="alert alert-dismissible alert-warning">
							Campos vacios
							</div>';
				break;
			case 3:
				$mensaje = '<div class="alert alert-dismissible alert-warning">
							Acceso invalido
							</div>';
				break;
			case 4:
				$mensaje = '<div class="alert alert-dismissible alert-success">
							Registro exitoso
							</div>';
				break;
			default:
		}

	echo $mensaje;
?>
	<br/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<div class="card border-primary mb-3" >
					<div class="card-header"><h4 class="card-title">Acceso</h4></div>
					<div class="card-body">
						<form action="validar.php" method="post">
							<label for="idUser" class="col-form-label col-form-label-sm">Correo</label>
							<input type="text" name="correo" id="idUser" class="form-control form-control-sm" required /><br/>
							<label for="idClave" class="col-form-label col-form-label-sm">Clave</label>
							<input type="password" name="clave" id="idClave" class="form-control form-control-sm" required /><br/>

							<button type="submit" class="btn btn-primary">Verificar</button>
						</form>
		  			</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<div class="card border-primary mb-3" >
					<div class="card-header"><h4 class="card-title">Registro</h4></div>
					<div class="card-body">
						<form action="registrarse.php" method="post">
							<label for="idNombre" class="col-form-label col-form-label-sm">Nombre</label>
							<input type="text" name="nombre" id="idNombre" class="form-control form-control-sm"/><br/>
							<label for="idApellidos" class="col-form-label col-form-label-sm">Apellidos</label>
							<input type="text" name="apellidos" id="idApellidos" class="form-control form-control-sm"/><br/>
							<label for="idEmail" class="col-form-label col-form-label-sm">Email</label>
							<input type="email" name="correo" id="idEmail" placeholder="email@example.com" class="form-control form-control-sm"><br/>
							<button type="submit" class="btn btn-primary">Registrar</button>
						</form>
		  			</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>

	</div>
	

</body>
</html>