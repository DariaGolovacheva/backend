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
  
  input[type="checkbox"] {
    margin-right: 5px;
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
</style>
</head>
<body>

<div class="main-block">
<div class="left-part">
<i class="fas fa-envelope"></i>
<i class="fas fa-at"></i>
<i class="fas fa-mail-bulk"></i>
</div>
<form action="" method="POST">
<h1 style="display: flex;
justify-content: center;
align-items: center;">Заявка</h1>
    <label>
      ФИО:<br />
      <input class = "f" name="name"
      placeholder="Введите ваше ФИО" />
    </label><br />
    <label>
    Телефон:<br />
    <input class = "f" name="phone"
      type="tel"
      placeholder="Введите ваш телефон" />
  </label><br />
  <label>
    Email:<br />
    <input class = "f" name="email"
      placeholder="Введите вашу почту" /></label>
      <label>
        <br />
        Дата рождения:<br />
        <input class = "f" name="data"
          value="2000-01-01"
          type="date" />
      </label>
      Пол:<br />
  <label><input type="radio" checked="checked"
    name="pol" value="M" />
    Мужской</label>
  <label><input type="radio"
    name="pol" value="W" />
    Женский</label><br />
             <label>
                <br />
      Любимый язык программирования:
      <br />
    <select class = "f" name="abilities[]" multiple="multiple">
            <option disabled>Выберите любимый язык пр.</option>
            <option value="Pascal">Pascal</option>
            <option value="C">C</option>
            <option value="C++">C++</option>
            <option value="JavaScript">JavaScript</option>
            <option value="PHP">PHP</option>
            <option value="Python">Python</option>
            <option value="Java">Java</option>
            <option value="Haskel">Haskel</option>
        </select>
    </label><br />
    <label>
      Биография:<br />
      <textarea class = "f" name="bio" placeholder="Ваша биография" ></textarea>
    </label><br />
  <label><input type="checkbox" checked="checked"
    name="ok" />    С контрактом ознакомлен(а)</label>
    <br />
<button type="submit" href="/">Сохранить</button>
</form>
</div>
</body>
</html>
