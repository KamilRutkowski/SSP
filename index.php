<?php
session_start();
session_unset();
session_destroy();
if($_SERVER["REQUEST_METHOD"] == "GET")
{
  if($_GET["Reason"] == "BadData")
  {
    echo('<script>alert("Nie udało się zalogować do systemu z powodu błędnych danych logowania.")</script>');
  }
  else if($_GET["Reason"] == "NoSQLConn") {
    echo('<script>alert("Nie udało się połączyć z bazą danych.")</script>');
  };
}
 ?>
<html>
<head>
  <style>
  .LoginBox {
    text-align: center;
    line-height: 200%;
    width: 25%;
    height: auto;
    margin: auto;
    border-style: solid;
    border-width: medium;
  }
  table {
    margin: auto;
  }
  </style>
  <title>Logowanie do SSP</title>
  <meta charset="UTF-8">
</head>
<body>
<div class = "LoginBox">
  <form action="serwis.php" method="post">
  <table>
    <tr>
      <td>Identyfikator użytkownika:</td> <td><input type = "text" name = "ID"></input></td>
    </tr>
    <tr>
      <td>Hasło:</td> <td><input type = "password" name = "Pass"></input><br /></td></tr>
    </tr>
  </table>
<button type="Submit" value="Login"> Zaloguj </button>
</form>
</div>
</body>
</html>
