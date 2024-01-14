<?php
  $current_script = $_SERVER['PHP_SELF'];
?>
<header class="py-3 mb-4 border-bottom">
  <div class="container d-flex flex-wrap justify-content-center">
    <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto ">
      <span class="fs-4">Админ-панель <a class="link-body-emphasis text-decoration-none"
          href="https://pro-po.store">Pro-po</a></span>
    </p>

    <ul class="nav nav-pills">
      <li class="nav-item"><a href="/"
          <?= $current_script == '/index.php' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>>Категории</a>
      </li>
      <li class="nav-item"><a href="subcategories.php"
          <?= $current_script == '/subcategories.php' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>>Подкатегории</a>
      </li>
      <li class="nav-item"><a href="media.php"
          <?= $current_script == '/media.php' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>>Медиа</a>
      </li>
      <li class="nav-item"><a href="programs.php"
          <?= $current_script == '/programs.php' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>>Программы</a>
      </li>
      <li class="nav-item"><a href="versions.php"
          <?= $current_script == '/versions.php' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>>Версии</a>
      </li>
      <li class="nav-item"><a href="more.php"
          <?= $current_script == '/more.php' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>>Дополнительно</a>
      </li>
    </ul>
  </div>
</header>