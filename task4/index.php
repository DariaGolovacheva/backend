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

    // Проверка корректности заполнения поля ФИО с использованием регулярного выражения.
    $fio = $_POST['fio'] ?? '';
    if (!validate_fio($fio)) {
        $messages[] = '<div class="error">Поле ФИО должно содержать только буквы и пробелы.</div>';
        // Сохранение информации об ошибке в Cookies.
        setcookie('fio_error', '1', 0, '/');
    } else {
        // Очистка информации об ошибке в Cookies.
        setcookie('fio_error', '', time() - 3600, '/');
        // Сохранение значения поля ФИО в Cookies на один год.
        setcookie('fio_value', $fio, time() + 31536000, '/');
    }

    // Проверка корректности заполнения поля email с использованием регулярного выражения.
    $email = $_POST['email'] ?? '';
    if (!validate_email($email)) {
        $messages[] = '<div class="error">Некорректный формат email адреса.</div>';
        // Сохранение информации об ошибке в Cookies.
        setcookie('email_error', '1', 0, '/');
    } else {
        // Очистка информации об ошибке в Cookies.
        setcookie('email_error', '', time() - 3600, '/');
        // Сохранение значения поля email в Cookies на один год.
        setcookie('email_value', $email, time() + 31536000, '/');
    }

    // Если есть ошибки, перезагружаем страницу.
    if (!empty($messages)) {
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
        $stmt = $pdo->prepare("INSERT INTO users (fio, email) VALUES (:fio, :email)");

        // Привязываем значения параметров к значениям переменных.
        $stmt->bindParam(':fio', $fio);
        $stmt->bindParam(':email', $email);

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
    if (!empty($_COOKIE['fio_error'])) {
        $messages[] = '<div class="error">Поле ФИО должно содержать только буквы и пробелы.</div>';
    }

    // Если есть Cookies с информацией об ошибке в поле email, добавляем сообщение в массив сообщений.
    if (!empty($_COOKIE['email_error'])) {
        $messages[] = '<div class="error">Некорректный формат email адреса.</div>';
    }

    // Значение поля ФИО по умолчанию - значение из Cookies, если есть.
    $fio_value = $_COOKIE['fio_value'] ?? '';
    // Значение поля email по умолчанию - значение из Cookies, если есть.
    $email_value = $_COOKIE['email_value'] ?? '';

    // Выводим форму.
    ?>
    <html>
      <head>
        <style>
          /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
          .error {
            border: 2px solid red;
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
        <input name="fio" value="<?php echo htmlspecialchars($fio_value); ?>" />
        <input name="email" value="<?php echo htmlspecialchars($email_value); ?>" />
        <input type="submit" value="Отправить" />
      </form>
      </body>
    </html>
    <?php
}

// Функция для валидации поля ФИО.
function validate_fio($fio) {
    // Регулярное выражение для проверки ФИО: только буквы и пробелы.
    return preg_match('/^[a-zA-Zа-яА-Я\s]+$/', $fio);
}

// Функция для валидации поля email.
function validate_email($email) {
    // Регулярное выражение для проверки email адреса.
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
?>
