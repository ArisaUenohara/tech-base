<?php

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
    //なかったらサーバのテーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS tbtest_travel"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."date DATE,"
    ."place CHAR(50),"
    ."image MEDIUMBLOB,"
    ."comment TEXT"
    .");";
    $stmt =$pdo->query($sql);
    
    if(!empty($_POST['submit'])){
        //日付があればそのまま、なければnullを$dateに挿入
        $date = !empty($_POST['date']) ? $_POST['date'] : null;
        $place = !empty($_POST['place']) ? $_POST['place'] : null;
        $comment = !empty($_POST['comment']) ? $_POST['comment'] : null;
        
        //画像
        $imageData = null;
        if(!empty($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])){
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
        }
        
        //データベースに登録
        $sql = "INSERT INTO tbtest_travel (date, place, image, comment) VALUES (:date, :place, :image, :comment)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':place', $place);
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();

        echo "登録が完了しました。";
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
    <form action="" method = "post" enctype="multipart/form-data">
        <h2>旅行日</h2>
        <br>
        <input type = "date" name = "date">
        <br>
        <h2>旅行場所</h2>
        <br>
        <input type = "text" name = "place">
        <br>
        <h2>思い出写真</h2>
        <input type = "file" name = "image">
        <br>
        <h2>一言コメント</h2>
        <input type = "text" name = "comment">
        <br>
        <input type = "submit" name = "submit" value = "登録">
    </form>
    <a href="1_showdata.php">今までの日記を見る</a>
</body>

<footer>
    <p></p>
</footer>
</html>