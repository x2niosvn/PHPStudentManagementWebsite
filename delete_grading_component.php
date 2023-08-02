<!-- delete_grading_component.php -->
<?php
// Check if componentID is provided in the URL
if (isset($_GET["componentID"])) {
    $componentID = $_GET["componentID"];

    // Include the database connection
    include 'db_connect.php';

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("DELETE FROM GradingComponent WHERE ComponentID = ?");
    $stmt->bind_param("i", $componentID);

    if ($stmt->execute()) {
        // Redirect to view_grading_components.php after successful deletion
        header("Location: view_grading_components.php");
        exit();
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Error deleting grading component. Please try again later.</div>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
}
?>
