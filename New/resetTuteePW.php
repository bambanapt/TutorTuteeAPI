<?php

require_once 'dbOperation.php';
$db = new dbOperation();

if(empty($_GET['id']) && empty($_GET['code'])) {
   $msg =  "<div class='alert alert-error'>
          <strong>Sorry!</strong>  No account found.
          </div>";
}

if(isset($_GET['id']) && isset($_GET['code'])) {
  $id = base64_decode($_GET['id']);
  $code = $_GET['code'];
 
  $stmt = $db->runQuery("SELECT * FROM tutees WHERE tutee_ID=:id AND tokenCode=:code");
  $stmt->execute(array(":id"=>$id,":code"=>$code));
  $rows = $stmt->fetch(PDO::FETCH_ASSOC);
 
  if($stmt->rowCount() == 1) {
    if(isset($_POST['btn-reset-pass'])) {
      $pass = $_POST['pass'];
      $cpass = $_POST['confirm-pass'];
   
      if($cpass!==$pass) {
        $msg =  "<div class='alert alert-block'>
          		<strong>Sorry!</strong>  Password doesn't match. <br />
          		Please try again.
          		</div>";
      } else {
        $stmt = $db->runQuery("UPDATE tutees SET password=:password WHERE tutee_ID=:id");
        $stmt->execute(array(":password"=>$cpass,":id"=>$rows['tutee_ID']));
    
        $msg = 	"<div class='alert alert-success'>
          		Password Changed.<br />
          		You can now login to TutorTutee App with your new password.
        		</div>";
      }
    } 
  } else {
    exit;
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>TutorTutee Password Reset</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="login">
    <div class="container">
     <div class='alert alert-success'>
   <strong>Hello Tutee <?php echo $rows['username'] ?>!</strong><br /> 
   You are here to reset your forgetton password.
  </div>
        <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Password Reset</h3><hr />
        <?php
        if(isset($msg))
  {
   echo $msg;
  }
  ?>
        <input type="password" class="input-block-level" placeholder="New Password" name="pass" required />
        <input type="password" class="input-block-level" placeholder="Confirm New Password" name="confirm-pass" required />
      <hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your Password</button>
        
      </form>

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>