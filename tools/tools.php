<?php

class tool
{
		var $numeRenglones;
		var $conexion;
		var $bloque;
		var $error;
		var $numeroRegistros;

		//var_dump($_POST);

		function tool()
		{
			$this->conexion = mysqli_connect
			(
				'localhost',
				'root',
				'',
				'congreso'
			);
		}

		function obtenerRegistro()
		{
			return mysqli_fetch_array($this->bloque);;
		}

		function accion($cual)
		{
			$tabla = $_POST['tabla'];
			if(isset($_POST['pagina']))
				$pagina = $_POST['pagina'];
			else
				$pagina = 0;

			switch($cual)
			{
				case 'delete':
					$consulta="delete from ".$_POST['tabla']." where ".$_POST['pk']."='".$_POST['valor']."';";
					$this->consulta($consulta);

					echo $this->tabla("mensajes", $pagina,array("delete", "edit"), true);
					break;
				case 'list':
					echo $this->tabla("mensajes", $pagina,array("delete", "edit"), true);
					break;
				case 'formNew':
					echo $this->nuevo();
					break;
				case 'add':
					$this->agregar();

					echo $this->tabla("mensajes", $pagina, array("delete", "edit"), true);
					break;
				case "edit":
					$consulta = "select * from ".$_POST['tabla']." where ".$_POST['pk']."='".$_POST['valor']."'";
					echo $this->editar($consulta);
					break;
				case 'save':
					$consulta = "select * from ".$_POST['tabla'];
					$this->guardar($consulta);

					echo $this->tabla("mensajes", $pagina, array("delete", "edit"), true);
					break;
			}

		}

		function guardar($consulta)
		{
			$this->consulta($consulta);

			$col = mysqli_num_fields($this->bloque);
			$omitir = 0;
			$consulta = "update ".$_POST['tabla']." set ";
			for ($c=0; $c <$col ; $c++)
			{ 
				$campo = mysqli_fetch_field($this->bloque);
				if(!(($campo->flags & MYSQLI_PRI_KEY_FLAG) && $campo->type==3))
					$consulta.= ($c-$omitir>0? ', ':'').$campo->name.'="'.$_POST[$campo->name].'" ';
				else
					$omitir=1;
			}

			$consulta .= " where ".$_POST['pk']."='".$_POST['valor']."';";

			//echo $consulta;
			$this->consulta($consulta);
		}

		function editar($consulta)
		{
			$this->consulta($consulta);

			$result = '<div class="card border-primary mb-3">'.
					'<div class="card-header">
						<img src="img/iconos/editar.png"/>
						Editar en '.$_POST['tabla'].'</div>'.
					'<div class="card-body">';
			$result .= '<form method="post">';

			$col = mysqli_num_fields($this->bloque);
			$row = mysqli_fetch_array($this->bloque);

			for ($c=0; $c <$col ; $c++)
			{ 
				$campo = mysqli_fetch_field($this->bloque);
				if(!(($campo->flags & MYSQLI_PRI_KEY_FLAG) && $campo->type==3))
					$result.= '<label for="id'.$campo->name.'" class="col-form-label col-form-label-sm">'.$campo->name.'</lable><br>'.
							'<input type="'.tipoDato($campo->type).'" id="id'.$campo->name.'" name="'.$campo->name.'" class="form-control form-control-sm" '.(tipoDato($campo->type)=='datetime'?' pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-9]{2}" placeholder="0000-00-00 00:00:00" ':' ').' value="'.$row[$campo->name].'" '.' required/><br/>';
				$tabla=$campo->table;
			}

			$result .= '<input type="hidden" name="tabla" value="'.$_POST['tabla'].'" />';
			$result .= '<input type="hidden" name="pk" value="'.$_POST['pk'].'" />';
			$result .= '<input type="hidden" name="valor" value="'.$_POST['valor'].'" />';
			$result .= '<input type="hidden" name="accion" value="save" />';
			$result .= '<input type="submit" value="Guardar" class="btn btn-primary btn-sm" />'.
				'</form> </div> </div>';
			return $result;
		}

		function agregar()
		{
			$this->consulta("select * from ".$_POST['tabla']);

			$col = mysqli_num_fields($this->bloque);
			$omitir = 0;
			$consulta = "insert into ".$_POST['tabla']."(";
			$consulta2 = " values(";
			for ($c=0; $c <$col ; $c++)
			{ 
				$campo = mysqli_fetch_field($this->bloque);
				if(!(($campo->flags & MYSQLI_PRI_KEY_FLAG) && $campo->type==3))
				{
					$consulta.= ($c-$omitir>0? ', ':'').$campo->name;
					$consulta2.= ($c-$omitir>0? ', ':'')."'".$_POST[$campo->name]."'";
				}
				else
					$omitir=1;
			}

			$consulta .= ") ";
			$consulta2 .=");";

		
			$this->consulta($consulta.$consulta2);

		}

		function nuevo()
		{
			$this->consulta("select * from ".$_POST['tabla']." limit 1");
			
			$result = '<div  class="card border-primary mb-3">'.
					'<div class="card-header">Insertar en '.$_POST['tabla'].'</div>'.
					'<div class="card-body">';
			$result .= '<form method="post">';
			$col = mysqli_num_fields($this->bloque);

			for ($c=0; $c <$col ; $c++)
			{ 
				$campo = mysqli_fetch_field($this->bloque);
				if(!(($campo->flags & MYSQLI_PRI_KEY_FLAG) && $campo->type==3))
					$result.= '<label class="col-form-label col-form-label-sm" for="id'.$campo->name.'">'.$campo->name.'<lable><br>'.
							'<input class="form-control form-control-sm" type="'.tipoDato($campo->type).'" id="id'.$campo->name.'" name="'.$campo->name.'"  '.(tipoDato($campo->type)=='datetime'?' pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-9]{2}" placeholder="0000-00-00 00:00:00" ':' ').' required autocomplete="off"/><br/>';
				$tabla=$campo->table;
			}

			$result .= '<input type="hidden" name="tabla" value="'.$_POST['tabla'].'" />';
			$result .= '<input type="hidden" name="accion" value="add" />';
			$result .= '<input type="submit" value="Guardar" class="btn btn-primary btn-sm" />'.
				'</form> </div> </div>';

			return $result;
		}

