<?php
	session_start();

	if(!isset($_SESSION['nombre']))
		header("location: index.php?m=3");

	include("tools/tools.php");

	$mensaje = "";
	if(isset($_POST['monto']))
	{
		if($_POST['monto']>0)
		{
			$consulta = "insert into pagos_efectivo(monto, id_user, id_autorizo) values(".$_POST['monto'].", ".$_POST['id_usuario'].", ".$_SESSION['id'].")";
			
			$db->consulta($consulta);
			$mensaje = "Pago Realizado correctamente";
		}
		else
			$mensaje = "Solo se aceptan pagos mayores a $0";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Pagos</title>
	
	<?php include("cssGeneral.php"); ?>

</head>
<body>
	<?php include("menu.php"); ?>

	<br/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-4">
				<!--
				<div class="card border-primary mb-3 color-fondo" >
					<div class="card-header">
						<img src="iconos/dinero.png"/>
						Pagos
					</div>
					<div class="card-body">
						<form method="post" action="">
							
							<label >Nombre usuario</label>
							
							<select class="custom-select" name="id_usuario" required>
								
								<?php
									$consulta = "select id, concat(apellidos, ' ', nombre) as nombre from usuario";
									$db->consulta($consulta);

									for($g=0;$g<$db->numeroRegistros;$g++)
									{
										$usuario = $db->obtenerRegistro();
										echo '<option value="'.$usuario['id'].'">'.$usuario['nombre'].'</option>';
									}

								?>
							</select>
					
							<label for="idPago" class="col-form-label col-form-label-sm">Pago</label><br>
							<input type="number" id="idPago" name="monto" class="form-control form-control-sm" required autocomplete="off" placeholder="$$$" /><br/>
							<button type="submit" class="btn btn-primary">Pago</button>
						</form>
					</div>
				</div>
				-->

				<div class="card border-primary mb-3 color-fondo" >
					<div class="card-header">
						<img src="img/iconos/dinero.png"/>
						Pagos
					</div>
					<div class="card-body">
						<form method="post" action="">
							
							<label >
								<img src="img/iconos/buscar.png"/>
								Buscar Usuario
							</label><br/>
							<input type="text" id="idBuscar" name="busqueda" class="form-control form-control-sm" required autocomplete="off" placeholder="Buscar" /><br/>
							<button type="submit" class="btn btn-primary btn-sm">Buscar</button>
						</form>
							<?php
								if(isset($_POST['busqueda']))
								{
									echo '<hr>';
									echo '
										<form method="post" action="">
											<label >Nombre usuario</label>
											<select class="custom-select" name="id_usuario" required>';
												
									$consulta = "select id, concat(apellidos, ' ', nombre) as nombre from usuario where apellidos like '%".$_POST['busqueda']."%'";
									$db->consulta($consulta);

									echo $db->numeroRegistros;

									for($g=0;$g<$db->numeroRegistros;$g++)
									{
										$usuario = $db->obtenerRegistro();
										echo '<option value="'.$usuario['id'].'">'.$usuario['nombre'].'</option>';
									}
												
									echo '
											</select>
											<br/><br/>
											<button type="submit" class="btn btn-primary btn-sm">Seleccionar</button>
										</form>
									';
								}
								if(isset($_POST['id_usuario']))
								{
									echo '<hr/>';
									echo '
										<form method="post" action="">
											<label for="idPago" class="col-form-label col-form-label-sm">Pagar</label><br>
											<input type="number" id="idPago" name="monto" class="form-control form-control-sm" required autocomplete="off" placeholder="$$$" /><br/>
											<input type="hidden" name="id_usuario" value="'.$_POST['id_usuario'].'" />
											<button type="submit" class="btn btn-primary btn-sm">Pagar</button>
										</form>
									';
								}
							?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<?php
					if($mensaje > '')
					{
						echo '<div class="alert alert-dismissible alert-success">
								'.$mensaje.'
							</div>';
					}
					if(isset(($_POST['id_usuario'])))
					{

						$consulta = "select concat(apellidos,' ', nombre) as nombre from usuario where id = ".$_POST['id_usuario'];
						$db->consulta($consulta);
						$datos = $db->obtenerRegistro();
						echo '
						<div >
							<div class="card border-primary mb-3">
								<div class="card-header">
									<img src="img/iconos/dinero.png"/>
									Pagos de '.$datos['nombre'].'
								</div>
								<div class="card-body">
									<ul class="list-group" >';
						
						$consulta = "select * from pagos_efectivo where id_user = ".$_POST['id_usuario'];
						$db->consulta($consulta);

						while($c = $db->obtenerRegistro())
						{
							echo '<li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 2px;">';
							echo "Monto: $".$c['monto'];
							echo '<span class="badge">
										<form method="post" action="recibo.php"  target="_blank">
											<input type="hidden" name="folio" value="'.$c['id'].'">
											<button type="submit" class="btn btn-primary btn-sm">Inprimir factura</button>
										</form>
								</span>';
							echo '</li>';
						}
									
						echo '		</ul>
								</div>
							</div>
						</div>';
					}
				?>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>

</body>
</html>
