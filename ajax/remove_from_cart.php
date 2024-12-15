<?php
require_once('../db.php');
session_start();

$product_id = intval($_POST['product_id'] ?? 0);

if ($product_id <= 0 || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Невалидни данни']);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id');
if ($stmt->execute(['user_id' => $user_id, 'product_id' => $product_id])) {
    $countStmt = $pdo->prepare('SELECT COUNT(*) FROM cart WHERE user_id = :user_id');
    $countStmt->execute(['user_id' => $user_id]);
    $cartCount = $countStmt->fetchColumn();

    echo json_encode(['success' => true, 'cart_count' => $cartCount]);
} else {
    echo json_encode(['success' => false, 'error' => 'Грешка при премахването']);
}
