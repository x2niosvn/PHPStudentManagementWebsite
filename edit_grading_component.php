<!-- edit_grading_component.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Grading Component</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Grading Component</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if componentID is provided in the URL
                        if (isset($_GET["componentID"])) {
                            $componentID = $_GET["componentID"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("SELECT ComponentID, ComponentName, Weightage, CourseID FROM GradingComponent WHERE ComponentID = ?");
                            $stmt->bind_param("i", $componentID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?componentID=' . $componentID; ?>">
                                    <div class="mb-3">
                                        <label for="componentName" class="form-label">Component Name</label>
                                        <input type="text" class="form-control" id="componentName" name="componentName" value="<?php echo $row["ComponentName"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="weightage" class="form-label">Weightage</label>
                                        <input type="number" step="0.01" class="form-control" id="weightage" name="weightage" value="<?php echo $row["Weightage"]; ?>" required>
                                    </div>
                            <div class="mb-3">
                                <label for="courseID" class="form-label">Course ID</label>
                                <select class="form-control" id="courseID" name="courseID" required>
                                    <?php
                                    // Include the database connection
                                    include 'db_connect.php';

                                    // Prepare and execute SQL statement to get CourseIDs from the Course table
                                    $sql = "SELECT CourseID, CourseName FROM Course";
                                    $result = $conn->query($sql);

                                    // Generate options for each CourseID

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $courseInfo = $row["CourseID"] . " - " . $row["CourseName"];
                                            echo '<option value="' . $row["CourseID"] . '">' . $courseInfo . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <a href="view_grading_components.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Grading component not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }

                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["componentID"])) {
                            $componentID = $_GET["componentID"];
                            include 'db_connect.php'; // Include the database connection

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("UPDATE GradingComponent SET ComponentName = ?, Weightage = ?, CourseID = ? WHERE ComponentID = ?");
                            $stmt->bind_param("sddi", $componentName, $weightage, $courseID, $componentID);

                            // Set parameters and execute
                            $componentName = $_POST["componentName"];
                            $weightage = $_POST["weightage"];
                            $courseID = $_POST["courseID"];

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Grading component updated successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error updating grading component. Please try again later.</div>';
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
</body>
</html>
