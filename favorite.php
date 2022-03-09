<link rel="stylesheet" href="css/favorite.css">
<?php
if (isset($_SESSION['customer'])) {
	echo '<h2>- お気に入り -</h2>';
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 
		'staff', 'password');
	$sql=$pdo->prepare(
		'select * from favorite, food '.
		' group by food_id having customer_id=? and favorite_id=food_id');
	$sql->execute([$_SESSION['customer']['id']]);

// if(!empty($sql)){
// 	echo 'hello';
// }else{
// 	echo 'good night';
// }

	if(!empty($sql->fetchAll())){
		$sql=$pdo->prepare(
		'select * from favorite, food '.
		' group by food_id having customer_id=? and favorite_id=food_id');
	$sql->execute([$_SESSION['customer']['id']]);
		foreach ($sql as $row) {
			$id=$row['food_id'];
			echo '<div class="favorite-content"><table class="favorite-table">';
			echo '<tr><td rowspan="3"><a href="product_detail.php?id='.$id.'"><img src="images/', $id, '.jpg" width="300px" height="225px"></a></td>';
			echo '<td class="product-name"><a href="product_detail.php?id='.$id.'">', $row['food_name'], '</a></td></tr>';
			echo '<tr><td class="product-price">', $row['price'], '円</td></tr>';
			echo '<tr><td class="favorite-delete"><a href="favorite-delete.php?id=', $id, '" >削除</a></td></tr>';
			echo '</table></div>';
		}
	} else {
	echo '<p class="favorite-message">お気に入りした商品はありません。</p>';
	}
} else {
	echo '<p class="favorite-message">お気に入りを表示するには、<a href="login.php">ログイン</a>してください。</p>';
}
?>
<?php require 'footer.php'; ?>