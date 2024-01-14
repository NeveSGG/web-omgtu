<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
  <?php include('./components/head.php') ?>

  <body>
    <main>
      <?php include('./components/header.php') ?>
      <?php
        $dsn = "mysql:host=localhost;dbname=propo_database";
        $username = "root";
        $password = "W4&KhpizoBbnnp4N";

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Failed to connect to the database: " . $e->getMessage());
        }

        $page = $_GET['page'] ?? '1';
        $perpage = 10;
        $offset = ($page - 1) * $perpage;

        if (array_key_exists('q', $_GET)) {
          $query = $_GET['q'];
          $sql = "SELECT * FROM product WHERE name LIKE '%$query%' LIMIT $perpage OFFSET $offset";
        } else {
          $sql = "SELECT * FROM product LIMIT $perpage OFFSET $offset";
        }
        $result = $pdo->query($sql);

        $products = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }

        $countSql = isset($query) ? "SELECT COUNT(*) FROM product WHERE name LIKE '%$query%'" : "SELECT COUNT(*) FROM product";
        $countResult = $pdo->query($countSql);
        $totalCount = $countResult->fetchColumn();

        $last_page = ceil($totalCount / $perpage);
      ?>
      <div class="container">
        <div
          style="padding-top: 36px; width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap">
          <h2>Программы<?= isset($query) ? ' - результаты поиска' : '' ?></h2>
          <button type="button" class="btn btn-primary" data-bs-json-data='[{
                    "id": "subcategory_id",
                    "name": "subcategory_id",
                    "label": "id Подкатегории",
                    "type": "number"
                  }, {
                    "id": "name",
                    "name": "name",
                    "label": "Название",
                    "type": "text"
                  }, {
                    "id": "description",
                    "name": "description",
                    "label": "Описание",
                    "type": "text"
                  }, {
                    "id": "rating",
                    "name": "rating",
                    "label": "Рейтинг",
                    "type": "number"
                  }, {
                    "id": "license_type",
                    "name": "license_type",
                    "label": "Тип лицензии",
                    "type": "text"
                  }, {
                    "id": "language",
                    "name": "language",
                    "label": "Язык",
                    "type": "text"
                  }, {
                    "id": "developers",
                    "name": "developers",
                    "label": "Разработчик",
                    "type": "text"
                  }, {
                    "id": "downloads",
                    "name": "downloads",
                    "label": "Количество скачиваний",
                    "type": "number"
                  }, {
                    "id": "slug",
                    "name": "slug",
                    "label": "Человеко-понятный URL",
                    "type": "text"
                  }]' data-bs-toggle="modal" data-bs-target="#addModal" data-bs-table-name="product">Добавить
            программу</button>
        </div>

        <div class="input-group pt-4" style="max-width: 450px">
          <input id="search_field_id" type="search" class="form-control rounded" style="border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;" placeholder="Поиск по названию" aria-label="Search"
            aria-describedby="search-addon" value="<?= isset($query) ? $query : '' ?>" />
          <button id="search_button_id" type="button" class="btn btn-outline-primary"
            data-mdb-ripple-init>Найти</button>
        </div>

        <div class="mt-4">
          <div class="row text-center border">
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>id</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>id Подкатегории</b></div>
            <div class="col themed-grid-col col-2 p-3 border-bottom"><b>Название</b></div>
            <div class="col themed-grid-col col-2 p-3 border-bottom"><b>Описание</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>Рейтинг</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>Лицензия</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>Язык</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>Разработчик</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>Скачиваний</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>ЧПУ</b></div>
          </div>

          <?php foreach ($products as $product): ?>
          <div class="row row-cols-2 gx-4 text-center position-relative">
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="id"><?= $product["id"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="subcategory_id">
              <?= $product["subcategory_id"] ?></div>
            <div class="col themed-grid-col col-2 border p-2 text-truncate" data-name="name"><?= $product["name"] ?>
            </div>
            <div class="col themed-grid-col col-2 border p-2 text-truncate" data-name="description">
              <?= $product["description"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="rating"><?= $product["rating"] ?>
            </div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="license_type">
              <?= $product["license_type"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="language">
              <?= $product["language"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="developers">
              <?= $product["developers"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="downloads">
              <?= $product["downloads"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="slug"><?= $product["slug"] ?>
            </div>
            <div class="row-buttons"
              style="width: min-content; padding: 0; display: none; gap: 8px; position: absolute; top: 2px; right: 0">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                data-bs-table-name="product" data-bs-json-data='[{
                    "id": "id",
                    "name": "id",
                    "label": "id",
                    "type": "number",
                    "initialValue": "<?= $product["id"] ?>"
                  }, {
                    "id": "subcategory_id",
                    "name": "subcategory_id",
                    "label": "id Подкатегории",
                    "type": "numbrt",
                    "initialValue": "<?= $product["subcategory_id"] ?>"
                  }, {
                    "id": "name",
                    "name": "name",
                    "label": "Название",
                    "type": "text",
                    "initialValue": "<?= $product["name"] ?>"
                  }, {
                    "id": "description",
                    "name": "description",
                    "label": "Описание",
                    "type": "text",
                    "initialValue": "<?= $product["description"] ?>"
                  }, {
                    "id": "rating",
                    "name": "rating",
                    "label": "Рейтинг",
                    "type": "number",
                    "initialValue": "<?= $product["rating"] ?>"
                  }, {
                    "id": "license_type",
                    "name": "license_type",
                    "label": "Тип лицензии",
                    "type": "text",
                    "initialValue": "<?= $product["license_type"] ?>"
                  }, {
                    "id": "language",
                    "name": "language",
                    "label": "Язык",
                    "type": "text",
                    "initialValue": "<?= $product["language"] ?>"
                  }, {
                    "id": "developers",
                    "name": "developers",
                    "label": "Разработчик",
                    "type": "text",
                    "initialValue": "<?= $product["developers"] ?>"
                  }, {
                    "id": "downloads",
                    "name": "downloads",
                    "label": "Количество скачиваний",
                    "type": "number",
                    "initialValue": "<?= $product["downloads"] ?>"
                  }, {
                    "id": "slug",
                    "name": "slug",
                    "label": "Человеко-понятный URL",
                    "type": "text",
                    "initialValue": "<?= $product["slug"] ?>"
                  }]' style="width: 40px; padding: 6px;"><i class="bi bi-pencil"></i></button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-bs-label="<?= $product["name"] ?>" data-bs-table="product" data-bs-id="<?= $product["id"] ?>"
                style="width: 40px; padding: 6px;"><i class="bi bi-trash"></i></button>
            </div>
          </div>
          <?php endforeach; ?>


        </div>

        <nav aria-label="pagination">
          <ul class="pagination" id="pagination" style="margin-top: 30px" data-current-page="<?= $page ?>"
            data-last-page="<?= $last_page ?>">
          </ul>
        </nav>
      </div>
    </main>
    <?php include('./components/footer.php') ?>
  </body>

</html>