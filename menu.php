	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="home.php">CIITEC 2018</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="perfil.php">Perfil</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="doctos.php">Doctos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="mensajes.php">Mensajes</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="pagos.php">Pagos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="conferencias.php">Conferencias</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="ModificarDiploma.php">Diplomas</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php">Cerrar</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="about.php">About</a>
				</li>
			</ul>
		</div>
		<span class="my-2 my-lg 0" style="color: white; font-weight: 500;"><?php echo $_SESSION['nombre'].'&nbsp;&nbsp;'; ?></span>
		<img src="<?php
					echo (is_file('data/fotos/perfiles/'.$_SESSION['id'].'.jpg'))?
						"data/fotos/perfiles/".$_SESSION['id'].".jpg?".rand()
						: "img/usuario.png";
					?>" class="foto-mini">
	</nav>