<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/login.css">
<title>ログイン | 麺屋ZURURU</title>
<?php
if(isset($_SESSION['customer'])){
	echo '<p class="login-message">ログインしています。</p>';
	require 'logout-input.php';
} else {
	require 'login-input.php';
}
?>
<?php require 'footer.php'; ?>