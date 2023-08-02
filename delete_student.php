<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">Delete Student</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if studentID is provided in the URL
                        if (isset($_GET["studentID"])) {
                            $studentID = $_GET["studentID"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("SELECT StudentID, FirstName, LastName FROM Student WHERE StudentID = ?");
                            $stmt->bind_param("i", $studentID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>
                                <p>Are you sure you want to delete the following student?</p>
                                <p><strong>Name:</strong> <?php echo $row["FirstName"] . ' ' . $row["LastName"]; ?></p>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="studentID" value="<?php echo $row["StudentID"]; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                    <a href="view_students.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Student not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }

                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
                            include 'db_connect.php'; // Include the database connection

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("DELETE FROM Student WHERE StudentID = ?");
                            $stmt->bind_param("i", $studentID);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Student deleted successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error deleting student. Please try again later.</div>';
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
