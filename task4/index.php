<?php
header('Content-Type: text/html; charset=UTF-8');

define("USER", "u67498");
define("PASSWORD", "2427367");
define("DBNAME", "u67498");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();

    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
    }

    $errors = array(
        'name' => !empty($_COOKIE['name_error']),
        'phone' => !empty($_COOKIE['phone_error']),
        'email' => !empty($_COOKIE['email_error']),
        'dob' => !empty($_COOKIE['dob_error']),
        'gender' => !empty($_COOKIE['gender_error']),
        'favoriteLanguage' => !empty($_COOKIE['favoriteLanguage_error']),
        'bio' => !empty($_COOKIE['bio_error']),
        'contract' => !empty($_COOKIE['contract_error']),
    );

    foreach ($errors as $field => $isError) {
        if ($isError) {
            setcookie($field . '_error', '', 100000);
            setcookie($field . '_value', '', 100000);
            $messages[] = '<div class="error">Заполните поле ' . $field . '.</div>';
        }
    }

    $values = array(
        'name' => empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'],
        'phone' => empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'],
        'email' => empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'],
        'dob' => empty($_COOKIE['dob_value']) ? '' : $_COOKIE['dob_value'],
        'gender' => empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'],
        'favoriteLanguage' => empty($_COOKIE['favoriteLanguage_value']) ? '' : $_COOKIE['favoriteLanguage_value'],
        'bio' => empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'],
        'contract' => empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'],
    );

    include('form.php');
} else {
    $errors = FALSE;

    if (empty($_POST['name']) || !preg_match('/^([А-Яа-я\s]+|[A-Za-z\s]+)$/', $_POST['name'])) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['phone']) || strlen($_POST['phone']) > 32 || !preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $_POST['phone'])) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['email']) || !preg_match('/^[\w_\.]+@([\w-]+\.)+[\w-]{2,4}$/', $_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['dob'])) {
        setcookie('dob_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('dob_value', $_POST['dob'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['favoriteLanguage'])) {
        setcookie('favoriteLanguage_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $language_value = implode(',', $_POST['favoriteLanguage']);
        setcookie('favoriteLanguage_value', $favoriteLanguage_value, time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['bio']) || strlen($_POST['bio']) > 256) {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['contract'])) {
        setcookie('contract_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('contract_value', $_POST['contract'], time() + 30 * 24 * 60 * 60);
    }

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        foreach (array_keys($errors) as $field) {setcookie($field . '_error', '', 100000);
        }
    }

    $user = USER;
    $pass = PASSWORD;
    $db = new PDO('mysql:host=localhost;dbname=' . DBNAME, $user, $pass, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    try {
        $stmt = $db->prepare("INSERT INTO application (name, email, phone, dob, gender, bio) VALUES (:name, :email, :phone, :dob, :gender, :bio)");
        $stmt->execute([
            ':name' => $_POST['name'],
            ':phone' => $_POST['phone'],
            ':email' => $_POST['email'],
            ':dob' => $_POST['dob'],
            ':gender' => $_POST['gender'],
            ':bio' => $_POST['bio']
        ]);

        $applicationId = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO application_ability (application_Id, language_Id) VALUES (:application_Id, :language_Id)");

        foreach ($_POST['favoriteLanguage'] as $selectedOption) {
            $languageStmt = $db->prepare("SELECT id FROM programming_language WHERE title = :title"); // Assuming the primary key is 'id'
            $languageStmt->execute([':title' => $selectedOption]);
            $language = $languageStmt->fetch(PDO::FETCH_ASSOC);

            if ($language) {
                $stmt->execute([
                    ':application_Id' => $application_Id,
                    ':language_Id' => $language['id']
                ]);
            }
        }
    } catch(PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }

    setcookie('save', '1');
    header('Location: index.php');
}
?>
