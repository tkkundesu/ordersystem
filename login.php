<link rel="stylesheet" href="css/login.css">

<?php
require "Drink.php";
require "config.php";
$order=new Drink();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $order->owner_login();
  header("Location:owner_drink.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja" height=100%>
<head>
  <meta charaset="utf-8">
  <title>マスターログイン</title>  <!--画面タイトル-->
</head>
<body>
<div class="field">
  <fieldset>
    <h1>owner login</h1>
    <form action="" method="post">
      <div class="iconPassword"></div>
      <input type="password" name="owner_pass" placeholder="Password" required>
      <input type="submit" value="Enter">
    </form>
  </fieldset>
  </div>
</body>
</html>
