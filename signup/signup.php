<?php

require "../assets/php/db.php";
require "../assets/php/functions.php";
session_start();
if (isset($_POST["create_account"])) {
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);
  $userid = date("Y")."_".uniqid(true,"");
  $confirmPassword = trim($_POST["confirm_password"]);
  $password = trim($_POST["password"]);
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $status = "";
  if (strlen($username) <= 20) {
    if (strlen($email) <= 50) {
      if (strlen($password) >= 6) {
       if ($password == $confirmPassword) {
        if (preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/", $email)) {
         $sql_check = "SELECT * FROM users WHERE email = ?";
         $stmt_check = mysqli_stmt_init($connect);
          if (mysqli_stmt_prepare($stmt_check, $sql_check)) {
            if (mysqli_stmt_bind_param($stmt_check,"s",$email)) {
              if (mysqli_stmt_execute($stmt_check)) {
                $result_check = mysqli_stmt_get_result($stmt_check);
                $num_rows = mysqli_num_rows($result_check);
                if ($num_rows > 0) {
                  // user with this email already exists
                  _innerjs("This email is already registered!");
                  _http_res(0,"index.php");
                  mysqli_stmt_close($stmt_check);
                } else {
                  $sql_insert = "INSERT INTO users (username,email,userid,status,password) VALUES (?,?,?,?,?)";
                  $stmt_insert = $stmt_check;
                  if (mysqli_stmt_prepare($stmt_insert,$sql_insert)) {
                    if (mysqli_stmt_bind_param($stmt_insert,"sssss",$username,$email,$userid,$status,$hashedPassword)) {
                      if (mysqli_stmt_execute($stmt_insert)) {
                        // account created
                        
                        $confirmcode = rand(1,99999);
                        $send = array(
                         "to" => $email,
                         "subject" => "New Email Confirmation",
                         "message" => " 
                           <html>
                           <body>
                           <h2>Confirm Your Email Address</h2>
                           <p>Dear {$username},</p>
                           <p>Thank you for creating an account with us at beecorp-messanger!</p>
                           <p>To confirm your email address and activate your account, please enter the following confirmation code on our website:</p>
                           <p><strong>Confirmation Code:</strong> {$confirmcode}</p>
                           <p>If you have any issues confirming your email address, please contact our support team at <a href='mailto:support@beecorp.site'>support@beecorp.site</a>.</p>
                           <p>Thank you!</p>
                           <p>Best regards,</p>
                           <p>beecorp-messanger</p>
                           </body>
                           </html>
                         ",
                         "header" => "Confirm account"
                        );
                        
                        mail($send["to"],$send["subject"],$send["message"],$send["header"]);
                        
                        $_SESSION["username"] = $username;
                        $_SESSION["email"] = $email;
                        $_SESSION["userid"] = $userid;
                        $_SESSION["confirm"] = $confirmcode;
                        $_SESSION["status"] = $status;
                        
                        _http_res(0,"confirm.php");
                        mysqli_stmt_close($stmt_insert);
                      } else {
                        // failed to execute inserted data
                        _innerjs("something went wrong whiles executing insterted data!");
                        _http_res(0,"index.php");
                      }
                    } else {
                      // failed bind inserted params
                      _innerjs("something went wrong whiles using inserted params!");
                      _http_res(0,"index.php");
                    }
                  } else {
                    // failed to prepare insert
                    _innerjs("something went wrong whiles executing your input!");
                    _http_res(0,"index.php");
                  }
                }
              } else {
                // failed to execute
                _innerjs("something went wrong whiles trying to execute!");
                _http_res(0,"index.php");
              }
            } else {
              // failed to bind params
              _innerjs("something went wrong whiles using params!");
              _http_res(0,"index.php");
            }
          } else {
           // failed to prepare
           _innerjs("something went wrong whiles checking!");
           _http_res(0,"index.php");
          }
        } else {
          // check if its a valid email
          _innerjs("please use a valid email");
          _http_res(0,"index.php");
        }
       } else {
          // password did not match   
           _innerjs("passwords did not match!");
           _http_res(0,"index.php");
       }
      } else {
       // password should b 6 or greater
       _innerjs("6 charecters password limit!");
       _http_res(0,"index.php");
      }
    } else {
      // email should b 50 chars
      _innerjs("50 charecters email limit!");
      _http_res(0,"index.php");
    }
  } else {
   // username should b 20 chars
   _innerjs("20 charecters username limit!");
   _http_res(0,"index.php");
  }
  
}

?>