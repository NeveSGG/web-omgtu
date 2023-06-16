<section class="hero-wrapper">
    <div class="hero-wrapper__container">
        <div class="hero-wrapper__container-actions">
            <h1 class="hero-title">Любимые программы в одном месте</h1>

            <form class="hero-search" action="/propo/search/" method="get" id="search-form">
                <input class="hero-search__input" placeholder="название или категория..." type="text" name="query" id="searchFieldId" />

                <img class="hero-search__icon" src="/propo/icons/search.svg" alt="Поиск" title="Поиск"/>
                <button class="hero-search__button" type="submit">
                  <img src="/propo/icons/searchIconWhite.png" alt="Поиск" title="Поиск"/>
                </button>
            </form>

            <div class="hero-secondary-container">
                <img src="/propo/icons/textLine.svg" alt="описание ProPO" title="Описание"/>
                <p class="hero-secondary">У нас более чем 30 000 самых востребованных программ, а так же популярные бесплатные игры</p>
            </div>

        </div>
        <img class="hero-animation" src="/propo/img/laptopAnim.gif" alt="Анимация" title="Анимация"/>
    </div>
</section>

<section class="categories-links-wrapper">
    <div class="categories-links_container">
      <h2 class="categories-links_container-title">Категории</h2>

      <div class="table-wrapper" id="table-wrapper">
        <table class="categories-links_table" id="table">
          <tbody>
            <?php foreach($categories as $category ):?>
                  <tr class="categories-links_table-row">
                    <?php foreach($category as $sub_category ):?>
                        <td class="categories-links_table-row-cell">
                          <a class="custom-link" title="<?= $sub_category['name'] ?>" href="/propo/category/<?=$sub_category['slug']?>"><span><?= $sub_category['name'] ?></span></a>
                        </td>
                    <?php endforeach; ?>
                  </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="fade" id="table-fade"></div>
      </div>

      <div class="show-more-button-wrapper" >
        <button id="show-more-button" style="cursor: pointer">
          Больше
          <img alt="Показать больше" title="Показать больше" src="/propo/icons/downArrow.svg" width="29" height="29" />
        </button>
      </div>
    </div>
  </section>

<section class="popular-wrapper">
    <div class="popular-wrapper_container">
        <h2 class="popular-wrapper_container-title">Популярное</h2>
        <div class="popular-wrapper_container-swiper-wrapper">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper" id="swiper-container-id">\
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
                                          <img alt="Рейтинг" src="/propo/icons/starRating.svg" width="25" height="25" title="Рейтинг" />
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
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
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
        
        const fade = document.getElementById('table-fade');
        const wrapper = document.getElementById('table-wrapper');
        const table = document.getElementById('table');
        const button = document.getElementById('show-more-button');

        button.onclick = () => {
          if (wrapper.clientHeight < table.clientHeight) {
            wrapper.style.height = `${table.clientHeight}px`;
            button.style.display = 'none';
            fade.style.display = 'none';
          }
        }
  })
</script>