		function consulta($consulta)
		{
			$this->bloque = mysqli_query( $this->conexion, $consulta);
			$this->error = mysqli_error($this->conexion);

			if($this->error == "")
			{
				if(strpos(strtoupper($consulta), "SELECT") !== false)
					$this->numeroRegistros = mysqli_num_rows($this->bloque);
			}
			else
				$this->numeroRegistros = -1;
		}

		function closeBD()
		{
			mysqli_close($this->conexion);
		}
			
				
		// metodo pra desplegar una tabla dinamica
		// recibe el numero de renglones y columnas, asi como la clase css del renglon par
		function tabla($tabla, $pagina, $iconos=array())
		{
			$this->consulta("select count(*) as cuantos from ".$tabla);
			$tupla = $this->obtenerRegistro();

			$numeroItemPagina = 7;
			$totalPaginas = ceil($tupla['cuantos']/$numeroItemPagina);

			$result = "";

			$this->consulta("select * from ".$tabla." limit ".($pagina*$numeroItemPagina).", ".$numeroItemPagina);

			$ren=$this->numeroRegistros;
			
			$columnapk="";

			$result.='<div >';
	
				$col = mysqli_num_fields($this->bloque);
				
				$result.= '<table class="table">';
				

				$result .='<tr class="table-primary">
								<th colspan="'.($col+count($iconos)).'" >
									<div class="row">
										<div class="col-1">
											<img src="img/iconos/nuevo.png"  class="icono-nuevo-mensaje" value="Insertar" onclick="frame(\'formulario'.$tabla.'.php\',\'Agregar '.$tabla.'\',\'\',\'\')" style="cursor: pointer;"/>
										</div>
										<div class="col-11" style="text-align:center;">
											'.strtoupper($tabla).'
										</div>
									</div>
								</th>
							</tr>';

				// crea las casillas vacias en la cabecera
				$result.= '<tr class="table-primary">';
				foreach ($iconos as $value) 
					$result .= '<td></td>';
				
				//crea los nombres de las cabeceras
				for ($c=0; $c <$col ; $c++)
				{ 
					$campo = mysqli_fetch_field($this->bloque);
					$result.= "<th>".strtoupper($campo->name)."</th>";
					$tabla=$campo->table;
					
					if($campo->flags & MYSQLI_PRI_KEY_FLAG)
						$columnapk = $campo->name;
				}
				$result.= "</tr>";

				//crea las celdas de la tabla
				for ($i=0; $i < $ren ; $i++)
				{ 
					if($i%2)
		                $result.= '<tr class="table-secondary">';
		            else
		            	$result.= '<tr class="table-primary">';

		            $row = mysqli_fetch_array($this->bloque); // obtiene una fila de la consulta

		            if(in_array("edit", $iconos))
		            	$result.='<td style="width:36px;">'.
		            			'<img type="image" src="img/Edit-icon.png" value="edit" onclick="frameEditar(\'formulario.editar.'.$tabla.'.php\',\'Editar '.$tabla.'\','.$row[$columnapk].',\'\',\'\','.$pagina.')" class="icono-editar"/> </td>';

		            if(in_array("delete", $iconos))
		            	$result.='<td style="width:36px;">
		            <form method="post" ><input class="icono-eliminar" type="image" src="img/trash-icon.png" onclick="return confirm(\'Seguro de borrar? '.$row[$columnapk].'\')"/>'.
		            		'<input type="hidden" name="tabla" value="'.$tabla.'" />'.
		            			'<input type="hidden" name="pk" value="'.$columnapk.'" />'.
		            			'<input type="hidden" name="valor" value="'.$row[$columnapk].'" />'.
		            			'<input type="hidden" name="accion" value="delete"/></form></td>';

					for ($j=0; $j <$col ; $j++) 
						$result.= '<td>'.$row[$j].'</td>';
					$result.= "</tr>";
				}

			$result.= "</table>";
			$result.= "</div>";

			$result.='<div>
						<ul class="pagination pagination-sm">';
			if($pagina!=0)
				$result .= 	'<li class="page-item ">
						      <a class="page-link" href="?pagina='.($pagina-1).'">&laquo;</a>
						    </li>';

			for($p=0;$p<$totalPaginas;$p++)
				$result .= '<li class="page-item '.($p==$pagina?"active":"").'">
      							<a class="page-link" href="?pagina='.$p.'">'.($p+1).'</a>
    						</li>';

    		if($pagina!=$totalPaginas-1)
			$result .= '	<li class="page-item">
					    		<a class="page-link" href="?pagina='.($pagina+1).'">&raquo;</a>
					    	</li>';

			$result .=	'</ul>
					</div>';
			

			return $result;
		}
	}

	function tipoDato($tipo)
	{
		$tipo;

		switch($tipo)
		{
			case 12: $tipo = "datetime"; break;
			case 3: $tipo = "number"; break;
			default: $tipo = "text";
		}

		return $tipo;
	}

	$db = new tool();

?>