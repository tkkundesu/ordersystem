<?php
  require "Drink.php";
  require "config.php";
  $drink = new Drink();
  $sql_products = $drink->getProducts();
  $sql_getDrinkorder = $drink->getDrink_order();
  $sql_order = $drink->setOrder_detail();
  $sql_drink_order = $drink->setDrink_order();

//カート内、個数変更、削除
  if(isset($_REQUEST['count']){
    switch($_REQUEST['count']){
      // ∔ボタン
      case 'plus':
      break;
      // -ボタン
      case 'minus';
      break;
      // 削除ボタン
      case 'delete';
      $drink->cart_delete();
      break;
    }
  }
?>

<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>注文システム</title>
  </head>
  <!-- ヘッダー -->
  <div class="header"></div>
  <!-- ハンバーガーメニュー -->
    <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
    <label for="openSidebarMenu" class="sidebarIconToggle">
        <div class="spinner diagonal part-1"></div>
        <div class="spinner horizontal"></div>
        <div class="spinner diagonal part-2"></div>
        <div for="openSidebarMenu" class="menu-background"></div>
      </label>
    <!-- ハンバーガーメニュー中身 -->
    <div id="sidebarMenu">

      <ul class="sidebarMenuInner">
        <!-- 選択されたドリンク、個数を表示 -->
        <?php
        if(isset($_SESSION['product'])):?>
          <form>
          <?php foreach($_SESSION['product'] as $id => $product): ?>
          <li>
            <!-- 名前 -->
            <span><?php echo $product[$name]; ?></span>
            <!-- 個数、変更ボタン -->
            <span>
              <form>
              <input type = "button" value = "+">
              <input type = "hidden" name = "count" value = "plus">
              </form>
              <form>
              <?php echo $product[$count]; ?>
              <input type = "button" value = "-">
              <input type = "hidden" name = "count" value = "minus">
              </form>
            </span>
          </li>
          <?php endforeach; ?>
          <li><input type="submit" class="btn btn-c btn-primary" value = "決定"></li>
        </form>
        <?php 
        }
        
      </ul>
    </div>

    <!-- 商品一覧 -->
    <body class = "body">
      <div class = "container">
        <table class = "table table_c">
          <thead>
            <tr>
              <th>Drink</th>
              <th></th>
              <th>Select</th>
            </tr>
          </thead>
          <tbody>
            <form>
              <?php foreach($sql_products as $row):?>
              <tr>
                <td><img src = "./images/drink<?php echo $row->id;?>.jpg" width="180" height="180"></td>
                <td><?php echo $row->productName; ?></td>
                <td>
                  <select name = "count">
                  <?php for($i = 1; $i<=10; $i++){
                    echo '<option value = "',$i, '">',$i, '</option>';
                  }?>
                  </select>
                </td>
                <td>
                  <input type = "hidden" name = "product_id" value = <?php echo $row->id;?>>
                  <input type = "submit" class="btn btn-pls btn-primary" value = "選択">
                </td>
              </tr>
              <?php endforeach;?>
            </form>
          </tbody>
        </table>
      </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script type="text/javascript" src="my.js"></script>
</body>
</html>