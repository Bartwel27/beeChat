<?php
session_start();
//include "../assets/php/db.php";
//include "../assets/php/functions.php";
require dirname(__DIR__, 1).'/assets/php/db.php';
require dirname(__DIR__, 1).'/assets/php/functions.php';

if (isset($_POST["login"])) {
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);
  
  if (!empty($email) && !empty($password)) {
    $sql_check = "select * from users where email = ?";
    $stmt_check = mysqli_stmt_init($connect);
    mysqli_stmt_prepare($stmt_check,$sql_check);
    mysqli_stmt_bind_param($stmt_check,"s",$email);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);
    if (mysqli_num_rows($result) > 0) {
      $fetch = mysqli_fetch_assoc($result);
      $dbuser = $fetch["username"];
      $dbemail = $fetch["email"];
      $dbstatus = $fetch["status"];
      $dbuserid = $fetch["userid"];
      $dbpass = $fetch["password"];      
      if (password_verify($password, $dbpass)) {
        if ($dbstatus == "confirmed") {
          $_SESSION["username"] = $dbuser;
          $_SESSION["email"] = $dbemail;
          $_SESSION["status"] = $dbstatus;
          $_SESSION["userid"] = $dbuserid;
          
          _http_res(0,"../home/");
        } else {_innerjs("This account is not confirmed!");_http_res(0,"../");}
      } else {_innerjs("Wrong email or password!");_http_res(0,"../");}
    } else {_innerjs("This email is not registered!");_http_res(0,"../");}
  } else {_innerjs("No fields should be empty!");_http_res(0,"../");}
  
}
?>