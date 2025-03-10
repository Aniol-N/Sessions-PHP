<?php
// Session start
session_start();

// Inicializar variables
$name = '';
$quantity = '';
$price = '';
$index = '';
$error = '';
$message = '';
$totalValue = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Añadir item en el formulario
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Verificar si el item ya existe en la lista
        $itemExists = false;
        if (isset($_SESSION['list'])) {
            foreach ($_SESSION['list'] as $item) {
                if ($item['name'] === $name) {
                    $itemExists = true;
                    break;
                }
            }
        }

        if ($itemExists) {
            $error = '[ERROR]: You can not add 2 items with the same name.';
        } else {
            // Guardar en session
            $_SESSION['list'][] = [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
            ];
            $message = 'Item added successfully!';
        }

        // Actualizar un item
    } elseif (isset($_POST['update'])) {

        // Reset de formulario
    } elseif (isset($_POST['reset'])) {
    }
}

// Calculo para obtener coste total
if (isset($_POST['total'])) {
    $totalValue = 0;
    foreach ($_SESSION['list'] as $item) {
        $totalValue += $item['quantity'] * $item['price'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping list</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($price); ?>">
        <br>
        <input type="hidden" name="index" value="<?php echo htmlspecialchars($index); ?>">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>

    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['list'])): ?>
                <?php foreach ($_SESSION['list'] as $index => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity'] * $item['price']); ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($item['name']); ?>">
                                <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                                <input type="hidden" name="price" value="<?php echo htmlspecialchars($item['price']); ?>">
                                <input type="hidden" name="index" value="<?php echo htmlspecialchars($index); ?>">
                                <input type="submit" name="edit" value="Edit">
                                <input type="submit" name="delete" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo htmlspecialchars($totalValue); ?></td>
                <td>
                    <form method="post">
                        <input type="submit" name="total" value="Calculate total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>