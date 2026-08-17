<?php
session_start();
$_SESSION = [];
session_destroy();
header("Cache-Control: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
  <title>State Demo (PHP) - Cleared</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<h1 align="center">Session Cleared, from Eban (PHP)</h1><hr/>
<p>Your saved data has been cleared.</p>
<p><a href="/hw2/php/state-save-php.php">Back to save page</a></p>

</body>
</html>
