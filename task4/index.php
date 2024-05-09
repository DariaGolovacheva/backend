<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Проверяем, был ли запрос методом GET или POST
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Массив для временного хранения сообщений пользователю.
    $messages = array();

    // Проверяем, была ли установлена кука с сообщением об успешном сохранении
    if (!empty($_COOKIE['save'])) {
        // Удаляем куку, чтобы она больше не отображалась
        setcookie('save', '', 100000);
        // Если есть параметр save, то выводим сообщение пользователю
        $messages[] = 'Спасибо, результаты сохранены.';
    }

    // Складываем признаки ошибок в массив
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['dob'] = !empty($_COOKIE['dob_error']);
    $errors['favoriteLanguage'] = !empty($_COOKIE['favoriteLanguage_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['contract'] = !empty($_COOKIE['contract_error']);

    // Выдаем сообщения об ошибках
    if ($errors['name']) {
        setcookie('name_error', '', 100000);
        setcookie('name_value', '', 100000);
        $messages[] = '<div class="error">Заполните ФИО.</div>';
    }
    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        setcookie('phone_value', '', 100000);
        $messages[] = '<div class="error">Заполните телефон.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Заполните email.</div>';
    }
    if ($errors['dob']) {
        setcookie('dob_error', '', 100000);
        setcookie('dob_value', '', 100000);
        $messages[] = '<div class="error">Заполните дату рождения.</div>';
    }
    if ($errors['favoriteLanguage']) {
        setcookie('favoriteLanguage_error', '', 100000);
        setcookie('favoriteLanguage_value', '', 100000);
        $messages[] = '<div class="error">Выберите хотя бы один язык программирования.</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        setcookie('bio_value', '', 100000);
        $messages[] = '<div class="error">Заполните биографию.</div>';
    }
    if ($errors['contract']) {
        setcookie('contract_error', '', 100000);
        setcookie('contract_value', '', 100000);
        $messages[] = '<div class="error">Необходимо ознакомиться с контрактом.</div>';
    }

    // Складываем предыдущие значения полей в массив, если они были сохранены в куки
    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['dob'] = empty($_COOKIE['dob_value']) ? '' : $_COOKIE['dob_value'];
    $values['favoriteLanguage'] = empty($_COOKIE['favoriteLanguage_value']) ? '' : $_COOKIE['favoriteLanguage_value'];
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['contract'] = empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'];

    // Включаем содержимое файла form.php
    // include('form.php');
} else {
    // Проверяем ошибки
    $errors = false;
    if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['dob']) || empty($_POST['favoriteLanguage']) || empty($_POST['bio']) || empty($_POST['contract'])) {
        // Выдаем куку на день с флажком об ошибке в нужных полях
        if (empty($_POST['name'])) {
            setcookie('name_error', '1', time() + 24 * 60 * 60);
        }
        if (empty($_POST['phone'])) {
            setcookie('phone_error', '1', time() + 24 * 60 * 60);
        }
        if (empty($_POST['email'])) {
            setcookie('email_error', '1', time() + 24 * 60 * 60);
        }
        if (empty($_POST['dob'])) {
            setcookie('dob_error', '1', time() + 24 * 60 * 60);
        }
        if (empty($_POST['favoriteLanguage'])) {
            setcookie('favoriteLanguage_error', '1', time() + 24 * 60 * 60);
        }
        if (empty($_POST['bio'])) {
            setcookie('bio_error', '1', time() + 24 * 60 * 60);
        }
        if (empty($_POST['contract'])) {
            setcookie('contract_error', '1', time() + 24 * 60 * 60);
        }

        $errors = true;
    }

    // Сохраняем ранее введенное в форму значение на месяц
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
    setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    setcookie('dob_value', $_POST['dob'], time() + 30 * 24 * 60 * 60);
    setcookie('favoriteLanguage_value', implode(', ', $_POST['favoriteLanguage']), time() + 30 * 24 * 60 * 60);
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
    setcookie('contract_value', $_POST['contract'], time() + 30 * 24 * 60 * 60);

    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта
        header('Location: index.php');
        exit();
    } else {
        // Удаляем Cookies с признаками ошибок
        setcookie('name_error', '', 100000);
        setcookie('phone_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('dob_error', '', 100000);
        setcookie('favoriteLanguage_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('contract_error', '', 100000);
    }

    // Вставляем данные в базу данных
    try {
        // Подключение к базе данных
        include('../db.php');
        $db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Подготовленный запрос для вставки данных в таблицу application
        $stmt = $db->prepare("INSERT INTO application (name, phone, email, dob, favoriteLanguages, bio, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['phone'], $_POST['email'], $_POST['dob'], implode(', ', $_POST['favoriteLanguage']), $_POST['bio'], $_POST['contract']]);

        // Получаем ID последней вставленной записи
        $lastId = $db->lastInsertId();

        // Вставляем данные в связанную таблицу ap_lan
        foreach ($_POST['favoriteLanguage'] as $language) {
            $stmtLang = $db->prepare("SELECT id FROM language WHERE name = ?");
            $stmtLang->execute([$language]);
            $languageId = $stmtLang->fetchColumn();

            $stmtApLang = $db->prepare("INSERT INTO ap_lan (id_application, id_language) VALUES (?, ?)");
            $stmtApLang->execute([$lastId, $languageId]);
        }
    } catch (PDOException $e) {
        // В случае ошибки выводим сообщение об ошибке
        print('Error : ' . $e->getMessage());
        exit();
    }

    // Сохраняем куку с признаком успешного сохранения
    setcookie('save', '1');

    // Делаем перенаправление
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
      <input type="text" id="fullName" name="name" value="<?php echo htmlspecialchars($_COOKIE['name']); ?>">
      <?php echo isset($_COOKIE['name_error']) ? '<span class="error">' . $_COOKIE['name_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['phone_error']) ? 'has-error' : ''; ?>">
      <label for="phone">Телефон:</label>
      <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($_COOKIE['phone']); ?>">
      <?php echo isset($_COOKIE['phone_error']) ? '<span class="error">' . $_COOKIE['phone_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['email_error']) ? 'has-error' : ''; ?>">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_COOKIE['email']); ?>">
      <?php echo isset($_COOKIE['email_error']) ? '<span class="error">' . $_COOKIE['email_error'] . '</span>' : ''; ?>
    </div>
    <div class="form-group <?php echo isset($_COOKIE['dob_error']) ? 'has-error' : ''; ?>">
      <label for="dob">Дата рождения:</label>
      <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($_COOKIE['dob']); ?>">
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
      <textarea id="bio" name="bio" rows="5"><?php echo htmlspecialchars($_COOKIE['bio']); ?></textarea>
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
