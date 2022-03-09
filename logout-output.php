<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/logout.css">
<title>ログイン | 麺屋ZURURU</title>
<?php
if (isset($_SESSION['customer'])) {
	unset($_SESSION['customer']);
	echo '<p class="logout-message">ログアウトしました。</p>';
	require 'login-input.php';
} else {
	echo '<p class="logout-message">すでにログアウトしています。</p>';
	require 'login-input.php';
}
?>
<?php require 'footer.php'; ?>
