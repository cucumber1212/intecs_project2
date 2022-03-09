<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>管理者ページ</title>
	<link rel="stylesheet" href="css/kannristyle.css">
<?php

// 商品テーブルの更新
$pdo = new PDO('mysql:host=localhost;dbname=zururu;charset=utf8','staff','password');
$insert = $pdo->prepare('INSERT INTO food VALUES(?,?,?,?)');
$updt1 = $pdo->prepare('UPDATE food SET food_name=?, price=?, comment=? WHERE food_id=?');
$dlt1 = $pdo->prepare('DELETE FROM food WHERE food_id=?');

$i = 0;
foreach ($pdo->query('SELECT * FROM food ORDER BY food_id ASC') as $row) {
	$i = $i + 1;
	if (isset($_REQUEST["food_name$i"]) and isset($_REQUEST["price$i"])){
		if ($updt1->execute([htmlspecialchars($_REQUEST["food_name$i"]),$_REQUEST["price$i"],$_REQUEST["comment$i"],$row['food_id']])) {
		}
		
		$check = isset($_REQUEST["1delete$i"]) ? "ok" : "no";
		if ($check === "ok"){
			$dlt1->execute([$row['food_id']]);
		}
	}
}

if (isset($_REQUEST['newfood_id']) and $_REQUEST['newfood_id']!='' and isset($_REQUEST['newfood_name']) and $_REQUEST['newfood_name']!='' and isset($_REQUEST['newprice']) and $_REQUEST['newprice']!=''){
	if ($_REQUEST['newfood_id']=='ラーメン') {
		$res = "SELECT MAX(food_id) AS mx FROM food WHERE food_name LIKE '%ラーメン%'";
	}else{
		$res = "SELECT MAX(food_id) AS mx FROM food WHERE food_name NOT LIKE '%ラーメン%'";
	}
	foreach ($pdo->query($res) as $row) {
		$id = $row['mx'] + 1;
	}
	
	if ($insert->execute([$id,$_REQUEST['newfood_name'],$_REQUEST['newprice'],$_REQUEST['newcomment']])){}
}

// 顧客テーブルの更新
$updt2 = $pdo->prepare('UPDATE customer SET name=?, address=?, phone_number=?, cell_phone_number=?, mail_address=?, login=?, password=?, paymoment=?, payee=? WHERE id=?');
$dlt2_1 = $pdo->prepare('DELETE FROM purchase WHERE customer_id=?');
$dlt2_2 = $pdo->prepare('DELETE FROM customer WHERE id=?');

$i = 0;
foreach ($pdo->query('SELECT * FROM customer') as $row) {
	$i = $i + 1;
	if (isset($_REQUEST["name$i"]) and isset($_REQUEST["address$i"]) and isset($_REQUEST["phone_number$i"]) and isset($_REQUEST["cell_phone_number$i"]) and isset($_REQUEST["mail_address$i"]) and isset($_REQUEST["login$i"]) and isset($_REQUEST["password$i"]) and isset($_REQUEST["paymoment$i"]) and isset($_REQUEST["payee$i"])){
		if (empty($_REQUEST["mail_address$i"])){
			$mail = null;
		} else {
			$mail = $_REQUEST["mail_address$i"];
		}

		if ($updt2->execute([$_REQUEST["name$i"],$_REQUEST["address$i"],$_REQUEST["phone_number$i"],$_REQUEST["cell_phone_number$i"],$mail,$_REQUEST["login$i"],$_REQUEST["password$i"],$_REQUEST["paymoment$i"],$_REQUEST["payee$i"],$row['id']])) {
		}

		$check = isset($_REQUEST["2delete$i"]) ? "ok" : "no";
		if ($check === "ok"){
			$dlt2_1->execute([$row['id']]);
			$dlt2_2->execute([$row['id']]);
		}
	}
}

// 注文テーブルの更新
$dlt3 = $pdo->prepare('DELETE FROM purchase_detail WHERE purchase_id=? AND purchasefood_id=?');

