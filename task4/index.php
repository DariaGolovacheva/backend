<?php
header('Content-Type: text/html; charset=UTF-8');

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    // Пример простой валидации для телефона (можно доработать по необходимости)
    return preg_match("/^\+?\d{1,3}\s?\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{2}[-\s]?\d{2}$/", $phone);
}

// Функция для проверки ФИО
function validate_name($name) {
    // Допустимые символы: буквы, пробелы, тире, апостроф
    return preg_match('/^[a-zA-Zа-яА-Я\s\-\'']+$/u', $name);
}

// Проверка метода запроса

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Валидация ФИО
    if (empty($_POST['name']) || !validate_name($_POST['name'])) {
        $errors['name'] = 'Введите корректное ФИО.';
    }

    // Валидация email
    
    if (empty($_POST['email']) || !validate_email($_POST['email'])) {
        $errors['email'] = 'Введите корректный email.';
    }

    // Валидация телефона
    if (empty($_POST['phone']) || !validate_phone($_POST['phone'])) {
        $errors['phone'] = 'Введите корректный номер телефона.';
    }

    // Валидация даты рождения
    if (empty($_POST['dob']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['dob'])) {
        $errors['dob'] = 'Введите корректную дату рождения.';
    }

    // Валидация пола
    if (empty($_POST['gender'])) {
        $errors['gender'] = 'Выберите ваш пол.';
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

    // Если есть ошибки
    if (!empty($errors)) {
        // Сохраняем ошибки в Cookies
        setcookie('form_errors', serialize($errors), 0, '/');
        
        // Перезагружаем страницу формы
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        // Успешная валидация
        // Сохраняем данные в Cookies на один год
        setcookie('form_data', serialize($_POST), time() + 3600 * 24 * 365, '/');
        
        // Очищаем Cookies с ошибками
        setcookie('form_errors', '', time() - 3600, '/');
        
        // Редирект на страницу успешного завершения
        header('Location: success.php');
        exit;
    }
}

// Если есть ошибки в Cookies, преобразуем их обратно в массив
$errors = isset($_COOKIE['form_errors']) ? unserialize($_COOKIE['form_errors']) : [];

// Если есть данные в Cookies, преобразуем их обратно в массив
$form_data = isset($_COOKIE['form_data']) ? unserialize($_COOKIE['form_data']) : [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрационная форма</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
  <h2>Регистрационная форма</h2>
  <form id="registrationForm" method="POST" action="">
    <div class="form-group">
      <label for="name">ФИО:</label>
      <input type="text" id="fullName" name="name" value="<?= isset($form_data['name']) ? htmlspecialchars($form_data['name']) : '' ?>">
      <?php if (isset($errors['name'])) echo '<p class="error">' . $errors['name'] . '</p>'; ?>
    </div>
    <!-- Другие поля формы соответственно с обработкой ошибок -->
    <button type="submit">Сохранить</button>
  </form>
</div>

</body>
</html>
