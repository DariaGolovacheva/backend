<?php
/**
 * Реализация проверки заполнения обязательных полей формы с использованием Cookies,
 * валидации всех полей формы на бекэнде, и сохранение значений в Cookies на один год
 * после успешного заполнения формы. Затем данные сохраняются в базу данных.
 */

// Установка правильной кодировки.
header('Content-Type: text/html; charset=UTF-8');

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Массив для временного хранения сообщений пользователю.
    $messages = array();

    // Валидация ФИО
    if (empty($_POST['name'])) {
        $errors[] = 'Введите ФИО.';
    } elseif (!preg_match('/^[a-zA-Zа-яА-Я\s]{1,150}$/', $_POST['name'])) {
        $errors[] = 'Неправильный формат ФИО.';
    }

    // Валидация email
    if (empty($_POST['email'])) {
        $errors[] = 'Введите email.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Неправильный формат email.';
    }

    // Валидация телефона
    if (empty($_POST['phone'])) {
        $errors[] = 'Введите номер телефона.';
    } elseif (!preg_match('/^\+?\d{10,15}$/', $_POST['phone'])) {
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
    if (empty($_POST['contract'])) {
        $errors[] = 'Необходимо ознакомиться с контрактом.';
    }

    // Валидация выбранного языка программирования
    if (empty($_POST['favoriteLanguage'])) {
        $errors[] = 'Выберите хотя бы один язык программирования.';
    }

    // Если есть ошибки, перезагружаем страницу.
    if (!empty($errors)) {
        header('Location: index.php');
        exit;
    }

    // Если ошибок нет, сохраняем данные в базу данных.
    $user = 'u67498';
    $pass = '2427367';
    $dbname = 'u67498';
    $db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    try {
        $pdo = new PDO($dsn, $username, $password);
        // Устанавливаем режим ошибок PDO на исключения.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Подготавливаем SQL запрос для вставки данных.
        $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, dob, gender, bio, contract, favorite_languages) VALUES (:name, :email, :phone, :dob, :gender, :bio, :contract, :favoriteLanguages)");

        // Привязываем значения параметров к значениям переменных.
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':phone', $_POST['phone']);
        $stmt->bindParam(':dob', $_POST['dob']);
        $stmt->bindParam(':gender', $_POST['gender']);
        $stmt->bindParam(':bio', $_POST['bio']);
        $stmt->bindParam(':contract', $_POST['contract']);
        $stmt->bindParam(':favoriteLanguages', implode(', ', $_POST['favoriteLanguage']));

        // Выполняем запрос.
        $stmt->execute();

        // Закрываем соединение с базой данных.
        $pdo = null;
    } catch (PDOException $e) {
        // В случае ошибки выводим сообщение об ошибке.
        echo "Ошибка базы данных: " . $e->getMessage();
    }

    // Отправляем куку с признаком успешного заполнения формы.
    setcookie('form_success', '1', 0, '/');

    // Перенаправляем пользователя на страницу успешного заполнения формы.
    header('Location: success.php');
    exit;
}

// Если запрос методом GET, отображаем форму.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Массив для временного хранения сообщений пользователю.
    $messages = array();

    // Если есть Cookies с информацией об ошибке в поле ФИО, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['name_error'])) {
        $messages[] = '<div class="error">Введите ФИО.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле email, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['email_error'])) {
        $messages[] = '<div class="error">Неправильный формат email.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле телефона, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['phone_error'])) {
        $messages[] = '<div class="error">Неправильный формат номера телефона.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле даты рождения, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['dob_error'])) {
        $messages[] = '<div class="error">Неправильный формат даты рождения.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле пола, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['gender_error'])) {
        $messages[] = '<div class="error">Укажите ваш пол.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле биографии, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['bio_error'])) {
        $messages[] = '<div class="error">Введите вашу биографию.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле контракта, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['contract_error'])) {
        $messages[] = '<div class="error">Необходимо ознакомиться с контрактом.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле языка программирования, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['favoriteLanguage_error'])) {
        $messages[] = '<div class="error">Выберите хотя бы один язык программирования.</div>';
    }

    // Значение поля ФИО по умолчанию - значение из Cookies, если есть.
    $name_value = $_COOKIE['name_value'] ?? '';
    // Значение поля email по умолчанию - значение из Cookies, если есть.
    $email_value = $_COOKIE['email_value'] ?? '';
    // Значение поля телефона по умолчанию - значение из Cookies, если есть.
    $phone_value = $_COOKIE['phone_value'] ?? '';
    // Значение поля даты рождения по умолчанию - значение из Cookies, если есть.
    $dob_value = $_COOKIE['dob_value'] ?? '';
    // Значение поля пола по умолчанию - значение из Cookies, если есть.
    $gender_value = $_COOKIE['gender_value'] ?? '';
    // Значение поля биографии по умолчанию - значение из Cookies, если есть.
    $bio_value = $_COOKIE['bio_value'] ?? '';
    // Значение поля контракта по умолчанию - значение из Cookies, если есть.
    $contract_value = $_COOKIE['contract_value'] ?? '';
    // Значение поля выбранных языков программирования по умолчанию - значение из Cookies, если есть.
    $favoriteLanguage_value = $_COOKIE['favoriteLanguage_value'] ?? '';

    // Выводим форму.
    ?>
    <html>
      <head>
        <style>
          /* Стили для формы */
          form {
              margin: 20px auto;
              width: 400px;
              padding: 20px;
              border: 1px solid #ccc;
              border-radius: 5px;
              background-color: #f9f9f9;
          }

          input[type="text"], input[type="email"], input[type="tel"], input[type="date"], select, textarea {
              width: calc(100% - 22px);
              padding: 10px;
              margin: 5px 0;
              border: 1px solid #ccc;
              border-radius: 5px;
          }

          input[type="submit"] {
              width: 100%;
              background-color: #4CAF50;
              color: white;
              padding: 10px;
              border: none;
              border-radius: 5px;
              cursor: pointer;
          }

          input[type="submit"]:hover {
              background-color: #45a049;
          }

          /* Стили для сообщений об ошибках */
          .error {
              color: red;
              font-weight: bold;
              margin-bottom: 10px;
          }
        </style>
      </head>
      <body>

      <?php
      if (!empty($messages)) {
        print('<div id="messages">');
        // Выводим все сообщения.
        foreach ($messages as $message) {
          print($message);
        }
        print('</div>');
      }
      ?>

      <form action="" method="POST">
        <input type="text" name="name" placeholder="ФИО" value="<?php echo htmlspecialchars($name_value); ?>" />
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email_value); ?>" />
        <input type="tel" name="phone" placeholder="Номер телефона" value="<?php echo htmlspecialchars($phone_value); ?>" />
        <input type="date" name="dob" placeholder="Дата рождения" value="<?php echo htmlspecialchars($dob_value); ?>" />
        <select name="gender">
          <option value="" disabled selected>Выберите пол</option>
          <option value="male" <?php echo ($gender_value === 'male') ? 'selected' : ''; ?>>Мужской</option>
          <option value="female" <?php echo ($gender_value === 'female') ? 'selected' : ''; ?>>Женский</option>
        </select>
        <textarea name="bio" placeholder="Биография"><?php echo htmlspecialchars($bio_value); ?></textarea>
        <input type="checkbox" name="contract" <?php echo ($contract_value) ? 'checked' : ''; ?> /> Я ознаком
