// lab11/js/login.js
(function () {
  const form = document.getElementById('login-form');
  const email = document.getElementById('email');
  const password = document.getElementById('password');
  const emailErr = document.getElementById('email-error');
  const passErr = document.getElementById('password-error');

  // очень простая проверка email (достаточно для фронт-проверки)
  const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function setError(inputEl, errorEl, msg) {
    inputEl.classList.add('form__input_invalid');
    errorEl.textContent = msg;
  }

  function clearError(inputEl, errorEl) {
    inputEl.classList.remove('form__input_invalid');
    errorEl.textContent = '';
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault(); // пока серверной проверки нет

    // очищаем прошлые ошибки
    clearError(email, emailErr);
    clearError(password, passErr);

    let ok = true;

    if (!email.value.trim() || !emailRe.test(email.value.trim())) {
      setError(email, emailErr, 'Введите корректный email');
      ok = false;
    }

    if (!password.value.trim() || password.value.length < 6) {
      setError(password, passErr, 'Пароль должен быть не короче 6 символов');
      ok = false;
    }

    if (ok) {
      // здесь в будущем отправка на сервер
      console.log('Форма валидна:', {
        email: email.value.trim(),
        password: '[HIDDEN]',
      });
      // для демонстрации можно очистить форму
      form.reset();
    }
  });

  // UX: убирать ошибку по вводу
  [email, password].forEach((el) => {
    el.addEventListener('input', () => {
      if (el === email) clearError(email, emailErr);
      if (el === password) clearError(password, passErr);
    });
  });
})();
