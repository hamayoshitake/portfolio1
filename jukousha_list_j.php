<?php
    require_once('./detavase.php');

    session_save_path('/home/y_hama/session/');

    session_start();

    $login_id=$_SESSION['kanrisha_id'];
    $login_pass=$_SESSION['kanrisha_pass'];
    $login_mei=$_SESSION['kanrisha_mei'];

    try {

    
     $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);

     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


     } catch (PDOException $e) {
     echo 'Connection failed:' . $e->getMessage();
      exit;
    }

  
    $stmt=$dbh->prepare('select jukousha_id,jukousha_bango,jukousha_mei,jukousha_ki from jukousha ');


      $stmt->execute();

      $jukousha_line="";

  
       if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

         
       foreach ($result as $row) {
   
        $jukousha_account_id = $row['jukousha_id'];
   
        $jukousha_bango=$row['jukousha_bango'];
   
        $jukousha_mei = $row['jukousha_mei'];
   
        $jukousha_ki=$row['jukousha_ki'];
   
  
   $jukousha_line.="<tr><td>".$jukousha_account_id."</td><td>".$jukousha_bango."</td><td>".$jukousha_mei."</td><td><a href='./jukousha_shousai.php?targetID=".$jukousha_account_id."'><button type='button'>詳細</button></a></td></tr>\n";
           }
       $result = null;
    }
      
       $stmt = null;
      
       $dbh = null;
          
    if(is_readable('./jukousha_list.html')) {

  
      $fp=fopen('./jukousha_list.html','r');
  
      while(!feof($fp)) {
    
         $line=fgets($fp);
  
         $line1=str_replace("<###LOGINNAME###>",$login_mei,$line);
          
         $lines=str_replace("<###EMPLOYERLIST###>",$jukousha_line,$line1);
       echo $lines;
      }
  
      fclose($fp);
      }
      exit();
  ?>