<?php

    require_once('./detavase.php');

    if(isset($_GET['targetID'])) {
     $target_user_id=$_GET['targetID'];
    }else {
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
    $shitumon_account_id = '';

    $shitumon_gaiyou = '';

    $shitumon_naiyou = '';

    $shitumon_hiduke='';

    $shitumon_hentousha='';

    $shitumon_hentou_hiduke='';

    $shitumon_hentou='';

    $shitumon_id = '';

    $shitumon_jukousha='';

    $shitumon_ki='';

    if($target_user_id != "") {

      $stmt = $dbh->prepare('select*from shitumon where shitumon_id=:target_user_id');
 
      $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
      $stmt->execute();
 
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
         $shitumon_account_id = $result['shitumon_id'];
 
         $shitumon_gaiyou = $result['shitumon_gaiyou'];
 
         $shitumon_naiyou = $result['shitumon_naiyou'];
 
         $shitumon_hentou = $result['shitumon_hentou'];
 
         $shitumon_hiduke = $result['shitumon_hiduke'];
 
         $shitumon_hentousha=$result['shitumon_hentousha'];
 
         $shitumon_hentou_hiduke = $result['shitumon_hentou_hiduke'];
         $shitumon_jukousha = $result['shitumon_jukousha'];
 
         $shitumon_ki = $result['shitumon_ki'];
 
         $shitumon_jukousha_hentou = $result['shitumon_jukousha_hentou'];
         $result= null;

         $stmt=null;
         }
  
  
       $stmt=$dbh->prepare('select shitumon_hentou,shitumon_hentou_hiduke,shitumon_hentousha,shitumon_jukousha,shitumon_jukousha_hentou,shitumon_hiduke from shitumon where shitumon_id=:target_user_id');
  
        $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
     
      $stmt->execute();
  
      $shitumon_line="";
      $shitumon_line2="";
    
      if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
  
  
       foreach ($result as $row) {
  
  
       $shitumon_hentousha = $row['shitumon_hentousha'];
       $shitumon_hentou_hiduke = $row['shitumon_hentou_hiduke'];

       $shitumon_hentou = $row['shitumon_hentou'];
  
       $shitumon_jukousha = $row['shitumon_jukousha'];
  
       $shitumon_hiduke = $row['shitumon_hiduke'];
  
       $shitumon_jukousha_hentou = $row['shitumon_jukousha_hentou'];
  
  
      $shitumon_line2.="<tr><td>".$shitumon_jukousha."</td><td>".$shitumon_hiduke."</td><td>".$shitumon_jukousha_hentou."</td></tr>\n";
  
  
      $shitumon_line.="<tr><td>".$shitumon_hentousha."</td><td>".$shitumon_hentou_hiduke."</td><td>".$shitumon_hentou."</td></tr>\n";
  
      }
      $result = null;
        $stmt = null;
       }
  
  
       if(is_readable('./shitumon_shousai_j.html')) {

    $fp=fopen('./shitumon_shousai_j.html','r');

    while(!feof($fp)) {
       $line=fgets($fp);

       $line1=str_replace("<###id###>",$shitumon_account_id,$line);

       $line2=str_replace("<###gaiyou###>",$shitumon_gaiyou,$line1);

       $line3=str_replace("<###naiyou###>",$shitumon_naiyou,$line2);

       $line4=str_replace("<###hentou###>",$shitumon_hentou,$line3);

       $line5=str_replace("<###jukousha###>",$shitumon_jukousha,$line4);

       $line6=str_replace("<###ki###>",$shitumon_ki,$line5);

       $line7=str_replace("<###hentousha###>",$shitumon_hentousha,$line6);
       $line8=str_replace("<###hentou_hiduke###>",$shitumon_hentou_hiduke,$line7);

       $line9=str_replace("<###hiduke###>",$shitumon_hiduke,$line8);
 
       $line10=str_replace("<###EMPLOYERLIST###>",$shitumon_line,$line9);
 
       $line11=str_replace("<###EMPLOYERLIST2###>",$shitumon_line2,$line10);
 
       $line12=str_replace("<###hentou_jukousha###>",$shitumon_jukousha_hentou,$line11);
 
       $lines=$line12;
 
        echo $lines;
     }
     fclose($fp);
     }
     exit();
 
 ?>