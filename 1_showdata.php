<?php

     // メモリ上限を128MBに増やす
    ini_set('memory_limit', '128M'); 
    
    session_start();
    
    //ログインしていない場合ログインページへ遷移
    if(!isset($_SESSION['id'])){
        header('Location: 1_login.php');
        exit;
    }
    
    $username = $_SESSION['name'];
    $userid = $_SESSION['id'];

     //サーバ
    $dsn = 'mysql:dbname=tb270100db;host=localhost';
    $user='tb-270100';
    $password = 'sGccyLtD4w';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING));
    
    if(!empty($_POST['logout'])){
        $_SESSION = array();
        session_destroy();
        
        header('Location: 1_login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>旅行日記帳</title>
</head>
<body>
    <h1><?php echo $username; ?>の旅行日記</h1>

<?php
    //データ表示
    $sql = 'SELECT * FROM tbtest_travel ORDER BY id';
    $stmt = $pdo->query($sql);
    $results =$stmt->fetchALL();
    
    foreach($results as $row){
        echo '<div>';
        echo '<strong>旅行日時</strong>　';
        echo $row['date'].'<br>';
        echo '<strong>旅行場所</strong>　';
        echo $row['place'].'<br>';
        echo '<strong>思い出写真</strong><br>';
        
        if(!empty($row['image'])){
            $base64 =base64_encode($row['image']);
            echo '<img src ="data:image/jpeg;base64,'.$base64.'"width="300"><br>';
        }else{
            echo '(画像なし)<br>';
        }
        
        echo '<strong>コメント</strong>　';
        echo $row['comment'].'<br>';
        echo '</div>';
    }

?>

<a href="1_index.php">旅行日記を追加する</a>
<form action="" method="post">
    <input type="submit" name="logout" value="ログアウト">
</form>

</body>

<footer>
    <p></p>
</footer>
</html>