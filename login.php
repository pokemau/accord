<?php
  include 'connect.php';
  require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body>

    <div id="loginForm">
      <form method="post">
        <h2>Welcome Back!</h2>
        <!--LOGIN-->
        <label for="txtemailaddorusername" class="labelTest">Email address or username</label>
        <input
          id="txtemailaddorusername"
          name="txtemailaddorusername"
          class="txtInput"
          type="text"
          placeholder="abcd@email.com or accord.mod.12"
          required />
        <label for="txtpassword">Password</label>
        <input
          id="txtpassword"
          name="txtpassword"
          class="txtInput"
          type="text"
          placeholder="********"
          required />
        <input type="submit" id="btnLogin" name="btnLogin" value="Login"  >
        <p>Need an account? <a href="register.php">Register</a></p>
      </form>
    </div>
  </body>


  <?php
    if(isset($_POST['btnLogin'])){
      $emailorusername = $_POST['txtemailaddorusername'];
      $password = $_POST['txtpassword'];

      $sqlemailadd = "Select * from tbluseraccount where emailadd='".$emailorusername."'";
      $sqlusername ="Select * from tbluseraccount where username='".$emailorusername."'";

      $result1 = mysqli_query($connection,$sqlemailadd);
      $result2 = mysqli_query($connection,$sqlusername);
      
      $count1 = mysqli_num_rows($result1);
      $count2 = mysqli_num_rows($result2);

      $row;
      if($count1 > 0){
        $row = mysqli_fetch_array($result1);
      }else{
        $row = mysqli_fetch_array($result2);
      }
      
      if($count1+$count2 == 0){
        echo "<script language='javascript'>
              alert('emailaddress or username not existing.');
            </script>";
      }else if($row[3] != $password) {
        echo "<script language='javascript'>
              alert('Incorrect password');
            </script>";
      }else{
        $_SESSION['username']=$row[0];
        header("location: index.php");
      }

    }

  ?>
  <footer>
    <p>Jorash Jonathan Robillos</p>
    <p>BSCS-2</p>
  </footer>
</html>
