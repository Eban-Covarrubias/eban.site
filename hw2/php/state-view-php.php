<?php
session_start();
header("Cache-Control: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
  <title>State Demo (PHP) - View</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<h1 align="center">Saved Session Data, from Eban (PHP)</h1><hr/>

<?php if (empty($_SESSION)): ?>
<p>No data saved yet. <a href="/hw2/php/state-save-php.php">Go save some &rarr;</a></p>
<?php else: ?>
<ul>
<?php foreach ($_SESSION as $key => $value): ?>
<li><strong><?php echo htmlspecialchars($key); ?>:</strong> <?php echo htmlspecialchars($value); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<p><a href="/hw2/php/state-save-php.php">Back to save page</a> &middot; <a href="/hw2/php/state-clear-php.php">Clear saved data</a></p>

</body>
</html>
