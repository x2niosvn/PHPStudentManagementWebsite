<!-- view_enrollments.php -->
<!DOCTYPE html>
<html>
<head>
    <title>View Enrollments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">View Enrollments</h3>
                    </div>
                    <div class="card-body">
                        <form class="d-flex mb-3" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Enrollment ID</th>
                                    <th>Student Name</th>
                                    <th>Course Name</th>
                                    <th>Enrollment Date</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Include the database connection
                                include 'db_connect.php';

                                // Process search query
                                $search = "";
                                if (isset($_GET['search'])) {
                                    $search = $_GET['search'];
                                    $sql = "SELECT e.EnrollmentID, s.FirstName, s.LastName, c.CourseName, e.EnrollmentDate, e.Grade
                                            FROM Enrollment e
                                            JOIN Student s ON e.StudentID = s.StudentID
                                            JOIN Course c ON e.CourseID = c.CourseID
                                            WHERE s.FirstName LIKE '%$search%' OR s.LastName LIKE '%$search%' OR c.CourseName LIKE '%$search%'";
                                } else {
                                    $sql = "SELECT e.EnrollmentID, s.FirstName, s.LastName, c.CourseName, e.EnrollmentDate, e.Grade
                                            FROM Enrollment e
                                            JOIN Student s ON e.StudentID = s.StudentID
                                            JOIN Course c ON e.CourseID = c.CourseID";
                                }

                                // Execute the SQL query
                                $result = $conn->query($sql);

                                // Display results
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["EnrollmentID"] . '</td>';
                                        echo '<td>' . $row["FirstName"] . ' ' . $row["LastName"] . '</td>';
                                        echo '<td>' . $row["CourseName"] . '</td>';
                                        echo '<td>' . $row["EnrollmentDate"] . '</td>';
                                        echo '<td>' . $row["Grade"] . '</td>';
                                        echo '<td>
                                                <a href="edit_enrollment.php?enrollmentID=' . $row["EnrollmentID"] . '" class="btn btn-primary btn-sm me-2">Edit</a>
                                                <a href="delete_enrollment.php?enrollmentID=' . $row["EnrollmentID"] . '" class="btn btn-danger btn-sm">Delete</a>
                                            </td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="6">No enrollments found.</td></tr>';
                                }

                                // Close connection
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
