<!-- view_grading_components.php -->
<!DOCTYPE html>
<html>
<head>
    <title>View Grading Components</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">View Grading Components</h3>
                    </div>
                    <div class="card-body">
                        <form class="d-flex mb-3" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Component ID</th>
                                    <th>Component Name</th>
                                    <th>Weightage</th>
                                    <th>Course Name</th>
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
                                    $sql = "SELECT gc.ComponentID, gc.ComponentName, gc.Weightage, c.CourseName FROM GradingComponent gc JOIN Course c ON gc.CourseID = c.CourseID WHERE gc.ComponentName LIKE '%$search%' OR c.CourseName LIKE '%$search%'";
                                } else {
                                    $sql = "SELECT gc.ComponentID, gc.ComponentName, gc.Weightage, c.CourseName FROM GradingComponent gc JOIN Course c ON gc.CourseID = c.CourseID";
                                }

                                // Execute the SQL query
                                $result = $conn->query($sql);

                                // Display results
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["ComponentID"] . '</td>';
                                        echo '<td>' . $row["ComponentName"] . '</td>';
                                        echo '<td>' . $row["Weightage"] . '</td>';
                                        echo '<td>' . $row["CourseName"] . '</td>';
                                        echo '<td>
                                                <a href="edit_grading_component.php?componentID=' . $row["ComponentID"] . '" class="btn btn-primary btn-sm me-2">Edit</a>
                                                <a href="delete_grading_component.php?componentID=' . $row["ComponentID"] . '" class="btn btn-danger btn-sm">Delete</a>
                                            </td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5">No grading components found.</td></tr>';
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
