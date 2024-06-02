<?php
session_start();

$db_host = 'mysql_db';
$db_username = 'root';
$db_password = 'toor';
$db_name = 'images';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

require_once 'clasacos.php';
require_once 'clasaproduse.php';

$product_id = $_POST['product_id'];

if (!isset($_SESSION['cos'])) {
    $cart = new Cos();
} else {
    $cart = unserialize($_SESSION['cos']);
}

$stmt = $conn->prepare("SELECT * FROM images WHERE id =?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product_data = $result->fetch_assoc();

$product = new Produse($product_data['id'], $product_data['descriere'], $product_data['image_data']);

$cart->addItems($product);

$_SESSION['cos'] = serialize($cart);

header('Location: menu.php');
exit;