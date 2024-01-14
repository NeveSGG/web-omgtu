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

        $sql = "SELECT * FROM media LIMIT $perpage OFFSET $offset";
        $result = $pdo->query($sql);

        $media = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $media[] = $row;
        }

        $countSql = "SELECT COUNT(*) FROM media";
        $countResult = $pdo->query($countSql);
        $totalCount = $countResult->fetchColumn();

        $last_page = ceil($totalCount / $perpage);
      ?>
      <div class="container">
        <div
          style="padding-top: 36px; width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap">
          <h2>Медиа</h2>
          <button type="button" class="btn btn-primary" data-bs-json-data='[{
                    "id": "product_id",
                    "name": "product_id",
                    "label": "id программы",
                    "type": "text"
                  }, {
                    "id": "type",
                    "name": "type",
                    "label": "Тип изображения",
                    "type": "text",
                    "enum": [{
                      "label": "Главное - большое",
                      "value": "main_lg"
                    }, {
                      "label": "Главное - малое",
                      "value": "main_sm"
                    }, {
                      "label": "Галлерея",
                      "value": "gallery"
                    }]
                  }, {
                    "id": "url",
                    "name": "url",
                    "label": "Ссылка на изображние",
                    "type": "file"
                  }]' data-bs-toggle="modal" data-bs-target="#addModal" data-bs-table-name="media">Загрузить
            изображение</button>
        </div>

        <div class="mt-4">
          <div class="row text-center border">
            <div class="col themed-grid-col col-1 p-3 border-bottom"><b>id</b></div>
            <div class="col themed-grid-col col-2 p-3 border-bottom"><b>id программы</b></div>
            <div class="col themed-grid-col col-2 p-3 border-bottom"><b>Тип изображения</b></div>
            <div class="col themed-grid-col col-6 p-3 border-bottom"><b>Изображение</b></div>
          </div>

          <?php foreach ($media as $media_item): ?>
          <div class="row row-cols-2 gx-4 text-center position-relative">
            <div class="col themed-grid-col col-1 border p-2 text-truncate" data-name="id"><?= $media_item["id"] ?>
            </div>
            <div class="col themed-grid-col col-2 border p-2 text-truncate" data-name="product_id">
              <?= $media_item["product_id"] ?></div>
            <div class="col themed-grid-col col-2 border p-2 text-truncate" data-name="type"><?= $media_item["type"] ?>
            </div>
            <div class="col themed-grid-col col-7 border p-2 text-truncate" data-name="url"><img
                src="https://pro-po.store<?= $media_item["url"] ?>" style="width: 100%; max-width: 250px" /></div>
            <div class="row-buttons"
              style="width: min-content; padding: 0; display: none; gap: 8px; position: absolute; top: 2px; right: 0">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                data-bs-table-name="media" data-bs-json-data='[{
                    "id": "id",
                    "name": "id",
                    "label": "id",
                    "type": "text",
                    "initialValue": "<?= $media_item["id"] ?>"
                  }, {
                    "id": "product_id",
                    "name": "product_id",
                    "label": "id программы",
                    "type": "text",
                    "initialValue": "<?= $media_item["product_id"] ?>"
                  }, {
                    "id": "type",
                    "name": "type",
                    "label": "Тип изображения",
                    "type": "text",
                    "enum": [{
                      "label": "Главное - большое",
                      "value": "main_lg"
                    }, {
                      "label": "Главное - малое",
                      "value": "main_sm"
                    }, {
                      "label": "Галлерея",
                      "value": "gallery"
                    }],
                    "initialValue": "<?= $media_item["type"] ?>"
                  }, {
                    "id": "url",
                    "name": "url",
                    "label": "Изображение",
                    "type": "file",
                    "initialValue": "<?= $media_item["url"] ?>"
                  }]' style="width: 40px; padding: 6px;"><i class="bi bi-pencil"></i></button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-bs-label="<?= $media_item["url"] ?>" data-bs-table="media" data-bs-id="<?= $media_item["id"] ?>"
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