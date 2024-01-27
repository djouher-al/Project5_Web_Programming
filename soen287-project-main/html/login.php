<?php
session_start();
if(array_key_exists("teacher",$_SESSION)){
  if($_SESSION["teacher"] == 0){
     header("Location:./student_main.php");
   }
   elseif ($_SESSION["teacher"] == 1){
     header("Location:./newTeacher.php");
   }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/style-loginSU.css" />
    <title>Login/Sign Up Form</title>
    <!-- <script src="./loginSU.js"></script> -->
  </head>
  <body>
  <div class="container">
  <h1 class="form__title">Login</h1>
  <?php

try{
    $db = new PDO('sqlite:../db/doodle.db');
    // $_SESSION['errorDisplayed'] = false;
    // $var = false;
    if(isset($_POST["submit"])){
        $user_email = $_POST["email"];
        $password = $_POST["password"];
        $stmt = $db ->query("SELECT * FROM User WHERE email='$user_email'");
        // $query = "SELECT user_id FROM User WHERE email='$user_id' AND password=\"'$password'\"";
    //     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $stmt = $db->prepare($query);
    // // EXECUTING THE QUERY
    //     $stmt->execute();
        $row = $stmt->fetch();
        if(empty($row['user_id'])){
          echo "<div class=form__input-error-message>There is no account associated with the provided email.</div>";
        }
        else if(isset($row['user_id'])){
          $user_id = $row['user_id'];
          $isTeacher = $row['teacher'];
          $name = $row['fullname'];

          if($row['password'] == $password){
            $_SESSION["id"]=$user_id;
            $_SESSION["name"] = $name;
                    // Direct students/teachers to their respective pages
                    echo "success";
                    if($isTeacher == 0){
                     $_SESSION["teacher"] = 0;
                      header("Location:./student_main.php");
                    }
                    elseif ($isTeacher == 1){
                      $_SESSION["teacher"] = 1;
                      header("Location:./newTeacher.php");
                    }
          }
          else{
            echo "<div class=form__input-error-message>Incorrect email/password combination.</div>";
          }
          // else if(!isset($_SESSION['errorDisplayed'])){
              
    
              // $_SESSION['errorDisplayed'] = true;
        // }
        }

    //     $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // // FETCHING DATA FROM DATABASE
    //     $result = $stmt->fetchAll();
    //     $db -> exec("SELECT * from User where user_id=$user_id ");
    //     $teacherQuery = ("SELECT teacher from User where user_id=$user_id");
    //     $stmt = $db->prepare($teacherQuery);
    //     $stmt->execute();
    //     $isTeacher = $stmt->fetchAll();
        
    //     if(count($result) == 1 && !empty($isTeacher)){
          
    //       $_SESSION["id"]=$user_id;
    //       $isTeacher = $isTeacher[0]["teacher"];
          
          // Direct students/teachers to their respective pages
          // echo "success";
          // if($isTeacher == 0)
          //   header("Location:./student_main.php");
          // elseif ($isTeacher == 1)
          //   header("Location:./newTeacher.php");
          
    //     }
    //     else if(empty($isTeacher)){
    //       echo "<div class=form__input-error-message>There is no account associated with the provided ID.</div>";
    //     }
    //     else if(count($result)==0){
    //         echo "<div class=form__input-error-message>Incorrect password/username combination</div>";
    //     }
  }

}
catch(PDOException $e){
   print 'Login failed - PDOException: ' .$e->getMessage();
}

?>
  
      <form  action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="form" id="login" method="post">
        
        <div class="form__message form__message--error"></div>
        <div class="form__input-group">
          <input
            type="text"
            class="form__input"
            autofocus
            placeholder="Enter Email"
            name="email"
          />
          <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
          <input
            type="password"
            class="form__input"
            autofocus
            placeholder="Password"
            name ="password"
          />
          <!-- <div class="form__input-error-message"></div> -->
        </div>
        <button class="form__button" type="submit" name="submit">Let's Go!</button>
        <p class="form__text">
          <a href="./db_forgotpass.php" class="form__link">Forgot your password?</a>
        </p>
        <p class="form__text">
          <a class="form__link" href="./create-account.php">Don't have an account? Create one!</a>
        </p>
      </form>
    

  </div>
  </body>
</html>