<?php
if(file_exists("clientes.txt")){
    $jsonClientes = file_get_contents("clientes.txt"); 
    $aClientes = json_decode($jsonClientes, true);
} else {
    $aClientes = array();
}

$pos = $_GET["pos"];
print_r($pos);
exit;

if($_POST){ /* es postback */
    //Definicion de variables
    $dni = $_POST["txtDni"];
    $nombre = $_POST["txtNombre"];
    $telefono = $_POST["txtTelefono"];
    $correo = $_POST["txtCorreo"];

    //Analizamos cada accion de los botones
    if(isset($_POST["btnInsertar"])){
        //Convertir los datos del formulario en un array
        $aClientes[] = array("dni" => $dni,
                            "nombre" => $nombre,
                            "telefono" => $telefono,
                            "correo" => $correo);

        //Convertir el array en json
        $jsonClientes = json_encode($aClientes);

        //Guardar en el archivo la variable json
        file_put_contents("clientes.txt", $jsonClientes);
    } else if(isset($_POST["btnModificar"])) {

    } else if(isset($_POST["btnBorrar"])) {

    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://nelsontarche.com.ar/css/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="https://nelsontarche.com.ar/css/fontawesome/css/fontawesome.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center py-3">
                <h1>Registro de clientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="txtDni">DNI:</label>
                            <input type="text" id="txtDni" name="txtDni" class="form-control" required >
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" id="txtNombre" name="txtNombre" class="form-control" required>
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtTelefono">Teléfono:</label>
                            <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" required> 
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtCorreo">Correo:</label>
                            <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="btnInsertar" name="btnInsertar" class="btn btn-primary">Insertar</button>
                            <button type="reset" id="btnLimpiar" name="btnLimpiar" class="btn btn-secondary">Limpiar</button>
                            <button type="submit" id="btnBorrar" name="btnBorrar" class="btn btn-danger">Borrar</button>
                            <button type="submit" id="btnModificar" name="btnModificar" class="btn btn-success">Modificar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <table class="table table-hover border">
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($aClientes as $cliente) { ?>
                    <tr>
                        <td><?php echo $cliente["dni"]; ?></td>
                        <td><?php echo $cliente["nombre"]; ?></td>
                        <td><?php echo $cliente["correo"]; ?></td>
                        <td><i class="fas fa-edit"></i></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>