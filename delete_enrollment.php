<!-- delete_enrollment.php -->
<?php
// Check if enrollmentID is provided in the URL
if (isset($_GET["enrollmentID"])) {
    $enrollmentID = $_GET["enrollmentID"];

    // Include the database connection
    include 'db_connect.php';

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("DELETE FROM Enrollment WHERE EnrollmentID = ?");
    $stmt->bind_param("i", $enrollmentID);

    if ($stmt->execute()) {
        // Redirect to view_enrollments.php after successful deletion
        header("Location: view_enrollments.php");
        exit();
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Error deleting enrollment. Please try again later.</div>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
}
?>
