<?php

include 'db.php';
$error = "";
$token = "";
$success = "";
$newPass = "";
$confirmPass = "";
  
  if(isset($_POST['submit'])){

    //IF VERIFY TOKEN EXISTS => STORE VARIABLES
    if (isset($_GET['token'])){
      $token = $_GET['token'];
      $newPass = trim($_POST['password']);
      $confirmPass = trim($_POST['confirm-password']);
    }//</$_GET['token']

      //CHECK IF ENTERED PASSWORD MATCH
      if($newPass != $confirmPass){
          $error = '<div class="alert alert-danger">Oops! Passwords don\'t match. Please try again.</div>';
      }else{
          //ENCRYPT PASSWORD
          $hash = "$2y$10$";
          $salt = "l9asia5oanfv8no1aieh6a";
          $hash_salt = $hash.$salt;
          $newPass = crypt($newPass,$hash_salt);
          
          //Display entered values
          //echo $newPass."<br>".$token;

          //UPDATE VALUES IN DATABASE
          if($stmt = $connection->prepare("UPDATE users SET password=? WHERE reset_token=?")){
            $stmt->bind_param("ss", $newPass, $token);
            $stmt->execute();
            $stmt->close();
        
            $success = '<div class="alert alert-success">Your password change was successfull.</div>';

          }else{
            echo "Something went wrong please try again.";
          }
      }

    
  }
 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Thought Catcher Password Reset Request</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Web Fonts--> 
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Shrikhand" rel="stylesheet"> 
    
    <!-- Local CSS-->
    <link rel="stylesheet" type="text/css" href="css/styles.css?=1.1">  
    
  </head>
  <body>
	   <div class="header">
        	<p id="header-text">Thought Catcher<span style="font-size:.5em">(Beta)</span></p>
        	<p class="sub-header">An app for capturing fleeting thoughts</p>
    	</div>
	  
	  <!--<div id="error"><?php echo $error; ?></div>
	  <div id="sucess"><?php echo $success; ?></div>-->
	  
  <form method="post">
      
	  <div class="container">
          <div id="error"><?php echo $error; ?></div>
	      <div id="sucess"><?php echo $success; ?></div>
		  <h2 style="padding-bottom:3%">Enter your new password and submit.</h2>
		  <div class="form-group">
			  <label><strong>New Password</strong></label>
			  <input type="password" name="password" class="form-control">
			  <br>
			  <label><strong>Confirm Password</strong></label>
			  <input type="password" name="confirm-password" class="form-control">
			  <br>
			  <button class="btn btn-primary" type="submit" name="submit">Submit Change</button>
		  </div>
	  </div>
    </form>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<html>
