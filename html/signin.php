<?php
//signin.php
require('header.php');
?>



<center>

  <form id="login" action="signAction.php" method="post">
  <input type="text" name="email" placeholder="Email Address" autocomplete="email"><br>
  <br>
  <br>
  <input type="password" name="password" placeholder="Password" autocomplete="current-password"><br>
  <br>
  <br>
  <input type="submit" value="Sign In" class="buttonSignIn">
  </form>
  <br>
  <br>
  <a class="buttonSignIn" href="'.$webRoot.'/register.php">Register</a>

<center>

<?php
require('footer.php');
?>

