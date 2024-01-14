<?php
  include('/var/www/admin.pro-po.store/components/modals.php');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script>
$(document).ready(() => {
  $('div.row').hover(
    function() {
      $(this).find('.row-buttons').css('display', 'flex');
    },
    function() {
      $(this).find('.row-buttons').css('display', 'none');
    }
  );

  const urlParams = new URLSearchParams(window.location.search);
  const page = +(urlParams.get('page') ?? '1');

  var pag = $('#pagination').simplePaginator({
    totalPages: parseInt($('#pagination').data('lastPage')),

    maxButtonsVisible: 4,

    currentPage: parseInt($('#pagination').data('currentPage')),

    nextLabel: 'Далее',
    prevLabel: 'Назад',
    firstLabel: '1',
    lastLabel: $('#pagination').data('lastPage'),

    clickCurrentPage: false,

    pageChange: function(page) {
      urlParams.set('page', page);
      window.location.search = urlParams.toString();
    }
  });

  const searchButton = document.getElementById('search_button_id');
  const searchField = document.getElementById('search_field_id');

  if (searchButton && searchField) {
    searchField.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
        searchButton.click();
      }
    });

    searchButton.onclick = () => {
      if (searchField.value) {
        urlParams.set('q', searchField.value);
        window.location.search = urlParams.toString();
      } else {
        urlParams.delete('q');
        urlParams.set('page', 1);
        window.location.search = urlParams.toString();
      }

    }
  }
});
</script>