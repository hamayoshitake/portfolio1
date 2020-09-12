<?php

    require_once('./detavase.php');

    session_save_path('/home/y_hama/session/');

    session_start();

    $login_id=$_SESSION['kanrisha_id'];
    $login_mei=$_SESSION['kanrisha_mei'];

    $jukousha_account_id=$_POST['jukousha_account_id'];

    $jukousha_bango=$_POST['jukousha_bango'];

    $jukousha_mei=$_POST['jukousha_mei'];

    $jukousha_kana=$_POST['jukousha_kana'];

    $jukousha_ki=$_POST['jukousha_ki'];

    $jukousha_pass=$_POST['jukousha_pass'];

    $submit_option=$_POST['submit_option'];

    $target_id=$_POST['target_id'];
    try {

   $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);

   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
   echo 'Connection failed:' . $e->getMessage();
    exit;
  }

 if($submit_option=="削除") {

  $stmt = $dbh->prepare('delete from jukousha where jukousha_id=:target_id');
  $stmt->bindParam(":target_id",$jukousha_account_id,PDO::PARAM_INT);
  $target_user_id="";

  } else if($submit_option=="更新") {
    $stmt = $dbh->prepare('update jukousha set jukousha_bango=:jukousha_bango,jukousha_mei=:jukousha_mei,jukousha_kana=:jukousha_kana,jukousha_ki=:jukousha_ki,jukousha_pass=:jukousha_pass where jukousha_id=:jukousha_account_id');

    $stmt->bindParam(":jukousha_account_id",$jukousha_account_id,PDO::PARAM_INT);

    $stmt->bindParam(":jukousha_bango",$jukousha_bango,PDO::PARAM_INT);

    $stmt->bindParam(":jukousha_mei",$jukousha_mei,PDO::PARAM_STR);

    $stmt->bindParam(":jukousha_kana",$jukousha_kana,PDO::PARAM_STR);

    $stmt->bindParam(":jukousha_ki",$jukousha_ki,PDO::PARAM_INT);

    $stmt->bindParam(":jukousha_pass",$jukousha_pass,PDO::PARAM_INT);

    $target_user_id=$jukousha_account_id;

     } else {

    $stmt=$dbh->prepare('select max(jukousha_id)+1 jukousha_id from jukousha');

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $new_id=$result['jukousha_id'];

    $stmt = null;
$stmt=$dbh->prepare('insert into jukousha(jukousha_id,jukousha_bango,jukousha_mei,jukousha_kana,jukousha_ki,jukousha_pass) values(:jukousha_id,:jukousha_bango,:jukousha_mei,:jukousha_kana,:jukousha_ki,:jukousha_pass)');

   $stmt->bindParam(":jukousha_id",$new_id,PDO::PARAM_INT);

   $stmt->bindParam(":jukousha_bango",$jukousha_bango,PDO::PARAM_INT);

   $stmt->bindParam(":jukousha_mei",$jukousha_mei,PDO::PARAM_STR);

   $stmt->bindParam(":jukousha_kana",$jukousha_kana,PDO::PARAM_STR);

   $stmt->bindParam(":jukousha_ki",$jukousha_ki,PDO::PARAM_INT);

   $stmt->bindParam(":jukousha_pass",$jukousha_pass,PDO::PARAM_INT);

   $target_user_id=$new_id;
}
try{
  $flag = $stmt->execute();

if (!$flag){
   echo "Error: Update or Insert";
   exit;

}
 }catch (PDOException $e){
  print('Error:'.$e->getMessage());
  exit;
 }

 $result = null;

 $stmt = null;

 if($submit_option == "削除") {

     header('location: ./jukousha_list.php');

     exit;

 }
 if($submit_option == "追加") {

     header('location: ./jukousha_list.php');

     exit;
    }
    if($submit_option == "更新") {

        header('location: ./jukousha_list.php');

        exit;
    }


    $stmt = $dbh->prepare('select jukousha_id,jukousha_bango,jukousha_mei,jukousha_kana,jukousha_ki,jukousha_pass from jukousha where jukousha_id=:target_user_id');

    $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
    $stmt->execute();

 if($stmt->rowCount() != 1) {

     echo "Error: データが特定できませんでした";
     exit;
    }
     $result = $stmt->fetch(PDO::FETCH_ASSOC);

     $jukousha_id = $result['jukousha_id'];

     $jukousha_bango = $result['jukousha_bango'];

     $jukousha_mei = $result['jukousha_mei'];
     $jukousha_ki=$result['jukousha_ki'];

     $jukousha_kana=$result['jukousha_kana'];

     $jukousha_pass = $result['jukousha_pass'];

     $result = null;

     $stmt = null;


    if(is_readable('./jukousha_touroku.html')) {

    $fp=fopen('./jukousha_touroku.html','r');

    while(!feof($fp)) {
       
       $line=fgets($fp);
     
       $line1=str_replace("<###id###>",$jukousha_account_id,$line);

       $line2=str_replace("<###bango###>",$jukousha_bango,$line1);

       $line3=str_replace("<###mei###>",$jukousha_mei,$line2);

       $line4=str_replace("<###kana###>",$jukousha_kana,$line3);

       $line5=str_replace("<###ki###>",$jukousha_ki,$line4);

       $line6=str_replace("<###pass###>",$jukousha_pass,$line5);

       $line7=str_replace("<###SUBOPTION1###>","cheked",$line6);

       $line8=str_replace("<###SUBOPTION2###>","",$line7);

       $line9=str_replace("<###SUBOPTION3###>","",$line8);

       $line10=str_replace("<###EMPLOYERID###>",$target_user_id,$line9);

       $lines=$line10;

       echo $lines;
    }
    fclose($fp);
    }
    exit();

?>
             