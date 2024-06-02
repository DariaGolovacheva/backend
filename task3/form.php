<html>
<head>
<title>Задание №3</title>

<style>
html, body {
  min-height: 100%;
  padding: 0;
  margin: 0;
  font-family: Roboto, Arial, sans-serif;
  font-size: 14px;
  color: #fff; /* Белый текст */
  background-color: #000; /* Черный фон */
}

h1 {
  margin: 0 0 20px;
  font-weight: 400;
  color: #FFA500; /* Оранжевый цвет заголовка */
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
  background: #000; /* Черный фон */
}

form {
  padding: 25px;
  margin: 25px;
  box-shadow: 0 2px 5px #FFA500; /* Оранжевый оттенок для тени */
  background: #222; /* Темно-серый фон для формы */
}

.fas {
  margin: 25px 10px 0;
  font-size: 72px;
  color: #FFA500; /* Оранжевый цвет для иконки */
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
  border: 1px solid #FFA500; /* Оранжевая рамка для полей ввода */
  outline: none;
}

input::placeholder {
  color: #fff; /* Белый цвет для плейсхолдера */
}

button {
  width: 100%;
  padding: 10px;
  border: none;
  background: #FFA500; /* Оранжевый фон для кнопки */
  font-size: 16px;
  font-weight: 400;
  color: #fff; /* Белый цвет текста на кнопке */
}

button:hover {
  background: #D48100; /* Темно-оранжевый цвет при наведении */
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
