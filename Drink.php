<?php
class Drink {
     private $_db;
     private $imageType;
   public function __construct() {//データーベース接続
      try {
        $this->_db = new PDO(DSN,DB_USERNAME,DB_PASSWORD);
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
      }
  }

  public function getRoom() {//ルームテーブルからセレクト
    $stmt = $this->_db->query("select * from room");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getProducts(){//プロダクトテーブルからセレクト
    $stmt = $this->_db->query("select * from products");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getProducts_isview(){//プロダクトテーブルからセレクト
    $stmt = $this->_db->query("select * from products where is_view=0");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getDrink_order(){//ドリンクオーダーテーブルからセレクト
    $stmt = $this->_db->query("select * from drink_order");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function owner_login(){//オーナーログイン
    try{
       if(!empty($_REQUEST["owner_pass"])){//リクエストパラメーターが空でない場合。
           $owner_pass=$_REQUEST["owner_pass"];
           $this->_login($owner_pass);//パスワードチェック
           return true;
        }else{
          throw new \Exception('リクエストパラメーターをセットしてください。');
        }
     } catch (\Exception $e) {
       echo $e->getMessage();
       exit;
       }
}
private function _login($owner_pass){
    if(isset($_SESSION['owner'])){//オーナーセッションがセットされていればアンセット
        unset($_SESSION['owner']);
       }
       $db_pwd=null;
       $stmt = $this->_db->prepare('select * from owner where owner_password=?');//入力されたパスワードよりテーブルから抽出
       $stmt->execute([$owner_pass]);
       $sql=$stmt->fetchAll();
    foreach($sql as $row) {//変数に格納
        $db_pwd=$row['owner_password'];
        $owner_login=$row['owner_login'];
   	}
    if ($owner_pass==$db_pwd) {//入力されたパスワードが一致するかチェック
		   $_SESSION['owner'] = $owner_login;//セッションに格納
	   } else {
		  throw new \Exception('パスワードが間違っています');
	  }
  }

public function cart_insert(){//カートに追加
   try{
       if(!empty($_REQUEST["id"])||!empty($_REQUEST["name"])||!empty($_REQUEST["count"])||!empty($_REQUEST["milk"])||!empty($_REQUEST["sugar"])){//リクエストパラメーターチェック
         $count=0;
         $count_m=0;
         $count_s=0;
         $id=$_REQUEST["id"];
           if(isset($_SESSION['product'][$id])){//もしその商品のセッション情報をすでに持っている場合
             $count=$_SESSION['product'][$id]['count'];//個数を変数に格納
             $count_m=$_SESSION['product'][$id]['milk'];
             $count_s=$_SESSION['product'][$id]['sugar'];

             }
         $_SESSION['product'][$id]=[//送られてきた情報をセッションに格納
           'name'=>$_REQUEST['name'],
           'count'=>$_REQUEST['count']+$count,
           'milk'=>$_REQUEST["milk"]+$count_m,
           'sugar'=>$_REQUEST["sugar"]+$count_s
          ];
         echo '<script>alert("カートに【',$_REQUEST['name'],'】を追加しました");</script>';
       }else{
          throw new \Exception('カートへ追加することが出来ませんでした。');
       }
    }catch (\Exception $e) {
      echo $e->getMessage();
      exit;
      }
    }

public function cart_delete(){//カート内の商品を削除
   try{
         if(!empty($_REQUEST["id"])){//リクエストパラメーターが空でない場合
            unset($_SESSION['product'][$_REQUEST['id']]);//その商品のセッションをアンセット
            echo '<script>alert("削除しました");</script>';
          }else{
            throw new \Exception('エラーが発生しました');
          }
     }catch (\Exception $e) {
         echo $e->getMessage();
        exit;
    }
  }

public function purchase(){//注文確定
   try{
      $purchase_id=1;
      $purchase_id=$this->max_id();//ドリンクオーダーテーブルから現在のIDの最大値+1を呼び出す
      $this->insert_drink($purchase_id);//ドリンクオーダーテーブルへインサート
       foreach ($_SESSION['product'] as $product_id=>$product) {//セッションプロダクトに入っている情報をorder_detailテーブルに追加
		          $this->insert_detail($purchase_id,$product_id,$product['count'],$product['milk'],$product['sugar']);
            	}
      unset($_SESSION['product']);//カート内セッションのアンセット
  }catch (\Exception $e) {
        echo $e->getMessage();
   exit;
     }
   }
private function max_id(){//ドリンクオーダーテーブルから現在のIDの最大値+1を呼び出す
    $stmt = $this->_db->query("select max(id) from drink_order");
      foreach ($stmt as $row) {
           $purchase_id=$row['max(id)']+1;
        }
   return $purchase_id;
}

private function insert_drink($purchase_id){//ドリンクオーダーテーブルへインサート
  $stmt = $this->_db->prepare("insert into drink_order values(?,?,null)");
  $sql=$stmt->execute([$purchase_id,$_SESSION['room']]);
     if(!isset($sql)){
        throw new \Exception('テーブルへ挿入が出来ませんでした。');
       }
   }

private function insert_detail($purchase_id,$product_id,$product_count,$milk,$sugar){//セッションプロダクトに入っている情報をorder_detailテーブルに追加
  $stmt = $this->_db->prepare("insert into order_detail values(?,?,?,?,?)");
  $sql=$stmt->execute([$purchase_id,$product_id,$product_count,$milk,$sugar]);
if(!isset($sql)){
  throw new \Exception('テーブルへ挿入が出来ませんでした。');
}

}

public function room_check(){//部屋情報のセッションを持つ
  try{
     if(!empty($_REQUEST["room_id"])){//リクエストパラメーターが空でない場合
         if(isset($_SESSION['room'])){//ルームセッションに情報が格納されている場合アンセット
             unset($_SESSION['room']);
           }
      $_SESSION['room']=$_REQUEST["room_id"];//送られてきたルームIDをセッションに格納
      }else{
        throw new \Exception('エラーが発生しました');
      }
    }catch (\Exception $e) {
      echo $e->getMessage();
      exit;
     }
  }

public function count_plus(){//カートの任意の商品の個数をプラスする
  try{
        $_SESSION['product'][$_REQUEST['id']]['count']++;
     }catch (\Exception $e) {
       echo $e->getMessage();
       exit;

    }
  }
public function count_minus(){//カートの任意の商品の個数をマイナスする
  try{
     $_SESSION['product'][$_REQUEST['id']]['count']--;
        if($_SESSION['product'][$_REQUEST['id']]['count']==0){//もし個数が0になってしまったら、その商品のセッションをアンセットする
            unset($_SESSION['product'][$_REQUEST['id']]);
         }
    }catch (\Exception $e) {
      echo $e->getMessage();
      exit;
        }
      }

public function room_add(){//会議室追加
	try{
         if (!isset($_REQUEST['new_room']) || $_REQUEST['new_room'] === '') {//リクエストパラメーターチェック
	    throw new \Exception('リクエストパラメーターがセットされていません。');
           }
	  $stmt = $this->_db->prepare('insert into room values(null,?,0)');//ルームテーブルにインサート
          $stmt->execute([$_REQUEST['new_room']]);
  }catch (\Exception $e) {
        echo $e->getMessage();
        exit;
          }
        }

  public function room_update(){//会議室更新
    try{
          if (!isset($_REQUEST['room_name'])|| !isset($_REQUEST['room_id'])  || $_REQUEST['room_name'] === ''||$_REQUEST['room_id']==='') {//リクエストパラメーターチェック
                     throw new \Exception('リクエストパラメーターがセットされていません。');
              }
          $stmt = $this->_db->prepare('update room set room_name=? where id=?');//ルームテーブルの更新
          $stmt->execute([$_REQUEST['room_name'],$_REQUEST['room_id']]);
        }catch (\Exception $e) {
          echo $e->getMessage();
          exit;
        }
      }

  public function room_isuse(){//会議室利用中かどうか切り替え
      try{
              if (!isset($_REQUEST['room_isuse'])|| !isset($_REQUEST['room_id'])  || $_REQUEST['room_isuse'] === ''||$_REQUEST['room_id']==='') {//リクエストパラメーターチェック
                  throw new \Exception('リクエストパラメーターがセットされていません。');
                }
             if($_REQUEST['room_isuse']==0){
                $stmt = $this->_db->prepare('update room set is_use=1 where id=?');
             }elseif ($_REQUEST['room_isuse']==1) {
                $stmt = $this->_db->prepare('update room set is_use=0 where id=?');
             }
           $stmt->execute([$_REQUEST['room_id']]);
          }catch (\Exception $e) {
            echo $e->getMessage();
            exit;
              }
            }

  public function product_add(){//商品追加
    try{
          if (!isset($_REQUEST['new_product']) || $_REQUEST['new_product'] === '' || !isset($_FILES['image']) || !isset($_REQUEST['milk']) || !isset($_REQUEST['sugar'])) {//リクエストパラメーターチェック
              throw new \Exception('リクエストパラメーターがセットされていません。');
             }
          if($_REQUEST['milk']==1 && $_REQUEST['sugar']==1){//ミルクとシュガーが必要かどうかで場合分け
            $stmt = $this->_db->prepare('insert into products values(null,?,0,1,1)');
          }elseif ($_REQUEST['milk']==1 && $_REQUEST['sugar']==0){
            $stmt = $this->_db->prepare('insert into products values(null,?,0,1,0)');
          }elseif ($_REQUEST['milk']==0 && $_REQUEST['sugar']==1) {
            $stmt = $this->_db->prepare('insert into products values(null,?,0,0,1)');
          }else{
            $stmt = $this->_db->prepare('insert into products values(null,?,0,0,0)');
          }

        $stmt->execute([$_REQUEST['new_product']]);
      }catch (\Exception $e) {
        echo $e->getMessage();
        exit;
          }
        }

  public function product_update(){//商品更新
   try{
            if (!isset($_REQUEST['product_name'])|| !isset($_REQUEST['product_id'])  || $_REQUEST['product_name'] === ''||$_REQUEST['product_id']==='') {//リクエストパラメーターチェック
               throw new \Exception('リクエストパラメーターがセットされていません。');
              }
        $stmt = $this->_db->prepare('update products set productName=? where id=?');//プロダクトテーブルを更新
        $stmt->execute([$_REQUEST['product_name'],$_REQUEST['product_id']]);
      }catch (\Exception $e) {
          echo $e->getMessage();
          exit;
            }
          }

    public function product_isview(){//商品利用中かどうか切り替え
      try{
            if (!isset($_REQUEST['product_isview'])|| !isset($_REQUEST['product_id']) || $_REQUEST['product_isview'] === ''||$_REQUEST['product_id']==='') {//リクエストパラメーターチェック
                  throw new \Exception('リクエストパラメーターがセットされていません。');
                }
            if($_REQUEST['product_isview']==0){//0の場合は1へ
                  $stmt = $this->_db->prepare('update products set is_view=1 where id=?');
            }elseif ($_REQUEST['product_isview']==1) {//1の場合は0へ
                  $stmt = $this->_db->prepare('update products set is_view=0 where id=?');
            }
            $stmt->execute([$_REQUEST['product_id']]);
        }catch (\Exception $e) {
            echo $e->getMessage();
            exit;
            }
          }
    public function product_milk(){//ミルク必要商品かどうかの切り替え
      try{
            if (!isset($_REQUEST['milk'])|| !isset($_REQUEST['product_id'])  || $_REQUEST['milk'] === ''||$_REQUEST['product_id']==='') {//リクエストパラメーターチェック
                  throw new \Exception('リクエストパラメーターがセットされていません。');
                }
            if($_REQUEST['milk']==0){//0の場合は1へ
                  $stmt = $this->_db->prepare('update products set milk=1 where id=?');
            }elseif ($_REQUEST['milk']==1) {//1の場合は0へ
                  $stmt = $this->_db->prepare('update products set milk=0 where id=?');
            }
            $stmt->execute([$_REQUEST['product_id']]);
        }catch (\Exception $e) {
            echo $e->getMessage();
            exit;
            }
          }
    public function product_sugar(){//砂糖必要商品かどうかの切り替え
      try{
            if (!isset($_REQUEST['sugar'])|| !isset($_REQUEST['product_id'])  || $_REQUEST['sugar'] === ''||$_REQUEST['product_id']==='') {//リクエストパラメーターチェック
                  throw new \Exception('リクエストパラメーターがセットされていません。');
                }
            if($_REQUEST['sugar']==0){//0の場合は1へ
                  $stmt = $this->_db->prepare('update products set sugar=1 where id=?');
            }elseif ($_REQUEST['sugar']==1) {//1の場合は0へ
                  $stmt = $this->_db->prepare('update products set sugar=0 where id=?');
            }
            $stmt->execute([$_REQUEST['product_id']]);
        }catch (\Exception $e) {
            echo $e->getMessage();
            exit;
            }
          }

  public function get_history() {//履歴表示
          $stmt = $this->_db->query("select * from drink_order,order_detail,products,room where drink_order.id=order_detail.order_id and order_detail.product_id=products.id and drink_order.room_id=room.id ORDER BY order_time DESC limit 50");
          return $stmt->fetchAll(PDO::FETCH_OBJ);
            }

  public function upload() {
     try {

       $this->validateUpload();//エラーチェック

       $ext = $this->validateImageType();//拡張子を取得

       $savePath = $this->save($ext);//保存

   } catch (\Exception $e) {
       echo $e->getMessage();

   }

 }
 private function validateUpload() {

     if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {//リクエストパラメーターチェック
       throw new \Exception('Upload Error!');
     }

     switch($_FILES['image']['error']) {
      case UPLOAD_ERR_OK://この内容ならOK
         return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
         throw new \Exception('ファイルが大きすぎます。');
      default:
         throw new \Exception('Err: ' . $_FILES['image']['error']);
     }

   }
 private function validateImageType() {
  $this->imageType = getimagesize($_FILES['image']['tmp_name']);//拡張子を調べる関数
  switch($this->imageType[2]) {
    case IMAGETYPE_GIF:
      return 'gif';
    case IMAGETYPE_JPEG:
      return 'jpg';
    case IMAGETYPE_PNG:
      return 'png';
    default:
      throw new \Exception('PNG/JPEG/GIF のみです。');
  }
}
private function save($ext) {
   $max_id=$this->max_id_product();//プロダクトテーブルからIDの最大値を取得
   $file_name = sprintf(//ファイル名を最大ID.拡張子名とする
     '%s.%s',
     $max_id,
     $ext
   );
   $savePath = 'images/'.$file_name;//パスを作る
   $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);//ファイルを保存する
   if ($res === false) {
     throw new \Exception('アップロードに失敗しました。');
   }
   return true;
 }

 private function max_id_product(){///プロダクトテーブルからIDの最大値を取得
   $stmt = $this->_db->query("select max(id) from products");
   foreach ($stmt as $row) {
     $max_id=$row['max(id)'];
    }
    return $max_id;
 }
}
?>
