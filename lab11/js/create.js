// Хранилище выбранных картинок (URL объектов)
const state = {
  urls: [],     // objectURL для <img src="">
  active: 0     // индекс текущей картинки
};

const fileInput  = document.getElementById('fileInput');
const addFirst   = document.getElementById('addFirstPhoto');
const addMore    = document.getElementById('addMorePhoto');
const slider     = document.getElementById('preview');
const indicator  = document.getElementById('indicator');
const prevBtn    = document.getElementById('prevBtn');
const nextBtn    = document.getElementById('nextBtn');
const captionEl  = document.getElementById('caption');
const shareBtn   = document.getElementById('shareBtn');

// открыть системный диалог выбора файла
const openPicker = () => fileInput.click();
addFirst.addEventListener('click', openPicker);
addMore.addEventListener('click', openPicker);

// при выборе файла(ов) — добавляем в слайдер
fileInput.addEventListener('change', (e) => {
  const files = Array.from(e.target.files || []);
  if (!files.length) return;

  files.forEach(f => {
    if (!f.type.startsWith('image/')) return;
    const url = URL.createObjectURL(f);
    state.urls.push({ url, name: f.name, size: f.size, type: f.type });
  });

  renderSlider();
  validateForm();

  // очищаем input, чтобы повторный выбор того же файла сработал
  fileInput.value = '';
});

// отрисовка слайдера
function renderSlider() {
  // показать контейнер
  slider.hidden = state.urls.length === 0;

  // удалить старые <img>, кроме кнопок и индикатора
  slider.querySelectorAll('img.slider__image').forEach(n => n.remove());

  state.urls.forEach((item, idx) => {
    const img = document.createElement('img');
    img.className = 'slider__image' + (idx === state.active ? ' is-active' : '');
    img.src = item.url;
    img.alt = `Фото ${idx + 1}`;
    slider.insertBefore(img, nextBtn); // вставляем перед кнопкой «вперёд»
  });

  // поправить активный индекс, если вышли за границу
  if (state.active > state.urls.length - 1) state.active = state.urls.length - 1;
  if (state.active < 0) state.active = 0;

  updateIndicator();
}

// индикатор 1/3
function updateIndicator() {
  indicator.textContent = `${state.urls.length ? state.active + 1 : 0}/${state.urls.length}`;
}

// переключение
prevBtn.addEventListener('click', () => {
  if (!state.urls.length) return;
  state.active = (state.active - 1 + state.urls.length) % state.urls.length;
  setActive();
});
nextBtn.addEventListener('click', () => {
  if (!state.urls.length) return;
  state.active = (state.active + 1) % state.urls.length;
  setActive();
});

function setActive() {
  const imgs = slider.querySelectorAll('img.slider__image');
  imgs.forEach((img, i) => img.classList.toggle('is-active', i === state.active));
  updateIndicator();
}

// валидация — активируем «Поделиться», когда есть >=1 фото И непустая подпись
function validateForm() {
  const hasPhoto = state.urls.length > 0;
  const hasText  = captionEl.value.trim().length > 0;
  shareBtn.disabled = !(hasPhoto && hasText);
}

captionEl.addEventListener('input', validateForm);

// обработка «Поделиться» — печатаем данные поста в консоль
shareBtn.addEventListener('click', (e) => {
  e.preventDefault();
  // имена файлов + подпись — как черновой payload
  const payload = {
    caption: captionEl.value.trim(),
    photos: state.urls.map(u => ({ name: u.name, type: u.type, size: u.size }))
  };
  console.log('Новый пост:', payload);

  // имитация отправки: очищаем форму
  alert('Пост сформирован (смотри консоль). Очистим форму.');
  // очистка objectURL
  state.urls.forEach(u => URL.revokeObjectURL(u.url));
  state.urls = [];
  state.active = 0;
  captionEl.value = '';
  renderSlider();
  validateForm();
});

// первичная инициализация
renderSlider();
validateForm();
