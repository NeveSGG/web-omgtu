<div style="position: absolute; display: flex; flex-wrap: wrap; gap: 8px; top: 80px; left: 30px; color: #efefef;
    transition: color 75ms linear; z-index: 100">
  <a href="/" class="custom-link" style="cursor: pointer; color: #efefef">Главная</a>
  <p>/</p>
  <a href="/category/<?= $subcategory['slug'] ?>" class="custom-link"
    style="cursor: pointer; color: #efefef"><?= $subcategory['name'] ?></a>
  <p>/</p>
  <p><?= $name ?></p>
</div>
<section class="product" itemscope itemtype="http://schema.org/SoftwareApplication">
  <div class="product_header">
    <meta itemprop="image" content="<?= $main_image ?>" />
    <div class="product_header-image" style="background-image: url(<?= $main_image ?>)"></div>

    <div class="product_header-description">
      <h1 class="product_header-description_title" itemprop="name"><?= $name ?></h1>
      <meta itemprop="aggregateRating" content="<?= $rating ?>" />
      <div class="product_header-description_rating">
        <img title="Рейтинг" alt="Рейтинг" src="/img/icons/contained.png" width="35" height="35"
          class="contained" />
        <img title="Рейтинг" alt="Рейтинг" src="/img/icons/contained.png" width="35" height="35"
          class="contained" />
        <img title="Рейтинг" alt="Рейтинг" src="/img/icons/contained.png" width="35" height="35"
          class="contained" />
        <img title="Рейтинг" alt="Рейтинг" src="/img/icons/contained.png" width="35" height="35"
          class="contained" />
        <img title="Рейтинг" alt="Рейтинг" src="/img/icons/outlined.png" width="35" height="35" class="outlined" />
      </div>
      <p class="product_header-description_version"><?= $last_version['version'] ?></p>
    </div>

    <a href="<?= $last_version['download_url'] ?>" style="display: none"
      itemprop="downloadUrl"><?= $last_version['download_url'] ?></a>

    <button class="product_header-download" data-id="<?= $id ?>" data-count="<?= $downloads ?>"
      data-download="<?= $last_version['download_url'] ?>" data-filename="<?= $last_version['name'] ?>">
      <span class="product_header-download_left">
        <span class="strong">Скачать</span>
        <span>Для <?= $platform ?></span>
      </span>

      <span class="product_header-download_right">
        <img title="Скачать" alt="Скачать" src="/img/icons/download.svg" width="30" height="30"/>
      </span>
    </button>
  </div>

  <div id="gallery_images_container" class="product_slider"
    data-images="<?= htmlspecialchars(json_encode($gallery)); ?>">
    <div class="swiper mySwiper-product-description">
      <div class="swiper-wrapper" id="swiper-product-description-container-id">
        <?php
                foreach ($gallery as $ind => $image):
              ?>
        <div class="swiper-slide">
          <div class="slider-card">
            <div class="slider-card_background" style="background-image: url(<?= $image ?>)"
              data-fancybox-ready="<?= $ind ?>"></div>
          </div>
        </div>
        <?php
                endforeach;
              ?>
      </div>
      <div class="swiper-product-description-pagination"></div>
    </div>
  </div>

  <div class="product_description">
    <div class="product_description-container" id="description-container">
      <p class="product_description-container-text" itemprop="description"><?= $description ?></p>
    </div>

    <button class="product_description-show-more" id="description-button">Показать полностью</button>
  </div>

  <div class="product_info-cards">
    <div class="product_info-cards_item">
      <strong>Лицензия</strong>
      <p itemprop="usageInfo"><?= $license_type ?></p>
    </div>
    <div class="product_info-cards_item">
      <strong>Версия</strong>
      <p itemprop="softwareVersion"><?= $last_version['version'] ?></p>
    </div>
    <div class="product_info-cards_item">
      <strong>Язык</strong>
      <p itemprop="inLanguage"><?= $language ?></p>
    </div>
    <div class="product_info-cards_item">
      <strong>Разработчик</strong>
      <p itemprop="creator"><?= $developers ?></p>
    </div>
    <div class="product_info-cards_item">
      <strong>Скачиваний</strong>
      <p><?= $downloads ?></p>
    </div>
  </div>

  <div class="product_platforms">
    <h2 class="product_platforms-title">
      Доступно на других устройствах
    </h2>

    <div class="product_platforms-cards">
      <?php foreach($other_platforms as $version): ?>
      <div class="product_platforms-cards_item" data-id="<?= $id ?>" data-count="<?= $downloads ?>"
        data-download="<?= $version['download_url'] ?>" data-filename="<?= $version['name'] ?>">
        <div class="product_platforms-cards_item-icon_block">
          <?php if ($version['platform'] == 'android'): ?>
          <img title="Андроид" src="/img/icons/android-sm.png" alt="Android" />
          <?php elseif ($version['platform'] == 'iphone'): ?>
          <img title="Айфон" src="/img/icons/apple-sm.png" alt="iPhone" />
          <?php endif; ?>
        </div>

        <p class="product_platforms-cards_item-text_block">
          <?= $name ?> на <?= ucfirst($version['platform']) ?>
        </p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="product_versions">
    <h2 class="product_versions-title">
      Прошлые версии
    </h2>

    <div class="product_versions-container">
      <?php
            foreach ($old_versions as $version):
          ?>
      <div class="product_versions-container_card" data-id="<?= $id ?>" data-count="<?= $downloads ?>"
        data-download="<?= $version['download_url'] ?>" data-filename="<?= $version['name'] ?>">
        <div class="product_versions-container_card-left">
          <p class="product-title"><?= $name ?></p>
          <p class="product-version"><?= $version['version'] ?></p>
        </div>

        <img title="Скачать" src="/img/icons/download.svg" alt="Скчать версию <?= $version['version'] ?>" width="30" height="30"/>
      </div>
      <?php
            endforeach;
          ?>
    </div>
  </div>

  <div class="product_from-developer">
    <h2 class="product_from-developer-title">От разработчика</h2>
    <div class="popular-wrapper_container-swiper-wrapper">
      <div class="swiper mySwiper">
        <div class="swiper-wrapper" id="swiper-container-id">
          <?php
                    foreach ($from_developer as $card):
                ?>
          <div class="swiper-slide">
            <a href="/product/<?= $card['slug'] ?>" style="display: none"><?= $card['name'] ?></a>
            <div class="slider-card" onclick="window.location='/product/<?= $card['slug'] ?>'">
              <div class="slider-card_background" style="background-image: url(<?= $card['background'] ?>)"></div>
              <div class="slider-card_info">
                <div class="slider-card_info-image" style="background-image: url(<?= $card['main_sm'] ?>)"></div>
                <div class="slider-card_info-text">
                  <strong><?= $card['name'] ?></strong>
                  <div class="slider-card_info-text_secondary">
                    <div class="slider-card_info-text_secondary-rating">
                      <img title="Рейтинг" alt="Рейтинг" src="/img/icons/starRating.svg" width="25" height="25" />
                      <p><?= $card['rating'] ?></p>
                    </div>

                    <p class="slider-card_info-text_secondary-platform"><?= $platform ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
                    endforeach;
                ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="autoplay-progress">
          <svg viewBox="0 0 48 48">
            <circle cx="24" cy="24" r="20"></circle>
          </svg>
          <span></span>
        </div>
      </div>
    </div>
  </div>

  <div class="product_related">
    <h2 class="product_related-title">
      Похожее
    </h2>

    <div class="product_related-container">
      <?php foreach($similar as $card): ?>
      <a href="/product/<?= $card['slug'] ?>" style="display: none"><?= $card['name'] ?></a>
      <div class="product_related-card" onclick="window.location='/product/<?= $card['slug'] ?>'">
        <div class="product_related-card_cover">
          <div style="background-image: url(<?= $card['main_sm'] ?>)"></div>
        </div>

        <div class="product_related-card_info">
          <div class="product_related-card_info-rating">
            <img title="Рейтинг" alt="Рейтинг" src="/img/icons/contained.png" width="20" height="20" />
            <p><?= $card['rating'] ?></p>
          </div>

          <p class="product_related-card_info-platform"><?= $platform ?></p>
        </div>

        <p class="product_related-card_title"><?= $card['name'] ?></p>
      </div>
      <?php endforeach; ?>
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

  const images = JSON.parse(document.getElementById('gallery_images_container').dataset.images);

  const lightbox = new FsLightbox();
  lightbox.props.sources = images;

  new Swiper(".mySwiper-product-description", {
    lazy: true,
    spaceBetween: 30,
    grabCursor: true,
    slidesPerView: "auto",
    loop: true,
    pagination: {
      el: ".swiper-product-description-pagination",
      clickable: true
    },
  });

  const progressCircle = document.querySelector(".autoplay-progress svg");
  const progressContent = document.querySelector(".autoplay-progress span");

  new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    loop: true,
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: false,
    },
    autoplay: {
      delay: 4000,
      disableOnInteraction: false
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true
    },
    on: {
      autoplayTimeLeft(s, time, progress) {
        progressCircle.style.setProperty("--progress", 1 - progress);
        progressContent.textContent = `${Math.ceil(time / 1000)}s`;
      }
    }
  });

  const descrContainer = document.getElementById('description-container');
  const descrButton = document.getElementById('description-button');

  descrButton.addEventListener('click', () => {
    descrContainer.style = "height: fit-content";
    descrButton.style = "display: none";
  })

  const sliderItems = document.querySelectorAll('div[data-fancybox-ready]');
  sliderItems.forEach((el, key) => {
    const ind = parseInt(el.getAttribute('data-fancybox-ready') || '0');
    el.addEventListener('click', () => {
      lightbox.open(ind);
    })
  })

})
</script>