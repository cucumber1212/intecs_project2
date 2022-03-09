<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/question.css">
<title>キャンセル内容確認</title>
<?php
	$q_mail=$_REQUEST['q_mail'];
	$q_phone=$_REQUEST['q_phone'];
	$q_naiyou=$_REQUEST['q_naiyou'];
  $q_bangou=$_REQUEST['q_bangou'];
	$q_contacts=$_REQUEST['q_contacts'];
?>

<div class="q_body">
<div class="q-padding">
<form action="qc_output.php" method="post">
    <input type="hidden" name="q_mail" value="<?php echo $q_mail; ?>">
    <input type="hidden" name="q_phone" value="<?php echo $q_phone; ?>">
    <input type="hidden" name="q_naiyou" value="<?php echo $q_naiyou; ?>">
    <input type="hidden" name="q_bangou" value="<?php echo $q_bangou; ?>">
    <input type="hidden" name="q_contacts" value="<?php echo $q_contacts; ?>">

 	<div class="q-message">
 		<h2>- お問い合わせ確認 -</h2>
        <p>お問い合わせ内容はこちらで宜しいでしょうか？<br>よろしければ「送信する」ボタンを押して下さい。</p>
	</div>

    <div>
        <div>
        	<div class="kakunin_table">
        		<label><p class="q_item"><b>メールアドレス</b></p></label>
				<p class="q_waku"><?php echo $q_mail; ?></p>
	        </div>
     	    <div class="kakunin_table">
     	        <label><p class="q_item"><b>電話番号</b></p></label>
				<p class="q_waku"><?php echo $q_phone; ?></p>
      		</div>
      		<div class="kakunin_table">
            	<label><p class="q_item"><b>注文番号</b></p></label>
				<p class="q_waku"><?php echo $q_bangou; ?></p>
	        </div>
	        <div class="kakunin_table">
	        	<label><p class="q_item"><b>お問い合わせ内容</b></p></label>
				<p class="q_waku"><?php echo nl2br($q_contacts); ?></p>
	        </div>            
    	</div>
    </div>

    <input type="button" value="内容を修正する" onclick="history.back(-1)" class="button">
    <input type="submit" value="送信する" class="button">
</form>
</div>
</div>

<?php require 'footer.php'; ?>