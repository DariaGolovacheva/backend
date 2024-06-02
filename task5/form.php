<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];

if (!empty($messages)) {
    print('<div id="messages">');

    // Выводим все сообщения.
    foreach ($messages as $message) {
        print($message);
    }

    print('</div>');
}

?>

<html>
<head>
    <style>
        /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
        .error {
            border: 2px solid red;
        }
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
</head>

<body style="display: flex; flex-direction: column; justify-content: center; align-items: center">

<h1>
    Form
</h1>

<form style="display: flex;flex-direction: column;width: 20%" action="" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
    <input required type="text" name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" placeholder="Full name">
    <input required type="tel" name="phone" <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php print $values['phone']; ?>" placeholder="Phone number">
    <input required type="email" name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" placeholder="Email">
    <input required type="date" name="year" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>" placeholder="Date of birth">

    <div style="flex-direction: row;margin-top: 20px">
        <input required type="radio" name="sex" <?php if ($errors['sex']) {print 'class="error"';} ?> value="M" <?php if ($values['sex'] == 'M') {print 'checked';} ?>>Male
        <input required type="radio" name="sex" <?php if ($errors['sex']) {print 'class="error"';} ?> value="F" <?php if ($values['sex'] == 'F') {print 'checked';} ?>>Female
    </div>

    <select style="margin-top: 20px" name="language[]" multiple <?php if ($errors['language']) {print 'class="error"';} ?>>
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

    <textarea required style="margin-top: 20px" name="biography" <?php if ($errors['biography']) {print 'class="error"';} ?> placeholder="Your biography"><?php print htmlspecialchars($values['biography']); ?></textarea>

    <p><input required type="checkbox" name="contract_agreement" <?php if ($errors['contract_agreement']) {print 'class="error"';} ?> value="Yes" <?php if ($values['contract_agreement'] == 'Yes') {print 'checked';} ?>>I agree with the contract.</p>

    <input required type="submit" value="Submit">
</form>

</body>
</html>
