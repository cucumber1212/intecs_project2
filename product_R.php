<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/product.css">
<title>らーめん一覧 | 麺屋 ZURURU</title>

<!-- ふわっとするやつ -->
<script src="https://unpkg.com/scrollreveal@4"></script>

<a href="shindan_show.php"><div class="shindan-link"><span>ラーメン<br>診断</span></div></a>
<script>
ScrollReveal().reveal('.shindan-link', {delay: 100, duration: 2000, distance: '100px'});
</script>

<div class="wrapper">
	<h2 class="product_title">- 商品一覧 -</h2>
	<div class="product_header">
		<div class="go_topping">
		<a href="product_T.php"><img src="images/topping.png"></a>
		</div>
		<form action="product_R.php" method="post" class="search">
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
	$sql=$pdo->prepare('select * from food where food_id like "1%"');
	$sql->execute([]);
} 
foreach ($sql as $row) {
	$id=$row['food_id'];
	echo '<div class="ramen">';
	echo '<div class="ramen_photo">';
	echo '<a href="product_detail.php?id=', $id, '"><img src="images/', $id, '.jpg" width="300px" height="225px">';
	echo '</div>';
	echo '<div class="ramen_name">';
	echo $row['food_name'];
	echo '</div>';
	echo '<div class="ramen_price">';
	echo $row['price'], '円(税込み)';
	echo '</a>';
	echo '</div>';
	echo '</div>';
}
	
	// echo '<div class="go_topping">';
	// echo '<a href="product_T.php"><img src="images/topping.png"></a>';
	// echo '</div>';
?>
	</div>
	</div>
<?php require 'footer.php'; ?>