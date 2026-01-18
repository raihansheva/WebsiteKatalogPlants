<?php
session_start();

// $urlPath = dirname($_SERVER['PHP_SELF']);
define('BASE_URL', '/WebsiteKatalogPlants');
$urlPath = BASE_URL;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="/WebsiteKatalogPlants/asset/image/favIcon.png">
    <title>Floratify</title>
    <?php if (!empty($page_css)): ?>
        <link rel="stylesheet" href="/WebsiteKatalogPlants/asset/style/main.css" />
        <link rel="stylesheet" href="/WebsiteKatalogPlants/asset/style/<?= $page_css ?>">
    <?php endif; ?>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="area-navbar">
            <div class="logo">Floratify.</div>
            <div class="area-menu-nav">
                <a href="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? '#' : '../index.php'; ?>" class="link-menu">Home</a>
                <a href="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'pages/plant.php' : 'plant.php'; ?>" class="link-menu">Plant & Shop</a>
                <a href="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'pages/categorie.php' : 'categorie.php'; ?>" class="link-menu">Categorie</a>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'pages/cart.php' : 'cart.php'; ?>" class="link-menu">Cart</a>
                    <a href="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'pages/orderItems.php' : 'orderItems.php'; ?>" class="link-menu">Order</a>
                <?php else: ?>
                <?php endif; ?>
                <a href="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? '#about' : '../index.php#about'; ?>" class="link-menu">About</a>
                <?php if (isset($_SESSION['user'])): ?>
                <?php else: ?>
                    <div
                        class="button-register"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalRegister">
                        <p class="link-register">Register</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div
        class="modal fade"
        id="exampleModalRegister"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-2">
                    <div class="area-modal-register">
                        <div class="area-modal-image-register">
                            <h2 class="tagline-register">Bring Nature Home.</h2>
                        </div>
                        <div class="area-register">
                            <h2 class="title-brand-register">Floratify.</h2>
                            <div class="line"></div>
                            <h2 class="title-register">Register</h2>
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="notifAlert">
                                    <p class="textNotif"><?= ($_SESSION['error']) ?></p>
                                </div>
                            <?php endif; ?>
                            <form class="form-register" action="<?= $urlPath ?>/functions/regis.php" method="post">
                                <input
                                    class="input-register"
                                    type="text"
                                    name="nama"
                                    id=""
                                    placeholder="Nama" require />
                                <input
                                    class="input-register"
                                    type="email"
                                    name="email"
                                    id=""
                                    placeholder="Email" require />
                                <input
                                    class="input-register"
                                    type="text"
                                    name="username"
                                    id=""
                                    placeholder="Username" require />
                                <input
                                    class="input-register"
                                    type="password"
                                    name="password"
                                    id=""
                                    placeholder="Password" require />
                                <button class="button-submit-register" type="submit">Submit</button>
                                <span class="span-register">Sudah Punya Akun?, <span class="textS" data-bs-target="#exampleModalLogin" data-bs-toggle="modal">Login</span></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        id="exampleModalLogin"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-2">
                    <div class="area-modal-login">
                        <div class="area-modal-image">
                            <h2 class="title-login-brand">Floratify.</h2>
                        </div>
                        <div class="area-login">
                            <div class="line"></div>
                            <h2 class="title-login">Login</h2>
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="notifAlert">
                                    <p class="textNotif"><?= ($_SESSION['error']) ?></p>
                                </div>
                            <?php endif; ?>
                            <form class="form-login" action="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'functions/login.php' : '/WebsiteKatalogPlants/functions/login.php'; ?>" method="post">
                                <input
                                    class="input-login"
                                    type="text"
                                    name="username"
                                    id=""
                                    placeholder="Username" require />
                                <input
                                    class="input-login"
                                    type="password"
                                    name="password"
                                    id=""
                                    placeholder="Password" require />
                                <button class="button-submit-login" type="submit">Login</button>
                                <span class="span-register">Belum Punya Akun?, <span class="textS" data-bs-target="#exampleModalRegister" data-bs-toggle="modal">Register</span></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>


    </script>