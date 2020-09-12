<?php
       require_once('./errorlist.php');
       if(isset($_GET['em'])) {
       $error_no=$_GET['em'];
       } else {
       $error_no=0;
       }
       if(is_readable('./login.html')) {
       $fp=fopen('./login.html','r');
       while(!feof($fp)) {
       $line=fgets($fp);
      $lines=str_replace("<###ERROR###>",$error_msg[$error_no],$line);
        echo $lines;
       }
       fclose($fp);
       }
?>