<?php
require_once('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Трябва да влезете в профила си, за да направите поръчка.';
    header('Location: index.php?page=login');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare('DELETE FROM cart WHERE user_id = :user_id');
if ($stmt->execute(['user_id' => $user_id])) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = 'Вашата поръчка е успешно направена!';
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Възникна грешка при обработката на поръчката.';
}

header('Location: index.php?page=cart');
exit;
?>
