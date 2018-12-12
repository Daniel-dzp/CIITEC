<?php
	session_start();

	if(!isset($_SESSION['nombre']))
		header("location: index.php?m=3");
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
</body>
</html>