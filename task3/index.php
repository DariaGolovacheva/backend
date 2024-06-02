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
        $errors[] = 'Введите ФИО.';
    } elseif (!preg_match('/^[a-zA-Zа-яА-Я\s]{1,150}$/', $_POST['name'])) {
        $errors[] = 'Неправильный формат ФИО.';
    }

    // Валидация email
    if (empty($_POST['email'])) {
        $errors[] = 'Введите email.';
    } elseif (!validate_email($_POST['email'])) {
        $errors[] = 'Неправильный формат email.';
    }

    // Валидация телефона
    if (empty($_POST['phone'])) {
        $errors[] = 'Введите номер телефона.';
    } elseif (!validate_phone($_POST['phone'])) {
        $errors[] = 'Неправильный формат номера телефона.';
    }

    // Валидация даты рождения
    if (empty($_POST['dob'])) {
        $errors[] = 'Введите дату рождения.';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['dob'])) {
        $errors[] = 'Неправильный формат даты рождения.';
    }

    // Валидация пола
    if (empty($_POST['gender'])) {
        $errors[] = 'Укажите ваш пол.';
    }

    // Валидация биографии
    if (empty($_POST['bio'])) {
        $errors[] = 'Введите вашу биографию.';
    }

    // Валидация контракта
    if (!isset($_POST['contract'])) {
        $errors[] = 'Необходимо ознакомиться с контрактом.';
    }

    // Валидация выбранного языка программирования
    if (empty($_POST['favoriteLanguage'])) {
        $errors[] = 'Выберите хотя бы один язык программирования.';
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

        // Подключение к базе данных
        $user = 'u67498';
        $pass = '2427367';
        $dbname = 'u67498';
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            // Вставка данных в таблицу application
            $stmt = $db->prepare("INSERT INTO application1 (name, email, phone, dob, gender, bio, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $dob, $gender, $bio, $contract]);
            
            // Получение ID вставленной записи
            $application_id = $db->lastInsertId();

            // Сохранение выбранных языков программирования в таблицу programming_language (если они еще не существуют)
            foreach ($_POST['favoriteLanguage'] as $language) {
                $stmt = $db->prepare("INSERT IGNORE INTO programming_language (name) VALUES (?)");
                $stmt->execute([$language]);
            }

            // Получение идентификаторов языков программирования из таблицы programming_language
            $stmt = $db->prepare("SELECT id FROM programming_language WHERE name IN (" . implode(',', array_fill(0, count($_POST['favoriteLanguage']), '?')) . ")");
$stmt->execute($_POST['favoriteLanguage']);

            $language_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Вставка данных в таблицу application_ability
            foreach ($language_ids as $language_id) {
                $stmt = $db->prepare("INSERT INTO application_ability (application_id, language_id) VALUES (?, ?)");
                $stmt->execute([$application_id, $language_id]);
            }

            echo 'Данные успешно сохранены в базе данных!';
        } catch(PDOException $e) {
            echo 'Ошибка выполнения запроса: ' . $e->getMessage();
        }
    }
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
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 40px;
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        textarea,
        select {
            width: calc(100% - 16px);
            padding: 14px;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #f5f5f5;
            color: #333;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            border-color: #007bff;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            padding: 16px 32px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: #ff0000;
            font-size: 12px;
        }

        .has-error input,
        .has-error select,
        .has-error textarea {
            border-color: #ff0000;
        }

        .error {
            border: 2px solid red;
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
