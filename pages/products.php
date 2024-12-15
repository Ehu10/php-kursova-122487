
<?php
// Страница за продукти
$products = [];

$search = $_GET['search'] ?? '';

$sql = 'SELECT * FROM products WHERE title LIKE :search';
$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => '%' . $search . '%']);

while ($row = $stmt->fetch()) {
    $cart_query = "SELECT id FROM cart WHERE user_id = :user_id AND product_id = :product_id";
    $cart_stmt = $pdo->prepare($cart_query);
    $cart_params = [
        ':user_id' => $_SESSION['user_id'] ?? 0,
        ':product_id' => $row['id']
    ];
    $cart_stmt->execute($cart_params);
    $row['in_cart'] = $cart_stmt->fetch() ? 1 : 0;

    $products[] = $row;
}

if (mb_strlen($search) > 0) {
    setcookie('last_search', $search, time() + 3600, '/', '', false, false);
}
?>

<div class="row">
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="hidden" name="page" value="products">
            <input type="text" class="form-control" placeholder="Търси козметичен продукт" name="search" value="<?php echo $search ?>">
            <button class="btn btn-primary" type="submit">Търсене</button>
        </div>
    </form>

    <div class="alert alert-info">
        Последно търсене: <?php echo $_COOKIE['last_search'] ?? 'няма'; ?>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-between">
    <?php
    foreach ($products as $product) {
        $cart_button = '';
        if (isset($_SESSION['username'])) {
            if ($product['in_cart'] == '1') {
                $cart_button = '
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-from-cart" data-product="' . $product['id'] . '">Премахни от кошницата</button>
                    </div>
                ';
            } else {
                $cart_button = '
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-sm btn-primary add-to-cart" data-product="' . $product['id'] . '">Добави в кошницата</button>
                    </div>
                ';
            }
        }

        echo '
            <div class="card mb-4" style="width: 18rem;">
                <img src="uploads/' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($product['title']) . '</h5>
                    <p class="card-text">' . htmlspecialchars($product['price']) . ' лв.</p>
                </div>
                ' . $cart_button . '
            </div>
        ';
    }
   
    ?>
</div>