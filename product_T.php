<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/product.css">
<title>トッピング一覧 | 麺屋ZURURU</title>
	<div class="wrapper">
		<h2 class="product_title">- 商品一覧 -</h2>
		<div class="product_header">
			<div class="go_ramen">
			<a href="product_R.php"><img src="images/ramen.png"></a>
			</div>
			<form action="product_T.php" method="post" class="search">
			商品検索
				<input type="text" name="keyword">
				<input type="image" src="images/search.png" width="60px"　title="検索">
			</form>
		</div>
<!-- <hr> -->
	<div class="product">
<?php 
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 'staff', 'password');
if (isset($_REQUEST['keyword'])) {
	$sql=$pdo->prepare('select * from food where food_name like ?');
	$sql->execute(['%'.$_REQUEST['keyword'].'%']);
} else {
	$sql=$pdo->prepare('select * from food where food_id like "2%"');
	$sql->execute([]);
}
foreach ($sql as $row) {
	$id=$row['food_id'];
	echo '<div class="topping">';
	echo '<div class="topping_photo">';
	echo '<a href="product_detail.php?id=', $id, '"><img src="images/', $id, '.jpg" width="300px" height="300px">';
	echo '</div>';
	echo '<div class="topping_name">';
	echo $row['food_name'];
	echo '</div>';
	echo '<div class="topping_price">';
	echo $row['price'], '円(税込み)';
	echo '</a>';
	echo '</div>';
	echo '</div>';
}

	echo '<div class="go_ramen">';
	echo '<a href="product_R.php"><img src="images/ramen.png"></a>';
	echo '</div>';
?>
	</div>
	</div>
<?php require 'footer.php'; ?>