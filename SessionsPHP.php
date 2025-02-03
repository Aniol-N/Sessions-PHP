<?php
session_start();

// Inicializar variables
if (!isset($_SESSION["worker"])) {
    $_SESSION["worker"] = '';
}
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        'softdrink' => 0,
        'water' => 0,
        'chicken' => 0,
        'eggs' => 0,
        'rice' => 0,
    ];
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // WORKER NAME
    if (isset($_POST["worker"])) {
        $_SESSION["worker"] = htmlspecialchars($_POST["worker"]);
    }


    // SELECT PRODUCT
    $product = isset($_POST["product"]) ? $_POST["product"] : '';


    // CANTIDAD PRODUCTO
    if (isset($_POST['bAdd']) && $product && isset($_SESSION['products'][$product])) {
        $_SESSION['products'][$product]++;
    }
    if (isset($_POST['bRemove']) && $product && isset($_SESSION['products'][$product])) {
        if ($_SESSION['products'][$product] > 0) {
            $_SESSION['products'][$product]--;
        }
    }
    if (isset($_POST['reset'])) {
        $_SESSION['products'] = [
            'softdrink' => 0,
            'water' => 0,
            'chicken' => 0,
            'eggs' => 0,
            'rice' => 0,
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SessionsPHP by Aniol Nicolau</title>
</head>

<body>
    <h1>Práctica Pr4 Sessions PHP</h1>
    <form action="" method="POST">
        <h2>Supermarket management</h2>

        <!-- Campo del trabajador CORREGIDO  -->
        <label for="worker">Worker name:</label>
        <input type="text" name="worker"
            value="<?php echo htmlspecialchars($_SESSION['worker']); ?>"
            placeholder="Su nombre" required>
        <br>

        <!-- Selección de producto -->
        <h3>Choose product: <br></h3>
        <select name="product" id="product">
            <option value="softdrink">Soft drink</option>
            <option value="water">Water</option>
            <option value="chicken">Chicken</option>
            <option value="eggs">Eggs</option>
            <option value="rice">Rice</option>
        </select>

        <!-- Botones  -->
        <h3>Product quantity: <br></h3>
        <button type="submit" name="bAdd" value="add">Add</button>
        <button type="submit" name="bRemove" value="remove">Remove</button>
        <button type="submit" name="reset" value="reset">Reset All</button>

        <!-- Inventario -->
        <h3>Inventory: <br></h3>
        <?php
        // Mostrar trabajador
        echo "Worker name: " . htmlspecialchars($_SESSION['worker']) . "<br>";

        // Mostrar productos
        foreach ($_SESSION['products'] as $product => $quantity) {
            echo ucfirst($product) . ": " . $quantity . "<br>";
        }
        ?>
    </form>
</body>

</html>