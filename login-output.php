<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
<div class="login-wrapper">
<?php
unset($_SESSION['customer']);
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 
	'staff', 'password');
	
$sql=$pdo->prepare('select * from customer where login=? and password=?');
$sql->execute([$_REQUEST['login'], $_REQUEST['password']]);
foreach ($sql as $row) {
	$_SESSION['customer']=[
		'id'=>$row['id'],
		'name'=>$row['name'], 
		'address'=>$row['address'],
		'phone_number'=>$row['phone_number'],
		'cell_phone_number'=>$row['cell_phone_number'],
		'mail_address'=>$row['mail_address'],
		'login'=>$row['login'], 
		'password'=>$row['password'],
		'paymoment'=>$row['paymoment'],
		'payee'=>$row['payee']
	];
}
if (isset($_SESSION['customer'])) {
	echo '<p>ようこそ、', $_SESSION['customer']['name'], 'さん。</p>';
	echo '<div class="index-button">';
	echo '<label>';
	echo '<p><input type="button" value="＼ずるる、する？／" onclick="pass()"></p>';
	echo '<img class="start-shopping" src="images/start.png">';
	echo '</label>';
	echo '<script>function pass(){location.href="product_R.php"}</script>';
	echo '</div>';
} else {
	echo '<p>ログイン名またはパスワードが違います。</p>';
}
?>
</div>
<?php require 'footer.php'; ?>