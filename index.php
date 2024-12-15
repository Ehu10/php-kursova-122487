<?php
require_once('functions.php');
require_once('db.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}
if ($page === 'products') {
header("refresh: 1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн магазин за козметика</title>
    <link href="https://bootswatch.com/5/flatly/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<script>
$(function() {
    function updateCartCount(count) {
        $('#cart-count').text(count); 
    }

    function showNotification(message) {
        if ("Notification" in window && Notification.permission === "granted") {
            new Notification(message);
        } else if ("Notification" in window && Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    new Notification(message);
                }
            });
        } else {
            alert(message);
        }
    }

    
    $(document).on('click', '.add-to-cart', function () {
    let btn = $(this);
    let productId = btn.data('product');

    $.ajax({
        url: './ajax/add_to_cart.php',
        method: 'POST',
        data: { product_id: productId },
        success: function (response) {
            let res = JSON.parse(response);

            if (res.success) {
                
                showNotification('Продуктът беше добавен в количката');
                
                
                $('#cart-count').text(res.cart_count);

                
                let removeBtn = $(`<button type="button" class="btn btn-sm btn-danger remove-from-cart" data-product="${productId}">Премахни от количката</button>`);
                btn.replaceWith(removeBtn);
            } else {
                showNotification(res.error || 'Грешка при добавянето');
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
});
    
    $(document).on('click', '.remove-from-cart', function() {
    let btn = $(this);
    let productId = btn.data('product');

    $.ajax({
        url: './ajax/remove_from_cart.php',
        method: 'POST',
        data: { product_id: productId },
        success: function(response) {
            let res = JSON.parse(response);

            if (res.success) {
                
                showNotification('Продуктът беше премахнат от количката');
                $('#cart-count').text(res.cart_count);

                let addBtn = $(`<button type="button" class="btn btn-sm btn-primary add-to-cart" data-product="${productId}">Добави в количката</button>`);
                btn.replaceWith(addBtn);
 
                if (btn.closest('tr').length) {
                    btn.closest('tr').remove();
                }
            } else {
                showNotification(res.error || 'Грешка при премахването');
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
});

});
</script>



    <header>
        

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">Онлайн магазин за козметика</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link <?php echo($page == 'home' ? 'active' : '') ?>" href="?page=home">Начало</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo($page == 'products' ? 'active' : '') ?>" href="?page=products">Продукти</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo($page == 'cart' ? 'active' : '') ?>" href="?page=cart">Кошница</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo($page == 'contacts' ? 'active' : '') ?>" href="?page=contacts">Контакти</a></li>
                    </ul>
                    <div class="d-flex flex-row align-items-center gap-3">
                        <?php
                            if (isset($_SESSION['username'])) {
                                echo '<span class="text-light me-3">Здравей, ' . htmlspecialchars($_SESSION['username']) . '</span>';
                                echo '
                                    <form method="POST" action="./handlers/handle_logout.php" class="m-0">
                                        <button type="submit" class="btn btn-outline-light">Изход</button>
                                    </form>
                                ';
                            } else {
                                echo '<a href="?page=login" class="btn btn-outline-light">Вход</a>';
                                echo '<a href="?page=register" class="btn btn-outline-light">Регистрация</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        <?php
            if (isset($flash['message'])) {
                echo '<div class="alert alert-' . $flash['message']['type'] . '">' . $flash['message']['text'] . '</div>';
            }
            if (file_exists("pages/$page.php")) {
                require_once("pages/$page.php");
            } else {
                require_once("pages/not_found.php");
            }
        ?>
    </main>

    <footer class="bg-dark text-center py-5 mt-auto">
        <div class="container">
            <span class="text-light">© 2024 Всички права запазени</span>
        </div>
    </footer>
</body>
</html>