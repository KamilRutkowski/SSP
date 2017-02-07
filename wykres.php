<?php
session_start();
if(empty($_SESSION["UserID"]))
{
  header('Location: index.php');
}

$connection = createConnection();
$getTeachers = "Select Ocena, count(*) from Oceny where IDNauczyciela = ".$_GET["teacher"]." group by Ocena;";
$teachersRes = mysqli_query($connection,$getTeachers);
$possibleMarks = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10");
$countOfMarks = array(0,0,0,0,0,0,0,0,0,0);
foreach (mysqli_fetch_all($teachersRes) as $teacher) {
  $countOfMarks[$teacher[0]-1] = $teacher[1];
}
include_once("graph.php");
makeGraph(1400,800,$possibleMarks,$countOfMarks,"Wykres ocen wykladowcy");

function createConnection()
{
  return new MySQLi("localhost", "root", "", "SSP");
}
?>
