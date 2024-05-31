<html>
<head>
 <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #333;
        color: #fff;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        max-width: 800px;
        width: 100%;
        background-color: #1a1a1a;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        text-align: center;
    }

    h2 {
        color: #ff9800;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    label {
        font-weight: bold;
        color: #ff9800;
        margin-bottom: 8px;
        display: block;
    }

    input[type="text"],
    input[type="tel"],
    input[type="email"],
    input[type="date"],
    textarea,
    select {
        width: calc(100% - 16px);
        padding: 14px;
        border: 2px solid #ff9800;
        border-radius: 8px;
        box-sizing: border-box;
        background-color: #444;
        color: #fff;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="tel"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    textarea:focus,
    select:focus {
        border-color: #ff5722;
    }

    input[type="checkbox"] {
        margin-right: 10px;
    }

    button {
        background-color: #ff9800;
        color: #fff;
        padding: 16px 32px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #e68900;
    }

    .error {
        color: #ff0000;
        font-size: 12px;
    }

    .has-error input,
    .has-error select,
    .has-error textarea {
        border-color: #ff0000;
    }

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
  <input required type="date" name="year" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>" placeholder="Date of birth">

  <div style="flex-direction: row;margin-top: 20px">
      <input required type="radio" name="sex" <?php if ($errors['sex']) {print 'class="error"';} ?> value="M" <?php if ($values['sex'] == 'M') {print 'checked';} ?>>Male
      <input required type="radio" name="sex" <?php if ($errors['sex']) {print 'class="error"';} ?> value="F" <?php if ($values['sex'] == 'F') {print 'checked';} ?>>Female
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

  <textarea required style="margin-top: 20px" name="biography" <?php if ($errors['biography']) {print 'class="error"';} ?> placeholder="Your biography"><?php print htmlspecialchars($values['biography']); ?></textarea>

  <p><input required type="checkbox" name="contract_agreement" <?php if ($errors['contract_agreement']) {print 'class="error"';} ?> value="Yes" <?php if ($values['contract_agreement'] == 'Yes') {print 'checked';} ?>>I agree with the contract.</p>
  <input required type="submit" value="Submit">
</form>
</body>
</html>
