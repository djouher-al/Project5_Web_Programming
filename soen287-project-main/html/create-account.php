<?php
session_start()
?>
<!DOCTYPE html>
<html>
  <head>
  <style>
    #accountCreated{
      display:none;
    }
    #createAccount{
      display:block;
    }
    </style>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/style-loginSU.css" />
    <title>Sign Up Form</title>
    <!-- <script src="./loginSU.js"></script> -->
  </head>
  <body>
  <script type="text/javascript">
    function pageRedirect() {
      window.location.href = "./login.php";
    } 
    </script>
  <?php
try{  
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
  $email = $name = $pass = $passConfirm = $type =$isTeacher = $error =  "";
  $db = new PDO('sqlite:../db/doodle.db');

  if(isset($_POST["submit"])){
    // echo '<script type="text/javascript">created();</script>';
   
    if (empty($_POST["fullname"])) {
      $error = "Fullname is required";
    } else {
      $name = test_input($_POST["fullname"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $error = "Only letters and white space allowed for the name";
      }
    }
    
    if (empty($_POST["email"])) {
      $error = "Email is required";
    } else {
      $email = test_input($_POST["email"]);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
      }
    }
      
    if (empty($_POST["password"])) {
      $error = "Password is required";
    } else {
      $pass = test_input($_POST["password"]);
    }
  
    if (empty($_POST["password2"])) {
      $error = "Password is required";
    } else {
      $passConfirm = test_input($_POST["password2"]);
      if($pass != $passConfirm){
        $error = "The passwords do not match";
      }
    }

    if (empty($_POST["type"])) {
      $error = "Gender is required";
    } else {
      $type = test_input($_POST["type"]);
    }

    if($type === "student"){
      $isTeacher=0;
    }else if($type === "teacher"){
      $isTeacher=1;
    }

      $stmt = $db ->query("SELECT * FROM User WHERE email='$email'");
      $row = $stmt->fetch();

      if(isset($row['user_id'])){
        $error = "This email is already registered";
      }
      else{    
        echo '<style type="text/css">
    #createAccount {
        display: none;
    } #accountCreated {
      display: block;
  }
    </style>';
              $db -> exec("INSERT INTO User(email,password,teacher,fullname) VALUES ('$email','$pass','$isTeacher', '$name')");
      }
  }
}
catch(PDOException $e){
  print 'Account creation failed - PDOException: ' .$e->getMessage();
}
?>
   
     <div class="container">
<form  action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="form" id="createAcc" method="post">
        <div id="createAccount">
        <h1 class="form__title">Create Account</h1>
        <div class="form__message form__message--error"><?php echo $error;?></div>
        <div class="form__input-group">
          <input
            type="email"
            class="form__input"
            autofocus
            placeholder="Enter Email"
            name="email"  
            value="<?php echo $email;?>"
          />
          </div>
        <div class="form__input-group">
          <input
            type="text"
            class="form__input"
            autofocus
            placeholder="Enter Fullname"
            name ="fullname" 
            value="<?php echo $name;?>"
          />
        </div>
        <div class="form__input-group">
          <input
            type="password"
            class="form__input"
            autofocus
            placeholder="Enter Password"
            name ="password"
          />
        </div>
        <div class="form__input-group">
          <input
            type="password"
            id="password2"
            class="form__input"
            autofocus
            placeholder="Confirm Password"
            name ="password2"
          />
        </div>
          <div id="radio-buttons" style ="text-align:center; margin-right:5px">
        
          <input type="radio" style="margin-right:5px;" name="type" <?php if (isset($type) && $type=="student") echo "checked";?> value="student">Student
          
          <input type="radio" style="margin-left:60px; margin-right:5px"name="type"<?php if (isset($type) && $type=="teacher") echo "checked";?>  value="teacher">Teacher
          </div>
        </br>
        <button class="form__button" type="submit" name="submit">Create</button>
        <p class="form__text">
          <a href="./login.php" class="form__link">Already have an account? Sign in!</a>
        </p>
        </div>
        <div id="accountCreated">
         
         <h2 class="form__title" >Registration Complete!</h2>
           <div style="text-align:center">Your Doodle account has been created using: </div>
           <div style="text-align:center"><h3><?php echo $email?></h3></div>
           <button class="form__button" type="button" name="submit" onclick="pageRedirect()">Log in to Doodle</button>
        </div>
      </form>
 
   

  </div>
  </body>
</html>