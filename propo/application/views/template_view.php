<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= $seo_title ?? "ProPO" ?></title>
        <meta name="description" content='<?= $seo_description ?? "ProPO" ?>'/>
        <link rel="stylesheet" href="/propo/css/style.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
        <!-- favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/propo/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/propo/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/propo/favicon/favicon-16x16.png">
        <link rel="manifest" href="/propo/favicon/site.webmanifest">
        <link rel="mask-icon" href="/propo/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="/propo/favicon/favicon.ico">
        <meta name="apple-mobile-web-app-title" content="ProPO">
        <meta name="application-name" content="ProPO">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="/propo/favicon/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
        <!-- /favicon -->
        
        <script src="/propo/js/fslightbox.js"></script>
        <script src="/propo/js/script.js"></script>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        
        <section id="root"><section class="content">
            <section class="header-wrapper">
                <header class="header" id="header">

                    <div class="header__nav">
                      <a class="header__nav__button" href="/propo" title="Логотип ProPO">
                        <img loading="lazy" src="/propo/img/logo.svg" alt="ProPO - Логотип" title="Логотип" width="33" height="33" />
                      </a>
<!--                      <a class="header__nav__button dropdown-trigger" href="#">
                        <img loading="lazy" src="/propo/img/androidButton.svg" alt="Android" width="33" height="33" />
                        <img loading="lazy" src="/propo/img/openArrow.svg" alt="Открыть" width="10" height="4.21" />
                      </a>
                      <ul class="header__nav__dropdown-menu">
                        <li class="header__nav__dropdown-menu_item">
                          <a href="#">Windows 10/11</a>
                        </li>
                        <li class="header__nav__dropdown-menu_item">
                          <a href="#">Android</a>
                        </li>
                        <li class="header__nav__dropdown-menu_item">
                          <a href="#">iPhone</a>
                        </li>
                      </ul>-->
                    </div>

                    <div class="header__links">
                      <a href="/propo/main" title="На главную" class="header__links__link custom-link">
                        <span class="header__links__link__text">
                          Главная
                        </span>
                      </a>
                    </div>

                    <div class="header__controls">
                      <a class="header__nav__button" href="/" title="Логотип">
                        <img loading="lazy" title="Логотип" src="/propo/img/userIcon.svg" alt="proPO - Логотип" width="33" height="33" />
                      </a>
<!--                      <a class="header__nav__button" href="#">
                        <img loading="lazy" src="/propo/img/settingsIcon.svg" alt="Android" width="33" height="33" />
                      </a>-->
                    </div>

                    <div class="hamburger-menu">
                      <input id="hamburger-menu__toggle" title="burger" type="checkbox"/>
                      <label class="hamburger-menu__btn" for="hamburger-menu__toggle" id="hamburger-button">
                        <span></span>
                      </label>

                      <ul class="hamburger-menu__box">
<!--                        <li><a class="hamburger-menu__box__item custom-link" href="#">
                          <img loading="lazy" src="/propo/img/user.svg" alt="Личный кабинет" />
                          Личный кабинет
                        </a></li>-->
                        <li><a class="hamburger-menu__box__item custom-link" href="/propo/main" title="На главную">
                          <img loading="lazy" src="/propo/img/home.svg" alt="На главную" title="На главную"/>
                          На главную
                        </a></li>
<!--                        <li><a class="hamburger-menu__box__item custom-link" href="#">
                          <img loading="lazy" src="/propo/img/search.svg" alt="Поиск" />
                          Поиск
                        </a></li>
                        <li><a class="hamburger-menu__box__item custom-link" href="#">
                          <img loading="lazy" src="/propo/img/categories.svg" alt="Категории" />
                          Категории
                        </a></li>
                        <li><a class="hamburger-menu__box__item custom-link" href="#">
                          <img loading="lazy" src="/propo/img/contacts.svg" alt="Контакты" />
                          Контакты
                        </a></li>-->
                      </ul>
                    </div>
                  </header>
            </section>
            
            <?php include 'application/views/'.$content_view; ?>
            
            <div class="cookie-notification" id="cookie-notification_1xn9341n193">
                <p>Мы используем куки, чтобы оставить хорошее впечатление о нашем сайте.</p>
                <button id="cookie-notification_button-b84b85hgc2g">ОК</button>
            </div>
            
        </section>
        
        <footer class="footer">
            <div class="footer-wrapper">

              <div class="footer-block">
                <p class="footer-block_title">Сведения о нас</p>
                <div class="footer-block_secondary">
                  <a href="#" class="footer-block_secondary-link custom-link" title="Сведения о сайте">Сведения о сайте</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Справка и поддержка">Справка и поддержка</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Вакансии">Вакансии</a>
                </div>
              </div>

              <div class="footer-block">
                <p class="footer-block_title">B2B</p>
                <div class="footer-block_secondary">
                  <a href="#" class="footer-block_secondary-link custom-link" title="Монетизация">Монетизация</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Загрузка вашего PO">Отправка вашего ПО и
      управление им</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Политика">Политика ПО</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Реклама">Возможности для
      рекламы</a>
                </div>
              </div>

              <div class="footer-block">
                <p class="footer-block_title">Юридическая
      информация</p>
                <div class="footer-block_secondary">
                  <a href="#" class="footer-block_secondary-link custom-link" title="Юридическая информация">Юридическая информация</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Условия использования">Условия использования</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Политика конфидециальности">Политика конфидециальности</a>
                  <a href="#" class="footer-block_secondary-link custom-link" title="Политика в отношении файлов cookie">Политика в отношении
      файлов cookie</a>
                </div>
              </div>

              <div class="footer-block">
                <p class="footer-block_title">Социальные сети</p>
                <div class="footer-block_socials">
                  <a rel="nofollow" target="_blank" href="#" title="Telegram">
                    <img src="/propo/icons/telegram.svg" alt="Telegram" title="Github" width="32" height="32" />
                  </a>
                  <a rel="nofollow" target="_blank" href="#" title="Github">
                    <img src="/propo/icons/github.svg" alt="Github" title="Github" width="32" height="32" />
                  </a>
                  <a rel="nofollow" target="_blank" href="#" title="Discord">
                    <img src="/propo/icons/discord.svg" alt="Discord" title="Github" width="32" height="32" />
                  </a>
                  <a rel="nofollow" target="_blank" href="#" title="VK">
                    <img src="/propo/icons/vk.svg" title="Вконтакте" alt="Vk" width="32" height="32" />
                  </a>
                </div>
              </div>

              <div class="footer-block-last">
                <div class="footer-block-last_left">
                  <span>Пишите нам:<br>
                    <a href="support@propo.com" title="Почта" class="custom-link">support@propo.com</a>
                  </span>
                </div>

                <div class="footer-block-last_right">
                  <span>© 2023 - ProPO®</span>
                </div>
              </div>

            </div>
          </footer>
            
        <div class="hero-background-circle"></div>
        <div class="hero-background-figure"></div>
        <div class="popular-background-circle"></div>
        <div class="popular-background-circle2"></div>
        <div class="categories-background-circle"></div>
        <div class="categories-background-circle2"></div>
        </script>
    </body>
</html>
