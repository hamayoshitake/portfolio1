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

    $shitumon_id = '';

    $shitumon_jukousha='';
    $shitumon_gaiyou = '';

    $shitumon_hiduke='';

    $shitumon_ki='';

    $shitumon_line='';

    $target_user_id='';


  if(isset($_GET['sousin'])){

   $sousin =$_GET['sousin'];
   }else{
   $sousin = '';
   }

    $stmt=$dbh->prepare('select shitumon_id,shitumon_gaiyou,shitumon_hiduke,shitumon_ki,shitumon_jukousha from shitumon where shitumon.shitumon_ki=:sousin');

    $stmt->bindParam(":sousin",$sousin,PDO::PARAM_INT);

    $stmt->execute();

    $shitumon_line="";

    if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

    foreach ($result as $row) {

     $shitumon_gaiyou=$row['shitumon_gaiyou'];

     $shitumon_account_id = $row['shitumon_id'];

     $shitumon_hiduke = $row['shitumon_hiduke'];

     $shitumon_ki = $row['shitumon_ki'];

     $shitumon_jukousha = $row['shitumon_jukousha'];

       $shitumon_line.="<tr><td>".$shitumon_account_id."</td><td>".$shitumon_hiduke."</td><td>".$shitumon_gaiyou."</td><td>".$shitumon_ki."</td><td>".$shitumon_jukousha."</td><td><a href='./shitumon_shousai_j2.php?targetID=".$shitumon_account_id."'><button type='button'>詳細</button></a></td></tr>\n";

     }
      $result = null;
      $stmt = null;
     }
     $shitumon_line_2="";

     $stmt = $dbh->prepare('select shitumon_ki,shitumon_id from shitumon ');

      $stmt->execute();


      if($stmt->rowCount() < 1) {
      echo "Error: 受講マスタにレコードが存在しません";
      exit;
      }

     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

     foreach($result as $row) {

     $shitumon_id = $row['shitumon_id'];

     $shitumon_account_ki= $row['shitumon_ki'];

    if($sousin == '23期'){
   $shitumon_line_2 .= "<option value='".$shitumon_ki."' selected>".$shitumon_account_ki."</option>\n";
     }elseif($sousin == '22期'){
   $shitumon_line_2 .= "<option value='".$shitumon_ki."'>".$shitumon_account_ki."</option>\n";
     }elseif($sousin == '21期'){
      $shitumon_line_2 .= "<option value='".$shitumon_ki."'>".$shitumon_account_ki."</option>\n";
    }

   $result = null;
}
   $stmt = null;


  if(isset($_POST['name'])){

  $name=$_POST['name'];
  $name='%'.$name.'%';

  $stmt = $dbh->prepare('select shitumon_id,shitumon_gaiyou,shitumon_hiduke,shitumon_ki,shitumon_jukousha from shitumon where shitumon_gaiyou like :gaiyou');

   $stmt->bindValue(":gaiyou",$name,PDO::PARAM_STR);

   $stmt->execute();
   if($stmt->rowCount() < 1) {
    echo "Error: 管理マスタにレコードが存在しません";
    exit;
    }

 if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

  foreach ($result as $row) {

   $shitumon_gaiyou=$row['shitumon_gaiyou'];

   $shitumon_account_id = $row['shitumon_id'];

   $shitumon_hiduke = $row['shitumon_hiduke'];

   $shitumon_ki = $row['shitumon_ki'];

   $shitumon_jukousha = $row['shitumon_jukousha'];


 $shitumon_line.="<tr><td>".$shitumon_account_id."</td><td>".$shitumon_hiduke."</td><td>".$shitumon_gaiyou."</td><td>".$shitumon_ki."</td><td>".$shitumon_jukousha."</td><td><a href='./shitumon_shousai_j2.php?targetID=".$shitumon_account_id."'><button type='button'>詳細</button></a></td></tr>\n";
}
$result = null;

$stmt = null;
}
$dbh = null;
}

if(is_readable('./shitumon_list_j.html')) {

$fp=fopen('./shitumon_list_j.html','r');

while(!feof($fp)) {

   $line=fgets($fp);
  
   $line1=str_replace("<###LOGINNAME###>",$login_mei,$line);
  
   $line2=str_replace("<###pul###>",$shitumon_line_2,$line1);

   $line3=str_replace("<###EMPLOYERLIST###>",$shitumon_line,$line2);
   $line4=str_replace("<###EMPLOYERID###>",$target_user_id,$line3);

$lines=$line4;

echo $lines;
}

fclose($fp);
}
  exit();
?>