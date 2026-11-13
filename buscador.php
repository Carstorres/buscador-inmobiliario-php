
<?php

$contenido = file_get_contents("data-1.json");

$propiedades = json_decode($contenido, true);

$mostrarTodos = isset($_GET['todos']);

$resultados = array();

if ($mostrarTodos) {

    $resultados = $propiedades;

} else {

    $valorPrecio = isset($_POST['precio']) ? $_POST['precio'] : '200;80000';

    preg_match_all('/\d+/', $valorPrecio, $coincidencias);

    $precioMinimo = isset($coincidencias[0][0]) ? (int)$coincidencias[0][0] : 200;

    $precioMaximo = isset($coincidencias[0][1]) ? (int)$coincidencias[0][1] : 80000;

    $ciudadSeleccionada = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';

    $tipoSeleccionado = isset($_POST['tipo']) ? $_POST['tipo'] : '';

    foreach ($propiedades as $propiedad) {

        $precio = (int)preg_replace('/\D/', '', $propiedad['Precio']);

        $coincidePrecio = $precio >= $precioMinimo && $precio <= $precioMaximo;

        $coincideCiudad = $ciudadSeleccionada == '' || $propiedad['Ciudad'] == $ciudadSeleccionada;

        $coincideTipo = $tipoSeleccionado == '' || $propiedad['Tipo'] == $tipoSeleccionado;

        if ($coincidePrecio && $coincideCiudad && $coincideTipo) {

            $resultados[] = $propiedad;

        }

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de búsqueda</title>

    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/customColors.css"/>

    <style>
        body {
            background: #f5f5f5;
            padding: 25px;
        }

        .contenedor {
            max-width: 1200px;
            margin: auto;
        }

        .propiedad {
            margin-bottom: 20px;
        }
    </style>

</head>

<body>

<div class="contenedor">

    <h3>Resultados de la búsqueda</h3>

    <p>Propiedades encontradas: <?php echo count($resultados); ?></p>

    <a href="index.php" class="btn">Volver al buscador</a>

    <div class="row">

        <?php if (count($resultados) > 0) { ?>

            <?php foreach ($resultados as $propiedad) { ?>

                <div class="col s12 m6 l4 propiedad">

                    <div class="card white">

                        <div class="card-content">

                            <span class="card-title">
                                <?php echo htmlspecialchars($propiedad['Tipo']); ?>
                            </span>

                            <p>
                                <strong>Precio:</strong>
                                <?php echo htmlspecialchars($propiedad['Precio']); ?>
                            </p>

                            <p>
                                <strong>Dirección:</strong>
                                <?php echo htmlspecialchars($propiedad['Direccion']); ?>
                            </p>

                            <p>
                                <strong>Ciudad:</strong>
                                <?php echo htmlspecialchars($propiedad['Ciudad']); ?>
                            </p>

                            <p>
                                <strong>Teléfono:</strong>
                                <?php echo htmlspecialchars($propiedad['Telefono']); ?>
                            </p>

                            <p>
                                <strong>Código postal:</strong>
                                <?php echo htmlspecialchars($propiedad['Codigo_Postal']); ?>
                            </p>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } else { ?>

            <p>No se encontraron propiedades con los filtros seleccionados.</p>

        <?php } ?>

    </div>

</div>

</body>
</html>
