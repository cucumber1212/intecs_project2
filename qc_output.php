<?php require 'header.php'; ?>
<title>キャンセルリクエスト完了 | 麺屋ZURURU</title>
<link rel="stylesheet" type="text/css" href="css/question.css">
<form>
	<div class="q_kaitou">
	<?php 
	$date = date("Y/m/d");
	
	$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8','staff','password');
	$sql=$pdo->prepare('insert into question values(?,?,?,?,?,?,?)');
	if($sql->execute([
		null,
		$date,
		$_REQUEST['q_mail'],
		$_REQUEST['q_phone'],
		$_REQUEST['q_naiyou'],
		$_REQUEST['q_bangou'],
		$_REQUEST['q_contacts']
		]))
		{
	echo '<p class="arigatou">お問い合わせいただきありがとうございました。<br>内容を確認のうえ、回答させていただきます。<br><br>※キャンセルについて：ご注文後一定期間を過ぎますと<br>キャンセルができない場合がございます。<br><br>回答までしばらくお待ちください。</P>';
	}
?>
	</div>
</form>
<?php require 'footer.php'; ?>