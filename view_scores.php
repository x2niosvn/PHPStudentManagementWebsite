<!DOCTYPE html>
<html>
<head>
    <title>View Scores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">View Scores</h2>

                <!-- Search Form -->
                <form method="get" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by Student ID" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <?php
                // Include the database connection
                include 'db_connect.php';

                // SQL query to fetch scores data with optional search filter
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $sql = "SELECT Score.ScoreID, Score.StudentID, Student.FirstName, Student.LastName, Score.ComponentID, GradingComponent.ComponentName, Score.Marks 
                        FROM Score
                        INNER JOIN Student ON Score.StudentID = Student.StudentID
                        INNER JOIN GradingComponent ON Score.ComponentID = GradingComponent.ComponentID
                        WHERE CONCAT(Student.StudentID, ' - ', Student.FirstName, ' ', Student.LastName) LIKE '%$search%'
                        ORDER BY Score.ScoreID";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    ?>
                    <!-- Display Scores Table -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Score ID</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Component ID</th>
                                <th>Component Name</th>
                                <th>Marks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row["ScoreID"] . '</td>';
                                echo '<td>' . $row["StudentID"] . '</td>';
                                echo '<td>' . $row["FirstName"] . ' ' . $row["LastName"] . '</td>';
                                echo '<td>' . $row["ComponentID"] . '</td>';
                                echo '<td>' . $row["ComponentName"] . '</td>';
                                echo '<td>' . $row["Marks"] . '</td>';
                                echo '<td>';
                                echo '<a href="edit_score.php?scoreID=' . $row["ScoreID"] . '" class="btn btn-primary btn-sm me-2">Edit</a>';
                                echo '<a href="delete_score.php?scoreID=' . $row["ScoreID"] . '" class="btn btn-danger btn-sm">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo '<div class="alert alert-info mt-3" role="alert">No scores found.</div>';
                }

                // Close the connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>
