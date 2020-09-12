<?php

    require_once('./detavase.php');

   session_save_path('/home/y_hama/session/');
   session_start();

   $kanrisha_id=$_SESSION['kanrisha_id'];
   $password=$_SESSION['kanrisha_pass'];
   $manager_flg=$_SESSION['manager_flg'];

   $path1 = './kadai_shousai.html';

   date_default_timezone_set('Asia/Tokyo');
   echo date("Y:-m-d H:i:s", filemtime($path1));


    $kadai_account_id=$_POST['kadai_account_id'];

    $kadai_mei=$_POST['kadai_mei'];

    $kadai_gaiyou=$_POST['kadai_gaiyou'];

    $kadai_naiyou=$_POST['kadai_naiyou'];

    $kadai_rei=$_POST['kadai_kaitourei'];

    $kaitou_code=$_POST['kaitou_code'];

    $kadai_hiduke=$_POST['kadai_hiduke'];

    $kaitou_jukousha=$_POST['kaitou_jukousha'];

    $kadai_ki=$_POST['kadai_ki'];

    $submit_option=$_POST['submit_option'];

    $target_id=$_POST['target_id'];


    try {
   $dbh = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_NAME."; charset=utf8", DB_ACCOUNT_ID , DB_ACCOUNT_PW);
   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
        echo'Connection failed: ' . $e->getMessage();
    exit;
}


    if($submit_option=="削除") {

    $stmt = $dbh->prepare('delete from kadai where kadai_id=:target_id');
      //変数紐づけ
    $stmt->bindParam(":target_id",$kadai_account_id,PDO::PARAM_INT);
        //削除なので従業員IDなし
    $target_user_id="";
      //情報変更

    } else if($submit_option=="更新") {
      $stmt = $dbh->prepare('update kadai set kadai_mei=:kadai_mei,kadai_gaiyou=:kadai_gaiyou,kadai_naiyou=:kadai_naiyou,kadai_kaitourei=:kadai_kaitourei,kadai_hiduke=:kadai_hiduke,kaitou_jukousha=:kaitou_jukousha,kadai_ki=:kadai_ki where kadai_id=:kadai_account_id and kadai_id=kaitou_id');

      $stmt->bindParam(":kadai_account_id",$kadai_account_id,PDO::PARAM_INT);
  
      $stmt->bindParam(":kadai_mei",$kadai_mei,PDO::PARAM_STR);
  
      $stmt->bindParam(":kadai_gaiyou",$kadai_gaiyou,PDO::PARAM_STR);
  
      $stmt->bindParam(":kadai_naiyou",$kadai_naiyou,PDO::PARAM_STR);
  
      $stmt->bindParam(":kadai_kaitourei",$kadai_rei,PDO::PARAM_STR);
  //    $stmt->bindParam(":kaitou_code",$kaitou_code,PDO::PARAM_STR);
  
      $stmt->bindParam(":kadai_hiduke",$kadai_hiduke,PDO::PARAM_STR);
      $stmt->bindParam(":kaitou_jukousha",$kaitou_jukousha,PDO::PARAM_STR);
      $stmt->bindParam(":kadai_ki",$kadai_ki,PDO::PARAM_STR);
  
      $target_user_id=$kadai_account_id;
  
      } else {
  
      $stmt=$dbh->prepare('select max(kadai_id)+1 kadai_id,max(kaitou_id)+1 kadai from kadai');
  
      $stmt->execute();
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $new_id=$result['kadai_id'];

      $new_kaitou_id=$result['kaitou_id'];
  
      $stmt = null;
  
      $stmt=$dbh->prepare('insert into kadai(kadai_id,kadai_mei,kadai_gaiyou,kadai_naiyou,kadai_kaitourei,kadai_hiduke,kadai_ki,kaitou_jukousha,kaitou_id)values(:kadai_id,:kadai_mei,:kadai_gaiyou,:kadai_naiyou,:kadai_kaitourei,:kadai_hiduke,:kadai_ki,:kaitou_jukousha,:kaitou_id)');
  
  
     $stmt->bindParam(":kadai_id",$new_id,PDO::PARAM_INT);
  
     $stmt->bindParam(":kadai_mei",$kadai_mei,PDO::PARAM_STR);
  
     $stmt->bindParam(":kadai_gaiyou",$kadai_gaiyou,PDO::PARAM_STR);
  
     $stmt->bindParam(":kadai_naiyou",$kadai_naiyou,PDO::PARAM_STR);
  
     $stmt->bindParam(":kadai_kaitourei",$kadai_rei,PDO::PARAM_STR);
  
  //  $stmt->bindParam(":kaitou_code",$kaitou_code,PDO::PARAM_STR);
     $stmt->bindParam(":kadai_hiduke",$kadai_hiduke,PDO::PARAM_STR);
    $stmt->bindParam(":kaitou_jukousha",$kaitou_jukousha,PDO::PARAM_STR);
     $stmt->bindParam(":kadai_ki",$kadai_ki,PDO::PARAM_STR);
  
    $stmt->bindParam(":kaitou_id",$new_kaitou_id,PDO::PARAM_INT);
     $target_user_id=$new_kaitou_id;
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
    
        //情報削除の場合は、従業員一覧に遷移
    
        if($submit_option == "削除") {
    
            header('location: ./kadai_list.php');
            exit;

          }
      
          if($submit_option == "追加") {
      
              header('location: ./kadai_list.php');
      
              exit;
          }
      
          if($submit_option == "更新") {
              header('location: ./kadai_list.php');
              exit;
          }
      
          $stmt = $dbh->prepare('select kadai_id,kadai_mei,kadai_gaiyou,kadai_naiyou,kadai_kaitourei,kaitou_code,kadai_hiduke,kaitou_jukousha,kadai_ki from kadai where kadai_id=:target_user_id');
      
          $stmt->bindParam(":target_user_id",$target_user_id,PDO::PARAM_INT);
          //実行
          $stmt->execute();
      
          if($stmt->rowCount() != 1) {
      
           echo "Error: データが特定できませんでした";
           exit;
          }
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          $kadai_account_id = $result['kadai_id'];
    
          $kadai_mei=$result['kadai_mei'];
    
          $kadai_gaiyou = $result['kadai_gaiyou'];
    
          $kadai_naiyou = $result['kadai_naiyou'];
    
          $kadai_rei = $result['kadai_kaitourei'];
    
          $kaitou_code =$result['kaitou_code'];
    
          $kadai_hiduke =$result['kadai_hiduke'];
    
          $kaitou_jukousha=$result['kaitou_jukousha'];
    
          $kadai_ki=$result['kadai_ki'];
    
        $result = null;
    
        $stmt = null;
    
    
        if(is_readable('./kadai_shousai.html')) {
    
        // ファイル内容を変数に取り込む
        $fp=fopen('./kadai_shousai.html','r');

        // ファイルの最後まで処理を行う
    
        while(!feof($fp)) {
    
           // 1行ずつファイルを読み込み変数にセット
    
           $line=fgets($fp);
         // データベースからセットする項目について置き換え（動的部分>）
          // 管理者出力
    
    $line1=str_replace("<###id###>",$kadai_account_id,$line);
    
           $line2=str_replace("<###mei###>",$kadai_mei,$line1);
    
           $line3=str_replace("<###gaiyou###>",$kadai_gaiyou,$line2);
    
           $line4=str_replace("<###naiyou###>",$kadai_naiyou,$line3);
    
           $line5=str_replace("<###rei###>",$kadai_rei,$line4);
    
           $line6=str_replace("<###SUBOPTION1###>","cheked",$line5);
           $line7=str_replace("<###SUBOPTION2###>","",$line6);
    
           $line8=str_replace("<###SUBOPTION3###>","",$line7);
    
           $line9=str_replace("<###EMPLOYERID###>",$target_user_id,$line8);
           $line10=str_replace("<###code###>",$kaitou_code,$line9);

           $line11=str_replace("<###hiduke###>",$kadai_hiduke,$line10);
                 $line12=str_replace("<###jukousha###>",$kaitou_jukousha,$line11);
                 $line13=str_replace("<###ki###>",$kaitou_ki,$line12);
           
                  $lines=$line13;
           
                  //  1行ずつ出力
                echo $lines;
               }
               fclose($fp);
               }
               exit();
           ?>