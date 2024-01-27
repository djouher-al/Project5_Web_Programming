<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./teacher_template.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./teacher_template.css">
    <title>Student Account</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand fixed-top" style=  "background-color: #a68ec5;">
        <!-- Navbar content -->
        <div class="container-fluid">
            <div class="row gx-1 flex-nowrap container-fluid">
                <a class="navbar-brand col-2 " href="index.php">DOODLE</a>
                <ul class="navbar-nav col">
                <li class="nav-item text-nowrap" style ="margin-left:85%;">
                        <a class="nav-link" href="student_main.php">Home</a>
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


    <!-- Sidebar + Main -->
    <div class = "d-flex justify-content-center"> 
        <div clas="row">
            <div class="container-fluid">
            <div id="sentenceIndex">
                <hr>
                <h3 style="text-align:center;"><?php echo $_SESSION["course_name"];?></h3>
                <hr>
            </div>    
                <div class="list-group">
                    <ul class="nav flex-column sidebar-nav text-center">
                        
                        <?php
                        try {
                            $db = new PDO('sqlite:../db/doodle.db');
                            $course_id = null;
                            if (array_key_exists("cid",$_GET)) {
                                $course_id = $_GET["cid"];
                                $_SESSION["course_id"] = $course_id;
                            } else {
                                // Use course id from session
                                $course_id = $_SESSION["course_id"];
                            }

                            $user_id = $_SESSION["id"];
                            $query = "SELECT * FROM EnrolledIn, Course, CourseSection WHERE student_id=$user_id AND EnrolledIn.course_id = CourseSection.course_id AND Course.course_id = $course_id";
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $db->prepare($query);
                            // EXECUTING THE QUERY
                            $stmt->execute();
                            $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            // FETCHING DATA FROM DATABASE
                            $courses = $stmt->fetchAll();
                            $course_name = $courses[0]["course_name"];
                            // Get section name
                            $query = "SELECT CourseSection.section_name FROM CourseSection, EnrolledIn WHERE student_id=$user_id AND EnrolledIn.course_id = $course_id";
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $db->prepare($query);
                            // EXECUTING THE QUERY
                            $stmt->execute();
                            $section_name = $stmt->fetch()[0];

                    echo "</ul>";
                echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            // <!-- Main -->
            echo "<main class=\"col \">";
               

                    $_SESSION["course_name"] =$course_name; 
                    $stmt = $db->prepare($query);
                    // EXECUTING THE QUERY
                    $stmt->execute();
                    $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    // FETCHING DATA FROM DATABASE
                    $course = $stmt->fetchAll()[0];
                } catch (PDOException $e) {

                    print 'PDOException: ' . $e->getMessage();
                }
              
                ?>
                <!-- Action Cards -->
                <div class="container-fluid">
                    <!-- First Row -->
                    <div class="row mb-4">
                        <!-- First Column -->
                        <div class="col-sm-6 mb-4">
                            <div class="card d-block">
                                <div class="card-body">
                                    <h5 class="card-title">Assessments</h5>
                                    <p class="card-text">
                                    <ul>
                                        <li>Assignments</li>
                                        <li>Exams</li>
                                        <li>Midterms</li>
                                    </ul>
                                    </p>
                                    <a class="btn" href="studentAssessments.php" style="background-color: #a68ec5;">View Assesments</a>
                                </div>
                            </div>
                        </div>
                        <!-- Second Cloumn -->
                        <div class="col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Marks</h5>
                                    <p class="card-text">
                                    <ul
                                        <li>Grade breakdown per assignment</li>
                                        <li>Total marks</li>
                                    </ul>
                                    </p>
                                    <a class="btn btn-" href="newFinalGrades.php" style="background-color: #a68ec5;">View Grades</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="row mb-4">
                        <!-- First Column -->

                        <!-- Second Cloumn -->
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Stats</h5>
                                    <p class="card-text">
                                    <ul>
                                        <li>Averages</li>
                                        <li>Median</li>
                                        <li>Standard Deviation</li>
                                    </ul>
                                    </p>
                                    <a class="btn " href="newStudentStats.php" style="background-color: #a68ec5;">Stats, stat!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    </body>



    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>
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