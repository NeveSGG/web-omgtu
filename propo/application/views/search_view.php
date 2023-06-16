<section class="search-page">

    <div class="search-page_wrapper">

      <form class="search" action="/propo/search/" method="get" id="search-form">
        <input class="search__input" placeholder="название или категория..." type="text" name="query" id="searchFieldId" />
        <img title="Поиск" class="search__icon" src="/propo/icons/search.svg" alt="Поиск" />
      </form>

      <div class="search-info"> 

        <div class="search-info_actions">
          <div class="search-info_actions-results">
            <strong><?= $query ?></strong>
            <span> (Результатов: <?= $count ?><?php if ($page != 1):?>. Страница <?= strval($page) ?> <?php endif; ?>)</span>
          </div>

          <button class="search-info_actions-sort">
            Сортировать
            <img title="Сортировка" src="/propo/icons/arrowDown.svg" alt="Сортировка" />
          </button>
        </div>

        <hr class="search-info_divider" >
      </div>
      <div class="cards-mobile">
          <?php foreach ($results as $ind => $card): ?>
              
          <div class="cards-mobile_card">
              <p class="cards-mobile_card-title" style="cursor: pointer" onclick="window.location='http://localhost/propo/product/<?= $card['slug'] ?>'">
                <?= $card['name'] ?>
              </p>

              <div class="cards-mobile_card-actions">
                <div class="cards-mobile_card-actions_image" style="background-image: url(<?= $card['main_sm'] ?>); cursor: pointer" onclick="window.location='http://localhost/propo/product/<?= $card['slug'] ?>'"></div>

                <div class="cards-mobile_card-actions_secondary">
                  <div class="cards-mobile_card-actions_secondary-rating">
                    <div class="cards-mobile_card-actions_secondary-rating_star">
                      <img title="Рейтинг" src="/propo/icons/starRating.svg" alt="Рейтинг" width="25" height="25" />
                      <span><?= $card['rating'] ?></span>
                    </div>
                    <?= $platform ?>

                  </div>

                  <a class="cards-mobile_card-actions_secondary-button" data-id="<?= $card['id'] ?>" data-count="<?= $card['downloads'] ?>" data-download="<?= $card['version']['download_url'] ?>" data-filename="<?= $card['version']['name'] ?>">
                    <strong>Скачать</strong><br>
                    Для <?= $platform ?>
                  </a>
                </div>
              </div>

              <div class="cards-mobile_card-description">
                <?php if (strlen($card['description']) > 250){
                    $card['description'] = substr($card['description'], 0, 250) . '...';
                }
                ?>
                <?= $card['description'] ?>
              </div>
            </div>
          
          <hr class="cards-mobile_divider">
            
          <?php endforeach; ?>
      </div>

      <div class="cards-desktop">
        <?php foreach ($results as $ind => $card): ?>
            <div class="cards-desktop_card">

              <div class="cards-desktop_card-image" style="background-image: url(<?= $card['main_sm'] ?>); cursor: pointer" onclick="window.location='http://localhost/propo/product/<?= $card['slug'] ?>'"></div>

              <div class="cards-desktop_card-info">
                <p class="cards-desktop_card-info_title" style="cursor: pointer" onclick="window.location='http://localhost/propo/product/<?= $card['slug'] ?>'">
                  <?= $card['name'] ?>
                </p>

                <div class="cards-desktop_card-info_rating">
                  <div class="cards-desktop_card-info_rating-star">
                    <img title="Рейтинг" src="/propo/icons/starRating.svg" alt="Рейтинг" width="25" height="25" />
                    <span><?= $card['rating'] ?></span>
                  </div>
                  <?= $platform ?>
                </div>

                <div class="cards-desktop_card-info_description">
                  <?= $card['description'] ?>
                </div>
              </div>

              <a class="cards-desktop_card-button" data-id="<?= $card['id'] ?>" data-count="<?= $card['downloads'] ?>" data-download="<?= $card['version']['download_url'] ?>" data-filename="<?= $card['version']['name'] ?>">
                <div>
                  <strong>Скачать</strong><br>
                  Для <?= $platform ?>
                </div>
                <img title="Скачать" src="/propo/icons/download.svg" alt="Скачать" />
              </a>
            </div>
          <hr class="cards-desktop_divider">
        <?php endforeach; ?>
      </div>

      <div class="search-pagination">
<!--        <div class="search-pagination_numbers">
          <button class="pagination_button">
            1
          </button>

          <button class="pagination_button">
            2
          </button>

          <button class="pagination_button">
            3
          </button>

          <div class="pagination_ellipsis">...</div>

          <button class="pagination_button">
            10
          </button>
        </div>-->

        <div class="search-pagination_arrows">
          <button class="pagination_button" onclick="window.location='http://localhost/propo/search/?query=<?= $query ?>&page=<?= $page-1 ?>'">
            <img title="Назад" src="/propo/icons/leftArrow.svg" alt="Назад" />
          </button>

          <button class="pagination_button" onclick="window.location='http://localhost/propo/search/?query=<?= $query ?>&page=<?= $page+1 ?>'">
            <img title="Вперёд" src="/propo/icons/rightArrow.svg" alt="Вперёд" />
          </button>
        </div>
      </div>

    </div>

  </section>

<script>
     document.addEventListener('DOMContentLoaded', () => {
        const downloadElements = document.querySelectorAll("[data-download]");

        downloadElements.forEach(downloadElement => {
          downloadElement.addEventListener("click", (event) => {
            
            event.preventDefault();
    
            const fileUrl = downloadElement.dataset.download;
            const filename = downloadElement.dataset.filename;
            const id = downloadElement.dataset.id;
            const count = downloadElement.dataset.count;
    
            const downloadLink = document.createElement("a");
            downloadLink.href = fileUrl;
            downloadLink.download = filename;
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
          });
        });
        
        const input = document.getElementById('searchFieldId');
        const form = document.getElementById('search-form');

        const onValueChange = (e) => {
          input.value = e.target.value;
        }

        const onEnterClick = () => {
            form.submit();
        }

        const keyPressHandler = (e) => {
          if (e.key === 'Enter') {
            e.preventDefault();
            onEnterClick()
          }
        }

        input.addEventListener("input", onValueChange);
        input.addEventListener("keypress", keyPressHandler);
    });
</script>