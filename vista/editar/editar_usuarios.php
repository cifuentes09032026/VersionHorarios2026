<?php
$id= $_GET['id'];
$pageTitle = 'editar usuario';
include("../plantillas/parte_superior.php");
$conexion= mysqli_connect("localhost", "root", "", "beta_horarios");
$consulta= "SELECT * FROM instructor WHERE id = $id";
$resultado= mysqli_query($conexion, $consulta);
$usuario= mysqli_fetch_assoc($resultado);

if (isset($_POST['modificar'])) {
	//RECUPERAR LOS DATOS QUE ESTAN EN EL FORMULARIO.
$id=$_POST['id'];
$Nombre=$_POST['Nombre'];
$email=$_POST['email'];
$contrasena=md5 ($_POST['contrasena']);

	//REALIZAR LA CONSULTA PARA MODIFICAR LOS DATOS.
		$sql="UPDATE instructor SET Nombre='$Nombre',email='$email',contrasena='$contrasena' WHERE id ='$id'";
		$resultado=mysqli_query($conexion,$sql);
		if ($resultado) {
			?>
    <script>
            alert('Usuario actualizado ...');
            window.location.href='../Usuarios.php';
            </script>
    <?php
		}else{
			?>
    <script>
            alert('No se puede actualizar el encargado por que algun dato ya existe, intente nuevamente.');
            window.location.href='';
            </script>
    <?php
		}
 }

?>



<!DOCTYPE html>
<html lang="es-MX">
<head>
        <title>Registro</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="view/Css/estiloprincipal.css" rel="stylesheet" type="text/CSS">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
<body id="page-top">

<form method="post">
<div class="content-wrapper">
  <div class="container">
    <br>
    <div class="row" style="display: contents;">
      <div class="col-sm-8 mx-auto">
        <div class="container border" style="padding: 4%; background-color: #a2a1a5a8;">
          <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="form-group">
              <label for="Nombre">Nombre:</label>
              <input type="text" id="Nombre" name="Nombre" class="form-control" value="<?php echo $usuario['Nombre']; ?>" required>
            </div>

            <div class="form-group">
              <label for="email">Correo:</label>
              <input type="email" name="email" id="email" class="form-control" value="<?php echo $usuario['email']; ?>" required>
            </div>

            <div class="form-group">
              <label for="contrasena">Contraseña:</label>
              <input type="password" name="contrasena" id="contrasena" class="form-control" value="<?php echo $usuario['contrasena']; ?>" required>
            </div>

            <div class="btn-group">
              <a href="../Usuarios.php" class="btn btn-secondary"><i class="bi-arrow-left"></i> Atrás</a>
              <button type="submit" name="modificar" class="btn btn-success">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</form>

<div style="height: 450px;"></div>
<?php include("../parte_inferior.php"); ?>

</body>
</html>
