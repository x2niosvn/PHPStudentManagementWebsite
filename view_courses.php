<!DOCTYPE html>
<html>
<head>
    <title>View Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">View Courses</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by Course Code or Course Name" name="searchKeyword">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Description</th>
                                    <th>Department</th>
                                    <th>Credit Hours</th>
                                    <th>Action</th> <!-- Add Action column header -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Include the database connection
                                include 'db_connect.php';

                                // Process form data when the form is submitted
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $searchKeyword = $_POST["searchKeyword"];

                                    // Query to retrieve courses from the database based on search keyword
                                    $sql = "SELECT CourseCode, CourseName, Description, Department, CreditHours FROM Course WHERE CourseCode LIKE '%$searchKeyword%' OR CourseName LIKE '%$searchKeyword%'";
                                } else {
                                    // Default query to retrieve all courses from the database
                                    $sql = "SELECT CourseCode, CourseName, Description, Department, CreditHours FROM Course";
                                }

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Loop through each row and display course information
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["CourseCode"] . '</td>';
                                        echo '<td>' . $row["CourseName"] . '</td>';
                                        echo '<td>' . $row["Description"] . '</td>';
                                        echo '<td>' . $row["Department"] . '</td>';
                                        echo '<td>' . $row["CreditHours"] . '</td>';
                                        echo '<td>';
                                        echo '<a href="edit_course.php?courseCode=' . $row["CourseCode"] . '" class="btn btn-primary btn-sm">Edit</a>'; // Add Edit button with link to edit_course.php
                                        echo '<a href="delete_course.php?courseCode=' . $row["CourseCode"] . '" class="btn btn-danger btn-sm ml-2">Delete</a>'; // Add Delete button with link to delete_course.php
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    // No courses found in the database
                                    echo '<tr><td colspan="6" class="text-center">No courses found.</td></tr>';
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