<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрационная форма</title>
<link rel="stylesheet" href="styles.css">
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
      <textarea id="biography" name="biofraphy" rows="5" ></textarea>
    </div>
    <div class="form-group">
      <label><input type="checkbox" id="contract" name="contract" > С контрактом ознакомлен (а)</label>
    </div>
    <button type="submit">Сохранить</button>
  </form>
</div>


</body>
</html>
