function initPostSliders() {
  const sliders = document.querySelectorAll('[data-slider]');
  sliders.forEach(slider => {
    const images = Array.from(slider.querySelectorAll('.slider__image'));
    const btnPrev = slider.querySelector('[data-prev]');
    const btnNext = slider.querySelector('[data-next]');
    const indicator = slider.querySelector('[data-indicator]');
    let index = 0;

    const update = () => {
      images.forEach((img, i) => img.classList.toggle('is-active', i === index));
      if (indicator) indicator.textContent = `${index + 1}/${images.length}`;
    };

    const next = () => { index = (index + 1) % images.length; update(); };
    const prev = () => { index = (index - 1 + images.length) % images.length; update(); };

    btnNext?.addEventListener('click', next);
    btnPrev?.addEventListener('click', prev);

    update();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initPostSliders();
});
function initModal() {
  const modal = document.querySelector('[data-modal]');
  if (!modal) return;

  const imgEl = modal.querySelector('[data-modal-image]');
  const indicator = modal.querySelector('[data-modal-indicator]');
  const btnClose = modal.querySelector('[data-modal-close]');
  const btnPrev = modal.querySelector('[data-modal-prev]');
  const btnNext = modal.querySelector('[data-modal-next]');

  let images = [];
  let index = 0;

  const open = (imgs, startIndex = 0) => {
    images = imgs;
    index = startIndex;
    update();
    modal.hidden = false;
    document.body.style.overflow = 'hidden'; // блокируем скролл
  };

  const close = () => {
    modal.hidden = true;
    document.body.style.overflow = '';
  };

  const update = () => {
    imgEl.src = images[index].src;
    indicator.textContent = `${index + 1}/${images.length}`;
  };

  const next = () => { index = (index + 1) % images.length; update(); };
  const prev = () => { index = (index - 1 + images.length) % images.length; update(); };

  btnNext.addEventListener('click', next);
  btnPrev.addEventListener('click', prev);
  btnClose.addEventListener('click', close);
  modal.addEventListener('click', e => {
    if (e.target === modal || e.target.classList.contains('modal__backdrop')) {
      close();
    }
  });

  document.addEventListener('keydown', e => {
    if (!modal.hidden && e.key === 'Escape') close();
  });

  // подключаем к картинкам поста
  document.querySelectorAll('[data-slider] .slider__image').forEach((img, i, all) => {
    img.style.cursor = 'pointer';
    img.addEventListener('click', () => {
      // находим все картинки внутри именно этого слайдера
      const sliderImages = Array.from(img.closest('[data-slider]').querySelectorAll('.slider__image'));
      const startIndex = sliderImages.indexOf(img);
      open(sliderImages, startIndex);
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initPostSliders();
  initModal();
});
function initMoreButtons() {
  const posts = document.querySelectorAll('[data-text]');
  posts.forEach(p => {
    const moreBtn = p.querySelector('[data-more]');
    if (!moreBtn) return;

    // Временно убираем clamp, чтобы измерить
    p.classList.remove('post__text--clamped');
    const needClamp = p.scrollHeight > p.clientHeight * 1.2; // грубая проверка переполнения

    if (needClamp) {
      p.classList.add('post__text--clamped');
      moreBtn.hidden = false;
      let expanded = false;

      moreBtn.addEventListener('click', () => {
        expanded = !expanded;
        p.classList.toggle('post__text--clamped', !expanded);
        moreBtn.textContent = expanded ? 'свернуть' : 'ещё';
      });
    } else {
      moreBtn.hidden = true;
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initPostSliders();
  initModal();
  initMoreButtons();   // ← добавили
});
