<?php require 'header.php'; ?>
<title>商品詳細 | 麺屋ZURURU</title>
<link rel="stylesheet" type="text/css" href="css/product_detail.css">
<div class="wrapper">
	<?php 
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 'staff', 'password');//データベースにアクセス
	$sql=$pdo->prepare('select * from food where food_id=?');
	$sql->execute([$_REQUEST['id']]);
	foreach ($sql as $row) {
		$id=$row['food_id'];
				echo '<form action="cart_insert.php" method="post" class="product_detail">';
				echo '<div class="product_photo">';
					echo '<img src="images/', $id, '.jpg" alt="', $row['food_name'], '" width="550px">';
				echo '</div>';
				echo '<div class="product_text">';
					echo '<h2>', $row['food_name'], '</h2>';
					echo '<p>',$row['comment'],'</p>';
					echo '<div class="product_select">';
						echo '<div class="product_price">';
							echo '価格：', $row['price'], '円(税込み)';
					echo '</div>';
						echo '<div class="product_count">';
							echo '個数：<select name="count">';
							for ($i=1; $i<=10; $i++) {
								echo '<option value="', $i, '">', $i, '</option>';
							}
							echo '</select>';
						echo '</div>';
					echo '</div>';

					echo '<input type="hidden" name="food_id" value="', $row['food_id'], '">';
					echo '<input type="hidden" name="food_name" value="', $row['food_name'], '">';
					echo '<input type="hidden" name="price" value="', $row['price'], '">';
					echo '<br>';
					
						echo '<div class="add_cart">';
						echo '<input type="image" src="images/cart_tuika.png" alt="カートに追加" class="to_cart">';
						echo '</div>';
						echo '</form>';
						echo '<div class="add_favorite">';
						echo '<a href="favorite-insert.php?id=', $row['food_id'], '" class="heart-button">お気に入り、する？</a>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				// ハートアイコンにしたい
	}

?>
<?php require 'footer.php'; ?>