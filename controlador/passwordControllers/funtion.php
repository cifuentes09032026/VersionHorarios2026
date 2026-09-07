<?php 
include("conexionpoo.php");
require_once 'conexionpoo.php';

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$contrasena = $_POST["contrasena"];

// Verificar pedido
$query   ="SELECT * FROM instructor WHERE id = $id";
$result = $db->query($query);
if(mysqli_num_rows($result) == 1) {
    // Sí existe el pedido
    $query   ="UPDATE instructores SET  Nombre= '$Nombre', email= '$email', contrasena='$contrasena' WHERE id = '$id' ";

    if ($db->query($query)) {
        echo "<script> alert('Usted ha cambiado el estado del pedido, por favor ejecute el delivery');
                        location.href = 'delivery.php';
                        </script>";
    } else {
        echo "Error al Registrar, vuevla a intentarlo" . mysqli_error($db);
    }
} else {
    echo "<script> alert('El número de pedido que intenta ingresar no existe, por favor verifiquelo e intente de nuevo.');
    location.href = 'dashboard.php';
    </script>";
    // No existe el pedido

}
?>