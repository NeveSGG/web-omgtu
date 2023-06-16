const cookieNotificationScript = () => {
  const wrapper = document.getElementById('cookie-notification_1xn9341n193');
  const button = document.getElementById('cookie-notification_button-b84b85hgc2g');

  const savedState = localStorage.getItem('isCookieNotificationShown');

  if (!savedState) {
    setTimeout(() => {
      wrapper.classList.add('cookie-notifications-show');
      localStorage.setItem('isCookieNotificationShown', 'true');
    }, 2000);
  }

  button.onclick = () => {
    wrapper.classList.remove('cookie-notifications-show');
  };
};

const headerScript = () => {
    const header = document.getElementById('header');
    const hamburgerButton = document.getElementById('hamburger-button');

    let lastScroll = 0;

    function debounce(func, delay) {
      let timeoutId;
      return function() {
        const context = this;
        // rome-ignore lint/style/noArguments: <explanation>
        const  args = arguments;
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(context, args), delay);
      };
    }

    window.addEventListener('scroll', debounce(function() {
      const currentScroll = window.scrollY;

      if (currentScroll > lastScroll) {
        header.classList.add('header-hidden');
      } else {
        header.classList.remove('header-hidden');
      }

      lastScroll = currentScroll;
    }, 10));

    hamburgerButton.addEventListener('click', () => {
      document.body.style.overflow = document.body.style.overflow === 'hidden' ? 'unset' : 'hidden';
    });
};

document.addEventListener('DOMContentLoaded', () => {
    headerScript();
    cookieNotificationScript();
});