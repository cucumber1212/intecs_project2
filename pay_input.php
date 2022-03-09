<?php require 'header.php'; ?>
<title>商品購入 | 麺屋ZURURU</title>
<link rel="stylesheet" type="text/css" href="css/pay.css">
<div class="pay-wrapper">
<?php
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8','staff', 'password');

$cart=$pdo->prepare('select cartfood_id,sum(count),food_name,price from cart,food where cart.cartfood_id=food.food_id and customer_id=? group by cartfood_id');
	$cart->execute([$_SESSION['customer']['id']]);

if (!isset($_SESSION['customer'])) {
	echo '<p>購入手続きを行うには<a href="login.php" class="pay-login">ログイン</a>してください。</p>';
} else 
if (empty($cart->fetchAll())) {
	echo '<p>カートに商品がありません。</p>';
} else {
	echo '<p>ご注文内容をご確認ください。</p>';
	echo '<table class="pay-table"><tr>';
	echo '<td rowspan="3" class="pay-table_main">お届け先</td>';
	echo '<td class="pay-table_list">お名前</td><td class="pay-table_customer">', $_SESSION['customer']['name'], ' 様</td>';
	echo '<tr><td class="pay-table_list">ご住所</td><td class="pay-table_customer">', $_SESSION['customer']['address'], '</td></tr>';
	echo '<tr><td class="pay-table_list">お支払方法</td><td class="pay-table_customer">', $_SESSION['customer']['paymoment'], '</td></tr>';
	echo '</table>';
	require 'cart-register.php';
	echo '<a href="pay_output.php"><div class="pay-confirm">購入を確定する</div></a>';
}
?>
</div>
<?php require 'footer.php'; ?>


