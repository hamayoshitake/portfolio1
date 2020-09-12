<?php
 require_once('./detavase.php');

 $shain_id=$_POST['shain_id'];

 $password=$_POST['password'];

 $manager_flg=$_POST['login'];


 try{
 $dbh = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8",DB_ACCOUNT_ID,DB_ACCOUNT_PW);

 $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
 echo 'Connection failed:'.$e->getMessage();
 exit;
 }

 $stmt = $dbh->prepare('select kanrisha_id,kanrisha_pass,manager_flg,kanrisha_mei from kanrisha where kanrisha_id=:kanrisha_id and kanrisha_pass=:kanrisha_pass ');

 $stmt->bindParam(":kanrisha_id",$shain_id,PDO::PARAM_INT);
 $stmt->bindParam(":kanrisha_pass",$password,PDO::PARAM_INT);

//管理者フラグ取得
// $stmt->bindParam(":manager_flg",$manager_flg,PDO::PARAM_INT);

 $stmt->execute();

   if($stmt->rowCount() != 1) {
       move_login();
   }
 $result=$stmt->fetch(PDO::FETCH_ASSOC);

 $kanrisha_id= $result['kanrisha_id'];
 $kanrisha_pass=$result['kanrisha_pass'];
 $manager_flg=$result['manager_flg'];
 $kanrisha_mei=$result['kanrisha_mei'];

 session_save_path('/home/y_hama/session/');
 session_start();
 $_SESSION = array();
 $_SESSION['kanrisha_id']=$kanrisha_id;
 $_SESSION['kanrisha_pass']=$kanrisha_pass;
 $_SESSION['manager_flg']=$manager_flg;
 $_SESSION['kanrisha_mei']=$kanrisha_mei;

 $stmt=null;
 $dbh=null;

   if($manager_flg =='1'){

   header("location:./kanrisha_menu.html");
  }else if($manager_flg =='0') {
   header("location:./jukousha_menu.html");
   exit;
   }
    function  move_login(){
   header("location: ./login.php?em=1");
   exit;
   }

  ?>