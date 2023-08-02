<!DOCTYPE html>
<html>
<head>
    <title>Edit Score</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Score</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if scoreID is provided in the URL
                        if (isset($_GET["scoreID"])) {
                            $scoreID = $_GET["scoreID"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement to fetch score details
                            $stmt = $conn->prepare("SELECT ScoreID, StudentID, ComponentID, Marks FROM Score WHERE ScoreID = ?");
                            $stmt->bind_param("i", $scoreID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?scoreID=' . $row["ScoreID"]; ?>">
                                    <div class="mb-3">
                                        <label for="studentID" class="form-label">Student ID</label>
                                        <input type="number" class="form-control" id="studentID" name="studentID" value="<?php echo $row["StudentID"]; ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="componentID" class="form-label">Component ID</label>
                                        <input type="number" class="form-control" id="componentID" name="componentID" value="<?php echo $row["ComponentID"]; ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="marks" class="form-label">Marks</label>
                                        <input type="number" class="form-control" id="marks" name="marks" min="0" max="100" value="<?php echo $row["Marks"]; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <a href="view_scores.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Score not found.</div>';
                            }

                            // Close the statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }

                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["scoreID"])) {
                            $scoreID = $_GET["scoreID"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Get data from the form
                            $marks = $_POST["marks"];

                            // Prepare and bind SQL statement to update score
                            $stmt = $conn->prepare("UPDATE Score SET Marks = ? WHERE ScoreID = ?");
                            $stmt->bind_param("di", $marks, $scoreID);

                            // Execute the statement
                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Score updated successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error updating score. Please try again later.</div>';
                            }

                            // Close the statement and connection
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
