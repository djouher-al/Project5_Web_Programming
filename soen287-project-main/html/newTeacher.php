<?php 
    session_start();
    if(!array_key_exists("id",$_SESSION)){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Teacher Account</title>
    <link rel="stylesheet" href="../css/newTeacher.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/./css/teacher_template.css">
    <style>
        .select-course{
            margin-left: 35%;
            width: 400px;
            max-width: 400px;
            
            padding: 2rem;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            background: #ffffff;
            align-items: center;
        }
        .content{
            margin-left: 28%;
        }
        
    </style>
    <style>
        .btn-group-vertical {margin: 0 auto;}
    </style>
  </head>

<header>
    <!-- Navbar -->
    <nav class="navbar navbar-light navbar-expand fixed-top  " style=  "background-color: #a68ec5;">
        <!-- Navbar content -->
        <div class="container-fluid"  style="background-color: #a68ec5;">
            <div class="row gx-1 flex-nowrap container-fluid">
                <a class="navbar-brand col-2 " href="index.php">DOODLE</a>
                <ul class="navbar-nav col">
                <li class="nav-item text-nowrap" style ="margin-left:85%;">
                        <a class="nav-link" href="course-teacher.php">Home</a>
                    </li>
                    <!-- Drop down menu for Courses -->
                    <li class="nav-item dropdown" >
                        <a class="nav-link btn btn-primary dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" href="#" style=  "background-color: #a68ec5; border-color: #a68ec5">
                            Courses</a>
                        <ul class="dropdown-menu">
                        <?php
                        try{
                            try{ 
                                $db = new PDO('sqlite:../db/doodle.db');
                                                           $user_id = $_SESSION["id"];
                                                           $stmt = $db ->query("SELECT Course.course_name, Course.course_id, CourseSection.teacher_id
                                                           FROM CourseSection 
                                                           INNER JOIN Course ON CourseSection.course_id=Course.course_id WHERE CourseSection.teacher_id = '$user_id';");
                                                           $rows = $stmt->fetchAll();

                                                           foreach($rows as $course){
                                                               $course_name = $course['course_name'];
                                                                echo "<li class=\"nav-item\"><a class=\"nav-link border-bottom\" href=\"#\">".$course_name."</a></li>";
                                                                
                                                           }
                                                           
                                                       }
                                                       catch(PDOException $e){
                                                           print 'PDOException: ' .$e->getMessage();
                                                       }
                        }
                        catch(PDOException $e){
                            print 'PDOException: ' .$e->getMessage();
                        }
                    ?>
                        </ul>
                    </li>
                    <!-- Log Out -->
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="./logout.php" >Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</br>
</br>
</br>
    <?php 
            print("Welcome back ". $_SESSION["name"]);
        ?>
</br>


</div>
</header>


<body>
  <!-- Menu for classes -->
      <div class=select-course style="margin-left:40%">
        <h1>Courses to review</h1>
        <br>
        <br>
        <br>
      <div class=content>
    <?php
    try{
        $db = new PDO('sqlite:../db/doodle.db');
            $user_id = $_SESSION["id"];
            $query = "SELECT Course.course_name, Course.course_id FROM Course, CourseSection WHERE teacher_id=$user_id AND Course.course_id = CourseSection.course_id";
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare($query);
        // EXECUTING THE QUERY
            $stmt->execute();
            $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // FETCHING DATA FROM DATABASE
            $courses = $stmt->fetchAll();
            foreach($courses as $c){
                $c_name = $c["course_name"];
                $c_id = $c["course_id"];
                print("<a href=\"course-teacher.php?cid=" . $c_id . "\"  type=\"button\" style=  \" border-color: #a68ec5;background-color: #a68ec5; \" class=\"btn btn-primary btn-lg btn-block\">" . $c_name . "</a>");
            }
            
    }
    catch(PDOException $e){
        print 'PDOException: ' .$e->getMessage();
    }
?>
</div>
</div>
</body>

        <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>


       <!-- footer -->
    <footer >
        <div class="footer"  style =" border-color: #a68ec5;background-color: #a68ec5;">
            <hr id = "line">
            © Doodle 2022
</br>
            All rights reserved (or something)
</br></br>
            Contact Us|
            <a href="mailto:help@doodle.ca" style="color:white">help@doodle.ca</a>
            <span> | </span>
            <a href="tel:514-555-2662" style="color:white">514-555-2662</a>
            <span> | </span>
            <a href="https://goo.gl/maps/dDtVWip4HNnGKuZA8" style="color:white">1550 Boul. de Maisonneuve Ouest, Montreal, Quebec H3G 2E9</a>
    </footer>

</div>
</html>