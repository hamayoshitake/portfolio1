<?php
   require_once('./detavase.php');
    //従業員一覧から遷移した場合
   if(isset($_GET['targetID'])) {
     $target_user_id=$_GET['targetID'];
    } else
{

    //新規登録の場合

        $target_user_id="";

    }
   session_save_path('/home/y_hama/session/');
   session_start();

   $kanrisha_id=$_SESSION['kanrisha_id'];
   $password=$_SESSION['kanrisha_pass'];
   $manager_flg=$_SESSION['manager_flg'];

 try {
   $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);
   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
        echo'Connection failed: ' . $e->getMessage();
    exit;
}
    //各入力変数を初期化
    $jukousha_account_id = '';

    $jukousha_id = '';
    $jukousha_bango = '';

    $jukousha_mei = '';

    $jukousha_kana = '';

    $jukousha_ki = '';

    $jukousha_pass='';

    if($target_user_id != "") {

    $stmt = $dbh->prepare('select*from jukousha where jukousha_id=:target_user_id');
    $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowCount() != 1) {
            echo "Error: データが特定できませんでした";
            exit;
        }
 //実行結果を変数にセット(1件)

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $jukousha_account_id = $result['jukousha_id'];

        $jukousha_bango = $result['jukousha_bango'];
        $jukousha_mei = $result['jukousha_mei'];

        $jukousha_kana = $result['jukousha_kana'];

        $jukousha_ki= $result['jukousha_ki'];

        $jukousha_pass = $result['jukousha_pass'];

       $result= null;
       $stmt=null;
       }


     if(is_readable('./jukousha_shousai.html')) {

    // ファイル内容を変数に取り込む

    $fp=fopen('./jukousha_shousai.html','r');

    // ファイルの最後まで処理を行う

    while(!feof($fp)) {

       // 1行ずつファイルを読み込み変数にセット

       $line=fgets($fp);

   // データベースからセットする項目について置き換え（動>

       $line1=str_replace("<###id###>",$jukousha_account_id,$line);
       $line2=str_replace("<###bango###>",$jukousha_bango,$line1);

       $line3=str_replace("<###mei###>",$jukousha_mei,$line2);

       $line4=str_replace("<###kana###>",$jukousha_kana,$line3);

       $line5=str_replace("<###ki###>",$jukousha_ki,$line4);

       $line6=str_replace("<###pass###>",$jukousha_pass,$line5);

       $lines=$line6;

       //  1行ずつ出力

       echo $lines;
    }
    fclose($fp);
    }
    exit();
?>
