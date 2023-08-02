<!-- edit_enrollment.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Enrollment</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if enrollmentID is provided in the URL
                        if (isset($_GET["enrollmentID"])) {
                            $enrollmentID = $_GET["enrollmentID"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("SELECT EnrollmentID, StudentID, CourseID, EnrollmentDate, Grade FROM Enrollment WHERE EnrollmentID = ?");
                            $stmt->bind_param("i", $enrollmentID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?enrollmentID=' . $enrollmentID; ?>">
                                    <input type="hidden" name="enrollmentID" value="<?php echo $row["EnrollmentID"]; ?>">
                                    <div class="mb-3">
                                        <label for="studentID" class="form-label">Student ID</label>
                                        <!-- Hiển thị student ID và tên -->
                                        <?php
                                        $studentID = $row["StudentID"];
                                        $stmt_student = $conn->prepare("SELECT CONCAT(StudentID, ' - ', FirstName, ' ', LastName) AS FullName FROM Student WHERE StudentID = ?");
                                        $stmt_student->bind_param("i", $studentID);
                                        $stmt_student->execute();
                                        $result_student = $stmt_student->get_result();
                                        $student = $result_student->fetch_assoc();
                                        echo '<input type="text" class="form-control" id="studentID" name="studentID" value="' . $student["FullName"] . '" disabled>';
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="courseID" class="form-label">Course ID</label>
                                        <!-- Hiển thị course ID và tên -->
                                        <?php
                                        $courseID = $row["CourseID"];
                                        $stmt_course = $conn->prepare("SELECT CONCAT(CourseID, ' - ', CourseName) AS CourseInfo FROM Course WHERE CourseID = ?");
                                        $stmt_course->bind_param("i", $courseID);
                                        $stmt_course->execute();
                                        $result_course = $stmt_course->get_result();
                                        $course = $result_course->fetch_assoc();
                                        echo '<input type="text" class="form-control" id="courseID" name="courseID" value="' . $course["CourseInfo"] . '" disabled>';
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="enrollmentDate" class="form-label">Enrollment Date</label>
                                        <input type="date" class="form-control" id="enrollmentDate" name="enrollmentDate" value="<?php echo $row["EnrollmentDate"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="grade" class="form-label">Grade</label>
                                        <input type="number" class="form-control" id="grade" name="grade" value="<?php echo $row["Grade"]; ?>" min="0" max="100" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <a href="view_enrollments.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Enrollment not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }

                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enrollmentID"])) {
                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement to update enrollment
                            $stmt_update = $conn->prepare("UPDATE Enrollment SET EnrollmentDate = ?, Grade = ? WHERE EnrollmentID = ?");
                            $stmt_update->bind_param("sii", $enrollmentDate, $grade, $enrollmentID);

                            // Set parameters and execute
                            $enrollmentDate = $_POST["enrollmentDate"];
                            $grade = $_POST["grade"];

                            if ($stmt_update->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Enrollment information updated successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error updating enrollment information. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt_update->close();
                            $conn->close();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
