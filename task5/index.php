// Генерируем уникальный логин и пароль.
$login = 'u67498';
$pass = '2427367';

// Сохраняем в Cookies.
setcookie('login', $login);
setcookie('pass', $pass);

// Проверяем, заполнены ли все поля формы.
$errors = false;
$fields = array('fio', 'email', 'password'); // Здесь перечислите все поля формы.

foreach ($fields as $field) {
    if (empty($_POST[$field])) {
        // Выдаем куку на день с флажком об ошибке в данном поле.
        setcookie($field . '_error', '1', time() + 24 * 60 * 60);
        $errors = true;
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie($field . '_value', $_POST[$field], time() + 30 * 24 * 60 * 60);
    }
}

if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
}

// Удаляем Cookies с признаками ошибок.
foreach ($fields as $field) {
    setcookie($field . '_error', '', 100000);
}

// Подключаемся к базе данных и сохраняем данные.
// Пример с использованием mysqli:
$mysqli = new mysqli("localhost", "user", "password", "database");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// Защищаемся от SQL-инъекций.
$fio = $mysqli->real_escape_string($_POST['fio']);
$email = $mysqli->real_escape_string($_POST['email']);
$password = md5($_POST['password']); // Хешируем пароль.

// TODO: Добавьте код для вставки данных в таблицу.

// Если сессия еще не запущена, запускаем ее.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Устанавливаем сессию пользователя.
$_SESSION['login'] = $login;

// Перезаписываем данные пользователя в БД, если они уже существуют.
if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
    // TODO: Добавьте код для обновления данных пользователя в БД.
}

// Сохраняем куку с признаком успешного сохранения.
setcookie('save', '1');

// Делаем перенаправление.
header('Location: ./');
