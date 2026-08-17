<?php
header("Cache-Control: no-cache");
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head><title>Hello CGI World - From Eban</title></head>
<body>

<h1 align="center">Hello HTML World, from Eban</h1><hr/>
<p>Hello World</p>
<p>This page was generated with the PHP programming language</p>
<p>This program was generated at: <?php echo date("D M j H:i:s Y"); ?></p>
<p>Your current IP Address is: <?php echo htmlspecialchars($_SERVER['REMOTE_ADDR']); ?></p>

</body>
</html>
