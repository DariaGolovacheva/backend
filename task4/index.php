<?php
header('Content-Type: text/html; charset=UTF-8');

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    // Пример простой валидации для телефона (можно доработать по необходимости)
    return preg_match("/^\+?\d{1,3}\s?\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{2}[-\s]?\d{2}$/", $phone);
}

$errors = [];

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Валидация ФИО
    if (empty($_POST['name'])) {
        $errors['name'] = 'Введите ФИО.';
    } elseif (!preg_match('/^[a-zA-Zа-яА-Я\s]{1,150}$/', $_POST['name'])) {
        $errors['name'] = 'Неправильный формат ФИО.';
    }

    // Валидация email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите email.';
    } elseif (!validate_email($_POST['email'])) {
        $errors['email'] = 'Неправильный формат email.';
    }

    // Валидация телефона
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Введите номер телефона.';
    } elseif (!validate_phone($_POST['phone'])) {
        $errors['phone'] = 'Неправильный формат номера телефона.';
    }

    // Валидация даты рождения
    if (empty($_POST['dob'])) {
        $errors['dob'] = 'Введите дату рождения.';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['dob'])) {
        $errors['dob'] = 'Неправильный формат даты рождения.';
    }

    // Валидация пола
    if (empty($_POST['gender'])) {
        $errors['gender'] = 'Укажите ваш пол.';
    }

    // Валидация биографии
    if (empty($_POST['bio'])) {
        $errors['bio'] = 'Введите вашу биографию.';
    }

    // Валидация контракта
    if (!isset($_POST['contract'])) {
        $errors['contract'] = 'Необходимо ознакомиться с контрактом.';
    }

    // Валидация выбранного языка программирования
    if (empty($_POST['favoriteLanguage'])) {
        $errors['favoriteLanguage'] = 'Выберите хотя бы один язык программирования.';
    }

    if (empty($errors)) {
        // Если ошибок нет, можно обрабатывать данные
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];
        $contract = isset($_POST['contract']) ? 1 : 0;
        $favoriteLanguages = implode(', ', $_POST['favoriteLanguage']); // Преобразуем массив в строку

        // Здесь ваш код для сохранения данных в базе данных

        // Сохранение значений в Cookies
        $cookieExpiration = time() + (365 * 24 * 60 * 60); // На год
        setcookie('name', $name, $cookieExpiration);
        setcookie('email', $email, $cookieExpiration);
        setcookie('phone', $phone, $cookieExpiration);
        setcookie('dob', $dob, $cookieExpiration);
        setcookie('gender', $gender, $cookieExpiration);
        setcookie('bio', $bio, $cookieExpiration);
        setcookie('favoriteLanguages', $favoriteLanguages, $cookieExpiration);

        // Выводим сообщение об успешном сохранении
        echo 'Данные успешно сохранены в базе данных!';
    } else {
        // Если есть ошибки, сохраняем их в Cookies
        $cookieExpiration = 0; // до конца сессии
        foreach ($errors as $key => $value) {
            setcookie($key . '_error', $value, $cookieExpiration);
        }

        // Перенаправляем обратно на форму с GET запросом
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        exit;
    }
}

// Проверяем наличие ошибок в Cookies и удаляем их
$errorsFromCookies = [];
foreach ($_COOKIE as $key => $value) {
    if (strpos($key, '_error') !== false) {
        $field = str_replace('_error', '', $key);
        $errorsFromCookies[$field] = $value;
        setcookie($key, '', time() - 3600); // Удаление Cookie
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрационная форма</title>
<link rel="stylesheet" href="styles.css">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #000; /* Черный фон */
    color: #fff; /* Белый цвет текста */
    margin: 0;
    padding: 0;
  }
  
  .container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #222; /* Черный цвет фона контейнера */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  
  h2 {
    text-align: center;
    color: #FFA500; /* Оранжевый цвет заголовка */
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  label {
    font-weight: bold;
    color: #fff; /* Белый цвет текста меток */
  }
  
  input[type="text"],
  input[type="tel"],
  input[type="email"],
  input[type="date"],
  textarea,
  select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #333; /* Черный цвет поля ввода */
    color: #fff; /* Белый цвет текста в полях ввода */
  }
  
  input[type="checkbox"] {
    margin-right: 5px;
  }
  
  button {
    background-color: #FFA500; /* Оранжевый цвет кнопки */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #FF8C00; /* Темно-оранжевый цвет кнопки при наведении */
  }
</style>
</head>
<body>

<div class="container">
  <h2>Регистрационная форма</h2>
  <form id="registrationForm" method="POST" action="">
    <div class="form-group">
      <label for="name">ФИО:</label>
      <input type="text" id="fullName" name="name" >
    </div>
    <div class="form-group">
      <label for="phone">Телефон:</label>
      <input type="tel" id="phone" name="phone">
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" >
    </div>
    <div class="form-group">
      <label for="dob">Дата рождения:</label>
      <input type="date" id="dob" name="dob" >
    </div>
    <div class="form-group">
      <label>Пол:</label>
      <label><input type="radio" name="gender" value="male" checked> Мужской</label>
      <label><input type="radio" name="gender" value="female"> Женский</label>
    </div>
    <div class="form-group">
      <label for="favoriteLanguage">Любимый язык программирования:</label>
      <select id="favoriteLanguage" name="favoriteLanguage[]" multiple >
        <option value="Pascal">Pascal</option>
        <option value="C">C</option>
        <option value="C++">C++</option>
        <option value="JavaScript">JavaScript</option>
        <option value="PHP">PHP</option>
        <option value="Python">Python</option>
        <option value="Java">Java</option>
        <option value="Haskel">Haskel</option>
        <option value="Clojure">Clojure</option>
        <option value="Prolog">Prolog</option>
        <option value="Scala">Scala</option>
      </select>
    </div>
    <div class="form-group">
      <label for="bio">Биография:</label>
      <textarea id="bio" name="bio" rows="5" ></textarea>
    </div>
    <div class="form-group">
      <label><input type="checkbox" id="contract" name="contract" > С контрактом ознакомлен (а)</label>
    </div>
    <button type="submit">Сохранить</button>
  </form>
</div>

</body>
</html>

