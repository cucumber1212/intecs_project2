<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">

<!-- 自動スライドのやつ -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<!-- ふわっとするやつ -->
<script src="https://unpkg.com/scrollreveal@4"></script> 

<title>ずるる、する？ | 麺屋ZURURU</title>

<a href="shindan_show.php"><div class="shindan-link"><span>ラーメン<br>診断</span></div></a>
<script>
ScrollReveal().reveal('.shindan-link', {delay: 100, duration: 2000, distance: '100px'});
</script>

<div class="index-slider1">
	<?php 
	for($i=101; $i<110; $i++){
		echo '<img src="images/';
		echo $i;
		echo '.jpg">';
	}
	for($i=201; $i<208; $i++){
		echo '<img src="images/';
		echo $i;
		echo '.jpg">';
	}
	?>
</div>

<div class="index-button">
	<label>
		<p><input type="button" value="＼ずるる、する？／" onclick="pass()" class=""></p>
		<img class="stat-shopping" src="images/start.png">
	</label>
	<script>
		function pass(){
			location.href="product_R.php"
		}
	</script>
</div>

<div class="index-slider2" dir="rtl">
	<?php 
	for($i=201; $i<208; $i++){
		echo '<img src="images/';
		echo $i;
		echo '.jpg">';
	}
	for($i=101; $i<110; $i++){
		echo '<img src="images/';
		echo $i;
		echo '.jpg">';
	}
	?>
</div>

<?php require 'footer.php'; ?>

<script>
$(function() {
        $('.index-slider1').slick({
			autoplay: true,
			slidesToShow: 7,
			slidesToScroll: 1,
			autoplaySpeed: 0,
			cssEase: 'linear',
			speed: 10000,
			arrows: false
        });
    });
</script>
<script>
$(function() {
        $('.index-slider2').slick({
			autoplay: true,
			slidesToShow: 7,
			slidesToScroll: 1,
			autoplaySpeed: 0,
			cssEase: 'linear',
			speed: 10000,
			arrows: false,
			rtl: true
        });
    });
</script>