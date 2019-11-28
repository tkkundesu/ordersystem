
<?php
require "Drink.php";
require "config.php";
$order=new Drink();
$sql=$order->getRoom_isuse();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $order->room_check();
  header("Location:main.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <title>会議室選択</title>  <!--画面タイトル-->
</head>
<body class="body index_body">


  <form action="" method="post" class="dutton_container">

      <!--データベースにある分だけ選択肢を作る-->
      <?php foreach ($sql as $row) :?>
        <br><input type="hidden" class="room_input btn btn-pls btn-primary btn-block " value="<?php echo $row->id;?>" name="room_id">
        <input type="submit" class="room_input btn btn-pls btn-primary btn-block " id="sound1" value="<?php echo $row->room_name; ?>" width=70%><br>
      <?php endforeach;?>

  </form>

  <footer class="py-4 text-right">
  <div class="container text-right">
    <small> <a href="login.php" class="master_entrance f_text">オーナーページへ</a></small>
  </div>
</footer>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/my.js"></script>
</body>
</html>
