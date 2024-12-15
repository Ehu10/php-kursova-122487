<?php
require_once('../db.php');

$response = ['success' => true, 'data' => []];
$user_id = $_SESSION['user_id'];

$sql = 'SELECT p.title, p.price, c.quantity FROM cart_items c INNER JOIN products p ON c.product_id = p.id WHERE c.user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);

$response['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($response);
exit;
