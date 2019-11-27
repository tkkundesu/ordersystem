<footer class="fixed-bottom text-center footer">
  <?php
  $owner_drink = "owner_drink.php";
  $owner_room = "owner_room.php";
  $owner_history = "owner_history.php";
  $now_url = $_SERVER["REQUEST_URI"];
  ?>
<nav class="container text-center">
  <?php if(preg_match( "/$owner_drink/" , $now_url ) == "false" ){ ?>
    <a class="btn btn-outline-light btn-lg drink_entrance" href="owner_drink.php" role="button">ドリンク編集へ</a>
  <?php }if(preg_match( "/$owner_room/" , $now_url ) == "false" ){ ?>
    <a class="btn btn-outline-light btn-lg room_entrance" href="owner_room.php" role="button">会議室編集へ</a>
  <?php }if(preg_match( "/$owner_history/" , $now_url ) == "false" ){ ?>
    <a class="btn btn-outline-light btn-lg history_entrance" href="owner_history.php" role="button">注文履歴へ</a>
  <?php } ?>
  <a class="btn btn-outline-light btn-lg index_entrance" href="index.php" role="button">TOPへ</a>
</footer>
