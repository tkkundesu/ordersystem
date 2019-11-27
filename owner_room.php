<link rel="stylesheet" href="../css/owner.css">
<?php
require "Drink.php";
require "config.php";
$order=new Drink();
$sql=$order->getRoom();
if(isset($_REQUEST['command'])){
  switch ($_REQUEST['command']) {
    case 'update':
      $order->room_update();
      header("Location:owner_room.php");

      break;
    case 'change':
      $order->room_isuse();
      header("Location:owner_room.php");
      break;
  }

  if(isset($_REQUEST['insert'])){
  $order->room_add();
  header("Location:owner_room.php");
    }

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charaset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>ルーム編集</title>  <!--画面タイトル-->
</head>
<body class="owner_body">
  <fieldset>
    <h1 class="owner_h1">会議室編集</h1>
    <h2>会議室新規追加</h2>

     <form action="" method="post">
          <input type="hidden" name="insert" value="insert">
          <input class="form-control col-sm-4 owner_form" type="text" name="new_room" placeholder="会議室名記入欄">
          <br><input class="btn btn-primary btn-pls owner_bottan" type="submit" value="追加">
    </from>
  </fieldset>
    <h2>既存会議室編集</h2>
    <fieldset>
      <table class="owner_table">
        <tr>
          <th>会議室ID</th>
          <th>会議室名</th>
          <th></th>
          <th>利用</th>
        </tr>
      <?php foreach ($sql as $row) :?>
        <tr>
          <td><?php echo $row->id; ?></td>
          <td><form action="" method="post">
            <input class="form-control" type="text" name="room_name" value="<?php echo $row->room_name; ?>">
            <input type="hidden" name="command" value="update">
            <input type="hidden" name="room_id" value="<?php echo $row->id;?>">
          </td>
          <td>
            <input class="btn btn-primary btn-pls owner_bottan" type="submit" value="更新"></td>
          </form>
          </td>
          <td class="change-td">
            <form action="" method="post">
            <input type="hidden" name="command" value="change">
            <input type="hidden" name="room_id" value="<?php echo $row->id;?>">
            <input type="hidden" name="room_isuse" value="<?php echo $row->is_use;?>">
            <?php if($row->is_use == "0" ){
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="on_room" value="利用中">';
            }else{
              echo '<input class="btn btn-primary btn-pls owner_bottan" type="submit" name="off_room" value="停止中">';
            }?>
          </td>
          </form>
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
