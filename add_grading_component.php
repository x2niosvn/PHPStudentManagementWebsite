<!-- add_grading_component.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Grading Component</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Grading Component</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement to add grading component
                            $stmt = $conn->prepare("INSERT INTO GradingComponent (ComponentName, Weightage, CourseID) VALUES (?, ?, ?)");
                            $stmt->bind_param("sdi", $componentName, $weightage, $courseID);

                            // Set parameters and execute
                            $componentName = $_POST["componentName"];
                            $weightage = $_POST["weightage"];
                            $courseID = $_POST["courseID"];

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Grading component added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding grading component. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        }
                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="componentName" class="form-label">Component Name</label>
                                <input type="text" class="form-control" id="componentName" name="componentName" required>
                            </div>
                            <div class="mb-3">
                                <label for="weightage" class="form-label">Weightage</label>
                                <input type="number" class="form-control" id="weightage" name="weightage" min="0" max="100" required>
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

                                    // Close connection
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Component</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
