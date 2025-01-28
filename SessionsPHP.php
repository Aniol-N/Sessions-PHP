<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SessionsPHP by Aniol Nicolau</title>
</head>

<body>
    <h1>Práctica Pr4 Sessions PHP</h1>
    <form action="" method="GET">
        <h2>Supermarket managment</h2>
        <!-- CODIGO FORM + PHP PARA WORKER NAME -->
        <label for="worker">Worker name:</label>
        <input type="worker" name="worker" value="<?php echo isset($_GET['worker']) ? htmlspecialchars($_GET['worker']) : ''; ?>" placeholder="Su nombre" required>
        <br>

        <!-- CODIGO FORM PARA PRODUCT CHOICE -->
        <h3>Choose product: <br></h3>
        <select name="product" id="product">
            <option value="softdrink">Soft drink</option>
            <option value="water">Water</option>
            <option value="chicken">Chicken</option>
            <option value="eggs">Eggs</option>
            <option value="rice">Rice</option>
        </select>

        <!-- CODIGO FORM PARA DEEFINIR CANTIDAD -->
        <h3>Procuct quantity: <br></h3>
        <button type="add" name="add" value="add">add</button>
        <button type="remove" name="remove" value="remove">remove</button>
        <button type="reset" name="reset" value="reset">reset</button>

        <!-- CODIGO FORM + PHP PARA MOSTRAR INVENTORY -->
        <h3>Inventory: <br></h3>
        <?php echo "Worker name: " . $_GET['worker']; ?>
        <br>

    </form>
</body>

</html>