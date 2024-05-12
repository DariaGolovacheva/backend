<html>
<head>
<title>Задание №5</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<style>
body {
    font-family: Roboto, Arial, sans-serif;
    font-size: 14px;
    color: #333;
    background-color: #f5f5f5;
}

.container {
    width: 60%;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

h1 {
    text-align: center;
    color: #1c87c9;
    margin-bottom: 20px;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="text"],
input[type="tel"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

input[type="checkbox"] {
    margin-right: 10px;
}

button {
    padding: 10px 20px;
    border: none;
    background-color: #1c87c9;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #2371a0;
}

.error {
    color: red;
    font-size: 12px;
    margin-top: -10px;
}

</style>
</head>
<body>
<div class="container">
    <h1>Заявка</h1>
    <form action="" method="POST">
        <label for="name">ФИО:</label>
        <input type="text" id="name" name="name" placeholder="Введите ваше ФИО" value="<?php print $values['name']; ?>">
        <?php if ($errors['name'] || $errors['name_struct'] || $errors['name_len']) { ?>
            <div class="error">Заполните это поле.</div>
        <?php } ?>

        <label for="phone">Телефон:</label>
        <input type="tel" id="phone" name="phone" placeholder="Введите ваш телефон" value="<?php print $values['phone']; ?>">
        <?php if ($errors['phone'] || $errors['phone_struct'] || $errors['phone_len']) { ?>
            <div class="error">Заполните это поле.</div>
        <?php } ?>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Введите вашу почту" value="<?php print $values['email']; ?>">
        <?php if ($errors['email'] || $errors['email_struct'] || $errors['email_len']) { ?>
            <div class="error">Заполните это поле.</div>
        <?php } ?>

        <label for="birthdate">Дата рождения:</label>
        <input type="date" id="birthdate" name="birthdate" value="<?php echo isset($values['birthdate']) ? $values['birthdate'] : '2000-01-01'; ?>">

        <label for="gender">Пол:</label>
        <input type="radio" id="male" name="gender" value="male" <?php if ($values['gender'] === 'male') { echo 'checked'; } ?>>
        <label for="male">Мужской</label>
        <input type="radio" id="female" name="gender" value="female" <?php if ($values['gender'] === 'female') { echo 'checked'; } ?>>
        <label for="female">Женский</label>

        <label for="language">Любимый язык программирования:</label>
        <select id="language" name="language[]" multiple>
            <option value="Pascal" <?php if (in_array('Pascal', $values['language'])) { echo 'selected'; } ?>>Pascal</option>
            <option value="C" <?php if (in_array('C', $values['language'])) { echo 'selected'; } ?>>C</option>
            <option value="C++" <?php if (in_array('C++', $values['language'])) { echo 'selected'; } ?>>C++</option>
            <option value="JavaScript" <?php if (in_array('JavaScript', $values['language'])) { echo 'selected'; } ?>>JavaScript</option>
            <option value="PHP" <?php if (in_array('PHP', $values['language'])) { echo 'selected'; } ?>>PHP</option>
            <option value="Python" <?php if (in_array('Python', $values['language'])) { echo 'selected'; } ?>>Python</option>
            <option value="Java" <?php if (in_array('Java', $values['language'])) { echo 'selected'; } ?>>Java</option>
            <option value="Ruby" <?php if (in_array('Ruby', $values['language'])) { echo 'selected'; } ?>>Ruby</option>
            <option value="Swift" <?php if (in_array('Swift', $values['language'])) { echo 'selected'; } ?>>Swift</option>
            <!-- Добавьте другие языки программирования -->
        </select>

        <label for="bio">Биография:</label>
        <textarea id="bio" name="bio"><?php print $values['bio']; ?></textarea>

        <label for="agree">С контрактом ознакомлен(а):</label>
        <input type="checkbox" id="agree" name="agree" <?php if ($values['agree'] === 'on') { echo 'checked'; } ?>>

        <button type="submit" name="button" value="ok">Сохранить</button>
        <button type="submit" name="button" value="exit">Выход</button>
    </form>
</div>
</body>
</html>
