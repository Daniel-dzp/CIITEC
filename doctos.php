<?php
	session_start();

	if(!isset($_SESSION['nombre']))
		header("location: index.php?m=3");


	$mensaje = "";
	if(isset($_POST['cargarFoto']))
	{
		//var_dump($_FILES['foto']);
		if($_FILES['documento']['size'] > 5000000)
			$mensaje = "Error al cargar, excede el tamaño permitido";
		else
		{
			$datos = explode(".", strtoupper($_FILES['documento']['name']));

			$extensiones = array('PDF', 'JPG', 'PNG', 'DOC', 'DOCX');
			//echo $datos[count($datos)-1];
			if(!(in_array($datos[count($datos)-1], $extensiones)))
				$mensaje = "Formato de documento equivocado";
			else
			{
				move_uploaded_file($_FILES['documento']['tmp_name'],"data/archivos/".$_FILES['documento']['name']);
				$mensaje = "Documento cargado";
			}

		}

	}

	if(isset($_POST['archivo']))
	{
		if(unlink("data/archivos/".$_POST['archivo']))
			$mensaje = "Archivo eliminado correctamente";
		else
			$mensaje = "Error al eliminar archivo";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php include("cssGeneral.php"); ?>
</head>
<body>
	<?php include("menu.php"); ?>

	<br/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-4">
				<div class="card border-primary mb-3" >
					<div class="card-header"><h4 class="card-title">
						<img src="img/iconos/fichero.png" style="width:32px;"/>
						Documentos cargados
					</h4></div>
					<div class="card-body">
						<?php
							$a = opendir('data/archivos');
							while($b = readdir($a)){
								if($b != '.' && $b != '..')
	  							{	
	  								$datos = explode(".", strtoupper($b));

	  								echo '
	  									<div class="row">
	  										<div class="col-1">
												<form method="post" style="text-wrap:pre-line;">
													<input type="hidden" name="archivo" value="'.$b.'" />
													<input class="icono-eliminar" type="image" src="img/trash-icon.png"/>
												</form>
											</div>
	  								';

	  								echo '
	  										<div class="col-11">
	  											<a href="data/archivos/'.$b.'" target="_blank">';
									switch ($datos[count($datos)-1])
									{
										case 'PDF':
											echo '<img src="img/iconos/pdf.png" alt=""/> ';
											break;
										case 'JPG':
											echo '<img src="img/iconos/jpg.png" alt=""/> ';
											break;
										case 'PNG':
											echo '<img src="img/iconos/png.png" alt=""/> ';
											break;
										case 'DOC':
											echo '<img src="img/iconos/doc.png" alt=""/> ';
											break;
										case 'DOCX':
											echo '<img src="img/iconos/docx.png" alt=""/> ';
											break;
									}

	  								echo $b.'</a><br/>
	  										</div>
										</div>
	  									';
	  							}
							}
							closedir($a);
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
			<div class="col-sm-4">
				<div class="card border-primary mb-3" >
					<div class="card-header"><h4 class="card-title">
						<img src="img/iconos/nuevo_documento.png" style="width:32px;"/>
						Cargar Documentos
					</h4></div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="input-group mb-3">
								<div class="custom-file">
									<input type="file" id="idFile" name="documento" class="custom-file-input"  required/>
									<label class="custom-file-label" for="idFile">Buscar</label>
								</div>
							</div>
							<input type="submit" name="cargarFoto" value="Cargar" class="btn btn-primary btn-sm" />
						</form>
					</div>
				</div>
				<?php
					if($mensaje != '')
						echo '<div class="alert alert-dismissible alert-primary">
								'.$mensaje.'
							</div>';
				?>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>

</body>
</html>
