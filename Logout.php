<?php
session_start();
session_unset();
session_destroy();
header('Location: index.php');
?>
<html>
<head>
  <style>
  </style>
  <title>Wylogowywanie z SSP</title>
  <meta charset="UTF-8">
</head>
<body>
</body>
</html>
