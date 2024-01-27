<?php
    session_start();
    if(!array_key_exists("id",$_SESSION)){
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
      
        <link rel="stylesheet" href="./css/newTeacher.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Bootstrap CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="/teacher_template.css">
        <title>  Grades</title>
      </head>


      <header>
        <!-- Navbar -->
        <nav class="navbar navbar-dark navbar-expand fixed-top" style=  "background-color: #a68ec5;">
        <!-- Navbar content -->
        <div class="container-fluid">
            <div class="row gx-1 flex-nowrap container-fluid">
                <a class="navbar-brand col-2 " href="index.php">DOODLE</a>
                <ul class="navbar-nav col">
                <li class="nav-item text-nowrap" style ="margin-left:85%;">
                        <a class="nav-link" href="course-student.php">Home</a>
                    </li>
                    <!-- Drop down menu for Courses -->
                    <li class="nav-item dropdown">
                        <a class="nav-link btn  dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" href="#" style=  "background-color: #a68ec5; ">
                            Courses</a>
                        <ul class="dropdown-menu">
                        <?php
                        try{
                            $db = new PDO('sqlite:../db/doodle.db');
                                $user_id = $_SESSION["id"];
                                $query = "SELECT EnrolledIn.course_id, Course.course_name FROM EnrolledIn, Course WHERE student_id=$user_id AND Course.course_id = EnrolledIn.course_id";
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
                                    print("<li><a href=\"course-student.php?cid=" . $c_id . "\"  class=\"dropdown-item\">" . $c_name . "</a></li>");
                                
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
                        <a class="nav-link" href="logout.php">Log Out</a>
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


<body>       
 <!-- Table for grades -->

 <div class = "row-cols-md-2"> 
    <div class="container-fluid">
    <div id="sentenceIndex">
    </br>               
    <hr>
                <h3 style="text-align:center;">View Your Grades for <?php echo $_SESSION["course_name"];?> !</h3>
                <hr>
            </div>    
    <table class="table table-bordered table-hover">
        
        <thead>
            <th scope="col" >#</th>
            <th scope="col" class="text-center" >Calculated Weight</th>
            <th scope="col" class="text-center">Grade</th>
        </thead>
        <?php
            try {
                $db = new PDO('sqlite:../db/doodle.db');
                //$course_id = null;
                if (array_key_exists("cid",$_GET)) {
                    $course_id = $_GET["cid"];
                    $_SESSION["course_id"] = $course_id;
                } else {
                    // Use course id from session
                    $course_id = $_SESSION["course_id"];
                }

                $user_id = $_SESSION["id"];
                $query = "SELECT * FROM Assessment, AssessmentGrade WHERE AssessmentGrade.student_id=$user_id AND AssessmentGrade.course_id = $course_id AND Assessment.assessment_id=AssessmentGrade.assessment_id";
               
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
                $stmt = $db->prepare($query);
                // EXECUTING THE QUERY
                $stmt->execute();
            
                $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                // FETCHING DATA FROM DATABASE
                $assessments = $stmt->fetchAll();
                //$course_name = $courses[0]["course_name"];
                //echo "<li class=\"nav-item\"><a class=\"nav-link border-bottom\" href=\"#\"> Course: ".$course_name."</a></li>";
          
                foreach ($assessments as $assessment) {  
                    echo "<tbody>";
                    echo "<tr>";
                    $assessment_name = $assessment["assessment_name"];
                        echo" <th scope=\"row\">". $assessment_name."</th>";
                        
                    $weight = $assessment["value"];
                        echo "<td class=\"text-center\" >".$weight."</td>";
                    $mark = $assessment["grade"];
                   
                        echo"<td class=\"text-center\" >".$mark."</td>";
                    echo "</tr>";
                }
                //$section_id=$_SESSION["section_id"] ;
                    //echo("<button type=\"button\" class=\"list-group-item text-center list-group-item-action\" >".$section_name."</button>");
                
            
                            // Get section name
                            // $query = "SELECT Course.course_name FROM Course WHERE course_id=$course_id";
                            // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            // $stmt = $db->prepare($query);
                            // // EXECUTING THE QUERY
                            // $stmt->execute();
                            // $section_name = $stmt->fetch()[0];
                        echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                } catch (PDOException $e) {
                print 'PDOException: ' . $e->getMessage();
            }
                ?>
       


      </table>
    </div>
    </div>
    </div>
</body>
<!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>
    </br>   
    <!-- footer -->
    <footer class="footer  mt-0 bg-light">
        <div class="container-fluid m-0 pt-4  px-4 px-md-3">
            <div class="row container-fluid m-0">
                <div class="col">
                    <a href="#" class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none"><img
                            src="DoodleNob.PNG" width="16px" height="16px" alt="logo"><span>DOODLE</span></a>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb2">Designed and built with all the love in the world by the DOODLE team</li>
                    </ul>
                </div>
                <div class="col mb3 small text-muted">
                    <h5>Media</h5>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><a href="#" class="link-secondary">Online</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Print</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Alternative Ads</a></li>
                    </ul>
                </div>
                <div class="col mb3 small text-muted">
                    <h5>Technology</h5>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><a href="#" class="link-secondary">Hardware Design</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Software Design</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Digital Signage</a></li>
                    </ul>
                </div>
                <div class="col mb3 small text-muted">
                    <h5>Legal</h5>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><a href="#" class="link-secondary">Privacy</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Terms of Use</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Sitemap</a></li>
                    </ul>
                </div>
                </div>
            </div>
    </footer>  
</html>