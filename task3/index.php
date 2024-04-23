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
    $errors[] = 'Заполните ФИО.';
}

// Валидация email
if (!empty($_POST['email']) && !validate_email($_POST['email'])) {
    $errors[] = 'Введите корректный email.';
}

// Валидация телефона
if (!empty($_POST['phone']) && !validate_phone($_POST['phone'])) {
    $errors[] = 'Введите корректный номер телефона.';
}
// вадидация ФИО
if (empty($_POST['name'])) {
    $errors[] = 'Заполните ФИО.';
}elseif(!preg_match("/^[а-яА-яЁёя-zA-Z\s]+$/u",$_POST['name'])){
    $errors[]='ФИО должно содержать только буквы и пробелы';
    }elseif (strlen($_POST['name']>150)){
             $errors[]='ФИО не должно превышать 150 символов';
             }
             

//валидация даты рождения 
if (empty($_POST['dob'])){
    $errors[]='заполните дату рождения';
    }else {
    $dob=$_POST['dob'];
$dob_timestamp=strtotime($dob);
if($dob_timestamp==false){
    $errors='некорректный ввод даты рождения';
}else{
    $min_age=18;
    $min_dob_timestamp=strtotime("-$min_age years");
    if($dob_timestamp > $min_dob_timestamp){
        $errors[]='вы должны  быть старше'.$min_age.'лет';
    }
}
}

// Другие валидации для остальных полей формы

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . '<br>';
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
    $stmt->execute([$_POST['name'], $_POST['phone'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['bio'], isset($_POST['contract'])? 1:0]);

    // Получение ID вставленной записи
    $application_id = $db->lastInsertId();

    // Вставка данных в таблицу application_ability
    foreach ($_POST['abilities'] as $ability) {
        $stmt = $db->prepare("INSERT INTO application_ability (application_id, language_id) VALUES (?, ?)");
        $stmt->execute([$application_id, $ability]);
    }

    // Перенаправление с сообщением об успешном сохранении
    header('Location: ?save=1');
} catch(PDOException $e) {
    echo 'Ошибка выполнения запроса: ' . $e->getMessage();
    // Здесь можно предоставить дополнительную информацию или инструкции для пользователя
    exit();
}
?>
