<!-- add_enrollment.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Enrollment</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement to add enrollment
                            $stmt = $conn->prepare("INSERT INTO Enrollment (StudentID, CourseID, EnrollmentDate) VALUES (?, ?, ?)");
                            $stmt->bind_param("iis", $studentID, $courseID, $enrollmentDate);

                            // Set parameters and execute
                            $studentID = $_POST["studentID"];
                            $courseID = $_POST["courseID"];
                            $enrollmentDate = $_POST["enrollmentDate"];

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Enrollment added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding enrollment. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        }
                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="studentID" class="form-label">Student</label>
                                <select class="form-control" id="studentID" name="studentID" required>
                                    <?php
                                    // Include the database connection
                                    include 'db_connect.php';

                                    // Prepare and execute SQL statement to get StudentIDs with First Name and Last Name from the Student table
                                    $sql_students = "SELECT StudentID, FirstName, LastName FROM Student";
                                    $result_students = $conn->query($sql_students);

                                    // Generate options for each StudentID with FirstName and LastName
                                    if ($result_students->num_rows > 0) {
                                        while ($row = $result_students->fetch_assoc()) {
                                            $fullName = $row["StudentID"] . " - " . $row["FirstName"] . " " . $row["LastName"];
                                            echo '<option value="' . $row["StudentID"] . '">' . $fullName . '</option>';
                                        }
                                    }

                                    // Close connection
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="courseID" class="form-label">Course</label>
                                <select class="form-control" id="courseID" name="courseID" required>
                                    <?php
                                    // Include the database connection
                                    include 'db_connect.php';

                                    // Prepare and execute SQL statement to get CourseIDs with CourseName from the Course table
                                    $sql_courses = "SELECT CourseID, CourseName FROM Course";
                                    $result_courses = $conn->query($sql_courses);

                                    // Generate options for each CourseID with CourseName
                                    if ($result_courses->num_rows > 0) {
                                        while ($row = $result_courses->fetch_assoc()) {
                                            $courseInfo = $row["CourseID"] . " - " . $row["CourseName"];
                                            echo '<option value="' . $row["CourseID"] . '">' . $courseInfo . '</option>';
                                        }
                                    }

                                    // Close connection
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="enrollmentDate" class="form-label">Enrollment Date</label>
                                <input type="date" class="form-control" id="enrollmentDate" name="enrollmentDate" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Enrollment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
