<?php
require_once 'clasacos.php'; 
require_once 'clasaproduse.php'; 

session_start();

if (isset($_GET['id'])) {
    $cos = unserialize($_SESSION['cos']);
    $id = $_GET['id']; 

    $items = $cos->getItems(); 

    if ($items!== null) { 
        foreach ($items as $key => $item) {
            if ($item->getId() == $id) {
                $item->setCantitate($item->getCantitate() - 1);
                if ($item->getCantitate() <= 0) {
                    $cos->removeItem($key); 
                }
                break;
            }
        }
    }

    $_SESSION['cos'] = serialize($cos);

    header('Location: cos.php');
    exit;
}