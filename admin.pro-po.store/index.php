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
          $sql = "SELECT * FROM category WHERE name LIKE '%$query%' LIMIT $perpage OFFSET $offset";
        } else {
          $sql = "SELECT * FROM category LIMIT $perpage OFFSET $offset";
        }
        $result = $pdo->query($sql);

        $categories = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row;
        }

        $countSql = isset($query) ? "SELECT COUNT(*) FROM category WHERE name LIKE '%$query%'" : "SELECT COUNT(*) FROM category";
        $countResult = $pdo->query($countSql);
        $totalCount = $countResult->fetchColumn();

        $last_page = ceil($totalCount / $perpage);
      ?>
      <div class="container">
        <div
          style="padding-top: 36px; width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap">
          <h2>Категории<?= isset($query) ? ' - результаты поиска' : '' ?></h2>
          <button type="button" class="btn btn-primary" data-bs-json-data='[{
                    "id": "name",
                    "name": "name",
                    "label": "Название",
                    "type": "text"
                  }]' data-bs-toggle="modal" data-bs-target="#addModal" data-bs-table-name="category">Добавить
            категорию</button>
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
            <div class="col themed-grid-col col-11 p-3 border-bottom"><b>Название</b></div>
          </div>

          <?php foreach ($categories as $category): ?>
          <div class="row row-cols-2 gx-4 text-center position-relative">
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="id"><?= $category["id"] ?></div>
            <div class="col themed-grid-col col-11 border p-2 text-truncate" data-name="name"><?= $category["name"] ?>
            </div>
            <div class="row-buttons"
              style="width: min-content; padding: 0; display: none; gap: 8px; position: absolute; top: 2px; right: 0">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                data-bs-table-name="category" data-bs-json-data='[{
                    "id": "id",
                    "name": "id",
                    "label": "id",
                    "type": "text",
                    "initialValue": "<?= $category["id"] ?>"
                  }, {
                    "id": "name",
                    "name": "name",
                    "label": "Название",
                    "type": "text",
                    "initialValue": "<?= $category["name"] ?>"
                  }]' style="width: 40px; padding: 6px;"><i class="bi bi-pencil"></i></button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-bs-label="<?= $category["name"] ?>" data-bs-table="category" data-bs-id="<?= $category["id"] ?>"
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