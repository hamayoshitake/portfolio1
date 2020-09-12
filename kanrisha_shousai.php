<?php
   require_once('./detavase.php');
    if(isset($_GET['targetID'])) {
     $target_user_id=$_GET['targetID'];
    } else
{

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
    $kanrisha_account_id = '';

    $kanrisha_id = '';
    $kanrisha_bango = '';
    $kanrisha_mei = '';

    $shozokubu = '';

    $kanrisha_pass = '';

    if($target_user_id != "") {

    $stmt = $dbh->prepare('select*from kanrisha where kanrisha_id=:target_user_id');
    $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowCount() != 1) {
            echo "Error: データが特定できませんでした";
            exit;
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $kanrisha_account_id = $result['kanrisha_id'];

        $kanrisha_bango = $result['kanrisha_bango'];

        $kanrisha_mei = $result['kanrisha_mei'];

        $shozokubu = $result['shozokubu'];
        $kanrisha_pass = $result['kanrisha_pass'];

        $result= null;
        $stmt=null;
        }
 
 
      if(is_readable('./kanrisha_shousai.html')) {
 
     $fp=fopen('./kanrisha_shousai.html','r');
 
     while(!feof($fp)) {
 
        $line=fgets($fp);
        
        $line1=str_replace("<###id###>",$kanrisha_account_id,$line);
        $line2=str_replace("<###bango###>",$kanrisha_bango,$line1);
        $line3=str_replace("<###mei###>",$kanrisha_mei,$line2);
 
        $line4=str_replace("<###shozokubu###>",$shozokubu,$line3);
        $lines=$line5;
 
        echo $lines;
     }
     fclose($fp);
     }
     exit();
 ?>
 