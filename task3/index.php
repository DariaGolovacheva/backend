<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Получаем данные для подключения к базе данных из переменных окружения
$db_user = $_ENV['DB_USER'] ?? '';
$db_pass = $_ENV['DB_PASS'] ?? '';
$db_name = $_ENV['DB_NAME'] ?? '';

try {
    // Подключение к базе данных
    $db = new PDO("mysql:host=localhost;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Обработка ошибки подключения к базе данных
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверка и сохранение данных в базу данных
    try {
        // Подготовленный запрос для вставки данных в таблицу application
        $stmt = $db->prepare("INSERT INTO application (name, phone, email, dob, favoriteLanguages, bio, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['phone'], $_POST['email'], $_POST['dob'], implode(', ', $_POST['favoriteLanguage']), $_POST['bio'], $_POST['contract']]);

        // Получаем ID последней вставленной записи
        $lastId = $db->lastInsertId();

        // Вставляем данные в связанную таблицу ap_lan
        foreach ($_POST['favoriteLanguage'] as $language) {
            $stmtLang = $db->prepare("SELECT id FROM language WHERE name = ?");
            $stmtLang->execute([$language]);
            $languageId = $stmtLang->fetchColumn();

            $stmtApLang = $db->prepare("INSERT INTO ap_lan (id_application, id_language) VALUES (?, ?)");
            $stmtApLang->execute([$lastId, $languageId]);
        }

        // Сохраняем куку с признаком успешного сохранения
        setcookie('save', '1', time() + 24 * 60 * 60);

        // Делаем перенаправление
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        // В случае ошибки выводим сообщение об ошибке
        die('Ошибка сохранения данных: ' . $e->getMessage());
    }
}

// Если запрос методом GET, отображаем форму
// Ваш код отображения формы здесь
?>
