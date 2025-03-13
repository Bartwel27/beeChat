<?php

require "signup.php";

$status = $_SESSION["status"];
$userid = $_SESSION["userid"];

if ($_SESSION["userid"]=="") {
  _http_res(0,"../");
  _innerjs("no session!");
  exit();
}

// split the userid
$split_userid = explode("_",$userid);
$first_index = $split_userid[0];
$last_index = $split_userid[1];

$sql_table = array(
 "contact" => "
    create table contact_{$last_index}(
      id int(11) not null primary key auto_increment,
      contact_username varchar(200) not null,
      contact_email varchar(200) not null,
      contact_userid varchar(200) not null,
      contact_file varchar(100) not null
   );
 ",
 "inbox" => "
    create table inbox_{$last_index}(
      id int(11) not null primary key auto_increment,
      sender_username varchar(200) not null,
      sender_email varchar(200) not null,
      sender_userid varchar(200) not null,
      receiver_username varchar(200) not null,
      receiver_email varchar(200) not null,
      receiver_userid varchar(200) not null,
      message text not null
    );
 "
);

$sql_arr = array(
  $sql_table["contact"],
  $sql_table["inbox"]
);

?>
<html>
<head>
<title>Confirm Email</title>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="white">
<meta name="author" content="Beecorp">

<link rel="stylesheet" href="../assets/css/confirm.css">
<link rel="icon" href="" type="image">

<style>
</style>

</head>
<body>


<!--container start-->
<div id="container">
 
 
 
 <!--deta start-->
  <style>
  
  </style>
  <div id="deta">
    <h2>Email Confirmation</h2>
  
  <div id="deta-wraping">
   <center>
   <form action="confirm.php" method="POST">     
      <p>Please enter the confirmation code sent to <?= $_SESSION["email"]; ?> address.</p>
      <input type="text" value="<?= $_SESSION["confirm"]; ?>" name="confirmation_code" placeholder="Confirmation Code" required>
     
      <br>
     
      <button type="text" name="confirm" name="submit">
       Confirm Email
      </button>
     
     </form>
      
      
      <a href="../" >
       Back
      </a>
     
     
   </center>
  </div>
  
  </div>
 <!--deta end-->
 

</div>
<!--container end-->

</body>
</html>


<?php

if (isset($_POST["confirm"])) {
   $confirmation_code = $_POST["confirmation_code"];
   if ($confirmation_code == $_SESSION["confirm"]) {
   $uid=$_SESSION["userid"];
     mysqli_query($connect,"update users set status = 'confirmed' where userid = '$uid'");
     mysqli_close($connect);
     
     for ($c = 0; $c < 2; $c++) {
      mysqli_query($connect2,$sql_arr[$c]);
     }
     mysqli_close($connect2);
     
     _innerjs("account created");
     _http_res(0,"../");
     session_destroy();
     exit();
   } else {
     _innerjs("try again");
     _http_res(0,"confirm.php");
   }
}

?>