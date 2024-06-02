<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env = file_get_contents(__DIR__ . '/.env');
$lines = explode("\n", $env);

foreach ($lines as $line) {
    if (strpos($line, '=') !== false) {
        list($name, $value) = explode('=', $line, 2);
        $_ENV[$name] = trim($value, "\" \r");
    }
}

$isAdminAuth = false;

$dbUser = $_ENV['DB_USER'];
$dbPassword = $_ENV['DB_PASSWORD'];
$dbName = $_ENV['DB_NAME'];

$db = new PDO("mysql:host=localhost;dbname=$dbName", $dbUser, $dbPassword, [
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Функция для проверки CSRF токена
function checkCsrfToken($token) {
    return !empty($_SESSION['csrf_token_admin']) && hash_equals($_SESSION['csrf_token_admin'], $token);
}

if (!empty($_SERVER['PHP_AUTH_USER']) &&
    !empty($_SERVER['PHP_AUTH_PW'])) {

    try {
        $admin_login = $_SERVER['PHP_AUTH_USER'];
        $admin_pass = $_SERVER['PHP_AUTH_PW'];
        $md5AdminPass = md5($admin_pass);

        $stmt = $db->prepare("SELECT * FROM adminAccount WHERE adminLogin = :adminLogin AND adminPass = :adminPass");
        $stmt->execute([':adminLogin' => $admin_login, ':adminPass' => $md5AdminPass]);
        $authData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($authData) {
            $_SESSION['isAdminAuth'] = true;
            $isAdminAuth = true;
        }
    } catch(PDOException $e){
        error_log('Error : ' . $e->getMessage());
        exit();
    }
}

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    !$isAdminAuth) {

  header('HTTP/1.1 401 Unauthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

echo "Вы успешно авторизовались и видите защищенные паролем данные.";

$usersDB = [];

try {
    $stmt = $db->prepare("SELECT * FROM person");
    $stmt->execute();
    $authData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($authData) {
        $usersDB = $authData;
    }
} catch(PDOException $e){
    error_log('Error : ' . $e->getMessage());
    exit();
}

if (!isset($_SESSION['csrf_token_admin'])) {
    $_SESSION['csrf_token_admin'] = bin2hex(random_bytes(32));
}

$csrfTokenAdmin = $_SESSION['csrf_token_admin'];

?>
<body style="display: flex; flex-direction: column; justify-content: center; align-items: center">

<h1>
    Admin Control Center
</h1>

<h3>
    List of users
</h3>
<style>
 
html, body {
      min-height: 100%;
      padding: 0;
      margin: 0;
      font-family: Roboto, Arial, sans-serif;
      font-size: 14px;
      color: #fff;
      background-color: #000;
    }

    h1 {
      margin: 0 0 20px;
      font-weight: 400;
      color: #FFA500;
    }

    p {
      margin: 0 0 5px;
    }

    .main-block {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #000;
    }

    form {
      padding: 25px;
      margin: 25px;
      box-shadow: 0 2px 5px #FFA500;
      background: #222;
    }

    .fas {
      margin: 25px 10px 0;
      font-size: 72px;
      color: #FFA500;
    }

    .fa-envelope {
      transform: rotate(-20deg);
    }

    .fa-at, .fa-mail-bulk {
      transform: rotate(10deg);
    }

    .f {
      width: calc(100% - 18px);
      padding: 8px;
      margin-bottom: 20px;
      border: 1px solid #FFA500;
      outline: none;
    }

    input::placeholder {
      color: #fff;
    }

    button {
      width: 100%;
      padding: 10px;
      border: none;
      background: #FFA500;
      font-size: 16px;
      font-weight: 400;
      color: #fff;
    }

    button:hover {
      background: #D48100;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    table, th, td {
      border: 1px solid #FFA500;
    }

    th, td {
      padding: 10px;
      text-align: left;
      background: #333;
    }

    th {
      background: #444;
    }

    table {
      border-radius: 10px;
      overflow: hidden;
    }

    @media (min-width: 1300px) {
      .main-block {
        flex-direction: row;
      }

      .left-part, form {
        width: 50%;
      }

      .fa-envelope {
        margin-top: 0;
        margin-left: 20%;
      }

      .fa-at {
        margin-top: -10%;
        margin-left: 65%;
      }

      .fa-mail-bulk {
        margin-top: 2%;
        margin-left: 28%;
      }
    }
</style>
<form style="display: flex;flex-direction: column;width: 20%" action="admin.php" method="POST">
    <input type="hidden" name="csrf_token_admin" value="<?php echo $csrfTokenAdmin; ?>">
    <select name="userId">
        <?php foreach($usersDB as $option) : ?>
            <option value="<?php echo $option['personId']; ?>"><?php echo "ID: " . $option['personId'] . " "; echo "Name: " . $option['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <input required type="submit" value="Выбрать этого пользователя">
</form>

<?php

$values = array(
    'personId' => 0,
    'name' => "",
    'phone' => "",
    'email' => "",
    'year' => "",
    'sex' => "",
    'language' => [],
    'biography' => ""
);

$savedLanguages = $values['language'];

function isSelected($optionValue, $savedLanguages) {
    return in_array($optionValue, $savedLanguages) ? 'selected' : '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {

    if (!checkCsrfToken($_POST['csrf_token_admin'])) {
        die('CSRF token validation failed.');
    }

    $selectOption = $_POST['userId'];

    try {
        $stmt = $db->prepare("SELECT name, phone, email, year, sex, biography FROM person WHERE personId = :personId");
        $stmt->bindParam(':personId', $selectOption, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($userData) {
            $values['personId'] = strip_tags($selectOption);
            $values['name'] = strip_tags($userData['name']);
            $values['phone'] = strip_tags($userData['phone']);
            $values['email'] = strip_tags($userData['email']);
            $values['year'] = strip_tags($userData['year']);
            $values['sex'] = strip_tags($userData['sex']);
            $values['biography'] = strip_tags($userData['biography']);
            $selectedLanguagesStmt = $db->prepare("SELECT title FROM language1 INNER JOIN personLanguage ON language1.languageId = personLanguage.languageId WHERE personLanguage.personId = :personId");
            $selectedLanguagesStmt->execute([':personId' => $values['personId']]);
            $savedLanguages = $selectedLanguagesStmt->fetchAll(PDO::FETCH_COLUMN, 0);
        } else {
            echo 'Данные пользователя не найдены.';
        }
    } catch(PDOException $e) {
        error_log('Error : ' . $e->getMessage());
        echo 'Ошибка при загрузке данных.';
        echo $e->getMessage();
    }
}
?>

<h3>
  This user form
</h3>

<form style="display: flex;flex-direction: column;width: 20%" action="admin.php" method="POST">
  <input type="hidden" name="csrf_token_admin" value="<?php echo $csrfTokenAdmin; ?>">
  <input required type="text" name="name" value="<?php print $values['name']; ?>" placeholder="Full name">
  <input required type="tel" name="phone" value="<?php print $values['phone']; ?>" placeholder="Phone number">
  <input required type="email" name="email" value="<?php print $values['email']; ?>" placeholder="Email">
  <input required type="date" name="year" value="<?php print $values['year']; ?>" placeholder="Date of birth">

  <div style="flex-direction: row;margin-top: 20px">
      <input required type="radio" name="sex" value="M" <?php if ($values['sex'] == 'M') {print 'checked';} ?>>Male
      <input required type="radio" name="sex" value="F" <?php if ($values['sex'] == 'F') {print 'checked';} ?>>Female
  </div>

<select style="margin-top: 20px" name="language[]" multiple>
    <option value="Pascal" <?php echo isSelected('Pascal', $savedLanguages); ?>>Pascal</option>
    <option value="C" <?php echo isSelected('C', $savedLanguages); ?>>C</option>
    <option value="C++" <?php echo isSelected('C++', $savedLanguages); ?>>C++</option>
    <option value="JavaScript" <?php echo isSelected('JavaScript', $savedLanguages); ?>>JavaScript</option>
    <option value="PHP" <?php echo isSelected('PHP', $savedLanguages); ?>>PHP</option>
    <option value="Python" <?php echo isSelected('Python', $savedLanguages); ?>>Python</option>
    <option value="Java" <?php echo isSelected('Java', $savedLanguages); ?>>Java</option>
    <option value="Haskel" <?php echo isSelected('Haskel', $savedLanguages); ?>>Haskel</option>
    <option value="Clojure" <?php echo isSelected('Clojure', $savedLanguages); ?>>Clojure</option>
    <option value="Prolog" <?php echo isSelected('Prolog', $savedLanguages); ?>>Prolog</option>
    <option value="Scala" <?php echo isSelected('Scala', $savedLanguages); ?>>Scala</option>
</select>

  <textarea required style="margin-top: 20px" name="biography" placeholder="Your biography"><?php print htmlspecialchars($values['biography']); ?></textarea>
  <input type="hidden" name="personId" value="<?php echo $values['personId']; ?>">

  <input required type="submit" value="Change data">
</form>

</body>

<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
         isset($_POST['personId']) &&
         isset($_POST['name']) &&
         isset($_POST['email']) &&
         isset($_POST['phone']) &&
         isset($_POST['year']) &&
         isset($_POST['sex']) &&
         isset($_POST['biography']) &&
         isset($_POST['language'])
    ) {
        try {


            $stmt = $db->prepare("UPDATE person SET name = :name, email = :email, phone = :phone, year = :year, sex = :sex, biography = :biography WHERE personId = :personId");
            $stmt->execute([
              ':name' => $_POST['name'],
              ':email' => $_POST['email'],
              ':phone' => $_POST['phone'],
              ':year' => $_POST['year'],
              ':sex' => $_POST['sex'],
              ':biography' => $_POST['biography'],
              ':personId' => intval($_POST['personId'])
            ]);

            if (is_array($_POST['language'])) {
                // Обновляем данные в таблице personLanguage.
                foreach ($_POST['language'] as $selectedOption) {
                    $languageStmt = $db->prepare("SELECT languageId FROM language1 WHERE title = :title");
                    $languageStmt->execute([':title' => $selectedOption]);
                    $language = $languageStmt->fetch(PDO::FETCH_ASSOC);

                    // Проверяем, существует ли уже запись для данного personId и languageId.
                    $checkStmt = $db->prepare("SELECT * FROM personLanguage WHERE personId = :personId AND languageId = :languageId");
                    $checkStmt->execute([
                      ':personId' => intval($_POST['personId']),
                      ':languageId' => $language['languageId']
                    ]);

                    if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
                        // Если запись существует, обновляем ее.
                        $updateStmt = $db->prepare("UPDATE personLanguage SET languageId = :languageId WHERE personId = :personId AND languageId = :languageId");
                        $updateStmt->execute([
                          ':personId' => intval($_POST['personId']),
                          ':languageId' => $language['languageId']
                        ]);
                    } else {
                        // Если записи не существует, вставляем новую.
                        $insertStmt = $db->prepare("INSERT INTO personLanguage (personId, languageId) VALUES (:personId, :languageId)");
                        $insertStmt->execute([
                          ':personId' => intval($_POST['personId']),
                          ':languageId' => $language['languageId']
                        ]);
                    }
                }
            }
        } catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
?>

<form style="display: flex;flex-direction: column;width: 20%" action="admin.php" method="POST">
    <input type="hidden" name="csrf_token_admin" value="<?php echo $csrfTokenAdmin; ?>">
    <textarea required style="margin-top: 20px" name="personId" placeholder="Введите personId пользователя, которого хотите удалить"></textarea>
    <input required type="submit" value="Удалить этого пользователя">
</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['personId'])) {

        if (!checkCsrfToken($_POST['csrf_token_admin'])) {
            die('CSRF token validation failed.');
        }
        try {
            $stmt = $db->prepare("DELETE FROM personLanguage WHERE personId = :personId");
            $stmt->execute([':personId' => intval($_POST['personId'])]);

            $stmt = $db->prepare("DELETE FROM personAuthentificationData WHERE personId = :personId");
            $stmt->execute([':personId' => intval($_POST['personId'])]);

            $stmt = $db->prepare("DELETE FROM person WHERE personId = :personId");
            $stmt->execute([':personId' => intval($_POST['personId'])]);

        } catch (PDOException $e) {
            echo "Ошибка выполнения запроса: " . $e->getMessage();
        }
    }


    // Запрос для подсчета количества пользователей по языкам
   $sql = "SELECT l.title, COUNT(pl.personId) AS user_count
        FROM language1 l
        LEFT JOIN personLanguage pl ON l.languageId = pl.languageId
        GROUP BY l.title";
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<tr><th>Язык</th><th>Количество пользователей</th></tr>";
        foreach ($results as $row) {
            echo "<tr><td>{$row['title']}</td><td>{$row['user_count']}</td></tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Ошибка выполнения запроса: " . $e->getMessage();
    }
?>
