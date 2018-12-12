<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" src="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script>
		$(function(){$("#tabs").tabs();});

		function apaga(cual)
		{
			if(cual == 1)
				if($("p").is(":visible"))
					$("p").hide();
				else
					$("p").show();
			else
				if(cual == 2)
					if($("span").is(":visible"))
						$("span").fadeOut();
					else
						$("span").fadeIn();
			//$("span").toggle();

		}

		
	</script>
</head>
<body>
	<p>Hola mundo</p>
	<p>Soy de sistemas o informatica y soy my feliz!!</p>
	<span>Bueno casi siempre como 3% de mi vida soy feliz, me dicen el dementor</span>
	<br/>
	<input type="button" onclick="apaga(1)" value="Apaga Parrafos">
	<input type="button" onclick="apaga(2)" value="Apaga Span">
	<br/><br/><br/>

	<div id="tabs">
		<ul>
			<li><a href="#tabArticulos">ARTICULOS</a></li>
			<li><a href="#tabTalleres">TALLERES</a></li>
			<li><a href="#tabEventos">EVENTOS</a></li>
		</ul>
		<div id="tabArticulos">
			ARTICULOS
		</div>
		<div id="tabTalleres">
			TALLERES
		</div>
		<div id="tabEventos">
			EVENTOS
		</div>
	</div>
</body>
</html>