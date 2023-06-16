<section class="product">
      <div class="product_header">
        <div class="product_header-image" style="background-image: url(<?= $main_image ?>)"></div>

        <div class="product_header-description">
          <p class="product_header-description_title"><?= $name ?></p>
          <div class="product_header-description_rating">
            <img title="Рейтинг" alt="Рейтинг" src="/propo/icons/contained.png" width="35" height="35" class="contained"></img>
            <img title="Рейтинг" alt="Рейтинг" src="/propo/icons/contained.png" width="35" height="35" class="contained"></img>
            <img title="Рейтинг" alt="Рейтинг" src="/propo/icons/contained.png" width="35" height="35" class="contained"></img>
            <img title="Рейтинг" alt="Рейтинг" src="/propo/icons/contained.png" width="35" height="35" class="contained"></img>
            <img title="Рейтинг" alt="Рейтинг" src="/propo/icons/outlined.png" width="35" height="35" class="outlined"></img>
          </div>
          <p class="product_header-description_version"><?= $last_version['version'] ?></p>
        </div>

        <button class="product_header-download" data-id="<?= $id ?>" data-count="<?= $downloads ?>" data-download="<?= $last_version['download_url'] ?>" data-filename="<?= $last_version['name'] ?>">
          <div class="product_header-download_left">
            <p class="strong">Скачать</p>
            <p>Для <?= $platform ?></p>
          </div>

          <div class="product_header-download_right">
            <img title="Скачать" alt="Скачать" src="/propo/icons/download.svg" />
          </div>
        </button>
      </div>

      <div id="gallery_images_container" class="product_slider" data-images="<?= htmlspecialchars(json_encode($gallery)); ?>">
        <div class="swiper mySwiper-product-description">
          <div class="swiper-wrapper" id="swiper-product-description-container-id">
              <?php
                foreach ($gallery as $ind => $image):
              ?>
                <div class="swiper-slide">
                    <div class="slider-card">
                      <div class="slider-card_background" style="background-image: url(<?= $image ?>)" data-fancybox-ready="<?= $ind ?>"></div> 
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
            <p class="product_description-container-text"><?= $description ?></p>
        </div>
        
        <button class="product_description-show-more" id="description-button">Показать полностью</button>
      </div>

      <div class="product_info-cards">
        <div class="product_info-cards_item">
          <strong>Лицензия</strong>
          <p><?= $license_type ?></p>
        </div>
        <div class="product_info-cards_item">
          <strong>Версия</strong>
          <p><?= $last_version['version'] ?></p>
        </div>
        <div class="product_info-cards_item">
          <strong>Язык</strong>
          <p><?= $language ?></p>
        </div>
        <div class="product_info-cards_item">
          <strong>Разработчик</strong>
          <p><?= $developers ?></p>
        </div>
        <div class="product_info-cards_item">
          <strong>Скачиваний</strong>
          <p><?= $downloads ?></p>
        </div>
      </div>

      <div class="product_platforms">
        <p class="product_platforms-title">
          Доступно на других устройствах
        </p>
        
        <div class="product_platforms-cards">
            <?php foreach($other_platforms as $version): ?>
                <div class="product_platforms-cards_item"  data-id="<?= $id ?>" data-count="<?= $downloads ?>" data-download="<?= $version['download_url'] ?>" data-filename="<?= $version['name'] ?>">
                    <div class="product_platforms-cards_item-icon_block">
                        <?php if ($version['platform'] == 'android'): ?>
                            <img title="Андроид" src="/propo/icons/android-sm.png" alt="Android"/>
                        <?php elseif ($version['platform'] == 'iphone'): ?>
                            <img title="Айфон" src="/propo/icons/apple-sm.png" alt="iPhone"/>
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
        <p class="product_versions-title">
          Прошлые версии
        </p>

        <div class="product_versions-container">
          <?php
            foreach ($old_versions as $version):
          ?>
            <div class="product_versions-container_card" data-id="<?= $id ?>" data-count="<?= $downloads ?>" data-download="<?= $version['download_url'] ?>" data-filename="<?= $version['name'] ?>">
                  <div class="product_versions-container_card-left">
                    <p class="product-title"><?= $name ?></p>
                    <p class="product-version"><?= $version['version'] ?></p>
                  </div>

                  <img title="Скачать" src="/propo/icons/download.svg" alt="Скчать версию <?= $version['version'] ?>" />
                </div>
          <?php
            endforeach;
          ?>
        </div>
      </div>

      <div class="product_from-developer">
        <strong class="product_from-developer-title">От разработчика</strong>
        <div class="popular-wrapper_container-swiper-wrapper">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper" id="swiper-container-id">
              <?php
                    foreach ($from_developer as $card):
                ?>
                    <div class="swiper-slide">
                        <div class="slider-card" onclick="window.location='http://localhost/propo/product/<?= $card['slug'] ?>'">
                              <div class="slider-card_background" style="background-image: url(<?= $card['background'] ?>)"></div>
                              <div class="slider-card_info">
                                <div class="slider-card_info-image" style="background-image: url(<?= $card['main_sm'] ?>)"></div>
                                <div class="slider-card_info-text">
                                  <strong><?= $card['name'] ?></strong>
                                  <div class="slider-card_info-text_secondary">
                                    <div class="slider-card_info-text_secondary-rating">
                                      <img title="Рейтинг" alt="Рейтинг" src="/propo/icons/starRating.svg" width="25" height="25" />
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
        <p class="product_related-title">
          Похожее
        </p>

        <div class="product_related-container">
          <?php foreach($similar as $card): ?>
                <div class="product_related-card" onclick="window.location='http://localhost/propo/product/<?= $card['slug'] ?>'">
                    <div class="product_related-card_cover">
                      <div style="background-image: url(<?= $card['main_sm'] ?>)"></div>
                    </div>

                    <div class="product_related-card_info">
                      <div class="product_related-card_info-rating">
                        <img title="Рейтинг" alt="Рейтинг" src="/propo/icons/contained.png" width="20" height="20" />
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

<?php
    
    
    
?>