<?php
session_start();
header("Cache-Control: no-cache");

$saved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['name'] = $_POST['name'] ?? '';
    $_SESSION['favorite_color'] = $_POST['favorite_color'] ?? '';
    $_SESSION['saved_at'] = date("D M j H:i:s Y");
    $saved = true;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>State Demo (PHP) - Save</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<h1 align="center">Server-Side State Demo, from Eban (PHP)</h1><hr/>

<?php if ($saved): ?>
<p>Saved to your session! <a href="/hw2/php/state-view-php.php">View saved data &rarr;</a></p>
<?php endif; ?>

<form method="post" action="/hw2/php/state-save-php.php">
  <p><label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?>"></label></p>
  <p><label>Favorite color: <input type="text" name="favorite_color" value="<?php echo htmlspecialchars($_SESSION['favorite_color'] ?? ''); ?>"></label></p>
  <button type="submit">Save</button>
</form>

<p><a href="/hw2/php/state-view-php.php">View saved data</a> &middot; <a href="/hw2/php/state-clear-php.php">Clear saved data</a></p>

</body>
</html>
