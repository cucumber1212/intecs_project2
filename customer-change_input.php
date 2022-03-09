<link rel="stylesheet" href="css/customer.css">
<h3 class="customer-title">お客様情報の変更</h3>
<div class="customer-content">
<?php
$name=$_SESSION['customer']['name'];
$address=$_SESSION['customer']['address'];
$phone_number=$_SESSION['customer']['phone_number'];
$cell_phone_number=$_SESSION['customer']['cell_phone_number'];
$mail_address=$_SESSION['customer']['mail_address'];
$login=$_SESSION['customer']['login'];
$password=$_SESSION['customer']['password'];
$paymoment=$_SESSION['customer']['paymoment'];
$payee=$_SESSION['customer']['payee'];
	
echo '<form action="customer-change_check.php" method="post">';
echo '<table class="customer-table">';
echo '<tr><td class="item">お名前<span>※</span></td><td>';
echo '<input type="text" name="name" value="', $name, '"></td></tr>';
echo '<tr><td class="item">住所<span>※</span></td><td>';
echo '<input type="text" name="address" value="', $address, '"></td>';
echo '<tr><td class="item">電話番号</td><td>';
echo '<input type="text" name="phone_number" value="', $phone_number, '"></td></tr>';
echo '<tr><td class="item">携帯番号</td><td>';
echo '<input type="text" name="cell_phone_number" value="', $cell_phone_number, '"></td></tr>';
echo '<tr><td class="item">メールアドレス</td><td>';
echo '<input type="text" name="mail_address" value="', $mail_address, '"></td></tr>';
echo '<tr><td class="item">ログイン名<span>※</span></td><td>';
echo '<input type="text" name="login" value="', $login, '"></td></tr>';
echo '<tr><td class="item">パスワード<span>※</span></td><td>';
echo '<input type="password" name="password" value="', $password, '"></td></tr>';
echo '<tr><td class="item">お支払方法</td><td>';
echo '<select name="paymoment" id="">';
echo '<option value="クレジット"';
if ($paymoment === 'クレジット') { echo ' selected'; }
echo '>クレジット</option>';
echo '<option value="銀行振込"';
if ($paymoment === '銀行振込') { echo ' selected'; }
echo '>銀行振込</option>';
echo '<option value="代引き"';
if ($paymoment === '代引き') { echo ' selected'; }
echo '>代引き</option>';
echo '</select></td></tr>';
echo '<input type="hidden" name="payee" value="', $payee, '">';
echo '</table>';
echo '<p class="customer-note"><span>※</span>入力必須項目</p>';
echo '<input type="submit" value="登録情報を変更する">';
echo '</form>';
?>
</div>


