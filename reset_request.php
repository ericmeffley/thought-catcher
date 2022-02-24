<?php
include 'db.php';
include 'functions.php';


//INITIALIZE VARIABLES
$userEmail = "";
$email = "";
$success = "";
$error = "";

    if(isset($_POST['submit'])){

      if($_POST['email'] == ""){
  
        echo "Ooops you forgot to enter your email first.";
        
      }else{

        //STORE USER EMAIL
        $userEmail = $_POST['email'];

        //VALIDATE THAT USER EXISTS
        $validation_stmt = $connection->prepare("SELECT username FROM users WHERE username=?");

        $validation_stmt->bind_param("s", $userEmail);
        $validation_stmt->execute();
        $validation_stmt->bind_result($email);
        $validation_stmt->fetch();
        $validation_stmt->close();
        //echo $userEmail."<br>".$email."<br>";

        if($userEmail == $email){
            //echo "user: ".$userEmail."<br>Database: ".$email;

            //CREATE A TOKEN
            $token = GenerateToken();
            //echo $token;
			
            //STORE TOKEN IN DATABASE
            $verify_stmt = $connection->prepare("UPDATE users SET reset_token = ? WHERE username = ?");
            $verify_stmt->bind_param("ss",$token, $email);
            $verify_stmt->execute();
            $verify_stmt->close();

            //echo '<div><p>Click on the link below to reset your password.</p><a href="http://127.0.0.1/thoughts/password_reset.php?token='.$token.'">Click Here to reset your Password.</a></div>';
				
			//-------------------------------------------------------------		
			//MAIL FUNCTION TO SHOW DATA
			//-------------------------------------------------------------	

			//$to = $userEmail;
      $to = "eric@ericmeffley.com";
			$headers = "From: eric@ericmeffley.com\r\n";
			$headers .= "Cc: \r\n";
			$headers .= "Bcc: \r\n";

			$subject = "Password validation Requested";

			$content = 'Click on the link to reset your password. http://www.ericmeffley.com/thought-catcher/password_reset.php?token='.$token;


				if(mail($to, $subject, $content, $headers)){

					$success .= '<div class="alert alert-success">An email has been sent to the email on file.</div>';
				}

				

            } else {
                $error .= '<div class="alert alert-danger">Sorry, your password validation failed for some reason!</div>';
            }

              //header("Location: password_validation.php");
            
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
    <title>Password validation Request</title>

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
	<div id="message"><?php echo $success; echo $error; ?></div>
	  
  	<form method="post">
	  <div class="container">
		  <div class="form-group">
			<label for="email">Enter your email below and we will send a link to reset your password.</label>
			<input type="email" name="email" class="form-control" aria-describedby="email" placeholder="Email">
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary" style="float:right;">Submit Request</button>
	  </div>	  
	  
    </form>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<html>
