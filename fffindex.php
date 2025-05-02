<?php 
	require_once realpath(__DIR__ . '/autoload.php');
?>
<html>
	<head>
		<title>Institución Educativa XYZ</title>
		<meta charset="utf-8">
		<meta name="viewport" content="with=device-with, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/estilos.css">
	</head>
	<body>
		<header>
			<h1>SGEV</h1>
			<p>Sistema Gestor Educativo Virtual</p>
		</header>
		<nav>
			<a href="">Inicio</a>
			<a href="">Acerca de Nosotros</a>
			<a href="">Contáctenos</a>
			<a href="">Programas</a>
			<a href="">Servicios</a>
		</nav>
		<aside>
			<h3>Avalados por el Sena y el MEN</h3>
			<img src="img/sena.avif" height="50px">
			<img src="img/mineducacion.jpg">
		</aside>
		<aside class="estilo1">
			Tipo de Documento <br>
		<form name="iniciosesion" method="post" action="pages/inicio.html">
			<select name="tipodedocumento">
                <option value="CC">Cédula de Ciudadanía Colombiana</option>
                <option value="TI">Tarjeta de Identidad</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="CE">Cédula de extranjería</option>
            </select><br><br>
			Número de Identificación<br> <input type="text" name="NoId" maxlength="15"><br><br>
			password<br> <input type="password" name="contrasenia1" maxlength="30"><br>
			<input type="submit" name="iniciosesion" value="Ingreso Estudiantes" class="boton"><br><br>
			<a href=".//pages/inicio_profesor.html" class="boton">Ingreso Docentes</a>
			<center><a href="pages/registro.html">Registrarse</a><br></center>
		</form>
		</aside>
		<section>
			<h1>¡Bienvenido!</h1>
				<p class="estilo2">
					Estudia con nosotros. Contamos con los mejores programas, docentes e instalaciones, para fomarte como un gran profesional para el futuro.
				</p>
				<p class="estilo2">
					En la institución XYZ puedes encontrar desde programas técnicos hasta profesionales. ¡No lo dudes más, somos la mejor opción!
				</p>
		</section>
		<footer>Instintución XYZ 2024</footer>
	</body>
</html>