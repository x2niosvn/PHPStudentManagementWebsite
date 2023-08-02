<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Course</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["courseCode"])) {
                            $courseCode = $_GET["courseCode"];

                            // Query to retrieve course information based on courseCode
                            $stmt = $conn->prepare("SELECT CourseCode, CourseName, Description, Department, CreditHours FROM Course WHERE CourseCode = ?");
                            $stmt->bind_param("s", $courseCode);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows == 1) {
                                $course = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="mb-3">
                                        <label for="courseCode" class="form-label">Course Code</label>
                                        <input type="text" class="form-control" id="courseCode" name="courseCode" value="<?php echo $course['CourseCode']; ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="courseName" class="form-label">Course Name</label>
                                        <input type="text" class="form-control" id="courseName" name="courseName" value="<?php echo $course['CourseName']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $course['Description']; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department" value="<?php echo $course['Department']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="creditHours" class="form-label">Credit Hours</label>
                                        <input type="number" class="form-control" id="creditHours" name="creditHours" value="<?php echo $course['CreditHours']; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Course not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Process form data when the form is submitted
                            $courseCode = $_POST["courseCode"];
                            $courseName = $_POST["courseName"];
                            $description = $_POST["description"];
                            $department = $_POST["department"];
                            $creditHours = $_POST["creditHours"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("UPDATE Course SET CourseName = ?, Description = ?, Department = ?, CreditHours = ? WHERE CourseCode = ?");
                            $stmt->bind_param("sssds", $courseName, $description, $department, $creditHours, $courseCode);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Course updated successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error updating course. Please try again later.</div>';
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
