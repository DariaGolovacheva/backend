
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрационная форма</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 40px;
        }

        label {
            font-weight: bold;
            color: #555;
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
            border: 2px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #f5f5f5;
            color: #333;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            border-color: #007bff;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            padding: 16px 32px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
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
    <div class="container">
        <h2>Регистрационная форма</h2>
        <?php
        if (!empty($messages)) {
            print('<div id="messages">');
            foreach ($messages as $message) {
                print($message);
            }
            print('</div>');
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Full name</label>
                <input required type="text" id="name" name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone number</label>
                <input required type="tel" id="phone" name="phone" <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php print $values['phone']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input required type="email" id="email" name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>">
            </div>
            <div class="form-group">
                <label for="dob">Date of birth</label>
                <input required type="date" id="dob" name="dob" <?php if ($errors['dob']) {print 'class="error"';} ?> value="<?php print $values['dob']; ?>">
</div>
           <div class="form-group <?php echo isset($_COOKIE['gender_error']) ? 'has-error' : ''; ?>">
    <label>Пол:</label><br>
    <input type="radio" id="male" name="gender" value="male" <?php echo (isset($_COOKIE['gender']) && $_COOKIE['gender'] == 'male') ? 'checked' : ''; ?>>
    <label for="male">Мужской</label>
    <input type="radio" id="female" name="gender" value="female" <?php echo (isset($_COOKIE['gender']) && $_COOKIE['gender'] == 'female') ? 'checked' : ''; ?>>
    <label for="female">Женский</label>
    <?php echo isset($_COOKIE['gender_error']) ? '<span class="error">' . $_COOKIE['gender_error'] . '</span>' : ''; ?>
</div>
            <div class="form-group">
                <label for="favoriteLanguage">Languages</label>
                <select id="favoriteLanguage" name="favoriteLanguage[]" multiple <?php if ($errors['favoriteLanguage']) {print 'class="error"';} ?>>
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
            </div>
            
                
                <textarea required style="margin-top: 20px" name="bio" <?php if ($errors['bio']) {print 'class="error"';} ?> placeholder="Your biography"><?php print htmlspecialchars($values['bio']); ?></textarea>

           
         <textarea required style="margin-top: 20px" name="biography" <?php if ($errors['biography']) {print 'class="error"';} ?> placeholder="Your biography"><?php print htmlspecialchars($values['biography']); ?></textarea>

  <p><input required type="checkbox" name="contract" <?php if ($errors['contract']) {print 'class="error"';} ?> value="Yes" <?php if ($values['contract'] == 'Yes') {print 'checked';} ?>>I agree with the contract.</p>
  <input required type="submit" value="Submit">
</form>
</body>
</html>
