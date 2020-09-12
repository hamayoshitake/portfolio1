<?php
   require_once('./detavase.php');


   if(isset($_GET['targetID'])) {

        $target_user_id=$_GET['targetID'];

    } else {
        $target_user_id="";
}

    session_save_path('/home/y_hama/session/');

    session_start();

    $login_id=$_SESSION['kanrisha_id'];
    $login_mei=$_SESSION['kanrisha_mei'];

    try {

        //接続情報設定
     $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);

     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
      echo 'Connection failed:' . $e->getMessage();
       exit;
     }
 
     $kanrisha_account_id='';
 
     $kanrisha_bango='';
 
     $kanrisha_mei='';
 
     $shozokubu='';
 
     $kanrisha_pass='';
 
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
     
          $result=null;
     
          $stmt=null;
        }
           if($target_user_id != "") {
          
             $suboption1 = "checked";
     
             $suboption2= "";
     
             $suboption3 = "";
            } else {

              $suboption1 = "disabled";
      
              $suboption2= "checked";
      
              $suboption3 = "disabled";
      
          }
             if(is_readable('./kanrisha_hensyu.html')) {
      
             $fp=fopen('./kanrisha_hensyu.html','r');
      
             while(!feof($fp)) {
      
          
             $line=fgets($fp);
           
             $line1=str_replace("<###id###>",$kanrisha_account_id,$line);
        
             $line2=str_replace("<###bango###>",$kanrisha_bango,$line1);

             $line3=str_replace("<###mei###>",$kanrisha_mei,$line2);
      
             $line4=str_replace("<###shozokubu###>",$shozokubu,$line3);
      
             $line5=str_replace("<###pass###>",$kanrisha_pass,$line4);
      
             $line6=str_replace("<###SUBOPTION1###>",$suboption1,$line5);
      
             $line7=str_replace("<###SUBOPTION2###>",$suboption2,$line6);
      
             $line8=str_replace("<###SUBOPTION3###>",$suboption3,$line7);
      
             $line9=str_replace("<###EMPLOYERID###>",$target_user_id,$line8);
              $lines=$line9;
      
            echo $lines;
          }
          fclose($fp);
          }
          exit();
      
      ?>
                                                                 