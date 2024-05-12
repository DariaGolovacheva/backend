<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
<title>Регистрационная форма</title>
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
