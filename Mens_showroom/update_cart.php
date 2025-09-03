<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $size_id = (int)$_POST['size_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($product_id > 0 && $size_id > 0 && $quantity > 0) {
        if (isset($_SESSION['cart'][$product_id][$size_id])) {
            $_SESSION['cart'][$product_id][$size_id]['quantity'] = $quantity;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}