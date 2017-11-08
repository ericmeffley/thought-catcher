<?php
    include("db.php");

    $error = "";
    $result = "";

    if(isset($_POST['submit'])){
        
        //STORE POST VARIABLES
        $username = $_POST["userName"];
        $password = $_POST["password"];
        $displayName = $_POST["displayName"];

        //ENCRYPT PASSWORD
        $hash = "";
        $salt = "";
        $hash_and_salt = $hash.$salt;
        $password = crypt($password,$hash_and_salt);

        $sign_up_query = $connection->prepare("INSERT INTO users (username,password,displayname) VALUES (?,?,?)");
        $sign_up_query->bind_param("sss", $username, $password, $displayName);
        $result = $sign_up_query->execute();
        
        if($result){
            $error="<div class='alert alert-success' role='alert'><p>Signup successfull, welcome to the family</p></div>";

            header( "Refresh:2; url=index.php", true, 303);
            //header( "Refresh:3; url=http://www.ericmeffley.com/thought-catcher/index.php", true, 303);
        } else {
            die("Sign up unsuccessful please try again later");
        }
    }
    


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Shrikhand" rel="stylesheet"> 

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/styles.css?=1.2">

  </head>
  <body>
    <div class="header">
        <p id="header-text">Thought Catcher<span style="font-size:.5em">(Beta)</span></p>
        <p class="sub-header">An app for capturing fleeting thoughts</p>
    </div>
    <div> 
        <p class="page-header">Sign Up</p>
    </div>

    <div class="container" id="error"><?php echo $error; ?></div>
<div class="container">
    <div class="row">
        <div class="col-sm-1 col-md-2 col-lg-3"></div>
        <div class="col-sm-10 col-md-8 col-lg-6">
            <form method="post">
                <div class="form-group">
                    <label for="displayName">Display Name</label>
                    <input type="text" class="form-control" id="displayName" name="displayName" aria-describedby="displayName" placeholder="Choose a display name.">
                </div>
                <div class="form-group">
                    <label for="userName">Username</label>
                    <input type="email" class="form-control" id="userName" name="userName" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Signup</button>
                <span class="signup-link"><a href="index.php" class="signup">Login</a></span>
            </form>
        </div>
        <div class="col-sm-1 col-md-2 col-lg-3"></div>
    </div>
</div>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
  </body>
</html>