<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрационная форма</title>
<html>
<head>
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
    /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
    .error {
      border: 2px solid red;
    }
  </style>
</head>
<body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
// Выводим все сообщения.
foreach ($messages as $message) {
print($message);
}
print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

<form style="display: flex;flex-direction: column;width: 20%" action="" method="POST">
  <input required type="text" name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" placeholder="Full name">
  <input required type="tel" name="phone" <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php print $values['phone']; ?>" placeholder="Phone number">
  <input required type="email" name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" placeholder="Email">
  <input required type="date" name="dob" <?php if ($errors['dob']) {print 'class="error"';} ?> value="<?php print $values['dob']; ?>" placeholder="Date of birth">

  <div style="flex-direction: row;margin-top: 20px">
      <input required type="radio" name="gender" <?php if ($errors['gender']) {print 'class="error"';} ?> value="M" <?php if ($values['gender'] == 'M') {print 'checked';} ?>>Male
      <input required type="radio" name="gender" <?php if ($errors['gender']) {print 'class="error"';} ?> value="F" <?php if ($values['gender'] == 'F') {print 'checked';} ?>>Female
  </div>

<select style="margin-top: 20px" name="language[]" multiple <?php if ($errors['language']) {print 'class="error"';} ?>>
    <option value="Pascal">Pascal</option>
    <option value="C">C</option>
    <option value="C++">C++</option>
    <option value="JavaScript">JavaScript</option>
    <option value="PHP">PHP</option>
    <option value="Python">Python</option>
    <option value="Java">Java</option>
    <option value="Haskel">Haskel</option>
    <option value="Clojure">Clojure</option>
    <option value="Prolog">Prolog</option>
    <option value="Scala">Scala</option>
  </select>

  <textarea required style="margin-top: 20px" name="bio" <?php if ($errors['bio']) {print 'class="error"';} ?> placeholder="Your biography"><?php print htmlspecialchars($values['bio']); ?></textarea>

  <p><input required type="checkbox" name="contract" <?php if ($errors['contract']) {print 'class="error"';} ?> value="Yes" <?php if ($values['contract'] == 'Yes') {print 'checked';} ?>>I agree with the contract.</p>
  <input required type="submit" value="Submit">
</form>
</body>
</html>
