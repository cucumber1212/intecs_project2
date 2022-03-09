<?php require 'header.php'; ?>
<title>商品購入 | 麺屋ZURURU</title>
<link rel="stylesheet" type="text/css" href="css/pay.css">
<?php
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', //データベースzururuにアクセス
	'staff', 'password');

$date = date("Y/m/d"); //あとで日付入れる列を作るので
$purchase_id=1;

foreach ($pdo->query('select max(purchase_id) from purchase') as $row) { //注文番号の最大値を取得
	$purchase_id=$row['max(purchase_id)']+1; //購入番号を連番で取得するために+1している
}

$sql=$pdo->prepare('insert into purchase values(?,?,?)'); //purchaseテーブルにpurchase_id(注文番号)とcustomer_id(顧客番号)、購入日を追加する
if ($sql->execute([$purchase_id, $_SESSION['customer']['id'], $date])) {

	$cart=$pdo->prepare('select cartfood_id,sum(count),food_name,price from cart,food where cart.cartfood_id=food.food_id and customer_id=? group by cartfood_id');
	$cart->execute([$_SESSION['customer']['id']]);

	foreach($cart as $cart_row){
		$sql=$pdo->prepare('insert into purchase_detail values(?,?,?)'); //purchase_detailテーブルに注文番号、商品番号、個数を追加する
		$sql->execute([$purchase_id, $cart_row['cartfood_id'], $cart_row['sum(count)']]);
	}

	echo '<p class="pay-thanks">Thank you!</p>';
	echo '<p class="pay-message">注文番号', $purchase_id, 'にて承りました。</p>';
	echo '<p class="pay-message">購入手続きが完了しました。ありがとうございます。</p>';

	//カートの中身をリセット
	$delete = $pdo->prepare('delete from cart where customer_id=?');
	$delete->execute([$_SESSION['customer']['id']]); 
} else {
	echo '購入手続き中にエラーが発生しました。申し訳ございません。';
}
?>
<?php require 'footer.php'; ?>

<?php



?>