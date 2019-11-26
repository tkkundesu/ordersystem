<link rel="stylesheet" href="css/owner.css">
<?php
require "Drink.php";
require "config.php";
$order=new Drink();
$sql=$order->getProducts();
if(isset($_REQUEST['command'])){
  switch ($_REQUEST['command']) {
    case 'update':
      $order->product_update();
        header("Location:owner_drink.php");
      break;
    case 'change':
      $order->product_isview();
      header("Location:owner_drink.php");
      break;
    case 'change_milk':
      $order->product_milk();
      header("Location:owner_drink.php");
      break;
    case 'change_sugar':
      $order->product_sugar();
      header("Location:owner_drink.php");
      break;
  }

}
if(isset($_REQUEST['insert'])){
$order->product_add();
$order->upload();
header("Location:owner_drink.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charaset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>ドリンク編集</title>  <!--画面タイトル-->
</head>
<body class="owner_body">
    <h1 class="owner_h1">ドリンク編集</h1>
    <fieldset>
    <h2>ドリンク新規追加</h2>

        <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="insert" value="insert">
          <input class="form-control col-sm-3 owner_form" type="text" name="new_product" placeholder="ドリンク名記入欄">
          <br>
          <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFile" lang="ja" name="image">
          <label class="custom-file-label col-sm-3 owner_form" for="customFile">ドリンク画像選択</label>
          </div>
          <br>
          <br>
          ミルク、砂糖が利用可能なドリンクならチェック
          <br>
          <label class="btn btn-primary btn-pls owner_bottan">
          <input type="hidden" name="milk" value="0">
          <input type="checkbox" name="milk" value="1">ミルク利用　有
          </label>
          <label class="btn btn-primary btn-pls owner_bottan">
          <input type="hidden" name="sugar" value="0">
          <input type="checkbox" name="sugar" value="1">砂糖利用　有
          </label>
          <br><input class="btn btn-primary btn-pls owner_bottan" type="submit" value="追加">
        </from>
      </fieldset>
      <fieldset>
    <h2>既存ドリンク編集</h2>
      <table class="owner_table">
        <tr>
          <th>ドリンクID</th>
          <th>ドリンク名</th>
          <th></th>
          <th>提供</th>
          <th>ミルク</th>
          <th>砂糖</th>
        </tr>
      <?php foreach ($sql as $row) :?>
        <tr>
          <td><?php echo $row->id; ?></td>
          <td><form action="" method="post" >
            <input class="form-control" type="text" name="product_name" value="<?php echo $row->productName; ?>">
            <input type="hidden" name="command" value="update">
            <input type="hidden" name="product_id" value="<?php echo $row->id;?>">
          </td>
          <td>
            <input class="btn btn-primary btn-pls owner_bottan" type="submit" value="更新"></td>
          </form>
          <td>
            <form action="" method="post">
            <input type="hidden" name="command" value="change">
            <input type="hidden" name="product_id" value="<?php echo $row->id;?>">
            <input type="hidden" name="product_isview" value="<?php echo $row->is_view;?>">
            <?php if($row->is_view == "0" ){
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="on_drink" value="提供中">';
            }else{
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="off_drink" value="停止中">';
            }?>
          </form>
          </td>
          <td>
            <form action="" method="post">
            <input type="hidden" name="command" value="change_milk">
            <input type="hidden" name="product_id" value="<?php echo $row->id;?>">
            <input type="hidden" name="milk" value="<?php echo $row->milk;?>">
            <?php if($row->milk == "1" ){
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="on_milk" value="ミルク利用可">';
            }else{
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="off_milk" value="ミルク利用不可">';
            }?>
          </form>
          </td>
          <td>
            <form action="" method="post">
            <input type="hidden" name="command" value="change_sugar">
            <input type="hidden" name="product_id" value="<?php echo $row->id;?>">
            <input type="hidden" name="sugar" value="<?php echo $row->sugar;?>">
            <?php if($row->sugar == "1" ){
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="on_sugar" value="砂糖利用可">';
            }else{
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="off_sugar" value="砂糖利用不可">';
            }?>
          </form>
          </td>
          </tr>
      <?php endforeach;?>
      </table>
    </fieldset>
  <?php require "footer.php"; ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
