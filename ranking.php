<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/ranking.css">
<title>ランキング | 麺屋ZURURU</title>
<h2 class="ranking-title">- ZURURU売上ランキング -</h2>
<?php
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8',
                'staff', 'password');

$rank=$pdo->query('select purchasefood_id,sum(count),food_name from purchase_detail,food where purchase_detail.purchasefood_id=food.food_id group by purchasefood_id order by sum(count) desc limit 3;');

$ranking=1;

foreach($rank as $row){
	$purchasefood_id = $row['purchasefood_id'];
	$food_name = $row['food_name'];
	
	echo '<div class="ranking-content">';
	echo '<img class="ranking-icon" src="images/ranking/r', $ranking,'.png">';
	echo '<div class="ranking-links">';
	echo '<a href="product_detail.php?id=', $purchasefood_id, '">';
	echo '<p>', $food_name, '</p>';
	echo '<img class="ranking-images" src="images/', $row['purchasefood_id'], '.jpg"></a></div></div>';
	$ranking++;
}

if(!isset($purchasefood_id)){
	echo '<p class="ranking-preparation">準備中</p>';
}
?>
<?php require 'footer.php'; ?>

