<?php require 'header.php'; ?>
<link rel="stylesheet" href="css/customer.css">
<title>会員登録 | 麺屋ZURURU</title>
<?php
if (isset($_SESSION['customer'])) {
	echo '<p class="customer-message">会員登録されています。</p>';

} else {

echo '<h2 class="entry-title">- 会員登録 -</h2>';
echo '<div class="customer-content">';
echo '<form action="customer-entry_check.php" method="post">';
echo '<table class="customer-table">';
echo '<tr><td class="item">お名前<span>※</span></td><td><input type="text" name="name" value=""></td></tr>';
echo '<tr><td class="item">住所<span>※</span></td><td><input type="text" name="address" value=""></td></tr>';
echo '<tr><td class="item">電話番号</td><td><input type="text" name="phone_number" value=""></td></tr>';
echo '<tr><td class="item">携帯番号</td><td><input type="text" name="cell_phone_number" value=""></td></tr>';
echo '<tr><td class="item">メールアドレス</td><td><input type="text" name="mail_address" value=""></td></tr>';
echo '<tr><td class="item">ログイン名<span>※</span></td><td><input type="text" name="login" value=""></td></tr>';
echo '<tr><td></td><td class="define">半角英数字4文字以上(数字のみは不可)</td></tr>';
echo '<tr><td class="item">パスワード<span>※</span></td><td><input type="password" name="password" value=""></td></tr>';
echo '<tr><td></td><td class="define">半角英数字6文字以上</td></tr>';
echo '<tr><td></td><td class="define">大文字小文字英数字を一文字以上含めてください。';
echo '<tr><td class="item">お支払方法</td>';
echo '<td><select name="paymoment" id="">';
echo '<option value="クレジット">クレジット</option>';
echo '<option value="銀行振込">銀行振込</option>';
echo '<option value="代引き">代引き</option>';
echo '</select></td>';
echo '</select></td>';
echo '<input type="hidden" name="payee" value="">';
echo '</table>';
echo '<p class="customer-note"><span>※</span>入力必須項目</p>';
echo '<input type="submit" value="登録情報を登録する">';
echo '</form></div>';
}
?>
<?php require 'footer.php'; ?>


