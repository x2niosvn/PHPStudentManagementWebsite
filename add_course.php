<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Course</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="courseCode" class="form-label">Course Code</label>
                                <input type="text" class="form-control" id="courseCode" name="courseCode" required>
                            </div>
                            <div class="mb-3">
                                <label for="courseName" class="form-label">Course Name</label>
                                <input type="text" class="form-control" id="courseName" name="courseName" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" required>
                            </div>
                            <div class="mb-3">
                                <label for="creditHours" class="form-label">Credit Hours</label>
                                <input type="number" class="form-control" id="creditHours" name="creditHours" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Course</button>
                        </form>

                        <?php
                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            include 'db_connect.php'; // Include the database connection

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("INSERT INTO Course (CourseCode, CourseName, Description, Department, CreditHours) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("ssssi", $courseCode, $courseName, $description, $department, $creditHours);

                            // Set parameters and execute
                            $courseCode = $_POST["courseCode"];
                            $courseName = $_POST["courseName"];
                            $description = $_POST["description"];
                            $department = $_POST["department"];
                            $creditHours = $_POST["creditHours"];

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Course added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding course. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
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
