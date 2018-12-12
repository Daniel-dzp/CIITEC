<?php
	include "tools/tools.php";

	// los elementos en su posiX y posiY se guardan en pixeles

	// acutaliza todos los elementos
	if(isset($_POST['num_registros']))
	{
		for($i=0;$i<$_POST['num_registros'];$i++)
		{
			$posiX = $_POST['posiX'.$_POST['id'.$i]];
			$posiY = $_POST['posiY'.$_POST['id'.$i]];

			$consulta = "update datos_reconocimientos set 
						posiX=".$posiX.", 
						posiY=".$posiY." 
						where id = ".$_POST['id'.$i];
			$db->consulta($consulta);
		}
	}

	// actualiza un elemento
	if(isset($_POST['guardar']))
	{
		$consulta = "update datos_reconocimientos set posiX=".$_POST['posiX']." , posiY=".$_POST['posiY'].", contenido='".$_POST['contenido']."', ancho=".$_POST['ancho']." , alto=".$_POST['alto']." , Tletra=".$_POST['tLetra']." , orden=".$_POST['orden'].",
				N=".(isset($_POST['N'])?"1":"0").",
				I=".(isset($_POST['I'])?"1":"0").",
				S=".(isset($_POST['S'])?"1":"0")."
				where id=".$_POST['id'];
		$db->consulta($consulta);
	}

	// guarda un nuevo elemento
	if(isset($_POST['texto']))
	{
		$consulta = "INSERT into datos_reconocimientos set posiX=".$_POST['posiX']." , posiY=".$_POST['posiY'].", contenido='".$_POST['contenido']."' , tipo= 'T', ancho=".$_POST['ancho']." , alto=".$_POST['alto']." , Tletra=".$_POST['tLetra']." , orden=".$_POST['orden'].",
			N=".(isset($_POST['N'])?"1":"0").",
			I=".(isset($_POST['I'])?"1":"0").",
			S=".(isset($_POST['S'])?"1":"0");

		$db->consulta($consulta);
	}

	// Cargar una imagen y la guarda un nuevo elemento. carpeta de imagenes  ./data/archivosReconocimiento
	if(isset($_POST['grafico']))
	{
		if($_FILES['imagen']['size'] < 1000000)
		{
			$datos = explode(".", strtoupper($_FILES['imagen']['name']));

			$extensiones = array('JPG', 'PNG');
			if(in_array($datos[count($datos)-1], $extensiones))
			{
				move_uploaded_file($_FILES['imagen']['tmp_name'],"data/archivosReconocimiento/".$_FILES['imagen']['name']);
				$consulta = "INSERT into datos_reconocimientos set posiX=".$_POST['posiX']." , posiY=".$_POST['posiY'].", contenido='".$_FILES['imagen']['name']."' , tipo= 'I', ancho=".$_POST['ancho']." , alto=".$_POST['alto']." , orden=".$_POST['orden']." ";
				$db->consulta($consulta);
			}
		}
	}

	// elimina un elemento
	if(isset($_GET['eliminar']))
	{
		$consulta = "select * from datos_reconocimientos where id=".$_GET['eliminar'];
		$db->consulta($consulta);
		$registro = $db->obtenerRegistro();
		if($registro['tipo'] == 'I')
			unlink('data/archivosReconocimiento/'.$registro['Contenido']);

		$consulta = "delete from datos_reconocimientos where id=".$_GET['eliminar'];
		$db->consulta($consulta);
	}
?>
<html>
<head>
	<title></title>
	<meta charset="utf-8"/>
	<script src="js/mouse.js" type="text/javascript"></script>
	<?php include('cssGeneral.php')?>
	<script>
		function actualizar(id)
		{
			document.getElementById('idPosiX'+id).value = parseInt(document.getElementById('idFormato'+id).style.left);
			document.getElementById('idPosiY'+id).value = parseInt(document.getElementById('idFormato'+id).style.top);
		}
	</script>
