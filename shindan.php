<link rel="stylesheet" type="text/css" href="css/shindan.css">
<h2 class="shindan-title">- ラーメン診断 -</h2>
<p class="shindan-message">今のあなたにぴったりのラーメンを診断します。</p>

<div class="question">
	<div class="question-content">
		<div class="question-content_number">Q1</div>
		<p class="question-content_question">今の気分は？</p>
	</div>
	<p class="question-note">思い当たる回答をセレクトボックスから１つ選んでください。</p>
	<select id="selecter" onclick="select()" class="question-select">
		<option disabled selected value>選択してください</option>
		<option value="A">普段通り！</option>
		<option value="B">楽しい♪</option>
		<option value="C">退屈…。</option>
	</select>
</div>
<div class="question">
	<div class="question-content">
		<div class="question-content_number">Q2</div>
		<p class="question-content_question">今どうしたい？</p>
	</div>
	<p class="question-note">思い当たる回答を下から１つチェックしてください。</p>
	<form action="kekka.php" name="Q" method="post" class="question-radio">
		<div id="A">
			<label><input type="radio" name="check1" value="D">思い出に浸りたい</label>
			<label><input type="radio" name="check1" value="E">ホッとしたい</label>
			<label><input type="radio" name="check1" value="F">青春の１ページを刻みたい</label>
		</div>
		<div id="B">
			<label><input type="radio" name="check3" value="J">多様な価値観に触れたい</label>
			<label><input type="radio" name="check3" value="K">ガッツがほしい</label>
			<label><input type="radio" name="check3" value="L">自分の限界を超えたい</label>
		</div>
		<div id="C">
			<label><input type="radio" name="check2" value="G">空腹を満たしたい</label>
			<label><input type="radio" name="check2" value="H">免疫力を上げたい</label>
			<label><input type="radio" name="check2" value="I">ちょっと冒険したい</label>
		</div>
		<input type="submit" value="診断結果を見る" class="question-submit">
	</form>
</div>

	

	<script type="text/javascript">
		document.getElementById("A").style.display ="none";
		document.getElementById("B").style.display ="none";
		document.getElementById("C").style.display ="none";

		function select(){
			str = document.getElementById("selecter").value;
			switch (str){
				case "A":
					document.getElementById("A").style.display = "block";
					document.getElementById("B").style.display = "none";
					document.getElementById("C").style.display = "none";
				break;
				case "B":
					document.getElementById("A").style.display = "none";
					document.getElementById("B").style.display = "block";
					document.getElementById("C").style.display = "none";
				break;
				case "C":
					document.getElementById("A").style.display = "none";
					document.getElementById("B").style.display = "none";
					document.getElementById("C").style.display = "block";
				break;

			}
		}
		select();
	</script>