<?php

require_once 'clasacos.php'; 
require_once 'clasaproduse.php'; 

session_start();

if (!isset($_SESSION['cos'])) {
    $_SESSION['cos'] = serialize(new Cos());
}

$cos = unserialize($_SESSION['cos']);

if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $image_data = 'image_data_'. $id;
    $descriere = 'descriere_'. $id;
    $produs = new Produse($id, $image_data, $descriere);
    $cos->addItems($produs);
    $_SESSION['cos'] = serialize($cos);
    header('Location:cart.php');
    exit;
}

$items = $cos->getItems();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        li:last-child {
            border-bottom: none;
        }
        a {
            text-decoration: none;
            color: #337ab7;
        }
        a:hover {
            color: #23527c;
        }
    </style>
</head>
<body>
    <h1>Cart</h1>
    <ul>
        <?php foreach ($items as $item) {?>
            <li>
                <strong>ID:</strong> <?php echo $item->getId();?><br>
                <strong>Description:</strong> <?php echo $item->getDescriere();?><br>
                <strong>Quantity:</strong> <?php echo $item->getCantitate();?><br>
                <a href="delete_from_cart.php?id=<?php echo $item->getId();?>">Delete</a>
            </li>
        <?php }?>
    </ul>
    <form action="menu.php">
        <input type="submit" value="Back to Menu" class="btn">
    </form>
</body>
</html>