<?php
    require_once('./detavase.php');

    session_save_path('/home/y_hama/session/');

    session_start();

    $login_id=$_SESSION['kanrisha_id'];
    $login_pass=$_SESSION['kanrisha_pass'];
    $login_mei=$_SESSION['kanrisha_mei'];

    try {

        //接続情報設定
     $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);

        //エラー出力設定
     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //失敗した場合はエラー表示
     } catch (PDOException $e) {
     echo 'Connection failed:' . $e->getMessage();
      exit;
    }

    $stmt=$dbh->prepare('select kanrisha_id,kanrisha_mei from kanrisha ');

    //実行
    $stmt->execute();

    // 後ほどhtmlファイルで置き換えするための変数の初期化
    $kanrisha_line="";

    //実行結果を変数にセット

    if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

     // if no one matched, move login

    foreach ($result as $row) {

     $kanrisha_account_id = $row['kanrisha_id'];

     $kanrisha_mei = $row['kanrisha_mei'];

       // 一覧用の値をセット
$kanrisha_line.="<tr><td>".$kanrisha_account_id."</td><td><a href ='./kanrisha_hensyu_2.php?targetID=".$kanrisha_account_id."'>$kanrisha_mei</a></td><td><a href='./kanrisha_shousai.php?targetID=".$kanrisha_account_id."'><button type='button'>詳細</button></a></td></tr>\n";
}

/* 結果セットを開放します */
$result = null;
}

#statementオブジェクトを初期化

$stmt = null;

#DB接続情報を初期化

$dbh = null;

// htmlファイルが読み込める状態かどうかを確認する

if(is_readable('./kanrisha_touroku.html')) {

$fp=fopen('./kanrisha_touroku.html','r');


while(!feof($fp)) {

$line=fgets($fp);
$line1=str_replace("<###LOGINNAME###>",$login_mei,$line);
$lines=str_replace("<###EMPLOYERLIST###>",$kanrisha_line,$line1);

echo $lines;
}

fclose($fp);
}
exit();
?>