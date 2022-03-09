<?php require 'header.php'; ?>
<title>ラーメン診断 | 麺屋ZURURU</title>
<link rel="stylesheet" type="text/css" href="css/shindan.css">
<h2 class="shindan-title">- 診断結果- </h2>
<p class="shindan-message">あなたにぴったりのラーメンは…！？</p>
<?php



if(!empty($_REQUEST['check1'])) {
	
	switch ($_REQUEST['check1']) {
	case 'D':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=109"><p class="kekka-ramen">＼ZURURUラーメン／</p>';
		echo '<img class="kekka-img" src="images/109.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	case 'E':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=101"><p class="kekka-ramen">＼醤油ラーメン／</p>';
		echo '<img class="kekka-img" src="images/101.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	case 'F':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=102"><p class="kekka-ramen">＼塩ラーメン／</p>';
		echo '<img class="kekka-img" src="images/102.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	}
	
} else if(!empty($_REQUEST['check2'])){
	
	switch ($_REQUEST['check2']) {
		
		case 'G':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=103"><p class="kekka-ramen">＼とんこつラーメン／</p>';
		echo '<img class="kekka-img" src="images/103.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	case 'H':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=104"><p class="kekka-ramen">＼味噌ラーメン／</p>';
		echo '<img class="kekka-img" src="images/104.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	case 'I':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=105"><p class="kekka-ramen">＼カレーラーメン／</p>';
		echo '<img class="kekka-img" src="images/105.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	}
		
} else if(!empty($_REQUEST['check3'])){

	switch ($_REQUEST['check3']) {
			
	case 'J':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=108"><p class="kekka-ramen">＼ヴィーガンラーメン／</p>';
		echo '<img class="kekka-img" src="images/108.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	case 'K':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=107"><p class="kekka-ramen">＼プロテインラーメン／</p>';
		echo '<img class="kekka-img" src="images/107.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
	case 'L':
		echo '<div class="kekka-content">';
		echo '<a href="product_detail.php?id=106"><p class="kekka-ramen">＼炎炎ラーメン／</p>';
		echo '<img class="kekka-img" src="images/106.jpg"></a>';
		echo '</div>';
		echo '<div class="shindan-repeat"><a href="shindan_show.php" >もう一度診断する</a></div>';
		break;
		}
} else {
	echo '<p class="please-select">Q2を選択してください😢</p>';
	require 'shindan.php';
}
?>
<?php require 'footer.php'; ?>

