<?php
/*
   -- I'M The PARENT here
   -- all identifications should come
      from me
*/
require "../login/login.php";

 if (isset($_POST["add_contact"])) {
 
 /*
 ------ use this to put in -------
    ---    there table    ---
     so that they can also be 
     able to identify us as a contact   
 */
 $parent_Username = $_SESSION["username"];
 $parent_Useremail = $_SESSION["email"];
 $parent_Userid = $_SESSION["userid"];
 
 // split the parents userid
 $parent_Userid = explode("_",$parent_Userid);
 $parent_Userid = end($parent_Userid); // use this instead of $parent_Userid
  
  // use the informatin provided to get data from this user
  $theEmail = $_POST["theEmail"];
  $add_sql = "select username, email, userid from users where email = ?";
  $add_stmt = mysqli_stmt_init($connect);
  mysqli_stmt_prepare($add_stmt, $add_sql);
  mysqli_stmt_bind_param($add_stmt, "s", $theEmail);
  mysqli_stmt_execute($add_stmt);
  
  // successfully fetched data from this user
  $add_result = mysqli_stmt_get_result($add_stmt);
  $add_fetch = mysqli_fetch_assoc($add_result);
  
  /*
    ------ use this to put in -------
       ---    parent table    ---
       so that we can identify them as
       our contact
  */
  $dbUsername = $add_fetch["username"];
  $dbEmail = $add_fetch["email"];
  $dbUserid = $add_fetch["userid"];
  
  $check_parent = mysqli_query($connect2, "select contact_email from contact_{$parent_Userid} where contact_email = '$theEmail'");
  $check_parent_f = mysqli_fetch_assoc($check_parent);
  
  // split there userid
  $dbUserid_split = explode("_",$dbUserid);
  $dbUserid = end($dbUserid_split); // get this instead of $dbUserid_split
  
  // put stractured tables in an array
  $sql_table = array(
  // "contact_$parent_Userid",
  // "contact_$dbUserid_split"
  );
   
  /*
    -- I have to go to my table
    -- to check for this guy
    -- Am the PARENT remember!
    -- in the second connection ok
  */
  
  $check_table = mysqli_query($connect2,"select contact_email from contact_{$parent_Userid} where contact_email = '$dbEmail'");
  if (mysqli_num_rows($check_table) == 0) {
     $file = "app-".uniqid(true,"").".php";
     $d="$";
     $code = "<?php
 require dirname(__DIR__, 2).'/login/login.php';
 
 {$d}email_parent = '$parent_Useremail';
 {$d}email_user = '$dbEmail';
 
 {$d}username_parent = '$parent_Username';
 {$d}username_user = '$dbUsername';
 
 {$d}userid_parent = '$parent_Userid';
 {$d}userid_user = '$dbUserid';
 
 {$d}file = '$file';
 
 {$d}stmt = mysqli_stmt_init({$d}connect2);
 
 if (
 !{$d}_SESSION['username'] == {$d}username_parent &&
 !{$d}_SESSION['email'] == {$d}email_parent ||
 !{$d}_SESSION['username'] == {$d}username_user &&
 !{$d}_SESSION['email'] == {$d}email_user 
 ) {
  _innerjs('not permited');
  _http_res(0,'../../../');
 } else {
   
   
   
 }
 
?>

<html>
	<head>
		<title>Messages</title>
		 <meta charset='utf-8' />
		 <meta name='viewport' content='width=device-width, initial-scale=1.0' />
		 <meta name='theme-color' content='default' />
		 <meta name='description' content='' />
		 <meta name='keywords' content='' />
		 
		 <link rel='stylesheet' href='css/' />
		 <link rel='stylesheet' href='css/' />
		 <script src='../../assets/js/jQuery.js'></script>
	</head>
	<body>
		 <!--container-->
		 <div class='container'>
		   
		    <!-- head -->
		    <style>
		    body{
		     width:100%;
		     max-width:800px;
		     margin:0 auto;
		     padding:0px;
		     position:relative;
		     font-family:sans-serif;
		    }
		      .head {
		      width:100%;
		      max-width:800px;
		      margin:0 auto;
		      background:#E7EEF6;
		      height:;
		      display:;
		      justify-content:space-between;
		      position:sticky;
		      top:0;
		      }
		      
		      .head .search-lettle{
		      width:100%;
		      max-width:300px;
		      height:50px;
		      border:0px solid grey;
		      display:flex;
		      padding:10px 0px 10px 0px;
		      margin-left:10px;
		      }.head .search-lettle button{
		      background:none;
		      border:0px;
		      margin-top:5px;
		      }.head .search-lettle #n{
		      width: 40px;
		      height:40px;
		      border-radius:20px;
		      border:0px;
		      font-weight:bold;
		      background: #8A6E63;
		      color:white;
		      font-size:20px;
		      }.head .search-lettle p{
		        width:250px;
		        padding:0px;
		        margin:0px;
		        border:0px solid red;
		        height:30px;
		        margin-top:15px;
		        margin-left:10px;
		      }
		      
		    </style>
		    <div class='head'>
		      
		      <!-- search-lettle -->
		      <div class='search-lettle'>	      
		      <button id='n'>
		      <?php
		        if ({$d}_SESSION['username'] == {$d}username_parent) {
		          echo strtoupper({$d}username_user[0]);
		        } else {
		          echo strtoupper({$d}username_parent[0]);
		        }
		      ?>
		      </button>
		      <p>
		        <?php
		          if ({$d}_SESSION['username'] == {$d}username_parent) {
		            echo {$d}username_user;
		          } else {
		            echo {$d}username_parent;
		        }
		        ?>
		      </p>
		      </div>
		      <!-- search-lettle -->
		      
		    </div>
		    <!-- head -->		   
		   
		  <!-- mymsg-box -->
		  <div class='mymsg-box'>
		  
		 <?php
		   {$d}sql = 'select * from inbox_$parent_Userid where receiver_email = ?';
		   if (mysqli_stmt_prepare({$d}stmt,{$d}sql)) {
		      mysqli_stmt_bind_param({$d}stmt, 's', {$d}email_user);
		     if (mysqli_stmt_execute({$d}stmt)) {
		       {$d}stmt_res = mysqli_stmt_get_result({$d}stmt);
		       {$d}num_rows = mysqli_num_rows({$d}stmt_res);
		       if ({$d}num_rows > 0) {
		          while ({$d}fetch = mysqli_fetch_assoc({$d}stmt_res)) {
		           {$d}id = {$d}fetch['id'];
		           
		           {$d}sender_username = {$d}fetch['sender_username'];
		           {$d}sender_email = {$d}fetch['sender_email'];
		           {$d}sender_userid = {$d}fetch['sender_userid'];
		           
		           {$d}receiver_username = {$d}fetch['receiver_username'];
		           {$d}receiver_email = {$d}fetch['receiver_email'];
		           {$d}receiver_userid = {$d}fetch['receiver_userid'];
		           
		           {$d}message = {$d}fetch['message'];
		          
		 ?>
		   <!-- mymsg -->
		   <style>
		   .mymsg-box{
		     width:100%;
		     max-width:800px;
		     margin:0 auto;
		     margin-bottom:100px;
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
		      <?= strtoupper({$d}sender_username[0]); ?>
		     </button>
		     <p>
		      <b><?= {$d}sender_username ?></b>
		      <span>
		        <?= {$d}message ?>
		      </span>
		     </p>
		     
		   </div>
		   <!-- mymsg -->
		 <?php
		           }
		       }
		     }
		  }
		 ?>
		   
		  </div>
		  <!-- mymsg-box -->
		   
		   <!-- msg -->
		   <style>
		    .msg{
		      width:100%;
		      max-width:400px;
		      margin:0 auto;
		      position:fixed;
		      bottom:0;
		      left:0;
		      right:0;
		      background:white;
		      height:60px;
		      border-top:01px solid #eee;
		    }.msg form{
		      border:0px solid red;
		      display:flex;
		      margin-top:10px;
		    }.msg form input{
		      width:350px;
		      height:40px;
		      outline:none;
		      border:0px;
		      background:white;
		      resize:none;
		    }.msg form button{
		      width:50px;
		      height:40px;
		      border:0px;
		      background:white;
		      font-weight:bold;
		    }
		   </style>
		   <div class='msg'>
		     <form action='../load-message.php' method='post'>
		     
		       <input name='parentemail' type='email' value='<?= {$d}email_parent ?>' hidden />
		       <input name='parentusername' value='<?= {$d}_SESSION['username'] ?>' hidden />
		       <input name='parentuserid' value='<?= {$d}userid_parent ?>' hidden />
		       
		       <input name='receiveremail' type='email' value='<?= {$d}email_user ?>' hidden />
		       <input name='receiverusername' value='<?= {$d}username_user ?>' hidden />
		       <input name='receiveruserid' value='<?= {$d}userid_user ?>' hidden />
		       
		       <input name='file' value='<?= {$d}file ?>' hidden />
		     
		       <input id='msg' type='text' name='msg' placeholder='type...' required />
		       
		       <button id='sendbtn' name='send_msg' type='submit'>
		        <svg width='24' height='24' viewBox='0 0 24 24'><path fill='#222' d='m20.34 9.32l-14-7a3 3 0 0 0-4.08 3.9l2.4 5.37a1.06 1.06 0 0 1 0 .82l-2.4 5.37A3 3 0 0 0 5 22a3.14 3.14 0 0 0 1.35-.32l14-7a3 3 0 0 0 0-5.36Zm-.89 3.57l-14 7a1 1 0 0 1-1.35-1.3l2.39-5.37a2 2 0 0 0 .08-.22h6.89a1 1 0 0 0 0-2H6.57a2 2 0 0 0-.08-.22L4.1 5.41a1 1 0 0 1 1.35-1.3l14 7a1 1 0 0 1 0 1.78Z'/></svg>
		       </button>
		     </form>
		   </div>
		   <!-- msg -->
		   
		   
<script>
 /*
  let msg = document.querySelector('#msg');
  $(document).ready(function(){
   $('#send_btn').click(function(){
        let parentemail = '<?= {$d}email_parent ?>';
        let parentusername = '<?= {$d}username_parent ?>';
        let parentuserid = '<?= {$d}userid_parent ?>';
       
        let receiveremail = '<?= {$d}email_user ?>';
        let receiverusername = '<?= {$d}username_user ?>';
        let receiveruserid = '<?= {$d}userid_username ?>';
        
        let file = '<?= {$d}file ?>';
        
        msg = msg.value;
     $('.mymsg-box').load('../load-message.php',{
       msg:msg,
       parentemail:parentemail,
       parentusername:parentusername,
       parentuserid:parentuserid,
       receiveremail:receiveremail,
       receiverusername:receiverusername,
       receiveruserid:receiveruserid
     });
   });
  });
  */
</script>
		   
		   
		 </div>
		 <!--container-->

	</body>
	
	<script scr=''></script>
	<script src=''></script>
	
</html>


     ";
     
     $myfile = fopen("chat/{$file}","w");
     fwrite($myfile, $code);
     fclose($myfile);
     $ins_sql = array(
      "INSERT INTO contact_{$parent_Userid} (contact_username,contact_email,contact_userid,contact_file) VALUES 
      (?,?,?,?)",
      "INSERT INTO contact_{$dbUserid} (contact_username,contact_email,contact_userid,contact_file) VALUES 
      (?,?,?,?)"
      );
     
     //for ($i=0;$i<count($ins_sql);$i++)  {
    //   mysqli_query($connect2,$ins_sql[$i]);
      //use prepared stmts
      $i_stmt = mysqli_stmt_init($connect2);
      
      mysqli_stmt_prepare($i_stmt,$ins_sql[0]);
      mysqli_stmt_bind_param($i_stmt,"ssss",$dbUsername,$dbEmail,$dbUserid,$file);
      mysqli_stmt_execute($i_stmt);
      
      mysqli_stmt_prepare($i_stmt,$ins_sql[1]);
      mysqli_stmt_bind_param($i_stmt,"ssss",$parent_Username,$parent_Useremail,$parent_Userid,$file);
      mysqli_stmt_execute($i_stmt);
    // }
     
     mysqli_close($connect2);
     _http_res(0,"index.php");
     _innerjs("added to contact");
     
  } else {
    _innerjs("This user is already a contact!");
    _http_res(0,"index.php");
  }
  
 }
