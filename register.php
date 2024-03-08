<?php
  include 'connect.php';
  require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accord Register Page</title>
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/register.css" />
  </head>
  <body>

    <div id="registerForm">
      <form method="post">
        <h1>Create an account</h1>
        <label for="txtemailadd">Email address</label>
        <input
          id="txtemailadd"
          name="txtemailadd"
          class="txtInput"
          type="email"
          placeholder="abcd@email.com"
          required />
        <label for="txtdisplayname">Display name</label>
        <input
          id="txtdisplayname"
          name="txtdisplayname"
          class="txtInput"
          type="text"
          placeholder="AccordMod"
          required />
        <label for="txtusername">Username</label>
        <input
          id="txtusername"
          name="txtusername"
          class="txtInput"
          type="text"
          placeholder="accord.mod12"
          required />
        <label for="txtgender">Gender</label>
        <select name="txtgender" class="txtInput">
            <option value="">------</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <label for="txtpassword">Password</label>
        <input
          id="txtpassword"
          name="txtpassword"
          class="txtInput"
          type="password"
          placeholder="*******"
          required />
        <label for="txtbirthdate">Date of birth</label>
        <input id="txtbirthdate" name="txtbirthdate" class="txtInput" type="date" required></input>
        <input type="submit" id="btnRegister" name="btnRegister" value="Register"  >
        <br>
        <a href="login.php">Already have an account?</a>
      </form>
    </div>
  </body>



  <?php
    if(isset($_POST['btnRegister'])){
      //userprofile
      $displayname = $_POST['txtdisplayname'];
      $gender = $_POST['txtgender'];
      $birthdate = $_POST['txtbirthdate'];
    
      //useraccount
      $emailadd = $_POST['txtemailadd'];
      $username = $_POST['txtusername'];
      $password = $_POST['txtpassword'];

      //save data
      $sqluserprofile ="Insert into tbluserprofile(displayname, gender, birthdate) values('".$displayname."','".$gender."','".$birthdate."')";

      //Check tbluseraccount if username is already existing. Save info if false. Prompt msg if true.
      $sql2 ="Select * from tbluseraccount where username='".$username."'";
      $result = mysqli_query($connection,$sql2);
      $row = mysqli_num_rows($result);
      if($row == 0){
        $sqluseraccount ="Insert into tbluseraccount(emailadd,username,password,usertype) values('".$emailadd."','".$username."','".$password."', 'user')";
        mysqli_query($connection,$sqluserprofile);
        mysqli_query($connection,$sqluseraccount);
        echo "<script language='javascript'>
              alert('New record saved.');
            </script>";
        //header("location: index.php");
      }else{
        echo "<script language='javascript'>
              alert('Username already existing');
            </script>";
      }
    }




    ?>

  <footer>
    <p>Jorash Jonathan C. Robillos</p>
    <p>BSCS-2</p>
  </footer>
</html>
