<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
      

    <link rel="stylesheet" href="./newStudent.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/./css/teacher_template.css">

    <title> Student Page</title>
  </head>

    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-dark navbar-expand fixed-top "style=  "background-color: #a68ec5;">
            <!-- Navbar content -->
            <div class="container-fluid">
                <div class="row gx-1 flex-nowrap container-fluid">
                    <a class="navbar-brand col-2 " href="index.php">DOODLE</a>
                    <ul class="navbar-nav col">


                                <!-- options in the nav bar -->
                        <li class="nav-item text-nowrap">
                            <a class="nav-link" href="./index.php" >  Log out</a>
                    
                        <li class="nav-item text-nowrap">
                            <a class="nav-link" href=" ./student-stats.html">|  Course Statistic |</a>
                        </li>
                        <li class="nav-item text-nowrap">
                            <a class="nav-link" href="./newFinalGrades.php">    Grades  </a>
                        </li>
    
                    </ul>   
                </div>
             </div>
        </nav>
        <?php 
            print("Logged into ID: ". $_SESSION["id"]);
        ?>
    <br>
    </div>
    </header>

 <!-- Menu for semesters -->

<div class = "d-flex justify-content-center"> 
    <div clas="row">
    <div class="container-fluid">

  
    <div class="list-group">
    <button type="button" class="list-group-item text-center list-group-item-action active" aria-current="true">
      Fall 2023
    </button>
    <br>
    <button type="button" class="list-group-item text-center list-group-item-action ">Winter 2023</button>
    <button type="button" class="list-group-item text-center list-group-item-action">Summer 2022</button>
    <button type="button" class="list-group-item text-center list-group-item-action">Winter 2022</button>
    <button type="button" class="list-group-item  text-center list-group-item-action">Fall 2021 </button>
    <br> 
    <br> 
    <button type="button" class="list-group-item text-center list-group-item-action" >View More..</button>
    </div>
</div>
</div>

</div>

        <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>

    </body>

       <!-- footer -->
    <footer >
        <div class="footer" style=  "background-color: #a68ec5;">
            <hr id = "line">
            © Doodle 2022
            <br>
            All rights reserved (or something)
            <br><br>
            Contact Us|
            <a href="mailto:help@doodle.ca" style="color:white">help@doodle.ca</a>
            <span> | </span>
            <a href="tel:514-555-2662" style="color:white">514-555-2662</a>
            <span> | </span>
            <a href="https://goo.gl/maps/dDtVWip4HNnGKuZA8" style="color:white">1550 Boul. de Maisonneuve Ouest, Montreal, Quebec H3G 2E9</a>
    </footer>

</div>
</html>
 
