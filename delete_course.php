<!DOCTYPE html>
<html>
<head>
    <title>Delete Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">Delete Course</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["courseCode"])) {
                            $courseCode = $_GET["courseCode"];

                            // Query to retrieve course information based on courseCode
                            $stmt = $conn->prepare("SELECT CourseCode, CourseName FROM Course WHERE CourseCode = ?");
                            $stmt->bind_param("s", $courseCode);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows == 1) {
                                $course = $result->fetch_assoc();
                                ?>
                                <p>Are you sure you want to delete the course '<?php echo $course['CourseName']; ?>' (Course Code: <?php echo $course['CourseCode']; ?>)?</p>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="courseCode" value="<?php echo $courseCode; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                    <a href="view_courses.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Course not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
                            // Process form data when the delete button is clicked
                            $courseCode = $_POST["courseCode"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("DELETE FROM Course WHERE CourseCode = ?");
                            $stmt->bind_param("s", $courseCode);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Course deleted successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error deleting course. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>
