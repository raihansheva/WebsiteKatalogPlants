<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        <div class="logo">FloratifyAdmin.</div>
        <div class="area-menu-nav">
          <a href="dashboard.php" class="link-menu">Dashboard</a>
          <a href="adminPlant.php" class="link-menu">Plants</a>
          <a href="adminCategories.php" class="link-menu">Kategori</a>
          <div
            class="button-login"
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
          >
            <p class="link-login">Logout</p>
          </div>
        </div>
      </div>
    </nav>
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
          <div class="modal-body p-2">
            <div class="area-modal-login">
              <div class="area-login">
                <div class="line"></div>
                <!-- <h2 class="title-login-brand">Floratify.</h2> -->
                <h2 class="title-logout">Mau logout?</h2>
                <form class="form-login" action="../functions/logout.php" method="post">
                  <button class="button-submit-login" type="submit">Logout</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>