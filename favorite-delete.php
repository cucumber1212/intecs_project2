<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/favorite.css">
<title>お気に入り | 麺屋ZURURU</title>
<?php
if (isset($_SESSION['customer'])) {
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 
		'staff', 'password');
	$sql=$pdo->prepare(
		'delete from favorite where customer_id=? and favorite_id=?');
	$sql->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
	echo '<p class="favorite-message">お気に入りから商品を削除しました。</p>';
} else {
	echo '<p class="favorite-message">お気に入りから商品を削除するには、ログインしてください。</p>';
}
require 'favorite.php';
?>
<?php require 'footer.php'; ?>
