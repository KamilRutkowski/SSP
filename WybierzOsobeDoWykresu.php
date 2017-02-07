<?php
session_start();
if(empty($_SESSION["UserID"]))
{
  header('Location: index.php');
}
?>
<html>
<head>
  <style>
  .MenuBox {
    text-align: center;
  }
  table {
    margin: auto;
  }
  </style>
  <title>SSP</title>
  <meta charset="UTF-8">
</head>
<body>
<div class="MenuBox">
  <h2>Wybierz profesora:</h2>
  <form action="wykres.php" method="get" target="_blank">
    <table>
    <?php
      $connection = createConnection();
      $getTeachers = "Select Nauczyciele.IDNauczyciela, TytulNaukowy, Imie, Nazwisko from Nauczyciele";
      $teachersRes = mysqli_query($connection,$getTeachers);
      echo "<tr><td><select name = \"teacher".$i."\">";
      foreach (mysqli_fetch_all($teachersRes) as $teacher) {
        echo ("<option value=\"".$teacher[0]."\">".$teacher[1]." ".$teacher[2]." ".$teacher[3]."</option>");
      }
      echo ("</select></td></tr>");

      function createConnection()
      {
        return new MySQLi("localhost", "root", "", "SSP");
      }
    ?>
  </table>
  <button type="Submit" value="Statistics"> Zobacz statystyki </button>
  </form>
  <form action="mainPage.php"><button type="Submit" value="Back"> Powrót </button></form>
</div>
</body>
</html>
