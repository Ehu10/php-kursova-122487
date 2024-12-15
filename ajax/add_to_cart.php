<?php
require_once('../db.php');
session_start();

$response = [
    'success' => true,
    'error' => '',
    'data' => []
];

$product_id = intval($_POST['product_id'] ?? 0);

if ($product_id <= 0 || !isset($_SESSION['user_id'])) {
    $response['success'] = false;
    $response['error'] = 'Невалидни данни';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM cart WHERE user_id = :user_id AND product_id = :product_id');
    $checkStmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $exists = $checkStmt->fetchColumn();

    if ($exists) {
        $response['success'] = false;
        $response['error'] = 'Продуктът вече е добавен';
    } else {
        $insertStmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)');
        $insertStmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

        $countStmt = $pdo->prepare('SELECT COUNT(*) FROM cart WHERE user_id = :user_id');
        $countStmt->execute(['user_id' => $user_id]);
        $cartCount = $countStmt->fetchColumn();

        $response['data']['cart_count'] = $cartCount;
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['error'] = 'Грешка при добавянето на продукта в количката';
}

echo json_encode($response);
exit;
?>
