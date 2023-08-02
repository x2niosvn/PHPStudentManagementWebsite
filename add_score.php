<!DOCTYPE html>
<html>
<head>
    <title>Add Score</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Score</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Include the database connection
                            include 'db_connect.php';

                            // Get data from the form
                            $studentID = $_POST["studentID"];
                            $componentID = $_POST["componentID"];
                            $marks = $_POST["marks"];

                            // Prepare and bind SQL statement to insert score
                            $stmt = $conn->prepare("INSERT INTO Score (StudentID, ComponentID, Marks) VALUES (?, ?, ?)");
                            $stmt->bind_param("iid", $studentID, $componentID, $marks);

                            // Execute the statement
                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Score added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding score. Please try again later.</div>';
                            }

                            // Close the statement and connection
                            $stmt->close();
                            $conn->close();
                        }
                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="studentID" class="form-label">Student ID</label>
                                <select class="form-control" id="studentID" name="studentID" required>
                                    <?php
                                    // Include the database connection
                                    include 'db_connect.php';

                                    // Prepare and bind SQL statement to fetch student IDs and names
                                    $stmt = $conn->prepare("SELECT StudentID, FirstName, LastName FROM Student");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row["StudentID"] . '">' . $row["StudentID"] . ' - ' . $row["FirstName"] . ' ' . $row["LastName"] . '</option>';
                                    }

                                    // Close the statement and connection
                                    $stmt->close();
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="componentID" class="form-label">Component ID</label>
                                <select class="form-control" id="componentID" name="componentID" required>
                                    <?php
                                    // Include the database connection
                                    include 'db_connect.php';

                                    // Prepare and bind SQL statement to fetch component IDs and names
                                    $stmt = $conn->prepare("SELECT ComponentID, ComponentName FROM GradingComponent");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row["ComponentID"] . '">' . $row["ComponentID"] . ' - ' . $row["ComponentName"] . '</option>';
                                    }

                                    // Close the statement and connection
                                    $stmt->close();
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="marks" class="form-label">Marks</label>
                                <input type="number" class="form-control" id="marks" name="marks" min="0" max="100" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Score</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>
