<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
</head>
<body>
	<header class="header">
		<div class="header-wrapper">
			<div class="site-logo">
				<a href="index.php"><img src="images/logo.png"></a>
			</div>
			<div class="menu">
				<nav>
					<ul>
						<li>
							<a href="ranking.php">
								<img src="images/ranking.png"><span>ランキング</span>
							</a>
						</li>
						<li>
							<a href="product_R.php">
								<img src="images/product_detail.png"><span>商品一覧</span>
							</a>
						</li>
						<li>
							<a href="mypage.php">
								<img src="images/mypage.png"><span>マイページ</span>
							</a>
						</li>
						<li>
							<a href="favorite-show.php">
								<img src="images/favorite.png"><span>お気に入り</span>
							</a>
						</li>
						<li>
							<a href="cart_show.php">
								<img src="images/cart.png"><span>買い物カート</span>
							</a>
						</li>
						<li>
							<a href="q.php">
								<img src="images/info.png"><span>お問い合わせ</span>
							</a>
						</li>
						<li>
							<a href="login.php">
								<img src="images/login.png"><span>ログイン</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="hello">
			<?php 
			if(isset($_SESSION['customer'])){
				echo 'こんにちは　',$_SESSION['customer']['name'],'　さん。';
			}else{
				echo 'こんにちは　ゲスト　さん。';
			}
			 ?>
			</div>
		</div>
		<div class="header-line">　</div>
	</header><!-- /header -->
	<main>


<!-- </body>
</html> -->
