
  <div class = "container" id = "form">
    <p id="font-size3">Форма:</p>
    <form action="обработчик.php" method="POST">
      <label for="fio">1. ФИО:</label>
      <input type="text" id="fio" name="fio"><br><br>

      <label for="phone">2. Телефон:</label>
      <input type="tel" id="phone" name="phone" required><br><br>

      <label for="email">3. E-mail:</label>
      <input type="text" id="email" name="email" required><br><br>

      <label for="birthdate">4. Дата рождения:</label>
      <input type="date" id="birthdate" name="birthdate" required><br><br>

      <label>5 Пол:</label>
      <input type="radio" id="male" name="gender" value="male" required>
      <label for="male">Мужской</label>
      <input type="radio" id="female" name="gender" value="female" required>
      <label for="female">Женский</label><br><br>

      <label>6. Любимый язык программирования:</label><br>
      <select name="programming_languages[]" multiple>
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
      </select><br><br>
      <label for="bio">7. Биография:</label><br>
      <textarea id="bio" name="bio" rows="4" required></textarea><br><br>

      <input type="checkbox" id="contract" name="contract" required>
      <label for="contract">8. С контрактом ознакомлен(а)</label><br><br>

  <input type="submit" value="ok" />
    </form>
  </div>
</div>
  
