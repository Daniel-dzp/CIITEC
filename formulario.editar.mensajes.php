<?php
	include("tools/tools.php");
	$consulta = "select * from mensajes where id=".$_GET['id'];
	$db->consulta($consulta);
	$registro = $db->obtenerRegistro();
?>
<form id="idFormTaller" onsubmit="return false;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<label class="col-form-label col-form-label-sm">
					Mensaje
				</label>
			</div>
			<div class="col-sm-8">
				<input type="text" class="form-control form-control-sm" name="mensaje" value="<?=$registro['mensaje']?>" />
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-sm-12" style="text-align: center;">
				<input type="button" class="btn-sm btn btn-success" value="Guardar" onclick="accion2('idFormTaller');"/>
			</div>
		</div>
	</div>
	<input type="hidden" name="accion" value="save">
	<input type="hidden" name="tabla" value="mensajes">
	<input type="hidden" name="pk" value="id">
	<input type="hidden" name="valor" value="<?=$registro['id']?>">
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>">
</form>