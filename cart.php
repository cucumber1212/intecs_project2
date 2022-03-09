<link rel="stylesheet" type="text/css" href="css/cart.css">
<div class="cart-wrapper">
<?php
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8','staff', 'password');

$subtotal = 0;
$total = 0;
$count_sum = 0;

if(isset($_SESSION['customer'])){

	$cart=$pdo->prepare('select cartfood_id,sum(count),food_name,price from cart,food where cart.cartfood_id=food.food_id and customer_id=? group by cartfood_id');
	$cart->execute([$_SESSION['customer']['id']]);

	if (!empty($cart->fetchAll())) {

		echo '<h2 class="cart-title">- 買い物カート -</h2>';
		echo '<div class="cart-content"><table class="cart-table">';

		$cart=$pdo->prepare('select cartfood_id,sum(count),food_name,price from cart,food where cart.cartfood_id=food.food_id and customer_id=? group by cartfood_id');
		$cart->execute([$_SESSION['customer']['id']]);

		foreach($cart as $cart_row){
			echo '<tr>';
			echo '<td rowspan="4" class="cart-delete"><a href="cart_delete.php?id=',  $cart_row['cartfood_id'], '">削除</a></td>';
			echo '<td rowspan="4"><img src="images/', $cart_row['cartfood_id'], '.jpg" alt="" width="200px"></a></td>';
			echo '<td class="cart-food_name"><a href="product_detail.php?id=', $cart_row['cartfood_id'], '">', $cart_row['food_name'], '</a><td>';
			echo '</tr>';
			echo '<tr><td>&yen', $cart_row['price'], ' /点</td></tr>';
			echo '<tr><td>', $cart_row['sum(count)'], ' 点</td></tr>';

			$count_sum+=$cart_row['sum(count)'];
			$subtotal=$cart_row['price']*$cart_row['sum(count)'];
			$total+=$subtotal;

			echo '<tr><td class="cart-table_subtotal">小計 &yen', $subtotal, '</td></tr>';
		}

	echo '<tr><td></td><td></td><td></td></tr>';
	echo '<tr class="cart-table_total"><td></td><td>合計 ', $count_sum, ' 点</td><td> &yen', $total, '</td></tr>';
	echo '</table></div>';
	echo '<a href="pay_input.php" class="cart_register"><img src="images/cart.png" alt="" class="cart-image">レジに進む</a>';
	} else {
	echo '</table></div>';
	echo '<p class="cart_nothing-message">カートに商品がありません。</p>';
	}
}else{
	echo '<p class="cart_nothing-message"><a class="cart-login" href="login.php">ログイン</a>してください。</p>';
}
?>
	
	