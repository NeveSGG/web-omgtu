<div style="position: absolute; display: flex; flex-wrap: wrap; gap: 8px; top: 80px; left: 30px; color: #efefef;
    transition: color 75ms linear; z-index: 100">
  <a href="/" class="custom-link" style="cursor: pointer; color: #efefef">Главная</a>
  <p>/</p>
  <p><?= $category[0]['name'] ?></p>
</div>
<section class="category" itemscope itemtype="https://schema.org/CollectionPage">

  <div class="first-container">
    <div class="sidebar">
      <ul class="sidebar-list">
        <li class="sidebar-list_element">
          <p class="sidebar-list_element-text"><?= $category[0]['name'] ?></p>
          <div class="sidebar-list_element-connect-line">
            <div class="circle first-circle"></div>
          </div>
        </li>
        <?php foreach($subcategories as $subcategory): ?>
        <li class="sidebar-list_element" onclick="window.location='/category/<?= $subcategory['slug'] ?>'">
        <a href="/category/<?= $subcategory['slug'] ?>" style="display: none"><?= $subcategory['name'] ?></a>  
        <p class="sidebar-list_element-text"><?= $subcategory['name'] ?></p>
          <div class="sidebar-list_element-connect-line">
            <div class="circle"></div>
            <div class="horizontal"></div>
            <div class="vertical"></div>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="description">
      <h1 class="description_header" itemprop="name"><?= $name ?></h1>

      <p class="description_text" itemprop="description"><?= $description ?></p>

      <div class="description_cards">

        <?php foreach($popular as $card): ?>
        <a href="/product/<?= $card['slug'] ?>" style="display: none"><?= $card['name'] ?></a>
        <div class="slider-card" onclick="window.location='/product/<?= $card['slug'] ?>'" itemscope
          itemtype="http://schema.org/SoftwareApplication">
          <div class="slider-card_background" style="background-image: url(<?= $card['background'] ?>)"></div>
          <div class="slider-card_info">
            <meta itemprop="image" content="<?= $card['main_sm'] ?>" />
            <div class="slider-card_info-image" style="background-image: url(<?= $card['main_sm'] ?>)"></div>
            <div class="slider-card_info-text">
              <strong itemprop="name"><?= $card['name'] ?></strong>
              <meta itemprop="description" content="<?= $card['description'] ?>" />
              <div class="slider-card_info-text_secondary">
                <div class="slider-card_info-text_secondary-rating">
                  <img alt="Рейтинг" src="/img/icons/starRating.svg" title="Рейтинг" width="25" height="25" />
                  <p itemprop="aggregateRating"><?= $card['rating'] ?></p>
                </div>

                <p class="slider-card_info-text_secondary-platform"><?= $platform ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div>

    </div>

  </div>

  <div class="divider">
    <div class="divider_content">

      <div class="dropdown" style="float:left;">
        <p class="dropbtn">Сортировать</p>
        <div class="dropdown-content" style="left:0">
          <a href="#" title="Сортировать по количеству скачиваний">По количеству скачиваний (по возр.)</a>
          <a href="#" title="Сортировать по количеству скачиваний">По количеству скачиваний (по уб.)</a>
          <a href="#" title="По рейтингу">По рейтингу (по возр.)</a>
          <a href="#" title="Сортировать по рейтингу">По рейтингу (по уб.)</a>
        </div>
      </div>

      <div class="dropdown" style="float: right;">
        <p class="dropbtn">Windows</p>
        <div class="dropdown-content" style="right:0">
          <a href="#" title="Windows">Windows</a>
          <a href="#" title="Android">Android</a>
          <a href="#" title="iPhone">iPhone</a>
        </div>
      </div>

    </div>
  </div>

  <div class="cards-wrapper">
    <div class="product_related">

      <div class="product_related-container">

        <?php foreach($products as $card): ?>

        <a href="/product/<?= $card['slug'] ?>" style="display: none"><?= $card['name'] ?></a>
        <div class="product_related-card" onclick="window.location='/product/<?= $card['slug'] ?>'" itemscope
          itemtype="http://schema.org/SoftwareApplication">
          <div class="product_related-card_cover">
            <meta itemprop="image" content="<?= $card['main_sm'] ?>" />
            <div style="background-image: url(<?= $card['main_sm'] ?>)"></div>
          </div>

          <div class="product_related-card_info">
            <div class="product_related-card_info-rating">
              <img alt="Рейтинг" src="/img/icons/contained.png" title="Рейтинг" width="20" height="20" />
              <p itemprop="aggregateRating"><?= $card['rating'] ?></p>
            </div>

            <p class="product_related-card_info-platform"><?= $platform ?></p>
          </div>

          <p class="product_related-card_title" itemprop="name"><?= $card['name'] ?></p>
          <meta itemprop="description" content="<?= $card['description'] ?>" />
        </div>

        <?php endforeach; ?>

      </div>
    </div>
  </div>

  <div class="pagination-wrapper">
    <div class="search-pagination">
      <!--          <div class="search-pagination_numbers">
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
        <button class="pagination_button">
          <img src="/img/icons/leftArrow.svg" alt="Назад" title="Назад" />
        </button>

        <button class="pagination_button">
          <img src="/img/icons/rightArrow.svg" alt="Вперёд" title="Вперёд" />
        </button>
      </div>
    </div>
  </div>

</section>