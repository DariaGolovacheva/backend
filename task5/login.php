<?php
/**
 * Файл login.php для неавторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Фиксируем, была ли начата сессия.
$session_started = false;

// Если сессия уже существует, значит, пользователь уже авторизован.
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    // Если пользователь уже авторизован, перенаправляем его на главную страницу.
    header('Location: ./');
    exit();
  }
}

// Если запрос пришел методом GET, выводим форму логина.
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form action="" method="post">
  <input name="login" placeholder="Логин" value="u67498"/>
  <input name="pass" type="password" placeholder="Пароль" value="2427367"/>
  <input type="submit" value="Войти"/>
</form>

<?php
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Если запрос пришел методом POST, обрабатываем логин и пароль.

  // Фиктивные данные для проверки.
  $correct_login = 'u67498';
  $correct_password = '2427367';

  $login = $_POST['login'];
  $password = $_POST['pass'];

  // Проверяем соответствие введенных данных фиктивным данным.
  if ($login === $correct_login && $password === $correct_password) {
    // Если логин и пароль верные, авторизуем пользователя.
    if (!$session_started) {
      session_start();
    }

    // Записываем логин и ID пользователя в сессию.
    $_SESSION['login'] = $login;
    $_SESSION['uid'] = 123; // Замените на реальный ID пользователя из базы данных.

    // Перенаправляем пользователя на главную страницу.
    header('Location: ./');
    exit();
  } else {
    // Если логин и/или пароль неверные, выводим сообщение об ошибке.
    echo "Неверный логин или пароль.";
  }
}
?>
