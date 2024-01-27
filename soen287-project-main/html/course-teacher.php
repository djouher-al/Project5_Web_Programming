<?php
    session_start();
    if(!array_key_exists("id",$_SESSION)){
        header("Location: login.php");
    }
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
    <title>Teacher page</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light navbar-expand fixed-top  " style="background-color: #a68ec5;">
        <!-- Navbar content -->
        <div class="container-fluid" style="background-color: #a68ec5;">
            <div class="row gx-1 flex-nowrap container-fluid">
                <a class="navbar-brand col-2 " href="../index.php">DOODLE</a>
                <ul class="navbar-nav col">
                    <li class="nav-item text-nowrap" style ="margin-left:85%;">
                        <a class="nav-link" href="newTeacher.php">Home</a>
                    </li>
                    <!-- Drop down menu for Courses -->
                    <li class="nav-item dropdown">
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
                            // $db = new PDO('sqlite:../db/doodle.db');
                            //     $user_id = $_SESSION["id"];
                            //     $stmt = $db ->query("SELECT * FROM CourseSection WHERE teacher_id='$user_id'");
                            //     $row = $stmt->fetch();

                            //     foreach($course as $row){
                            //         $id_course = $course['course_id'];
                            //     $stmt2 = $db ->query("SELECT * FROM Course WHERE course_id='$id_course'");
                            //     $row2 = $stmt2->fetch();
                            //     echo $row2['course_name'];
                            //     }
                                

                            //     $query = "SELECT EnrolledIn.course_id, Course.course_name FROM EnrolledIn, Course WHERE student_id=$user_id AND Course.course_id = EnrolledIn.course_id";
                            //     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            //     $stmt = $db->prepare($query);
                            // // EXECUTING THE QUERY
                            //     $stmt->execute();
                            //     $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            // // FETCHING DATA FROM DATABASE
                            //     $courses = $stmt->fetchAll();
                            //     foreach($courses as $c){
                            //         $c_name = $c["course_name"];
                            //         $c_id = $c["course_id"];
                            //         print("<li><a href=\"course-student.php?cid=" . $c_id . "\"  class=\"dropdown-item\">" . $c_name . "</a></li>");
                                
                            //     }
                                
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
    <div class="container-fluid px-2 align-content-stretch" id="sidebarMainWrapper">
        <div class="row" style="height:inherit;">
            <!-- Left Sidebar -->
            <div class="col-2 bg-light sidebar">
                <div class="left-sidebar">
                    <ul class="nav flex-column sidebar-nav text-center">
                        <li class="nav-item"><a class="nav-link border-bottom" href="#">SECTIONS:</a></li>
                        <?php
                        try {
                            $db = new PDO('sqlite:../db/doodle.db');

                            if (array_key_exists("cid",$_GET)) {
                                $course_id = $_GET["cid"];
                                $_SESSION["course_id"] = $course_id;
                            } else {
                                // Use course id from session
                                $course_id = $_SESSION["course_id"];
                            }

                            $user_id = $_SESSION["id"];
                            $query = "SELECT * FROM Course, CourseSection WHERE teacher_id=$user_id AND Course.course_id = CourseSection.course_id AND Course.course_id = $course_id";
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $db->prepare($query);
                            // EXECUTING THE QUERY
                            $stmt->execute();
                            $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            // FETCHING DATA FROM DATABASE
                            $courses = $stmt->fetchAll();
                            $course_name = $courses[0]["course_name"];
                        } catch (PDOException $e) {
                            print 'PDOException: ' . $e->getMessage();
                        }
                        foreach ($courses as $course) {
                            $section_name = $course["section_name"];
                            $section_id = $course["section_id"];
                            $_SESSION["section_id"] = $section_id;
                            print("<li class=\"nav-item\"><a class=\"nav-link\" href=\"#\">" . $section_name . "</a></li>");
                        }

                        // Get section name
                        $query = "SELECT section_name FROM CourseSection WHERE teacher_id=$user_id AND section_id = $section_id AND course_id = $course_id";
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $db->prepare($query);
                        // EXECUTING THE QUERY
                        $stmt->execute();
                        $section_name = $stmt->fetch()[0];

                        ?>
                    </ul>
                </div>
            </div>

            <!-- Main -->
            <main class="col ">
            <div class="d-flex justify-content-center">
                <div clas="row">
                    <div class="container-fluid">
                        <div id="sentenceIndex">
                            <hr>
                            <?php
                            try {
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                $r = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                $course = $stmt->fetchAll()[0];
                                print("<h3 style=\"text-align:center;\">" . $course_name . " Section " . $section_name . "</h3>");
                            } 
                            catch (PDOException $e) {
                                print 'PDOException: ' . $e->getMessage();
                            }
                            ?>
                            <hr>
                        </div>
                        <div class="list-group">
                            <ul class="nav flex-column sidebar-nav text-center">
            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                
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
                                        <p>Create and Manage your:</p>
                                        <li>Exams</li>
                                        <li>Midterms</li>
                                        <li>Assignments</li>
                                        <li>Projects</li>
                                        <li>Set Due Dates</li>
                                    </ul>
                                    </p>
                                    <a class="btn btn-primary" href="create_new_assessment.php" style=  "background-color: #a68ec5; border-color: #a68ec5">Create Assessments</a>
                                </div>

                            </div>
                        </div>
                        <!-- Second Cloumn -->
                        <div class="col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Marks</h5>
                                    <p class="card-text">
                                    <ul>
                                        <p>From here you can:</p>
                                        <li>Add grades</li>
                                        <li>Individual marks</li>
                                        <li>Section-wide marks</li>
                                        <li>Import from .csv file</li>
                                        <li>Import from .xls file</li>
                                    </ul>
                                    </p>
                                    <a class="btn btn-primary" href="finalGradesTeacher.php" style=  "background-color: #a68ec5; border-color: #a68ec5">View Grades</a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="row mb-4">
                        <!-- First Column -->
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Manage Students</h5>
                                    <p class="card-text">
                                    <ul>
                                        <p>Take a look how your students are doing:</p>
                                        <li>Overall Performance</li>
                                        <li>Course specific stats</li>
                                        <li>Section-wide</li>
                                        <li>Individual student's performance</li>
                                        <li>Nerd stuff</li>
                                    </ul>
                                    </p>
                                    <a class="btn btn-primary" href="#" style=  "background-color: #a68ec5; border-color: #a68ec5">Manage</a>
                                </div>
                            </div>
                        </div>
                        <!-- Second Cloumn -->
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Stats</h5>
                                    <p class="card-text">
                                    <ul>
                                        <p>Take a look how your students are doing:</p>
                                        <li>Overall Performance</li>
                                        <li>Course specific stats</li>
                                        <li>Section-wide</li>
                                        <li>Individual student's performance</li>
                                        <li>Nerd stuff</li>
                                    </ul>
                                    </p>
                                    <a class="btn btn-primary" href="newStudentStats.php" style=  "background-color: #a68ec5; border-color: #a68ec5">Stats, stat!</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

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
                <div class="col mb3 text-muted small ">
                    <h5>Placeholder</h5>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                    </ul>
                </div>
                <div class="col mb3 small text-muted">
                    <h5>Placeholder</h5>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                    </ul>
                </div>
                <div class="col mb3 small text-muted">
                    <h5>Placeholder</h5>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Placeholder</a></li>
                    </ul>
                    <!-- </div>
                <ul class="footer__nav">
                    <li class="nav__item">
                        <h2 class="nav__title">Media</h2>

                        <ul class="nav__ul">
                            <li>
                                <a href="#">Online</a>
                            </li>

                            <li>
                                <a href="#">Print</a>
                            </li>

                            <li>
                                <a href="#">Alternative Ads</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav__item nav__item--extra">
                        <h2 class="nav__title">Technology</h2>

                        <ul class="nav__ul nav__ul--extra">
                            <li>
                                <a href="#">Hardware Design</a>
                            </li>

                            <li>
                                <a href="#">Software Design</a>
                            </li>

                            <li>
                                <a href="#">Digital Signage</a>
                            </li>

                            <li>
                                <a href="#">Automation</a>
                            </li>

                            <li>
                                <a href="#">Artificial Intelligence</a>
                            </li>

                            <li>
                                <a href="#">IoT</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav__item">
                        <h2 class="nav__title">Legal</h2>

                        <ul class="nav__ul">
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>

                            <li>
                                <a href="#">Terms of Use</a>
                            </li>

                            <li>
                                <a href="#">Sitemap</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="legal">
                    <p>&copy; 2019 Something. All rights reserved.</p>

                    <div class="legal__links">
                        <span>Made with <span class="heart">♥</span> remotely from Anywhere</span>
                    </div>
                </div> -->
                </div>
            </div>
    </footer>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>