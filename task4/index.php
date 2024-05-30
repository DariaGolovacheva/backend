<?php
header('Content-Type: text/html; charset=UTF-8');

define("user", "u67498");
define("password", "2427367");
define("dbname", "u67498");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  $errors = array();

  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['phone'] = !empty($_COOKIE['phone_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['dob'] = !empty($_COOKIE['dob_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['language'] = !empty($_COOKIE['language_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['contract'] = !empty($_COOKIE['contract_error']);

  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    setcookie('name_value', '', 100000);
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['phone']) {
      setcookie('phone_error', '', 100000);
      setcookie('phone_value', '', 100000);
      $messages[] = '<div class="error">Заполните поле номера телефона.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    setcookie('email_value', '', 100000);
    $messages[] = '<div class="error">Заполните поле email.</div>';
  }
  if ($errors['dob']) {
      setcookie('dob_error', '', 100000);
      setcookie('dob_value', '', 100000);
      $messages[] = '<div class="error">Укажите дату рождения.</div>';
  }
   if ($errors['sex']) {
         setcookie('gender_error', '', 100000);
         setcookie('gender_value', '', 100000);
         $messages[] = '<div class="error">Заполните пол.</div>';
      }
      if ($errors['language']) {
            setcookie('language_error', '', 100000);
            setcookie('language_value', '', 100000);
            $messages[] = '<div class="error">Выберете языки.</div>';
         }

   if ($errors['biography']) {
        setcookie('bio_error', '', 100000);
        setcookie('bio_value', '', 100000);
        $messages[] = '<div class="error">Заполните поле биографии.</div>';
      }
      if ($errors['contract']) {
              setcookie('contract_error', '', 100000);
              setcookie('contract_value', '', 100000);
              $messages[] = '<div class="error">Поставьте галочку.</div>';
            }


  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['dob'] = empty($_COOKIE['dob_value']) ? '' : $_COOKIE['dob_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['language'] = empty($_COOKIE['language_value']) ? '' : $_COOKIE['language_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['contract'] = empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'];



  include('form.php');
}

else {
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


if (empty($_POST['language'])) {
      setcookie('language_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    } else {
        // Преобразование массива в строку для сохранения в cookie
        $favoriteLanguage_value = implode(',', $_POST['language']);
        setcookie('language_value', $language_value, time() + 30 * 24 * 60 * 60);
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
  }
  else {
    setcookie('name_error', '', 100000);
    setcookie('phone_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('dob_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('language_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('contract_error', '', 100000);
  }

    $user = user;
    $pass = password;
    $db = new PDO('mysql:host=localhost;dbname=' . dbname, $user, $pass, [
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

      $stmt = $db->prepare("INSERT INTO application_ability (applicationId, programming_languageId) VALUES (:applicationId, :programming_languageId)");

      foreach ($_POST['language'] as $selectedOption) {
        $languageStmt = $db->prepare("SELECT programming_languageId FROM language WHERE title = :title");
        $languageStmt->execute([':title' => $selectedOption]);
        $language = $languageStmt->fetch(PDO::FETCH_ASSOC);

        $stmt->execute([
          ':applicationId' => $applicationId,
          ':programming_languageId' => $language['programming_languageId']
        ]);
      }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }

  setcookie('save', '1');

  header('Location: index.php');
}
