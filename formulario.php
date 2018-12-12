	<div class="card border-primary mb-3" style="max-width: 20rem;">
		<div class="card-header">Nuevo</div>
		<div class="card-body">
			<div class="form-group form-group-sm">
			<label for="idSeleccion">Seleccione</label>
				<select class="form-control form-control-sm" id="idSeleccion" required onchange="mostrarFormulario(this.value);">
					<option value="T" >Texto</option>
					<option value="I" >Imagen</option>
				</select>
			</div>
			<hr/>
			<form id="formularioTexto" method="post">
				X
				<input type="number" id="idPosiX" name="posiX" required class="form-control form-control-sm"/>
				Y
				<input type="number" id="idPosiY" name="posiY" required class="form-control form-control-sm"/>
				Contenido
				<textarea id="idContenido" name="contenido" required class="form-control form-control-sm"/></textarea>
				Orden
				<input type="number" id="idOrden" name="orden" required class="form-control form-control-sm"/>
				Tamaño letra
				<input type="number" id="idTLetra" name="tLetra" value="10" required class="form-control form-control-sm"/>
				Ancho
				<input id="idAncho" name="ancho" required class="form-control form-control-sm"/>
				Alto
				<input type="number" id="idAlto" name="alto" required class="form-control form-control-sm"/>
				Negrita
				<input type="checkbox" name="N" value="1">&nbsp;&nbsp;
				Subrayar
				<input type="checkbox" name="S" value="1">&nbsp;&nbsp;
				Italic
				<input type="checkbox" name="I" value="1">
				<br/><br/>
				<input type="submit" name="texto" value="Agregar" class="btn btn-success btn-sm"/>
			</form>
			<form method="post" enctype="multipart/form-data" id="formularioImagen">
				X
				<input type="number"  id="idPosiX" name="posiX" required class="form-control form-control-sm"/>
				Y
				<input type="number" id="idPosiY" name="posiY" required class="form-control form-control-sm"/>
				Imagen
				<input type="file" name="imagen" required class="form-control-file"/>
				Orden
				<input type="number" id="idOrden" name="orden" required class="form-control form-control-sm"/>
				Ancho
				<input type="number" id="idAncho" name="ancho" required class="form-control form-control-sm"/>
				Alto
				<input type="number" id="idAlto" name="alto" required class="form-control form-control-sm"/>
				<br/>
				<input type="submit" name="grafico" value="Agregar" class="btn btn-success btn-sm" />
			</form>

		</div>
	</div>
	</div>

<script>
	var formT = document.getElementById('formularioTexto');
	var formI = document.getElementById('formularioImagen');
	var selec = document.getElementById('idSeleccion');
	mostrarFormulario(selec.value);

	// funcion para ocultar y mostrar los formularios.
	function mostrarFormulario(valor)
	{
		formT.style.display = "none";
		formI.style.display = "none";
		if(valor == 'T')
			formT.style.display = "block";
		if(valor == 'I')
			formI.style.display = "block";
	}
</script>