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
        $newName = $_POST['name'];
        $newQuantity = $_POST['quantity'];
        $newPrice = $_POST['price'];
        $index = $_POST['index'];

        // Verificar que el índice existe
        if (isset($_SESSION['list'][$index])) {
            // Verificar si el nuevo nombre ya existe en otro item (excepto el que estamos actualizando)
            $nameExists = false;
            foreach ($_SESSION['list'] as $i => $item) {
                if ($i != $index && $item['name'] === $newName) {
                    $nameExists = true;
                    break;
                }
            }

            if ($nameExists) {
                $error = '[ERROR]: An item with that name already exists.';
            } else {
                // Actualizar el item
                $_SESSION['list'][$index] = [
                    'name' => $newName,
                    'quantity' => $newQuantity,
                    'price' => $newPrice,
                ];
                $message = 'Item updated successfully!';
            }
        } else {
            $error = '[ERROR]: Item not found.';
        }

        // Editar un item (cargar datos en el formulario)
    } elseif (isset($_POST['edit'])) {
        $index = $_POST['index'];
        if (isset($_SESSION['list'][$index])) {
            $name = $_SESSION['list'][$index]['name'];
            $quantity = $_SESSION['list'][$index]['quantity'];
            $price = $_SESSION['list'][$index]['price'];
        }

        // Eliminar un item
    } elseif (isset($_POST['delete'])) {
        $index = $_POST['index'];
        if (isset($_SESSION['list'][$index])) {
            unset($_SESSION['list'][$index]);
            // Reindexar el array para evitar huecos
            $_SESSION['list'] = array_values($_SESSION['list']);
            $message = 'Item deleted successfully!';
        }

        // Reset de formulario
    } elseif (isset($_POST['reset'])) {
        $name = '';
        $quantity = '';
        $price = '';
        $index = '';
        $error = '';
        $message = 'Form reset successfully!';
    }
}

// Calculo para obtener coste total
if (isset($_POST['total'])) {
    $totalValue = 0;
    if (isset($_SESSION['list'])) {
        foreach ($_SESSION['list'] as $item) {
            $totalValue += $item['quantity'] * $item['price'];
        }
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

        .error {
            color: red;
            font-weight: bold;
        }

        .message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Shopping list</h1>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($quantity); ?>" min="1" required>
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($price); ?>" step="0.01" min="0" required>
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
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="index" value="<?php echo htmlspecialchars($index); ?>">
                                <input type="submit" name="edit" value="Edit">
                            </form>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="index" value="<?php echo htmlspecialchars($index); ?>">
                                <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><strong><?php echo htmlspecialchars($totalValue); ?></strong></td>
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