<form action="" method="POST">
  <label for="fio">ФИО:</label>
  <input type="text" name="fio" id="fio" required />
  <br/>

  <label for="phone">Телефон:</label>
  <input type="tel" name="phone" id="phone" required />
  <br/>

  <label for="email">Email:</label>
  <input type="email" name="email" id="email" required />
  <br/>

  <label for="dob">Дата рождения:</label>
  <input type="date" name="dob" id="dob" required />
  <br/>

  <label for="gender">Пол:</label>
  <select name="gender" id="gender" required>
    <option value="male">Мужской</option>
    <option value="female">Женский</option>
  </select>
  <br/>

  <label for="languages">Языки программирования:</label>
  <select name="languages[]" id="languages" multiple required>
    <option value="1">Pascal</option>
    <option value="2">C</option>
    <option value="3">C++</option>
    <option value="4">JavaScript</option>
    <option value="5">PHP</option>
    <option value="6">Python</option>
    <option value="7">Java</option>
    <option value="8">Haskel</option>
    <option value="9">Clojure</option>
    <option value="10">Prolog</option>
    <option value="11">Scala</option>
  </select>
  <br/>

  <label for="bio">Биография:</label><br/>
  <textarea name="bio" id="bio" rows="4" required></textarea>
  <br/>

  <label for="contract">С контрактом ознакомлен:</label>
  <input type="checkbox" name="contract" id="contract" required />
  <br/>

  <input type="submit" value="Отправить" />
</form>
