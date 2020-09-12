<?php

   require_once('./detavase.php');

    session_save_path('/home/y_hama/session/');

    session_start();


    $kanrisha_account_id=$_POST['kanrisha_account_id'];

    $kanrisha_bango=$_POST['kanrisha_bango'];

    $kanrisha_mei=$_POST['kanrisha_mei'];

    $shozokubu=$_POST['shozokubu'];

    $kanrisha_pass=$_POST['kanrisha_pass'];

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

  $stmt = $dbh->prepare('delete from kanrisha where kanrisha_id=:target_id');
    
  $stmt->bindParam(":target_id",$kanrisha_account_id,PDO::PARAM_INT);  $target_user_id="";

  } else if($submit_option=="更新") {

  $stmt = $dbh->prepare('update kanrisha set kanrisha_bango=:kanrisha_bango,kanrisha_mei=:kanrisha_mei,shozokubu=:shozokubu,kanrisha_pass=:kanrisha_pass where kanrisha_id=:kanrisha_account_id');

  $stmt->bindParam(":kanrisha_account_id",$kanrisha_account_id,PDO::PARAM_INT);
  $stmt->bindParam(":kanrisha_bango",$kanrisha_bango,PDO::PARAM_INT);

  $stmt->bindParam(":kanrisha_mei",$kanrisha_mei,PDO::PARAM_STR);

  $stmt->bindParam(":shozokubu",$shozokubu,PDO::PARAM_STR);

  $stmt->bindParam(":kanrisha_pass",$kanrisha_pass,PDO::PARAM_INT);


   
  $target_user_id=$kanrisha_account_id;
   } else {

  $stmt=$dbh->prepare('select max(kanrisha_id)+1 kanrisha_id from kanrisha');

  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $new_id=$result['kanrisha_id'];

  $stmt = null;
  $stmt=$dbh->prepare('insert into kanrisha(kanrisha_id,kanrisha_bango,kanrisha_mei,shozokubu,kanrisha_pass) values(:kanrisha_id,:kanrisha_bango,:kanrisha_mei,:shozokubu,:kanrisha_pass)');

   $stmt->bindParam(":kanrisha_id",$new_id,PDO::PARAM_INT);

   $stmt->bindParam(":kanrisha_bango",$kanrisha_bango,PDO::PARAM_INT);

   $stmt->bindParam(":kanrisha_mei",$kanrisha_mei,PDO::PARAM_STR);

   $stmt->bindParam(":shozokubu",$shozokubu,PDO::PARAM_STR);

   $stmt->bindParam(":kanrisha_pass",$kanrisha_pass,PDO::PARAM_INT);

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

        header('location: ./kanrisha_touroku.php');

        exit;
    }

    if($submit_option == "追加") {

        header('location: ./kanrisha_touroku.php');

        exit;
    }
    if($submit_option == "更新") {

        header('location: ./kanrisha_touroku.php');

        exit;
    }

    $stmt = $dbh->prepare('select kanrisha_id,kanrisha_bango,kanrisha_mei,shozokubu,kanrisha_pass from kanrisha where kanrisha_id =:target_user_id');
    $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
    $stmt->execute();

 if($stmt->rowCount() != 1) {

     echo "Error: データが特定できませんでした";
     exit;
    }
     $result = $stmt->fetch(PDO::FETCH_ASSOC);



     $kanrisha_id = $result['kanrisha_id'];

     $kanrisha_bango = $result['kanrisha_bango'];

     $kanrisha_mei = $result['kanrisha_mei'];

     $shozokubu = $result['shozokubu'];

     $kanrisha_pass = $result['kanrisha_pass'];

     $result = null;

     $stmt = null;
     if(is_readable('./kanrisha_hensyu.html')) {

      
      $fp=fopen('./kanrisha_hensyu.html','r');
  
      
      while(!feof($fp)) {
  
         
         $line=fgets($fp);
       
         $line1=str_replace("<###id###>",$kanrisha_id,$line);
  
         $line2=str_replace("<###bango###>",$kanrisha_bango,$line1);
  
         $line3=str_replace("<###mei###>",$kanrisha_mei,$line2);
  
         $line4=str_replace("<###shozokubu###>",$shozokubu,$line3);
  
         $line5=str_replace("<###pass###>",$kanrisha_pass,$line4);
  
         $line6=str_replace("<###SUBOPTION1###>","cheked",$line5);
         $line7=str_replace("<###SUBOPTION2###>","",$line6);

         $line8=str_replace("<###SUBOPTION3###>","",$line7);
  
         $line9=str_replace("<###EMPLOYERID###>",$target_user_id,$line8);
          $lines=$line9;
  
        echo $lines;
      }
      fclose($fp);
      }
      exit();
  
  ?>