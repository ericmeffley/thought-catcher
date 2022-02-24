<?php ob_start(); ?>
<?php
    include 'db.php';

    if(isset($_POST['forgotPassword'])){

        //echo"Inside the post if statement";
        $enteredUsername = mysqli_real_escape_string($connection, $_POST['email']);
        $query = "SELECT username FROM users WHERE username = '$enteredUsername' ";
        $result = mysqli_query($connection, $query);
        $userExists = mysqli_fetch_array($result);
        $user = $userExists['username'];
        
        if($user){
            
            echo $user;
            $password = "1234asdf";
            $pwrurl = "localhost/thought-catcher/reset_password.php?q=".$password;
            
            $mailbody = "To reset your password click the link below.".$pwrurl."Thank you!";
            
            mail($user, "Localhost - password reset", $mailbody);
            echo "Your password recovery key has been sent to your emil address.";
            
        } else{
            
            echo "user not found";
        }
        
    }
?>
