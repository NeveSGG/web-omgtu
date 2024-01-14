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
          $sql = "SELECT * FROM version WHERE name LIKE '%$query%' LIMIT $perpage OFFSET $offset";
        } else {
          $sql = "SELECT * FROM version LIMIT $perpage OFFSET $offset";
        }
        $result = $pdo->query($sql);

        $versions = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $versions[] = $row;
        }

        $countSql = isset($query) ? "SELECT COUNT(*) FROM version WHERE name LIKE '%$query%'" : "SELECT COUNT(*) FROM version";
        $countResult = $pdo->query($countSql);
        $totalCount = $countResult->fetchColumn();

        $last_page = ceil($totalCount / $perpage);
      ?>
      <div class="container">
        <div
          style="padding-top: 36px; width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap">
          <h2>Версии<?= isset($query) ? ' - результаты поиска' : '' ?></h2>
          <button type="button" class="btn btn-primary" data-bs-json-data='[{
                    "id": "product_id",
                    "name": "product_id",
                    "type": "number",
                    "label": "id программы"
                  }, {
                    "id": "name",
                    "name": "name",
                    "type": "text",
                    "label": "Название"
                  }, {
                    "id": "platform",
                    "name": "platform",
                    "type": "text",
                    "label": "Платформа",
                    "enum": [{
                      "label": "Android",
                      "value": "android"
                    }, {
                      "label": "IPhone",
                      "value": "iphone"
                    }, {
                      "label": "Windows",
                      "value": "windows"
                    }]
                  }, {
                    "id": "version",
                    "name": "version",
                    "type": "text",
                    "label": "Версия"
                  }, {
                    "id": "download_url",
                    "name": "download_url",
                    "type": "file",
                    "label": "Файл"
                  }, {
                    "id": "is_last",
                    "name": "is_last",
                    "type": "checkbox",
                    "label": "Является последней версией"
                  }]' data-bs-toggle="modal" data-bs-target="#addModal" data-bs-table-name="version">Добавить
            версию</button>
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
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>id программы</b></div>
            <div class="col themed-grid-col col-3 p-3 border-bottom"><b>Название</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>Платформа</b></div>
            <div class="col themed-grid-col col-2 p-3 border-bottom"><b>Версия</b></div>
            <div class="col themed-grid-col col-3 p-3 border-bottom"><b>Файл</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>Последняя версия</b></div>
          </div>

          <?php foreach ($versions as $version): ?>
          <div class="row row-cols-2 gx-4 text-center position-relative">
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="id"><?= $version["id"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="product_id">
              <?= $version["product_id"] ?></div>
            <div class="col themed-grid-col col-3 border p-2 text-truncate" data-name="name"><?= $version["name"] ?>
            </div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="platform">
              <?= $version["platform"] ?></div>
            <div class="col themed-grid-col col-2 border p-2 text-truncate" data-name="version">
              <?= $version["version"] ?></div>
            <div class="col themed-grid-col col-3 border p-2 text-truncate" data-name="download_url"><a
                href="https://pro-po.store<?= $version["download_url"] ?>"
                download="<?= $version["name"] ?>"><?= $version["download_url"] ?></a></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate " data-name="is_last"><input type="checkbox"
                class="form-check-input" <?= $version["is_last"] ? 'checked' : '' ?> disabled /></div>
            <div class="row-buttons"
              style="width: min-content; padding: 0; display: none; gap: 8px; position: absolute; top: 2px; right: 0">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                data-bs-table-name="version" data-bs-json-data='[{
                    "id": "id",
                    "name": "id",
                    "label": "id",
                    "type": "number",
                    "initialValue": "<?= $version["id"] ?>"
                  }, {
                    "id": "product_id",
                    "name": "product_id",
                    "label": "id программы",
                    "type": "nubmer",
                    "initialValue": "<?= $version["product_id"] ?>"
                  }, {
                    "id": "name",
                    "name": "name",
                    "label": "Название",
                    "type": "text",
                    "initialValue": "<?= $version["name"] ?>"
                  }, {
                    "id": "platform",
                    "name": "platform",
                    "label": "Платформа",
                    "type": "text",
                    "enum": [{
                      "label": "Android",
                      "value": "android"
                    }, {
                      "label": "IPhone",
                      "value": "iphone"
                    }, {
                      "label": "Windows",
                      "value": "windows"
                    }],
                    "initialValue": "<?= $version["platform"] ?>"
                  }, {
                    "id": "version",
                    "name": "version",
                    "label": "Версия",
                    "type": "text",
                    "initialValue": "<?= $version["version"] ?>"
                  }, {
                    "id": "download_url",
                    "name": "download_url",
                    "label": "Файл",
                    "type": "file",
                    "initialValue": "<?= $version["download_url"] ?>"
                  }, {
                    "id": "is_last",
                    "name": "is_last",
                    "label": "Является последней версией",
                    "type": "checkbox",
                    "initialValue": "<?= $version["is_last"] ?>"
                  }]' style="width: 40px; padding: 6px;"><i class="bi bi-pencil"></i></button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-bs-label="<?= $version["name"] ?>" data-bs-table="version" data-bs-id="<?= $version["id"] ?>"
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