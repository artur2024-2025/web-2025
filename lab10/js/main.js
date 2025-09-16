'use strict';

// 1. Простые числа
function isPrimeNumber(value) {
  function isPrime(n) {
    if (typeof n !== 'number' || !Number.isInteger(n)) return false;
    if (n < 2) return false;
    if (n === 2) return true;
    if (n % 2 === 0) return false;
    const lim = Math.floor(Math.sqrt(n));
    for (let d = 3; d <= lim; d += 2) if (n % d === 0) return false;
    return true;
  }

  const print = (n) =>
    console.log(`${n} ${isPrime(n) ? 'простое число' : 'не простое число'}`);

  if (Array.isArray(value)) {
    if (!value.every((x) => typeof x === 'number' && Number.isFinite(x))) {
      console.error('Ошибка: массив должен содержать только числа');
      return;
    }
    value.forEach(print);
  } else if (typeof value === 'number' && Number.isFinite(value)) {
    print(value);
  } else {
    console.error('Ошибка: ожидается число или массив чисел');
  }
}

// 2. Подсчет гласных в строке
function countVowels(str) {
  if (typeof str !== 'string') {
    console.error('Ошибка: требуется строка');
    return 0;
  }
  const VOWELS_RU = 'аеёиоуыэюя';
  let count = 0;
  for (const ch of str.toLowerCase()) if (VOWELS_RU.includes(ch)) count++;
  return count;
}

// 3. Уникальные элементы в массиве
function uniqueElements(arr) {
  if (!Array.isArray(arr)) {
    console.error('Ошибка: требуется массив');
    return {};
  }
  return arr.reduce((acc, el) => {
    const key = String(el);
    acc[key] = (acc[key] || 0) + 1;
    return acc;
  }, {});
}

// 4. Объединение объектов (приоритет у obj2)
function mergeObjects(obj1, obj2) {
  if (obj1 == null || typeof obj1 !== 'object' ||
      obj2 == null || typeof obj2 !== 'object') {
    console.error('Ошибка: оба параметра должны быть объектами');
    return {};
  }
  return { ...obj1, ...obj2 };
}

// 5. Преобразование массива объектов → массив имен (map)
function pickUserNames(users) {
  if (!Array.isArray(users)) {
    console.error('Ошибка: требуется массив объектов пользователей');
    return [];
  }
  return users.map((u) => u?.name);
}

// 6. Метод map для объекта (доп)
function mapObject(obj, callback) {
  if (obj == null || typeof obj !== 'object') {
    console.error('Ошибка: требуется объект');
    return {};
  }
  if (typeof callback !== 'function') {
    console.error('Ошибка: второй параметр должен быть функцией');
    return {};
  }
  const entries = Object.entries(obj).map(([k, v]) => [k, callback(v, k, obj)]);
  return Object.fromEntries(entries);
}

// 7. Генератор пароля (доп) — длина ≥ 4, обяз. категории
function generatePassword(length = 12) {
  if (typeof length !== 'number' || !Number.isInteger(length) || length < 4) {
    console.error('Ошибка: длина пароля должна быть целым числом ≥ 4');
    return '';
  }
  const LOWER = 'abcdefghijklmnopqrstuvwxyz';
  const UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  const DIGIT = '0123456789';
  const SPECIAL = '!@#$%^&*()-_=+[]{};:,.<>/?';
  const all = LOWER + UPPER + DIGIT + SPECIAL;

  const rnd = (s) => s[Math.floor(Math.random() * s.length)];
  const chars = [rnd(LOWER), rnd(UPPER), rnd(DIGIT), rnd(SPECIAL)];
  while (chars.length < length) chars.push(rnd(all));
  // перемешивание Фишера–Йетса
  for (let i = chars.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [chars[i], chars[j]] = [chars[j], chars[i]];
  }
  return chars.join('');
}

// 8. map + filter (доп): *3, затем > 10
function mapTimes3FilterGt10(nums) {
  if (!Array.isArray(nums) || !nums.every((n) => typeof n === 'number')) {
    console.error('Ошибка: требуется массив чисел');
    return [];
  }
  return nums.map((n) => n * 3).filter((n) => n > 10);
}

// чтобы функции были доступны из консоли:
Object.assign(window, {
  isPrimeNumber,
  countVowels,
  uniqueElements,
  mergeObjects,
  pickUserNames,
  mapObject,
  generatePassword,
  mapTimes3FilterGt10,
});
