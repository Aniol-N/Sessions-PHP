<?php
// Iniciar la sesión
session_start();

// Definir el array inicial si no existe en la sesión
if (!isset($_SESSION['numbers'])) {
    $_SESSION['numbers'] = array(10, 20, 30);
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Modificar el array
    if (isset($_POST['modify'])) {
        $position = $_POST['position'];
        $value = $_POST['value'];
        // Modificar el valor en la posición seleccionada
        $_SESSION['numbers'][$position] = $value;
    }
    // Calcular el promedio
    elseif (isset($_POST['average'])) {
        $average = array_sum($_SESSION['numbers']) / count($_SESSION['numbers']);
    }
    // Reiniciar el array
    elseif (isset($_POST['reset'])) {
        $_SESSION['numbers'] = array(10, 20, 30); 
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Array en Sesión</title>
</head>

<body>
    <h1>Modificar array guardado en sesión</h1>
    <form action="" method="POST">
        <label for="position">Posición a modificar:</label>
        <select id="position" name="position">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <br><br>
        <label for="value">Nuevo valor:</label>
        <input type="text" id="value" name="value">
        <br><br>
        <button type="submit" name="modify" value="modify">Modificar</button>
        <button type="submit" name="average" value="average">Media</button>
        <button type="submit" name="reset" value="reset">Reset</button>
    </form>

    <p>Current array: <?php echo implode(', ', $_SESSION['numbers']); ?></p>
    <?php if (isset($average)): ?>
        <p>Average: <?php echo $average; ?></p>
    <?php endif; ?>
</body>

</html>