$i = 0;
foreach ($pdo->query('SELECT * FROM purchase_detail') as $row) {
	$i = $i + 1;
	$check = isset($_REQUEST[$row['purchase_id']."_".$row['purchasefood_id']]) ? "ok" : "no";
	if ($check === "ok"){
		$dlt3->execute([$row['purchase_id'],$row['purchasefood_id']]);
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	header("location:kannri.php");
	exit;
}
?>
</head>
<body>
<h1>管理者ページ</h1>

<ul class="manager_list">
	<li><a href="#readme">使い方</a></li>
	<li><a href="#food">商品一覧</a></li>
	<li><a href="#customer">顧客情報</a></li>
	<li><a href="#purchase">注文データ</a></li>
	<li><a href="#question">お問い合わせ</a></li>
</ul>

<h2 id="readme">使い方</h2>
<p>更新する場合は更新する場所を変更し、更新ボタンを押してください。</p>
<p>削除する場合は削除する項目をチェックし、更新ボタンを押してください。</p>
<p>追加する場合はリストからラーメンかトッピングかを選び、商品名と価格を入力し、更新ボタンを押してください。</p>
<p>上記3つをまとめて更新することはできます。</p>
<!-- 商品一覧 -->
<h2 id="food">商品一覧</h2>
<form action="" method="post">
<table class="manager_table">
	<thead>
		<tr>
			<th class="manager_id">商品ID</th>
			<th class="manager_foodname">商品名</th>
			<th class="manager_price">価格</th>
			<th class="manager_comment">コメント</th>
			<th class="manager_delete">削除</th>
		</tr>
	</thead>
	<tbody>
<?php
$i = 0;
foreach ($pdo->query('SELECT * FROM food ORDER BY food_id ASC') as $row) {
	$i = $i + 1;
	echo '<tr>';
	echo '<td name="food_id'.$i.'">',$row['food_id'],'</td>';
	echo '<td><input type="text" name="food_name'.$i.'"" value="',$row['food_name'],'"></td>';
	echo '<td><input type="text" name="price'.$i.'" value="',$row['price'],'"></td>';
	echo '<td><textarea name="comment'.$i.'">',$row['comment'],'</textarea></td>';
	echo '<td><input type="checkbox" name="',"1delete$i",'" class="manager_check"></button>';
	echo '</tr>';
}
?>
		<tr>
			<th>追加</th>
			<th class="manager_foodname">商品名</th>
			<th class="manager_price">価格</th>
			<th class="manager_comment">コメント</th>
		</tr>
		<tr>
			<td><select name="newfood_id">
				<option value="ラーメン">ラーメン</option>
				<option value="トッピング">トッピング</option>
			</select></td>
			<td><input type="text" name="newfood_name"></td>
			<td><input type="text" name="newprice"></td>
			<td><textarea name="newcomment"></textarea></td>
		</tr>
	</tbody>
</table>
<input type="submit" name="trns" value="更新">
</form>


<!-- 顧客情報 -->
<h2 id="customer">顧客情報</h2>
<form action="" method="post">
<table class="manager_table">
	<thead>
		<tr>
			<th class="manager_id">顧客ID</th>
			<th class="manager_username">顧客名</th>
			<th class="manager_address">住所</th>
			<th class="manager_phone">電話番号</th>
			<th class="manager_cellphone">携帯番号</th>
			<th class="manager_mailaddress">メールアドレス</th>
			<th class="manager_loginname">ログイン名</th>
			<th class="manager_password">パスワード</th>
			<th class="manager_paymoment">決済方法</th>
			<th class="manager_payee">決済先</th>
			<th class="manager_delete">削除</th>
		</tr>
	</thead>
	<tbody>
<?php

$i = 0;
foreach ($pdo->query('SELECT * FROM customer') as $row) {
	$i = $i + 1;
	echo '<tr>';
	echo '<td name="customer_id'.$i.'">',$row['id'],'</td>';
	echo '<td><input type="text" name="name'.$i.'"" value="',$row['name'],'"></td>';
	echo '<td><input type="text" name="address'.$i.'" value="',$row['address'],'"></td>';
	echo '<td><input type="text" name="phone_number'.$i.'" value="',$row['phone_number'],'"></td>';
	echo '<td><input type="text" name="cell_phone_number'.$i.'" value="',$row['cell_phone_number'],'"></td>';
	echo '<td><input type="text" name="mail_address'.$i.'" value="',$row['mail_address'],'"></td>';
	echo '<td><input type="text" name="login'.$i.'" value="',$row['login'],'"></td>';
	echo '<td><input type="text" name="password'.$i.'" value="',$row['password'],'"></td>';
	echo '<td><input type="text" name="paymoment'.$i.'" value="',$row['paymoment'],'"></td>';
	echo '<td><input type="text" name="payee'.$i.'" value="',$row['payee'],'"></td>';
	echo '<td><input type="checkbox" name="',"2delete$i",'"></button>';
	echo '</tr>';
}
?>

	</tbody>
</table>
<input type="submit" name="trns" value="更新">
</form>

<h2 id="purchase">注文データ</h2>
<form action="" method="get">
	<input type="text" name="search" placeholder="ユーザー検索">
	<input type="submit" value="検索">
</form>
<form action="" method="post">
<table class="manager_table">
	<thead>
		<tr>
			<th>注文ID</th>
			<th>顧客ID</th>
			<th>顧客名</th>
			<th>日付</th>
			<th>商品ID</th>
			<th>個数</th>
			<th class="manager_delete">削除</th>
		</tr>	
	</thead>
	<tbody>
<?php

$i = 0;
if (empty($_REQUEST['search'])) {
	$search = '';
} else {
	$search = "WHERE customer.name='".$_REQUEST['search']."' OR purchase.customer_id='".$_REQUEST['search']."' OR purchase.date='".$_REQUEST['search']."'";
}
foreach ($pdo->query('SELECT purchase_detail.purchase_id AS purchase_id,purchase.customer_id AS customer_id ,customer.name AS customer_name,purchase.date AS date,purchase_detail.purchasefood_id AS purchasefood_id,purchase_detail.count AS count FROM purchase_detail INNER JOIN purchase ON purchase.purchase_id = purchase_detail.purchase_id INNER JOIN customer ON customer.id = purchase.customer_id '.$search) as $row) {
	$i = $i + 1;
	echo '<tr>';
	echo '<td>',$row['purchase_id'],'</td>';
	echo '<td>',$row['customer_id'],'</td>';
	echo '<td>',$row['customer_name'],'</td>';
	echo '<td>',$row['date'],'</td>';
	echo '<td>',$row['purchasefood_id'],'</td>';
	echo '<td>',$row['count'],'</td>';
	echo '<td><input type="checkbox" name="'.$row['purchase_id'].'_'.$row['purchasefood_id'].'"></button>';
	echo '</tr>';
}
if ($i == 0){
	echo '<p>該当なし</p>';
}
?>

	</tbody>
</table>
<input type="submit" name="trns" value="更新">
</form>

<!-- お問い合わせ -->
<h2 id="question">お問い合わせ</h2>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>日付</th>
			<th>メールアドレス</th>
			<th>電話番号</th>
			<th>お問い合わせ内容</th>
			<th>注文番号</th>
			<th>コメント</th>
		</tr>
	</thead>
	<tbody>
<?php

foreach ($pdo->query('SELECT * FROM question') as $row) {
	$i = $i + 1;
	echo '<tr>';
	echo '<td>',$row['q_id'],'</td>';
	echo '<td>',$row['date'],'</td>';
	echo '<td>',$row['q_mail'],'</td>';
	echo '<td>',$row['q_phone'],'</td>';
	echo '<td>',$row['q_naiyou'],'</td>';
	if ($row['q_bangou'] == '000'){
		$bangou = '--';
	} else {
		$bangou = $row['q_bangou'];
	}
	echo '<td>',$bangou,'</td>';
	echo '</tr>';
}
?>
	</tbody>
</table>
</body>
</html>
<!-- 











                                      .(++g++J,..J...(++++J...
                                      dMMMMMMMMMMMMMMM9??????!                                                                                (gmx..
                                      dMMMMMMMMMMMMM\`                                                                      gm..              dMMMM\             (NNNNNN+..........,
                                      dMMMMMMMMMMM#^               .gm(J.                                                   MMMMMR            dMMMML.             ?TMMMMMMMMMMMMMMMMN[
                                      dMMMMMMMMMM=                 dMM#Y`        (MNe          .dNNK                        MMMM@`            dMMMMM:               ?HMMMMMMMMMMMMMMMF
                                      dMMMMMMMMM3                  ?MM#-        .dMD!          .MMM$                        MMMB!             dMMMMD`    .ge..        `dMMMMMMMMMMMMMF
                                      dMMMMMMMMD`       .-.         dMM]       .NMD`          (MMM$          .-,            MMM[              dMMMM\    +MMMML.         ?MMMMMMMMMMMMF
                                       MMMMMMMM[       .WMMMMMNagg,.dMMb.(gggggNMMNggMMM{    .MMMNgNMMMMMMMMMMMMm,          MMMNggggggggggggggMMMMMMMMMMMMMMMMp.         (HMMMNMMMMMMb.
                                       MMMMMMM#:         ~?THHMMMMMMMMMMMMMMMMMMMF!!?WHH!    jMM@!!!!!!!!!?MMHHHH8`         dMMMMMMMMMMMMMMMMMMMMMMMMMMHHHHHHH8`          ,MMMMMMMMMMM)
                                       MMMMMMMF                 (""""TMP      dM@           .MM@jm-       .dN_              MMMB"""WMMMMMMMMNrdMM#!                        JMMMMMMMMMM[
                                       MMMMMMMF                      .MF    .dMY            dM#`(MN&      JM%               MMM[              dMM@                         (MMMMMMMMMM[
                                       MMMMMMMF                      .MF (e.dB!             -TE /MMNR.  .dMY`               MMM[              dMM@                          dMMMMMMMMM[
                                       MMMMMMMF                      .Mk+MMNr         `           dMMN+.dMD`                MMM[               dM@                          dMMMMMMMMM[
                                       MMMMMMMF                       ,MMMMMMMMMMMMMMMMm+J,        7HMMMM#`                 MMM[               dM@                          dMMMMMMMMM[
                                       MMMMMMMF                       .MMM7??TMMMMMMMMMMMMP          JMMMNe.                MMM[               dM@                          -MMMMMMMMM[
                                       MMMMMMMF                     .gMMM#_.....,`` ``dMMD`         .MMMMMMN&               MMM[ .......J&ggNNNMMNaJJggggNNNNNm.             dMMMMMMMM\
                                       MMMMMMMF                    .dMMMMMMMMMMMMMMR..WMN_         .dMMY?MMMMp              MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM`             dMMMMMMMF
                                       MMMMMMMF                   .dMM#!dMMM@77MMMM{  JMN_        (M#=7` .WMMNm.             TM\?77777777777`       ?77777HY77`              ?MMMMMMMF
                                       MMMMMMMF                   jMM#` dMMM%  MMM%  .MMB`      .dMD`     ("7MMF                                                              MMMMMMMF
                                       MMMMMMMF                  (MMD`  dMM%  .MMM\ .MMM}.(,    JMD`                                 .,                                       MMMMMMMF
                                       MMMMMMMF                 .MD!    dMMMMMMMM$  (MM@`.MMNm.                                      dN+gggggg,....     .....                 MMMMMMMF
                                       MMMMMMMF                          ~!!!!!`    MMF  .MMMMN,                                    dMMMMMMMMMMMMMMNNNNMMMMM#>                (MMMMM#'
                                       MMMMMMMF                                    +#=    .HMMMN,                                   dMM"""""WMMMMMMMMY"""MMMN;                (MMMMM@
                                       MMMMMMMF                                    ?=       ?MMMNl...........                       dM#                  dMMM\                .MMMMM@
                                       MMMMMMMF                             .gm-...(gNNNNNNNNNMMMMMMMMMMMMMMNm                      dM#                  dMM@`                .MMMMM@
                                       MMMMMMMF                             (MMMMMMMMM#""""""HMMMMMM""""""MMMNs                     dM#                  dMMF                 .MMMMM@
                                       MMMMMMMF                               ?"""""=  .J++++JJ..?"=                                dMN,                 dMMF                 .MMMMM@
                                       MMMMMMMF                                        dMMMMMMMMMMNae..                             dMMb                 dMMF                 (MMMMM@
                                       MMMMMMMF                                          ```?""""""""9'                             dMM@             ....(MMF                 MMMMMM@
                                       MMMMMMMb.                                        dMMMMMMMNgm+                                dMMMMMMMMMMMMMMMMMMMMYMM$                jMMMMMM@
                                       MMMMMMMM[       .M#!  .ge.    Jx.              .gK=77777777HMM%                              dMNMMMMM9=7777?!`     H8                .MMMMMMM@
                                       MMMMMMMML.     .j#'jNNMMN..   ?M]               dMmgNa.......                                dMWB%                                  .dMMMMMMM9
                                       MMMMMMMMMo     .MF    JMY"=   .MF dNp           dMMMMMMMMMMMMMN;                             ?"`                                   .(MMMMMMM#
                                       MMMMMMMMMN-    .Mb.   JM{     .Mb  ?M]          dMMMF     ?MMMM\              .            ..                                     .dMMMMMMMM#
                                       MMMMMMMMMMN+    ?B>   JM{     .WB> .MF          dMMN%      jMM]              (Mm,        .J#>                                   .gMMMMMMMMMM@
                                       MMMMMMMMMMMML         ("!                       dMMMm((((..dM#!              ("YMP    .JMHY                                   .(MMMMMMMMMMMN~
                                       MMMMMMMMMMMMMp.                                 dMMMMMMMMMNMM@              .J.      .MMm,                                  .dMMMMMMMMMMMMMN_
                                       MMMMMMMMMMMMMMo.                                -TMMMMMMMMMMM5             .MMNm..     _dMm,                              .gMMMMMMMMMMMMMMMN_
                                       MMMMMMMMMMMMMMMNJ...,                                      7"                 _T"%       _TM[                           .JMMMMMMMMMMMMMMMMMN_
                                       7"""""""""TWMMMMB"""!                                                                                                .+gMMMMMMMMMMMMMMMMMMM=`
                                                                                                                                                           .MMMMMMMHB9Y77???????








-->
<!--                                                                                                       (a.
                                                                                                         ..dMN..  .NNe.
                                                                                                         .MYMMY^ ..MMMH`
                                                                                                          .g~TD ?MMMMm.
                                                                                                          (Mm.   jp ``
                                                                                                           ?MK   dMmJ.
                                                                                                    ..     ..      ??`
                                                                                                   .NN)   (MN.
                                                                                                   NM@`   JMN_
                        .&JJ.            .NNg,                                      ..             MMF    JMN_
                       dMMMMN-           JMMME                                     dMMm,          .MMNNm+.(MN,..gNNm,                    ..
                       ?MMMMM#           JMM#    ..-,          ..,.         .ge.    MMMNe.        dM#""HMMMMMMMMMMMMM}       ...        (MNp
                        ?MMMM#.          JMM# .(MMMMM{         dM#%         JMN_    MMMMN_        dM#      dM#?""TMM%       .MMN_  .(&ggdMN>
                         (MMMMNm,     ...JMM#.jMMMMMr          dMN.  ....   JMN_    vMMMN_        (MNt     dM#              (M#>  .WMMMMMMMK
                          (TMMMMNm.  jMMDJMMNdMMHMMM[          dMMMNMMMMM:  JMN_    .MMMN_                 dM#              MMF         JMN~
                            ?HMMMMNe dMMb(MMMMM% MMM[          dM#""""""=`  JMN_    .MMY^           .J+++++dMN....uMN&.     MMF       ..jMB`
                             .HMMMM= dMM@ dMMB!  MMM[          dM@          JMN&    MMM[           (MMMMMMMMMMMMMMMMM8`     MMF    .(MMMMM{
                              ?""=`  (MMNNMM#    MMMb.      `  dM@           ?"=    MMM\           ?5`  dM#BMN2``````       MMF   .MM%_dMMN,
                                      dMMMMM8    MMMN:    (JgNaMM@                  MM@`               .MM$ dM@             MMb.  .MMaJMMMM#
                                      dMMMMN_    MMMM{ .(MMMMMMMM@                  MMF                jM#!dM#              (TB:   ?MMMB=dM#
                       (gNNm.          ``JMN_    (MMM{ .MMm`?MMMMNm,               .MMF               (M#= dM#                           (T=
                       dMMMMMNe.         JMN_    .MMMaJ,JMNm. .dMMMMm,             dMM$               dM#  ?MMMNm+J,.
                       _TMMMMMMNggg,     JMN_     ?TMMM#=?MMNgMMM$_TH3             dM@                dM#   _777MMM#\
                         `!7HHHHHHB=     (MM`              ?THHY`                   ~`                ?T=





                (NNg,             (a,
                JMMM@            .M#%   ...
                (MMM@       .JJ,.dM@  .JMM)                                  `
                 _MMN/      dMMMMMMNgMMMMF`                                . (MNm,                                                      .(g,          ..
            ..    .MM#_      ``~~?MMM""9=                                 dNm._MMM}                                                     JMMN,        qM#>   (g+
           .dM#.   .MML.          MMF                                     ?MMM{                                                         .MMMR       .MMP   .TMMN,
           (MMMNp.   ?!      .ggggMMNggMMMN_         ..           .......  ?MMm.         .g&.             (&J.       .           J,      dMM#.      dMM$     ?TM8
            jMMMMMNNNNNNNm, dMMHHHHHHHB^?MM:      .+gMNR         .MMMMMMNm+ (TY_(ma. ....MMNa..          .MMMNe     (NNm,       uME..jNNNMMMMN&jNNNmMM#
            _T""""""""""""!  jN&((((((-..` ...    .MMM#^          7"`  (TMNe   .MMM:.WMMMMMMMM8          .MMMM@     (MMM@      jM#.MMMMMMMMMMMMMNMMMMMMMMN.         `
                  .+gggMNs   MMMMMMMMMMMMMMMMb    .MMMMb                 dM@   .MM\      MMF             .MMM#^      dMM@      dM# ?"!   (MM@   7"7MM#"""^ .JJ.     (Mb.   .(&g,
                  ?MMMMM@`   MMF       _??!MM@   .MMMMMN[              .gMME   dM@`      MMF             .MMMD       dMM@      dM#       JMM@     (MM$     .MMD`   jMM#!   (MMMN/
                 .... _(..   HMb.... ..    dM@   .MMMMM#_    ...     .(MM#=    MMF    ...MMb.            .MMN_ ....  ?MM@      dM#       dMM@     dMN_     .MM{    dMMF   .d#YMMF
                 dMMNgdMMb.  .MM\dMbJMN_   dM@   MMMMHMMNa..gMB!    (MMD       MMF  .gMMMMMMN-           .MMN_.MNM=   dM@      dM#       dMM@    .MMM`     .MM{    dMMF .(NK: MMF
                  ?TMMMMMB>   _!uM#^JMN_    ?`  (MMB^ (TMMMMMB!    (M#^`       MMF  .MMNMM#MMN-          .MMMNkMM=    dM@      dMNx      dMM$   .dMD`   ....MM{     MMNNMM@!  MMF
                   dNm..        dM@ JMN_        dM8      ?T9^      dMMmJ..     ?9'   .T""9^(MMB          .MMMMMN\    (M#=      dMMN.    .MM#`   (M#:  .gMMMMMD`     .MMMN:    MMt
                   MMMMMm.     (MN> JMN_                            ?TMMMB`                               (MMMB^     ?M8       ?MB"^    .MM#    MMF   .MM}.MMMm.     ?MM=    .ME
                   MMF?MMb     JMN`.dMN_                                                                                                (MMC    _^`   .MMNMM#M9`            .M@`
                   MMF dM@    .MM{ .MMY    (m,                                                                                          JMN~           (TB=`                 ?
                  +M#: dM@   .MMr  .MMa..  dM@                                                                                          .7=
                  dMMMNMM@   7MB:  .TMMMMMMMM@
                   TBTTHB=              !!!!!`
                                ..
                               .dMD
                               JMNa..
                               .dMYWMH_
                             ..+dN_
                             W#?HN..
                             ?MNMMB%










 -->
<!--                                                                          `                                                                                           ` ?Wk_._` .(wo_..........`..``
 ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` `   ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` ` `  ` `(Wc.._. _zk:........... ```
  ` `  `  ` `  `  ` `  `  ` `  `  ` `  `  ` `  `  ` `  `  ` `  `  ` `  `  ` ` `   ` `  `  ` ` ` ` ` `  `  ` `  `  ` `  `  ` `  `  ` `  `  ` ` ` `  `  ` `  `  ` `  `  ` `     XR-._.  +0>-....`..``. ```
 `    `      `  `     `      `  `     `      `  `     `      `  `   ` `    `   `     `  ` `  `.(-. `  `     ` ` `  `  `      `  `     `      `   `  `     `      `  `    ` `  jN2._-  (y>...`...`...````
  `  `  `` `  `  ` ` `  `` `  `  ` ` `  `` `  `  ` ` `  `` `  `  `   `  ` `  `  `` `  `  ` ``.v~.So-   ` ` `   `  ` `  ` ``  `   ` ` `  `` `  `  `   ` ` `  `` `  `  ` `  `    d#_  _._zC...``...``...`.
 `  `  `  `  `  `  `  `   `  `  `  `  `   `  `  `  `  `   `  `  ` `    `   `  `   `  `  ` `  (!.s<？U&. ``` `   ` `  ` `  `  `  `  ` `  `  `  ..`   `  `  `    `  `  `  `   ` ` ?Sl..`._(2 ....`.`.``..``
  `  `     `  `   `   `  `  `  `  `   `  `  `  `  `   `  `  `  `   `` `  `  `  `   `  `  ``  <_jHk.-?OA. `  ``` ` ``  ` ` ``  ` `  `````   ._ :   `  `  `  `   `  `   `  `  `   (S< _..__ `.``...`......
 `  ` ` ` `  `  `  ` `  `  `  `  `  ``  `  `  `  `  `  `  `  `  `    `  ` `  `  ` `  `` `  `-_.WgHHHe-_?U&................   ``  ``   _ `.(:`.<     `  `  ` ` `  `  `  `  `    `.ZI_...-<~...`.`.`.`.```
  `  ``  `  `  `  `   `  `  `   `  `   `  `  `  `  `  `  `  `   ` `   `    ` ` `   `  `     (.j@gmHHHH+-.JU=<!~` ````_~~~?<i(-.``  `` ``.+: `(<  ` `  `  `   `  `  `  `  `  `    (Xl_..._...``..`.`..`.`
 `  `  `   `  `  `  `  `  `  ` `  `   `  `  `  `  `  `  `  `  ``  `` `  `   `  ` `  `  ``` ._ dHHHHHg@H6!   `  `  `          ?C&.``  ``.z:   <~`  `  `  `  `  ` ``  `  `  `  `` ` wk:...`..`..........`.
  `     ` `  `  `  `  `  `  `   `  ` `  `  `  `  `  `  `  `  `  `     `  ``   `   `  `    `._ dHg@@qHY!  ``  `  `  `  `  ``  ` _7G..  .z! `  +_     `  `  `  `     `  `  `  `    `(Wk-.....`.......``.`.
 `  ``  `  `  `  `  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  ` `  `   ` `  `  `  ` `  (_ d@HHHY!   `  `  `  `  `  `   ` ``  .?G-(v`   ` 1` ``   `   `  `  `  `  `  `  `  `    dHs-._`.`...``..`....
  `   `  `  `  `  `  `  ` `  `  `     `  `  `  `  `  `  ` ``  `  `  `  `  `   `  `  ` ` `  (` jqR!`  ``  `` `  `  `  `  ` ` `   `` -dC`` `` (l.   ` `  `  `  `  `  `  `  `   ` ``` _dHo_ .`...`.`.. ``..
 `  `  `  `  ` ``.-. `  `  `  `  ` ` `  `  `  `  `  `  `     `  `  `  `  `  `  `  `  ` ` `._ `(W> ``  `    ` ` ```   `  ```  ``..jwd>``    `(<``   `  `  `  `  ` `  ` ` ` `` `  ````?Hk+ ........````.`.
  `  `  `  `  ` .!~j&.`  `` `` ``````  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   `   `(<  (C ``  ` ``  ``  ``      `   ..(+lOdV:``` ````j>  ` `  `  `  `  `  ` `` ..--___+wXWHm+(dHHx.--------.-.(zz
 `  `  `  ` ` .!`` .d:``  .--((--__.-_`  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   ` `(!`  ++   ` `         _~~_``   .jXVtOzd$!` ` ` .. j>   `  `          .. ..(+zv<_..--.._??7TTWHHytwrwwwk>((jwtw
  `  `  `   ._  ...dV~  `.j>` jkI~ -_   `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` ` ``  (_  (zI-`` `` -_____    -   `  .wZOO1w3  ```` (H$_d>   `   ..-<>;<u&uAAQyOXXwuwWqmHHgHQmA..  ?WHkwwXWVOwXwOX0v
 `  `  ` ``.+~_+dUW0: `  (> `.dHC__`  ``  `  `  `  `  `  `  `  `  `  `  `  `  `  `      ` (~  _?O6_ `` _       .-____````.dkzzv! `` `` (W@$_d_...JgQXC!  ` `(z?<？7717<<~``~??7WHHMgHI-` .4@HkrXuXOzZwWkw
  `  `  `  (! `.HR(v``` (c-..jH>-<(++-. `` `   `  `  `  `  `  `  `  `  `  `  `  `  ` ` `  (_ `  ` -<_. ..(++<;>?=z>_...~~.dXV!     ``.jWHmr(v<？7UWUUXww&.. (+! `` `` `         _?TMHZO- .(WHHWZZwXuXZVwH
 `  ` ````(<`` (K?z~   +=~?uQWD` j2~ js_ `  ` `  `  `  `  `  `  `  `  `  `  `  `  `  `` ` (_` `  `  _?zO<<uZz++<<_-(+<_.(v>~ ` ` `` .jWHWH{(> ` _?<？TV7zXHm+- `   `  ` `` `  `  .~!?WyOzXkXH@HkwwOZXkXXH
  `    ` (<``.(WD(>   +!` .d0U: -I!`(WD_.-(-.``   `   `  `  `  `  `  `  `  `  `  `  ` `  .>_ `   `    .-??711zOuswXUY7<!` `  `    . jWHkHD~(!` ` `    ` _~~?UXCzA&..`   ````` .J>   ?Wzv<<？7WHHkXwXwXWU0
 `  ` `` _  (dHHkI_ .+!   (Wkv_.Z1((d9>.c_ dk_ `  `  `  `  `  `  `  `  `  `  `  `  `   `.(k_ .`  ```` ?We.     ``` `  `  ` `  `` +>` ?THN%(z`   ```  ``.((~` ``_?7TUA+.   ..JZY!  -- ?Wc< ``jH@HkzwXXWXw
  `  ` `.+1&udHD?1- (! `.(XKZ!.v` jkwv_(C  Jk_`  `  `  `  `  `  `  `  `  `  `  `  `  ` (y71~ _ `   `   _vHo.     ``  `  `` ``   ,$_  ` ?9:(> ` `` ` .-+<`   `  `  ` _?4X&dV=!` `   ?1-?S+-   ZH@HkyyVXWk
 `  `    1< (UMR-(kAo--JdH80>_<` .XKU> l+(+dH!`  `  `   `   `  `  `  `  `  `  `  ` ` .JY` <~(< `` ` ``` .WH{```    ``  `  `  `  z{       .j: ``` ..(vC` ``` ` `  ``  ` _?TX&-+-.```` <<(Uk< `(W@MHkkwwWw
  `  `   jl(VOWMHyXkvusXM$i<_~`  (H0O~.C` ?WK!` `  ` `  `  `  `  `  `  `  `  ` `   `.d> ` <~(z_  `` `   jgHm_ `` `   `  `  ` ``.v_` `` ` (O!   .+I!` `         `    ` `   _?CXXXA+-.` _1zXk-  jM@H@HKWWH
 `  `   `.1zz~(WMXHD`(4H#>(WI-.(+XDw: +< .(XR~ `  `   `  `  `   `  `  `  `  `  `   (v!  ` (~(X_ `    ``.XggHl ` ` `  `  ``` `` (w< ` `` (<>_ (x7! ```  `  ` `  `  `  `` ` ` ` ?Twz7TU&...TWk- (WMMHMHVUX
  `  `  `` jw_ dHHHt_`.XN>(>`_jwXZ(+_.1<.jHgR~`  `  `  `  `  ` `  `  `  `  `  `   (v~``   <_(X!`   `  `.X@g@k- ` ``   `    `  .+XI~ ` .+!.i_ _`` `  `  ` `  ` `  ` ``  `` ```    ?1&._~<<~?X2_zvgH@MMkkk
 `  `  ` `  ?OJdKvV>(<(XDjs:` .XHHdW6w!_jdHHH+.  ``` `  `  `  `  `  `  `  `  ` `.JC`  ``  (_(<```` ``  (XHHHHm+.   ` `  `  ``-?zd$   .<~ .vO<.`` ` `` `   `  `  `    ` `      `` `` ?1+-.` (AI<zjWHMMHHH
  `  `  `  `  ?7WHWWZ___1dHn-(dWmHwXe+. (W@MH>?z+. ``  `  `     `  `  `   ` `` .JC``` `  `(_ _  ``  ` (zXHgHHggHe.  `  `  ``   (WD~ __<_.vI<？+.`  `  `  `  `   `  `      `           ` _<+--?Oz>.HMHMMHV
 `  `  ` ` `` `` ?7WHo-_(XHMC?TWH@HH@HC<vHM@HI `_?I-`   `  ` ` `  `  `  `      jC `  ` ```(:``  .. ..(XHHHHqHgmkHo    `  `   `  >! __(~((>_1-_<-   `  `  `  `  `  ` `` `  ` `  `   `` ``` _dkwR-vOHWHgMk
  `  `   ``  ` ` `` ?UkzXWWW&_` vH@MM6+<<JdH@Hx-. (w_``  `  `   `   `  ` ``  `.k<` ` `  ``(:`(&+zzjdWHHgHHqmg@gHH$  `  ` `  `` .c  `-jv(I` (1_ (-      `  `  `  `     `  `  ` ` ` `  `  ` `(WHX0>.WHHHMH
 `  `  `      `       ?I.(wzWHXAdHMMMk&.JHMMM@MHk+(K:  `  `  `  `  `  ` ` `` `(Wk-  `   .--< dWW9UXkkHggHMHgH@HH3``` ```  ` `  &:``` `-z`  `(<  <o. ` ` ` `` `` `  ``````` ` ` `` ``    `` -OWHk>.QWVOMM
  `  `  ` ` ` ` ` ` ` ` ?7WHm-_?zkZ7THMMmqHH@@@@@@HI-` `  `  `  `  `        ` (pWko-...++I(<_dH! `?7MHbHHHHHH9>`  ` .(&QAa+-.(+$  ``  (kJ--. 1<  zl  ````` ``  ....-(---.. ``  `    ```   ` (zXko(dHkW@H
 `  `  `   `   ` ``  ` `   jVUAJ&wXA+zUWHMg@@@@MHHHWXm_``  `  `  `  ` `` ``   .W9XWkwO+<jI_(_dS` `-+!ZHkdHH>` `  .+dH9=!(?7?THHy.`   .vT7?TWAqk `(kx-.   ..(+<<<<<!~~~<1zzz-(---  ``   ``` _+zOOOZWHHMHH
  `  `  `  ` `     `    ``.z<d0WdHHHHHm+jWHHMgHS<d0dHR_  `  `  `  `  `  `  ``  jWWHHkkwZjS~(_(k- `(?_-dHwwv~` ` .XHU> ` .<~` jH>     +< ```(U@0` (wC<<<<__```   `````  _<1<zWWWHA&z+_`  `  `` ?<？VVXHMHW
 `  `  `  `   ` `   `  `    _dWkkk<jXWH077WHHg@HHHHHH0`` `   `  `  `   ` ` ``  (HqH9WUVC?S_-_-XR- (O!.+UzC<_  `  z6d>  __(! .dC `` `(z``  ` jHC  .X{ ```    `        `  ` _<1XXHUY!````   `` ````` _7WHk
  `  `  `  `  `  ` `  `   ` ` _ZMHHHHHHHagWHMHHMXHDTWZ```  `  `  `  `  ``  ``.+zdD!.-_(<.z_ -. ?UUzOwXAQm{ ` `  ` (Xki.&J<.(dY``  ` j!`  `  (V~  ($```  ` ``  ` `     ``    (d0C````  ``  ` `    ....`_1
 `  `  `  `  `  `  `  `  `     (HNmz?TWWX@@@@HUWNkXmWH+`  `  `  `  `  `   ` (v~J=.JZC+- ?U{`(< ``` ` ?HM#>    ```  ?TUHHWUY>```   `(v` `` `.j!  .X{ `  ` `  `  ` ` ``     .(xC! `  `    ``   (+zXWB90O(J
  `  `  `  `  `  `  `  `  ` ``  (VTHme-?WH@@HC_OHHHWHHH-  ``  `  ``  ` `` .JC`<!  _`._?+.j{  +-` `   -XHD`` `  `   `    ` `   `  `.dk_ ``  (>` .jD`` `  ` `  `    `  ``  (dV! `` `  ```   .(dXV<~`   (vT
 `  `  `  `  `  `    `  `  `  ` .OmxTHHk-?HMH>  OHWfWWkI-`  ` ````  ` `  (v<.(++gAx- ?z(wkl `_z.  ``  XH> `  `    `      ``  ` `` (HH<`  `.<_  (K:` ``     `  ` `   `` .(W$``   ` `` ` ` (jv7Uz01+-.J<__
  `  `  `  `  `  ` `  `  `  `  ``.UHmxjW3(HMH>`` dHWVUHHl  ` `    `  ` .zwdZ<!~~_?TUo-_OXHr   (z. `   ?C  ``  ` `  ` `    `  ``  (WHH:`` .<~ `.XD~`` ` ``  `  `  `    (uK3`    ` `   `` (v<``(< _+wYC<+r
 `  `  `  `  `  `  `  `   `  `  ``(HgHI~-WHgMl   (UV: ?WHx `  ``  `` (s0jWI_....````_juJWHR_`  <y- ` `` .``    `  `  ` ` ` ``  .JKUXS!  (>` `.dUSz+. `  ` `  `  ` ` `(dH$```````  ``   +v!  `-<.JC_(dUww
  `  `   `  `  `  `  `  `  `  `   .dHHI`(H@@Ml   .1w<  -vHQma.   `  _w+(v<`   _<<-. ` ?WkHMn.  (wo.   .dmmgA+.`   ` ` `` ` ``.JdWH9Y6~.<`` .(WC` _1O< `  `` ` `  `` (dU$` `     ` ``  yC   ` .jI~.OOvz_?
 `  `  `  `   `  `  `  `  `  ` ` `.dkH> .X@@HI  ` (Oz.  (WHH@H+`` `.+OUC``  ` ``  <+.` (UHHHn- .HHo.`` ???TT9C`` `` `   ` .(zAq@#3` (<!  (jXV! `   jz- ``` ``    .-(dWR!      `   `` jC_ .((?zC~.zzwZ!``
  `  `  `  ` `  `  `  `  `  `   ` (WHR! (X@@HR_ ` .1O_  ,HHUHHk-.`-<~.zk--.  `` `   <__(dHMM@m-JdHHk<  ... `` `      `` .JQWHHM9<(<<~~_+yXUI+(--(((zXZXA&&+JuQkmkWWHHHI  `  `  `    (v~jy<-..+~(I?7T>``_
 `  `  `  `   `   `  `  `  `  `  `(WMC .dm@@MH_``  (O<  (HHXVH0?4As&uv!``~!<1i- `` ` zzjdHHm@MHXHgH@Hx(dgHm-  ```` ``.JdHHHY!  .....(+!`  ` ` ` `     `````~?!!<<!<<1U>  ``  `  ` ` d> _Cz+wXv(jQo.. .-_
  `  `  `  `  `  `  `  `  `  ` ` `(HH>(XH@@@HHy  ``-zz`.dM@Hodk  _jWI``  ```  ?+. `` (XHHHgHWIdggMHM@HHH@@MH-`````.(dWH9OU0&uQWHMHkz-.   ` `      `  `    ` `` ``` `(X_` `  `  `   (d:`` (zOw<jWW$?1dHC+
 `  `  `  `  `  `  `  `  `  `   ` JHM>z@HgHgHHHx `` (z.(MgggMMS  ` (Ow++-..   ` >.  -jWHHWXV>dHMH8HM@g@gHHHM6_ .(&WHHHHHVW0Y=!!!~~``  `  ```` ``````` ```___(;+(-J+udk< ``  `  `   (Z~` `  JI:d0(> _TI-~
  `  `  `  `  `  `   `  `  `  ` `.dHU<(HHmm@HUHH< ``(+dWMW@HMMH_     (z .?C:.  ` ~.(dWWWVT7~dMMS1jpHMHHmHH@HmkpH9=! _dHHHSz:(-. ` ` `` `   `     `    ` ``  `    ` _?W>   ``  `  `.jZ.`` .<？1+dHyw&-(WkQ
 `  `  `  `  `  `  `   `  `  `  ` dRX! ?WHH@@kOHR-  (dH6zV7W@H=  ``  -1<   (<.` .(jXHHWV!`(dHH01zdHHWWH@HHH@@HR-`  ` dHMHZ0w+zz<-  `  `` `  `` `  `  ` `   ` ```` `  dk_ `   `` ``.dI``.(! (<>dWHp0WodHm
  `  `   `  `  `  ` `  `   `   ``.dH0-.` _??TY>_?SAdHUXQmeuWH>  ``    +I.` `(_.(uXSOZC!`.J011zOztOCzXWWWdWHHgHHHo.   dHmHHkXwO>_.   `  `  `   `  `  `     `        ` dHo. ....-((xwX> .ux-(+wzXWHXWZz<CW
 `  `  `  `  `  `    `  `  `  ` `.dHHvXn..(((((&&-(+dH@@MHMHWo--. ``` (Z1-_(zzzOWU6>` .JkCz1wOukAzzlzwyXUVwUUUXwk-..(dWgHHWyZwOz_ ```  `  `  `  `  `  ` `  ` `  `   `jHNc`._<<+?<zXWI`-?<？VUWo?UdSzds-->
<!-- `  `  `  `  ` `  `  `  `  ` (dMNodHHkI?1WMM@Ho<zW@@HK=~~!~~<1<.   O<z+dO+zC>~  (dwWkIzwWWWWHWXXWHSwz+wOzOzI+wWXXWHH@gHWWXXXOz-. ` `   `   `  `  `  `  `  ` ` `  (XHK__~<~`_(jwdk_`` `  (TCzXsdWY<(O
 `  `  `  `  `  `  `  `  `  `    _zXWM@H@HkmQH@@@@MgHHMB=`  `  `  ~_  .OwZXX0>`    .dHUSz<zVTOwWWXUXXWHkwXXWWwwsOZWWWHkHkWHkwOrwwwz+-.` ` `` `` ``  `` `` `` ``` `  `(XHNs-__(+zzVXWS_  ``  (_`.XY<？Gv(w
  `  `  `  `   `  `  `  `  ` ` ` (dkXUTHHHHHHkMMHBYY77!` `       ` <.` OykZ<`  `` (dBXZ>(+1++zOX0OuwyWHHHUWWUyZ?1zzXWHWWWkXWHHHWHHHWky+-   `   `   ` ``     ``   `  .dWHHNm- _~<1OwX0_      (-(C!   _(v`
 `  `  `  `  `  `  `  `  `    `  (dH0U+   (OwwZ<! `` ``   `` `  `  (-  <？C!  `` .dV3uZ1uwywXOzsQkHUYTTUXwwVOZXXwO+<zCwWkWHkWkqmHMHHHHHkAe&-.. `  ``    ```  `  `  .(jXWkWHHWe--_(ZXdw_`   ``_!``  .(w>_u
  `  `  `  `  `  `  `  `  ` `  ``(dMk<1+ ` (zOz< `     ` `  ` `  ``(< `  `  `.(dH$<+1wWZXWWHkWUY!` `   _?1zOdkWZXAwIzwXWHUUUXUUWVS1OWHMHM@HkkmA&-..  ``   ...((+++lOXkXWHHHH@MkAZzwXWA. ` ._+z  .JX=`.jH
 `  `  `  `  `  `  `  `  `  `    (dfHn_Xx``` <<<z- `  ` `      `   jz_ .(-.(dkq81+<+zC11zdHH9!`` `  ` ``  _1XpkWXHXZzOvIv?<<zOOVSzzwXZ1XXWMHqHHgHkWQmQQ&&+uz&u&uQkkpHHHW@HHWWWHHo__(ZTUo-<!_(!  ?C~ .dHC
  `  `   `  `  `  `  `  `  `  ` `  ``` <C<.` (+uwz-. ` `  `` `  `` (z<.(HkkWHH0zI+?1<;++zZV! `          `   ?WWUXfkwz+zOzwzzv1OXSwvOXZ1wHHUUU0XUOCZWHHHHmmHWUUVXHHRwXkwWWWWkXwWMHkm&-   ~       ..J?<vI
 `  `  `  `  `  `   `  `  `  `        `  ?zA&zwUOwZv_```    `  ```.(+<<O@HM9IzwZzzOzzzwOZ!`    ` ` ` `  `  ` ?wOXXkkXXWWuuXI<+X0kZtOZ<+lv<1<+1zzIjOwWHHWMHXXZOlyWHHHgHUOwWHHkXWHHS>?UWaJ-++&zZVY=!` `_O(
  `  `  `  `  `  ` `  `  `  `  ` `  `  ```.?<7TXWkw+_ ` ``` ` `   .j>_(XMHS1=wVXXwOXWW0>`     `   ` ` `  `  ` ?wXWHWUUUUX0Ov11wfkOIv1zzOudkwwXWXdkZOwXWWHWHWkkX=dHWWUXZzjXHHqHMM6!  (WY!~  ` `` `` ..JCw
 `  `  `  `  `  `   `   `  `  ` ` `  `    `    -?vHko_``     ` `  .+<(XHMM61Z0ZOOXIdXC!  ` `   `       `  `   ` ?TWkOz1zwkXo_jzXS1+dXWHWWWXWWUWHHkyzzzOOwWXXWH0wwwXXHHk+zOXU0WHMy  _vS~---.....--<<!`  <
  `  `  `  `   `  `  ` `  `  `     `  `    ` ` `` ?Hk+.  ````  ` (jwwXHW8>+z<;<<<=Ok>` `` `` `  `` ` `  `       `` _?1zuXwkI<=zv1jXWUwOwXXZC1wVdHHIdWWOtOOOwXWQkkWWWWkXkkZ<>1XHMN<  (X_`   ```    `  ``.
 `  `  `  `  `  `  `  `  `  `  ` `  `  ` `  `    ``?UWk&-..   .(JudHHHH6(zz++<;++dV! `        `   `  `  `  ` `        ` _?C1zOzOvY7<？7?777TCOOwXHHWWbkwO?+11dHHHH9vOXWWWHwwOwOOWH$_ (XI   ``  ``  `` .(O
  `  `  `  `  `  `  `   `  `  `  `  `   `  `  `   `  _7UUWkkQXkHmHUZwOzdkkwwwwwvV>` ` `  ` `  `  `  `  `  ` ` ` `  `  `    `    `          `   .?U0wWHkWXwyOwXWpkwOOVOdHHWWZOz=dMk- _<TA..........(+?<`
 `  `  `  `  `  `  `  `   `  `  `  `  `  `  `  `      ``  ?TCOWH9IwXXwUXHqHp0y0<`  ` `  `  ` `  `  `  `  `     ` ` ` `  `      `  `` ` `` `     ` ?vUuWWkkkXWkXHgHXwwZOXWWkkWXwXHH;`  jK=````````` `  `
  `  `   `  `  `  `  ` `  `   `  `  `  `  `  `  `` `  `  `  ?w0z(OwXWUV0XVXkZ7` `` `` `  `    `  `   `  `  ` `    `   `  ` `  `  `  `   `  ` `` ` ` _?WWHHHgHHHHHHHWkwzwWWHHWWHHXHk&. jR_ `        ``  .
 `  `  `  `  `  `   `   `  `  `   `  `  `  `  `   ` `   `  `  _?1z0OwOOzkZY! ` `      `  `  `  `  `  `   `  ` ` `   `  `  `  `  `    `   `  ``  .     .??TWHHkWWHHHHY<!!`  `  _??7WI~<(XR&---_(((<>+j-_<
  `  `  `  `  `  ` `  `  `  `  `  `   `  `  `  `     ` `  `        _~~~``   ` `  ` `   `  ` `  `  ` ` `  `     `  `  `  `  `  `  ` `  ` `   ` _<<<<<？+7OU0COUVU9UUVOOzz++++--..J+&dHkQQk<``  ```  ` (w&s
 `  `  `  `  `  `   `  `  `  `  `  `  `   `  `  ` ` `   `   `   `   `     `    `  ` ` `  `   `  `  `  `  ` ` `   `  `  `  `  `  `   `  `  `  ` `` `  ````  ``     ``    .-JdWH@@MkWH@mHNme-.`` `     ?XH
  `  `  `  `   `  `  `  `  `  `  `  `  `  `   `  `  `  `  `  ` `  ` ` ` `  ` `  `    `  `  `  `  `   `  `   ` ` `  `  `  `  `  `  `  `  `  `` `  `  `      ``  `     ..dWMMHHHHH@@MM@@M9THMm&-(+zzI1-.(U
 `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` `  `  `  `  `  `   `  `   `  `  `  `  `   `  ` `  `  `  `  `  `   `  `  `  `  `  `  `  ` `  ``     ``` ` ` ``   ` ..J&gQW9Y!` ..J&kHY^?WHHzjXMH@HI~``  _~__
  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   `  ` ` `  `    `  `  `  `  `  `    `  `  `  `  `  ` `  ` .(((JgQQkZOQmQQgae(JJggHgHNHHk&+zzOT777<++gQWkXH@H@H@HMS       `
 `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` `  `  `  `  ` `  `   `  `  `  `   `  `  `  `  ` `  `   `  `  `  `  ```  wXH@HqHHkAadHH@HWUWWWUVVHMHMHkA+-- .(QQHHHH@HMHHWHgHHHHR ` `  `
  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   `  `  `  `  `  `  `   `  ` `  `  `   `  `  `  `  `  `   `  `  `   `  .dHW0I1zwXHHH@MHMHHHs-_<<？?=!`~~~`  .jWH@@H@@MM@@@HKVCvzWS_ ` `` `
 `  `  `  `  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   `  ` ` `  `   `  `  `  `   `  `   `  ` `  `   `  ``` .(XHkWHHUUWMNkXWMHI((WMHQAmA&-((......(TB9UXwzOwwXWmHHkrz+1V~ ``
  `  `  `  `  `  ` `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `    `  `  `  `  `  `  `  `   ` `  `   `  ` ` ` ` .dVYCzHMgHHkkHHgHkXMHkWMMHHH@HHH@MMHM91(+QWHMHHMMBYYYYWHKdy-jR--..    `
 `  `  `  `  `  `   `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `    `  `  `  `  `  `  `  `  `  `  `  ` `` ` .JQU=-jWMM@@MHHmgH@g@HWM@HMHHgmqmgHMMWWXQWMMB97<!`  ``` .dHdWMHHS=z><-.(&+
  `  `  `  `   `  `  ` `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` `` `  `  `  `  `  `  `  ` `   `  ` `  ` `.(xZC>_(wz(z0<？7TH@gHWH@@HXMHv~jHHgH9YOgWMMHkA+JJ(---..  .+WSdWHH@HCz<<1<1wX0
 `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `    `  `  `  `  `  `  `  `   ` `  ` ` `` .(lOI<+1+7OwUzXHHm+vVHMkdH@@kZHWkW@@8!(gHHWWWXWXUXWWWgHHHWkWSkZ>(W@MWOz<+?<_~<<
  `  `  `  `  `  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `    `  `  `  `  `  `  `  `  ` .......(<1v>~(V~_~(vUI?OWHMSzQwWMHHHgMkXH@@@HwXHRj&dMMMHI+dMHH9<<XWWWHHNmdMMUCC<<<~__~<_
 `  `  `  `  `  `  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` ` `   `  `  `  `  `  `  ```.(v<？<<<<(-<! .JWI+Oz<OMl.OC?XIX9UXHHMMMMXWMH@HI<zXHHkWHHkmHgHHHqWmkHmHHMgHH9=!` ``` `  ```
  `  `   `  `  `  `  ` `  `   `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   ` `  `   `   `  `  `  ` .J<!_.-`.+<_...jHgMIzHf_`_7_.JJOIz<？WHMHMMHwwdWMHXXWHMH@MHH@HHHkmyVHHCjW@HHH9^ ` ``  `  `` ..
 `  `  `  `  `  `   `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `    `  `  `  `  `  `   .(<~  ><-(d+?7?4HMM@HR(v$--.  ?T8{(1_(OWMH@H0W9UHkWH@@@@@H@MHMHM@MMHWAdWKY<!        .-..-(JgQH@
  `  `  `  `  `  ` `  `  `  `  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   `  ``.<~ ._ _<dWC` `.jMgHWHHkz0I~?+- ..+j<(zdHMHH8!``.dMMM@HH@@@@@@@MMHHY?!~ (4A..`` ..JgdHHH@Mg@@@@M
 `  `  `  `  `  `   `  `  `  `  `  ` `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` `  `  `  `  `  `  ` (v<_`__+x1I<_-.dH@@HH9YTSx<1wXw&xz+dZzdH@@@HC ` .dMM@@@@@@@@@g@@M9!`````` _?1zwXWHHHM@@@g@@@H9C!
  `  `  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `   `  `  `  `  `  `   (>-+-+I! .<&+zXMMHKC~   dHCwsz+wkwXQWHHBTXHK!`  (HMM@H@H@@H@M@@M$```` ..Jzzw&+uwX61+ZOXH@gH9:_ `
 `  `  `  `  `  `  `  `  `  `  `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `` 1z<？<+JJ+J+XM9~dMHS-.``.j#>(dHB=<!<1&uQAgHM$`` .WM@HH@@@@g@@HMK>  .(+xwkkrwvXXHHHkkkmQHM861<! `
  `  `  `  `  `  `  `  `  `  `  `  `   `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `      (>   _4H@H9^-(+VT8>?<_.dHHHHYYC  JdH@ggggHD~  .dMHgH@H@@@@@MM91JQXWXXXWWkXWHHHHHWHHggH91J<!   .
 `  `  `  `  `  `  `  `  `  `  `  ` ` `  `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `` `.I!  +QzW9~-z<<I` (ua&dHHH8>`  u&JWMHg@@H9!   .d@HMHHM@@@@HHHXXWUTAkWWWHMMM@HHWWH@@MMY1+C! `  _-
  `  `   `  `  `  `  `  `  `  `  `   `  ` `  `   `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` <:  (XY!+z<!(<`  .(d@HrWHHR?>.jWHMD!jW9=!` ` .dqWMHHHHHHWWHgmHSAkHUXWkHHHHHmHHM@MHH$izI! ` `  +_
 `  `  `  `  `  `   `  `  `  `  `  `   `   `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  `  ` (>  (dHcz~ .JI-(.JXHB=<jWHW0jdvWMM0+Jv>``` ` (X0W@@@MH0wXWUWHHXVYIzXHHHWWkHH@@@@H9C+v><~` `` ` dI
  `  `  `  `  `  ` `  `  `  `  `  `  `  `  `  `  `  `   `   `  `  `  `  `  `  `  `  `  `  `  `  `  ` (1uaQdgHV` Jv` _dWHH$<(?~+!` ?WC(XHHkc_````  (WHWHHHM@HWUUwXHWY1+wWWH9XUUWHHHMMHY~(OI<``   `    z:
 `  `  `  `  `  `   `   `  `  `  `  `  `  `  `  `  `  `  ` `  `  `  `  `  ` ` `   `   `  `  `  `  ` `_(?WHHM9~ J!   .dH=<z<` (~   .dIv~?HNt  `  `(WHHH@@MHUXkAWH0C&dYIdWWXUGdWMMHBY!_.Z1<~`   `    `(Z_
  `  `  `  `   `  `  ` `  `  `  `  `  `  `  `  `  `  `  `   `   `  `  `  `   `  `  ` `  `  `  `  `  ` z-(WMY!`.I ` (XY~-!  `(<-(jeJd0~ .H@:`  ` .jHMMHH81JUHHXWXdkIuWHWwdkWMNHB=! ` (<<_``  `  ``` .jI_(
 `  `  `  `  `  `  `  `  `  `  `  ``  `  `  `  `  `  `  `  `  `   `  `  `  `  `  `                  ` ~`_=?`  `~  _?!  ```  _   _?^~` `.7! ``  _!?7777!_!?7!???????????77777!`` `  ```~``    `      ?`_? -->