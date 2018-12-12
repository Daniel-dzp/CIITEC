<?php
	session_start();

	if(!isset($_SESSION['nombre']))
		header("location: index.php?m=3");

	include("tools/tools.php");

	// Actualizar

	if(isset($_POST['nombre']))
	{

		$consulta = "update usuario set nombre='".$_POST['nombre']."' , apellidos='".$_POST['apellidos']."' , correo='".$_POST['correo']."' ";

		if($_POST['clave'] > "")
			$consulta .= " , pwd=password('".$_POST['clave']."')"; 

		$consulta .=  "where id=".$_SESSION['id'];

		$db->consulta($consulta);
		$_SESSION['nombre'] = $_POST['nombre'].' '.$_POST['apellidos'];
	}

	$mensaje = "";
	if(isset($_POST['cargarFoto']))
	{
		//var_dump($_FILES['foto']);
		if($_FILES['foto']['size'] > 500000)
			$mensaje = "No se puede actualizar la imagen por excede el tamaño permitido";
		else
		{
			$datos = explode(".", strtoupper($_FILES['foto']['name']));
			if($datos[count($datos)-1] != "JPG")
				$mensaje = "Formato de imagen equivocado";
			else
			{
				move_uploaded_file($_FILES['foto']['tmp_name'],"fotos/".$_SESSION['id'].".jpg");
				$mensaje = "Foto cargada";
			}

		}

	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfil</title>
	<?php include("cssGeneral.php"); ?>
	<meta charset="utf-8"/>
</head>
<body>
	<?php include("menu.php"); ?>

	<br/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-4">
				<div class="card border-primary mb-3" >
					<div class="card-header"><h4 class="card-title"><img src="img/iconos/ajustes.png"> Cambios</h4></div>
					<div class="card-body">
						<form action="perfil.php" method="post">
							<?php

								$consulta = "select * from usuario where id=".$_SESSION['id'];
								$db->consulta($consulta);

								$row = $db->obtenerRegistro();
							?>
							<label for="idNombre" class="col-form-label col-form-label-sm">Nombre</label>
							<input type="text" name="nombre" id="idNombre" value="<?=$row['nombre']?>" class="form-control form-control-sm"/><br/>
							<label for="idApellidos" class="col-form-label col-form-label-sm">Apellidos</label>
							<input type="text" name="apellidos" id="idApellidos" value="<?=$row['apellidos']?>" class="form-control form-control-sm"/><br/>
							<label for="idEmail" class="col-form-label col-form-label-sm">Email</label>
							<input type="email" name="correo" id="idEmail" value="<?=$row['correo']?>" class="form-control form-control-sm"><br/>
							<label for="idClave" class="col-form-label col-form-label-sm">Clave</label>
							<input type="password" name="clave" id="idClave" value="" class="form-control form-control-sm"><br/>
							<button type="submit" class="btn btn-primary btn-sm">Guardar</button>
						</form>
		  			</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
			<div class="col-sm-4">
				<div class="card border-primary mb-3" >
					<div class="card-header"><h4 class="card-title">
					<?php
						if(is_file('data/fotos/perfiles/'.$_SESSION['id'].'.jpg'))
							echo '<img src="data/fotos/perfiles/'.$_SESSION['id'].'.jpg?'.rand().'" class="foto-usuario" />';
						else
							echo '<img src="img/usuario.png" class="foto-usuario" />';

					?>
					</h4></div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="input-group mb-3">
								<div class="custom-file">
									<input type="file" id="idFoto" name="foto" class="custom-file-input"  required/>
									<label class="custom-file-label" for="inputGroupFile02">Buscar</label>
								</div>
							</div>
							<input type="submit" name="cargarFoto" value="Cargar" class="btn btn-primary btn-sm" />
						</form>
					</div>
					
					<?php
						if($mensaje>'')
							echo '
								<div class="alert alert-dismissible alert-primary">
									'.$mensaje.'
								</div>';
					?>
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>



</body>
</html>
