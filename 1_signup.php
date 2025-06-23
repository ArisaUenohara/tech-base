<?php
     //サーバ
    $dsn = 'mysql:dbname=tb270100db;host=localhost';
    $user='tb-270100';
    $password = 'sGccyLtD4w';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING));
    //なかったらサーバのテーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS tbtest_user"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name CHAR(50),"
    ."password CHAR(30)"
    .");";
    $stmt =$pdo->query($sql);
    
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $sql = "SELECT COUNT(*) FROM tbtest_user WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $username, PDO::PARAM_STR);
        $stmt->execute();
        $userExists = $stmt->fetchColumn();

        //すでに存在するユーザー名の場合
        if ($userExists > 0) {
            echo "すでに登録済みのユーザーネームです";
        } else {
        
        $sql = "INSERT INTO tbtest_user (name, password) VALUES(:name, :password)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':name',$username,PDO::PARAM_STR);
        $stmt->bindParam(':password',$password,PDO::PARAM_STR);
        
        $stmt->execute();
        
        echo "ユーザー登録が完了しました";
        echo "<a href='1_login.php'>ログインページへ移行</a>";
        }
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
    <div class="container">
        <h1>新規登録</h1>
    
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">sign in</button>
        </form>
    </div>
    <a href="1_login.php">ログインページに戻る</a>
</body>
</html>