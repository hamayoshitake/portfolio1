<?php

   require_once('./detavase.php');

   session_save_path('/home/y_hama/session/');

   session_start();

    $login_id=$_SESSION['kanrisha_id'];
    $login_mei=$_SESSION['kanrisha_mei'];

    $shitumon_account_id=$_POST['shitumon_account_id'];

    $shitumon_gaiyou=$_POST['shitumon_gaiyou'];

    $shitumon_naiyou=$_POST['shitumon_naiyou'];

    $shitumon_jukousha=$_POST['shitumon_jukousha'];

    $shitumon_ki=$_POST['shitumon_ki'];

    $shitumon_hiduke=$_POST['shitumon_hiduke'];
    $shitumon_jukousha_hentou=$_POST['shitumon_jukousha_hentou'];

    $submit_option=$_POST['submit_option'];



    try {
   $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);
   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e)
        {
     echo 'Connection failed:' . $e->getMessage();
      exit;
        }


    if($submit_option=="削除") {

    $stmt = $dbh->prepare('delete from shitumon where shitumon_id=:target_id and shitumon_jukousha=:shitumon_jukousha');
    $stmt->bindParam(":target_id",$shitumon_account_id,PDO::PARAM_INT);
    $stmt->bindParam(":shitumon_jukousha",$shitumon_jukousha,PDO::PARAM_STR);
    $target_user_id="";
    
  } else if($submit_option=="更新") {

  $stmt = $dbh->prepare('update shitumon set shitumon_gaiyou=:shitumon_gaiyou,shitumon_hiduke=:shitumon_hiduke,shitumon_naiyou=:shitumon_naiyou,shitumon_jukousha=:shitumon_jukousha,shitumon_jukousha_hentou=:shitumon_jukousha_hentou where shitumon_id=:shitumon_account_id and shitumon_ki=:shitumon_ki');

  $stmt->bindParam(":shitumon_account_id",$shitumon_account_id,PDO::PARAM_INT);

  $stmt->bindParam(":shitumon_gaiyou",$shitumon_gaiyou,PDO::PARAM_STR);

  $stmt->bindParam(":shitumon_hiduke",$shitumon_hiduke,PDO::PARAM_STR);

  $stmt->bindParam(":shitumon_naiyou",$shitumon_naiyou,PDO::PARAM_STR);

  $stmt->bindParam(":shitumon_ki",$shitumon_ki,PDO::PARAM_STR);
  $stmt->bindParam(":shitumon_jukousha",$shitumon_jukousha,PDO::PARAM_STR);

  $stmt->bindParam(":shitumon_jukousha_hentou",$shitumon_jukousha_hentou,PDO::PARAM_STR);

  $target_user_id=$shitumon_account_id;

   } else {
    $stmt=$dbh->prepare('select max(shitumon_id)+1 shitumon_id from shitumon');

    $stmt->execute();
 
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
    $new_id=$result['shitumon_id'];
 
     $stmt = null;
 
     $stmt=$dbh->prepare('insert into shitumon(shitumon_id,shitumon_gaiyou,shitumon_hiduke,shitumon_naiyou,shitumon_ki,shitumon_jukousha,shitumon_jukousha_hentou)values(:new_id,:shitumon_gaiyou,:shitumon_hiduke,:shitumon_naiyou,:shitumon_ki,:shitumon_jukousha,:shitumon_jukousha_hentou)');
 
  $stmt->bindParam(":new_id",$new_id,PDO::PARAM_INT);
 
     $stmt->bindParam(":shitumon_gaiyou",$shitumon_gaiyou,PDO::PARAM_STR);
 
     $stmt->bindParam(":shitumon_hiduke",$shitumon_hiduke,PDO::PARAM_STR);
 
     $stmt->bindParam(":shitumon_naiyou",$shitumon_naiyou,PDO::PARAM_STR);
  
     $stmt->bindParam(":shitumon_ki",$shitumon_ki,PDO::PARAM_STR);
 
     $stmt->bindParam(":shitumon_jukousha",$shitumon_jukousha,PDO::PARAM_STR);
   
       $stmt->bindParam(":shitumon_jukousha_hentou",$shitumon_jukousha_hentou,PDO::PARAM_STR);
   
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
   
           header('location: ./shitumon_list_j.php');
   
           exit;
   
     }
     if($submit_option == "追加") {
   
           header('location: ./shitumon_list_j.php');
   
           exit;
     }
     if($submit_option == "更新") {
   
           header('location: ./shitumon_list_j.php');
   
           exit;
     }
    echo $shitumon_hentou;exit;
   
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
          if(is_readable('./shitumon_shousai_j.html')) {

            $fp=fopen('./shitumon_shousai_j.html','r');
            while(!feof($fp)) {
        
               $line=fgets($fp);
                  
               $line1=str_replace("<###id###>",$shitumon_account_id,$line);
        
               $line2=str_replace("<###gaiyou###>",$shitumon_gaiyou,$line1);
        
               $line3=str_replace("<###naiyou###>",$shitumon_naiyou,$line2);
        
               $line4=str_replace("<###SUBOPTION1###>","cheked",$line3);
               $line5=str_replace("<###SUBOPTION2###>","",$line4);

               $line6=str_replace("<###SUBOPTION3###>","",$line5);
        
               $line7=str_replace("<###EMPLOYERID###>",$target_user_id,$line6);
        
               $line8=str_replace("<###jukousha###>",$shitumon_jukousha,$line7);
        
               $line9=str_replace("<###ki###>",$shitumon_ki,$line8);
        
               $line10=str_replace("<###hiduke###>",$shitumon_hiduke,$line9);
        
               $line11=str_replace("<###EMPLOYERLIST###>",$shitumon_line,$line10);
        
               $line12=str_replace("<###EMPLOYERLIST2###>",$shitumon_line2,$line11);
        
               $line13=str_replace("<###hentou_jukousha###>",$shitumon_jukousha_hentou,$line12);
        
               $lines=$line13;
  
           echo $lines;
            }
            fclose($fp);
          }
          exit();
      ?>