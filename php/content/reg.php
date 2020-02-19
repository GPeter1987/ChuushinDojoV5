<p>
  Amennyiben tagja vagy a Chuushin dojónak, kérlek, regisztrálj az alábbi űrlapon!
</p>
<form action="reg_process.php" method="post">
  <label for="user">Felhasználónév: </label>
  <input type="text" name="user" />
  <p>Hibalehetőség</p>
  <label for="fullName">Teljes név: </label>
  <input type="text" name="fullName" />
  <p>Hibalehetőség</p>
  <label for="birthDate">Születési dátum: </label>
  <input type="date" name="birthDate" />
  <p>Hibalehetőség</p>
  <label for="signInDate">Beiratkozási dátum: </label>
  <input type="date" name="signInDate" />
  <p>Hibalehetőség</p>
  <label for="beltDegree">Övfokozat: </label>
  <input type="number" name="beltDegree" max=12 min=1 maxlength=2 />.
  <select name="kyudan">
    <option value="kyu">kyu</option>
    <option value="dan">dan</option>
  </select>
  <p>Hibalehetőség</p>
  <label for="pass">Jelszó: </label>
  <input type="password" name="pass" />
  <p>Hibalehetőség</p>
  <label for="passAgain">Jelszó újra: </label>
  <input type="password" name="passAgain" />
  <p>Hibalehetőség</p>
  <p>
    <input type="submit" name="submit" value="Regisztráció" />
  </p>
</form>