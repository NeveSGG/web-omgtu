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
          $sql = "SELECT * FROM subcategory WHERE name LIKE '%$query%' LIMIT $perpage OFFSET $offset";
        } else {
          $sql = "SELECT * FROM subcategory LIMIT $perpage OFFSET $offset";
        }
        $result = $pdo->query($sql);

        $subcategories = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $subcategories[] = $row;
        }

        $countSql = isset($query) ? "SELECT COUNT(*) FROM subcategory WHERE name LIKE '%$query%'" : "SELECT COUNT(*) FROM subcategory";
        
        $countResult = $pdo->query($countSql);
        $totalCount = $countResult->fetchColumn();

        $last_page = ceil($totalCount / $perpage);
      ?>
      <div class="container">
        <div
          style="padding-top: 36px; width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap">
          <h2>Подкатегории<?= isset($query) ? ' - результаты поиска' : '' ?></h2>
          <button type="button" class="btn btn-primary" data-bs-json-data='[{
                    "id": "name",
                    "name": "name",
                    "type": "text",
                    "label": "Название"
                  }, {
                    "id": "slug",
                    "name": "slug",
                    "type": "text",
                    "label": "Человеко-понятный URL"
                  }, {
                    "id": "description",
                    "name": "description",
                    "type": "text",
                    "label": "Описание"
                  }, {
                    "id": "category_id",
                    "name": "category_id",
                    "type": "number",
                    "label": "id Категории"
                  }]' data-bs-toggle="modal" data-bs-target="#addModal" data-bs-table-name="subcategory">Добавить
            подкатегорию</button>
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
            <div class="col themed-grid-col col-2 p-3 border-bottom"><b>Название</b></div>
            <div class="col themed-grid-col col-2 p-3 border-bottom"><b>ЧПУ</b></div>
            <div class="col themed-grid-col col-6 p-3 border-bottom"><b>Описание</b></div>
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>id категории</b></div>
          </div>

          <?php foreach ($subcategories as $subcategory): ?>
          <div class="row row-cols-2 gx-4 text-center position-relative">
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="id"><?= $subcategory["id"] ?>
            </div>
            <div class="col themed-grid-col col-2 border p-2 text-truncate" data-name="name"><?= $subcategory["name"] ?>
            </div>
            <div class="col themed-grid-col col-2 border p-2 text-truncate" data-name="slug"><?= $subcategory["slug"] ?>
            </div>
            <div class="col themed-grid-col col-6 border p-2 text-truncate" data-name="description">
              <?= $subcategory["description"] ?></div>
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="category_id">
              <?= $subcategory["category_id"] ?></div>
            <div class="row-buttons"
              style="width: min-content; padding: 0; display: none; gap: 8px; position: absolute; top: 2px; right: 0">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                data-bs-table-name="subcategory" data-bs-json-data='[{
                    "id": "id",
                    "name": "id",
                    "label": "id",
                    "type": "nubmer",
                    "initialValue": "<?= addslashes($subcategory["id"]) ?>"
                  }, {
                    "id": "name",
                    "name": "name",
                    "label": "Название",
                    "type": "text",
                    "initialValue": "<?= addslashes($subcategory["name"]) ?>"
                  }, {
                    "id": "slug",
                    "name": "slug",
                    "type": "text",
                    "label": "Человеко-понятный URL",
                    "initialValue": "<?= addslashes($subcategory["slug"]) ?>"
                  }, {
                    "id": "description",
                    "name": "description",
                    "label": "Описание",
                    "type": "text",
                    "initialValue": "<?= addslashes($subcategory["description"]) ?>"
                  }, {
                    "id": "category_id",
                    "name": "category_id",
                    "type": "number",
                    "label": "id Категории",
                    "initialValue": "<?= addslashes($subcategory["category_id"]) ?>"
                  }]' style="width: 40px; padding: 6px;"><i class="bi bi-pencil"></i></button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-bs-label="<?= $subcategory["name"] ?>" data-bs-table="subcategory"
                data-bs-id="<?= $subcategory["id"] ?>" style="width: 40px; padding: 6px;"><i
                  class="bi bi-trash"></i></button>
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