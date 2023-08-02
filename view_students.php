<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">View Students</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by First Name or Last Name" name="searchKeyword">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Student Code</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Enrollment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Include the database connection
                                include 'db_connect.php';

                                // Process form data when the form is submitted
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $searchKeyword = $_POST["searchKeyword"];

                                    // Query to retrieve students from the database based on search keyword
                                    $sql = "SELECT StudentID, FirstName, LastName, StudentCode, DateOfBirth, Gender, ContactNumber, Email, Address, EnrollmentStatus FROM Student WHERE FirstName LIKE '%$searchKeyword%' OR LastName LIKE '%$searchKeyword%'";
                                } else {
                                    // Default query to retrieve all students from the database
                                    $sql = "SELECT StudentID, FirstName, LastName, StudentCode, DateOfBirth, Gender, ContactNumber, Email, Address, EnrollmentStatus FROM Student";
                                }

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Loop through each row and display student information
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["StudentID"] . '</td>';
                                        echo '<td>' . $row["FirstName"] . '</td>';
                                        echo '<td>' . $row["LastName"] . '</td>';
                                         echo '<td>' . $row["StudentCode"] . '</td>';
                                        echo '<td>' . $row["DateOfBirth"] . '</td>';
                                        echo '<td>' . $row["Gender"] . '</td>';
                                        echo '<td>' . $row["ContactNumber"] . '</td>';
                                        echo '<td>' . $row["Email"] . '</td>';
                                        echo '<td>' . $row["Address"] . '</td>';
                                        echo '<td>' . $row["EnrollmentStatus"] . '</td>';
                                        echo '<td>';
                                        echo '<a href="edit_student.php?studentID=' . $row["StudentID"] . '" class="btn btn-primary btn-sm">Edit</a> ';
                                        echo '<a href="delete_student.php?studentID=' . $row["StudentID"] . '" class="btn btn-danger btn-sm">Delete</a>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    // No students found in the database
                                    echo '<tr><td colspan="10" class="text-center">No students found.</td></tr>';
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

    <!-- Add other content and scripts as needed -->
</body>
</html>
