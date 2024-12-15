<?php
require_once('../functions.php');
require_once('../db.php');

session_start();

$id = intval($_POST['product_id'] ?? 0);
$user_id = $_SESSION['user_id'] ?? 0;

if ($id <= 0 || $user_id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешен идентификатор на продукт или не сте влезли в профила!";
    header('Location: ../index.php?page=cart');
    exit;
}

$query = "DELETE FROM cart WHERE product_id = :product_id AND user_id = :user_id";
$stmt = $pdo->prepare($query);

if ($stmt->execute(['product_id' => $id, 'user_id' => $user_id])) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше премахнат от кошницата!";
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при премахване на продукта от кошницата!";
}

header('Location: ../index.php?page=cart');
exit;
?>