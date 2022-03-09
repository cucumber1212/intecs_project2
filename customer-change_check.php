<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/customer.css">
<h3 class="customer-title">変更内容のご確認</h3>
<div class="customer-content">
	<?php
	$name=$_REQUEST['name'];
	$address=$_REQUEST['address'];
	$phone_number=$_REQUEST['phone_number'];
	$cell_phone_number=$_REQUEST['cell_phone_number'];
	$mail_address=$_REQUEST['mail_address'];
	$login=$_REQUEST['login'];
	$password=$_REQUEST['password'];
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
	?>

	<form action="customer-change_output.php" method="post">
		<input type="hidden" name="name" value="<?php echo $name; ?>">
		<input type="hidden" name="address" value="<?php echo $address; ?>">
		<input type="hidden" name="phone_number" value="<?php echo $phone_number; ?>">
		<input type="hidden" name="cell_phone_number" value="<?php echo $cell_phone_number; ?>">
		<input type="hidden" name="mail_address" value="<?php echo $mail_address; ?>">
		<input type="hidden" name="login" value="<?php echo $login; ?>">
		<input type="hidden" name="password" value="<?php echo $password; ?>">
		<input type="hidden" name="paymoment" value="<?php echo $paymoment; ?>">
		<input type="hidden" name="payee" value="<?php echo $payee; ?>">
		<input type="submit" value="上記内容で登録情報を変更する">
		<input type="button" value="内容を修正する" onclick="history.back(-1)">
	</form>
</div>
<?php require 'footer.php'; ?>

