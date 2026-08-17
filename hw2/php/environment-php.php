<?php
header("Cache-Control: no-cache");
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Environment Variables - PHP</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<h1 align="center">Environment Variables, from Eban (PHP)</h1><hr/>
<table border="1" cellpadding="6" style="margin:0 auto;color:#eef0f3;border-color:#262a33;border-collapse:collapse;">
<tr><th>Variable</th><th>Value</th></tr>
<?php
ksort($_SERVER);
foreach ($_SERVER as $key => $value):
    $display = is_array($value) ? json_encode($value) : $value;
?>
<tr><td><?php echo htmlspecialchars($key); ?></td><td><?php echo htmlspecialchars($display); ?></td></tr>
<?php endforeach; ?>
</table>

</body>
</html>
