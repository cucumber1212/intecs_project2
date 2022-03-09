<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/cart.css">
<?php
$pdo=new PDO('mysql:host=localhost;dbname=zururu;charset=utf8','staff', 'password');

$delete = $pdo->prepare('delete from cart where customer_id=? and cartfood_id=?');
$delete->execute([$_SESSION['customer']['id'],$_REQUEST['id']]);

echo '<p class="cart_delete-message">カートから商品を削除しました。</p>';
require 'cart.php';
?>
<?php require 'footer.php'; ?>
