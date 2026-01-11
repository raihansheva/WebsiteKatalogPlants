<?php
session_start();
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
</head>

<body>
    <nav>
        <div class="area-navbar">
            <div class="logo">Floratify.</div>
            <div class="area-menu-nav">
                <a href="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? '#' : 'index.php'; ?>" class="link-menu">Home</a>
                <a href="plant.php" class="link-menu">Plant</a>
                <a href="#" class="link-menu">Categorie</a>
                <a href="#about" class="link-menu">About</a>
                <div
                    class="button-login"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <p class="link-login">Login</p>
                </div>
            </div>
        </div>
    </nav>
    <div
        class="modal fade"
        id="exampleModal"
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
                            <!--  -->
                            <div class="line"></div>
                            <h2 class="title-login">Login</h2>
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="notifAlert">
                                    <p class="textNotif"><?= ($_SESSION['error']) ?></p>
                                </div>
                            <?php endif; ?>
                            <form class="form-login" action="../functions/login.php" method="post">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>