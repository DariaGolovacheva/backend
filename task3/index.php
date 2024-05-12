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
       // Подключение к базе данных
$user = 'u67498';
$pass = '2427367';
$dbname = 'u67498';
$db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Сохранение выбранных языков программирования в таблицу programming_language (если они еще не существуют)
    foreach ($_POST['favoriteLanguage'] as $language) {
        $stmt = $db->prepare("INSERT IGNORE INTO programming_language (name) VALUES (?)");
        $stmt->execute([$language]);
    }

    // Получение идентификаторов языков программирования из таблицы programming_language
    $stmt = $db->prepare("SELECT id, name FROM programming_language WHERE name IN (?)");
    $stmt->execute([$_POST['favoriteLanguage']]);
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Вставка данных в таблицу application_ability
    $application_id = $db->lastInsertId();
    foreach ($languages as $language) {
        $stmt = $db->prepare("INSERT INTO application_ability (application_id, language_id) VALUES (?, ?)");
        $stmt->execute([$application_id, $language['id']]);
    }

    echo 'Данные успешно сохранены в базе данных!';
} catch(PDOException $e) {
    echo 'Ошибка выполнения запроса: ' . $e->getMessage();
}
    
}
} 


