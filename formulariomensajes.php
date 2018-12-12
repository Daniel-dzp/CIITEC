<form id="idFormTaller" onsubmit="return false;">
	<input type="hidden" name="tabla" value="mensajes">
	<input type="hidden" name="accion" value="add">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<label class="col-form-label col-form-label-sm">
					Mensaje
				</label>
			</div>
			<div class="col-sm-8">
				<input type="text" class="form-control form-control-sm" name="mensaje"/>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-sm-12" style="text-align: center;">
				<input type="button" class="btn-sm btn btn-success" value="Agregar" onclick="accion2('idFormTaller');"/>
			</div>
		</div>
	</div>
</form>
