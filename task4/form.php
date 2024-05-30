<html>
<head>
  <style>
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
