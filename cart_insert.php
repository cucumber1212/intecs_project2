<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/cart.css">
<title>買い物カート | 麺屋ZURURU</title>
<?php
if (isset($_SESSION['customer'])) {
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 
		'staff', 'password');
	$sql=$pdo->prepare('insert into cart values(?,?,?,?)');
	$sql->execute([null,$_SESSION['customer']['id'], $_REQUEST['food_id'],$_REQUEST['count']]);
	echo '<p class="cart-insert_message">カートに商品を追加しました。</p>';
	echo '<p class="cart-insert_message"><a href="product_R.php">お買い物を続ける</a></p>';
	require 'cart.php';
} else {
	echo '<p class="cart-loginmessage">カートに商品を追加するには、<a href="login.php" class="cart-login">ログイン</a>してください。</p>';
}
?>
<?php require 'footer.php'; ?>

