<?php
header('Content-Type: text/html; charset=UTF-8');

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    // Пример простой валидации для телефона (можно доработать по необходимости)
    return preg_match("/^\+?\d{1,3}\s?\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{2}[-\s]?\d{2}$/", $phone);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['name_len'] = !empty($_COOKIE['name_error_len']);
  $errors['name_struct'] = !empty($_COOKIE['name_error_struct']);
  $errors['phone'] = !empty($_COOKIE['phone_error']);
  $errors['phone_struct'] = !empty($_COOKIE['phone_error_struct']);
  $errors['phone_len'] = !empty($_COOKIE['phone_error_len']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['email_struct'] = !empty($_COOKIE['email_error_struct']);
  $errors['email_len'] = !empty($_COOKIE['email_error_len']);
  $errors['data'] = !empty($_COOKIE['data_error']);
  $errors['data_struct'] = !empty($_COOKIE['data_error_struct']);
  $errors['pol'] = !empty($_COOKIE['pol_error']);
  $errors['pol_struct'] = !empty($_COOKIE['pol_error_struct']);
  $errors['ok'] = !empty($_COOKIE['ok_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['abilities_struct'] = !empty($_COOKIE['abilities_error_struct']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['bio_len'] = !empty($_COOKIE['bio_error_len']);
  
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    setcookie('name_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error"> Введите ФИO.</div>';
  }

    if($errors['name_struct']) {
    setcookie('name_error_struct', '', 100000);
    setcookie('name_value', '', 100000);
    $messages[] = '<div class="error">Неправильный формат ФИО.</div>';
  }
    if ($errors['phone']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('phone_error', '', 100000);
    setcookie('phone_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Введите номер телефона.</div>';
  }
  if($errors['phone_len']) {
    setcookie('phone_error_len', '', 100000);
    setcookie('phone_value', '', 100000);
    $messages[] = '<div class="error">Неправильный формат номера телефона.</div>';
  }
  
    if ($errors['email']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    setcookie('email_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Введите email.</div>';
  }

    if($errors['email_struct']) {
    setcookie('email_error_struct', '', 100000);
    setcookie('email_value', '', 100000);
    $messages[] = '<div class="error">Неправильный формат email.</div>';
  }
      if ($errors['data']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('data_error', '', 100000);
    setcookie('data_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Введите дату рождения.</div>';
  }
  if($errors['data_struct']) {
    setcookie('data_error_struct', '', 100000);
    setcookie('data_value', '', 100000);
    $messages[] = '<div class="error">Неправильный формат даты рождения.</div>';
  }
        if ($errors['contract']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('ok_error', '', 100000);
    setcookie('ok_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Необходимо ознакомиться с контрактом.</div>';
  }
        if ($errors['gender']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('pol_error', '', 100000);
    setcookie('pol_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Укажите ваш пол.</div>';
  }

    if ($errors['favouriteLanguage']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('abilities_error', '', 100000);
    setcookie('abilities_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите хотя бы один язык программирования.</div>';
  }
 
      if ($errors['bio']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('bio_error', '', 100000);
    setcookie('bio_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Введите вашу биографию.</div>';
  }

  
  
  
  
  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['data'] = empty($_COOKIE['data_value']) ? '' : $_COOKIE['data_value'];
  $values['pol'] = empty($_COOKIE['pol_value']) ? '' : $_COOKIE['pol_value'];
 $values['abilities'] = isset($_COOKIE['abilities_value']) ? unserialize($_COOKIE['abilities_value']) : [];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['ok'] = empty($_COOKIE['ok_value']) ? '' : $_COOKIE['ok_value'];

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $errors = FALSE;
    // Валидация ФИО
    if (empty($_POST['name'])) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
          $errors = true;
    } elseif (!preg_match('/^[a-zA-Zа-яА-Я\s]{1,150}$/', $_POST['name'])) {
       
    }

    // Валидация email
    if (empty($_POST['email'])) {
       
    } elseif (!validate_email($_POST['email'])) {
      
    }

    // Валидация телефона
    if (empty($_POST['phone'])) {
       
    } elseif (!validate_phone($_POST['phone'])) {

    }

    // Валидация даты рождения
    if (empty($_POST['dob'])) {
     
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['dob'])) {
       
    }

    // Валидация пола
    if (empty($_POST['gender'])) {
        
    }

    // Валидация биографии
    if (empty($_POST['bio'])) {
       
    }

    // Валидация контракта
    if (!isset($_POST['contract'])) {
      
    }

    // Валидация выбранного языка программирования
    if (empty($_POST['favoriteLanguage'])) {
      
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

        
        // Сохранение значений в Cookies
        $cookieExpiration = time() + (365 * 24 * 60 * 60); // На год
        setcookie('name', $name, $cookieExpiration);
        setcookie('email', $email, $cookieExpiration);
        setcookie('phone', $phone, $cookieExpiration);
        setcookie('dob', $dob, $cookieExpiration);
        setcookie('gender', $gender, $cookieExpiration);
        setcookie('bio', $bio, $cookieExpiration);
        setcookie('favoriteLanguages',  serialize($favoriteLanguages), $cookieExpiration);
        // Подключение к базе данных
        $user = 'u67498';
        $pass = '2427367';
        $dbname = 'u67498';
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

             try {
            // Вставка данных в таблицу application
            $stmt = $db->prepare("INSERT INTO application (name, email, phone, dob, gender, bio, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $dob, $gender, $bio, $contract]);
            
            // Получение ID вставленной записи
            $application_id = $db->lastInsertId();

            // Сохранение выбранных языков программирования в таблицу programming_language (если они еще не существуют)
            foreach ($_POST['favoriteLanguage'] as $language) {
                $stmt = $db->prepare("INSERT IGNORE INTO programming_language (name) VALUES (?)");
                $stmt->execute([$language]);
            }

            // Получение идентификаторов языков программирования из таблицы programming_language
            $stmt = $db->prepare("SELECT id FROM programming_language WHERE name IN (" . implode(',', array_fill(0, count($_POST['favoriteLanguage']), '?')) . ")");
$stmt->execute($_POST['favoriteLanguage']);

            $language_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Вставка данных в таблицу application_ability
            foreach ($language_ids as $language_id) {
                $stmt = $db->prepare("INSERT INTO application_ability (application_id, language_id) VALUES (?, ?)");
                $stmt->execute([$application_id, $language_id]);
            }

            echo 'Данные успешно сохранены в базе данных!';
        } catch(PDOException $e) {
            echo 'Ошибка выполнения запроса: ' . $e->getMessage();
        }
    }
}

// Проверяем наличие ошибок в Cookies и удаляем их
$errorsFromCookies = [];
foreach ($_COOKIE as $key => $value) {
    if (strpos($key, '_error') !== false) {
        $field = str_replace('_error', '', $key);
        $errorsFromCookies[$field] = $value;
        setcookie($key, '', time() - 3600); // Удаление Cookie
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрационная форма</title>
<link rel="stylesheet" href="styles.css">
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
</style>
</head>
<body>

<div class="container">
  <h2>Регистрационная форма</h2>
  <label>
      ФИО:<br />
      <input 
      name="name" style = "width: calc(100% - 18px);
padding: 8px;
margin-bottom: 20px;
border: 1px solid #1c87c9;
outline: none;"
      placeholder="Введите ваше ФИО" <?php if ($errors['name'] || $errors['name_struct'] ) {print 'class="error"';} ?> value="<?php print $values['name']; ?>"/>
    <label>
    Телефон:<br />
    <input  style = "width: calc(100% - 18px);
padding: 8px;
margin-bottom: 20px;
border: 1px solid #1c87c9;
outline: none;" name="phone"
      type="tel"
      placeholder="Введите ваш телефон" <?php if ($errors['phone']  || $errors['phone_len'] ) {print 'class="error"';} ?> value="<?php print $values['phone']; ?>"/>
  </label><br />
  <label>
    Email:<br />
    <input  style = "width: calc(100% - 18px);
padding: 8px;
margin-bottom: 20px;
border: 1px solid #1c87c9;
outline: none;" name="email"
      placeholder="Введите вашу почту" <?php if ($errors['email'] || $errors['email_struct']  ) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"/></label>
      <label>
        <br />
        Дата рождения:<br />
        <input style = "width: calc(100% - 18px);
padding: 8px;
margin-bottom: 20px;
border: 1px solid #1c87c9;
outline: none;" name="data"
          type="date" value="<?php echo isset($values['data']) ? $values['data'] : '2000-01-01'; ?>"
    type="date" <?php if ($errors['data']) {echo 'class="error"';} ?>/>
      </label>
Пол:<br />
<label><input type="radio" 
    name="pol" value="M" <?php if ($values['gender'] === 'M') {echo 'checked';} ?> <?php if ($errors['gender'] || $errors['gender_struct']) {echo 'class="error"';} ?>/>
    Мужской</label>
<label><input type="radio"
    name="pol" value="W" <?php if ($values['gender'] === 'W') {echo 'checked';} ?> <?php if ($errors['gender'] || $errors['gender_struct']) {echo 'class="error"';} ?>/>
    Женский</label><br />
                <br />
      Любимый язык программирования:
      <br />
    </label><br />
  <select style="width: calc(100% - 18px); padding: 8px; margin-bottom: 20px; border: 1px solid #1c87c9; outline: none;" name="abilities[]" multiple="multiple" <?php if ($errors['favouriteLanguage']) {echo 'class="error"';} 
$abilities_array = is_array($values['favouriteLanguage']) ? $values['favouriteLanguage'] : [];
  ?>>
    <option disabled>Выберите любимый язык пр.</option>
    <option value="Pascal" <?php if(in_array('Pascal', $abilities_array)) {echo 'selected';}?>>Pascal</option>
    <option value="C" <?php if(in_array('C', $abilities_array)) {echo 'selected';} ?>>C</option>
    <option value="C++" <?php if(in_array('C++', $abilities_array)) {echo 'selected';} ?>>C++</option>
    <option value="JavaScript" <?php if(in_array('JavaScript', $abilities_array)) {echo 'selected';} ?>>JavaScript</option>
    <option value="PHP" <?php if(in_array('PHP', $abilities_array)) {echo 'selected';} ?>>PHP</option>
    <option value="Python" <?php if(in_array('Python', $abilities_array)) {echo 'selected';} ?>>Python</option>
    <option value="Java" <?php if(in_array('Java', $abilities_array)) {echo 'selected';} ?>>Java</option>
    <option value="Haskel"<?php if (in_array('Haskel', $abilities_array)) { echo ' selected'; } ?>>Haskel</option>
</select>
    <label>
      Биография:<br />
     <textarea style="width: calc(100% - 18px); padding: 8px; margin-bottom: 20px; border: 1px solid #1c87c9; outline: none;" name="bio" placeholder="<?php print $values['bio']; ?>" <?php if ($errors['bio'] || $errors['bio_len']) { print 'class="error"'; } ?>><?php print $values['bio']; ?></textarea>
<label><input type="checkbox"
    name="ok" <?php if ($values['contract'] === 'on') {echo 'checked';} ?> <?php if ($errors['contract']) {echo 'class="error"';} ?>/>    С контрактом ознакомлен(а)</label>
    <br />
<button type="submit" href="/">Сохранить</button>
</form>
</div>
</body>
</html>
