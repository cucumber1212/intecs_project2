<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/mypage.css">
<title>麺屋ZURURU | マイページ</title>
<?php
if (!isset($_SESSION['customer'])) {
	echo '<p class="mypage-nothing"><a href="login.php">ログイン</a>してください。</p>';
} else {
	echo '<h2 class="mypage-title">- マイページ -</h2>';
	require 'logout-input.php';
	require 'customer-change_input.php';
	require 'history.php';
}
?>
<?php require 'footer.php'; ?>
