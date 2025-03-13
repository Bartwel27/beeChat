<?php

//require "../../assets/php/db.php";
//require "../../assets/php/functions.php";
require "../login/login.php";

echo '
<style>
 form{
   font-family:sans-serif;
 }form button{
   padding:10px;
   background:#222;
   color:white;
   font-weight:bold;
   border-radius:3px;
   border:2px solid grey;
 }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
';

if (isset($_POST["check_email"])) {
  $myemail = $_SESSION["email"];
  $email = trim($_POST["email"]);
  if (!empty($email)) {
    if (preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/", $email)) {
      $c_sql = "select * from users where email = ? AND email != ?";
      $c_stmt = mysqli_stmt_init($connect);
      if (mysqli_stmt_prepare($c_stmt, $c_sql)) {
         if (mysqli_stmt_bind_param($c_stmt, "ss", $email,$myemail)) {
            if (mysqli_stmt_execute($c_stmt)) {
              $c_results = mysqli_stmt_get_result($c_stmt);
              if (mysqli_num_rows($c_results) > 0) {
                $c_fetch = mysqli_fetch_assoc($c_results);
                
                $thereUsername = $c_fetch["username"];
                $thereEmail = $c_fetch["email"];
                $thereUserid = $c_fetch["userid"];
               
 ?> 
    <form action='add-contact.php' method='post'>
      <p><?php echo "record found for ".$c_fetch["username"];?></p>
      <input name="theEmail" value="<?= $thereEmail;?>" type="hidden" />
      <button name='add_contact' type='submit'>Add Contact</button>
      <a href='index.php'><button type='button' style="background:red;">Cancel</button></a>
    </form>
    
 <?php 
       
      
                mysqli_stmt_close($c_stmt);
              } else {
                 _http_res(0,"index.php");
                 _innerjs("No results found");
              }
            } else {
              _http_res(0,"index.php");
              _innerjs("Failed to perform action at the moment!");
            }
         } else {
            _http_res(0,"index.php");
            _innerjs("Failed to combine input!");
         }
      } else {
        _http_res(0,"index.php");
        _innerjs("Failed to prepare inputs!");
      }
    } else {
      _http_res(0,"index.php");
      _innerjs("Enter a valid email!");
    }
  } else {
   _http_res(0,"index.php");
   _innerjs("Field should not be empty!");
  }
}

?>
