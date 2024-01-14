<script>
function tryParseJSONObject(jsonString) {
  try {
    var o = JSON.parse(jsonString);

    // Handle non-exception-throwing cases:
    // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
    // but... JSON.parse(null) returns null, and typeof null === "object", 
    // so we must check for that, too. Thankfully, null is falsey, so this suffices:
    if (o && typeof o === "object") {
      return o;
    }
  } catch (e) {}

  return false;
};

async function uploadFile(file) {
  const formData = new FormData();
  formData.append('file', file);

  const response = await fetch('/api/upload.php', {
    method: 'POST',
    body: formData
  });

  const filePath = await response.text();

  return filePath;
};
</script>

<!-- Модалка удаления -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Удалить ...</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Выдействительно хотите удалить ...?
      </div>
      <div class="modal-footer">
        <div class="spinner-border text-primary --spinner" style="display: none" role="status">
          <span class="visually-hidden">Загрузка...</span>
        </div>
        <button type="button" class="btn btn-secondary --cancel-button" data-bs-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-danger --delete-button">Удалить</button>
      </div>
    </form>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const deleteModal = document.getElementById('deleteModal');

  if (deleteModal) {
    let button = null;
    const modalForm = deleteModal.querySelector('form.modal-content');
    const modalTitle = deleteModal.querySelector('.modal-title')
    const modalBody = deleteModal.querySelector('.modal-body')
    const modalSpinner = deleteModal.querySelector('.--spinner')
    const modalCancelButton = deleteModal.querySelector('.--cancel-button')
    const modalDeleteButton = deleteModal.querySelector('.--delete-button')

    modalForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const table = button.getAttribute('data-bs-table')
      const id = button.getAttribute('data-bs-id')

      modalCancelButton.disabled = true;
      modalDeleteButton.disabled = true;
      modalSpinner.style.display = 'inline-block';

      const response = await fetch('/api/index.php', {
        method: 'DELETE',
        body: JSON.stringify({
          data: {
            id
          },
          table
        }),
        headers: {
          ContentType: 'application/json',
          charset: 'utf-8'
        },
      });

      if (response.ok) {
        const text = await response.text();
        if (text === "success") {
          $(button).closest('div.row').remove();
          $(deleteModal).modal('toggle');
        } else {
          alert(text);
        }

        modalCancelButton.disabled = false;
        modalDeleteButton.disabled = false;
        modalSpinner.style.display = 'none';
      } else {
        alert("Ошибка запроса: " + response.status);
      }
    });

    deleteModal.addEventListener('show.bs.modal', event => {
      button = event.relatedTarget
      const name = button.getAttribute('data-bs-label')
      const table = button.getAttribute('data-bs-table')
      const id = button.getAttribute('data-bs-id')

      modalTitle.textContent = `Удаление ${name}`
      modalBody.textContent = `Вы действительно хотите удалить ${name}?`
    })
  }
})
</script>

