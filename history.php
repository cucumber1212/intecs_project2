<link rel="stylesheet" type="text/css" href="css/history.css">
<div class="history-wrraper">
<h3 class="history-title">購入履歴</h3>
<?php
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8',  //データベースにアクセス
		'staff', 'password');
	
	$sql_purchase=$pdo->prepare(
		'select * from purchase where customer_id=? order by purchase_id desc');
	$sql_purchase->execute([$_SESSION['customer']['id']]);
	//purchaseテーブルからcustomer_idが一致する行をpurchase_idの降順に抽出（いまログインしている人の購入履歴を抽出）

	foreach ($sql_purchase as $row_purchase) {
		echo '<div class="history-purchaseid">';

		$sql_detail=$pdo->prepare(
			'select * from purchase_detail,food '.
			'where purchase_id=? and purchasefood_id=food_id');
		$sql_detail->execute([$row_purchase['purchase_id']]);
		//purchaseテーブルのpurchase_id列が?のもの、かつ
		//purchase_detailテーブルのpurchasefood_id列と、foodテーブルのfood_id列が一致するものを抽出

		echo '<p class="history-buyday">購入日：', $row_purchase['date'], '</p>';

		$total=0;

		foreach ($sql_detail as $row_detail) {
			echo '<table class="history-table">';
			echo '<tr><td rowspan="4">';
			echo '<a href="product_detail.php?id=', $row_detail['food_id'], '">';
			echo '<img src="images/', $row_detail['food_id'], '.jpg"></a></td>';
			echo '<td class="history-table_food-name"><a href="product_detail.php?id=', $row_detail['food_name'], '">';
			echo $row_detail['food_name'], '</a></td></tr>';
			echo '<tr><td>&yen', $row_detail['price'], ' / 点</td></tr>';
			echo '<tr><td>数量 ', $row_detail['count'], ' 点</td></tr>';

			$subtotal=$row_detail['price']*$row_detail['count'];
			$total+=$subtotal;
			
			echo '<tr><td class="history-table_subtotal">小計 &yen', $subtotal, '</td></tr>';
		}
		echo '</table><hr>';
		echo '<div class="history-purchase_id">注文番号：', $row_purchase['purchase_id'], '</div>';
		echo '<div class="history-total">合計 &yen', $total, '</div>';
		echo '</div>';
	}
	
	if(!isset($total)){
		echo '<p class="history-nothing">購入履歴がありません。</p>';
	}
?>



	

