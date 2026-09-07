<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/css/adminlte.min.css">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="img/logo1.png" type="image/x-icon">
	<title>Horarios login</title>
</head>

<body>
	<header>
		<div class="d-flex flex-row-reverse">
			<img class="img" src="img/cenigraf.png">
		</div>
	</header>
	<div class="container">
		<div class="card-body">
			<div class="wrapper">
				<form action="controlador/val.php" method="POST" class="p-2 mt-2">
					<div class="form-group mb-3">
						<label for="email">Email:</label>
						<div class="form-field d-flex align-items-center">
							<input type="email" class="mr-sm-2 form-control " placeholder="Digite su email" name="correo" id="email" required="">
						</div>
					</div>
					<div class="form-group mb-3">
						<label for="email">Contraseña:</label>
						<div class="form-field d-flex align-items-center">
							<input type="password" class="form-control" placeholder="Digite su contraseña" name="contra" id="pwd" required="">
						</div>
						<div class="d-flex justify-content-between mt-4">
							<button type="submit" class="btn btn-dark">Entrar</button><br>
						</div>
					</div>
				</form>
				<div class="text-center fs-6">
					<a href="./restablecer.php" class="link-secondary">¿Olvidó su contraseña?</a>
				</div>
				<?php
				if (isset($_GET['x'])) { ?>
					<br>
					<div class="alert alert-danger alert-dismissible fade show">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Error de autenticación</strong>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<footer class="main-footer">
		<strong> Copyright &copy; <?php echo date('Y'); ?> <a href="https://comunicaciongraficasena.blogspot.com">Cenigraf</a>.</strong> Todos los derechos reservados.
	</footer>
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>