<!-- Модалка редактирования -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Редактирование ...</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <div class="spinner-border text-primary --spinner" style="display: none" role="status">
          <span class="visually-hidden">Загрузка...</span>
        </div>
        <button type="button" class="btn btn-secondary --cancel-button" data-bs-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary --save-edit-button">Сохранить</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const editModal = document.getElementById('editModal');

  if (editModal) {
    let button = null;
    const modalForm = editModal.querySelector('form.modal-content');
    const modalCancelButton = editModal.querySelector('.--cancel-button');
    const modalSaveButton = editModal.querySelector('.--save-edit-button');
    const modalSpinner = editModal.querySelector('.--spinner');

    modalForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const data = JSON.parse(button.getAttribute('data-bs-json-data'));
      const tableName = button.getAttribute('data-bs-table-name');

      modalCancelButton.disabled = true;
      modalSaveButton.disabled = true;
      modalSpinner.style.display = 'inline-block';
      const formData = new FormData(modalForm);

      for (const [name, value] of formData.entries()) {
        if (value instanceof File) {
          const path = await uploadFile(value);

          if (!path.includes('<b>')) {
            formData.set(name, path);
          } else {
            alert('Произошла ошибка при загрузке файла: ' + path);
          }
        }
      }

      console.log(Object.fromEntries(formData));

      const response = await fetch('/api/index.php', {
        method: 'PATCH',
        body: JSON.stringify({
          data: Object.fromEntries(formData),
          table: tableName
        }),
        headers: {
          ContentType: 'application/json',
          charset: 'utf-8'
        },
      });

      if (response.ok) {
        const text = await response.text();
        if (tryParseJSONObject(text)) {
          const responseObj = JSON.parse(text);

          $(button).closest('div.row').children('div.col[data-name]').each((index, row) => {
            const name = $(row).data('name');
            const value = responseObj[name];
            const newData = data.map(dataElement => {
              const newDataElement = {
                ...dataElement
              };
              if (newDataElement.name === name) {
                newDataElement.initialValue = value;
              }

              return newDataElement;
            });
            button.dataset.bsJsonData = JSON.stringify(newData);

            console.log($(row).children('a').length);

            if ($(row).children('img').length) {
              $(row).children('img').attr("src", `https://pro-po.store${value}`);
            } else if ($(row).children('a').length) {
              $(row).children('a').attr("href", `https://pro-po.store${value}`);
              $(row).children('a').text(value);
            } else if ($(row).children('input[type=checkbox]').length) {
              $(row).children('input[type=checkbox]').prop('checked', !(!value))
            } else {
              $(row).text(value);
            }

          });

          $(editModal).modal('toggle');
        } else {
          alert(text);
        }

        modalCancelButton.disabled = false;
        modalSaveButton.disabled = false;
        modalSpinner.style.display = 'none';
      } else {
        alert("Ошибка запроса: " + response.status);
      }
    });

    editModal.addEventListener('show.bs.modal', event => {
      button = event.relatedTarget

      const data = JSON.parse(button.getAttribute('data-bs-json-data'));
      const modalTitle = editModal.querySelector('.modal-title')
      const modalBody = editModal.querySelector('.modal-body')

      modalBody.textContent = '';
      data.forEach(element => {
        if (element.name === 'id') {
          modalTitle.textContent = `Редактирование элемента с id ${element.initialValue}`
        }
        modalBody.insertAdjacentHTML('beforeend', `
          <div class="${element.type === 'checkbox' ? 'form-check mb-3' : 'mb-3'}">
            <label for="${element.id}" class="form-label">${element.label}</label>
            ${element.type === 'checkbox' ? '<input type="hidden" name="'+element.name+'" value="0"/>' : ''}
            
            ${element.enum ? `
              <select class="form-select" id="${element.id}" name="${element.name}" required>
                ${element.enum.map((el) => `<option value="${el.value}" ${element.initialValue === el.value ? 'selected' : ''}>${el.label}</option>`).join('')}
              </select>
              ` : `
              <input
                type="${element.type}"
                class="${element.type === 'checkbox' ? 'form-check-input' : 'form-control'}"
                id="${element.id}"
                name="${element.name}"
                value="${element.type === 'checkbox' ? '1' : element.initialValue}"
                ${element.type === 'checkbox' && element.initialValue === '1' ? 'checked' : ''}
                ${element.type !== 'checkbox' ? 'required' : ''}
              />`
            }
          </div>
        `);
      });
    })
  }
})
</script>