</head>
<body onload="carga()" style="background:#283747;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-3">
				<!-- Boton de vista previa -->
				<a href="diploma.php" target="_blank" class="btn btn-success btn-sm">
					<img src="img/iconos/ver.png">
					Vista Previa
				</a>
			</div>
			<div class="col-sm-3">
				<form action="?" method="post">
					<!-- Boton de agregar un elemento -->
					<button type="submit" name="nuevoElemento"  class="btn btn-success btn-sm">
						<img src="img/iconos/agregar.png">
						Agregar elemento
					</button>
				</form>
			</div>
			<div class="col-sm-3"></div>
		</div>

		<div class="row">
			<div class="col-sm-9">
				<div style="border: 1px solid grey;  position:relative; width: 970px; height: 1255px; background: white;">
					<?php
						$consulta = "select * from datos_reconocimientos";
						$db->consulta($consulta);
					?>
					<form method="post" action="?">
						<button type="submit" class="btn btn-success btn-sm" style="position: absolute; top:-46px;">
							<img src="img/iconos/refrescar.png">
							Actualizar
						</button>
						
					<?php
						for($i=0;$i<$db->numeroRegistros;$i++): 
							$row = $db->obtenerRegistro();
					?>
						<!-- Cada elemento en su ancho y largo se multiplican con 4.4921723 que es la escala de una hoja tamaño carta, ya que se guarda en posiX y posiY los pixeles no en longitud de milimentros -->
						<div id="idFormato<?=$row['id']?>" style="position:absolute; left:<?=$row['posiX']?>px; top:<?=$row['posiY']?>px; border: 1px solid grey; width:<?=$row['ancho']*4.5?>px; height:<?=$row['alto']*4.5?>px; font-size: 17px; padding: 0px;" onmousedown="comienzoMovimiento(event, this.id);"  onmouseover="this.style.cursor=\'move\'" onmouseup="actualizar(<?=$row['id']?>);">

							<?php if($row['tipo'] == "T"): ?>
							<?=$row['Contenido']?>
							<?php endif; ?>
							<?php if($row['tipo'] == "I"): ?>
								<img src="data/archivosReconocimiento/<?=$row['Contenido']?>" style="width: 100%; height: 100%;">
							<?php endif; ?>

							<input type="hidden" id="id<?=$i?>" name="id<?=$i?>" value="<?=$row['id']?>" />
							
							<!-- Boton de editar un elemento -->
							<a href="?editar=<?=$row['id']?>">
								<img style="position: absolute; left: 0px; top:-20px; border: 1px solid lightgrey;" src="img/editar.png">
							</a>
							<!-- Boton de eliminar un elemento -->
							<a href="?eliminar=<?=$row['id']?>">
								<img style="position: absolute; left: 25px; top:-20px; border: 1px solid lightgrey;" src="img/iconos/eliminar.png">
							</a>
						</div>
						<input type="hidden"  id="idPosiX<?=$row['id']?>" name="posiX<?=$row['id']?>" value="<?=$row['posiX']?>"/>
						<input type="hidden"  id="idPosiY<?=$row['id']?>" name="posiY<?=$row['id']?>" value="<?=$row['posiY']?>"/>
					<?php endfor; ?>
						<!-- Boton de atualizar todos los elementos -->
						<input type="hidden" name="num_registros" value="<?=$db->numeroRegistros?>">
					</form>
				</div>
			</div>
			<div class="col-sm-3">
				<?php
					if(isset($_GET['editar'])):
						$consulta = "select * from datos_reconocimientos where id=".$_GET['editar']." order by orden asc";
						$db->consulta($consulta);
						$row = $db->obtenerRegistro();
				?>
					<div class="card border-primary mb-3">
						<div class="card-header">Editar</div>
						<div class="card-body">
							<form method="post" >
								<label>X</label>
								<input type="number" name="posiX" value="<?=$row['posiX']?>" required class="form-control form-control-sm"/>
								<label>Y</label>
								<input type="number" name="posiY" value="<?=$row['posiY']?>" required class="form-control form-control-sm"class="form-control form-control-sm"/>
								<label>Contenido</label>
								<textarea name="contenido" required class="form-control form-control-sm"><?=$row['Contenido']?></textarea>
								<label>Orden</label>
								<input type="number" name="orden" value="<?=$row['orden']?>" required class="form-control form-control-sm"/>
								<label>Tamaño de Letra</label>
								<input type="number" name="tLetra" value="<?=$row['TLetra']?>" required class="form-control form-control-sm"/>
								<label>Ancho</label>
								<input type="number" name="ancho" value="<?=$row['ancho']?>" required class="form-control form-control-sm"/>
								<label>Alto</label>
								<input type="number" name="alto" value="<?=$row['alto']?>" required class="form-control form-control-sm"/>
								<input type="hidden" name="id" value="<?=$_GET['editar']?>">
								Negrita
								<input type="checkbox" name="N" value="1" <?=($row['N']==1?"checked":"")?> />&nbsp;&nbsp;
								Subrayar
								<input type="checkbox" name="S" value="1" <?=($row['S']==1?"checked":"")?> />&nbsp;&nbsp;
								Italic
								<input type="checkbox" name="I" value="1" <?=($row['I']==1?"checked":"")?> />
								<br/><br/>
								<input type="submit" name="guardar" value="Guardar" class="btn btn-success btn-sm"/>
							</form>
						</div>
					</div>
				<?php
					endif;
				?>

				<?php
					if(isset($_POST['nuevoElemento']))
						include('formulario.php');
				?>

			</div>
		</div>
		<br/>
	</div>
</body>
</html>