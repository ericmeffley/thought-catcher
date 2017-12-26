function passwordMatch(){
    var p1 = document.getElementById("password").value;
    var p2 = document.getElementById("confirmPassword").value;

    if (p1 != p2) {
        alert("Password: " + p1 + " Confirmation: " + p2 + " :: Passwords don't match. Please try again.");
        return false;
    }
}
  