<!-- Модалка добавления -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Добавление ...</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <div class="spinner-border text-primary --spinner" style="display: none" role="status">
          <span class="visually-hidden">Загрузка...</span>
        </div>
        <button type="button" class="btn btn-secondary --cancel-button" data-bs-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary --add-button">Добавить</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const addModal = document.getElementById('addModal');

  if (addModal) {
    let button = null;
    const modalForm = addModal.querySelector('form.modal-content');
    const modalCancelButton = addModal.querySelector('.--cancel-button');
    const modalAddButton = addModal.querySelector('.--add-button');
    const modalSpinner = addModal.querySelector('.--spinner');

    modalForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      // const data = JSON.parse(button.getAttribute('data-bs-json-data'));
      const tableName = button.getAttribute('data-bs-table-name');

      modalCancelButton.disabled = true;
      modalAddButton.disabled = true;
      modalSpinner.style.display = 'inline-block';
      const formData = new FormData(modalForm);

      for (const [name, value] of formData.entries()) {
        if (value instanceof File) {
          const path = await uploadFile(value);

          if (!path.includes('<b>')) {
            formData.set(name, path);
          } else {
            alert('Произошла ошибка при загрузке файла: ' + path);
          }
        }
      }

      const response = await fetch('/api/index.php', {
        method: 'POST',
        body: JSON.stringify({
          data: Object.fromEntries(formData),
          table: tableName
        }),
        headers: {
          ContentType: 'application/json',
          charset: 'utf-8'
        },
      });

      if (response.ok) {
        const text = await response.text();
        if (tryParseJSONObject(text)) {
          const responseObj = JSON.parse(text);

          $(addModal).modal('toggle');
          location.reload();
        } else {
          alert(text);
        }
      } else {
        alert("Ошибка запроса: " + response.status);
      }

      modalCancelButton.disabled = false;
      modalAddButton.disabled = false;
      modalSpinner.style.display = 'none';
    });

    addModal.addEventListener('show.bs.modal', event => {
      button = event.relatedTarget

      const data = JSON.parse(button.getAttribute('data-bs-json-data'));
      const modalTitle = addModal.querySelector('.modal-title')
      const modalBody = addModal.querySelector('.modal-body')
      modalTitle.textContent = `Добавление элемента`

      modalBody.textContent = '';
      data.forEach(element => {
        console.log(element.enum);
        modalBody.insertAdjacentHTML('beforeend', `
          <div class="${element.type === 'checkbox' ? 'form-check mb-3' : 'mb-3'}">
            <label for="${element.id}" class="form-label">${element.label}</label>
            ${element.type === 'checkbox' ? '<input type="hidden" name="'+element.name+'" value="0"/>' : ''}
            ${element.enum ? `
              <select class="form-select" id="${element.id}" name="${element.name}" required>
                ${element.enum.map((el) => `<option value="${el.value}">${el.label}</option>`).join('')}
              </select>
              ` : `
              <input
                type="${element.type}"
                class="${element.type === 'checkbox' ? 'form-check-input' : 'form-control'}"
                id="${element.id}"
                name="${element.name}"
                ${element.type !== 'checkbox' ? 'required' : 'value="1"'}
              />`}
            
          </div>
        `);
      });
    })
  }
})
</script>

<!-- Модалка генерации sitemap -->
<div class="modal fade" id="sitemapModal" tabindex="-1" aria-labelledby="sitemapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="sitemapModalLabel">Генерация sitemap</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Вы действительно хотите сгенерировать sitemap? Файл <a href="https://pro-po.store/sitemap.xml"
          download>sitemap.xml</a> будет заменён.
      </div>
      <div class="modal-footer">
        <div class="spinner-border text-primary --spinner" style="display: none" role="status">
          <span class="visually-hidden">Загрузка...</span>
        </div>
        <button type="button" class="btn btn-secondary --cancel-button" data-bs-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary --generate-button">Сгенерировать</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const sitemapModal = document.getElementById('sitemapModal');

  if (sitemapModal) {
    let button = null;
    const modalForm = sitemapModal.querySelector('form.modal-content');
    const modalSpinner = sitemapModal.querySelector('.--spinner')
    const modalCancelButton = sitemapModal.querySelector('.--cancel-button')
    const modalGenerateButton = sitemapModal.querySelector('.--generate-button')

    modalForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const table = button.getAttribute('data-bs-table')
      const id = button.getAttribute('data-bs-id')

      modalCancelButton.disabled = true;
      modalGenerateButton.disabled = true;
      modalSpinner.style.display = 'inline-block';

      const response = await fetch('/api/sitemap.php');

      if (response.ok) {
        const text = await response.text();
        if (text === "https://pro-po.store/sitemap.xml") {

          let link = document.createElement('a');
          link.setAttribute('href', text);
          link.setAttribute('download', 'sitemap.xml');
          link.click();

          $(sitemapModal).modal('toggle');
        } else {
          alert(text);
        }

        modalCancelButton.disabled = false;
        modalGenerateButton.disabled = false;
        modalSpinner.style.display = 'none';
      } else {
        alert("Ошибка запроса: " + response.status);
      }
    });

    sitemapModal.addEventListener('show.bs.modal', event => {
      button = event.relatedTarget
    })
  }
})
</script>