<?php
    session_start();
    if(!array_key_exists("id",$_SESSION)){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/./css/teacher_template.css">
    <title>Create Assessment</title>
</head>

<body>
</br>
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

    <!-- Sidebar + Main -->
    <div class="container-fluid px">
        <div class="row" style="height:inherit;">
            <!-- Left Sidebar -->
            <div class="col-2 bg-light sidebar">
                <div class="left-sidebar">
                    <ul class="nav flex-column sidebar-nav text-center">
                        <li class="nav-item"><a class="nav-link border-bottom" href="#">Navigation:</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">List of Assessments</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Edit</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Remove</a></li>
                    </ul>
                </div>
            </div>

            <!--  Main -->
            <main role="main" class="col ml-sm-auto col-lg-10 px-4">

                <!-- Create Assessment Form -->
                <!-- Add event listener in javascript to validate before sending -->
                <div class="container my-5">
                    <div class="row p-4 align-items-center rounded-3 border shadow">
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post"
                            id="create_new_assessment">
                            <!-- Assessment type -->
                            <div class="mb-3">
                                <label for="assessment_type">Assessment Type</label>
                                <select class="form-select" name="assessment_type" id="assessment_type">
                                    <option selected>Choose Assessment Type</option>
                                    <option value="1">Assignment</option>
                                    <option value="2">Midterm</option>
                                    <option value="3">Final</option>
                                    <option value="4">Project</option>
                                    <option value="5">Report</option>
                                    <option value="6">Other</option>
                                </select>
                            </div>
                            <!-- Assessment name -->
                            <div class="mb-3">
                                <label for="assessment_name" class="form-label"> Assessment Name:</label>
                                <input type="text" class="form-control" name="assessment_name" id="assessment_name">
                            </div>

                            <!-- Assessment Weight -->
                            <!-- add max value as whatever is left from existing assessments -->
                            <div class="mb-3">
                                <label class="form-label" for="assessment_weight">Assessment Weight %: <span id="value"
                                        placeholder="50"></span></label>
                                <input type="range" class="form-range" value="50" step="5" name="assessment_weight"
                                    id="weight">
                            </div>

                            <!-- Number of questions -->
                            <div class="mb-3">
                                <label class="form-label" for="numOfQuestions">Number of Questions:</label>
                                <input type="number" class="form-control" name="number_of_questions"
                                    id="numOfQuestions">
                            </div>

                            <!-- Due Date -->
                            <div class="mb-3">
                                <label class="form-label" for="assessment_due_datetime-local">Due Date:</label>
                                <input class="form-control" type="datetime-local" name="assessment_due_datetime-local"
                                    id="assessment_due_datetime-local">
                            </div>

                            <!-- File Input -->
                            <div class="mb-3">
                                <label class="form-label" for="assessment_file">Optional file input:</label>
                                <input class="form-control" type="file" name="assessment_file" id="assessment_file">
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 mb-3">
                                <button type="submit" name="submit" class="btn btn-primary" style="background-color: #a68ec5; border-color: #a68ec5;">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php

    try {

        $db = new PDO('sqlite:../db/doodle.db');

        if (isset($_POST["submit"])) {

            $c_id = $_SESSION["course_id"];
            $s_id = $_SESSION["section_id"];
            $a_name = $_POST["assessment_name"];
            $a_weight = $_POST["assessment_weight"];
            
            // Set assessment_id as the next id after the current max id for the course/section
            $query = "SELECT MAX(assessment_id) FROM Assessment WHERE course_id=$c_id AND section_id=$s_id";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $a_id = $stmt->fetch()[0];
            
            $db->exec("INSERT INTO Assessment VALUES ($a_id+1, $c_id, $s_id, '$a_name', $a_weight)");
            // DEBUG: print_r("CR: " . $a_id+1 . " " . $c_id . " " . $s_id . " " . $a_weight);

        }

    } catch (PDOException $e) {
        print 'Account creation failed - PDOException: ' . $e->getMessage();
    }

    ?>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

    <!-- Helper script for slider values display -->
    <script>
        let slider = document.getElementById("weight");
        let output = document.getElementById("value");

        output.innerHTML = slider.innerHTML;    // Display the default slider value

        // Update the current slider value (each time you drag the slider handle)
        slider.oninput = function () { output.innerHTML = this.value }
    </script>
</body>

</html>