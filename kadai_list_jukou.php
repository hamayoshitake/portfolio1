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

    $stmt=$dbh->prepare('select kadai_mei,kadai_id,kadai_ki from kadai');

     $stmt->execute();

      $kadai_line="";
    if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

     foreach ($result as $row) {
 
      $kadai_mei=$row['kadai_mei'];
 
      $kadai_account_id = $row['kadai_id'];
 
      $kadai_ki=$row['kadai_ki'];
 
  $kadai_line.="<tr><td>".$kadai_account_id."</td><td>$kadai_mei</td><td><a href='./kadai_shousai_jukou2.php?targetID=".$kadai_account_id."'><button type='button'>詳細</button></a></td></tr>\n";
         }
 
     $result = null;
  }
 
     $stmt = null;
  
     $dbh = null;
 
     if(is_readable('./kadai_list_jukou.html')) {

    
      $fp=fopen('./kadai_list_jukou.html','r');
   
      while(!feof($fp)) {

         $line=fgets($fp);
  
         $line1=str_replace("<###LOGINNAME###>",$login_mei,$line);
         
         $lines=str_replace("<###EMPLOYERLIST###>",$kadai_line,$line1);
       echo $lines;
      }
  
      fclose($fp);
      }
      exit();
  ?>