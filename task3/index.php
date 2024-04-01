<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('Спасибо, результаты сохранены.');
    }
    include('form.php');
    exit();
}

$errors = FALSE;

if (empty($_POST['name'])) {
    print('Заполните ФИО.<br/>');
    $errors = TRUE;
}

// Проверка остальных полей, включая валидацию email, даты рождения и других полей.

if ($errors) {
    exit();
}


$user = 'u67498';
$pass = '2427367'; 
$dbname = 'u67498'; 
$db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Вставка данных в таблицу application
    $stmt = $db->prepare("INSERT INTO application (name, phone, email, dob, gender, bio, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['phone'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['bio'], isset($_POST['contract']) ? 1 : 0]);
    
    // Получаем ID вставленной записи
    $application_id = $db->lastInsertId();

    // Вставка данных в таблицу application_ability
    foreach ($_POST['abilities'] as $ability) {
        $stmt = $db->prepare("INSERT INTO application_ability (application_id, language_id) VALUES (?, ?)");
        $stmt->execute([$application_id, $ability]);
    }

    // Перенаправление с сообщением об успешном сохранении
    header('Location: ?save=1');
} catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}
?>
