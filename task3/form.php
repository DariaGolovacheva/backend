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

<div class="container">
  <h2>Регистрационная форма</h2>
  <form id="registrationForm" method="POST" action="">
    <div class="form-group">
      <label for="fio">ФИО:</label>
      <input type="text" id="fio" name="fio" >
    </div>
    <div class="form-group">
      <label for="phone">Телефон:</label>
      <input type="tel" id="telephone" name="telephone">
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" >
    </div>
    <div class="form-group">
      <label for="dob">Дата рождения:</label>
      <input type="date" id="bday" name="bday" >
    </div>
    <div class="form-group">
      <label>Пол:</label>
      <label><input type="radio" name="sex" value="male" checked> Мужской</label>
      <label><input type="radio" name="sex" value="female"> Женский</label>
    </div>
    <div class="form-group">
      <label for="langs">Любимый язык программирования:</label>
      <select id="langs" name="langs" multiple >
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
    <div class="form-group">
      <label for="biography">Биография:</label>
      <textarea id="biography" name="biography" rows="5" ></textarea>
    </div>
    <div class="form-group">
      <label><input type="checkbox" id="contract" name="contract" > С контрактом ознакомлен (а)</label>
    </div>
    <button type="submit">Сохранить</button>
  </form>
</div>

</body>
</html>
