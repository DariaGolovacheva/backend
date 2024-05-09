<?php
header('Content-Type: text/html; charset=UTF-8');

// Функция для установки Cookie
function set_cookie($name, $value, $expiration) {
    setcookie($name, $value, $expiration, '/');
}

// Функция для получения Cookie
function get_cookie($name) {
    return $_COOKIE[$name] ?? '';
}

// Функция для валидации текста
function validate_text($text) {
    return preg_match('/^[a-zA-Zа-яА-Я\s.,!?()-]{1,255}$/', $text);
}

$errors = [];

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Валидация ФИО
    if (empty($_POST['name']) || !validate_text($_POST['name'])) {
        $errors['name'] = 'Введите ФИО. Допустимы буквы, пробелы и знаки препинания.';
    }

    // Валидация email
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email.';
    }

    // Валидация телефона
    if (empty($_POST['phone']) || !preg_match("/^\+?\d{1,3}\s?\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{2}[-\s]?\d{2}$/", $_POST['phone'])) {
        $errors['phone'] = 'Введите корректный номер телефона.';
    }

    // Валидация даты рождения
    if (empty($_POST['dob']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['dob'])) {
        $errors['dob'] = 'Введите корректную дату рождения в формате YYYY-MM-DD.';
    }

    // Валидация выбранного языка программирования
    if (empty($_POST['favoriteLanguage'])) {
        $errors['favoriteLanguage'] = 'Выберите хотя бы один язык программирования.';
    }

    // Валидация биографии
    if (empty($_POST['bio']) || !validate_text($_POST['bio'])) {
        $errors['bio'] = 'Введите корректную биографию. Допустимы буквы, пробелы и знаки препинания.';
    }

    // Валидация контракта
    if (!isset($_POST['contract'])) {
        $errors['contract'] = 'Необходимо ознакомиться с контрактом.';
    }

    if (empty($errors)) {
        // Если ошибок нет, можно обрабатывать данные
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $favoriteLanguages = implode(', ', $_POST['favoriteLanguage']); // Преобразуем массив в строку
        $bio = $_POST['bio'];
        $contract = isset($_POST['contract']) ? 1 : 0;

        // Сохранение данных в Cookies на один год
        set_cookie('name', $name, time() + 31536000); // 31536000 секунд в году
        set_cookie('email', $email, time() + 31536000);
        set_cookie('phone', $phone, time() + 31536000);
        set_cookie('dob', $dob, time() + 31536000);
        set_cookie('favoriteLanguages', $favoriteLanguages, time() + 31536000);
        set_cookie('bio', $bio, time() + 31536000);
        set_cookie('contract', $contract, time() + 31536000);

        include('../db.php');
$db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX
// Подготовленный запрос. Не именованные метки.
try {
$stmt = $db->prepare("INSERT INTO application (name, phone, email, data, pol, bio, ok) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$_POST['name'], $_POST['phone'], $_POST['email'], $_POST['data'], $_POST['pol'], $_POST['bio'], $_POST['ok']]);
$lastId = $db->lastInsertId();

foreach ($_POST['abilities'] as $ability) {
    $stmtLang = $db->prepare("SELECT id FROM language WHERE name = ?");
    $stmtLang->execute([$ability]);
    $languageId = $stmtLang->fetchColumn();

    $stmtApLang = $db->prepare("INSERT INTO ap_lan (id_application, id_language) VALUES (:lastId, :languageId)");
    $stmtApLang->bindParam(':lastId', $lastId);
    $stmtApLang->bindParam(':languageId', $languageId);
    $stmtApLang->execute();
}
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрационная форма</title>
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
      
      .error {
        color: #ff0000; /* Красный цвет текста ошибки */
        font-size: 12px;
      }
      
      .has-error input,
      .has-error select,
      .has-error textarea {
        border-color: #ff0000; /* Красная рамка вокруг поля ввода с ошибкой */
      }
    </style>
</head>
<body>

<div class="container">
  <h2>Регистрационная форма</h2>
  <form id="registrationForm" method="POST" action="">
    <div class="form-group <?php echo isset($_COOKIE['name_error']) ? 'has-error' : ''; ?>">
      <label for="name">ФИО:</label>
      <input type="text" id="fullName" name="name" value="<?php echo htmlspecialchars(get_cookie('name')); ?>">
      <?php echo isset($_COOKIE['name_error']) ? '<span class="error">' . $_COOKIE['name_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['phone_error']) ? 'has-error' : ''; ?>">
      <label for="phone">Телефон:</label>
      <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars(get_cookie('phone')); ?>">
      <?php echo isset($_COOKIE['phone_error']) ? '<span class="error">' . $_COOKIE['phone_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['email_error']) ? 'has-error' : ''; ?>">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars(get_cookie('email')); ?>">
      <?php echo isset($_COOKIE['email_error']) ? '<span class="error">' . $_COOKIE['email_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['dob_error']) ? 'has-error' : ''; ?>">
      <label for="dob">Дата рождения:</label>
      <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars(get_cookie('dob')); ?>">
      <?php echo isset($_COOKIE['dob_error']) ? '<span class="error">' . $_COOKIE['dob_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['favoriteLanguage_error']) ? 'has-error' : ''; ?>">
      <label for="favoriteLanguage">Любимый язык программирования:</label>
      <select id="favoriteLanguage" name="favoriteLanguage[]" multiple>
        <option value="Pascal">Pascal</option>
        <option value="C">C</option>
        <option value="C++">C++</option>
        <option value="JavaScript">JavaScript</option>
        <option value="PHP">PHP</option>
        <option value="Python">Python</option>
        <option value="Java">Java</option>
        <option value="Haskell">Haskell</option>
        <option value="Clojure">Clojure</option>
        <option value="Prolog">Prolog</option>
        <option value="Scala">Scala</option>
      </select>
      <?php echo isset($_COOKIE['favoriteLanguage_error']) ? '<span class="error">' . $_COOKIE['favoriteLanguage_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['bio_error']) ? 'has-error' : ''; ?>">
      <label for="bio">Биография:</label>
      <textarea id="bio" name="bio" rows="5"><?php echo htmlspecialchars(get_cookie('bio')); ?></textarea>
      <?php echo isset($_COOKIE['bio_error']) ? '<span class="error">' . $_COOKIE['bio_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['contract_error']) ? 'has-error' : ''; ?>">
      <label><input type="checkbox" id="contract" name="contract"> С контрактом ознакомлен (а)</label>
      <?php echo isset($_COOKIE['contract_error']) ? '<span class="error">' . $_COOKIE['contract_error'] . '</span>' : ''; ?>
    </div>
    <button type="submit">Сохранить</button>
  </form>
</div>

</body>
</html>
