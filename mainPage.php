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

  </style>
  <title>SSP</title>
  <meta charset="UTF-8">
</head>
<body>
<div class="MenuBox">
  <h2>Co chcesz zrobić?</h2>
  <table>
    <tr>
      <td>
        <form action="Ocenianie.php" method="post">
          <button type="submit" name="Ocen">Oceń profesorów</button>
        </form>
      </td>
      <td>
        <form action="WybierzOsobeDoWykresu.php" method="post">
          <button type="submit" name="Wykresy">Zobacz statystyki profesora</button>
        </form>
      </td>
      <td>
        <form action="Logout.php" method="post">
          <button type="submit" name="Logout">Wyloguj</button>
        </form>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
