<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
  	validateData();
}
else {
  goToLoginPage("");
}

function validateData()
{
  $Login = secureDataHandling($_POST["ID"]);
  $Password = hash("sha256",secureDataHandling($_POST["Pass"]));
  if(checkIfValidLoginData($Login, $Password))
  {
    LogInAndShowService($Login);
  }
}

function LogInAndShowService($Log)
{
  $_SESSION["UserID"] = $Log;
  header('Location: mainPage.php');
}

function secureDataHandling($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function checkIfValidLoginData($Log, $Pas)
{
  $connection = createConnection();
  if(!$connection)
  {
    goToLoginPage("Reason=NoSQLConn");
    return False;
  }
  $query = "Select * from Studenci where IDStudenta = \"".$Log."\" and Haslo = \"".$Pas."\";";
  $result = mysqli_query($connection,$query);
  if(mysqli_num_rows($result)<1)
  {
    goToLoginPage("Reason=BadData");
    return False;
  }
  return True;
}

function createConnection()
{
  return new MySQLi("localhost", "root", "", "SSP");
}

function goToLoginPage($getParameters)
{
  session_unset();
  session_destroy();
  header('Location: index.php?'.$getParameters);
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

</body>
</html>
