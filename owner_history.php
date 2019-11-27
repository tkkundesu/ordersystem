<link rel="stylesheet" href="css/owner.css">
<?php
require "Drink.php";
require "config.php";
$order=new Drink();
$sql=$order->get_history();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charaset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>履歴表示</title>  <!--画面タイトル-->
</head>
<body class="owner_body history_font">
    <h1 class="owner_h1 history_h1">ドリンク注文履歴</h1>
      <table class="teble teble-border owner_table">
        <thead>
        <tr>
          <th>会議室名</th>
          <th>注文ドリンク</th>
          <th>注文数</th>
          <th>ミルク数</th>
          <th>砂糖数</th>
          <th>注文日時</th>
        </tr>
      <?php foreach ($sql as $row) :?>
        <tr>
          <td><?php echo $row->room_name; ?></td>
          <td><?php echo $row->productName; ?></td>
          <td><?php echo $row->product_count; ?></td>
          <td><?php echo $row->milk_count ?></td>
          <td><?php echo $row->sugar_count; ?></td>
          <td><?php echo $row['select order_time + interval 9 hour']; ?></td>
        </tr>
      <?php endforeach;?>
      </thead>
      </table>
  <?php require "footer.php"; ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
