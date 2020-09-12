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
    $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
      echo 'Connection failed:' . $e->getMessage();
      exit;
    }

    $jukousha_account_id='';

    $jukousha_bango='';

    $jukousha_mei='';

    $jukousha_kana='';

    $jukousha_ki='';

    $jukousha_pass='';

   if($target_user_id != "") {

    $stmt = $dbh->prepare('select*from jukousha where jukousha_id=:target_user_id');

    $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
    $stmt->execute();


    if($stmt->rowCount() != 1) {
            echo "Error: データが特定できませんでした";
            exit;
        }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $jukousha_account_id = $result['jukousha_id'];

    $jukousha_bango = $result['jukousha_bango'];

     $jukousha_mei = $result['jukousha_mei'];

     $jukousha_kana = $result['jukousha_kana'];

     $jukousha_ki=$result['jukousha_ki'];

     $jukousha_pass = $result['jukousha_pass'];

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
            if(is_readable('./jukousha_touroku_t.html')) {
     
            $fp=fopen('./jukousha_touroku_t.html','r');
     
            while(!feof($fp)) {
         
            $line=fgets($fp);
          
            $line1=str_replace("<###id###>",$jukousha_account_id,$line);
     
            $line2=str_replace("<###bango###>",$jukousha_bango,$line1);
     
            $line3=str_replace("<###mei###>",$jukousha_mei,$line2);
        
            $line4=str_replace("<###kana###>",$jukousha_kana,$line3);

            $line5=str_replace("<###ki###>",$jukousha_ki,$line4);
     
            $line6=str_replace("<###pass###>",$jukousha_pass,$line5);
     
            $line7=str_replace("<###SUBOPTION1###>",$suboption1,$line6);
     
            $line8=str_replace("<###SUBOPTION2###>",$suboption2,$line7);
     
            $line9=str_replace("<###SUBOPTION3###>",$suboption3,$line8);
     
            $line10=str_replace("<###EMPLOYERID###>",$target_user_id,$line9);
        
            $lines=$line9;
     
         echo $lines;
         }
         fclose($fp);
         }
         exit();
     
     ?>
                                                                                                          