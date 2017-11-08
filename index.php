<?php
	
	ob_start();
    session_start();
    date_default_timezone_set("America/New_York");
    include 'db.php';


    //INITIALIZE VARIABLES// 
    $error = "";
    $successMessage = "";
    $_SESSION['displayname']="";
    
    if($_SESSION['displayname'] && $_SESSION['username'] && $_SESSION['id']){
        header("Location: main.php");
    }else{
    
        if (isset($_POST['submit'])){
            
            //STORE ENTERED USERNAME AND PASSWORD
            $enteredPassword = $_POST['password'];
            $enteredUsername = $_POST['username'];
            
            
            //ENCRYPT PASSWORD
            $hash = "$2y$10$";
            $salt = "l9asia5oanfv8no1aieh6a";
            $hash_and_salt = $hash.$salt;
            $enteredPassword = crypt($enteredPassword,$hash_and_salt);

            //QUERY USERNAME
            if($stmt = $connection->prepare("SELECT id, username FROM `users` WHERE username=?")){
                
                $stmt->bind_param("s", $enteredUsername);
                $stmt->execute();
                $stmt->bind_result($id, $userName);
                $stmt->fetch();
                $stmt->close();
                
            }else{
                $error = '<div class="alert alert-warning">Query Failed, Please try again.</div';
            }
            
            //IF USERNAME MATCH
            if($enteredUsername == $userName){
                //QUERY PASSWORD
                if($pass_stmt = $connection->prepare("SELECT username, password, displayname FROM `users` WHERE password=? AND username=?")){
                
                    $pass_stmt->bind_param("ss", $enteredPassword, $enteredUsername);
                    $pass_stmt->execute();
                    $pass_stmt->bind_result($userName, $password, $displayName);
                    $pass_stmt->fetch();
                    $pass_stmt->close();
                    //echo $id."<br>".$userName."<br>".$password."<br>".$displayName;
                    
                } else {
                    $error = '<div class="alert alert-warning">Query Failed, Please try again.</div>';
                }
                
                if($enteredPassword == $password){
                    //IF PASSWORD MATCH    
                    $_SESSION['displayname'] = $displayName;
                    $_SESSION['username'] = $userName;
                    $_SESSION['id'] = $id;
                    // header("Location: http://www.ericmeffley.com/thought-catcher/main.php");
                    header("Location: main.php");
                } else{
                    $error = '<div class="alert alert-danger">Password Not Correct.</div>';
                }
                
            } else {
                
                $error = '<div class="alert alert-danger">Username Not Found.</div>';
            }
        
            
                
            }//</post['submit']
        }
        
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
      
     <!-- Web Fonts--> 
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Shrikhand" rel="stylesheet"> 
    
    <!-- Local CSS-->
    <link rel="stylesheet" type="text/css" href="css/styles.css?=1.10">
   
  </head>

<body>
      


    <div class="header">
        <p id="header-text">Thought Catcher<span style="font-size:.5em">(Beta)</span></p>
        <p class="sub-header">An app for capturing fleeting thoughts</p>
    </div>
    <div> 
        <p class="page-header">Log In</p>
    </div>
    
    <div class="container" id="error"><?php echo $error; ?></div>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-1 col-md-2 col-lg-3"></div>
            <div class="col-sm-10 col-md-8 col-lg-6">
            <form method="post" action="">
                <div class="form-group">
                    <label for="username"><strong>Email</strong></label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Email">
                </div>
                <div class="form-group">
                    <label><strong>Password</strong></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
                <span class="signup-link"><a href="signup.php" class="signup">Signup</a></span>
                <span class="signup-link"><a href="reset_request.php" class="signup" style="float:right">Forgot Password</a></span>
            </form>
            </div>
            <div class="col-sm-1 col-md-2 col-lg-3"></div>
        </div>
    </div>

    <!--<div class="footer">
        <div class="container footer-content">
            <p>&copy2017 The Meffley Company L.L.C.</p>
        </div>  
    </div>-->
    
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
      
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      
    <script type="text/javascript">
        
        $("form").submit(function(e){
                
            var error = "";

                      
            if($("#password").val() == ""){

            error+= "Password is a required field. </br>";

            }
            
            if($("#username").val() == ""){

            error+= "Username is a required field.";

            }
                      
            if(error != ""){

                $("#error").html('<div class="alert alert-danger" role="alert">' + error + '</div>');

                return false;

            } else {

                return true;

            }
      
        })
      
      
    </script>  
  </body>
</html>