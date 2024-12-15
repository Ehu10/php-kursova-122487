<?php

require_once('../functions.php');
require_once('../db.php');
session_start();

$response = [
    'success' => true,
    'error' => '',
    'data' => []
];

$product_id = intval($_POST['product_id'] ?? 0);
$user_id = $_SESSION['user_id'] ?? 0;

if ($product_id <= 0 || $user_id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Невалидни данни за продукта или потребителя!";
    header('Location: ../index.php?page=products');
    exit;
}

try {
    $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM cart WHERE user_id = :user_id AND product_id = :product_id');
    $checkStmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $exists = $checkStmt->fetchColumn();

    if ($exists) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Продуктът вече е добавен в количката!";
    } else {
        $insertStmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)');
        $insertStmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

        $_SESSION['flash']['message']['type'] = 'success';
        $_SESSION['flash']['message']['text'] = "Продуктът беше добавен успешно в количката!";
    }
} catch (Exception $e) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при добавяне на продукта в количката!";
}


header('Location: ../index.php?page=products');
exit;
?>
