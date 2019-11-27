<?php
  require "Drink.php";
  require "config.php";
  $drink = new Drink();
  $sql_products = $drink->getProducts_isview();
  $sql_getDrinkorder = $drink->getDrink_order();

  //カート内、個数変更、削除
  if(isset($_REQUEST['count'])){
    switch($_REQUEST['count']){
      // ∔ボタン
      case 'plus':
        $drink->count_plus();
        header("Location: main.php");
      break;
      // -ボタン
      case 'minus';
        $drink->count_minus();
        header("Location: main.php");
      break;
      // 削除ボタン
      case 'delete';
        $drink->cart_delete();
        header("Location: main.php");
      break;
    }
  }
  // 購入
  if(isset($_REQUEST['purchase'])){
    $drink->purchase();
  }
  // カートに入れる
  if(isset($_REQUEST['cart_insert'])){
    $drink->cart_insert();
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
    <link rel="stylesheet" href="../css/style.css">
    <title>注文システム</title>
  </head>


  <div id="sidebarMenu">

    <ul class="sidebarMenuInner">
      <!-- 選択されたドリンク、個数を表示 -->
      <?php
          if(!empty($_SESSION['product'])):?>
            <span>
              <li>
                <strong>ご注文内容<strong>
              </li>
              <hr>
            </span>
            <?php foreach($_SESSION['product'] as $id => $product): ?>
              <li>
                <!-- 名前 -->
                <span><?php echo $product['name']; ?></span>
                <!-- 個数、変更ボタン -->
                <span>
                  <div class="group">
                    <form>
                      <!-- プラス -->
                      <input type = "submit" class="group_s btn btn rounded-circle p-2 btn-c" value = "＋">
                      <input type = "hidden" name = "count" value = "plus">
                      <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                    </form>

                    <!-- 現在の個数表示 -->
                    <a class="group_s number"><?php echo $product['count']; ?></a>

                    <form>
                    <!-- マイナス -->
                      <input type = "submit" class="group_s btn rounded-circle p-2 btn-c" value = "―">
                      <input type = "hidden" name = "count" value = "minus">
                      <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                    </form><br>

                    <form>
                      <!-- 削除 -->
                      <input type = "hidden" name = "count"  value = "delete">
                      <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                      <input type = "submit" value = "削除" class="group_s btn btn-c">
                    </form>
                  </div>
                  
                  <?php
                if($product['milk']!=0){
                  echo 'ミルク  ',$product['milk'],'  個　';
                }
                if($product['sugar']!=0){
                  echo '砂糖  ',$product['sugar'],'  個';
                }
                ?>
                </span>
              </li>
            <?php endforeach; ?>

            <!-- モーダル切り替えボタン -->
            <li>
              <button type="button" class="btn btn-c btn-primary" data-toggle="modal" data-target="#exampleModal">
                決定
              </button>
            </li>
    </div>
    <!-- モーダル外枠 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- モーダル　ダイアログ本体 -->
      <div class="modal-dialog" role="document">
        <!-- モーダル　コンテンツ -->
        <div class="modal-content">
          <!-- モーダル　ヘッダー -->
          <div class="modal-header">
            <!-- モーダルのタイトル -->
            <h5 class="modal-title" id="exampleModalLabel">注文確認</h5>
            <!-- 閉じるアイコン -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <!-- モーダルの本文 -->
            <div class="modal-body">
              ご注文内容はこちらでよろしいでしょうか？
              <?php foreach($_SESSION['product'] as $id => $product): ?>
              <li>
              <!-- 名前 -->
              <span><?php echo $product['name']; ?>
                <!--  個数 -->
                <!-- 現在の個数表示 -->
                <a class="group_s number"><?php echo $product['count']; ?>個</a>
                <?php
                if($product['milk']!=0){
                  echo '【 ミルク',$product['milk'],'個';
                  if($product['sugar']==0){
                    echo '】';
                }}
                if($product['sugar']!=0){
                  if($product['milk']!=0){
                    echo '  /  ';
                  }else{
                    echo '【 ';
                  }
                  echo '砂糖',$product['sugar'],'個　】';
                }
                ?>
              </span>
              </li>
              <?php endforeach; ?>
            </div>
            <!-- モーダルフッター -->
            <div class="modal-footer modal_footer_padding">
              <form action="" class= "decide">
                <input type="hidden" name="purchase" value="1">
                <input type="submit" class="btn btn-secondary" value = "決定">
              </form>
              <!-- 閉じるボタン -->
              <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
            </div>
          </div>
        </div>
      </div>
      <span>
      <?php else:?>
        <li>商品を選択してください</li>
      <?php endif; ?>
      </span>
    </ul>
  </div>

  <!-- 商品一覧 -->
  <body class = "body">
      <!-- ヘッダー -->
  <div class="header"><img src="../images/drinkmenu.png" class="logo"></div>

<hr>
            <div class="card-deck">
              <div class="row">
                <?php foreach($sql_products as $row):?>
                  <div class="col-sm-4 col_size">
                    <div class="card h-100">
                      <!-- 画像の拡張子判別 -->
                      <?php $product_id=$row->id;
                        $url1='../images/'.$product_id.'.jpg';
                        $url2='../images/'.$product_id.'.png';
                        $url3='../images/'.$product_id.'.gif';
                        $response1 = @file_get_contents($url1);
                        $response2 = @file_get_contents($url2);
                        $response3 = @file_get_contents($url3);
                        // 存在したらURLとして使う
                        if ($response1 !== false) {
                          $url='../images/'.$product_id.'.jpg';
                        } else if ($response2 !== false){
                          $url='../images/'.$product_id.'.png';
                        } else{
                          $url='../images/'.$product_id.'.gif';
                        }
                      ?>

                    <!-- 画像を表示 -->
                      <img src = "<?php echo $url;?>" class="card-img-top">
                
                <div class = "card-body">
                  <form>
                    <div class="form-row align-items-center">
                      <strong><?php echo $row->productName; ?></strong>
                      <select name = "count" class="custom-select" id="inlineFormCustomSelect">
                        <?php for($i = 1; $i<=10; $i++){
                                echo '<option value = "',$i, '">',$i, '</option>';
                              }
                        ?>
                      </select>
                    </div>
                    <!-- ミルク、砂糖個数選択 -->
                    <?php
                      if($row->milk==1){
                        echo '<div class="form-row align-items-center">';
                        echo 'ミルク';
                        echo '<select name = "milk" class=" my_select" id="inlineFormCustomSelect">';
                        for($m = 0; $m<=10; $m++){
                          echo '<option value = "',$m, '">',$m, '</option>';
                        }
                        echo '</select>';
                      }else{
                        echo '<input type="hidden" name="milk" value=0><br>';
                      }
                      if($row->sugar==1){
                        echo '砂糖';
                        echo '<select name = "sugar" class=" my_select" id="inlineFormCustomSelect">';
                        for($s = 0; $s<=10; $s++){
                          echo '<option value = "',$s, '">',$s, '</option>';
                        }
                        echo '</select> </div> ';
                      }else{
                        echo '<input type="hidden" name="sugar" value=0><br>';
                      }
                      
                      ?>

                    <!-- 商品選択 -->
                    <hr>
                      <input type = "hidden" name = "id" value = <?php echo $row->id;?>>
                      <input type = "hidden" name = "name" value = <?php echo $row->productName;?>>
                      <input type = "hidden" name = "cart_insert" value = <?php echo $row->id;?>>
                      <input type = "submit" class="btn btn-pls btn-primary" value = "選択">
                  </form>

                </div>
                <!-- card-body -->
              </div>
              <!-- card h-100 -->
          </div>
          <!-- col-sm-4 col_size -->
        <?php endforeach;?>
      </div>
      <!-- row -->
    </div>
    <!-- class="card-deck -->
<footer class="py-4 text-right">
  <div class="container text-right">
    <small><a class="f_text" href="index.php" >戻る</a></small>
  </div>
</footer>

<!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <!-- <script type="text/javascript" src="../js/my.js"></script> -->
  </body>
</html>
