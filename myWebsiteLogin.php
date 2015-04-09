<?php
session_set_cookie_params("session.cookie_domain", "csis.svsu.edu/");
session_start();

//STEP 1: Set logged in to true
$_SESSION["loggedIn"] = "True";

//STEP 2:Set up page styles and functions
echo '<html>
<head>
<title>My Webpage Login</title>
<style>
   #wrap {
      width: 750px;
      margin: 0 auto;
      background-color:#f2f2f2; 
     }
   h1{
      background-color:#C0C0C0;
     }
</style>
<script>

// Function for validating login fields
function validateForm() {

    var usernameEmpty = document.forms["myLogin"]["username"].value;
    var passwordEmpty = document.forms["myLogin"]["password"].value;

    var usernameLogin = "test";
    var passwordLogin = "password";


    // check if username is empty
    if (usernameEmpty==null || usernameEmpty=="") {
        alert("Username must be filled out");
        return false;
    }

    // check if password is empty
    if (passwordEmpty==null || passwordEmpty=="") {
        alert("Password must be filled out");
        return false;
    }
    
    // check that username and password are correct
    if (usernameEmpty!= usernameLogin || passwordEmpty!=passwordLogin) {
      alert("Incorrect username or password!");
      return false;
    }


}

</script>

</head>
<body style="background-color: #555">

<center>
<div id="wrap">

<h1 style="color:#069"> Please Enter Login Information </h1>

<!-- Display textboxes for inputing username and password -->
<form name= "myLogin" action="myWebsite.php" onsubmit="return validateForm()" method="POST">
  <table>
    <tr>
      <td>Username(test):</td>
      <td><input type="text" name="username" size="30" /></td>
    </tr>
    <tr>
      <td>Password(password):</td>
      <td><input type="password" name="password" size="30" /></td>
    </tr>
    <tr>
      <td><input type="submit" value="Submit" /></td>
    </tr>
  </table>
</form>
</div>
</center>
</body>
</html>';
?>
