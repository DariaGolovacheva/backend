<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Подключение к базе данных
include('../db.php');
try {
    $db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    // Обработка ошибки подключения к базе данных
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверка наличия всех обязательных полей в форме
    $required_fields = ['name', 'phone', 'email', 'dob', 'favoriteLanguage', 'bio', 'contract'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "Не заполнено поле $field";
        }
    }

    if (!empty($errors)) {
        // Если есть ошибки, установка куки с сообщением об ошибке
        setcookie('form_errors', implode(', ', $errors), time() + 24 * 60 * 60);
        header('Location: index.php');
        exit();
    }

    // Подготовленный запрос для вставки данных в таблицу application
    $stmt = $db->prepare("INSERT INTO application (name, phone, email, dob, favoriteLanguages, bio, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $favoriteLanguages = implode(', ', $_POST['favoriteLanguage']);
    $stmt->execute([$_POST['name'], $_POST['phone'], $_POST['email'], $_POST['dob'], $favoriteLanguages, $_POST['bio'], $_POST['contract']]);

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

    // Установка куки с признаком успешного сохранения
    setcookie('save', '1', time() + 24 * 60 * 60);

    // Перенаправление на страницу индекса
    header('Location: index.php');
    exit();
}

// Если запрос методом GET, проверяем наличие ошибок формы и выводим их пользователю
if (!empty($_COOKIE['form_errors'])) {
    $messages[] = '<div class="error">' . $_COOKIE['form_errors'] . '</div>';
    setcookie('form_errors', '', time() - 3600); // Удаляем куку с ошибками формы
}

// Включаем содержимое файла form.php
// include('form.php');
?>
