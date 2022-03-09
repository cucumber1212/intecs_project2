<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/favorite.css">
<title>お気に入り | 麺屋ZURURU</title>
<?php
if (isset($_SESSION['customer'])) {
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 
		'staff', 'password');
	$sql=$pdo->prepare('insert into favorite values(?,?)');
	$sql->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
	echo '<p class="favorite-message">お気に入りに商品を追加しました。</p>';
	echo '<p class="favorite-message_shopping"><a href="product_R.php">お買い物を続ける</a></p>';
	require 'favorite.php';
} else {
	echo '<p class="favorite-message">お気に入りに商品を追加するには、<a href="login.php">ログイン</a>してください。</p>';
}
?>
<?php require 'footer.php'; ?>

