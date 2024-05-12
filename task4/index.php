<?php
function print_error($error)
{
    print($error);
    exit();
}

function validate_data($data)
{
    $errors = [];
    $all_names = ["name", "phone", "email", "dob", "gender", "favoriteLanguage", "bio", "contract"];
    $re_patterns = ['name' => '/^[\w\s]+$/',
        'phone' => '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/',
        'email' => '/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'];
    $size_limits = ['name' => 255, 'email' => 255, 'bio' => 512];
    foreach ($all_names as $name) {
        if (empty($data[$name])) {
            $errors[$name] = "Field {$name} is empty.";
        } elseif (in_array($name, array_keys($size_limits))
            && strlen($data[$name]) > $size_limits[$name]) {
            $errors[$name] = "Length of the contents of the field {$name} more than {$size_limits[$name]} symbols.";
        } elseif (in_array($name, array_keys($re_patterns))
            && !preg_match($re_patterns[$name], $data[$name])) {
            $errors[$name] = "Invalid {$name}.";
        } elseif ($name == 'dob') {
            if (!strtotime($data[$name]) ||
                strtotime('1900-01-01') > strtotime($data[$name]) ||
                strtotime($data[$name]) > time()) {
                $errors[$name] = "Invalid {$name}.";
            }
        }
    }

    if (!empty($errors)) {
        setcookie('errors', serialize($errors), 0);
        setcookie('incor_data', serialize($data), 0);
        header("Location:" . parse_url($_SERVER['REQUEST_URI'])['path'] . "?errors_flag=true");
        exit();
    }
}

function save_to_database($data)
{
    $user = 'u67498';
    $pass = '2427367';
    $dbname = 'u67498';
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Вставляем данные заявки
        $app_req = "INSERT INTO application (name, phone, email, dob, gender, bio) VALUES (:name, :phone, :email, :dob, :gender, :bio)";
        $app_stmt = $db->prepare($app_req);
        $app_stmt->execute([
            ':name' => $data['name'],
            ':phone' => $data['phone'],
            ':email' => $data['email'],
            ':dob' => $data['dob'],
            ':gender' => $data['gender'],
            ':bio' => $data['bio']
        ]);

        // Получаем идентификатор последней вставленной заявки
        $last_app_id = $db->lastInsertId();

        // Вставляем связанные данные в таблицу application_ability
        foreach ($data['favoriteLanguage'] as $lang_id) {
            $ability_req = "INSERT INTO application_ability (application_id, programming_language_id) VALUES (:application_id, :programming_language_id)";
            $ability_stmt = $db->prepare($ability_req);
            $ability_stmt->execute([
                ':application_id' => $last_app_id,
                ':programming_language_id' => $lang_id
            ]);
        }

        // Выводим сообщение об успешной отправке данных
        echo "<p style='color: green; text-align: center;'>Данные успешно отправлены!</p>";
    } catch (PDOException $e) {
        print_error($e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $all_names = ["name", "phone", "email", "dob", "gender", "favoriteLanguage", "bio", "contract"];
    $form_data = array_fill_keys($all_names, "");
    $form_data['favoriteLanguage'] = [];
    foreach ($_POST as $key => $val) {
        if (!empty($val)) {
            if ($key == 'favoriteLanguage') {
                $form_data[$key] = $val;
            } else {
                $form_data[$key] = $val;
            }
        }
    }
    validate_data($form_data);
    save_to_database($form_data);
    setcookie('cor_data', serialize($form_data), time() + 3600 * 24 * 365);
    header("Location:" . parse_url($_SERVER['REQUEST_URI'])['path'] . "?success_flag=true");
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
</style>
</head>
<body>

<div class="container">
  <h2>Регистрационная форма</h2>
  <form id="registrationForm" method="POST" action="">
    <div class="form-group">
      <label for="name">ФИО:</label>
      <input type="text" id="fullName" name="name" >
    </div>
    <div class="form-group">
      <label for="phone">Телефон:</label>
      <input type="tel" id="phone" name="phone">
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" >
    </div>
    <div class="form-group">
      <label for="dob">Дата рождения:</label>
      <input type="date" id="dob" name="dob" >
    </div>
    <div class="form-group">
      <label>Пол:</label>
      <label><input type="radio" name="gender" value="male" checked> Мужской</label>
      <label><input type="radio" name="gender" value="female"> Женский</label>
    </div>
    <div class="form-group">
      <label for="favoriteLanguage">Любимый язык программирования:</label>
      <select id="favoriteLanguage" name="favoriteLanguage[]" multiple >
        <option value="1">Pascal</option>
        <option value="2">C</option>
        <option value="3">C++</option>
        <option value="4">JavaScript</option>
        <option value="5">PHP</option>
        <option value="6">Python</option>
        <option value="7">Java</option>
        <option value="8">Haskel</option>
        <option value="9">Clojure</option>
        <option value="10">Prolog</option>
        <option value="11">Scala</option>
      </select>
    </div>
    <div class="form-group">
      <label for="bio">Биография:</label>
      <textarea id="bio" name="bio" rows="5" ></textarea>
    </div>
    <div class="form-group">
      <label><input type="checkbox" id="contract" name="contract" > С контрактом ознакомлен (а)</label>
    </div>
    <button type="submit">Сохранить</button>
  </form>
</div>

</body>
</html>
