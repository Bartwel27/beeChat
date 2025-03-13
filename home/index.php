<?php
require "../login/login.php";

if ($_SESSION["username"] == "" && $_SESSION["email"] == "" && $_SESSION["status"] == "" && $_SESSION["userid"] == "") {
  _http_res(0,"../");
  exit;
} else {
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$status = $_SESSION["status"];
$userid = $_SESSION["userid"];

$userid = explode("_",$userid);
$userid = end($userid);
?>
<html>
 <head>
  <title><?= $username; ?>’s contacts</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="keyword" content="" />
  <meta name="theme-color" content="#E7EEF6" />
  
  <link rel="stylesheet" href="../assets/css/main.css" />
  
 </head>
 <body>
   
   <!-- container -->
   <div class="container">
     
     <!-- header -->
     <div class="header">
     
       <!-- head-svg -->
       <div class="head-svg">
         <button><svg width="35" height="35" viewBox="0 0 32 32"><path fill="#222" d="M16 10a6 6 0 0 0-6 6v8a6 6 0 0 0 12 0v-8a6 6 0 0 0-6-6zm-4.25 7.87h8.5v4.25h-8.5zM16 28.25A4.27 4.27 0 0 1 11.75 24v-.13h8.5V24A4.27 4.27 0 0 1 16 28.25zm4.25-12.13h-8.5V16a4.25 4.25 0 0 1 8.5 0zm10.41 3.09L24 13v9.1a4 4 0 0 0 8 0a3.83 3.83 0 0 0-1.34-2.89zM28 24.35a2.25 2.25 0 0 1-2.25-2.25V17l3.72 3.47A2.05 2.05 0 0 1 30.2 22a2.25 2.25 0 0 1-2.2 2.35zM0 22.1a4 4 0 0 0 8 0V13l-6.66 6.21A3.88 3.88 0 0 0 0 22.1zm2.48-1.56L6.25 17v5.1a2.25 2.25 0 0 1-4.5 0a2.05 2.05 0 0 1 .73-1.56zM15 5.5A3.5 3.5 0 1 0 11.5 9A3.5 3.5 0 0 0 15 5.5zm-5.25 0a1.75 1.75 0 1 1 1.75 1.75A1.77 1.77 0 0 1 9.75 5.5zM20.5 2A3.5 3.5 0 1 0 24 5.5A3.5 3.5 0 0 0 20.5 2zm0 5.25a1.75 1.75 0 1 1 1.75-1.75a1.77 1.77 0 0 1-1.75 1.75z"/></svg></button>
         <h1>version 0.1</h1>
       </div>
       <!-- head-svg -->
       
       <!-- search-lettle -->
       <div class="search-lettle">
         <a href="#.html">
          <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#4e6780" d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5A6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14z"/></svg>
          </button>
         </a>
         
         <button id="n">
          <?= strtoupper($username[0]); ?>
         </button>
       </div>
       <!-- search-lettle -->
       
     </div>
     <!-- header -->
     
     <!-- contacts -->
     <style>
      .contacts{
       width:100%;
       max-width:800px;
       margin:0 auto;
       
      }.contacts a{
        text-decoration:none;
        color:black;
      }.contacts a .user{
        width:100%;
        max-width:300px;
        margin:0 auto;
        margin-top:10px;
        background:white;
        border:0px solid grey;
        border-radius:5px;
        display:flex;
        justify-content:space-between;
        padding:10px;
      }.contacts a .user button{
        width:50px;
        height:50px;
        border-radius:25px;
        border:0px;
        font-size:20px;
        font-weight:bold;
      }.contacts a .user p{
        border:0px solid red;
        width:220px;
        margin:0px;
        margin-right:20px;
        margin-top:5px;
      }.contacts a .user p b{
        display:block;
      }
     </style>
     <div class="contacts">
      <?php
       $get_stmt = mysqli_stmt_init($connect2);
       if (mysqli_stmt_prepare($get_stmt,"select * from contact_{$userid} order by id desc")) {
         if (mysqli_stmt_execute($get_stmt)) {
         $get_res = mysqli_stmt_get_result($get_stmt);
         $get_rows = mysqli_num_rows($get_res);
           if ($get_rows > 0) {
             while ($get_fetch = mysqli_fetch_assoc($get_res)) {
              $getusername = $get_fetch["contact_username"];
              $getemail = $get_fetch["contact_email"];
              $getuserid = $get_fetch["contact_userid"];
              $getfile = $get_fetch["contact_file"];
          
              $get_inbox_query = mysqli_query($connect2, "select * from inbox_{$userid} where receiver_email = '$getemail' or sender_email = '$getemail' OR receiver_email = '$email' or sender_email = '$email' and receiver_userid = '$getuserid' order by id desc");
              $get_inbox_rows = mysqli_num_rows($get_inbox_query);
              $get_inbox_f = mysqli_fetch_assoc($get_inbox_query);
      ?>      
          <a href="chat/<?=$getfile?>">
           <div class="user">
            <button><?= strtoupper($getusername[0]); ?></button>
            <p>
             <?= strtoupper($getusername); ?>
             <?php
             if ($get_inbox_rows > 0) {
               if (strlen($get_inbox_f["message"]) > 25) {
                 echo "<b>".substr($get_inbox_f["message"], 0, 25)." ...</b>";
               } else {
                 echo "<b>".$get_inbox_f["message"]."</b>";
               }
             } else {
               echo "<br><span>no message</span>";
             }
             ?>
             
            </p>
           </div>
          </a>
      <?php
                
             }
           } else {
             echo "<p style='text-align:center;margin-top:20px;font-size:12px;'>You have no user contacts yet!</p>";
           }
         } else {
            echo "failed to perform actions";
         }
       } else {
         echo "failed to prepare data";
       }
      ?>
     </div>
     <!-- contacts -->
     
     
     
     
      
     <!-- add-float-container -->
     <div class="add-float-container">
       <h2>Search for contact</h2>
       <form action="search-email.php" method="post">
         <input type="email" name="email" placeholder="search..." />
         <button name="check_email" type="submit">Search</button>
       </form>
     </div>
     <!-- add-float-container -->
     
     <div class="add-float-button">  
      <button>
        <svg width="20" height="20" viewBox="0 0 16 16"><path fill="#000" d="M14 7v1H8v6H7V8H1V7h6V1h1v6z"/></svg>     
      </button>
     </div>
     
   </div>
   <!-- container -->
   
 </body>
 
 <script src="../assets/js/float-cont.js"></script>

</html>
<?php
}
?>
