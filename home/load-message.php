<?php
require "../assets/php/db.php";
require "../assets/php/functions.php";

/*
msg:msg,
parentemail:parentemail,
parentusername:parentusername,
parentuserid:parentuserid,
receiveremail:receiveremail,
receiverusername:receiverusername,
receiveruserid:receiveruserid,
file:file
*/
if (isset($_POST["send_msg"])) {

$msg = $_POST["msg"];
$parentemail = $_POST["parentemail"];
$parentusername = $_POST["parentusername"];
$parentuserid = $_POST["parentuserid"];

$receiveremail = $_POST["receiveremail"];
$receiverusername = $_POST["receiverusername"];
$receiveruserid = $_POST["receiveruserid"];

$file = $_POST["file"];

if (
!empty($msg) &&
!empty($parentemail) &&
!empty($parentusername) &&
!empty($parentuserid) &&
!empty($receiveremail) &&
!empty($receiverusername) &&
!empty($receiveruserid)
) {
$send_stmt = mysqli_stmt_init($connect2);
 $send_sql = "insert into inbox_$parentuserid (sender_username, sender_email, sender_userid, receiver_username, receiver_email, receiver_userid, message) values 
 (?,?,?,?,?,?,?)";
if (mysqli_stmt_prepare($send_stmt, $send_sql)) {
  if (mysqli_stmt_bind_param($send_stmt, "sssssss", 
  $parentusername, $parentemail, $parentuserid, $receiverusername, $receiveremail, $receiveruserid, $msg)) {
  if (mysqli_stmt_execute($send_stmt)) {
		   
		   
		   $send_sql = "insert into inbox_$receiveruserid (sender_username, sender_email, sender_userid, receiver_username, receiver_email, receiver_userid, message) values 
		   (?,?,?,?,?,?,?)";
		   mysqli_stmt_prepare($send_stmt, $send_sql);
		   mysqli_stmt_bind_param($send_stmt, "sssssss", 
		   $parentusername, $parentemail, $parentuserid, $receiverusername, $receiveremail, $receiveruserid, $msg);
		   mysqli_stmt_execute($send_stmt);
		   
		   /*$sql = 'select * from inbox_$parentuserid';
		   if (mysqli_stmt_prepare($stmt,$sql)) {
		     if (mysqli_stmt_execute($stmt)) {
		       $stmt_res = mysqli_stmt_get_result($stmt);
		       $num_rows = mysqli_num_rows($stmt_res);
		       if ($num_rows > 0) {
		          while ($fetch = mysqli_fetch_assoc($stmt_res)) {
		           $id = $fetch['id'];
		           
		           $sender_username = $fetch['sender_username'];
		           $sender_email = $fetch['sender_email'];
		           $sender_userid = $fetch['sender_userid'];
		           
		           $receiver_username = $fetch['receiver_username'];
		           $receiver_email = $fetch['receiver_email'];
		           $receiver_userid = $fetch['receiver_userid'];
		           
		           $message = $fetch['message'];
		          
		 ?>
		   <!-- mymsg -->
		   <style>
		   .mymsg-box{
		     width:100%;
		     max-width:800px;
		     margin:0 auto;
		   }.mymsg-box .mymsg{
		     width:100%;
		     max-width:400px;
		     margin:0 auto;
		     display:flex;
		     border-bottom:0px solid grey;
		     margin-top:20px;
		   }.mymsg-box .mymsg button{
		     width:30px;
		     height:30px;
		     border-radius:15px;
		     border:0px;
		     margin-left:5px;
		     font-weight:bold;
		     background:linear-gradient(to right, #C8D4E0, #ACB6BF);
		     color:white;
		   }.mymsg-box .mymsg p{
		    width:300px;
		    padding:0px;
		    margin:0px 0px 0px 10px;
		    border:0px solid red;
		   }.mymsg-box .mymsg p b{
		    font-size:16px;
		    display:block;
		    margin-bottom:5px;
		   }.mymsg-box .mymsg p span{
		    display:block;
		    font-size:15px;
		   }
		   </style>
		   <div class='mymsg'>
		     <button>
		      <?= strtoupper($sender_username[0]); ?>
		     </button>
		     <p>
		      <b><?= $sender_username ?></b>
		      <span>
		        <?= $message ?>
		      </span>
		     </p>
		   </div>
		   <!-- mymsg -->
		 <?php
		           }
		       }
		     }
		  }
		  */
   _http_res(0,"chat/".$file);
   //_innerjs("sent to ".$receiverusername);
} else {
   _innerjs("unable to perform sending!");
   _http_res(0,"chat/".$file);
}

} else {
   _innerjs("unable to bind params");
   _http_res(0,"chat/".$file);
}

} else {
   _innerjs("unable to prepare message");
   _http_res(0,"chat/".$file);
}

// when not empty
} else {
  _innerjs("we are unable to send your message at the moment!");
  _http_res(0,"chat/".$file);
}

}
		 ?>