<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/css/adminlte.min.css">
	<link rel="stylesheet" href="style.css">
	<title>Horarios login</title>
</head>

<body>
	<header>
		<div class="d-flex flex-row-reverse">
			<img class="img" src="img/cenigraf.png">
		</div>
	</header>
	<div class="container">
		<div class="wrapper">
			<form action="./vista/olvicontra.php" method="POST" class="p-2 mt-2">
				<div class="form-group mb-3">
					<label for="email">Email:</label>
					<div class="form-field d-flex align-items-center">
					<input type="text" class="mr-sm-2 form-control " placeholder="Digite su email" name="correo" required="">
				</div>
				</div>
				<div class="d-flex justify-content-between mt-4">
					<button type="submit" name="pass-reset" class="btn btn-dark">Enviar</button>
				</div>
			</form>
			<div class="text-center fs-6">
				<a href="index.php" class="link-secondary">Iniciar sesión</a>
			</div>
			<?php
			if (isset($_SESSION['status'])) {
			?>
				<div class="alert alert-success alert-dismissible fade show">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong><?= $_SESSION['status']; ?></strong>
				</div>
		</div>
	<?php
				unset($_SESSION['status']);
			} ?>
	</div>
	</div>
	<footer class="main-footer">
		<strong>Copyright &copy; 2022 <a href="https://comunicaciongraficasena.blogspot.com">Cenigraf</a>.</strong> Todos los derechos reservados.
	</footer>
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>