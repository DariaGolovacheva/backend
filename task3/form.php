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
      
      input[type="checkbox"],
      input[type="radio"] {
        margin-right: 5px;
      }

      input[type="radio"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #FFA500; /* Оранжевая рамка */
        outline: none;
        cursor: pointer;
      }

      input[type="radio"]:checked {
        background-color: #FFA500; /* Оранжевый цвет заполнения при выборе */
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
      
      .error {
        color: #ff0000; /* Красный цвет текста ошибки */
        font-size: 12px;
      }
      
      .has-error input,
      .has-error select,
      .has-error textarea {
        border-color: #ff0000; /* Красная рамка вокруг поля ввода с ошибкой */
      }
    </style>
</head>
<body>

<div class="container">
  <h2>Регистрационная форма</h2>
  <form id="registrationForm" method="POST" action="">
<div class="form-group <?php echo isset($_COOKIE['name_error']) ? 'has-error' : ''; ?>">
    <label for="name">ФИО:</label>
    <input type="text" id="fullName" name="name" value="<?php echo isset($_COOKIE['name']) ? htmlspecialchars($_COOKIE['name']) : ''; ?>">
    <?php echo isset($_COOKIE['name_error']) ? '<span class="error">' . $_COOKIE['name_error'] . '</span>' : ''; ?>
</div>
<div class="form-group <?php echo isset($_COOKIE['phone_error']) ? 'has-error' : ''; ?>">
    <label for="phone">Телефон:</label>
    <input type="tel" id="phone" name="phone" value="<?php echo isset($_COOKIE['phone']) ? htmlspecialchars($_COOKIE['phone']) : ''; ?>">
    <?php echo isset($_COOKIE['phone_error']) ? '<span class="error">' . $_COOKIE['phone_error'] . '</span>' : ''; ?>
</div>
<div class="form-group <?php echo isset($_COOKIE['email_error']) ? 'has-error' : ''; ?>">
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>">
    <?php echo isset($_COOKIE['email_error']) ? '<span class="error">' . $_COOKIE['email_error'] . '</span>' : ''; ?>
</div>
<div class="form-group <?php echo isset($_COOKIE['dob_error']) ? 'has-error' : ''; ?>">
    <label for="dob">Дата рождения:</label>
    <input type="date" id="dob" name="dob" value="<?php echo isset($_COOKIE['dob']) ? htmlspecialchars($_COOKIE['dob']) : ''; ?>">
    <?php echo isset($_COOKIE['dob_error']) ? '<span class="error">' . $_COOKIE['dob_error'] . '</span>' : ''; ?>
</div>
<div class="form-group <?php echo isset($_COOKIE['gender_error']) ? 'has-error' : ''; ?>">
    <label>Пол:</label><br>
    <input type="radio" id="male" name="gender" value="male" <?php echo (isset($_COOKIE['gender']) && $_COOKIE['gender'] == 'male') ? 'checked' : ''; ?>>
    <label for="male">Мужской</label>
    <input type="radio" id="female" name="gender" value="female" <?php echo (isset($_COOKIE['gender']) && $_COOKIE['gender'] == 'female') ? 'checked' : ''; ?>>
    <label for="female">Женский</label>
    <?php echo isset($_COOKIE['gender_error']) ? '<span class="error">' . $_COOKIE['gender_error'] . '</span>' : ''; ?>
</div>
<div class="form-group <?php echo isset($_COOKIE['favoriteLanguage_error']) ? 'has-error' : ''; ?>">
    <label for="favoriteLanguage">Любимый язык программирования:</label>
    <select id="favoriteLanguage" name="favoriteLanguage[]" multiple>
        <option value="Pascal">Pascal</option>
        <option value="C">C</option>
        <option value="C++">C++</option>
        <option value="JavaScript">JavaScript</option>
        <option value="PHP">PHP</option>
        <option value="Python">Python</option>
        <option value="Java">Java</option>
        <option value="Haskell">Haskell</option>
        <option value="Clojure">Clojure</option>
        <option value="Prolog">Prolog</option>
        <option value="Scala">Scala</option>
    </select>
    <?php echo isset($_COOKIE['favoriteLanguage_error']) ? '<span class="error">' . $_COOKIE['favoriteLanguage_error'] . '</span>' : ''; ?>
</div>
<div class="form-group <?php echo isset($_COOKIE['bio_error']) ? 'has-error' : ''; ?>">
    <label for="bio">Биография:</label>
    <textarea id="bio" name="bio" rows="5"><?php echo isset($_COOKIE['bio']) ? htmlspecialchars($_COOKIE['bio']) : ''; ?></textarea>
    <?php echo isset($_COOKIE['bio_error']) ? '<span class="error">' . $_COOKIE['bio_error'] . '</span>' : ''; ?>
</div>
<div class="form-group <?php echo isset($_COOKIE['contract_error']) ? 'has-error' : ''; ?>">
    <label><input type="checkbox" id="contract" name="contract"> С контрактом ознакомлен (а)</label>
    <?php echo isset($_COOKIE['contract_error']) ? '<span class="error">' . $_COOKIE['contract_error'] . '</span>' : ''; ?>
</div>

    <button type="submit">Сохранить</button>
  </form>
</div>

</body>
</html>
