<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/customer.css">
<?php
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 'staff', 'password');

$id=$_SESSION['customer']['id'];

$sql=$pdo->prepare('select * from customer where id!=? and login=?');
$sql->execute([$id, $_REQUEST['login']]);

$name = $_REQUEST['name'];
if(empty($name)){
	$name = null;
}

$address = $_REQUEST['address'];
if(empty($address)){
	$address = null;
}
	
$phone_number = $_REQUEST['phone_number'];
if(empty($phone_number)){
	$phone_number = null;
}

$cell_phone_number = $_REQUEST['cell_phone_number'];
if(empty($cell_phone_number)){
	$cell_phone_number = null;
}

$mail_address = $_REQUEST['mail_address'];
if(empty($mail_address)){
	$mail_address = null;
}

$login = $_REQUEST['login'];
if(empty($login)){
	$login = null;
}

$password = $_REQUEST['password'];
if(empty($password)){
	$password = null;
}

$paymoment = $_REQUEST['paymoment'];

$payee = $_REQUEST['payee'];
if(empty($payee)){
	$payee = null;
}

if(empty($name and $address and $login and $password)){
	echo '<p class="customer-message">必要事項が入力されていません。</p>';
	echo '<input type="button" value="内容を修正する" onclick="history.back(-1)" class="customer-correction">';
} else if (empty($sql->fetchAll())) {
	$sql=$pdo->prepare('update customer set name=?, address=?, phone_number=?, cell_phone_number=?, mail_address=?, login=?, password=?,  paymoment=?, payee=? where id=?');
	$sql->execute([
		$name, 
		$address,
		$phone_number, 
		$cell_phone_number,
		$mail_address,
		$login, 
		$password,
		$paymoment,
		$payee,
		$id]);

	$_SESSION['customer']=[
		'id'=>$id,
		'name'=>$_REQUEST['name'], 
		'address'=>$_REQUEST['address'],
		'phone_number'=>$_REQUEST['phone_number'],
		'cell_phone_number'=>$_REQUEST['cell_phone_number'],
		'mail_address'=>$_REQUEST['mail_address'],
		'login'=>$_REQUEST['login'], 
		'password'=>$_REQUEST['password'],
		'paymoment'=>$_REQUEST['paymoment'],
		'payee'=>$_REQUEST['payee']
		];
			
	echo '<p class="customer-message">お客様情報を更新しました。</p>';

} else {
	
	echo '<p class="customer-message">ログイン名がすでに使用されていますので、変更してください。</p>';
}
?>
<?php require 'footer.php'; ?>
