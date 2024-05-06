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
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        echo 'Спасибо, результаты сохранены.';
    }
    include('form.php');
    exit();
}

// Валидация данных
if (empty($_POST['name'])) {
    $errors[] = 'Введите ФИО.';
} elseif (!preg_match('/^[a-zA-Zа-яА-Я\s]{1,150}$/', $_POST['name'])) {
    $errors[] = 'Неправильный формат ФИО.';
}

if (empty($_POST['email'])) {
    $errors[] = 'Введите email.';
} elseif (!validate_email($_POST['email'])) {
    $errors[] = 'Неправильный формат email.';
}

if (empty($_POST['phone'])) {
    $errors[] = 'Введите номер телефона.';
} elseif (!validate_phone($_POST['phone'])) {
    $errors[] = 'Неправильный формат номера телефона.';
}

if (empty($_POST['dob'])) {
    $errors[] = 'Введите дату рождения.';
} elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['dob'])) {
    $errors[] = 'Неправильный формат даты рождения.';
} else {
    list($year, $month, $day) = explode('-', $_POST['dob']);
    if (!checkdate($month, $day, $year)) {
        $errors[] = 'Неправильная дата рождения.';
    }
}

if (empty($_POST['gender'])) {
    $errors[] = 'Укажите ваш пол.';
}

if (empty($_POST['bio'])) {
    $errors[] = 'Введите вашу биографию.';
}

if (empty($_POST['abilities'])) {
    $errors[] = 'Выберите хотя бы один навык.';
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    exit();
}

$user = 'u67498';
$pass = '2427367';
$dbname = 'u67498';
$db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Вставка данных в таблицу applicationn
    $stmt = $db->prepare("INSERT INTO applicationn (name, phone, email, dob, gender, bio, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['phone'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['bio'], isset($_POST['contract']) ? 1 : 0]);

    // Получение ID вставленной записи
    $application_id = $db->lastInsertId();

    // Вставка данных в таблицу application_ability
    foreach ($_POST['abilities'] as $ability) {
        $stmt = $db->prepare("INSERT INTO application_ability (application_id, language_id) VALUES (?, ?)");
        $stmt->execute([$application_id, $ability]);
    }

    // Перенаправление с сообщением об успешном сохранении
    header('Location: ?save=1');
} catch (PDOException $e) {
    echo 'Ошибка выполнения запроса: ' . $e->getMessage();
    // Здесь можно предоставить дополнительную информацию или инструкции для пользователя
    exit();
}
?>
