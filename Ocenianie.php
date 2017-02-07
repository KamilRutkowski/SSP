<?php
session_start();
if(empty($_SESSION["UserID"]))
{
  header('Location: index.php');
}
else
{
  getDataFromDatabase();
}

function getDataFromDatabase()
{

  $connection = createConnection();
  $GetUnmarkedLessons = "Select Zajecia.ID from Zajecia, Studenci, WZajStu where Studenci.IDStudenta = WZajStu.IDStudenci and Zajecia.ID = WZajStu.IDZajecia and
  Zajecia.ID not in (select IDZajecia from Oceny where Oceny.IDStudenta = Studenci.IDStudenta) and Studenci.IDStudenta = \"".$_SESSION["UserID"]."\";";
  $result = mysqli_query($connection,$GetUnmarkedLessons);
  $_SESSION["IDZajec"]=mysqli_fetch_all($result);
}

function createConnection()
{
  return new MySQLi("localhost", "root", "", "SSP");
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
  <h2>Profesorowie do ocenienia:</h2>
  <form action="OcenProfesorow.php" method="post">
    <table>
    <?php

      $connection = createConnection();
      $i = 0;
      echo "<tr><td>Nazwa zajęcia:</td> <td>Semestr:</td> <td>Typ zajęć:</td> <td>Nauczyciel:</td><td>Ocena:</td></tr>";
      foreach ($_SESSION["IDZajec"] as $row){
        $getLessonInfo = "Select Semestr, TypZajec, NazwaPrzedmiotu from Zajecia, Przedmioty where ID = ".$row[0]." and Zajecia.IDPrzedmiotu = Przedmioty.IDPrzedmiotu;";
        echo $row["ID"];
        $res = mysqli_query($connection,$getLessonInfo);
        $record = mysqli_fetch_assoc($res);
        echo ("<tr><td>".$record["NazwaPrzedmiotu"]."</td> <td>".$record["Semestr"]."</td> <td>".$record["TypZajec"]."</td>");
        $getTeachers = "Select Nauczyciele.IDNauczyciela, TytulNaukowy, Imie, Nazwisko from Nauczyciele, Zajecia, WZajNau where Nauczyciele.IDNauczyciela = WZajNau.IDNauczyciele and
        Zajecia.ID = WZajNau.IDZajecia and Zajecia.ID = ".$row[0].";";
        $teachersRes = mysqli_query($connection,$getTeachers);
        echo "<td><select name = \"teacher".$i."\">";
        foreach (mysqli_fetch_all($teachersRes) as $teacher) {
          echo ("<option value=\"".$teacher[0]."\">".$teacher[1]." ".$teacher[2]." ".$teacher[3]."</option>");
        }
        echo ("</select></td><td><select name = \"mark".$i."\">");
        for($mark = 1; $mark<11; $mark++)
        {
          echo ("<option value=\"".$mark."\">".$mark."</option>");
        }
        echo ("</select></td></tr>");
        $i+=1;
      }
    ?>
  </table>
  <button type="Submit" value="Ocen"> Oceń </button>
  </form>
</div>
</body>
</html>
