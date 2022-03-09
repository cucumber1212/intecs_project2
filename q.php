<?php require 'header.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/question.css">
	<title>お問い合わせ内容選択 | 麺屋ZURURU</title>
	<div class="q_body">
		
			<div><h2>- お問い合わせ内容を選択してください。-</h2></div>

			<div>
				<a href="qc_input.php"><input type="button" class="button" value="キャンセルのお問い合わせ"></a>
				<p class="alart_text"><b>【キャンセルについて】</b><br>キャンセルには、注文番号が必要です。<br>あらかじめマイページの注文履歴から、キャンセルしたい商品の注文番号をご確認ください。<br>なお、ご注文後一定期間を過ぎますとキャンセルができない場合がございます。</p>
			</div>
			<br>
			<br>
			<div>
				<a href="q_input.php"><input type="button" class="button" value="その他のお問い合わせ"></a>
				<p class="alart_text"><b>【商品の返品について】</b><br>商品に汚れや破損がある、賞味期限切れなどの問題がある場合のみご対応いたします。<br>詳しくはお問い合わせください。</p>
			</div>
		</form>
	</div>
<?php require 'footer.php'; ?>