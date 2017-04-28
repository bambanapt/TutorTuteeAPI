<?php

require_once 'dbOperation.php';
$db = new dbOperation();

if(empty($_GET['id']) && empty($_GET['code']))
{
  $msg =  "<div class='alert alert-error'>
          <strong>Sorry!</strong>  No account found.
          </div>";
}

if(isset($_GET['id']) && isset($_GET['code']))
{
  $id = base64_decode($_GET['id']);
  $code = $_GET['code'];
 
  $activateY = "Y";
  $activateN = "N";
 
  $stmt = $db->runQuery("SELECT tutee_ID,activated FROM tutees WHERE tutee_ID=:id AND tokenCode=:code LIMIT 1");
  $stmt->execute(array(":id"=>$id,":code"=>$code));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);
  if($stmt->rowCount() > 0) {
    if($row['activated']==$activateN) {
      $stmt = $db->runQuery("UPDATE tutees SET activated=:activated WHERE tutee_ID=:id");
      $stmt->bindparam(":activated",$activateY);
      $stmt->bindparam(":id",$id);
      $stmt->execute(); 
   
      $msg =  "<div class='alert alert-success'>
              <strong>Congratulations!</strong>  Your tutee account is now activated.<br />
              You can now login to TutorTutee App.
              </div>"; 
    } else {
      $msg =  "<div class='alert alert-error'>
              <strong>Sorry!</strong>  Your tutee account is already activated.<br />
              You can login to TutorTutee App.
              </div>";
    }
  } else {
    $msg =  "<div class='alert alert-error'>
            <strong>Sorry!</strong>  No account found.<br />
            Please try to register again at TutorTutee App.
            </div>";
  } 
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>TutorTutee Confirm Registration</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
  <?php if(isset($msg)) { echo $msg; } ?>
    </div> <!-- /container -->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>