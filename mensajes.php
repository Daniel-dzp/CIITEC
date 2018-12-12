<?php
	session_start();

	if(!isset($_SESSION['nombre']))
		header("location: index.php?m=3");

	include("tools/tools.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Mensajes</title>
	
	<?php include("cssGeneral.php"); ?>
	<link rel="stylesheet" href="css/jquery-confirm.min.css">
	<script src="js/jquery-confirm.min.js"></script>
	<script src="js/funciones.js"></script>

	<meta charset="utf-8"/>
</head>
<body>
	<?php include("menu.php"); ?>

	<br/>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8" id="idTabla">
				<?php
					
					if(isset($_POST['accion']))
					{
						$db->accion($_POST['accion']);
					}
					else
					{
						if(!isset($_GET['pagina']))
							$_GET['pagina'] = 0;
						echo $db->tabla("mensajes", $_GET['pagina'],array("delete", "edit"), true);
					}

				?>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>

</body>
</html>
