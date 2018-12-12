<?php
	session_start();

	if(!isset($_SESSION['nombre']))
		header("location: index.php?m=3");

	include("tools/tools.php");

	$mensaje = "";
	if(isset($_POST['conferencista']))
	{
		// cargar foto
		if($_FILES['foto']['size'] > 500000)
			$mensaje = "No se puede actualizar la imagen por excede el tamaño permitido";
		else
		{
			$datos = explode(".", strtoupper($_FILES['foto']['name']));
			if($datos[count($datos)-1] != "JPG")
				$mensaje = "Formato de imagen equivocado";
			else
			{
				// crear el conferencista
				$consulta = "insert into conferencista(nombre, apellidos, genero, correo, telefono, institucion, biografia)
							values('".$_POST['nombre']."', '".$_POST['apellidos']."', '".$_POST['genero']."', '".$_POST['correo']."', '".$_POST['telefono']."', '".$_POST['institucion']."', '".$_POST['biografia']."')";
				$db->consulta($consulta);

				$consulta = "select max(id) as id from conferencista";
				$db->consulta($consulta);
				$conferencista = $db->obtenerRegistro();

				// foto
				move_uploaded_file($_FILES['foto']['tmp_name'],"data/fotos/conferencistas/".$conferencista['id'].".jpg");
				$mensaje = "Conferencista añadido";
			}

		}
	}

	if(isset($_POST['conferencia']))
	{
		$consulta = "insert into conferencia(nombre, descripcion, lugar_conf, fecha, hora, id_conferencista, costo, cupo) values('".$_POST['nombreC']."', '".$_POST['descripcion']."', '".$_POST['lugar']."', '".$_POST['fecha']."', '".$_POST['hora']."', ".$_POST['id'].", '".$_POST['costo']."', '".$_POST['cupo']."')";
		$db->consulta($consulta);
		$mensaje = "Conferencia creada";
	}

	if(isset($_POST['guardar_conferencia']))
	{
		$consulta = "update conferencia set nombre='".$_POST['nombreC']."' , descripcion='".$_POST['descripcion']."' , lugar_conf='".$_POST['lugar']."' , fecha='".$_POST['fecha']."' , hora='".$_POST['hora']."' , id_conferencista=".$_POST['id']." , costo=".$_POST['costo']." , cupo=".$_POST['cupo']." where id=".$_POST['id_conferenciaG'];

		$db->consulta($consulta);

		$mensaje = "Cambios guardados de conferencia";
	}

	if(isset($_POST['guardar_conferencista']))
	{
		$consulta = "update conferencista set nombre='".$_POST['nombre']."' , apellidos='".$_POST['apellidos']."' , genero='".$_POST['genero']."', correo='".$_POST['correo']."' , telefono='".$_POST['telefono']."' , institucion='".$_POST['institucion']."' , biografia='".$_POST['biografia']."' where id=".$_POST['id_conferencista'];

		$db->consulta($consulta);

		$mensaje = "Cambios guardados de conferencista";
	}

	if(isset($_POST['eliminar_conferencia']))
	{
		$consulta = "delete from conferencia where id=".$_POST['id_conferencia'];
		$db->consulta($consulta);
		$mensaje = "Conferencia eliminada";
	}

	if(isset($_POST['eliminar_conferencista']))
	{
		$consulta = "delete from conferencista where id=".$_POST['id_conferencista'];
		$db->consulta($consulta);
		$mensaje = "Conferencista eliminado";	
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	
	<?php include("cssGeneral.php"); ?>

	<meta charset="utf-8"/>
</head>
<body>
	<?php include("menu.php"); ?>

	<div class="container-fluid">
		<br/>
		<div class="row">
			<div class="col-sm-4">
				<?php
					if($mensaje>'')
						echo '
							<div class="alert alert-dismissible alert-primary">
								'.$mensaje.'
							</div>';
				?>
				<div class="card border-primary mb-3">
					<div class="card-header">
						<img src="img/iconos/nueva_persona.png">
						Conferencista
					</div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
							<label class="col-form-label col-form-label-sm">Foto</label>
							<input type="file" id="idFoto" name="foto" class="form-control-file"  required/>

							<label for="idNombre" class="col-form-label col-form-label-sm">Nombre</label>
							<input type="text" name="nombre" id="idNombre" class="form-control form-control-sm" required="required" />
							<label for="idApellidos" class="col-form-label col-form-label-sm">Apellidos</label>
							<input type="text" name="apellidos" id="idApellidos" class="form-control form-control-sm" required="required" />

							<label>Genero</label><br/>
							<label for="idHombre"> Hombre&nbsp;&nbsp;</label><input type="radio" id="idHombre" name="genero" value='H' checked/>
							<label for="idMujer">&nbsp;&nbsp;&nbsp;Mujer&nbsp;&nbsp;</label><input type="radio" name="genero" id="idMujer" value='M'/><br/>

							<label for="idCorreo" class="col-form-label col-form-label-sm">Correo</label>
							<input type="email" name="correo" id="idCorreo" class="form-control form-control-sm" required />
							<label for="idTelefono" class="col-form-label col-form-label-sm">Telefono</label>
							<input type="text" name="telefono" id="idTelefono" class="form-control form-control-sm" required />
							<label for="idInstitucion" class="col-form-label col-form-label-sm">Institución</label>
							<input type="text" name="institucion" id="idInstitucion" class="form-control form-control-sm" required />
							<br/>
							<textarea name="biografia" placeholder="Biografia" required="required" rows="4" style="width: 100%; resize: none;"></textarea>
							<br/><br/>

							<input type="submit" name="conferencista" value="Crear" class="btn btn-primary btn-sm" />
							
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card border-primary mb-3">
					<div class="card-header">
						<img src="img/iconos/conferencia.png">
						Conferencias
					</div>
					<div class="card-body">
						<form action="" method="post">
							<label for="idNombreC" class="col-form-label col-form-label-sm">Nombre Conferencia</label>
							<input type="text" name="nombreC" id="idNombreC" class="form-control form-control-sm" required="required" /><br/>
							
							<textarea name="descripcion" placeholder="Descripcion" required="required" rows="4" style="width: 100%; resize: none;"></textarea>
							<br/><br/>

							<label for="idLugar" class="col-form-label col-form-label-sm">Lugar</label>
							<input type="text" name="lugar" id="idLugar" class="form-control form-control-sm" required="required" />
							
							<label for="idFecha" class="col-form-label col-form-label-sm">Fecha</label>
							<input type="date" name="fecha" id="idFecha" class="form-control form-control-sm" required />

							<label for="idHora" class="col-form-label col-form-label-sm">Hora</label>
							<input type="time" name="hora" id="idHora" class="form-control form-control-sm" required />

							<div class="row">
								<div class="col-sm-7">
									<label >Conferencista</label>

									<select class="custom-select" name="id" id="id_seleccion" required onchange="mostrarFoto(this);">
										
										<?php
											$consulta = "select id, concat(apellidos, ' ', nombre) as conferencista from conferencista";
											$db->consulta($consulta);

											for($g=0;$g<$db->numeroRegistros;$g++)
											{
												$c = $db->obtenerRegistro();
												echo '<option value="'.$c['id'].'">'.$c['conferencista'].'</option>';
											}

										?>
									</select>
								</div>
								<div class="col-sm-5">
									<div class="card-body" style="text-align: center;">
										<img id="id_congrecista" src="" style="height: 90px; max-width:100%; border: 1px solid lightblue; border-radius: 8px;">
									</div>
								</div>
							</div>

							<label for="idCosto" class="col-form-label col-form-label-sm">Costo</label>
							<input type="number" name="costo" id="idCosto" class="form-control form-control-sm" required />
							<label for="idCupo" class="col-form-label col-form-label-sm">Cupo</label><br/>
							<input type="number" name="cupo" id="idCupo" class="form-control form-control-sm" required />
								
							<br/>
							<input type="submit" name="conferencia" value="Crear" class="btn btn-primary btn-sm" />
							
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-4">

				<?php
					if(isset($_POST['editar_conferencia']))
					{
						$consulta = "select * from conferencia where id=".$_POST['id_conferencia'];
						$db->consulta($consulta);
						$row = $db->obtenerRegistro();

						echo '
							<div class="card border-primary mb-3">
								<div class="card-header">
									<img src="img/iconos/conferencia.png">
									Editar Conferencia
								</div>
								<div class="card-body">
									<form action="" method="post">
										<label for="idNombreCE" class="col-form-label col-form-label-sm">Nombre Conferencia</label>
										<input type="text" name="nombreC" id="idNombreCE" class="form-control form-control-sm" required="required" value="'.$row['nombre'].'"/><br/>
										
										<textarea name="descripcion" placeholder="Descripcion" required="required" rows="4" style="width: 100%; resize: none;">'.$row['descripcion'].'</textarea>
										<br/><br/>

										<label for="idLugarE" class="col-form-label col-form-label-sm">Lugar</label>
										<input type="text" name="lugar" id="idLugarE" class="form-control form-control-sm" required="required" value="'.$row['lugar_conf'].'"/>
										
										<label for="idFechaE" class="col-form-label col-form-label-sm">Fecha</label>
										<input type="date" name="fecha" id="idFechaE" class="form-control form-control-sm" required value="'.$row['fecha'].'" />

										<label for="idHoraE" class="col-form-label col-form-label-sm">Hora</label>
										<input type="time" name="hora" id="idHoraE" class="form-control form-control-sm" required value="'.$row['hora'].'" />

										<div class="row">
											<div class="col-sm-7">
												<label >Conferencista</label>

												<select class="custom-select" name="id" id="id_seleccionE" required onchange="mostrarFotoE(this);">
												';

						$consulta = "select id, concat(apellidos, ' ', nombre) as conferencista from conferencista";
						$db->consulta($consulta);

						for($g=0;$g<$db->numeroRegistros;$g++)
						{
							$c = $db->obtenerRegistro();
							echo '<option value="'.$c['id'].'" '.($row['id_conferencista']==$c['id']?' selected ':'').'>'.$c['conferencista'].'</option>';
						}

						echo '	
												</select>
											</div>
											<div class="col-sm-5">
												<div class="card-body" style="text-align: center;">
													<img id="id_congrecistaE" src="" style="height: 90px; max-width:100%; border: 1px solid lightblue; border-radius: 8px;">
												</div>
											</div>
										</div>

										<label for="idCostoE" class="col-form-label col-form-label-sm">Costo</label>
										<input type="number" name="costo" id="idCostoE" class="form-control form-control-sm" required value="'.$row['costo'].'" />
										<label for="idCupoE" class="col-form-label col-form-label-sm">Cupo</label><br/>
										<input type="number" name="cupo" id="idCupoE" class="form-control form-control-sm" required value="'.$row['cupo'].'" />
											
										<br/>
										<input type="hidden" name="id_conferenciaG" value="'.$_POST['id_conferencia'].'"/>
										<input type="submit" name="guardar_conferencia" value="Guardar" class="btn btn-primary btn-sm" />
										
									</form>
								</div>
							</div>
						';
					}


					if(isset($_POST['editar_conferencista']))
					{

						$consulta = "select * from conferencista where id=".$_POST['id_conferencista'];
						$db->consulta($consulta);

						$row = $db->obtenerRegistro();

						echo '
							<div class="card border-primary mb-3">
								<div class="card-header">
									<img src="img/iconos/nueva_persona.png">
									Editar Conferencista '.$row['apellidos'].' '.$row['nombre'].'
								</div>
								<div class="card-body">
									<form action="" method="post">
										<label for="idNombreE" class="col-form-label col-form-label-sm">Nombre</label>
										<input type="text" name="nombre" id="idNombreE" class="form-control form-control-sm" required="required"  value="'.$row['nombre'].'"/>
										<label for="idApellidosE" class="col-form-label col-form-label-sm">Apellidos</label>
										<input type="text" name="apellidos" id="idApellidosE" class="form-control form-control-sm" required="required"  value="'.$row['apellidos'].'"/>

										<label>Genero</label><br/>
										<label for="idHombreE"> Hombre&nbsp;&nbsp;</label><input type="radio" id="idHombreE" name="genero" value="H" '.($row['genero'] == 'H'?'checked':'').' />
										<label for="idMujerE">&nbsp;&nbsp;&nbsp;Mujer&nbsp;&nbsp;</label><input type="radio" name="genero" id="idMujerE" value="M" '.($row['genero'] == 'M'?'checked':'').'/><br/>

										<label for="idCorreoE" class="col-form-label col-form-label-sm">Correo</label>
										<input type="email" name="correo" id="idCorreoE" class="form-control form-control-sm" required value="'.$row['correo'].'"/>
										<label for="idTelefonoE" class="col-form-label col-form-label-sm">Telefono</label>
										<input type="text" name="telefono" id="idTelefonoE" class="form-control form-control-sm" required  value="'.$row['telefono'].'"/>
										<label for="idInstitucionE" class="col-form-label col-form-label-sm">Institución</label>
										<input type="text" name="institucion" id="idInstitucionE" class="form-control form-control-sm" required value="'.$row['institucion'].'"/>
										<br/>
										<textarea name="biografia" placeholder="Biografia" required="required" rows="4" style="width: 100%; resize: none;">'.$row['biografia'].'</textarea>
										<br/><br/>

										<input type="hidden" name="id_conferencista" value="'.$_POST['id_conferencista'].'" />

										<input type="submit" name="guardar_conferencista" value="Guardar" class="btn btn-primary btn-sm" />
										
									</form>
								</div>
							</div>
						';
					}
				?>

				<div class="card border-primary mb-3">
					<div class="card-header">
						<img src="img/iconos/conferencias.png">
						Conferencias
					</div>
					<!--<div class="card-body">
						<?php
							echo '<ul class="list-group" >';

							$consulta = "select * from conferencia";
							$db->consulta($consulta);

							while($c = $db->obtenerRegistro())
							{
								echo '<li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 2px;">';
								echo '
											'.$c['nombre'].' ';
								echo '		<span class="badge badge-primary badge-pill">'.$c['fecha'].'</span>';
								echo '		<form method="post" >
												<input class="icono-eliminar" type="image" src="img/trash-icon.png"/>
		            							<input type="hidden" name="id_conferencia" value="'.$c['id'].'" />
		            						</form>
		            						
									</li>';
							}
							echo '</ul>';
						?>
					</div>-->
				</div>

				<div id="accordion">
				  
				  	<?php
						$consulta = "select * from conferencia";
						$db->consulta($consulta);

						while($c = $db->obtenerRegistro())
						{
							echo '
							<div class="card">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse'.$c['id'].'" aria-expanded="false" aria-controls="collapse'.$c['id'].'">
							          '.$c['nombre'].'
							        </button>
							        <span class="badge badge-primary badge-pill">'.$c['fecha'].'</span>
							      </h5>
							    </div>
							    <div id="collapse'.$c['id'].'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							      	<form method="post" >
										Eliminar <input class="icono-eliminar" type="image" src="img/trash-icon.png"/>
										<input type="hidden" name="eliminar_conferencia" value="" />
            							<input type="hidden" name="id_conferencia" value="'.$c['id'].'" />
            						</form>
            						<form method="post" >
										Editar <input class="icono-editar" type="image" src="img/edit-icon.png"/>
										<input type="hidden" name="editar_conferencia" value="" />
            							<input type="hidden" name="id_conferencia" value="'.$c['id'].'" />
            						</form>
            						lugar: '.$c['lugar_conf'].'<br/>
            						costo: $'.$c['costo'].'<br/>
            						cupo: '.$c['cupo'].' personas<br/>
            						Descripcion: '.$c['descripcion'].'<br/>
							      </div>
							    </div>
							</div>
							';
						}

				  
				?>

				</div>
				<br/>

				<div class="card border-primary mb-3">
					<div class="card-header">
						<img src="img/iconos/conferencias.png">
						Conferencistas
					</div>
				</div>

				<?php
						$consulta = "select * from conferencista";
						$db->consulta($consulta);

						while($c = $db->obtenerRegistro())
						{
							echo '
							<div class="card">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#ccollapse'.$c['id'].'" aria-expanded="false" aria-controls="ccollapseOne'.$c['id'].'">
							          '.$c['nombre'].' '.$c['apellidos'].'
							        </button>
							        
							      </h5>
							    </div>
							    <div id="ccollapse'.$c['id'].'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body row">
							      	<div class="col-sm-7">
								      	<form method="post" >
											Eliminar <input class="icono-eliminar" type="image" src="img/trash-icon.png"/>
											<input type="hidden" name="eliminar_conferencista" value="" />
	            							<input type="hidden" name="id_conferencista" value="'.$c['id'].'" />
	            						</form>
	            						<form method="post" >
											Editar <input class="icono-editar" type="image" src="img/edit-icon.png"/>
											<input type="hidden" name="editar_conferencista" value="" />
	            							<input type="hidden" name="id_conferencista" value="'.$c['id'].'" />
	            						</form>
	            						Genero: '.$c['genero'].'<br/>
	            						Correo: '.$c['correo'].'<br/>
	            						Telefono: '.$c['telefono'].'<br/>
	            						Institución: '.$c['institucion'].'<br/>
	            						Biografia: '.$c['biografia'].'
	            					</div>
									<div class="col-sm-5" style="text-align: center;">
										<img src="data/fotos/conferencistas/'.$c['id'].'.jpg" style="max-width:80%; border: 1px solid lightblue; border-radius: 8px;" />
	            					</div>
							      </div>
							    </div>
							 </div>
							';
						}

				  
				?>

			</div>
		</div>


		<div class="row">
			<div class="col-sm-8">
				
			</div>
			
		</div>
	</div>

</body>
</html>


<script type="text/javascript">
	var persona = document.getElementById('id_seleccion');
	var foto_c = document.getElementById('id_congrecista');
	foto_c.src = "data/fotos/conferencistas/"+persona.value+".jpg";

	var personaE = document.getElementById('id_seleccionE');
	var foto_cE = document.getElementById('id_congrecistaE');
	foto_cE.src = "data/fotos/conferencistas/"+personaE.value+".jpg";

    function mostrarFoto()
    {
        foto_c.src = "data/fotos/conferencistas/"+persona.value+".jpg";
    }

    function mostrarFotoE()
    {   
        foto_cE.src = "data/fotos/conferencistas/"+personaE.value+".jpg";
    }

</script>