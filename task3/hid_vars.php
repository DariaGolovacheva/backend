<?php
$user = 'u67498'; // Заменить на ваш логин uXXXXX
$pass = '2427367'; // Заменить на пароль
$db = new PDO('mysql:host=localhost;dbname=u67498', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
?>
