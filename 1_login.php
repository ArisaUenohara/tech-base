<?php

    session_start();

     //サーバ
    $dsn = 'mysql:dbname=*********';
    $user='********';
    $password = '********';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING));
    //なかったらサーバのテーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS tbtest_user"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name CHAR(50),"
    ."password CHAR(30)"
    .");";
    $stmt =$pdo->query($sql);
    
    //ユーザー確認
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        //パスワード確認
        $sql = 'SELECT id, password FROM tbtest_user WHERE name = :username';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($user['password'] == $password){
            //セッションに保存
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $username;
            
            //ホームページに移動
            header('Location: 1_index.php');
            exit;
        }else{
            echo 'ユーザー情報が違います';
        }
    }
    
    
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <h1>Welcome</h1>
    
            <form action="" method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
        </div>
        <div>
            <a href="">パスワードを忘れた人</a>
            <a href="1_signup.php">新規登録用</a>
        </div>
    </div>
</body>
</html>
