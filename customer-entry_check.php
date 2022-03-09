<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/customer.css">
<title>会員登録 | 麺屋ZURURU</title>
<?php
if (isset($_SESSION['customer'])) {
	echo '<p class="customer-message">会員登録されています。</p>';

} else {

echo '<h2 class="entry-title">- 会員登録 -</h2>';
echo '<div class="customer-content">';
	
	$name=$_REQUEST['name'];
	$address=$_REQUEST['address'];
	$phone_number=$_REQUEST['phone_number'];
	$cell_phone_number=$_REQUEST['cell_phone_number'];
	$mail_address=$_REQUEST['mail_address'];
	$login=$_REQUEST['login'];
		if (!preg_match('/(?=.*[a-z])[a-zA-Z0-9]{4,}/', $login)) {
			echo '<p class="attention">※ログイン名をご確認ください。</p>';
		}
	$password=$_REQUEST['password'];
		if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,}/',$password)) {
		echo '<p class="attention">※パスワードをご確認ください。</p>';
	}
	$paymoment=$_REQUEST['paymoment'];
	$payee=$_REQUEST['payee'];
	
	echo '<table class="customer-table">';
	echo '<tr><td class="item">お名前<span>※</span></td>';
	echo '<td class="customer-check">', $name, '</td></tr>';
	echo '<tr><td class="item">住所<span>※</span></td>';
	echo '<td class="customer-check">', $address, '</td></tr>';
	echo '<tr><td class="item">電話番号</td>';
	echo '<td class="customer-check">', $phone_number, '</td></tr>';
	echo '<tr><td class="item">携帯番号</td>';
	echo '<td class="customer-check">', $cell_phone_number, '</td></tr>';
	echo '<tr><td class="item">メールアドレス</td>';
	echo '<td class="customer-check">', $mail_address, '</td></tr>';
	echo '<tr><td class="item">ログイン名<span>※</span></td>';
	echo '<td class="customer-check">', $login, '</td></tr>';
	echo '<tr><td class="item">パスワード<span>※</span></td>';
	echo '<td class="customer-check">', $password, '</td></tr>';
	echo '<tr><td class="item">お支払方法</td>';
	echo '<td class="customer-check">', $paymoment, '</td></tr>';
	echo '</table>';
	echo '<p class="customer-note"><span>※</span>入力必須項目</p>';
	

	echo '<form action="customer-entry_output.php" method="post">';
	echo '<input type="hidden" name="name" value="', $name, '">';
	echo '<input type="hidden" name="address" value="', $address, '">';
	echo '<input type="hidden" name="phone_number" value="', $phone_number, '">';
	echo '<input type="hidden" name="cell_phone_number" value="', $cell_phone_number, '">';
	echo '<input type="hidden" name="mail_address" value="', $mail_address, '">';
	echo '<input type="hidden" name="login" value="', $login, '">';
	echo '<input type="hidden" name="password" value="', $password, '">';
	echo '<input type="hidden" name="paymoment" value="', $paymoment, '">';
	echo '<input type="hidden" name="payee" value="', $payee, '">';
	echo '<p><input type="submit" value="上記内容で登録情報を変更する"></p>';
	echo '<p><input type="button" value="内容を修正する" onclick="history.back(-1)"></p>';
	echo '</form></div>';
}
?>
<?php require 'footer.php'; ?>


