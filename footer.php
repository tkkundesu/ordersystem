<footer class="fixed-bottom text-center footer">
<nav class="container text-center">
  <?php if($_SERVER["REQUEST_URI"] != "/order_system/php/owner_drink.php"){ ?>
    <a class="btn btn-outline-light btn-lg drink_entrance" href="owner_drink.php" role="button">ドリンク編集へ</a>
  <?php }if($_SERVER["REQUEST_URI"] != "/order_system/php/owner_room.php"){ ?>
    <a class="btn btn-outline-light btn-lg room_entrance" href="owner_room.php" role="button">会議室編集へ</a>
  <?php }if($_SERVER["REQUEST_URI"] != "/order_system/php/owner_history.php"){ ?>
    <a class="btn btn-outline-light btn-lg history_entrance" href="owner_history.php" role="button">注文履歴へ</a>
  <?php } ?>
  <a class="btn btn-outline-light btn-lg index_entrance" href="index.php" role="button">TOPへ</a>
</footer>