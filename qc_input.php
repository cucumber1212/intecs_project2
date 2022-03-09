<?php require 'header.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/question.css">
	<title>キャンセルリクエスト | 麺屋ZURURU</title>
	<div class="q_body">
		<form action="qc_kakunin.php" method="post" name="question" class="q_form">
			<div><h2>- キャンセルリクエスト -</h2></div>
			<div>
				<label><b>メールアドレス</b></label><br>
				<input type="text" name="q_mail" placeholder="メールアドレスをご記入ください。" value="">
			</div>
			<div>
				<label><b>電話番号</b></label><br>
				<input type="text" name="q_phone" placeholder="ハイフン無しで入力してください。" value="">
			</div>
			<div>
                <input type="hidden" name="q_naiyou" value="キャンセル" class="select">
                <label><b>キャンセルしたい商品のある注文番号を入力してください。</b></label><br>
                <input type="text" name="q_bangou">
                <p class="alart_text">注文番号はマイページの購入履歴から確認できます。</p>
            </div>
			<div>
				<label><b>お問い合わせ内容をご記入ください。</b></label><br>
				<textarea name="q_contacts" rows="5" placeholder="お問い合わせ内容を入力してください。"></textarea>
			<p class="alart_text"><b>【キャンセルについて】</b><br>ご注文後一定期間を過ぎますとキャンセルができない場合がございます。</p>

			<p class="alart_text"><b>【商品の返品について】</b><br>商品に汚れや破損がある、賞味期限切れなどの問題がある場合のみご対応いたします。<br>詳しくはお問い合わせください。</p>
			<input type="submit" class="button" value="確認画面へ">
			</div>
		</form>
	</div>
<?php require 'footer.php'; ?>