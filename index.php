<?php

if (file_exists("data.txt")) {
    $jsonClientes = file_get_contents("data.txt");
    $aClientes = json_decode($jsonClientes, true);
} else {
   $aClientes = array();
}

$id = isset($_GET["id"]) ? $_GET["id"] : '';

if(isset($_GET["id"]) && isset($_GET["do"]) && $_GET["do"] == "eliminar"){
    unset($aClientes[$id]);
    $jsonClientes = json_encode($aClientes);
    file_put_contents("data.txt", $jsonClientes);
}

if($_POST){

    $dni = $_POST["txtDni"];
    $nombre = $_POST["txtNombre"];
    $telefono = $_POST["txtTelefono"];
    $correo = $_POST["txtCorreo"];
    $nombreImagen = "";

    if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
        $nombreAleatorio = date("Ymdhmsi");
        $archivo_tmp = $_FILES["archivo"]["tmp_name"];
        $nombreArchivo = $_FILES["archivo"]["name"];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreImagen = $nombreAleatorio . "." . $extension;
        move_uploaded_file($archivo_tmp, "archivos/$nombreImagen");
    }


    if(isset($_GET["id"])){
        //Si hay una imagen anterior eliminarla, siempre y cuando se suba una nueva imagen
        $imagenAnterior = $aClientes[$id]["imagen"];

        if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
            if($imagenAnterior != ""){
                unlink("archivos/$imagenAnterior");
            }
        }        
        if ($_FILES["archivo"]["error"] !== UPLOAD_ERR_OK) {
            $nombreImagen = $imagenAnterior;
        }

        //Actualizada
        $aClientes[$id] = array("dni" => $dni,
            "nombre" => $nombre,
            "telefono" => $telefono,
            "correo" => $correo,
            "imagen" => $nombreImagen
        );
    } else {
        //Es nuevo
        $aClientes[] = array("dni" => $dni,
            "nombre" => $nombre,
            "telefono" => $telefono,
            "correo" => $correo,
            "imagen" => $nombreImagen
        );
    }
    
    //Convertir el array en json
    $jsonClientes = json_encode($aClientes);

    //Guardar el json en un afile_put_contents("data.txt", $jsonClientes);rchivo data.txt con file_put_contents
    file_put_contents("data.txt", $jsonClientes);
    $id = "";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="css/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="css/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center py-3">
                <h1>Registro de clientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-12">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="txtDni">DNI:</label>
                            <input type="text" id="txtDni" name="txtDni" class="form-control" required value="<?php echo isset($aClientes[$id])? $aClientes[$id]["dni"] : ''; ?>">
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" id="txtNombre" name="txtNombre" class="form-control" required value="<?php echo isset($aClientes[$id])? $aClientes[$id]["nombre"] : ''; ?>">
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtTelefono">Teléfono:</label>
                            <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" required value="<?php echo isset($aClientes[$id])? $aClientes[$id]["telefono"] : ''; ?>"> 
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtCorreo">Correo:</label>
                            <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" required value="<?php echo isset($aClientes[$id])? $aClientes[$id]["correo"] : '';?>">
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtCorreo">Archivo adjunto:</label>
                            <input type="file" id="archivo" name="archivo" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 col-12">
                <table class="table table-hover border">
                    <tr>
                        <th>Imagen</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($aClientes as $key => $cliente): ?>
                    <tr>
                            <td><img src="archivos/<?php echo $cliente["imagen"]; ?>" class="img-thumbnail"></td>
                            <td><?php echo $cliente["dni"]; ?></td>
                            <td><?php echo $cliente["nombre"]; ?></td>
                            <td><?php echo $cliente["correo"]; ?></td>
                            <td style="width: 110px;">
                            <a href="index.php?id=<?php echo $key ?>"><i class="fas fa-edit"></i></a>
                            <a href="index.php?id=<?php echo $key ?>&do=eliminar"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <a href="index.php"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    
</body>
</html>