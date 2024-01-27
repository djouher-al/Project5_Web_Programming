
<!DOCTYPE html>
<html>
 <head>
  <style>
    #forgotPassDiv{
      display:block;
    }
    #passwordChanged{
      display: none;
    }
    </style>
   <meta charset = "utf-8">
   <link rel = "stylesheet" href = "../css/style-loginSU.css">
   <title>Forgot Pass Form</title>
</head> 
<body>
<script type="text/javascript">
    function errorMessage(message){
      document.getElementById("errorMessage").innerHTML = message;
     }
     let timeout;
     function changedPass(){
      document.getElementById("forgotPassDiv").style.display='none';
      document.getElementById("passwordChanged").style.display='block';
      timeout = setTimeout(pageRedirect, 4000);
     }
     function pageRedirect() {
      window.location.href = "./login.php";
    } 
  
</script>


<div class="container">
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class = "form" id = "forgotPass" method="post" >
   <div id ="forgotPassDiv">
        <h1 class="form__title" >Forgot Password</h1>
        <div class="form__input-error-message"></div>
        <div id="errorMessage" class="form__message form__message--error"></div>
        <div class="form__input-group">
          <input
            type="email"
            id = "email"
            class="form__input"
            autofocus
            placeholder="Email Address"
            name="email"
          />
        </div>
        <div class="form__input-group">
          <input
            type="password"
            id="passwordCheck"
            class="form__input"
            autofocus
            placeholder="Password"
            name="passwordCheck"
          />
          <div class="form__input-error-message"></div>
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
          <div class="form__input-error-message"></div>
        </div>
        <button class="form__button" type="submit" name="submit">Submit</button>
        <p class="form__text">
          <br />
          <a class="form__link" href="./login.php" id="linkLogin">Already have an account? Sign in!</a>
        </p>
        </div>
        <div id="passwordChanged">
           <h2 class="form__title" >Password Change Complete!</h2>
           <div>Your password has been updated. You will be redirected back to the login page in 5 seconds.</div>
        </div>
      </form>
</div>
      <?php
try{
   $db = new PDO('sqlite:../db/doodle.db');
  
    if(isset($_POST['submit'])){
      $user_email = $_POST["email"];
      $pass = $_POST["passwordCheck"];
      $confirmPass = $_POST["password2"];
      $stmt = $db ->query("SELECT * FROM User WHERE email='$user_email'");
      $row = $stmt->fetch();
      if(empty($row['user_id'])){
        echo '<script type="text/javascript">',
        'errorMessage("There is no account associated with the provided email.");',
        '</script>';
      }else if(isset($row['user_id'])){
        $id = $row['user_id'];
        if($pass != $confirmPass){
          echo '<script type="text/javascript">',
        'errorMessage("The passwords do not match.");',
        '</script>';
        }else if($row['password'] == $pass){
          echo '<script type="text/javascript">',
        'errorMessage("Please choose a new password.");',
        '</script>';
        }
        else{
        $db -> exec("UPDATE User SET password=\"$pass\" WHERE user_id=$id");
        echo '<script type="text/javascript">',
        'changedPass();',
        '</script>';
        }
      }
     
    }
}catch(PDOException $e){
   print 'Password Reset Failed - PDOException: ' .$e->getMessage();
}

?>

</body>
</html> 
