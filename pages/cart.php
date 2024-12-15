<?php
require_once('db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('
        SELECT p.id, p.title, p.price, c.quantity 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = :user_id
    ');
    $stmt->execute(['user_id' => $user_id]);
    $cartItems = $stmt->fetchAll();
} else {
    $cartItems = [];
}


if (isset($_POST['submit'])) {
    echo '<div class="alert alert-success" role="alert">Благодарим Ви за поръчката! Ще се свържем с вас по имейл за подробности.</div>';
}
?>

<h1>Вашата кошница</h1>
<div>
    <?php if (empty($cartItems)): ?>
        <p>Вашата кошница е празна.</p>
    <?php else: ?>
        <?php foreach ($cartItems as $item): ?>
            <div>
                <h2><?= htmlspecialchars($item['title']) ?></h2>
                <p>Цена: <?= htmlspecialchars($item['price']) ?> лв.</p>
                <p>Количество: <?= htmlspecialchars($item['quantity']) ?></p>
            </div>
        <?php endforeach; ?>
        <form method="POST">
        <button type="submit" class="btn btn-primary" name="submit">Заяви поръчка</button>
        </form>
        <?php endif; ?>
    
</div>
