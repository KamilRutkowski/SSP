<?php
session_start();
if(empty($_SESSION["UserID"]))
{
  header('Location: index.php');
}
$connection = createConnection();
$i = 0;
foreach ($_SESSION["IDZajec"] as $zajecia) {
  $query = "INSERT INTO Oceny(IDStudenta, IDZajecia, IDNauczyciela, Ocena) VALUES (\"".$_SESSION["UserID"]."\", ".$zajecia[0].", ".$_POST["teacher".$i].", ".$_POST["mark".$i].");";
  $result = mysqli_query($connection, $query);
  $i++;
}
header('Location: mainPage.php');

function createConnection()
{
  return new MySQLi("localhost", "root", "", "SSP");
}
?>
