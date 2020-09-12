<?php


   require_once('./detavase.php');

   session_save_path('/home/y_hama/session/');

   session_start();

    $login_id=$_SESSION['kanrisha_id'];
    $login_mei=$_SESSION['kanrisha_mei'];
    $shitumon_account_id=$_POST['shitumon_account_id'];
    $shitumon_gaiyou=$_POST['shitumon_gaiyou'];

    $shitumon_naiyou=$_POST['shitumon_naiyou'];

    $shitumon_hentou=$_POST['shitumon_hentou'];

    $shitumon_jukousha=$_POST['shitumon_jukousha'];

    $shitumon_ki=$_POST['shitumon_ki'];

    $shitumon_hiduke=$_POST['shitumon_hiduke'];

    $shitumon_hentousha=$_POST['shitumon_hentousha'];
    $shitumon_hentousha=$_POST['shitumon_hentousha'];

    $shitumon_hentou_hiduke=$_POST['shitumon_hentou_hiduke'];
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

    $stmt = $dbh->prepare('delete from shitumon where shitumon_id=:target_id');
    $stmt->bindParam(":target_id",$shitumon_account_id,PDO::PARAM_INT);
    $target_user_id="";
  } else if($submit_option=="更新") {

    $stmt = $dbh->prepare('update shitumon set shitumon_gaiyou=:shitumon_gaiyou,shitumon_hiduke=:shitumon_hiduke,shitumon_naiyou=:shitumon_naiyou,shitumon_hentou=:shitumon_hentou,shitumon_ki=:shitumon_ki,shitumon_jukousha=:shitumon_jukousha,shitumon_hentousha=:shitumon_hentousha,shitumon_hentou_hiduke=:shitumon_hentou_hiduke where shitumon_id=:shitumon_account_id');

    $stmt->bindParam(":shitumon_account_id",$shitumon_account_id,PDO::PARAM_INT);

    $stmt->bindParam(":shitumon_gaiyou",$shitumon_gaiyou,PDO::PARAM_STR);
    $stmt->bindParam(":shitumon_hiduke",$shitumon_hiduke,PDO::PARAM_STR);

    $stmt->bindParam(":shitumon_naiyou",$shitumon_naiyou,PDO::PARAM_STR);

    $stmt->bindParam(":shitumon_hentou",$shitumon_hentou,PDO::PARAM_STR);

    $stmt->bindParam(":shitumon_ki",$shitumon_ki,PDO::PARAM_STR);

    $stmt->bindParam(":shitumon_jukousha",$shitumon_jukousha,PDO::PARAM_STR);

    $stmt->bindParam(":shitumon_hentousha",$shitumon_hentousha,PDO::PARAM_STR);

    $stmt->bindParam(":shitumon_hentou_hiduke",$shitumon_hentou_hiduke,PDO::PARAM_STR);
    $target_user_id=$shitumon_account_id;

  } else {
$stmt=$dbh->prepare('select shitumon_id from shitumon');

$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$new_id=$result['shitumon_id'];

 $stmt = null;

 $stmt=$dbh->prepare('insert into shitumon(shitumon_id,shitumon_hentou,shitumon_hentousha,shitumon_hentou_hiduke)values(:target_user_id,:shitumon_hentou,:shitumon_hentousha,:shitumon_hentou_hiduke)');

 $stmt->bindParam(":target_user_id",$shitumon_account_id,PDO::PARAM_INT);
 $stmt->bindParam(":shitumon_hentou",$shitumon_hentou,PDO::PARAM_STR);

   $stmt->bindParam(":shitumon_hentousha",$shitumon_hentousha,PDO::PARAM_STR);

   $stmt->bindParam(":shitumon_hentou_hiduke",$shitumon_hentou_hiduke,PDO::PARAM_STR);


   $target_user_id=$shitumon_account_id;

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

     header('location: ./situmon_list.php');

     exit;

}
if($submit_option == "追加") {

     header('location: ./situmon_list.php');

     exit;
}
if($submit_option == "更新") {

     header('location: ./situmon_list.php');

     exit;
}

   $stmt= $dbh->prepare('select shitumon_id,shitumon_hentou,shitumon_hentousha,shitumon_hentou_hiduke from shitumon where shitumon_id=:target_user_id');
   $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);

   $stmt->execute();
 
     if($stmt->rowCount() != 1) {
 
      echo "Error: データが測定できませんでした";
      exit;
      }
 
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
      $shitumon_account_id = $result['shitumon_id'];
 
      $shitumon_hentou = $result['shitumon_hentou'];
 
      $shitumon_hentousha=$result['shitumon_hentousha'];
 
      $shitumon_hentou_hiduke = $result['shitumon_hentou_hiduke'];
 
     $result = null;
 
     $stmt = null;
 
 
     if(is_readable('./situmon_shousai.html')) {
      $fp=fopen('./situmon_shousai.html','r');
 
      while(!feof($fp)) {
  
         $line=fgets($fp);
       
         $line1=str_replace("<###id###>",$shitumon_account_id,$line);
  
         $line2=str_replace("<###daimei###>",$shitumon_daimei,$line1);
  
         $line3=str_replace("<###gaiyou###>",$shitumon_gaiyou,$line2);
  
         $line4=str_replace("<###naiyou###>",$shitumon_naiyou,$line3);
  
         $line5=str_replace("<###hentou###>",$shitumon_hentou,$line4);
  
         $line6=str_replace("<###SUBOPTION1###>","cheked",$line5);
  
         $line7=str_replace("<###SUBOPTION2###>","",$line6);
  
         $line8=str_replace("<###SUBOPTION3###>","",$line7);
         $line9=str_replace("<###EMPLOYERID###>",$target_user_id,$line8);

         $line10=str_replace("<###jukousha###>",$shitumon_jukousha,$line9);
  
         $line11=str_replace("<###ki###>",$shitumon_ki,$line10);
  
         $line12=str_replace("<###hentousha###>",$shitumon_hentousha,$line11);
  
         $line13=str_replace("<###hentou_hiduke###>",$shitumon_hentou_hiduke,$line12);
  
         $line14=str_replace("<###hiduke###>",$shitumon_hiduke,$line13);
          $line15=str_replace("<###EMPLOYERLIST###>",$shitumon_line,$line14);
         $lines=$line15;
  
       echo $lines;
      }
      fclose($fp);
      }
      exit();
  ?>