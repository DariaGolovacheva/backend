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
        $errors['name'] = 'Неправильный формат ФИО. Разрешены только буквы и пробелы.';
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

        // Установка Cookies на один год
        $expiry = time() + (365 * 24 * 60 * 60); // текущее время + один год
        setcookie('name', $name, $expiry);
        setcookie('email', $email, $expiry);
        setcookie('phone', $phone, $expiry);
        setcookie('dob', $dob, $expiry);
        setcookie('gender', $gender, $expiry);
        setcookie('bio', $bio, $expiry);
        setcookie('contract', $contract, $expiry);
        setcookie('favoriteLanguages', $favoriteLanguages, $expiry);

        // Перенаправление на успешную страницу
        header('Location: success.php');
        exit();
    } else {
        // Сохранение ошибок в Cookies
        setcookie('errors', json_encode($errors), 0);

        // Сохранение значений полей в Cookies
        foreach ($_POST as $key => $value) {
            setcookie($key, $value, 0);
        }

        // Перенаправление на страницу с формой
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Восстановление значений полей из Cookies
$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : '';
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
$phone = isset($_COOKIE['phone']) ? $_COOKIE['phone'] : '';
$dob = isset($_COOKIE['dob']) ? $_COOKIE['dob'] : '';
$gender = isset($_COOKIE['gender']) ? $_COOKIE['gender'] : '';
$bio = isset($_COOKIE['bio']) ? $_COOKIE['bio'] : '';
$contract = isset($_COOKIE['contract']) ? $_COOKIE['contract'] : '';
$favoriteLanguages = isset($_COOKIE['favoriteLanguages']) ? $_COOKIE['favoriteLanguages'] : '';

// Восстановление ошибок из Cookies
$errors = isset($_COOKIE['errors']) ? json_decode($_COOKIE['errors'], true) : [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрационная форма</title>
<link rel="stylesheet" href="styles.css">
<style>
  .error {
    color: red;
  }
</style>
</head>
<body>

<div class="container">
  <h2>Регистрационная форма</h2>
  <form id="registrationForm" method="POST" action="">
    <div class="form-group">
      <label for="name">ФИО:</label>
      <input type="text" id="fullName" name="name" value="<?php echo $name; ?>">
      <?php if(isset($errors['name'])) echo '<p class="error">' . $errors['name'] . '</p>'; ?>
    </div>
    <div class="form-group">
      <label for="phone">Телефон:</label>
      <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>">
      <?php if(isset($errors['phone'])) echo '<p class="error">' . $errors['phone'] . '</p>'; ?>
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>">
      <?php if(isset($errors['email'])) echo '<p class="error">' . $errors['email'] . '</p>'; ?>
    </div>
    <div class="form-group">
      <label for="dob">Дата рождения:</label>
      <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>">
      <?php if(isset($errors['dob'])) echo '<p class="error">' . $errors['dob'] . '</p>'; ?>
    </div>
    <div class="form-group">
      <label>Пол:</label>
      <label><input type="radio" name="gender" value="male" <?php echo ($gender === 'male') ? 'checked' : ''; ?>> Мужской</label>
      <label><input type="radio" name="gender" value="female" <?php echo ($gender === 'female') ? 'checked' : ''; ?>> Женский</label>
      <?php if(isset($errors['gender'])) echo '<p class="error">' . $errors['gender'] . '</p>'; ?>
    </div>
    <div class="form-group">
      <label for="favoriteLanguage">Любимый язык программирования:</label>
      <select id="favoriteLanguage" name="favoriteLanguage[]" multiple>
        <option value="Pascal" <?php echo strpos($favoriteLanguages, 'Pascal') !== false ? 'selected' : ''; ?>>Pascal</option>
        <!-- Добавьте остальные опции с аналогичной проверкой -->
      </select>
      <?php if(isset($errors['favoriteLanguage'])) echo '<p class="error">' . $errors['favoriteLanguage'] . '</p>'; ?>
    </div>
    <div class="form-group">
      <label for="bio">Биография:</label>
      <textarea id="bio" name="bio" rows="5"><?php echo $bio; ?></textarea>
      <?php if(isset($errors['bio'])) echo '<p class="error">' . $errors['bio'] . '</p>'; ?>
    </div>
    <div class="form-group">
      <label><input type="checkbox" id="contract" name="contract" <?php echo $contract ? 'checked' : ''; ?>> С контрактом ознакомлен (а)</label>
      <?php if(isset($errors['contract'])) echo '<p class="error">' . $errors['contract'] . '</p>'; ?>
    </div>
    <button type="submit">Сохранить</button>
  </form>
</div>

</body>
</html>
