<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/customer.css">
<link rel="stylesheet" href="css/index.css">
<title>会員登録 | 麺屋ZURURU</title>
<?php
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8', 
		'staff', 'password');

	$name = $_REQUEST['name']; //空欄のものはひたすらnullを入れていく
	if(empty($name)){
		$name=null;
	}

	$address = $_REQUEST['address'];
	if(empty($address)){
		$address=null;
	}

	$phone_number = $_REQUEST['phone_number'];
	if(empty($phone_number)){
		$phone_number=null;
	}

	$cell_phone_number = $_REQUEST['cell_phone_number'];
	if(empty($cell_phone_number)){
		$cell_phone_number=null;
	}

	$mail_address = $_REQUEST['mail_address'];
	if(empty($mail_address)){
		$mail_address=null;
	}

	$login = $_REQUEST['login'];
	if(empty($login)){
		$login=null;
	}

	$password = $_REQUEST['password'];
	if(empty($password)){
		$password=null;
	}

	$paymoment = $_REQUEST['paymoment'];
	if(empty($paymoment)){
		$paymoment=null;
	}

	$payee = $_REQUEST['payee'];
	if(empty($payee)){
		$payee=null;
	}

$sql=$pdo->prepare('select * from customer where login=?'); //ログインidの被りがないか調べる
	$sql->execute([$_REQUEST['login']]);



	if(empty($address and $name and $login and $password)){
		echo '<p class="customer-message">必要事項が入力されていません。</p>';

	} else if (empty($sql->fetchAll())) {
			$sql=$pdo->prepare('INSERT INTO customer VALUES(?,?,?,?,?,?,?,?,?,?)');
			$sql->execute([null,
				$name, 
				$address,
				$phone_number, 
				$cell_phone_number,
				$mail_address,
				$login, 
				$password,
				$paymoment,
				$payee
			]);

			$result=$pdo->query('select max(id) from customer'); 
			foreach ($result as $row) {
				$customer_id=$row['max(id)'];
			}

			$_SESSION['customer']=[
				'id'=>$customer_id,
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

			echo '<p class="customer-message">お客様情報を登録しました。</p>';
			echo '<p class="customer-message">ようこそ、', $name, 'さん！</p>';
			echo '<div class="index-button">';
			echo '<label>';
			echo '<p><input type="button" value="＼ずるる、する？／" onclick="pass()"></p>';
			echo '<img src="images/start.png">';
			echo '</label>';
			echo '<script>function pass(){location.href="product_R.php"}</script>';
			echo '</div>';

		} else {
		echo '<p class="customer-message">ログイン名が既に使われています。変更してください。</p>';
	}
?>
<?php require 'footer.php'; ?>
