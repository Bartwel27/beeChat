<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password Page</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  --><link rel="stylesheet" href="../assets/css/forgot.css" />
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="forgot-password-container">
        <div class="forgot-password-header">
          <h2>Forgot Password</h2>
        </div>
        <form class="forgot-password-form" action="forgot.php" method="post">
          <input type="email" name="email" placeholder="Email">
          <input type="submit" value="Reset Password">
        </form>
        <div class="back-to-login">
          Back to <a href="../">Login</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>